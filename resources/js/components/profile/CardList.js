import Card from './Card';

export default function CardList(config = {}) {
	if (!(this instanceof CardList)) {
		return new CardList(config);
    }

	this.config = {
		ajax:				config.ajax,
		pending:			config.pending,
		entryTemplate:		config.entryTemplate,

		targetContainer:	config.targetContainer,
		sectionTemplate:	config.sectionTemplate,
		modalEntryRemove:	config.modalEntryRemove,

		sectionContainer: undefined,
	};
	this.data = Object.assign({}, config.type);
	this.entries = this.data.entries.map(entry => {
		return new Card({
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
CardList.prototype.getId = function() {
	return this.data.id;
};
CardList.prototype.addEntry = function(entry) {
	this.entries.push(
		new Card({
			parent: this,
			entry,
			ajax: this.config.ajax,
			pending: this.config.pending,
			entryTemplate: this.config.entryTemplate
		})
	);

	this.render();
};
CardList.prototype.getEntryById = function(id) {
	return this.entries.filter(card => card.getId() == id)[0];
};
CardList.prototype.removeEntryById = function(id) {
	if (this.entries.length === 0) { return; }

	this.entries = this.entries.filter(card => card.getId() != id);
	this.render();
};
CardList.prototype.render = function() {
	let cardsTarget = this.config.sectionContainer.querySelector('div[bind-cards]');
	cardsTarget.innerHTML = '';
	if (this.entries.length === 0) {
		this.config.sectionContainer.classList.add('hidden');
		return;
	} else {
		this.config.sectionContainer.classList.remove('hidden');
	}

	this.entries.forEach(card => {
		cardsTarget.appendChild(card.getElement());
	});

	let removalBtn = Array.from(cardsTarget.querySelectorAll('div[bind-remove]'));
		removalBtn.forEach(entryRemoval => {
			entryRemoval.removeAttribute('bind-remove');

			let id = entryRemoval.getAttribute('card-id');
			let card = this.getEntryById(id);
			entryRemoval.addEventListener('click', e => {
				this.config.modalEntryRemove.bindValues({
					'[bind-ident1]': card.getIdent1(),
					'[bind-ident2]': card.getIdent2(),
					'[bind-release]': card.getRelease(),
					'[bind-entry-id]': id,
					'[bind-entry-type]': 2,
				});
				this.config.modalEntryRemove.show();
			});
		});
};