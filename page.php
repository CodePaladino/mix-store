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
 global $wpopconfig;
 $wpopconfig = $wpoEngine->getPageConfig();


get_header( $wpoEngine->getHeaderLayout() ); 
?>

<?php if($wpopconfig['breadcrumb']){ ?>
    <div class="wrapper-breadcrumb">
          <?php wpo_breadcrumb(); ?>
  </div>
<?php } ?>
<section id="wpo-mainbody" class="wpo-mainbody default-template clearfix">
    <div class="container">
      <div class="container-inner">
        <div class="row">
          <!-- MAIN CONTENT -->
          <div id="wpo-content" class="<?php echo esc_attr( $wpopconfig['main']['class'] ); ?>">
            <div id="wpo-content" class="wpo-content">
              <?php if($wpopconfig['showtitle']){ ?>
              <header class="header-title">
                <div class="container">
                  <h1 class="page-title"><?php the_title(); ?></h1>
                </div>  
              </header><!-- /header -->
              <?php } ?>
              <?php /* The loop */ ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                  <?php the_content(); ?>
                </article><!-- #post -->
                <?php if(get_the_ID()==352){ comments_template(); } ?>
              <?php endwhile; ?>
            </div>
          </div>
          <!-- //MAIN CONTENT -->
          <?php get_sidebar( 'left' );  ?>
          <?php get_sidebar( 'right' );  ?>
        </div>
      </div>
    </div>
</section>
<?php get_footer(); ?>
