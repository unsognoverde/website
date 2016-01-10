<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to quadro_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package quadro
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'quadro' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h2>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use quadro_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define quadro_comment() and that will be used instead.
				 * See quadro_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'quadro_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation clear" role="navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'quadro' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'quadro' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'quadro' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'quadro' ); ?></p>
	<?php endif; ?>

	<?php $comment_defaults = array(
		'comment_notes_after'  	=> '',
		'title_reply'          	=> esc_html__( 'Leave a Comment', 'quadro' ),
		'title_reply_to'       	=> esc_html__( 'Leave a Reply to %s', 'quadro' ),
	); ?>

	<?php comment_form( $comment_defaults ); ?>

</div><!-- #comments -->
