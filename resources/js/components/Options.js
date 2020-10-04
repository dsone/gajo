export default function Options(config = {}) {
    if (!(this instanceof Options)) {
        return new Options(config);
    }

	/**
	 * privateProfile:	The private profile checkbox,
	 * colorblind:		color blind mode checkbox,
	 * hideReleased:	auto hide released checkbox,
	 * hideTBA:			auto hide TBA entries checkbox,
	 * rss:				The input for RSS token,
	 * changeRSS:		button to change RSS id
	 * ajax:			An instance of Ajax, implementing the functions put, post, get
	 */
	this.config = Object.assign({
		ajaxInProgress: false,
	}, config);
	this.data = {
		privateProfile:	this.config.privateProfile.checked,
		colorblind:		this.config.colorblind.checked,
		hideReleased:	this.config.hideReleased.checked,
		hideTBA:		this.config.hideTBA.checked,
	};

	let main = () => {
		this.config.changeRSS.addEventListener('click', async () => {
			try {
				let uri = this.config.changeRSS.getAttribute('data-uri');

				this.config.changeRSS.setAttribute('disabled', 'disabled');
				this.config.ajax.get(uri)
					.then(json => {
						if (!json.data.error) {
							this.config.rss.value = json.data.data;
							notify('Success', 'Updated RSS token', 'success');
						} else {
							notify('Error', json.message, 'danger');
						}
						this.config.changeRSS.removeAttribute('disabled', 'disabled');
					})
					.catch(json => {
						this.config.changeRSS.removeAttribute('disabled', 'disabled');
						notify('Error', 'Failed to update RSS token', 'danger');
					});
			} catch (e) {
				console.error(e);
			}
		});

		let timer = undefined;
		[ 'privateProfile', 'colorblind', 'hideReleased', 'hideTBA' ].forEach(key => {
			this.config[key].addEventListener('click', e => {
				if (this.config.ajaxInProgress) {
					e.preventDefault();
					return;
				}
				this.data = Object.assign({ _method: 'put' }, this.data);
				this.data[key] = this.config[key].checked;

				let update = data => {
					this.config.ajaxInProgress = true;
					this.config.ajax.put(__ROUTES.options, data)
						.then(json => {
							if (!json.data.error) {
								this.data[key] = this.config[key].checked;
								notify('Success', 'Updated Options', 'success');
							} else {
								notify('Error', json.message, 'danger');
							}
							this.config.ajaxInProgress = false;
						})
						.catch(json => {
							this.config.ajaxInProgress = false;
							notify('Error', 'Failed to update RSS token', 'danger');
						});
				};
				clearTimeout(timer);
				timer = setTimeout(() => update(this.data), 2000);
			});
		});
	};
	main();
}