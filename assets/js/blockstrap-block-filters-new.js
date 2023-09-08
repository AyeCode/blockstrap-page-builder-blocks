const {addFilter} = wp.hooks;

/**
 * When this function gets run by the addfilter
 * hook below, the filter passes it the block settings
 * or config file.
 */
const blockstrapBlocksFilterBlocks = (settings) => {
	blockstrap_blocks_add_editor_compat_class();
	if (settings.name !== 'core/post-template') {
		return settings
	}

	var external_wp_blockEditor_namespaceObject = window["wp"]["blockEditor"];
	var external_wp_element_namespaceObject = window["wp"]["element"];
	// var external_wp_coreData_namespaceObject = window["wp"]["coreData"];
	// var external_wp_data_namespaceObject = window["wp"]["data"];
	var external_wp_components_namespaceObject = window["wp"]["components"];
	;// CONCATENATED MODULE: external ["wp","i18n"]
	var external_wp_i18n_namespaceObject = window["wp"]["i18n"];
	;// CONCATENATED MODULE: external ["wp","blockEditor"]
	var external_wp_blockEditor_namespaceObject = window["wp"]["blockEditor"];
	;// CONCATENATED MODULE: external ["wp","serverSideRender"]
	var external_wp_serverSideRender_namespaceObject = window["wp"]["serverSideRender"];

	;// CONCATENATED MODULE: external ["wp","url"]
	var external_wp_url_namespaceObject = window["wp"]["url"];
	;// CONCATENATED MODULE: external ["wp","coreData"]
	var external_wp_coreData_namespaceObject = window["wp"]["coreData"];
	;// CONCATENATED MODULE: external ["wp","data"]
	var external_wp_data_namespaceObject = window["wp"]["data"];

	var external_wp_blocks_namespaceObject = window["wp"]["blocks"];
	;// CONCATENATED MODULE: external ["wp","element"]
	var external_wp_element_namespaceObject = window["wp"]["element"];
	;// CONCATENATED MODULE: external ["wp","primitives"]
	var external_wp_primitives_namespaceObject = window["wp"]["primitives"];
	;// CONCATENATED MODULE: ./node_modules/@wordpress/icons/build-module/library/archive.js


	function PostTemplateBlockPreview({
			  blocks,
			  blockContextId,
			  isHidden,
			  setActiveBlockContextId
		  }) {
		const blockPreviewProps = (0, external_wp_blockEditor_namespaceObject.__experimentalUseBlockPreview)({
			blocks,
			props: {
				className: 'wp-block-post'
			}
		});

		const handleOnClick = () => {
			setActiveBlockContextId(blockContextId);
		};

		const style = {
			display: isHidden ? 'none' : undefined
		};
		return (0, external_wp_element_namespaceObject.createElement)("li", {
			...blockPreviewProps,
			tabIndex: 0 // eslint-disable-next-line jsx-a11y/no-noninteractive-element-to-interactive-role
			,
			role: "button",
			onClick: handleOnClick,
			onKeyPress: handleOnClick,
			style: style
		});
	}

	const MemoizedPostTemplateBlockPreview = (0, external_wp_element_namespaceObject.memo)(PostTemplateBlockPreview);

	const post_template_edit_TEMPLATE = [['core/post-title'], ['core/post-date'], ['core/post-excerpt']];

	function PostTemplateInnerBlocks() {
		const innerBlocksProps = (0, external_wp_blockEditor_namespaceObject.useInnerBlocksProps)({
			className: 'wp-block-post col mb-4'
		}, {
			template: post_template_edit_TEMPLATE,
			__unstableDisableLayoutClassNames: true
		});
		return (0, external_wp_element_namespaceObject.createElement)("li", {
			...innerBlocksProps
		});
	}

	const newSettings = {
		...settings,
		edit(_ref2) {

			let {
				setAttributes,
				clientId,
				context: {
					query: {
						perPage,
						offset = 0,
						postType,
						order,
						orderBy,
						author,
						search,
						exclude,
						sticky,
						inherit,
						taxQuery,
						parents,
						pages,
						// We gather extra query args to pass to the REST API call.
						// This way extenders of Query Loop can add their own query args,
						// and have accurate previews in the editor.
						// Noting though that these args should either be supported by the
						// REST API or be handled by custom REST filters like `rest_{$this->post_type}_query`.
						...restQueryArgs
					} = {},
					queryContext = [{
						page: 1
					}],
					templateSlug,
					previewPostType
				},
				attributes: {
					layout
				},
				__unstableLayoutClassNames
			} = _ref2;

			const {
				type: layoutType,
				columnCount = 3
			} = layout || {};
			const [{
				page
			}] = queryContext;
			const [activeBlockContextId, setActiveBlockContextId] = (0, external_wp_element_namespaceObject.useState)();
			const {
				posts,
				blocks
			} = (0, external_wp_data_namespaceObject.useSelect)(select => {
				const {
					getEntityRecords,
					getTaxonomies
				} = select(external_wp_coreData_namespaceObject.store);
				const {
					getBlocks
				} = select(external_wp_blockEditor_namespaceObject.store);
				const taxonomies = getTaxonomies({
					type: postType,
					per_page: -1,
					context: 'view'
				});
				const templateCategory = inherit && templateSlug?.startsWith('category-') && getEntityRecords('taxonomy', 'category', {
					context: 'view',
					per_page: 1,
					_fields: ['id'],
					slug: templateSlug.replace('category-', '')
				});
				const query = {
					offset: perPage ? perPage * (page - 1) + offset : 0,
					order,
					orderby: orderBy
				}; // There is no need to build the taxQuery if we inherit.

				if (taxQuery && !inherit) {
					// We have to build the tax query for the REST API and use as
					// keys the taxonomies `rest_base` with the `term ids` as values.
					const builtTaxQuery = Object.entries(taxQuery).reduce((accumulator, [taxonomySlug, terms]) => {
						const taxonomy = taxonomies?.find(({
															   slug
														   }) => slug === taxonomySlug);

						if (taxonomy?.rest_base) {
							accumulator[taxonomy?.rest_base] = terms;
						}

						return accumulator;
					}, {});

					if (!!Object.keys(builtTaxQuery).length) {
						Object.assign(query, builtTaxQuery);
					}
				}

				if (perPage) {
					query.per_page = perPage;
				}

				if (author) {
					query.author = author;
				}

				if (search) {
					query.search = search;
				}

				if (exclude?.length) {
					query.exclude = exclude;
				}

				if (parents?.length) {
					query.parent = parents;
				} // If sticky is not set, it will return all posts in the results.
				// If sticky is set to `only`, it will limit the results to sticky posts only.
				// If it is anything else, it will exclude sticky posts from results. For the record the value stored is `exclude`.


				if (sticky) {
					query.sticky = sticky === 'only';
				} // If `inherit` is truthy, adjust conditionally the query to create a better preview.


				if (inherit) {
					// Change the post-type if needed.
					if (templateSlug?.startsWith('archive-')) {
						query.postType = templateSlug.replace('archive-', '');
						postType = query.postType;
					} else if (templateCategory) {
						query.categories = templateCategory[0]?.id;
					}
				} // When we preview Query Loop blocks we should prefer the current
				// block's postType, which is passed through block context.


				const usedPostType = previewPostType || postType;
				return {
					posts: getEntityRecords('postType', usedPostType, {
						...query,
						...restQueryArgs
					}),
					blocks: getBlocks(clientId)
				};
			}, [perPage, page, offset, order, orderBy, clientId, author, search, postType, exclude, sticky, inherit, templateSlug, taxQuery, parents, restQueryArgs, previewPostType]);
			const blockContexts = (0, external_wp_element_namespaceObject.useMemo)(() => posts?.map(post => ({
				postType: post.type,
				postId: post.id
			})), [posts]);

			let colCount = layoutType === 'grid' ? columnCount : 1;
			let colMd = ' row-cols-md-' + colCount;
			let colSm = ' row-cols-sm-' + colCount > 1 ? (colCount - 1) : colCount;
			let rowClass = 'row aaa list-unstyled row-cols-1' + colSm + colMd;

			const blockProps = (0, external_wp_blockEditor_namespaceObject.useBlockProps)({
				className: rowClass
			});

			if (!posts) {
				return (0, external_wp_element_namespaceObject.createElement)("p", {
					...blockProps
				}, (0, external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.Spinner, null));
			}

			if (!posts.length) {
				return (0, external_wp_element_namespaceObject.createElement)("p", {
					...blockProps
				}, " ", (0, external_wp_i18n_namespaceObject.__)('No results found.'));
			}

			const setDisplayLayout = newDisplayLayout => setAttributes({
				layout: {
					...layout,
					...newDisplayLayout
				}
			});

			const list = (0, external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.SVG, {
				viewBox: "0 0 24 24",
				xmlns: "http://www.w3.org/2000/svg"
			}, (0, external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.Path, {
				d: "M4 4v1.5h16V4H4zm8 8.5h8V11h-8v1.5zM4 20h16v-1.5H4V20zm4-8c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2z"
			}));
			/* harmony default export */
			var library_list = (list);

			const grid = (0, external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.SVG, {
				xmlns: "http://www.w3.org/2000/svg",
				viewBox: "0 0 24 24"
			}, (0, external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.Path, {
				d: "m3 5c0-1.10457.89543-2 2-2h13.5c1.1046 0 2 .89543 2 2v13.5c0 1.1046-.8954 2-2 2h-13.5c-1.10457 0-2-.8954-2-2zm2-.5h6v6.5h-6.5v-6c0-.27614.22386-.5.5-.5zm-.5 8v6c0 .2761.22386.5.5.5h6v-6.5zm8 0v6.5h6c.2761 0 .5-.2239.5-.5v-6zm0-8v6.5h6.5v-6c0-.27614-.2239-.5-.5-.5z",
				fillRule: "evenodd",
				clipRule: "evenodd"
			}));
			/* harmony default export */
			var library_grid = (grid);

			const displayLayoutControls = [{
				icon: library_list,
				title: (0, external_wp_i18n_namespaceObject.__)('List view'),
				onClick: () => setDisplayLayout({
					type: 'default'
				}),
				isActive: layoutType === 'default' || layoutType === 'constrained'
			}, {
				icon: library_grid,
				title: (0, external_wp_i18n_namespaceObject.__)('Grid view'),
				onClick: () => setDisplayLayout({
					type: 'grid',
					columnCount
				}),
				isActive: layoutType === 'grid'
			}]; // To avoid flicker when switching active block contexts, a preview is rendered
			// for each block context, but the preview for the active block context is hidden.
			// This ensures that when it is displayed again, the cached rendering of the
			// block preview is used, instead of having to re-render the preview from scratch.

			return (0, external_wp_element_namespaceObject.createElement)(external_wp_element_namespaceObject.Fragment, null, (0, external_wp_element_namespaceObject.createElement)(external_wp_blockEditor_namespaceObject.BlockControls, null, (0, external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.ToolbarGroup, {
				controls: displayLayoutControls
			})), (0, external_wp_element_namespaceObject.createElement)("ul", {
				...blockProps
			}, blockContexts && blockContexts.map(blockContext => (0, external_wp_element_namespaceObject.createElement)(external_wp_blockEditor_namespaceObject.BlockContextProvider, {
				key: blockContext.postId,
				value: blockContext
			}, blockContext.postId === (activeBlockContextId || blockContexts[0]?.postId) ? (0, external_wp_element_namespaceObject.createElement)(PostTemplateInnerBlocks, null) : null, (0, external_wp_element_namespaceObject.createElement)(MemoizedPostTemplateBlockPreview, {
				blocks: blocks,
				blockContextId: blockContext.postId,
				setActiveBlockContextId: setActiveBlockContextId,
				isHidden: blockContext.postId === (activeBlockContextId || blockContexts[0]?.postId)
			})))));

		},
		save(props) {
			return (
				settings.save(props)
			)
		}
	}

	return newSettings; // now with pink backgrounds!
}

addFilter(
	'blocks.registerBlockType', // hook name, very important!
	'blockstrap-blocks/blockstrap-blocks-filter-blocks', // your name, very arbitrary!
	blockstrapBlocksFilterBlocks // function to run
)


function blockstrap_blocks_add_editor_compat_class() {
	jQuery('.edit-post-visual-editor').addClass('bsui');
}

/*
Remove the "Apply Globally" button as it adds a new advanced tab in block settings and is not used by any of our blocks.
@todo remove this once they add an option to remove per block https://github.com/WordPress/gutenberg/issues/47256
 */
function blockstrap_blocks_remove_gloabl_styles() {
	wp.hooks.removeFilter(
		'editor.BlockEdit',
		'core/edit-site/push-changes-to-global-styles'
	);
}

blockstrap_blocks_remove_gloabl_styles();


wp.domReady(function () {
	blockstrap_blocks_remove_gloabl_styles();
	setTimeout(function () {
		blockstrap_blocks_remove_gloabl_styles();
	}, 5000);
});

//
// function blockstrap_blocks_add_post_editor_root_class(){
// 	jQuery('.is-root-container').addClass('container');
// 	console.log('add root class');
// }
//
// wp.domReady( function() {
// 	blockstrap_blocks_add_post_editor_root_class();
// 	setTimeout(function(){
// 		blockstrap_blocks_add_post_editor_root_class();
// 	}, 5000);
//
// 	window._wpLoadBlockEditor.then( function() {
//
// 		const getDeviceType = () => wp.data.select('core/edit-post').__experimentalGetPreviewDeviceType();
//
// 		let deviceType = wp.data.select('core/edit-post').__experimentalGetPreviewDeviceType();
//
// 		wp.data.subscribe(() => {
//
// 			// get the current postFormat
// 			const newDeviceType = getDeviceType();
//
// 			// only do something if postFormat has changed.
// 			if( deviceType !== newDeviceType) {
//
// 				// Do whatever you want after postFormat has changed
// 				blockstrap_blocks_add_post_editor_root_class();
// 				setTimeout(function(){
// 					blockstrap_blocks_add_post_editor_root_class();
// 				}, 500);
//
// 			}
//
// 			// update the postFormat variable.
// 			deviceType = newDeviceType;
//
// 		});
//
// 	});
//
// } );


// custom-link-in-toolbar.js
// wrapped into IIFE - to leave global space clean.

/*
wp.domReady( function() {
( function( window, wp ){
	//alert(1);

	// just to keep it cleaner - we refer to our link by id for speed of lookup on DOM.
	var link_id = 'Your_Super_Custom_Link';

	// prepare our custom link's html.
	var link_html = '<div class="bsui"><button id="' + link_id + '" class="btn btn-sm btn-primary" onclick="bpbb_open_template_modal()"  ><i class="fas fa-th-large mr-2 me-2"></i> BlockStrap Templates</button></div>';

	// check if gutenberg's editor root element is present.
	var editorEl = document.getElementById( 'editor' );
	if( !editorEl ){ // do nothing if there's no gutenberg root element on page.
		return;
	}

	var unsubscribe = wp.data.subscribe( function () {
		setTimeout( function () {//alert(2);
			if ( !document.getElementById( link_id ) ) {//alert(3);
				var toolbalEl = editorEl.querySelector( '.edit-post-header-toolbar__left' );
				if( toolbalEl instanceof HTMLElement ){
					toolbalEl.insertAdjacentHTML( 'beforeend', link_html );
				}
			}
		}, 1 )
	} );
	// unsubscribe is a function - it's not used right now
	// but in case you'll need to stop this link from being reappeared at any point you can just call unsubscribe();

} )( window, wp )

} );

function bpbb_open_template_modal(){
	var $loading = '<div class="d-flex align-items-center justify-content-center h-100"><div class="spinner-border text-muted fs-2" role="status">\n' +
		'  <span class="visually-hidden">Loading...</span>\n' +
		'</div></div>';
	aui_modal('Templates',$loading,'',true,'','modal-fullscreen p-5','');
	bpbb_get_template_html();
}


function bpbb_get_template_html($page){
	var data = {
		'action': 'bpbb_get_templates',
		'whatever': 123      // We pass php values differently!
	};
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajaxurl, data, function(response) {
		jQuery('#aui-modal .modal-body').html(response);
	});
}
*/
