jQuery(function ($) {
	let frame;
	const metaBox = $('#rt-media-meta-img.postbox');
	const imgContainer = metaBox.find('.custom-img-container');
	const imgInputId = metaBox.find('.image-id');
	const imgRemoveId = metaBox.find('.image-id-removed');

	$('.upload-custom-img').on('click', function (event) {
		event.preventDefault();

		if (frame) {
			frame.open();
			return;
		}
		// frame settings media type - image only.
		frame = wp.media({
			title: 'Select Images',
			button: {
				text: 'Import',
			},
			multiple: true,
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
					'<div class="image-container"><img src="' +
					element.url +
					'" alt="" style="max-width:70%;"/><br></div>';
				arr.push(element.id);
			});
			imgContainer.append(imageTags);

			// create array of the image ids.
			imgInputId.val(
				JSON.stringify([
					...arr,
					...JSON.parse(imgInputId.val() || '[]'),
				])
			);
		});

		frame.open();
	});

	// delete image.
	$('.remove-image-button').on('click', function (event) {
		event.preventDefault();

		// get id from data-attachment-id.
		const attachmentId = $(this).data('attachment-id');
		const arr = [];
		arr.push(attachmentId);
		imgRemoveId.val(
			JSON.stringify([...arr, ...JSON.parse(imgRemoveId.val() || '[]')])
		);
		//remove front end block of image.
		$(this).parent('.image-container').remove();
	});
});
