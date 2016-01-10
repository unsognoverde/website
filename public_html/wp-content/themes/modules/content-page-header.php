<?php
/**
 * The template used for displaying page header in page.php
 *
 */
?>

<?php 
// Get Page metadata
$page_id = get_the_ID();

$hide_header 		= esc_attr( get_post_meta( $page_id, 'quadro_page_header_hide', true ) );

if ( $hide_header != 'true' ) {
	
	$header_pos 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_pos', true ) );
	$header_size 	= esc_attr( get_post_meta( $page_id, 'quadro_page_header_size', true ) );
	$use_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_show_tagline', true ) );
	$page_tagline 	= esc_attr( get_post_meta( $page_id, 'quadro_page_tagline', true ) );
	$back_color     = esc_attr( get_post_meta( $page_id, 'quadro_page_header_back_color', true ) );
	?>

	<header class="page-header <?php echo $header_pos; ?>-header <?php echo $header_size; ?>-header">
		
		<div class="page-inner-header">
			
			<h1 class="page-title"><?php the_title(); ?></h1>
			
			<?php if ( $use_tagline == 'true' ) { ?>
			<h2 class="page-tagline"><?php echo $page_tagline; ?></h2>
			<?php } ?>
			
			<?php quadro_breadcrumbs(); ?>
		
		</div>
	
	</header><!-- .page-header -->

<?php }
?>