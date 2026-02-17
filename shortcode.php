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

add_shortcode('code','wpo_shortcode_code');
function wpo_shortcode_code($atts,$content=null){
    $html = '<pre class="shortcode_sourcecode"><code>
        ' . esc_html( $content ) . '
    </code></pre>';
    return $html;
}

add_shortcode('clearfix', 'wpo_shortcode_clearfix');
function wpo_shortcode_clearfix($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .='
        <div class="clearfix"></div>
    ';
    return $html;
}

add_shortcode('one_full', 'wpo_shortcode_one_full');
function wpo_shortcode_one_full($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-12'
    ), $atts, 'one_full');
    $html ='';
    $html .='
        <div class="col-md-12 ' . esc_attr( $atts['class'] ) . '">';
            $html.= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('one_half', 'wpo_shortcode_one_half');
function wpo_shortcode_one_half($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6',
    ), $atts, 'one_half');
    $html ='';
    $html .='
        <div class="col-md-6 ' . esc_attr( $atts['class'] ) . '">
            '.do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('one_third', 'wpo_shortcode_one_third');
function wpo_shortcode_one_third($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6',
        'title' => '',
    ), $atts, 'one_third');
    $html ='';
    $html .='
        <div class="col-md-4 ' . esc_attr( $atts['class'] ) . '">';
            $html .= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('two_third', 'wpo_shortcode_two_third');
function wpo_shortcode_two_third($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6'
    ), $atts, 'two_third');
    $html ='';
    $html .='
        <div class="col-md-8 ' . esc_attr( $atts['class'] ) . '">';
            $html .= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('one_fourth', 'wpo_shortcode_one_fourth');
function wpo_shortcode_one_fourth($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6'
    ), $atts, 'one_fourth');
    $html ='';
    $html .='
        <div class="col-md-3 ' . esc_attr( $atts['class'] ) . '">';
            $html.= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('three_fourth', 'wpo_shortcode_three_fourth');
function wpo_shortcode_three_fourth($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-9'
    ), $atts, 'three_fourth');
    $html ='';
    $html .='
        <div class="col-md-9 ' . esc_attr( $atts['class'] ) . '">';
            $html.= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('one_sixth', 'wpo_shortcode_one_sixth');
function wpo_shortcode_one_sixth($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6'
    ), $atts, 'one_sixth');
    $html ='';
    $html .='
        <div class="col-md-2 ' . esc_attr( $atts['class'] ) . '">';
            $html .= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('seven_twelve', 'wpo_shortcode_seven_twelve');
function wpo_shortcode_seven_twelve($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6'
    ), $atts, 'seven_twelve');
    $html ='';
    $html .='
        <div class="col-md-7 ' . esc_attr( $atts['class'] ) . '">';
            $html.= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('five_twelve', 'wpo_shortcode_five_twelve');
function wpo_shortcode_five_twelve($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => 'col-sm-6'
    ), $atts, 'five_twelve');
    $html ='';
    $html .='
        <div class="col-md-5 ' . esc_attr( $atts['class'] ) . '">';
            $html.= do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('panel_group', 'wpo_shortcode_panel_group');
function wpo_shortcode_panel_group($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'id' => '',
        'sub_title' => '',
        'class' => '',
        'animate' => '',
    ), $atts, 'panel_group');
    $html ='';
    $html .='
        <div class="panel-group" id="' . esc_attr( $atts['id'] ) . '">
            '.do_shortcode($content).'
        </div>
    ';
    return $html;

}
add_shortcode('panel', 'wpo_shortcode_panel');
function wpo_shortcode_panel($atts, $content=null){
    static $counter = 1;
    $atts = shortcode_atts(
        array(
        'id_parent' => '',
        'in' => '',
        'title' => '',
        'type' => 'default',
        'animate' => '',
    ), $atts, 'panel');
    if($atts['in']=="true"){
        $in = 'in';
    }else{
        $in = '';
    }
    $html ='';
    $html .='
        <div class="panel panel-' . esc_attr( $atts['type'] ) . '">
            <div class="panel-heading">
                <h4 class="panel-title">
                 <a class="accordion-toggle" data-toggle="collapse" data-parent="#' . esc_attr( $atts['id_parent'] ) . '" href="#collapsepanel' . absint( $counter ) . '">' . esc_html( $atts['title'] ) . '</a>
                </h4>
            </div>
            <div id="collapsepanel' . absint( $counter ) . '" class="panel-collapse collapse ' . esc_attr( $in ) . '">
                <div class="panel-body">
                <div>'.do_shortcode($content).'</div>
                </div>
            </div>
        </div>
    ';
    $counter++;
    return $html;

}

add_shortcode('accordion', 'wpo_shortcode_accordion');
function wpo_shortcode_accordion($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'id' => '',
        'sub_title' => '',
        'class' => '',
        'animate' => '',
    ), $atts, 'accordion');
    $html ='';
    $html .='
        <div class="accordion" id="' . esc_attr( $atts['id'] ) . '">
            '.do_shortcode($content).'
        </div>
    ';
    return $html;

}

add_shortcode('accordion_item', 'wpo_shortcode_accordion_item');
function wpo_shortcode_accordion_item($atts, $content=null){
    static $counter = 1;
    $atts = shortcode_atts(
        array(
        'id_parent' => '',
        'effect' => '',
        'in' => '',
        'title' => '',
        'animate' => '',
    ), $atts, 'accordion_item');
    if($atts['in']=="true"){
        $in = 'in';
    }else{
        $in = '';
    }
    $html ='';
    $html .='
        <div class="accordion-group">
            <div class="accordion-heading">
                 <a class="accordion-toggle" data-toggle="collapse" data-parent="#' . esc_attr( $atts['id_parent'] ) . '" href="#collapse' . absint( $counter ) . '"><em class="icon-plus icon-fixed-width"></em>' . esc_html( $atts['title'] ) . '</a>
            </div>
            <div id="collapse' . absint( $counter ) . '" class="accordion-body collapse ' . esc_attr( $in ) . '">
                <div class="accordion-inner">
                <div>'.do_shortcode($content).'</div>
                </div>
            </div>
        </div>
    ';
    $counter++;
    return $html;

}

add_shortcode('button','wpo_shortcode_button');
 function wpo_shortcode_button($atts, $content = null){
     $atts = shortcode_atts(
        array(
        'type'=>'default',
        'size'=>'',
        'disable'=>'',
        'block'=>'',
        'link'=>'#',
    ), $atts, 'button');
    if($atts['disable']=='true'){
        $disable = 'disable';
    }else{
        $disable = '';
    }
    if($atts['block']=='true'){
        $block = 'block';
    }else{
        $block = '';
    }
    $html ='';
    $html .='
        <a class="btn ' . esc_attr( $disable ) . ' btn-' . esc_attr( $atts['type'] ) . ' btn-' . esc_attr( $block ) . ' btn-' . esc_attr( $atts['size'] ) . '" href="' . esc_url( $atts['link'] ) . '">'.do_shortcode($content).'</a>
    ';
    return $html;
}

add_shortcode('tabs', 'wpo_shortcode_tabs_group');
function wpo_shortcode_tabs_group($atts, $content = null ) {
    global $tabs_divs;
    $atts = shortcode_atts(array(
        'style' => '',
    ), $atts, 'tabs');
    $tabs_divs = '';

    $output = '<div class="tabbable tabs-' . esc_attr( $atts['style'] ) . '"><ul class="nav nav-tabs"';
    $output.='>'.do_shortcode($content).'</ul>';
    $output.= '<div class="tab-content">'.$tabs_divs.'</div></div>';

    return $output;
}

add_shortcode('tab', 'wpo_shortcode_tab');
function wpo_shortcode_tab($atts, $content = null) {
    global $tabs_divs;

    $atts = shortcode_atts(array(
        'id' => '',
        'title' => '',
        'active' => '',
    ), $atts, 'tab');

    if(empty($atts['id']))
        $atts['id'] = 'side-tab'.rand(100,999);

    $output = '
        <li class="' . esc_attr( $atts['active'] ) . '">
            <a href="#' . esc_attr( $atts['id'] ) . '" data-toggle="tab">' . esc_html( $atts['title'] ) . '</a>
        </li>
    ';

    $tabs_divs.= '<div class="tab-pane ' . esc_attr( $atts['active'] ) . '" id="' . esc_attr( $atts['id'] ) . '">'.do_shortcode($content).'</div>';

    return $output;
}

add_shortcode('alert_box', 'wpo_shortcode_alert_box');
function wpo_shortcode_alert_box($atts, $content = null){
    $atts = shortcode_atts(array(
        'type' => '',
    ), $atts, 'alert_box');
    $html ='';
    $html .='
         <div class="alert alert-' . esc_attr( $atts['type'] ) . '">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          '.do_shortcode($content).'
        </div>
    ';
    return $html;
}

add_shortcode('icon','wpo_shortcode_icon');
 function wpo_shortcode_icon($atts, $content = null){
     $atts = shortcode_atts(
        array(
        'icon_name'=>''
    ), $atts, 'icon');
    $html = '';
    $html .='
        <i class="fa ' . esc_attr( $atts['icon_name'] ) . '"></i>
    ';
    return $html;
 }