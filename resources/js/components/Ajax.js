let axios = require('axios');
	axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Used as dependency inside Options.js rather than hardcode axios in it.
 * If any other library than Axios is used, just change the respective functions here and
 * return a Promise of that other library.
 */
function Ajax() {
	let post = async (url, data) => {
		return axios.post(url, Object.assign({}, data));
    };

	let put = async (url, data) => {
		return axios.put(url, Object.assign({}, data));
    };

	let get = async (url) => {
		return axios.get(url);
    };

	return {
		get, put, post
	};
};

export default new Ajax();
