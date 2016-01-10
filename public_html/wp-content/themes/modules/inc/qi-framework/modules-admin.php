<?php
/**
 * This file adds admin functionality and helpers to Modules management
 */


/**
 * Checks for modular template and hides editor on loading
 * to avoid display of unstyled content (until jQuery scripts load)
 */
function qi_modular_hide_editor(){
	
	$post_id = get_the_id();

	// Return early if nof editing a page
	if ( get_post_type( $post_id ) !== 'page' )
		return false;

	// Return early if not a modular one
	if ( get_page_template_slug( $post_id ) !== 'template-modular.php' )
		return false;

	// Hide editor early
	echo '<style>#postdivrich { display: none; } #modular-qi-template-metabox { display: block; }</style>';

}
add_action( 'edit_page_form', 'qi_modular_hide_editor' );


/*
 * Creates post duplicate as a draft and redirects then to the edit post screen
 * http://rudrastyh.com/wordpress/duplicate-post.html
 */
function qi_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title . ' (duplicate)',
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_qi_duplicate_post_as_draft', 'qi_duplicate_post_as_draft' );
 

/*
 * Add the duplicate link to action list for post_row_actions
 */
function qi_duplicate_post_link( $actions, $post ) {
	if ( get_post_type() === 'quadro_mods' && current_user_can('edit_posts') ) {
		$actions['duplicate'] = '<a href="admin.php?action=qi_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="' . esc_html__('Duplicate this item', 'quadro') . '" rel="permalink">' . esc_html__('Duplicate', 'quadro') . '</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'qi_duplicate_post_link', 10, 2 );


/**
 * Modules Reorder Function enqueuing
 */
function qi_modules_ui_setup( $hook ) {
	if ( get_post_type() == 'quadro_mods' && ($hook == 'post.php' || $hook == 'post-new.php') ) {
		// wp_enqueue_script( 'jquery' );
		add_action('admin_print_footer_scripts', 'qi_modules_ui_setup_scripts');
	}
}
add_action( 'admin_enqueue_scripts', 'qi_modules_ui_setup', 10, 1 );


/**
 * Modules Reorder and Tabs functionality
 */
function qi_modules_ui_setup_scripts() {
	js_wp_editor();

	?>
	<script type="text/javascript">

		// Add & build tabs menu
		jQuery('#mod-type-metabox').after('<ul class="qi-tabs-menu clear"><li class="module-style-link"><a href="#mod-metabox">Module Style</a></li></ul>');
		
		var moduleSelector = jQuery('#quadro_mod_type'),
			selType = moduleSelector.val();

		if ( selType != 'canvas' ) {
			
			var data = {
				action: 'quadro_ajax_mod_metabox',
				post_id: jQuery('#post_ID').val(),
				type: selType,
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				if ( response != -1 ) {
					// Bring fields
					jQuery('#mod-container-metabox .inside').html(response);
			        // Call Scripts of Fields Function
					jQuery(this).callFieldsScripts();
				}
			});

			jQuery('.qi-tabs-menu').prepend('<li class="current module-options-link"><a href="#mod-container-metabox">Module Options</a></li>');
		
		}
		
		// Move WP editor after Module Type select
		jQuery('#mod-type-metabox').after( jQuery('#postdiv, #postdivrich') );
		
		// Create Tabs Container
		jQuery('.qi-tabs-menu').after('<div class="qi-tabs-container"></div>');
		
		// Add all relevant modules inside tabs container
		jQuery('.qi-tabs-container').append( jQuery('#mod-metabox') );
		// jQuery('.qi-tabs-container').append( jQuery('.postbox[id*=qi-type-metabox]') );
		jQuery('.qi-tabs-container').append( jQuery('#mod-container-metabox') );
		
		// Enable Tabs Functionality
		jQuery('.qi-tabs-menu').on( 'click', 'a', function(event) {
			event.preventDefault();
			jQuery(this).parent().addClass("current");
			jQuery(this).parent().siblings().removeClass("current");
			var tab = jQuery(this).attr("href");
			jQuery('.qi-tabs-container .postbox').not(tab).hide().addClass('tab-hidden');
			jQuery(tab).fadeIn().removeClass('tab-hidden');
		});

		moduleSelector.change(function(){
			var selType = moduleSelector.val();

			if ( selType != 'canvas' ) {
				
				var data = {
					action: 'quadro_ajax_mod_metabox',
					post_id: jQuery('#post_ID').val(),
					type: selType,
				};
				
				jQuery.post(ajaxurl, data, function(response) {
					if ( response != -1 ) {
						jQuery('#mod-container-metabox .inside').html(response);
						// Add link to tabs menu
						if ( !jQuery('.qi-tabs-menu li.module-options-link').length ) {
							jQuery('.qi-tabs-menu').prepend('<li class="module-options-link"><a href="#mod-container-metabox">Module Options</a></li>');
							// Keep Module Style as current if previously selected
							if ( !jQuery('.qi-tabs-menu li.module-style-link').hasClass('current') ) {
								jQuery('.qi-tabs-menu li.module-options-link').addClass('current');
							}			
						} 
						// Call Scripts of Fields Function
						jQuery(this).callFieldsScripts();
					}
				});
			
			} else {
				jQuery('#mod-container-metabox .inside').html('');
				jQuery('.qi-tabs-menu li.module-options-link').remove();
				jQuery('.qi-tabs-menu li.module-style-link').addClass('current');
			}
			
		});

		// Function to call scripts on newly loaded fields
		jQuery.fn.callFieldsScripts = function() {
			// Handles selection boxes appearing when chosing selection methods
			// First, hide the selectors by default and show already chosen selector
			var allSelectors = jQuery('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr');
			jQuery('select[id*=_method]').each(function(){
				jQuery(this).parents('tr').siblings('tr').find('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr').hide();
				jQuery(this).parents('tr').siblings('tr').find('.q' + jQuery(this).val() + '-selector').parents('tr').fadeIn();
			})

			// Enable Editor custom field
			// if ( jQuery('textarea.qi-editor').length ) jQuery('textarea.qi-editor').wp_editor();
			if ( jQuery('textarea.qi-editor').length ) {
				tinyMCE.init({
					selector: 'textarea.qi-editor',
					mode: 'specific_textareas',
					content_css: '<?php echo includes_url(); ?>' + 'js/tinymce/skins/wordpress/wp-content.css',
					menubar : false,
					plugins: "textcolor",
					toolbar1: "styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent | undo redo",
				});
			}
			
			// Enable Repeatable Editors
			tinyMCE.init({
				selector: 'textarea.repeatable-editor',
				mode: 'specific_textareas',
				content_css: '<?php echo includes_url(); ?>' + 'js/tinymce/skins/wordpress/wp-content.css',
				menubar : false,
				plugins: "textcolor",
				toolbar1: "styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | undo redo",
			});


			jQuery('.custom_repeatable').sortable({
				opacity: 0.6,
				revert: true,
				cursor: 'move',
				handle: '.sort',
				start: function(event, ui) {
					sortablePrevChecked = ui.item.find('input:checked').val();
					// Disarm editors in this field before sorting
					if ( ui.item.find('.wp-editor-area').length ) tinyMCE.execCommand( 'mceRemoveEditor', false, ui.item.find('.wp-editor-area').attr('id') );
				},
				update: function(event, ui) {
					// Renumber Array indexes when re ordered
					jQuery(this).data().uiSortable.currentItem.parent().find('.fields-set').each(function(rowIndex){
						jQuery(this).find('input[name], textarea[name], select[name]').each(function(){
							var selectName;
							selectName = jQuery(this).attr('name');
							selectName = selectName.replace(/\[[0-9]+\]/g, '['+rowIndex+']');
							// Modify Names
							jQuery(this).attr('name',selectName);
							// Modify Editors' IDs too
							if ( jQuery(this).hasClass('wp-editor-area') ) jQuery(this).attr('id',selectName);
						});
					});
					ui.item.find(':radio[value='+sortablePrevChecked+']').prop("checked", true);
				},
				stop: function(e,ui) {},
			});

			// Enables Posts Sorting in Posts Select fields
			jQuery('.sel-posts-container').sortable({
				opacity: 0.6,
				revert: true,
				cursor: 'move',
				handle: '.li-mover',
				update: function (e, ui) {
					// Grabs current li's data IDs and puts them into the hidden field
					var $postsIds = '';
					jQuery(this).find('li').each(function(){
						$postsIds += jQuery(this).data('id') + ', ';
					});
					jQuery(this).next().val($postsIds);
				}
			});
			
		}
		
		/*
		 *	JavaScript Wordpress Editor
		 *	Author: 		Ante Primorac
		 *	Author URI: 	http://anteprimorac.from.hr
		 *	Version: 		1.1
		 *	License: (on PHP version of file)
		 */
		;(function(a,r){a.fn.wp_editor=function(c){a(this).is("textarea")||console.warn("Element must be a textarea");"undefined"!=typeof tinyMCEPreInit&&"undefined"!=typeof QTags&&"undefined"!=typeof adminscripts_localized||console.warn("js_wp_editor( $settings ); must be loaded");if(!a(this).is("textarea")||"undefined"==typeof tinyMCEPreInit||"undefined"==typeof QTags||"undefined"==typeof adminscripts_localized)return this;var e={mode:"html",mceInit:{theme:"modern",skin:"lightgray",language:"en",formats:{alignleft:[{selector:"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",styles:{textAlign:"left"},deep:!1,remove:"none"},{selector:"img,table,dl.wp-caption",classes:["alignleft"],deep:!1,remove:"none"}],aligncenter:[{selector:"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",styles:{textAlign:"center"},deep:!1,remove:"none"},{selector:"img,table,dl.wp-caption",classes:["aligncenter"],deep:!1,remove:"none"}],alignright:[{selector:"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",styles:{textAlign:"right"},deep:!1,remove:"none"},{selector:"img,table,dl.wp-caption",classes:["alignright"],deep:!1,remove:"none"}],strikethrough:{inline:"del",deep:!0,split:!0}},relative_urls:!1,remove_script_host:!1,convert_urls:!1,browser_spellcheck:!0,fix_list_elements:!0,entities:"38,amp,60,lt,62,gt",entity_encoding:"raw",keep_styles:!1,paste_webkit_styles:"font-weight font-style color",preview_styles:"font-family font-size font-weight font-style text-decoration text-transform",wpeditimage_disable_captions:!1,wpeditimage_html5_captions:!1,plugins:"charmap,hr,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview,image",content_css:"<?php echo includes_url(); ?>css/dashicons.css?ver=3.9,<?php echo includes_url(); ?>js/mediaelement/mediaelementplayer.min.css?ver=3.9,<?php echo includes_url(); ?>js/mediaelement/wp-mediaelement.css?ver=3.9,<?php echo includes_url(); ?>js/tinymce/skins/wordpress/wp-content.css?ver=3.9",selector:"#apid",resize:"vertical",menubar:!1,wpautop:!0,indent:!1,toolbar1:"bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv",toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",toolbar3:"",toolbar4:"",tabfocus_elements:":prev,:next",body_class:"apid"}},n=RegExp("apid","g");tinyMCEPreInit.mceInit.apid&&(e.mceInit=tinyMCEPreInit.mceInit.apid);c=a.extend(!0,e,c);return this.each(function(){if(a(this).is("textarea")){var b=a(this).attr("id");a.each(c.mceInit,function(d,k){"string"==a.type(k)&&(c.mceInit[d]=k.replace(n,b))});c.mode="tmce"==c.mode?"tmce":"html";tinyMCEPreInit.mceInit[b]=c.mceInit;a(this).addClass("wp-editor-area").show();var d=this;a(this).closest(".wp-editor-wrap").length&&(d=a(this).closest(".wp-editor-wrap").parent(),a(this).closest(".wp-editor-wrap").before(a(this).clone()),a(this).closest(".wp-editor-wrap").remove(),d=d.find('textarea[id="'+b+'"]'));var f=a('<div id="wp-'+b+'-wrap" class="wp-core-ui wp-editor-wrap '+c.mode+'-active" />'),g=a('<div id="wp-'+b+'-editor-tools" class="wp-editor-tools hide-if-no-js" />'),h=a('<div class="wp-editor-tabs" />'),e=a('<a id="'+b+'-html" class="wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">Text</a>'),p=a('<a id="'+b+'-tmce" class="wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">Visual</a>'),l=a('<div id="wp-'+b+'-media-buttons" class="wp-media-buttons" />'),q=a('<a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="'+b+'" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a>'),m=a('<div id="wp-'+b+'-editor-container" class="wp-editor-container" />');q.appendTo(l);l.appendTo(g);e.appendTo(h);p.appendTo(h);h.appendTo(g);g.appendTo(f);m.appendTo(f);m.append(a(d).clone().addClass("wp-editor-area"));a(d).before('<link rel="stylesheet" id="editor-buttons-css" href="'+adminscripts_localized.includes_url+'css/editor.css" type="text/css" media="all">');a(d).before(f);a(d).remove();new QTags(b);QTags._buttonsInit();switchEditors.go(b,c.mode);a(f).on("click",".insert-media",function(b){var c=a(b.currentTarget),d=c.data("editor"),e={frame:"post",state:"insert",title:wp.media.view.l10n.addMedia,multiple:!0};b.preventDefault();c.blur();c.hasClass("gallery")&&(e.state="gallery",e.title=wp.media.view.l10n.createGalleryTitle);wp.media.editor.open(d,e)})}else console.warn("Element must be a textarea")})}})(jQuery,window);
	
	</script>
<?php }


/**
 * Builds a Modular Pages Dropdown for a page to be selected
 * when adding a module to a page from the add/edit module screen
 */
function qi_module_adder() {

	// Present pages dropdown and offer to select a page
	echo '<h2>' . esc_html__('Add this module to a page', 'quadro') . '</h2>';
	$args = array(
		'name' => 'qi_modular_pages',
		'id' => 'qi-modular-pages',
		'show_option_none' => esc_html__('Select a page', 'quadro'),
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-modular.php'
	);
	wp_dropdown_pages($args);
	
	// Receiver for next ajax action
	echo '<div class="qi-page-modules"></div>';
	
	// Receiver for "already loaded ajax content" response
	echo '<input type="hidden" id="already-loaded"/>';
	
	die(1);
}
add_action('wp_ajax_qi_ajax_module_adder', 'qi_module_adder');


/**
 * Shows a sortable list of modules currently in use in page
 * and adds current module to that list
 */
function qi_module_fields() {
	
	// Get current modules in page
	$meta = esc_attr( get_post_meta( $_POST['page_id'], 'quadro_mod_temp_modules', true ) );
	
	echo '<p>' . esc_html__('You can re-order and edit this page\'s modules list from here too. Don\'t forget to click "Save page" before closing this box.', 'quadro') . '</p>';
	
	// Build sortable list
	echo '<ul class="sel-posts-container">';
	$sel_posts = explode( ', ', rtrim($meta, ', ') );
	if( $meta != '' ) :
		foreach ( $sel_posts as $sel_post ) :
			if ( $sel_post == '' || $sel_post == ' ' ) continue;
			echo '<li data-id="' . $sel_post . '">
				<label class="li-mover">
					<i class="remove-post fa fa-times"></i> ' . get_the_title( $sel_post ) . '
				</label>
			</li>';
    	endforeach;
	endif;
	
	// Add this module to list
	echo '<li data-id="' . $_POST['mod_id'] . '" class="added-module" style="display: none;">
		<label class="li-mover">
			<i class="remove-post fa fa-times"></i> ' . get_the_title($_POST['mod_id']) . '
		</label>
	</li>';
	
	echo '</ul>';
	
	// We don't want to add $meta if empty, to prevent page-module bug on page
	$list = $meta != '' ? $meta . ', ' . $_POST['mod_id'] : $_POST['mod_id'];
	// Little home for the list to be saved in
    echo '<input type="hidden" id="modules-to-save" value="' . $list . '" />';
    echo '<a id="page-mods-save" href="#" class="button button-primary button-large">' . esc_html__('Save page', 'quadro') . '</a>';
    
    // Receiver for next ajax action
    echo '<div class="saved-mods-receiver" style="display: none;"></div>';

	die(1);
}
add_action('wp_ajax_qi_ajax_module_fields', 'qi_module_fields');


/**
 * Saves current modules list on selected page and
 * cleans transients for that page when saving
 */
function qi_module_save() {
	
	// Save selected modules in page
	update_post_meta( esc_attr($_POST['page_id']), 'quadro_mod_temp_modules', esc_attr($_POST['mods_list']) );
	
	// Refresh related transients if enabled
	global $wpdb, $quadro_options;
	if ( $quadro_options['transients_enable'] == 'enabled' ) {
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_qi_fragm_modpage".esc_attr($_POST['page_id'])."%'" );
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_timeout_qi_fragm_modpage".esc_attr($_POST['page_id'])."%'" );
	}

	// Notice for Page Saved
	echo '<p class="qi-page-updated">' . esc_html__('Page updated.', 'quadro') . '</p>';

	// Offer to preview the page
	echo '<p><a href="' . esc_url( get_permalink( esc_attr($_POST['page_id']) ) ) . '" target="_blank">' . esc_html__('Preview this page', 'quadro') . '</a></p>';

	// Offer to edit the page
	echo '<p><a href="' . get_edit_post_link( esc_attr($_POST['page_id']) ) . '" target="_blank">' . esc_html__('Edit this page separatedly', 'quadro') . '</a></p>';

	die(1);
}
add_action('wp_ajax_qi_ajax_module_save', 'qi_module_save');


/**
 * Ajax Metabox Creator for Modules
 */
function quadro_ajax_mod_metabox() {

	global $quadro_cfields_mods_def;

	// Call metabox printing function
	quadro_print_boxes( $quadro_cfields_mods_def['mod_' . esc_attr( $_POST['type'] ) . '_type_metabox'], esc_attr( $_POST['post_id'] ) );

	die();

}
add_action('wp_ajax_quadro_ajax_mod_metabox', 'quadro_ajax_mod_metabox');


/*
 *	JavaScript Wordpress editor
 *	Author: 		Ante Primorac
 *	Author URI: 	http://anteprimorac.from.hr
 *	Version: 		1.1
 *	License:
 *		Copyright (c) 2013 Ante Primorac
 *		Permission is hereby granted, free of charge, to any person obtaining a copy
 *		of this software and associated documentation files (the "Software"), to deal
 *		in the Software without restriction, including without limitation the rights
 *		to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *		copies of the Software, and to permit persons to whom the Software is
 *		furnished to do so, subject to the following conditions:
 *
 *		The above copyright notice and this permission notice shall be included in
 *		all copies or substantial portions of the Software.
 *
 *		THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *		IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *		FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *		AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *		LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *		OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *		THE SOFTWARE.
 *	Usage:
 *		server side(WP):
 *			js_wp_editor( $settings );
 *		client side(jQuery):
 *			$('textarea').wp_editor( options );
 */
function js_wp_editor( $settings = array() ) {
	if ( ! class_exists( '_WP_Editors' ) )
		require( ABSPATH . WPINC . '/class-wp-editor.php' );
	$set = _WP_Editors::parse_settings( 'apid', $settings );
	_WP_Editors::editor_settings( 'apid', $set );
}
// Call the function to make sure it's runing
// js_wp_editor();


?>