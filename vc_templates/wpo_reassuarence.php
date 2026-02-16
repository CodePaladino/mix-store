<?php

extract(shortcode_atts(array(
		'icon' 			=> '',
		'color' 		=> '',
		'image' 		=> '',
		'number' 		=> '',
		'title' 		=> '',
		'style'	 		=> 'vertical',
		'animate'	 	=> 'animate-math',
		'description'	=> '',
		'information'	=> '',
		'size'     		=> '',
		'alignment'     => 'separator_align_left',
		'el_class'	=> ''
	), $atts));


	$color = $color?'style="color:'. $color .';"' : "";

?>
<?php $img = wp_get_attachment_image_src($image,'full'); ?>
<div class="widget wpo-reassuarence <?php echo $animate.' '.$el_class.' '.$alignment; ?> counter_<?php echo $style ;?>">
		<?php if( isset($img[0]) ) { ?>
			<div class="reassuarence-icon">
		 		<img src="<?php echo esc_url( $img[0] );?>" title="<?php echo esc_attr( $title ); ?>" class="image-icon">
		 	</div>
		 <?php }else if( $icon ) { ?>
		 	<div class="reassuarence-icon">
		 		<i class="fa <?php echo $icon; ?> fa-2x" <?php echo $color ?>></i>
		 	</div>
		 <?php } ?>

	   <?php if( $title ) { ?>
		<h3 class="widget-title <?php echo $size.' '.$alignment; ?>">
			<?php echo esc_attr( $title ); ?>
		</h3>
	  <?php } ?>
	  <p class="widget-content"><?php echo $description; ?></p>
 </div>