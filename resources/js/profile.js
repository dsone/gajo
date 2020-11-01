import Ajax from './components/Ajax';
import Pending from './components/Pending';
import Modal from './components/Modal';
import CardList from './components/profile/CardList';
import TableList from './components/profile/TableList';

let startContainer = document.querySelector('div[bind-start]');
let editEntryModal = new Modal($('template#modal-entry-edit').innerHTML);
let modalEntryRemove = new Modal($('template#modal-remove-confirm').innerHTML);
let listing = __TYPES.map(type => {
	if (type.display == 2) {
		return new CardList({
			ajax:				Ajax,
			pending:			Pending,
			type,
			targetContainer:	$('.section-container'),
			sectionTemplate:	$('template#skeleton-card-section').innerHTML,
			entryTemplate:		$('template#skeleton-card-entry').innerHTML,

			modalEntryRemove:	modalEntryRemove,
			modalEntryEdit:		editEntryModal,
		});
	} else {
		return new TableList({
			ajax:				Ajax,
			pending:			Pending,
			type,
			targetContainer:	$('.section-container'),
			sectionTemplate:	$('template#skeleton-table-section').innerHTML,
			tableTemplate:		$('template#skeleton-table').innerHTML,
			entryTemplate:		$('template#skeleton-table-entry').innerHTML,

			modalEntryRemove:	modalEntryRemove,
			modalEntryEdit:		editEntryModal,
		});
	}
});
if (!listing.some(list => list.getEntries().length > 0)) {
	startContainer.classList.remove('hidden');
}

// Abort Removal Modal
let btnCloseEntryRemoveModal = modalEntryRemove.querySelector('.js-modal-close');
if (btnCloseEntryRemoveModal) {
	btnCloseEntryRemoveModal.addEventListener('click', function(e) {
		modalEntryRemove.hide();
	});
}
// Confirm Removal Modal
let btnConfirmEntryRemoveModal = modalEntryRemove.querySelector('.js-modal-confirm');
if (btnConfirmEntryRemoveModal) {
	btnConfirmEntryRemoveModal.addEventListener('click', function(e) {
		if (Pending.isPending()) {
			notify('Warning', 'Another request is in progress, please wait a second!', 'warning');
			return;
		}

		btnConfirmEntryRemoveModal.setAttribute('disabled', 'disabled');
		btnConfirmEntryRemoveModal.classList.add('cursor-pointer');
		let entryId = parseInt(btnConfirmEntryRemoveModal.getAttribute('entry-id'));
		if (!!entryId) {
			Pending.show();
			Ajax.post(
					__ROUTES.entries.remove, 
					{ id: entryId, _method: 'delete' }
				).then(resp => {
					let json = resp.data;
					if (!json.error) {
						listing.forEach(list => {
							list.removeEntryById(entryId);
						})

						notify('Success', 'Entry removed', 'success');
					} else {
						notify('Error', json.message, 'danger');
					}

					// Check if all listings are empty
					if (!listing.some(list => list.getEntries().length > 0)) {
						startContainer.classList.remove('hidden');
					}
				}).catch(err => {
					notify('Error', err.message, 'danger');
				}).finally(resp => {
					btnConfirmEntryRemoveModal.removeAttribute('disabled');
					btnConfirmEntryRemoveModal.classList.remove('cursor-wait');

					modalEntryRemove.hide();
					Pending.hide();
				});
		}
	});
}

// Add Entry modal
let addEntryModal = new Modal($('template#modal-entry-add').innerHTML);
let entryModalForm = addEntryModal.querySelector('form');
// Setup modal
if (addEntryModal) {
	let selectType = addEntryModal.querySelector('[bind-types]');
	if (selectType) {
		__TYPES.forEach((type, i) => {
			let option = document.createElement('option');
				option.value = type.id;
				option.text = type.name;
				option.setAttribute('data-ident1', type.ident_1);
				option.setAttribute('data-ident2', type.ident_2);

			selectType.appendChild(option);
		});

		// Update input fields to reflect selected type
		selectType.addEventListener('change', e => {
			let selOption = selectType.options[selectType.selectedIndex];
			let ident1 = selOption.getAttribute('data-ident1');
			let ident2 = selOption.getAttribute('data-ident2');

			addEntryModal.querySelector('[bind-ident1]').innerText = ident1;
			addEntryModal.querySelector('[name=ident_1]').setAttribute('placeholder', ident1);
			addEntryModal.querySelector('[bind-ident2]').innerText = ident2;
			addEntryModal.querySelector('[name=ident_2]').setAttribute('placeholder', ident2);
		});

		// make first element in options auto-select and fill in idents
		selectType.dispatchEvent(new Event('change'));
	}
}
// Save entered entry
let btnSaveEntry = addEntryModal.querySelector('.js-modal-confirm');
if (btnSaveEntry) {
	btnSaveEntry.addEventListener('click', e => {
		if (Pending.isPending()) {
			notify('Warning', 'Another request is in progress, please wait a second!', 'warning');
			return;
		}

		btnSaveEntry.setAttribute('disabled', 'disabled');
		btnSaveEntry.classList.add('cursor-wait');
		Pending.show();
		Ajax.post(
				__ROUTES.entries.store, {
					type: entryModalForm.type.options[entryModalForm.type.selectedIndex].value,
					ident_1: entryModalForm.ident_1.value,
					ident_2: entryModalForm.ident_2.value,
					release: entryModalForm.release.value,
					visibility: entryModalForm.visibility.value
				}
			).then(resp => {
				let json = resp.data;
				if (!json.error) {
					addEntryModal.hide();

					if (entryModalForm) {
						entryModalForm.reset();
					}

					listing.some(type => {
						if (type.getId() == json.data.entry.type_id) {
							startContainer.classList.add('hidden');
							type.addEntry(json.data.entry);
							return true;
						}

						return false;
					});

					notify('Success', 'Entry added', 'success');
				} else {
					notify('Error', json.message, 'danger');
				}
			}).catch(err => {
				notify('Error', err.message, 'danger');
			}).finally(resp => {
				btnSaveEntry.removeAttribute('disabled');
				btnSaveEntry.classList.remove('cursor-wait');
				Pending.hide();
			});
	});
}

// Close Add Entry modal and reset form
let btnCloseEntryModal = addEntryModal.querySelector('.js-modal-close');
if (btnCloseEntryModal) {
	btnCloseEntryModal.addEventListener('click', function(e) {
		addEntryModal.hide();

		if (entryModalForm) {
			entryModalForm.reset();
		}
	});
}

// Navbar button to trigger Add Entry modal
let navbarBtn = $('.js-navbar-add-entry');
if (navbarBtn) {
	navbarBtn.addEventListener('click', e => {
		addEntryModal.show();
	});
}


// Edit Entry modal
let editEntryModalForm = editEntryModal.querySelector('form');
// Setup modal
if (editEntryModal) {
	let selectType = editEntryModal.querySelector('[bind-types]');
	if (selectType) {
		__TYPES.forEach((type, i) => {
			let option = document.createElement('option');
				option.value = type.id;
				option.text = type.name;
				option.setAttribute('data-ident1', type.ident_1);
				option.setAttribute('data-ident2', type.ident_2);

			selectType.appendChild(option);
		});

		// Update input fields to reflect selected type
		selectType.addEventListener('change', e => {
			let selOption = selectType.options[selectType.selectedIndex];
			let ident1 = selOption.getAttribute('data-ident1');
			let ident2 = selOption.getAttribute('data-ident2');

			editEntryModal.querySelector('[bind-ident1]').innerText = ident1;
			editEntryModal.querySelector('[name=ident_1]').setAttribute('placeholder', ident1);
			editEntryModal.querySelector('[bind-ident2]').innerText = ident2;
			editEntryModal.querySelector('[name=ident_2]').setAttribute('placeholder', ident2);
		});

		// make first element in options auto-select and fill in idents
		selectType.dispatchEvent(new Event('change'));
	}
}
// Save edited entry
let btnEditEntry = editEntryModal.querySelector('.js-modal-confirm');
if (btnEditEntry) {
	btnEditEntry.addEventListener('click', e => {
		if (Pending.isPending()) {
			notify('Warning', 'Another request is in progress, please wait a second!', 'warning');
			return;
		}

		btnEditEntry.setAttribute('disabled', 'disabled');
		btnEditEntry.classList.add('cursor-wait');
		Pending.show();
		let entryId = btnEditEntry.getAttribute('entry-id');
		let oldEntryType = btnEditEntry.getAttribute('entry-type');
		Ajax.post(
				__ROUTES.entries.update, {
					id:			entryId,
					// fetch type "freshly" since it may have changed to the previous type inside oldEntryType
					type:		editEntryModalForm.type.options[editEntryModalForm.type.selectedIndex].value,
					ident_1:	editEntryModalForm.ident_1.value,
					ident_2:	editEntryModalForm.ident_2.value,
					release:	editEntryModalForm.release.value,
					visibility: editEntryModalForm.visibility.value,
					_method:	'put',
				}
			).then(resp => {
				let json = resp.data;
				if (!json.error) {
					editEntryModal.hide();

					if (editEntryModalForm) {
						editEntryModalForm.reset();
					}

					let typeChanged = json.data.entry.type_id != oldEntryType;
					listing.some(type => {
						// Remove from current type if it has changed
						if (typeChanged) {
							if (type.getId() == oldEntryType) {
								type.removeEntryById(entryId);
							}
						}

						// target type found
						if (type.getId() == json.data.entry.type_id) {
							if (typeChanged) {
								type.addEntry(json.data.entry);
							} else {
								type.modifyEntry(json.data.entry.id, json.data.entry);
							}

							if (!typeChanged) {
								return true;
							}
						}

						// if type changed, list is looped entirely
						return false;
					});

					notify('Success', 'Entry updated', 'success');
				} else {
					notify('Error', json.message, 'danger');
				}
			}).catch(err => {
				notify('Error', err.message, 'danger');
			}).finally(resp => {
				btnEditEntry.removeAttribute('disabled');
				btnEditEntry.classList.remove('cursor-wait');
				Pending.hide();
			});
	});
}

// Close Add Entry modal and reset form
let btnCloseEntryEditModal = editEntryModal.querySelector('.js-modal-close');
if (btnCloseEntryEditModal) {
	btnCloseEntryEditModal.addEventListener('click', function(e) {
		editEntryModal.hide();

		if (editEntryModalForm) {
			editEntryModalForm.reset();
		}
	});
}