<?php
/**
 * Replaces the default header in BlockStrap theme.
 *
 * @param $content
 *
 * @return string
 */
function bsb_pattern_header_default( $content ) {

	$img_url = esc_url( BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/Blockstrap-white.png' ); /* <?php echo esc_url( $img_url ); ?> */
	$img_url_dark = esc_url( BLOCKSTRAP_BLOCKS_PLUGIN_URL . 'assets/images/Blockstrap.png' ); /* <?php echo esc_url( $img_url_dark ); ?> */
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-skip-links {"content":"\u003ca href=\u0022#main\u0022 class=\u0022btn btn-primary\u0022\u003eSkip to main content\u003c/a\u003e","sd_shortcode":"bs_skip_links"} /-->

	<!-- wp:blockstrap/blockstrap-widget-navbar {"bg":"light-subtle","bgtus":true,"container":"navbar-light","inner_container":"container","pt_lg":"2","pb_lg":"2","shadow":"shadow","position":"fixed-top","sd_shortcode":"bs_navbar","sd_shortcode_close":"bs_navbar"} -->
	<nav class="navbar navbar-expand-lg mb-3 pt-2 pb-2 bg-light-subtle bg-image-fixed bg-transparent-until-scroll navbar-light fixed-top shadow"><div class="wp-block-blockstrap-blockstrap-widget-navbar container"><!-- wp:blockstrap/blockstrap-widget-navbar-brand {"text":"","icon_image":"<?php echo esc_url( $img_url ); ?>","icon_image_dark":"<?php echo esc_url( $img_url_dark ); ?>","type":"custom","custom_url":"/","brand_font_size":"h1","brand_font_weight":"font-weight-normal","brand_font_italic":"font-italic","bg_on_text":true,"mb_lg":"0","pt_lg":"0","pr_lg":"3","pb_lg":"0","rounded_size":"lg","sd_shortcode":"bs_navbar_brand"} -->
			<a class="navbar-brand d-flex align-items-center mb-0 pt-0 pe-3 pb-0 rounded-lg" href="/"><img class="aui-light-mode-hide" alt="Site logo" src="<?php echo esc_url( $img_url ); ?>" style="max-width:150px" width="150" height="50"/><img class="aui-dark-mode-hide" alt="Site logo dark" src="<?php echo esc_url( $img_url_dark ); ?>" style="max-width:150px" width="150" height="50"/><span class="mb-0 props.attributes.brand_font_size props.attributes.brand_font_weight fst-italic"></span></a>
			<!-- /wp:blockstrap/blockstrap-widget-navbar-brand -->

			<?php
			echo blockstrap_blocks_get_default_menu(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?></div></nav>
	<!-- /wp:blockstrap/blockstrap-widget-navbar -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_header_default', 'bsb_pattern_header_default', 10, 1 );
