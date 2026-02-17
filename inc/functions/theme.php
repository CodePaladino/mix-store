<?php
//auto add footer type in visual composer
function set_visual_composer_post_type(){
 if($options = get_option('wpb_js_content_types')){
    $check = true;
    foreach ($options as $key => $value) {
      if($value=='footer') $check=false;
    }
    if($check)
      $options[] = 'footer';
  }else{
    $options = array('page','footer');
  }
  update_option( 'wpb_js_content_types',$options );
}
add_action('init','set_visual_composer_post_type',100);


function wpo_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() ) {
    return $title;
  }

  // Add the site name.
  $title .= get_bloginfo( 'name', 'display' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title = "$title $sep $site_description";
  }

  // Add a page number if necessary.
  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
    $title = "$title $sep " . sprintf( __( 'Page %s', TEXTDOMAIN ), max( $paged, $page ) );
  }

  return $title;
}
add_filter( 'wp_title', 'wpo_wp_title', 10, 2 );


function wpo_header_style(){
    $text_color = get_header_textcolor();
    return ;
}

// This theme allows users to set a custom background.
add_theme_support( 'custom-background', apply_filters( 'wpo_custom_background_args', array(
    'default-color' => 'f5f5f5',
  ) ) );

add_theme_support( 'custom-header');

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since Twenty Fourteen 1.0
 */
function wpo_post_thumbnail() {
  
  if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
    return;
  }

  if ( is_singular() ) :
  ?>
  <div class="post-thumbnail">
  <?php
    if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'template-fullwidth.php' ) ) ) {
      the_post_thumbnail( 'fullwidth' );
    } else {
      the_post_thumbnail();
    }
  ?>
  </div>
  <?php else : ?>
  <a class="post-thumbnail" href="<?php the_permalink(); ?>">
  <?php
    if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'template-fullwidth.php' ) ) ) {
      the_post_thumbnail( 'fullwidth' );
    } else {
      the_post_thumbnail();
    }
  ?>
  </a>

  <?php endif; // End is_singular()
}


/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Fourteen 1.0
 */
function wpo_posted_on() {
  if ( is_sticky() && is_home() && ! is_paged() ) {
    echo '<span class="featured-post">' . __( 'Sticky', TEXTDOMAIN ) . '</span>';
  }

  // Set up and print post meta information.
  printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span><span class="meta-sep"> / </span><span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
    esc_url( get_permalink() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    get_the_author()
  );
}
 

/**
 * Find out if blog has more than one category.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return boolean true if blog has more than 1 category
 */
function wpo_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'wpo_category_count' ) ) ) {
    // Create an array of all the categories that are attached to posts
    $all_the_cool_cats = get_categories( array(
      'hide_empty' => 1,
    ) );

    // Count the number of categories that are attached to the posts
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'wpo_category_count', $all_the_cool_cats );
  }

  if ( 1 !== (int) $all_the_cool_cats ) {
    // This blog has more than 1 category so wpo_categorized_blog should return true
    return true;
  } else {
    // This blog has only 1 category so wpo_categorized_blog should return false
    return false;
  }
}

/**
 * Get template part (for templates like the shop-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wpo_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", WC()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( WC()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
		$template = WC()->plugin_path() . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", WC()->template_path() . "{$slug}.php" ) );
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'wc_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 *
 */
function wpo_get_categories( $category ) {
	$categories = get_categories( array( 'taxonomy' => $category ));

	$output = array( '' => __( 'All', TEXTDOMAIN ) );
	foreach( $categories as $cat ){
		if( is_object($cat) ) $output[$cat->slug] = $cat->name;
	}
	return $output;
}

///// Define  list of function processing theme logics.
function wpo_vc_shortcode_render( $atts, $content='' , $tag='' ){
	$output = '';
	if(is_file( WPO_FRAMEWORK_TEMPLATES_PAGEBUILDER. $tag.'.php')){
		ob_start();
		require( WPO_FRAMEWORK_TEMPLATES_PAGEBUILDER.$tag.'.php' );
		$output .= ob_get_clean();
	}
	return $output;
}
/// //
if(wpo_theme_options('is-effect-scroll','1')=='1'){
    add_filter('body_class', 'wpo_animate_scroll');
    function wpo_animate_scroll($classes){
    $classes[] = 'wpo-animate-scroll';
        return $classes;
    }
}


add_filter('body_class', 'wpo_body_class');
function wpo_body_class( $classes ){
  foreach ( $classes as $key => $value ) {
      if ( $value == 'boxed' || $value == 'default' ) 
        unset( $classes[$key] );
  }
  $classes[] = wpo_theme_options('configlayout');
  return $classes;
}


if(function_exists('PostRatings')){
  add_action( 'wpo_rating', 'wpo_vote_count' );
  function wpo_vote_count(){
    $options = PostRatings()->getRating(get_the_ID());
    $classRating = "vote-default";
    if(isset($options['bayesian_rating']) && $options['bayesian_rating']>0 ){
      if(85<$options['bayesian_rating'] && $options['bayesian_rating'] <=100){
        $classRating = "vote-perfect";
      }
      if(75<$options['bayesian_rating'] && $options['bayesian_rating'] <=85){
        $classRating = "vote-good";
      }
      if(65<$options['bayesian_rating'] && $options['bayesian_rating'] <=75){
        $classRating = "vote-average";
      }
      if(55<$options['bayesian_rating'] && $options['bayesian_rating'] <=65){
        $classRating = "vote-bad";
      }
      if(0<$options['bayesian_rating'] && $options['bayesian_rating'] <=55){
        $classRating = "vote-poor";
      }
  ?>
  <?php
    $result_ratings = number_format((float)$options['bayesian_rating']/10,1,'.','');

  ?>
      <div class="entry-vote <?php echo $classRating; ?>"><span class="entry-vote-inner"><?php echo  $result_ratings ?></span></div>
  <?php
    }
  }
}


/*
** Search With Category
*/

if(!function_exists('categories_searchform')){
    function categories_searchform(){
        if(class_exists('WooCommerce')){
        	global $wpdb;
			$dropdown_args = array(
                'show_counts'        => false,
                'hierarchical'       => true,
                'show_uncategorized' => 0
            );
        ?>
		<form role="search" method="get" class="input-group search-category" action="<?php echo esc_url( home_url('/') ); ?>">
            <div class="input-group-addon search-category-container">
            	<label class="select">
            		<?php wc_product_dropdown_categories( $dropdown_args ); ?>
            	</label>
            </div>
            <input name="s" id="s" maxlength="60" class="form-control search-category-input" type="text" size="20" placeholder="Enter search...">
            <div class="input-group-btn">
                <label class="btn btn-link btn-search">
                  <span id="wpo-title-search" class="title-search hidden"><?php _e('Search', TEXTDOMAIN) ?></span>
                  <input type="submit" id="searchsubmit" class="fa searchsubmit" value="&#xf002;"/>
                </label>
                <input type="hidden" name="post_type" value="product"/>
            </div>
        </form>
        <?php
        }else{
        	get_search_form();
        }
    }
}

/*
** Pagination Navigation
*/

if(!function_exists('wpo_pagination_nav')){
    function wpo_pagination_nav($per_page,$total,$max_num_pages=''){
        ?>
        <section class="wpo-pagination">
            <?php global  $wp_query; ?>
            <?php wpo_pagination($prev = __('Previous',TEXTDOMAIN), $next = __('Next',TEXTDOMAIN), $pages=$max_num_pages ,array('class'=>'pull-left')); ?>
            <div class="result-count pull-right">
                <?php
                $paged    = max( 1, $wp_query->get( 'paged' ) );
                $first    = ( $per_page * $paged ) - $per_page + 1;
                $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

                if ( 1 == $total ) {
                    _e( 'Showing the single result', 'woocommerce' );
                } elseif ( $total <= $per_page || -1 == $per_page ) {
                    printf( __( 'Showing all %d results', 'woocommerce' ), $total );
                } else {
                    printf( _x( 'Showing %1$d–%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
                }
                ?>
            </div>
        </section>
    <?php
    }
}

/*
** Load More Portfolio
*/
add_action( 'wp_ajax_wpo_load_more_portfolio', 'wpo_load_more_portfolio' );
add_action( 'wp_ajax_nopriv_wpo_load_more_portfolio', 'wpo_load_more_portfolio' );

if( !function_exists ('wpo_load_more_portfolio')) {
    function wpo_load_more_portfolio() {
        // Verify nonce for security
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'wpo_load_more_portfolio' ) ) {
            wp_send_json_error( array( 'message' => 'Security check failed' ) );
            exit();
        }

        $number = isset( $_POST['number'] ) ? intval( $_POST['number'] ) : 10;
        $paged = isset( $_POST['paged'] ) ? intval( $_POST['paged'] ) : 1;
        $class_column = isset( $_POST['column'] ) ? sanitize_text_field( wp_unslash( $_POST['column'] ) ) : '4';
        $args = array(
            'post_type' => 'portfolio',
            'posts_per_page'=>$number,
            'paged' => $paged
        );
        $loop = new WP_Query($args);
        $result = $posts = array();

        if($loop->have_posts()){
            while($loop->have_posts()) : $loop->the_post();

                $item_classes = 'all ';
                $item_cats = get_the_terms($loop->post->ID, 'Categories');

             foreach((array)$item_cats as $item_cat){
                 if(count($item_cat)>0){
                   $item_classes .= $item_cat->slug . ' ';
                }
             }
             $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'blog-thumbnails' );
                ob_start();
            ?>
             <div class="col-sm-<?php echo esc_attr( $class_column ); ?> item col-md-<?php echo esc_attr( $class_column ); ?> col-lg-<?php echo esc_attr( $class_column ); ?> <?php echo esc_attr( $item_classes ); ?>">
                 <div class="wpo-portfolio-content thumbnail text-center">
                      <?php if ( has_post_thumbnail()) : ?>
                          <figure class="wpo-portfolio-thumbnail">
                              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                  <?php the_post_thumbnail('blog-thumbnails'); ?>
                              </a>
                          </figure>
                      <?php endif; ?>
                      <div class="wpo-portfolio-title caption">
                          <h4 class="entry-title">
                              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                          </h4>
                          <?php if( $image_attributes ) : ?>
                              <a href="<?php echo esc_url( $image_attributes[0] ); ?>" rel="prettyPhoto[<?php echo esc_attr( $item_classes ); ?>]" title="<?php the_title_attribute(); ?>" class="btn btn-outline-inverse">
                                <i class="fa fa-plus"></i>
                              </a>
                        <?php endif; ?>
                          <p class="entry-description"><?php echo wpo_excerpt(20,'...'); ?></p>
                      </div>
                 </div>
             </div>

            <?php
                $posts[] = ob_get_clean();
            endwhile;
            wp_reset_postdata();
        }
        if($paged >= $loop->max_num_pages)
            $result['check'] = false;
        else
            $result['check'] = true;

        $result['posts'] = $posts;
        wp_send_json( $result );
        exit();
    }
}


if ( !function_exists( 'wpo_print_style_footer' ) ) {
  function wpo_print_style_footer(){
    $footer = wpo_theme_options('footer-style','default');
    if($footer!='default'){
    $shortcodes_custom_css = get_post_meta( $footer, '_wpb_shortcodes_custom_css', true );
      if ( ! empty( $shortcodes_custom_css ) ) {
        echo '<style>
              '.$shortcodes_custom_css.'
            </style>
          ';
      }
    }
  }
}
add_action('wp_head','wpo_print_style_footer', 18);
 

if(!function_exists('wpo_add_extra_fields_menu_config')){
    add_action( 'wpo_megamenu_item_config' , 'wpo_add_extra_fields_menu_config' );
    function wpo_add_extra_fields_menu_config($item){
        $item_id = esc_attr( $item->ID );
    ?>
        <p class="field-addclass description description-wide">
            <label for="edit-menu-item-text_customize-<?php echo $item_id; ?>">
                <?php  echo __( 'Text customize', TEXTDOMAIN ); ?><br />
                <select name="menu-item-text_customize[<?php echo $item_id; ?>]">
                  <option value="text_new" <?php selected( esc_attr($item->text_customize), 'text_new' ); ?>><?php _e('New', TEXTDOMAIN); ?></option>
                  <option value="text_hot" <?php selected( esc_attr($item->text_customize), 'text_hot' ); ?>><?php _e('Hot', TEXTDOMAIN); ?></option>
                  <option value="text_featured" <?php selected( esc_attr($item->text_customize), 'text_featured' ); ?>><?php _e('Featured', TEXTDOMAIN); ?></option>
                  <option value="" <?php selected( esc_attr($item->text_customize), '' ); ?>><?php _e('None', TEXTDOMAIN); ?></option>
                </select>
            </label>
        </p>
    <?php
    }
}

if(!function_exists('wpo_custom_nav_update')){
    add_action('wp_update_nav_menu_item', 'wpo_custom_nav_update',10, 3);
    function wpo_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
      // Verify nonce
      if ( ! isset( $_POST['update-nav-menu-nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['update-nav-menu-nonce'] ) ), 'update-nav_menu' ) ) {
          return;
      }
      
      if( ! isset( $_POST['menu-item-text_customize'][$menu_item_db_id] ) ){
          $_POST['menu-item-text_customize'][$menu_item_db_id] = "";
      }
      $custom_value = sanitize_text_field( wp_unslash( $_POST['menu-item-text_customize'][$menu_item_db_id] ) );
      update_post_meta( $menu_item_db_id, 'text_customize', $custom_value );
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */

if(!function_exists('wpo_custom_nav_item')){
    add_filter( 'wp_setup_nav_menu_item','wpo_custom_nav_item' );
    function wpo_custom_nav_item($menu_item) {
        $menu_item->text_customize = get_post_meta( $menu_item->ID, 'text_customize', true );
        return $menu_item;
    }
}

if(!function_exists('wpo_custom_nav_edit_walker')){
    add_filter( 'wp_edit_nav_menu_walker', 'wpo_custom_nav_edit_walker',10,2 );
    function wpo_custom_nav_edit_walker($walker,$menu_id) {
        return 'WPO_Megamenu_Config';
    }
}

if(!function_exists('wpo_comment_form')){
    function wpo_comment_form($arg,$class='btn-primary'){
      ob_start();
      comment_form($arg);
      $form = ob_get_clean();
      echo str_replace('id="submit"','id="submit" class="btn '.$class.'"', $form);
    }
}

if(!function_exists('wpo_comment_reply_link')){
    function wpo_comment_reply_link($arg,$class='btn btn-default btn-xs'){
      ob_start();
      comment_reply_link($arg);
      $reply = ob_get_clean();
      echo str_replace('comment-reply-link','comment-reply-link '.$class, $reply);
    }
}

if(!function_exists('wpo_renderButtonToggle')){
    function wpo_renderButtonToggle($class='btn-primary btn-xs visible-xs', $toggle='offcanvas'){
    ?>
      <a href="javascript:;"
            data-target=".navbar-collapse"
            data-pos="left" data-effect="<?php echo wpo_theme_options('magemenu-offcanvas-effect','off-canvas-effect-1'); ?>"
            data-nav="#wpo-off-canvas"
            data-toggle="<?php echo $toggle; ?>"
            class="navbar-toggle off-canvas-toggle <?php echo $class; ?>">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
        </a>
    <?php
    }
}

if ( !function_exists( 'wpo_theme_options' ) ) {
  function wpo_theme_options( $name, $default = false ) {
    $config = get_option( 'wpo_theme_options' );

    if ( ! isset( $config['id'] ) ) {
      return $default;
    }

    $options = get_option( $config['id'] );

    if ( isset( $options[$name] ) ) {
      return $options[$name];
    }

    return $default;
  }
}

if ( !function_exists( 'wpo_print_style_footer' ) ) {
  function wpo_print_style_footer(){
    $footer = wpo_theme_options('footer-style','default');
    if($footer!='default'){
    $shortcodes_custom_css = get_post_meta( $footer, '_wpb_shortcodes_custom_css', true );
      if ( ! empty( $shortcodes_custom_css ) ) {
        echo '<style>
              '.esc_attr( $shortcodes_custom_css ).'
            </style>
          ';
      }
    }
  }
}
add_action('wp_head','wpo_print_style_footer', 18);

if(!function_exists('wpo_price')){
    function wpo_price($html){
      $tmp = '';
      if ( $html ) {
        $wpoEngine_price = preg_split("/<ins>/", $html);
        if(count($wpoEngine_price) > 1) { 
          $tmp .= '<div class="price old-price"> ';
          if(isset($wpoEngine_price[1])) $tmp .= '<ins>' . $wpoEngine_price[1]; 
          if(isset($wpoEngine_price[0])) $tmp .= $wpoEngine_price[0];
          $tmp .= '</div>';
        }else{ 
          $tmp = '<div class="price">'. $html .'</div>';
        }
      }
      return $tmp;
    }
}
 
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
  $menus = get_terms( array( 
    'taxonomy' => 'nav_menu',
    'hide_empty' => true
  ) ); 
  $locations = get_theme_mod('nav_menu_locations');
  if( ! $locations || ! isset( $locations['mainmenu'] ) || ! $locations['mainmenu'] ) {
    if( ! empty( $menus ) && ! is_wp_error( $menus ) && isset( $menus[0]->term_id ) ) {
      $locations['mainmenu'] = $menus[0]->term_id;
      set_theme_mod( 'nav_menu_locations', $locations );
    }
  }
}
