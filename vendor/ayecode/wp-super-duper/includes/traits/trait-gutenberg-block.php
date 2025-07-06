<?php
/**
 * WP Super Duper Gutenberg Block Trait
 *
 * This trait contains all methods for creating and managing the dynamic
 * Gutenberg block, including the JavaScript generation for block registration,
 * controls, and previews.
 *
 * @version 1.2.25
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait WP_Super_Duper_Gutenberg_Block {

	/**
	 * Add the dynamic block code inline when the wp-blocks script is enqueued.
	 */
	public function register_block() {
		wp_add_inline_script( 'wp-blocks', $this->block() );
		if ( class_exists( 'SiteOrigin_Panels' ) ) {
			wp_add_inline_script( 'wp-blocks', self::siteorigin_js() );
		}
	}

	/**
	 * Check if we need to show advanced options for the block.
	 *
	 * @return bool True if any argument is marked as advanced.
	 */
	public function block_show_advanced() {
		$arguments = $this->get_arguments();
		if ( ! empty( $arguments ) ) {
			foreach ( $arguments as $argument ) {
				if ( isset( $argument['advanced'] ) && $argument['advanced'] ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Generate the block icon, enabling Font Awesome support.
	 *
	 * @param string $icon The icon class or Dashicon slug.
	 *
	 * @return string The JS representation of the icon.
	 */
	public function get_block_icon( $icon ) {
		$fa_type = '';
		if ( strpos( $icon, 'fas fa-' ) === 0 ) {
			$fa_type = 'solid';
		} elseif ( strpos( $icon, 'far fa-' ) === 0 ) {
			$fa_type = 'regular';
		} elseif ( strpos( $icon, 'fab fa-' ) === 0 ) {
			$fa_type = 'brands';
		} else {
			return "'" . esc_js( $icon ) . "'";
		}

		if ( $fa_type ) {
			$fa_icon  = str_replace( array( "fas fa-", "far fa-", "fab fa-" ), "", $icon );
			$icon_url = $this->get_url() . "icons/" . $fa_type . ".svg#" . $fa_icon;

			return "el('svg',{width: 20, height: 20, viewBox: '0 0 20 20'},el('use', {'xlink:href': '" . esc_js( $icon_url ) . "','href': '" . esc_js( $icon_url ) . "'}))";
		}

		return "'" . esc_js( $icon ) . "'";
	}

	/**
	 * Group arguments by the 'group' key for creating panels in the block editor.
	 *
	 * @param array $arguments The arguments to group.
	 *
	 * @return array The grouped arguments.
	 */
	public function group_arguments( $arguments ) {
		if ( ! empty( $arguments ) ) {
			$temp_arguments = array();
			$general        = __( "General", 'ayecode-connect' );
			$add_sections   = false;
			foreach ( $arguments as $key => $args ) {
				if ( isset( $args['group'] ) ) {
					$temp_arguments[ $args['group'] ][ $key ] = $args;
					$add_sections                             = true;
				} else {
					$temp_arguments[ $general ][ $key ] = $args;
				}
			}
			if ( $add_sections ) {
				return $temp_arguments;
			}
		}

		return $arguments;
	}

	public function group_block_tabs( $tabs, $arguments ) {
		if ( ! empty( $tabs ) && ! empty( $arguments ) ) {
			$has_sections = false;

			foreach ( $this->arguments as $key => $args ) {
				if ( isset( $args['group'] ) ) {
					$has_sections = true;
					break;
				}
			}

			if ( ! $has_sections ) {
				return $tabs;
			}

			$new_tabs = array();

			foreach ( $tabs as $tab_key => $tab ) {
				$new_groups = array();

				if ( ! empty( $tab['groups'] ) && is_array( $tab['groups'] ) ) {
					foreach ( $tab['groups'] as $group ) {
						if ( isset( $arguments[ $group ] ) ) {
							$new_groups[] = $group;
						}
					}
				}

				if ( ! empty( $new_groups ) ) {
					$tab['groups'] = $new_groups;

					$new_tabs[ $tab_key ] = $tab;
				}
			}

			$tabs = $new_tabs;
		}

		return $tabs;
	}

	public function block_row_start( $key, $args ) {
		// check for row
		if ( ! empty( $args['row'] ) ) {

			if ( ! empty( $args['row']['open'] ) ) {

				// element require
				$element_require     = ! empty( $args['element_require'] ) ? $this->block_props_replace( $args['element_require'], true ) . " && " : "";
				$device_type         = ! empty( $args['device_type'] ) ? esc_attr( $args['device_type'] ) : '';
				$device_type_require = ! empty( $args['device_type'] ) ? " deviceType == '" . esc_attr( $device_type ) . "' && " : '';
				$device_type_icon    = '';
				if ( $device_type == 'Desktop' ) {
					$device_type_icon = '<span class="dashicons dashicons-desktop" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
				} elseif ( $device_type == 'Tablet' ) {
					$device_type_icon = '<span class="dashicons dashicons-tablet" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
				} elseif ( $device_type == 'Mobile' ) {
					$device_type_icon = '<span class="dashicons dashicons-smartphone" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
				}
				echo $element_require;
				echo $device_type_require;

			if ( false ){
				?>
				<script><?php }?>
					el('div', {
							className: 'bsui components-base-control',
						},
						<?php if(! empty( $args['row']['title'] )){ ?>
						el('label', {
								className: 'components-base-control__label position-relative',
								style: {width: "100%"}
							},
							el('span', {dangerouslySetInnerHTML: {__html: '<?php echo addslashes( $args['row']['title'] ) ?>'}}),
							<?php if($device_type_icon){ ?>
							deviceType == '<?php echo $device_type;?>' && el('span', {
								dangerouslySetInnerHTML: {__html: '<?php echo $device_type_icon; ?>'},
								title: deviceType + ": Set preview mode to change",
								style: {right: "0", position: "absolute", color: "var(--wp-admin-theme-color)"}
							})
							<?php
							}
							?>


						),
						<?php }?>
						<?php if(! empty( $args['row']['desc'] )){ ?>
						el('p', {
								className: 'components-base-control__help mb-0',
							},
							'<?php echo addslashes( $args['row']['desc'] ); ?>'
						),
						<?php }?>
						el(
							'div',
							{
								className: 'row mb-n2 <?php if ( ! empty( $args['row']['class'] ) ) {
									echo esc_attr( $args['row']['class'] );
								} ?>',
							},
							el(
								'div',
								{
									className: 'col pr-2 pe-2',
								},

					<?php
					if ( false ){
					?></script><?php }
			} elseif ( ! empty( $args['row']['close'] ) ) {
			if ( false ){
				?>
				<script><?php }?>
					el(
						'div',
						{
							className: 'col pl-0 ps-0',
						},
					<?php
					if ( false ){
					?></script><?php }
			} else {
			if ( false ){
				?>
				<script><?php }?>
					el(
						'div',
						{
							className: 'col pl-0 ps-0 pr-2 pe-2',
						},
					<?php
					if ( false ){
					?></script><?php }
			}

		}
	}

	public function block_row_end( $key, $args ) {

		if ( ! empty( $args['row'] ) ) {
			// maybe close
			if ( ! empty( $args['row']['close'] ) ) {
				echo "))";
			}

			echo "),";
		}
	}

	public function block_tab_start( $key, $args ) {

		// check for row
		if ( ! empty( $args['tab'] ) ) {

			if ( ! empty( $args['tab']['tabs_open'] ) ) {

			if ( false ){
				?>
				<script><?php }?>

					el('div', {className: 'bsui'},

						el('hr', {className: 'm-0'}), el(
							wp.components.TabPanel,
							{
								activeClass: 'is-active',
								className: 'btn-groupx',
								initialTabName: '<?php echo addslashes( esc_attr( $args['tab']['key'] ) ); ?>',
								tabs: [

					<?php
					if ( false ){
					?></script><?php }
			}

			if ( ! empty( $args['tab']['open'] ) ) {

			if ( false ){
				?>
				<script><?php }?>
					{
						name: '<?php echo addslashes( esc_attr( $args['tab']['key'] ) ); ?>',
							title
					:
						el('div', {dangerouslySetInnerHTML: {__html: '<?php echo addslashes( esc_attr( $args['tab']['title'] ) ); ?>'}}),
							className
					:
						'<?php echo addslashes( esc_attr( $args['tab']['class'] ) ); ?>',
							content
					:
						el('div', {}, <?php if(! empty( $args['tab']['desc'] )){ ?>el('p', {
							className: 'components-base-control__help mb-0',
							dangerouslySetInnerHTML: {__html: '<?php echo addslashes( $args['tab']['desc'] ); ?>'}
						}),<?php }
					if ( false ){
					?></script><?php }
			}

		}

	}

	public function block_tab_end( $key, $args ) {

		if ( ! empty( $args['tab'] ) ) {
			// maybe close
			if ( ! empty( $args['tab']['close'] ) ) {
				echo ")}, /* tab close */";
			}

			if ( ! empty( $args['tab']['tabs_close'] ) ) {
					if(false){?><script><?php }?>
						]}, ( tab ) => {
								return tab.content;
							}
						)), /* tabs close */
					<?php if(false){ ?></script><?php }
				}
		}
	}

	public function build_block_arguments( $key, $args ) {
		$custom_attributes = ! empty( $args['custom_attributes'] ) ? $this->array_to_attributes( $args['custom_attributes'] ) : '';
		$options           = '';
		$extra             = '';
		$suffix            = '';
		$require           = '';
		$inside_elements   = '';
		$after_elements    = '';

		// `content` is a protected and special argument
		if ( $key == 'content' ) {
			return;
		}

		$device_type         = ! empty( $args['device_type'] ) ? esc_attr( $args['device_type'] ) : '';
		$device_type_require = ! empty( $args['device_type'] ) ? " deviceType == '" . esc_attr( $device_type ) . "' && " : '';
		$device_type_icon    = '';
		if ( $device_type == 'Desktop' ) {
			$device_type_icon = '<span class="dashicons dashicons-desktop" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
		} elseif ( $device_type == 'Tablet' ) {
			$device_type_icon = '<span class="dashicons dashicons-tablet" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
		} elseif ( $device_type == 'Mobile' ) {
			$device_type_icon = '<span class="dashicons dashicons-smartphone" style="font-size: 18px;" onclick="sd_show_view_options(this);"></span>';
		}

		// icon
		$icon = '';
		if ( ! empty( $args['icon'] ) ) {
			$icon .= "el('div', {";
			$icon .= "dangerouslySetInnerHTML: {__html: '" . self::get_widget_icon( esc_attr( $args['icon'] ) ) . "'},";
			$icon .= "className: 'text-center',";
			$icon .= "title: '" . addslashes( $args['title'] ) . "',";
			$icon .= "}),";

			// blank title as its added to the icon.
			$args['title'] = '';
		}

		// require advanced
		$require_advanced = ! empty( $args['advanced'] ) ? "props.attributes.show_advanced && " : "";

		// element require
		$element_require = ! empty( $args['element_require'] ) ? $this->block_props_replace( $args['element_require'], true ) . " && " : "";


		$onchange = "props.setAttributes({ $key: $key })"; // Base onchange

		// Check for our new custom parameter
		if ( ! empty( $args['clears_on_change'] ) && is_array( $args['clears_on_change'] ) ) {

			$clear_logic_js = "const attrsToClear = {};";
			$clear_logic_js .= "switch($key) {";

			foreach ( $args['clears_on_change'] as $case_value => $attrs_to_clear ) {
				if ( $case_value === 'default_case' ) {
					continue;
				}
				$clear_logic_js .= " case '" . esc_js( $case_value ) . "': ";
				foreach ( $attrs_to_clear as $attr_name ) {
					$clear_logic_js .= "attrsToClear['" . esc_js( $attr_name ) . "'] = undefined; ";
				}
				$clear_logic_js .= " break;";
			}

			// Add the default case
			if ( isset( $args['clears_on_change']['default_case'] ) ) {
				$clear_logic_js .= " default: ";
				foreach ( $args['clears_on_change']['default_case'] as $attr_name ) {
					$clear_logic_js .= "attrsToClear['" . esc_js( $attr_name ) . "'] = undefined; ";
				}
				$clear_logic_js .= " break;";
			}

			$clear_logic_js .= "}";
			$clear_logic_js .= "props.setAttributes(attrsToClear);";

			// Prepend the clearing logic to the original onChange
			$onchange = $onchange . '; ' . $clear_logic_js;
		}


		$onchangecomplete = "";
		$value            = "props.attributes.$key";
		$text_type        = array( 'text', 'password', 'number', 'email', 'tel', 'url', 'colorx', 'range' );
		if ( in_array( $args['type'], $text_type ) ) {
			$type = 'TextControl';
			// Save numbers as numbers and not strings
			if ( $args['type'] == 'number' ) {
				$onchange = "props.setAttributes({ $key: $key ? Number($key) : '' } )";
			}

			if ( substr( $key, 0, 9 ) === 'metadata_' ) {
				$real_key = str_replace( 'metadata_', '', $key );
				$onchange = "props.setAttributes({ metadata: { $real_key: $key } } )";
				$value    = "props.attributes.metadata && props.attributes.metadata.$real_key ? props.attributes.metadata.$real_key : ''";
			}

			// Maybe add the icon picker
			if ( ! empty( $args['icon_picker'] ) ) {
				$type   = 'InputControl';
				$suffix .= " el(
						window.auiBlockTools.IconPickerButton,
						{
							value: props.attributes." . esc_js( $key ) . ",
							setAttributes: props.setAttributes,
							attributeName: '" . esc_js( $key ) . "',
							uniqueId: '" . esc_js( $key ) . "'
						}
					),";
			}


			// Maybe add the dynamic data picker
			if ( ! empty( $args['dynamic_data'] ) ) {
				$type   = 'InputControl';
				$suffix .= "el(
    window.auiBlockTools.DynamicDataButton,
    {
        onSelect: function(dataTag) {
            // This function runs when a tag is selected from the modal

            // 1. Get the current value of the specific attribute we want to change
            var currentText = props.attributes." . esc_js( $key ) . " || '';

            // 2. Create the new value by appending the tag
            var newText = currentText + ' ' + dataTag;

            // 3. Create a new attributes object to avoid mutation issues
            var newAttributes = {};
            newAttributes['" . esc_js( $key ) . "'] = newText;

            // 4. Call setAttributes with the updated value
            props.setAttributes(newAttributes);
        }
    }
),";
			}
		}
//			else if ( $args['type'] == 'popup' ) {
//				$type = 'TextControl';
//				$args['type'] == 'text';
//				$after_elements .= "el( wp.components.Button, {
//                          className: 'components-button components-circular-option-picker__clear is-primary is-smallx',
//                          onClick: function(){
//							  aui_modal('','<input id=\'zzz\' value= />');
//							  const source = document.getElementById('zzz');
//							  source.value = props.attributes.$key;
//							  source.addEventListener('input', function(e){props.setAttributes({ $key: e.target.value });});
//                          }
//                        },
//                        'test'
//                        ),";
//
//				$value     = "props.attributes.$key ? props.attributes.$key : ''";
//			}
		else if ( $args['type'] == 'styleid' ) {
			$type = 'TextControl';
			$args['type'] == 'text';
			// Save numbers as numbers and not strings
			$value = "props.attributes.$key ? props.attributes.$key : ''";
		} else if ( $args['type'] == 'notice' ) {

			$notice_message = ! empty( $args['desc'] ) ? addslashes( $args['desc'] ) : '';
			$notice_status  = ! empty( $args['status'] ) ? esc_attr( $args['status'] ) : 'info';

			$notice = "el('div',{className:'bsui'},el(wp.components.Notice, {status: '$notice_status',isDismissible: false,className: 'm-0 pr-0 pe-0 mb-3'},el('div',{dangerouslySetInnerHTML: {__html: '$notice_message'}}))),";
			echo $notice_message ? $element_require . $notice : '';

			return;
		} elseif ( $args['type'] == 'color' ) {
			$type     = 'ColorPicker';
			$onchange = "";
			$extra    = "color: $value,";
			if ( ! empty( $args['disable_alpha'] ) ) {
				$extra .= "disableAlpha: true,";
			}
			$onchangecomplete = "onChangeComplete: function($key) {
				value =  $key.rgb.a && $key.rgb.a < 1 ? \"rgba(\"+$key.rgb.r+\",\"+$key.rgb.g+\",\"+$key.rgb.b+\",\"+$key.rgb.a+\")\" : $key.hex;
						props.setAttributes({
							$key: value
						});
					},";
		} elseif ( $args['type'] == 'gradient' ) {
			$type  = 'GradientPicker';
			$extra .= "gradients: [{
			name: 'Vivid cyan blue to vivid purple',
			gradient:
				'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)',
			slug: 'vivid-cyan-blue-to-vivid-purple',
		},
		{
			name: 'Light green cyan to vivid green cyan',
			gradient:
				'linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%)',
			slug: 'light-green-cyan-to-vivid-green-cyan',
		},
		{
			name: 'Luminous vivid amber to luminous vivid orange',
			gradient:
				'linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%)',
			slug: 'luminous-vivid-amber-to-luminous-vivid-orange',
		},
		{
			name: 'Luminous vivid orange to vivid red',
			gradient:
				'linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%)',
			slug: 'luminous-vivid-orange-to-vivid-red',
		},
		{
			name: 'Very light gray to cyan bluish gray',
			gradient:
				'linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%)',
			slug: 'very-light-gray-to-cyan-bluish-gray',
		},
		{
			name: 'Cool to warm spectrum',
			gradient:
				'linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%)',
			slug: 'cool-to-warm-spectrum',
		}],";

		} elseif ( $args['type'] == 'image' ) {
//                print_r($args);

			$img_preview = isset( $args['focalpoint'] ) && ! $args['focalpoint'] ? " props.attributes.$key && el('img', { src: props.attributes.$key,style: {maxWidth:'100%',background: '#ccc'}})," : " ( props.attributes.$key ||  props.attributes.{$key}_use_featured ) && el(wp.components.FocalPointPicker,{
							url:  props.attributes.{$key}_use_featured === true ? 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiID8+CjxzdmcgYmFzZVByb2ZpbGU9InRpbnkiIGhlaWdodD0iNDAwIiB2ZXJzaW9uPSIxLjIiIHdpZHRoPSI0MDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6ZXY9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEveG1sLWV2ZW50cyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxkZWZzIC8+PHJlY3QgZmlsbD0iI2QzZDNkMyIgaGVpZ2h0PSI0MDAiIHdpZHRoPSI0MDAiIHg9IjAiIHk9IjAiIC8+PGxpbmUgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxMCIgeDE9IjAiIHgyPSI0MDAiIHkxPSIwIiB5Mj0iNDAwIiAvPjxsaW5lIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMTAiIHgxPSIwIiB4Mj0iNDAwIiB5MT0iNDAwIiB5Mj0iMCIgLz48cmVjdCBmaWxsPSIjZDNkM2QzIiBoZWlnaHQ9IjUwIiB3aWR0aD0iMjE4LjAiIHg9IjkxLjAiIHk9IjE3NS4wIiAvPjx0ZXh0IGZpbGw9IndoaXRlIiBmb250LXNpemU9IjMwIiBmb250LXdlaWdodD0iYm9sZCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMjAwLjAiIHk9IjIwNy41Ij5QTEFDRUhPTERFUjwvdGV4dD48L3N2Zz4='  : props.attributes.$key,
							value: props.attributes.{$key}_xy.x !== undefined && props.attributes.{$key}_xy.x >= 0 ? props.attributes.{$key}_xy  : {x: 0.5,y: 0.5,},
//                            value: props.attributes.{$key}_xy,
							onChange: function(focalPoint){
							console.log(props.attributes);
											  return props.setAttributes({
												  {$key}_xy: focalPoint
												});
									},
									// @todo for some reason this does not work as expected.
//                         onDrag: function(focalPointTemp){
//                                  return props.setAttributes({
//                                      {$key}_xy: focalPointTemp
//                                    });
//                        }


						}), ";


			$value    = '""';
			$type     = 'MediaUpload';
			$extra    .= "onSelect: function(media){
					  return props.setAttributes({
						  $key: media.url,
						  {$key}_id: media.id
						});
					  },";
			$extra    .= "type: 'image',";
			$extra    .= "render: function (obj) {
						return el( 'div',{},
						( !props.attributes.$key && !props.attributes.{$key}_use_featured ) && el( wp.components.Button, {
						  className: 'components-button components-circular-option-picker__clear is-primary is-smallx',
						  onClick: obj.open
						},
						'Upload Image'
						),
					   $img_preview
						props.attributes.$key && el( wp.components.Button, {
									  className: 'components-button components-circular-option-picker__clear is-secondary is-small',
									  style: {margin:'8px 0',display: 'block'},
									  onClick: function(){
											  return props.setAttributes({
												  $key: '',
												  {$key}_id: ''
												});
									}
									},
									props.attributes.$key? 'Clear' : ''
							)
					   )



					  }";
			$onchange = "";

			//$inside_elements = ",el('div',{},'file upload')";
		} else if ( $args['type'] == 'images' ) {
			$img_preview = "props.attributes.$key && (function() {
	let uploads = JSON.parse('['+props.attributes.$key+']');
	let images = [];
	uploads.map((upload, index) => (
		images.push( el('div',{ className: 'col p-2', draggable: 'true', 'data-index': index },
			el('img', {
				src: (upload.sizes && upload.sizes.thumbnail ? upload.sizes.thumbnail.url : upload.url),
				style: { maxWidth:'100%', background: '#ccc', pointerEvents:'none' }
			}),
			el('i',{
				className: 'fas fa-times-circle text-danger position-absolute  ml-n2 mt-n1 bg-white rounded-circle c-pointer',
				onClick: function() {
					aui_confirm('" . esc_attr__( 'Are you sure?' ) . "', '" . esc_attr__( 'Delete' ) . "', '" . esc_attr__( 'Cancel' ) . "', true).then(function(confirmed) {
						if (confirmed) {
							let new_uploads = JSON.parse('['+props.attributes.$key+']');
							new_uploads.splice(index, 1);
								return props.setAttributes({ {$key}: JSON.stringify( new_uploads ).replace('[','').replace(']','') });
							}
					});
				}},
			'')
		))
	));
	return images;
})(),";


			$value    = '""';
			$type     = 'MediaUpload';
			$extra    .= "onSelect: function(media){
	let slim_images = props.attributes.$key ? JSON.parse('['+props.attributes.$key+']') : [];
	if(media.length){
		for (var i=0; i < media.length; i++) {
			slim_images.push({id: media[i].id, caption: media[i].caption, description: media[i].description,title: media[i].title,alt: media[i].alt,sizes: media[i].sizes, url: media[i].url});
		}
	}
	var slimImagesV = JSON.stringify(slim_images);
	if (slimImagesV) {
		slimImagesV = slimImagesV.replace('[','').replace(']','').replace(/'/g, '&#39;');
	}
	return props.setAttributes({ $key: slimImagesV});
},";
			$extra    .= "type: 'image',";
			$extra    .= "multiple: true,";
			$extra    .= "render: function (obj) {
	/* Init the sort */
	enableDragSort('sd-sortable');
	return el( 'div',{},
		el( wp.components.Button, {
				className: 'components-button components-circular-option-picker__clear is-primary is-smallx',
				onClick: obj.open
			},
			'Upload Images'
		),
		el('div',{
				className: 'row row-cols-3 px-2 sd-sortable',
				'data-field':'$key'
			},
			$img_preview
		),
		props.attributes.$key && el( wp.components.Button, {
				className: 'components-button components-circular-option-picker__clear is-secondary is-small',
				style: {margin:'8px 0'},
				onClick: function(){
					return props.setAttributes({ $key: '' });
				}
			},
			props.attributes.$key ? 'Clear All' : ''
		)
	)
}";
			$onchange = "";

			//$inside_elements = ",el('div',{},'file upload')";
		} elseif ( $args['type'] == 'checkbox' ) {
			$type     = 'CheckboxControl';
			$extra    .= "checked: props.attributes.$key,";
			$onchange = "props.setAttributes({ $key: ! props.attributes.$key } )";
		} elseif ( $args['type'] == 'textarea' ) {
			$type = 'TextareaControl';

		} elseif ( $args['type'] == 'select' || $args['type'] == 'multiselect' ) {
			$type = 'SelectControl';

			if ( $args['name'] == 'category' && ! empty( $args['post_type_linked'] ) ) {
				$options .= "options: taxonomies_" . str_replace( "-", "_", $this->id ) . ",";
			} elseif ( $args['name'] == 'sort_by' && ! empty( $args['post_type_linked'] ) ) {
				$options .= "options: sort_by_" . str_replace( "-", "_", $this->id ) . ",";
			} else {

				if ( ! empty( $args['options'] ) ) {
					$options .= "options: [";
					foreach ( $args['options'] as $option_val => $option_label ) {
						$options .= "{ value: '" . esc_attr( $option_val ) . "', label: '" . esc_js( addslashes( $option_label ) ) . "' },";
					}
					$options .= "],";
				}
			}
			if ( isset( $args['multiple'] ) && $args['multiple'] ) { //@todo multiselect does not work at the moment: https://github.com/WordPress/gutenberg/issues/5550
				$extra .= ' multiple:true,style:{height:"auto",paddingRight:"8px","overflow-y":"auto"}, ';
			}

			if ( $args['type'] == 'multiselect' || ( isset( $args['multiple'] ) && $args['multiple'] ) ) {
				$after_elements .= "props.attributes.$key && el( wp.components.Button, {
									  className: 'components-button components-circular-option-picker__clear is-secondary is-small',
									  style: {margin:'-8px 0 8px 0',display: 'block'},
									  onClick: function(){
											  return props.setAttributes({
												  $key: '',
												});
									}
									},
									'Clear'
							),";
			}
		} elseif ( $args['type'] == 'tagselect' ) {
//				$type = 'FormTokenField';
//
//				if ( ! empty( $args['options'] ) ) {
//						$options .= "suggestions: [";
//						foreach ( $args['options'] as $option_val => $option_label ) {
//							$options .= "{ value: '" . esc_attr( $option_val ) . "', title: '" . addslashes( $option_label ) . "' },";
////							$options .= "'" . esc_attr( $option_val ) . "':'" . addslashes( $option_label ) . "',";
//						}
//						$options .= "],";
//				}
//
//				$onchangex  = "{ ( selectedItems ) => {
//						// Build array of selected posts.
//						let selectedPostsArray = [];
//						selectedPosts.map(
//							( postName ) => {
//								const matchingPost = posts.find( ( post ) => {
//									return post.title.raw === postName;
//
//								} );
//								if ( matchingPost !== undefined ) {
//									selectedPostsArray.push( matchingPost.id );
//								}
//							}
//						)
//
//						setAttributes( { selectedPosts: selectedPostsArray } );
//					} } ";
//				$onchange  = '';// "props.setAttributes({ $key: [ props.attributes.$key ] } )";
//
////				$options  = "";
//				$value     = "[]";
//				$extra .= ' __experimentalExpandOnFocus: true,';

		} else if ( $args['type'] == 'alignment' ) {
			$type = 'AlignmentToolbar'; // @todo this does not seem to work but cant find a example
		} else if ( $args['type'] == 'margins' ) {

		} else if ( $args['type'] == 'visibility_conditions' && ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) ) {
			$type         = 'TextControl';
			$value        = "(props.attributes.$key ? props.attributes.$key : '')";
			$args['type'] = 'text';
			$options      .= 'disabled:true,';
			$bsvc_title   = esc_attr( addslashes( $args['title'] ) );
			$bsvc_body    = $this->block_visibility_fields( $args );
			// @TODO reset button
			$bsvc_footer    = '<button type="button" class="btn btn-danger d-none">' . __( 'Reset', 'ayecode-connect' ) . '</button><button type="button" class="btn btn-secondary bs-vc-close text-white" data-bs-dismiss="modal">' . __( 'Close', 'ayecode-connect' ) . '</button><button type="button" class="btn btn-primary bs-vc-save">' . __( 'Save Rules', 'ayecode-connect' ) . '</button>';
			$after_elements .= "el('div', {className: 'components-base-control bs-vc-button-wrap'}, el(wp.components.Button, {
						className: 'components-button components-circular-option-picker__clear is-primary is-smallx',
						onClick: function() {
							var sValue = props.attributes." . $key . ";
							var oValue;
							try {oValue = JSON.parse(sValue);} catch(err) {}
							jQuery(document).off('show.bs.modal', '.bs-vc-modal').on('show.bs.modal', '.bs-vc-modal', function (e) {
								if (e.target && jQuery(e.target).hasClass('bs-vc-modal')) {
									sd_block_visibility_render_fields(oValue);
									if (!jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule').length) {
										jQuery('.bs-vc-modal-form .bs-vc-add-rule').trigger('click');
									}
									if(typeof aui_init_select2 == 'function') {
										aui_init_select2();
									}
									jQuery('.bs-vc-modal-form').trigger('change');
								}
							});
							aui_modal('" . $bsvc_title . "', '" . addslashes( $bsvc_body ) . "', '" . $bsvc_footer . "', true, 'bs-vc-modal', 'modal-lg', '');
							jQuery(document).off('change', '#bsvc_raw_value').on('change', '#bsvc_raw_value', function(e) {
								props.setAttributes({" . $key . ": e.target.value});
							});
						}
					},
					'" . addslashes( ! empty( $args['button_title'] ) ? $args['button_title'] : $args['title'] ) . "'
				) ),";
		} else {
			return;// if we have not implemented the control then don't break the JS.
		}

		// color input does not show the labels so we add them
		if ( $args['type'] == 'color' ) {
			// add show only if advanced
			echo $require_advanced;
			// add setting require if defined
			echo $element_require;
			echo "el('div', {style: {'marginBottom': '8px'}}, '" . addslashes( $args['title'] ) . "'),";
		}

		// add show only if advanced
		echo $require_advanced;
		// add setting require if defined
		echo $element_require;
		echo $device_type_require;

		// icon
		echo $icon;


		// maybe we need a suffix
		if ( $suffix ) {
			$extra .= "suffix: el('span', { style: {
            display: 'flex',
	        }}, $suffix),";
		}
		?>
		el( <?php echo $args['type'] == 'image' || $args['type'] == 'images' ? $type : "wp.components." . $type; ?>, {
		label: <?php if ( empty( $args['title'] ) ) {
			echo "''";
		} else if ( empty( $args['row'] ) && ! empty( $args['device_type'] ) ) { ?>el('label',{className:'components-base-control__label',style:{width:"100%"}},el('span',{dangerouslySetInnerHTML: {__html: '<?php echo addslashes( $args['title'] ) ?>'}}),<?php if ( $device_type_icon ) { ?>deviceType == '<?php echo $device_type; ?>' && el('span',{dangerouslySetInnerHTML: {__html: '<?php echo $device_type_icon; ?>'},title: deviceType + ": Set preview mode to change",style: {right:"0",position:"absolute",color:"var(--wp-admin-theme-color)"}})<?php } ?>)<?php
		} else { ?>'<?php echo addslashes( trim( esc_html( $args['title'] ) ) ); ?>'<?php } ?>,
		help: <?php echo( isset( $args['desc'] ) ? "el('span', {dangerouslySetInnerHTML: {__html: '" . trim( wp_kses_post( addslashes( $args['desc'] ) ) ) . "'}})" : "''" ); ?>,
		value: <?php echo $value; ?>,
		<?php if ( $type == 'TextControl' && $args['type'] != 'text' ) {
			echo "type: '" . addslashes( $args['type'] ) . "',";
		} ?>
		<?php if ( ! empty( $args['placeholder'] ) ) {
			echo "placeholder: '" . esc_js( addslashes( trim( esc_html( $args['placeholder'] ) ) ) ) . "',";
		} ?>
		<?php echo $options; ?>
		<?php echo $extra; ?>
		<?php echo $custom_attributes; ?>
		<?php echo $onchangecomplete; ?>
		<?php if ( $onchange ) { ?>
			onChange: function ( <?php echo $key; ?> ) {
			<?php echo $onchange; ?>
			}
		<?php } ?>
		} <?php echo $inside_elements; ?> ),
		<?php
		echo $after_elements;
	}

	/**
	 * A self looping function to create the output for JS block elements.
	 *
	 * This is what is output in the WP Editor visual view.
	 *
	 * @param $args
	 */
	public function block_element( $args, $save = false ) {

//            print_r($args);echo '###';exit;

		if ( ! empty( $args ) ) {
			foreach ( $args as $element => $new_args ) {

				if ( is_array( $new_args ) ) { // its an element


					if ( isset( $new_args['element'] ) ) {

						if ( isset( $new_args['element_require'] ) ) {
							echo str_replace( array(
									"'+",
									"+'"
								), '', $this->block_props_replace( $new_args['element_require'] ) ) . " &&  ";
							unset( $new_args['element_require'] );
						}

						if ( $new_args['element'] == 'InnerBlocks' ) {
							echo "\n el( InnerBlocks, {";
						} elseif ( $new_args['element'] == 'innerBlocksProps' ) {
							$element = isset( $new_args['inner_element'] ) ? esc_attr( $new_args['inner_element'] ) : 'div';
							//  echo "\n el( 'section', wp.blockEditor.useInnerBlocksProps( blockProps, {";
//                                echo $save ? "\n el( '$element', wp.blockEditor.useInnerBlocksProps.save( " : "\n el( '$element', wp.blockEditor.useInnerBlocksProps( ";
							echo $save ? "\n el( '$element', wp.blockEditor.useInnerBlocksProps.save( " : "\n el( '$element', wp.blockEditor.useInnerBlocksProps( ";
							echo $save ? "wp.blockEditor.useBlockProps.save( {" : "wp.blockEditor.useBlockProps( {";
							echo ! empty( $new_args['blockProps'] ) ? $this->block_element( $new_args['blockProps'], $save ) : '';

							echo "} ), {";
							echo ! empty( $new_args['innerBlocksProps'] ) && ! $save ? $this->block_element( $new_args['innerBlocksProps'], $save ) : '';
							//    echo '###';

							//  echo '###';
						} elseif ( $new_args['element'] == 'BlocksProps' ) {

							if ( isset( $new_args['if_inner_element'] ) ) {
								$element = $new_args['if_inner_element'];
							} else {
								$element = isset( $new_args['inner_element'] ) ? "'" . esc_attr( $new_args['inner_element'] ) . "'" : "'div'";
							}

							unset( $new_args['inner_element'] );
							echo $save ? "\n el( $element, wp.blockEditor.useBlockProps.save( {" : "\n el( $element, wp.blockEditor.useBlockProps( {";
							echo ! empty( $new_args['blockProps'] ) ? $this->block_element( $new_args['blockProps'], $save ) : '';


							// echo "} ),";

						} else {
							echo "\n el( '" . $new_args['element'] . "', {";
						}


						// get the attributes
						foreach ( $new_args as $new_key => $new_value ) {


							if ( $new_key == 'element' || $new_key == 'content' || $new_key == 'if_content' || $new_key == 'element_require' || $new_key == 'element_repeat' || is_array( $new_value ) ) {
								// do nothing
							} else {
								echo $this->block_element( array( $new_key => $new_value ), $save );
							}
						}

						echo $new_args['element'] == 'BlocksProps' ? '} ),' : "},";// end attributes

						// get the content
						$first_item = 0;
						foreach ( $new_args as $new_key => $new_value ) {
							if ( $new_key === 'content' || $new_key === 'if_content' || is_array( $new_value ) ) {

								if ( $new_key === 'content' ) {
									echo "'" . $this->block_props_replace( wp_slash( $new_value ) ) . "'";
								} else if ( $new_key === 'if_content' ) {
									echo $this->block_props_replace( $new_value );
								}

								if ( is_array( $new_value ) ) {

									if ( isset( $new_value['element_require'] ) ) {
										echo str_replace( array(
												"'+",
												"+'"
											), '', $this->block_props_replace( $new_value['element_require'] ) ) . " &&  ";
										unset( $new_value['element_require'] );
									}

									if ( isset( $new_value['element_repeat'] ) ) {
										$x = 1;
										while ( $x <= absint( $new_value['element_repeat'] ) ) {
											$this->block_element( array( '' => $new_value ), $save );
											$x ++;
										}
									} else {
										$this->block_element( array( '' => $new_value ), $save );
									}
								}
								$first_item ++;
							}
						}

						if ( $new_args['element'] == 'innerBlocksProps' || $new_args['element'] == 'xBlocksProps' ) {
							echo "))";// end content
						} else {
							echo ")";// end content
						}


						echo ", \n";

					}
				} else {

					if ( substr( $element, 0, 3 ) === "if_" ) {
						$extra = '';
						if ( strpos( $new_args, '[%WrapClass%]' ) !== false ) {
							$new_args = str_replace( '[%WrapClass%]"', '" + sd_build_aui_class(props.attributes)', $new_args );
							$new_args = str_replace( '[%WrapClass%]', '+ sd_build_aui_class(props.attributes)', $new_args );
						}
						echo str_replace( "if_", "", $element ) . ": " . $this->block_props_replace( $new_args, true ) . ",";
					} elseif ( $element == 'style' && strpos( $new_args, '[%WrapStyle%]' ) !== false ) {
						$new_args = str_replace( '[%WrapStyle%]', '', $new_args );
						echo $element . ": {..." . $this->block_props_replace( $new_args ) . " , ...sd_build_aui_styles(props.attributes) },";
//                            echo $element . ": " . $this->block_props_replace( $new_args ) . ",";
					} elseif ( $element == 'style' ) {
						echo $element . ": " . $this->block_props_replace( $new_args ) . ",";
					} elseif ( ( $element == 'class' || $element == 'className' ) && strpos( $new_args, '[%WrapClass%]' ) !== false ) {
						$new_args = str_replace( '[%WrapClass%]', '', $new_args );
						echo $element . ": '" . $this->block_props_replace( $new_args ) . "' + sd_build_aui_class(props.attributes),";
					} elseif ( $element == 'template' && $new_args ) {
						echo $element . ": $new_args,";
					} else {
						echo $element . ": '" . $this->block_props_replace( $new_args ) . "',";
					}

				}
			}
		}
	}

	public function block_visibility_fields( $args ) {
		$value   = ! empty( $args['value'] ) ? esc_attr( $args['value'] ) : '';
		$content = '<div class="bs-vc-rule-template d-none">';
		$content .= '<div class="p-3 pb-0 mb-3 border border-1 rounded-1 position-relative bs-vc-rule" data-bs-index="BSVCINDEX" >';
		$content .= '<div class="row">';
		$content .= '<div class="col-sm-12">';
		$content .= '<div class="bs-rule-action position-absolute top-0 end-0 p-2 zindex-5"><span class="text-danger c-pointer bs-vc-remove-rule" title="' . esc_attr__( 'Remove Rule', 'ayecode-connect' ) . '"><i class="fas fa-circle-minus fs-6"></i></span></div>';
		$content .= aui()->select(
			array(
				'id'               => 'bsvc_rule_BSVCINDEX',
				'name'             => 'bsvc_rule_BSVCINDEX',
				'label'            => __( 'Rule', 'ayecode-connect' ),
				'placeholder'      => __( 'Select Rule...', 'ayecode-connect' ),
				'class'            => 'bsvc_rule form-select-sm no-select2 mw-100',
				'options'          => sd_visibility_rules_options(),
				'default'          => '',
				'value'            => '',
				'label_type'       => '',
				'select2'          => false,
				'input_group_left' => __( 'Rule:', 'ayecode-connect' ),
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= '</div>';

		if ( class_exists( 'GeoDirectory' ) ) {
			$content .= '<div class="col-md-7 col-sm-12">';

			$content .= aui()->select(
				array(
					'id'               => 'bsvc_gd_field_BSVCINDEX',
					'name'             => 'bsvc_gd_field_BSVCINDEX',
					'label'            => __( 'FIELD', 'ayecode-connect' ),
					'placeholder'      => __( 'FIELD', 'ayecode-connect' ),
					'class'            => 'bsvc_gd_field form-select-sm no-select2 mw-100',
					'options'          => sd_visibility_gd_field_options(),
					'default'          => '',
					'value'            => '',
					'label_type'       => '',
					'select2'          => false,
					'element_require'  => '[%bsvc_rule_BSVCINDEX%]=="gd_field"',
					'extra_attributes' => array(
						'data-minimum-results-for-search' => '-1'
					)
				)
			);

			$content .= '</div>';
			$content .= '<div class="col-md-5 col-sm-12">';

			$content .= aui()->select(
				array(
					'id'               => 'bsvc_gd_field_condition_BSVCINDEX',
					'name'             => 'bsvc_gd_field_condition_BSVCINDEX',
					'label'            => __( 'CONDITION', 'ayecode-connect' ),
					'placeholder'      => __( 'CONDITION', 'ayecode-connect' ),
					'class'            => 'bsvc_gd_field_condition form-select-sm no-select2 mw-100',
					'options'          => sd_visibility_field_condition_options(),
					'default'          => '',
					'value'            => '',
					'label_type'       => '',
					'select2'          => false,
					'element_require'  => '[%bsvc_rule_BSVCINDEX%]=="gd_field"',
					'extra_attributes' => array(
						'data-minimum-results-for-search' => '-1'
					)
				)
			);

			$content .= '</div>';
			$content .= '<div class="col-sm-12">';

			$content .= aui()->input(
				array(
					'type'            => 'text',
					'id'              => 'bsvc_gd_field_search_BSVCINDEX',
					'name'            => 'bsvc_gd_field_search_BSVCINDEX',
					'label'           => __( 'VALUE TO MATCH', 'ayecode-connect' ),
					'class'           => 'bsvc_gd_field_search form-control-sm',
					'placeholder'     => __( 'VALUE TO MATCH', 'ayecode-connect' ),
					'label_type'      => '',
					'value'           => '',
					'element_require' => '([%bsvc_rule_BSVCINDEX%]=="gd_field" && [%bsvc_gd_field_condition_BSVCINDEX%] && [%bsvc_gd_field_condition_BSVCINDEX%]!="is_empty" && [%bsvc_gd_field_condition_BSVCINDEX%]!="is_not_empty")'
				)
			);

			$content .= '</div>';
		}

		$content .= apply_filters( 'sd_block_visibility_fields', '', $args );

		$content .= '</div>';

		$content      .= '<div class="row aui-conditional-field" data-element-require="jQuery(form).find(\'[name=bsvc_rule_BSVCINDEX]\').val()==\'user_roles\'" data-argument="bsvc_user_roles_BSVCINDEX_1"><label for="bsvc_user_roles_BSVCINDEX_1" class="form-label mb-3">' . __( 'Select User Roles:', 'ayecode-connect' ) . '</label>';
		$role_options = sd_user_roles_options();

		$role_option_i = 0;
		foreach ( $role_options as $role_option_key => $role_option_name ) {
			$role_option_i ++;

			$content .= '<div class="col-sm-6">';
			$content .= aui()->input(
				array(
					'id'         => 'bsvc_user_roles_BSVCINDEX_' . $role_option_i,
					'name'       => 'bsvc_user_roles_BSVCINDEX[]',
					'type'       => 'checkbox',
					'label'      => $role_option_name,
					'label_type' => 'hidden',
					'class'      => 'bsvc_user_roles',
					'value'      => $role_option_key,
					'switch'     => 'md',
					'no_wrap'    => true
				)
			);
			$content .= '</div>';
		}
		$content .= '</div>';
		$content .= '<div class="bs-vc-sep-wrap text-center position-absolute top-0 mt-n3"><div class="bs-vc-sep-cond d-inline-block badge text-dark bg-gray mt-1">' . esc_html__( 'AND', 'ayecode-connect' ) . '</div></div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '<form id="bs-vc-modal-form" class="bs-vc-modal-form">';
		$content .= '<div class="bs-vc-rule-sets"></div>';
		$content .= '<div class="row"><div class="col-sm-12 text-center pt-1 pb-4"><button type="button" class="btn btn-sm btn-primary d-block w-100 bs-vc-add-rule"><i class="fas fa-plus"></i> ' . __( 'Add Rule', 'ayecode-connect' ) . '</button></div></div>';
		$content .= '<div class="row"><div class="col-md-6 col-sm-12">';
		$content .= aui()->select(
			array(
				'id'               => 'bsvc_output',
				'name'             => 'bsvc_output',
				'label'            => __( 'What should happen if rules met.', 'ayecode-connect' ),
				'placeholder'      => __( 'Show Block', 'ayecode-connect' ),
				'class'            => 'bsvc_output form-select-sm no-select2 mw-100',
				'options'          => sd_visibility_output_options(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= '</div><div class="col-md-6 col-sm-12">';

		$content .= aui()->select(
			array(
				'id'              => 'bsvc_page',
				'name'            => 'bsvc_page',
				'label'           => __( 'Page Content', 'ayecode-connect' ),
				'placeholder'     => __( 'Select Page ID...', 'ayecode-connect' ),
				'class'           => 'bsvc_page form-select-sm no-select2 mw-100',
				'options'         => sd_template_page_options(),
				'default'         => '',
				'value'           => '',
				'label_type'      => 'top',
				'select2'         => false,
				'element_require' => '[%bsvc_output%]=="page"'
			)
		);

		$content .= aui()->select(
			array(
				'id'               => 'bsvc_tmpl_part',
				'name'             => 'bsvc_tmpl_part',
				'label'            => __( 'Template Part', 'ayecode-connect' ),
				'placeholder'      => __( 'Select Template Part...', 'ayecode-connect' ),
				'class'            => 'bsvc_tmpl_part form-select-sm no-select2 mw-100',
				'options'          => sd_template_part_options(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'element_require'  => '[%bsvc_output%]=="template_part"',
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= aui()->select(
			array(
				'id'               => 'bsvc_message_type',
				'name'             => 'bsvc_message_type',
				'label'            => __( 'Custom Message Type', 'ayecode-connect' ),
				'placeholder'      => __( 'Default (none)', 'ayecode-connect' ),
				'class'            => 'bsvc_message_type form-select-sm no-select2 mw-100',
				'options'          => sd_aui_colors(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'element_require'  => '[%bsvc_output%]=="message"',
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= '</div><div class="col-sm-12">';

		$content .= aui()->input(
			array(
				'type'             => 'text',
				'id'               => 'bsvc_message',
				'name'             => 'bsvc_message',
				'label'            => '',
				'class'            => 'bsvc_message form-control-sm mb-3',
				'placeholder'      => __( 'CUSTOM MESSAGE TO SHOW', 'ayecode-connect' ),
				'label_type'       => '',
				'value'            => '',
				'form_group_class' => ' ',
				'element_require'  => '[%bsvc_output%]=="message"',
			)
		);

		$content .= '</div></div><div class="row"><div class="col col-12"><div class="pt-3 mt-1 border-top"></div></div><div class="col-md-6 col-sm-12">';
		$content .= aui()->select(
			array(
				'id'               => 'bsvc_output_n',
				'name'             => 'bsvc_output_n',
				'label'            => __( 'What should happen if rules NOT met.', 'ayecode-connect' ),
				'placeholder'      => __( 'Show Block', 'ayecode-connect' ),
				'class'            => 'bsvc_output_n form-select-sm no-select2 mw-100',
				'options'          => sd_visibility_output_options(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= '</div><div class="col-md-6 col-sm-12">';

		$content .= aui()->select(
			array(
				'id'              => 'bsvc_page_n',
				'name'            => 'bsvc_page_n',
				'label'           => __( 'Page Content', 'ayecode-connect' ),
				'placeholder'     => __( 'Select Page ID...', 'ayecode-connect' ),
				'class'           => 'bsvc_page_n form-select-sm no-select2 mw-100',
				'options'         => sd_template_page_options(),
				'default'         => '',
				'value'           => '',
				'label_type'      => 'top',
				'select2'         => false,
				'element_require' => '[%bsvc_output_n%]=="page"'
			)
		);

		$content .= aui()->select(
			array(
				'id'               => 'bsvc_tmpl_part_n',
				'name'             => 'bsvc_tmpl_part_n',
				'label'            => __( 'Template Part', 'ayecode-connect' ),
				'placeholder'      => __( 'Select Template Part...', 'ayecode-connect' ),
				'class'            => 'bsvc_tmpl_part_n form-select-sm no-select2 mw-100',
				'options'          => sd_template_part_options(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'element_require'  => '[%bsvc_output_n%]=="template_part"',
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= aui()->select(
			array(
				'id'               => 'bsvc_message_type_n',
				'name'             => 'bsvc_message_type_n',
				'label'            => __( 'Custom Message Type', 'ayecode-connect' ),
				'placeholder'      => __( 'Default (none)', 'ayecode-connect' ),
				'class'            => 'bsvc_message_type_n form-select-sm no-select2 mw-100',
				'options'          => sd_aui_colors(),
				'default'          => '',
				'value'            => '',
				'label_type'       => 'top',
				'select2'          => false,
				'element_require'  => '[%bsvc_output_n%]=="message"',
				'extra_attributes' => array(
					'data-minimum-results-for-search' => '-1'
				)
			)
		);

		$content .= '</div><div class="col-sm-12">';

		$content .= aui()->input(
			array(
				'type'             => 'text',
				'id'               => 'bsvc_message_n',
				'name'             => 'bsvc_message_n',
				'label'            => '',
				'class'            => 'bsvc_message_n form-control-sm',
				'placeholder'      => __( 'CUSTOM MESSAGE TO SHOW', 'ayecode-connect' ),
				'label_type'       => '',
				'value'            => '',
				'form_group_class' => ' ',
				'element_require'  => '[%bsvc_output_n%]=="message"',
			)
		);

		$content .= '</div></div></form><input type="hidden" id="bsvc_raw_value" name="bsvc_raw_value" value="' . $value . '">';

		return $content;
	}


	/**
	 * Output the JS for building the dynamic Guntenberg block.
	 *
	 * @return mixed
	 * @since 1.0.9 Save numbers as numbers and not strings.
	 * @since 1.1.0 Font Awesome classes can be used for icons.
	 * @since 1.0.4 Added block_wrap property which will set the block wrapping output element ie: div, span, p or empty for no wrap.
	 */
	public function block() {
		global $sd_is_js_functions_loaded, $aui_bs5;

		$show_advanced = $this->block_show_advanced();

		ob_start();
		?>
		<script>
			<?php
			if ( ! $sd_is_js_functions_loaded ) {
			$sd_is_js_functions_loaded = true;
			?>
			function sd_show_view_options($this) {
				if (jQuery($this).html().length) {
					jQuery($this).html('');
				} else {
					jQuery($this).html('<div class="position-absolute d-flex flex-column bg-white p-1 rounded border shadow-lg " style="top:-80px;left:-5px;"><div class="dashicons dashicons-desktop mb-1" onclick="sd_set_view_type(\'Desktop\');"></div><div class="dashicons dashicons-tablet mb-1" onclick="sd_set_view_type(\'Tablet\');"></div><div class="dashicons dashicons-smartphone" onclick="sd_set_view_type(\'Mobile\');"></div></div>');
				}
			}

			function sd_set_view_type($device) {
				const wpVersion = '<?php global $wp_version; echo esc_attr( $wp_version ); ?>';
				if (parseFloat(wpVersion) < 6.5) {
					wp.data.dispatch('core/edit-site') ? wp.data.dispatch('core/edit-site').__experimentalSetPreviewDeviceType($device) : wp.data.dispatch('core/edit-post').__experimentalSetPreviewDeviceType($device);
				} else {
					const editorDispatch = wp.data.dispatch('core/editor');
					if (editorDispatch) {
						editorDispatch.setDeviceType($device);
					}
				}
			}

			jQuery(function () {
				sd_block_visibility_init();
			});

			function sd_block_visibility_init() {
				jQuery(document).off('change', '.bs-vc-modal-form').on('change', '.bs-vc-modal-form', function () {
					try {
						aui_conditional_fields('.bs-vc-modal-form');
					} catch (err) {
						console.log(err.message);
					}
				});

				jQuery(document).off('click', '.bs-vc-save').on('click', '.bs-vc-save', function () {
					var $bsvcModal = jQuery(this).closest('.bs-vc-modal'),
						$bsvcForm = $bsvcModal.find('.bs-vc-modal-form'),
						vOutput = jQuery('#bsvc_output', $bsvcForm).val(),
						vOutputN = jQuery('#bsvc_output_n', $bsvcForm).val(), rawValue = '', oVal = {}, oOut = {},
						oOutN = {}, iRule = 0;
					jQuery(this).addClass('disabled');
					jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule').each(function () {
						vRule = jQuery(this).find('.bsvc_rule').val(), oRule = {};
						if (vRule == 'logged_in' || vRule == 'logged_out' || vRule == 'post_author') {
							oRule.type = vRule;
						} else if (vRule == 'user_roles') {
							oRule.type = vRule;
							if (jQuery(this).find('.bsvc_user_roles:checked').length) {
								var user_roles = jQuery(this).find('.bsvc_user_roles:checked').map(function () {
									return jQuery(this).val();
								}).get();
								if (user_roles && user_roles.length) {
									oRule.user_roles = user_roles.join(",");
								}
							}
						} else if (vRule == 'gd_field') {
							if (jQuery(this).find('.bsvc_gd_field ').val() && jQuery(this).find('.bsvc_gd_field_condition').val()) {
								oRule.type = vRule;
								oRule.field = jQuery(this).find('.bsvc_gd_field ').val();
								oRule.condition = jQuery(this).find('.bsvc_gd_field_condition').val();
								if (oRule.condition != 'is_empty' && oRule.condition != 'is_not_empty') {
									oRule.search = jQuery(this).find('.bsvc_gd_field_search').val();
								}
							}
						} else {
							oRule = jQuery(document).triggerHandler('sd_block_visibility_init', [vRule, oRule, jQuery(this)]);
						}

						if (Object.keys(oRule).length > 0) {
							iRule++;
							oVal['rule' + iRule] = oRule;
						}
					});
					if (vOutput == 'hide') {
						oOut.type = vOutput;
					} else if (vOutput == 'message') {
						if (jQuery('#bsvc_message', $bsvcForm).val()) {
							oOut.type = vOutput;
							oOut.message = jQuery('#bsvc_message', $bsvcForm).val();
							if (jQuery('#bsvc_message_type', $bsvcForm).val()) {
								oOut.message_type = jQuery('#bsvc_message_type', $bsvcForm).val();
							}
						}
					} else if (vOutput == 'page') {
						if (jQuery('#bsvc_page', $bsvcForm).val()) {
							oOut.type = vOutput;
							oOut.page = jQuery('#bsvc_page', $bsvcForm).val();
						}
					} else if (vOutput == 'template_part') {
						if (jQuery('#bsvc_tmpl_part', $bsvcForm).val()) {
							oOut.type = vOutput;
							oOut.template_part = jQuery('#bsvc_tmpl_part', $bsvcForm).val();
						}
					}
					if (Object.keys(oOut).length > 0) {
						oVal.output = oOut;
					}
					if (vOutputN == 'hide') {
						oOutN.type = vOutputN;
					} else if (vOutputN == 'message') {
						if (jQuery('#bsvc_message_n', $bsvcForm).val()) {
							oOutN.type = vOutputN;
							oOutN.message = jQuery('#bsvc_message_n', $bsvcForm).val();
							if (jQuery('#bsvc_message_type_n', $bsvcForm).val()) {
								oOutN.message_type = jQuery('#bsvc_message_type_n', $bsvcForm).val();
							}
						}
					} else if (vOutputN == 'page') {
						if (jQuery('#bsvc_page_n', $bsvcForm).val()) {
							oOutN.type = vOutputN;
							oOutN.page = jQuery('#bsvc_page_n', $bsvcForm).val();
						}
					} else if (vOutputN == 'template_part') {
						if (jQuery('#bsvc_tmpl_part_n', $bsvcForm).val()) {
							oOutN.type = vOutputN;
							oOutN.template_part = jQuery('#bsvc_tmpl_part_n', $bsvcForm).val();
						}
					}
					if (Object.keys(oOutN).length > 0) {
						oVal.outputN = oOutN;
					}
					if (Object.keys(oVal).length > 0) {
						rawValue = JSON.stringify(oVal);
					}
					$bsvcModal.find('[name="bsvc_raw_value"]').val(rawValue).trigger('change');
					$bsvcModal.find('.bs-vc-close').trigger('click');
				});
				jQuery(document).off('click', '.bs-vc-add-rule').on('click', '.bs-vc-add-rule', function () {
					var bsvcTmpl = jQuery('.bs-vc-rule-template').html();
					var c = parseInt(jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule:last').data('bs-index'));
					if (c > 0) {
						c++;
					} else {
						c = 1;
					}
					bsvcTmpl = bsvcTmpl.replace(/BSVCINDEX/g, c);
					jQuery('.bs-vc-modal-form .bs-vc-rule-sets').append(bsvcTmpl);
					jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule .bs-vc-sep-wrap').removeClass('d-none');
					jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule:first .bs-vc-sep-wrap').addClass('d-none');
					jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule:last').find('select').each(function () {
						if (!jQuery(this).hasClass('no-select2')) {
							jQuery(this).addClass('aui-select2');
						}
					});
					if (!jQuery(this).hasClass('bs-vc-rendering')) {
						if (typeof aui_init_select2 == 'function') {
							aui_init_select2();
						}
						if (typeof aui_conditional_fields == 'function') {
							aui_conditional_fields('.bs-vc-modal-form');
						}
					}
				});
				jQuery(document).off('click', '.bs-vc-remove-rule').on('click', '.bs-vc-remove-rule', function () {
					jQuery(this).closest('.bs-vc-rule').remove();
				});
			}

			function sd_block_visibility_render_fields(oValue) {
				console.log(oValue);
				if (typeof oValue == 'object' && oValue.rule1 && typeof oValue.rule1 == 'object') {
					for (k = 1; k <= Object.keys(oValue).length; k++) {
						if (oValue['rule' + k] && oValue['rule' + k].type) {
							var oRule = oValue['rule' + k];
							jQuery('.bs-vc-modal-form .bs-vc-add-rule').addClass('bs-vc-rendering').trigger('click');
							var elRule = jQuery('.bs-vc-modal-form .bs-vc-rule-sets .bs-vc-rule:last');
							jQuery('select.bsvc_rule', elRule).val(oRule.type);
							if (oRule.type == 'user_roles' && oRule.user_roles) {
								var user_roles = oRule.user_roles;
								if (typeof user_roles == 'string') {
									user_roles = user_roles.split(",");
								}
								if (user_roles.length) {
									jQuery.each(user_roles, function (i, role) {
										elRule.find("input[value='" + role + "']").prop('checked', true);
									});
								}
								jQuery('select.bsvc_user_roles', elRule).val(oRule.user_roles);
							} else if (oRule.type == 'gd_field') {
								if (oRule.field) {
									jQuery('select.bsvc_gd_field', elRule).val(oRule.field);
									if (oRule.condition) {
										jQuery('select.bsvc_gd_field_condition', elRule).val(oRule.condition);
										if (typeof oRule.search != 'undefined' && oRule.condition != 'is_empty' && oRule.condition != 'is_not_empty') {
											jQuery('input.bsvc_gd_field_search', elRule).val(oRule.search);
										}
									}
								}
							} else {
								jQuery(document).trigger('sd_block_visibility_render_fields', [oRule, elRule]);
							}

							jQuery('.bs-vc-modal-form .bs-vc-add-rule').removeClass('bs-vc-rendering');
						}
					}

					if (oValue.output && oValue.output.type) {
						jQuery('.bs-vc-modal-form #bsvc_output').val(oValue.output.type);
						if (oValue.output.type == 'message' && typeof oValue.output.message != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_message').val(oValue.output.message);
							if (typeof oValue.output.message_type != 'undefined') {
								jQuery('.bs-vc-modal-form #bsvc_message_type').val(oValue.output.message_type);
							}
						} else if (oValue.output.type == 'page' && typeof oValue.output.page != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_page').val(oValue.output.page);
						} else if (oValue.output.type == 'template_part' && typeof oValue.output.template_part != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_template_part').val(oValue.output.template_part);
						}
					}

					if (oValue.outputN && oValue.outputN.type) {
						jQuery('.bs-vc-modal-form #bsvc_output_n').val(oValue.outputN.type);
						if (oValue.outputN.type == 'message' && typeof oValue.outputN.message != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_message_n').val(oValue.outputN.message);
							if (typeof oValue.outputN.message_type != 'undefined') {
								jQuery('.bs-vc-modal-form #bsvc_message_type_n').val(oValue.outputN.message_type);
							}
						} else if (oValue.outputN.type == 'page' && typeof oValue.outputN.page != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_page_n').val(oValue.outputN.page);
						} else if (oValue.outputN.type == 'template_part' && typeof oValue.outputN.template_part != 'undefined') {
							jQuery('.bs-vc-modal-form #bsvc_template_part_n').val(oValue.outputN.template_part);
						}
					}
				}
			}

			/**
			 * Try to auto-recover blocks.
			 */
			function sd_auto_recover_blocks() {
				var recursivelyRecoverInvalidBlockList = blocks => {
					const _blocks = [...blocks]
					let recoveryCalled = false
					const recursivelyRecoverBlocks = willRecoverBlocks => {
						willRecoverBlocks.forEach(_block => {
							if (!_block.isValid) {
								recoveryCalled = true
								const newBlock = recoverBlock(_block)
								for (const key in newBlock) {
									_block[key] = newBlock[key]
								}
							}
							if (_block.innerBlocks.length) {
								recursivelyRecoverBlocks(_block.innerBlocks)
							}
						})
					}
					recursivelyRecoverBlocks(_blocks)
					return [_blocks, recoveryCalled]
				}
				var recoverBlock = ({
										name,
										attributes,
										innerBlocks
									}) => wp.blocks.createBlock(name, attributes, innerBlocks);
				var recoverBlocks = blocks => {
					return blocks.map(_block => {
						const block = _block;
						// If the block is a reusable block, recover the Stackable blocks inside it.
						if (_block.name === 'core/block') {
							const {attributes: {ref}} = _block
							const parsedBlocks = wp.blocks.parse(wp.data.select('core').getEntityRecords('postType', 'wp_block', {include: [ref]})?.[0]?.content?.raw) || []
							const [recoveredBlocks, recoveryCalled] = recursivelyRecoverInvalidBlockList(parsedBlocks)
							if (recoveryCalled) {
								console.log('Stackable notice: block ' + block.name + ' (' + block.clientId + ') was auto-recovered, you should not see this after saving your page.');
								return {blocks: recoveredBlocks, isReusable: true, ref}
							}
						} else if (_block.name === 'core/template-part' && _block.attributes && _block.attributes.theme) {
							var tmplPart = wp.data.select('core').getEntityRecord('postType', 'wp_template_part', _block.attributes.theme + '//' + _block.attributes.slug);
							var tmplPartBlocks = block.innerBlocks && block.innerBlocks.length ? block.innerBlocks : wp.blocks.parse(tmplPart?.content?.raw) || [];
							if (tmplPartBlocks && tmplPartBlocks.length && tmplPartBlocks.some(block => !block.isValid)) {
								block.innerBlocks = tmplPartBlocks;
								block.tmplPartId = _block.attributes.theme + '//' + _block.attributes.slug;
							}
						}
						if (block.innerBlocks && block.innerBlocks.length) {
							if (block.tmplPartId) {
								console.log('Template part ' + block.tmplPartId + ' block ' + block.name + ' (' + block.clientId + ') starts');
							}
							const newInnerBlocks = recoverBlocks(block.innerBlocks)
							if (newInnerBlocks.some(block => block.recovered)) {
								block.innerBlocks = newInnerBlocks
								block.replacedClientId = block.clientId
								block.recovered = true
							}
							if (block.tmplPartId) {
								console.log('Template part ' + block.tmplPartId + ' block ' + block.name + ' (' + block.clientId + ') ends');
							}
						}
						if (!block.isValid) {
							const newBlock = recoverBlock(block)
							newBlock.replacedClientId = block.clientId
							newBlock.recovered = true
							console.log('Stackable notice: block ' + block.name + ' (' + block.clientId + ') was auto-recovered, you should not see this after saving your page.');
							return newBlock
						}
						return block
					})
				}
				// Recover all the blocks that we can find.
				var sdBlockEditor = wp.data.select('core/block-editor');
				var mainBlocks = sdBlockEditor ? recoverBlocks(sdBlockEditor.getBlocks()) : null;
				// Replace the recovered blocks with the new ones.
				if (mainBlocks) {
					mainBlocks.forEach(block => {
						if (block.isReusable && block.ref) {
							// Update the reusable blocks.
							wp.data.dispatch('core').editEntityRecord('postType', 'wp_block', block.ref, {
								content: wp.blocks.serialize(block.blocks)
							}).then(() => {
								// But don't save them, let the user do the saving themselves. Our goal is to get rid of the block error visually.
							})
						}
						if (block.recovered && block.replacedClientId) {
							wp.data.dispatch('core/block-editor').replaceBlock(block.replacedClientId, block)
						}
					})
				}
			}

			/**
			 * Try to auto-recover OUR blocks if traditional way fails.
			 */
			function sd_auto_recover_blocks_fallback(editTmpl) {
				console.log('sd_auto_recover_blocks_fallback()');
				var $bsRecoverBtn = jQuery(".edit-site-visual-editor__editor-canvas").contents().find('div[class*=" wp-block-blockstrap-"] .block-editor-warning__actions  .block-editor-warning__action .components-button.is-primary').not(":contains('Keep as HTML')");
				if ($bsRecoverBtn.length) {
					if (jQuery('.edit-site-layout.is-full-canvas').length || jQuery('.edit-site-layout.is-edit-mode').length) {
						$bsRecoverBtn.removeAttr('disabled').trigger('click');
					}
				}
			}

			<?php if( ! isset( $_REQUEST['sd-block-recover-debug'] ) ){ ?>
			// Wait will window is loaded before calling.
			window.onload = function () {
				sd_auto_recover_blocks();
				// fire a second time incase of load delays.
				setTimeout(function () {
					sd_auto_recover_blocks();
				}, 5000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 6000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 10000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 15000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 20000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 30000);

				setTimeout(function () {
					sd_auto_recover_blocks_fallback();
				}, 60000);

				jQuery('.edit-site-page-panels__edit-template-button, .edit-site-visual-editor__editor-canvas').on('click', function () {
					setTimeout(function () {
						sd_auto_recover_blocks_fallback(true);
						jQuery('.edit-site-page-panels__edit-template-button, .edit-site-visual-editor__editor-canvas').addClass('bs-edit-tmpl-clicked');
					}, 100);
				});
			};
			<?php } ?>

			// fire when URL changes also.
			let lastUrl = location.href;
			new MutationObserver(() => {
				const url = location.href;
				if (url !== lastUrl) {
					lastUrl = url;
					sd_auto_recover_blocks();
					// fire a second time incase of load delays.
					setTimeout(function () {
						sd_auto_recover_blocks();
						sd_auto_recover_blocks_fallback();
					}, 2000);

					setTimeout(function () {
						sd_auto_recover_blocks_fallback();
					}, 10000);

					setTimeout(function () {
						sd_auto_recover_blocks_fallback();
					}, 15000);

					setTimeout(function () {
						sd_auto_recover_blocks_fallback();
					}, 20000);

				}
			}).observe(document, {
				subtree: true,
				childList: true
			});


			/**
			 *
			 * @param $args
			 * @returns {*|{}}
			 */
			function sd_build_aui_styles($args) {

				$styles = {};
				// background color
				if ($args['bg'] !== undefined && $args['bg'] !== '') {
					if ($args['bg'] == 'custom-color') {
						$styles['background-color'] = $args['bg_color'];
					} else if ($args['bg'] == 'custom-gradient') {
						$styles['background-image'] = $args['bg_gradient'];

						// use background on text
						if ($args['bg_on_text'] !== undefined && $args['bg_on_text']) {
							$styles['backgroundClip'] = "text";
							$styles['WebkitBackgroundClip'] = "text";
							$styles['text-fill-color'] = "transparent";
							$styles['WebkitTextFillColor'] = "transparent";
						}
					}

				}

				let $bg_image = $args['bg_image'] !== undefined && $args['bg_image'] !== '' ? $args['bg_image'] : '';

				// maybe use featured image.
				if ($args['bg_image_use_featured'] !== undefined && $args['bg_image_use_featured']) {
					$bg_image = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiID8+CjxzdmcgYmFzZVByb2ZpbGU9InRpbnkiIGhlaWdodD0iNDAwIiB2ZXJzaW9uPSIxLjIiIHdpZHRoPSI0MDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6ZXY9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEveG1sLWV2ZW50cyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxkZWZzIC8+PHJlY3QgZmlsbD0iI2QzZDNkMyIgaGVpZ2h0PSI0MDAiIHdpZHRoPSI0MDAiIHg9IjAiIHk9IjAiIC8+PGxpbmUgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxMCIgeDE9IjAiIHgyPSI0MDAiIHkxPSIwIiB5Mj0iNDAwIiAvPjxsaW5lIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMTAiIHgxPSIwIiB4Mj0iNDAwIiB5MT0iNDAwIiB5Mj0iMCIgLz48cmVjdCBmaWxsPSIjZDNkM2QzIiBoZWlnaHQ9IjUwIiB3aWR0aD0iMjE4LjAiIHg9IjkxLjAiIHk9IjE3NS4wIiAvPjx0ZXh0IGZpbGw9IndoaXRlIiBmb250LXNpemU9IjMwIiBmb250LXdlaWdodD0iYm9sZCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMjAwLjAiIHk9IjIwNy41Ij5QTEFDRUhPTERFUjwvdGV4dD48L3N2Zz4=';
				}

				if ($bg_image !== undefined && $bg_image !== '') {
					var hasImage = true
					if ($styles['background-color'] !== undefined && $args['bg'] == 'custom-color') {
						$styles['background-image'] = "url(" + $bg_image + ")";
						$styles['background-blend-mode'] = "overlay";
					} else if ($styles['background-image'] !== undefined && $args['bg'] == 'custom-gradient') {
						$styles['background-image'] += ",url(" + $bg_image + ")";
					} else if ($args['bg'] !== undefined && $args['bg'] != '' && $args['bg'] != 'transparent') {
						// do nothing as we already have a preset
						hasImage = false;
					} else {
						$styles['background-image'] = "url(" + $bg_image + ")";
					}

					if (hasImage) {
						$styles['background-size'] = "cover";

						if ($args['bg_image_fixed'] !== undefined && $args['bg_image_fixed']) {
							$styles['background-attachment'] = "fixed";
						}
					}

					if (hasImage && $args['bg_image_xy'].x !== undefined && $args['bg_image_xy'].x >= 0) {
						$styles['background-position'] = ($args['bg_image_xy'].x * 100) + "% " + ($args['bg_image_xy'].y * 100) + "%";
					}
				}


				// sticky offset top
				if ($args['sticky_offset_top'] !== undefined && $args['sticky_offset_top'] !== '') {
					$styles['top'] = $args['sticky_offset_top'];
				}

				// sticky offset bottom
				if ($args['sticky_offset_bottom'] !== undefined && $args['sticky_offset_bottom'] !== '') {
					$styles['bottom'] = $args['sticky_offset_bottom'];
				}

				// font size
				if ($args['font_size'] === undefined || $args['font_size'] === 'custom') {
					if ($args['font_size_custom'] !== undefined && $args['font_size_custom'] !== '') {
						$styles['fontSize'] = $args['font_size_custom'] + "rem";
					}
				}

				// font color
				if ($args['text_color'] === undefined || $args['text_color'] === 'custom') {
					if ($args['text_color_custom'] !== undefined && $args['text_color_custom'] !== '') {
						$styles['color'] = $args['text_color_custom'];
					}
				}

				// font line height
				if ($args['font_line_height'] !== undefined && $args['font_line_height'] !== '') {
					$styles['lineHeight'] = $args['font_line_height'];
				}

				// max height
				if ($args['max_height'] !== undefined && $args['max_height'] !== '') {
					$styles['maxHeight'] = $args['max_height'];
				}

				return $styles;

			}

			function sd_build_aui_class($args) {

				$classes = [];

				<?php
				if($aui_bs5){
				?>
				$aui_bs5 = true;
				$p_ml = 'ms-';
				$p_mr = 'me-';

				$p_pl = 'ps-';
				$p_pr = 'pe-';
				<?php
				}else{
				?>
				$aui_bs5 = false;
				$p_ml = 'ml-';
				$p_mr = 'mr-';

				$p_pl = 'pl-';
				$p_pr = 'pr-';
				<?php
				}
				?>

				// margins
				if ($args['mt'] !== undefined && $args['mt'] !== '') {
					$classes.push("mt-" + $args['mt']);
					$mt = $args['mt'];
				} else {
					$mt = null;
				}
				if ($args['mr'] !== undefined && $args['mr'] !== '') {
					$classes.push($p_mr + $args['mr']);
					$mr = $args['mr'];
				} else {
					$mr = null;
				}
				if ($args['mb'] !== undefined && $args['mb'] !== '') {
					$classes.push("mb-" + $args['mb']);
					$mb = $args['mb'];
				} else {
					$mb = null;
				}
				if ($args['ml'] !== undefined && $args['ml'] !== '') {
					$classes.push($p_ml + $args['ml']);
					$ml = $args['ml'];
				} else {
					$ml = null;
				}

				// margins tablet
				if ($args['mt_md'] !== undefined && $args['mt_md'] !== '') {
					$classes.push("mt-md-" + $args['mt_md']);
					$mt_md = $args['mt_md'];
				} else {
					$mt_md = null;
				}
				if ($args['mr_md'] !== undefined && $args['mr_md'] !== '') {
					$classes.push($p_mr + "md-" + $args['mr_md']);
					$mt_md = $args['mr_md'];
				} else {
					$mr_md = null;
				}
				if ($args['mb_md'] !== undefined && $args['mb_md'] !== '') {
					$classes.push("mb-md-" + $args['mb_md']);
					$mt_md = $args['mb_md'];
				} else {
					$mb_md = null;
				}
				if ($args['ml_md'] !== undefined && $args['ml_md'] !== '') {
					$classes.push($p_ml + "md-" + $args['ml_md']);
					$mt_md = $args['ml_md'];
				} else {
					$ml_md = null;
				}

				// margins desktop
				if ($args['mt_lg'] !== undefined && $args['mt_lg'] !== '') {
					if ($mt == null && $mt_md == null) {
						$classes.push("mt-" + $args['mt_lg']);
					} else {
						$classes.push("mt-lg-" + $args['mt_lg']);
					}
				}
				if ($args['mr_lg'] !== undefined && $args['mr_lg'] !== '') {
					if ($mr == null && $mr_md == null) {
						$classes.push($p_mr + $args['mr_lg']);
					} else {
						$classes.push($p_mr + "lg-" + $args['mr_lg']);
					}
				}
				if ($args['mb_lg'] !== undefined && $args['mb_lg'] !== '') {
					if ($mb == null && $mb_md == null) {
						$classes.push("mb-" + $args['mb_lg']);
					} else {
						$classes.push("mb-lg-" + $args['mb_lg']);
					}
				}
				if ($args['ml_lg'] !== undefined && $args['ml_lg'] !== '') {
					if ($ml == null && $ml_md == null) {
						$classes.push($p_ml + $args['ml_lg']);
					} else {
						$classes.push($p_ml + "lg-" + $args['ml_lg']);
					}
				}

				// padding
				if ($args['pt'] !== undefined && $args['pt'] !== '') {
					$classes.push("pt-" + $args['pt']);
					$pt = $args['pt'];
				} else {
					$pt = null;
				}
				if ($args['pr'] !== undefined && $args['pr'] !== '') {
					$classes.push($p_pr + $args['pr']);
					$pr = $args['pt'];
				} else {
					$pr = null;
				}
				if ($args['pb'] !== undefined && $args['pb'] !== '') {
					$classes.push("pb-" + $args['pb']);
					$pb = $args['pt'];
				} else {
					$pb = null;
				}
				if ($args['pl'] !== undefined && $args['pl'] !== '') {
					$classes.push($p_pl + $args['pl']);
					$pl = $args['pt'];
				} else {
					$pl = null;
				}

				// padding tablet
				if ($args['pt_md'] !== undefined && $args['pt_md'] !== '') {
					$classes.push("pt-md-" + $args['pt_md']);
					$pt_md = $args['pt_md'];
				} else {
					$pt_md = null;
				}
				if ($args['pr_md'] !== undefined && $args['pr_md'] !== '') {
					$classes.push($p_pr + "md-" + $args['pr_md']);
					$pr_md = $args['pt_md'];
				} else {
					$pr_md = null;
				}
				if ($args['pb_md'] !== undefined && $args['pb_md'] !== '') {
					$classes.push("pb-md-" + $args['pb_md']);
					$pb_md = $args['pt_md'];
				} else {
					$pb_md = null;
				}
				if ($args['pl_md'] !== undefined && $args['pl_md'] !== '') {
					$classes.push($p_pl + "md-" + $args['pl_md']);
					$pl_md = $args['pt_md'];
				} else {
					$pl_md = null;
				}

				// padding desktop
				if ($args['pt_lg'] !== undefined && $args['pt_lg'] !== '') {
					if ($pt == null && $pt_md == null) {
						$classes.push("pt-" + $args['pt_lg']);
					} else {
						$classes.push("pt-lg-" + $args['pt_lg']);
					}
				}
				if ($args['pr_lg'] !== undefined && $args['pr_lg'] !== '') {
					if ($pr == null && $pr_md == null) {
						$classes.push($p_pr + $args['pr_lg']);
					} else {
						$classes.push($p_pr + "lg-" + $args['pr_lg']);
					}
				}
				if ($args['pb_lg'] !== undefined && $args['pb_lg'] !== '') {
					if ($pb == null && $pb_md == null) {
						$classes.push("pb-" + $args['pb_lg']);
					} else {
						$classes.push("pb-lg-" + $args['pb_lg']);
					}
				}
				if ($args['pl_lg'] !== undefined && $args['pl_lg'] !== '') {
					if ($pl == null && $pl_md == null) {
						$classes.push($p_pl + $args['pl_lg']);
					} else {
						$classes.push($p_pl + "lg-" + $args['pl_lg']);
					}
				}

				// row cols, mobile, tablet, desktop
				if ($args['row_cols'] !== undefined && $args['row_cols'] !== '') {
					$classes.push("row-cols-" + $args['row_cols']);
					$row_cols = $args['row_cols'];
				} else {
					$row_cols = null;
				}
				if ($args['row_cols_md'] !== undefined && $args['row_cols_md'] !== '') {
					$classes.push("row-cols-md-" + $args['row_cols_md']);
					$row_cols_md = $args['row_cols_md'];
				} else {
					$row_cols_md = null;
				}
				if ($args['row_cols_lg'] !== undefined && $args['row_cols_lg'] !== '') {
					if ($row_cols == null && $row_cols_md == null) {
						$classes.push("row-cols-" + $args['row_cols_lg']);
					} else {
						$classes.push("row-cols-lg-" + $args['row_cols_lg']);
					}
				}

				// columns , mobile, tablet, desktop
				if ($args['col'] !== undefined && $args['col'] !== '') {
					$classes.push("col-" + $args['col']);
					$col = $args['col'];
				} else {
					$col = null;
				}
				if ($args['col_md'] !== undefined && $args['col_md'] !== '') {
					$classes.push("col-md-" + $args['col_md']);
					$col_md = $args['col_md'];
				} else {
					$col_md = null;
				}
				if ($args['col_lg'] !== undefined && $args['col_lg'] !== '') {
					if ($col == null && $col_md == null) {
						$classes.push("col-" + $args['col_lg']);
					} else {
						$classes.push("col-lg-" + $args['col_lg']);
					}
				}


				// border
				if ($args['border'] === undefined || $args['border'] == '') {
				} else if ($args['border'] !== undefined && ($args['border'] == 'none' || $args['border'] === '0')) {
					$classes.push("border-0");
				} else if ($args['border'] !== undefined) {
					if ($aui_bs5 && $args['border_type'] !== undefined) {
						$args['border_type'] = $args['border_type'].replace('-left', '-start').replace('-right', '-end');
					}
					$border_class = 'border';
					if ($args['border_type'] !== undefined && !$args['border_type'].includes('-0')) {
						$border_class = '';
					}
					$classes.push($border_class + " border-" + $args['border']);
				}

				// border radius type
				//  if ( $args['rounded'] !== undefined && $args['rounded'] !== '' ) { $classes.push($args['rounded']); }

				// border radius size
				if ($args['rounded_size'] !== undefined && ($args['rounded_size'] === 'sm' || $args['rounded_size'] === 'lg')) {
					if ($args['rounded_size'] !== undefined && $args['rounded_size'] !== '') {
						$classes.push("rounded-" + $args['rounded_size']);
						// if we set a size then we need to remove "rounded" if set
						var index = $classes.indexOf("rounded");
						if (index !== -1) {
							$classes.splice(index, 1);
						}
					}
				} else {
					// rounded_size , mobile, tablet, desktop
					if ($args['rounded_size'] !== undefined && $args['rounded_size'] !== '') {
						$classes.push("rounded-" + $args['rounded_size']);
						$rounded_size = $args['rounded_size'];
					} else {
						$rounded_size = null;
					}
					if ($args['rounded_size_md'] !== undefined && $args['rounded_size_md'] !== '') {
						$classes.push("rounded-md-" + $args['rounded_size_md']);
						$rounded_size_md = $args['rounded_size_md'];
					} else {
						$rounded_size_md = null;
					}
					if ($args['rounded_size_lg'] !== undefined && $args['rounded_size_lg'] !== '') {
						if ($rounded_size == null && $rounded_size_md == null) {
							$classes.push("rounded-" + $args['rounded_size_lg']);
						} else {
							$classes.push("rounded-lg-" + $args['rounded_size_lg']);
						}
					}
				}


				// shadow
				// if ( $args['shadow'] !== undefined && $args['shadow'] !== '' ) { $classes.push($args['shadow']); }

				// background
				if ($args['bg'] !== undefined && $args['bg'] !== '') {
					$classes.push("bg-" + $args['bg']);
				}

				// background image fixed bg_image_fixed
				if ($args['bg_image_fixed'] !== undefined && $args['bg_image_fixed'] !== '') {
					$classes.push("bg-image-fixed");
				}

				// text_color
				if ($args['text_color'] !== undefined && $args['text_color'] !== '') {
					$classes.push("text-" + $args['text_color']);
				}

				// text_align
				if ($args['text_justify'] !== undefined && $args['text_justify']) {
					$classes.push('text-justify');
				} else {
					if ($args['text_align'] !== undefined && $args['text_align'] !== '') {
						if ($aui_bs5) {
							$args['text_align'] = $args['text_align'].replace('-left', '-start').replace('-right', '-end');
						}
						$classes.push($args['text_align']);
						$text_align = $args['text_align'];
					} else {
						$text_align = null;
					}
					if ($args['text_align_md'] !== undefined && $args['text_align_md'] !== '') {
						if ($aui_bs5) {
							$args['text_align_md'] = $args['text_align_md'].replace('-left', '-start').replace('-right', '-end');
						}
						$classes.push($args['text_align_md']);
						$text_align_md = $args['text_align_md'];
					} else {
						$text_align_md = null;
					}
					if ($args['text_align_lg'] !== undefined && $args['text_align_lg'] !== '') {
						if ($aui_bs5) {
							$args['text_align_lg'] = $args['text_align_lg'].replace('-left', '-start').replace('-right', '-end');
						}
						if ($text_align == null && $text_align_md == null) {
							$classes.push($args['text_align_lg'].replace("-lg", ""));
						} else {
							$classes.push($args['text_align_lg']);
						}
					}
				}

				// display
				if ($args['display'] !== undefined && $args['display'] !== '') {
					$classes.push($args['display']);
					$display = $args['display'];
				} else {
					$display = null;
				}
				if ($args['display_md'] !== undefined && $args['display_md'] !== '') {
					$classes.push($args['display_md']);
					$display_md = $args['display_md'];
				} else {
					$display_md = null;
				}
				if ($args['display_lg'] !== undefined && $args['display_lg'] !== '') {
					if ($display == null && $display_md == null) {
						$classes.push($args['display_lg'].replace("-lg", ""));
					} else {
						$classes.push($args['display_lg']);
					}
				}

				// bgtus - background transparent until scroll
				if ($args['bgtus'] !== undefined && $args['bgtus']) {
					$classes.push("bg-transparent-until-scroll");
				}

				// cscos - change color scheme on scroll
				if ($args['bgtus'] !== undefined && $args['bgtus'] && $args['cscos'] !== undefined && $args['cscos']) {
					$classes.push("color-scheme-flip-on-scroll");
				}

				// hover animations
				if ($args['hover_animations'] !== undefined && $args['hover_animations']) {
					$classes.push($args['hover_animations'].toString().replace(',', ' '));
				}

				// hover icon animations
				if ($args['hover_icon_animation'] !== undefined && $args['hover_icon_animation'] !== '') {
					$classes.push($args['hover_icon_animation']);
				}

				// absolute_position
				if ($args['absolute_position'] !== undefined) {
					if ('top-left' === $args['absolute_position']) {
						$classes.push('start-0 top-0');
					} else if ('top-center' === $args['absolute_position']) {
						$classes.push('start-50 top-0 translate-middle');
					} else if ('top-right' === $args['absolute_position']) {
						$classes.push('end-0 top-0');
					} else if ('center-left' === $args['absolute_position']) {
						$classes.push('start-0 bottom-50');
					} else if ('center' === $args['absolute_position']) {
						$classes.push('start-50 top-50 translate-middle');
					} else if ('center-right' === $args['absolute_position']) {
						$classes.push('end-0 top-50');
					} else if ('bottom-left' === $args['absolute_position']) {
						$classes.push('start-0 bottom-0');
					} else if ('bottom-center' === $args['absolute_position']) {
						$classes.push('start-50 bottom-0 translate-middle');
					} else if ('bottom-right' === $args['absolute_position']) {
						$classes.push('end-0 bottom-0');
					}
				}

				// build classes from build keys
				$build_keys = sd_get_class_build_keys();
				if ($build_keys.length) {
					$build_keys.forEach($key => {

						if ($key.endsWith("-MTD")) {

							$k = $key.replace("-MTD", "");

							// Mobile, Tablet, Desktop
							if ($args[$k] !== undefined && $args[$k] !== '') {
								$classes.push($args[$k]);
								$v = $args[$k];
							} else {
								$v = null;
							}
							if ($args[$k + '_md'] !== undefined && $args[$k + '_md'] !== '') {
								$classes.push($args[$k + '_md']);
								$v_md = $args[$k + '_md'];
							} else {
								$v_md = null;
							}
							if ($args[$k + '_lg'] !== undefined && $args[$k + '_lg'] !== '') {
								if ($v == null && $v_md == null) {
									$classes.push($args[$k + '_lg'].replace('-lg', ''));
								} else {
									$classes.push($args[$k + '_lg']);
								}
							}

						} else {
							if ($key == 'font_size' && ($args[$key] == 'custom' || $args[$key] === '0')) {
								return;
							}
							if ($args[$key] !== undefined && $args[$key] !== '') {
								$classes.push($args[$key]);
							}
						}

					});
				}

				return $classes.join(" ");
			}

			function sd_get_class_build_keys() {
				return <?php echo json_encode( sd_get_class_build_keys() );?>;
			}

			<?php


			}

			if ( method_exists( $this, 'block_global_js' ) ) {
				echo $this->block_global_js();
			}

			$block_name = str_replace( "_", "-", sanitize_title_with_dashes( $this->options['textdomain'] ) . '/' . sanitize_title_with_dashes( $this->options['class_name'] ) );
			?>

			jQuery(function () {

				/**
				 * BLOCK: Basic
				 *
				 * Registering a basic block with Gutenberg.
				 * Simple block, renders and saves the same content without any interactivity.
				 *
				 * Styles:
				 *        editor.css — Editor styles for the block.
				 *        style.css  — Editor & Front end styles for the block.
				 */
				(function (blocksx, elementx, blockEditor) {
					if (typeof blockEditor === 'undefined') {
						return;<?php /* Yoast SEO load blocks.js without block-editor.js on post edit pages */ ?>
					}
					var __ = wp.i18n.__; // The __() for internationalization.
					var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
					var editable = wp.blocks.Editable;
					var blocks = wp.blocks;
					var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.
					var is_fetching = false;
					var prev_attributes = [];

					var InnerBlocks = blockEditor.InnerBlocks;

					var term_query_type = '';
					var post_type_rest_slugs = <?php if ( ! empty( $this->arguments ) && isset( $this->arguments['post_type']['onchange_rest']['values'] ) ) {
						echo "[" . json_encode( $this->arguments['post_type']['onchange_rest']['values'] ) . "]";
					} else {
						echo "[]";
					} ?>;
					const taxonomies_<?php echo str_replace( "-", "_", $this->id );?> = [{
						label: "Please wait",
						value: 0
					}];
					const sort_by_<?php echo str_replace( "-", "_", $this->id );?> = [{label: "Please wait", value: 0}];
					const MediaUpload = wp.blockEditor.MediaUpload;


					// Ensure InputControl exists even on older builds: @todo add version check
					if (
						typeof wp.components.InputControl === 'undefined' &&
						typeof wp.components.__experimentalInputControl !== 'undefined'
					) {
						wp.components.InputControl = wp.components.__experimentalInputControl;
					}

					const iconPickerInstances = {};

					/**
					 * Register Basic Block.
					 *
					 * Registers a new block provided a unique name and an object defining its
					 * behavior. Once registered, the block is made available as an option to any
					 * editor interface where blocks are implemented.
					 *
					 * @param  {string}   name     Block name.
					 * @param  {Object}   settings Block settings.
					 * @return {?WPBlock}          The block, if it has been successfully
					 *                             registered; otherwise `undefined`.
					 */
					registerBlockType('<?php echo $block_name; ?>', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
						apiVersion: <?php echo isset( $this->options['block-api-version'] ) ? absint( $this->options['block-api-version'] ) : 2; ?>,
						title: '<?php echo addslashes( $this->options['name'] ); ?>', // Block title.
						description: '<?php echo addslashes( $this->options['widget_ops']['description'] )?>', // Block title.
						icon: <?php echo $this->get_block_icon( $this->options['block-icon'] );?>,//'<?php echo isset( $this->options['block-icon'] ) ? esc_attr( $this->options['block-icon'] ) : 'shield-alt';?>', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
						supports: {
							<?php
							if ( ! isset( $this->options['block-supports']['renaming'] ) ) {
								$this->options['block-supports']['renaming'] = false;
							}
							if ( isset( $this->options['block-supports'] ) ) {
								echo $this->array_to_attributes( $this->options['block-supports'] );
							}
							?>
						},
						__experimentalLabel(attributes, {context}) {
							var visibility_html = attributes && attributes.visibility_conditions ? ' &#128065;' : '';
							var metadata_name = attributes && attributes.metadata && attributes.metadata.name ? attributes.metadata.name : '';
							var label_name = <?php echo ! empty( $this->options['block-label'] ) ? $this->options['block-label'] : "'" . esc_attr( addslashes( $this->options['name'] ) ) . "'"; ?>;
							return metadata_name ? metadata_name + visibility_html : label_name + visibility_html;
						},
						category: '<?php echo isset( $this->options['block-category'] ) ? esc_attr( $this->options['block-category'] ) : 'common';?>', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
						<?php if ( isset( $this->options['block-keywords'] ) ) {
							echo "keywords : " . $this->options['block-keywords'] . ",";
						}


						// block hover preview.
						$example_args = array();
						if ( ! empty( $this->arguments ) ) {
							foreach ( $this->arguments as $key => $a_args ) {
								if ( isset( $a_args['example'] ) ) {
									$example_args[ $key ] = $a_args['example'];
								}
							}
						}
						$viewport_width = isset( $this->options['example']['viewportWidth'] ) ? 'viewportWidth: ' . absint( $this->options['example']['viewportWidth'] ) : '';
						$example_inner_blocks = ! empty( $this->options['example']['innerBlocks'] ) && is_array( $this->options['example']['innerBlocks'] ) ? 'innerBlocks: ' . wp_json_encode( $this->options['example']['innerBlocks'] ) : '';
						if ( isset( $this->options['example'] ) && $this->options['example'] === false ) {
							// no preview if set to false
						} elseif ( ! empty( $example_args ) ) {
							echo "example : {attributes:{" . $this->array_to_attributes( $example_args ) . "},$viewport_width},";
						} elseif ( ! empty( $this->options['example'] ) ) {
							unset( $this->options['example']['viewportWidth'] );
							unset( $this->options['example']['innerBlocks'] );
							$example_atts  = $this->array_to_attributes( $this->options['example'] );
							$example_parts = array();
							if ( $example_atts ) {
								$example_parts[] = rtrim( $example_atts, "," );
							}
							if ( $viewport_width ) {
								$example_parts[] = $viewport_width;
							}
							if ( $example_inner_blocks ) {
								$example_parts[] = $example_inner_blocks;
							}
							if ( ! empty( $example_parts ) ) {
								echo "example : {" . implode( ',', $example_parts ) . "},";
							}
						} else {
							echo 'example : {viewportWidth: 500},';
						}



						// limit to parent
						if ( ! empty( $this->options['parent'] ) ) {
							echo "parent : " . wp_json_encode( $this->options['parent'] ) . ",";
						}

						// limit allowed blocks
						if ( ! empty( $this->options['allowed-blocks'] ) ) {
							echo "allowedBlocks : " . wp_json_encode( $this->options['allowed-blocks'] ) . ",";
						}

						// maybe set no_wrap
						$no_wrap = isset( $this->options['no_wrap'] ) && $this->options['no_wrap'] ? true : false;
						if ( isset( $this->arguments['no_wrap'] ) && $this->arguments['no_wrap'] ) {
							$no_wrap = true;
						}
						if ( $no_wrap ) {
							$this->options['block-wrap'] = '';
						}

						// Maybe load the drag/drop functions.
						$img_drag_drop = false;
						$show_alignment = false;

						echo "attributes : {";

						if ( $show_advanced ) {
							echo "show_advanced: {";
							echo "  type: 'boolean',";
							echo "  default: false";
							echo "},";
						}

						// Block wrap element
						if ( ! empty( $this->options['block-wrap'] ) ) { //@todo we should validate this?
							echo "block_wrap: {";
							echo "  type: 'string',";
							echo "  default: '" . esc_attr( $this->options['block-wrap'] ) . "'";
							echo "},";
						}


						if ( ! empty( $this->arguments ) ) {
							foreach ( $this->arguments as $key => $args ) {
								if ( $args['type'] == 'image' || $args['type'] == 'images' ) {
									$img_drag_drop = true;
								}

								// Set if we should show alignment.
								if ( $key == 'alignment' ) {
									$show_alignment = true;
								}

								$extra    = '';
								$_default = isset( $args['default'] ) && ! is_null( $args['default'] ) ? $args['default'] : '';

								if ( ! empty( $_default ) ) {
									$_default = wp_slash( $_default );
								}

								if ( $args['type'] == 'notice' || $args['type'] == 'tab' ) {
									continue;
								} else if ( $args['type'] == 'checkbox' ) {
									$type    = 'boolean';
									$default = $_default ? 'true' : 'false';
								} else if ( $args['type'] == 'number' ) {
									$type    = 'number';
									$default = "'" . $_default . "'";
								} else if ( $args['type'] == 'select' && ! empty( $args['multiple'] ) ) {
									$type = 'array';
									if ( isset( $args['default'] ) && is_array( $args['default'] ) ) {
										$default = ! empty( $_default ) ? "['" . implode( "','", $_default ) . "']" : "[]";
									} else {
										$default = "'" . $_default . "'";
									}
								} else if ( $args['type'] == 'tagselect' ) {
									$type    = 'array';
									$default = "'" . $_default . "'";
								} else if ( $args['type'] == 'multiselect' ) {
									$type    = 'array';
									$default = "'" . $_default . "'";
								} else if ( $args['type'] == 'image_xy' ) {
									$type    = 'object';
									$default = "'" . $_default . "'";
								} else if ( $args['type'] == 'image' ) {
									$type    = 'string';
									$default = "'" . $_default . "'";
								} else {
									$type    = ! empty( $args['hidden_type'] ) ? esc_attr( $args['hidden_type'] ) : 'string';
									$default = "'" . $_default . "'";
								}

								echo $key . " : {";
								echo "type : '$type',";
								echo "default : $default";
								echo "},";
							}
						}


						echo "content : {type : 'string',default: 'Please select the attributes in the block settings'},";
						echo "sd_shortcode : {type : 'string',default: ''},";

						// set dynamic filed
						if ( ! empty( $this->options['block-dynamic-field'] ) ) {
							echo "sd_dynamic_field : {type : 'string',default: 'true'},";
						}

						if ( ! empty( $this->options['nested-block'] ) || ! empty( $this->arguments['html'] ) ) {
							echo "sd_shortcode_close : {type : 'string',default: ''},";
						}

						echo "className: { type: 'string', default: '' }";
						echo "},";


						// add block transforms
						if ( ! empty( $this->options['transforms'] ) ) {
							echo $this->generate_block_transforms( $block_name, $this->options['transforms'] );
						}
						?>


						// The "edit" property must be a valid function.
						edit: function (props) {

							<?php if(! empty( $this->options['block-dynamic-field'] )){
							// for dynamic data insert into richText at current cursor position
							$dynamic_field_key = esc_attr( $this->options['block-dynamic-field'] );
							?>
							/**
							 * --------------------------------------------------------------------
							 * 1. State Management
							 * --------------------------------------------------------------------
							 */
								// State for the modal's visibility
							const modalState = wp.element.useState(false);
							const isModalOpen = modalState[0];
							const setModalOpen = modalState[1];

							// State to store the last known cursor position
							const caretState = wp.element.useState(null);
							const caretOffset = caretState[0];
							const setCaretOffset = caretState[1];

							// A 'ref' to get a direct handle on our block's wrapper element
							const blockWrapperRef = wp.element.useRef(null);

							/**
							 * --------------------------------------------------------------------
							 * 2. Handler Functions
							 * --------------------------------------------------------------------
							 */

							// This function manually calculates the cursor position.
							// This logic is proven to work in both editor contexts.
							function updateCaret() {
								const node = blockWrapperRef.current;
								if (!node) return;

								// Get the selection from the document that OWNS our text field.
								const sel = node.ownerDocument.defaultView.getSelection();

								if (!sel.rangeCount) return;
								const range = sel.getRangeAt(0);

								const editableEl = node.querySelector('[contenteditable="true"]');
								if (!editableEl || !editableEl.contains(range.startContainer)) return;

								const pre = range.cloneRange();
								pre.selectNodeContents(editableEl);
								pre.setEnd(range.endContainer, range.endOffset);
								setCaretOffset(pre.toString().length);
							}

							// This function uses the captured cursor position to insert the tag.
							function handleSelect(dataTag) {
								const existingText = props.attributes.<?php echo esc_attr( $dynamic_field_key );?> || '';
								const offset = caretOffset !== null ? caretOffset : existingText.length;

								const before = existingText.slice(0, offset);
								const after = existingText.slice(offset);

								props.setAttributes({ <?php echo esc_attr( $dynamic_field_key );?>:
								before + dataTag + after
							})
								;
								setModalOpen(false);
								setCaretOffset(null); // Reset after insertion
							}

							function handleTextChange(newHtmlString) {
								props.setAttributes({ <?php echo esc_attr( $dynamic_field_key );?>:
								newHtmlString
							})
								;
							}

							/**
							 * --------------------------------------------------------------------
							 * 3. Rendered Output
							 * --------------------------------------------------------------------
							 */
								// Assign the ref to the block props here. This is the wrapper div.
							const blockProps = wp.blockEditor.useBlockProps({
									ref: blockWrapperRef,
									className: sd_build_aui_class(props.attributes),
									style: sd_build_aui_styles(props.attributes),
								});

							<?php } ?>

							const selectedBlock = wp.data.select('core/block-editor').getSelectedBlock();
							<?php
							// only include the drag/drop functions if required.
							if ( $img_drag_drop ) {
							?>

							function enableDragSort(listClass) {
								setTimeout(function () {
									const sortableLists = document.getElementsByClassName(listClass);
									Array.prototype.map.call(sortableLists, (list) => {
										enableDragList(list)
									});
								}, 300);
							}

							function enableDragList(list) {
								Array.prototype.map.call(list.children, (item) => {
									enableDragItem(item)
								});
							}

							function enableDragItem(item) {
								item.setAttribute('draggable', true)
								item.ondrag = handleDrag;
								item.ondragend = handleDrop;
							}

							function handleDrag(item) {
								const selectedItem = item.target,
									list = selectedItem.parentNode,
									x = event.clientX,
									y = event.clientY;

								selectedItem.classList.add('drag-sort-active');
								let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);

								if (list === swapItem.parentNode) {
									swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
									list.insertBefore(selectedItem, swapItem);
								}
							}

							function handleDrop(item) {

								item.target.classList.remove('drag-sort-active');

								const newOrder = [];
								let $parent = item.target.parentNode;
								let $field = $parent.dataset.field;
								let $imgs = JSON.parse('[' + props.attributes[$field] + ']');
								item.target.parentNode.classList.add('xxx');
								$children = $parent.children;

								Object.keys($children).forEach(function (key) {
									let $nKey = $children[key].dataset.index
									newOrder.push($imgs[$nKey]);
								});

								// @todo find out why we need to empty the value first otherwise the order is wrong.
								props.setAttributes({[$field]: ''});
								setTimeout(function () {
									props.setAttributes({[$field]: JSON.stringify(newOrder).replace('[', '').replace(']', '')});
								}, 100);

							}
							<?php } ?>

							if (typeof (props.attributes.styleid) !== 'undefined') {
								if (props.attributes.styleid == '') {
									props.setAttributes({'styleid': 'block-' + (Math.random() + 1).toString(36).substring(2)});
								}
							}

							<?php
							if(! empty( $this->options['block-edit-raw'] )) {
							echo $this->options['block-edit-raw']; // strings have to be in single quotes, may cause issues
						}else{
							?>

							function hasSelectedInnerBlock(props) {
								const select = wp.data.select('core/editor');
								const selected = select.getBlockSelectionStart();
								const inner = select.getBlock(props.clientId).innerBlocks;
								for (let i = 0; i < inner.length; i++) {
									if (inner[i].clientId === selected || inner[i].innerBlocks.length && hasSelectedInnerBlock(inner[i])) {
										return true;
									}
								}
								return false;
							};

							const parentBlocksIDs = wp.data.select('core/block-editor').getBlockParents(props.clientId);
							const parentBlocks = wp.data.select('core/block-editor').getBlocksByClientId(parentBlocksIDs);
// const isParentOfSelectedBlock = useSelect( ( select ) => wp.data.select( 'core/block-editor' ).hasSelectedInnerBlock( props.clientId, true ) ):
							const block = wp.data.select('core/block-editor').getBlocksByClientId(props.clientId);//.[0].innerBlocks;
							const childBlocks = block[0] == null ? '' : block[0].innerBlocks;

							var $value = '';
							<?php
							// if we have a post_type and a category then link them
							if( isset( $this->arguments['post_type'] ) && isset( $this->arguments['category'] ) && ! empty( $this->arguments['category']['post_type_linked'] ) ){
							?>
							if (typeof (prev_attributes[props.clientId]) != 'undefined' && selectedBlock && selectedBlock.clientId === props.clientId) {
								$pt = props.attributes.post_type;
								if (post_type_rest_slugs.length) {
									$value = post_type_rest_slugs[0][$pt];
								}
								var run = false;

								if ($pt != term_query_type) {
									run = true;
									term_query_type = $pt;
								}
								<?php
								$cat_path = '';
								if ( ! empty( $this->arguments['post_type']['onchange_rest']['path'] ) ) {
									$cat_path = esc_js( strip_tags( $this->arguments['post_type']['onchange_rest']['path'] ) );
									$cat_path = str_replace( array( '&quot;', '&#039;' ), array(
										'"',
										"'"
									), $cat_path );
								}
								?>
								/* taxonomies */
								if ($value && 'post_type' in prev_attributes[props.clientId] && 'category' in prev_attributes[props.clientId] && run) {
									if (!window.gdCPTCats) {
										window.gdCPTCats = [];
									}
									var gdCatPath = "<?php echo( ! empty( $cat_path ) ? $cat_path : "/wp/v2/" + $value + "/categories/?per_page=100" ); ?>";
									if (window.gdCPTCats[gdCatPath]) {
										terms = window.gdCPTCats[gdCatPath];
										while (taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.length) {
											taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.pop();
										}
										taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.push({
											label: "All",
											value: 0
										});
										jQuery.each(terms, function (key, val) {
											taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.push({
												label: val.name,
												value: val.id
											});
										});

										/* Setting the value back and fourth fixes the no update issue that sometimes happens where it won't update the options. */
										var $old_cat_value = props.attributes.category
										props.setAttributes({category: [0]});
										props.setAttributes({category: $old_cat_value});
									} else {
										wp.apiFetch({path: gdCatPath}).then(terms => {
											window.gdCPTCats[gdCatPath] = terms;
											while (taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.length) {
												taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.pop();
											}
											taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.push({
												label: "All",
												value: 0
											});
											jQuery.each(terms, function (key, val) {
												taxonomies_<?php echo str_replace( "-", "_", $this->id );?>.push({
													label: val.name,
													value: val.id
												});
											});

											/* Setting the value back and fourth fixes the no update issue that sometimes happens where it won't update the options. */
											var $old_cat_value = props.attributes.category
											props.setAttributes({category: [0]});
											props.setAttributes({category: $old_cat_value});

											return taxonomies_<?php echo str_replace( "-", "_", $this->id );?>;
										});
									}
								}

								/* sort_by */
								if ($value && 'post_type' in prev_attributes[props.clientId] && 'sort_by' in prev_attributes[props.clientId] && run) {
									if (!window.gdCPTSort) {
										window.gdCPTSort = [];
									}
									if (window.gdCPTSort[$pt]) {
										response = window.gdCPTSort[$pt];
										while (sort_by_<?php echo str_replace( "-", "_", $this->id );?>.length) {
											sort_by_<?php echo str_replace( "-", "_", $this->id );?>.pop();
										}

										jQuery.each(response, function (key, val) {
											sort_by_<?php echo str_replace( "-", "_", $this->id );?>.push({
												label: val,
												value: key
											});
										});

										// setting the value back and fourth fixes the no update issue that sometimes happens where it won't update the options.
										var $old_sort_by_value = props.attributes.sort_by
										props.setAttributes({sort_by: [0]});
										props.setAttributes({sort_by: $old_sort_by_value});
									} else {
										var data = {
											'action': 'geodir_get_sort_options',
											'post_type': $pt
										};
										jQuery.post(ajaxurl, data, function (response) {
											response = JSON.parse(response);
											window.gdCPTSort[$pt] = response;
											while (sort_by_<?php echo str_replace( "-", "_", $this->id );?>.length) {
												sort_by_<?php echo str_replace( "-", "_", $this->id );?>.pop();
											}

											jQuery.each(response, function (key, val) {
												sort_by_<?php echo str_replace( "-", "_", $this->id );?>.push({
													label: val,
													value: key
												});
											});

											// setting the value back and fourth fixes the no update issue that sometimes happens where it won't update the options.
											var $old_sort_by_value = props.attributes.sort_by
											props.setAttributes({sort_by: [0]});
											props.setAttributes({sort_by: $old_sort_by_value});

											return sort_by_<?php echo str_replace( "-", "_", $this->id );?>;
										});
									}
								}
							}
							<?php } ?>
							<?php
							$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : '';
							if(! empty( $current_screen->base ) && $current_screen->base === 'widgets'){
							echo 'const { deviceType } = "";';
						}else{
							?>
							/** Get device type const. */
							const wpVersion = '<?php global $wp_version; echo esc_attr( $wp_version ); ?>';
							const {deviceType} = typeof wp.data.useSelect !== 'undefined' ? wp.data.useSelect(select => {
								if (parseFloat(wpVersion) < 6.5) {
									const {__experimentalGetPreviewDeviceType} = select('core/edit-site') ? select('core/edit-site') : select('core/edit-post') ? select('core/edit-post') : '';
									return {
										deviceType: __experimentalGetPreviewDeviceType(),
									};
								} else {
									const editorSelect = select('core/editor');
									if (editorSelect) {
										return {
											deviceType: editorSelect.getDeviceType(),
										};
									} else {
										return {
											deviceType: 'Desktop', // Default value if device type is not available
										};
									}
								}
							}, []) : '';
							<?php } ?>
							var content = props.attributes.content;
							//console.log(props.attributes);
							var shortcode = '';

							window.sdBlockDebounceTimers = window.sdBlockDebounceTimers || {};

							function onChangeContent() {
								// Clear any existing timer to reset the delay
								clearTimeout(window.sdBlockDebounceTimers[props.clientId]);

								// --- START: NEW DYNAMIC DELAY LOGIC ---
								let delay = 500; // Default delay
								const longDelayAttributes = ['title', 'text', 'description']; // Add any text field attribute names here

								// Find which attribute key changed
								if (prev_attributes[props.clientId]) {
									for (const key in props.attributes) {
										if (props.attributes[key] !== prev_attributes[props.clientId][key]) {
											// If the changed attribute is NOT in our long-delay list, make the update faster.
											if (!longDelayAttributes.includes(key)) {
												delay = 100; // Use a much shorter delay for select dropdowns, toggles, etc.
											}
											break; // We only need to find the first change
										}
									}
								}
								// --- END: NEW DYNAMIC DELAY LOGIC ---
								console.log(delay);

								// Set a new timer with our calculated delay
								window.sdBlockDebounceTimers[props.clientId] = setTimeout(function () {
									var originalFunctionality = function () {
										// This is your original logic, now wrapped
										var $refresh = false;
										if (typeof (prev_attributes[props.clientId]) != 'undefined') {
											prev_attributes[props.clientId].content = props.attributes.content;
											prev_attributes[props.clientId].sd_shortcode = props.attributes.sd_shortcode;
										} else if (props.attributes.content === "") {
											$refresh = true;
										} else {
											if (props.attributes.content && props.attributes.content !== 'Please select the attributes in the block settings') {
												prev_attributes[props.clientId] = props.attributes;
											}
										}

										if ((!is_fetching && JSON.stringify(prev_attributes[props.clientId]) != JSON.stringify(props.attributes)) || $refresh) {
											is_fetching = true;
											var data = {
												'action': 'super_duper_output_shortcode',
												'shortcode': '<?php echo $this->options['base_id'];?>',
												'attributes': props.attributes,
												'block_parent_name': parentBlocks.length ? parentBlocks[parentBlocks.length - 1].name : '',
												'post_id': <?php global $post; echo isset( $post->ID ) ? $post->ID : 0;?>,
												'_ajax_nonce': '<?php echo wp_create_nonce( 'super_duper_output_shortcode' );?>'
											};
											jQuery.post(ajaxurl, data).then(function (env) {
												if (env == '') {
													env = "<div style='background:#0185ba33;padding: 10px;border: 4px #ccc dashed;'>" + "<?php _e( 'Placeholder for:', 'ayecode-connect' );?> " + props.name + "</div>";
												}
												<?php if(! empty( $this->options['nested-block'] )): ?>
												<?php else: ?>
												props.setAttributes({content: env});
												<?php endif; ?>
												is_fetching = false;
												prev_attributes[props.clientId] = props.attributes;
												if (typeof aui_init === "function") {
													aui_init();
												}
											});
										}
									};
									originalFunctionality();
								}, delay); // Use the dynamic delay

								return props.attributes.content;
							}

							<?php
							if ( ! empty( $this->options['block-edit-js'] ) ) {
								echo $this->options['block-edit-js']; // strings have to be in single quotes, may cause issues
							}




							if(empty( $this->options['block-save-return'] )){
							?>
							///////////////////////////////////////////////////////////////////////

							// build the shortcode.
							//	shortcode = "[<?php echo $this->options['base_id'];?>";
							shortcode = "<?php echo $this->options['base_id'];?>";
							<?php

							if ( ! empty( $this->arguments ) ) {

								foreach ( $this->arguments as $key => $args ) {
									// if($args['type']=='tabs'){continue;}

									// don't add metadata arguments
									if ( substr( $key, 0, 9 ) === 'metadata_' ) {
										continue;
									}
									/*
								 ?>
								 if (props.attributes.hasOwnProperty("<?php echo esc_attr( $key );?>")) {
									 if ('<?php echo esc_attr( $key );?>' == 'html') {
									 } else if ('<?php echo esc_attr( $args['type'] );?>' == 'image_xy') {
										 props.attributes.<?php echo esc_attr( $key );?>.length && ( props.attributes.<?php echo esc_attr( $key );?>.x.length || props.attributes.<?php echo esc_attr( $key );?>.y.length ) ? " <?php echo esc_attr( $key );?>='{x:" + props.attributes.<?php echo esc_attr( $key );?>.x + ",y:"+props.attributes.<?php echo esc_attr( $key );?>.y +"}' " : "";
									 } else {
										   props.attributes.<?php echo esc_attr( $key );?>.toString().replace('\'','&#39;');
									 }
								 }
								 <?php
									*/
								}
							}

							?>
							//shortcode += "]";

							if (shortcode) {

								// can cause a react exception when selecting multile blocks of the same type when the settings are not the same
								if (props.attributes.sd_shortcode !== shortcode) {
									props.setAttributes({sd_shortcode: shortcode});
								}


								<?php
								if ( ! empty( $this->options['nested-block'] ) || ! empty( $this->arguments['html'] ) ) {
									echo "props.setAttributes({sd_shortcode_close: '" . esc_attr( $this->options['base_id'] ) . "'});";
//										echo "props.setAttributes({sd_shortcode_close: '[/".esc_attr( $this->options['base_id'] )."]'});";
								}
								?>
							}


							///////////////////////////////////////////////////////////////////////
							<?php
							} // end nested block check


							// set dynamic filed
							if ( ! empty( $this->options['block-dynamic-field'] ) ) {
								echo "props.setAttributes({ sd_dynamic_field: '" . esc_attr( $this->options['block-dynamic-field'] ) . "' });";
							}
							?>

							return [

								el(wp.blockEditor.BlockControls, {key: 'controls'},

									<?php if($show_alignment){?>
									el(
										wp.blockEditor.AlignmentToolbar,
										{
											value: props.attributes.alignment,
											onChange: function (alignment) {
												props.setAttributes({alignment: alignment})
											}
										}
									),
									<?php }?>

								),

								el(wp.blockEditor.InspectorControls, {key: 'inspector'},

									<?php

									if(! empty( $this->arguments )){

									if ( $show_advanced ) {
									?>
									el('div', {
											style: {'padding-left': '16px', 'padding-right': '16px'}
										},
										el(
											wp.components.ToggleControl,
											{
												label: 'Show Advanced Settings?',
												checked: props.attributes.show_advanced,
												onChange: function (show_advanced) {
													props.setAttributes({show_advanced: !props.attributes.show_advanced})
												}
											}
										)
									)
									,
									<?php
									}

									$arguments = $this->group_arguments( $this->arguments );
									$block_group_tabs = ! empty( $this->options['block_group_tabs'] ) ? $this->group_block_tabs( $this->options['block_group_tabs'], $arguments ) : array();

									// Do we have sections?
									$has_sections = $arguments == $this->arguments ? false : true;

									if($has_sections){
									$panel_count = 0;
									$open_tab = '';

									$open_tab_groups = array();
									$used_tabs = array();

									foreach ( $arguments as $key => $args ) {
									$close_tab = false;
									$close_tabs = false;

									if ( ! empty( $block_group_tabs ) ) {
										foreach ( $block_group_tabs as $tab_name => $tab_args ) {
											if ( in_array( $key, $tab_args['groups'] ) ) {
												$open_tab_groups[] = $key;

												if ( $open_tab != $tab_name ) {
													$tab_args['tab']['tabs_open'] = $open_tab == '' ? true : false;
													$tab_args['tab']['open']      = true;

													$this->block_tab_start( '', $tab_args );
													$open_tab    = $tab_name;
													$used_tabs[] = $tab_name;
												}

												if ( $open_tab_groups == $tab_args['groups'] ) {
													$close_tab       = true;
													$open_tab_groups = array();

													if ( $used_tabs == array_keys( $block_group_tabs ) ) {
														$close_tabs = true;
													}
												}
											}
										}
									}
									?>
									el(wp.components.PanelBody, {
											title: '<?php esc_attr_e( $key ); ?>',
											initialOpen: <?php if ( $panel_count ) {
												echo "false";
											} else {
												echo "true";
											}?>
										},
										<?php
										foreach ( $args as $k => $a ) {
											$this->block_tab_start( $k, $a );
											$this->block_row_start( $k, $a );
											$this->build_block_arguments( $k, $a );
											$this->block_row_end( $k, $a );
											$this->block_tab_end( $k, $a );
										}
										?>
									),
									<?php
									$panel_count ++;

									if ( $close_tab || $close_tabs ) {
										$tab_args = array(
											'tab' => array(
												'tabs_close' => $close_tabs,
												'close'      => true,
											)

										);
										$this->block_tab_end( '', $tab_args );
//											echo '###close'; print_r($tab_args);
										$panel_count = 0;
									}
									//

									}
									}else {
									?>
									el(wp.components.PanelBody, {
											title: '<?php esc_attr_e( "Settings", 'ayecode-connect' ); ?>',
											initialOpen: true
										},
										<?php
										foreach ( $this->arguments as $key => $args ) {
											$this->block_row_start( $key, $args );
											$this->build_block_arguments( $key, $args );
											$this->block_row_end( $key, $args );
										}
										?>
									),
									<?php
									}

									}
									?>

								),

								<?php
								// If the user sets block-output array then build it
								if ( ! empty( $this->options['block-output'] ) ) {
								$this->block_element( $this->options['block-output'] );
							}elseif ( ! empty( $this->options['block-edit-return'] ) ) {
								echo $this->options['block-edit-return'];
							}else{
								// if no block-output is set then we try and get the shortcode html output via ajax.
								$block_edit_wrap_tag = ! empty( $this->options['block_edit_wrap_tag'] ) ? esc_attr( $this->options['block_edit_wrap_tag'] ) : 'div';
								?>
								el('<?php echo esc_attr( $block_edit_wrap_tag ); ?>', wp.blockEditor.useBlockProps({
									dangerouslySetInnerHTML: {__html: onChangeContent()},
									className: props.className,
									<?php //if(isset($this->arguments['visibility_conditions'])){ echo 'dataVisibilityConditionSD: props.visibility_conditions ? true : false,';} //@todo we need to implement this in the other outputs also ?>
									style: {'minHeight': '30px'}
								}))
								<?php
								}
								?>
							]; // end return

							<?php
							} // end block-edit-raw else
							?>
						},

						// The "save" property must be specified and must be a valid function.
						save: function (props) {

							var attr = props.attributes;
							var align = '';

							// build the shortcode.
							var content = "[<?php echo $this->options['base_id'];?>";
							$html = '';
							<?php

							if(! empty( $this->arguments )){

							foreach($this->arguments as $key => $args){
							// if($args['type']=='tabs'){continue;}

							// don't add metadata arguments
							if ( substr( $key, 0, 9 ) === 'metadata_' ) {
								continue;
							}


							// Get the attribute value into a variable for easy and safe checking
							$attributeValue = 'attr.' . esc_attr( $key );
							?>
							// Check if the attribute exists and has a meaningful value before processing
							if (<?php echo $attributeValue; ?> !==
							undefined && <?php echo $attributeValue; ?> !== null && <?php echo $attributeValue; ?> !== ''
						)
							{
								if ('<?php echo esc_attr( $key );?>' == 'html') {
									$html = <?php echo $attributeValue; ?>;
								} else if ('<?php echo esc_attr( $args['type'] );?>' == 'image_xy') {
									// Also ensure the inner properties of image_xy are valid
									if (<?php echo $attributeValue; ?>.
									x || <?php echo $attributeValue; ?>.
									y
								)
									{
										content += " <?php echo esc_attr( $key );?>='{x:" + <?php echo $attributeValue; ?>.
										x + ",y:" +<?php echo $attributeValue; ?>.
										y + "}' ";
									}
								} else {
									// Now it's safe to call .toString()
									content += " <?php echo esc_attr( $key );?>='" + <?php echo $attributeValue; ?>.
									toString().replace('\'', '&#39;') + "' ";
								}
							}

							<?php
							}
							}

							?>
							content += "]";
							content = '';

							<?php
							//                            if(!empty($this->options['nested-block'])){
							//                                ?>
//                                $html = 'el( InnerBlocks.Content )';
//                                <?php
							//                            }
							?>
							// if has html element
							if ($html) {
								//content += $html + "[/<?php echo $this->options['base_id'];?>]";
							}

							// @todo should we add inline style here or just css classes?
							if (attr.alignment) {
								if (attr.alignment == 'left') {
									align = 'alignleft';
								}
								if (attr.alignment == 'center') {
									align = 'aligncenter';
								}
								if (attr.alignment == 'right') {
									align = 'alignright';
								}
							}

							<?php
							//							if(!empty($this->options['nested-block'])){
							//                                ?x>
							//                              return el(
							//                                    'div',
							//                                    { className: props.className,
							//                                        style: {'minHeight': '300px','position':'relative','overflow':'hidden','backgroundImage': 'url(https://s.w.org/images/core/5.5/don-quixote-06.jpg)'}
							//                                    },
							//                                    el( InnerBlocks.Content ),
							//                                    el('div', {dangerouslySetInnerHTML: {__html: content}, className: align})
							//                                );
							//                                <x?php
							//							}else

							if(! empty( $this->options['block-output'] )){
							//                               echo "return";
							//                               $this->block_element( $this->options['block-output'], true );
							//                               echo ";";

							?>
							return el(
								'',
								{},
								// el('', {dangerouslySetInnerHTML: {__html: content}}),
								<?php $this->block_element( $this->options['block-output'], true ); ?>
								// el('', {dangerouslySetInnerHTML: {__html: "[/<?php echo $this->options['base_id'];?>]"}})
							);
							<?php

							}elseif ( ! empty( $this->options['block-save-return'] ) ) {
							echo 'return ' . $this->options['block-save-return'];
						}elseif(! empty( $this->options['nested-block'] )){
							?>
							return el(
								'',
								{},
								el('', {dangerouslySetInnerHTML: {__html: content + "\n"}}),
								InnerBlocks.Content ? el(InnerBlocks.Content) : '', // @todo i think we need a comma here
								//  el('', {dangerouslySetInnerHTML: {__html: "[/<?php echo $this->options['base_id'];?>]"}})
							);
							<?php
							}elseif ( ! empty( $this->options['block-save-return'] ) ) {
							echo "return " . $this->options['block-edit-return'] . ";";
						}elseif(isset( $this->options['block-wrap'] ) && $this->options['block-wrap'] == ''){
							?>
							return content;
							<?php
							}else{
							?>
							var block_wrap = 'div';
							if (attr.hasOwnProperty("block_wrap")) {
								block_wrap = attr.block_wrap;
							}
							return el(block_wrap, wp.blockEditor.useBlockProps.save({
								dangerouslySetInnerHTML: {__html: content},
								className: align
							}));
							<?php
							}
							?>


						}
					});
				})(
					window.wp.blocks,
					window.wp.element,
					window.wp.blockEditor
				);

			});
		</script>
		<?php
		$output = ob_get_clean();

		/*
		 * We only add the <script> tags for code highlighting, so we strip them from the output.
		 */

		return str_replace( array(
			'<script>',
			'</script>'
		), '', $output );
	}
}
