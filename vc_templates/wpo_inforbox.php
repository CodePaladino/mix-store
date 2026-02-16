<?php
extract( shortcode_atts( array(
	'title'       =>'',
	'imagebg'     => '',
	'colorbg'     => '',
	'el_class'    =>'',
	'size'        =>'',
	'title_align' =>'',
	'information' =>''
), $atts ) );

 $style = array();
?>

<?php $img = wp_get_attachment_image_src($imagebg,'full'); ?>
<?php
	if( isset($img[0]) )  {
		 $style[] = "background-image:url('".esc_url( $img[0] )."')";
	}
	if( $colorbg ){
		$style[] = "background-color:".$colorbg;
	}
?>


<div class="widget wpo-inforbox <?php echo $el_class;?>" style="<?php echo  implode(';', $style); ?>">
	<?php if($title!=''): ?>
    	<h3 class="widget-title inforbox-heading <?php echo $title_align.' '.$size; ?>">
			<span><span><?php echo esc_attr( $title ); ?></span></span>
		</h3>
    <?php endif; ?>

    <?php if(trim($information)!=''){ ?>
        <div class="inforbox-content">
			<?php echo do_shortcode( $information );?>
		</div>
    <?php } ?>
</div>