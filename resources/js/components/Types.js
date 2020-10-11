export default function Types(config = {}) {
    if (!(this instanceof Types)) {
        return new Types(config);
    }

	this.container = config.container;
	this.types = [
		/**
		 {
			 "id": 1,
			 "name": "Test",
			 "ident_1": "Test1",
			 "ident_2": "Test1",
			 "sort": 1,
			 "display": 1
		 }
		 */
	];
	this.types = config.types.slice(0);
	this.template = config.template;

	this.render();
}

Types.prototype.render = function() {
	this.container.innerHTML = '';

	this.types.forEach(type => {
		let element = this.template.slice(0);
			element = element.replace(/#type_id#/gim, type.id)
							 .replace(/#type_id_url#/gim, type.id)
							 .replace(/#type_name#/gim, type.name)
							 .replace(/#type_ident1#/gim, type.ident_1)
							 .replace(/#type_ident2#/gim, type.ident_2);
		this.container.innerHTML += element;

		element = this.container.querySelector(`div[data-id="${ type.id }"]`);
		console.log(element);
		let select = element.querySelector('.js-type-select');
			select.selectedIndex = type.display - 1;
	});

	this.dragndrop();
};

Types.prototype.dragndrop = function() {
	// Create Drag'n'Drop features
	let draggable = Array.from($$('.draggable-item .js-btn-drag'));
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
	Array.from($$('.drag-target')).forEach(el => {
		el.addEventListener('dragover', function(e) {  // auto fires every 350ms-ish
			e.preventDefault();
		});

		el.addEventListener('drop', function(e) {  // auto fires every 350ms-ish
			console.log('test', e.dataTransfer);
			Array.from($$('.drop')).forEach(el => el.classList.remove('drop'));
			$(`[data-id="${ e.dataTransfer.getData('text/plain') }"]`).remove();
			e.currentTarget.innerHTML = e.currentTarget.innerHTML + e.dataTransfer.getData('text/html');
		});

		el.addEventListener('dragenter', function(e) {
			e.currentTarget.classList.add('drop');
		});
		el.addEventListener('dragleave', function(e) {
			e.currentTarget.classList.remove('drop');
		});
	});
};