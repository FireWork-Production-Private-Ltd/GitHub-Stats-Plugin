wp.customize('site-background-color-setting', function (value) {
	value.bind(function (newval) {
		const rootColor = document.querySelector(':root');
		rootColor.style.setProperty('--primary-color', newval);
	});
});

wp.customize('single-page-navigation-setting', function (value) {
	value.bind(function (newval) {
		if (newval) {
			document.querySelector('.single-page-pagination').style.display =
				'block';
		} else {
			document.querySelector('.single-page-pagination').style.display =
				'none';
		}
	});
});
