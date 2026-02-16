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

extract( shortcode_atts( array(
	'title' => '', 
	'category' => '',
	'number'=>-1,
	'columns_count'=>'4',
	'icon' => '',
	'el_class' => '',
	'style'=>'grid',
	'image_cat' => ''
), $atts ) );

 //echo $image_cat;
// die;

switch ($columns_count) {
	case '6': 
		$class_column = 'col-lg-2 col-md-4 col-sm-6 col-xs-12';
		break;
	case '4':
		$class_column='col-md-3 col-sm-6';
		break;
	case '3':
		$class_column='col-md-4 col-sm-12';
		break;
	case '2':
		$class_column='col-md-6 col-sm-6';
		break;
	default:
		$class_column='col-md-12 col-sm-12';
		break;
}
$_id = wpo_makeid();
if($category=='') return;
$_count = 1;
$loop = wpo_woocommerce_query('',$number,$category);

?>
<div class="widget widget-products <?php echo (($el_class!='')?' '.$el_class:''); ?>">
	<?php if($title){ ?>
		<h3 class="widget-title visual-title">
	       <span><span><?php echo esc_attr( $title ); ?></span></span>
		</h3>
	<?php }
	if ( $loop->have_posts() ) : ?>
		<?php if($image_cat){ ?>
			<div class="cat-image">
				<?php echo wp_get_attachment_image( $image_cat , 'full'); ?>
			</div>
		<?php } ?>
		<div class="woocommerce">
			<div class="widget-content <?php echo $style; ?>">
				<?php wc_get_template( 'widget-products/'.$style.'.php' , array( 'loop'=>$loop,'columns_count'=>$columns_count,'class_column'=>$class_column,'posts_per_page'=>$number ) ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php wp_reset_query(); ?>