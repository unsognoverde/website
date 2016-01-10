<?php
/**
 * The main template file.
 *
 * We'll be using this file as the home template file.
 *
 * @package quadro
 */

get_header(); ?>

<?php // Retrieve Theme Options
global $quadro_options; ?>

<?php // Define Animations
$anim = esc_attr($quadro_options['blog_layout']) == 'masonry' ? 'anim-grid' : ''; ?>

<?php // Define Sidebar class
$sidebar = esc_attr($quadro_options['blog_sidebar']) == 'sidebar' ? 'with-sidebar' : 'no-sidebar'; ?>

	<main id="main" class="site-main blog-style-<?php echo esc_attr($quadro_options['blog_layout']); ?> masonry-margins-<?php echo esc_attr($quadro_options['masonry_margins']); ?> <?php echo $sidebar; ?>" role="main">

		<div class="page-wrapper clear">
		
			<div id="primary" class="content-area">

			<?php if ( have_posts() ) : ?>

				<div id="grid" class="<?php echo $anim; ?> anim-<?php echo esc_attr($quadro_options['blog_animation']); ?> blog-container blog-content blog-<?php echo esc_attr($quadro_options['blog_layout']); ?> blog-columns-<?php echo esc_attr($quadro_options['blog_columns']); ?>">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php // Call template for post content
						get_template_part( 'content', esc_attr($quadro_options['blog_layout']) ); ?>

					<?php endwhile; ?>

				</div>

				<?php quadro_paging_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->

	</main><!-- #main -->

<?php get_footer(); ?>
