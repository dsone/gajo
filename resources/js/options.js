import Ajax from './components/Ajax';
import Modal from './components/Modal';
import Pending from './components/Pending';
import TypeList from './components/TypeList';
import Options from './components/options/Options';

// Init Options
let options = new Options({
	privateProfile:	$('.js-options-privateProfile'),
	colorblind:		$('.js-options-colorblind'),
	hideReleased:	$('.js-options-hideReleased'),
	hideTBA:		$('.js-options-hideTBA'),
	rss:			$('.js-options-rss'),
	changeRSS:		$('.js-btn-rss'),
	ajax:			Ajax,
	pending:		Pending,
});

// Create Modal for confirmation of type removal
let removalConfirmModal = new Modal($('template#modal-remove-confirm').innerHTML);
// Init Types
let typeList = new TypeList({
	container:		$('.js-types-container'),
	emptyContainer: $('.js-types-empty'),
	template:		$('template#type-item').innerHTML,
	types:			__TYPES,
	// Whenever a rendering was done, reset events
	renderCallback: function(listAvailable) {
		if (listAvailable) {
			let btnRemove = $$('.js-remove-type');
			btnRemove.forEach(btn => {
				btn.addEventListener('click', e => {
					let index = btn.getAttribute('data-index');
					let type = this.getByIndex(index);
					if (parseInt(type.entries_count, 10) > 0) {
						notify.warning(
							'Non-Empty Type', 
							`Only empty types can be deleted!<br>Remove its ${ type.entries_count + (type.entries_count > 1 ? ' entries' : ' entry') } first.`
						);
						return;
					}

					let elName = removalConfirmModal.querySelector('[bind-name]');
					let ident1 = removalConfirmModal.querySelector('[bind-ident1]');
					let ident2 = removalConfirmModal.querySelector('[bind-ident2]');
					let confirmBtn = removalConfirmModal.querySelector('[bind-type-id]');

					try {
						elName.innerHTML = type.name;
						ident1.innerHTML = type.ident_1;
						ident2.innerHTML = type.ident_2;
						confirmBtn.setAttribute('type-id', type.id);
					} catch(e) {
						return;
					}

					removalConfirmModal.show();
				});
			});
		}
	},
	// Updating order via dragndrop invokes this function
	// if nothing was changed, this is not called
	dragndropCallback: function() {
		let newOrder = this.types.reduce( (prevV, curV) => {
			prevV.push(curV.id);
			return prevV;
		}, []);
		
		Ajax.post(
				__ROUTES.types.order, { order: newOrder }
			).then(resp => {
				let json = resp.data;
				if (!json.error) {
					notify.success('Success', 'Order saved!');
				} else {
					notify.danger('Error', json.message);
				}
			}).catch(err => {
				notify.danger('Error', err.message);
			}).finally(resp => {
				Pending.hide();

				return resp;
			});
	},
	// If a type was chaned inline, this func is invoked
	updateTypeCallback: function(type) {
		Pending.show();

		return Ajax.post(
				__ROUTES.types.update, {
					_method: 'put',
					...type
				}
			).then(resp => {
				let json = resp.data;
				if (!json.error) {
					notify.success('Success', 'Type updated');
				} else {
					notify.danger('Error', json.message);
				}

				return !json.error;
			}).catch(err => {
				notify.danger('Error', err.message);

				return false;
			}).finally(resp => {
				Pending.hide();

				return resp;
			});
	}
});


// Create modal for adding types
let typeModal = new Modal($('template#modal-type').innerHTML);
let typeModalForm = typeModal.querySelector('form');
let btnCloseModal = typeModal.querySelector('.js-modal-close');
if (btnCloseModal) {
	btnCloseModal.addEventListener('click', function(e) {
		typeModal.hide();

		if (typeModalForm) {
			typeModalForm.reset();
		}
	});
}

// Save a type
let btnSaveType = typeModal.querySelector('.js-save-type');
if (btnSaveType) {
	btnSaveType.addEventListener('click', function(e) {
		let errName = typeModal.querySelector('[error-name]');
		let err1 = typeModal.querySelector('[error-ident1]');
		let err2 = typeModal.querySelector('[error-ident2]');
		let errorFound = false;
		if (typeList.getTypes().some(type => type.name === typeModalForm.name.value)) {
			errName && errName.classList.remove('hidden'), typeModalForm.name.classList.remove('border-red-700');
			setTimeout(() => {
				errName && errName.classList.add('hidden');
			}, 4000);

			return;
		}
		[ [ 'name', errName ], [ 'ident_1', err1 ], [ 'ident_2', err2] ].forEach((check, index) => {
			if (check[1] && typeModalForm[check[0]].value === '') {
				check[1].classList.remove('hidden');
				typeModalForm[check[0]].classList.add('border-red-700');
				setTimeout(() => {
					check[1].classList.add('hidden');
					typeModalForm[check[0]].classList.remove('border-red-700');
				}, 4000);
				errorFound = true;
			} else if (check[1]) {
				check[1].classList.add('hidden');
				typeModalForm[check[0]].classList.remove('border-red-700');
			}
		});
		if (errorFound) {
			return;
		}

		if (Pending.isPending()) {
			notify.warning('Warning', 'Another request is in progress, please wait a second!');
			return;
		}

		btnSaveType.setAttribute('disabled', 'disabled');
		btnSaveType.classList.add('cursor-wait');
		Pending.show();
		Ajax.post(
				__ROUTES.types.store, {
					name: typeModalForm.name.value,
					ident_1: typeModalForm.ident_1.value,
					ident_2: typeModalForm.ident_2.value,
					display: typeModalForm.display.options[typeModalForm.display.selectedIndex].value
				}
			).then(resp => {
				let json = resp.data;
				if (!json.error) {
					typeModal.hide();

					typeList.addType(json.data);
					if (typeModalForm) {
						typeModalForm.reset();
					}

					notify.success('Success', 'Type added');
				} else {
					notify.danger('Error', json.message);
				}
			}).catch(err => {
				notify.danger('Error', err.message);
			}).finally(resp => {
				btnSaveType.removeAttribute('disabled');
				btnSaveType.classList.remove('cursor-wait');
				Pending.hide();
			});
	});
}
// Open Form modal for new Type
let btnAddType = $('.js-modal-add-type');
if (btnAddType) {
	btnAddType.addEventListener('click', function() {
		typeModal.show();
	});
}


// Create Modal to remove a type
let btnAbortRemoval = removalConfirmModal.querySelector('.js-modal-close');
if (btnAbortRemoval) {
	btnAbortRemoval.addEventListener('click', function(e) {
		removalConfirmModal.hide();
	});
}
// Remove type
let btnConfirmRemoval = removalConfirmModal.querySelector('.js-modal-confirm');
if (btnConfirmRemoval) {
	btnConfirmRemoval.addEventListener('click', function(e) {
		if (Pending.isPending()) {
			notify.warning('Warning', 'Another request is in progress, please wait a second!');
			return;
		}

		btnConfirmRemoval.setAttribute('disabled', 'disabled');
		btnConfirmRemoval.classList.add('cursor-pointer');
		let typeId = parseInt(btnConfirmRemoval.getAttribute('type-id'));
		if (!!typeId) {
			Pending.show();
			Ajax.post(
					__ROUTES.types.remove, 
					{ id: typeId, _method: 'delete' }
				).then(resp => {
					let json = resp.data;
					if (!json.error) {
						typeList.removeById(typeId);

						notify.success('Success', 'Type removed');
					} else {
						notify.danger('Error', json.message);
					}
				}).catch(err => {
					notify.danger('Error', err.message);
				}).finally(resp => {
					btnConfirmRemoval.removeAttribute('disabled');
					btnConfirmRemoval.classList.remove('cursor-wait');

					removalConfirmModal.hide();
					Pending.hide();
				});
		}
	});
}