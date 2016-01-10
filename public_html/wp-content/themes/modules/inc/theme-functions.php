<?php 
/**
 * This file contains functions that are specific to this theme.
 * 
 */

// Retrieve Theme Options
global $quadro_options;
$quadro_options = quadro_get_options();


/*-----------------------------------------------------------------------------------*/
/*	Post Styling Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Modify the output for the More Tag in posts
 */
if ( ! function_exists( 'quadro_more_tag' ) ) :
function quadro_more_tag() {
	return '<a href="' . esc_url( get_the_permalink() ) . '" class="readmore-link"><span class="read-more">' . esc_html__('Read more', 'quadro') . '</span></a>';
}
endif; // if !function_exists
add_filter( 'the_content_more_link', 'quadro_more_tag' );


/**
 * Sets thumbnail size for Jetpack Related Posts
 */
function quadro_jetpack_related_thumb( $size ) {
	
	global $_wp_additional_image_sizes;
	
	// Return if we have no sizes to set
	if ( !isset($_wp_additional_image_sizes['quadro-med-thumb']) )
		return $size;

	$size = array(
		'width' => $_wp_additional_image_sizes['quadro-med-thumb']['width'],
		'height' => $_wp_additional_image_sizes['quadro-med-thumb']['height']
	);

	return $size;

}
add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'quadro_jetpack_related_thumb' );


/**
 * Filter the_post_thumbnail to add lazy load original attribute
 */
add_filter( 'wp_get_attachment_image_attributes', 'quadro_lazy_original_src', 10, 2 );
function quadro_lazy_original_src( $attr, $attachment ) {
    $attr['data-original'] = $attr['src'];
    return $attr;
}


/*-----------------------------------------------------------------------------------*/
/*	Pages Styling Functions
/*-----------------------------------------------------------------------------------*/

// Aply CSS styles to Pages for Colors & Background
if ( ! function_exists( 'quadro_page_styles' ) ) :
function quadro_page_styles( $page_id ) {

	$page_css = '';
	$css = false;
	$page_use_pic	= get_post_meta( $page_id, 'quadro_page_back_usepic', true );
	$page_pic_url 	= esc_url( get_post_meta( $page_id, 'quadro_page_back_pic', true ) );
	$title_color    = esc_attr( get_post_meta( $page_id, 'quadro_page_title_color', true ) );
	$back_color     = esc_attr( get_post_meta( $page_id, 'quadro_page_header_back_color', true ) );
	$header_use_pic	= get_post_meta( $page_id, 'quadro_page_header_back_usepic', true );
	// Get featured image for background
	if ( $header_use_pic == 'true' ) $feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'full' );

	if ( $page_use_pic == 'true' ) {
		$page_css .= $page_pic_url != '' ? 'body { background-image: url("' . $page_pic_url . '"); background-size: cover; background-repeat: repeat; background-attachment: fixed; }' : '';
		$css = true;
	}

	if ( $title_color != '#' || $back_color != '#' || $header_use_pic ) {
		$page_css .= $title_color != '#' ? 'h1.page-title, .page-tagline { color: ' . $title_color . '; }' : '';
		$page_css .= $back_color != '#' && $header_use_pic != 'true' ? '.page-header { background-color: ' . $back_color . '; }' : '';
		$page_css .= $header_use_pic == 'true' && $feat_image_url[0] != '' ? '.page-header { background-image: url("' . $feat_image_url[0] . '"); }' : '';
		$css = true;
	}

	if ( $css == true ) {
		// Add Dynamically Generated Styles
		echo '<style scoped>' . $page_css . '</style>';
	}

}
endif; // if !function_exists


/*-----------------------------------------------------------------------------------*/
/*	Sections Output (printing) Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Print Site Title & Gravatar / Logo
 */
if ( ! function_exists( 'quadro_site_title' ) ) :
function quadro_site_title() {
	// Retrieve Theme Options
	global $quadro_options;
	echo '<div class="site-branding">';
	if ( $quadro_options['logo_type'] == 'logo' ) { ?>
		<h1 class="site-title logo-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( $quadro_options['logo_img'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>">
			</a>
		</h1>
	<?php } else if ( $quadro_options['logo_type'] == 'title' ) { ?>
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>
	<?php }
	echo '</div>';
}
endif; // if !function_exists


/**
 * Print Site Menu
 */
if ( ! function_exists( 'quadro_site_menu' ) ) :
function quadro_site_menu() {
	?>
	<h1 class="menu-toggle">
		<a href="#msite-navigation">
			<span class="menu-toggle-icon menu-toggle-icon-1"></span>
			<span class="menu-toggle-icon menu-toggle-icon-2"></span>
			<span class="menu-toggle-icon menu-toggle-icon-3"></span>
		</a>
	</h1>
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="inner-nav">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'quadro' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</div>
	</nav><!-- #site-navigation -->
	<?php
}
endif; // if !function_exists


/**
 * Print Site Tagline (About Text)
 */
function quadro_site_about() {
	global $quadro_options;
	if ( esc_attr($quadro_options['about_text']) != '' ) {
		echo '<h2 class="site-description">' . esc_attr($quadro_options['about_text']) . '</h2>';
	}
}


/**
 * Print Search Bar
 */
if ( ! function_exists( 'quadro_search_bar' ) ) :
function quadro_search_bar() {
	// Retrieve Theme Options
	global $quadro_options;
	if ( $quadro_options['search_header_display'] == 'show' ) {
		echo '<div class="search-area"><span class="search-icon"><i class="fa fa-search"></i></span>';
		echo '<div class="search-slide">';
			get_search_form();
		echo '</div></div>';
	}
}
endif; // if !function_exists


/**
 * Prints a Login functionality section, as defined in Theme Options.
 * Will bring a custom menu when user logged in.
 */
if ( ! function_exists( 'quadro_header_login' ) ) :
function quadro_header_login() {
	global $quadro_options;
	echo '<li class="qi-login-link">';
	if( !is_user_logged_in() ) { ?>
		<a href="<?php echo esc_url( $quadro_options['header_login_url'] ); ?>" title="<?php echo esc_attr( $quadro_options['header_login_text'] ); ?>">
			<i class="fa fa-user"></i><span><?php echo esc_attr( $quadro_options['header_login_text'] ); ?></span>
		</a>
	<?php } else { 
		$current_user = wp_get_current_user(); ?>
		<a href="<?php echo esc_url( $quadro_options['header_logged_url'] ); ?>" title="<?php echo $current_user->display_name; ?>">
			<i class="fa fa-user"></i><span><?php echo $current_user->display_name; ?></span></a>
		<?php if ( has_nav_menu( 'user' ) ) { ?>
			<nav id="user-navigation" class="user-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'user' ) ); ?>
			</nav>
		<?php } ?>
	<?php }
	echo '</li>';
}
endif; // if !function_exists


/**
 * Prints the Search bar
 */
if ( ! function_exists( 'quadro_header_search' ) ) :
function quadro_header_search() {
	echo '<li class="search-handler">'; // Add handler for full width, static menu
	echo '<i class="fa fa-search"></i>';
	echo '<div class="header-search">';
	get_search_form();
	echo '</div>';
	echo '</li>';
}
endif; // if !function_exists


/**
 * Prints a handler for the widgetized header section
 */
if ( ! function_exists( 'quadro_header_widgt_handler' ) ) :
function quadro_header_widgt_handler() {
	echo '<li id="widgt-header-handle"><span class="widgt-header-icon"></span></li>';
}
endif; // if !function_exists


/**
 * Add Logout link to User Menu
 */
if ( $quadro_options['header_login'] == 'show' && $quadro_options['header_logout'] == 'show' ) {
	if ( ! function_exists( 'quadro_logout_link' ) ) :
	function quadro_logout_link( $nav, $args ) {
		global $quadro_options;
		$logout_text = $quadro_options['header_logout_text'] != '' ? $quadro_options['header_logout_text'] : 'Logout';
		if( $args->theme_location == 'user' ) 
			return $nav . '<li><a href="' . wp_logout_url( esc_url( get_permalink() ) ) . '" title="' . $logout_text . '"><i class="fa fa-sign-out"></i> ' . $logout_text . '</a></li>';
		return $nav;
	}
	endif; // if !function_exists
	add_filter('wp_nav_menu_items','quadro_logout_link', 10, 2);
}


/**
 * Add actions to qi_header_extras hook
 */
if ( $quadro_options['search_header_display'] == 'show' ) {
	add_action( 'qi_header_extras', 'quadro_header_search', 20 );
}
if ( $quadro_options['header_cart'] == 'show' && class_exists( 'Woocommerce' ) ) {
	add_action( 'qi_header_extras', 'quadro_header_cart', 30 );
}
if ( $quadro_options['header_login'] == 'show' ) {
	add_action( 'qi_header_extras', 'quadro_header_login', 40 );
}
if ( $quadro_options['widgetized_header_display'] == 'show' ) {
	add_action( 'qi_header_extras', 'quadro_header_widgt_handler', 50 );
}


// Check for empty Header Extras action hook
if ( has_action( 'qi_header_extras' ) ) {
	/**
	 * Print Header Extras Wrappers TOP
	 * (only if action hook not empty)
	 * Priorities 1 & 9999.
	 */
	if ( ! function_exists( 'quadro_header_extras_top' ) ) :
	function quadro_header_extras_top() {
		echo '<div class="header-extras"><ul>';
	}
	endif; // if !function_exists
	add_action( 'qi_header_extras', 'quadro_header_extras_top', 1 );

	/**
	 * Print Header Extras Wrappers BOTTOM
	 * (only if action hook not empty)
	 */
	if ( ! function_exists( 'quadro_header_extras_bottom' ) ) :
	function quadro_header_extras_bottom() {
			echo '</ul></div>';
	}
	endif; // if !function_exists
	add_action( 'qi_header_extras', 'quadro_header_extras_bottom', 9999 );

	/**
 	* Add 'header-extras-on' to body class
 	*/
	function quadro_header_extras_class($classes) {
		$classes[] = 'header-extras-on';
		return $classes;
	}
	add_filter('body_class', 'quadro_header_extras_class');
}


/**
 * Print Author Box
 */
if ( ! function_exists( 'quadro_author_box' ) ) :
function quadro_author_box( $author_ID ) {

	global $quadro_options;
	$author = get_user_by( 'id', $author_ID );
	$author_link = get_author_posts_url( $author_ID );
	?>

	<div class="author-box">

		<div class="inner-author">

			<div class="author-name">
				<?php if ( get_avatar( $author->user_email ) ) {
					echo '<a href="' . $author_link . '" title="' . esc_html__('Posts by ', 'quadro') . $author->display_name . '">';
					echo get_avatar( $author->user_email, $size='120', '', $author->display_name ) . '</a>'; 
				} ?>
				<h3>
					<a href="<?php echo $author_link; ?>" title="<?php echo esc_html__('Posts by ', 'quadro') . $author->display_name; ?>">
						<?php echo $author->display_name; ?>
					</a>
				</h3>
			</div>
			
			<?php if ( get_the_author_meta( 'description', $author_ID ) != '' )
			 echo '<div class="author-bio">' . get_the_author_meta( 'description', $author_ID ) . '</div>'; ?>

			<div class="author-extras">
				<?php 
				$user_url = esc_url( get_the_author_meta( 'user_url', $author_ID ) );
				if ( $user_url != '' )
					echo '<a class="author-web" href="' . $user_url . '" title="' . $user_url . '"><i class="fa fa-link"></i></a>';
				// Now get methods defined at Theme Options >> Social Tab
 				if ( is_array( $quadro_options['available_contact_methods'] ) ) {
 					foreach ( $quadro_options['available_contact_methods'] as $method ) {
						$contact = esc_url( get_the_author_meta( $method['slug'], $author_ID ) );
						if ( $contact != '' )
							echo '<a class="author-' . $method['slug'] . '" href="' . $contact . '" title="' . esc_html__('Follow', 'quadro') . ' ' . $author->display_name . ' ' . esc_html__('on', 'quadro') . ' ' . $method['title'] . '"><i class="fa fa-' . $method['slug'] . '"></i></a>';
 					}
 				} ?>
			</div>

		</div>

	</div>

	<?php

}
endif; // if !function_exists


/**
 * Wrapper for header Social Icons function
 * (to be used when marking up header layouts)
 */
function quadro_social_icons_header() {
	quadro_social_icons('social_header_display', 'header-social-icons', 'header_icons_scheme', 'header_icons_color_type');
}


/*-----------------------------------------------------------------------------------*/
/*	Header Sections Output 
/*-----------------------------------------------------------------------------------*/

// Layouts Definition
$header_layouts = array(
	'header-layout1' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array( 'quadro_site_menu' ),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		),
	),
	'header-layout2' => array(
		'1st' => array(
			'left' => array( 'quadro_social_icons_header' ),
			'center' => array( 'quadro_site_title' ),
			'right' => array( 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array( 'quadro_site_menu' ),
			'right' => array()
		)
	),
	'header-layout3' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title', 'quadro_site_about' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array( 'quadro_site_menu' ),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout4' => array(
		'1st' => array(
			'left' => array(),
			'center' => array( 'quadro_site_menu' ),
			'right' => array()
		),
		'2nd' => array(
			'left' => array( 'quadro_social_icons_header' ),
			'center' => array( 'quadro_site_title' ),
			'right' => array( 'qi_header_extras' )
		)
	),
	'header-layout5' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array(),
			'right' => array( 'quadro_site_menu', 'quadro_social_icons_header', 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout6' => array(
		'1st' => array(
			'left' => array( 'qi_header_extras', 'quadro_social_icons_header', 'quadro_site_menu' ),
			'center' => array(),
			'right' => array( 'quadro_site_title' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout7' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title', 'qi_header_extras' ),
			'center' => array( 'quadro_site_menu' ),
			'right' => array( 'quadro_social_icons_header' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout8' => array(
		'1st' => array(
			'left' => array( 'quadro_site_menu', 'qi_header_extras' ),
			'center' => array( 'quadro_site_title' ),
			'right' => array( 'quadro_social_icons_header' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout9' => array(
		'1st' => array(
			'left' => array( 'quadro_social_icons_header' ),
			'center' => array( 'quadro_site_title' ),
			'right' => array( 'qi_header_extras', 'quadro_site_menu' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout10' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title', 'quadro_site_menu' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout11' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title', 'quadro_site_menu' ),
			'center' => array(),
			'right' => array( 'quadro_site_about' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout12' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras', 'quadro_site_menu' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout13' => array(
		'1st' => array(
			'left' => array( 'quadro_site_about' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array(),
			'right' => array( 'quadro_site_menu' )
		)
	),
	'header-layout14' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array(),
			'right' => array( 'quadro_ad_output_header' )
		),
		'2nd' => array(
			'left' => array( 'quadro_site_menu' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		)
	),
	'header-layout15' => array(
		'1st' => array(
			'left' => array( 'quadro_site_menu' ),
			'center' => array(),
			'right' => array( 'quadro_social_icons_header', 'qi_header_extras' )
		),
		'2nd' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array(),
			'right' => array( 'quadro_ad_output_header' )
		)
	),
	'header-layout16' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array( 'quadro_social_icons_header' ),
			'right' => array( 'qi_header_extras', 'quadro_site_menu' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
	'header-layout17' => array(
		'1st' => array(
			'left' => array( 'quadro_site_title' ),
			'center' => array( ),
			'right' => array( 'quadro_site_menu' )
		),
		'2nd' => array(
			'left' => array(),
			'center' => array(),
			'right' => array()
		)
	),
);

// Wrappers for rows and sections in the array
$r = 0; $s = 0;
$row_wrap = array(
	0 => '1st',
	1 => '2nd',
);
$sect_wrap = array(
	'left' => 'left',
	'center' => 'center',
	'right' => 'right',
);


// Run through selected layout and callbacks for each row & section
global $quadro_options;
foreach ( $header_layouts[$quadro_options['header_layout']] as $section ) {
	// And run through each position hook
	foreach ( $section as $index => $functions ) {
		$s = 0;
		foreach ( $functions as $function ) {
			add_action( 'qi_header_' . $row_wrap[$r] . '_row_' . $sect_wrap[$index], $function );
		}
		$s++;
	}
	$r++;
}


/*-----------------------------------------------------------------------------------*/
/*	Modules Functions 
/*  (require declared post type and custom fields definition)
/*-----------------------------------------------------------------------------------*/

// Aply CSS styles to module for Colors & Background
if ( ! function_exists( 'quadro_mod_styles' ) ) :
function quadro_mod_styles( $mod_id ) {
	$header_layout 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_header_layout', true ) );
	$title_color   	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_title_color', true ) );
	$title_back    	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_title_back', true ) );
	$title_use_pic 	= get_post_meta( $mod_id, 'quadro_mod_title_back_usepic', true );
	$title_pic_url 	= esc_url( get_post_meta( $mod_id, 'quadro_mod_title_back_pic', true ) );
	$back_color     = esc_attr( get_post_meta( $mod_id, 'quadro_mod_back_color', true ) );
	$back_pattern 	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_back_pattern', true ) );
	$use_pic    	= get_post_meta( $mod_id, 'quadro_mod_back_usepic', true );
	$pic_url    	= esc_url( get_post_meta( $mod_id, 'quadro_mod_back_pic', true ) );

	if ( ($header_layout != 'none' && $title_back != '#') || $back_color != '#' || $back_pattern != 'none' || $use_pic ) {
		$this_mod_css = '';
		$this_mod_css .= $title_color != '#' ? '#post-' . $mod_id . ' h1.mod-title, #post-' . $mod_id . ' .modheader-intro, #post-' . $mod_id . ' a.modheader-btn { color: ' . $title_color . '; }' : '';
		$this_mod_css .= $title_back != '#' ? '#post-' . $mod_id . ' .mod-header { background-color: ' . $title_back . '; }' : '';
		$this_mod_css .= $title_use_pic == 'true' && $title_pic_url != '' ? '#post-' . $mod_id . ' .mod-header { background-image: url("' . $title_pic_url . '"); background-repeat: no-repeat; background-size: cover; }' : '';
		$this_mod_css .= $back_color != '#' ? '#post-' . $mod_id . ' { background-color: ' . $back_color . '; }' : '';
		$this_mod_css .= $use_pic != 'true' && ($back_pattern != 'none' && $back_pattern != '') ? '#post-' . $mod_id . ' { background-image: url("' . get_template_directory_uri() . '/images/patterns/' . $back_pattern .'.jpg"); background-repeat: repeat; }' : '';
		$this_mod_css .= $use_pic == 'true' && $pic_url != '' ? '#post-' . $mod_id . ' { background-image: url("' . $pic_url . '"); background-repeat: no-repeat; background-size: cover; }' : '';

		// Add Dynamically Generated Styles
		echo '<style scoped>' . $this_mod_css . '</style>';
	}	
}
endif; // if !function_exists


// Check for Parallax Background Option
function quadro_mod_parallax( $mod_id ) {
	// Only if not mobile
	if ( ! wp_is_mobile() ) {
		// Get parallax data
		$parallax = esc_attr( get_post_meta( $mod_id, 'quadro_mod_parallax', true ) );
		echo $parallax == 'true' ? 'parallax-back' : '';
	}
	else {
		return;
	}
}


// Show the Title for Module if option is true
if ( ! function_exists( 'quadro_mod_title' ) ) :
function quadro_mod_title( $mod_id ) {
	// Retrieve options
	$header_layout 	= get_post_meta( $mod_id, 'quadro_mod_header_layout', true );
	$header_intro	= esc_attr( get_post_meta( $mod_id, 'quadro_mod_intro', true ) );
	$header_btn 	= wp_kses_post( get_post_meta( $mod_id, 'quadro_mod_header_btn', true ) );
	$header_btn_url	= esc_url( get_post_meta( $mod_id, 'quadro_mod_header_btn_url', true ) );
	if ( $header_layout != 'none' ) {
		echo '<header class="mod-header">';
			echo '<div class="inner-mod">';
				echo '<h1 class="mod-title">' . get_the_title() . '</h1>';
				if ( $header_intro != "" ) echo '<p class="modheader-intro">' . $header_intro . '</p>';
				if ( $header_btn != "" ) echo '<a href="' . $header_btn_url . '" class="modheader-btn">' . $header_btn . '</a>';
			echo '</div><!-- .inner-mod -->';
		echo '</header><!-- .mod-header -->';
	}
}
endif; // if !function_exists


// Add Twitter, Google and Facebook fields to user profile
add_filter('user_contactmethods', 'quadro_user_contactmethods');
if ( ! function_exists( 'quadro_user_contactmethods' ) ) :
function quadro_user_contactmethods($user_contactmethods) {

 	global $quadro_options;

 	if ( is_array( $quadro_options['available_contact_methods'] ) ) {

 		foreach ( $quadro_options['available_contact_methods'] as $method ) {
			$user_contactmethods[$method['slug']] = $method['title'];
 		}

 	}

	return $user_contactmethods;

}
endif; // if !function_exists


// Add cover image option to user profile
add_action( 'profile_personal_options', 'quadro_show_user_cover_img');
function quadro_show_user_cover_img( $user ) { ?>
	<h3><?php esc_html_e('Author Page Cover Image', 'quadro'); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="twitter"><?php esc_html_e('Image', 'quadro'); ?></label></th>
			<td>
				<input class="upload" id="cover_img" type="text" size="30" name="cover_img" value="<?php echo esc_url( get_the_author_meta( 'cover_img', $user->ID ) ); ?>" />
				<input class="upload_file_button" type="button" value="<?php esc_html_e( 'Select file', 'quadro' ) ?>" />
				<p><?php esc_html_e( 'Once you select the file, click "Choose Image".', 'quadro' ); ?></p>
			</td>
		</tr>
	</table>
<?php }


// Save cover image option for user profile
add_action( 'personal_options_update', 'quadro_save_user_cover_img' );
add_action( 'edit_user_profile_update', 'quadro_save_user_cover_img' );
function quadro_save_user_cover_img( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, 'cover_img', esc_url($_POST['cover_img']) );
}


/**
 * Prepare variable that holds all available animations
 */
$qi_animations = qi_available_animations();


/**
 * Remove 'single' class from body on quadro_mods
 */
add_filter('body_class', 'qi_remove_single_class_from_mod', 20, 2);
function qi_remove_single_class_from_mod($wp_classes) {
	global $post;
	if ( is_object($post) && $post->post_type != 'quadro_mods' ){
		return $wp_classes;
	} else {
		// remove single class
    	$blacklist = array( 'single' );
    	$wp_classes = array_diff( $wp_classes, $blacklist );
    	return $wp_classes;
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Options Add Ons
/*-----------------------------------------------------------------------------------*/

// Add Video Library Banner to Theme Options Sidebar
add_action( 'qi_options_sidebar', 'quadro_options_video_banner' );
function quadro_options_video_banner() {
	?>
	<aside class="qi-aside banner">
		<a href="http://quadroideas.com/video-training?utm_source=Modules&utm_medium=theme&utm_content=101videoBanner">
			<img src="<?php echo get_template_directory_uri(); ?>/images/admin/video-training-banner.jpg"/>
		</a>
	</aside>
	<?php
}


/*-----------------------------------------------------------------------------------*/
/*	Portfolio Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Retrieves content for single portfolio item
 */
if ( ! function_exists( 'quadro_single_portfolio_item' ) ) :
function quadro_single_portfolio_item( $item_id ) {

	// Get a global post reference since get_adjacent_post() references it
    global $post, $quadro_options;

    // Get Item ID from ajax call if there is
    $item_id = isset( $_POST['item_id'] ) ? esc_attr( $_POST['item_id'] ) : $item_id;

    // Get the post object for the specified post and place it in the global variable
    $post = get_post( $item_id );
    setup_postdata( $post );

	// Get Portfolio Item Options
	$media_order 	= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_video_position', true ) );
	$video_out		= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_video_out', true ) );
	$item_style 	= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_item_style', true ) );
	$img_link 		= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_img_link', true ) );
	$viewall_url	= esc_url( get_post_meta( $item_id, 'quadro_portfolio_viewall_url', true ) );
	$viewall_text	= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_viewall', true ) );
	$media_order	= $video_out != 'true' ? explode(',', $media_order) : array('gallery', 'video');
	
	// Prepare Navigation
	$viewall_url 	= $viewall_url != '' ? $viewall_url : esc_url( $quadro_options['portfolio_viewall_url'] );
	$viewall_text 	= $viewall_text != '' ? $viewall_text : esc_attr( $quadro_options['portfolio_viewall'] );
	$prev_id 		= get_previous_post() ? get_previous_post($quadro_options['portfolio_keep_nav_in'], '', 'portfolio_tax')->ID : '';
	$next_id 		= get_next_post() ? get_next_post($quadro_options['portfolio_keep_nav_in'], '', 'portfolio_tax')->ID : '';
	$disabled_prev 	= $prev_id == '' ? 'disabled' : '';
	$disabled_next 	= $next_id == '' ? 'disabled' : '';

	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear ' . $item_style ); ?>>
		
		<header class="item-header">
			<?php qi_before_portf_item_header(); ?>
			<?php // Show view all option if on single. We check for the AJAX $_POST variable
			if ( $viewall_url != '' && !isset($_POST['item_id']) ) { ?>
			<a href="<?php echo $viewall_url; ?>" class="view-all-portf"><span><?php echo $viewall_text; ?></span></a>
			<?php } ?>
			
			<h1 class="item-title"><?php the_title(); ?></h1>
			<div class="item-terms">
				<?php echo get_the_term_list( $item_id, 'portfolio_tax', '', '', '' ); ?>
			</div>
			
			<div class="actions-header">
				<a href="<?php echo esc_url( get_permalink( $prev_id ) ); ?>" class="item-link prev-portf-item <?php echo $disabled_prev; ?>" title="<?php esc_html_e('Prev Item', 'quadro') ?>" data-id="<?php echo $prev_id; ?>"><span class="prev-item"><i class="fa fa-angle-left"></i></span></a>
				<a href="<?php echo esc_url( get_permalink( $next_id ) ); ?>" class="item-link next-portf-item <?php echo $disabled_next; ?>" title="<?php esc_html_e('Next Item', 'quadro') ?>" data-id="<?php echo $next_id; ?>"><span class="next-item"><i class="fa fa-angle-right"></i></span></a>
			</div>
			<?php qi_after_portf_item_header(); ?>
		</header>


		<div class="item-body clear">

			<?php 
			// Try to retrieve Content Transient and set it later if nothing there
			$content_transient = get_transient( 'qi_portf_item_content_' . $item_id );
			// Try to retrieve Media Transient and set it later if nothing there
			$media_transient = get_transient( 'qi_portf_item_media_' . $item_id );
			
			if ( false === $content_transient || false === $media_transient ) {
				$content = get_the_content( $item_id );
			} ?>
			
			<?php // Process Media Content
			if ( $item_style != 'as-created' ) { // Opening Style Conditional

				if ( false === $content_transient || false === $media_transient ) {
					// Remove Galleries from content
					$content = quadro_strip_shortcode_gallery( $content );

					// Filter through the_content filter
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );
				
					$media_transient = '';
					$media_transient .= '<div class="media-wrapper">';
					$media_transient .= '<ul class="portfolio-gallery ' . $item_style . '-gallery slides">';
					
					
					// Define image sizes
					if ( $item_style == 'portf-layout1' || $item_style == 'portf-layout2' ) {
						$correct_thumb = 'large';
					} else if ( $item_style == 'portf-layout5' || $item_style == 'portf-layout5b' ) {
						$correct_thumb = 'quadro-med-full-thumb';
					} else {
						$correct_thumb = 'quadro-full-thumb';
					}

					// Prepare faux element for masonry style. Avoid it if empty content.
					if ( ($item_style == 'portf-layout5' || $item_style == 'portf-layout5b') && $content != '' ) 
						$media_transient .= '<li class="gallery-item faux-element"></li>';

					foreach ( $media_order as $media ) {
						
						switch ($media) {

							case 'gallery':
								if ( get_post_gallery() ) {
									$gallery = get_post_gallery( get_the_ID(), false );
									/* Loop through all images and output them one by one */
									$gallery_ids = explode(',', $gallery['ids']);
									foreach( $gallery_ids as $pic_id ) {
										$full_url = wp_get_attachment_image_src( $pic_id, 'full' );
										$media_transient .= '<li class="gallery-item">';
										$media_transient .= $img_link == 'true' ? '<a href="' . $full_url[0] . '" class="portf-lightbox" rel="lightbox">' : '';
										$media_transient .= wp_get_attachment_image( $pic_id, $correct_thumb );
										$media_transient .= ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
										$media_transient .= $img_link == 'true' ? '</a>' : '';
										$media_transient .= '</li>';
									}
								} else {
									$media_transient .= '<li class="gallery-item">';
									// Bring Item's Featured Image
									$media_transient .= get_the_post_thumbnail( get_the_ID(), $correct_thumb, array('alt' => '' . get_the_title() . '', 'title' => '') );
									$media_transient .= '</li>';
								}
								break;

							case 'video':
								// Exit early if Video Out checked and layout is 'wide-slider-media'
								if ( $video_out == 'true' && ( $item_style == 'wide-slider-media' || $item_style == 'regular-slider-media' ) ) break;
								// Bring videos and strip them out of $content
								$iframes_return = quadro_print_iframes($content, '<li class="gallery-item">', '</li>');
								$content = $iframes_return['content'];
								$media_transient .= $iframes_return['media'];
								break;

						} // end switch operator

					} // end foreach
					
					$media_transient .= '</ul>';

					$media_transient .= '</div>'; // Closing .media-wrapper

					// Bring videos and strip them out of $content
					if ( $video_out == 'true' && ( $item_style == 'portf-layout2' || $item_style == 'portf-layout4' || $item_style == 'portf-layout6' ) ) {
						$iframes_return = quadro_print_iframes($content, '<div class="item-videos">', '</div>');
						$content = $iframes_return['content'];
						$media_transient .= $iframes_return['media'];
					}

				} // End if empty media or content

			} // Closing Style Conditional 
			else {
				if ( false === $content_transient || false === $media_transient ) {
					// Filter through the_content filter as it comes
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );
				}
			}
			?>

			<?php if ( false === $content_transient || false === $media_transient ) {
				// We save both here to make sure they both get stored on the same place.
				set_transient('qi_portf_item_content_' . get_the_ID(), $content, 750 * HOUR_IN_SECONDS );
				set_transient('qi_portf_item_media_' . get_the_ID(), $media_transient, 750 * HOUR_IN_SECONDS );
			} else {
				$content = $content_transient;
			} ?>

			<?php if ( $content !== '' ) { ?>
			<div class="item-content clear">

				<?php // Present Content Handler if Layout 6 Selected
				if ( $item_style == 'portf-layout6' ) echo '<span class="portf-content-handler"></span>'; ?>

				<?php quadro_get_portfolio_fields($item_id); ?>

				<div class="item-description">
					<?php echo apply_filters( 'qi_filter_portf_item_content', $content ); ?>
				</div>
			
			</div><!-- .item-content -->
			<?php } ?>


			<?php if ( $item_style != 'as-created' ) { // Opening Style Conditional ?>
			<div class="item-media">
				<?php echo apply_filters( 'qi_filter_portf_item_media', $media_transient ); ?>
			</div><!-- .item-media -->
			<?php } ?>
			
		</div><!-- .item-body -->

	</article><!-- #post-## -->
	<?php

	// Reset post data
	wp_reset_postdata();

}
endif; // if !function_exists
// Add this function to AJAX call too, in case its required.
add_action( 'wp_ajax_quadro_load_portf_item', 'quadro_single_portfolio_item' );
add_action( 'wp_ajax_nopriv_quadro_load_portf_item', 'quadro_single_portfolio_item' );


/**
 * Retrieve specific data fields from Portfolio Items
 */
if ( ! function_exists( 'quadro_get_portfolio_fields' ) ) :
function quadro_get_portfolio_fields($item_id) {

	global $quadro_options;
	
	// Get fields from Item
	$available_fields 	= get_post_meta( $item_id, 'quadro_portfolio_fields', true );
	$ext_link 			= esc_url( get_post_meta( $item_id, 'quadro_portfolio_link', true ) );
	$link_title 		= esc_attr( get_post_meta( $item_id, 'quadro_portfolio_link_title', true ) );
	$print_fields 		= '';

	// Loop through fields and build printable element
	if ( is_array($available_fields) && is_array($quadro_options['portfolio_fields']) && !empty($quadro_options['portfolio_fields']) ) {
		foreach ( $quadro_options['portfolio_fields'] as $field ) {
			// Skip early if value empty
			$this_slug = $field['slug'];
			if ( !isset($available_fields[$this_slug]['value']) || $available_fields[$this_slug]['value'] == '' ) continue;
			// Print it
			$print_fields .= '<p class="portfolio-field-' . $field['slug'] . '">';
			if ( isset($field['show']) && $field['show'] == true ) $print_fields .= '<span>' . esc_attr($field['title']) . '</span> ';
			$print_fields .= $available_fields[$this_slug]['value'];
			$print_fields .= '</p>';
		}
	}

	if ( $print_fields != '' || $ext_link != '' ) {
		echo '<div class="item-data">';
		echo apply_filters( 'qi_filter_portf_item_fields', $print_fields );
		if ( $ext_link != '' ) {
			echo '<a href="' . $ext_link . '" title="' . $link_title . '" class="item-ext-link">' . $link_title . '</a>';
		}
		echo '</div>';
	}

}
endif; // if !function_exists


/**
 * Delete Portfolio Items transients when publishing or updating quadro_portfolio posts.
 */
function quadro_delete_portf_transients() {

	global $post;

	// Make sure the post obj is present and complete. If not, return.
	if ( !is_object($post) || !isset($post->post_type) ) {
		return;
	}

	// Make sure post type is our portfolio item.
	if ( $post->post_type != 'quadro_portfolio') {
		return;
	}

	// And, delete its transients
	delete_transient( 'qi_portf_item_content_' . $post->ID );
	delete_transient( 'qi_portf_item_media_' . $post->ID );

}
add_action( 'save_post', 'quadro_delete_portf_transients' );
add_action( 'transition_post_status', 'quadro_delete_portf_transients' );


/*-----------------------------------------------------------------------------------*/
/*	Advertising Functions
/*-----------------------------------------------------------------------------------*/

// Output Ad Section (section corresponds to specific hook)
if ( ! function_exists( 'quadro_ad_output' ) ) :
function quadro_ad_output( $section ) {
	global $quadro_options; 

	// Return if set not to be shown
	if ( $quadro_options['ads_'.$section.'_show'] != 'show' )
		return false;

	// Do shortcode if there is one
	if ( $quadro_options['ads_'.$section.'_shortcode'] != '' ) {
		echo '<div class="qi-ad ad-' . $section . '">';
		echo do_shortcode( esc_textarea( $quadro_options['ads_'.$section.'_shortcode'] ) );
		echo '</div>';
	}
	elseif ( $quadro_options['ads_'.$section.'_upload'] != '' ) {
		echo '<div class="qi-ad ad-' . $section . '"><a href="' . esc_url( $quadro_options['ads_'.$section.'_url'] ) . '" 
			target="' . esc_attr( $quadro_options['ads_'.$section.'_target'] ) . '">
			<img src="' . esc_url( $quadro_options['ads_'.$section.'_upload'] ) . '"></a></div>';
	}
}
endif; // if !function_exists


// Output Header Ad Section (section corresponds to specific hook)
if ( ! function_exists( 'quadro_ad_output_header' ) ) :
function quadro_ad_output_header() {
	global $quadro_options; 

	// Return if set not to be shown
	if ( $quadro_options['ads_header_show'] != 'show' )
		return false;

	// Do shortcode if there is one
	if ( $quadro_options['ads_header_shortcode'] != '' ) {
		echo '<div class="qi-ad ad-header">';
		echo do_shortcode( esc_textarea( $quadro_options['ads_header_shortcode'] ) );
		echo '</div>';
	}
	elseif ( $quadro_options['ads_header_upload'] != '' ) {
		echo '<div class="qi-ad ad-header"><a href="' . esc_url( $quadro_options['ads_header_url'] ) . '" 
			target="' . esc_attr( $quadro_options['ads_header_target'] ) . '">
			<img src="' . esc_url( $quadro_options['ads_header_upload'] ) . '"></a></div>';
	}
}
endif; // if !function_exists


// Return Ad Section (section corresponds to specific hook)
if ( ! function_exists( 'quadro_ad_return' ) ) :
function quadro_ad_return( $section ) {
	global $quadro_options; 

	// Return if set not to be shown
	if ( $quadro_options['ads_'.$section.'_show'] != 'show' )
		return false;

	// Do shortcode if there is one
	if ( $quadro_options['ads_'.$section.'_shortcode'] != '' ) {
		$ad = '<div class="qi-ad ad-' . $section . '">';
		$ad .= do_shortcode( esc_textarea( $quadro_options['ads_'.$section.'_shortcode'] ) );
		$ad .= '</div>';
	}
	elseif ( $quadro_options['ads_'.$section.'_upload'] != '' ) {
		$ad = '<div class="qi-ad ad-' . $section . '"><a href="' . esc_url( $quadro_options['ads_'.$section.'_url'] ) . '" 
			target="' . esc_attr( $quadro_options['ads_'.$section.'_target'] ) . '">
			<img src="' . esc_url( $quadro_options['ads_'.$section.'_upload'] ) . '"></a></div>';
	}
	return $ad;
}
endif; // if !function_exists

// Add Pre Title Ad
add_action( 'qi_before_post_title', 'quadro_ad_output', 1, 1 );

// Add After Title Ad
add_action( 'qi_after_post_title', 'quadro_ad_output', 1, 1 );

// Add Pre Content Ad
add_action( 'qi_before_post', 'quadro_ad_output', 1, 1 );

// Add After Content Ad
add_action( 'qi_after_post', 'quadro_ad_output', 1, 1 );

// Add Inside Post Ad
function qi_inside_post_ad( $content ) {
	// We check "single" for single posts and "is_main_query"
	// to avoid this showing up in weird places via the_content filter
	global $post;
	if( is_single() && is_main_query() && $post->post_type === 'post' ) {
		global $quadro_options;
		$ad_content = '';
		$p_after = $quadro_options['ads_midcontent_paragraphs'];
		$content = explode( '</p>', $content );
		for ( $i = 0; $i < count($content); $i++ ) {
			if ( $i == $p_after ) {
				$ad_content .= quadro_ad_return( 'midcontent' );
			}
			$ad_content .= $content[$i] . '</p>';
		}
	}
	if ( !isset($ad_content) || $ad_content == '' ) $ad_content = $content;
	return $ad_content;
}

// Add filter for inside posts ad
if ( $quadro_options['ads_midcontent_show'] == 'show' ) {
	add_filter( 'the_content', 'qi_inside_post_ad' );
}


// Remove p tags from Portfolio items' images
function quadro_filter_ptags_on_portfimages($content) {
	global $post;
	if ( $post->post_type != 'quadro_portfolio') return $content;
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'quadro_filter_ptags_on_portfimages');


?>