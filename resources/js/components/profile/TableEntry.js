const WEEK_IN_MILLISECONDS = 604_800_000;
const HOURS_48_IN_MILLISECONDS = 172_800_000;

let getReleaseColor = ts => {
	let now = +new Date();
	let _1Week = now + WEEK_IN_MILLISECONDS;
	let _48Hours = now + HOURS_48_IN_MILLISECONDS;

	return ts < now ? 'release-available' : ( ts < _48Hours ? 'release-48-hours' : ( ts < _1Week ? 'release-1-week' : 'release-later' ) );
};

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
		releaseColor:	'',
	};
	this.data = Object.assign({}, config.entry);

	this.config.releaseColor = getReleaseColor( (this.data.release_at === null ? Infinity : +new Date(this.data.release_at)) );
}
TableEntry.prototype.getElement = function() {
	let _div = document.createElement('div');
	let entry = this.config.entryTemplate.slice(0);

	_div.innerHTML = entry;
	entry = _div.firstElementChild;

	entry.setAttribute('entry-id', this.data.id);
	entry.classList.add(this.config.releaseColor);
	let bav = entry.querySelector('[bind-availability]');
		bav.setAttribute('title', bav.querySelector(`.${ this.config.releaseColor }`).getAttribute('title'));
	entry.querySelector('[bind-ident1]').innerHTML = this.data.ident_1;
	entry.querySelector('[bind-ident2]').innerHTML = this.data.ident_2;
	entry.querySelector('[bind-release]').innerHTML = this.data.release_at != null ? new Intl.DateTimeFormat(undefined, { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(this.data.release_at)) : 'TBA';

	if (this.config.editable) {
		let color = ['', 'green', 'orange', '', 'red'][this.data.visibility];

		let visibility = entry.querySelector('[bind-visibility]');
			visibility.classList.add(`entry-visibility--${ color }`);
			visibility.setAttribute('title', ['', 'Hidden', 'Private', '', 'Public'][this.data.visibility]);

		let icon = visibility.querySelector(`[icon-${ color }]`);
			icon && icon.classList.remove('hidden');

		Array.from(entry.querySelectorAll('[bind-edit]')).map(el => el.setAttribute('entry-id', this.data.id));
		Array.from(entry.querySelectorAll('[bind-remove]')).map(el => el.setAttribute('entry-id', this.data.id));
	} else {
		Array.from(entry.querySelectorAll('[private]')).forEach(el => el.remove());
	}

	return entry;
};
TableEntry.prototype.update = function(update) {
	this.data = Object.assign({}, this.data, update);
	this.config.releaseColor = getReleaseColor( (this.data.release_at === null ? Infinity : +new Date(this.data.release_at)) );
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