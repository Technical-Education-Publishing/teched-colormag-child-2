<?php
/**
 * Adds the suppliers Meta to both Single and Archive views
 *
 * @package Colormag_Child_2
 * @since {{VERSION}}
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'teched_suppliers_get_field' ) ) exit;

$states = array();

if ( function_exists( 'teched_suppliers_get_state_list' ) ) {
    $states = teched_suppliers_get_state_list();
}

$state = teched_suppliers_get_field( 'state' );

?>

<p>
    <strong><?php _e( 'Address:', 'colormag-child-2' ); ?></strong>
    <br />
    <?php echo ( $address_1 = teched_suppliers_get_field( 'street_address_1' ) ) ? $address_1 . '<br />' : ''; ?>
    <?php echo ( $address_2 = teched_suppliers_get_field( 'street_address_2' ) ) ? $address_2 . '<br />' : ''; ?>
    <?php echo ( $city = teched_suppliers_get_field( 'city' ) ) ? $city . ', ' : ''; ?>
    <?php echo ( isset( $states[ $state ] ) ) ? $states[ $state ] : $state; ?>
    <?php echo ( $zip = teched_suppliers_get_field( 'zip' ) ) ? ' ' . $zip : ''; ?>
</p>

<?php if ( $phone = teched_suppliers_get_field( 'phone' ) ) : ?>

    <p>
        <strong><?php _e( 'Phone:', 'colormag-child-2' ); ?></strong>
        <?php echo ' ' . trim( teched_get_phone_number_link( $phone ) ); ?>
    </p>

<?php endif; ?>

<?php if ( $fax = teched_suppliers_get_field( 'fax' ) ) : ?>

    <p>
        <strong><?php _e( 'Fax:', 'colormag-child-2' ); ?></strong>
        <?php echo ' ' . trim( teched_get_phone_number_link( $fax ) ); ?>
    </p>

<?php endif; ?>

<?php if ( $website_url = teched_suppliers_get_field( 'website_url' ) ) : 

    // Ensure we have a useable URL
    if ( ! preg_match( '/^(?:\/\/|https?:\/\/)/is', trim( $website_url ) ) ) {
        $website_url = '//' . trim( $website_url );
    }
    
    ?>

    <p>
        <a href="<?php echo trim( $website_url ); ?>" target="_blank">

            <?php echo trim( preg_replace( '/^\/\//is', '', $website_url ) ); ?>
            
        </a>
    </p>

<?php endif; ?>

<?php if ( ! empty( wp_get_post_terms( get_the_ID(), 'suppliers-subject-discipline' ) ) ) : ?>

    <p>
        <strong><?php _e( 'Subjects/Disciplines:', 'colormag-child-2' ); ?></strong>
        <?php echo ' ' . get_the_term_list( get_the_ID(), 'suppliers-subject-discipline', '', ', ' ); ?></p>
    </p>

<?php endif; ?>

<?php if ( ! empty( wp_get_post_terms( get_the_ID(), 'suppliers-grade-level' ) ) ) : ?>

    <p>
        <strong><?php _e( 'Grade Levels:', 'colormag-child-2' ); ?></strong>
        <?php echo ' ' . get_the_term_list( get_the_ID(), 'suppliers-grade-level', '', ', ' ); ?></p>
    </p>

<?php endif; ?>

<?php if ( ! empty( wp_get_post_terms( get_the_ID(), 'suppliers-industry' ) ) ) : ?>

    <p>
        <strong><?php _e( 'Industries:', 'colormag-child-2' ); ?></strong>
        <?php echo ' ' . get_the_term_list( get_the_ID(), 'suppliers-industry', '', ', ' ); ?></p>
    </p>

<?php endif; ?>