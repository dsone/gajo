import Ajax from './components/Ajax';
import Modal from './components/Modal';

import Options from './components/Options';
import Pending from './components/Pending';

// Create modal for adding types
let typeModal = new Modal(document.querySelector('template#modal-type').innerHTML);
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
let btnAddType = document.querySelector('.js-modal-add-type');
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

// Create Drag'n'Drop features
let draggable = Array.from(document.querySelectorAll('.draggable-item .js-btn-drag'));
let start = function(event, parent) {
	event.dataTransfer.setData('text/html', parent.outerHTML);
	event.dataTransfer.setData('text/plain', parent.dataset.id);
};
draggable.forEach(function(el) {
	let parent = el.closest('.draggable-item');
	el.addEventListener('dragstart', function(e) {
		start(e, parent);
		parent.classList.add('dragging');
	});
	el.addEventListener('dragend', function(e) {
		parent.classList.remove('dragging');
	});
});
Array.from(document.querySelectorAll('.drag-target')).forEach(el => {
	el.addEventListener('dragover', function(e) {  // auto fires every 350ms-ish
		e.preventDefault();
	});

	el.addEventListener('drop', function(e) {  // auto fires every 350ms-ish
		console.log('test', e.dataTransfer);
		Array.from(document.querySelectorAll('.drop')).forEach(el => el.classList.remove('drop'));
		document.querySelector(`[data-id="${ e.dataTransfer.getData('text/plain') }"]`).remove();
		e.currentTarget.innerHTML = e.currentTarget.innerHTML + e.dataTransfer.getData('text/html');
	});

	el.addEventListener('dragenter', function(e) {
		e.currentTarget.classList.add('drop');
	});
	el.addEventListener('dragleave', function(e) {
		e.currentTarget.classList.remove('drop');
	});
});