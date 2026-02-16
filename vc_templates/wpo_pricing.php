<?php
extract( shortcode_atts( array(
 	'title'				 =>'',
 	'subtitle'      	 =>'',
 	'price'         	 =>'',
 	'currency'			 =>'',
 	'period'          	 =>'',
 	'featured'           =>'',
 	'style' 			 =>'',
 	'information'     	 =>'',
 	'link' 				 =>'#',
 	'linktitle'     	 =>'Buy Now!',
 	'style'         	 =>'',
), $atts ) );
 $class = $featured ? "featured-plan": '';
 //var_dump($content);
?>

<div class="wpo-pricing-table panel panel-primary <?php echo $class; ?> text-center">
	<div class="panel-heading pricing-header">
		<h4 class="plan-title"><span><?php echo esc_attr( $title ); ?></span></h4>
		<p class="plan-subtitle"><?php echo esc_attr( $subtitle ); ?></p>
		<div class="plan-price"><sup class="plan-currency"><?php echo $currency; ?></sup> <span class="plan-figure"><?php echo $price; ?></span><sup class="plan-period"> / <?php echo $period; ?></sup> </div>
	</div>
	<div class="panel-body pricing-body no-padding">
		<div class="plain-info">
			<?php echo do_shortcode($content); ; ?>
		</div>
	</div>
	<div class="panel-footer pricing-footer no-padding"><a class="btn btn-lg btn-block btn-outline plan-link" href="<?php echo $link; ?>"><?php echo  $linktitle; ?></a></div>
</div>