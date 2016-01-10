<?php
/**
 * Quadro Theme Options Settings API
 *
 * This file implements the WordPress Settings API for the 
 * Options for the Theme.
 * 
 */

/**
 * Register Settings
 * 
 * Register $quadro_options_group array to hold all Theme options.
 */
global $quadro_options_group;
register_setting( 
	// $option_group
	$quadro_options_group, 
	// $option_name
	$quadro_options_group, 
	// $sanitize_callback
	'quadro_options_validate' 
);

/**
 * Quadro register_setting() sanitize callback
 * 
 * Validate and whitelist user-input data before updating Theme 
 * Options in the database. Only whitelisted options are passed
 * back to the database, and user-input data for all whitelisted
 * options are sanitized.
 * 
 * @link	http://codex.wordpress.org/Data_Validation	Codex Reference: Data Validation
 * 
 * @param	array	$input	Raw user-input data submitted via the Theme Settings page
 * @return	array	$input	Sanitized user-input data passed to the database
 */
function quadro_options_validate( $input ) {

	// This is the "whitelist": current settings
	$valid_input = quadro_get_options();
	// Get the array of Theme settings, by Settings Page tab
	$settingsbytab = quadro_get_settings_by_tab();
	// Get the array of option parameters
	$option_parameters = quadro_get_option_parameters();
	// Get the array of option defaults
	$option_defaults = quadro_get_option_defaults();
	// Get list of tabs
	$tabs = quadro_get_settings_page_tabs();

	// Determine what type of submit was input
	$submittype = 'submit';	
	foreach ( $tabs as $tab ) {
		$resetname = 'reset-' . $tab['name'];
		if ( ! empty( $input[$resetname] ) ) {
			$submittype = 'reset';
		}
	}

	// Determine what tab was input
	$submittab = 'general';	
	foreach ( $tabs as $tab ) {
		$submitname = 'submit-' . $tab['name'];
		$resetname = 'reset-' . $tab['name'];
		if ( ! empty( $input[$submitname] ) || ! empty($input[$resetname] ) ) {
			$submittab = $tab['name'];
		}
	}
	global $wp_customize;
	// Get settings by tab
	$tabsettings = ( isset( $wp_customize ) ? $settingsbytab['all'] : $settingsbytab[$submittab] );

	// Restore options from backup if submitted
	if ( isset($input['restore_next']) && $input['restore_next'] === true ) {
		$tabsettings = $settingsbytab['all'];
		$valid_input['restore_next'] = false;
	}

	// Loop through each tab setting
	foreach ( $tabsettings as $setting ) {
		// If no option is selected, set the default
		$valid_input[$setting] = ( ! isset( $input[$setting] ) ? $option_defaults[$setting] : $input[$setting] );

		// Get the setting details from the defaults array
		$optiondetails = $option_parameters[$setting];

		// If submit, validate/sanitize $input
		if ( 'submit' == $submittype ) {

			// Get the array of valid options, if applicable
			$valid_options = ( isset( $optiondetails['valid_options'] ) ? $optiondetails['valid_options'] : false );

			// Validate checkbox fields
			if ( 'checkbox' == $optiondetails['type'] ) {
				// If input value is set and is true, return true; otherwise return false
				$valid_input[$setting] = ( ( isset( $input[$setting] ) && true == $input[$setting] ) ? true : false );
			}
			// Validate radio button fields
			else if ( 'radio' == $optiondetails['type'] ) {
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate select fields
			else if ( 'select' == $optiondetails['type'] ) {
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate text input and textarea fields
			else if ( 'text' == $optiondetails['type'] || 'textarea' == $optiondetails['type'] || 'pass' == $optiondetails['type'] || 'text-hideable' == $optiondetails['type'] ) {
				// Validate no-HTML content
				if ( 'nohtml' == $optiondetails['sanitize'] ) {
					// Pass input data through the wp_filter_nohtml_kses filter
					$valid_input[$setting] = wp_filter_nohtml_kses( $input[$setting] );
				}
				// Validate HTML content
				if ( 'html' == $optiondetails['sanitize'] ) {
					// Pass input data through the wp_filter_kses filter
					$valid_input[$setting] = wp_kses_post( $input[$setting] );
				}
			}
			// Validate KSES text input fields
			else if ( 'text-hideable-kses' == $optiondetails['type'] ) {
				// Pass input data through the wp_filter_nohtml_kses filter
				$valid_input[$setting] = wp_kses( $input[$setting], '' );
			}
			// Validate upload input fields
			else if ( 'upload' == $optiondetails['type'] ) {
				// Pass input data through the wp_filter_nohtml_kses filter
				$valid_input[$setting] = wp_filter_nohtml_kses( $input[$setting] );
			}
			// Validate color input fields
			else if ( 'color' == $optiondetails['type'] ) {
				// Pass input data through the wp_filter_kses filter
				$valid_input[$setting] = ( preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input[$setting]) ? $input[$setting] : $option_defaults[$setting] );
				// $valid_input[$setting] = ( sanitize_hex_color($input[$setting]) ? $input[$setting] : $option_defaults[$setting] );
			}
			// Validate layout-picker fields
			else if ( 'layout-picker' == $optiondetails['type'] ) {
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate select fields
			else if ( 'font' == $optiondetails['type'] ) {
				$valid_fonts = quadro_get_valid_fontslist();
				$chosen_font = explode('|', $input[$setting]);
				// Only update setting if input value is in the list of valid options
				$valid_input[$setting] = ( array_key_exists( $chosen_font[0], $valid_fonts ) ? $input[$setting] : $valid_input[$setting] );
			}
			// Validate select fields
			else if ( 'number' == $optiondetails['type'] ) {
				// Only update setting if number is between defined limits
				$valid_input[$setting] = ( intval( $input[$setting] >= $optiondetails['min'] ) && intval( $input[$setting] <= $optiondetails['max'] ) ? intval( $input[$setting] ) : $option_defaults[$setting] );
			}
			// Validate repeatable fields
			else if ( 'repeatable' == $optiondetails['type'] ) {
				$valid_input[$setting] = quadro_array_map_r( 'wp_filter_kses', $input[$setting] );
			}
			// Validate backup options fields
			else if ( 'backup_options' == $optiondetails['type'] ) {
			}
			// Validate transfer options fields
			else if ( 'transfer_options' == $optiondetails['type'] ) {
			}
		}
		// If reset, reset defaults
		elseif ( 'reset' == $submittype ) {
			// Escape this Reset iteration if no_reset is set to true
			if ( isset($optiondetails['no_reset']) && $optiondetails['no_reset'] == true ) continue;
			// Set $setting to the default value
			$valid_input[$setting] = $option_defaults[$setting];
		}
	}

	return $valid_input;

}

/**
 * Globalize the variable that holds 
 * the Settings Page tab definitions
 * 
 * @global	array	Settings Page Tab definitions
 */
global $quadro_tabs;
$quadro_tabs = quadro_get_settings_page_tabs();
/**
 * Call add_settings_section() for each Settings 
 * 
 * Loop through each Theme Settings page tab, and add 
 * a new section to the Theme Settings page for each 
 * section specified for each tab.
 * 
 * @link	http://codex.wordpress.org/Function_Reference/add_settings_section	Codex Reference: add_settings_section()
 * 
 * @param	string		$sectionid	Unique Settings API identifier; passed to add_settings_field() call
 * @param	string		$title		Title of the Settings page section
 * @param	callback	$callback	Name of the callback function in which section text is output
 * @param	string		$pageid		Name of the Settings page to which to add the section; passed to do_settings_sections()
 */
foreach ( $quadro_tabs as $tab ) {
	$tabname = $tab['name'];
	$tabsections = $tab['sections'];
	foreach ( $tabsections as $section ) {
		$sectionname = $section['name'];
		$sectiontitle = $section['title'];
		// Add settings section
		add_settings_section(
			// $sectionid
			'quadro_' . $sectionname . '_section',
			// $title
			$sectiontitle,
			// $callback
			'quadro_sections_callback',
			// $pageid
			'quadro_' . $tabname . '_tab'
		);
	}
}

/**
 * Callback for add_settings_section()
 * 
 * Generic callback to output the section text
 * for each Theme settings section. 
 * 
 * @uses	quadro_get_settings_page_tabs()	Defined in /functions/options.php
 * 
 * @param	array	$section_passed	Array passed from add_settings_section()
 */
function quadro_sections_callback( $section_passed ) {
	global $quadro_tabs;
	$quadro_tabs = quadro_get_settings_page_tabs();
	foreach ( $quadro_tabs as $tabname => $tab ) {
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $sectionname => $section ) {
			if ( 'quadro_' . $sectionname . '_section' == $section_passed['id'] ) {
				?>
				<p><?php echo $section['description']; ?></p>
				<?php
			}
		}
	}
}

/**
 * Globalize the variable that holds 
 * all the Theme option parameters
 * 
 * @global	array	Theme options parameters
 */
global $option_parameters;
$option_parameters = quadro_get_option_parameters();

/**
 * Call add_settings_field() for each Setting Field
 * 
 * Loop through each Theme option, and add a new 
 * setting field to the Theme Settings page for each 
 * setting.
 * 
 * @link	http://codex.wordpress.org/Function_Reference/add_settings_field	Codex Reference: add_settings_field()
 * 
 * @param	string		$settingid	Unique Settings API identifier; passed to the callback function
 * @param	string		$title		Title of the setting field
 * @param	callback	$callback	Name of the callback function in which setting field markup is output
 * @param	string		$pageid		Name of the Settings page to which to add the setting field; passed from add_settings_section()
 * @param	string		$sectionid	ID of the Settings page section to which to add the setting field; passed from add_settings_section()
 * @param	array		$args		Array of arguments to pass to the callback function
 */
foreach ( $option_parameters as $option ) {
	$optionname = $option['name'];
	$optiontitle = $option['title'];
	$optiontab = $option['tab'];
	$optionsection = $option['section'];
	$optiontype = $option['type'];
	if ( 'custom' != $optiontype ) {
		add_settings_field(
			// $settingid
			'quadro_setting_' . $optionname,
			// $title
			$optiontitle,
			// $callback
			'quadro_setting_callback',
			// $pageid
			'quadro_' . $optiontab . '_tab',
			// $sectionid
			'quadro_' . $optionsection . '_section',
			// $args
			$option
		);
	} if ( 'custom' == $optiontype ) {
		add_settings_field(
			// $settingid
			'quadro_setting_' . $optionname,
			// $title
			$optiontitle,
			//$callback
			'quadro_setting_' . $optionname,
			// $pageid
			'quadro_' . $optiontab . '_tab',
			// $sectionid
			'quadro_' . $optionsection . '_section'
		);
	}
}

/**
 * Callback for get_settings_field()
 */
function quadro_setting_callback( $option ) {
	global $quadro_options_group;
	$quadro_options = quadro_get_options();
	$option_parameters = quadro_get_option_parameters();
	$optionname = $option['name'];
	$optiontitle = $option['title'];
	$optiondescription = $option['description'];
	$fieldtype = $option['type'];
	$fieldname = $quadro_options_group . '[' . $optionname . ']';

	// Output checkbox form field markup
	if ( 'checkbox' == $fieldtype ) {
		?>
		<input type="checkbox" name="<?php echo $fieldname; ?>" <?php checked( $quadro_options[$optionname] ); ?> />
		<?php
	}
	// Output radio button form field markup
	else if ( 'radio' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		foreach ( $valid_options as $valid_option ) {
			?>
			<span class="radio-container">
				<label>
					<input type="radio" name="<?php echo $fieldname; ?>" <?php checked( $valid_option['name'] == $quadro_options[$optionname] ); ?> value="<?php echo $valid_option['name']; ?>" />
					<?php echo $valid_option['title']; ?>
					<?php if ( $valid_option['description'] ) { ?>
						<small style="padding-left: 5px;"><em><?php echo $valid_option['description']; ?></em></small>
					<?php } ?>
				</label>
			</span>
			<?php
		}
		echo '</div>';
	}
	// Output select form field markup
	else if ( 'select' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		?>
		<select name="<?php echo $fieldname; ?>" <?php echo $hide_option; ?>>
		<?php 
		foreach ( $valid_options as $valid_option ) {
			?>
			<option <?php selected( $valid_option['name'] == $quadro_options[$optionname] ); ?> value="<?php echo $valid_option['name']; ?>"><?php echo $valid_option['title']; ?></option>
			<?php
		}
		?>
		</select>
		<?php
	} 
	// Output color form field markup
	else if ( 'color' == $fieldtype ) {
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		?>
		</select>
		<input type="text" name="<?php echo $fieldname; ?>" value="<?php echo wp_filter_nohtml_kses( $quadro_options[$optionname] ); ?>" />
		<input type="button" class="quadropickcolor button-secondary" value="<?php esc_html_e( 'Select color', 'quadro' ); ?>">
		<div id="qcolorpicker"></div>
		<?php
		echo '</div>';
	} 
	// Output text input form field markup
	else if ( 'text' == $fieldtype ) {
		?>
		<input type="text" name="<?php echo $fieldname; ?>" value="<?php echo esc_attr( $quadro_options[$optionname] ); ?>" />
		<?php
	}
	// Output hideable text input form field markup
	else if ( 'text-hideable' == $fieldtype ) {
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		?>
		<input type="text" name="<?php echo $fieldname; ?>" value="<?php echo esc_attr( $quadro_options[$optionname] ); ?>" />
		<?php
	}
	// Output hideable text input form field markup (with KSES sanitization)
	else if ( 'text-hideable-kses' == $fieldtype ) {
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		?>
		<input type="text" name="<?php echo $fieldname; ?>" value='<?php echo wp_kses_post( $quadro_options[$optionname] ); ?>' />
		<?php
	}
	// Output textarea input form field markup
	else if ( 'textarea' == $fieldtype ) {
		?>
		<textarea name="<?php echo $fieldname; ?>"><?php echo esc_attr( $quadro_options[$optionname] ); ?></textarea>
		<?php
	}
	// Output pass input form field markup
	else if ( 'pass' == $fieldtype ) {
		?>
		<input type="password" name="<?php echo $fieldname; ?>" value="<?php echo esc_attr( $quadro_options[$optionname] ); ?>" />
		<?php
	}
	// Output upload form field markup
	else if ( 'upload' == $fieldtype ) {
		?>
		<input class="upload" id="<?php echo $fieldname; ?>" type="text" name="<?php echo $fieldname; ?>" value="<?php echo wp_filter_nohtml_kses( $quadro_options[$optionname] ); ?>" />
		<input class="upload_file_button" type="button" value="<?php esc_html_e( 'Select file', 'quadro' ) ?>" />
		<p>Once you upload the file, click "Choose Image".</p>
		<?php
	}
	// Output layout picker form field markup
	else if ( 'layout-picker' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		foreach ( $valid_options as $valid_option ) {
			?>
			<label class="layout-item <?php echo isset($valid_option['label-class']) ? $valid_option['label-class'] : ''; ?> <?php echo $optionname; ?>-layout">
			<input type="radio" name="<?php echo $fieldname; ?>" <?php checked( $valid_option['name'] == $quadro_options[$optionname] ); ?> value="<?php echo $valid_option['name']; ?>" <?php echo isset($valid_option['disabled']) ? $valid_option['disabled'] : ''; ?>/>
			<?php if ( $valid_option['img'] != '' ) { ?>
			<img src="<?php echo get_template_directory_uri() . $option['path'] . $valid_option['img']; ?>" alt="<?php echo $valid_option['title']; ?>">
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
		echo '</div>';
	}
	// Output Repeatable Fields form field markup
	else if ( 'repeatable' == $fieldtype ) {
		$repeat_fields = array();
		$repeat_fields = $option['repeat_fields'];
		$meta = $quadro_options[$optionname];
		
		echo '<ul id="'.$fieldname.'-repeatable" class="custom_repeatable">';

		// Make it behave as an array even if it's not
		if ( !is_array($meta) ) $meta[0] = array();

		$i = 0;

		foreach ( $meta as $row ) {
			echo '<li>';
			$item_name = isset( $option['item-name'] ) ? $option['item-name'] : esc_html__('Item', 'quadro');
			echo '<h4 class="fields-toggle sort">' . $item_name . ' <span class="repeat-index">' . ($i + 1) . '</span><i class="fa fa-caret-up"></i></h4>';
			echo '<div class="fields-wrapper">';
				echo '<div class="fields-set">';
					foreach ( $repeat_fields as $repeat_field ) {
						$this_item = $repeat_field['name'];
						$this_value = ( !empty($row) && isset($row[$this_item]) ) ? esc_attr($row[$this_item]) : '';
						echo '<label><span>' . $repeat_field['title'] . '</span>';
						// Swith through possible field types
						switch ( $repeat_field['type'] ) {
							case 'text':
								echo '<input type="text" name="' . $fieldname . '['.$i.']['. $repeat_field['name'] .']" id="' . $fieldname . '" value="' . $this_value . '" size="30" />';		
								break;
							case 'textarea':
								echo '<textarea name="' . $fieldname . '['.$i.']['. $repeat_field['name'] .']" id="' . $fieldname . '" size="30" />' . $this_value . '</textarea>';
								break;
							case 'checkbox':
								?>
								<input type="checkbox" name="<?php echo $fieldname . '['.$i.']['. $repeat_field['name'] .']'; ?>" id="<?php echo $fieldname; ?>" <?php checked( $this_value == 'on' ); ?> />
								<?php
								break;
						}
						if ( $repeat_field['description'] ) { ?>
						<span class="repeatable-item-desc"><em><?php echo $repeat_field['description']; ?></em></span>
						<?php }
						echo '</label>';
					}
					echo '<a class="repeatable-remove" href="#">' . esc_html__('Remove this item', 'quadro') . '</a>';
				echo '</div><!-- .fields-set -->';
				echo '</div><!-- .fields-wrapper -->';
			echo '</li>';
			$i++;
		}

		echo '</ul>';
		echo '<a class="repeatable-add button" href="#">+ ' . $option['repeat-item'] . '</a>';
	}
	// Output font form field markup
	else if ( 'font' == $fieldtype ) {
		$hide_option = '';
		if ( isset($option['hide']) && $option['hide'] == true ) {
			$hide_option .= 'data-hide="hideme" ';
			$hide_option .= 'data-if=' . json_encode( $option['conditions'] );
		}
		echo '<div ' . $hide_option . '>';
		$valid_fonts = array();
		$valid_fonts = quadro_get_valid_fontslist(); ?>
		<select name="<?php echo $fieldname; ?>">
		<?php foreach ( $valid_fonts as $valid_font ) { ?>
			<option <?php selected( $valid_font['css-name'] . '|' . $valid_font['font-family'] == $quadro_options[$optionname] ); ?> value="<?php echo esc_attr( $valid_font['css-name'] ) . '|' . esc_attr( $valid_font['font-family'] ); ?>"><?php echo $valid_font['font-name']; ?></option>
		<?php } ?>
		</select>
		<?php
	}
	// Output number input form field markup
	else if ( 'number' == $fieldtype ) {
		?>
		<input type="number" name="<?php echo $fieldname; ?>" min="<?php echo $option['min']; ?>" max="<?php echo $option['max']; ?>" value="<?php echo wp_filter_nohtml_kses( $quadro_options[$optionname] ); ?>" />
		<?php
	}
	// Output greyed out input form field markup
	else if ( 'greyed-out' == $fieldtype ) {
		$pro_desc 	= $option['pro_desc'];
		$pro_url 	= $option['pro_url'];
		?>
		<p id="<?php echo $fieldname; ?>" class="greyed-out-option">
			<a href="<?php echo $pro_url; ?>"><?php echo $pro_desc; ?></a>
		</p>
		<?php
	}
	// Output radio button form field markup
	else if ( 'skin_select' == $fieldtype ) {
		$valid_options = array();
		$valid_options = $option['valid_options'];
		foreach ( $valid_options as $valid_option ) {
			?>
			<label>
			<input type="radio" name="<?php echo $fieldname; ?>" class="skin-select-radio" <?php checked( $valid_option['name'] == $quadro_options[$optionname] ); ?> value="<?php echo $valid_option['name']; ?>" />
			<input type="hidden" id="<?php echo $valid_option['name']; ?>-skin" value='<?php echo json_encode($valid_option['settings']); /* 100% safe - ignore theme check nag */ ?>' />
			<span>
			<?php echo $valid_option['title']; ?>
			<?php if ( $valid_option['description'] ) { ?>
				<span style="padding-left:5px;"><em><?php echo $valid_option['description']; ?></em></span>
			<?php } ?>
			</span>
			</label>
			<br />
			<?php
		}
		echo '<input type="hidden" id="skin_confirm" value="' . esc_html__('By clicking OK you will replace some of your theme options. Are you sure?', 'quadro') . '" />';
		echo '<a href="#" id="quadro_skin_button" class="button" title="' . esc_html__('Set Skin', 'quadro') . '">' . esc_html__('Set Skin', 'quadro') . '</a>';
	}
	// Output backup and restore options markup
	else if ( 'backup_options' == $fieldtype ) {
		global $quadro_options_group;
		$backup = get_option( $quadro_options_group . '_backup' );
		
		if(!isset($backup['backup_log'])) {
			$log = esc_html__('No backups yet', 'quadro');
		} else {
			$log = $backup['backup_log'];
		}
		
		$output = '';
		$output .= '<div class="backup-box">';
		$output .= '<input type="hidden" id="backup_confirm" value="' . esc_html__('Click OK to backup your current saved options.', 'quadro') . '" />';
		$output .= '<input type="hidden" id="restore_confirm" value="' . esc_html__('Warning: All of your current saved options will be replaced with the data from your last backup! Proceed?', 'quadro') . '" />';
		$output .= '<p><strong>'. esc_html__('Last Backup : ', 'quadro').'<span class="backup-log">'.$log.'</span></strong></p></div>'."\n";
		$output .= '<a href="#" id="quadro_backup_button" class="button" title="' . esc_html__('Backup Options', 'quadro') . '">' . esc_html__('Backup Options', 'quadro') . '</a>';
		$output .= '<a href="#" id="quadro_restore_button" class="button" title="' . esc_html__('Restore Options', 'quadro') . '">' . esc_html__('Restore Options', 'quadro') . '</a>';
		$output .= '</div>';

		echo $output;

	}
	// Output transfer options markup
	else if ( 'transfer_options' == $fieldtype ) {		
		// Get Theme Options
		$data = quadro_get_options();
		echo '<input type="hidden" id="import_confirm" value="' . esc_html__('Click OK to import these options. All your theme options will be replaced!', 'quadro') . '" />';
		echo '<textarea id="export_data" rows="8">'.urlencode(serialize($data)).'</textarea>'."\n";
		echo '<a href="#" id="quadro_select_button" class="button" title="' . esc_html__('Select All', 'quadro') . '">' . esc_html__('Select All', 'quadro') . '</a>';
		echo '<a href="#" id="quadro_import_button" class="button" title="' . esc_html__('Import Options', 'quadro') . '">' . esc_html__('Import Options', 'quadro') . '</a>';
	}
	// Output dummy content import options markup
	else if ( 'dummy_import' == $fieldtype ) {
		echo '<input type="hidden" id="dcontent_confirm" value="' . esc_html__('Click OK to import Dummy Content to your WordPress install. Several WP options and all your theme options will be replaced!', 'quadro') . '" />';
		echo '<input type="hidden" id="dcontent_success" value="' . esc_html__('Dummy Content successfully imported. Page needs to be refreshed.', 'quadro') . '" />';
		echo '<div class="loader-icon" style="display: none;"><i class="fa fa-spinner fa-spin"></i> ' . esc_html__('This may take a while. Please, don\'t refresh your browser till you get a nice message saying it went ok. ;)', 'quadro') . '</div>';
		echo '<a href="#" id="quadro_dcontent_button" class="button" title="' . esc_html__('Import Dummy Content', 'quadro') . '">' . esc_html__('Import Dummy Content', 'quadro') . '</a>';
	}
	// Output NEW dummy content import options markup
	else if ( 'dummy_importx' == $fieldtype ) {
		echo '<div class="loader-icon" style="display: none;"><i class="fa fa-spinner fa-spin"></i> ' . esc_html__('This may take a while. Please, don\'t refresh your browser till you get a nice message saying it went ok. ;)', 'quadro') . '</div>';
		echo '<a href="#" id="quadro_dcontentx_button" class="button button-primary" title="' . esc_html__('Open Demo Content Importer', 'quadro') . '">' . esc_html__('Open Demo Content Importer', 'quadro') . '</a>';
		qi_dcontent_lightbox();
	}
	// Output activate Typekit markup
	else if ( 'typekit_activate' == $fieldtype ) {
		echo '<a href="#" id="quadro_typekit_activate" class="button" title="' . esc_html__('Activate Typekit', 'quadro') . '">' . esc_html__('Activate Typekit', 'quadro') . '</a>';
	}
	// Output user check markup
	else if ( 'usercheck' == $fieldtype ) {
		echo '<a href="#" id="quadro_user_check" class="button" title="' . esc_html__('Check Now', 'quadro') . '">' . esc_html__('Check Now', 'quadro') . '</a>';
	}
	// Output Portfolio Transients Delete markup
	else if ( 'portf-transients-del' == $fieldtype ) {
		echo '<a href="#" id="quadro_portf_transients_delete_button" class="button" title="' . esc_html__('Refresh Transients', 'quadro') . '">' . esc_html__('Refresh Transients', 'quadro') . '</a>';
	}

	// Output the setting description
	?>
	<span class="description"><?php echo $optiondescription; ?></span>
	<?php
}


/**
 * Ajax Theme Options Functions
 * Adapted from: https://github.com/syamilmj/Options-Framework
 */
function quadro_ajax_callback()
{

	$nonce = $_POST['security'];

	if (! wp_verify_nonce($nonce, 'quadro_ajax_nonce') ) die('-1');

	// Get Theme Options
	$current_options = quadro_get_options();

	$call_type = $_POST['type'];

	if ( $call_type == 'backup_options' ) {

		$backup = $current_options;
		$backup['backup_log'] = date("D, j M Y G:i:s");

		global $quadro_options_group;
		update_option( $quadro_options_group . '_backup', $backup );

		die('1');
	}
	elseif ( $call_type == 'restore_options' ) {

		global $quadro_options_group;
		$data = get_option($quadro_options_group . '_backup');
		// Set value to let the validation callback know
		// it is alright to go through all the options.
		$data['restore_next'] = true;
		update_option( $quadro_options_group, $data );

		die('1');
	}
	elseif ( $call_type == 'import_options' ) {

		$data = $_POST['data'];
		$data = unserialize(urldecode($data));
		// Set value to let the validation callback know
		// it is alright to go through all the options.
		$data['restore_next'] = true;
		global $quadro_options_group;
		update_option( $quadro_options_group, $data );

		die('1');
	}
	elseif ( $call_type == 'dcontent_import' ) {

		// Include Dummy Content Importer functions
		require( get_template_directory() . '/inc/qi-framework/dcontent_importer.php' );
		// Run Dummy Content Import functions
		quadro_dcontent_import();

		die('1');

	}
	elseif ( $call_type == 'typekit_activate' ) {

		$check_url = 'http://quadroideas.com/users-api-typekit';
		$send_for_check = array(
			'body' => array(
				'item_slug' 	=> get_option('template'),
				'username' 		=> $current_options['quadro_username'],
				'userpass' 		=> $current_options['quadro_userpass'],
				'userlicense' 	=> $current_options['quadro_userlicense'],
			)
		);
		$raw_response = wp_remote_post($check_url, $send_for_check);
		if ( !is_wp_error($raw_response) ) {
			// unserialize response
			$raw_response['body'] = json_decode( $raw_response['body'] );
			// Print the proper response now
			if ( $raw_response['body']->error_msg == '' ) {
				// populate Typekit options
				$current_options['typekit_kit_id'] 				= wp_kses( $raw_response['body']->typekit_kit_id, '' );
				$current_options['typekit_kit_headings_family'] = wp_kses( $raw_response['body']->headings_font, '' );
				$current_options['typekit_kit_body_family'] 	= wp_kses( $raw_response['body']->body_font, '' );
				// Set value to let the validation callback know
				// it is alright to go through all the options.
				$current_options['restore_next'] = true;
				// save options
				global $quadro_options_group;
				update_option( $quadro_options_group, $current_options );
				// print success message
				echo esc_html__( 'Typekit kit activated on theme! Please refresh this page before saving other options. For added beauty, we recommend setting the body size on 20px.', 'quadro' );
			} else {
				// print error message
				echo $raw_response['body']->error_msg;
			}
		} else {
			// If there was a WP error, print it
			echo $raw_response->get_error_message();
		}

		die();

	}
	elseif ( $call_type == 'user_check' ) {

		$check_url = 'http://quadroideas.com/users-api-check';
		$send_for_check = array(
			'body' => array(
				'item_slug' 	=> get_option('template'),
				'username' 		=> esc_attr( $_POST['username'] ),
				'userpass' 		=> esc_attr( $_POST['userpass'] ),
				'license' 		=> esc_attr( $_POST['license'] ),
			)
		);
		$raw_response = wp_remote_post($check_url, $send_for_check);
		if ( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ) {
			// Print the proper response now
			if ( $raw_response['body'] == 'ok' ) {
				echo esc_html__('You theme was sucesfully verified.', 'quadro');
			} else {
				echo $raw_response['body'];
			}
		} else {
			// If there was a WP error, print it
			echo $raw_response->get_error_message();
		}

		die();

	}
	elseif ( $call_type == 'portfolio_transients_delete' ) {

		global $wpdb;
		// Delete Portfolio Transients
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_qi_portf_item_%'" );
		$wpdb->query( "DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_timeout_portf_item_%'" );
		die('1');

	}

	die();
}
add_action('wp_ajax_quadro_ajax_options_action', 'quadro_ajax_callback');


/**
 * Demo Content Importer Lightbox
 */
function qi_dcontent_lightbox() {
	// Bring Available Demo Content Packs
	$dcontent_packs = qi_available_demo_packs();
	// Build Demo Content Picker
	?>
	<div id="dcontent-selector" style="display: none;">
		<div class="dcontent-wrapper">
			<h2><?php esc_html_e('Browse available demo content packs', 'quadro'); ?></h2>
			<ul class="dcontent-packs">
				<?php foreach ( $dcontent_packs as $pack ) {
					echo '<li class="dcontent-pack">';
						echo '<a href="#" class="dcontent-view-details dcontent-image-link" data-pack="' . $pack['slug'] . '"><img src="' . get_template_directory_uri() . '/inc/dcontent/' . $pack['path'] . $pack['thumbs'][0] . '"></a>';
						echo '<h4><a href="#" class="dcontent-view-details" data-pack="' . $pack['slug'] . '">' . $pack['name'] . '</a></h4>';
						echo '<a href="#" class="dcontent-view-details dcontent-link" data-pack="' . $pack['slug'] . '">' . esc_html__('View Details', 'quadro') . '</a>';
						echo '<a href="' . $pack['url'] . '" class="dcontent-demo-link" target="_blank">' . esc_html__('View Online Demo', 'quadro') . '</a>';
					echo '</li>';
				} ?>
			</ul>
			<div class="dcontent-pack-details dcontent-details-hidden"></div>
		</div>
	</div>
	<?php
}


/**
 * Ajax Demo Content Import Functions
 * Adapted from: https://github.com/syamilmj/Options-Framework
 */
function quadro_ajax_dcontent() {
	
	// Check nonce
	$nonce = $_POST['security'];
	if (! wp_verify_nonce($nonce, 'quadro_ajax_nonce') ) die('-1');

	$call_type = esc_attr( $_POST['type'] );

	if ( $call_type == 'dcontent_details' ) {

		// Bring Available Demo Content Packs
		$dcontent_packs = qi_available_demo_packs();
		// Retrieve selected pack
		$pack = esc_attr( $_POST['pack'] );
		echo '<a href="#" class="backto-dcontent">' . esc_html__('Back to Packs', 'quadro') . '</a>';
		echo '<div class="dcontent-text">';
		echo '<h3>' . $dcontent_packs[$pack]['name'] . '</h3>';
		echo '<p class="dcontent-desc">' . $dcontent_packs[$pack]['desc'] . '</p>';
		echo '<p class="dcontent-tags">' . $dcontent_packs[$pack]['tags'] . '</p>';
		echo '<p class="dcontent-plugins"><span>Plugins being used:</span> ';
		$plugins_used = '';
		foreach ($dcontent_packs[$pack]['plugins'] as $key => $value) {
			 $plugins_used .= $value . ', ';
		}
		echo rtrim( $plugins_used, ', ' );
		echo '</p>';
		echo '<small>' . esc_html__( '* Images are not included', 'quadro' ) . '</small>';
		echo '<div>';
		echo '<a href="' . $dcontent_packs[$pack]['url'] . '" class="dcontent-demo-link" target="_blank">' . esc_html__('View Online Demo', 'quadro') . '</a>';
		echo '<a href="#" class="dcontent-install-pack" data-pack="' . $dcontent_packs[$pack]['slug'] . '">' . esc_html__('Install This Pack', 'quadro') . '</a>';
		echo '<i class="fa fa-cog fa-spin fa-2x fa-fw dpack-loader" style="display: none;"></i>';
		echo '</div>';
		echo '</div>';
		echo '<div class="dcontent-gallery">';
		echo '<div class="dcontent-thumb-screener">';
			echo '<img src="' . get_template_directory_uri() . '/inc/dcontent/' . $dcontent_packs[$pack]['path'] . $dcontent_packs[$pack]['thumbs'][0] . '">';
		echo '</div>';
		echo '<ul class="dcontent-thumbs">';
		foreach ( $dcontent_packs[$pack]['thumbs'] as $thumb ) {
			echo '<img src="' . get_template_directory_uri() . '/inc/dcontent/' . $dcontent_packs[$pack]['path'] . $thumb . '">';
		}
		echo '</ul>';
		echo '</div>';

		die();
	}

	elseif ( $call_type == 'dcontent_importx' ) {

		// Include Dummy Content Importer functions
		require( get_template_directory() . '/inc/qi-framework/dcontent_importerx.php' );
		
		// Run Dummy Content Import functions
		quadro_dcontent_importx( esc_attr( $_POST['pack'] ) );

		die('1');

	}

	die();

}
add_action('wp_ajax_quadro_ajax_dcontent', 'quadro_ajax_dcontent');


?>