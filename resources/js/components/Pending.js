let Pending = (() => {
	let container = undefined;
	let pending = false;

	let init = () => {
		let id = +new Date();
		
		container = document.createElement('div');
		container.setAttribute('id', `i${ id }`);
		container.setAttribute('class', 'pending-container fixed bottom-0 left-0 ml-4 mb-4 text-primary-400 animated slow invisible');
		container.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>';
		document.body.appendChild(container);
		container = document.querySelector(`#i${ id }`);
	};

	// trigger once for "above the fold" images
	document.addEventListener("DOMContentLoaded", function() {
		init();
	});

	let show = () => {
		container.classList.remove('invisible');
		container.classList.add('flash');
		pending = true;
	};
	let hide = () => {
		container.classList.add('invisible');
		container.classList.remove('flash');
		pending = false;
	};
	let isPending = () => {
		return pending;
	};

	return {
		hide, show, isPending
	}
})();

module.exports = Pending;