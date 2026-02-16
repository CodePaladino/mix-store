<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WPOpal  Team <wpopal@gmail.com, support@wpopal.com>
 * @copyright  Copyright (C) 2014 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
wp_enqueue_style( 'isotope-css' );
wp_enqueue_script( 'isotope' );

extract( shortcode_atts( array(
  'title'         => '',
  'size'          => '',
  'el_class'      => '',
  'descript'      => '',
  'alignment'     => '',
  'template'      => '',
  'number'        => -1,
  'columns_count' => '4',
  'style'         => 'effect5 left_to_right'
  ), $atts ) );

switch ($columns_count) {
  case '6':
  $class_column='2';
  break;
  case '4':
  $class_column='3';
  break;
  case '3':
  $class_column='4';
  break;
  case '2':
  $class_column='6';
  break;
  default:
  $class_column='12';
  break;
}

$portfolio_skills = get_terms('Categories',array('orderby'=>'id'));
$args = array(
  'post_type' => 'portfolio',
  'posts_per_page'=>$number
  );
$loop = new WP_Query($args);

?>

<div class="widget wpb_grid wpo-portfolio <?php echo (($el_class!='')?' '.$el_class:''); ?>">
  <div class="teaser_grid_container">
    <div class="wpb_filtered_grid teaser_grid_container">
        <?php if( $title ) { ?>
            <h3 class="widget-title visual-title <?php echo $size.' '.$alignment; ?>">
                <span><span><?php echo esc_attr( $title ); ?></span></span>
                <?php if(trim($descript)!=''){ ?>
                <span class="visual-description">
                <?php echo $descript; ?>
                </span>
                <?php } ?>
            </h3>
        <?php } ?>

      <?php if( $loop->have_posts()): ?>
      <!-- filters category -->
      <div id="filters" class="isotope-filter">
        <ul class="nav nav-tabs wpo-portfolio-filters categories_filter">
          <?php
          $terms = $portfolio_skills;
          $count = count($terms);
          echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';

          if ( $count > 0 ){
            foreach ( $terms as $term ) {
              echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$term->slug.'">'.esc_attr( $term->name ).'</a></li>';
            }
          }
          ?>
        </ul>
      </div>

      <!-- end filters -->
      <?php $_id = wpo_makeid();

      ?>

      <div class="isotope-list row wpb_thumbnails wpb_thumbnails-fluid clearfix list-unstyled" data-isotope-duration="400" id="isotope-<?php echo $_id; ?>">
       <?php while($loop->have_posts()): $loop->the_post();

       $item_classes = 'all ';
       $item_cats = get_the_terms( $loop->post->ID, 'Categories' );

       foreach((array)$item_cats as $item_cat){
         if(count($item_cat)>0){
           $item_classes .= $item_cat->slug . ' ';
         }
       }
       $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'blog-thumbnails' );
       ?>
       <div class="isotope-item col-sm-<?php echo $class_column; ?> item col-md-<?php echo $class_column; ?> col-lg-<?php echo $class_column; ?> <?php echo $item_classes; ?>">
        
        <div class="wpo-portfolio-content thumbnail text-center">
          <div class="ih-item square colored <?php echo $style; ?>">
            <a href="<?php the_permalink(); ?>">
              <div class="img">
                  <?php if ( has_post_thumbnail()) {
                    the_post_thumbnail('blog-thumbnails');
                  }?>
              </div>
              <div class="info">
              <h3><?php the_title(); ?></h3>
              <p><?php echo wpo_excerpt(20,'...'); ?></p>
              </div>
            </a>
          </div>
      </div>

    </div>
    <?php endwhile; ?>
    </div>


    <?php endif; ?>
    </div>
  </div>  
</div>    
<?php wp_reset_query(); ?>

<script>

</script>