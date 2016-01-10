<?php

/**
 * Adds useful theme links menu to Admin Toolbar
 */
add_action( 'admin_bar_menu', 'quadro_toolbar', 999 );
function quadro_toolbar( $wp_admin_bar ) {
	$args = array(
		'id'    => 'quadro_toolbar',
		'title' => wp_get_theme() . ' Theme',
		'href'  => admin_url( 'themes.php?page=quadro-settings' ),
		'meta'  => array( 'class' => 'quadro-toolbar-menu' )
	);
	$wp_admin_bar->add_node( $args );

	$args = array(
		'id'    => 'theme_options',
		'title' => esc_html__('Theme Options', 'quadro'),
		'parent' => 'quadro_toolbar',
		'href'  => admin_url( 'themes.php?page=quadro-settings' ),
		'meta'  => array( 'class' => 'quadro-toolbar-theme-options' )
	);
	$wp_admin_bar->add_node( $args );

	$args = array(
		'id'    => 'getting_started',
		'title' => esc_html__('Getting Started', 'quadro'),
		'parent' => 'quadro_toolbar',
		'href'  => admin_url( 'themes.php?page=getting-started' ),
		'meta'  => array( 'class' => 'quadro-toolbar-getting-started' )
	);
	$wp_admin_bar->add_node( $args );

	global $docs_url;
	
	$args = array(
		'id'    => 'theme_docs',
		'title' => esc_html__('Documentation & Guides', 'quadro'),
		'parent' => 'quadro_toolbar',
		'href'  => $docs_url,
		'meta'  => array( 'class' => 'quadro-toolbar-theme-docs' )
	);
	$wp_admin_bar->add_node( $args );

	$args = array(
		'id'    => 'wordpress_training',
		'title' => esc_html__('WordPress Training Videos', 'quadro'),
		'parent' => 'quadro_toolbar',
		'href'  => '//quadroideas.com/video-training/',
		'meta'  => array( 'class' => 'quadro-toolbar-wordpress-training' )
	);
	$wp_admin_bar->add_node( $args );

	$args = array(
		'id'    => 'theme_support',
		'title' => esc_html__('Support', 'quadro'),
		'parent' => 'quadro_toolbar',
		'href'  => '//quadroideas.com/support-center/',
		'meta'  => array( 'class' => 'quadro-toolbar-theme-support' )
	);
	$wp_admin_bar->add_node( $args );
}


/**
 * Adds Useful Pointers to Admin Section
 */
add_action( 'admin_enqueue_scripts', 'quadro_admin_pointers_header' );
function quadro_admin_pointers_header() {
	if ( quadro_admin_pointers_check() ) {
		add_action( 'admin_print_footer_scripts', 'quadro_admin_pointers_footer' );
		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_style( 'wp-pointer' );
	}
}

function quadro_admin_pointers_check() {
	$admin_pointers = quadro_admin_pointers();
	foreach ( $admin_pointers as $pointer => $array ) {
		if ( $array['active'] )
			return true;
	}
}

function quadro_admin_pointers_footer() {
	$admin_pointers = quadro_admin_pointers();
	?>
<script type="text/javascript">
/* <![CDATA[ */
( function($) {
	<?php
	foreach ( $admin_pointers as $pointer => $array ) {
		if ( $array['active'] ) {
			?>
			jQuery( '<?php echo $array['anchor_id']; ?>' ).pointer( {
				content: '<?php echo $array['content']; ?>',
				position: {
				edge: '<?php echo $array['edge']; ?>',
				align: '<?php echo $array['align']; ?>'
			},
				close: function() {
					jQuery.post( ajaxurl, {
						pointer: '<?php echo $pointer; ?>',
						action: 'dismiss-wp-pointer'
					} );
				}
			} ).pointer( 'open' );
			<?php
		}
	}
	?>
} )(jQuery);
/* ]]> */
</script>
	<?php
}

function quadro_admin_pointers() {
	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	$version = '1_0'; // replace all periods in 1.0 with an underscore
	$prefix = 'quadro_admin_pointers' . $version . '_';

	$new_pointer_content = '<h3>' . esc_html__( 'Theme Shortcuts', 'quadro' ) . '</h3>';
	$new_pointer_content .= '<p>' . esc_html__( 'Easily access your Theme Options, Docs or Support by selecting from this drop down menu.', 'quadro' ) . '</p>';

	return array(
		$prefix . 'theme_shortcuts' => array(
			'content' => $new_pointer_content,
			'anchor_id' => '#wp-admin-bar-quadro_toolbar',
			'edge' => 'top',
			'align' => 'left',
			'active' => ( ! in_array( $prefix . 'theme_shortcuts', $dismissed ) )
		),
	);
}