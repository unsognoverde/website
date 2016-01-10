<?php
/**
 * The template for displaying Archive pages.
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

	<?php if ( have_posts() ) : ?>

	<main id="main" class="site-main blog-style-<?php echo esc_attr($quadro_options['blog_layout']); ?> masonry-margins-<?php echo esc_attr($quadro_options['masonry_margins']); ?> <?php echo $sidebar; ?>" role="main">

		<?php // Bring cover img for author
		$style = '';
		if ( is_author() ) {
			$cover_img = esc_url( get_the_author_meta( 'cover_img', get_query_var( 'author' ) ) );
			$style = $cover_img != '' ? 'style="background-image: url(' . $cover_img . ');"' : '';
		} ?>

		<header class="archive-header" <?php echo $style; ?>>
			<div class="inner-archive">
				<?php 
				quadro_archive_title( '<h1 class="archive-title">', '</h1>' );
				
				if ( is_author() ) {
					quadro_author_box( get_query_var( 'author' ) );
				}
				else {
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				} ?>
			</div>
		</header><!-- .archive-header -->
					
		<div class="page-wrapper clear">
		
			<div id="primary" class="content-area">

				<div id="grid" class="<?php echo $anim; ?> anim-<?php echo esc_attr($quadro_options['blog_animation']); ?> blog-container blog-content blog-<?php echo esc_attr($quadro_options['blog_layout']); ?> blog-columns-<?php echo esc_attr($quadro_options['blog_columns']); ?>">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php // Call template for post content
						get_template_part( 'content', esc_attr($quadro_options['blog_layout']) ); ?>

					<?php endwhile; ?>

				</div>

				<?php quadro_paging_nav( '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ); ?>

			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->

	</main><!-- #main -->

	<?php else : ?>

	<main id="main" class="site-main <?php echo $sidebar; ?>" role="main">
		
		<div class="page-wrapper clear">

			<div id="primary" class="content-area">
				<?php get_template_part( 'content', 'none' ); ?>
			</div><!-- #primary -->
			
			<?php get_sidebar(); ?>

		</div><!-- .page-wrapper -->
	
	</main><!-- #main -->

	<?php endif; ?>

<?php get_footer(); ?>
