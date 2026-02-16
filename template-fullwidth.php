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
*Template Name: Layout Full Width
*
*/

$config = $wpoEngine->getPageConfig();

?>
<?php get_header( $wpoEngine->getHeaderLayout() ); ?>
<?php
  if($config['breadcrumb'])
    wpo_breadcrumb();
 ?>


<section id="wpo-mainbody" class="wpo-mainbody vc-temlpate clearfix">
  <!-- MAIN CONTENT -->
  <div class="container-full-width">
    <?php if($config['showtitle']){ ?>
        <header class="container header-title">
            <h1 class="page-title"><span><?php the_title(); ?></span></h1>
        </header><!-- /header -->
    <?php } ?>

    <?php /* The loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                <?php the_content(); ?>
            </article><!-- #post -->
        <?php //comments_template(); ?>
    <?php endwhile; ?>
</div>

</section>

<?php get_footer(); ?>