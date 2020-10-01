<template id="modal">
	<div class="absolute inset-0 z-50 hidden transition-all duration-200 opacity-0 modal-overlay">
		<div class="absolute inset-0 bg-black opacity-75"></div>
		<div class="absolute inset-0 z-30">
			<div class="flex flex-col items-center justify-center h-full mx-auto">
				<div class="w-full px-4 md:w-2/3 md:px-0 lg:w-3/5 xl:w-3/6 xxl:w-2/5">
					<span class="float-right">
						<button title="Close" class="text-4xl font-bold leading-none text-white text-secondary-200 focus:outline-none hover:text-secondary-100">×</button>
					</span>
				</div>
				<div class="md:w-2/3 md:px-0 lg:w-3/5 xl:w-3/6 xxl:w-2/5">
					<div class="w-full p-4 bg-white rounded modal-content">
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

		var Modal = function(title, bodyContent) {
			if (!(this instanceof Modal)) {
				return new Modal(title, bodyContent);
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
			this.element.classList.remove('hidden', 'opacity-0');
			document.body.classList.add('overflow-hidden');
		};
		Modal.prototype.hide = function() {
			this.element.classList.add('hidden', 'opacity-0');
			document.body.classList.remove('overflow-hidden');
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