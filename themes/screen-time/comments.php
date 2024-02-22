<?php
/**
 * Comments template
 *
 * @package ScreenTime
 */

?>
<div class="comment-container">
	
	<?php
	if ( comments_open() ) {
		comment_form(
			array(
				'title_reply_before' => '<div class="container-heading"><h1 class="container-heading-title">',
				'title_reply_after'  => '</h1></div>',
				'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment*', 'screen-time' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
				'fields'             => array(
					'author-email' =>
						'<div class="comment-form-name-email">
							<p class="comment-form-author"><label for="author">' . esc_html__( 'Name*', 'screen-time' ) . '</label><input id="author" name="author" type="text" required></p>
							<p class="comment-form-email"><label for="email">' . esc_html__( 'Email*', 'screen-time' ) . '</label><input id="email" name="email" type="email" required></p>
                        </div>',
					'url'          => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'screen-time' ) . '</label><input id="url" name="url" type="url"></p>',
				),
				'label_submit'       => esc_html__( 'Post Review', 'screen-time' ),
			)
		);
	}
	?>
</div>
