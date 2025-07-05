<?php

/**
 * Replaces the default page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_part_comments_default( $content ) {
	ob_start();
	?>
	<!-- wp:comments {"className":"wp-block-comments-query-loop text-body"} -->
	<div class="wp-block-comments wp-block-comments-query-loop text-body"><!-- wp:comments-title /-->

		<!-- wp:comment-template -->
		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card","border":"gray","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container","className":"w-100 mw-100"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3  border-gray bg-image-fixed card"><!-- wp:blockstrap/blockstrap-widget-container {"container":"card-header","bg":"transparent","css_class":"d-flex align-items-center","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container","className":"d-flex align-items-center"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-transparent bg-image-fixed card-header d-flex align-items-center"><!-- wp:avatar {"size":45,"style":{"border":{"radius":"20px"}}} /-->

				<!-- wp:comment-author-name {"className":"ml-2","fontSize":"small"} /-->

				<!-- wp:comment-date {"className":"ms-auto me-2","fontSize":"small"} /-->

				<!-- wp:comment-edit-link {"className":"btn btn-outline-primary me-2","style":{"elements":{"link":{"color":{"text":"var:preset|color|text-body"}}}},"fontSize":"small"} /-->

				<!-- wp:comment-reply-link {"className":"btn btn-primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"fontSize":"small"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-body","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed card-body"><!-- wp:comment-content /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container -->
		<!-- /wp:comment-template -->

		<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:comments-pagination-previous /-->

		<!-- wp:comments-pagination-numbers /-->

		<!-- wp:comments-pagination-next /-->
		<!-- /wp:comments-pagination -->

		<!-- wp:post-comments-form /--></div>
	<!-- /wp:comments -->
	<?php

	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_part_comments_default', 'bsb_pattern_part_comments_default', 10, 1 );




