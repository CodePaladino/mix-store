<?php
extract( shortcode_atts( array(
	'title'=>'',
	'size' => '',
	'icon'=> '',
	'style'	=> '',
	'el_class'=>'',
	'title_align'=>'',
	'information'=>''
), $atts ) );

?>

<div class="widget wpo-ourservice <?php echo $el_class.' '.$style.' '; ?>">
	<div class="ourservice-icon">
		<i class="fa <?php echo $icon; ?> text-skin"></i>
	</div>
	<?php if($title!=''): ?>
		<h3 class="ourservice-heading <?php echo $size.' '.$title_align.' '; ?>">
			<span><?php echo esc_attr( $title ); ?></span>
		</h3>
	<?php endif; ?>
	<?php if(trim($information)!=''){ ?>
        <p class="ourservice-content">
			<?php echo do_shortcode( $information );?>
		</p>
    <?php } ?>
</div>