<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
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
<?php include APPLICATION_PATH .  '/application/modules/Sessocialtube/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessmtheme_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sessocialtube()->getContantValueXML('theme_color'); ?>", '');
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
if($('socialtube_theme_color')) {
  $('socialtube_theme_color').value = '#e82f34';
  document.getElementById('socialtube_theme_color').color.fromString('#e82f34');
}
if($('socialtube_theme_secondary_color')) {
  $('socialtube_theme_secondary_color').value = '#222';
  document.getElementById('socialtube_theme_secondary_color').color.fromString('#222');
}
//Theme Base Styling

//Body Styling
if($('socialtube_body_background_color')) {
  $('socialtube_body_background_color').value = '#f7f8fa';
  document.getElementById('socialtube_body_background_color').color.fromString('#f7f8fa');
}
if($('socialtube_font_color')) {
  $('socialtube_font_color').value = '#555';
  document.getElementById('socialtube_font_color').color.fromString('#555');
}
if($('socialtube_font_color_light')) {
  $('socialtube_font_color_light').value = '#888';
  document.getElementById('socialtube_font_color_light').color.fromString('#888');
}

if($('socialtube_heading_color')) {
  $('socialtube_heading_color').value = '#555';
  document.getElementById('socialtube_heading_color').color.fromString('#555');
}
if($('socialtube_link_color')) {
  $('socialtube_link_color').value = '#222';
  document.getElementById('socialtube_link_color').color.fromString('#222');
}
if($('socialtube_link_color_hover')) {
  $('socialtube_link_color_hover').value = '#e82f34';
  document.getElementById('socialtube_link_color_hover').color.fromString('#e82f34');
}
if($('socialtube_content_heading_background_color')) {
  $('socialtube_content_heading_background_color').value = '#f1f1f1'; document.getElementById('socialtube_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('socialtube_content_background_color')) {
  $('socialtube_content_background_color').value = '#fff';
  document.getElementById('socialtube_content_background_color').color.fromString('#fff');
}
if($('socialtube_content_border_color')) {
  $('socialtube_content_border_color').value = '#eee';
  document.getElementById('socialtube_content_border_color').color.fromString('#eee');
}
if($('socialtube_content_border_color_dark')) {
  $('socialtube_content_border_color_dark').value = '#ddd';
  document.getElementById('socialtube_content_border_color_dark').color.fromString('#ddd');
}

if($('socialtube_input_background_color')) {
  $('socialtube_input_background_color').value = '#fff';
  document.getElementById('socialtube_input_background_color').color.fromString('#fff');
}
if($('socialtube_input_font_color')) {
  $('socialtube_input_font_color').value = '#000';
  document.getElementById('socialtube_input_font_color').color.fromString('#000');
}
if($('socialtube_input_border_color')) {
  $('socialtube_input_border_color').value = '#dce0e3';
  document.getElementById('socialtube_input_border_color').color.fromString('#dce0e3');
}
if($('socialtube_button_background_color')) {
  $('socialtube_button_background_color').value = '#e82f34';
  document.getElementById('socialtube_button_background_color').color.fromString('#e82f34');
}
if($('socialtube_button_background_color_hover')) {
  $('socialtube_button_background_color_hover').value = '#2d2d2d'; document.getElementById('socialtube_button_background_color_hover').color.fromString('#2d2d2d');
}
if($('socialtube_button_background_color_active')) {
  $('socialtube_button_background_color_active').value = '#e82f34'; document.getElementById('socialtube_button_background_color_active').color.fromString('#e82f34');
}
if($('socialtube_button_font_color')) {
  $('socialtube_button_font_color').value = '#fff';
  document.getElementById('socialtube_button_font_color').color.fromString('#fff');
}
if($('socialtube_popup_heading_color')) {
  $('socialtube_popup_heading_color').value = '#fff';
  document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('socialtube_header_background_color')) {
  $('socialtube_header_background_color').value = '#222222';
  document.getElementById('socialtube_header_background_color').color.fromString('#222222');
}
if($('socialtube_header_border_color')) {
  $('socialtube_header_border_color').value = '#000';
  document.getElementById('socialtube_header_border_color').color.fromString('#000');
}
if($('socialtube_menu_logo_top_space')) {
  $('socialtube_menu_logo_top_space').value = '10px';
}
if($('socialtube_mainmenu_background_color')) {
  $('socialtube_mainmenu_background_color').value = '#515151';
  document.getElementById('socialtube_mainmenu_background_color').color.fromString('#515151');
}
if($('socialtube_mainmenu_background_color_hover')) {
  $('socialtube_mainmenu_background_color_hover').value = '#363636';
  document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#363636');
}
if($('socialtube_mainmenu_link_color')) {
  $('socialtube_mainmenu_link_color').value = '#ddd';
  document.getElementById('socialtube_mainmenu_link_color').color.fromString('#ddd');
}
if($('socialtube_mainmenu_link_color_hover')) {
  $('socialtube_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('socialtube_mainmenu_border_color')) {
  $('socialtube_mainmenu_border_color').value = '#666';
  document.getElementById('socialtube_mainmenu_border_color').color.fromString('#666');
}
if($('socialtube_minimenu_link_color')) {
  $('socialtube_minimenu_link_color').value = '#ddd';
  document.getElementById('socialtube_minimenu_link_color').color.fromString('#ddd');
}
if($('socialtube_minimenu_link_color_hover')) {
  $('socialtube_minimenu_link_color_hover').value = '#fff';
  document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#fff');
}
if($('socialtube_minimenu_border_color')) {
  $('socialtube_minimenu_border_color').value = '#aaa';
  document.getElementById('socialtube_minimenu_border_color').color.fromString('#aaa');
}
if($('socialtube_minimenu_icon')) {
  $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('socialtube_header_searchbox_background_color')) {
  $('socialtube_header_searchbox_background_color').value = '#222222'; document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#222222');
}
if($('socialtube_header_searchbox_text_color')) {
  $('socialtube_header_searchbox_text_color').value = '#ddd';
  document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#ddd');
}
if($('socialtube_header_searchbox_border_color')) {
  $('socialtube_header_searchbox_border_color').value = '#666';
  document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#666');
}
//Header Styling

//Footer Styling
if($('socialtube_footer_background_color')) {
  $('socialtube_footer_background_color').value = '#2D2D2D';
  document.getElementById('socialtube_footer_background_color').color.fromString('#2D2D2D');
}
if($('socialtube_footer_border_color')) {
  $('socialtube_footer_border_color').value = '#e82f34';
  document.getElementById('socialtube_footer_border_color').color.fromString('#e82f34');
}
if($('socialtube_footer_text_color')) {
  $('socialtube_footer_text_color').value = '#fff';
  document.getElementById('socialtube_footer_text_color').color.fromString('#fff');
}
if($('socialtube_footer_link_color')) {
  $('socialtube_footer_link_color').value = '#999999';
  document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
}
if($('socialtube_footer_link_hover_color')) {
  $('socialtube_footer_link_hover_color').value = '#e82f34';
  document.getElementById('socialtube_footer_link_hover_color').color.fromString('#e82f34');
}
//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
if($('socialtube_theme_color')) {
  $('socialtube_theme_color').value = '#0186bf';
  document.getElementById('socialtube_theme_color').color.fromString('#0186bf');
}
if($('socialtube_theme_secondary_color')) {
  $('socialtube_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('socialtube_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('socialtube_body_background_color')) {
  $('socialtube_body_background_color').value = '#E3E3E3';
  document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
}
if($('socialtube_font_color')) {
  $('socialtube_font_color').value = '#555';
  document.getElementById('socialtube_font_color').color.fromString('#555');
}
if($('socialtube_font_color_light')) {
  $('socialtube_font_color_light').value = '#888';
  document.getElementById('socialtube_font_color_light').color.fromString('#888');
}

if($('socialtube_heading_color')) {
  $('socialtube_heading_color').value = '#555';
  document.getElementById('socialtube_heading_color').color.fromString('#555');
}
if($('socialtube_link_color')) {
  $('socialtube_link_color').value = '#222';
  document.getElementById('socialtube_link_color').color.fromString('#222');
}
if($('socialtube_link_color_hover')) {
  $('socialtube_link_color_hover').value = '#0186BF';
  document.getElementById('socialtube_link_color_hover').color.fromString('#0186BF');
}
if($('socialtube_content_heading_background_color')) {
  $('socialtube_content_heading_background_color').value = '#f1f1f1'; document.getElementById('socialtube_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('socialtube_content_background_color')) {
  $('socialtube_content_background_color').value = '#fff';
  document.getElementById('socialtube_content_background_color').color.fromString('#fff');
}
if($('socialtube_content_border_color')) {
  $('socialtube_content_border_color').value = '#eee';
  document.getElementById('socialtube_content_border_color').color.fromString('#eee');
}
if($('socialtube_content_border_color_dark')) {
  $('socialtube_content_border_color_dark').value = '#ddd';
  document.getElementById('socialtube_content_border_color_dark').color.fromString('#ddd');
}

if($('socialtube_input_background_color')) {
  $('socialtube_input_background_color').value = '#fff';
  document.getElementById('socialtube_input_background_color').color.fromString('#fff');
}
if($('socialtube_input_font_color')) {
  $('socialtube_input_font_color').value = '#000';
  document.getElementById('socialtube_input_font_color').color.fromString('#000');
}
if($('socialtube_input_border_color')) {
  $('socialtube_input_border_color').value = '#dce0e3';
  document.getElementById('socialtube_input_border_color').color.fromString('#dce0e3');
}
if($('socialtube_button_background_color')) {
  $('socialtube_button_background_color').value = '#0186BF';
  document.getElementById('socialtube_button_background_color').color.fromString('#0186BF');
}
if($('socialtube_button_background_color_hover')) {
  $('socialtube_button_background_color_hover').value = '#2B2D2E'; document.getElementById('socialtube_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('socialtube_button_background_color_active')) {
  $('socialtube_button_background_color_active').value = '#2B2D2E'; document.getElementById('socialtube_button_background_color_active').color.fromString('#2B2D2E');
}
if($('socialtube_button_font_color')) {
  $('socialtube_button_font_color').value = '#fff';
  document.getElementById('socialtube_button_font_color').color.fromString('#fff');
}
if($('socialtube_popup_heading_color')) {
  $('socialtube_popup_heading_color').value = '#fff';
  document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('socialtube_header_background_color')) {
  $('socialtube_header_background_color').value = '#fff';
  document.getElementById('socialtube_header_background_color').color.fromString('#fff');
}
if($('socialtube_header_border_color')) {
  $('socialtube_header_border_color').value = '#fff';
  document.getElementById('socialtube_header_border_color').color.fromString('#fff');
}
if($('socialtube_menu_logo_top_space')) {
  $('socialtube_menu_logo_top_space').value = '10px';
}
if($('socialtube_mainmenu_background_color')) {
  $('socialtube_mainmenu_background_color').value = '#f7f7f7';
  document.getElementById('socialtube_mainmenu_background_color').color.fromString('#f7f7f7');
}
if($('socialtube_mainmenu_background_color_hover')) {
  $('socialtube_mainmenu_background_color_hover').value = '#f2f2f2';
  document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#f2f2f2');
}
if($('socialtube_mainmenu_link_color')) {
  $('socialtube_mainmenu_link_color').value = '#555555';
  document.getElementById('socialtube_mainmenu_link_color').color.fromString('#555555');
}
if($('socialtube_mainmenu_link_color_hover')) {
  $('socialtube_mainmenu_link_color_hover').value = '#0186BF';
  document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#0186BF');
}
if($('socialtube_mainmenu_border_color')) {
  $('socialtube_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('socialtube_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('socialtube_minimenu_link_color')) {
  $('socialtube_minimenu_link_color').value = '#555555';
  document.getElementById('socialtube_minimenu_link_color').color.fromString('#555555');
}
if($('socialtube_minimenu_link_color_hover')) {
  $('socialtube_minimenu_link_color_hover').value = '#111';
  document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#111');
}
if($('socialtube_minimenu_border_color')) {
  $('socialtube_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('socialtube_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('socialtube_minimenu_icon')) {
  $('socialtube_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('socialtube_header_searchbox_background_color')) {
  $('socialtube_header_searchbox_background_color').value = '#fff'; document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#fff');
}
if($('socialtube_header_searchbox_text_color')) {
  $('socialtube_header_searchbox_text_color').value = '#111';
  document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111');
}
if($('socialtube_header_searchbox_border_color')) {
  $('socialtube_header_searchbox_border_color').value = '#e3e3e3'; document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#e3e3e3');
}
//Header Styling

//Footer Styling
if($('socialtube_footer_background_color')) {
  $('socialtube_footer_background_color').value = '#2D2D2D';
  document.getElementById('socialtube_footer_background_color').color.fromString('#2D2D2D');
}
if($('socialtube_footer_border_color')) {
  $('socialtube_footer_border_color').value = '#0186BF';
  document.getElementById('socialtube_footer_border_color').color.fromString('#0186BF');
}
if($('socialtube_footer_text_color')) {
  $('socialtube_footer_text_color').value = '#fff';
  document.getElementById('socialtube_footer_text_color').color.fromString('#fff');
}
if($('socialtube_footer_link_color')) {
  $('socialtube_footer_link_color').value = '#999999';
  document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
}
if($('socialtube_footer_link_hover_color')) {
  $('socialtube_footer_link_hover_color').value = '#0186BF';
  document.getElementById('socialtube_footer_link_hover_color').color.fromString('#0186BF');
}
//Footer Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
if($('socialtube_theme_color')) {
  $('socialtube_theme_color').value = '#ff4700';
  document.getElementById('socialtube_theme_color').color.fromString('#ff4700');
}
if($('socialtube_theme_secondary_color')) {
  $('socialtube_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('socialtube_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('socialtube_body_background_color')) {
  $('socialtube_body_background_color').value = '#E3E3E3';
  document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
}
if($('socialtube_font_color')) {
  $('socialtube_font_color').value = '#555';
  document.getElementById('socialtube_font_color').color.fromString('#555');
}
if($('socialtube_font_color_light')) {
  $('socialtube_font_color_light').value = '#888';
  document.getElementById('socialtube_font_color_light').color.fromString('#888');
}

if($('socialtube_heading_color')) {
  $('socialtube_heading_color').value = '#FF4700';
  document.getElementById('socialtube_heading_color').color.fromString('#FF4700');
}
if($('socialtube_link_color')) {
  $('socialtube_link_color').value = '#222';
  document.getElementById('socialtube_link_color').color.fromString('#222');
}
if($('socialtube_link_color_hover')) {
  $('socialtube_link_color_hover').value = '#ff4700';
  document.getElementById('socialtube_link_color_hover').color.fromString('#ff4700');
}
if($('socialtube_content_heading_background_color')) {
  $('socialtube_content_heading_background_color').value = '#fff'; document.getElementById('socialtube_content_heading_background_color').color.fromString('#fff');
}
if($('socialtube_content_background_color')) {
  $('socialtube_content_background_color').value = '#fff';
  document.getElementById('socialtube_content_background_color').color.fromString('#fff');
}
if($('socialtube_content_border_color')) {
  $('socialtube_content_border_color').value = '#eee';
  document.getElementById('socialtube_content_border_color').color.fromString('#eee');
}
if($('socialtube_content_border_color_dark')) {
  $('socialtube_content_border_color_dark').value = '#ddd';
  document.getElementById('socialtube_content_border_color_dark').color.fromString('#ddd');
}

if($('socialtube_input_background_color')) {
  $('socialtube_input_background_color').value = '#fff';
  document.getElementById('socialtube_input_background_color').color.fromString('#fff');
}
if($('socialtube_input_font_color')) {
  $('socialtube_input_font_color').value = '#000';
  document.getElementById('socialtube_input_font_color').color.fromString('#000');
}
if($('socialtube_input_border_color')) {
  $('socialtube_input_border_color').value = '#dce0e3';
  document.getElementById('socialtube_input_border_color').color.fromString('#dce0e3');
}
if($('socialtube_button_background_color')) {
  $('socialtube_button_background_color').value = '#ff4700';
  document.getElementById('socialtube_button_background_color').color.fromString('#ff4700');
}
if($('socialtube_button_background_color_hover')) {
  $('socialtube_button_background_color_hover').value = '#2B2D2E'; document.getElementById('socialtube_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('socialtube_button_background_color_active')) {
  $('socialtube_button_background_color_active').value = '#2B2D2E'; document.getElementById('socialtube_button_background_color_active').color.fromString('#2B2D2E');
}
if($('socialtube_button_font_color')) {
  $('socialtube_button_font_color').value = '#fff';
  document.getElementById('socialtube_button_font_color').color.fromString('#fff');
}
if($('socialtube_popup_heading_color')) {
  $('socialtube_popup_heading_color').value = '#fff';
  document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('socialtube_header_background_color')) {
  $('socialtube_header_background_color').value = '#fff';
  document.getElementById('socialtube_header_background_color').color.fromString('#fff');
}
if($('socialtube_header_border_color')) {
  $('socialtube_header_border_color').value = '#fff';
  document.getElementById('socialtube_header_border_color').color.fromString('#fff');
}
if($('socialtube_menu_logo_top_space')) {
  $('socialtube_menu_logo_top_space').value = '10px';
}
if($('socialtube_mainmenu_background_color')) {
  $('socialtube_mainmenu_background_color').value = '#f7f7f7';
  document.getElementById('socialtube_mainmenu_background_color').color.fromString('#f7f7f7');
}
if($('socialtube_mainmenu_background_color_hover')) {
  $('socialtube_mainmenu_background_color_hover').value = '#f2f2f2';
  document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#f2f2f2');
}
if($('socialtube_mainmenu_link_color')) {
  $('socialtube_mainmenu_link_color').value = '#555555';
  document.getElementById('socialtube_mainmenu_link_color').color.fromString('#555555');
}
if($('socialtube_mainmenu_link_color_hover')) {
  $('socialtube_mainmenu_link_color_hover').value = '#FF4700';
  document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FF4700');
}
if($('socialtube_mainmenu_border_color')) {
  $('socialtube_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('socialtube_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('socialtube_minimenu_link_color')) {
  $('socialtube_minimenu_link_color').value = '#555555';
  document.getElementById('socialtube_minimenu_link_color').color.fromString('#555555');
}
if($('socialtube_minimenu_link_color_hover')) {
  $('socialtube_minimenu_link_color_hover').value = '#FF4700';
  document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FF4700');
}
if($('socialtube_minimenu_border_color')) {
  $('socialtube_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('socialtube_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('socialtube_minimenu_icon')) {
  $('socialtube_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('socialtube_header_searchbox_background_color')) {
  $('socialtube_header_searchbox_background_color').value = '#ffffff'; document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#ffffff');
}
if($('socialtube_header_searchbox_text_color')) {
  $('socialtube_header_searchbox_text_color').value = '#111';
  document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111');
}
if($('socialtube_header_searchbox_border_color')) {
  $('socialtube_header_searchbox_border_color').value = '#e3e3e3'; document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#e3e3e3');
}
//Header Styling

//Footer Styling
if($('socialtube_footer_background_color')) {
  $('socialtube_footer_background_color').value = '#2D2D2D';
  document.getElementById('socialtube_footer_background_color').color.fromString('#2D2D2D');
}
if($('socialtube_footer_border_color')) {
  $('socialtube_footer_border_color').value = '#ff4700';
  document.getElementById('socialtube_footer_border_color').color.fromString('#ff4700');
}
if($('socialtube_footer_text_color')) {
  $('socialtube_footer_text_color').value = '#fff';
  document.getElementById('socialtube_footer_text_color').color.fromString('#fff');
}
if($('socialtube_footer_link_color')) {
  $('socialtube_footer_link_color').value = '#999999';
  document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
}
if($('socialtube_footer_link_hover_color')) {
  $('socialtube_footer_link_hover_color').value = '#ff4700';
  document.getElementById('socialtube_footer_link_hover_color').color.fromString('#ff4700');
}
//Footer Styling
		}
		else if(value == 4) {
			//Theme Base Styling
if($('socialtube_theme_color')) {
  $('socialtube_theme_color').value = '#FFC000';
  document.getElementById('socialtube_theme_color').color.fromString('#FFC000');
}
if($('socialtube_theme_secondary_color')) {
  $('socialtube_theme_secondary_color').value = '#DDDDDD';
  document.getElementById('socialtube_theme_secondary_color').color.fromString('#DDDDDD');
}
//Theme Base Styling

//Body Styling
if($('socialtube_body_background_color')) {
  $('socialtube_body_background_color').value = '#222222';
  document.getElementById('socialtube_body_background_color').color.fromString('#222222');
}
if($('socialtube_font_color')) {
  $('socialtube_font_color').value = '#ddd';
  document.getElementById('socialtube_font_color').color.fromString('#ddd');
}
if($('socialtube_font_color_light')) {
  $('socialtube_font_color_light').value = '#999';
  document.getElementById('socialtube_font_color_light').color.fromString('#999');
}

if($('socialtube_heading_color')) {
  $('socialtube_heading_color').value = '#ddd';
  document.getElementById('socialtube_heading_color').color.fromString('#ddd');
}
if($('socialtube_link_color')) {
  $('socialtube_link_color').value = '#fff';
  document.getElementById('socialtube_link_color').color.fromString('#fff');
}
if($('socialtube_link_color_hover')) {
  $('socialtube_link_color_hover').value = '#FFC000';
  document.getElementById('socialtube_link_color_hover').color.fromString('#FFC000');
}
if($('socialtube_content_heading_background_color')) {
  $('socialtube_content_heading_background_color').value = '#2f2f2f'; document.getElementById('socialtube_content_heading_background_color').color.fromString('#2f2f2f');
}
if($('socialtube_content_background_color')) {
  $('socialtube_content_background_color').value = '#2f2f2f';
  document.getElementById('socialtube_content_background_color').color.fromString('#2f2f2f');
}
if($('socialtube_content_border_color')) {
  $('socialtube_content_border_color').value = '#383838';
  document.getElementById('socialtube_content_border_color').color.fromString('#383838');
}
if($('socialtube_content_border_color_dark')) {
  $('socialtube_content_border_color_dark').value = '#535353';
  document.getElementById('socialtube_content_border_color_dark').color.fromString('#535353');
}

if($('socialtube_input_background_color')) {
  $('socialtube_input_background_color').value = '#4c4c4c';
  document.getElementById('socialtube_input_background_color').color.fromString('#4c4c4c');
}
if($('socialtube_input_font_color')) {
  $('socialtube_input_font_color').value = '#ddd';
  document.getElementById('socialtube_input_font_color').color.fromString('#ddd');
}
if($('socialtube_input_border_color')) {
  $('socialtube_input_border_color').value = '#666';
  document.getElementById('socialtube_input_border_color').color.fromString('#666');
}
if($('socialtube_button_background_color')) {
  $('socialtube_button_background_color').value = '#FFC000';
  document.getElementById('socialtube_button_background_color').color.fromString('#ffc000');
}
if($('socialtube_button_background_color_hover')) {
  $('socialtube_button_background_color_hover').value = '#797979'; document.getElementById('socialtube_button_background_color_hover').color.fromString('#797979');
}
if($('socialtube_button_background_color_active')) {
  $('socialtube_button_background_color_active').value = '#797979'; document.getElementById('socialtube_button_background_color_active').color.fromString('#797979');
}
if($('socialtube_button_font_color')) {
  $('socialtube_button_font_color').value = '#fff';
  document.getElementById('socialtube_button_font_color').color.fromString('#fff');
}
if($('socialtube_popup_heading_color')) {
  $('socialtube_popup_heading_color').value = '#fff';
  document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('socialtube_header_background_color')) {
  $('socialtube_header_background_color').value = '#151515';
  document.getElementById('socialtube_header_background_color').color.fromString('#151515');
}
if($('socialtube_header_border_color')) {
  $('socialtube_header_border_color').value = '#222222';
  document.getElementById('socialtube_header_border_color').color.fromString('#222222');
}
if($('socialtube_menu_logo_top_space')) {
  $('socialtube_menu_logo_top_space').value = '10px';
}
if($('socialtube_mainmenu_background_color')) {
  $('socialtube_mainmenu_background_color').value = '#0D0D0D';
  document.getElementById('socialtube_mainmenu_background_color').color.fromString('#0D0D0D');
}
if($('socialtube_mainmenu_background_color_hover')) {
  $('socialtube_mainmenu_background_color_hover').value = '#080808';
  document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#080808');
}
if($('socialtube_mainmenu_link_color')) {
  $('socialtube_mainmenu_link_color').value = '#DDDDDD';
  document.getElementById('socialtube_mainmenu_link_color').color.fromString('#DDDDDD');
}
if($('socialtube_mainmenu_link_color_hover')) {
  $('socialtube_mainmenu_link_color_hover').value = '#FFC000';
  document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFC000');
}
if($('socialtube_mainmenu_border_color')) {
  $('socialtube_mainmenu_border_color').value = '#222222';
  document.getElementById('socialtube_mainmenu_border_color').color.fromString('#222222');
}
if($('socialtube_minimenu_link_color')) {
  $('socialtube_minimenu_link_color').value = '#DDDDDD';
  document.getElementById('socialtube_minimenu_link_color').color.fromString('#DDDDDD');
}
if($('socialtube_minimenu_link_color_hover')) {
  $('socialtube_minimenu_link_color_hover').value = '#FFC000';
  document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFC000');
}
if($('socialtube_minimenu_border_color')) {
  $('socialtube_minimenu_border_color').value = '#666666';
  document.getElementById('socialtube_minimenu_border_color').color.fromString('#666666');
}
if($('socialtube_minimenu_icon')) {
  $('socialtube_minimenu_icon').value = 'minimenu-icons-gray.png';
}
if($('socialtube_header_searchbox_background_color')) {
  $('socialtube_header_searchbox_background_color').value = '#4c4c4c'; document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#4c4c4c');
}
if($('socialtube_header_searchbox_text_color')) {
  $('socialtube_header_searchbox_text_color').value = '#ddd';
  document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#ddd');
}
if($('socialtube_header_searchbox_border_color')) {
  $('socialtube_header_searchbox_border_color').value = '#666'; document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#666');
}
//Header Styling

//Footer Styling
if($('socialtube_footer_background_color')) {
  $('socialtube_footer_background_color').value = '#151515';
  document.getElementById('socialtube_footer_background_color').color.fromString('#151515');
}
if($('socialtube_footer_border_color')) {
  $('socialtube_footer_border_color').value = '#ffc000';
  document.getElementById('socialtube_footer_border_color').color.fromString('#ffc000');
}
if($('socialtube_footer_text_color')) {
  $('socialtube_footer_text_color').value = '#fff';
  document.getElementById('socialtube_footer_text_color').color.fromString('#fff');
}
if($('socialtube_footer_link_color')) {
  $('socialtube_footer_link_color').value = '#999999';
  document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
}
if($('socialtube_footer_link_hover_color')) {
  $('socialtube_footer_link_hover_color').value = '#ffc000';
  document.getElementById('socialtube_footer_link_hover_color').color.fromString('#ffc000');
}
//Footer Styling
		}
    else if(value == 6) {
			//Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '#3EA9A9';
        document.getElementById('socialtube_theme_color').color.fromString('#3EA9A9');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '#FF5F3F';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('#FF5F3F');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '#E3E3E3';
        document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '#555555';
        document.getElementById('socialtube_font_color').color.fromString('#555555');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '#888888';
        document.getElementById('socialtube_font_color_light').color.fromString('#888888');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '#555555';
        document.getElementById('socialtube_heading_color').color.fromString('#555555');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '#3EA9A9';
        document.getElementById('socialtube_link_color').color.fromString('#3EA9A9');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '#FF5F3F';
        document.getElementById('socialtube_link_color_hover').color.fromString('#FF5F3F');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_content_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '#EEEEEE';
        document.getElementById('socialtube_content_border_color').color.fromString('#EEEEEE');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_input_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '#000000';
        document.getElementById('socialtube_input_font_color').color.fromString('#000000');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '#DCE0E3';
        document.getElementById('socialtube_input_border_color').color.fromString('#DCE0E3');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '#FF5F3F';
        document.getElementById('socialtube_button_background_color').color.fromString('#FF5F3F');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '#3EA9A9'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('#3EA9A9');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '#3EA9A9'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('#3EA9A9');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '#FFFFFF';
        document.getElementById('socialtube_button_font_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '#fff';
        document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
      }
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '#54BFBF';
        document.getElementById('socialtube_header_background_color').color.fromString('#54BFBF');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '#339797';
        document.getElementById('socialtube_header_border_color').color.fromString('#339797');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '#3EA9A9';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('#3EA9A9');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '#47B5B5';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#47B5B5');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '#339797';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('#339797');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '#111111';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '#2D2D2D';
        document.getElementById('socialtube_footer_background_color').color.fromString('#2D2D2D');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '#FF5F3F';
        document.getElementById('socialtube_footer_border_color').color.fromString('#FF5F3F');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '#FFFFFF';
        document.getElementById('socialtube_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '#999999';
        document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '#3EA9A9';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('#3EA9A9');
      }
      //Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '#00B841';
        document.getElementById('socialtube_theme_color').color.fromString('#00B841');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '#31302B';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '#E3E3E3';
        document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '#555555';
        document.getElementById('socialtube_font_color').color.fromString('#555555');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '#888888';
        document.getElementById('socialtube_font_color_light').color.fromString('#888888');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '#555555';
        document.getElementById('socialtube_heading_color').color.fromString('#555555');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '#111111';
        document.getElementById('socialtube_link_color').color.fromString('#111111');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '#00B841';
        document.getElementById('socialtube_link_color_hover').color.fromString('#00B841');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_content_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '#EEEEEE';
        document.getElementById('socialtube_content_border_color').color.fromString('#EEEEEE');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_input_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '#000000';
        document.getElementById('socialtube_input_font_color').color.fromString('#000000');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '#DCE0E3';
        document.getElementById('socialtube_input_border_color').color.fromString('#DCE0E3');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '#25783C';
        document.getElementById('socialtube_button_background_color').color.fromString('#25783C');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('#31302B');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('#31302B');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '#FFFFFF';
        document.getElementById('socialtube_button_font_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '#fff';
        document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
      }
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '#00B841';
        document.getElementById('socialtube_header_background_color').color.fromString('#00B841');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '#00B841';
        document.getElementById('socialtube_header_border_color').color.fromString('#00B841');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '#01BE44';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#01BE44');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '#111111';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '#31302B';
        document.getElementById('socialtube_footer_background_color').color.fromString('#31302B');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '#00B841';
        document.getElementById('socialtube_footer_border_color').color.fromString('#00B841');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '#FFFFFF';
        document.getElementById('socialtube_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '#999999';
        document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '#00B841';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('#00B841');
      }
      //Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '#A61C28';
        document.getElementById('socialtube_theme_color').color.fromString('#A61C28');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '#31302B';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '#E3E3E3';
        document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '#555555';
        document.getElementById('socialtube_font_color').color.fromString('#555555');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '#888888';
        document.getElementById('socialtube_font_color_light').color.fromString('#888888');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '#555555';
        document.getElementById('socialtube_heading_color').color.fromString('#555555');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '#111111';
        document.getElementById('socialtube_link_color').color.fromString('#111111');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '#A61C28';
        document.getElementById('socialtube_link_color_hover').color.fromString('#A61C28');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_content_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '#EEEEEE';
        document.getElementById('socialtube_content_border_color').color.fromString('#EEEEEE');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_input_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '#000000';
        document.getElementById('socialtube_input_font_color').color.fromString('#000000');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '#DCE0E3';
        document.getElementById('socialtube_input_border_color').color.fromString('#DCE0E3');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '#730710';
        document.getElementById('socialtube_button_background_color').color.fromString('#730710');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('#31302B');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('#31302B');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '#FFFFFF';
        document.getElementById('socialtube_button_font_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '#fff';
        document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
      }
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '#A61C28';
        document.getElementById('socialtube_header_background_color').color.fromString('#A61C28');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '#A61C28';
        document.getElementById('socialtube_header_border_color').color.fromString('#A61C28');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '#9C1824';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#9C1824');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '#111111';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '#31302B';
        document.getElementById('socialtube_footer_background_color').color.fromString('#31302B');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '#A61C28';
        document.getElementById('socialtube_footer_border_color').color.fromString('#A61C28');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '#FFFFFF';
        document.getElementById('socialtube_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '#999999';
        document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '#A61C28';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('#A61C28');
      }
      //Footer Styling
    }
    else if(value == 9) {
      //Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '#EF672F';
        document.getElementById('socialtube_theme_color').color.fromString('#EF672F');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '#31302B';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '#E3E3E3';
        document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '#555555';
        document.getElementById('socialtube_font_color').color.fromString('#555555');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '#888888';
        document.getElementById('socialtube_font_color_light').color.fromString('#888888');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '#555555';
        document.getElementById('socialtube_heading_color').color.fromString('#555555');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '#111111';
        document.getElementById('socialtube_link_color').color.fromString('#111111');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '#EF672F';
        document.getElementById('socialtube_link_color_hover').color.fromString('#EF672F');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_content_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '#EEEEEE';
        document.getElementById('socialtube_content_border_color').color.fromString('#EEEEEE');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_input_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '#000000';
        document.getElementById('socialtube_input_font_color').color.fromString('#000000');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '#DCE0E3';
        document.getElementById('socialtube_input_border_color').color.fromString('#DCE0E3');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '#C14800';
        document.getElementById('socialtube_button_background_color').color.fromString('#C14800');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('#31302B');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('#31302B');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '#FFFFFF';
        document.getElementById('socialtube_button_font_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '#fff';
        document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
      }
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '#EF672F';
        document.getElementById('socialtube_header_background_color').color.fromString('#EF672F');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '#EF672F';
        document.getElementById('socialtube_header_border_color').color.fromString('#EF672F');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '#F28558';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#F28558');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '#111111';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '#31302B';
        document.getElementById('socialtube_footer_background_color').color.fromString('#31302B');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '#EF672F';
        document.getElementById('socialtube_footer_border_color').color.fromString('#EF672F');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '#FFFFFF';
        document.getElementById('socialtube_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '#999999';
        document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '#EF672F';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('#EF672F');
      }
      //Footer Styling
    }
    else if(value == 10) {
      //Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '#0DC7F1';
        document.getElementById('socialtube_theme_color').color.fromString('#0DC7F1');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '#31302B';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '#E3E3E3';
        document.getElementById('socialtube_body_background_color').color.fromString('#E3E3E3');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '#555555';
        document.getElementById('socialtube_font_color').color.fromString('#555555');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '#888888';
        document.getElementById('socialtube_font_color_light').color.fromString('#888888');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '#555555';
        document.getElementById('socialtube_heading_color').color.fromString('#555555');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '#111111';
        document.getElementById('socialtube_link_color').color.fromString('#111111');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '#0DC7F1';
        document.getElementById('socialtube_link_color_hover').color.fromString('#0DC7F1');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_content_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '#EEEEEE';
        document.getElementById('socialtube_content_border_color').color.fromString('#EEEEEE');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '#FFFFFF';
        document.getElementById('socialtube_input_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '#000000';
        document.getElementById('socialtube_input_font_color').color.fromString('#000000');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '#DCE0E3';
        document.getElementById('socialtube_input_border_color').color.fromString('#DCE0E3');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '#60ACC9';
        document.getElementById('socialtube_button_background_color').color.fromString('#60ACC9');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('#31302B');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '#31302B'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('#31302B');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '#FFFFFF';
        document.getElementById('socialtube_button_font_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '#fff';
        document.getElementById('socialtube_popup_heading_color').color.fromString('#fff');
      }
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '#0DC7F1';
        document.getElementById('socialtube_header_background_color').color.fromString('#0DC7F1');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '#0DC7F1';
        document.getElementById('socialtube_header_border_color').color.fromString('#0DC7F1');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '#60ACC9';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('#60ACC9');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '#31302B';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '#111111';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '#31302B';
        document.getElementById('socialtube_footer_background_color').color.fromString('#31302B');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '#0DC7F1';
        document.getElementById('socialtube_footer_border_color').color.fromString('#0DC7F1');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '#FFFFFF';
        document.getElementById('socialtube_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '#999999';
        document.getElementById('socialtube_footer_link_color').color.fromString('#999999');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '#0DC7F1';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('#0DC7F1');
      }
      //Footer Styling
    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('socialtube_theme_color')) {
        $('socialtube_theme_color').value = '<?php echo $settings->getSetting('socialtube.theme.color') ?>';
        document.getElementById('socialtube_theme_color').color.fromString('<?php echo $settings->getSetting('socialtube.theme.color') ?>');
      }
      if($('socialtube_theme_secondary_color')) {
        $('socialtube_theme_secondary_color').value = '<?php echo $settings->getSetting('socialtube.theme.secondary.color') ?>';
        document.getElementById('socialtube_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('socialtube.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('socialtube_body_background_color')) {
        $('socialtube_body_background_color').value = '<?php echo $settings->getSetting('socialtube.body.background.color') ?>';
        document.getElementById('socialtube_body_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.body.background.color') ?>');
      }
      if($('socialtube_font_color')) {
        $('socialtube_font_color').value = '<?php echo $settings->getSetting('socialtube.fontcolor') ?>';
        document.getElementById('socialtube_font_color').color.fromString('<?php echo $settings->getSetting('socialtube.fontcolor') ?>');
      }
      if($('socialtube_font_color_light')) {
        $('socialtube_font_color_light').value = '<?php echo $settings->getSetting('socialtube.font.color.light') ?>';
        document.getElementById('socialtube_font_color_light').color.fromString('<?php echo $settings->getSetting('socialtube.font.color.light') ?>');
      }
      if($('socialtube_heading_color')) {
        $('socialtube_heading_color').value = '<?php echo $settings->getSetting('socialtube.heading.color') ?>';
        document.getElementById('socialtube_heading_color').color.fromString('<?php echo $settings->getSetting('socialtube.heading.color') ?>');
      }
      if($('socialtube_link_color')) {
        $('socialtube_link_color').value = '<?php echo $settings->getSetting('socialtube.linkcolor') ?>';
        document.getElementById('socialtube_link_color').color.fromString('<?php echo $settings->getSetting('socialtube.linkcolor') ?>');
      }
      if($('socialtube_link_color_hover')) {
        $('socialtube_link_color_hover').value = '<?php echo $settings->getSetting('socialtube.link.color.hover') ?>';
        document.getElementById('socialtube_link_color_hover').color.fromString('<?php echo $settings->getSetting('socialtube.link.color.hover') ?>');
      }
      if($('socialtube_content_heading_background_color')) {
        $('socialtube_content_heading_background_color').value = '<?php echo $settings->getSetting('socialtube.content.heading.background.color') ?>'; 
        document.getElementById('socialtube_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.content.heading.background.color') ?>');
      }
      if($('socialtube_content_background_color')) {
        $('socialtube_content_background_color').value = '<?php echo $settings->getSetting('socialtube.content.background.color') ?>';
        document.getElementById('socialtube_content_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.content.background.color') ?>');
      }
      if($('socialtube_content_border_color')) {
        $('socialtube_content_border_color').value = '<?php echo $settings->getSetting('socialtube.content.bordercolor') ?>';
        document.getElementById('socialtube_content_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.content.bordercolor') ?>');
      }
      if($('socialtube_content_border_color_dark')) {
        $('socialtube_content_border_color_dark').value = '<?php echo $settings->getSetting('socialtube.content.border.color.dark') ?>';
        document.getElementById('socialtube_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('socialtube.content.border.color.dark') ?>');
      }
      if($('socialtube_input_background_color')) {
        $('socialtube_input_background_color').value = '<?php echo $settings->getSetting('socialtube.input.background.color') ?>';
        document.getElementById('socialtube_input_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.input.background.color') ?>');
      }
      if($('socialtube_input_font_color')) {
        $('socialtube_input_font_color').value = '<?php echo $settings->getSetting('socialtube.input.font.color') ?>';
        document.getElementById('socialtube_input_font_color').color.fromString('<?php echo $settings->getSetting('socialtube.input.font.color') ?>');
      }
      if($('socialtube_input_border_color')) {
        $('socialtube_input_border_color').value = '<?php echo $settings->getSetting('socialtube.input.border.color') ?>';
        document.getElementById('socialtube_input_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.input.border.color') ?>');
      }
      if($('socialtube_button_background_color')) {
        $('socialtube_button_background_color').value = '<?php echo $settings->getSetting('socialtube.button.backgroundcolor') ?>';
        document.getElementById('socialtube_button_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.button.backgroundcolor') ?>');
      }
      if($('socialtube_button_background_color_hover')) {
        $('socialtube_button_background_color_hover').value = '<?php echo $settings->getSetting('socialtube.button.background.color.hover') ?>'; 
        document.getElementById('socialtube_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('socialtube.button.background.color.hover') ?>');
      }
      if($('socialtube_button_background_color_active')) {
        $('socialtube_button_background_color_active').value = '<?php echo $settings->getSetting('socialtube.button.background.color.active') ?>'; 
        document.getElementById('socialtube_button_background_color_active').color.fromString('<?php echo $settings->getSetting('socialtube.button.background.color.active') ?>');
      }
      if($('socialtube_button_font_color')) {
        $('socialtube_button_font_color').value = '<?php echo $settings->getSetting('socialtube.button.font.color') ?>';
        document.getElementById('socialtube_button_font_color').color.fromString('<?php echo $settings->getSetting('socialtube.button.font.color') ?>');
      }
      if($('socialtube_popup_heading_color')) {
        $('socialtube_popup_heading_color').value = '<?php echo $settings->getSetting('socialtube.button.font.color') ?>';
        document.getElementById('socialtube_popup_heading_color').color.fromString('<?php echo $settings->getSetting('socialtube.popup.heading.color') ?>');
      }
      
      //Body Styling
      //Header Styling
      if($('socialtube_header_background_color')) {
        $('socialtube_header_background_color').value = '<?php echo $settings->getSetting('socialtube.header.background.color') ?>';
        document.getElementById('socialtube_header_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.header.background.color') ?>');
      }
      if($('socialtube_header_border_color')) {
        $('socialtube_header_border_color').value = '<?php echo $settings->getSetting('socialtube.header.border.color') ?>';
        document.getElementById('socialtube_header_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.header.border.color') ?>');
      }
      if($('socialtube_menu_logo_top_space')) {
        $('socialtube_menu_logo_top_space').value = '10px';
      }
      if($('socialtube_mainmenu_background_color')) {
        $('socialtube_mainmenu_background_color').value = '<?php echo $settings->getSetting('socialtube.mainmenu.backgroundcolor') ?>';
        document.getElementById('socialtube_mainmenu_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.mainmenu.backgroundcolor') ?>');
      }
      if($('socialtube_mainmenu_background_color_hover')) {
        $('socialtube_mainmenu_background_color_hover').value = '<?php echo $settings->getSetting('socialtube.mainmenu.background.color.hover') ?>';
        document.getElementById('socialtube_mainmenu_background_color_hover').color.fromString('<?php echo $settings->getSetting('socialtube.mainmenu.background.color.hover') ?>');
      }
      if($('socialtube_mainmenu_link_color')) {
        $('socialtube_mainmenu_link_color').value = '<?php echo $settings->getSetting('socialtube.mainmenu.linkcolor') ?>';
        document.getElementById('socialtube_mainmenu_link_color').color.fromString('<?php echo $settings->getSetting('socialtube.mainmenu.linkcolor') ?>');
      }
      if($('socialtube_mainmenu_link_color_hover')) {
        $('socialtube_mainmenu_link_color_hover').value = '<?php echo $settings->getSetting('socialtube.mainmenu.link.color.hover') ?>';
        document.getElementById('socialtube_mainmenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('socialtube.mainmenu.link.color.hover') ?>');
      }
      if($('socialtube_mainmenu_border_color')) {
        $('socialtube_mainmenu_border_color').value = '<?php echo $settings->getSetting('socialtube.mainmenu.border.color') ?>';
        document.getElementById('socialtube_mainmenu_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.mainmenu.border.color') ?>');
      }
      if($('socialtube_minimenu_link_color')) {
        $('socialtube_minimenu_link_color').value = '<?php echo $settings->getSetting('socialtube.minimenu.linkcolor') ?>';
        document.getElementById('socialtube_minimenu_link_color').color.fromString('<?php echo $settings->getSetting('socialtube.minimenu.linkcolor') ?>');
      }
      if($('socialtube_minimenu_link_color_hover')) {
        $('socialtube_minimenu_link_color_hover').value = '<?php echo $settings->getSetting('socialtube.minimenu.link.color.hover') ?>';
        document.getElementById('socialtube_minimenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('socialtube.minimenu.link.color.hover') ?>');
      }
      if($('socialtube_minimenu_border_color')) {
        $('socialtube_minimenu_border_color').value = '<?php echo $settings->getSetting('socialtube.minimenu.border.color') ?>';
        document.getElementById('socialtube_minimenu_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.minimenu.border.color') ?>');
      }
      if($('socialtube_minimenu_icon')) {
        $('socialtube_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('socialtube_header_searchbox_background_color')) {
        $('socialtube_header_searchbox_background_color').value = '<?php echo $settings->getSetting('socialtube.header.searchbox.background.color') ?>'; 
        document.getElementById('socialtube_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.header.searchbox.background.color') ?>');
      }
      if($('socialtube_header_searchbox_text_color')) {
        $('socialtube_header_searchbox_text_color').value = '<?php echo $settings->getSetting('socialtube.header.searchbox.text.color') ?>';
        document.getElementById('socialtube_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('socialtube.header.searchbox.text.color') ?>');
      }
      if($('socialtube_header_searchbox_border_color')) {
        $('socialtube_header_searchbox_border_color').value = '<?php echo $settings->getSetting('socialtube.header.searchbox.border.color') ?>'; 
        document.getElementById('socialtube_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('socialtube_footer_background_color')) {
        $('socialtube_footer_background_color').value = '<?php echo $settings->getSetting('socialtube.footer.background.color') ?>';
        document.getElementById('socialtube_footer_background_color').color.fromString('<?php echo $settings->getSetting('socialtube.footer.background.color') ?>');
      }
      if($('socialtube_footer_border_color')) {
        $('socialtube_footer_border_color').value = '<?php echo $settings->getSetting('socialtube.footer.border.color') ?>';
        document.getElementById('socialtube_footer_border_color').color.fromString('<?php echo $settings->getSetting('socialtube.footer.border.color') ?>');
      }
      if($('socialtube_footer_text_color')) {
        $('socialtube_footer_text_color').value = '<?php echo $settings->getSetting('socialtube.footer.text.color') ?>';
        document.getElementById('socialtube_footer_text_color').color.fromString('<?php echo $settings->getSetting('socialtube.footer.text.color') ?>');
      }
      if($('socialtube_footer_link_color')) {
        $('socialtube_footer_link_color').value = '<?php echo $settings->getSetting('socialtube.footer.link.color') ?>';
        document.getElementById('socialtube_footer_link_color').color.fromString('<?php echo $settings->getSetting('socialtube.footer.link.color') ?>');
      }
      if($('socialtube_footer_link_hover_color')) {
        $('socialtube_footer_link_hover_color').value = '<?php echo $settings->getSetting('socialtube.footer.link.hover.color') ?>';
        document.getElementById('socialtube_footer_link_hover_color').color.fromString('<?php echo $settings->getSetting('socialtube.footer.link.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>