import Notify from './components/Notify';

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function() {
	window.notify = Notify;
})();