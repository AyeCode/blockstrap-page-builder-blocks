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
	<!-- wp:comments {"className":"wp-block-comments-query-loop "} -->
	<div class="wp-block-comments wp-block-comments-query-loop"><!-- wp:comments-title {"textColor":"gray-dark"} /-->

		<!-- wp:comment-template -->
		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card","border":"gray","sd_shortcode":"[bs_container container='card'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border='gray'  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor=''  css_class='' ]","sd_shortcode_close":"[/bs_container]","className":"w-100 mw-100"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3  border-gray bg-image-fixed card"><!-- wp:blockstrap/blockstrap-widget-container {"container":"card-header","bg":"transparent","css_class":"d-flex align-items-center","sd_shortcode":"[bs_container container='card-header'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg='transparent'  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor=''  css_class='d-flex align-items-center' ]","sd_shortcode_close":"[/bs_container]","className":"d-flex align-items-center"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-transparent bg-image-fixed card-header d-flex align-items-center"><!-- wp:avatar {"size":45,"style":{"border":{"radius":"20px"}}} /-->

				<!-- wp:comment-author-name {"className":"ml-2","fontSize":"small"} /-->

				<!-- wp:comment-date {"className":"ml-auto mr-2","fontSize":"small"} /-->

				<!-- wp:comment-edit-link {"className":"btn btn-outline-primary mr-2","fontSize":"small"} /-->

				<!-- wp:comment-reply-link {"className":"btn btn-primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"fontSize":"small"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-body","sd_shortcode":"[bs_container container='card-body'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor=''  css_class='' ]","sd_shortcode_close":"[/bs_container]"} -->
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
