<template id="modal">
	<div class="absolute inset-0 z-50 hidden transition-all duration-200 opacity-0 modal-overlay">
		<div class="absolute inset-0 bg-black opacity-75"></div>
		<div class="absolute inset-0 z-30">
			<div class="flex flex-col items-center p-4 mx-auto mt-4 lg:mt-16">
				<div class="absolute top-0 right-0 mt-6 mr-6">
					<span class="float-right">
						<button title="Close" class="text-4xl font-bold leading-none text-white text-secondary-200 focus:outline-none hover:text-secondary-100">×</button>
					</span>
				</div>
				<div class="w-full p-8 pt-6 mx-auto mt-16 bg-white rounded md:w-2/3 lg:w-1/2 xl:w-1/3">
					<div class="modal-content">
						{{-- dynamically filled --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	(function() {
		var modalTmpl = document.querySelector('template#modal').content;

		var Modal = function(bodyContent) {
			if (!(this instanceof Modal)) {
				return new Modal(bodyContent);
			}

			this.element = modalTmpl.cloneNode(true);
			this.content = this.element.querySelector('.modal-content');
			this.content.innerHTML = bodyContent;
			document.body.appendChild(this.element);
			this.element = document.body.lastElementChild;
			this.btnClose = this.element.querySelector('button');

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
		};
		Modal.prototype.close = function() {
			this.hide();
		};
		window.Modal = Modal;

		document.body.addEventListener('keyup', e => {
			let key = e.keyCode || e.which;
			if (key === 27) {
				var openModal = document.querySelector('.modal-overlay:not(.hidden)');
				if (openModal) {
					openModal.click();
				}
			}
		});
	})();
</script>