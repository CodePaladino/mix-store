<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
extract(shortcode_atts(array(
    'title'           => '',
    'grid_thumb_size' => 'thumbnail',
    'el_class'        => '',
    'grid_columns'    => 3,
    'layout'          => 'list-1',
    'orderby'         => NULL,
    'order'           => 'DESC',
    'loop'            => '',
    'size'            => '',
    'alignment'       => '',
    'grid_columns'    => 3,
), $atts));
if(empty($loop)) return;
$this->getLoop($loop);
$args = $this->loop_args;
?>

<section class="widget wpo-grid-posts section-blog <?php echo (($el_class!='')?' '.$el_class:''); ?>">
    <?php if( $title ) { ?>
        <h3 class="widget-title visual-title <?php echo $size.' '.$alignment; ?>">
           <span><span> <?php echo esc_attr( $title ); ?></span></span>
        </h3>
    <?php } ?>

    <div class="widget-content">
        <?php
            if( $layout == 'categories-posts' && !empty($args['cat']) ) {

            $categories  = explode( ",", $args['cat'] );

            $ccount = count($categories);
            $ccol = floor( 12/$ccount );
        ?>
        <div class="posts-grid-category">
            <div class="row">
                <?php
                    foreach( $categories as $catid ) {
                    $cargs = $args;
                    $cargs['cat'] = $catid;
                    $loop = new WP_Query($cargs);
                ?>

                <?php  if($loop->have_posts()){  ?>
                 <div class="category-posts col-sm-<?php echo $ccol; ?>">
                    <span class="label category-posts-label"><a href="<?php echo esc_url( get_category_link( $catid ) ) ?>"><?php echo esc_attr( get_cat_name( $catid ) ) ?></a></span>
                <?php wpo_get_template('post/'.$layout.'.php', array( 'loop'=> $loop , 'class_column'=> $el_class,'grid_thumb_size'=>$grid_thumb_size ) ); ?>
                <?php  } ?>
                </div>   <?php wp_reset_query(); ?>
                <?php  } ?>
             </div>
         </div>

        <?php } else {  ?>
        <?php

            $loop = new WP_Query($args);
            if($loop->have_posts()){  ?>
                <?php wpo_get_template('post/'.$layout.'.php',array( 'grid_columns' => $grid_columns, 'loop'=> $loop , 'class_column'=> $el_class,'grid_thumb_size'=>$grid_thumb_size ) ); ?>
             <?php  } ?>
          <?php  } ?>
          <?php wp_reset_query(); ?>
    </div>
</section>
