import Ajax from '../components/Ajax';
import Modal from '../components/Modal';
import Pending from '../components/Pending';
import TypeList from '../components/TypeList';

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
					
					let elName = removalConfirmModal.element.querySelector('[bind-name]');
					let ident1 = removalConfirmModal.element.querySelector('[bind-ident1]');
					let ident2 = removalConfirmModal.element.querySelector('[bind-ident2]');
					let confirmBtn = removalConfirmModal.element.querySelector('[bind-type-id]');

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
					notify('Success', 'Order saved!', 'success');
				} else {
					notify('Error', json.message, 'danger');
				}
				Pending.hide();
			}).catch(err => {
				notify('Error', err.message, 'danger');
				Pending.hide();
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
					notify('Success', 'Type updated', 'success');
				} else {
					notify('Error', json.message, 'danger');
				}
				Pending.hide();

				return !json.error;
			}).catch(err => {
				notify('Error', err.message, 'danger');
				Pending.hide();

				return false;
			});
	}
});


// Create modal for adding types
let typeModal = new Modal($('template#modal-type').innerHTML);
let typeModalForm = typeModal.element.querySelector('form');
let btnCloseModal = typeModal.element.querySelector('.js-modal-close');
if (btnCloseModal) {
	btnCloseModal.addEventListener('click', function(e) {
		typeModal.hide();

		if (typeModalForm) {
			typeModalForm.reset();
		}
	});
}

let btnSaveType = typeModal.element.querySelector('.js-save-type');
if (btnSaveType) {
	btnSaveType.addEventListener('click', function(e) {
		typeModal.hide();

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
					typeList.addType(json.data);
					if (typeModalForm) {
						typeModalForm.reset();
					}

					notify('Success', 'Type added', 'success');
				} else {
					notify('Error', json.message, 'danger');
				}
				Pending.hide();
			}).catch(err => {
				notify('Error', err.message, 'danger');
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
let btnAbortRemoval = removalConfirmModal.element.querySelector('.js-modal-close');
if (btnAbortRemoval) {
	btnAbortRemoval.addEventListener('click', function(e) {
		removalConfirmModal.hide();
	});
}
let btnConfirmRemoval = removalConfirmModal.element.querySelector('.js-modal-confirm');
if (btnConfirmRemoval) {
	btnConfirmRemoval.addEventListener('click', function(e) {
		removalConfirmModal.hide();

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

						notify('Success', 'Type removed', 'success');
					} else {
						notify('Error', json.message, 'danger');
					}
					Pending.hide();
				}).catch(err => {
					notify('Error', err.message, 'danger');
					Pending.hide();
				});
		}
	});
}