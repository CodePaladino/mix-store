<?php  
global $wpopconfig;  
$pos = wpo_theme_options('woocommerce-archive-right-sidebar');
?>

<?php if($wpopconfig['right-sidebar']['show']){ ?>
	<div class="<?php echo $wpopconfig['right-sidebar']['class']; ?>">
		<div class="wpo-sidebar wpo-sidebar-right">
			<div class="sidebar-inner">
				<?php dynamic_sidebar( $pos ); ?>
			</div>
		</div>
	</div>
<?php } ?>
