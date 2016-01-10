<?php
/**
 * The Template for displaying all single posts.
 *
 * @package quadro
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single-header' ); ?>

			<div class="single-wrapper clear">

				<div id="primary" class="content-area">

					<?php get_template_part( 'content', 'single' ); ?>

					<?php quadro_post_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', 'quadro-med-thumb', false ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				</div><!-- #primary -->

				<?php if ( esc_attr( $quadro_options['single_sidebar'] ) == 'sidebar') get_sidebar(); ?>

			</div><!-- .single-wrapper -->

		<?php endwhile; // end of the loop. ?>
	
	</main><!-- #main -->

<?php get_footer(); ?>