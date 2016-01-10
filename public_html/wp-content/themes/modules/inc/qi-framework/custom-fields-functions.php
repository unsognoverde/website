<?php

/*-----------------------------------------------------------------------------------*/
/*	Print fields and metaboxes in screen (function definitions)
/*-----------------------------------------------------------------------------------*/

function quadro_print_boxes( $quadro_current_fields, $post_id = '' ) {

	global $quadro_cfields_def, $quadro_cfields_mods_def, $post;
	// Retrieve Theme Options
	global $quadro_options;
	// $quadro_options = quadro_get_options();
	$post_id = !empty($post) ? $post->ID : $post_id;

	// Use nonce for verification
	echo '<input type="hidden" name="quadro_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<table>';

		foreach ( $quadro_current_fields['fields'] as $field ) {

		// get current post meta data
		if ( $field['type'] != 'editor' && $field['type'] != 'prev-editor' && $field['type'] != 'repeatable' && $field['type'] != 'xrepeatable' && $field['type'] != 'radio' && $field['type'] != 'portfolio-fields-input' ) {			$meta = esc_attr( get_post_meta( $post_id, $field['id'], true ) );
		} else {
			$meta = get_post_meta( $post_id, $field['id'], true );
		}
		echo '<tr class="tr-' . $field['type'] . '">';

		echo '<th class="option-label th-' . $field['type'] . '" style="padding-right: 20px;">';
		if ( $field['type'] != 'subtitle' ) {
			echo '<label for="', $field['id'], '">', $field['name'], '</label>';
		} else {
			echo '<h3 class="field-subtitle">' . $field['name'] . '</h3>';
		}
		echo '</th>';
		echo '<td class="option-choice td-' . $field['type'] . '">';

		switch ( $field['type'] ) {

			case 'subtitle':
				if ( isset($field['desc']) && $field['desc'] != '' ) echo '<span class="field-description">' . $field['desc'] . '</span>';
				echo '<br />';
				break;

			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : '', '" size="30" style="width: 97%" />';
				if ( isset($field['desc']) && $field['desc'] != '' ) echo '<br /><em class="field-description">' . $field['desc'] . '</em>';
				break;

			case 'number':
				echo '<input type="number" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : '', '" size="30" style="width: 60px;" />';
				if ( isset($field['desc']) && $field['desc'] != '' ) echo '<em class="field-description">' . $field['desc'] . '</em>';
				break;

			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? $meta : '', '</textarea>', '<br />', isset($field['desc']) ? $field['desc'] : '';
				break;

			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option value="' . $option['value'] . '" ', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
				}
				echo '</select>';
				echo isset($field['desc']) ? '<br /><em class="desc">' . $field['desc'] . '</em>' : '';
				break;

			case 'double_select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option value="' . $option['slug'] . '"', $meta == $option['slug'] ? ' selected="selected"' : '', '>', $option['type'], '</option>';
				}
				echo '</select>';
				break;

			case 'checkbox':
				echo '<label><input type="hidden" name="', $field['id'], '" value=false />';
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value=true ', $meta == 'true' ? ' checked="checked"' : '', ' />';
				// Print Checkbox Description if there is one
				echo isset($field['desc']) ? ' <span class="desc">' . $field['desc'] . '</span>' : '';
				echo '</label>';
				break;

			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<p><label><input type="radio" name="', $field['id'], '" value="', esc_attr( $option['value'] ), '"', ( $meta == $option['value'] || (!$meta  && $field['std'] == $option['value']) ) ? ' checked="checked"' : '', ' />', esc_attr( $option['name'] ), '</label></p>';
				}
				echo isset($field['desc']) ? '<p style="clear: both;"><em class="desc">' . $field['desc'] . '</em></p>' : '';
				break;

			case 'layout-picker':
				$valid_options = array();
				$valid_options = $field['options'];
				foreach ( $valid_options as $valid_option ) {
					?>
					<label class="layout-item <?php echo $field['id']; ?>-layout">
					<input type="radio" name="<?php echo $field['id']; ?>" <?php checked( $valid_option['name'] == $meta || ( $meta == '' && $valid_option['name'] == $field['std'] ) ); ?> value="<?php echo $valid_option['name']; ?>" />
					<?php if ( $valid_option['img'] != '' ) { ?>
					<img src="<?php echo get_template_directory_uri() . $field['path'] . $valid_option['img']; ?>" alt="<?php echo $valid_option['title']; ?>">
					<?php } ?>
					<span>
					<?php echo $valid_option['title']; ?>
					<?php if ( $valid_option['description'] ) { ?>
						<span style="padding-left:5px;"><em><?php echo $valid_option['description']; ?></em></span>
					<?php } ?>
					</span>
					</label>
					<?php
				}
				echo isset($field['desc']) ? '<p style="clear: both;"><em class="desc">' . $field['desc'] . '</em></p>' : '';
				break;

			case 'editor':
				wp_editor( wp_kses_post($meta), $field['id'] );
				break;

			case 'prev-editor':
				// For backwards compatibility, this editor will first bring
				// any content that could previously have been in the post editor
				$content = $meta ? wp_kses_post($meta) : get_post( $post_id )->post_content;
				// $content = $meta ? wp_kses_post($meta) : '';
				// wp_editor( $content, $field['id'], array('textarea_rows' => 4) );
				echo '<textarea class="qi-editor" name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="8">' . $content . '</textarea>';
				break;

			case 'color':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? esc_attr( $meta ) : $field['std'], '" size="15"/>
				<input type="button" class="quadropickcolor button-secondary" value="' . esc_html__( 'Select color', 'quadro' ) . '">
				<div id="qcolorpicker"></div>';
				if ( isset($field['desc']) && $field['desc'] != '' ) echo '<br /><em class="field-description">' . $field['desc'] . '</em>';
				break;

			case 'upload':
				?>
				<input class="upload" id="<?php echo $field['id']; ?>" type="text" size="30" name="<?php echo $field['id']; ?>" value="<?php echo $meta ? $meta : ''; ?>" />
				<input class="upload_file_button" type="button" value="<?php esc_html_e( 'Select file', 'quadro' ) ?>" />
				<p><?php esc_html_e( 'Once you select the file, click "Choose File".', 'quadro' ); ?></p>
				<?php
				break;

			case 'gallery':
				?>
				<input class="upload" id="<?php echo $field['id']; ?>" type="text" size="30" name="<?php echo $field['id']; ?>" value="<?php echo $meta ? $meta : ''; ?>" />
				<input class="gallery_pick_button" type="button" value="<?php esc_html_e( 'Select Gallery', 'quadro' ) ?>" />
				<?php
				break;

			case 'icon_extended':
				echo '<input type="hidden" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : '', '" />';
				echo '<i class="icon-placeholder ' . $meta . '"></i>';
				echo '<a class="button icon-picker-opener">' . esc_html__( 'Open / Close', 'quadro' ) . '</a>';
				qi_add_icon_picker( $meta );
				break;

			case 'one_post_picker':
				// Posts query, bring all of them
				$args = array( 'post_type' => $field['post_type'], 'posts_per_page' => -1 );
				$select_query = get_posts( $args );
				// List them
				if( !empty($select_query) ) : 
					echo '<select name="', $field['id'], '" id="', $field['id'], '" class="qcustom-selector">';
					foreach ( $select_query as $litem ) :
						// Define Post type name
						$qtype_name = '';
						$qpost_type = get_post_type( $litem->ID );
						if ( $qpost_type == 'post' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Post', 'quadro') . ')</span>';
						if ( $qpost_type == 'quadro_slide' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Slide', 'quadro') . ')</span>';
						if ( $qpost_type == 'quadro_nym_portfolio' || $qpost_type == 'quadro_portfolio' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Portfolio', 'quadro') . ')</span>';
						if ( $qpost_type == 'product' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Product', 'quadro') . ')</span>';
						// Echo the option
						echo '<option value="' . $litem->ID . '"', $meta == $litem->ID ? ' selected="selected"' : '', '>', $litem->post_title . $qtype_name . '</option>';
                	endforeach;
					echo '</select>';
				endif;
				wp_reset_postdata();
				break;

			case 'posts_picker' :
				// Output Description
				echo isset($field['desc']) ? '<p style="clear: both;"><em class="desc">' . $field['desc'] . '</em></p>' : '';
				// First query, bring all of them
				$args = array( 'post_type' => $field['post_type'], 'posts_per_page' => -1 );
				$select_query = get_posts( $args );
				$items = 0;
				$qtype_class = '';
				// List them
				if( !empty($select_query) ) :
					// Output Filter for Modules Selector
					if ( $field['post_type'] == 'quadro_mods' ) {
						echo '<div class="modules-filter-container">';
						echo '<span class="module-type-filter-title">' . esc_html__( 'Filter By Module Type', 'quadro' ) . '</span>';
						global $available_modules;
						echo '<select class="module-type-filter">';
						echo '<option class="all">' . esc_html__( 'All Module Types', 'quadro' ) . '</option>';
						foreach ($available_modules as $key => $value) {
							echo '<option class="' . $value . '">' . $key . '</option>';
						}
						echo '</select></div>';
					}
					// Output Posts Selector
					echo '<select name="posts-picker" class="posts-picker qcustom-selector" multiple>';
					foreach ( $select_query as $litem ) :
						// Check if we want some particular module type
						if ( isset($field['mod_type']) ){
							// And check for it
							if ( esc_attr(get_post_meta( $litem->ID, 'quadro_mod_type', true )) != $field['mod_type'] )
								continue;
						}
						// Check if we want some particular post format
						if ( isset($field['post_format']) ){
							// And check for it
							if ( ! in_array(get_post_format($litem->ID), $field['post_format']) )
								continue;
						}
						$qtype_name = '';
						// Display Module type for Modular Template
						if ( $field['post_type'] == 'quadro_mods' ) {
							// Skip iteration if Wrapper Module
							$mod_types = $field['available_mods'];
					        $mod_type = get_post_meta( $litem->ID, 'quadro_mod_type', true );
							if ( isset($field['wrapper']) && $field['wrapper'] == true && ($mod_type == 'wrapper' || $mod_type == 'tabs') ) continue;
					        $this_type = array_search( $mod_type, $mod_types );
					        $qtype_name = ' <span class="type-name">(' . $this_type . ')</span>';
					        $qtype_class = 'class="qi-type-'. $mod_type . ' qi-type-all"';
						}
						if ( $field['show_type'] == true ) {
							// Define Post type name
							$qpost_type = get_post_type( $litem->ID );
							if ( $qpost_type == 'post' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Post', 'quadro') . ')</span>';
							if ( $qpost_type == 'quadro_slide' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Slide', 'quadro') . ')</span>';
							if ( $qpost_type == 'quadro_nym_portfolio' || $qpost_type == 'quadro_portfolio' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Portfolio', 'quadro') . ')</span>';
							if ( $qpost_type == 'product' ) $qtype_name = '<span class="type-name"> (' . esc_html__('Product', 'quadro') . ')</span>';
							// Echo the option
						}
						echo '<option value="' . $litem->ID . '" ', $qtype_class, ' ', $meta == $litem->ID ? ' selected="selected"' : '', '>', $litem->post_title . $qtype_name . '</option>';
                		$items++;
                	endforeach;
                echo '</select>';
                echo '<span class="posts-adder">' . esc_html__('Add to list', 'quadro') . '</span>';
				endif;
				wp_reset_postdata();

				// Ofer link to create Portfolio Modules if it matches the requested module
				if ( $items == 0 && isset($field['mod_type']) ){
					$link = '<a href="' . get_site_url() . '/wp-admin/post-new.php?post_type=quadro_mods" target="_blank">';
					if ( $field['mod_type'] == 'portfolio' )
						echo '<p>' . esc_html__('No portfolio modules yet? What about ', 'quadro') . $link . esc_html__('adding one right now?', 'quadro') . '</a></p>';
					if ( $field['mod_type'] == 'blog' )
						echo '<p>' . esc_html__('No blog modules yet? What about ', 'quadro') . $link . esc_html__('adding one right now?', 'quadro') . '</a></p>';
				}

				// Ofer link to create Modules if it matches the requested post type
				if ( $items == 0 && !isset($field['mod_type']) && $field['post_type'] == 'quadro_mods' ){
					$link = '<a href="' . get_site_url() . '/wp-admin/post-new.php?post_type=quadro_mods" target="_blank">';
					echo '<p>' . esc_html__('No modules yet? What about ', 'quadro') . $link . esc_html__('adding one right now?', 'quadro') . '</a></p>';
				}

				// Ofer link to create Slides if it matches the requested post type
				if ( $items == 0 && $field['post_type'] == 'quadro_slide' ){
					$link = '<a href="' . get_site_url() . '/wp-admin/post-new.php?post_type=quadro_slide" target="_blank">';
					echo '<p>' . esc_html__('No slides yet? What about ', 'quadro') . $link . esc_html__('adding one right now?', 'quadro') . '</a></p>';
				}

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_posts = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if( $meta != '' ) :
					// Prepare internal preview for modules
					$maybeIntPreview = ( isset($field['post_type']) && $field['post_type'] == 'quadro_mods' ) ? '?qi=internal-preview' : '';
					foreach ( $sel_posts as $sel_post ) :
						$edit_link = get_edit_post_link( $sel_post, '' );
						echo '<li data-id="' . $sel_post . '">
							<label class="li-mover">
								<i class="remove-post fa fa-times"></i> ' . get_the_title( $sel_post ) . '
							</label>
							<span class="qi-mod-action-links">
								<a href="' . esc_url( get_permalink( $sel_post ) ) . $maybeIntPreview . '" target="_blank" class="qi-preview-link"><i class="fa fa-eye"></i></a>
								<a href="' . $edit_link . '" class="qi-edit-link"><i class="fa fa-pencil"></i></a>
							</span>
						</li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'authors_picker' :
				// First query, bring all of them
				$select_query = get_users( array( 'fields' => array( 'display_name', 'ID' ), 'who' => 'authors' ) );
				// List them
				if( !empty($select_query) ) {
					echo '<select name="posts-picker" class="posts-picker qcustom-selector" multiple>';
					foreach ( $select_query as $litem ) {
						echo '<option value="' . $litem->ID . '"', $meta == $litem->ID ? ' selected="selected"' : '', '>', $litem->display_name . '</option>';
                	}
                	echo '</select>';
                	echo '<span class="posts-adder">' . esc_html__('Add to list', 'quadro') . '</span>';
				}

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_authors = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if( $meta != '' ) :
					foreach ( $sel_authors as $sel_author ) :
						echo '<li data-id="' . $sel_author . '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' . get_the_author_meta( 'display_name', $sel_author ) . '</label></li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'pattern_picker':
				$quadro_patterns = quadro_get_background_patterns();
				echo '<a class="button" id="pattern-picker-opener">' . esc_html__( 'Select pattern', 'quadro' ) . '</a>';
				echo '<div id="pattern-selector" style="display: none;">';
				echo '<label><input type="radio" name="', $field['id'], '"' . checked( ($meta == 'none' || $meta == '' ) ? true : false ) . ' value="none" />' . esc_html__( 'None', 'quadro' ) . '</label>';
				foreach ( $quadro_patterns as $quadro_pattern ) {
					echo '<label><input type="radio" name="', $field['id'], '"' . checked( $meta == $quadro_pattern ? true : false ) . ' value="' . $quadro_pattern . '" /><img src="' . get_template_directory_uri() . '/images/admin/pattern-thumbs/' . $quadro_pattern . 'thumb.jpg" width="30px" height="30px" /></label>';
				}
				echo '</div>';
				break;

			case 'tax_picker' :
				// First, bring all of them
				$terms = get_terms( $field['tax_slug'], array( 'hide_empty' => 0 ) );
				// List them
				if ( count($terms) > 0 ) :
					echo '<select name="posts-picker" class="posts-picker qtax-selector" multiple>';
					foreach ( $terms as $term ) :
						// Echo the option
						echo '<option value="' . $term->term_id . '"', $meta == $term->term_id ? ' selected="selected"' : '', '>' . $term->name . '</option>';
                	endforeach;
                echo '</select>';
                echo '<span class="posts-adder">' . __('Add categories to list', 'quadro') . '</span>';
				endif;

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_taxs = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if( $meta != '' ) :
					foreach ( $sel_taxs as $sel_tax ) :
						if ( $tax_object = get_term( $sel_tax, $field['tax_slug'] ) )
							echo '<li data-id="' . $sel_tax . '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' . $tax_object->name . '</label></li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'tax_picker_permanent' :
				// First, bring all of them
				$terms = get_terms( $field['tax_slug'], array( 'hide_empty' => 0 ) );
				// List them
				if ( count($terms) > 0 ) :
					echo '<select name="posts-picker" class="posts-picker" multiple>';
					foreach ( $terms as $term ) :
						// Echo the option
						echo '<option value="' . $term->term_id . '"', $meta == $term->term_id ? ' selected="selected"' : '', '>' . $term->name . '</option>';
                	endforeach;
                echo '</select>';
                echo '<span class="posts-adder">' . esc_html__('Add categories to list', 'quadro') . '</span>';
				endif;

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_taxs = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if( $meta != '' ) :
					foreach ( $sel_taxs as $sel_tax ) :
						if ( $tax_object = get_term( $sel_tax, $field['tax_slug'] ) )
							echo '<li data-id="' . $sel_tax . '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' . $tax_object->name . '</label></li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'format_picker' :
				// First, define all of them
				$post_formats = array( 'standard' => esc_html__('Standard', 'quadro'), 'aside' => esc_html__('Aside', 'quadro'), 'status' => esc_html__('Status', 'quadro'), 'gallery' => esc_html__('Gallery', 'quadro'), 'image' => esc_html__('Image', 'quadro'), 'audio' => esc_html__('Audio', 'quadro'), 'video' => esc_html__('Video', 'quadro'), 'quote' => esc_html__('Quote', 'quadro'), 'link' => esc_html__('Link', 'quadro') );
				// Then, list them
					echo '<select name="posts-picker" class="posts-picker qformat-selector" multiple>';
					foreach ( $post_formats as $format => $name ) :
						// Echo the option
						echo '<option value="' . $format . '"', $meta == $format ? ' selected="selected"' : '', '>' . $name . '</option>';
                	endforeach;
                echo '</select>';
                echo '<span class="posts-adder">' . esc_html__('Add formats to list', 'quadro') . '</span>';

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_formats = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if( $meta != '' ) :
					foreach ( $sel_formats as $sel_format ) :
							echo '<li data-id="' . $sel_format . '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' . $post_formats[$sel_format] . '</label></li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'greyed-out':
				echo '<p id="' . $field['id'] . '" class="greyed-out-field">';
				echo '<a href="' . $field['pro_url'] . '">' . $field['pro_desc'] . '</a>';
				echo '</p>';
				break;

			case 'data-fields-picker':
				// First, bring all of them
				$data_fields = $quadro_options['portfolio_fields'];
				// List them
				if ( count($data_fields) > 0 ) :
					echo '<select name="posts-picker" class="posts-picker" multiple>';
					foreach ( $data_fields as $data_field ) :
						// Echo the option
						echo '<option value="' . $data_field['slug'] . '"', $meta == $data_field['slug'] ? ' selected="selected"' : '', '>' . $data_field['title'] . '</option>';
                	endforeach;
                echo '</select>';
                echo '<span class="posts-adder">' . esc_html__('Add fields to list', 'quadro') . '</span>';
				endif;

				// Prepare UL for jQuery to add selected items,
				// and query the items again based on previously
				// selected and saved in $meta
				echo '<ul class="sel-posts-container">';
				$sel_fields = explode( ', ', rtrim($meta, ', ') );
				// (second query)
				if ( $meta != '' ) :
					foreach ( $sel_fields as $sel_field ) :
						foreach($data_fields as $key => $value) {
						    if ( in_array($sel_field, $value) ) break;
						}
						echo '<li data-id="' . $sel_field . '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' . $data_fields[$key]['title'] . '</label></li>';
                	endforeach;
				endif;
				echo '</ul>';
				// Little home for the list to be saved in
                echo '<input type="hidden" name="', $field['id'], '" value="' . $meta . '" />';
				break;

			case 'sidebar_picker':
				$quadro_sidebars = $quadro_options['quadro_sidebars'];
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				echo '<option value="main-sidebar"', $meta == 'main-sidebar' ? ' selected="selected"' : '', '>', esc_html__('Sidebar (default)', 'quadro'), '</option>';
				foreach ( $quadro_sidebars as $sidebar ) {
					echo '<option value="' . $sidebar['slug'] . '"', $meta == $sidebar['slug'] ? ' selected="selected"' : '', '>', $sidebar['name'], '</option>';
				}
				echo '</select>';
				
				break;

			case 'repeatable':

				echo isset($field['desc']) ? '<p class="description">' . $field['desc'] . '</p>' : '';

				echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';

				// Make it behave as an array even if it's not
				if ( !is_array($meta) ) $meta[0] = array();

				$i = 0;

				foreach ( $meta as $row ) {

					echo '<li>';
					// echo '<span class="sort hndle button"><i class="fa fa-arrows-v"></i></span> ';
					$item_name = isset( $field['item-name'] ) ? $field['item-name'] : esc_html__('Item', 'quadro');
					echo '<h4 class="fields-toggle sort">' . $item_name . ' <span class="repeat-index">' . ($i + 1) . '</span><i class="fa fa-caret-up"></i></h4>';
					echo '<div class="fields-wrapper">';

						echo '<div class="fields-set">';
							foreach ( $field['repeat-fields'] as $this_field ) {
								echo '<label><strong>' . $this_field['title'] . '</strong> ';
								// Swith through possible field types
								switch ( $this_field['type'] ) {
									case 'text':
										// echo $row[$this_field['name']];
										$this_value = (!empty($row[$this_field['name']])) ? esc_attr($row[$this_field['name']]) : '';
										echo '<input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" id="' . $field['id'] . '" value="' . $this_value . '" size="30" />';
										break;
									case 'textarea':
										$this_value = (!empty($row[$this_field['name']])) ? esc_attr($row[$this_field['name']]) : '';
										echo '<textarea name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" id="' . $field['id'] . '" size="30">' . $this_value . '</textarea>';
										break;
									case 'upload':
										$this_value = (!empty($row[$this_field['name']])) ? esc_url($row[$this_field['name']]) : '';
										echo '<input class="upload" id="' . $field['id'] . '" type="text" size="30" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" value="' . $this_value . '" />';
										echo '<span class="upload_file_button button">' . esc_html__( 'Select file', 'quadro' ) . '</span>';
										break;
									case 'social':
										$this_value = (!empty($row[$this_field['name']])) ? $row[$this_field['name']] : '';
										echo '<label>Twitter: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .'][twitter]" id="' . $field['id'] . '" value="'; if ( isset($this_value['twitter']) ) echo esc_attr($this_value['twitter']); echo '" size="30" />';
										echo '<label>Facebook: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .'][facebook]" id="' . $field['id'] . '" value="'; if ( isset($this_value['facebook']) ) echo esc_attr($this_value['facebook']); echo '" size="30" />';
										echo '<label>Google Plus: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .'][google-plus]" id="' . $field['id'] . '" value="'; if ( isset($this_value['google-plus']) ) echo esc_attr($this_value['google-plus']); echo '" size="30" />';
										echo '<label>Website: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .'][globe]" id="' . $field['id'] . '" value="'; if ( isset($this_value['globe']) ) echo esc_attr($this_value['globe']); echo '" size="30" />';
										echo '<label>Email: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .'][envelope]" id="' . $field['id'] . '" value="'; if ( isset($this_value['envelope']) ) echo esc_attr($this_value['envelope']); echo '" size="30" />';
										break;
									case 'social-flex':
										$this_value = (!empty($row[$this_field['name']])) ? $row[$this_field['name']] : '';
										if ( is_array( $quadro_options['available_contact_methods'] ) ) {
						 					foreach ( $quadro_options['available_contact_methods'] as $method ) {
						 						echo '<label>'.$method['title'].': </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']['.$method['slug'].']" id="' . $field['id'] . '" value="'; if ( isset($this_value[$method['slug']]) ) echo esc_attr($this_value[$method['slug']]); echo '" size="30" />';
						 					}
						 				}
										break;
									case 'icon_extended':
										$this_value = (!empty($row[$this_field['name']])) ? esc_attr($row[$this_field['name']]) : '';
										echo '<input type="hidden" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" id="' . $field['id'] . '" value="' . $this_value . '"/>';
										echo '<i class="icon-placeholder ' . $this_value . '"></i>';
										echo '<a class="button icon-picker-opener">' . esc_html__( 'Open / Close', 'quadro' ) . '</a>';
										qi_add_icon_picker( $this_value, '['.$i.']' );
										break;
									case 'select':
										$this_value = (!empty($row[$this_field['name']])) ? esc_attr($row[$this_field['name']]) : '';
										echo '<select name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" id="' . $field['id'] . '">';
											foreach ($this_field['options'] as $option) {
												echo '<option value="' . $option['value'] . '" ', $this_value == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
											}
										echo '</select>';
										break;
									case 'layout-picker':
										$this_value = (!empty($row[$this_field['name']])) ? esc_attr($row[$this_field['name']]) : '';
										echo '<div class="repeatable-layout-picker clear">';
										foreach ( $this_field['options'] as $option ) {
											?>
											<label class="layout-item">
											<input type="radio" name="<?php echo $field['id'] . '['.$i.']['. $this_field['name'] .']'; ?>" <?php checked( $option['name'] == $this_value || ( $this_value == '' && $option['name'] == $this_field['std'] ) ); ?> value="<?php echo $option['name']; ?>" />
											<?php if ( $option['img'] != '' ) { ?>
											<img src="<?php echo get_template_directory_uri() . $this_field['path'] . $option['img']; ?>" alt="<?php echo $option['title']; ?>">
											<?php } ?>
											<span>
											<?php echo $option['title']; ?>
											<?php if ( $option['description'] ) { ?>
												<span style="padding-left:5px;"><em><?php echo $option['description']; ?></em></span>
											<?php } ?>
											</span>
											</label>
											<?php
										}
										echo '</div>';
										break;
									case 'editor':
										$this_value = (!empty($row[$this_field['name']])) ? wp_kses_post($row[$this_field['name']]) : '';
										// $settings = array( 'textarea_rows' => 6, 'textarea_name' => $field['id'] . '['.$i.']['. $this_field['name'] .']' );
										// wp_editor( wp_kses_post($this_value), $field['id'] . '-'.$i.'-'. $this_field['name'], $settings );
										echo '<textarea class="wp-editor-area repeatable-editor" name="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" id="' . $field['id'] . '['.$i.']['. $this_field['name'] .']" cols="60" rows="6">' . $this_value . '</textarea>';
										break;

								}
								echo '</label>';
							}

							echo '<a class="repeatable-remove" href="#">' . esc_html__('Remove this item', 'quadro') . '</a>';
						echo '</div><!-- .fields-set -->';

					echo '</div><!-- .fields-wrapper -->';
					echo '</li>';

					$i++;

				}

				echo '</ul>';
				echo '<a class="repeatable-add button" href="#">+ ' . $field['repeat-item'] . '</a>';
				break; // end repeatable

			case 'xrepeatable':

				echo '<p class="description">'.$field['desc'].'</p>';

				echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';

				// Make it behave as an array even if it's not
				if ( !is_array($meta) ) $meta[0] = array();

				$i = 0;

				foreach ( $meta as $row ) {

					echo '<li>';
					// echo '<span class="sort hndle button"><i class="fa fa-arrows-v"></i></span> ';
					$item_name = isset( $field['item-name'] ) ? $field['item-name'] : esc_html__('Item', 'quadro');
					echo '<h4 class="fields-toggle sort">' . $item_name . ' <span class="repeat-index">' . ($i + 1) . '</span><i class="fa fa-caret-up"></i></h4>';
					echo '<div class="fields-wrapper">';

						echo '<div class="fields-set">';
							foreach ( $field['repeat-fields'] as $this_field => $type ) {
								echo '<label><span>' . $this_field . '</span>';
								// Swith through possible field types
								switch ( $type ) {
									case 'text':
										$this_value = (!empty($row)) ? esc_attr($row[$this_field]) : '';
										echo '<input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .']" id="' . $field['id'] . '" value="' . $this_value . '" size="30" />';
										break;
									case 'textarea':
										$this_value = (!empty($row)) ? esc_attr($row[$this_field]) : '';
										echo '<textarea name="' . $field['id'] . '['.$i.']['. $this_field .']" id="' . $field['id'] . '" size="30">' . $this_value . '</textarea>';
										break;
									case 'upload':
										$this_value = (!empty($row)) ? esc_url($row[$this_field]) : '';
										echo '<input class="upload" id="' . $field['id'] . '" type="text" size="30" name="' . $field['id'] . '['.$i.']['. $this_field .']" value="' . $this_value . '" />';
										echo '<span class="upload_file_button button">' . esc_html__( 'Upload file', 'quadro' ) . '</span>';
										break;
									case 'social':
										$this_value = (!empty($row)) ? $row[$this_field] : '';
										echo '<label>Twitter: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .'][twitter]" id="' . $field['id'] . '" value="'; if ( isset($this_value['twitter']) ) echo esc_attr($this_value['twitter']); echo '" size="30" />';
										echo '<label>Facebook: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .'][facebook]" id="' . $field['id'] . '" value="'; if ( isset($this_value['facebook']) ) echo esc_attr($this_value['facebook']); echo '" size="30" />';
										echo '<label>Google Plus: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .'][google-plus]" id="' . $field['id'] . '" value="'; if ( isset($this_value['google-plus']) ) echo esc_attr($this_value['google-plus']); echo '" size="30" />';
										echo '<label>Website: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .'][globe]" id="' . $field['id'] . '" value="'; if ( isset($this_value['globe']) ) echo esc_attr($this_value['globe']); echo '" size="30" />';
										echo '<label>Email: </label><input type="text" name="' . $field['id'] . '['.$i.']['. $this_field .'][envelope]" id="' . $field['id'] . '" value="'; if ( isset($this_value['envelope']) ) echo esc_attr($this_value['envelope']); echo '" size="30" />';
										break;
								}
								echo '</label>';
							}

						echo '<a class="repeatable-remove" href="#">' . esc_html__('Remove this item', 'quadro') . '</a>';
						echo '</div><!-- .fields-set -->';

					echo '</div><!-- .fields-wrapper -->';
					echo '</li>';

					$i++;

				}

				echo '</ul>';
				echo '<a class="repeatable-add button" href="#">+ ' . $field['repeat-item'] . '</a>';
				break; // end xrepeatable

			case 'portfolio-fields-input':
				echo '<em>' . $field['desc'] . '</em>';
				$portfolio_fields = $quadro_options['portfolio_fields'];
				if ( !is_array($portfolio_fields) ) {
					echo '<p>' . esc_html__('No fields to fill yet.', 'quadro') . '</p>';
					break;
				}
				foreach ($portfolio_fields as $portfolio_field) {
					$this_slug = esc_attr( $portfolio_field['slug'] );
					$this_title = esc_attr( $portfolio_field['title'] );
					if ( $this_slug == '' || $this_title == '' ) continue;
					$this_show = isset($portfolio_field['show']) && 'on' == $portfolio_field['show'] ? true : false;
					$this_value = is_array($meta) ? esc_attr($meta[$portfolio_field['slug']]['value']) : '';
					echo '<label for="' . $field['id'] . '[' . $this_slug . ']" class="portfolio-fields-label">';
					echo '<span>' . $this_title . '</span>';
					echo '<input type="text" name="' . $field['id'] . '[' . $this_slug . '][value]" id="' . $field['id'] . '" value="' . $this_value . '" size="30" />';
					echo '<input type="hidden" name="' . $field['id'] . '[' . $this_slug . '][title]" id="' . $field['id'] . '" value="' . $this_title . '" />';
					echo '<input type="hidden" name="' . $field['id'] . '[' . $this_slug . '][show]" id="' . $field['id'] . '" value="' . $this_show  . '" />';
					echo '<input type="hidden" name="' . $field['id'] . '[' . $this_slug . '][slug]" id="' . $field['id'] . '" value="' . $this_slug  . '" />';
					echo '</label>';
				}

				break;

		}

		echo '</td>';
		echo '</tr>';

	}

	echo '</table>';

}


/*-----------------------------------------------------------------------------------*/
/*	Add the metaboxes
/*-----------------------------------------------------------------------------------*/

function quadro_add_cfields_box() {
	global $quadro_cfields_def;
	foreach ( $quadro_cfields_def as $quadro_metabox) {
		add_meta_box( $quadro_metabox['id'], $quadro_metabox['title'], 'quadro_show_boxes', $quadro_metabox['page'], $quadro_metabox['context'], $quadro_metabox['priority'], $quadro_metabox );
	}
}
add_action('add_meta_boxes', 'quadro_add_cfields_box');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta boxes
/*-----------------------------------------------------------------------------------*/

function quadro_show_boxes( $post, $quadro_current_fields ) {
	global $quadro_cfields_def, $post;
	quadro_print_boxes( $quadro_current_fields['args'] );
}


/*-----------------------------------------------------------------------------------*/
/*	Save data from meta boxes
/*-----------------------------------------------------------------------------------*/

function quadro_save_custom_data( $post_id ) {

	global $quadro_cfields_def, $quadro_cfields_mods_def;

	// verify nonce
	if ( isset($_POST['quadro_meta_box_nonce']) ) {
		if (!wp_verify_nonce($_POST['quadro_meta_box_nonce'], basename(__FILE__))) return $post_id;
	}

	// check autosave
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	// check permissions
	if ( isset($_POST['post_type']) ) {
		if ('post' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif ( !current_user_can('edit_post', $post_id) ) {
			return $post_id;
		}
	}

	// for common cusotm fields
	foreach ( $quadro_cfields_def as $quadro_box ) {

		foreach ( $quadro_box['fields'] as $field ) {
			if ( isset ($_POST[$field['id']]) )	{
				$old = get_post_meta( $post_id, $field['id'], true );
				$new = $_POST[$field['id']];

				if ( $new && $new != $old ) {
					update_post_meta( $post_id, $field['id'], $new );
				} elseif ( '' == $new && $old ) {
					delete_post_meta( $post_id, $field['id'], $old );
				}
			}
		}

	}

	// for modules specific cusotm fields
	if ( isset($_POST['post_type']) && 'quadro_mods' == $_POST['post_type'] ) {
		foreach ( $quadro_cfields_mods_def as $quadro_mod_box ) {
			foreach ( $quadro_mod_box['fields'] as $field ) {
				if ( isset ($_POST[$field['id']]) )	{
					$old = get_post_meta( $post_id, $field['id'], true );
					$new = $_POST[$field['id']];

					if ( $new && $new != $old ) {
						update_post_meta( $post_id, $field['id'], $new );
					} elseif ( '' == $new && $old ) {
						delete_post_meta( $post_id, $field['id'], $old );
					}
				}
			}
		}
	}

}
add_action('save_post', 'quadro_save_custom_data');


/**
 * Icon Picker Lightbox
 */
function qi_add_icon_picker( $meta, $index = '' ) {
	// Bring icon definitions
	$icon_list = quadro_icons_font_def();
	// Build icon picker
	echo '<div id="icon-selector" style="display: none;">';
		echo '<div class="icons-wrapper">';
			echo '<h2>' . esc_html__('Choose or search your desired icon', 'quadro') . '</h2>';
			echo '<label>Search: <input type="text" class="icon-search"/></label>';
			echo '<div class="icon-selector">';
				foreach ( $icon_list as $icon_set) {
					echo '<h3>' . $icon_set['section-name'] . '</h3>';
					echo '<div>';
					foreach ( $icon_set['icon-classes'] as $icon_class ) {
						echo '<label><input type="radio" name="icon_picker_input' . $index . '" value="', $icon_class, '"', ( $meta == $icon_class || !$meta ) ? ' checked="checked"' : '', ' /><i class="' . $icon_class . '"></i></label>';
					}
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
}


/**
 * wp_editor AJAX call
 */
function qi_create_editor(){
	$settings = array( 'textarea_rows' => 6, 'textarea_name' => esc_attr($_POST['newName']), 'tinymce' => false );
	wp_editor( '', esc_attr($_POST['newID']), $settings );
	die();
}
add_action('wp_ajax_quadro_ajax_fields_action', 'qi_create_editor');


?>