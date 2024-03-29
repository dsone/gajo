const WEEK_IN_MILLISECONDS = 604_800_000;
const HOURS_48_IN_MILLISECONDS = 172_800_000;

let getReleaseColor = ts => {
	let now = +new Date();
	let _1Week = now + WEEK_IN_MILLISECONDS;
	let _48Hours = now + HOURS_48_IN_MILLISECONDS;

	return ts < now ? 'release-available' : ( ts < _48Hours ? 'release-48-hours' : ( ts < _1Week ? 'release-1-week' : 'release-later' ) );
};

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
		releaseColor:	'',
	};
	this.data = Object.assign({}, config.entry);

	this.config.releaseColor = getReleaseColor( (this.data.release_at === null ? Infinity : +new Date(this.data.release_at)) );
}
Card.prototype.getElement = function() {
	let _div = document.createElement('div');
	let entry = this.config.entryTemplate.slice(0);

	_div.innerHTML = entry;
	entry = _div.firstElementChild;

	entry.setAttribute('entry-id', this.data.id);
	entry.classList.add(this.config.releaseColor);
	let bav = entry.querySelector('[bind-availability]');
		bav.setAttribute('title', bav.querySelector(`.${ this.config.releaseColor }`).getAttribute('title'));
	entry.querySelector('h4[bind-ident1]').innerHTML = this.data.ident_1;
	entry.querySelector('div[bind-ident2]').innerHTML = this.data.ident_2;
	entry.querySelector('div[bind-release]').innerHTML = this.data.release_at != null ? new Intl.DateTimeFormat(undefined, { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(this.data.release_at)) : 'TBA';

	if (this.config.editable) {
		let color = ['', 'green', 'orange', '', 'red'][this.data.visibility];
		let visibility = entry.querySelector('div[bind-visibility]');
			visibility.classList.add(`card-visibility--${ color }`);
			visibility.setAttribute('title', ['', 'Hidden', 'Private', '', 'Public'][this.data.visibility]);

		let icon = visibility.querySelector(`[icon-${ color }]`);
			icon && icon.classList.remove('hidden');

		entry.querySelector('div[bind-edit]').setAttribute('entry-id', this.data.id);
		entry.querySelector('div[bind-remove]').setAttribute('entry-id', this.data.id);
	} else {
		Array.from(entry.querySelectorAll('[private]')).forEach(el => el.remove());
	}

	return entry;
};
Card.prototype.update = function(update) {
	this.data = Object.assign({}, this.data, update);
	this.config.releaseColor = getReleaseColor( (this.data.release_at === null ? Infinity : +new Date(this.data.release_at)) );
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