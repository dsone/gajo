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

		var that = this;
		this.element.addEventListener('click', function(e) {
			if (e.target.closest('.modal-content')) {
				return;
			}

			that.hide();
		});
		this.btnClose.addEventListener('click', function(e) {
			that.element.click();
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

	document.body.addEventListener('keyup', e => {
		let key = e.keyCode || e.which;
		if (key === 27) {
			var openModal = document.querySelector('.modal-overlay:not(.hidden)');
			if (openModal) {
				openModal.click();
			}
		}
	});
	window.Modal = Modal;

	return Modal;
})();
module.exports = Modal;