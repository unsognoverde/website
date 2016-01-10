<?php
/**
 * Custom functions that act independently of the theme templates
 */


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function quadro_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'quadro_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 */
function quadro_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'quadro_body_classes' );


/**
 * Adds browser class to body
 */
// add_filter('body_class','quadro_browser_body_class');
// function quadro_browser_body_class($classes) {
// 	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

// 	if($is_lynx) $classes[] = 'lynx';
// 	elseif($is_gecko) $classes[] = 'gecko';
// 	// elseif($is_opera) $classes[] = 'opera';
// 	// elseif($is_NS4) $classes[] = 'ns4';
// 	elseif($is_safari) $classes[] = 'safari';
// 	elseif($is_chrome) $classes[] = 'chrome';
// 	elseif($is_IE) $classes[] = 'ie';
// 	else $classes[] = 'unknown';

// 	if($is_iphone) $classes[] = 'iphone';
// 	return $classes;
// }


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function quadro_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'quadro_enhanced_image_navigation', 10, 2 );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
if ( ! function_exists( 'quadro_wp_title' ) ) :
function quadro_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'quadro' ), max( $paged, $page ) );

	return $title;
}
endif; // if !function_exists
// We are commenting it out in favor of title-tag support.
// @todo: delete function
// add_filter( 'wp_title', 'quadro_wp_title', 10, 2 );


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 */
function quadro_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'quadro_setup_author' );


// Function to convert Hex colors to RGB
function quadro_toRGB($hex_value, $opacity){   

	if ( substr($hex_value, 0,1) == "#" ) {
		$hex_value = substr($hex_value,1);
	}

	$R_value = substr($hex_value,0,2);
	$G_value = substr($hex_value,2,2);
	$B_value = substr($hex_value,4,2);

	$R_value = hexdec($R_value);
	$G_value = hexdec($G_value);
	$B_value = hexdec($B_value);

	$RGB_value = 'rgba(' . $R_value . ', ' . $G_value . ', ' . $B_value . ', ' . $opacity . ')';
	
	return $RGB_value;

}


// Add selected posts to queries if selected
// (just for post types with that field in)
// Param: $mod_id and $field for selected posts
function quadro_add_selected_posts( $mod_id, $field_id, $args ) {

	// Get selected
	$picked_posts_list = esc_attr( get_post_meta( $mod_id, $field_id, true ) );

	if ( $picked_posts_list != '' ) {
		// Prepare the picked posts list to use in query
		$picked_posts = explode( ', ', $picked_posts_list );
		// Build query args extension
		$picked_args = array (
			'post__in' => $picked_posts,
			'orderby' => 'post__in'
		);
		// Add Posts Picker choices to query args
		$args = array_merge( $args, $picked_args );
		return $args;
	}

}


// Add selected formats to queries if selected
// (just for post types with that field in)
// Param: $mod_id and $field for selected posts
function quadro_add_selected_formats( $mod_id, $field_id, $args ) {

	// Get selected formats
	$sel_formats = esc_attr( get_post_meta( $mod_id, $field_id, true ) );
	
	if ( $sel_formats != '' ) {

		$sel_formats = explode( ', ', rtrim($sel_formats, ', ') );
		foreach ($sel_formats as $sel_format) { 
			// Build the array with selected formats
			$built_formats[] = 'post-format-' . $sel_format;
		}
		
		if ( in_array('standard', $sel_formats) ) {
			// We need to build this query by excluding any other post formats
			$query_formats = array( 'post-format-standard', 'post-format-aside', 'post-format-status', 'post-format-gallery', 'post-format-image', 'post-format-audio', 'post-format-video', 'post-format-quote', 'post-format-link' );
			$query_formats = array_diff( $query_formats, $built_formats );
			$operator = 'NOT IN';
		} else {
			// We need to build this query by calling specific formats (standard post format has no format)
			$query_formats = $built_formats;
			$operator = 'IN';
		}
		
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => $query_formats,
				'operator' => $operator,
			)
		);
		
		return $args;
	
	}

}


// Define allowed numbers for backround pattern images
function quadro_get_background_patterns(){

	global $patterns_qty;

	$patterns = array();
	$i = 1;

	while ( $i <= $patterns_qty ) {
		$patterns[] = $i;
		$i++;
	}

	return $patterns;

}


/**
 * Breadcrumbs function
 */
if ( ! function_exists( 'quadro_breadcrumbs' ) ) :
function quadro_breadcrumbs() {

	global $post, $quadro_options;

	// Return if homepage
	if ( is_front_page() ) return;
	// Return early if Breadcrumbs disabled in theme options
	if ( $quadro_options['breadcrumbs_show'] == 'hide' ) return;
	// Return early if Breadcrumbs disabled in page options
	if ( is_page() && get_post_meta( get_the_ID(), 'quadro_page_breadcrumbs', true ) == 'hide' ) return;

	if ( !is_front_page() ) {
		echo '<p class="page-breadcrumbs">';
		if ( $quadro_options['breadcrumbs_prefix'] != '' ) echo esc_attr( $quadro_options['breadcrumbs_prefix'] ) . ' ';
		echo '<a href="';
		echo esc_url(home_url('/'));
		echo '">';
		echo esc_html__('Home', 'quadro');
		echo "</a> &raquo; ";
	}

	if ( is_category() || is_single() ) {
		// Escape this for WooCommerce, complicated stuff
		if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) {
			// do nothing
		} else {
			$category = get_the_category();
			$ID = $category[0]->cat_ID;
			echo get_category_parents($ID, TRUE, ' &raquo; ', FALSE );
		}
	}

	if($post && $post->post_parent) {

		$trail = '';

		$parent_id = $post->post_parent;
 
		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a> &raquo; ';
			$parent_id = $page->post_parent;
		}
 
		$breadcrumbs = array_reverse($breadcrumbs);
		foreach($breadcrumbs as $crumb) $trail .= $crumb;
		echo $trail;

	}

	if( is_single() && !class_exists( 'Woocommerce' ) ) the_title();
	if( is_page() ) the_title();
	if( is_tag() ) echo "Tag: ".single_tag_title('',FALSE);
	if( is_404() ) echo esc_html__('Page not Found', 'quadro');
	if( is_search() ) echo "Search";
	if( is_year() ) echo get_the_time('Y');
	
	// Page titles for WooCommerce
	if( class_exists( 'Woocommerce' ) && is_woocommerce() && is_shop() ) echo get_the_title( get_option('woocommerce_shop_page_id') );
	if( class_exists( 'Woocommerce' ) && is_woocommerce() && is_single() ) {
		$shop_id = get_option('woocommerce_shop_page_id');
		echo '<a href="' . esc_url( get_permalink( $shop_id ) ) . '">' . get_the_title( $shop_id ) . '</a>';
		echo '</a> &raquo; ';
		the_title();
	}
	if( class_exists( 'Woocommerce' ) && is_woocommerce() && is_product_category() ) {
		$shop_id = get_option('woocommerce_shop_page_id');
		echo '<a href="' . esc_url( get_permalink( $shop_id ) ) . '">' . get_the_title( $shop_id ) . '</a>';
		echo '</a> &raquo; ';
		woocommerce_page_title();
	}

	echo "</p>";

}
endif; // if !function_exists


/**
 * Social Icons Function
 */
if ( ! function_exists( 'quadro_social_icons' ) ) :
function quadro_social_icons($area, $class, $style, $color) {

	// Retrieve Theme Options
	global $quadro_options;

	$icons_style = isset( $quadro_options[$style] ) ? esc_attr( $quadro_options[$style] ) : '';

	$profiles = array( 
		'dribbble' => 'Dribbble', 
		'facebook' => 'Facebook', 
		'flickr' => 'Flickr', 
		'github' => 'Github', 
		'google-plus' => 'Google+',
		'instagram' => 'Instagram', 
		'linkedin' => 'Linkedin', 
		'pinterest' => 'Pinterest', 
		'skype' => 'Skype', 
		'tumblr' => 'Tumblr', 
		'twitter' => 'Twitter', 
		'vimeo-square' => 'Vimeo', 
		'youtube' => 'Youtube', 
	);

	if ( $quadro_options[$area] == 'show' ) {

		echo '<ul class="social-area ' . $icons_style . ' ' . esc_attr($quadro_options[$color]) . '-color ' . $class . '">';

		foreach ( $profiles as $profile => $name ) {
			if ( $quadro_options[$profile . '_profile'] == '' ) continue;
			echo '<li><a href="' . esc_url( $quadro_options[$profile . '_profile'] ) . '" target="' . esc_attr( $quadro_options['social_target'] ) . '" title="' . $name . '"><i class="fa fa-' . $profile . '"></i></a></li>';
		}

		echo '</ul>';

	}

}
endif; // if !function_exists


/**
 * Function to map an array while applying a
 * specific function to it.
 * Source and interesting info:
 * http://stackoverflow.com/questions/4861053/php-sanitize-values-of-a-array
 */
function quadro_array_map_r( $func, $arr ) {
	// Return early if not an array
	if ( !is_array($arr) ) return;

	$newArr = array();

	foreach( $arr as $key => $value ) {
		$newArr[ $key ] = ( is_array( $value ) ? quadro_array_map_r( $func, $value ) : ( is_array($func) ? call_user_func_array($func, $value) : $func( $value ) ) );
	}

	return $newArr;
}


/**
 * Print Dynamic Widget Areas
 */
function quadro_widget_area( $display, $layout, $section_class, $area_class, $handler = true ){

	// Retrieve Theme Options
	global $quadro_options;

	if ( $quadro_options[$display] == 'show' ) { ?>

			<div class="<?php echo $section_class; ?> clear">

				<?php // Check if we are showing the widgetized header and add a wrapper
				if ( $display == 'widgetized_header_display' ) echo '<div class="widgetized-header clear">'; ?>

				<?php			
				// Retrieve Theme Options for Footer Layout
				if ( $quadro_options[$layout] == 'widg-layout1' ) { $i = 4; }
				else if ( $quadro_options[$layout] == 'widg-layout2' || $quadro_options[$layout] == 'widg-layout3' || $quadro_options[$layout] == 'widg-layout4' ) { $i = 3; }
				else if ( $quadro_options[$layout] == 'widg-layout5' ) { $i = 2; }
				else if ( $quadro_options[$layout] == 'widg-layout6' ) { $i = 1; }

				for ($j = 1; $j <= $i ; $j++) { ?>
					
					<div class="<?php echo esc_attr( $quadro_options[$layout] ); ?>">
					<?php dynamic_sidebar( $area_class . $j ); ?>
					</div>

				<?php } // end for ?>

				<?php // Check if we are showing the widgetized header
				if ( $display == 'widgetized_header_display' ) {
					echo '</div>';
					if ( $handler == true ) echo '<span id="header-handle" class="header-handler"></span>';
				} ?>
										
			</div> <!-- .widgetized-area -->
			
	<?php }

}


/**
 * Quadro Custom the_excerpt and changes the "more" tag
 */
if ( ! function_exists( 'quadro_excerpt' ) ) :
function quadro_excerpt( $excerpt = '', $excerpt_length = 20, $readmore = '', $tags = '' ) {

	global $post;
	
	// Filter through the_content filter
	$excerpt = apply_filters( 'the_content', $excerpt );
	$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );

	// Filter the content looking for iframes and remove them
	preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $excerpt, $matches);
	$excerpt = $matches ? str_replace( $matches[0], '', $excerpt ) : $excerpt;
	
	$string_check = explode( ' ', $excerpt );
	
	if ( count($string_check, COUNT_RECURSIVE) > $excerpt_length ) {
		
		$quadro_excerpt_words = explode( ' ', $excerpt, $excerpt_length + 1 );
		array_pop( $quadro_excerpt_words );
		$excerpt_text = implode( ' ', $quadro_excerpt_words );
		$temp_content = strip_tags( $excerpt_text, $tags );
		$short_content = preg_replace( '`\[[^\]]*\]`', '', $temp_content );
		if ( $readmore != '' ) { 
			$short_content .= ' ... ' . '<a href="' . esc_url( get_permalink($post->ID) ) . '" class="readmore-link">' . $readmore . '</a>';
		} else { 
			$short_content .= ' ... ';
		}
		echo $short_content;
	
	} else {
	
		echo $excerpt;
		if ( $readmore != '' ) { 
			echo '<a href="' . esc_url( get_permalink($post->ID) ) . '" class="readmore-link">' . $readmore . '</a>';
		}
	
	}
	
}
endif; // if !function_exists


/**
 * Quadro Custom Login Logo
 */
function quadro_custom_login_logo() {
	// Retrieve Theme Options
	global $quadro_options;

	if ( isset($quadro_options['custom_login_img']) && $quadro_options['custom_login_img'] != '' ) {
		echo '<style type="text/css">';
		echo '.login h1 a { width: auto; background-size: auto 100%; }';
		echo 'h1 a { background-image:url(\'' . esc_url( $quadro_options['custom_login_img'] ) . '\') !important; }';
		// ...and for retina:
		echo '@media (-webkit-min-device-pixel-ratio: 2), ';
		echo '(min-resolution: 192dpi) { ';
		echo 'h1 a { background-image:url(\'' . esc_url( $quadro_options['custom_login_img_retina'] ) . '\') !important; }';
		echo ' }';
		echo '</style>';
	}
}
add_action('login_head', 'quadro_custom_login_logo');


/**
 * Get color brightness, for use in color settings.
 * Returns brightness value from 0 to 255.
 * Credits: http://www.webmasterworld.com/forum88/9769.htm
 */
function quadro_get_brightness($hex) {
	// Strip off any leading #
	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}


/**
 * Deletes first gallery shortcode and returns content
 * From: http://stackoverflow.com/questions/17224100/wordpress-remove-shortcode-and-save-for-use-elsewhere
 */
function quadro_strip_shortcode_gallery( $content ) {
	// $content = do_shortcode( $content );
	preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
	if ( ! empty( $matches ) ) {
		foreach ( $matches as $shortcode ) {
			if ( 'gallery' === $shortcode[2] ) {
				$pos = strpos( $content, $shortcode[0] );
				if ($pos !== false)
					return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
			}
		}
	}
	return $content;
}


/**
 * Function to get content between two strings. Used to retrieve galleries IDs from shortcodes.
 */
function quadro_get_string_between($string, $start, $end) {
	$ini = strpos($string,$start);
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}


/**
 * Function to retrieve galleries from gallery type custom fields
 */
function quadro_maybe_print_gallery_field( $field, $id, $size = 'full', $class = 'gallery-field' ) {
	
	// Return early if no field given
	if ( !isset($field) ) return false;

	// Retrieve custom field
	$gallery = esc_attr( get_post_meta( $id, $field, true ) );

	// Return if nothing in field
	if ( $gallery == '' ) return false;

	preg_match_all( '!\d+!', $gallery, $pic_ids );

	echo '<div class="' . $class . '"><ul class="slides">';
	foreach( $pic_ids[0] as $pic_id ) {
		echo '<li>';
		echo wp_get_attachment_image( $pic_id, $size );
		echo '</li>';
	}
	echo '</ul></div>';

}


/**
 * Function to retrieve galleries from gallery type custom fields
 */
function quadro_maybe_print_gallery_field_as_bg( $field, $id, $size = 'full', $class = 'gallery-field' ) {
	
	// Return early if no field given
	if ( !isset($field) ) return false;

	// Retrieve custom field
	$gallery = esc_attr( get_post_meta( $id, $field, true ) );

	// Return if nothing in field
	if ( $gallery == '' ) return false;

	preg_match_all( '!\d+!', $gallery, $pic_ids );

	echo '<div class="' . $class . '"><ul class="slides">';
	foreach( $pic_ids[0] as $pic_id ) {
		$image = wp_get_attachment_image_src( $pic_id, $size );
		echo '<li style="background-image: url(\'' . $image[0] . '\');"></li>';
	}
	echo '</ul></div>';

}


/**
 * Store any iframe for later use and process $content to strip them out of it
 */
function quadro_print_iframes($content, $before, $after) {

	if ( preg_match_all( '#<iframe[^>]+>.*?</iframe>#is', $content, $videos ) ) {

		$media = '';

		foreach ($videos[0] as $video) {
			$media .= $before . $video . $after;
			// Remove video from $content
			$content = str_replace($video,'', $content);
		}

		return array('content' => $content, 'media' => $media);

	} else {

		// We have to return the $content anyway so it don't stay empty
		return array('content' => $content, 'media' => '');
	
	}

}


/**
 * Store any wanted media for later use and process $content to strip them out of it
 * Argument $types receives an array of wanted media types: 'audio', 'video', 'object', 'embed', or 'iframe'.
 * Function based on get_media_embedded_in_content() from media.php (in Core @since 3.6.0).
 */
function quadro_print_media($content, $types = null, $amount = 999, $before, $after) {

	$allowed_media_types = array( 'audio', 'video', 'object', 'embed', 'iframe' );
	$media = '';
	$i = 0;

	if ( ! empty( $types ) ) {
		if ( ! is_array( $types ) )
			$types = array( $types );
		$allowed_media_types = array_intersect( $allowed_media_types, $types );
	}

	// Filter through the_content filter
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	foreach ( $allowed_media_types as $tag ) {
		if ( preg_match_all( '#' . get_tag_regex( $tag ) . '#', $content, $elements ) ) {
			foreach ($elements[0] as $element) {
				$media .= $before . $element . $after;
				// Remove element from $content
				$content = str_replace($element,'', $content);
				// Exit this if we reached the requested amount.
				$i++;
				if ( $amount == $i ) break 2;
			}
		}
	}

	// Return the results, content and requested media apart
	return array('content' => $content, 'media' => $media);

}


/**
 * Retrieve a video screenshot from Vimeo or Youtube, from Content passed
 */
function quadro_video_screenshot($content, $permalink, $title) {

	// Bring URLs from content
	$urls = quadro_getUrls($content);

	// Filter URLs searching for Vimeo or YouTube videos
	foreach ($urls as $url) {
		
		if ( strpos( $url, 'vimeo' ) !== false ) {
			// For Vimeo
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			$hash = unserialize( wp_remote_fopen('http://vimeo.com/api/v2/video/' . $video_id . '.php') );
			echo '<a href="' . $permalink . '" class="auto-screenshot-link"><img src="' . $hash[0]['thumbnail_large'] . '" title="' . $title . '" alt="' . $title . '"></a>';
			// Skip all other URLs
			break;
		} elseif ( strpos ( $url, 'youtube' ) !== false ) {
			// For YouTube
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $video_ids);
			echo '<a href="' . $permalink . '" class="auto-screenshot-link"><img src="http://img.youtube.com/vi/' . $video_ids[0] . '/hqdefault.jpg" title="' . $title . '" alt="' . $title . '"></a>';
			// Skip all other URLs
			break;
		}

	}

}


/**
 * Retrieve a video screenshot URL from Vimeo or Youtube, from Content passed
 */
function quadro_video_screenshot_url($content) {

	// Bring URLs from content
	$urls = quadro_getUrls($content);

	// Filter URLs searching for Vimeo or YouTube videos
	foreach ($urls as $url) {
		
		if ( strpos( $url, 'vimeo' ) !== false ) {
			// For Vimeo
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			$hash = unserialize( wp_remote_fopen('http://vimeo.com/api/v2/video/' . $video_id . '.php') );
			return esc_url( $hash[0]['thumbnail_large'] );
			// Skip all other URLs
			break;
		} elseif ( strpos ( $url, 'youtube' ) !== false ) {
			// For YouTube
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $video_ids);
			$video_ids[0] = trim($video_ids[0]);
			return 'http://img.youtube.com/vi/' . $video_ids[0] . '/hqdefault.jpg';
			// Skip all other URLs
			break;
		}

	}

}


/**
 * @get URLs from string (string may be a url)
 * Credit: http://stackoverflow.com/questions/11588542/get-all-urls-in-a-string-with-php
 */
function quadro_getUrls($string) {
	$regex = '/https?\:\/\/[^\" ]+/i';
	preg_match_all($regex, $string, $matches);
	//return (array_reverse($matches[0]));
	return ($matches[0]);
}


/**
 * Retrieve & print quote from content
 */
function quadro_print_quote($content, $before, $after) {

	// Filter through the_content filter
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	/* Match any <blockquote> elements. */
	preg_match( '/<blockquote>(.)*<\/blockquote>/msi', $content, $matches );
	if ( !empty( $matches ) ) {
		$request = $before . $matches[0] . $after;
		// Remove element from $content
		$content = str_replace($matches[0],'', $content);
	} else {
		// Wrap content in blockquote
		$request = '<blockquote>' . $content . '</blockquote>';
		// And empty content
		$content = '';
	}
	return array('content' => $content, 'request' => $request);

}


/**
 * Retrieve & print quote from content
 */
function quadro_just_quote($content, $before, $after) {

	// Filter through the_content filter
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	/* Match any <blockquote> elements. */
	preg_match( '/<blockquote>(.)*?<\/blockquote>/msi', $content, $matches );
	// preg_match( '/<cite>(.)*<\/cite>/msi', $content, $authors );
	// This line is working better than the previous one for multiple quotes' authors in one post
	preg_match( '#<cite>(.+)</cite>#siU', $content, $authors );
	if ( !empty( $matches ) && !empty( $authors ) ) {
		// remove any cites from quote for cases where the cite is inside the blockquote
		$quote = str_replace($authors[0], '', $matches[0]);
		$request = $before . $quote . $authors[0] . $after;
	} elseif ( !empty( $matches ) ) {
		// No authors, so, just print the first quote
		$request = $before . $matches[0] . $after;
	} else {
		// Wrap content in blockquote if no other quote (don't serve empty content)
		$request = '<blockquote>' . $content . '</blockquote>';
	}
	return $request;

}


/**
 * Include API's for Vimeo and YouTube when embedding (specially for sliders)
 */
function quadro_modify_embed_output($html, $url, $attr) {

	if ( strpos( $html, 'vimeo' ) !== false )
		{ return str_replace('" width="', '?api=1" width="', $html); }
	elseif ( strpos ( $html, 'youtube' ) !== false )
		{ return str_replace( '" frameborder="', '&enablejsapi=1&playerapiid=ytplayer" frameborder="', $html ); }
	else
		{ return $html; }
		
}
add_filter( 'embed_oembed_html', 'quadro_modify_embed_output', 10, 3);


// Fixes oEmbed Vimeo problem regarding HTTPS vs HTTP
function quadro_oembed_providers_fix( $providers ) {
	unset($providers['#http://(www\.)?vimeo\.com/.*#i']);
	$providers['#https?://(www\.)?vimeo\.com/.*#i'] = array( 'http://vimeo.com/api/oembed.{format}', true  );
	return $providers;
}
add_filter('oembed_providers', 'quadro_oembed_providers_fix');


/**
 * Add string to filename for retina purposes
 */
function quadro_retina_filename( $filename ) {
	return substr_replace( $filename, '@2x', -4, 0 );
}


/**
 * Enabling Font uploads in Media Uploader
 */
function quadro_mime_types($mime_types){
	$mime_types['eot'] = 'application/font-eot'; // Adding woff extension
	$mime_types['woff'] = 'application/font-woff'; // Adding woff extension
	$mime_types['ttf'] = 'application/font-ttf'; // Adding ttf extension
	$mime_types['otf'] = 'application/font-otf'; // Adding otf extension
	$mime_types['svg'] = 'application/font-svg'; // Adding svg extension
	return $mime_types;
}
add_filter('upload_mimes', 'quadro_mime_types', 1, 1);


// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');


// Solving Youtube iFrame overlapping issue for IE versions
function qi_add_video_wmode_transparent($html, $url, $attr) {

	if ( strpos( $html, "<embed src=" ) !== false )
		return str_replace( '<embed', '<embed wmode="transparent" ', $html );
	elseif ( strpos ( $html, 'feature=oembed' ) !== false )
		return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html );
	else
		return $html;

}
add_filter( 'embed_oembed_html', 'qi_add_video_wmode_transparent', 10, 3);


// Retrieves the a WordPress cropped image from the file URL
// https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
function qi_image_by_url( $image_url, $size ) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
   	// check if we have an actual ID for this image
   	if ( isset($attachment[0]) ) {
   		$image_thumb = wp_get_attachment_image_src( $attachment[0], $size );
		return $image_thumb[0];
   	// if we don't, return the original URL
   	} else {
   		return $image_url;
   	}
}