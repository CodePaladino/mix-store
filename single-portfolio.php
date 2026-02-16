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
$wpopconfig = $wpoEngine->getPortfolioConfig();
?>

<?php get_header( wpo_theme_options('headerlayout', '') ); ?>

<?php
	if( wpo_theme_options( 'portfolio_show-breadcrumb', true))
		wpo_breadcrumb();
 ?>

<section id="wpo-mainbody" class="wpo-mainbody clearfix single-portfolio">
	<div class="container">
		<div class="row">
			<?php get_sidebar( 'left' );  ?>
			<!-- MAIN CONTENT -->
			<div class="<?php echo $wpopconfig['main']['class']; ?>">
				<div id="wpo-content" class="wpo-content ">
					<?php while(have_posts()):the_post(); ?>
						<?php if( wpo_theme_options('portfolio_show-title', true)){ ?>
							<div class="title-post"><?php the_title(); ?></div>
						<?php } ?>
							
						</div>
					<div class="post next">
						<div class="post-next">
							<?php previous_post_link('<strong>%link</strong>', 'Previous', FALSE); ?> | <?php next_post_link('<strong>%link</strong>', 'Next', FALSE); ?>
 						</div>
					</div>
					<?php $_video = array('type' => 'wpo_portfolio', 'format' =>'video_link'); //var_dump( wpo_embed( $_video)); ?>
					<div class="post-area single-blog">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="post-container">
							<?php if( wpo_embed( $_video) ){ ?>
							    <div class="entry-thumb post-type-video">
							      <div class="video-thumb video-responsive">
							      	<?php echo wpo_embed( $_video); ?>
							      </div>
							    </div>
							<?php }elseif ( has_post_thumbnail() ) { ?>
								<div class="entry-thumb">
									<a href="<?php the_permalink(); ?>" title="">
										<?php the_post_thumbnail('');?>
									</a>
								</div>
							<?php } ?>
								<div class="entry-content no-border">
									<?php the_content(); ?>
									<?php wp_link_pages(); ?>
								</div>
								<?php if( wpo_theme_options('show-share-portfolio', true)) { ?>
									<div class="post-share">
	                                    <div class="row">
	                                        <div class="col-sm-4">
	                                            <h6><?php echo __( 'Share this Post!',TEXTDOMAIN ); ?></h6>
	                                        </div>
	                                        <div class="col-sm-8">
	                                            <?php wpo_share_box(); ?>
	                                        </div>
	                                    </div>
	                                </div>
                                <?php } ?>

                                <?php
                                if(wpo_theme_options('show-related-portfolio')){
                                    $relate_count = wpo_theme_options('portfolio-items-show', 4);
                                    wpo_related_post($relate_count, 'portfolio', 'Categories');
                                }
                                ?>
							</div>
						</article>
					</div>
					<?php endwhile; ?>
				</div>
				<!-- //MAIN CONTENT -->
				<?php get_sidebar( 'right' );  ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>