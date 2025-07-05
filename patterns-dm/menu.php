<?php


/**
 * Get the default menu.
 *
 * @return false|string
 */
function blockstrap_blocks_get_default_menu() {
	ob_start();


	if ( ! defined( 'GEODIRECTORY_VERSION' ) ) {

		?>

		<!-- wp:blockstrap/blockstrap-widget-nav {"anchor":"main-nav","font_size":"0","rounded_size":"lg","width":"w-100","sd_shortcode":"bs_nav","sd_shortcode_close":"bs_nav"} -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav_main-nav" aria-label="Open menu"><span class="navbar-toggler-icon"></span></button><div class="wp-block-blockstrap-blockstrap-widget-nav blockstrap-nav collapse navbar-collapse" id="navbarNav_main-nav"><ul class="wp-block-blockstrap-blockstrap-widget-nav navbar-nav me-auto ms-auto me-lg-0 ms-lg-auto rounded-lg w-100"><!-- wp:blockstrap/blockstrap-widget-nav-item {"text":"Home","ml":"0","ml_md":"0","ml_lg":"auto","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003eHome\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"#about","text":"About","ml":"0","ml_md":"0","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003eAbout\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->

				<?php
				// Blog page
				if ( 'page' === get_option( 'show_on_front' ) ) {
					$blog_page_id = get_option( 'page_for_posts' );
					if ( $blog_page_id ) {
						?>
						<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"page","page_id":"<?php echo absint( $blog_page_id ); ?>","text":"Blog","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003eBlog\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
						<?php
					}
				}
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-dropdown {"text":"Dropdown","link_bg":"success","sd_shortcode":"bs_nav_dropdown","sd_shortcode_close":"bs_nav_dropdown"} -->
				<li class="wp-block-blockstrap-blockstrap-widget-nav-dropdown nav-item dropdown form-inline"><a class="dropdown-toggle nav-link nav-link text-" href="#" roll="button" data-toggle="dropdown" aria-expanded="false">Dropdown</a><ul class="wp-block-blockstrap-blockstrap-widget-nav-dropdown dropdown-menu"><!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_place","text":"Item","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022dropdown-item \u0022 \u003eItem\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->

						<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_place","text":"Item with icon","icon_class":"fas fa-ship","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022dropdown-item \u0022 \u003e\u003ci class=\u0022fas fa-ship me-2\u0022\u003e\u003c/i\u003eItem with icon\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /--></ul></li>
				<!-- /wp:blockstrap/blockstrap-widget-nav-dropdown -->

				<!-- wp:blockstrap/blockstrap-widget-dark-mode {"type":"nav-item","link_type":"btn-icon","hover_icon_animation":"animate-scale","css_class":"active","content":"\u003cli class=\u0022nav-item animate-scale active\u0022\u003e\u003cbutton class=\u0022bs-dark-mode-toggle btn btn-icon nav-link btn btn-icon rounded-circle \u0022 role=\u0022button\u0022 data-bs-toggle=\u0022tooltip\u0022 data-bs-placement=\u0022bottom\u0022 data-bs-title=\u0022Toggle dark mode\u0022 aria-label=\u0022Toggle dark mode\u0022 \u003e\n\t\t\t\t\t  \u003ci class=\u0022fa-solid fa-sun bs-is-light-mode aui-dark-mode-hide animate-target\u0022 style=\u0022display: inline;\u0022\u003e\u003c/i\u003e\n\t\t\t\t\t  \u003ci class=\u0022fa-solid fa-moon bs-is-dark-mode aui-light-mode-hide animate-target\u0022 style=\u0022display: none;\u0022\u003e\u003c/i\u003e\n\t\t\t\t\t\u003c/button\u003e\u003c/li\u003e","sd_shortcode":"bs_dark_mode"} /-->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"https://wpblockstrap.com/","text":"Buy now","icon_class":"fas fa-shopping-bag","link_type":"btn-round","link_bg":"danger","text_align":"text-center","text_align_lg":"text-lg-end","mr":"auto","ml":"auto","ml_md":"0","mr_lg":"0","ml_lg":"3","hover_icon_animation":"animate-shake","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022 btn btn-round btn-danger \u0022 \u003e\u003ci class=\u0022fas fa-shopping-bag animate-target me-2\u0022\u003e\u003c/i\u003eBuy now\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /--></ul></div>
		<!-- /wp:blockstrap/blockstrap-widget-nav -->
		<?php
	} else {
		// @todo this needs converted to new style
		?>
		<!-- wp:blockstrap/blockstrap-widget-nav {"anchor":"main-nav","font_size":"0","ml_lg":"","rounded_size":"lg","width":"w-100","sd_shortcode":"bs_nav","sd_shortcode_close":"bs_nav"} -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav_main-nav" aria-label="Open menu"><span class="navbar-toggler-icon"></span></button><div class="wp-block-blockstrap-blockstrap-widget-nav blockstrap-nav collapse navbar-collapse" id="navbarNav_main-nav"><ul class="wp-block-blockstrap-blockstrap-widget-nav navbar-nav me-auto ms-auto me-lg-0 rounded-lg w-100">
			<?php
			// Location switcher if location manager installed
			if ( defined( 'GEODIRLOCATION_VERSION' ) ) {
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_location_switcher","text":"Set Location","icon_class":"fas fa-map-marker-alt fa-lg text-primary","link_divider":"right","ml":"0","ml_md":"0","mr_lg":"2","pr_lg":"2","hover_icon_animation":"animate-shake","content":"\u003ca href=\u0022##location-switcher\u0022 class=\u0022nav-link \u0022 \u003e\u003ci class=\u0022fas fa-map-marker-alt fa-lg text-primary animate-target me-2\u0022\u003e\u003c/i\u003eSet Location\u003cspan class=\u0022navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y\u0022\u003e\u003c/span\u003e\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->				<?php
			}

			// CPTs
			$post_types = geodir_get_posttypes( 'array' );

			foreach ( $post_types as $pt => $cpt ) {

				if ( $cpt['public'] ) {
					$name = ! empty( $cpt['labels']['name'] ) ? esc_attr( $cpt['labels']['name'] ) : esc_attr( $pt );
					?>
					<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"<?php echo esc_attr( $pt ); ?>","text":"<?php echo esc_attr( $name ); ?>","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e<?php echo esc_attr( $name ); ?>\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
					<?php
				}
			}


			// Blog page

			if ( 'page' === get_option( 'show_on_front' ) ) {
				$blog_page_id = get_option( 'page_for_posts' );
				if ( $blog_page_id ) {
					?>
					<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"page","page_id":"<?php echo absint( $blog_page_id ); ?>","text":"Blog","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003eBlog\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
					<?php
				}
			}

			// spacer
			?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"spacer","text":" ","icon_class":" ","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","ml_lg":"auto","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e \u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
			<?php

			if ( defined( 'USERSWP_VERSION' ) ) { //@todo
				// Sign in/out with UWP
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"uwp_login","text":"Sign in","icon_class":"far fa-user","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","hover_icon_animation":"animate-shake","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e\u003ci class=\u0022far fa-user animate-target me-2\u0022\u003e\u003c/i\u003eSign in\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"wp-logout","text":"Sign out","icon_class":"fas fa-sign-out-alt","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","hover_icon_animation":"animate-slide-end","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e\u003ci class=\u0022fas fa-sign-out-alt animate-target me-2\u0022\u003e\u003c/i\u003eSign out\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
				<?php
			} else {
				// Signin/out without UWP
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"wp-login","text":"Sign in","icon_class":"far fa-user","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","hover_icon_animation":"animate-shake","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e\u003ci class=\u0022far fa-user animate-target me-2\u0022\u003e\u003c/i\u003eSign in\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"wp-logout","text":"Sign out","icon_class":"fas fa-sign-out-alt","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","hover_icon_animation":"animate-slide-end","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022nav-link \u0022 \u003e\u003ci class=\u0022fas fa-sign-out-alt animate-target me-2\u0022\u003e\u003c/i\u003eSign out\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->
				<?php
			}
			?>
				<!-- wp:blockstrap/blockstrap-widget-dark-mode {"type":"nav-item","link_type":"btn-icon","hover_icon_animation":"animate-scale","css_class":"active","content":"\u003cli class=\u0022nav-item animate-scale active\u0022\u003e\u003cbutton class=\u0022bs-dark-mode-toggle btn btn-icon nav-link btn btn-icon rounded-circle \u0022 role=\u0022button\u0022 data-bs-toggle=\u0022tooltip\u0022 data-bs-placement=\u0022bottom\u0022 data-bs-title=\u0022Toggle dark mode\u0022 aria-label=\u0022Toggle dark mode\u0022 \u003e\n\t\t\t\t\t  \u003ci class=\u0022fa-solid fa-sun bs-is-light-mode aui-dark-mode-hide animate-target\u0022 style=\u0022display: inline;\u0022\u003e\u003c/i\u003e\n\t\t\t\t\t  \u003ci class=\u0022fa-solid fa-moon bs-is-dark-mode aui-light-mode-hide animate-target\u0022 style=\u0022display: none;\u0022\u003e\u003c/i\u003e\n\t\t\t\t\t\u003c/button\u003e\u003c/li\u003e","sd_shortcode":"bs_dark_mode"} /-->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"add_gd_place","text":"Add listing","icon_class":"fas fa-plus","link_type":"btn-round","link_bg":"danger","text_align":"text-center","ml":"0","ml_md":"0","ml_lg":"3","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","hover_icon_animation":"animate-rotate","content":"\u003ca href=\u0022#placeholder\u0022 class=\u0022 btn btn-round btn-danger \u0022 \u003e\u003ci class=\u0022fas fa-plus animate-target me-2\u0022\u003e\u003c/i\u003eAdd listing\u003c/a\u003e","sd_shortcode":"bs_nav_item"} /-->			</ul></div>
		<!-- /wp:blockstrap/blockstrap-widget-nav -->
		<?php
	}

	return ob_get_clean();
}
