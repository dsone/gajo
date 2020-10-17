export default function Types(config = {}) {
    if (!(this instanceof Types)) {
        return new Types(config);
    }

	this.container = config.container;
	this.emptyContainer = config.emptyContainer;
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
	this.container.innerHTML = '<div class="h-6 drag-target" data-target="-1">&nbsp;</div>';

	if (this.types.length > 0) {
		this.emptyContainer.classList.add('hidden');

		this.types.forEach((type, index) => {
			let element = this.template.slice(0);
				element = element.replace(/#type_id#/gim, type.id)
								.replace(/#type_id_url#/gim, type.id)
								.replace(/#type_name#/gim, type.name)
								.replace(/#type_ident1#/gim, type.ident_1)
								.replace(/#type_ident2#/gim, type.ident_2)
								.replace(/#type_index#/gim, index);
			this.container.innerHTML += element;

			element = this.container.querySelector(`div[data-id="${ type.id }"]`);
			let select = element.querySelector('.js-type-select');
				select.selectedIndex = type.display - 1;
		});

		this.dragndrop();
	} else {
		this.emptyContainer.classList.remove('hidden');
	}
};

Types.prototype.dragndrop = function() {
	// Create Drag'n'Drop features
	let draggable = Array.from($$('.draggable-item .js-btn-drag'));

	let draggedItemIndex;
	draggable.forEach(function(el) {
		let parent = el.closest('.draggable-item');
		el.addEventListener('dragstart', function(e) {
			draggedItemIndex = parseInt(parent.querySelector('.drag-target').getAttribute('data-target'), 10);

			parent.classList.add('dragging');
		});
		el.addEventListener('dragend', function(e) {
			parent.classList.remove('dragging');
		});
	});

	let that = this;
	Array.from($$('.drag-target')).forEach(el => {
		let draggedItemTargetIndex = parseInt(el.getAttribute('data-target'));

		el.addEventListener('dragover', function(e) {  // auto fires every 350ms-ish
			e.preventDefault();
		});

		el.addEventListener('drop', function(e) {
			if (draggedItemTargetIndex > draggedItemIndex) {  // = is excluded below
				that.types.splice(draggedItemTargetIndex, 0, ...that.types.splice(draggedItemIndex, 1));
			} else {
				// if a type is moved upwards (lower index) we need to add 1 to target,
				// or we move before the target, ie 2 upwards instead of 1
				that.types.splice(draggedItemTargetIndex+1, 0, ...that.types.splice(draggedItemIndex, 1));
			}

			that.render();
		});

		el.addEventListener('dragenter', function(e) {
			// skip draggable-item's own drag-target and the target directly before that
			if (draggedItemIndex === draggedItemTargetIndex || draggedItemIndex-1 === draggedItemTargetIndex) {
				return;
			}

			e.currentTarget.classList.add('drop');
		});
		el.addEventListener('dragleave', function(e) {
			e.currentTarget.classList.remove('drop');
		});
	});
};