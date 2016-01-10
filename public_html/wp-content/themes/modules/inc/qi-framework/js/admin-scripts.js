jQuery(document).ready(function($){

	"use strict";

	/**
	 * Helper function to get URL parameters by name
	 * http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
	 */
	function getParameterByName(name) {
		var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
	}


	/**
	 * Adding functionality for Upload input boxes in Custom Fields and Options
	 * New Code (new media manager)
	 * 
	 * IMPORTANT: Needs wp_enqueue_media(); anywhere in the theme to work in other
	 * places than regular post editor. We are calling it as soon as we initiate the
	 * QI Framework.
	 *
	 * Credit to: https://github.com/thomasgriffin/New-Media-Image-Uploader/blob/master/js/media.js
	 */
	
	// Prepare the variable that holds our custom media manager
	var qiMedia, qiMediaGallery;
  	
  	// For simple uploads
  	jQuery(document).on('click', '.upload_file_button', function() {

		var thisButton 	= jQuery(this),
  			uploadID 	= thisButton.prev('input');
		
		qiMedia = wp.media.frames.qiMedia = wp.media({
			frame: 'select',
			title: adminscripts_localized.mediaTitle,
			button: {
				text: adminscripts_localized.mediaButton
			},
		});

		qiMedia.on('select', function(){
			// Grab our attachment selection and construct a JSON representation of the model.
			var media_attachment = qiMedia.state().get('selection').first().toJSON();
			// Send the attachment URL to our custom input field via jQuery.
			uploadID.val( media_attachment.url );
		});
		qiMedia.open();
		return false;
	
	});

  	// For Gallery Uploads
	jQuery(document).on('click', '.gallery_pick_button', function() {

		var thisButton 	= jQuery(this),
  			uploadID 	= thisButton.prev('input');
		
		qiMediaGallery = wp.media.frames.qiMediaGallery = wp.media({
			frame: 'post',
			title: adminscripts_localized.mediaTitle,
			button: {
				text: adminscripts_localized.mediaButton
			},
		});

		qiMediaGallery.on( 'update', function(selection){
			// Send the gallery shortcode to our custom input field via jQuery.
			uploadID.val( wp.media.gallery.shortcode( selection ).string() );
		});
		qiMediaGallery.open();
		return false;
	
	});


	/**
	 * Adding functionality for repeatable input boxes
	 */

	jQuery(document).on('click', '.repeatable-add', function(e){
		var thisRepeat = jQuery(this),
			field = thisRepeat.closest('td').find('.custom_repeatable li:last').clone(true),
			fieldLocation = thisRepeat.closest('td').find('.custom_repeatable li:last');
		// Reset new item, and increase index number for inputs
		jQuery('input:not([type=radio]), textarea, select', field).val('').attr('name', function(index, name) {
			if (name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		jQuery('input:radio', field).attr('name', function(index, name) {
			if (name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		// Increase textarea ID number for WYSIWYG editors
		jQuery('.wp-editor-area', field).attr('id', function(index, id) {
			if (id) {
				return id.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		// Prepare new ID and name for wp_editor
		var newEditorID = jQuery('.wp-editor-area', field).attr('id'),
		 	newEditorName = jQuery('.wp-editor-area', field).attr('name');
		// Remove current editor and put a textarea instead
		jQuery('.wp-editor-area.repeatable-editor', field).replaceWith('');
		jQuery('.mce-tinymce.mce-container.mce-panel', field).replaceWith('<textarea class="wp-editor-area repeatable-editor" id="'+newEditorID+'" name="'+newEditorName+'"></textarea>');
		// Increase new item title index
		var index = parseInt( jQuery('.repeat-index', field).html() );
		jQuery('.repeat-index', field).html(++index);
		// Insert newly added item in DOM
		field.insertAfter(fieldLocation, jQuery(this).closest('td'));
		// Enable Repeatable Editors
		tinyMCE.init({
			selector: 'textarea.repeatable-editor',
			mode: 'specific_textareas',
			content_css: adminscripts_localized.includes_url + 'js/tinymce/skins/wordpress/wp-content.css',
			menubar : false,
			plugins: "textcolor",
			toolbar1: "styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | undo redo",
		});
		
		return false;
	});


	jQuery(document).on('click', '.repeatable-remove', function(e){
		if ( jQuery('.custom_repeatable .fields-set').length != 1 ) {
			jQuery(this).parents('li').remove();
		} else {
			// If there is only one set, just clean it up
			jQuery(this).parent().find('input').val('');
		}
		return false;
	});

	// Setting a variable 
	var sortablePrevChecked;

	jQuery('.custom_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort',
		start: function(event, ui) {
			sortablePrevChecked = ui.item.find('input:checked').val();
		},
		update: function(event, ui) {
			// Renumber Array indexes when re ordered
			jQuery(this).data().uiSortable.currentItem.parent().find('.fields-set').each(function(rowIndex){
				jQuery(this).find('input[name], textarea[name], select[name]').each(function(){
					var selectName;
					selectName = jQuery(this).attr('name');
					selectName = selectName.replace(/\[[0-9]+\]/g, '['+rowIndex+']');
					jQuery(this).attr('name',selectName);
				});
			});
			ui.item.find(':radio[value='+sortablePrevChecked+']').prop("checked", true);
		},
	});

	// Enable Fieldset Toggle
	jQuery(document).on('click', '.custom_repeatable .fields-toggle', function(e){
		var thisToggle = jQuery(this);
		thisToggle.next('.fields-wrapper').slideToggle();
		thisToggle.find('i').toggleClass('fa-flip-vertical');
	});
	
	// End repeatable section


	// Enables Color Picker for Admin Options
	jQuery(document).on('click', '.quadropickcolor', function(e){
		var colorPicker = jQuery(this).next('div'),
			input = jQuery(this).prev('input');
		jQuery(colorPicker).farbtastic(input);
		colorPicker.children().show();
		e.preventDefault();
		jQuery(document).mousedown( function() {
			jQuery(colorPicker).children().hide();
			jQuery('#bg-color').trigger('change');
		});
	});


	/**
	 * Post selection and pickers functionality
	 */

	var selTemplate = jQuery('#page_template').val(),
		maybeIntPreview = selTemplate == 'template-modular.php' ? '&qi=internal-preview' : '';

	// Enables Posts Select functionality in custom fields
	jQuery(document).on('click', '.posts-adder', function(e){
		// Grab all selected
		var $selPosts = jQuery(e.target).prev('.posts-picker').find('option:selected'),
			$listContainer = jQuery(e.target).next();
		// Map them and construct icon prefixed li's with Posts' ID as data-id
		$selPosts.map(function(){
			// Get current posts list and check if current post is already there
			var $currentPosts = $listContainer.next().val().split(', ');
			if ( jQuery.inArray( jQuery(this).val(), $currentPosts ) == -1 ) {
				var thisId = jQuery(this).val();
				// If it isn't, add it
				$listContainer.append('<li data-id="' + thisId + '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' + jQuery(this).text() + '</label><span class="qi-mod-action-links"><a href="' + adminscripts_localized.generalPostLink + thisId + maybeIntPreview + '" target="_blank" class="qi-preview-link"><i class="fa fa-eye"></i></a><a href="' + adminscripts_localized.generalEditLink.replace('1', thisId) + '" class="qi-edit-link"><i class="fa fa-pencil"></i></a></span></li>');
			}
		});

		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';
		$listContainer.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		if ( $postsIds !== '' ) {
			$listContainer.next().val($postsIds);
		}
	});

	// Enables Posts Select functionality in custom fields on double click
	jQuery(document).on('dblclick', '.posts-picker option', function(e){
		// Grab all selected + general edit link
		var $selPosts 		= jQuery(e.target),
			$listContainer 	= $selPosts.parent().siblings('ul');
		// Map them and construct icon prefixed li's with Posts' ID as data-id
		$selPosts.map(function(){
			// Get current posts list and check if current post is already there
			var $currentPosts = $listContainer.next().val().split(', ');
			if ( jQuery.inArray( jQuery(this).val(), $currentPosts ) == -1 ) {
				var thisId = jQuery(this).val();
				// If it isn't, add it
				$listContainer.append('<li data-id="' + thisId + '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' + jQuery(this).text() + '</label><span class="qi-mod-action-links"><a href="' + adminscripts_localized.generalPostLink + thisId + maybeIntPreview + '" target="_blank" class="qi-preview-link"><i class="fa fa-eye"></i></a><a href="' + adminscripts_localized.generalEditLink.replace('1', thisId) + '" class="qi-edit-link"><i class="fa fa-pencil"></i></a></span></li>');
			}
		});

		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';
		$listContainer.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		if ( $postsIds != '' ) {
			$listContainer.next().val($postsIds);
		}
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

	// Enables Remover for posts list items
	jQuery(document).on("click", '.remove-post', function(e){
		// Grab parent variable position before we swipe this li out
		var $containerUl = jQuery(this).parents('ul');
		// Remove this Parent li
		jQuery(this).parents('li').remove();
		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';		
		$containerUl.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		$containerUl.next().val($postsIds);
	});


	// Removes empty select boxes when nothing to show
	jQuery('.posts-picker').each(function(){
		if ( ! jQuery(this).find('option').length ) {
			jQuery(this).hide();
			jQuery(this).next('.posts-adder').hide();
		}
	});


	/**
	 * Modules Type Filter in Posts Picker
	 */
	jQuery('.module-type-filter').change(function(){
		var filter = jQuery(this),
			type = filter.find(':selected').attr('class');
		filter.parent().next().find('option').hide();
		filter.parent().next().find('option.qi-type-'+type).fadeIn('fast');
	});

	
	/**
	 * Handles selection boxes appearing when chosing selection methods
	 */
	
	// First, hide the selectors by default and show already chosen selector
	var allSelectors = jQuery('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr');
	
	jQuery('select[id*=_method]').each(function(){
		jQuery(this).parents('tr').siblings('tr').find('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr').hide();
		jQuery(this).parents('tr').siblings('tr').find('.q' + jQuery(this).val() + '-selector').parents('tr').fadeIn();
	})
	// Then, detect change on selection method and show the proper select box
	jQuery(document).on('change', 'select[id*=_method]', function(){
		jQuery(this).parents('tr').siblings('tr').find('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr').hide();
		jQuery(this).parents('tr').siblings('tr').find('.q' + jQuery(this).val() + '-selector').parents('tr').fadeIn();
	})


	/**
	 * Little handler to make Greyed Out custom fields take full width space
	 */
	jQuery('#quadro_page_greyed_out').parent('td').prev('th').hide();


	/**
	 * Ajax Function for Options Backup and Restore
	 */
	jQuery('#quadro_backup_button').live('click', function(){
	
		var answerText = jQuery('#backup_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
			var clickedObject = jQuery(this),
				clickedID = jQuery(this).attr('id'),
				nonce = jQuery('#quadro_nonce').val();
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'backup_options',
				security: nonce
			};
						
			jQuery.post(ajaxurl, data, function(response) {				
				//check nonce
				if( response == -1 ) { 
					//failed
				} else {
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
	return false;
					
	}); 
	
	//restore button
	jQuery('#quadro_restore_button').live('click', function(){
	
		var answerText = jQuery('#restore_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ){
					
			var nonce = jQuery('#quadro_nonce').val();
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'restore_options',
				security: nonce
			};
						
			jQuery.post(ajaxurl, data, function(response) {			
				//check nonce
				if( response == -1 ) { 
					//failed
				} else {
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
			});
	
		}
	
	return false;
					
	});


	/**
	 * Select All Btn For Textareas
	 */
	jQuery('#quadro_select_button').live('click', function(){
		jQuery(this).prev('textarea').select();
		return false;
	});


	/**
	 * Ajax Transfer (Import/Export) Option
	 */
	jQuery('#quadro_import_button').live('click', function(){
	
		var answerText = jQuery('#import_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
					
			var nonce = jQuery('#quadro_nonce').val();
			
			var import_data = jQuery('#export_data').val();

			var data = {
				action: 'quadro_ajax_options_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
						
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if ( response == -1 ) { 
					//failed
				} else 	{
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
		return false;
					
	});


	/**
	 * Ajax Dummy Content Install Option
	 */
	jQuery('#quadro_dcontent_button').live('click', function(){
	
		var answerText = jQuery('#dcontent_confirm').val(),
			answerSuccess = jQuery('#dcontent_success').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
					
			var nonce = jQuery('#quadro_nonce').val(),
				loaderImg = jQuery('.loader-icon');
				loaderImg.fadeIn();

			var data = {
				action: 'quadro_ajax_options_action',
				type: 'dcontent_import',
				security: nonce,
			};

			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if ( response == -1 ) { 
					// Failed
					loaderImg.fadeOut();
					alert(adminscripts_localized.importFail);
				} else 	{
					loaderImg.fadeOut(function(){
						var answerSuccessResp = confirm(answerSuccess);
						if (answerSuccessResp){
							window.setTimeout(function(){
								location.reload();
							}, 1000);
						}
					});
				}
			});
			
		}
		
		return false;
					
	});


	/**
	 * NEW Ajax Demo Content Install Option
	 */
	jQuery('#quadro_dcontentx_button').live('click', function(){
					
		var thisWrapper = jQuery('.dcontent-wrapper');
		jQuery.colorbox({
			width: '85%',
			height: '85%',
			close: '<i class="fa fa-close"></i>',
			inline: true,
			href: thisWrapper,
			onComplete: function(){},
			onCleanup: function(){},
		});
		
		return false;
					
	});


	/**
	 * Demo Content Pack Details Preview
	 */
	jQuery('.dcontent-view-details').live('click', function(){
		
		jQuery(this).parents('.dcontent-pack').addClass('selected-pack').siblings().removeClass('selected-pack');

		var detailsWrapper = jQuery('.dcontent-pack-details'),
			nonce = jQuery('#quadro_nonce').val(),
			data = {
				action: 'quadro_ajax_dcontent',
				type: 'dcontent_details',
				pack: jQuery(this).data('pack'),
				security: nonce,
			};
		
		jQuery.post(ajaxurl, data, function(response) {
			//check nonce
			if ( response != -1 ) {
				jQuery('.dcontent-packs').addClass('packs-view-small');
				detailsWrapper.html(response).removeClass('dcontent-details-hidden').addClass('dcontent-details-shown');
				jQuery('#cboxLoadedContent').animate({scrollTop: 0}, 500);
			}
		});
		
		return false;
					
	});


	/**
	 * Demo Content Pack Thumbs Previewer
	 */
	jQuery('.dcontent-thumbs img').live('click', function(){
		var thisImg = jQuery(this),
			selImg = thisImg.clone();
		thisImg.addClass('selected-thumb').siblings().removeClass('selected-thumb');
		jQuery('.dcontent-thumb-screener').html(selImg);
	});


	/**
	 * Back to Demo Content Pack Button
	 */
	jQuery('.backto-dcontent').live('click', function(){
		jQuery('.dcontent-pack-details').html('').toggleClass('dcontent-details-hidden dcontent-details-shown');
		jQuery('.dcontent-packs').removeClass('packs-view-small');
		jQuery('.dcontent-pack').removeClass('selected-pack');

		return false;
	});


	/**
	 * Demo Content Import AJAX Call
	 */
	jQuery('.dcontent-install-pack').live('click', function(){
	
		var answer = confirm(adminscripts_localized.importConfirm + '\n\n' + adminscripts_localized.importPlugins );
		
		if ( answer ) {

			var nonce = jQuery('#quadro_nonce').val(),
				loaderIcon = jQuery('.dpack-loader');

				loaderIcon.fadeIn();

			var data = {
				action: 'quadro_ajax_dcontent',
				type: 'dcontent_importx',
				pack: jQuery(this).data('pack'),
				security: nonce,
			};

			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if ( response == -1 ) { 
					// Failed
					loaderIcon.fadeOut();
					alert(adminscripts_localized.importFail);
				} else 	{
					loaderIcon.fadeOut(function(){
						var answerSuccessResp = confirm(adminscripts_localized.importSuccess);
						if (answerSuccessResp){
							window.setTimeout(function(){
								location.reload();
							}, 1000);
						}
					});
				}
			});
			
		}
		
		return false;
					
	});


	/**
	 * Ajax Function for QuadroIdeas.com Typekit Activation
	 */
	jQuery('#quadro_typekit_activate').live('click', function(){
		
		var nonce = jQuery('#quadro_nonce').val();

		// make request
		var data = {
			action: 'quadro_ajax_options_action',
			type: 'typekit_activate',
			security: nonce
		};
					
		jQuery.post(ajaxurl, data, function(response) {				
			alert(response);
		});
		
		return false;
					
	});


	/**
	 * Ajax Function for QuadroIdeas.com User check
	 */
	jQuery('#quadro_user_check').live('click', function(){
		
		var nonce = jQuery('#quadro_nonce').val(),
			lic_username = jQuery('input[name="quadro_modules_options[quadro_username]"]').val(),
			lic_password = jQuery('input[name="quadro_modules_options[quadro_userpass]"]').val(),
			lic_license = jQuery('input[name="quadro_modules_options[quadro_userlicense]"]').val();

		// highlight empty fields and return false
		if ( lic_username == '' ) jQuery('input[name="quadro_modules_options[quadro_username]"]').addClass('opts-incomplete-field');
		if ( lic_password == '' ) jQuery('input[name="quadro_modules_options[quadro_userpass]"]').addClass('opts-incomplete-field');
		// if ( lic_license == '' ) jQuery('input[name="quadro_modules_options[quadro_userlicense]"]').addClass('opts-incomplete-field');
		
		if ( jQuery('.opts-incomplete-field').length ) {
			jQuery('.opts-incomplete-field').css({ backgroundColor: "#f3f37e" }).after('<small class="incomplete-notice"> Oops! This field cannot be empty.</small><br />');
			return false;
		}
	
		var data = {
			action: 'quadro_ajax_options_action',
			type: 'user_check',
			username: lic_username,
			userpass: lic_password,
			license: lic_license,
			security: nonce
		};
					
		jQuery.post(ajaxurl, data, function(response) {				
			alert(response);
		});
		
	return false;
					
	});


	// Remove "incomplete fields" notice when fields get populated
	jQuery(document).on( 'keyup', '.opts-incomplete-field', function(){
		jQuery(this).removeClass('opts-incomplete-field').css({ backgroundColor: "#fff" }).next('.incomplete-notice').remove();
	});


	/**
	 * Ajax Portfolio Transients Delete Option
	 */
	jQuery('#quadro_portf_transients_delete_button').live('click', function(){
	
		var nonce = jQuery('#quadro_nonce').val();
		var data = {
			action: 'quadro_ajax_options_action',
			type: 'portfolio_transients_delete',
			security: nonce,
		};
					
		jQuery.post(ajaxurl, data, function(response) {
			//check nonce
			if ( response == -1 ) { 
				//failed
			} else 	{
				alert(adminscripts_localized.portfTransientsRefreshed);
			}
		});
		
		return false;
					
	});


	/**
	 * Ajax Set Skin Option
	 */
	jQuery('#quadro_skin_button').live('click', function(){

		var answerText = jQuery('#skin_confirm').val(),
			answer = confirm(answerText);
		
		if (answer){
	
			var nonce = jQuery('#quadro_nonce').val();

			var sel_option = jQuery('.skin-select-radio:checked').val();
			
			var selected_skin = jQuery.parseJSON(jQuery('#'+sel_option+'-skin').val());
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'set_skin',
				security: nonce,
				data: selected_skin
			};
						
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if(response==-1){ 
					//failed
				} else 	{
					alert(response);
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
		return false;
					
	});


	// Show or Hide Modules Metaboxes depending on Selected Modules
	// Add Module type to body class
	// ************************************************************
	if ( jQuery('#mod-type-metabox').length ) {
		
		var moduleSelector = jQuery('#quadro_mod_type');

		// First, get selected type on loading and display metabox
		var selType = moduleSelector.val();
		// Show or Hide Metabox
		jQuery('#mod-' + selType + '-qi-type-metabox').addClass('selected-type-metabox');
		// Add module class to body
		jQuery('body').addClass('qimodule-' + selType);

		// Reset Shown Module on change
		moduleSelector.change(function(){
			var selType = moduleSelector.val();
			// Show or Hide Metabox
			jQuery('.selected-type-metabox').fadeOut().removeClass('selected-type-metabox');
			jQuery('#mod-' + selType + '-qi-type-metabox').fadeIn().addClass('selected-type-metabox').removeClass('tab-hidden');
			// Add module class to body
			jQuery('body').alterClass('qimodule-*').addClass('qimodule-' + selType);
			// Scroll to editor if Canvas selected
			if ( selType == 'canvas' ) {
				// jQuery('html, body').animate({scrollTop: 0}, 600);
				jQuery('html, body').animate({ scrollTop: jQuery('#postdivrich').offset().top-20 }, 800);
			}
		});

	}


	// Show or Hide Specific Theme Options depending on selected theme options
	// ************************************************************
	
	// Define operators for posible conditions
	var operators = {
		'==': function( a, b ){ return a == b; },
		'!=': function( a, b ){ return a != b; },
		'<=': function( a, b ){ return a <= b; },
		'>=': function( a, b ){ return a >= b; },
		'<': function( a, b ){ return a < b; },
		'>': function( a, b ){ return a > b; },
	};

	function showHideFields() {
		// Function to loop through all hidden fields and show/hide if conditions met
		jQuery('*[data-hide="hideme"]').each(function(){
			var showConditions = jQuery(this).data('if'),
				conditionsCount = showConditions.length;

			// jQuery.each(showConditions, function(index, item) {
			// 	var op = typeof item['operator'] != 'undefined' ? item['operator'] : '==';
			// 	// if ( jQuery('[name$="['+item['id']+']"]'+item['type']).val() == item['val'] ) conditionsCount = conditionsCount - 1;
			// 	if ( operators[op]( jQuery('[name$="['+item['id']+']"]'+item['type']).val(), item['val'] ) ) conditionsCount = conditionsCount - 1;
			// });

			jQuery.each(showConditions, function(index, item) {
                // go for combined conditions first
                if ( typeof item['combined'] != 'undefined' && item['combined'] == 'true' ) {
                    // grab recursive conditions array, count it and define operator
                    var combination = item['combination'],
                    	combConditionsCount = combination.length,
                    	combAddition = 0,
                    	combOperator = item['combOperator'] == 'or' ? 1 : combConditionsCount;
                    // go through each recursive conditions array
                    jQuery.each(combination, function(combIndex, combItem) {
                    	var op = typeof combItem['operator'] != 'undefined' ? combItem['operator'] : '==';
                    	if ( operators[op]( jQuery('[name$="['+combItem['id']+']"]'+combItem['type']).val(), combItem['val'] ) ) combAddition = combAddition + 1;
                    });
                    // define result
                    if ( combAddition >= combOperator	 ) conditionsCount = conditionsCount - 1;
                } else {
                    var op = typeof item['operator'] != 'undefined' ? item['operator'] : '==';
                    if ( operators[op]( jQuery('[name$="['+item['id']+']"]'+item['type']).val(), item['val'] ) ) conditionsCount = conditionsCount - 1;
                }
            });

			// We substracted 1 per each met condition, so we'll
			// show the option field if the count has reached 0.
			// Hide it, if the count isn't 0.
			if ( conditionsCount == 0 ) {
				jQuery(this).parents('tr').fadeIn('fast');
			} else {
				jQuery(this).parents('tr').hide();
			}
		});
	}

	// Show or hide fields if conditions met
	showHideFields();

	// Trigger conditions check once form changes
	jQuery('#quadro_options_form').change(function(){
		showHideFields();
	})


	// Show or Hide Template Metaboxes depending on Selected Template
	// ************************************************************
	if ( jQuery('#page_template').length ) {
		
		// First, get selected type on loading and display metabox
		var selTemplate = jQuery('#page_template').val();
		// Hide editor for Modular Template
		if ( selTemplate == 'template-modular.php' ) jQuery('#postdivrich').hide();
		// Present according option metaboxes
		selTemplate = selTemplate.substring(selTemplate.indexOf('-') +1).split('.');
		jQuery('#' + selTemplate[0] + '-qi-template-metabox').addClass('selected-template-metabox');

		// Reset Shown Module on change
		jQuery("#page_template").live('change',function(){
			var selTemplate = jQuery(this).val();
			// Hide or show editor for Modular Template
			if ( selTemplate == 'template-modular.php' ) {
				jQuery('#postdivrich').hide();
			} else {
				jQuery('#postdivrich').show();
				jQuery('#modular-qi-template-metabox').hide();
			}
			// Present according option metaboxes
			selTemplate = selTemplate.substring(selTemplate.indexOf('-') +1).split('.');
			jQuery('.selected-template-metabox').removeClass('selected-template-metabox');
			jQuery('#' + selTemplate[0] + '-qi-template-metabox').addClass('selected-template-metabox');
		});

	}


	// Togles Pattern Selector display in Custom Fields
	jQuery('#pattern-picker-opener').click(function(){
		jQuery('#pattern-selector').toggle();
	});

	
	// Opens Colorbox Lightbox for Icon Picker
	jQuery('.icon-picker-opener').live('click', function() { 
		var thisHandler = jQuery(this),
			thisPicker = thisHandler.next().find('.icons-wrapper');
		jQuery.colorbox({
			width: '60%',
			height: '80%',
			close: '<i class="fa fa-close"></i>',
			inline: true,
			href: thisPicker,
			onComplete: function(){
				// Adds focus on icon search when opening icon selector
				jQuery('.icon-search').focus();
			},
			onCleanup: function(){ 
				if ( thisPicker.find('.icon-selector input:checked + i').attr('class') ) {
					// Adds copy of selected icon to Working Fields (input + icon placeholder)
					thisHandler.prev('i').attr('class', 'icon-placeholder ' + thisPicker.find('.icon-selector input:checked + i').attr('class'));
					thisHandler.siblings('input').val(thisPicker.find('.icon-selector input:checked + i').attr('class'));
				}
			},
		});
	});


	// Enable Icon Picker opening when clicking
	// on selected icon
	jQuery(document).on( 'click', '.icon-placeholder', function(e){
		jQuery(e.target).next('a').click();
	});


	// Make the icon picker close on double clicks over icons
	jQuery(document).on( 'dblclick', '.icon-selector i', function(e){
		jQuery.colorbox.close();
	});
	

	// Responds to Icon Search for Icon Picker
	jQuery(document).on( 'keyup', '.icon-search', function(e){
		var iSearcher	= jQuery(this),
			iSearch 	= iSearcher.val(),
			iPicker 	= iSearcher.parent().next('.icon-selector');
		// Hide all labels to begin with
		iPicker.find('h3, label').hide();
		// Show Icons which contain the searched terms
		var iShow = iPicker.find('i[class*="' + iSearch + '"]');
		iShow.parent().show();
		iShow.parent().parent().prev('h3').show();
		// Show all if search empty
		if ( iSearch == '' ) iPicker.find('h3, label').show();
	});


	/**
	 * Adds Portfolio Sortable Functionality in backend
	 */
	jQuery('#sortable-table tbody').sortable({
		
		axis: 'y',
		handle: '.draggable',
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		update: function(event, ui) {
		
			var theOrder = jQuery(this).sortable('toArray');

			var data = {
				action: 'quadro_update_portfolio_order',
				postType: jQuery(this).attr('data-post-type'),
				order: theOrder
			};

			jQuery.post(ajaxurl, data);
			
			jQuery('.order-updated').fadeTo('slow', 1).animate({opacity: 1.0}, 600).fadeTo('slow', 0);
			
		}
		
	}).disableSelection();


	// Dismisses Welcome Panel message
	jQuery('.welc-msg-dismiss').click(function(){
		jQuery('#qi-welcome-panel').fadeOut();
		return false;
	});


	/**
	 * Handling Mailchimp Form Option-Cookies to avoid
	 * showing it again after the user has already
	 * submitted the form once successfully.
	 */
	if ( jQuery('#mc_embed_signup').length ) {
		var mcForm = document.getElementById('mce-success-response');
		if( window.addEventListener ) {
			// Normal browsers
			mcForm.addEventListener('DOMSubtreeModified', mailchimpSent, false);
		} else
		if ( window.attachEvent ) {
			// IE
			mcForm.attachEvent('DOMSubtreeModified', mailchimpSent);
		}
	}

	function mailchimpSent() {

		// Store cookie for this user stating it has already
		// submitted the form once successfully
		var nonce = jQuery('#mailchimp_nonce').val();
		var data = {
			action: 'quadro_mailchimp_submit_check',
			security: nonce
		};
		// Call function via ajax
		jQuery.post(ajaxurl, data, function(response) {});
			
	}


	// Adding 'internal-preview' parameter to Modules Preview button
	if ( jQuery('body').hasClass('post-type-quadro_mods') ) {
		if ( jQuery('#preview-action').length ) {
			var	currentPreview = jQuery('#sample-permalink a').attr('href');
			jQuery('#preview-action').before('<a class="preview button" href="' + currentPreview + '?qi=internal-preview" id="module-view">View Module</a>').remove();
			jQuery('#edit-slug-buttons').after('<a class="slug-view-mod" href="' + currentPreview + '?qi=internal-preview" id="module-view">View Module</a>');
			jQuery('#message.updated p a').attr('href', currentPreview + '?qi=internal-preview');
		}
	}


	/**
	 * Adding "Add to Page" & "Duplicate" links to Module Type select metabox
	 */
	jQuery('#mod-type-metabox').find('td').append('<div class="module-helpers"></div><div style="display: none;"><div id="qi-page-adder"></div></div>');
	jQuery('.module-helpers').append('<a href="#qi-page-adder" class="in-mod-addto-page">'+ adminscripts_localized.addThisModule +'</a>');
	jQuery('.module-helpers').append('<a href="admin.php?action=qi_duplicate_post_as_draft&amp;post=' + jQuery('#post_ID').val() + '" class="in-mod-duplicate-link" target="_blank">'+adminscripts_localized.dupThisModule +'</a>');


	/**
	 * Modify add to page button if module already published
	 */
	if ( jQuery('#original_post_status').val() == 'publish' ) {
		jQuery('.in-mod-addto-page').removeClass('in-mod-addto-page').addClass('in-mod-addto-page-publish');
	}


	/**
	 * Ask for module publishing before enabling add to page functionality
	 */
	jQuery(document).on( 'click', '.in-mod-addto-page', function(e){
		e.preventDefault();
		alert(adminscripts_localized.publishFirst);
	});


	/**
	 * Handling "Add this Module to Page"
	 */
	jQuery('.in-mod-addto-page-publish').colorbox({
		width: '60%',
		height: '85%',
		close: '<i class="fa fa-close"></i>',
		inline: true,
		onComplete: function(){
			// Grab previously loaded content if there is one
			var	prevLoaded = jQuery('#already-loaded').val();
			if ( prevLoaded == undefined ) {
				// Run first Ajax function
				var data = { action: 'qi_ajax_module_adder' };
				jQuery.post(ajaxurl, data, function(response) {				
					if( response != -1 ) { 
						jQuery('#qi-page-adder').html(response);
						// Set previously loaded content
						jQuery('#already-loaded').val('loaded');
					}
				});
			}
		},

	});

	jQuery(document).on( 'change', '#qi-modular-pages', function(){
		var data = { 
			action: 'qi_ajax_module_fields', 
			page_id: jQuery(this).val(),
			mod_id: jQuery('#post_ID').val(),
		};
		jQuery.post(ajaxurl, data, function(response) {				
			if( response != -1 ) { 
				jQuery('.qi-page-modules').html(response);
				jQuery('.added-module').fadeIn();
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
		});
	});

	jQuery(document).on( 'click', '#page-mods-save', function(e){
		e.preventDefault();
		jQuery('.saved-mods-receiver').fadeOut();
		var data = { 
			action: 'qi_ajax_module_save', 
			page_id: jQuery('#qi-modular-pages').val(),
			mods_list: jQuery('#modules-to-save').val(),
		};
		jQuery.post(ajaxurl, data, function(response) {				
			if( response != -1 ) { 
				jQuery('.saved-mods-receiver').html(response).fadeIn();
			}
		});
	});


	// Handle Scrolling to anchors in pages
	jQuery(document).on( 'click', '.scroll-to-link', function(){
		var thisLink = jQuery(this);
		if ( thisLink.is('a') ) {
			var target = jQuery( thisLink.attr('href') );
		} else {
			var target = jQuery( thisLink.find('a').attr('href') );
		}
		jQuery('html, body').animate({ scrollTop: target.offset().top - 50
		}, 600, 'swing');
		return false;
	});


	/**
	 * Getting Started Page Tabs
	 */
	jQuery('#gs-tabs-list li').click(function(i){
		jQuery(this).addClass('current').siblings().removeClass('current')
		.parent().next('#started-tabs').find('.gs-tab').removeClass('visible').end()
		.find('#'+ jQuery(this).attr('id') +'-tab').addClass('visible');
		return false;
	});

	// Check URL for 'current-tab' parameter and make specified
	// tab visible if selected (in use at Getting Started Page)
	if ( getParameterByName('page') === 'getting-started' ) {
		var currentTab = getParameterByName('current-tab');
		if ( currentTab !== null && currentTab !== '' ) {
			jQuery('#started-tabs').find('.gs-tab').removeClass('visible').end()
			.find('#'+currentTab+'-tab').addClass('visible');
			jQuery('#gs-tabs-list').find('li').removeClass('current').end()
			.find('#'+currentTab).addClass('current');
		}
	}

	// Getting Started FAQS Back to top links
	jQuery('.theme-faq').append( jQuery('<a class="scroll-to-link back-to-faqs" href="#theme-faqs-list"><i class="fa fa-angle-up"></i> ' + adminscripts_localized.backToTop + '</a>') );

	
});



/**
 * jQuery alterClass plugin
 * https://gist.github.com/peteboere/1517285
 *
 * Remove element classes with wildcard matching. Optionally add classes:
 *   $( '#foo' ).alterClass( 'foo-* bar-*', 'foobar' )
 *
 * Copyright (c) 2011 Pete Boere (the-echoplex.net)
 * Free under terms of the MIT license: http://www.opensource.org/licenses/mit-license.php
 *
 */
(function ( $ ) {
	
$.fn.alterClass = function ( removals, additions ) {
	
	var self = this;
	
	if ( removals.indexOf( '*' ) === -1 ) {
		// Use native jQuery methods if there is no wildcard matching
		self.removeClass( removals );
		return !additions ? self : self.addClass( additions );
	}
 
	var patt = new RegExp( '\\s' + 
			removals.
				replace( /\*/g, '[A-Za-z0-9-_]+' ).
				split( ' ' ).
				join( '\\s|\\s' ) + 
			'\\s', 'g' );
 
	self.each( function ( i, it ) {
		var cn = ' ' + it.className + ' ';
		while ( patt.test( cn ) ) {
			cn = cn.replace( patt, ' ' );
		}
		it.className = $.trim( cn );
	});
 
	return !additions ? self : self.addClass( additions );
};
 
})( jQuery );



/*!
	Colorbox 1.6.0
	license: MIT
	http://www.jacklmoore.com/colorbox
*/
(function(t,e,i){function n(i,n,o){var r=e.createElement(i);return n&&(r.id=Z+n),o&&(r.style.cssText=o),t(r)}function o(){return i.innerHeight?i.innerHeight:t(i).height()}function r(e,i){i!==Object(i)&&(i={}),this.cache={},this.el=e,this.value=function(e){var n;return void 0===this.cache[e]&&(n=t(this.el).attr("data-cbox-"+e),void 0!==n?this.cache[e]=n:void 0!==i[e]?this.cache[e]=i[e]:void 0!==X[e]&&(this.cache[e]=X[e])),this.cache[e]},this.get=function(e){var i=this.value(e);return t.isFunction(i)?i.call(this.el,this):i}}function h(t){var e=W.length,i=(A+t)%e;return 0>i?e+i:i}function a(t,e){return Math.round((/%/.test(t)?("x"===e?E.width():o())/100:1)*parseInt(t,10))}function s(t,e){return t.get("photo")||t.get("photoRegex").test(e)}function l(t,e){return t.get("retinaUrl")&&i.devicePixelRatio>1?e.replace(t.get("photoRegex"),t.get("retinaSuffix")):e}function d(t){"contains"in y[0]&&!y[0].contains(t.target)&&t.target!==v[0]&&(t.stopPropagation(),y.focus())}function c(t){c.str!==t&&(y.add(v).removeClass(c.str).addClass(t),c.str=t)}function g(e){A=0,e&&e!==!1&&"nofollow"!==e?(W=t("."+te).filter(function(){var i=t.data(this,Y),n=new r(this,i);return n.get("rel")===e}),A=W.index(_.el),-1===A&&(W=W.add(_.el),A=W.length-1)):W=t(_.el)}function u(i){t(e).trigger(i),ae.triggerHandler(i)}function f(i){var o;if(!G){if(o=t(i).data(Y),_=new r(i,o),g(_.get("rel")),!$){$=q=!0,c(_.get("className")),y.css({visibility:"hidden",display:"block",opacity:""}),I=n(se,"LoadedContent","width:0; height:0; overflow:hidden; visibility:hidden"),b.css({width:"",height:""}).append(I),j=T.height()+k.height()+b.outerHeight(!0)-b.height(),D=C.width()+H.width()+b.outerWidth(!0)-b.width(),N=I.outerHeight(!0),z=I.outerWidth(!0);var h=a(_.get("initialWidth"),"x"),s=a(_.get("initialHeight"),"y"),l=_.get("maxWidth"),f=_.get("maxHeight");_.w=(l!==!1?Math.min(h,a(l,"x")):h)-z-D,_.h=(f!==!1?Math.min(s,a(f,"y")):s)-N-j,I.css({width:"",height:_.h}),J.position(),u(ee),_.get("onOpen"),O.add(S).hide(),y.focus(),_.get("trapFocus")&&e.addEventListener&&(e.addEventListener("focus",d,!0),ae.one(re,function(){e.removeEventListener("focus",d,!0)})),_.get("returnFocus")&&ae.one(re,function(){t(_.el).focus()})}var p=parseFloat(_.get("opacity"));v.css({opacity:p===p?p:"",cursor:_.get("overlayClose")?"pointer":"",visibility:"visible"}).show(),_.get("closeButton")?B.html(_.get("close")).appendTo(b):B.appendTo("<div/>"),w()}}function p(){y||(V=!1,E=t(i),y=n(se).attr({id:Y,"class":t.support.opacity===!1?Z+"IE":"",role:"dialog",tabindex:"-1"}).hide(),v=n(se,"Overlay").hide(),M=t([n(se,"LoadingOverlay")[0],n(se,"LoadingGraphic")[0]]),x=n(se,"Wrapper"),b=n(se,"Content").append(S=n(se,"Title"),F=n(se,"Current"),P=t('<button type="button"/>').attr({id:Z+"Previous"}),K=t('<button type="button"/>').attr({id:Z+"Next"}),R=n("button","Slideshow"),M),B=t('<button type="button"/>').attr({id:Z+"Close"}),x.append(n(se).append(n(se,"TopLeft"),T=n(se,"TopCenter"),n(se,"TopRight")),n(se,!1,"clear:left").append(C=n(se,"MiddleLeft"),b,H=n(se,"MiddleRight")),n(se,!1,"clear:left").append(n(se,"BottomLeft"),k=n(se,"BottomCenter"),n(se,"BottomRight"))).find("div div").css({"float":"left"}),L=n(se,!1,"position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;"),O=K.add(P).add(F).add(R)),e.body&&!y.parent().length&&t(e.body).append(v,y.append(x,L))}function m(){function i(t){t.which>1||t.shiftKey||t.altKey||t.metaKey||t.ctrlKey||(t.preventDefault(),f(this))}return y?(V||(V=!0,K.click(function(){J.next()}),P.click(function(){J.prev()}),B.click(function(){J.close()}),v.click(function(){_.get("overlayClose")&&J.close()}),t(e).bind("keydown."+Z,function(t){var e=t.keyCode;$&&_.get("escKey")&&27===e&&(t.preventDefault(),J.close()),$&&_.get("arrowKey")&&W[1]&&!t.altKey&&(37===e?(t.preventDefault(),P.click()):39===e&&(t.preventDefault(),K.click()))}),t.isFunction(t.fn.on)?t(e).on("click."+Z,"."+te,i):t("."+te).live("click."+Z,i)),!0):!1}function w(){var e,o,r,h=J.prep,d=++le;if(q=!0,U=!1,u(he),u(ie),_.get("onLoad"),_.h=_.get("height")?a(_.get("height"),"y")-N-j:_.get("innerHeight")&&a(_.get("innerHeight"),"y"),_.w=_.get("width")?a(_.get("width"),"x")-z-D:_.get("innerWidth")&&a(_.get("innerWidth"),"x"),_.mw=_.w,_.mh=_.h,_.get("maxWidth")&&(_.mw=a(_.get("maxWidth"),"x")-z-D,_.mw=_.w&&_.w<_.mw?_.w:_.mw),_.get("maxHeight")&&(_.mh=a(_.get("maxHeight"),"y")-N-j,_.mh=_.h&&_.h<_.mh?_.h:_.mh),e=_.get("href"),Q=setTimeout(function(){M.show()},100),_.get("inline")){var c=t(e);r=t("<div>").hide().insertBefore(c),ae.one(he,function(){r.replaceWith(c)}),h(c)}else _.get("iframe")?h(" "):_.get("html")?h(_.get("html")):s(_,e)?(e=l(_,e),U=_.get("createImg"),t(U).addClass(Z+"Photo").bind("error",function(){h(n(se,"Error").html(_.get("imgError")))}).one("load",function(){d===le&&setTimeout(function(){var t;_.get("retinaImage")&&i.devicePixelRatio>1&&(U.height=U.height/i.devicePixelRatio,U.width=U.width/i.devicePixelRatio),_.get("scalePhotos")&&(o=function(){U.height-=U.height*t,U.width-=U.width*t},_.mw&&U.width>_.mw&&(t=(U.width-_.mw)/U.width,o()),_.mh&&U.height>_.mh&&(t=(U.height-_.mh)/U.height,o())),_.h&&(U.style.marginTop=Math.max(_.mh-U.height,0)/2+"px"),W[1]&&(_.get("loop")||W[A+1])&&(U.style.cursor="pointer",U.onclick=function(){J.next()}),U.style.width=U.width+"px",U.style.height=U.height+"px",h(U)},1)}),U.src=e):e&&L.load(e,_.get("data"),function(e,i){d===le&&h("error"===i?n(se,"Error").html(_.get("xhrError")):t(this).contents())})}var v,y,x,b,T,C,H,k,W,E,I,L,M,S,F,R,K,P,B,O,_,j,D,N,z,A,U,$,q,G,Q,J,V,X={html:!1,photo:!1,iframe:!1,inline:!1,transition:"elastic",speed:300,fadeOut:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,opacity:.9,preloading:!0,className:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:void 0,closeButton:!0,fastIframe:!0,open:!1,reposition:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)((#|\?).*)?$/i,retinaImage:!1,retinaUrl:!1,retinaSuffix:"@2x.$1",current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",returnFocus:!0,trapFocus:!0,onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,rel:function(){return this.rel},href:function(){return t(this).attr("href")},title:function(){return this.title},createImg:function(){var e=new Image,i=t(this).data("cbox-img-attrs");return"object"==typeof i&&t.each(i,function(t,i){e[t]=i}),e},createIframe:function(){var i=e.createElement("iframe"),n=t(this).data("cbox-iframe-attrs");return"object"==typeof n&&t.each(n,function(t,e){i[t]=e}),"frameBorder"in i&&(i.frameBorder=0),"allowTransparency"in i&&(i.allowTransparency="true"),i.name=(new Date).getTime(),i.allowFullScreen=!0,i}},Y="colorbox",Z="cbox",te=Z+"Element",ee=Z+"_open",ie=Z+"_load",ne=Z+"_complete",oe=Z+"_cleanup",re=Z+"_closed",he=Z+"_purge",ae=t("<a/>"),se="div",le=0,de={},ce=function(){function t(){clearTimeout(h)}function e(){(_.get("loop")||W[A+1])&&(t(),h=setTimeout(J.next,_.get("slideshowSpeed")))}function i(){R.html(_.get("slideshowStop")).unbind(s).one(s,n),ae.bind(ne,e).bind(ie,t),y.removeClass(a+"off").addClass(a+"on")}function n(){t(),ae.unbind(ne,e).unbind(ie,t),R.html(_.get("slideshowStart")).unbind(s).one(s,function(){J.next(),i()}),y.removeClass(a+"on").addClass(a+"off")}function o(){r=!1,R.hide(),t(),ae.unbind(ne,e).unbind(ie,t),y.removeClass(a+"off "+a+"on")}var r,h,a=Z+"Slideshow_",s="click."+Z;return function(){r?_.get("slideshow")||(ae.unbind(oe,o),o()):_.get("slideshow")&&W[1]&&(r=!0,ae.one(oe,o),_.get("slideshowAuto")?i():n(),R.show())}}();t[Y]||(t(p),J=t.fn[Y]=t[Y]=function(e,i){var n,o=this;return e=e||{},t.isFunction(o)&&(o=t("<a/>"),e.open=!0),o[0]?(p(),m()&&(i&&(e.onComplete=i),o.each(function(){var i=t.data(this,Y)||{};t.data(this,Y,t.extend(i,e))}).addClass(te),n=new r(o[0],e),n.get("open")&&f(o[0])),o):o},J.position=function(e,i){function n(){T[0].style.width=k[0].style.width=b[0].style.width=parseInt(y[0].style.width,10)-D+"px",b[0].style.height=C[0].style.height=H[0].style.height=parseInt(y[0].style.height,10)-j+"px"}var r,h,s,l=0,d=0,c=y.offset();if(E.unbind("resize."+Z),y.css({top:-9e4,left:-9e4}),h=E.scrollTop(),s=E.scrollLeft(),_.get("fixed")?(c.top-=h,c.left-=s,y.css({position:"fixed"})):(l=h,d=s,y.css({position:"absolute"})),d+=_.get("right")!==!1?Math.max(E.width()-_.w-z-D-a(_.get("right"),"x"),0):_.get("left")!==!1?a(_.get("left"),"x"):Math.round(Math.max(E.width()-_.w-z-D,0)/2),l+=_.get("bottom")!==!1?Math.max(o()-_.h-N-j-a(_.get("bottom"),"y"),0):_.get("top")!==!1?a(_.get("top"),"y"):Math.round(Math.max(o()-_.h-N-j,0)/2),y.css({top:c.top,left:c.left,visibility:"visible"}),x[0].style.width=x[0].style.height="9999px",r={width:_.w+z+D,height:_.h+N+j,top:l,left:d},e){var g=0;t.each(r,function(t){return r[t]!==de[t]?(g=e,void 0):void 0}),e=g}de=r,e||y.css(r),y.dequeue().animate(r,{duration:e||0,complete:function(){n(),q=!1,x[0].style.width=_.w+z+D+"px",x[0].style.height=_.h+N+j+"px",_.get("reposition")&&setTimeout(function(){E.bind("resize."+Z,J.position)},1),t.isFunction(i)&&i()},step:n})},J.resize=function(t){var e;$&&(t=t||{},t.width&&(_.w=a(t.width,"x")-z-D),t.innerWidth&&(_.w=a(t.innerWidth,"x")),I.css({width:_.w}),t.height&&(_.h=a(t.height,"y")-N-j),t.innerHeight&&(_.h=a(t.innerHeight,"y")),t.innerHeight||t.height||(e=I.scrollTop(),I.css({height:"auto"}),_.h=I.height()),I.css({height:_.h}),e&&I.scrollTop(e),J.position("none"===_.get("transition")?0:_.get("speed")))},J.prep=function(i){function o(){return _.w=_.w||I.width(),_.w=_.mw&&_.mw<_.w?_.mw:_.w,_.w}function a(){return _.h=_.h||I.height(),_.h=_.mh&&_.mh<_.h?_.mh:_.h,_.h}if($){var d,g="none"===_.get("transition")?0:_.get("speed");I.remove(),I=n(se,"LoadedContent").append(i),I.hide().appendTo(L.show()).css({width:o(),overflow:_.get("scrolling")?"auto":"hidden"}).css({height:a()}).prependTo(b),L.hide(),t(U).css({"float":"none"}),c(_.get("className")),d=function(){function i(){t.support.opacity===!1&&y[0].style.removeAttribute("filter")}var n,o,a=W.length;$&&(o=function(){clearTimeout(Q),M.hide(),u(ne),_.get("onComplete")},S.html(_.get("title")).show(),I.show(),a>1?("string"==typeof _.get("current")&&F.html(_.get("current").replace("{current}",A+1).replace("{total}",a)).show(),K[_.get("loop")||a-1>A?"show":"hide"]().html(_.get("next")),P[_.get("loop")||A?"show":"hide"]().html(_.get("previous")),ce(),_.get("preloading")&&t.each([h(-1),h(1)],function(){var i,n=W[this],o=new r(n,t.data(n,Y)),h=o.get("href");h&&s(o,h)&&(h=l(o,h),i=e.createElement("img"),i.src=h)})):O.hide(),_.get("iframe")?(n=_.get("createIframe"),_.get("scrolling")||(n.scrolling="no"),t(n).attr({src:_.get("href"),"class":Z+"Iframe"}).one("load",o).appendTo(I),ae.one(he,function(){n.src="//about:blank"}),_.get("fastIframe")&&t(n).trigger("load")):o(),"fade"===_.get("transition")?y.fadeTo(g,1,i):i())},"fade"===_.get("transition")?y.fadeTo(g,0,function(){J.position(0,d)}):J.position(g,d)}},J.next=function(){!q&&W[1]&&(_.get("loop")||W[A+1])&&(A=h(1),f(W[A]))},J.prev=function(){!q&&W[1]&&(_.get("loop")||A)&&(A=h(-1),f(W[A]))},J.close=function(){$&&!G&&(G=!0,$=!1,u(oe),_.get("onCleanup"),E.unbind("."+Z),v.fadeTo(_.get("fadeOut")||0,0),y.stop().fadeTo(_.get("fadeOut")||0,0,function(){y.hide(),v.hide(),u(he),I.remove(),setTimeout(function(){G=!1,u(re),_.get("onClosed")},1)}))},J.remove=function(){y&&(y.stop(),t[Y].close(),y.stop(!1,!0).remove(),v.remove(),G=!1,y=null,t("."+te).removeData(Y).removeClass(te),t(e).unbind("click."+Z).unbind("keydown."+Z))},J.element=function(){return t(_.el)},J.settings=X)})(jQuery,document,window);