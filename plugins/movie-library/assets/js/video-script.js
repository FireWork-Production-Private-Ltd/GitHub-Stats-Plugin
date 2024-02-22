jQuery(function ($) {
	let frame1;
	const metaBoxVideo = $('#rt-media-meta-video.postbox');
	const videoContainer = metaBoxVideo.find('.custom-video-container');
	const videoInputId = metaBoxVideo.find('.video-id');
	const videoRemoveId = metaBoxVideo.find('.video-id-removed');

	$('.upload-custom-video').on('click', function (event) {
		event.preventDefault();

		if (frame1) {
			frame1.open();
			return;
		}
		// frame settings media type - video only.
		frame1 = wp.media({
			title: 'Select Videos',
			button: {
				text: 'Import',
			},
			multiple: true,
			library: {
				type: 'video',
			},
		});

		frame1.on('select', function () {
			const attachmentIds = frame1
				.state()
				.get('selection')
				.map(function (attachment) {
					return attachment.id;
				});
			let videoTags = '';
			const arr = [];

			// create video div when we upload any video.
			attachmentIds.forEach((element) => {
				const attachment = wp.media.attachment(element);
				videoTags +=
					'<div class="video-container" style="max-width:100%;"><video width="500" height="140" controls><source src="' +
					attachment.get('url') +
					'" type="video/mp4"></video><br></div>';
				arr.push(element);
			});
			videoContainer.append(videoTags);

			// create array of the video ids.
			videoInputId.val(
				JSON.stringify([
					...arr,
					...JSON.parse(videoInputId.val() || '[]'),
				])
			);
		});

		frame1.open();
	});

	// delete video.
	$('.remove-video-button').on('click', function (event) {
		event.preventDefault();
		const attachmentId = $(this).data('attachment-video-id');
		const arr = [];
		arr.push(attachmentId);
		videoRemoveId.val(
			JSON.stringify([...arr, ...JSON.parse(videoRemoveId.val() || '[]')])
		);
		$(this).parent('.video-container').remove();
	});
});
