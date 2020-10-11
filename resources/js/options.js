import Ajax from './components/Ajax';
import Modal from './components/Modal';

import Options from './components/Options';
import Types from './components/Types';
import Pending from './components/Pending';

// Create modal for adding types
let typeModal = new Modal($('template#modal-type').innerHTML);
let btnCloseModal = typeModal.element.querySelector('.js-modal-close');
if (btnCloseModal) {
	let typeModalForm = typeModal.element.querySelector('form');
	btnCloseModal.addEventListener('click', function(e) {
		typeModal.hide();

		if (typeModalForm) {
			typeModalForm.reset();
		}
	});
}
let btnAddType = $('.js-modal-add-type');
if (btnAddType) {
	btnAddType.addEventListener('click', function() {
		typeModal.show();
	});
}

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

// Init Types
let types = new Types({
	container: $('.js-types-container'),
	template: $('template#type-item').innerHTML,
	types: __TYPES,
});