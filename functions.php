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

	$states = array();
	if ( function_exists( 'teched_directory_get_state_list' ) ) {
		$states = teched_directory_get_state_list();
	}

	// Show full State Name, not an abbreviation
	$args['values'] = array_map( function( $item ) use ( $states ) {

		$item['facet_display_value'] = $states[ $item['facet_display_value'] ];

		return $item;

	}, $args['values'] );

	return $args;
	
}

add_filter( 'theme_mod_colormag_default_layout', function( $value ) {

	if ( ! is_post_type_archive( 'teched-directory' ) ) return $value;

	return 'left_sidebar';

} );

add_filter( 'term_link', 'teched_alter_directory_category_link', 999, 3 );

/**
 * Make all Directory State Category Links use FacetWP
 * 
 * @param		string $link     Category Link
 * @param		object $term     WP_Term
 * @param		string $taxonomy Taxonomy Name
 *                                   
 * @since		{{VERSION}}
 * @return		string Category Link
 */
function teched_alter_directory_category_link( $link, $term, $taxonomy ) {
	
	if ( $taxonomy !== 'teched-directory-state' ) return $link;

	$states = array();
	if ( function_exists( 'teched_directory_get_state_list' ) ) {
		$states = teched_directory_get_state_list();
	}

	if ( ! array_key_exists( $term->name, $states ) ) return $link;
	
	$link = add_query_arg( array(
		'_state' => $term->slug,
	), get_post_type_archive_link( 'teched-directory' ) );

	return $link;

}

/**
 * Returns a tel: link formatted all nicely
 * 
 * @param		string  $phone_number Phone Number
 * @param		string  $extension    Optional Extension to auto-dial to
 * @param		string  $link_text    Text to use instead of the Phone Number
 * @param		boolean $echo         Whether to echo out the HTML. False returns the Tel Link
 *             
 * @since		{{VERSION}}                                                                       
 * @return		string  tel: Link
 */
function teched_get_phone_number_link( $phone_number, $extension = false, $link_text = '', $echo = true ) {
    
    $trimmed_phone_number = preg_replace( '/\D/', '', trim( $phone_number ) );
    
    if ( strlen( $trimmed_phone_number ) == 10 ) { // No Country Code
        $trimmed_phone_number = '1' . $trimmed_phone_number;
    }
    else if ( strlen( $trimmed_phone_number ) == 7 ) { // No Country or Area Code
        $trimmed_phone_number = '1734' . $trimmed_phone_number; // We'll assume 734
    }
    
    $tel_link = 'tel:' . $trimmed_phone_number;
    
    if ( $link_text == '' ) {
        
        $link_text = $phone_number;
        
        if ( ( $extension !== false ) && ( $extension !== '' ) ) {
            $link_text = $link_text . __( ' x ', 'colormag-child-2' ) . $extension;
        }
        
    }
    
    if ( ( $extension !== false ) && ( $extension !== '' ) ) {
        $tel_link = $tel_link . ',' . $extension;
    }
	
	if ( $echo ) {
    
		return "<a href='$tel_link' class='phone-number-link'>$link_text</a>";
		
	}

	return $tel_link;
    
}