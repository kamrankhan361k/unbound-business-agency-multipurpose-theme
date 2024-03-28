<?php
/**
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<?php
if ( ! empty( unbound_global_var( 'shop_box_style', '', false ) ) ) {
	include get_parent_theme_file_path( 'woocommerce/shop-box/shop-box-' . unbound_global_var( 'shop_box_style', '', false ) . '.php' );
} else {
	include get_parent_theme_file_path( 'woocommerce/shop-box/shop-box-style-one.php' );
}
?>