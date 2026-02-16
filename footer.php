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
global $footer_builder;
$footer = wpo_theme_options('footer-style','default');

?>
	<?php if(is_active_sidebar('social')) dynamic_sidebar('social'); ?>

	<?php if($footer !='default' && (get_post($footer))){ 
		 echo $footer_builder['footer'];
    ?>
    	<footer id="wpo-footer" class="wpo-footer">
            <?php 
              $post = get_post($footer);
              echo do_shortcode( $post->post_content); 
            ?>
      </footer>
	<?php }else{ ?>

	<footer id="wpo-footer" class="wpo-footer">
		<div class="container">
			<section class="footer-top">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="inner wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="200ms" >
							<?php dynamic_sidebar('footer-1'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="inner wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="400ms" >
							<?php dynamic_sidebar('footer-2'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="inner wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="600ms" >
							<?php dynamic_sidebar('footer-3'); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		</div>
	</footer>
	<?php } ?>

	<section class="wpo-copyright">
		<div class="container">
			<div class="copyright">
				<address>
					<?php echo wpo_theme_options('copyright_text', 'Copyright &copy; 2015 - mixstore. All Rights Reserved. <br/> Powered by <a href="' . ( is_ssl()  ? 'https' : 'http') . '://themeforest.net/user/Opal_WP">OpalTheme</a>'); ?>
				</address>

				<?php if(wpo_theme_options('image-payment', '')){ ?>
					<div class="payment">
						<img src="<?php echo esc_url( wpo_theme_options('image-payment', '') ); ?>" />
					</div>
				<?php } ?>

			</div>
		</div>
	</section>

</section>
<!-- END Wrapper -->
<?php wp_footer(); ?>
<div class="return-top">
	<span class="fa fa-angle-up">&nbsp;</span>
	<span><?php echo __('TOP', TEXTDOMAIN) ?></span>
</div>
</body>
</html>