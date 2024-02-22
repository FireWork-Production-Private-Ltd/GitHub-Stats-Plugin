jQuery(function ($) {
	let frame;
	const metaBoxPoster = $('#rt-movie-meta-carousel-poster.postbox');
	const carouselImgContainer = metaBoxPoster.find(
		'.custom-carousel_img-container'
	);
	const carouselImgInputId = metaBoxPoster.find('.carousel-img-id');
	const carouselImgRemoveId = metaBoxPoster.find('.carousel-img-id-removed');

	$('.upload-custom-carousel_img').on('click', function (event) {
		event.preventDefault();

		if (frame) {
			frame.open();
			return;
		}

		// frame settings media type - poster only. (only one)
		frame = wp.media({
			title: 'Select Images',
			button: {
				text: 'Import',
			},
			multiple: false,
			library: {
				type: 'image',
			},
		});

		frame.on('select', function () {
			const attachment = frame.state().get('selection').toJSON();

			let imageTags = '';
			const arr = [];

			// create image div when we upload any image.
			attachment.forEach((element) => {
				imageTags +=
					'<div class="carousel-img-container"><img src="' +
					element.url +
					'" alt="" style="max-width:70%;"/><br></div>';
				arr.push(element.id);
			});
			carouselImgContainer.empty();
			carouselImgContainer.append(imageTags);

			// create array of the image ids.
			carouselImgInputId.val(
				JSON.stringify([
					...arr,
					// ...JSON.parse(carouselImgInputId.val() || '[]'),
				])
			);
		});

		frame.open();
	});

	// delete image.
	$('.remove-carousel-img-button').on('click', function (event) {
		event.preventDefault();

		// get id from data-attachment-id.
		const attachmentId = $(this).data('attachment-id');
		const arr = [];
		arr.push(attachmentId);
		carouselImgRemoveId.val(
			JSON.stringify([
				...arr,
				...JSON.parse(carouselImgRemoveId.val() || '[]'),
			])
		);
		//remove front end block of image.
		$(this).parent('.carousel-img-container').remove();
	});
});
