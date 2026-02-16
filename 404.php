<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2014 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http:/wpopal.com
 * @support  http://wpopal.com
 */

/*
*Template Name: 404 Page
*/

?>

<?php get_header( $wpoEngine->getHeaderLayout() ); ?>

<section class="wpo-mainbody clearfix 404-page">
	<section class="container">
		<div class="page_not_found text-center clearfix">
			<h1 class="skin_color error-title">Ups...</h1>
			<div class="col-sm-12">
				<header class="h3">
			<?php echo wpo_theme_options('404','<br><br><h3">Dein Lieblingsst&uuml;ck ist wohl schon vergriffen.<br>Du wei&szlig;t schon, alle Lieblingsmanufaktur Produkte sind Einzelst&uuml;cke!</h3><br><br>'); ?>
				</header>
				<footer class="page-footer">
					<p><a class="wpllm_button_02 button single_add_to_cart_button alt btn-block" href="https://www.lieblingsmanufaktur.de/tuecher-und-loop-schals/">Klicke hier und Du gelangst direkt zu den derzeit verf&uuml;gbaren Lieblingsst&uuml;cken!</a></p>
					<?php get_search_form(); ?>
				</footer>
			</div>
		</div>
	</section>
</section>

<?php get_footer(); ?>