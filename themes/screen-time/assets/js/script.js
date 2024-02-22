/**
 * Wait for the DOM to load before running the script.
 *
 * @package
 */

document.addEventListener('DOMContentLoaded', function () {
	/* eslint-disable no-undef */
	getPersonCards = document.querySelectorAll('.person-card-item');
	getPersonCardsMobile = document.querySelectorAll(
		'.person-card-item-mobile'
	);
	for (let i = 12; i < getPersonCards.length; i++) {
		getPersonCards[i].style.display = 'none';
		getPersonCardsMobile[i].style.display = 'none';
	}

	const moreButton = document.querySelector('.load-more-button');

	if (getPersonCards.length <= 12 && moreButton) {
		moreButton.style.display = 'none';
	}

	if (moreButton) {
		moreButton.addEventListener('click', function () {
			for (let i = 12; i < getPersonCards.length; i++) {
				if (screen.width < 768) {
					getPersonCardsMobile[i].style.display = 'flex';
					moreButton.style.display = 'none';
				} else {
					getPersonCards[i].style.display = 'flex';
					moreButton.style.display = 'none';
				}
			}
		});
	}
	/* eslint-enable no-undef */
	// get all the drop-down menus
	const menus = document.getElementsByClassName('sub-menu');

	// loop through the menus
	for (let i = 0; i < menus.length; i++) {
		// add a click event listener to each menu
		menus[i].addEventListener('click', function () {
			// get the arrow and the menu
			const menuContent = this.getElementsByTagName('nav');

			// toggle the open class on the arrow and the menu
			menuContent[0].classList.toggle('menu-closed');
		});
	}

	const menuBtn = document.getElementById('mobile-menu-icon');

	// add event listener to the menu button
	menuBtn.addEventListener('click', function () {
		// get all the elements to toggle
		const barIcon = document.getElementById('bar-icon');
		const closeIcon = document.getElementById('close-icon');
		const subMenu = document.getElementById('mobile-menu');

		// toggle the menu button
		barIcon.classList.toggle('hide');
		closeIcon.classList.toggle('hide');
		subMenu.classList.toggle('none');
	});

	// const searchBtn = document.getElementById('search-button');
	const searchBtn = document.getElementById('search-title');

	// add event listener to the menu button
	searchBtn.addEventListener('click', function () {
		// get all the elements to toggle
		const searchIcon = document.querySelector('.searchform');
		const searchTitle = document.getElementById('search-title');

		// toggle the search form
		if ('block' === searchIcon.style.display) {
			searchIcon.style.display = 'none';
		} else {
			searchIcon.style.display = 'block';
		}
		searchTitle.classList.toggle('hide');
	});

	const searchBtn1 = document.getElementById('search-button1');

	searchBtn1.addEventListener('click', function () {
		// get all the elements to toggle
		const searchIcon = document.querySelector('.searchform');

		// toggle the search form
		if ('block' === searchIcon.style.display) {
			searchIcon.style.display = 'none';
		} else {
			searchIcon.style.display = 'block';
		}
	});

	// Variable for check interval status.
	let intervalStatus = 0;

	// get all the dots events.
	const dots = document.getElementsByClassName('slide-dot');

	// Added click event listener to all dots.
	for (let i = 0; i < dots.length; i++) {
		dots[i].addEventListener('click', function () {
			displaySlide(i);

			// Clear the interval and set again.
			if (intervalStatus) {
				clearInterval(intervalStatus);
				intervalStatus = setInterval(displaySlide, 10 * 1000);
			}
		});
	}

	// Variable for store slide No temporarily data.
	let slideNo = 0;

	// Get all the slides.
	const slides = document.getElementsByClassName('slide');

	// function for show slides.
	function displaySlide(n = slideNo) {
		// Remove all slide none class and dots active class.
		for (let i = 0; i < slides.length; i++) {
			slides[i].style.display = 'none';
		}

		for (let i = 0; i < dots.length; i++) {
			dots[i].classList.remove('show');
		}

		slideNo = n;

		// Display the current slide and current dot.
		if (slides[slideNo].style.display === 'none') {
			slides[slideNo].style.display = 'unset';
		}
		dots[slideNo].classList.add('show');

		slideNo++;
		if (slideNo >= slides.length) {
			slideNo = 0;
		}
	}

	displaySlide();
	// Set interval for show slides.
	intervalStatus = setInterval(displaySlide, 10 * 1000);
});
