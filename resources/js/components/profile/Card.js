export default function Card(config = {}) {
	if (!(this instanceof Card)) {
		return new Card(config);
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
Card.prototype.getElement = function() {
	let _div = document.createElement('div');
	let entry = this.config.entryTemplate.slice(0);

	_div.innerHTML = entry;
	entry = _div.firstElementChild;

	entry.setAttribute('entry-id', this.data.id);
	entry.querySelector('h4[bind-ident1]').innerHTML = this.data.ident_1;
	entry.querySelector('div[bind-ident2]').innerHTML = this.data.ident_2;
	entry.querySelector('div[bind-release]').innerHTML = this.data.release_at != null ? new Date(this.data.release_at).toLocaleDateString(): 'TBA';

	console.log(this.config.editable);
	if (this.config.editable) {
		let visibility = entry.querySelector('div[bind-visibility]');
			visibility.classList.add('card-visibility--' + ['', 'green', 'orange', '', 'red'][this.data.visibility]);
			visibility.setAttribute('title', ['', 'Hidden', 'Private', '', 'Public'][this.data.visibility]);

		entry.querySelector('div[bind-edit]').setAttribute('entry-id', this.data.id);
		entry.querySelector('div[bind-remove]').setAttribute('entry-id', this.data.id);
	} else {
		Array.from(entry.querySelectorAll('[private]')).forEach(el => el.remove());
	}

	return entry;
};
Card.prototype.update = function(update) {
	this.data = Object.assign({}, this.data, update);
};
Card.prototype.getId = function() {
	return this.data.id;
};
Card.prototype.getIdent1 = function() {
	return this.data.ident_1;
};
Card.prototype.getIdent2 = function() {
	return this.data.ident_2;
};
Card.prototype.getRelease = function() {
	return this.data.release_at;
};
Card.prototype.getVisibility = function() {
	return this.data.visibility;
};
Card.prototype.getTypeId = function() {
	return this.data.type_id;
};