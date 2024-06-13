/**
 * WordPress can't detect our block names when registered via PHP, so we provide this field where their scan function can read the blocks.
 *
 * This file is not used in the plugin at all.
 *
 * @package BlockStrap Page Builder Blocks
 */

/*
registerBlockType( 'blockstrap/blockstrap-widget-archive-actions', { title: 'BS > Archive Actions' } );
registerBlockType( 'blockstrap/blockstrap-widget-archive-title', { title: 'BS > Archive Title' } );
registerBlockType( 'blockstrap/blockstrap-widget-breadcrumb', { title: 'BS > BS > Breadcrumb' } );
registerBlockType( 'blockstrap/blockstrap-widget-button', { title: 'BS > Button' } );
registerBlockType( 'blockstrap/blockstrap-widget-container', { title: 'BS > Container' } );
registerBlockType( 'blockstrap/blockstrap-widget-counter', { title: 'BS > Counter' } );
registerBlockType( 'blockstrap/blockstrap-widget-gallery', { title: 'BS > Gallery' } );
registerBlockType( 'blockstrap/blockstrap-widget-heading', { title: 'BS > Heading' } );
registerBlockType( 'blockstrap/blockstrap-widget-icon-box', { title: 'BS > Icon Box' } );
registerBlockType( 'blockstrap/blockstrap-widget-image', { title: 'BS > Image' } );
registerBlockType( 'blockstrap/blockstrap-widget-map', { title: 'BS > Map' } );
registerBlockType( 'blockstrap/blockstrap-widget-nav', { title: 'BS > Nav' } );
registerBlockType( 'blockstrap/blockstrap-widget-nav-dropdown', { title: 'BS > Nav Dropdown' } );
registerBlockType( 'blockstrap/blockstrap-widget-nav-item', { title: 'BS > Nav Item' } );
registerBlockType( 'blockstrap/blockstrap-widget-navbar', { title: 'BS > Navbar' } );
registerBlockType( 'blockstrap/blockstrap-widget-navbar-brand', { title: 'BS > Navbar Brand' } );
registerBlockType( 'blockstrap/blockstrap-widget-pagination', { title: 'BS > Pagination' } );
registerBlockType( 'blockstrap/blockstrap-widget-post-excerpt', { title: 'BS > Post Excerpt' } );
registerBlockType( 'blockstrap/blockstrap-widget-post-info', { title: 'BS > Post Info' } );
registerBlockType( 'blockstrap/blockstrap-widget-post-title', { title: 'BS > Post Title' } );
registerBlockType( 'blockstrap/blockstrap-widget-search', { title: 'BS > Search' } );
registerBlockType( 'blockstrap/blockstrap-widget-shape-divider', { title: 'BS > Shape Divider' } );
registerBlockType( 'blockstrap/blockstrap-widget-share', { title: 'BS > Share' } );
registerBlockType( 'blockstrap/blockstrap-widget-skip-links', { title: 'BS > Skip Links' } );
registerBlockType( 'blockstrap/blockstrap-widget-tab', { title: 'BS > Tab' } );
registerBlockType( 'blockstrap/blockstrap-widget-tabs', { title: 'BS > Tabs' } );
registerBlockType( 'blockstrap/blockstrap-widget-accordion', { title: 'BS > Accordion' } );
registerBlockType( 'blockstrap/blockstrap-widget-accordion-item', { title: 'BS > Accordion Item' } );
registerBlockType( 'blockstrap/blockstrap-widget-contact', { title: 'BS > Contact Form' } );
registerBlockType( 'blockstrap/blockstrap-widget-rating', { title: 'BS > Rating' } );
registerBlockType( 'blockstrap/blockstrap-widget-scroll-top', { title: 'BS > Scroll Top' } );
registerBlockType( 'blockstrap/blockstrap-widget-offcanvas', { title: 'BS > Offcanvas' } );
*/


el(
	'div',
	wp.blockEditor.useBlockProps(
		{
			//dangerouslySetInnerHTML: {__html: onChangeContent()},
			style: sd_build_aui_styles( props.attributes ),
			className: sd_build_aui_class( props.attributes ),

		}
	),
	el(
		'nav',
		{className: props.attributes.tabs_greedy ? 'greedy' : ''},
		el(
			'ul',
			{className: (props.attributes.tabs_style == 'nav-pills' ? 'border-0 ' : '') + 'nav nav-tabs ' + props.attributes.tabs_style + ' ' + props.attributes.tab_size + ' mb-' + props.attributes.tabs_head_mb + ' ' + sd_build_aui_class( {flex_justify_content : props.attributes.tabs_flex_justify_content,flex_justify_content_md : props.attributes.tabs_flex_justify_content_md,flex_justify_content_lg : props.attributes.tabs_flex_justify_content_lg} ) ,role : 'tablist'},
			(function() {
				let tabs       = [];
				let tabs_array = [];

				if (childBlocks.length) {
					let active_index = 0

					childBlocks.map(
						(tab, index) => (
						tabs_array.push( {name:tab.attributes.text,id:tab.attributes.anchor} ),
						active_index = tab.clientId === wp.data.select( 'core/editor' ).getBlockSelectionStart() || hasSelectedInnerBlock( tab ) ? index : active_index
						)
					);

					props.setAttributes(
						{
							tabs_head_array: JSON.stringify( tabs_array ).replace( '[','' ).replace( ']','' )
						}
					);

					childBlocks.map(
						(tab, index) => (
						//console.log( 'tab:' + index )
						tabs.push(
							el(
								'li',
								{className:'nav-item'},
								el(
									'button',
									{
										className: active_index === index ? 'nav-link active ' + sd_build_aui_class( {rounded_size : props.attributes.tabs_rounded_size} ) : 'nav-link ' + sd_build_aui_class( {rounded_size : props.attributes.tabs_rounded_size} ),
										'data-{$bs5}toggle': 'tab',
										type: 'button',
										role: 'tab',
										'aria-selected': false,
										'aria-controls': 'nav-profile',
										'data-{$bs5}target':  '#block-' + tab.clientId
									},
									tab.attributes.text ? tab.attributes.text : 'Tab ' + (index + 1)
								)
							)
						)
						)
					);
				}

				return tabs;
			})(),
		),
	),
	el(
		'div',
		wp.blockEditor.useInnerBlocksProps(
			{className: 'tab-content'},
			{orientation: 'horizontal',inner_element: 'div',
				template:
				[
				[ 'blockstrap/blockstrap-widget-tab', {text:'Tab1',anchor:'tab-1'}, [[ 'core/paragraph', { placeholder: 'Add your blocks here' } ],] ],
				[ 'blockstrap/blockstrap-widget-tab', {text:'Tab2',anchor:'tab-2'}, [[ 'core/paragraph', { placeholder: 'Add your blocks here' } ],] ],

				]
				,
			},
		)
	)
)
