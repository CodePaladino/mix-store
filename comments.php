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

if ( post_password_required() ){
    return;
}
?>
<div id="comments" class="comments">
    <header class="header-title">
        <h5 class="comments-title"><?php comments_number( __('0 Comment', TEXTDOMAIN), __('1 Comment', TEXTDOMAIN), __('% Comments', TEXTDOMAIN) ); ?></h5>
    </header><!-- /header -->

    <?php if ( have_comments() ) { ?>
        <hr>
		<div class="wpo-commentlists">
    	    <ol class="commentlists">
    	        <?php wp_list_comments('callback=wpo_theme_comment'); ?>
    	    </ol>
    	    <?php
    	    	// Are there comments to navigate through?
    	    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    	    ?>
    	    <footer class="navigation comment-navigation" role="navigation">
    	        <div class="previous">&Auml;lterer Kommentar</div>
    	        <div class="next right">Neuerer Kommentar</div>
    	    </footer><!-- .comment-navigation -->
    	    <?php endif; // Check for comment navigation ?>

    	    <?php if ( ! comments_open() && get_comments_number() ) : ?>
    	        <p class="no-comments">Zur Zeit k&ouml;nnen keine Kommentare abgegeben werden.</p>
    	    <?php endif; ?>
        </div>
    <?php } ?> 
	
	<hr>
	
	<?php
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
                        'title_reply'=> __('<h4 class="title">Hinterlasse einen Kommentar</h4>',TEXTDOMAIN),
                        'comment_field' => '<div class="form-group">
                                                <label class="field-label redstar" for="comment">Kommentar<code>*</code>:</label>
                                                <textarea rows="8" id="comment" class="form-control"  name="comment"'.$aria_req.'></textarea>
												<p><br>Bitte beachte unsere <a class="wpllm_button_01" href="https://www.lieblingsmanufaktur.de/datenschutz/" target="_blank">Datenschutzerklärung</a>.</p>
												<p class="redstar"><code>*</code> Pflichtfelder</p>
                                            </div>',
                        'fields' => apply_filters(
                        	'comment_form_default_fields',
                    		array(
                                'author' => '<div class="form-group">
                                            <label for="author" class="redstar">Name<code>*</code>:</label>
                                            <input type="text" name="author" class="form-control" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
                                            </div>',
                                'email' => ' <div class="form-group">
                                            <label for="email" class="redstar">Email<code>*</code>:</label>
                                            <input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
                                            </div>',
								'url' => '<div class="form-group">
                                            <label for="url">Webseite:</label>
                                            <input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
                                            </div>',
                            )),
						'label_submit' => 'Senden',
						'comment_notes_before' => '<div class="form-group h-info">Deine E-Mail-Adresse wird nicht veröffentlicht.</div>',
						'comment_notes_after' => '',
                        );
    ?>
	<?php global $post; ?>
	<?php if('open' == $post->comment_status){ ?>
	<div class="commentform row reset-button-default">
    	<div class="col-sm-12">
			<?php wpo_comment_form($comment_args); ?>
    	</div>
    </div><!-- end commentform -->
	<?php } ?>
</div><!-- end comments -->