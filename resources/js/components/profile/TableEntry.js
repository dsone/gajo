export default function TableEntry(config = {}) {
	if (!(this instanceof TableEntry)) {
		return new TableEntry(config);
	}

	this.config = {
		parent:			config.parent,
		editable:		config.editable,
		ajax:			config.ajax,
		pending:		config.pending,
		entryTemplate:	config.entryTemplate,
	};
	this.data = Object.assign({}, config.entry);
}
TableEntry.prototype.getElement = function() {
	let _div = document.createElement('div');
	let entry = this.config.entryTemplate.slice(0);

	_div.innerHTML = entry;
	entry = _div.firstElementChild;

	entry.setAttribute('entry-id', this.data.id);
	entry.querySelector('div[bind-ident1]').innerHTML = this.data.ident_1;
	entry.querySelector('div[bind-ident2]').innerHTML = this.data.ident_2;
	entry.querySelector('div[bind-release]').innerHTML = this.data.release_at != null ? new Date(this.data.release_at).toLocaleDateString(): 'TBA';

	if (this.config.editable) {
		let visibility = entry.querySelector('div[bind-visibility]');
			visibility.classList.add('entry-visibility--' + ['', 'green', 'orange', '', 'red'][this.data.visibility]);
			visibility.setAttribute('title', ['', 'Hidden', 'Private', '', 'Public'][this.data.visibility]);

		entry.querySelector('div[bind-edit]').setAttribute('entry-id', this.data.id);
		entry.querySelector('div[bind-remove]').setAttribute('entry-id', this.data.id);
	} else {
		Array.from(entry.querySelectorAll('[private]')).forEach(el => el.remove());
	}

	return entry;
};
TableEntry.prototype.update = function(update) {
	this.data = Object.assign({}, this.data, update);
};
TableEntry.prototype.getId = function() {
	return this.data.id;
};
TableEntry.prototype.getIdent1 = function() {
	return this.data.ident_1;
};
TableEntry.prototype.getIdent2 = function() {
	return this.data.ident_2;
};
TableEntry.prototype.getRelease = function() {
	return this.data.release_at;
};
TableEntry.prototype.getVisibility = function() {
	return this.data.visibility;
};
TableEntry.prototype.getTypeId = function() {
	return this.data.type_id;
};