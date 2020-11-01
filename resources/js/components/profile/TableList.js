import TableEntry from './TableEntry';

export default function TableList(config = {}) {
	if (!(this instanceof TableList)) {
		return new TableList(config);
    }

	this.config = {
		ajax:				config.ajax,
		pending:			config.pending,
		entryTemplate:		config.entryTemplate,

		targetContainer:	config.targetContainer,
		sectionTemplate:	config.sectionTemplate,
		tableTemplate:		config.tableTemplate,
		entryTemplate:		config.entryTemplate,
		modalEntryRemove:	config.modalEntryRemove,
		modalEntryEdit:		config.modalEntryEdit,

		sectionContainer:	undefined,
	};

	this.data = Object.assign({}, config.type);
	this.entries = this.data.entries.map(entry => {
		return new TableEntry({
				parent: this,
				entry,
				ajax: this.config.ajax,
				pending: this.config.pending,
				entryTemplate: this.config.entryTemplate
			});
	});

	(() => {
		// Create the new section for this new card list
		let _div = document.createElement('div');
		let section = this.config.sectionTemplate.slice(0);
			_div.innerHTML = section;
			section = _div.firstElementChild;
			section.querySelector('h3[bind-section-title]').innerHTML = this.data.name;

		this.config.sectionContainer = section;

		// Reserve place inside target container place inside 
		this.config.targetContainer.appendChild(this.config.sectionContainer);

		this.render();
	})();
}
TableList.prototype.getId = function() {
	return this.data.id;
};
TableList.prototype.addEntry = function(entry) {
	this.entries.push(
		new TableEntry({
			parent: this,
			entry,
			ajax: this.config.ajax,
			pending: this.config.pending,
			entryTemplate: this.config.entryTemplate
		})
	);

	this.render();
};
TableList.prototype.getEntryById = function(id) {
	return this.entries.filter(entry => entry.getId() == id)[0];
};
TableList.prototype.removeEntryById = function(id) {
	if (this.entries.length === 0) { return; }

	this.entries = this.entries.filter(entry => entry.getId() != id);
	this.render();
};
TableList.prototype.modifyEntry = function(id, update) {
	if (this.entries.some((entry, index) => {
		if (entry.id == id) {
			this.entries[index] = Object.assign({}, this.entries[index], update);

			return true;
		}
		return false;
	})) {
		this.render();
	}
};
TableList.prototype.getEntries = function() {
	return this.entries;
};
TableList.prototype.render = function() {
	let tableTarget = this.config.sectionContainer.querySelector('div[bind-table]');
	tableTarget.innerHTML = '';

	if (this.entries.length === 0) {
		this.config.sectionContainer.classList.add('hidden');
		return;
	} else {
		this.config.sectionContainer.classList.remove('hidden');
	}

	let _div = document.createElement('div');
	let newTable = this.config.tableTemplate.slice(0);
		_div.innerHTML = newTable;
		newTable = _div.firstElementChild;
		newTable.querySelector('div[bind-ident1]').innerHTML = this.data.ident_1;
		newTable.querySelector('div[bind-ident2]').innerHTML = this.data.ident_2;

	this.entries.forEach(tableEntry => {
		newTable.appendChild(tableEntry.getElement());
	});
	tableTarget.appendChild(newTable);

	let removalBtn = Array.from(tableTarget.querySelectorAll('div[bind-remove]'));
		removalBtn.forEach(entryRemoval => {
			entryRemoval.removeAttribute('bind-remove');

			let id = entryRemoval.getAttribute('entry-id');
			let entry = this.getEntryById(id);
			entryRemoval.addEventListener('click', e => {
				this.config.modalEntryRemove.bindValues({
					'[bind-ident1]': entry.getIdent1(),
					'[bind-ident2]': entry.getIdent2(),
					'[bind-release]': entry.getRelease(),
					'[bind-entry-id]': id,
					'[bind-entry-type]': 1,
				});
				this.config.modalEntryRemove.show();
			});
		});

	let editBtn = Array.from(tableTarget.querySelectorAll('div[bind-edit]'));
		editBtn.forEach(entryEdit => {
			entryEdit.removeAttribute('bind-edit');

			let id = entryEdit.getAttribute('entry-id');
			let entry = this.getEntryById(id);

			entryEdit.addEventListener('click', e => {
				this.config.modalEntryEdit.bindValues({
					'select[name=type]': this.data.id,
					'[bind-ident1]': entry.getIdent1(),
					'input[name=ident_1]': entry.getIdent1(),
					'[bind-ident2]': entry.getIdent2(),
					'input[name=ident_2]': entry.getIdent2(),
					'input[name=release]': (entry.getRelease() || '').substr(0, 10),  // date input only accept yyyy-mm-dd values
					'[bind-entry-id]': id,
					'[bind-entry-type]': this.data.id,
				});
				this.config.modalEntryEdit.show();
			});
		});
};