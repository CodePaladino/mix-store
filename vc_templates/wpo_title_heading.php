<?php
extract( shortcode_atts( array(
    'title'       => '',
    'title_align' => '',
    'descript'    => '',
    'size'        =>'',
    'font_color'  =>'',
    'el_class'    => ''
), $atts ) );

?>

<div class="widget widget-text-heading <?php echo esc_attr( $el_class ); ?>">
	<?php if($title!=''): ?>
        <h3 class="widget-title visual-title <?php echo $title_align.' '.$size; ?>" style="<?php echo 'color:'.$font_color;?>">
           <span><span><?php echo esc_attr( $title ); ?></span></span>
            <?php if(trim($descript)!=''){ ?>
                <span class="visual-description">
                    <?php echo $descript; ?>
                </span>
            <?php } ?>
        </h3>
    <?php endif; ?>
</div>