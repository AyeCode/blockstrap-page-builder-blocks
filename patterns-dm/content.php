<?php


/**
 * Replaces the default feature section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_feature_home_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"pt_lg":"4","anchor":"main","css_class":"align-items-center","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pt-4 bg-image-fixed container align-items-center" id="main"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","row_cols":"1","row_cols_md":"2","row_cols_lg":"4","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 row-cols-1 row-cols-md-2 row-cols-lg-4 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","pr_lg":"5","pl_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pe-5 ps-5 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-icon-box {"icon_class":"fas fa-handshake","title":"Praesent porttitor","title_tag":"h2","description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit.","icon_size":"h1","icon_color":"custom","icon_color_custom":"#cc2563","title_size":"h4","title_pb":"2","desc_size":"h6","desc_font_line_height":1.6,"desc_color_custom":"#575757","desc_font_weight":"font-weight-light","content":"\u003cdiv class=\u0022blockstrap-iconbox position-relative h-100  \u0022  \u003e\u003cdiv class=\u0022blockstrap-iconbox-icon text-custom text-center h1 \u0022  style=\u0022color:#cc2563;\u0022 \u003e\u003ci class=\u0022fas fa-handshake   \u0022\u003e\u003c/i\u003e\u003c/div\u003e\u003cdiv class=\u0022iconbox-text-wrap  \u0022\u003e\u003ca class=\u0022blockstrap-iconbox-title-link stretched-link\u0022 \u003e\u003ch2 class=\u0022blockstrap-iconbox-title pb-2 text-center h4  mb-0\u0022  \u003ePraesent porttitor\u003c/h2\u003e\u003c/a\u003e\u003cdiv class=\u0022blockstrap-iconbox-desc text-center fw-light h6 \u0022  style=\u0022line-height:1.6;\u0022 \u003eLorem ipsum dolor sit amet, consectetur adipiscing elit.\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e","sd_shortcode":"bs_iconbox"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","pr_lg":"5","pl_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pe-5 ps-5 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-icon-box {"icon_class":"fas fa-umbrella-beach","title":"Placerat nibh","description":"Quisque in est vel mi feugiat vestibulum, venenatis amet.","icon_size":"h1","icon_color":"custom","icon_color_custom":"#cc2563","title_size":"h4","title_pb":"2","desc_size":"h6","desc_font_line_height":1.6,"desc_font_weight":"font-weight-light","content":"\u003cdiv class=\u0022blockstrap-iconbox position-relative h-100  \u0022  \u003e\u003cdiv class=\u0022blockstrap-iconbox-icon text-custom text-center h1 \u0022  style=\u0022color:#cc2563;\u0022 \u003e\u003ci class=\u0022fas fa-umbrella-beach   \u0022\u003e\u003c/i\u003e\u003c/div\u003e\u003cdiv class=\u0022iconbox-text-wrap  \u0022\u003e\u003ca class=\u0022blockstrap-iconbox-title-link stretched-link\u0022 \u003e\u003ch3 class=\u0022blockstrap-iconbox-title pb-2 text-center h4  mb-0\u0022  \u003ePlacerat nibh\u003c/h3\u003e\u003c/a\u003e\u003cdiv class=\u0022blockstrap-iconbox-desc text-center fw-light h6 \u0022  style=\u0022line-height:1.6;\u0022 \u003eQuisque in est vel mi feugiat vestibulum, venenatis amet.\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e","sd_shortcode":"bs_iconbox"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","pr_lg":"5","pl_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pe-5 ps-5 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-icon-box {"icon_class":"fas fa-route","title":"Curabitur eget","description":"Morbi ac dolor ipsum onec dictum enim lacus.","icon_size":"h1","icon_color":"custom","icon_color_custom":"#cc2563","title_size":"h4","title_pb":"2","desc_size":"h6","desc_font_line_height":1.6,"desc_font_weight":"font-weight-light","content":"\u003cdiv class=\u0022blockstrap-iconbox position-relative h-100  \u0022  \u003e\u003cdiv class=\u0022blockstrap-iconbox-icon text-custom text-center h1 \u0022  style=\u0022color:#cc2563;\u0022 \u003e\u003ci class=\u0022fas fa-route   \u0022\u003e\u003c/i\u003e\u003c/div\u003e\u003cdiv class=\u0022iconbox-text-wrap  \u0022\u003e\u003ca class=\u0022blockstrap-iconbox-title-link stretched-link\u0022 \u003e\u003ch3 class=\u0022blockstrap-iconbox-title pb-2 text-center h4  mb-0\u0022  \u003eCurabitur eget\u003c/h3\u003e\u003c/a\u003e\u003cdiv class=\u0022blockstrap-iconbox-desc text-center fw-light h6 \u0022  style=\u0022line-height:1.6;\u0022 \u003eMorbi ac dolor ipsum onec dictum enim lacus.\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e","sd_shortcode":"bs_iconbox"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","pr_lg":"5","pl_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pe-5 ps-5 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-icon-box {"icon_class":"fas fa-link","title":"Nullam lectus","description":"Integer eu urna bibendum sem finibus maximus.","icon_size":"h1","icon_color":"custom","icon_color_custom":"#cc2563","title_size":"h4","title_pb":"2","desc_size":"h6","desc_font_line_height":1.6,"desc_font_weight":"font-weight-light","content":"\u003cdiv class=\u0022blockstrap-iconbox position-relative h-100  \u0022  \u003e\u003cdiv class=\u0022blockstrap-iconbox-icon text-custom text-center h1 \u0022  style=\u0022color:#cc2563;\u0022 \u003e\u003ci class=\u0022fas fa-link   \u0022\u003e\u003c/i\u003e\u003c/div\u003e\u003cdiv class=\u0022iconbox-text-wrap  \u0022\u003e\u003ca class=\u0022blockstrap-iconbox-title-link stretched-link\u0022 \u003e\u003ch3 class=\u0022blockstrap-iconbox-title pb-2 text-center h4  mb-0\u0022  \u003eNullam lectus\u003c/h3\u003e\u003c/a\u003e\u003cdiv class=\u0022blockstrap-iconbox-desc text-center fw-light h6 \u0022  style=\u0022line-height:1.6;\u0022 \u003eInteger eu urna bibendum sem finibus maximus.\u003c/div\u003e\u003c/div\u003e\u003c/div\u003e","sd_shortcode":"bs_iconbox"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_feature_home_default', 'bsb_pattern_feature_home_default', 10, 1 );

/**
 * Replaces the default 404 page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_404_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"anchor":"main","sd_shortcode":"[bs_container container='container'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor='main'  css_class='' ]","sd_shortcode_close":"[/bs_container]"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed container" id="main"><!-- wp:spacer {"height":"5vh"} -->
		<div style="height:5vh" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center">It looks like nothing was found at this location. Maybe try one of the links below, or a search? </p>
		<!-- /wp:paragraph -->

		<!-- wp:spacer {"height":"70px"} -->
		<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:latest-posts {"postsToShow":3,"displayAuthor":true,"displayPostDate":true,"postLayout":"grid","align":"center"} /-->

		<!-- wp:search {"label":"Search","showLabel":false,"buttonText":"Search"} /--></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_page_content_404_default', 'bsb_pattern_page_content_404_default', 10, 1 );


/**
 * Replaces the default Archive page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_archive_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"6","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mt-6 mb-3 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","display":"d-block","display_lg":"d-lg-flex","flex_align_items_lg":"align-items-lg-center","flex_justify_content_lg":"justify-content-lg-between","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed d-block d-lg-flex col align-items-center justify-content-between"><!-- wp:blockstrap/blockstrap-widget-search {"mb":"3","mb_lg":"0","styleid":"block-6ymvngh09h","content":"\u003cform role=\u0022search\u0022 method=\u0022get\u0022 action=\u0022\u0022 class=\u0022mb-3 mb-lg-0 block-6ymvngh09h\u0022\u003e\u003cdiv class=\u0022input-group\u0022  \u003e\u003cinput type=\u0022text\u0022  name=\u0022s\u0022  id=\u0022bs-block-search-s\u0022  placeholder=\u0022Search...\u0022  class=\u0022form-control \u0022  \u003e\u003cbutton class=\u0022btn  rounded-end btn-primary \u0022 type=\u0022submit\u0022 id=\u0022bs-block-search-btn\u0022\u003eSearch\u003c/button\u003e\u003c/div\u003e\u003c/form\u003e","sd_shortcode":"bs_search"} /-->

				<!-- wp:blockstrap/blockstrap-widget-archive-actions {"styleid":"block-c2xktxnuck","content": "","sd_shortcode":"bs_archive_actions"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container -->

		<!-- wp:template-part {"slug":"main","theme":"blockstrap","tagName":"main","className":"site-main"} /--></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}

add_filter( 'blockstrap_pattern_page_content_archive_default', 'bsb_pattern_page_content_archive_default', 10, 1 );
add_filter( 'blockstrap_pattern_page_content_search_default', 'bsb_pattern_page_content_archive_default', 10, 1 );


/**
 * Replaces the default page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_page_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"anchor":"main","sd_shortcode":"[bs_container container='container'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor='main'  css_class='' ]","sd_shortcode_close":"[/bs_container]"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed container" id="main"><!-- wp:spacer {"height":"5vh"} -->
		<div style="height:5vh" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:post-content {"align":"full","layout":{"inherit":false}} /-->

		<!-- wp:spacer {"height":"70px"} -->
		<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:template-part {"slug":"comments","theme":"blockstrap"} /--></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}

add_filter( 'blockstrap_pattern_page_content_page_default', 'bsb_pattern_page_content_page_default', 10, 1 );


/**
 * Replaces the default post page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_post_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"bg_color":"#0d1b48","text_color":"body","mr_lg":"auto","mb_lg":"","ml_lg":"auto","rounded":"rounded","rounded_size":"lg","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container","className":"mw-50 "} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container me-auto ms-auto rounded-lg bg-image-fixed text-body container position-relative rounded"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","row_cols_lg":"1","bg":"transparent","text_align_lg":"text-lg-center","mr_lg":"auto","mb_lg":"","ml_lg":"auto","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container","className":"list-group-horizontal align-items-cente justify-content-center"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container me-auto ms-auto row-cols-1 bg-transparent bg-image-fixed text-center row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","text_align_lg":"text-lg-center","mt_lg":"n5","mb_lg":"0","pt_lg":"0","border":"0","display_lg":"d-lg-inline-block","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mt-n5 mb-0 pt-0 border-0 bg-image-fixed text-center d-inline-block col"><!-- wp:avatar {"size":60,"isLink":true,"className":"rounded-circle overflow-hidden d-inline-block shadow"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","bg":"transparent","mb_lg":"0","pt_lg":"0","border":"0","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-0 pt-0 border-0 bg-transparent bg-image-fixed col"><!-- wp:post-author {"showAvatar":false,"showBio":false,"style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"},"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"fontSize":"medium"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","bg":"transparent","mb_lg":"0","pt_lg":"0","border":"0","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-0 pt-0 border-0 bg-transparent bg-image-fixed col"><!-- wp:post-date /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->

	<!-- wp:blockstrap/blockstrap-widget-container {"anchor":"main","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed container" id="main"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","col":"12","col_md":"12","col_lg":"8","mr_lg":"auto","ml_lg":"auto","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container me-auto mb-3 ms-auto col-12 col-md-12 col-lg-8 bg-image-fixed col"><!-- wp:spacer {"height":"50px"} -->
			<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:blockstrap/blockstrap-widget-image {"img_src":"featured","img_size":"medium_large","img_aspect":"21by9","content": "","sd_shortcode":"bs_image"} /-->

			<!-- wp:post-content {"align":"full","layout":{"inherit":true}} /-->

			<!-- wp:post-terms {"term":"post_tag"} /-->

			<!-- wp:group {"className":"post-nav","style":{"spacing":{"margin":{"top":"2.375em"}}}} -->
			<div class="wp-block-group post-nav" style="margin-top:2.375em"><!-- wp:post-navigation-link {"type":"previous"} /-->

				<!-- wp:post-navigation-link /--></div>
			<!-- /wp:group -->

			<!-- wp:spacer {"height":"70px"} -->
			<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:template-part {"slug":"comments","theme":"blockstrap"} /--></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}

add_filter( 'blockstrap_pattern_page_content_post_default', 'bsb_pattern_page_content_post_default', 10, 1 );


/**
 * Replaces the default page sidebar left content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_page_sidebar_left_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"5","anchor":"main","sd_shortcode":"[bs_container container='container'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='5'  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor='main'  css_class='' ]","sd_shortcode_close":"[/bs_container]"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-3 bg-image-fixed container" id="main"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","col_lg":"4"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 col-4 bg-image-fixed col"><!-- wp:template-part {"slug":"sidebar-left","theme":"blockstrap","area":"uncategorized"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed col"><!-- wp:post-content {"align":"full","layout":{"inherit":true}} /-->

				<!-- wp:template-part {"slug":"comments","theme":"blockstrap"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}

add_filter( 'blockstrap_pattern_page_content_page_sidebar_left_default', 'bsb_pattern_page_content_page_sidebar_left_default', 10, 1 );

/**
 * Replaces the default page sidebar right content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_page_content_page_sidebar_right_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"5","anchor":"main","sd_shortcode":"[bs_container container='container'  h100=''  row_cols=''  row_cols_md=''  row_cols_lg=''  col=''  col_md=''  col_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bg_on_text='false'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='5'  mr_lg=''  mb_lg='3'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  border_type=''  border_width=''  border_opacity=''  rounded=''  rounded_size=''  shadow=''  position=''  sticky_offset_top=''  sticky_offset_bottom=''  display=''  display_md=''  display_lg=''  flex_align_items=''  flex_align_items_md=''  flex_align_items_lg=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  flex_align_self=''  flex_align_self_md=''  flex_align_self_lg=''  flex_order=''  flex_order_md=''  flex_order_lg=''  overflow=''  max_height=''  scrollbars=''  hover_animations=''  visibility_conditions=''  anchor='main'  css_class='' ]","sd_shortcode_close":"[/bs_container]"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-3 bg-image-fixed container" id="main"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed col"><!-- wp:post-content {"align":"full","layout":{"inherit":true}} /-->

				<!-- wp:template-part {"slug":"comments","theme":"blockstrap"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","col_lg":"4"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 col-4 bg-image-fixed col"><!-- wp:template-part {"slug":"sidebar-right","theme":"blockstrap","tagName":"aside","className":"blockstrap-sidebar-right"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}

add_filter( 'blockstrap_pattern_page_content_page_sidebar_right_default', 'bsb_pattern_page_content_page_sidebar_right_default', 10, 1 );


/**
 * Replaces the default page content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_part_main_default( $content ) {
	ob_start();
	?>
	<!-- wp:query {"queryId":1,"query":{"pages":"100","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","sticky":"","exclude":[],"perPage":10,"inherit":false}} -->
	<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
		<!-- wp:blockstrap/blockstrap-widget-container {"container":"card","bg":"light-subtle","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","border":"0","rounded":"rounded","rounded_size":"lg","shadow":"shadow-sm","css_class":"overflow-hidden h-100 hover-move-up hover-shadow","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pt-0 pe-0 pb-0 ps-0 border-0 rounded-lg bg-light-subtle bg-image-fixed card shadow-sm rounded overflow-hidden h-100 hover-move-up hover-shadow"><!-- wp:blockstrap/blockstrap-widget-image {"img_src":"featured","fallback_img_src":"default","img_link_to":"post","img_aspect":"16by9","mb_lg":"0","content": "","sd_shortcode":"bs_image"} /-->

			<!-- wp:blockstrap/blockstrap-widget-post-info {"type":"taxonomy","taxonomy_limit":1,"is_link":true,"icon_type":"custom","link_type":"badge-round","link_size":"extra-small","link_bg":"danger","mt_lg":"2","mb_lg":"0","ml_lg":"2","position":"position-absolute","absolute_position":"top-left","content":"\u003ca href=\u0022#\u0022 class=\u0022mt-2 mb-0 ms-2 start-0 top-0 position-absolute badge rounded-pill text-bg-danger align-self-center\u0022 \u003eTaxonomy\u003c/a\u003e","sd_shortcode":"bs_post_info"} /-->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-body","mb_lg":"0","pb_lg":"0","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-0 pb-0 bg-image-fixed card-body"><!-- wp:blockstrap/blockstrap-widget-post-title {"html_tag":"h2","is_link":true,"font_size":"h5","sd_shortcode":"bs_post_title"} /-->

				<!-- wp:blockstrap/blockstrap-widget-post-excerpt {"html_tag":"p","trim_count":20,"font_size":"fs-base","mb_lg":"0","content":"\u003cp class=\u0022mb-0 fs-base\u0022\u003eLorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel felis ante. Aliquam suscipit eleifend leo, et pretium sapien finibus…\u003c/p\u003e","sd_shortcode":"bs_post_excerpt"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container -->

			<!-- wp:blockstrap/blockstrap-widget-container {"container":"card-footer","mb_lg":"0","border":"0","display_lg":"d-lg-flex","flex_align_items_lg":"align-items-lg-center","flex_justify_content_lg":"justify-content-lg-between","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-0 border-0 bg-image-fixed d-flex card-footer align-items-center justify-content-between"><!-- wp:blockstrap/blockstrap-widget-post-info {"type":"read_time","date_format":"time-ago","font_size":"fs-sm","content":"\u003cspan class=\u0022fs-sm \u0022 \u003e\u003ci class=\u0022far fa-clock me-2\u0022\u003e\u003c/i\u003e5 min read\u003c/span\u003e","sd_shortcode":"bs_post_info"} /-->

				<!-- wp:blockstrap/blockstrap-widget-post-info {"type":"date_published","date_format":"time-ago","font_size":"fs-sm","content":"\u003cspan class=\u0022fs-sm \u0022 \u003e\u003ci class=\u0022far fa-clock me-2\u0022\u003e\u003c/i\u003e2 days ago\u003c/span\u003e","sd_shortcode":"bs_post_info"} /--></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container -->
		<!-- /wp:post-template -->

		<!-- wp:blockstrap/blockstrap-widget-pagination {"show_advanced":"inline_before","content": "","sd_shortcode":"bs_pagination"} /--></div>
	<!-- /wp:query -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_part_main_default', 'bsb_pattern_part_main_default', 10, 1 );
