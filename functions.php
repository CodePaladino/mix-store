<?php
 /**
 * Theme function
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WPOpal  Team <opalwordpress@gmail.com, support@wpopal.com>
 * @copyright  Copyright (C) 2014 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if( !defined('TEXTDOMAIN') ){

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	define( 'TEXTDOMAIN', $themename );
}

define( 'WPO_THEME_DIR', get_template_directory() );
define( 'WPO_THEME_SUB_DIR', WPO_THEME_DIR.'/inc/' );
define( 'WPO_THEME_CSS_DIR', WPO_THEME_DIR.'/css/' );

define( 'WPO_THEME_URI', get_template_directory_uri() );

define( 'WPO_THEME_NAME', TEXTDOMAIN );
define( 'WPO_THEME_VERSION', '1.0' );

define( 'WPO_WOOCOMMERCE_ACTIVED', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
define( 'WPO_VISUAL_COMPOSER_ACTIVED', in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
/*
 * Include list of files from Opal Framework.
 */
require_once( WPO_THEME_DIR . '/inc/loader.php' );
/*
 * Localization
 */
// $lang = WPO_THEME_DIR . '/languages' ;
// load_theme_textdomain( TEXTDOMAIN, $lang );

// echo $lang;


/**
 * Create variant objects to modify and proccess actions of only theme.
 */

/*
 * Shortcodes
 */
require_once( WPO_THEME_SUB_DIR. '/functions/shortcode.php' );
/*
 * Create & start up instance of framework in application.
 */

/// include list of functions to process logics of worpdress not support 3rd-plugins.
require_once( WPO_THEME_SUB_DIR . 'functions/theme.php' );



/**
 * Create variant objects to modify and proccess actions of only theme.
 */
if( WPO_VISUAL_COMPOSER_ACTIVED ){
	require_once( WPO_THEME_SUB_DIR . 'vc/visualcomposer.php' );
	$path = WPO_THEME_SUB_DIR . '/vc/class/*.php';
	$files = glob($path);
	foreach ($files as $key => $file) {
		if(is_file($file)){
			require($file);
		}
	}
}

//if( is_admin() ) {

	require_once( WPO_THEME_SUB_DIR . 'customizer/customizer-custom-classes.php' );
	require_once( WPO_THEME_SUB_DIR . 'customizer/theme.php' );
	require_once( WPO_THEME_SUB_DIR . 'customizer/blog.php' );
	require_once( WPO_THEME_SUB_DIR . 'customizer/portfolio.php' );
	require_once( WPO_THEME_SUB_DIR . 'customizer/function.php' );
	// require_once( WPO_THEME_DIR . '/sample/import.php' );
//}


/// WooCommerce specified functions
if( WPO_WOOCOMMERCE_ACTIVED  ) {
    require_once( WPO_THEME_SUB_DIR . 'woocommerce/woocommerce.php' );
    require_once( WPO_THEME_SUB_DIR . 'functions/woocommerce.php' );
    //if( is_admin() ) {
    	require_once( WPO_THEME_SUB_DIR . 'customizer/woocommerce.php' );
	//}
}



/**
 * Startup theme application
 *
 */
$wpoEngine = new WPO_Frontend();
$protocol = is_ssl() ? 'https:' : 'http:';



// Add List of Menu Group
$wpoEngine->addMenu('mainmenu','Main Menu');
$wpoEngine->addMenu('topmenu','Top Header Menu');
//$wpoEngine->addThemeSupport( 'post-formats',  array( 'aside', 'link' , 'quote', 'image' ) );


$wpoEngine->init();

/**
 *
 */
global $wpopconfig;

$wpoconfig = is_single()?  $wpoEngine->configLayout(wpo_theme_options('single-layout','0-1-0')):$wpoEngine->getPageConfig();

// Auf Artikelseite die Bewertungen entfernen
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['reviews'] ); 			// Remove the reviews tab

    return $tabs;
}

// kein Warenkorbbutton auf den kleinen Produktbildern
function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

// remove_action(�wp_head�, �wp_generator�);

/*
// Cookie-Richtlinie
function cookierichtlinie() {

echo '<!-- Cookie Hinweis - Start -->
<script type="text/javascript">
window.cookieconsent_options = {"message":"Diese Website verwendet Cookies. Durch die Nutzung unserer Services erkl&auml;ren Sie sich damit einverstanden, dass wir Cookies setzen. ","dismiss":"Zustimmen","learnMore":" - Mehr erfahren","link":"https://www.lieblingsmanufaktur.de/datenschutz/","theme":"dark-bottom"};
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
<!-- Cookie Hinweis - Ende -->';
}
add_action('wp_footer', 'cookierichtlinie');
*/

/** add this to your function.php child theme to remove ugly shortcode on excerpt */
if(!function_exists('remove_vc_from_excerpt')) {
	function remove_vc_from_excerpt( $excerpt ) {
	$patterns = "/\[[\/]?vc_[^\]]*\]/";
	$replacements = "";
	return preg_replace($patterns, $replacements, $excerpt);
	}
}

/** * Original elision function mod by Paolo Rudelli */

if(!function_exists('kc_excerpt')) {
	/** Function that cuts post excerpt to the number of word based on previosly set global * variable $word_count, which is defined below */
	function kc_excerpt($excerpt_length = 20) {
		global $word_count, $post;
		$word_count = isset($word_count) && $word_count != "" ? $word_count : $excerpt_length;
		$post_excerpt = $post->post_excerpt != "" ? $post->post_excerpt : strip_tags($post->post_content); $clean_excerpt = strpos($post_excerpt, '...') ? strstr($post_excerpt, '...', true) : $post_excerpt;

		/** add by PR */
		$clean_excerpt = strip_shortcodes(remove_vc_from_excerpt($clean_excerpt));
		/** end PR mod */
		$excerpt_word_array = explode (' ',$clean_excerpt);
		$excerpt_word_array = array_slice ($excerpt_word_array, 0, $word_count);
		$excerpt = implode (' ', $excerpt_word_array).'...'; echo ''.$excerpt.'';
		}
}


add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );

function custom_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'random_list' === $orderby_value ) {
        $args['orderby'] = 'rand';
        $args['order'] = '';
        $args['meta_key'] = '';
    }
    return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );

function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['random_list'] = 'Random';
    return $sortby;
}

// Edit order items table template defaults
function sww_add_wc_order_email_images( $table, $order ) {

	ob_start();

	$template = $plain_text ? 'emails/plain/email-order-items.php' : 'emails/email-order-items.php';
	wc_get_template( $template, array(
		'order'                 => $order,
		'items'                 => $order->get_items(),
		'show_download_links'   => $show_download_links,
		'show_sku'              => true,
		'show_purchase_note'    => $show_purchase_note,
		'show_image'            => true,
		'image_size'            => array( 150, 150 )
	) );

	return ob_get_clean();
}
add_filter( 'woocommerce_email_order_items_table', 'sww_add_wc_order_email_images', 10, 2 );

function sww_edit_order_item_name( $name ) {
    return $name . '<br />';
}
add_filter( 'woocommerce_order_item_name', 'sww_edit_order_item_name' );

//How To Remove Query Strings from Static Resources
function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

/***
Speicherung der IP-Adresse bei der Abgabe von Kommentaren verhindern
***/
function  wpb_remove_commentsip( $comment_author_ip ) {
	return '';
	}
add_filter( 'pre_comment_user_ip', 'wpb_remove_commentsip' );

/***
HSTS im Header der Webseite f�r alle Browser aktivieren
***/

add_action( 'send_headers', 'tgm_io_strict_transport_security' );
/**
 * Enables the HTTP Strict Transport Security (HSTS) header.
 *
 * @since 1.0.0
 */
function tgm_io_strict_transport_security() {

    header( 'Strict-Transport-Security: max-age=10886400; includeSubDomains; preload' );

}

/***
Abschaltung s�mticher FEED Elemente
***/
/***
function fastwp_disable_feed() {
 wp_die(__('<p>Feed nicht verf�gbar. Schau mal hier: <a href="'.get_bloginfo('url').'">Lieblingsmanufaktur</a>!</p>'));
}
add_action('do_feed', 'fastwp_disable_feed', 1);
add_action('do_feed_rdf', 'fastwp_disable_feed', 1);
add_action('do_feed_rss', 'fastwp_disable_feed', 1);
add_action('do_feed_rss2', 'fastwp_disable_feed', 1);
add_action('do_feed_atom', 'fastwp_disable_feed', 1);
***/

/***
Beitragsbild im RSS-Feed mit ausgeben
***/
function featured_image_in_rss($content)
{
    global $post;
    // �berpr�fen, ob Artikel ein Beitragsbild hat
    if (has_post_thumbnail($post->ID))
    {
         $content = '<div style="float: left;">' . get_the_post_thumbnail($post->ID, 'medium') . '</div>' . $content;
    }
    return $content;
}
//Filter f�r RSS-Auszug
add_filter('the_excerpt_rss', 'featured_image_in_rss');
//Filter f�r RSS-Content
add_filter('the_content_feed', 'featured_image_in_rss');


/***
Abschaltung der WP-Emoji Nachladung
***/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Dequeue the Parent Theme scripts.
 *
 * Hooked to the wp_print_scripts action, with a late priority (100),
 * so that it is after the script was enqueued.
 */
function my_site_WI_dequeue_script() {
	wp_dequeue_script( 'scroll_animate' ); //scroll-site
}

add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );

/***
* Button fuer Uebersicht bei jedem Produkt 
***/
add_action( 'woocommerce_after_single_product_summary', 'bbloomer_custom_action', 5 );
add_action( 'woocommerce_after_single_product', 'bbloomer_custom_action', 5 );
 
function bbloomer_custom_action() {
	
	// Get parent product categories on single product pages
	$terms = wp_get_post_terms( get_the_ID(), 'product_cat', array( 'include_children' => false ) );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return;
	}
	// Get the first main product category (not a child one)
	$term = reset( $terms );
	if ( ! $term ) {
		return;
	}
	$term_link = get_term_link( $term->term_id, 'product_cat' );
	if ( is_wp_error( $term_link ) ) {
		return;
	}
	// echo "<div class='cat-prod-link-back x-container max width' style='text-align: center; width: 50%; margin: auto; padding-bottom: 20px;'><a class='wpllm-button_02 button single_add_to_cart_button alt btn-block' href='#' onClick='history.go(-1); return false;'>zur&uuml;ck zur &Uuml;bersicht</a></div>";
	echo '<div class="cat-prod-link-back x-container max width" style="text-align: center; width: 50%; margin: auto; padding-bottom: 20px;"><a class="wpllm-button_02 button single_add_to_cart_button alt btn-block" href="' . esc_url( $term_link ) . '">zur &Uuml;bersicht</a></div>';
}


/* Ausblenden der nicht Versandkostenpauschale wenn kostenlose Lieferung erfolgen kann */
function show_only_free_shipping_if_available( $rates )
{
    $free = array();
     foreach ( $rates as $rate_id => $rate )
    {
         if ( 'free_shipping' === $rate->method_id )
        {
              $free[ $rate_id ] = $rate;
              break;
        }
   }
   return ! empty( $free ) ? $free : $rates;
}

add_filter( 'woocommerce_package_rates', 'show_only_free_shipping_if_available', 90 );

/* Telefon nich als Pflichfeld */
add_filter( 'woocommerce_billing_fields', 'kd_no_required_phone', 10, 1 );

function kd_no_required_phone( $address_fields ) {
	$address_fields['billing_phone']['required'] = false;
	return $address_fields;
}

/* Bilder in Bestelluebersicht anzeigen je Bestellung */
// Add a new custom column to admin order list
add_filter( 'manage_edit-shop_order_columns', 'admin_orders_list_add_column', 10, 1 );
function admin_orders_list_add_column( $columns ){
    $columns['custom_column'] = __( 'New Column', 'woocommerce' );

    return $columns;
}

// The data of the new custom column in admin order list
add_action( 'manage_shop_order_posts_custom_column' , 'admin_orders_list_column_content', 10, 2 );
function admin_orders_list_column_content( $column, $post_id ){
    global $the_order;

    if( 'custom_column' === $column && $the_order ){
        $count = 0;

        // Loop through order items
        foreach( $the_order->get_items() as $item ) {
            $product = $item->get_product(); // The WC_Product Object
            if ( ! $product ) {
                continue;
            }
            $style   = $count > 0 ? ' style="padding-left:6px;"' : '';

            // Display product thumbnail
            printf( '<span%s>%s</span>', esc_attr( $style ), $product->get_image( array( 50, 50 ) ) );

            $count++;
        }
    }
}

/* Bestellnotiz des Kunden in Bestelluebersicht Backend anzeigen lassen */
function kb_set_order_note_column( $columns ) {
  $columns['order_notes'] = __('Order note','TEXTDOMAIN');
  return $columns;
}
add_filter( 'manage_shop_order_posts_columns', 'kb_set_order_note_column', 99 );

function kb_show_order_note_columns( $column_name, $post_id ) {
 switch ( $column_name ) {
  case 'order_notes':
  $order = wc_get_order( $post_id );
  if ( ! $order ) {
      break;
  }
  $note = $order->get_customer_note();
  /*print $note ? __('Yes','TEXTDOMAIN') : __('No','TEXTDOMAIN');*/
  echo esc_html( $note );
  break;
 }
}
add_action( 'manage_shop_order_posts_custom_column' , 'kb_show_order_note_columns', 10, 2 );

// Ausblenden der inaktiven Artikel bei Related Products
function misha_hide_out_of_stock_option( $option ){
	return 'yes';
}
 
add_action( 'woocommerce_before_template_part', function( $template_name ) {
 
	if( $template_name !== "single-product/related.php" ) {
		return;
	}
 
	add_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'misha_hide_out_of_stock_option' );
 
} );
 
add_action( 'woocommerce_after_template_part', function( $template_name ) {
 
	if( $template_name !== "single-product/related.php" ) {
		return;
	}
 
	remove_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'misha_hide_out_of_stock_option' );
 
} );



add_filter( 'woocommerce_output_related_products_args', function( $args )
{
    $args = wp_parse_args( array(
        'posts_per_page' => 4,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock'
            )
        )
    ), $args );
    return $args;
});

// Adinserter Feld 7 Funktion fuer Unikat
add_action( 'woocommerce_single_product_summary', 'llm_content_before_product_title', 1 );

function llm_content_before_product_title() {
	if (function_exists ('adinserter')) echo adinserter (7);
}

// Adinserter Feld 8 Funktion fuer Cross Sell bei Produkt
add_action( 'woocommerce_product_meta_end', 'llm_content_after_product_metas', 10 );

function llm_content_after_product_metas() {
	if (function_exists ('adinserter')) echo adinserter (8);
}


