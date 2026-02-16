<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '' ,
    'css'             => '',
    'parallax'        => '0',
    'isfullwidth'     => '1'
), $atts));

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$is_parallax = ($parallax!='' && $parallax!='0') ? true : false;

if($is_parallax){
    $el_class .=' parallax';
    $parallax = ' data-stellar-background-ratio="0.6"';
}else{
    $parallax = '';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class(), $this->settings['base'], $atts );
//$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );


$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

$output='<section class="wpb-container' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ).'" '.$parallax.'><div class="wpb-inner'.($isfullwidth?' container':' ').'" '.$style.'>';

if($is_parallax) $output .= '<div class="parallax-inner">';

$output .= '<div class="'.$css_class.'"'.$style.'>';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'.$this->endBlockComment('row');

if($is_parallax) $output.='</div>';
$output.='</div></section>';
echo $output;