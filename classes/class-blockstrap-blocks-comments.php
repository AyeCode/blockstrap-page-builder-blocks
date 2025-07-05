<?php
/**
 * Filter the output of the comments form.
 *
 * @package BlockStrap
 * @since 1.0.0
 */

/**
 * Filter the comments form output.
 */
class BlockStrap_Blocks_Comments {

	public function __construct() {

		add_action( 'comment_form_default_fields', array( $this, 'comment_args' ) );
		add_action( 'comment_form_defaults', array( $this, 'comment_form_defaults' ), 100 );
		add_filter('render_block', array( $this, 'comment_form_blocks_render' ), 10, 2);

	}

	/**
	 * Force some WP comment form blocks to use the `a` tag instead of wrapping it in a dev so BS classes work.
	 *
	 * @param $block_content
	 * @param $block
	 *
	 * @return array|mixed|string|string[]|null
	 */
	public function comment_form_blocks_render($block_content, $block) {
		$target_blocks = ['core/comment-edit-link', 'core/comment-reply-link'];

		if (!in_array($block['blockName'], $target_blocks, true)) {
			return $block_content;
		}

		$class = isset($block['attrs']['className']) ? $block['attrs']['className'] : '';
		$font_size = isset($block['attrs']['fontSize']) ? 'has-' . sanitize_html_class($block['attrs']['fontSize']) . '-font-size' : '';
		$all_classes = trim("has-link-color $class $font_size");

		$block_content = preg_replace('/^<div[^>]*>(.*?)<\/div>$/s', '$1', $block_content);
		$block_content = preg_replace('/<a /', '<a class="' . esc_attr($all_classes) . '" ', $block_content, 1);

		return $block_content;
	}

	/**
	 * Change the default output of the comments form.
	 *
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function comment_form_defaults( $defaults ) {

		$defaults['comment_field'] = '
<div class="comment-form-comment mb-3">
   <label for="comment" class="sr-only sr-only-focusable">' . esc_html__( 'Enter your comment here...', 'blockstrap-page-builder-blocks' ) . '</label>
    <textarea class="form-control" id="comment" name="comment" placeholder="' . esc_html__( 'Enter your comment here...', 'blockstrap-page-builder-blocks' ) . '"  rows="8" maxlength="65525" required="required"></textarea>
</div>
 ';

		$defaults['fields']['author'] = '
<div class="comment-form-author mb-3">
<label for="author" class="sr-only sr-only-focusable">' . esc_html__( 'Name', 'blockstrap-page-builder-blocks' ) . '<span class="required">*</span></label>
<input class="required form-control border-gray" id="author" name="author" type="text" value="" placeholder="' . esc_html__( 'Name (required)', 'blockstrap-page-builder-blocks' ) . '"  maxlength="245" required=\'required\' />
</div>';

		$defaults['fields']['email'] = '
<div class="comment-form-email mb-3">
<label for="email" class="sr-only sr-only-focusable">' . esc_html__( 'Email', 'blockstrap-page-builder-blocks' ) . '<span class="required">*</span></label>
<input class="required form-control border-gray" id="email" name="email" type="email" value="" placeholder="' . esc_html__( 'Email (required)', 'blockstrap-page-builder-blocks' ) . '" maxlength="100" aria-describedby="email-notes" required=\'required\' />
</div>';

		$defaults['fields']['url'] = '
<div class="comment-form-url mb-3">
<label for="url" class="sr-only sr-only-focusable">' . esc_html__( 'Website', 'blockstrap-page-builder-blocks' ) . '</label>
<input class="required form-control border-gray" id="url" name="url" type="url" placeholder="' . esc_html__( 'Website', 'blockstrap-page-builder-blocks' ) . '" value=""  maxlength="200" />
</div>';

		$defaults['fields']['cookies'] = '
<div class="comment-form-cookies-consent mb-3 form-check custom-control custom-checkbox">
<input class="custom-control-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" />
<label class="custom-control-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'blockstrap-page-builder-blocks' ) . '</label>
</div>';

		$defaults['class_submit'] .= ' ';

		$defaults['submit_field'] = '<div class="form-submit mb-3">%1$s %2$s</div>';

		$defaults['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary btn-lg" value="%4$s" />';

		$defaults['comment_notes_before'] = str_replace( 'comment-notes', 'comment-notes text-muted', $defaults['comment_notes_before'] );

		return $defaults;
	}


	public function comment_args( $fields ) {

		return $fields;
	}


}

new BlockStrap_Blocks_Comments();
