<?php
/**
 * Route the Archive Content requests to be specific per-Post Type
 *
 * @package Colormag_Child_2
 * @since {{VERSION}}
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( $file = locate_template( 'content-archive-' . get_post_type() . '.php', false, false ) ) {

    // Use version specific to our CPT
    include $file;

}
elseif ( file_exists( trailingslashit( get_template_directory() ) . 'content-archive.php' ) ) {

    // Can't use locate_template() here since we want to check the Parent Theme specifically
    // If the parent theme has this file, fall back to it
    // As of the writing of this code, this file does _not_ exist
    include trailingslashit( get_template_directory() ) . 'content-archive.php';

}
else {
    // Fallback to file that only exists in Parent Theme
    locate_template( 'content.php', true, true );
}