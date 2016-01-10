<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="page-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'quadro' ),
					'after'  => '</div>',
				) );
			?>
			<?php edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .page-content -->

</section><!-- #post-## -->
