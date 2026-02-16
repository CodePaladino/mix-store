<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


global $product, $woocommerce_loop,$wp_query;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;


 
// Extra post classes
$classes = '';
if ( 1 == $woocommerce_loop['columns'] )
    $classes = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
    $classes = 'last';

$columns = 12/$woocommerce_loop['columns']
?>
<div <?php post_class('shopcol product-wrapper '.$classes.' col-lg-'.$columns.' col-md-'.$columns.' col-sm-'.$columns.' col-xs-12' ); ?>>
    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
</div>
