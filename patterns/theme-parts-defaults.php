<?php

/**
 * Replaces the default page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_part_comments_default( $content ) {
	return '<!-- wp:comments {"className":"wp-block-comments-query-loop "} -->
<div class="wp-block-comments wp-block-comments-query-loop"><!-- wp:comments-title {"textColor":"gray-dark"} /-->

	<!-- wp:comment-template -->
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"card","border":"gray","className":"w-100 mw-100"} -->
	[bs_container container=\'card\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'3\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'\'  pl_lg=\'\'  border=\'gray\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-3 border border-gray card"><!-- wp:blockstrap/blockstrap-widget-container {"container":"card-header","bg":"transparent","css_class":"d-flex align-items-center","className":"d-flex align-items-center"} -->
		[bs_container container=\'card-header\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'transparent\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'3\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'\'  pl_lg=\'\'  border=\'\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'d-flex align-items-center\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-3 bg-transparent card-header d-flex align-items-center"><!-- wp:avatar {"size":45,"style":{"border":{"radius":"20px"}}} /-->

			<!-- wp:comment-author-name {"className":"ml-2","fontSize":"small"} /-->

			<!-- wp:comment-date {"className":"ml-auto mr-2","fontSize":"small"} /-->

			<!-- wp:comment-edit-link {"className":"btn btn-outline-primary mr-2","fontSize":"small"} /-->

			<!-- wp:comment-reply-link {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"className":"btn btn-primary","fontSize":"small"} /--></div>[/bs_container]
		<!-- /wp:blockstrap/blockstrap-widget-container -->

		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-body"} -->
		[bs_container container=\'card-body\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'3\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'\'  pl_lg=\'\'  border=\'\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-3 card-body"><!-- wp:comment-content /--></div>[/bs_container]
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>[/bs_container]
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<!-- /wp:comment-template -->

	<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
	<!-- wp:comments-pagination-previous /-->

	<!-- wp:comments-pagination-numbers /-->

	<!-- wp:comments-pagination-next /-->
	<!-- /wp:comments-pagination -->

	<!-- wp:post-comments-form /--></div>
<!-- /wp:comments -->';
}
add_filter( 'blockstrap_pattern_part_comments_default', 'bsb_pattern_part_comments_default', 10, 1 );

/**
 * Replaces the default page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_part_main_default( $content ) {
	return '<!-- wp:query {"queryId":1,"query":{"pages":"100","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","sticky":"","exclude":[],"perPage":5,"inherit":true},"displayLayout":{"type":"list"}} -->
<div class="wp-block-query"><!-- wp:post-template -->
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"card","bg":"light","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","border":"0","rounded":"rounded","rounded_size":"lg","shadow":"shadow-sm","css_class":"overflow-hidden h-100 hover-move-up hover-shadow"} -->
	[bs_container container=\'card\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'light\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'3\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'0\'  pr_lg=\'0\'  pb_lg=\'0\'  pl_lg=\'0\'  border=\'0\'  rounded=\'rounded\'  rounded_size=\'lg\'  shadow=\'shadow-sm\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'overflow-hidden h-100 hover-move-up hover-shadow\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-3 pt-0 pr-0 pb-0 pl-0 border-0 rounded-lg bg-light card shadow-sm rounded overflow-hidden h-100 hover-move-up hover-shadow"><!-- wp:blockstrap/blockstrap-widget-image {"img_src":"featured","fallback_img_src":"default","img_link_to":"post","mb_lg":"0","content":""} -->
		[bs_image img_src=\'featured\'  img_image=\'\'  img_image_id=\'\'  img_size=\'\'  img_url=\'\'  fallback_img_src=\'default\'  fallback_img_image=\'\'  fallback_img_image_id=\'\'  img_link_to=\'post\'  img_link=\'\'  img_link_lightbox=\'\'  lightbox_size=\'full\'  text=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  img_aspect=\'16by9\'  img_cover=\'\'  img_border=\'\'  img_rounded=\'\'  img_rounded_size=\'\'  img_shadow=\'\'  text_color=\'\'  font_size=\'\'  font_size_custom=\'\'  font_weight=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  bg_on_text=\'false\'  mt=\'\'  mr=\'\'  mb=\'\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'0\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'\'  pl_lg=\'\'  border=\'\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  img_mask=\'\'  img_mask_position=\'center center\'  css_class=\'\' ]
		<!-- /wp:blockstrap/blockstrap-widget-image -->

		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-body","mb_lg":"0","pb_lg":"0"} -->
		[bs_container container=\'card-body\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'0\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'0\'  pl_lg=\'\'  border=\'\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-0 pb-0 card-body"><!-- wp:post-title {"isLink":true,"fontSize":"normal"} /-->

			<!-- wp:post-terms {"term":"category"} /-->

			<!-- wp:post-excerpt {"moreText":"","showMoreOnNewLine":false,"style":{"typography":{"fontSize":"0.7rem"}},"textColor":"gray-dark"} /-->

			<!-- wp:post-terms {"term":"post_tag","style":{"spacing":{"padding":{"top":"2em"}}}} /--></div>[/bs_container]
		<!-- /wp:blockstrap/blockstrap-widget-container -->

		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-footer","mb_lg":"0","border":"0","display_lg":"d-lg-flex","flex_align_items_lg":"align-items-lg-center","flex_justify_content_lg":"justify-content-lg-between"} -->
		[bs_container container=\'card-footer\'  row_cols=\'\'  row_cols_md=\'\'  row_cols_lg=\'\'  col=\'\'  col_md=\'\'  col_lg=\'\'  bg=\'\'  bg_color=\'#0073aa\'  bg_gradient=\'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)\'  bg_image_fixed=\'false\'  bg_image_use_featured=\'false\'  bg_image=\'\'  bg_image_id=\'\'  bg_image_xy=\'{x:undefined,y:undefined}\'  bg_on_text=\'false\'  text_color=\'\'  text_justify=\'false\'  text_align=\'\'  text_align_md=\'\'  text_align_lg=\'\'  mt=\'\'  mr=\'\'  mb=\'3\'  ml=\'\'  mt_md=\'\'  mr_md=\'\'  mb_md=\'\'  ml_md=\'\'  mt_lg=\'\'  mr_lg=\'\'  mb_lg=\'0\'  ml_lg=\'\'  pt=\'\'  pr=\'\'  pb=\'\'  pl=\'\'  pt_md=\'\'  pr_md=\'\'  pb_md=\'\'  pl_md=\'\'  pt_lg=\'\'  pr_lg=\'\'  pb_lg=\'\'  pl_lg=\'\'  border=\'0\'  rounded=\'\'  rounded_size=\'\'  shadow=\'\'  position=\'\'  sticky_offset_top=\'\'  sticky_offset_bottom=\'\'  display=\'\'  display_md=\'\'  display_lg=\'d-lg-flex\'  flex_align_items=\'\'  flex_align_items_md=\'\'  flex_align_items_lg=\'align-items-lg-center\'  flex_justify_content=\'\'  flex_justify_content_md=\'\'  flex_justify_content_lg=\'justify-content-lg-between\'  flex_align_self=\'\'  flex_align_self_md=\'\'  flex_align_self_lg=\'\'  flex_order=\'\'  flex_order_md=\'\'  flex_order_lg=\'\'  anchor=\'\'  css_class=\'\' ]<div class="wp-block-blockstrap-blockstrap-widget-container undefined mb-3 mb-lg-0 border-0 d-flex card-footer align-items-center justify-content-between"><!-- wp:post-author {"showAvatar":false,"textColor":"gray-dark","className":"mb-n3","fontSize":"small"} /-->

			<!-- wp:post-date {"format":"M j"} /--></div>[/bs_container]
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>[/bs_container]
	<!-- /wp:blockstrap/blockstrap-widget-container -->

	<!-- wp:spacer {"height":"30px"} -->
	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:spacer {"height":"20px"} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:separator {"opacity":"css","backgroundColor":"beige","className":"is-style-wide"} -->
	<hr class="wp-block-separator has-text-color has-beige-color has-css-opacity has-beige-background-color has-background is-style-wide"/>
	<!-- /wp:separator -->

	<!-- wp:spacer {"height":"20px"} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination -->
	<!-- wp:query-pagination-previous /-->

	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
';
}
add_filter( 'blockstrap_pattern_part_main_default', 'bsb_pattern_part_main_default', 10, 1 );
