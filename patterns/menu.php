<?php


/**
 * Get the default menu.
 *
 * @return false|string
 */
function blockstrap_blocks_get_default_menu() {
	ob_start();


	if ( ! defined( 'GEODIRLOCATION_VERSION' ) ) {
		?>
		<!-- wp:blockstrap/blockstrap-widget-nav {"inside_navbar":"1","font_size":"0","ml_lg":"","rounded_size":"lg","width":"w-100"} -->
		[bs_nav inside_navbar='1'  container=''  flex_direction=''  nav_style=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  nav_fill=''  font_size='0'  font_size_custom=''  bg=''  mt=''  mr='auto'  mb=''  ml='auto'  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg='0'  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size='lg'  shadow=''  width='w-100'  css_class='' ]<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav_1"><span class="navbar-toggler-icon"></span></button><div class="wp-block-blockstrap-blockstrap-widget-nav collapse navbar-collapse" id="navbarNav_1"><ul class="wp-block-blockstrap-blockstrap-widget-nav navbar-nav me-auto ms-auto me-lg-0 rounded-lg w-100 0">

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"page_id":"70","custom_url":"#about","text":"Home","text_color":"white","ml":"0","ml_md":"0","ml_lg":"auto","content":""} -->
		[bs_nav_item type='home'  page_id='70'  post_id=''  custom_url='#about'  text='Home'  icon_class=''  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color='white'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml='0'  mt_md=''  mr_md=''  mb_md=''  ml_md='0'  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg='auto'  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"#about","text":"About","text_color":"white","content":""} -->
		[bs_nav_item type='custom'  page_id=''  post_id=''  custom_url='#about'  text='About'  icon_class=''  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color='white'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

		<!-- wp:blockstrap/blockstrap-widget-nav-dropdown {"text":"Dropdown","link_bg":"success"} -->
		[bs_nav_dropdown text='Dropdown'  icon_class=''  link_type=''  link_size=''  link_bg='success'  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]<li class="wp-block-blockstrap-blockstrap-widget-nav-dropdown nav-item dropdown form-inline"><a class="dropdown-toggle nav-link nav-link text-" href="#" roll="button" data-toggle="dropdown" aria-expanded="false">Dropdown</a><ul class="wp-block-blockstrap-blockstrap-widget-nav-dropdown dropdown-menu"><!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_place","text":"Item","content":""} -->
				[bs_nav_item type='gd_place'  page_id=''  post_id=''  custom_url=''  text='Item'  icon_class=''  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_place","text":"Item with icon","icon_class":"fas fa-ship","content":""} -->
				[bs_nav_item type='gd_place'  page_id=''  post_id=''  custom_url=''  text='Item with icon'  icon_class='fas fa-ship'  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item --></ul></li>[/bs_nav_dropdown]
		<!-- /wp:blockstrap/blockstrap-widget-nav-dropdown -->

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"#facebook","icon_class":"fab fa-facebook","link_bg":"outline-light","text_color":"white","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":""} -->
		[bs_nav_item type='custom'  page_id=''  post_id=''  custom_url='#facebook'  text=''  icon_class='fab fa-facebook'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color='white'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"#twitter","icon_class":"fab fa-twitter","link_bg":"outline-light","text_color":"white","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":""} -->
		[bs_nav_item type='custom'  page_id=''  post_id=''  custom_url='#twitter'  text=''  icon_class='fab fa-twitter'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color='white'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"#instagram","icon_class":"fab fa-instagram","link_bg":"outline-light","text_color":"white","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":""} -->
		[bs_nav_item type='custom'  page_id=''  post_id=''  custom_url='#instagram'  text=''  icon_class='fab fa-instagram'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color='white'  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

		<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"custom","custom_url":"https://wpblockstrap.com/","text":"Buy now","icon_class":"fas fa-shopping-bag","link_type":"btn-round","link_bg":"danger","text_align_lg":"text-lg-end","ml":"0","ml_md":"0","mt_lg":"0","mb_lg":"0","ml_lg":"3","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":""} -->
		[bs_nav_item type='custom'  page_id=''  post_id=''  custom_url='https://wpblockstrap.com/'  text='Buy now'  icon_class='fas fa-shopping-bag'  link_type='btn-round'  link_size=''  link_bg='danger'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg='text-lg-end'  font_weight=''  mt=''  mr=''  mb=''  ml='0'  mt_md=''  mr_md=''  mb_md=''  ml_md='0'  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg='3'  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow=''  visibility_conditions=''  css_class='' ]
		<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

			</ul></div><script>jQuery("#navbarNav_1").on("show.bs.collapse", function () {jQuery("#navbarNav_1").closest(".bg-transparent-until-scroll,.bg-transparent").addClass("nav-menu-open");});jQuery("#navbarNav_1").on("hidden.bs.collapse", function () {jQuery("#navbarNav_1").closest(".bg-transparent-until-scroll,.bg-transparent").removeClass("nav-menu-open");});</script>[/bs_nav]
		<!-- /wp:blockstrap/blockstrap-widget-nav -->
		<?php
	} else {
		?>
	<!-- wp:blockstrap/blockstrap-widget-nav {"inside_navbar":"1","font_size":"0","ml_lg":"","rounded_size":"lg","width":"w-100"} -->
	[bs_nav inside_navbar='1'  container=''  flex_direction=''  nav_style=''  flex_justify_content=''  flex_justify_content_md=''  flex_justify_content_lg=''  nav_fill=''  font_size='0'  font_size_custom=''  bg=''  mt=''  mr='auto'  mb=''  ml='auto'  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg='0'  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size='lg'  shadow=''  width='w-100'  css_class='' ]<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav_1"><span class="navbar-toggler-icon"></span></button><div class="wp-block-blockstrap-blockstrap-widget-nav collapse navbar-collapse" id="navbarNav_1"><ul class="wp-block-blockstrap-blockstrap-widget-nav navbar-nav me-auto ms-auto me-lg-0 rounded-lg w-100 0">

			<?php
			// Location switcher if location manager installed
			if ( defined( 'GEODIRLOCATION_VERSION' ) ) {
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"gd_location_switcher","page_id":"70","custom_url":"#about","text":"Set Location","icon_class":"fas fa-map-marker-alt fa-lg text-primary","link_divider":"right","ml":"0","ml_md":"0","mr_lg":"2","pr_lg":"2","content":"\u003ca href=\u0022##location-switcher\u0022 class=\u0022nav-link \u0022\u003e\u003ci class=\u0022fas fa-map-marker-alt fa-lg text-primary me-2\u0022\u003e\u003c/i\u003eSet Location\u003cspan class=\u0022navbar-divider d-none d-lg-block position-absolute top-50 end-0 translate-middle-y\u0022\u003e\u003c/span\u003e\u003c/a\u003e"} -->
				[bs_nav_item type='gd_location_switcher'  page_id='70'  post_id=''  custom_url='#about'  text='Set Location'  icon_class='fas fa-map-marker-alt fa-lg text-primary'  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider='right'  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml='0'  mt_md=''  mr_md=''  mb_md=''  ml_md='0'  mt_lg=''  mr_lg='2'  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg='2'  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->
				<?php
			}

			// CPTs
			if ( defined( 'GEODIRECTORY_VERSION' ) ) {
				$post_types = geodir_get_posttypes( 'array' );

				foreach ( $post_types as $pt => $cpt ) {

					if ( $cpt['public'] ) {
						$name = ! empty( $cpt['labels']['name'] ) ? esc_attr( $cpt['labels']['name'] ) : esc_attr( $pt );
						?>
						<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"<?php echo esc_attr( $pt ); ?>","custom_url":"","text":"<?php echo esc_attr( $name ); ?>","content":""} -->
						[bs_nav_item type='<?php echo esc_attr( $pt ); ?>'  page_id=''  post_id=''  custom_url=''  text='<?php echo esc_attr( $name ); ?>'  icon_class=''  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
						<!-- /wp:blockstrap/blockstrap-widget-nav-item -->
						<?php
					}
				}
			}

			// Blog page

			if ( 'page' === get_option( 'show_on_front' ) ) {
				$blog_page_id = get_option( 'page_for_posts' );
				if ( $blog_page_id ) {
					?>
					<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"page","page_id":"<?php echo absint( $blog_page_id ); ?>","text":"Blog","content":""} -->
					[bs_nav_item type='page'  page_id='<?php echo absint( $blog_page_id ); ?>'  post_id=''  custom_url=''  text='Blog'  icon_class=''  link_type=''  link_size=''  link_bg=''  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg=''  pr_lg=''  pb_lg=''  pl_lg=''  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
					<!-- /wp:blockstrap/blockstrap-widget-nav-item -->
					<?php
				}
			}

			// spacer
			?>
			<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"spacer","text":" ","icon_class":" ","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","ml_lg":"auto","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003cli class=\u0022nav-item mt-0 mb-0 ms-auto pt-0 pe-0 pb-0 ps-0\u0022\u003e\u003c/li\u003e"} -->
			[bs_nav_item type='spacer'  page_id=''  post_id=''  custom_url=''  text=' '  icon_class=' '  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg='auto'  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
			<!-- /wp:blockstrap/blockstrap-widget-nav-item -->
			<?php

			if ( defined( 'USERSWP_VERSION' ) ) {
				// Sign in/out with UWP
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"uwp_login","text":"Sign in","icon_class":"far fa-user","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#http://localhost/login/?redirect_to=http://localhost/add-listing/\u0022 class=\u0022nav-link \u0022\u003e\u003ci class=\u0022far fa-user me-2\u0022\u003e\u003c/i\u003eSign in\u003c/a\u003e"} -->
				[bs_nav_item type='uwp_login'  page_id=''  post_id=''  custom_url=''  text='Sign in'  icon_class='far fa-user'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"uwp_logout","text":"Sign out","icon_class":"fas fa-sign-out-alt","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#http://localhost/wp-login.php?action=logout\u0026amp;_wpnonce=ff174f2c84\u0022 class=\u0022nav-link \u0022\u003e\u003ci class=\u0022fas fa-sign-out-alt me-2\u0022\u003e\u003c/i\u003eSign out\u003c/a\u003e"} -->
				[bs_nav_item type='uwp_logout'  page_id=''  post_id=''  custom_url=''  text='Sign out'  icon_class='fas fa-sign-out-alt'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->
				<?php
			} else {
				// Signin/out without UWP
				?>
				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"wp-login","text":"Sign in","icon_class":"far fa-user","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#http://localhost/login/?redirect_to=http://localhost/add-listing/\u0022 class=\u0022nav-link \u0022\u003e\u003ci class=\u0022far fa-user me-2\u0022\u003e\u003c/i\u003eSign in\u003c/a\u003e"} -->
				[bs_nav_item type='wp-login'  page_id=''  post_id=''  custom_url=''  text='Sign in'  icon_class='far fa-user'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

				<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"wp-logout","text":"Sign out","icon_class":"fas fa-sign-out-alt","link_bg":"outline-light","mt_lg":"0","mb_lg":"0","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#http://localhost/wp-login.php?action=logout\u0026amp;_wpnonce=ff174f2c84\u0022 class=\u0022nav-link \u0022\u003e\u003ci class=\u0022fas fa-sign-out-alt me-2\u0022\u003e\u003c/i\u003eSign out\u003c/a\u003e"} -->
				[bs_nav_item type='wp-logout'  page_id=''  post_id=''  custom_url=''  text='Sign out'  icon_class='fas fa-sign-out-alt'  link_type=''  link_size=''  link_bg='outline-light'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg=''  font_weight=''  mt=''  mr=''  mb=''  ml=''  mt_md=''  mr_md=''  mb_md=''  ml_md=''  mt_lg='0'  mr_lg=''  mb_lg='0'  ml_lg=''  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
				<!-- /wp:blockstrap/blockstrap-widget-nav-item -->

				<?php
			}
			?>

			<!-- wp:blockstrap/blockstrap-widget-nav-item {"type":"add_gd_place","text":"Add listing","icon_class":"fas fa-plus","link_type":"btn-round","link_size":"small","link_bg":"danger","text_align_lg":"text-lg-end","ml":"0","ml_md":"0","ml_lg":"3","pt_lg":"0","pr_lg":"0","pb_lg":"0","pl_lg":"0","content":"\u003ca href=\u0022#http://localhost/add-listing/?listing_type=gd_place\u0022 class=\u0022btn btn-round btn-primary btn-sm \u0022\u003e\u003ci class=\u0022fas fa-plus me-2\u0022\u003e\u003c/i\u003eAdd listing\u003c/a\u003e"} -->
			[bs_nav_item type='add_gd_place'  page_id=''  post_id=''  custom_url=''  text='Add listing'  icon_class='fas fa-plus'  link_type='btn-round'  link_size='small'  link_bg='danger'  link_pt=''  link_pr=''  link_pb=''  link_pl=''  link_pt_md=''  link_pr_md=''  link_pb_md=''  link_pl_md=''  link_pt_lg=''  link_pr_lg=''  link_pb_lg=''  link_pl_lg=''  link_divider=''  text_color=''  text_justify='false'  text_align=''  text_align_md=''  text_align_lg='text-lg-end'  font_weight=''  mt=''  mr=''  mb=''  ml='0'  mt_md=''  mr_md=''  mb_md=''  ml_md='0'  mt_lg=''  mr_lg=''  mb_lg=''  ml_lg='3'  pt=''  pr=''  pb=''  pl=''  pt_md=''  pr_md=''  pb_md=''  pl_md=''  pt_lg='0'  pr_lg='0'  pb_lg='0'  pl_lg='0'  border=''  rounded=''  rounded_size=''  shadow='' visibility_conditions=''  css_class='' ]
			<!-- /wp:blockstrap/blockstrap-widget-nav-item -->



		</ul></div><script>jQuery("#navbarNav_1").on("show.bs.collapse", function () {jQuery("#navbarNav_1").closest(".bg-transparent-until-scroll,.bg-transparent").addClass("nav-menu-open");});jQuery("#navbarNav_1").on("hidden.bs.collapse", function () {jQuery("#navbarNav_1").closest(".bg-transparent-until-scroll,.bg-transparent").removeClass("nav-menu-open");});</script>[/bs_nav]
	<!-- /wp:blockstrap/blockstrap-widget-nav -->
		<?php
	}

	return ob_get_clean();
}
