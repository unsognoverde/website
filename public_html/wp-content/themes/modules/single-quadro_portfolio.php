<?php
/**
 * The Template for displaying Portfolio type's (quadro_portfolio) single posts.
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">
		
		<div class="single-wrapper clear">

			<div id="primary" class="content-area">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php quadro_single_portfolio_item( get_the_id() ); ?>

			<?php endwhile; // end of the loop. ?>
			
			</div><!-- #primary -->

		</div><!-- .single-wrapper -->
		
	</main><!-- #main -->

<?php get_footer(); ?>