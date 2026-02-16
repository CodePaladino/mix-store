<?php

extract(shortcode_atts(array(
			'icon' 			=> '',
			'color' 		=> '',
			'image' 		=> '',
			'number' 		=> '',
			'title' 		=> '',
			'style'	 		=> 'vertical',
			'animate'	 	=> '',
			'el_class'	=> '',
	), $atts));


	$color = $color?'style="color:'. $color .';"' : "";

?>
<?php $img = wp_get_attachment_image_src($image,'full'); ?>
<div class="wpo-counter media animate-math counter_<?php echo $style ;?>">
	<?php if( $animate ){ ?>
	<div class="animate" data-anim-type="<?php echo $animate; ?>">
	<?php } ?>

		<div class="counter-icon-wrapper pull-left">
			<?php if( isset($img[0]) ) { ?>
				<img src="<?php echo esc_url( $img[0] );?>" title="<?php echo esc_attr( $title ); ?>" class="media-object image-icon">
			<?php }else if( $icon ) { ?>
			 	<i class="fa <?php echo $icon; ?> fa-4x" <?php echo $color ?>></i>
			<?php } ?>
		</div>
		<div class="media-body counter-desc-wrapper">
			<?php if( $number ) { ?>
			<div class="counter-number counter"><?php echo $number ?></div>
			<?php } ?>
			<?php if( $title ) { ?>
			<h4 class="media-heading counter-title"><span><?php echo esc_attr( $title ) ?></span></h4>
			<?php } ?>
		</div>

	<?php if( $animate ){ ?>
	</div>
	<?php } ?>
 </div>