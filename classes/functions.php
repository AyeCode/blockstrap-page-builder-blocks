<?php
/**
 * Common functions
 */

/**
 * Get the link types for block and widgets.
 *
 * @return array
 */
function blockstrap_pbb_get_block_link_types(){
	global $ayecode_ui_version;
	$links = [
		'home'      => __( 'Home', 'blockstrap-page-builder-blocks' ),
		'page'      => __( 'Page', 'blockstrap-page-builder-blocks' ),
		'post-id'   => __( 'Post ID', 'blockstrap-page-builder-blocks' ),
		'term-id'   => __( 'Term ID', 'blockstrap-page-builder-blocks' ),
		'wp-login'  => __( 'WP Login (logged out)', 'blockstrap-page-builder-blocks' ),
		'wp-logout' => __( 'WP Logout (logged in)', 'blockstrap-page-builder-blocks' ),
		'custom'    => __( 'Custom URL', 'blockstrap-page-builder-blocks' ),
		'lightbox'  => __( 'Open Lightbox', 'blockstrap-page-builder-blocks' ),
		'offcanvas' => __( 'Open Offcanvas', 'blockstrap-page-builder-blocks' ),
	];

	if(version_compare($ayecode_ui_version, '0.2.99', '>')){
		$links['dark-mode-toggle'] = __( 'Dark Mode Toggle', 'blockstrap-page-builder-blocks' );
		$links['dark-mode-dropdown'] = __( 'Dark Mode Dropdown', 'blockstrap-page-builder-blocks' );
	}

	if (defined('GEODIRECTORY_VERSION')) {
		$post_types           = function_exists('geodir_get_posttypes') ? geodir_get_posttypes('options-plural') : [];
		$links['gd_search']   = __('GD Search', 'blockstrap-page-builder-blocks');
		$links['gd_location'] = __('GD Location', 'blockstrap-page-builder-blocks');
		foreach ($post_types as $cpt => $cpt_name) {
			// translators: Custom Post Type name.
			$links[$cpt] = sprintf(__('%s (archive)', 'blockstrap-page-builder-blocks'), $cpt_name);
			// translators: Custom Post Type name.
			$links['add_'.$cpt] = sprintf(__('%s (add listing)', 'blockstrap-page-builder-blocks'), $cpt_name);
		}
	}

	if (defined('GEODIRLOCATION_VERSION')) {
		$links['gd_location_switcher'] = __('GD Location Switcher', 'blockstrap-page-builder-blocks');
	}

	if (defined('USERSWP_VERSION')) {
		// logged out
		$links['uwp_login']    = __('UWP Login (logged out)', 'blockstrap-page-builder-blocks');
		$links['uwp_register'] = __('UWP Register (logged out)', 'blockstrap-page-builder-blocks');
		$links['uwp_forgot']   = __('UWP Forgot Password? (logged out)', 'blockstrap-page-builder-blocks');

		// logged in
		$links['uwp_account']         = __('Account (logged in)', 'blockstrap-page-builder-blocks');
		$links['uwp_change_password'] = __('Change Password (logged in)', 'blockstrap-page-builder-blocks');
		$links['uwp_profile']         = __('Profile (logged in)', 'blockstrap-page-builder-blocks');
		$links['uwp_logout']          = __('Log out (logged in)', 'blockstrap-page-builder-blocks');
	}

	$links['spacer'] = __('spacer (non link)', 'blockstrap-page-builder-blocks');

	return $links;
}

/**
 * Get the link parts for bocks that have dynamic links.
 *
 * @param $args
 * @param $wrap_class
 * @return array|string
 */
function blockstrap_pbb_get_link_parts( $args, $wrap_class = '' )
{
	global $aui_bs5;

	$link_parts = [];
	if ('spacer' === $args['type']) {
		return '<li class="nav-item '.$wrap_class.'"></li>';
	} else if ('home' === $args['type']) {
		$link      = get_home_url();
		$link_text = __('Home', 'blockstrap-page-builder-blocks');
	} else if ('page' === $args['type'] || 'post-id' === $args['type']) {
		$page_id = ! empty($args['page_id']) ? absint($args['page_id']) : 0;
		$post_id = ! empty($args['post_id']) ? absint($args['post_id']) : 0;
		$id      = 'page' === $args['type'] ? $page_id : $post_id;
		if ($id) {
			$page = get_post($id);
			if (! empty($page->post_title)) {
				$link      = get_permalink($id);
				$link_text = esc_attr($page->post_title);
			}
		}
	} else if ('term-id' === $args['type']) {
		$taxonomy = ! empty($args['taxonomy']) ? esc_attr($args['taxonomy']) : '';
		$term_id = ! empty($args['term_id']) ? absint($args['term_id']) : 0;
		if ($term_id && $taxonomy) {
			$link = get_term_link($term_id, $taxonomy);
			if (empty($args['text'])) {
				// its more efficient to manually set a name but this is good UX
				$term = get_term($term_id, $taxonomy);
				if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
					$link_text = esc_attr($term->name);
				}
			}

			// fallback
			if(empty($link_text)) {
				$link_text = __('Term link', 'blockstrap-page-builder-blocks');
			}

		}
	} else if ('wp-login' === $args['type']) {
		$args['icon_class'] = $args['icon_class'] ?: 'far fa-user';
		$link               = esc_url(wp_login_url(get_permalink()));
		$link_text          = __('Sign in', 'blockstrap-page-builder-blocks');
	} else if ( 'wp-logout' === $args['type'] ) {
		$args['icon_class'] = $args['icon_class'] ?: 'fas fa-sign-out-alt';
		$link               = esc_url( wp_logout_url() );
		$link_text          = __( 'Sign out', 'blockstrap-page-builder-blocks' );
	} else if ('lightbox' === $args['type']) {
		$link      = ! empty($args['custom_url']) ? esc_url_raw($args['custom_url']) : '#';
		$link_text = __('Open Lightbox', 'blockstrap-page-builder-blocks');
		$link_attr = ' data-bs-toggle="modal" ';
	} else if ('offcanvas' === $args['type']) {
		$link      = ! empty($args['custom_url']) ? esc_url_raw($args['custom_url']) : '#';
		$link_text = __('Open Offcanvas', 'blockstrap-page-builder-blocks');
		$link_attr = ' data-bs-toggle="offcanvas" ';
	} else if ('dark-mode-toggle' === $args['type']) {
		$icon = '<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
</div>';
		//$icon = '<input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">';

		$icon = '<span class="bs-dark-mode-toggle" role="button" aria-label="Toggle dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Toggle dark mode">
  <i class="fa-solid fa-sun bs-is-light-mode" style="display: none;"></i>
  <i class="fa-solid fa-moon bs-is-dark-mode" style="display: none;"></i>
</span>'."<script>
(function () {
  const toggle = document.querySelector('.bs-dark-mode-toggle');
  const sunIcon = toggle.querySelector('.bs-is-light-mode');
  const moonIcon = toggle.querySelector('.bs-is-dark-mode');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  function setMode(mode) {
    document.documentElement.setAttribute('data-bs-theme', mode);
    localStorage.setItem('bs-theme', mode);
    sunIcon.style.display = mode === 'light' ? 'inline' : 'none';
    moonIcon.style.display = mode === 'dark' ? 'inline' : 'none';
  }

  function initMode() {
    const saved = localStorage.getItem('bs-theme');
    if (saved) {
      setMode(saved);
    } else {
      setMode(prefersDark ? 'dark' : 'light');
    }
  }

  toggle.addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-bs-theme');
    setMode(current === 'dark' ? 'light' : 'dark');
  });

  initMode();
})();
</script>
";
		$link      = ! empty($args['custom_url']) ? esc_url_raw($args['custom_url']) : '#dark-mode-toggle';
		//$link_text = __('Dark Mode', 'blockstrap-page-builder-blocks');
//		$link_attr = ' data-bs-toggle="offcanvas" ';
//		$icon_class         = ! empty($args['icon_class']) ? esc_attr($args['icon_class']) : 'fas fa-map-marker-alt fa-lg text-primary';
//		$args['icon_class'] = $icon_class;


	} else if ('custom' === $args['type']) {
		$link      = ! empty($args['custom_url']) ? esc_url_raw($args['custom_url']) : '#';
		$link_text = __('Custom', 'blockstrap-page-builder-blocks');
	} else if ('gd_search' === $args['type']) {
		$link      = function_exists('geodir_search_page_base_url') ? geodir_search_page_base_url() : '';
		$link_text = __('Search', 'blockstrap-page-builder-blocks');
	} else if ('gd_location' === $args['type']) {
		$link      = function_exists('geodir_location_page_id') ? get_permalink(geodir_location_page_id()) : '';
		$link_text = __('Location', 'blockstrap-page-builder-blocks');
	} else if ('gd_location_switcher' === $args['type']) {
		global $geodirectory;
		$location_name = ! empty( $args['text'] ) ? esc_attr( $args['text'] ) : __('Set Location', 'blockstrap-page-builder-blocks');
		$location_set  = true;

		// print_r($geodirectory->location);
		if (! empty($geodirectory->location->neighbourhood)) {
			$location_name = $geodirectory->location->neighbourhood;
		} else if (! empty($geodirectory->location->city)) {
			$location_name = $geodirectory->location->city;
		} else if (! empty($geodirectory->location->region)) {
			$location_name = $geodirectory->location->region;
		} else if (! empty($geodirectory->location->country)) {
			$location_name = __($geodirectory->location->country, 'geodirectory');
		} else {
			$location_set = false;
		}

		$icon_class         = ! empty($args['icon_class']) ? esc_attr($args['icon_class']) : 'fas fa-map-marker-alt fa-lg text-primary';
		$args['icon_class'] = $icon_class;

		if ($location_set) {
			$mr   = $aui_bs5 ? ' me-1' : ' mr-1';
			$icon               = '<span class="hover-swap gdlmls-menu-icon '.$mr.'"><i class="'.$icon_class.' hover-content-original"></i><i class="fas fa-times hover-content c-pointer" title="'.__('Clear Location', 'geodirlocation').'" data-toggle="tooltip"></i></span> ';
			$args['text']       = esc_attr($location_name);
		}

		$link      = '#location-switcher';
		$link_text = esc_attr($location_name);
	} else if (substr($args['type'], 0, 3) === 'gd_') {
		$post_types = function_exists('geodir_get_posttypes') ? geodir_get_posttypes('options-plural') : '';
		if (! empty($post_types)) {
			foreach ($post_types as $cpt => $cpt_name) {
				if ($cpt === $args['type']) {
					$link      = get_post_type_archive_link($cpt);
					$link_text = $cpt_name;
				}
			}
		}
	} else if (substr($args['type'], 0, 7) === 'add_gd_') {
		$post_types = function_exists('geodir_get_posttypes') ? geodir_get_posttypes('options') : '';
		if (! empty($post_types)) {
			foreach ($post_types as $cpt => $cpt_name) {
				if ('add_'.$cpt === $args['type']) {
					$link = function_exists('geodir_add_listing_page_url') ? geodir_add_listing_page_url($cpt) : '';
					// translators: Custom Post Type name.
					$link_text = sprintf(__('Add %s', 'blockstrap-page-builder-blocks'), $cpt_name);
				}
			}
		}
	} else if ('uwp_login' === $args['type']) {
		$link        = function_exists('uwp_get_login_page_url') ? uwp_get_login_page_url() : '';
		$link_text   = __('Login', 'blockstrap-page-builder-blocks');
		$wrap_class .= ' uwp-login-link';
	} else if ('uwp_register' === $args['type']) {
		$link        = function_exists('uwp_get_register_page_url') ? uwp_get_register_page_url() : '';
		$link_text   = __('Register', 'blockstrap-page-builder-blocks');
		$wrap_class .= ' uwp-register-link';
	} else if ('uwp_forgot' === $args['type']) {
		$link        = function_exists('uwp_get_forgot_page_url') ? uwp_get_forgot_page_url() : '';
		$link_text   = __('Forgot Password', 'blockstrap-page-builder-blocks');
		$wrap_class .= ' uwp-forgot-password-link';
	} else if ('uwp_account' === $args['type']) {
		$link      = function_exists('uwp_get_account_page_url') ? uwp_get_account_page_url() : '';
		$link_text = __('Account', 'blockstrap-page-builder-blocks');
	} else if ('uwp_change_password' === $args['type']) {
		$link      = function_exists('uwp_get_change_page_url') ? uwp_get_change_page_url() : '';
		$link_text = __('Change password', 'blockstrap-page-builder-blocks');
	} else if ('uwp_profile' === $args['type']) {
		$link      = function_exists('uwp_get_profile_page_url') ? uwp_get_profile_page_url() : '';
		$link_text = __('Profile', 'blockstrap-page-builder-blocks');
	} else if ( 'uwp_logout' === $args['type'] ) {
		if ( class_exists( 'UsersWP_Templates', false ) ) {
			$uwp_templates = new UsersWP_Templates();
			$link = esc_url( $uwp_templates->uwp_logout_url() );
		} else {
			$link = esc_url( wp_logout_url() );
		}
		$link_text = __( 'Log out', 'blockstrap-page-builder-blocks' );
	}//end if

	// set link
	if ( isset( $link ) ) {
		$link_parts['link'] = $link;
	}

	// set text
	if ( isset( $link_text ) ) {
		$link_parts['text'] = $link_text;
	}

	// set icon
	if ( isset( $icon ) ) {
		$link_parts['icon'] = $icon;
	}

	// set icon_class
	//if ( isset( $link_parts['icon_class'] ) ) {
		$link_parts['icon_class'] = $args['icon_class'];
	//}

	// set link_attr
	if ( isset( $link_attr ) ) {
		$link_parts['link_attr'] = $link_attr;
	}

	// set wrap_class
	if ( isset( $wrap_class ) ) {
		$link_parts['wrap_class'] = $wrap_class;
	}

	return $link_parts;

}

/**
 * Retrieves and prepares a list of options for pages, excluding certain predefined pages.
 *
 * This function checks if the SD Template Page Options function exists and calls it if
 * available. Otherwise, it creates a list of root-level published pages excluding:
 * - The page set as the homepage.
 * - The page set as the posts page.
 *
 * The list of pages is sorted by post title in ascending order, and the number of pages
 * can be limited by a filter 'blockstrap_blocks_page_options_limit'.
 *
 * @return array Associative array of page options with the page ID as the key and page title as the value.
 * @global object $wpdb Global WordPress database access object.
 *
 * @global array $blockstrap_pbb_page_options Cached page options to avoid redundant database queries.
 */
function blockstrap_pbb_page_options($exclude_blog = true, $exclude_front = true, $parent_only = false ) {

	// Same function, lets not call it twice if we don't need to
	if(function_exists('sd_template_page_options') && $exclude_blog && $exclude_front) {
		return sd_template_page_options();
	}

	global $blockstrap_pbb_page_options, $wpdb;

	if ( ! empty( $blockstrap_pbb_page_options ) ) {
		return $blockstrap_pbb_page_options;
	}

	$exclude_pages = array();
	if ( $page_on_front = get_option( 'page_on_front' ) && $exclude_front ) {
		$exclude_pages[] = $page_on_front;
	}

	if ( $page_for_posts = get_option( 'page_for_posts' ) && $exclude_blog ) {
		$exclude_pages[] = $page_for_posts;
	}

	$exclude_pages_placeholders = '';
	if ( ! empty( $exclude_pages ) ) {
		// Sanitize the array of excluded pages and implode it for the SQL query
		$exclude_pages_placeholders = implode(',', array_fill(0, count($exclude_pages), '%d'));
	}

	// Prepare the base SQL query, including child_of = 0 (only root-level pages)
	$sql = "
		SELECT ID, post_title
		FROM $wpdb->posts
		WHERE post_type = 'page'
		AND post_status = 'publish'
	";

	if ($parent_only) {
		$sql .= " AND post_parent = 0 ";
	}

	// Add the exclusion if there are pages to exclude
	if ( ! empty( $exclude_pages ) ) {
		$sql .= " AND ID NOT IN ($exclude_pages_placeholders)";
	}

	// Add sorting
	$sql .= " ORDER BY post_title ASC";

	// add a limit so we don't break
	$limit = apply_filters('blockstrap_blocks_page_options_limit',200);
	if ($limit) {
		$sql .= $wpdb->prepare(" LIMIT %d", $limit);
	}

	// Prepare the SQL query to include the excluded pages only if we have placeholders.
	$pages = $exclude_pages_placeholders ? $wpdb->get_results( $wpdb->prepare( $sql, ...$exclude_pages ) ) : $wpdb->get_results( $sql );

	$options = array( '' => __( 'Select Page...', 'blockstrap-page-builder-blocks' ) );
	if ( ! empty( $pages ) ) {
		foreach ( $pages as $page ) {
			if ( ! empty( $page->ID ) && ! empty( $page->post_title ) ) {
				$options[ $page->ID ] = $page->post_title . ' (#' . $page->ID . ')';
			}
		}
	}

	$blockstrap_pbb_page_options = $options;

	return $options;
}
