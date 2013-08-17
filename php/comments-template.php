<?php
/**
 * The custom template for displaying Comments for comment-guestbook plugin.
 */
if(!defined('ABSPATH')) {
	exit;
}

require_once(CGB_PATH.'php/comments-functions.php');
$cgb_func = new cgb_comments_functions();

// prepare $wp_query->comments when template is displayed
global $wp_query;
if(!isset($wp_query->comments)) {
	$wp_query->comments = get_comments(array('post_id' => $wp_query->post->ID, 'status' => 'approve', 'order' => 'ASC'));
	$wp_query->comment_count = count($wp_query->comments);
}
?>
	<div id="comments">
	<?php $cgb_func->show_comment_form_html('above_comments') ?>
	<?php if(post_password_required()) : ?>
		<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', $cgb_func->l10n_domain); ?></p>
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			echo '</div><!-- #comments -->';
			return;
		endif;
	?>

	<?php if(have_comments()) : ?>
		<?php /* TODO: Insert an option to add a title before the comment list
		<h2 id="comments-title">
			<?php
				printf( get_the_title().' Entries:' );
			?>
		</h2>
		*/
		?>
		<?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
			<nav id="comment-nav-above">
				<?php $cgb_func->show_nav_html(); ?>
			</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use the specified function to format the comments.
				 */
				$cgb_func->list_comments();
			?>
		</ol>

		<?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<?php $cgb_func->show_nav_html(); ?>
		</nav>
		<?php endif; // check for comment navigation ?>
	<?php endif; ?>
	<?php $cgb_func->show_comment_form_html('below_comments') ?>
	</div><!-- #comments -->
