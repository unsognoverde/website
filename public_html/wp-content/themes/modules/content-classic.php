<?php
/**
 * @package quadro
 */
?>

<?php // Enabling the "more tag"
global $more;
$more = 0;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>

	<?php get_template_part( 'content', 'classic-header' ); ?>

	<div class="entry-content">
		<?php qi_before_post(); ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'quadro' ),
				'after'  => '</div>',
			) );
		?>
		<?php qi_after_post(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php
			$tag_list = get_the_tag_list( '', ' ' );

			if ( '' != $tag_list ) {
				$meta_text = '<p class="single-tags">' . esc_html__( '%1$s', 'quadro' ) . '</p>';
			} else {
				$meta_text = '';
			}

			printf(
				$meta_text,
				$tag_list,
				esc_url( get_permalink() )
			);
		?>
		
		<?php edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->