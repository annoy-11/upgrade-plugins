<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sesmaterial/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessmtheme_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesmaterial()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {
	  changeThemeColor(value, 'custom');
  }


	function changeThemeColor(value, custom) {
	
	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4 || value == 6 || value == 7 || value == 8 || value == 9)) {
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
			//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#4267B2';
  document.getElementById('sesmaterial_theme_color').color.fromString('#4267B2');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#4267B2';
  document.getElementById('sesmaterial_link_color').color.fromString('#4267B2');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#4267B2';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#4267B2');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#4267B2';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#4267B2');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#4267B2'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#4267B2');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#4267B2'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#4267B2');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#4267B2';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#4267B2');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#4267B2';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#4267B2');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#4267B2';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#4267B2');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		} 
		else if(value == 2) {
//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#2681d5';
  document.getElementById('sesmaterial_theme_color').color.fromString('#2681d5');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#2681d5';
  document.getElementById('sesmaterial_link_color').color.fromString('#2681d5');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#2681d5';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#2681d5');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#2681d5';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#2681d5');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#2681d5'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#2681d5');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#2681d5'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#2681d5');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#2681d5';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#2681d5');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#2681d5';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#2681d5');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#2681d5';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#2681d5');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		} 
		else if(value == 3) {
	//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#0177b5';
  document.getElementById('sesmaterial_theme_color').color.fromString('#0177b5');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#0177b5';
  document.getElementById('sesmaterial_link_color').color.fromString('#0177b5');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#0177b5';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#0177b5');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#0177b5';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#0177b5');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#0177b5'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#0177b5');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#0177b5'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#0177b5');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#0177b5';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#0177b5');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#0177b5';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#0177b5');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#0177b5';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#0177b5');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		}
		else if(value == 4) {
	//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#CC0821';
  document.getElementById('sesmaterial_theme_color').color.fromString('#CC0821');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#CC0821';
  document.getElementById('sesmaterial_link_color').color.fromString('#CC0821');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#CC0821';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#CC0821');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#CC0821';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#CC0821');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#CC0821'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#CC0821');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#CC0821'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#CC0821');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#CC0821';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#CC0821');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#CC0821';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#CC0821');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#ffafb9';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#ffafb9');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#CC0821';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#CC0821');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		}
    else if(value == 6) {
		//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#53cb60';
  document.getElementById('sesmaterial_theme_color').color.fromString('#53cb60');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#53cb60';
  document.getElementById('sesmaterial_link_color').color.fromString('#53cb60');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#53cb60';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#53cb60');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#53cb60';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#53cb60');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#53cb60'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#53cb60');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#53cb60'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#53cb60');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#53cb60';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#53cb60');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#53cb60';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#53cb60');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#c7ffcd';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#c7ffcd');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#53cb60';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#53cb60');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#ec4829';
  document.getElementById('sesmaterial_theme_color').color.fromString('#ec4829');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#ec4829';
  document.getElementById('sesmaterial_link_color').color.fromString('#ec4829');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#ec4829';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#ec4829');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#ec4829';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#ec4829');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#ec4829'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#ec4829');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#ec4829'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#ec4829');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#ec4829';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#ec4829');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#ec4829';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#ec4829');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#f9aa9c';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#f9aa9c');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#ec4829';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#ec4829');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#1dce97';
  document.getElementById('sesmaterial_theme_color').color.fromString('#1dce97');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#1dce97';
  document.getElementById('sesmaterial_link_color').color.fromString('#1dce97');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#1dce97';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#1dce97');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#1dce97';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#1dce97');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#1dce97'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#1dce97');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#1dce97'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#1dce97');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#1dce97';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#1dce97');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#1dce97';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#1dce97');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#b4ffe8';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#b4ffe8');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#1dce97';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#1dce97');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 9) {
      //Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#35485f';
  document.getElementById('sesmaterial_theme_color').color.fromString('#35485f');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#35485f';
  document.getElementById('sesmaterial_link_color').color.fromString('#35485f');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#35485f';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#35485f');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#35485f';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#35485f');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#35485f'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#35485f');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#35485f'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#35485f');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#35485f';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#35485f');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#35485f';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#35485f');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#35485f';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#35485f');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 10) {
  //Theme Base Styling
if($('sesmaterial_theme_color')) {
  $('sesmaterial_theme_color').value = '#ff0547';
  document.getElementById('sesmaterial_theme_color').color.fromString('#ff0547');
}
if($('sesmaterial_theme_secondary_color')) {
  $('sesmaterial_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesmaterial_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesmaterial_body_background_color')) {
  $('sesmaterial_body_background_color').value = '#e5eaef';
  document.getElementById('sesmaterial_body_background_color').color.fromString('#e5eaef');
}
if($('sesmaterial_font_color')) {
  $('sesmaterial_font_color').value = '#555';
  document.getElementById('sesmaterial_font_color').color.fromString('#555');
}
if($('sesmaterial_font_color_light')) {
  $('sesmaterial_font_color_light').value = '#888';
  document.getElementById('sesmaterial_font_color_light').color.fromString('#888');
}

if($('sesmaterial_heading_color')) {
  $('sesmaterial_heading_color').value = '#555';
  document.getElementById('sesmaterial_heading_color').color.fromString('#555');
}
if($('sesmaterial_link_color')) {
  $('sesmaterial_link_color').value = '#222';
  document.getElementById('sesmaterial_link_color').color.fromString('#222');
}
if($('sesmaterial_link_color_hover')) {
  $('sesmaterial_link_color_hover').value = '#ff0547';
  document.getElementById('sesmaterial_link_color_hover').color.fromString('#ff0547');
}
if($('sesmaterial_content_heading_background_color')) {
  $('sesmaterial_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesmaterial_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesmaterial_content_background_color')) {
  $('sesmaterial_content_background_color').value = '#fff';
  document.getElementById('sesmaterial_content_background_color').color.fromString('#fff');
}
if($('sesmaterial_content_border_color')) {
  $('sesmaterial_content_border_color').value = '#DFDFDF';
  document.getElementById('sesmaterial_content_border_color').color.fromString('#DFDFDF');
}
if($('sesmaterial_content_border_color_dark')) {
  $('sesmaterial_content_border_color_dark').value = '#ddd';
  document.getElementById('sesmaterial_content_border_color_dark').color.fromString('#ddd');
}

if($('sesmaterial_input_background_color')) {
  $('sesmaterial_input_background_color').value = '#fff';
  document.getElementById('sesmaterial_input_background_color').color.fromString('#fff');
}
if($('sesmaterial_input_font_color')) {
  $('sesmaterial_input_font_color').value = '#000';
  document.getElementById('sesmaterial_input_font_color').color.fromString('#000');
}
if($('sesmaterial_input_border_color')) {
  $('sesmaterial_input_border_color').value = '#c8c8c8';
  document.getElementById('sesmaterial_input_border_color').color.fromString('#c8c8c8');
}
if($('sesmaterial_button_background_color')) {
  $('sesmaterial_button_background_color').value = '#ff0547';
  document.getElementById('sesmaterial_button_background_color').color.fromString('#ff0547');
}
if($('sesmaterial_button_background_color_hover')) {
  $('sesmaterial_button_background_color_hover').value = '#ff0547'; document.getElementById('sesmaterial_button_background_color_hover').color.fromString('#ff0547');
}
if($('sesmaterial_button_background_color_active')) {
  $('sesmaterial_button_background_color_active').value = '#ff0547'; document.getElementById('sesmaterial_button_background_color_active').color.fromString('#ff0547');
}
if($('sesmaterial_button_font_color')) {
  $('sesmaterial_button_font_color').value = '#fff';
  document.getElementById('sesmaterial_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sesmaterial_header_background_color')) {
  $('sesmaterial_header_background_color').value = '#fff';
  document.getElementById('sesmaterial_header_background_color').color.fromString('#fff');
}
if($('sesmaterial_header_border_color')) {
  $('sesmaterial_header_border_color').value = '#fff';
  document.getElementById('sesmaterial_header_border_color').color.fromString('#fff');
}
if($('sesmaterial_menu_logo_top_space')) {
  $('sesmaterial_menu_logo_top_space').value = '10px';
}
if($('sesmaterial_mainmenu_background_color')) {
  $('sesmaterial_mainmenu_background_color').value = '#ff0547';
  document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('#ff0547');
}
if($('sesmaterial_mainmenu_background_color_hover')) {
  $('sesmaterial_mainmenu_background_color_hover').value = '#ff0547';
  document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('#ff0547');
}
if($('sesmaterial_mainmenu_link_color')) {
  $('sesmaterial_mainmenu_link_color').value = '#fdbccd';
  document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('#fdbccd');
}
if($('sesmaterial_mainmenu_link_color_hover')) {
  $('sesmaterial_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sesmaterial_mainmenu_border_color')) {
  $('sesmaterial_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_link_color')) {
  $('sesmaterial_minimenu_link_color').value = '#555555';
  document.getElementById('sesmaterial_minimenu_link_color').color.fromString('#555555');
}
if($('sesmaterial_minimenu_link_color_hover')) {
  $('sesmaterial_minimenu_link_color_hover').value = '#ff0547';
  document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('#ff0547');
}
if($('sesmaterial_minimenu_border_color')) {
  $('sesmaterial_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sesmaterial_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sesmaterial_minimenu_icon')) {
  $('sesmaterial_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sesmaterial_header_searchbox_background_color')) {
  $('sesmaterial_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sesmaterial_header_searchbox_text_color')) {
  $('sesmaterial_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sesmaterial_header_searchbox_border_color')) {
  $('sesmaterial_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sesmaterial_footer_background_color')) {
  $('sesmaterial_footer_background_color').value = '#090D25';
  document.getElementById('sesmaterial_footer_background_color').color.fromString('#090D25');
}
if($('sesmaterial_footer_border_color')) {
  $('sesmaterial_footer_border_color').value = '#dcdcdc';
  document.getElementById('sesmaterial_footer_border_color').color.fromString('#dcdcdc');
}
if($('sesmaterial_footer_text_color')) {
  $('sesmaterial_footer_text_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_text_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_color')) {
  $('sesmaterial_footer_link_color').value = '#B7B7B7';
  document.getElementById('sesmaterial_footer_link_color').color.fromString('#B7B7B7');
}
if($('sesmaterial_footer_link_hover_color')) {
  $('sesmaterial_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('sesmaterial_theme_color')) {
        $('sesmaterial_theme_color').value = '<?php echo $settings->getSetting('sesmaterial.theme.color') ?>';
        document.getElementById('sesmaterial_theme_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.theme.color') ?>');
      }
      if($('sesmaterial_theme_secondary_color')) {
        $('sesmaterial_theme_secondary_color').value = '<?php echo $settings->getSetting('sesmaterial.theme.secondary.color') ?>';
        document.getElementById('sesmaterial_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesmaterial_body_background_color')) {
        $('sesmaterial_body_background_color').value = '<?php echo $settings->getSetting('sesmaterial.body.background.color') ?>';
        document.getElementById('sesmaterial_body_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.body.background.color') ?>');
      }
      if($('sesmaterial_font_color')) {
        $('sesmaterial_font_color').value = '<?php echo $settings->getSetting('sesmaterial.fontcolor') ?>';
        document.getElementById('sesmaterial_font_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.fontcolor') ?>');
      }
      if($('sesmaterial_font_color_light')) {
        $('sesmaterial_font_color_light').value = '<?php echo $settings->getSetting('sesmaterial.font.color.light') ?>';
        document.getElementById('sesmaterial_font_color_light').color.fromString('<?php echo $settings->getSetting('sesmaterial.font.color.light') ?>');
      }
      if($('sesmaterial_heading_color')) {
        $('sesmaterial_heading_color').value = '<?php echo $settings->getSetting('sesmaterial.heading.color') ?>';
        document.getElementById('sesmaterial_heading_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.heading.color') ?>');
      }
      if($('sesmaterial_link_color')) {
        $('sesmaterial_link_color').value = '<?php echo $settings->getSetting('sesmaterial.linkcolor') ?>';
        document.getElementById('sesmaterial_link_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.linkcolor') ?>');
      }
      if($('sesmaterial_link_color_hover')) {
        $('sesmaterial_link_color_hover').value = '<?php echo $settings->getSetting('sesmaterial.link.color.hover') ?>';
        document.getElementById('sesmaterial_link_color_hover').color.fromString('<?php echo $settings->getSetting('sesmaterial.link.color.hover') ?>');
      }
      if($('sesmaterial_content_heading_background_color')) {
        $('sesmaterial_content_heading_background_color').value = '<?php echo $settings->getSetting('sesmaterial.content.heading.background.color') ?>'; 
        document.getElementById('sesmaterial_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.content.heading.background.color') ?>');
      }
      if($('sesmaterial_content_background_color')) {
        $('sesmaterial_content_background_color').value = '<?php echo $settings->getSetting('sesmaterial.content.background.color') ?>';
        document.getElementById('sesmaterial_content_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.content.background.color') ?>');
      }
      if($('sesmaterial_content_border_color')) {
        $('sesmaterial_content_border_color').value = '<?php echo $settings->getSetting('sesmaterial.content.bordercolor') ?>';
        document.getElementById('sesmaterial_content_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.content.bordercolor') ?>');
      }
      if($('sesmaterial_content_border_color_dark')) {
        $('sesmaterial_content_border_color_dark').value = '<?php echo $settings->getSetting('sesmaterial.content.border.color.dark') ?>';
        document.getElementById('sesmaterial_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('sesmaterial.content.border.color.dark') ?>');
      }
      if($('sesmaterial_input_background_color')) {
        $('sesmaterial_input_background_color').value = '<?php echo $settings->getSetting('sesmaterial.input.background.color') ?>';
        document.getElementById('sesmaterial_input_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.input.background.color') ?>');
      }
      if($('sesmaterial_input_font_color')) {
        $('sesmaterial_input_font_color').value = '<?php echo $settings->getSetting('sesmaterial.input.font.color') ?>';
        document.getElementById('sesmaterial_input_font_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.input.font.color') ?>');
      }
      if($('sesmaterial_input_border_color')) {
        $('sesmaterial_input_border_color').value = '<?php echo $settings->getSetting('sesmaterial.input.border.color') ?>';
        document.getElementById('sesmaterial_input_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.input.border.color') ?>');
      }
      if($('sesmaterial_button_background_color')) {
        $('sesmaterial_button_background_color').value = '<?php echo $settings->getSetting('sesmaterial.button.backgroundcolor') ?>';
        document.getElementById('sesmaterial_button_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.button.backgroundcolor') ?>');
      }
      if($('sesmaterial_button_background_color_hover')) {
        $('sesmaterial_button_background_color_hover').value = '<?php echo $settings->getSetting('sesmaterial.button.background.color.hover') ?>'; 
        document.getElementById('sesmaterial_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('sesmaterial.button.background.color.hover') ?>');
      }
      if($('sesmaterial_button_background_color_active')) {
        $('sesmaterial_button_background_color_active').value = '<?php echo $settings->getSetting('sesmaterial.button.background.color.active') ?>'; 
        document.getElementById('sesmaterial_button_background_color_active').color.fromString('<?php echo $settings->getSetting('sesmaterial.button.background.color.active') ?>');
      }
      if($('sesmaterial_button_font_color')) {
        $('sesmaterial_button_font_color').value = '<?php echo $settings->getSetting('sesmaterial.button.font.color') ?>';
        document.getElementById('sesmaterial_button_font_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.button.font.color') ?>');
      }
      //Body Styling
      //Header Styling
      if($('sesmaterial_header_background_color')) {
        $('sesmaterial_header_background_color').value = '<?php echo $settings->getSetting('sesmaterial.header.background.color') ?>';
        document.getElementById('sesmaterial_header_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.header.background.color') ?>');
      }
      if($('sesmaterial_header_border_color')) {
        $('sesmaterial_header_border_color').value = '<?php echo $settings->getSetting('sesmaterial.header.border.color') ?>';
        document.getElementById('sesmaterial_header_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.header.border.color') ?>');
      }
      if($('sesmaterial_menu_logo_top_space')) {
        $('sesmaterial_menu_logo_top_space').value = '10px';
      }
      if($('sesmaterial_mainmenu_background_color')) {
        $('sesmaterial_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesmaterial.mainmenu.backgroundcolor') ?>';
        document.getElementById('sesmaterial_mainmenu_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.mainmenu.backgroundcolor') ?>');
      }
      if($('sesmaterial_mainmenu_background_color_hover')) {
        $('sesmaterial_mainmenu_background_color_hover').value = '<?php echo $settings->getSetting('sesmaterial.mainmenu.background.color.hover') ?>';
        document.getElementById('sesmaterial_mainmenu_background_color_hover').color.fromString('<?php echo $settings->getSetting('sesmaterial.mainmenu.background.color.hover') ?>');
      }
      if($('sesmaterial_mainmenu_link_color')) {
        $('sesmaterial_mainmenu_link_color').value = '<?php echo $settings->getSetting('sesmaterial.mainmenu.linkcolor') ?>';
        document.getElementById('sesmaterial_mainmenu_link_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.mainmenu.linkcolor') ?>');
      }
      if($('sesmaterial_mainmenu_link_color_hover')) {
        $('sesmaterial_mainmenu_link_color_hover').value = '<?php echo $settings->getSetting('sesmaterial.mainmenu.link.color.hover') ?>';
        document.getElementById('sesmaterial_mainmenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sesmaterial.mainmenu.link.color.hover') ?>');
      }
      if($('sesmaterial_mainmenu_border_color')) {
        $('sesmaterial_mainmenu_border_color').value = '<?php echo $settings->getSetting('sesmaterial.mainmenu.border.color') ?>';
        document.getElementById('sesmaterial_mainmenu_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.mainmenu.border.color') ?>');
      }
      if($('sesmaterial_minimenu_link_color')) {
        $('sesmaterial_minimenu_link_color').value = '<?php echo $settings->getSetting('sesmaterial.minimenu.linkcolor') ?>';
        document.getElementById('sesmaterial_minimenu_link_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.minimenu.linkcolor') ?>');
      }
      if($('sesmaterial_minimenu_link_color_hover')) {
        $('sesmaterial_minimenu_link_color_hover').value = '<?php echo $settings->getSetting('sesmaterial.minimenu.link.color.hover') ?>';
        document.getElementById('sesmaterial_minimenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sesmaterial.minimenu.link.color.hover') ?>');
      }
      if($('sesmaterial_minimenu_border_color')) {
        $('sesmaterial_minimenu_border_color').value = '<?php echo $settings->getSetting('sesmaterial.minimenu.border.color') ?>';
        document.getElementById('sesmaterial_minimenu_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.minimenu.border.color') ?>');
      }
      if($('sesmaterial_minimenu_icon')) {
        $('sesmaterial_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sesmaterial_header_searchbox_background_color')) {
        $('sesmaterial_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesmaterial.header.searchbox.background.color') ?>'; 
        document.getElementById('sesmaterial_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.header.searchbox.background.color') ?>');
      }
      if($('sesmaterial_header_searchbox_text_color')) {
        $('sesmaterial_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesmaterial.header.searchbox.text.color') ?>';
        document.getElementById('sesmaterial_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.header.searchbox.text.color') ?>');
      }
      if($('sesmaterial_header_searchbox_border_color')) {
        $('sesmaterial_header_searchbox_border_color').value = '<?php echo $settings->getSetting('sesmaterial.header.searchbox.border.color') ?>'; 
        document.getElementById('sesmaterial_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('sesmaterial_footer_background_color')) {
        $('sesmaterial_footer_background_color').value = '<?php echo $settings->getSetting('sesmaterial.footer.background.color') ?>';
        document.getElementById('sesmaterial_footer_background_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.footer.background.color') ?>');
      }
      if($('sesmaterial_footer_border_color')) {
        $('sesmaterial_footer_border_color').value = '<?php echo $settings->getSetting('sesmaterial.footer.border.color') ?>';
        document.getElementById('sesmaterial_footer_border_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.footer.border.color') ?>');
      }
      if($('sesmaterial_footer_text_color')) {
        $('sesmaterial_footer_text_color').value = '<?php echo $settings->getSetting('sesmaterial.footer.text.color') ?>';
        document.getElementById('sesmaterial_footer_text_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.footer.text.color') ?>');
      }
      if($('sesmaterial_footer_link_color')) {
        $('sesmaterial_footer_link_color').value = '<?php echo $settings->getSetting('sesmaterial.footer.link.color') ?>';
        document.getElementById('sesmaterial_footer_link_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.footer.link.color') ?>');
      }
      if($('sesmaterial_footer_link_hover_color')) {
        $('sesmaterial_footer_link_hover_color').value = '<?php echo $settings->getSetting('sesmaterial.footer.link.hover.color') ?>';
        document.getElementById('sesmaterial_footer_link_hover_color').color.fromString('<?php echo $settings->getSetting('sesmaterial.footer.link.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>
