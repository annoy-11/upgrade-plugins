<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl 2017-06-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesexpose/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form sesexpose_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesexpose()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {
	  changeThemeColor(value, 'custom');
  }


	function changeThemeColor(value, custom) {
	
	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4 || value == 6 || value == 7 || value == 8 || value == 9 || value == 10)) {
	    if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'none';
		  if($('header_settings-wrapper'))
				$('header_settings-wrapper').style.display = 'none';
	    if($('footer_settings-wrapper'))
				$('footer_settings-wrapper').style.display = 'none';
		  if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'none';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'none';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'none';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'none';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'none';
	    if($('custom_theme_color-wrapper'))
				$('custom_theme_color-wrapper').style.display = 'none';
	  } else if(custom == '' && value == 5) {
	    
	    if($('custom_theme_color-wrapper'))
				$('custom_theme_color-wrapper').style.display = 'block';
		  changeCustomThemeColor(5);
	  } else if(custom == 'custom') {
		  if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'block';
		  if($('header_settings-wrapper'))
				$('header_settings-wrapper').style.display = 'block';
	    if($('footer_settings-wrapper'))
				$('footer_settings-wrapper').style.display = 'block';
			if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'block';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'block';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'block';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'block';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'block';
	  }


		if(value == 1) {
			console.log(document.getElementById('exp_theme_color'));
      //Theme Base Styling
      if($('exp_theme_color')) {
        $('exp_theme_color').value = '#000';
        //document.getElementById('exp_theme_color').color.fromString('#000');
      }
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#eeeeee';
				//document.getElementById('exp_body_background_color').color.fromString('#eeeeee');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#000';
				//document.getElementById('exp_font_color').color.fromString('#000');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#292929';
				//document.getElementById('exp_links_color').color.fromString('#292929');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#000';
				//document.getElementById('exp_links_hover_color').color.fromString('#000');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#E7E7E7';
				//document.getElementById('exp_content_border_color').color.fromString('#E7E7E7');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#000';
				//document.getElementById('exp_form_label_color').color.fromString('#000');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#fff';
				//document.getElementById('exp_input_background_color').color.fromString('#fff');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#000';
				//document.getElementById('exp_input_font_color').color.fromString('#000');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#E7E7E7';
				//document.getElementById('exp_input_border_color').color.fromString('#E7E7E7');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#000';
				//document.getElementById('exp_button_background_color').color.fromString('#000');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#1e1e1e'; //document.getElementById('exp_button_background_color_hover').color.fromString('#1e1e1e');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#000'; //document.getElementById('exp_button_background_color_hover').color.fromString('#000');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';  
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#000';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#000');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#292929';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#292929');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#000';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#000');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; //document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#000';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#000');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#E7E7E7';
				//document.getElementById('exp_footer_border_color').color.fromString('#E7E7E7');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#FFFFFF';
				//document.getElementById('exp_footer_text_color').color.fromString('#FFFFFF');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#FFFFFF';
				//document.getElementById('exp_footer_links_color').color.fromString('#FFFFFF');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#FFFFFF';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#FFFFFF');
			}
			//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#0288D1';
				//document.getElementById('exp_theme_color').color.fromString('#0288D1');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#F6F9FC';
				//document.getElementById('exp_body_background_color').color.fromString('#F6F9FC');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#0288D1';
				//document.getElementById('exp_links_hover_color').color.fromString('#0288D1');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5a5a5a';
				//document.getElementById('exp_form_label_color').color.fromString('#5a5a5a');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5a5a5a';
				//document.getElementById('exp_input_font_color').color.fromString('#5a5a5a');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#0288D1';
				//document.getElementById('exp_button_background_color').color.fromString('#0288D1');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#0097e9'; //document.getElementById('exp_button_background_color_hover').color.fromString('#0097e9');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#0288D1'; //document.getElementById('exp_button_background_color_hover').color.fromString('#0288D1');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#0288D1';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#0288D1');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#0288D1';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#0288D1');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; //document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#0288D1';
				//document.getElementById('exp_footer_border_color').color.fromString('#0288D1');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#F30000';
				//document.getElementById('exp_theme_color').color.fromString('#F30000');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#fff';
				//document.getElementById('exp_body_background_color').color.fromString('#fff');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#F30000';
				//document.getElementById('exp_links_hover_color').color.fromString('#F30000');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#424242';
				//document.getElementById('exp_form_label_color').color.fromString('#424242');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#424242';
				//document.getElementById('exp_input_font_color').color.fromString('#424242');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#F30000';
				//document.getElementById('exp_button_background_color').color.fromString('#F30000');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#ff3232';
				//document.getElementById('exp_button_background_color_hover').color.fromString('#ff3232');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#F30000';
				//document.getElementById('exp_button_background_color_hover').color.fromString('#F30000');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#F30000';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#F30000');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#F30000';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#F30000');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#424242';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#424242');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#F30000';
				//document.getElementById('exp_footer_border_color').color.fromString('#F30000');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#10a5a0';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#10a5a0');
			}
			//Footer Styling
		}
		else if(value == 4) {
					//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#a3845b';
				//document.getElementById('exp_theme_color').color.fromString('#a3845b');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#f2f2f2';
				//document.getElementById('exp_body_background_color').color.fromString('#f2f2f2');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#a3845b';
				//document.getElementById('exp_links_hover_color').color.fromString('#a3845b');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5A5A5A';
				//document.getElementById('exp_form_label_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5A5A5A';
				//document.getElementById('exp_input_font_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#a3845b';
				//document.getElementById('exp_button_background_color').color.fromString('#a3845b');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#bc9b6f'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#bc9b6f');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#a3845b'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#a3845b');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#a3845b';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#a3845b');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#a3845b';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#a3845b');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#a3845b';
				//document.getElementById('exp_footer_border_color').color.fromString('#a3845b');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling
		  }
    else if(value == 6) {
						
			//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#6A1C9E';
				//document.getElementById('exp_theme_color').color.fromString('#6A1C9E');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#fff';
				//document.getElementById('exp_body_background_color').color.fromString('#fff');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#6A1C9E';
				//document.getElementById('exp_links_hover_color').color.fromString('#6A1C9E');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5A5A5A';
				//document.getElementById('exp_form_label_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5A5A5A';
				//document.getElementById('exp_input_font_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#6A1C9E';
				//document.getElementById('exp_button_background_color').color.fromString('#6A1C9E');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#8024bd'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#8024bd');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#6A1C9E'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#6A1C9E');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#6A1C9E';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#6A1C9E');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#6A1C9E';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#6A1C9E');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#6A1C9E';
				//document.getElementById('exp_footer_border_color').color.fromString('#6A1C9E');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling
						
    }
    else if(value == 7) {
									//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#F1991B';
				//document.getElementById('exp_theme_color').color.fromString('#F1991B');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#F4F4F4';
				//document.getElementById('exp_body_background_color').color.fromString('#F4F4F4');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#F1991B';
				//document.getElementById('exp_links_hover_color').color.fromString('#F1991B');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5A5A5A';
				//document.getElementById('exp_form_label_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5A5A5A';
				//document.getElementById('exp_input_font_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#F1991B';
				//document.getElementById('exp_button_background_color').color.fromString('#F1991B');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#ffaf3d'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#ffaf3d');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#F1991B'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#F1991B');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#F1991B';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#F1991B');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#F1991B';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#F1991B');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#F1991B';
				//document.getElementById('exp_footer_border_color').color.fromString('#F1991B');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling
    }
    else if(value == 8) {
						
									//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#409843';
				//document.getElementById('exp_theme_color').color.fromString('#409843');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#fff';
				//document.getElementById('exp_body_background_color').color.fromString('#fff');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#409843';
				//document.getElementById('exp_links_hover_color').color.fromString('#409843');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5A5A5A';
				//document.getElementById('exp_form_label_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5A5A5A';
				//document.getElementById('exp_input_font_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#409843';
				//document.getElementById('exp_button_background_color').color.fromString('#409843');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#49ad4d'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#49ad4d');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#409843'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#409843');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#409843';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#409843');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#409843';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#409843');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#409843';
				//document.getElementById('exp_footer_border_color').color.fromString('#409843');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling

    }
    else if(value == 9) {
      						//Theme Base Styling
			if($('exp_theme_color')) {
				$('exp_theme_color').value = '#41617B';
				//document.getElementById('exp_theme_color').color.fromString('#41617B');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#f4f4f4';
				//document.getElementById('exp_body_background_color').color.fromString('#f4f4f4');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#424242';
				//document.getElementById('exp_font_color').color.fromString('#424242');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#424242';
				//document.getElementById('exp_font_color_light').color.fromString('#424242');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#000';
				//document.getElementById('exp_heading_color').color.fromString('#000');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#202020';
				//document.getElementById('exp_links_color').color.fromString('#202020');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#41617B';
				//document.getElementById('exp_links_hover_color').color.fromString('#41617B');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#fff';
				//document.getElementById('exp_content_background_color').color.fromString('#fff');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#ebecee';
				//document.getElementById('exp_content_border_color').color.fromString('#ebecee');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#5A5A5A';
				//document.getElementById('exp_form_label_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#f5f5f5';
				//document.getElementById('exp_input_background_color').color.fromString('#f5f5f5');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#5A5A5A';
				//document.getElementById('exp_input_font_color').color.fromString('#5A5A5A');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#cacaca';
				//document.getElementById('exp_input_border_color').color.fromString('#cacaca');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#41617B';
				//document.getElementById('exp_button_background_color').color.fromString('#41617B');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#537a99'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#537a99');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#41617B'; 
				//document.getElementById('exp_button_background_color_hover').color.fromString('#41617B');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#fff';
				//document.getElementById('exp_button_font_color').color.fromString('#fff');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#fff';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#fff');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#f6f7f9';
				//document.getElementById('exp_comment_background_color').color.fromString('#f6f7f9');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#fff';
				//document.getElementById('exp_header_background_color').color.fromString('#fff');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#eeeeee';
				//document.getElementById('exp_header_border_color').color.fromString('#eeeeee');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#1c1c1c';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#1c1c1c');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#41617B';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#41617B');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#424242';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#424242');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#41617B';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#41617B');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#fff'; 
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#fff');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#E7E7E7';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#E7E7E7');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#41617B';
				//document.getElementById('exp_footer_border_color').color.fromString('#41617B');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#ffffff';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#ffffff');
			}
			//Footer Styling
    }
    else if(value == 10) {
     						//Theme Base Styling
			if( 	$('exp_theme_color')) {
				$('exp_theme_color').value = '#FF2851';
				//document.getElementById('exp_theme_color').color.fromString('#FF2851');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('exp_body_background_color')) {
				$('exp_body_background_color').value = '#181818';
				//document.getElementById('exp_body_background_color').color.fromString('#181818');
			}
			if($('exp_font_color')) {
				$('exp_font_color').value = '#AAAAAA';
				//document.getElementById('exp_font_color').color.fromString('#AAAAAA');
			}
			if($('exp_font_color_light')) {
				$('exp_font_color_light').value = '#AAAAAA';
				//document.getElementById('exp_font_color_light').color.fromString('#AAAAAA');
			}
			
			if($('exp_heading_color')) {
				$('exp_heading_color').value = '#FFFFFF';
				//document.getElementById('exp_heading_color').color.fromString('#FFFFFF');
			}
			if($('exp_links_color')) {
				$('exp_links_color').value = '#FFFFFF';
				//document.getElementById('exp_links_color').color.fromString('#FFFFFF');
			}
			if($('exp_links_hover_color')) {
				$('exp_links_hover_color').value = '#FF2851';
				//document.getElementById('exp_links_hover_color').color.fromString('#FF2851');
			}
			if($('exp_content_background_color')) {
				$('exp_content_background_color').value = '#282828';
				//document.getElementById('exp_content_background_color').color.fromString('#282828');
			}
			if($('exp_content_border_color')) {
				$('exp_content_border_color').value = '#313131';
				//document.getElementById('exp_content_border_color').color.fromString('#313131');
			}
			if($('exp_form_label_color')) {
				$('exp_form_label_color').value = '#FFFFFF';
				//document.getElementById('exp_form_label_color').color.fromString('#FFFFFF');
			}
			if($('exp_input_background_color')) {
				$('exp_input_background_color').value = '#181818';
				//document.getElementById('exp_input_background_color').color.fromString('#181818');
			}
			if($('exp_input_font_color')) {
				$('exp_input_font_color').value = '#FFFFFF';
				//document.getElementById('exp_input_font_color').color.fromString('#FFFFFF');
			}
			if($('exp_input_border_color')) {
				$('exp_input_border_color').value = '#313131';
				//document.getElementById('exp_input_border_color').color.fromString('#313131');
			}
			if($('exp_button_background_color')) {
				$('exp_button_background_color').value = '#FF2851';
				//document.getElementById('exp_button_background_color').color.fromString('#FF2851');
			}
			if($('exp_button_background_color_hover')) {
				$('exp_button_background_color_hover').value = '#ee0d38';
				//document.getElementById('exp_button_background_color_hover').color.fromString('#ee0d38');
			}
			if($('exp_button_border_color')) {
				$('exp_button_border_color').value = '#FF2851';
				//document.getElementById('exp_button_background_color_hover').color.fromString('#FF2851');
			}
			if($('exp_button_font_color')) {
				$('exp_button_font_color').value = '#FFFFFF';
				//document.getElementById('exp_button_font_color').color.fromString('#FFFFFF');
			}
			if($('exp_button_font_hover_color')) {
				$('exp_button_font_hover_color').value = '#FFFFFF';
				//document.getElementById('exp_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('exp_comment_background_color')) {
				$('exp_comment_background_color').value = '#282828';
				//document.getElementById('exp_comment_background_color').color.fromString('#282828');
			}
			//Body Styling
			
			//Header Styling
			if($('exp_header_background_color')) {
				$('exp_header_background_color').value = '#282828';
				//document.getElementById('exp_header_background_color').color.fromString('#282828');
			}
			if($('exp_header_border_color')) {
				$('exp_header_border_color').value = '#313131';
				//document.getElementById('exp_header_border_color').color.fromString('#313131');
			}
			if($('exp_menu_logo_top_space')) {
				$('exp_menu_logo_top_space').value = '10px';
			}
			if($('exp_mainmenu_links_color')) {
				$('exp_mainmenu_links_color').value = '#FFFFFF';
				//document.getElementById('exp_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('exp_mainmenu_links_hover_color')) {
				$('exp_mainmenu_links_hover_color').value = '#FF2851';
				//document.getElementById('exp_mainmenu_links_hover_color').color.fromString('#FF2851');
			}
			if($('exp_minimenu_links_color')) {
				$('exp_minimenu_links_color').value = '#FFFFFF';
				//document.getElementById('exp_minimenu_links_color').color.fromString('#FFFFFF');
			}
			if($('exp_minimenu_links_hover_color')) {
				$('exp_minimenu_links_hover_color').value = '#FF2851';
				//document.getElementById('exp_minimenu_links_hover_color').color.fromString('#FF2851');
			}
			if($('exp_header_searchbox_background_color')) {
				$('exp_header_searchbox_background_color').value = '#FFFFFF';
				//document.getElementById('exp_header_searchbox_background_color').color.fromString('#FFFFFF');
			}
			if($('exp_header_searchbox_text_color')) {
				$('exp_header_searchbox_text_color').value = '#636363';
				//document.getElementById('exp_header_searchbox_text_color').color.fromString('#636363');
			}
			if($('exp_header_searchbox_border_color')) {
				$('exp_header_searchbox_border_color').value = '#313131';
				//document.getElementById('exp_header_searchbox_border_color').color.fromString('#313131');
			}
			//Header Styling
			
			//Footer Styling
			if($('exp_footer_background_color')) {
				$('exp_footer_background_color').value = '#222222';
				//document.getElementById('exp_footer_background_color').color.fromString('#222222');
			}
			if($('exp_footer_border_color')) {
				$('exp_footer_border_color').value = '#FF2851';
				//document.getElementById('exp_footer_border_color').color.fromString('#FF2851');
			}
			if($('exp_footer_text_color')) {
				$('exp_footer_text_color').value = '#767676';
				//document.getElementById('exp_footer_text_color').color.fromString('#767676');
			}
			if($('exp_footer_links_color')) {
				$('exp_footer_links_color').value = '#767676';
				//document.getElementById('exp_footer_links_color').color.fromString('#767676');
			}
			if($('exp_footer_links_hover_color')) {
				$('exp_footer_links_hover_color').value = '#FFFFFF';
				//document.getElementById('exp_footer_links_hover_color').color.fromString('#FFFFFF');
			}
			//Footer Styling

    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('exp_theme_color')) {
        $('exp_theme_color').value = '<?php echo $settings->getSetting('exp.theme.color') ?>';
        document.getElementById('exp_theme_color').color.fromString('<?php echo $settings->getSetting('exp.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('exp_body_background_color')) {
        $('exp_body_background_color').value = '<?php echo $settings->getSetting('exp.body.background.color') ?>';
        document.getElementById('exp_body_background_color').color.fromString('<?php echo $settings->getSetting('exp.body.background.color') ?>');
      }
      if($('exp_font_color')) {
        $('exp_font_color').value = '<?php echo $settings->getSetting('exp.fontcolor') ?>';
        document.getElementById('exp_font_color').color.fromString('<?php echo $settings->getSetting('exp.fontcolor') ?>');
      }
      if($('exp_font_color_light')) {
        $('exp_font_color_light').value = '<?php echo $settings->getSetting('exp.font.color.light') ?>';
        document.getElementById('exp_font_color_light').color.fromString('<?php echo $settings->getSetting('exp.font.color.light') ?>');
      }
      if($('exp_heading_color')) {
        $('exp_heading_color').value = '<?php echo $settings->getSetting('exp.heading.color') ?>';
        document.getElementById('exp_heading_color').color.fromString('<?php echo $settings->getSetting('exp.heading.color') ?>');
      }
      if($('exp_links_color')) {
        $('exp_links_color').value = '<?php echo $settings->getSetting('exp.links.color') ?>';
        document.getElementById('exp_links_color').color.fromString('<?php echo $settings->getSetting('exp.links.color') ?>');
      }
      if($('exp_links_hover_color')) {
        $('exp_links_hover_color').value = '<?php echo $settings->getSetting('exp.links.color.hover') ?>';
        document.getElementById('exp_links_hover_color').color.fromString('<?php echo $settings->getSetting('exp.links.color.hover') ?>');
      }
      if($('exp_content_background_color')) {
        $('exp_content_background_color').value = '<?php echo $settings->getSetting('exp.content.background.color') ?>';
        document.getElementById('exp_content_background_color').color.fromString('<?php echo $settings->getSetting('exp.content.background.color') ?>');
      }
      if($('exp_content_border_color')) {
        $('exp_content_border_color').value = '<?php echo $settings->getSetting('exp.content.bordercolor') ?>';
        document.getElementById('exp_content_border_color').color.fromString('<?php echo $settings->getSetting('exp.content.bordercolor') ?>');
      }
      if($('exp_form_label_color')) {
        $('exp_input_font_color').value = '<?php echo $settings->getSetting('exp.form.label.color') ?>';
        document.getElementById('exp_form_label_color').color.fromString('<?php echo $settings->getSetting('exp.form.label.color') ?>');
      }
      if($('exp_input_background_color')) {
        $('exp_input_background_color').value = '<?php echo $settings->getSetting('exp.input.background.color') ?>';
        document.getElementById('exp_input_background_color').color.fromString('<?php echo $settings->getSetting('exp.input.background.color') ?>');
      }
      if($('exp_input_font_color')) {
        $('exp_input_font_color').value = '<?php echo $settings->getSetting('exp.input.font.color') ?>';
        document.getElementById('exp_input_font_color').color.fromString('<?php echo $settings->getSetting('exp.input.font.color') ?>');
      }
      if($('exp_input_border_color')) {
        $('exp_input_border_color').value = '<?php echo $settings->getSetting('exp.input.border.color') ?>';
        document.getElementById('exp_input_border_color').color.fromString('<?php echo $settings->getSetting('exp.input.border.color') ?>');
      }
      if($('exp_button_background_color')) {
        $('exp_button_background_color').value = '<?php echo $settings->getSetting('exp.button.backgroundcolor') ?>';
        document.getElementById('exp_button_background_color').color.fromString('<?php echo $settings->getSetting('exp.button.backgroundcolor') ?>');
      }
      if($('exp_button_background_color_hover')) {
        $('exp_button_background_color_hover').value = '<?php echo $settings->getSetting('exp.button.background.color.hover') ?>'; 
        document.getElementById('exp_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('exp.button.background.color.hover') ?>');
      }
      if($('exp_button_font_color')) {
        $('exp_button_font_color').value = '<?php echo $settings->getSetting('exp.button.font.color') ?>';
        document.getElementById('exp_button_font_color').color.fromString('<?php echo $settings->getSetting('exp.button.font.color') ?>');
      }
      if($('exp_button_font_hover_color')) {
        $('exp_button_font_color').value = '<?php echo $settings->getSetting('exp.button.font.hover.color') ?>';
        document.getElementById('exp_button_font_hover_color').color.fromString('<?php echo $settings->getSetting('exp.button.font.hover.color') ?>');
      }
      if($('exp_comment_background_color')) {
        $('exp_comment_background_color').value = '<?php echo $settings->getSetting('exp.comment.background.color') ?>';
        document.getElementById('exp_comment_background_color').color.fromString('<?php echo $settings->getSetting('exp.comment.background.color') ?>');
      }
      if($('exp_button_border_color')) {
        $('exp_button_background_color_hover').value = '<?php echo $settings->getSetting('exp.button.border.color') ?>'; 
        document.getElementById('exp_button_border_color').color.fromString('<?php echo $settings->getSetting('exp.button.border.color') ?>');
      }
      //Body Styling
      //Header Styling
      if($('exp_header_background_color')) {
        $('exp_header_background_color').value = '<?php echo $settings->getSetting('exp.header.background.color') ?>';
        document.getElementById('exp_header_background_color').color.fromString('<?php echo $settings->getSetting('exp.header.background.color') ?>');
      }
      if($('exp_header_border_color')) {
        $('exp_header_border_color').value = '<?php echo $settings->getSetting('exp.header.border.color') ?>';
        document.getElementById('exp_header_border_color').color.fromString('<?php echo $settings->getSetting('exp.header.border.color') ?>');
      }
      if($('exp_menu_logo_top_space')) {
        $('exp_menu_logo_top_space').value = '10px';
      }
      if($('exp_mainmenu_links_color')) {
        $('exp_mainmenu_links_color').value = '<?php echo $settings->getSetting('exp.mainmenu.links.color') ?>';
        document.getElementById('exp_mainmenu_links_color').color.fromString('<?php echo $settings->getSetting('exp.mainmenu.links.color') ?>');
      }
      if($('exp_mainmenu_links_hover_color')) {
        $('exp_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('exp.mainmenu.links.color.hover') ?>';
        document.getElementById('exp_mainmenu_links_hover_color').color.fromString('<?php echo $settings->getSetting('exp.mainmenu.links.color.hover') ?>');
      }
      if($('exp_minimenu_links_color')) {
        $('exp_minimenu_links_color').value = '<?php echo $settings->getSetting('exp.minimenu.linkscolor') ?>';
        document.getElementById('exp_minimenu_links_color').color.fromString('<?php echo $settings->getSetting('exp.minimenu.linkscolor') ?>');
      }
      if($('exp_minimenu_links_hover_color')) {
        $('exp_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('exp.minimenu.links.color.hover') ?>';
        document.getElementById('exp_minimenu_links_hover_color').color.fromString('<?php echo $settings->getSetting('exp.minimenu.links.color.hover') ?>');
      }
      if($('exp_header_searchbox_background_color')) {
        $('exp_header_searchbox_background_color').value = '<?php echo $settings->getSetting('exp.header.searchbox.background.color') ?>'; 
        document.getElementById('exp_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('exp.header.searchbox.background.color') ?>');
      }
      if($('exp_header_searchbox_text_color')) {
        $('exp_header_searchbox_text_color').value = '<?php echo $settings->getSetting('exp.header.searchbox.text.color') ?>';
        document.getElementById('exp_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('exp.header.searchbox.text.color') ?>');
      }
			if($('exp_header_searchbox_border_color')) {
        $('exp_header_searchbox_border_color').value = '<?php echo $settings->getSetting('exp.header.searchbox.border.color') ?>';
        document.getElementById('exp_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('exp.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('exp_footer_background_color')) {
        $('exp_footer_background_color').value = '<?php echo $settings->getSetting('exp.footer.background.color') ?>';
        document.getElementById('exp_footer_background_color').color.fromString('<?php echo $settings->getSetting('exp.footer.background.color') ?>');
      }
      if($('exp_footer_border_color')) {
        $('exp_footer_border_color').value = '<?php echo $settings->getSetting('exp.footer.border.color') ?>';
        document.getElementById('exp_footer_border_color').color.fromString('<?php echo $settings->getSetting('exp.footer.border.color') ?>');
      }
      if($('exp_footer_text_color')) {
        $('exp_footer_text_color').value = '<?php echo $settings->getSetting('exp.footer.text.color') ?>';
        document.getElementById('exp_footer_text_color').color.fromString('<?php echo $settings->getSetting('exp.footer.text.color') ?>');
      }
      if($('exp_footer_links_color')) {
        $('exp_footer_links_color').value = '<?php echo $settings->getSetting('exp.footer.links.color') ?>';
        document.getElementById('exp_footer_links_color').color.fromString('<?php echo $settings->getSetting('exp.footer.links.color') ?>');
      }
      if($('exp_footer_links_hover_color')) {
        $('exp_footer_links_hover_color').value = '<?php echo $settings->getSetting('exp.footer.links.hover.color') ?>';
        document.getElementById('exp_footer_links_hover_color').color.fromString('<?php echo $settings->getSetting('exp.footer.links.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>