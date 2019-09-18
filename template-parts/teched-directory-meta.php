<?php
/**
 * Adds the Directory Meta to both Single and Archive views
 *
 * @package Colormag_Child_2
 * @since {{VERSION}}
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'teched_directory_get_field' ) ) exit;

$states = array();

if ( function_exists( 'teched_directory_get_state_list' ) ) {
    $states = teched_directory_get_state_list();
}

$state = teched_directory_get_field( 'state' );

?>

<p>
    <strong><?php _e( 'Address:', 'colormag-child-2' ); ?></strong>
    <br />
    <?php echo ( $address_1 = teched_directory_get_field( 'street_address_1' ) ) ? $address_1 . '<br />' : ''; ?>
    <?php echo ( $address_2 = teched_directory_get_field( 'street_address_2' ) ) ? $address_2 . '<br />' : ''; ?>
    <?php echo ( $city = teched_directory_get_field( 'city' ) ) ? $city . ', ' : ''; ?>
    <?php echo ( isset( $states[ $state ] ) ) ? $states[ $state ] : $state; ?>
    <?php echo ( $zip = teched_directory_get_field( 'zip' ) ) ? ' ' . $zip : ''; ?>
</p>

<?php if ( $name = teched_directory_get_field( 'name' ) ) : ?>

    <p>
        <strong><?php _e( 'Name:', 'colormag-child-2' ); ?></strong>
        <?php echo trim( $name ); ?>
    </p>

<?php endif; ?>

<?php if ( $business_email = teched_directory_get_field( 'business_email' ) ) : ?>

    <p>
        <a href="mailto:<?php echo trim( $business_email ); ?>">
            <?php echo trim( $business_email ); ?>
        </a>
    </p>

<?php endif; ?>

<?php if ( $phone = teched_directory_get_field( 'phone' ) ) : ?>

    <p>
        <strong><?php _e( 'Phone:', 'colormag-child-2' ); ?></strong>
        <?php echo trim( teched_get_phone_number_link( $phone ) ); ?>
    </p>

<?php endif; ?>

<?php if ( $fax = teched_directory_get_field( 'fax' ) ) : ?>

    <p>
        <strong><?php _e( 'Fax:', 'colormag-child-2' ); ?></strong>
        <?php echo trim( teched_get_phone_number_link( $fax ) ); ?>
    </p>

<?php endif; ?>

<?php if ( $website_url = teched_directory_get_field( 'website_url' ) ) : ?>

    <p>
        <a href="<?php echo trim( $website_url ); ?>" target="_blank">

            <?php if ( $website_text = teched_directory_get_field( 'website_text' ) ) : ?>
                <?php echo trim( $website_text ); ?>
            <?php else : ?>
                <?php echo trim( $website_url ); ?>
            <?php endif; ?>
            
        </a>
    </p>

<?php endif; ?>