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

/*
*Template Name: Magazine
*
*/
global $wpopconfig;
$wpopconfig = $wpoEngine->getPageConfig();
?>
 <?php get_header( $wpoEngine->getHeaderLayout() ); ?>
 <?php wpo_breadcrumb(); ?>

<section id="wpo-mainbody" class="wpo-mainbody news-page clearfix">
    <div class="container">
        <div class="row">
        <?php get_sidebar( 'left' );  ?>
            <?php /******************************* MAIN CONTENT ************************************/ ?>
            <div class="<?php echo $wpopconfig['main']['class']; ?>">
                <div id="wpo-content" class="wpo-content no-padding bg-transparent">
                  <?php if($config['showtitle']){ ?>
                      <header class="header-title">
                          <h1 class="page-title"><span><?php the_title(); ?></span></h1>
                      </header><!-- /header -->
                  <?php } ?>

                  <?php /* The loop */ ?>
                      <?php while ( have_posts() ) : the_post(); ?>
                      <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                          <?php the_content(); ?>
                      </article><!-- #post -->
                      <?php //comments_template(); ?>
                  <?php endwhile; ?>
              </div>
            </div>

          
          <?php get_sidebar( 'right' ); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>