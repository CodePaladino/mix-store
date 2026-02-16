<?php
global $vc_teaser_box;
$grid_link = $grid_layout_mode = $title = $filter = '';
$posts = array();
extract( shortcode_atts( array(
	'title' => '',
	'grid_columns_count' => 4,
	'grid_teasers_count' => 8,
	'grid_layout' => 'title,thumbnail,text', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
	'grid_link_target' => '_self',
	'filter' => '', //grid,
	'grid_thumb_size' => 'thumbnail',
	'grid_layout_mode' => 'fitRows',
	'el_class' => '',
	'teaser_width' => '12',
	'orderby' => NULL,
	'order' => 'DESC',
	'title_align'        => '',
	'size'               =>'',
	'loop' => '',
), $atts ) );
$this->resetTaxonomies();
if ( empty( $loop ) ) return;
$this->getLoop( $loop );
$my_query = $this->query;
$args = $this->loop_args;
$teaser_blocks = vc_sorted_list_parse_value( $grid_layout );
while ( $my_query->have_posts() ) {
	$my_query->the_post(); // Get post from query
	$post = new stdClass(); // Creating post object.
	$post->id = get_the_ID();
	$post->link = get_permalink( $post->id );
	if ( $vc_teaser_box->getTeaserData( 'enable', $post->id ) === '1' ) {
		$post->custom_user_teaser = true;
		$data = $vc_teaser_box->getTeaserData( 'data', $post->id );
		if ( ! empty( $data ) ) $data = json_decode( $data );
		$post->bgcolor = $vc_teaser_box->getTeaserData( 'bgcolor', $post->id );
		$post->custom_teaser_blocks = array();
		$post->title_attribute = the_title_attribute( 'echo=0' );
		if ( ! empty( $data ) )
			foreach ( $data as $block ) {
				$settings = array();
				if ( $block->name === 'title' ) {
					$post->title = the_title( "", "", false );
				} elseif ( $block->name === 'image' ) {
					if ( $block->image === 'featured' ) {
						$post->thumbnail_data = $this->getPostThumbnail( $post->id, $grid_thumb_size );
					} elseif ( ! empty( $block->image ) ) {
						$post->thumbnail_data = wpb_getImageBySize( array( 'attach_id' => (int)$block->image, 'thumb_size' => $grid_thumb_size ) );
					} else {
						$post->thumbnail_data = false;
					}
					$post->thumbnail = $post->thumbnail_data && isset( $post->thumbnail_data['thumbnail'] ) ? $post->thumbnail_data['thumbnail'] : '';
					$post->image_link = empty( $video ) && $post->thumbnail && isset( $post->thumbnail_data['p_img_large'][0] ) ? $post->thumbnail_data['p_img_large'][0] : $video;
				} elseif ( $block->name === 'text' ) {
					if ( $block->mode === 'custom' ) {
						$settings[] = 'text';
						$post->content = $block->text;
					} elseif ( $block->mode === 'excerpt' ) {
						$settings[] = $block->mode;
						if(get_the_excerpt())
							$post->excerpt = $this->getPostExcerpt();
					} else {
						$settings[] = $block->mode;
						$post->content = $this->getPostContent();
					}
				}
				if ( isset( $block->link ) ) {
					if ( $block->link === 'post' ) {
						$settings[] = 'link_post';
					} elseif ( $block->link === 'big_image' ) {
						$settings[] = 'link_image';
					} else {
						$settings[] = 'no_link';
					}
					$settings[] = '';
				}
				$post->custom_teaser_blocks[] = array( $block->name, $settings );
			}
	} else {
		$post->custom_user_teaser = false;
		$post->title = the_title( "", "", false );
		$post->title_attribute = the_title_attribute( 'echo=0' );
		$post->post_type = get_post_type();
		$post->content = $this->getPostContent();
		if(get_the_excerpt())
			$post->excerpt = $this->getPostExcerpt();
		$post->thumbnail_data = $this->getPostThumbnail( $post->id, $grid_thumb_size );
		$post->thumbnail = $post->thumbnail_data && isset( $post->thumbnail_data['thumbnail'] ) ? $post->thumbnail_data['thumbnail'] : '';
		$video = get_post_meta( $post->id, "_p_video", true );
		$post->image_link = empty( $video ) && $post->thumbnail && isset( $post->thumbnail_data['p_img_large'][0] ) ? $post->thumbnail_data['p_img_large'][0] : $video;
	}

	$post->categories_css = $this->getCategoriesCss( $post->id );

	$posts[] = $post;
}
wp_reset_query();

/**
 * Css classes for grid and teasers.
 * {{
 */
$post_types_teasers = '';
if ( ! empty( $args['post_type'] ) && is_array( $args['post_type'] ) ) {
	foreach ( $args['post_type'] as $post_type ) {
		$post_types_teasers .= 'wpb_teaser_grid_' . $post_type . ' ';
	}
}
$el_class = $this->getExtraClass( $el_class );
$li_span_class = $this->spanClass( $grid_columns_count );
$li_span_class = str_replace('vc_','',$li_span_class);

$css_class = 'wpb_row wpb_teaser_grid wpb_content_element ' .
  $this->getMainCssClass( $filter ) . // Css class as selector for isotope plugin
  ' columns_count_' . $grid_columns_count . // Custom margin/padding for different count of columns in grid
  ' columns_count_' . $grid_columns_count . // Combination of layout and column count
  // ' post_grid_'.$li_span_class .
  ' ' . $post_types_teasers . // Css classes by selected post types
  $el_class; // Custom css class from shortcode attributes
// }}

$this->setLinktarget( $grid_link_target );

?>
<div
  class="<?php echo apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ?>">
	<div class="wpb_wrapper">
		<div class="widget">		
			<?php if( $title ) { ?>
				<h3 class="widget-title visual-title <?php echo $title_align.' '.$size; ?>">
					<span><?php echo esc_html( $title ); ?></span>
				</h3>
			<?php } ?>			
			<div class="widget-content teaser_grid_container">
				<?php if ( $filter === 'yes' && ! empty( $this->filter_categories ) ):
				$categories_array = $this->getFilterCategories();
				?>
				<ul class="nav nav-tabs categories_filter vc_col-sm-12 vc_clearfix">
					<li class="active"><a href="#" data-filter="*"><?php _e( 'All', 'js_composer' ) ?></a></li>
					<?php foreach ( $this->getFilterCategories() as $cat ): ?>
					<li><a href="#"
						   data-filter=".grid-cat-<?php echo $cat->term_id ?>"><?php echo esc_attr( $cat->name ) ?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="vc_clearfix"></div>
				<?php endif; ?>
				<ul class="wpb_thumbnails wpb_thumbnails-fluid clearfix row list-unstyled"
					data-layout-mode="<?php echo $grid_layout_mode ?>">
					<?php
					/**
					 * Enqueue js/css
					 * {{
					 */
					wp_enqueue_style( 'isotope-css' );
					wp_enqueue_script( 'isotope' );
					?>
					<?php if ( count( $posts ) > 0 ): ?>
					<?php foreach ( $posts as $post ): ?>
						<?php
						$blocks_to_build = $post->custom_user_teaser === true ? $post->custom_teaser_blocks : $teaser_blocks;
						$block_style = isset( $post->bgcolor ) ? ' style="background-color: ' . $post->bgcolor . '"' : '';
						?>
						<li
						  class="isotope-item <?php echo apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $li_span_class, 'vc_teaser_grid_li', $atts ) . $post->categories_css ?>"<?php echo $block_style ?>>
							<div class="isotope-inner">
							<?php foreach ( $blocks_to_build as $block_data ): ?>

								<?php include $this->getBlockTemplate() ?>
							<?php endforeach; ?>
							</div>
						</li> <?php echo $this->endBlockComment( 'single teaser' ); ?>
						<?php endforeach; ?>
					<?php else: ?>
					<li class="<?php echo $this->spanClass( 1 ); ?>"><?php _e( "Nothing found.", "js_composer" ) ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div> <?php echo $this->endBlockComment( '.wpb_wrapper' ) ?>
	<div class="clear"></div>
</div> <?php echo $this->endBlockComment( '.wpb_teaser_grid' ) ?>