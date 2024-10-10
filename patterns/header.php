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
	ob_start();
	?>
	<!-- wp:blockstrap/blockstrap-widget-skip-links {"content":"\u003ca href=\u0022#main\u0022 class=\u0022btn btn-primary\u0022\u003eSkip to main content\u003c/a\u003e","sd_shortcode":"[bs_skip_links text1='Skip to main content'  hash1='main'  text2=''  hash2=''  text3=''  hash3=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  css_class='' ]"} /-->

	<!-- wp:blockstrap/blockstrap-widget-navbar {"bg":"dark","bg_color":"#0d1b48","bgtus":true,"container":"navbar-dark","inner_container":"container","mb_lg":"","pt_lg":"2","pb_lg":"2","shadow":"shadow","position":"fixed-top","sd_shortcode":"[bs_navbar bg='dark'  bg_color='#0d1b48'  bg_gradient='linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)'  bg_image_fixed='false'  bg_image_use_featured='false'  bg_image=''  bg_image_id=''  bgtus='true'  cscos='false'  container='navbar-dark'  inner_container='container'  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='2'  pr_lg=''  pb_lg='2'  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow='shadow'  position='fixed-top'  sticky_offset_top=''  sticky_offset_bottom='' ]","sd_shortcode_close":"[/bs_navbar]"} -->
	<nav class="navbar navbar-expand-lg pt-2 pb-2 bg-dark bg-image-fixed bg-transparent-until-scroll navbar-dark fixed-top shadow"><div class="wp-block-blockstrap-blockstrap-widget-navbar container"><!-- wp:blockstrap/blockstrap-widget-navbar-brand {"text":"","icon_image":"<?php echo esc_url( $img_url ); ?>","img_max_width":150,"type":"custom","custom_url":"/","brand_font_size":"h1","brand_font_weight":"font-weight-normal","brand_font_italic":"font-italic","bg_gradient":"linear-gradient(135deg,rgb(34,227,7) 0%,rgb(245,245,245) 100%)","bg_on_text":true,"mb_lg":"","pt_lg":"0","pr_lg":"3","pb_lg":"0","rounded_size":"lg","sd_shortcode":"[bs_navbar_brand text=''  icon_image='<?php echo esc_url( $img_url ); ?>'  img_max_width='150'  type='custom'  custom_url='/'  text_color=''  brand_font_size='h1'  brand_font_weight='font-weight-normal'  brand_font_italic='font-italic'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  bg=''  bg_color='#0073aa'  bg_gradient='linear-gradient(135deg,rgb(34,227,7) 0%,rgb(245,245,245) 100%)'  bg_on_text='true'  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='3'  pb_lg='0'  pl_lg=''  border=''  rounded=''  rounded_size='lg'  shadow=''  css_class='' ]"} -->
			<a class="navbar-brand d-flex align-items-center pt-0 pe-3 pb-0 rounded-lg" href="/"><img class="" alt="Site logo" src="<?php echo esc_url( $img_url ); ?>" style="max-width:150px" width="150" height="50"/><span class="mb-0 props.attributes.brand_font_size props.attributes.brand_font_weight fst-italic"></span></a>
			<!-- /wp:blockstrap/blockstrap-widget-navbar-brand -->

			<?php
			echo blockstrap_blocks_get_default_menu(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?></div></nav>
	<!-- /wp:blockstrap/blockstrap-widget-navbar -->
	<?php
	return ob_get_clean();
}
add_filter( 'blockstrap_pattern_header_default', 'bsb_pattern_header_default', 10, 1 );
