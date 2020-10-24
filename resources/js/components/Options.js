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

	let toggleInProgress = inProgress => {
		if (inProgress) {
			this.config.ajaxInProgress = true;
			this.config.pending.show();
		} else {
			this.config.ajaxInProgress = false;
			this.config.pending.hide();
		}
	};
	let main = () => {
		this.config.changeRSS.addEventListener('click', async () => {
			if (this.config.ajaxInProgress) {
				e.preventDefault();
				return false;
			}

			try {
				let uri = this.config.changeRSS.getAttribute('data-uri');

				toggleInProgress(true);
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

						toggleInProgress(false);
					})
					.catch(json => {
						this.config.changeRSS.removeAttribute('disabled', 'disabled');
						notify('Error', 'Failed to update RSS token', 'danger');

						toggleInProgress(false);
					});
			} catch (e) {
				console.error(e);
			}
		});

		let update = data => {
			toggleInProgress(true);
			this.config.ajax
				.put(__ROUTES.options, data)
				.then(json => {
					if (!json.data.error) {
						this.data = Object.assign({}, data);
						notify('Success', 'Updated Options', 'success');
					} else {
						notify('Error', json.message, 'danger');
					}

					toggleInProgress(false);
				})
				.catch(json => {
					notify('Error', 'Failed to update options', 'danger');

					toggleInProgress(false);
				});
		};

		let timer = undefined;
		let updateOptions = Object.assign({ _method: 'put'}, this.data);
		[ 'privateProfile', 'colorblind', 'hideReleased', 'hideTBA' ].forEach(key => {
			this.config[key].addEventListener('click', e => {
				if (this.config.ajaxInProgress) {
					e.preventDefault();
					return false;
				}
				updateOptions[key] = this.config[key].checked;

				clearTimeout(timer);
				timer = setTimeout(() => update(updateOptions), 1000);
			});
		});
	};
	main();
}