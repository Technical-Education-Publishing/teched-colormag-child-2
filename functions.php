<?php
/**
 * The theme's functions file that loads on EVERY page, used for uniform functionality.
 *
 * @since   1.1.0
 * @package Colormag_Child_2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure PHP version is correct
if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
	wp_die( _x( 'ERROR in ColorMag Child 02 theme: PHP version 5.3 or greater is required.', 'PHP Version too low Error', 'colormag-child-2' ) );
}

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VER' ) ||
	defined( 'THEME_URL' ) ||
	defined( 'THEME_DIR' ) ||
	defined( 'THEME_FILE' ) ) {
	wp_die( _x( 'ERROR in ColorMag Child 02 theme: There is a conflicting constant. Please either find the conflict or rename the constant.', 'Constant or Global already in use Error', 'colormag-child-2' ) );
}

/**
 * Define Constants based on our Stylesheet Header. Update things only once!
 */
$theme_header = wp_get_theme();

define( 'THEME_VER', $theme_header->get( 'Version' ) );
define( 'THEME_NAME', $theme_header->get( 'Name' ) );
define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_DIR', get_stylesheet_directory() );

$parent_theme = wp_get_theme( $theme_header->get( 'Template' ) );

// Parent Theme didn't have any cache busting. This will at least do so for the main styles
define( 'PARENT_THEME_VER', $parent_theme->get( 'Version' ) );

add_action( 'init', 'teched_register_scripts' );
function teched_register_scripts() {
	
	wp_register_script(
		'teched',
		THEME_URL . '/dist/assets/js/app.js',
		array( 'jquery' ),
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER,
		true
	);
	
	wp_register_style(
		'teched-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : PARENT_THEME_VER,
		'all'
	);
	
	wp_register_style(
		'teched',
		THEME_URL . '/dist/assets/css/app.css',
		array( 'teched-parent' ),
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER,
		'all'
	);
	
}

add_action( 'wp_enqueue_scripts', 'teched_enqueue_scripts' );
function teched_enqueue_scripts() {
	
	//wp_enqueue_script( 'teched' );
	
	wp_enqueue_style( 'teched' );
	
}

require_once THEME_DIR . '/core/widgets/class-teched-featured-post-widget.php';

add_action( 'wp_head', 'teched_gtm_head' );

/**
 * Google Analytics Head
 * 
 * @since		1.1.0
 * @return		void
 */
function teched_gtm_head() {
	
	?>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WF3NB62');</script>
	<!-- End Google Tag Manager -->

	<?php
	
}

add_action( 'colormag_before', 'teched_gtm_after_opening_body_tag', 1 );

/**
 * Google Analytics Body (Holy cow, the parent theme actually had a hook for this!?)
 *
 * @since		1.1.0
 * @return		void
 */
function teched_gtm_after_opening_body_tag() {
	
	?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WF3NB62"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php
	
}

function teched_get_state_list() {

	return array(
		'AL' => __( 'Alabama', 'colormag-child-2' ),
		'AK' => __( 'Alaska', 'colormag-child-2' ),
		'AZ' => __( 'Arizona', 'colormag-child-2' ),
		'AR' => __( 'Arkansas', 'colormag-child-2' ),
		'CA' => __( 'California', 'colormag-child-2' ),
		'CO' => __( 'Colorado', 'colormag-child-2' ),
		'CT' => __( 'Connecticut', 'colormag-child-2' ),
		'DE' => __( 'Delaware', 'colormag-child-2' ),
		'DC' => __( 'District of Columbia', 'colormag-child-2' ),
		'FL' => __( 'Florida', 'colormag-child-2' ),
		'GA' => __( 'Georgia', 'colormag-child-2' ),
		'HI' => __( 'Hawaii', 'colormag-child-2' ),
		'ID' => __( 'Idaho', 'colormag-child-2' ),
		'IL' => __( 'Illinois', 'colormag-child-2' ),
		'IN' => __( 'Indiana', 'colormag-child-2' ),
		'IA' => __( 'Iowa', 'colormag-child-2' ),
		'KS' => __( 'Kansas', 'colormag-child-2' ),
		'KY' => __( 'Kentucky', 'colormag-child-2' ),
		'LA' => __( 'Louisiana', 'colormag-child-2' ),
		'ME' => __( 'Maine', 'colormag-child-2' ),
		'MD' => __( 'Maryland', 'colormag-child-2' ),
		'MA' => __( 'Massachusetts', 'colormag-child-2' ),
		'MI' => __( 'Michigan', 'colormag-child-2' ),
		'MN' => __( 'Minnesota', 'colormag-child-2' ),
		'MS' => __( 'Mississippi', 'colormag-child-2' ),
		'MO' => __( 'Missouri', 'colormag-child-2' ),
		'MT' => __( 'Montana', 'colormag-child-2' ),
		'NE' => __( 'Nebraska', 'colormag-child-2' ),
		'NV' => __( 'Nevada', 'colormag-child-2' ),
		'NH' => __( 'New Hampshire', 'colormag-child-2' ),
		'NJ' => __( 'New Jersey', 'colormag-child-2' ),
		'NM' => __( 'New Mexico', 'colormag-child-2' ),
		'NY' => __( 'New York', 'colormag-child-2' ),
		'NC' => __( 'North Carolina', 'colormag-child-2' ),
		'ND' => __( 'North Dakota', 'colormag-child-2' ),
		'OH' => __( 'Ohio', 'colormag-child-2' ),
		'OK' => __( 'Oklahoma', 'colormag-child-2' ),
		'OR' => __( 'Oregon', 'colormag-child-2' ),
		'PA' => __( 'Pennsylvania', 'colormag-child-2' ),
		'RI' => __( 'Rhode Island', 'colormag-child-2' ),
		'SC' => __( 'South Carolina', 'colormag-child-2' ),
		'SD' => __( 'South Dakota', 'colormag-child-2' ),
		'TN' => __( 'Tennessee', 'colormag-child-2' ),
		'TX' => __( 'Texas', 'colormag-child-2' ),
		'UT' => __( 'Utah', 'colormag-child-2' ),
		'VT' => __( 'Vermont', 'colormag-child-2' ),
		'VA' => __( 'Virginia', 'colormag-child-2' ),
		'WA' => __( 'Washington', 'colormag-child-2' ),
		'WV' => __( 'West Virginia', 'colormag-child-2' ),
		'WI' => __( 'Wisconsin', 'colormag-child-2' ),
		'WY' => __( 'Wyoming', 'colormag-child-2' ),
		'AA' => __( 'Armed Forces Americas', 'colormag-child-2' ),
		'AE' => __( 'Armed Forces Europe', 'colormag-child-2' ),
		'AP' => __( 'Armed Forces Pacific', 'colormag-child-2' ),
	);

}

add_filter( 'facetwp_facet_render_args', 'teched_only_show_state_directory_categories', 10 );

/**
 * Force the Rare and Collectible Checkbox to always show in Instrument Categories
 *
 * @param   [array]  $args  Facet Rendering Args
 *
 * @since	{{VERSION}}
 * @return  [array]         Facet Rendering Args
 */
function teched_only_show_state_directory_categories( $args ) {

	if ( $args['facet']['name'] !== 'state' ) return $args;

	$states = teched_get_state_list();

	// Restrict to States
	$args['values'] = array_filter( $args['values'], function( $item ) use ( $states ) {
		return array_key_exists( $item['facet_display_value'], $states );
	} );

	// Show full State Name, not an abbreviation
	$args['values'] = array_map( function( $item ) use ( $states ) {

		$item['facet_display_value'] = $states[ $item['facet_display_value'] ];

		return $item;

	}, $args['values'] );

	return $args;
	
}

add_filter( 'register_post_type_args', function( $args, $post_type ) {

	if ( $post_type !== WPBDP_POST_TYPE ) return $args;

	$args['has_archive'] = true;
	$args['show_in_nav_menus'] = true;

	return $args;

}, 10, 2 );

add_filter( 'wpbdp_url', function( $url, $pathorview, $args ) {

	if ( $pathorview !== '/' && $pathorview !== 'edit_listing' ) return $url;

	if ( $pathorview == 'edit_listing' ) {
		return add_query_arg( array( 
			'post' => $args,
			'action' => 'edit',
		), admin_url( 'post.php' ) );
	}

	return get_post_type_archive_link( WPBDP_POST_TYPE );

}, 10, 3 );

add_filter( 'theme_mod_colormag_default_layout', function( $value ) {

	if ( ! is_post_type_archive( WPBDP_POST_TYPE ) ) return $value;

	return 'left_sidebar';

} );

add_filter( 'term_link', 'teched_alter_directory_category_link', 999, 3 );

/**
 * Make all Directory Category Links use FacetWP
 * 
 * @param		string $link     Category Link
 * @param		object $term     WP_Term
 * @param		string $taxonomy Taxonomy Name
 *                                   
 * @since		{{VERSION}}
 * @return		string Category Link
 */
function teched_alter_directory_category_link( $link, $term, $taxonomy ) {
	
	if ( $taxonomy !== WPBDP_CATEGORY_TAX ) return $link;

	if ( ! array_key_exists( $term->name, teched_get_state_list() ) ) return $link;
	
	$link = add_query_arg( array(
		'_state' => $term->slug,
	), get_post_type_archive_link( WPBDP_POST_TYPE ) );

	return $link;

}