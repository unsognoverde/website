<?php
/**
 * Template Name: Page - Centered Content
 * 
 * The template for displaying full width standard pages.
 * Note: Page styles function gets called in header.php
 * 
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page-header' ); ?>

			<div class="page-wrapper clear">

				<div id="primary" class="content-area">

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				</div><!-- #primary -->

			</div><!-- .page-wrapper -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
