<?php 
global $wpopconfig;  
$pos = esc_attr( wpo_theme_options('woocommerce-archive-left-sidebar') );
?> 
<?php if($wpopconfig['left-sidebar']['show']){ ?>
	<div class="<?php echo $wpopconfig['left-sidebar']['class']; ?>">
		<div class="wpo-sidebar wpo-sidebar-left">
			<div class="sidebar-inner">
				<?php dynamic_sidebar( $pos ); ?>
			</div>
 
		</div>
	</div>
<?php } ?>
 