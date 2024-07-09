=== BlockStrap Page Builder Blocks ===
Contributors: stiofansisland, paoltaia, ayecode
Donate link: https://ayecode.io
Tags: page builder, bootstrap, blocks, builder, design
Requires at least: 6.0
Tested up to: 6.5
Stable tag: 0.1.19
Requires PHP: 7.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

BlockStrap Page Builder Blocks combines the power of BootStrap with the power of the block editor.

== Description ==

BlockStrap Page Builder Blocks gives you a selection of bootstrap blocks that let you craft a whole site including header, footer and even menus.

This plugin, combined with the [BlockStrap theme](https://wordpress.org/themes/blockstrap/), turbocharges your website's loading speed effortlessly.

# BlockStrap: The Ultimate BootStrap Page Builder for WordPress

Transform your WordPress website with BlockStrap, the ultimate page builder plugin that brings the power of the Bootstrap CSS framework to your fingertips. 

## Why Choose BlockStrap?

BlockStrap is not just a plugin, it's a complete page builder that gives you the freedom to create any type of theme. It integrates seamlessly with the WordPress block editor, providing a wide range of fully customizable blocks and easy to use. 

## Build Anything with BlockStrap

Whether you're building a blog, a Directory, an e-commerce store, a portfolio, or a business website, BlockStrap has got you covered. With over 30+ unique blocks, you can create anything from stylish navigation bars and responsive image galleries to dynamic accordions and interactive maps. 

## BlockStrap Free Child Themes

* [Directory Theme](https://wordpress.org/themes/directory/) - Built for our plugin [GeoDirectory](https://wordpress.org/plugins/geodirectory), this is the [best free WordPress directory theme] (https://wpgeodirectory.com/downloads/directory-theme/) you will find on WordPress.org.
* [Real Estate Theme](https://wpgeodirectory.com/downloads/real-estate-directory-theme/) - Designed specifically for our GeoDirectory plugin, this is the top free WordPress Real Estate theme available. When used alongside the free [Real Estate Directory add-on ](https://wpgeodirectory.com/downloads/real-estate-directory/), for GeoDirectory, it puts premium real estate themes to shame.
* [Job Board Theme](https://wpgeodirectory.com/downloads/job-board-theme/) Seamlessly integrated with GeoDirectory, this theme offers a robust platform for managing and showcasing job opportunities. Whether running a local job board or a large-scale employment site, the Job Board Theme ensures a professional look and smooth user experience.
* [School Child Theme](https://wordpress.org/themes/school/) Build a professional-looking educational website with the free School Child Theme for Blockstrap. Tailored for academic institutions, this theme provides a clean, user-friendly design that enhances the online presence of schools and educational programs. Fully compatible with the Blockstrap framework, the School Child Theme offers seamless functionality and a professional aesthetic to engage students, parents, and educators alike.

Many more BLockstrap Child themes are in the pipeline. We aim to release at least 2 per month.

## Blockstrap Blocks

### BS > Archive Actions
Perfect for blogs and news sites, this block allows you to add category selector and sort options to archive pages.

### BS > Archive Title
Display your archive titles in a stylish and professional manner.

### BS > Breadcrumb
Improve your site navigation with this breadcrumb block.

### BS > Button
Create stylish and responsive buttons that are highly customizable.

### BS > Container
This block allows you to create responsive containers for your content. It also doubles as row, column and card blocks.

### BS > Counter
Display numbers in a dynamic and engaging way with this counter block.

### BS > Gallery
Showcase your images in a beautiful and responsive gallery.

### BS > Heading
Create headings that stand out and match your theme.

### BS > Icon Box
Add icons to your site with this easy-to-use block.

### BS > Image
Display your images in a stylish and responsive manner.

### BS > Map
Add interactive maps to your site with this block.

### BS > Nav
Create a responsive navigation menu for your site.

### BS > Nav Dropdown
Add dropdown menus to your navigation with this block.

### BS > Nav Item
Add individual items to your navigation menu.

### BS > Navbar
Create a stylish and responsive navigation bar.

### BS > Navbar Brand
Display your brand / logo in your navigation bar with this block.

### BS > Pagination
Improve your site navigation with this pagination block.

### BS > Post Excerpt
Display post excerpts in a stylish and engaging manner.

### BS > Post Info
Showcase your post info with this block, including author, dates, comments, read time etc.

### BS > Post Title
Display your post titles in a stylish and professional manner.

### BS > Search
Add a search function to your site with this block.

### BS > Shape Divider
Add stylish dividers to your site with this block.

### BS > Share
Make it easy for your visitors to share your content with this social share block.

### BS > Skip Links
Improve your site accessibility with this skip links block.

### BS > Tab
Create tabs for your content with this block.

### BS > Tabs
Organize your content in a stylish and responsive tabs layout.

### BS > Accordion
Display your content in a dynamic accordion layout.

### BS > Accordion Item
Add individual items to your accordion with this block.

### BS > Contact Form
Add a simple and easy contact form to your site with this block.

### BS > Rating
Add a start rating icons to your posts. (can also be used to output GeoDirectory post ratings)

### BS > Scroll Top
Add a button to the page so users can scroll back to the top of the page easily.

### BS > Modal
Add a modal (popup) to the page containing any content.

### BS > Offcanvas
Add a Offcanvas element to the page containing any content.

## Get BlockStrap Today!
Take your WordPress site to the next level with the BlockStrap plugin. Experience the power of Bootstrap in your WordPress block editor today!

== Installation ==

= Minimum Requirements =

* WordPress 6.0 or greater
* PHP version 5.6 or greater
* MySQL version 5.0 or greater

= AUTOMATIC INSTALLATION =

Automatic installation is the easiest option. To automatically install BlockStrap Page Builder Blocks, log in to your WordPress dashboard, navigate the Plugins menu, and click Add New.

In the search field, type BlockStrap, and click Search Plugins. Once you've found our plugin, you install it by clicking Install Now.

= MANUAL INSTALLATION =

The manual installation method involves downloading our Directory plugin and uploading it to your webserver via your favorite FTP application. The WordPress codex will tell you more [here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation). 

= UPDATING =

Automatic updates should work seamlessly. We always suggest you backup your website before any automated update to avoid unforeseen problems.

== Screenshots ==

1. Archive Actions.
2. Archive title.
3. Breadcrumbs.
4. Buttons.
5. Contact form.
6. Container multi-use block.
7. Image Gallery.

== Changelog ==

= 0.1.20 =
* BS Container has `undefined` class if style ID not set - FIXED

= 0.1.19 =
* BS > Offcanvas block added for creating Offcanvas items - ADDED
* Accordion block not setting parent ID which could break some advanced features - FIXED
* Gallery block not setting uploaded images alt tag - FIXED
* Modal and Offcanvas in footer not rendering shortcodes - FIXED

= 0.1.17 =
* BS > Modal block added for creating popups - ADDED
* Most blocks now show better previews - ADDED
* Parent and allowedBlocks params added to some blocks to remove them from main list when they can only be nested - CHANGED
* Some blocks such as Navbar will now auto add child element dummy data on insert for faster building - ADDED
* Some blocks such as tabs were not working in editor with certain AyeCode UI setting - FIXED

= 0.1.16 =
* Nav item can show class in name for UWP login in/out - FIXED
* Accordion block now has option to enable FAQ Schema - ADDED
* New BS > Scroll Top block for scrolling the page back to the top - NEW/ADDED
* BS > Post Title will now dynamically change h tag if inside GD Loop - ADDED
* BD > Post Title link color not showing correct color when set - FIXED
* BS > Share block current URl function improved - CHANGED
* BS > Share block will use new twitter X logo if current Font Awesome version supports it - CHANGED
* BS > Container block background as featured image will now USE GD location, category and CPT images when available - ADDED
* BS > Container block background in editor will now use inline SVG image instead of URL for better template compatibility - CHANGED

= 0.1.15 =
* Better block auto-recovery to auto recover blocks - UPDATED

= 0.1.14 =
* Better block auto-recovery to auto recover blocks - UPDATED

= 0.1.13 =
* Gallery images dummy data CDN url updated - CHANGED
* Block Rename now supported - ADDED
* SD + AUI Packages updated to latest - UPDATED

= 0.1.12 =
* BS > Nav inline script move to wp_add_inline_script() call - CHANGED
* BS > Button added link attributes options - ADDED

= 0.1.11 =
* BS > Rating block added to output rating stars, general use or for GeoDirectory - ADDED

= 0.1.10 =
* WP 6.3 breaks AUI query loop columns selection - FIXED
* Visibility conditions is not working for tab action link - FIXED
* Contact form block modal moved to footer to avoid z-index issues - CHANGED
* Missing composer files could cause fatal error - FIXED

= 0.1.8 =
* BS > Gallery working when image don't have different sizes - FIXED
* Button gets display options - ADDED
* 1-2-2 Gallery layout missing closing div if only 2 or 3 images - FIXED

= 0.1.7 =
* Button block can now use GD meta as value - ADDED
* SD and AUI updated to latest - UPDATED
 
= 0.1.6 = 
* Title and Heading blocks now have more border controls - ADDED
* Super Duper lib updated - UPDATED

= 0.1.5 =
* Gallery block in 1-2-5 layout could skip closing divs - FIXED

= 0.1.4 =
* post info block Deprecated: Optional parameter notice - FIXED
* Several minor block improvements - ADDED
* Gallery block in 1-2-5 layout could skip last image - FIXED
* BS > Contact form, block added for simple contact forms - ADDED
* New option added in BS > Button and BS > Nav item to be able to open BS > Contact form lightboxes - ADDED
* Footer and menu items updated for new block argument - UPDATED

= 0.1.2 =
* Map block Google address input not showing as default value wrong - FIXED
* Pre and Code blocks can break if PHP opening tag used - FIXED
* WP 6.2.2 causes closing shortcodes to show - FIXED

= 0.1.1 =
* New Accordion block added - ADDED
* WP 6.2 apply globally feature disabled until they add a way for devs to remove per block - CHANGED
* Image block, new alt setting - ADDED
* Image block, new lazy load setting - ADDED
* Image block, new setting to remove icon on link hover - ADDED
* Block visibility feature added for some blocks - ADDED

= 0.1.0 =
* Button block hover styling not working - FIXED
* Breadcrumb block - ADDED
* Share block - ADDED
* Post excerpt block - ADDED
* Post info block (for meta details) - ADDED
* Several changes and improvements to other blocks for BS5 option - CHANGED
* Added option to remove archive title prefix in BS > Archive title block - ADDED
* Added spacer and log in/out options to BS > Nav item block - ADDED
* Default to Bootstrap v5 - ADDED

= 0.0.3 =
* First WP.org release - RELEASE

= 0.0.2 =
* Added index.php files to main directories for better security - ADDED
* Updated Bootstrap to latest v4 (4.6.2) - UPDATED

= 0.0.1 =
* First public release - RELEASE

= Resources used to build this plugin =

* Image for image block placeholder ( block-image-placeholder.jpg ), Copyright PxHere
  License: CC0 Public Domain
  Source: https://pxhere.com/en/photo/356005
  
* Logo used for nav logo placeholder ( Blockstrap.png & Blockstrap-white.png ), Copyright AyeCode Ltd
  License: CC0 Public Domain
  Source: Created and licensed by AyeCode Ltd (plugin creator)
  
* Illustration used in home block pattern ( placeholder-home.png ), Copyright AyeCode Ltd
  License: CC0 Public Domain
  Source: Created and licensed by AyeCode Ltd (plugin creator)
  
* Social icons used in Illustration in home block pattern,  Copyright Font Awesome (Fonticons, Inc.)
  License: CC BY 4.0 License
  Source: https://fontawesome.com/v5/search?q=social&o=r&m=free
  
* Shape divider block shape options ( /assets/shapes/* ), Copyright Elementor
  License: GPL v3
  Source: https://github.com/elementor/elementor/tree/master/assets/shapes
  
* Image block mask options ( /assets/masks/ circle, flower, sketch, triangle ), Copyright Elementor
  License: GPL v3
  Source: https://github.com/elementor/elementor/tree/master/assets/mask-shapes
  
* Image block mask options ( /assets/masks/ blob1, blob2, blob3, rounded, hexagon ), Copyright Kadence blocks
  License: GPL v2
  Source: https://github.com/kadencewp/kadence-blocks/tree/master/includes/assets/images/masks
