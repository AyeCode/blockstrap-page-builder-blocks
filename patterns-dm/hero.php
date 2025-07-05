<?php


/**
 * Replaces the default hero section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_hero_home_default( $content ) {

	$img_url = esc_url( BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/placeholder-home.avif' ); /* <?php echo esc_url( $img_url ); ?> */
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"container-fluid","bg":"primary-subtle","bg_gradient":"linear-gradient(135deg,rgb(30,23,126) 4%,rgb(96,41,182) 100%)","text_color":"body","pt_lg":"5","pb_lg":"5","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pt-5 pb-5 bg-primary-subtle bg-image-fixed text-body container-fluid position-relative"><!-- wp:blockstrap/blockstrap-widget-shape-divider {"sd":"mountains","sd_position":"bottom","sd_color":"body","styleid":"block-lwftvovh12","sd_shortcode":"bs_shape_divider"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-shape-divider block-lwftvovh12 blockstrap-shape blockstrap-shape-bottom position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">	<path class=" blockstrap-shape-fill" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"/>	<path class=" blockstrap-shape-fill" opacity="0.66" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"/>	<path class=" blockstrap-shape-fill" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"/></svg></div><style>.block-lwftvovh12 { pointer-events: none;background-repeat: no-repeat;bottom:  -1px; left: -1px;right: -1px;line-height: 0;overflow: hidden;margin: 0 1px;-webkit-transform: rotate(180deg); transform: rotate(180deg);}.block-lwftvovh12 svg{ height: 100px;width: calc(200% + 1.3px);left: 50%;position: relative;display: block;-webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%);}.block-lwftvovh12 svg path{ fill: var(--bs-body-bg)}</style>
		<!-- /wp:blockstrap/blockstrap-widget-shape-divider -->

		<!-- wp:blockstrap/blockstrap-widget-container {"pt_lg":"5","pb_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pt-5 pb-5 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","pt_lg":"5","pb_lg":"5","flex_align_items_lg":"align-items-lg-center","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container","className":"align-items-center"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 pt-5 pb-5 bg-image-fixed row align-items-center"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","col":"12","col_lg":"7","bg_gradient":"linear-gradient(90deg,rgb(0,252,13) 5%,rgb(155,81,224) 100%)","bg_on_text":true,"sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 col-12 col-lg-7 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-heading {"text":"BlockStrap, build \u003cem\u003ewebsites \u003c/em\u003efaster!","html_tag":"h1","text_color":"secondary-emphasis","font_size":"display-1","font_size_custom":5,"bg_gradient":"linear-gradient(139deg,rgb(18,255,1) 4%,rgb(175,236,241) 57%)","bg_on_text":true,"content":""} -->
					<h1 class="wp-block-blockstrap-blockstrap-widget-heading mb-3 text-secondary-emphasis display-1">BlockStrap, build <em>websites </em>faster!</h1>
					<!-- /wp:blockstrap/blockstrap-widget-heading -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.6"}},"fontSize":"normal"} -->
					<p class="has-normal-font-size" style="line-height:1.6">Welcome to BlockStrap, a mashup of the famous BootStrap UI and the new WordPress Block Theme technology.  The answer to beautiful sites that load super fast.</p>
					<!-- /wp:paragraph -->

					<!-- wp:blockstrap/blockstrap-widget-button {"type":"custom","custom_url":"#","text":"Buy BlockStrap","icon_position":"right","link_type":"btn-round","link_bg":"danger","font_size_custom":0.8,"font_weight":"font-weight-bold","font_case":"text-uppercase","pt_lg":"2","pr_lg":"4","pb_lg":"2","pl_lg":"4","styleid":"block-cqjcoz7zm5","content":"\u003ca style=\u0022font-size:0.8rem;\u0022  class=\u0022btn btn-round btn-danger pt-2 pe-4 pb-2 ps-4 fw-bold text-uppercase block-cqjcoz7zm5\u0022\u003eBuy BlockStrap\u003c/a\u003e ","sd_shortcode":"bs_button"} /-->

					<!-- wp:blockstrap/blockstrap-widget-button {"type":"custom","custom_url":"#","text":"Contact Us","icon_position":"right","link_type":"btn-round","link_size":"medium","link_bg":"light","font_size_custom":0.8,"font_weight":"font-weight-bold","font_case":"text-uppercase","pt_lg":"2","pr_lg":"4","pb_lg":"2","pl_lg":"4","styleid":"block-sn48coyitz","content":"\u003ca style=\u0022font-size:0.8rem;\u0022  class=\u0022btn btn-round btn-light pt-2 pe-4 pb-2 ps-4 fw-bold text-uppercase block-sn48coyitz\u0022\u003eContact Us\u003c/a\u003e ","sd_shortcode":"bs_button"} /--></div>
				<!-- /wp:blockstrap/blockstrap-widget-container -->

				<!-- wp:blockstrap/blockstrap-widget-container {"container":"col","col":"12","col_lg":"5","bg_gradient":"linear-gradient(90deg,rgb(0,252,13) 5%,rgb(155,81,224) 100%)","bg_on_text":true,"sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 col-12 col-lg-5 bg-image-fixed col"><!-- wp:blockstrap/blockstrap-widget-image {"img_src":"url","img_size":"full","img_url":"<?php echo esc_url( $img_url ); ?>","img_alt":"Easy drag and drop page builder","img_lazyload":"eager","img_aspect":"4by3","img_cover":"x","content": "","sd_shortcode":"bs_image"} /--></div>
				<!-- /wp:blockstrap/blockstrap-widget-container --></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_hero_home_default', 'bsb_pattern_hero_home_default', 10, 1 );


/**
 * Replaces the default 404 page hero section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_hero_404_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"container-fluid","bg":"primary-subtle","text_color":"body","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-primary-subtle bg-image-fixed text-body container-fluid position-relative"><!-- wp:blockstrap/blockstrap-widget-shape-divider {"sd":"curve","sd_position":"bottom","sd_color":"light-subtle","sd_width":"140","sd_invert":true,"styleid":"block-xu9bmn6lkf","sd_shortcode":"bs_shape_divider"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-shape-divider block-xu9bmn6lkf blockstrap-shape blockstrap-shape-bottom position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">	<path class=" blockstrap-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/></svg></div><style>.block-xu9bmn6lkf { pointer-events: none;background-repeat: no-repeat;bottom:  -1px; left: -1px;right: -1px;line-height: 0;overflow: hidden;margin: 0 1px;}.block-xu9bmn6lkf svg{ height: 100px;width: calc(140% + 1.3px);left: 50%;position: relative;display: block;-webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%);}.block-xu9bmn6lkf svg path{ fill: var(--bs-light-bg-subtle)}</style>
		<!-- /wp:blockstrap/blockstrap-widget-shape-divider -->

		<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"0","pt_lg":"5","pb_lg":"2","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mt-0 mb-3 pt-5 pb-2 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","text_align_lg":"text-lg-center","mt_lg":"5","mb_lg":"5","pt_lg":"5","pb_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-5 pt-5 pb-5 bg-image-fixed text-center col"><!-- wp:blockstrap/blockstrap-widget-heading {"text":"Oops! That page can't be found."} -->
					<h1 class="wp-block-blockstrap-blockstrap-widget-heading mb-3">Oops! That page can't be found.</h1>
					<!-- /wp:blockstrap/blockstrap-widget-heading --></div>
				<!-- /wp:blockstrap/blockstrap-widget-container --></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_hero_404_default', 'bsb_pattern_hero_404_default', 10, 1 );

/**
 * Replaces the default archive page hero section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_hero_archive_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"container-fluid","bg":"primary-subtle","mb_lg":"","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container bg-primary-subtle bg-image-fixed container-fluid position-relative"><!-- wp:blockstrap/blockstrap-widget-shape-divider {"sd":"curve","sd_position":"bottom","sd_color":"light-subtle","sd_width":"140","sd_invert":true,"styleid":"block-xu9bmn6lkf","sd_shortcode":"bs_shape_divider"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-shape-divider block-xu9bmn6lkf blockstrap-shape blockstrap-shape-bottom position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">	<path class=" blockstrap-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/></svg></div><style>.block-xu9bmn6lkf { pointer-events: none;background-repeat: no-repeat;bottom:  -1px; left: -1px;right: -1px;line-height: 0;overflow: hidden;margin: 0 1px;}.block-xu9bmn6lkf svg{ height: 100px;width: calc(140% + 1.3px);left: 50%;position: relative;display: block;-webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%);}.block-xu9bmn6lkf svg path{ fill: var(--bs-light-bg-subtle)}</style>
		<!-- /wp:blockstrap/blockstrap-widget-shape-divider -->

		<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"0","pt_lg":"5","pb_lg":"2","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mt-0 mb-3 pt-5 pb-2 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","text_align_lg":"text-lg-center","mt_lg":"5","mb_lg":"5","pt_lg":"5","pb_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-5 pt-5 pb-5 bg-image-fixed text-center col"><!-- wp:blockstrap/blockstrap-widget-archive-title {"sd_shortcode":"bs_archive_title"} /-->

					<!-- wp:term-description /--></div>
				<!-- /wp:blockstrap/blockstrap-widget-container --></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_hero_archive_default', 'bsb_pattern_hero_archive_default', 10, 1 );

/**
 * Replaces the default page hero section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_hero_page_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"container-fluid","bg":"primary-subtle","text_color":"body","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-primary-subtle bg-image-fixed text-body container-fluid position-relative"><!-- wp:blockstrap/blockstrap-widget-shape-divider {"sd":"curve","sd_position":"bottom","sd_color":"light-subtle","sd_width":"140","sd_invert":true,"styleid":"block-xu9bmn6lkf","sd_shortcode":"bs_shape_divider"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-shape-divider block-xu9bmn6lkf blockstrap-shape blockstrap-shape-bottom position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">	<path class=" blockstrap-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/></svg></div><style>.block-xu9bmn6lkf { pointer-events: none;background-repeat: no-repeat;bottom:  -1px; left: -1px;right: -1px;line-height: 0;overflow: hidden;margin: 0 1px;}.block-xu9bmn6lkf svg{ height: 100px;width: calc(140% + 1.3px);left: 50%;position: relative;display: block;-webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%);}.block-xu9bmn6lkf svg path{ fill: var(--bs-light-bg-subtle)}</style>
		<!-- /wp:blockstrap/blockstrap-widget-shape-divider -->

		<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"0","pt_lg":"5","pb_lg":"2","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mt-0 mb-3 pt-5 pb-2 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","text_align_lg":"text-lg-center","mt_lg":"5","mb_lg":"5","pt_lg":"5","pb_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-5 pt-5 pb-5 bg-image-fixed text-center col"><!-- wp:blockstrap/blockstrap-widget-post-title {"sd_shortcode":"bs_post_title"} /--></div>
				<!-- /wp:blockstrap/blockstrap-widget-container --></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_hero_page_default', 'bsb_pattern_hero_page_default', 10, 1 );

/**
 * Replaces the default post hero section content in the BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_hero_post_default( $content ) {
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-container {"container":"container-fluid","bg":"primary-subtle","position":"position-relative","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
	<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-primary-subtle bg-image-fixed container-fluid position-relative"><!-- wp:blockstrap/blockstrap-widget-shape-divider {"sd":"curve","sd_position":"bottom","sd_color":"light-subtle","sd_width":"140","sd_invert":true,"styleid":"block-xu9bmn6lkf","sd_shortcode":"bs_shape_divider"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-shape-divider block-xu9bmn6lkf blockstrap-shape blockstrap-shape-bottom position-absolute"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">	<path class=" blockstrap-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/></svg></div><style>.block-xu9bmn6lkf { pointer-events: none;background-repeat: no-repeat;bottom:  -1px; left: -1px;right: -1px;line-height: 0;overflow: hidden;margin: 0 1px;}.block-xu9bmn6lkf svg{ height: 100px;width: calc(140% + 1.3px);left: 50%;position: relative;display: block;-webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); transform: translateX(-50%);}.block-xu9bmn6lkf svg path{ fill: var(--bs-light-bg-subtle)}</style>
		<!-- /wp:blockstrap/blockstrap-widget-shape-divider -->

		<!-- wp:blockstrap/blockstrap-widget-container {"mt_lg":"0","pt_lg":"5","pb_lg":"2","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
		<div class="wp-block-blockstrap-blockstrap-widget-container mt-0 mb-3 pt-5 pb-2 bg-image-fixed container"><!-- wp:blockstrap/blockstrap-widget-container {"container":"row","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
			<div class="wp-block-blockstrap-blockstrap-widget-container mb-3 bg-image-fixed row"><!-- wp:blockstrap/blockstrap-widget-container {"container":"col","text_align_lg":"text-lg-center","mt_lg":"5","mb_lg":"5","pt_lg":"5","pb_lg":"5","sd_shortcode":"bs_container","sd_shortcode_close":"bs_container"} -->
				<div class="wp-block-blockstrap-blockstrap-widget-container mt-5 mb-5 pt-5 pb-5 bg-image-fixed text-center col"><!-- wp:blockstrap/blockstrap-widget-post-title {"text_color":"body","sd_shortcode":"bs_post_title"} /-->

					<!-- wp:post-terms {"term":"category"} /--></div>
				<!-- /wp:blockstrap/blockstrap-widget-container --></div>
			<!-- /wp:blockstrap/blockstrap-widget-container --></div>
		<!-- /wp:blockstrap/blockstrap-widget-container --></div>
	<!-- /wp:blockstrap/blockstrap-widget-container -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_hero_post_default', 'bsb_pattern_hero_post_default', 10, 1 );
