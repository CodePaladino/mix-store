<?php 
global $wpopconfig;  
$pos = empty($wpopconfig['left-sidebar']) ?wpo_theme_options('left-sidebar'): $wpopconfig['left-sidebar']['widget'];
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
 