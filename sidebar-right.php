<?php  
global $wpopconfig;

?>

<?php if($wpopconfig['right-sidebar']['show']){ ?>
	<div class="<?php echo $wpopconfig['right-sidebar']['class']; ?>">
		<div class="wpo-sidebar wpo-sidebar-right">
			<div class="sidebar-inner">
				<?php dynamic_sidebar( $wpopconfig['right-sidebar']['widget'] ); ?>
			</div>
		</div>
	</div>
<?php } ?>