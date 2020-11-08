export default function TypeList(config = {}) {
    if (!(this instanceof TypeList)) {
        return new TypeList(config);
    }

	this.container = config.container;
	this.emptyContainer = config.emptyContainer;
	/**this.types = [
		{
			"id": 1,
			"name": "Test",
			"ident_1": "Test1",
			"ident_2": "Test1",
			"sort": 1,
			"display": 1
		}
	];*/
	this.types = config.types.slice(0);
	this.template = config.template;
	this.renderCallback = config.renderCallback;
	this.dragndropCallback = config.dragndropCallback;
	this.updateTypeCallback = config.updateTypeCallback;

	this.render();
}

/**
 * Returns a type by a given index, wheras the index means the index of the position inside the types array.
 * Removing types will obviously change the index
 * 
 * @param 	integer	i	The index of the type to return.
 * @returns				The Type JSON literal representing the requested type, by value, not ref.	
 */
TypeList.prototype.getByIndex = function(i) {
	if (typeof(this.types[i]) === 'undefined') {
		return undefined;
	}
	return this.types.slice(i, i+1)[0];
};

TypeList.prototype.getTypes = function() {
	return this.types;
};

/**
 * Removes a Type by its id. Using id here is more secure than using the Type's index position.
 * Rerenders the type display after removal.
 * 
 * @param	integer	id	The id of the Type to remove.
 */
TypeList.prototype.removeById = function(id) {
	this.types = this.types.filter(type => type.id !== id);
	this.render();
};

/**
 * Adds a new Type to the list.
 * 
 * @param JSON	type	The JSON representation of the new Type.
 */
TypeList.prototype.addType = function(type) {
	this.types.push(type);
	this.render();
};

TypeList.prototype.render = function() {
	this.container.innerHTML = '<div class="h-6 drag-target" data-target="-1">&nbsp;</div>';

	if (this.types.length > 0) {
		this.emptyContainer.classList.add('hidden');

		let events = {
			selects: [],
			inputs: [],
			selectedIndex: {}
		};
		//! Setting innerHTML with '+=' resets events and the selectedIndex on previous selects
		this.types.forEach((type, index) => {
			let element = this.template.slice(0);
				element = element.replace(/#type_id#/gim, type.id)
								.replace(/#type_name#/gim, type.name)
								.replace(/#type_ident1#/gim, type.ident_1)
								.replace(/#type_ident2#/gim, type.ident_2)
								.replace(/#type_index#/gim, index);
			this.container.innerHTML += element;

			element = this.container.querySelector(`div[data-id="${ type.id }"]`);

			events.selectedIndex[type.id] = type.display - 1;
			events.selects.push([ type.id, element.querySelector('.js-type-select') ]);
			events.inputs.push([
				type.id, [
					element.querySelector('.js-type-name'),
					element.querySelector('.js-type-ident1'),
					element.querySelector('.js-type-ident2')
				]
			]);
		});
		
		// No set events as needed
		this.types.forEach((type, index) => {
			let typeElement = this.container.querySelector(`div[data-id="${ type.id }"]`);
			let select = typeElement.querySelector('.js-type-select');
				select.selectedIndex = events.selectedIndex[type.id];
				select.addEventListener('change', e => {
					this.update(type, select.name, parseInt(select.options[select.selectedIndex].value));
				});
			[
				typeElement.querySelector('.js-type-name'),
				typeElement.querySelector('.js-type-ident1'),
				typeElement.querySelector('.js-type-ident2')
			].forEach(el => {
				el.addEventListener('change', e => {
					this.update(type, el.name, el.value);
				});
			});
		});

		this.dragndrop();
	} else {
		this.emptyContainer.classList.remove('hidden');
		if (!!this.renderCallback) {
			this.renderCallback(false);
		}
	}
};

/**
 * Adds event listeners for drag and drop.
 * Deals with changing position of a Type within the list.
 * Calls render() when necessary and a custom callback function on drop.
 */
TypeList.prototype.dragndrop = function() {
	// Create Drag'n'Drop features
	let draggable = Array.from(document.querySelectorAll('.draggable-item .js-btn-drag'));

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
	Array.from(document.querySelectorAll('.drag-target')).forEach(el => {
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
			if (!!that.dragndropCallback) {
				that.dragndropCallback();
			}
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

	if (!!this.renderCallback) {
		this.renderCallback(true);
	}
};

TypeList.prototype.update = function(type, attrName, value) {
	// Name has a unique constraint for a user
	if (attrName === 'name') {
		let uniqueNameError = this.types.some(tp => {
			return tp.name === value && tp.id !== type.id;
		});

		if (uniqueNameError) {
			notify.danger('Error', 'Name of Type must be unique!');
			return this.render();  // deletes duplicate name
		}
	}

	if (!!this.updateTypeCallback) {
		let copy = Object.assign({}, type);
			copy[attrName] = value;
		this.updateTypeCallback(copy).then(success => {
			if (success) {
				type[attrName] = value;
			}

			// if error, success = false -> reset to old value
			this.render();
		});
	}
};