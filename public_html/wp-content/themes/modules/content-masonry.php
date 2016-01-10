<?php
/**
 * @package quadro
 */
?>

<?php // Retrieve Theme Options
global $quadro_options;
// Set Columns to selected choices in Module if being called from a Module
// or let it adjust to Theme Options if not
$columns = isset($mod_id) ? $blog_columns : $quadro_options['blog_columns'];
?>

<?php
$post_format = get_post_format();
$post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item size-item'); ?>>
	
	<?php // Declare global $more (before the loop) to allow <!--more--> tag
	global $more; $more = 0; ?>

	<header class="entry-header">

		<div class="entry-thumbnail">

		<?php switch ( $post_format ) {
			case 'video':

				// if post thumbnail, bring it
				if ( has_post_thumbnail() && ! post_password_required() ) { ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'quadro-med-thumb'); ?></a>
				<?php } else {
					// there's no thumbnail, try to bring a video screenshot
					quadro_video_screenshot( get_the_content(), esc_url( get_the_permalink() ), get_the_title() );
				}
				break;
			
			case 'image':
				if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('full'); ?></a>
				<?php endif;
				break;

			case 'gallery':
				if ( get_post_gallery() ) {
					// Retrieve first gallery
					$gallery = get_post_gallery( get_the_ID(), false );
					if ( isset($gallery['ids']) ) {
						// Remove Galleries from content
						$content = quadro_strip_shortcode_gallery( get_the_content( '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>' ) );
						echo '<div class="entry-gallery"><ul class="slides">';
						/* Loop through all images and output them one by one */
						$gallery_ids = explode(',', $gallery['ids']);
						foreach( $gallery_ids as $pic_id ) {
							echo '<li class="gallery-item">';
							echo wp_get_attachment_image( $pic_id, 'quadro-med-thumb' );
							echo ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
							echo '</li>';
						}
						echo '</ul></div>';
					} else {
						// Exit if gallery has no ids (old versions),
						// and leave content intact.
						$content = get_the_content( '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>' );
					}
				} else {
					// Bring Content if no gallery anyway
					$content = get_the_content( '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>' );
				}
				// Filter through the_content filter
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );
				break;

			default:
				if ( has_post_thumbnail() && ! post_password_required() && $post_format != 'aside' && $post_format != 'status' ) : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'quadro-med-thumb', array('alt' => get_the_title(), 'title' => get_the_title(), 'class' => 'attachment-quadro-med-thumb wp-post-image lazy') ); ?></a>
				<?php endif;
				break;
		} ?>

		</div><!-- .entry-thumbnail -->

		<?php if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' ) { ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php } ?>

		<?php if ( 'post' == $post_type ) {
			// Print date meta
			quadro_posted_on();
		} ?>

		<?php if ( 'post' == $post_type && ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' && $post_format != 'image' && $post_format != 'link' ) ) { 
		// Hide category and tag text for pages on Search ?>
			<?php $categories_list = get_the_category_list( ', ' );
			if ( $categories_list && quadro_categorized_blog() ) : ?>
				<span class="cat-links">
					<?php echo $categories_list; ?>
				</span>
			<?php endif; // End if categories ?>
		<?php } ?>

	</header><!-- .entry-header -->


	<?php // We show here the excerpt, but not for these formats
 	if ( $post_format == '' || $post_format == 'gallery' ) { ?>
		<div class="entry-summary">
			<?php echo quadro_excerpt(get_the_excerpt(), 30, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?>
		</div><!-- .entry-summary -->
	<?php } else {
		if ( $post_format == 'quote' ) {
			echo '<div class="entry-summary">';
			echo quadro_just_quote(get_the_content(), '', '');
			echo '<a href="' . esc_url( get_the_permalink() ) . '" class="readmore-link"><span class="read-more">' . esc_html__('Read more', 'quadro') . '</span></a>';
			echo '</div>';
		} elseif ( $post_format == 'link' && is_array($the_link = quadro_getUrls(get_the_content())) && isset($the_link[0]) ) {
			// $the_link = quadro_getUrls(get_the_content())[0];
			$the_link = $the_link[0];
			$the_link_parsed = parse_url($the_link);
			echo '<div class="entry-summary">';
			echo '<p class="the-link-url"><a href="' . esc_url( $the_link ) . '" title="' . $the_link . '">' . $the_link_parsed['host'] . '</a></p>';
			echo '</div>';
		} elseif ( $post_format == 'audio' || $post_format == 'video' ) {
			echo '<div class="entry-summary">';
			echo quadro_excerpt(get_the_excerpt(), 30, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>');
			echo '</div>';
		} elseif ( $post_format == 'image' ) {
			// nothing here
		} elseif ( $post_format == 'aside' || $post_format == 'status' ) {
			// Bring the full content for the other formats (aside & status between others)
			echo '<div class="entry-summary">';
			the_content( '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>' );
			echo '</div>';
		} else { ?>
			<div class="entry-summary">
			<?php echo quadro_excerpt(get_the_excerpt(), 30, '<span class="read-more">' . esc_html__('Read more', 'quadro') . '</span>'); ?>
			</div><!-- .entry-summary -->
		<?php }
	} ?>

</article><!-- #post-## -->
