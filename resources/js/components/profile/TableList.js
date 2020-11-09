import TableEntry from './TableEntry';

export default function TableList(config = {}) {
	if (!(this instanceof TableList)) {
		return new TableList(config);
    }

	this.config = {
		ajax:				config.ajax,
		pending:			config.pending,
		editable:			config.editable,
		entryTemplate:		config.entryTemplate,
		sortAscIcon:		config.sortAscIcon,
		sortDescIcon:		config.sortDescIcon,

		targetContainer:	config.targetContainer,
		sectionTemplate:	config.sectionTemplate,
		tableTemplate:		config.tableTemplate,
		entryTemplate:		config.entryTemplate,
		modalEntryRemove:	config.modalEntryRemove,
		modalEntryEdit:		config.modalEntryEdit,

		sectionContainer:	undefined,
		sortby:				'ident_1',
		sortAscending:			true,
	};

	this.data = Object.assign({}, config.type);
	this.entries = this.data.entries.sort((a, b) => {
			try {
				return this.config.sortAscending ? a[this.config.sortby].toLocaleLowerCase().localeCompare(b[this.config.sortby]) : b[this.config.sortby].toLocaleLowerCase().localeCompare(a[this.config.sortby]);
			} catch (e) {
				console.error(e);
				return false;
			}
		}).map(entry => {
			return new TableEntry({
				parent: this,
				editable: config.editable,
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
			editable: this.config.editable,
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
		if (entry.getId() == id) {
			entry.update(update);

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
TableList.prototype.sort = function() {
	let mapFuncs = {
		'ident_1': 'getIdent1',
		'ident_2': 'getIdent2',
	};
	let compareDates = this.config.sortby === 'release_at';
	this.entries.sort((a, b) => {
		if (!compareDates) {
			let cmpA = a[mapFuncs[this.config.sortby] ]().toLocaleLowerCase();
			let cmpB = b[mapFuncs[this.config.sortby] ]().toLocaleLowerCase();

			// push TBA always to the end
			if (cmpA == 'tba' && cmpB == 'tba' || cmpB == 'tba') { return -1; }
			if (cmpA == 'tba') { return 1; }

			return this.config.sortAscending ? cmpA.localeCompare(cmpB) : cmpB.toLocaleLowerCase().localeCompare(cmpA);
		} else {
			let dateA = +new Date((a.getRelease() || 0));
			let dateB = +new Date((b.getRelease() || 0));

			// push nullable dates always to the end
			if (!dateA && !dateB || !dateB) { return -1; }
			if (!dateA) { return 1; }

			return this.config.sortAscending ? dateA - dateB : dateB - dateA;
		}
	});
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
		newTable.querySelector('[bind-ident1]').innerHTML = this.data.ident_1;
		newTable.querySelector('[bind-ident2]').innerHTML = this.data.ident_2;

	this.entries.forEach(tableEntry => {
		newTable.appendChild(tableEntry.getElement());
	});

	if (!this.config.editable) {
		Array.from(newTable.querySelectorAll('[private]')).forEach(el => el.remove());
	}

	tableTarget.appendChild(newTable);

	[...tableTarget.querySelectorAll('[sortby]') ].forEach(head => {
		head.classList.add('cursor-pointer');
		if (head.getAttribute('sortby') === this.config.sortby) {
			head.classList.add(`sorted-by-${ this.config.sortAscending ? 'asc' : 'desc' }`);
			head.innerHTML += this.config.sortAscending ? this.config.sortAscIcon.slice(0) : this.config.sortDescIcon.slice(0);
		}
		head.addEventListener('click', e => {
			if (this.config.sortby === head.getAttribute('sortby')) {
				this.config.sortAscending = !this.config.sortAscending;
			} else {
				this.config.sortAscending = true;
				this.config.sortby = head.getAttribute('sortby');
			}
			this.sort();
			this.render();
		});
	});

	if (!this.config.editable) { return; }
	let removalBtn = Array.from(tableTarget.querySelectorAll('[bind-remove]'));
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

	let editBtn = Array.from(tableTarget.querySelectorAll('[bind-edit]'));
		editBtn.forEach(entryEdit => {
			let event = entryEdit.getAttribute('bind-edit');
			entryEdit.removeAttribute('bind-edit');

			let id = entryEdit.getAttribute('entry-id');
			let entry = this.getEntryById(id);

			entryEdit.addEventListener(event, e => {
				this.config.modalEntryEdit.bindValues({
					'select[name=type]': this.data.id,
					'[bind-ident1]': this.data.ident_1,
					'input[name=ident_1]': entry.getIdent1(),
					'[bind-ident2]': this.data.ident_2,
					'input[name=ident_2]': entry.getIdent2(),
					'input[name=release]': (entry.getRelease() || '').substr(0, 10),  // date input only accept yyyy-mm-dd values
					'input[name=visibility]': entry.getVisibility(),
					'[bind-entry-id]': id,
					'[bind-entry-type]': this.data.id,
				});
				this.config.modalEntryEdit.show();
			});
		});
};