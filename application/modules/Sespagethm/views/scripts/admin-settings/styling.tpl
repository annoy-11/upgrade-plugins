<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sespagethm/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessmtheme_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sespagethm()->getContantValueXML('theme_color'); ?>", '');
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
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#85B44C';
  document.getElementById('sespagethm_theme_color').color.fromString('#85B44C');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#3593C4';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#3593C4');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#FFFFFF';
  document.getElementById('sespagethm_body_background_color').color.fromString('#FFFFFF');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555555';
  document.getElementById('sespagethm_font_color').color.fromString('#555555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#999999';
  document.getElementById('sespagethm_font_color_light').color.fromString('#999999');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#000000';
  document.getElementById('sespagethm_link_color').color.fromString('#000000');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#3593C4';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#3593C4');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#FFFFFF'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#FFFFFF');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#FDFDFD';
  document.getElementById('sespagethm_content_background_color').color.fromString('#FDFDFD');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#E2E4E6';
  document.getElementById('sespagethm_content_border_color').color.fromString('#E2E4E6');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#E2E4E6';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#E2E4E6');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#FFFFFF';
  document.getElementById('sespagethm_input_background_color').color.fromString('#FFFFFF');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#E2E4E6';
  document.getElementById('sespagethm_input_border_color').color.fromString('#E2E4E6');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#85B44C';
  document.getElementById('sespagethm_button_background_color').color.fromString('#85B44C');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#3593C4'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#3593C4');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#3593C4'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#3593C4');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#FFFFFF';
  document.getElementById('sespagethm_button_font_color').color.fromString('#FFFFFF');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#444444';
  document.getElementById('sespagethm_header_background_color').color.fromString('#444444');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#444444';
  document.getElementById('sespagethm_header_border_color').color.fromString('#444444');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#85B44C';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#85B44C');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#85B44C';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#85B44C');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#FFFFFF';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#FFFFFF');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#FFFFFF';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#85B44C';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#85B44C');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#FFFFFF';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#FFFFFF');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#85B44C';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#85B44C');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#85B44C';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#85B44C');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#FFFFFF'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#FFFFFF');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#111111';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#111111');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#FFFFFF'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#FFFFFF');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#E8E8E8';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#E8E8E8');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#3593C4';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#3593C4');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#555555';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#555555');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#000000';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#000000');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#3593C4';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#3593C4');
}
//Footer Styling
		} 
		else if(value == 2) {
//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#2681d5';
  document.getElementById('sespagethm_theme_color').color.fromString('#2681d5');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#2681d5';
  document.getElementById('sespagethm_link_color').color.fromString('#2681d5');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#2681d5';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#2681d5');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#2681d5';
  document.getElementById('sespagethm_button_background_color').color.fromString('#2681d5');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#2681d5'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#2681d5');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#2681d5'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#2681d5');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#2681d5';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#2681d5');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#2681d5';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#2681d5');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#2681d5';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#2681d5');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		} 
		else if(value == 3) {
	//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#0177b5';
  document.getElementById('sespagethm_theme_color').color.fromString('#0177b5');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#0177b5';
  document.getElementById('sespagethm_link_color').color.fromString('#0177b5');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#0177b5';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#0177b5');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#0177b5';
  document.getElementById('sespagethm_button_background_color').color.fromString('#0177b5');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#0177b5'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#0177b5');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#0177b5'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#0177b5');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#0177b5';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#0177b5');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#0177b5';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#0177b5');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#0177b5';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#0177b5');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		}
		else if(value == 4) {
	//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#CC0821';
  document.getElementById('sespagethm_theme_color').color.fromString('#CC0821');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#CC0821';
  document.getElementById('sespagethm_link_color').color.fromString('#CC0821');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#CC0821';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#CC0821');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#CC0821';
  document.getElementById('sespagethm_button_background_color').color.fromString('#CC0821');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#CC0821'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#CC0821');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#CC0821'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#CC0821');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#CC0821';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#CC0821');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#CC0821';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#CC0821');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#ffafb9';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#ffafb9');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#CC0821';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#CC0821');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
		}
    else if(value == 6) {
		//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#53cb60';
  document.getElementById('sespagethm_theme_color').color.fromString('#53cb60');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#53cb60';
  document.getElementById('sespagethm_link_color').color.fromString('#53cb60');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#53cb60';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#53cb60');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#53cb60';
  document.getElementById('sespagethm_button_background_color').color.fromString('#53cb60');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#53cb60'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#53cb60');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#53cb60'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#53cb60');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#53cb60';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#53cb60');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#53cb60';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#53cb60');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#c7ffcd';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#c7ffcd');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#53cb60';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#53cb60');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#ec4829';
  document.getElementById('sespagethm_theme_color').color.fromString('#ec4829');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#ec4829';
  document.getElementById('sespagethm_link_color').color.fromString('#ec4829');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#ec4829';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#ec4829');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#ec4829';
  document.getElementById('sespagethm_button_background_color').color.fromString('#ec4829');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#ec4829'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#ec4829');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#ec4829'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#ec4829');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#ec4829';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#ec4829');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#ec4829';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#ec4829');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#f9aa9c';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#f9aa9c');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#ec4829';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#ec4829');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#1dce97';
  document.getElementById('sespagethm_theme_color').color.fromString('#1dce97');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#1dce97';
  document.getElementById('sespagethm_link_color').color.fromString('#1dce97');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#1dce97';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#1dce97');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#1dce97';
  document.getElementById('sespagethm_button_background_color').color.fromString('#1dce97');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#1dce97'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#1dce97');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#1dce97'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#1dce97');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#1dce97';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#1dce97');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#1dce97';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#1dce97');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#b4ffe8';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#b4ffe8');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#1dce97';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#1dce97');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 9) {
      //Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#35485f';
  document.getElementById('sespagethm_theme_color').color.fromString('#35485f');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#35485f';
  document.getElementById('sespagethm_link_color').color.fromString('#35485f');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#35485f';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#35485f');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#35485f';
  document.getElementById('sespagethm_button_background_color').color.fromString('#35485f');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#35485f'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#35485f');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#35485f'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#35485f');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#35485f';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#35485f');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#35485f';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#35485f');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#bbd8f3';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#bbd8f3');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#35485f';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#35485f');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    }
    else if(value == 10) {
  //Theme Base Styling
if($('sespagethm_theme_color')) {
  $('sespagethm_theme_color').value = '#ff0547';
  document.getElementById('sespagethm_theme_color').color.fromString('#ff0547');
}
if($('sespagethm_theme_secondary_color')) {
  $('sespagethm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sespagethm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sespagethm_body_background_color')) {
  $('sespagethm_body_background_color').value = '#e5eaef';
  document.getElementById('sespagethm_body_background_color').color.fromString('#e5eaef');
}
if($('sespagethm_font_color')) {
  $('sespagethm_font_color').value = '#555';
  document.getElementById('sespagethm_font_color').color.fromString('#555');
}
if($('sespagethm_font_color_light')) {
  $('sespagethm_font_color_light').value = '#888';
  document.getElementById('sespagethm_font_color_light').color.fromString('#888');
}

if($('sespagethm_heading_color')) {
  $('sespagethm_heading_color').value = '#555';
  document.getElementById('sespagethm_heading_color').color.fromString('#555');
}
if($('sespagethm_link_color')) {
  $('sespagethm_link_color').value = '#222';
  document.getElementById('sespagethm_link_color').color.fromString('#222');
}
if($('sespagethm_link_color_hover')) {
  $('sespagethm_link_color_hover').value = '#ff0547';
  document.getElementById('sespagethm_link_color_hover').color.fromString('#ff0547');
}
if($('sespagethm_content_heading_background_color')) {
  $('sespagethm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sespagethm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sespagethm_content_background_color')) {
  $('sespagethm_content_background_color').value = '#fff';
  document.getElementById('sespagethm_content_background_color').color.fromString('#fff');
}
if($('sespagethm_content_border_color')) {
  $('sespagethm_content_border_color').value = '#DFDFDF';
  document.getElementById('sespagethm_content_border_color').color.fromString('#DFDFDF');
}
if($('sespagethm_content_border_color_dark')) {
  $('sespagethm_content_border_color_dark').value = '#ddd';
  document.getElementById('sespagethm_content_border_color_dark').color.fromString('#ddd');
}

if($('sespagethm_input_background_color')) {
  $('sespagethm_input_background_color').value = '#fff';
  document.getElementById('sespagethm_input_background_color').color.fromString('#fff');
}
if($('sespagethm_input_font_color')) {
  $('sespagethm_input_font_color').value = '#000';
  document.getElementById('sespagethm_input_font_color').color.fromString('#000');
}
if($('sespagethm_input_border_color')) {
  $('sespagethm_input_border_color').value = '#c8c8c8';
  document.getElementById('sespagethm_input_border_color').color.fromString('#c8c8c8');
}
if($('sespagethm_button_background_color')) {
  $('sespagethm_button_background_color').value = '#ff0547';
  document.getElementById('sespagethm_button_background_color').color.fromString('#ff0547');
}
if($('sespagethm_button_background_color_hover')) {
  $('sespagethm_button_background_color_hover').value = '#ff0547'; document.getElementById('sespagethm_button_background_color_hover').color.fromString('#ff0547');
}
if($('sespagethm_button_background_color_active')) {
  $('sespagethm_button_background_color_active').value = '#ff0547'; document.getElementById('sespagethm_button_background_color_active').color.fromString('#ff0547');
}
if($('sespagethm_button_font_color')) {
  $('sespagethm_button_font_color').value = '#fff';
  document.getElementById('sespagethm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sespagethm_header_background_color')) {
  $('sespagethm_header_background_color').value = '#fff';
  document.getElementById('sespagethm_header_background_color').color.fromString('#fff');
}
if($('sespagethm_header_border_color')) {
  $('sespagethm_header_border_color').value = '#fff';
  document.getElementById('sespagethm_header_border_color').color.fromString('#fff');
}
if($('sespagethm_menu_logo_top_space')) {
  $('sespagethm_menu_logo_top_space').value = '10px';
}
if($('sespagethm_mainmenu_background_color')) {
  $('sespagethm_mainmenu_background_color').value = '#ff0547';
  document.getElementById('sespagethm_mainmenu_background_color').color.fromString('#ff0547');
}
if($('sespagethm_mainmenu_background_color_hover')) {
  $('sespagethm_mainmenu_background_color_hover').value = '#ff0547';
  document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('#ff0547');
}
if($('sespagethm_mainmenu_link_color')) {
  $('sespagethm_mainmenu_link_color').value = '#fdbccd';
  document.getElementById('sespagethm_mainmenu_link_color').color.fromString('#fdbccd');
}
if($('sespagethm_mainmenu_link_color_hover')) {
  $('sespagethm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sespagethm_mainmenu_border_color')) {
  $('sespagethm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_link_color')) {
  $('sespagethm_minimenu_link_color').value = '#555555';
  document.getElementById('sespagethm_minimenu_link_color').color.fromString('#555555');
}
if($('sespagethm_minimenu_link_color_hover')) {
  $('sespagethm_minimenu_link_color_hover').value = '#ff0547';
  document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('#ff0547');
}
if($('sespagethm_minimenu_border_color')) {
  $('sespagethm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sespagethm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sespagethm_minimenu_icon')) {
  $('sespagethm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sespagethm_header_searchbox_background_color')) {
  $('sespagethm_header_searchbox_background_color').value = '#f8f8f8'; document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('#f8f8f8');
}
if($('sespagethm_header_searchbox_text_color')) {
  $('sespagethm_header_searchbox_text_color').value = '#C8C8C8';
  document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('#C8C8C8');
}
if($('sespagethm_header_searchbox_border_color')) {
  $('sespagethm_header_searchbox_border_color').value = '#C8C8C8'; document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('#C8C8C8');
}
//Header Styling

//Footer Styling
if($('sespagethm_footer_background_color')) {
  $('sespagethm_footer_background_color').value = '#090D25';
  document.getElementById('sespagethm_footer_background_color').color.fromString('#090D25');
}
if($('sespagethm_footer_border_color')) {
  $('sespagethm_footer_border_color').value = '#dcdcdc';
  document.getElementById('sespagethm_footer_border_color').color.fromString('#dcdcdc');
}
if($('sespagethm_footer_text_color')) {
  $('sespagethm_footer_text_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_text_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_color')) {
  $('sespagethm_footer_link_color').value = '#B7B7B7';
  document.getElementById('sespagethm_footer_link_color').color.fromString('#B7B7B7');
}
if($('sespagethm_footer_link_hover_color')) {
  $('sespagethm_footer_link_hover_color').value = '#FFFFFF';
  document.getElementById('sespagethm_footer_link_hover_color').color.fromString('#FFFFFF');
}
//Footer Styling
    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('sespagethm_theme_color')) {
        $('sespagethm_theme_color').value = '<?php echo $settings->getSetting('sespagethm.theme.color') ?>';
        document.getElementById('sespagethm_theme_color').color.fromString('<?php echo $settings->getSetting('sespagethm.theme.color') ?>');
      }
      if($('sespagethm_theme_secondary_color')) {
        $('sespagethm_theme_secondary_color').value = '<?php echo $settings->getSetting('sespagethm.theme.secondary.color') ?>';
        document.getElementById('sespagethm_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('sespagethm.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sespagethm_body_background_color')) {
        $('sespagethm_body_background_color').value = '<?php echo $settings->getSetting('sespagethm.body.background.color') ?>';
        document.getElementById('sespagethm_body_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.body.background.color') ?>');
      }
      if($('sespagethm_font_color')) {
        $('sespagethm_font_color').value = '<?php echo $settings->getSetting('sespagethm.fontcolor') ?>';
        document.getElementById('sespagethm_font_color').color.fromString('<?php echo $settings->getSetting('sespagethm.fontcolor') ?>');
      }
      if($('sespagethm_font_color_light')) {
        $('sespagethm_font_color_light').value = '<?php echo $settings->getSetting('sespagethm.font.color.light') ?>';
        document.getElementById('sespagethm_font_color_light').color.fromString('<?php echo $settings->getSetting('sespagethm.font.color.light') ?>');
      }
      if($('sespagethm_heading_color')) {
        $('sespagethm_heading_color').value = '<?php echo $settings->getSetting('sespagethm.heading.color') ?>';
        document.getElementById('sespagethm_heading_color').color.fromString('<?php echo $settings->getSetting('sespagethm.heading.color') ?>');
      }
      if($('sespagethm_link_color')) {
        $('sespagethm_link_color').value = '<?php echo $settings->getSetting('sespagethm.linkcolor') ?>';
        document.getElementById('sespagethm_link_color').color.fromString('<?php echo $settings->getSetting('sespagethm.linkcolor') ?>');
      }
      if($('sespagethm_link_color_hover')) {
        $('sespagethm_link_color_hover').value = '<?php echo $settings->getSetting('sespagethm.link.color.hover') ?>';
        document.getElementById('sespagethm_link_color_hover').color.fromString('<?php echo $settings->getSetting('sespagethm.link.color.hover') ?>');
      }
      if($('sespagethm_content_heading_background_color')) {
        $('sespagethm_content_heading_background_color').value = '<?php echo $settings->getSetting('sespagethm.content.heading.background.color') ?>'; 
        document.getElementById('sespagethm_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.content.heading.background.color') ?>');
      }
      if($('sespagethm_content_background_color')) {
        $('sespagethm_content_background_color').value = '<?php echo $settings->getSetting('sespagethm.content.background.color') ?>';
        document.getElementById('sespagethm_content_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.content.background.color') ?>');
      }
      if($('sespagethm_content_border_color')) {
        $('sespagethm_content_border_color').value = '<?php echo $settings->getSetting('sespagethm.content.bordercolor') ?>';
        document.getElementById('sespagethm_content_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.content.bordercolor') ?>');
      }
      if($('sespagethm_content_border_color_dark')) {
        $('sespagethm_content_border_color_dark').value = '<?php echo $settings->getSetting('sespagethm.content.border.color.dark') ?>';
        document.getElementById('sespagethm_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('sespagethm.content.border.color.dark') ?>');
      }
      if($('sespagethm_input_background_color')) {
        $('sespagethm_input_background_color').value = '<?php echo $settings->getSetting('sespagethm.input.background.color') ?>';
        document.getElementById('sespagethm_input_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.input.background.color') ?>');
      }
      if($('sespagethm_input_font_color')) {
        $('sespagethm_input_font_color').value = '<?php echo $settings->getSetting('sespagethm.input.font.color') ?>';
        document.getElementById('sespagethm_input_font_color').color.fromString('<?php echo $settings->getSetting('sespagethm.input.font.color') ?>');
      }
      if($('sespagethm_input_border_color')) {
        $('sespagethm_input_border_color').value = '<?php echo $settings->getSetting('sespagethm.input.border.color') ?>';
        document.getElementById('sespagethm_input_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.input.border.color') ?>');
      }
      if($('sespagethm_button_background_color')) {
        $('sespagethm_button_background_color').value = '<?php echo $settings->getSetting('sespagethm.button.backgroundcolor') ?>';
        document.getElementById('sespagethm_button_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.button.backgroundcolor') ?>');
      }
      if($('sespagethm_button_background_color_hover')) {
        $('sespagethm_button_background_color_hover').value = '<?php echo $settings->getSetting('sespagethm.button.background.color.hover') ?>'; 
        document.getElementById('sespagethm_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('sespagethm.button.background.color.hover') ?>');
      }
      if($('sespagethm_button_background_color_active')) {
        $('sespagethm_button_background_color_active').value = '<?php echo $settings->getSetting('sespagethm.button.background.color.active') ?>'; 
        document.getElementById('sespagethm_button_background_color_active').color.fromString('<?php echo $settings->getSetting('sespagethm.button.background.color.active') ?>');
      }
      if($('sespagethm_button_font_color')) {
        $('sespagethm_button_font_color').value = '<?php echo $settings->getSetting('sespagethm.button.font.color') ?>';
        document.getElementById('sespagethm_button_font_color').color.fromString('<?php echo $settings->getSetting('sespagethm.button.font.color') ?>');
      }
      //Body Styling
      //Header Styling
      if($('sespagethm_header_background_color')) {
        $('sespagethm_header_background_color').value = '<?php echo $settings->getSetting('sespagethm.header.background.color') ?>';
        document.getElementById('sespagethm_header_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.header.background.color') ?>');
      }
      if($('sespagethm_header_border_color')) {
        $('sespagethm_header_border_color').value = '<?php echo $settings->getSetting('sespagethm.header.border.color') ?>';
        document.getElementById('sespagethm_header_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.header.border.color') ?>');
      }
      if($('sespagethm_menu_logo_top_space')) {
        $('sespagethm_menu_logo_top_space').value = '10px';
      }
      if($('sespagethm_mainmenu_background_color')) {
        $('sespagethm_mainmenu_background_color').value = '<?php echo $settings->getSetting('sespagethm.mainmenu.backgroundcolor') ?>';
        document.getElementById('sespagethm_mainmenu_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.mainmenu.backgroundcolor') ?>');
      }
      if($('sespagethm_mainmenu_background_color_hover')) {
        $('sespagethm_mainmenu_background_color_hover').value = '<?php echo $settings->getSetting('sespagethm.mainmenu.background.color.hover') ?>';
        document.getElementById('sespagethm_mainmenu_background_color_hover').color.fromString('<?php echo $settings->getSetting('sespagethm.mainmenu.background.color.hover') ?>');
      }
      if($('sespagethm_mainmenu_link_color')) {
        $('sespagethm_mainmenu_link_color').value = '<?php echo $settings->getSetting('sespagethm.mainmenu.linkcolor') ?>';
        document.getElementById('sespagethm_mainmenu_link_color').color.fromString('<?php echo $settings->getSetting('sespagethm.mainmenu.linkcolor') ?>');
      }
      if($('sespagethm_mainmenu_link_color_hover')) {
        $('sespagethm_mainmenu_link_color_hover').value = '<?php echo $settings->getSetting('sespagethm.mainmenu.link.color.hover') ?>';
        document.getElementById('sespagethm_mainmenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sespagethm.mainmenu.link.color.hover') ?>');
      }
      if($('sespagethm_mainmenu_border_color')) {
        $('sespagethm_mainmenu_border_color').value = '<?php echo $settings->getSetting('sespagethm.mainmenu.border.color') ?>';
        document.getElementById('sespagethm_mainmenu_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.mainmenu.border.color') ?>');
      }
      if($('sespagethm_minimenu_link_color')) {
        $('sespagethm_minimenu_link_color').value = '<?php echo $settings->getSetting('sespagethm.minimenu.linkcolor') ?>';
        document.getElementById('sespagethm_minimenu_link_color').color.fromString('<?php echo $settings->getSetting('sespagethm.minimenu.linkcolor') ?>');
      }
      if($('sespagethm_minimenu_link_color_hover')) {
        $('sespagethm_minimenu_link_color_hover').value = '<?php echo $settings->getSetting('sespagethm.minimenu.link.color.hover') ?>';
        document.getElementById('sespagethm_minimenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sespagethm.minimenu.link.color.hover') ?>');
      }
      if($('sespagethm_minimenu_border_color')) {
        $('sespagethm_minimenu_border_color').value = '<?php echo $settings->getSetting('sespagethm.minimenu.border.color') ?>';
        document.getElementById('sespagethm_minimenu_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.minimenu.border.color') ?>');
      }
      if($('sespagethm_minimenu_icon')) {
        $('sespagethm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sespagethm_header_searchbox_background_color')) {
        $('sespagethm_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sespagethm.header.searchbox.background.color') ?>'; 
        document.getElementById('sespagethm_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.header.searchbox.background.color') ?>');
      }
      if($('sespagethm_header_searchbox_text_color')) {
        $('sespagethm_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sespagethm.header.searchbox.text.color') ?>';
        document.getElementById('sespagethm_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('sespagethm.header.searchbox.text.color') ?>');
      }
      if($('sespagethm_header_searchbox_border_color')) {
        $('sespagethm_header_searchbox_border_color').value = '<?php echo $settings->getSetting('sespagethm.header.searchbox.border.color') ?>'; 
        document.getElementById('sespagethm_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('sespagethm_footer_background_color')) {
        $('sespagethm_footer_background_color').value = '<?php echo $settings->getSetting('sespagethm.footer.background.color') ?>';
        document.getElementById('sespagethm_footer_background_color').color.fromString('<?php echo $settings->getSetting('sespagethm.footer.background.color') ?>');
      }
      if($('sespagethm_footer_border_color')) {
        $('sespagethm_footer_border_color').value = '<?php echo $settings->getSetting('sespagethm.footer.border.color') ?>';
        document.getElementById('sespagethm_footer_border_color').color.fromString('<?php echo $settings->getSetting('sespagethm.footer.border.color') ?>');
      }
      if($('sespagethm_footer_text_color')) {
        $('sespagethm_footer_text_color').value = '<?php echo $settings->getSetting('sespagethm.footer.text.color') ?>';
        document.getElementById('sespagethm_footer_text_color').color.fromString('<?php echo $settings->getSetting('sespagethm.footer.text.color') ?>');
      }
      if($('sespagethm_footer_link_color')) {
        $('sespagethm_footer_link_color').value = '<?php echo $settings->getSetting('sespagethm.footer.link.color') ?>';
        document.getElementById('sespagethm_footer_link_color').color.fromString('<?php echo $settings->getSetting('sespagethm.footer.link.color') ?>');
      }
      if($('sespagethm_footer_link_hover_color')) {
        $('sespagethm_footer_link_hover_color').value = '<?php echo $settings->getSetting('sespagethm.footer.link.hover.color') ?>';
        document.getElementById('sespagethm_footer_link_hover_color').color.fromString('<?php echo $settings->getSetting('sespagethm.footer.link.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>
