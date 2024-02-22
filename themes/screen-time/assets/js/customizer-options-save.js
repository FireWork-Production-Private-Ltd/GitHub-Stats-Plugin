document.addEventListener('DOMContentLoaded', function () {
	// Set the theme customizer options.
	/* eslint-disable no-undef */
	function localizeScript() {
		const rootColor = document.querySelector(':root');
		if (themeCustomizerOption.hasOwnProperty('background_color')) {
			rootColor.style.setProperty(
				'--primary-color',
				themeCustomizerOption.background_color
			);
		}

		if (themeCustomizerOption.hasOwnProperty('nav_setting')) {
			if ('1' === themeCustomizerOption.nav_setting) {
				document.querySelector(
					'.single-page-pagination'
				).style.display = 'block';
			} else {
				document.querySelector(
					'.single-page-pagination'
				).style.display = 'none';
			}
		}
	}
	/* eslint-enable no-undef */
	localizeScript();
});
