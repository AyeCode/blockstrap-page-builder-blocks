const { addFilter } = wp.hooks;

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

	function _extends() {
		_extends = Object.assign ? Object.assign.bind() : function (target) {
			for (var i = 1; i < arguments.length; i++) {
				var source = arguments[i];

				for (var key in source) {
					if (Object.prototype.hasOwnProperty.call(source, key)) {
						target[key] = source[key];
					}
				}
			}

			return target;
		};
		return _extends.apply(this, arguments);
	}

	function PostTemplateBlockPreview(_ref) {
		let {
			blocks,
			blockContextId,
			isHidden,
			setActiveBlockContextId
		} = _ref;
		const blockPreviewProps = (0,external_wp_blockEditor_namespaceObject.__experimentalUseBlockPreview)({
			blocks,
			props: {
				className: 'wp-block-post  col mb-4'
			}
		});

		const handleOnClick = () => {
			setActiveBlockContextId(blockContextId);
		};

		const style = {
			display: isHidden ? 'none' : undefined
		};
		return (0,external_wp_element_namespaceObject.createElement)("li", _extends({}, blockPreviewProps, {
			tabIndex: 0 // eslint-disable-next-line jsx-a11y/no-noninteractive-element-to-interactive-role
			,
			role: "button",
			onClick: handleOnClick,
			onKeyPress: handleOnClick,
			style: style
		}));
	}

	const MemoizedPostTemplateBlockPreview = (0,external_wp_element_namespaceObject.memo)(PostTemplateBlockPreview);

	const post_template_edit_TEMPLATE = [['core/post-title'], ['core/post-date'], ['core/post-excerpt']];

	function PostTemplateInnerBlocks() {
		const innerBlocksProps = (0,external_wp_blockEditor_namespaceObject.useInnerBlocksProps)({
			className: 'wp-block-post col mb-4'
		}, {
			template: post_template_edit_TEMPLATE
		});
		return (0,external_wp_element_namespaceObject.createElement)("li", innerBlocksProps);
	}

	console.log(settings);




	const newSettings = {
		...settings,
		edit(_ref2) {

			let {
				clientId,
				context: {
					query: {
						perPage,
						offset,
						postType,
						order,
						orderBy,
						author,
						search,
						exclude,
						sticky,
						inherit,
						taxQuery
					} = {},
					queryContext = [{
						page: 1
					}],
					templateSlug,
					displayLayout: {
						type: layoutType = 'flex',
						columns = 1
					} = {}
				}
			} = _ref2;
			const [{
				page
			}] = queryContext;
			const [activeBlockContextId, setActiveBlockContextId] = (0,external_wp_element_namespaceObject.useState)();
			const {
				posts,
				blocks
			} = (0,external_wp_data_namespaceObject.useSelect)(select => {
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
				const query = {
					offset: perPage ? perPage * (page - 1) + offset : 0,
					order,
					orderby: orderBy
				};

				if (taxQuery) {
					// We have to build the tax query for the REST API and use as
					// keys the taxonomies `rest_base` with the `term ids` as values.
					const builtTaxQuery = Object.entries(taxQuery).reduce((accumulator, _ref3) => {
						let [taxonomySlug, terms] = _ref3;
						const taxonomy = taxonomies === null || taxonomies === void 0 ? void 0 : taxonomies.find(_ref4 => {
							let {
								slug
							} = _ref4;
							return slug === taxonomySlug;
						});

						if (taxonomy !== null && taxonomy !== void 0 && taxonomy.rest_base) {
							accumulator[taxonomy === null || taxonomy === void 0 ? void 0 : taxonomy.rest_base] = terms;
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

				if (exclude !== null && exclude !== void 0 && exclude.length) {
					query.exclude = exclude;
				} // If sticky is not set, it will return all posts in the results.
				// If sticky is set to `only`, it will limit the results to sticky posts only.
				// If it is anything else, it will exclude sticky posts from results. For the record the value stored is `exclude`.


				if (sticky) {
					query.sticky = sticky === 'only';
				} // If `inherit` is truthy, adjust conditionally the query to create a better preview.


				if (inherit) {
					// Change the post-type if needed.
					if (templateSlug !== null && templateSlug !== void 0 && templateSlug.startsWith('archive-')) {
						query.postType = templateSlug.replace('archive-', '');
						postType = query.postType;
					}
				}

				return {
					posts: getEntityRecords('postType', postType, query),
					blocks: getBlocks(clientId)
				};
			}, [perPage, page, offset, order, orderBy, clientId, author, search, postType, exclude, sticky, inherit, templateSlug, taxQuery]);
			const blockContexts = (0,external_wp_element_namespaceObject.useMemo)(() => posts === null || posts === void 0 ? void 0 : posts.map(post => ({
				postType: post.type,
				postId: post.id
			})), [posts]);
			const hasLayoutFlex = layoutType === 'flex' && columns > 1;
			let colCount = layoutType === 'flex' ? columns : 1;
			// console.log(layoutType);
			let colMd = ' row-cols-md-' + colCount;
			let colSm = ' row-cols-sm-' + colCount > 1 ? ( colCount - 1 ) : colCount;
			let rowClass = 'row list-unstyled row-cols-1'+colSm +colMd;
			const blockProps = (0,external_wp_blockEditor_namespaceObject.useBlockProps)({
				className: rowClass
			});

			if (!posts) {
				return (0,external_wp_element_namespaceObject.createElement)("p", blockProps, (0,external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.Spinner, null));
			}

			if (!posts.length) {
				return (0,external_wp_element_namespaceObject.createElement)("p", blockProps, " ", (0,external_wp_i18n_namespaceObject.__)('No results found.'));
			} // To avoid flicker when switching active block contexts, a preview is rendered
			// for each block context, but the preview for the active block context is hidden.
			// This ensures that when it is displayed again, the cached rendering of the
			// block preview is used, instead of having to re-render the preview from scratch.


			return (0,external_wp_element_namespaceObject.createElement)("ul", blockProps, blockContexts && blockContexts.map(blockContext => {
				var _blockContexts$, _blockContexts$2;

				return (0,external_wp_element_namespaceObject.createElement)(external_wp_blockEditor_namespaceObject.BlockContextProvider, {
					key: blockContext.postId,
					value: blockContext
				}, blockContext.postId === (activeBlockContextId || ((_blockContexts$ = blockContexts[0]) === null || _blockContexts$ === void 0 ? void 0 : _blockContexts$.postId)) ? (0,external_wp_element_namespaceObject.createElement)(PostTemplateInnerBlocks, null) : null, (0,external_wp_element_namespaceObject.createElement)(MemoizedPostTemplateBlockPreview, {
					blocks: blocks,
					blockContextId: blockContext.postId,
					setActiveBlockContextId: setActiveBlockContextId,
					isHidden: blockContext.postId === (activeBlockContextId || ((_blockContexts$2 = blockContexts[0]) === null || _blockContexts$2 === void 0 ? void 0 : _blockContexts$2.postId))
				}));
			}));

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


function blockstrap_blocks_add_editor_compat_class(){
	jQuery('.edit-post-visual-editor').addClass('bsui');
}

/*
Remove the "Apply Globally" button as it adds a new advanced tab in block settings and is not used by any of our blocks.
@todo remove this once they add an option to remove per block https://github.com/WordPress/gutenberg/issues/47256
 */
function blockstrap_blocks_remove_gloabl_styles(){
	wp.hooks.removeFilter(
		'editor.BlockEdit',
		'core/edit-site/push-changes-to-global-styles'
	);
}
blockstrap_blocks_remove_gloabl_styles();


wp.domReady( function() {
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
