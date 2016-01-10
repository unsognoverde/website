<?php
/**
 * @package quadro
 */
?>

<?php
// Retrieve Theme Options
global $quadro_options;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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

		<?php if ( $quadro_options['single_author_box'] == 'show' ) quadro_author_box( $post->post_author ); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
