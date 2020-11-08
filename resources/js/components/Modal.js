let Modal = (() => {
	let modalTmpl = document.querySelector('template#modal').content;

	let Modal = function(bodyContent) {
		if (!(this instanceof Modal)) {
			return new Modal(bodyContent);
		}

		this.element = modalTmpl.cloneNode(true);
		this.content = this.element.querySelector('.modal-content');
		this.content.innerHTML = bodyContent;
		document.body.appendChild(this.element);
		this.element = document.body.lastElementChild;
		this.btnClose = this.element.querySelector('button');
		this.scrollTop = 0;
		this.disableBackdrop = !!this.element.querySelector('[disable-backdrop]');

		if (!this.disableBackdrop) {
			this.element.addEventListener('mousedown', e => {
				if (e.which != 1) { return; }

				if (e.target.closest('.modal-content')) {
					return;
				}

				this.hide();
			});
		}
		this.btnClose.addEventListener('click', e => {
			this.hide();
		});
	};

	Modal.prototype.show = function() {
		this.scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

		window.scrollTo(0, 0);
		this.element.classList.remove('hidden', 'opacity-0');
		document.body.classList.add('overflow-hidden');
	};
	Modal.prototype.open = function() {
		this.show();
	};
	Modal.prototype.hide = function() {
		this.element.classList.add('hidden', 'opacity-0');
		document.body.classList.remove('overflow-hidden');

		window.scrollTo(0, this.scrollTop);
	};
	Modal.prototype.close = function() {
		this.hide();
	};
	Modal.prototype.querySelector = function(selector) {
		return this.element.querySelector(selector);
	};

	Modal.prototype.bindValues = function(mapping = {}) {
		let selectors = Object.keys(mapping);
		selectors.forEach(selector => {
			let elements = Array.from(this.element.querySelectorAll(selector));

			elements.forEach(element => {
				switch (element.nodeName.toLocaleLowerCase()) {
					case 'select':
						Array.from(element.options).some((option, i) => {
							if (option.value == mapping[selector]) {
								element.selectedIndex = i;
								return true;
							}

							return false;
						});
					break;
					case 'input':
						switch (element.type) {
							case 'radio':  // radios share a name, hence no else
								if(element.value == mapping[selector]) {
									element.checked = true;
								}
							break;

							default:
								element.value = mapping[selector];
							break;
						}
					break;
					case 'textarea':
						element.value = mapping[selector];
					break;
					case 'button':
						element.setAttribute(selector.replace(/\[|\]|bind-/gi, ''), mapping[selector]);
					break;
					default:
						element.innerHTML = mapping[selector];
					break;
				}
			});
		});
	};

	document.body.addEventListener('keyup', e => {
		let key = e.keyCode || e.which;
		if (key === 27) {
			var openModal = document.querySelector('.modal-overlay:not(.hidden)');
			if (openModal) {
				let closeBtn = openModal.querySelector('[bind-close]');
				closeBtn && closeBtn.click();
			}
		} else if (key === 13) {
			var openModal = document.querySelector('.modal-overlay:not(.hidden)');
			if (openModal) {
				let btnConfirm = openModal.querySelector('.js-modal-confirm');
				if (btnConfirm) {
					btnConfirm.click();
				}
			}
		}
	});
	window.Modal = Modal;

	return Modal;
})();
module.exports = Modal;