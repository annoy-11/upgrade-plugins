<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
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
<?php include APPLICATION_PATH .  '/application/modules/Sesspectromedia/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessmtheme_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesspectromedia()->getContantValueXML('theme_color'); ?>", '');
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
if($('sm_theme_color')) {
  $('sm_theme_color').value = '#e82f34';
  document.getElementById('sm_theme_color').color.fromString('#e82f34');
}
if($('sm_theme_secondary_color')) {
  $('sm_theme_secondary_color').value = '#222';
  document.getElementById('sm_theme_secondary_color').color.fromString('#222');
}
//Theme Base Styling

//Body Styling
if($('sm_body_background_color')) {
  $('sm_body_background_color').value = '#f7f8fa';
  document.getElementById('sm_body_background_color').color.fromString('#f7f8fa');
}
if($('sm_font_color')) {
  $('sm_font_color').value = '#555';
  document.getElementById('sm_font_color').color.fromString('#555');
}
if($('sm_font_color_light')) {
  $('sm_font_color_light').value = '#888';
  document.getElementById('sm_font_color_light').color.fromString('#888');
}

if($('sm_heading_color')) {
  $('sm_heading_color').value = '#555';
  document.getElementById('sm_heading_color').color.fromString('#555');
}
if($('sm_link_color')) {
  $('sm_link_color').value = '#222';
  document.getElementById('sm_link_color').color.fromString('#222');
}
if($('sm_link_color_hover')) {
  $('sm_link_color_hover').value = '#e82f34';
  document.getElementById('sm_link_color_hover').color.fromString('#e82f34');
}
if($('sm_content_heading_background_color')) {
  $('sm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sm_content_background_color')) {
  $('sm_content_background_color').value = '#fff';
  document.getElementById('sm_content_background_color').color.fromString('#fff');
}
if($('sm_content_border_color')) {
  $('sm_content_border_color').value = '#eee';
  document.getElementById('sm_content_border_color').color.fromString('#eee');
}
if($('sm_content_border_color_dark')) {
  $('sm_content_border_color_dark').value = '#ddd';
  document.getElementById('sm_content_border_color_dark').color.fromString('#ddd');
}

if($('sm_input_background_color')) {
  $('sm_input_background_color').value = '#fff';
  document.getElementById('sm_input_background_color').color.fromString('#fff');
}
if($('sm_input_font_color')) {
  $('sm_input_font_color').value = '#000';
  document.getElementById('sm_input_font_color').color.fromString('#000');
}
if($('sm_input_border_color')) {
  $('sm_input_border_color').value = '#dce0e3';
  document.getElementById('sm_input_border_color').color.fromString('#dce0e3');
}
if($('sm_button_background_color')) {
  $('sm_button_background_color').value = '#e82f34';
  document.getElementById('sm_button_background_color').color.fromString('#e82f34');
}
if($('sm_button_background_color_hover')) {
  $('sm_button_background_color_hover').value = '#2d2d2d'; document.getElementById('sm_button_background_color_hover').color.fromString('#2d2d2d');
}
if($('sm_button_background_color_active')) {
  $('sm_button_background_color_active').value = '#e82f34'; document.getElementById('sm_button_background_color_active').color.fromString('#e82f34');
}
if($('sm_button_font_color')) {
  $('sm_button_font_color').value = '#fff';
  document.getElementById('sm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sm_header_background_color')) {
  $('sm_header_background_color').value = '#222222';
  document.getElementById('sm_header_background_color').color.fromString('#222222');
}
if($('sm_header_border_color')) {
  $('sm_header_border_color').value = '#000';
  document.getElementById('sm_header_border_color').color.fromString('#000');
}
if($('sm_menu_logo_top_space')) {
  $('sm_menu_logo_top_space').value = '10px';
}
if($('sm_mainmenu_background_color')) {
  $('sm_mainmenu_background_color').value = '#515151';
  document.getElementById('sm_mainmenu_background_color').color.fromString('#515151');
}
if($('sm_mainmenu_background_color_hover')) {
  $('sm_mainmenu_background_color_hover').value = '#363636';
  document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#363636');
}
if($('sm_mainmenu_link_color')) {
  $('sm_mainmenu_link_color').value = '#ddd';
  document.getElementById('sm_mainmenu_link_color').color.fromString('#ddd');
}
if($('sm_mainmenu_link_color_hover')) {
  $('sm_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sm_mainmenu_border_color')) {
  $('sm_mainmenu_border_color').value = '#666';
  document.getElementById('sm_mainmenu_border_color').color.fromString('#666');
}
if($('sm_minimenu_link_color')) {
  $('sm_minimenu_link_color').value = '#ddd';
  document.getElementById('sm_minimenu_link_color').color.fromString('#ddd');
}
if($('sm_minimenu_link_color_hover')) {
  $('sm_minimenu_link_color_hover').value = '#fff';
  document.getElementById('sm_minimenu_link_color_hover').color.fromString('#fff');
}
if($('sm_minimenu_border_color')) {
  $('sm_minimenu_border_color').value = '#aaa';
  document.getElementById('sm_minimenu_border_color').color.fromString('#aaa');
}
if($('sm_minimenu_icon')) {
  $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('sm_header_searchbox_background_color')) {
  $('sm_header_searchbox_background_color').value = '#222222'; document.getElementById('sm_header_searchbox_background_color').color.fromString('#222222');
}
if($('sm_header_searchbox_text_color')) {
  $('sm_header_searchbox_text_color').value = '#ddd';
  document.getElementById('sm_header_searchbox_text_color').color.fromString('#ddd');
}
if($('sm_header_searchbox_border_color')) {
  $('sm_header_searchbox_border_color').value = '#666';
  document.getElementById('sm_header_searchbox_border_color').color.fromString('#666');
}
//Header Styling

//Footer Styling
if($('sm_footer_background_color')) {
  $('sm_footer_background_color').value = '#2D2D2D';
  document.getElementById('sm_footer_background_color').color.fromString('#2D2D2D');
}
if($('sm_footer_border_color')) {
  $('sm_footer_border_color').value = '#e82f34';
  document.getElementById('sm_footer_border_color').color.fromString('#e82f34');
}
if($('sm_footer_text_color')) {
  $('sm_footer_text_color').value = '#fff';
  document.getElementById('sm_footer_text_color').color.fromString('#fff');
}
if($('sm_footer_link_color')) {
  $('sm_footer_link_color').value = '#999999';
  document.getElementById('sm_footer_link_color').color.fromString('#999999');
}
if($('sm_footer_link_hover_color')) {
  $('sm_footer_link_hover_color').value = '#e82f34';
  document.getElementById('sm_footer_link_hover_color').color.fromString('#e82f34');
}
//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
if($('sm_theme_color')) {
  $('sm_theme_color').value = '#0186bf';
  document.getElementById('sm_theme_color').color.fromString('#0186bf');
}
if($('sm_theme_secondary_color')) {
  $('sm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sm_body_background_color')) {
  $('sm_body_background_color').value = '#E3E3E3';
  document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
}
if($('sm_font_color')) {
  $('sm_font_color').value = '#555';
  document.getElementById('sm_font_color').color.fromString('#555');
}
if($('sm_font_color_light')) {
  $('sm_font_color_light').value = '#888';
  document.getElementById('sm_font_color_light').color.fromString('#888');
}

if($('sm_heading_color')) {
  $('sm_heading_color').value = '#555';
  document.getElementById('sm_heading_color').color.fromString('#555');
}
if($('sm_link_color')) {
  $('sm_link_color').value = '#222';
  document.getElementById('sm_link_color').color.fromString('#222');
}
if($('sm_link_color_hover')) {
  $('sm_link_color_hover').value = '#0186BF';
  document.getElementById('sm_link_color_hover').color.fromString('#0186BF');
}
if($('sm_content_heading_background_color')) {
  $('sm_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sm_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sm_content_background_color')) {
  $('sm_content_background_color').value = '#fff';
  document.getElementById('sm_content_background_color').color.fromString('#fff');
}
if($('sm_content_border_color')) {
  $('sm_content_border_color').value = '#eee';
  document.getElementById('sm_content_border_color').color.fromString('#eee');
}
if($('sm_content_border_color_dark')) {
  $('sm_content_border_color_dark').value = '#ddd';
  document.getElementById('sm_content_border_color_dark').color.fromString('#ddd');
}

if($('sm_input_background_color')) {
  $('sm_input_background_color').value = '#fff';
  document.getElementById('sm_input_background_color').color.fromString('#fff');
}
if($('sm_input_font_color')) {
  $('sm_input_font_color').value = '#000';
  document.getElementById('sm_input_font_color').color.fromString('#000');
}
if($('sm_input_border_color')) {
  $('sm_input_border_color').value = '#dce0e3';
  document.getElementById('sm_input_border_color').color.fromString('#dce0e3');
}
if($('sm_button_background_color')) {
  $('sm_button_background_color').value = '#0186BF';
  document.getElementById('sm_button_background_color').color.fromString('#0186BF');
}
if($('sm_button_background_color_hover')) {
  $('sm_button_background_color_hover').value = '#2B2D2E'; document.getElementById('sm_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('sm_button_background_color_active')) {
  $('sm_button_background_color_active').value = '#2B2D2E'; document.getElementById('sm_button_background_color_active').color.fromString('#2B2D2E');
}
if($('sm_button_font_color')) {
  $('sm_button_font_color').value = '#fff';
  document.getElementById('sm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sm_header_background_color')) {
  $('sm_header_background_color').value = '#fff';
  document.getElementById('sm_header_background_color').color.fromString('#fff');
}
if($('sm_header_border_color')) {
  $('sm_header_border_color').value = '#fff';
  document.getElementById('sm_header_border_color').color.fromString('#fff');
}
if($('sm_menu_logo_top_space')) {
  $('sm_menu_logo_top_space').value = '10px';
}
if($('sm_mainmenu_background_color')) {
  $('sm_mainmenu_background_color').value = '#f7f7f7';
  document.getElementById('sm_mainmenu_background_color').color.fromString('#f7f7f7');
}
if($('sm_mainmenu_background_color_hover')) {
  $('sm_mainmenu_background_color_hover').value = '#f2f2f2';
  document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#f2f2f2');
}
if($('sm_mainmenu_link_color')) {
  $('sm_mainmenu_link_color').value = '#555555';
  document.getElementById('sm_mainmenu_link_color').color.fromString('#555555');
}
if($('sm_mainmenu_link_color_hover')) {
  $('sm_mainmenu_link_color_hover').value = '#0186BF';
  document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#0186BF');
}
if($('sm_mainmenu_border_color')) {
  $('sm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sm_minimenu_link_color')) {
  $('sm_minimenu_link_color').value = '#555555';
  document.getElementById('sm_minimenu_link_color').color.fromString('#555555');
}
if($('sm_minimenu_link_color_hover')) {
  $('sm_minimenu_link_color_hover').value = '#111';
  document.getElementById('sm_minimenu_link_color_hover').color.fromString('#111');
}
if($('sm_minimenu_border_color')) {
  $('sm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sm_minimenu_icon')) {
  $('sm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sm_header_searchbox_background_color')) {
  $('sm_header_searchbox_background_color').value = '#fff'; document.getElementById('sm_header_searchbox_background_color').color.fromString('#fff');
}
if($('sm_header_searchbox_text_color')) {
  $('sm_header_searchbox_text_color').value = '#111';
  document.getElementById('sm_header_searchbox_text_color').color.fromString('#111');
}
if($('sm_header_searchbox_border_color')) {
  $('sm_header_searchbox_border_color').value = '#e3e3e3'; document.getElementById('sm_header_searchbox_border_color').color.fromString('#e3e3e3');
}
//Header Styling

//Footer Styling
if($('sm_footer_background_color')) {
  $('sm_footer_background_color').value = '#2D2D2D';
  document.getElementById('sm_footer_background_color').color.fromString('#2D2D2D');
}
if($('sm_footer_border_color')) {
  $('sm_footer_border_color').value = '#0186BF';
  document.getElementById('sm_footer_border_color').color.fromString('#0186BF');
}
if($('sm_footer_text_color')) {
  $('sm_footer_text_color').value = '#fff';
  document.getElementById('sm_footer_text_color').color.fromString('#fff');
}
if($('sm_footer_link_color')) {
  $('sm_footer_link_color').value = '#999999';
  document.getElementById('sm_footer_link_color').color.fromString('#999999');
}
if($('sm_footer_link_hover_color')) {
  $('sm_footer_link_hover_color').value = '#0186BF';
  document.getElementById('sm_footer_link_hover_color').color.fromString('#0186BF');
}
//Footer Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
if($('sm_theme_color')) {
  $('sm_theme_color').value = '#ff4700';
  document.getElementById('sm_theme_color').color.fromString('#ff4700');
}
if($('sm_theme_secondary_color')) {
  $('sm_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sm_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sm_body_background_color')) {
  $('sm_body_background_color').value = '#E3E3E3';
  document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
}
if($('sm_font_color')) {
  $('sm_font_color').value = '#555';
  document.getElementById('sm_font_color').color.fromString('#555');
}
if($('sm_font_color_light')) {
  $('sm_font_color_light').value = '#888';
  document.getElementById('sm_font_color_light').color.fromString('#888');
}

if($('sm_heading_color')) {
  $('sm_heading_color').value = '#FF4700';
  document.getElementById('sm_heading_color').color.fromString('#FF4700');
}
if($('sm_link_color')) {
  $('sm_link_color').value = '#222';
  document.getElementById('sm_link_color').color.fromString('#222');
}
if($('sm_link_color_hover')) {
  $('sm_link_color_hover').value = '#ff4700';
  document.getElementById('sm_link_color_hover').color.fromString('#ff4700');
}
if($('sm_content_heading_background_color')) {
  $('sm_content_heading_background_color').value = '#fff'; document.getElementById('sm_content_heading_background_color').color.fromString('#fff');
}
if($('sm_content_background_color')) {
  $('sm_content_background_color').value = '#fff';
  document.getElementById('sm_content_background_color').color.fromString('#fff');
}
if($('sm_content_border_color')) {
  $('sm_content_border_color').value = '#eee';
  document.getElementById('sm_content_border_color').color.fromString('#eee');
}
if($('sm_content_border_color_dark')) {
  $('sm_content_border_color_dark').value = '#ddd';
  document.getElementById('sm_content_border_color_dark').color.fromString('#ddd');
}

if($('sm_input_background_color')) {
  $('sm_input_background_color').value = '#fff';
  document.getElementById('sm_input_background_color').color.fromString('#fff');
}
if($('sm_input_font_color')) {
  $('sm_input_font_color').value = '#000';
  document.getElementById('sm_input_font_color').color.fromString('#000');
}
if($('sm_input_border_color')) {
  $('sm_input_border_color').value = '#dce0e3';
  document.getElementById('sm_input_border_color').color.fromString('#dce0e3');
}
if($('sm_button_background_color')) {
  $('sm_button_background_color').value = '#ff4700';
  document.getElementById('sm_button_background_color').color.fromString('#ff4700');
}
if($('sm_button_background_color_hover')) {
  $('sm_button_background_color_hover').value = '#2B2D2E'; document.getElementById('sm_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('sm_button_background_color_active')) {
  $('sm_button_background_color_active').value = '#2B2D2E'; document.getElementById('sm_button_background_color_active').color.fromString('#2B2D2E');
}
if($('sm_button_font_color')) {
  $('sm_button_font_color').value = '#fff';
  document.getElementById('sm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sm_header_background_color')) {
  $('sm_header_background_color').value = '#fff';
  document.getElementById('sm_header_background_color').color.fromString('#fff');
}
if($('sm_header_border_color')) {
  $('sm_header_border_color').value = '#fff';
  document.getElementById('sm_header_border_color').color.fromString('#fff');
}
if($('sm_menu_logo_top_space')) {
  $('sm_menu_logo_top_space').value = '10px';
}
if($('sm_mainmenu_background_color')) {
  $('sm_mainmenu_background_color').value = '#f7f7f7';
  document.getElementById('sm_mainmenu_background_color').color.fromString('#f7f7f7');
}
if($('sm_mainmenu_background_color_hover')) {
  $('sm_mainmenu_background_color_hover').value = '#f2f2f2';
  document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#f2f2f2');
}
if($('sm_mainmenu_link_color')) {
  $('sm_mainmenu_link_color').value = '#555555';
  document.getElementById('sm_mainmenu_link_color').color.fromString('#555555');
}
if($('sm_mainmenu_link_color_hover')) {
  $('sm_mainmenu_link_color_hover').value = '#FF4700';
  document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FF4700');
}
if($('sm_mainmenu_border_color')) {
  $('sm_mainmenu_border_color').value = '#e3e3e3';
  document.getElementById('sm_mainmenu_border_color').color.fromString('#e3e3e3');
}
if($('sm_minimenu_link_color')) {
  $('sm_minimenu_link_color').value = '#555555';
  document.getElementById('sm_minimenu_link_color').color.fromString('#555555');
}
if($('sm_minimenu_link_color_hover')) {
  $('sm_minimenu_link_color_hover').value = '#FF4700';
  document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FF4700');
}
if($('sm_minimenu_border_color')) {
  $('sm_minimenu_border_color').value = '#e3e3e3';
  document.getElementById('sm_minimenu_border_color').color.fromString('#e3e3e3');
}
if($('sm_minimenu_icon')) {
  $('sm_minimenu_icon').value = 'minimenu-icons-dark.png';
}
if($('sm_header_searchbox_background_color')) {
  $('sm_header_searchbox_background_color').value = '#ffffff'; document.getElementById('sm_header_searchbox_background_color').color.fromString('#ffffff');
}
if($('sm_header_searchbox_text_color')) {
  $('sm_header_searchbox_text_color').value = '#111';
  document.getElementById('sm_header_searchbox_text_color').color.fromString('#111');
}
if($('sm_header_searchbox_border_color')) {
  $('sm_header_searchbox_border_color').value = '#e3e3e3'; document.getElementById('sm_header_searchbox_border_color').color.fromString('#e3e3e3');
}
//Header Styling

//Footer Styling
if($('sm_footer_background_color')) {
  $('sm_footer_background_color').value = '#2D2D2D';
  document.getElementById('sm_footer_background_color').color.fromString('#2D2D2D');
}
if($('sm_footer_border_color')) {
  $('sm_footer_border_color').value = '#ff4700';
  document.getElementById('sm_footer_border_color').color.fromString('#ff4700');
}
if($('sm_footer_text_color')) {
  $('sm_footer_text_color').value = '#fff';
  document.getElementById('sm_footer_text_color').color.fromString('#fff');
}
if($('sm_footer_link_color')) {
  $('sm_footer_link_color').value = '#999999';
  document.getElementById('sm_footer_link_color').color.fromString('#999999');
}
if($('sm_footer_link_hover_color')) {
  $('sm_footer_link_hover_color').value = '#ff4700';
  document.getElementById('sm_footer_link_hover_color').color.fromString('#ff4700');
}
//Footer Styling
		}
		else if(value == 4) {
			//Theme Base Styling
if($('sm_theme_color')) {
  $('sm_theme_color').value = '#FFC000';
  document.getElementById('sm_theme_color').color.fromString('#FFC000');
}
if($('sm_theme_secondary_color')) {
  $('sm_theme_secondary_color').value = '#DDDDDD';
  document.getElementById('sm_theme_secondary_color').color.fromString('#DDDDDD');
}
//Theme Base Styling

//Body Styling
if($('sm_body_background_color')) {
  $('sm_body_background_color').value = '#222222';
  document.getElementById('sm_body_background_color').color.fromString('#222222');
}
if($('sm_font_color')) {
  $('sm_font_color').value = '#ddd';
  document.getElementById('sm_font_color').color.fromString('#ddd');
}
if($('sm_font_color_light')) {
  $('sm_font_color_light').value = '#999';
  document.getElementById('sm_font_color_light').color.fromString('#999');
}

if($('sm_heading_color')) {
  $('sm_heading_color').value = '#ddd';
  document.getElementById('sm_heading_color').color.fromString('#ddd');
}
if($('sm_link_color')) {
  $('sm_link_color').value = '#fff';
  document.getElementById('sm_link_color').color.fromString('#fff');
}
if($('sm_link_color_hover')) {
  $('sm_link_color_hover').value = '#FFC000';
  document.getElementById('sm_link_color_hover').color.fromString('#FFC000');
}
if($('sm_content_heading_background_color')) {
  $('sm_content_heading_background_color').value = '#2f2f2f'; document.getElementById('sm_content_heading_background_color').color.fromString('#2f2f2f');
}
if($('sm_content_background_color')) {
  $('sm_content_background_color').value = '#2f2f2f';
  document.getElementById('sm_content_background_color').color.fromString('#2f2f2f');
}
if($('sm_content_border_color')) {
  $('sm_content_border_color').value = '#383838';
  document.getElementById('sm_content_border_color').color.fromString('#383838');
}
if($('sm_content_border_color_dark')) {
  $('sm_content_border_color_dark').value = '#535353';
  document.getElementById('sm_content_border_color_dark').color.fromString('#535353');
}

if($('sm_input_background_color')) {
  $('sm_input_background_color').value = '#4c4c4c';
  document.getElementById('sm_input_background_color').color.fromString('#4c4c4c');
}
if($('sm_input_font_color')) {
  $('sm_input_font_color').value = '#ddd';
  document.getElementById('sm_input_font_color').color.fromString('#ddd');
}
if($('sm_input_border_color')) {
  $('sm_input_border_color').value = '#666';
  document.getElementById('sm_input_border_color').color.fromString('#666');
}
if($('sm_button_background_color')) {
  $('sm_button_background_color').value = '#FFC000';
  document.getElementById('sm_button_background_color').color.fromString('#ffc000');
}
if($('sm_button_background_color_hover')) {
  $('sm_button_background_color_hover').value = '#797979'; document.getElementById('sm_button_background_color_hover').color.fromString('#797979');
}
if($('sm_button_background_color_active')) {
  $('sm_button_background_color_active').value = '#797979'; document.getElementById('sm_button_background_color_active').color.fromString('#797979');
}
if($('sm_button_font_color')) {
  $('sm_button_font_color').value = '#fff';
  document.getElementById('sm_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sm_header_background_color')) {
  $('sm_header_background_color').value = '#151515';
  document.getElementById('sm_header_background_color').color.fromString('#151515');
}
if($('sm_header_border_color')) {
  $('sm_header_border_color').value = '#222222';
  document.getElementById('sm_header_border_color').color.fromString('#222222');
}
if($('sm_menu_logo_top_space')) {
  $('sm_menu_logo_top_space').value = '10px';
}
if($('sm_mainmenu_background_color')) {
  $('sm_mainmenu_background_color').value = '#0D0D0D';
  document.getElementById('sm_mainmenu_background_color').color.fromString('#0D0D0D');
}
if($('sm_mainmenu_background_color_hover')) {
  $('sm_mainmenu_background_color_hover').value = '#080808';
  document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#080808');
}
if($('sm_mainmenu_link_color')) {
  $('sm_mainmenu_link_color').value = '#DDDDDD';
  document.getElementById('sm_mainmenu_link_color').color.fromString('#DDDDDD');
}
if($('sm_mainmenu_link_color_hover')) {
  $('sm_mainmenu_link_color_hover').value = '#FFC000';
  document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFC000');
}
if($('sm_mainmenu_border_color')) {
  $('sm_mainmenu_border_color').value = '#222222';
  document.getElementById('sm_mainmenu_border_color').color.fromString('#222222');
}
if($('sm_minimenu_link_color')) {
  $('sm_minimenu_link_color').value = '#DDDDDD';
  document.getElementById('sm_minimenu_link_color').color.fromString('#DDDDDD');
}
if($('sm_minimenu_link_color_hover')) {
  $('sm_minimenu_link_color_hover').value = '#FFC000';
  document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFC000');
}
if($('sm_minimenu_border_color')) {
  $('sm_minimenu_border_color').value = '#666666';
  document.getElementById('sm_minimenu_border_color').color.fromString('#666666');
}
if($('sm_minimenu_icon')) {
  $('sm_minimenu_icon').value = 'minimenu-icons-gray.png';
}
if($('sm_header_searchbox_background_color')) {
  $('sm_header_searchbox_background_color').value = '#4c4c4c'; document.getElementById('sm_header_searchbox_background_color').color.fromString('#4c4c4c');
}
if($('sm_header_searchbox_text_color')) {
  $('sm_header_searchbox_text_color').value = '#ddd';
  document.getElementById('sm_header_searchbox_text_color').color.fromString('#ddd');
}
if($('sm_header_searchbox_border_color')) {
  $('sm_header_searchbox_border_color').value = '#666'; document.getElementById('sm_header_searchbox_border_color').color.fromString('#666');
}
//Header Styling

//Footer Styling
if($('sm_footer_background_color')) {
  $('sm_footer_background_color').value = '#151515';
  document.getElementById('sm_footer_background_color').color.fromString('#151515');
}
if($('sm_footer_border_color')) {
  $('sm_footer_border_color').value = '#ffc000';
  document.getElementById('sm_footer_border_color').color.fromString('#ffc000');
}
if($('sm_footer_text_color')) {
  $('sm_footer_text_color').value = '#fff';
  document.getElementById('sm_footer_text_color').color.fromString('#fff');
}
if($('sm_footer_link_color')) {
  $('sm_footer_link_color').value = '#999999';
  document.getElementById('sm_footer_link_color').color.fromString('#999999');
}
if($('sm_footer_link_hover_color')) {
  $('sm_footer_link_hover_color').value = '#ffc000';
  document.getElementById('sm_footer_link_hover_color').color.fromString('#ffc000');
}
//Footer Styling
		}
    else if(value == 6) {
			//Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '#3EA9A9';
        document.getElementById('sm_theme_color').color.fromString('#3EA9A9');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '#FF5F3F';
        document.getElementById('sm_theme_secondary_color').color.fromString('#FF5F3F');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '#E3E3E3';
        document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '#555555';
        document.getElementById('sm_font_color').color.fromString('#555555');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '#888888';
        document.getElementById('sm_font_color_light').color.fromString('#888888');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '#555555';
        document.getElementById('sm_heading_color').color.fromString('#555555');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '#3EA9A9';
        document.getElementById('sm_link_color').color.fromString('#3EA9A9');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '#FF5F3F';
        document.getElementById('sm_link_color_hover').color.fromString('#FF5F3F');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '#FFFFFF';
        document.getElementById('sm_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '#EEEEEE';
        document.getElementById('sm_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sm_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '#FFFFFF';
        document.getElementById('sm_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '#000000';
        document.getElementById('sm_input_font_color').color.fromString('#000000');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '#DCE0E3';
        document.getElementById('sm_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '#FF5F3F';
        document.getElementById('sm_button_background_color').color.fromString('#FF5F3F');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '#3EA9A9'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('#3EA9A9');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '#3EA9A9'; 
        document.getElementById('sm_button_background_color_active').color.fromString('#3EA9A9');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '#FFFFFF';
        document.getElementById('sm_button_font_color').color.fromString('#FFFFFF');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '#54BFBF';
        document.getElementById('sm_header_background_color').color.fromString('#54BFBF');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '#339797';
        document.getElementById('sm_header_border_color').color.fromString('#339797');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '#3EA9A9';
        document.getElementById('sm_mainmenu_background_color').color.fromString('#3EA9A9');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '#47B5B5';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#47B5B5');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '#339797';
        document.getElementById('sm_mainmenu_border_color').color.fromString('#339797');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '#111111';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '#2D2D2D';
        document.getElementById('sm_footer_background_color').color.fromString('#2D2D2D');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '#FF5F3F';
        document.getElementById('sm_footer_border_color').color.fromString('#FF5F3F');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '#FFFFFF';
        document.getElementById('sm_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '#999999';
        document.getElementById('sm_footer_link_color').color.fromString('#999999');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '#3EA9A9';
        document.getElementById('sm_footer_link_hover_color').color.fromString('#3EA9A9');
      }
      //Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '#00B841';
        document.getElementById('sm_theme_color').color.fromString('#00B841');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '#31302B';
        document.getElementById('sm_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '#E3E3E3';
        document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '#555555';
        document.getElementById('sm_font_color').color.fromString('#555555');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '#888888';
        document.getElementById('sm_font_color_light').color.fromString('#888888');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '#555555';
        document.getElementById('sm_heading_color').color.fromString('#555555');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '#111111';
        document.getElementById('sm_link_color').color.fromString('#111111');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '#00B841';
        document.getElementById('sm_link_color_hover').color.fromString('#00B841');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '#FFFFFF';
        document.getElementById('sm_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '#EEEEEE';
        document.getElementById('sm_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sm_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '#FFFFFF';
        document.getElementById('sm_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '#000000';
        document.getElementById('sm_input_font_color').color.fromString('#000000');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '#DCE0E3';
        document.getElementById('sm_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '#25783C';
        document.getElementById('sm_button_background_color').color.fromString('#25783C');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '#31302B'; 
        document.getElementById('sm_button_background_color_active').color.fromString('#31302B');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '#FFFFFF';
        document.getElementById('sm_button_font_color').color.fromString('#FFFFFF');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '#00B841';
        document.getElementById('sm_header_background_color').color.fromString('#00B841');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '#00B841';
        document.getElementById('sm_header_border_color').color.fromString('#00B841');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '#31302B';
        document.getElementById('sm_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '#01BE44';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#01BE44');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '#31302B';
        document.getElementById('sm_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '#111111';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '#31302B';
        document.getElementById('sm_footer_background_color').color.fromString('#31302B');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '#00B841';
        document.getElementById('sm_footer_border_color').color.fromString('#00B841');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '#FFFFFF';
        document.getElementById('sm_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '#999999';
        document.getElementById('sm_footer_link_color').color.fromString('#999999');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '#00B841';
        document.getElementById('sm_footer_link_hover_color').color.fromString('#00B841');
      }
      //Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '#A61C28';
        document.getElementById('sm_theme_color').color.fromString('#A61C28');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '#31302B';
        document.getElementById('sm_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '#E3E3E3';
        document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '#555555';
        document.getElementById('sm_font_color').color.fromString('#555555');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '#888888';
        document.getElementById('sm_font_color_light').color.fromString('#888888');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '#555555';
        document.getElementById('sm_heading_color').color.fromString('#555555');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '#111111';
        document.getElementById('sm_link_color').color.fromString('#111111');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '#A61C28';
        document.getElementById('sm_link_color_hover').color.fromString('#A61C28');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '#FFFFFF';
        document.getElementById('sm_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '#EEEEEE';
        document.getElementById('sm_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sm_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '#FFFFFF';
        document.getElementById('sm_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '#000000';
        document.getElementById('sm_input_font_color').color.fromString('#000000');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '#DCE0E3';
        document.getElementById('sm_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '#730710';
        document.getElementById('sm_button_background_color').color.fromString('#730710');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '#31302B'; 
        document.getElementById('sm_button_background_color_active').color.fromString('#31302B');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '#FFFFFF';
        document.getElementById('sm_button_font_color').color.fromString('#FFFFFF');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '#A61C28';
        document.getElementById('sm_header_background_color').color.fromString('#A61C28');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '#A61C28';
        document.getElementById('sm_header_border_color').color.fromString('#A61C28');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '#31302B';
        document.getElementById('sm_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '#9C1824';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#9C1824');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '#31302B';
        document.getElementById('sm_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '#111111';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '#31302B';
        document.getElementById('sm_footer_background_color').color.fromString('#31302B');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '#A61C28';
        document.getElementById('sm_footer_border_color').color.fromString('#A61C28');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '#FFFFFF';
        document.getElementById('sm_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '#999999';
        document.getElementById('sm_footer_link_color').color.fromString('#999999');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '#A61C28';
        document.getElementById('sm_footer_link_hover_color').color.fromString('#A61C28');
      }
      //Footer Styling
    }
    else if(value == 9) {
      //Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '#EF672F';
        document.getElementById('sm_theme_color').color.fromString('#EF672F');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '#31302B';
        document.getElementById('sm_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '#E3E3E3';
        document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '#555555';
        document.getElementById('sm_font_color').color.fromString('#555555');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '#888888';
        document.getElementById('sm_font_color_light').color.fromString('#888888');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '#555555';
        document.getElementById('sm_heading_color').color.fromString('#555555');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '#111111';
        document.getElementById('sm_link_color').color.fromString('#111111');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '#EF672F';
        document.getElementById('sm_link_color_hover').color.fromString('#EF672F');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '#FFFFFF';
        document.getElementById('sm_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '#EEEEEE';
        document.getElementById('sm_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sm_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '#FFFFFF';
        document.getElementById('sm_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '#000000';
        document.getElementById('sm_input_font_color').color.fromString('#000000');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '#DCE0E3';
        document.getElementById('sm_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '#C14800';
        document.getElementById('sm_button_background_color').color.fromString('#C14800');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '#31302B'; 
        document.getElementById('sm_button_background_color_active').color.fromString('#31302B');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '#FFFFFF';
        document.getElementById('sm_button_font_color').color.fromString('#FFFFFF');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '#EF672F';
        document.getElementById('sm_header_background_color').color.fromString('#EF672F');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '#EF672F';
        document.getElementById('sm_header_border_color').color.fromString('#EF672F');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '#31302B';
        document.getElementById('sm_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '#F28558';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#F28558');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '#31302B';
        document.getElementById('sm_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '#111111';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '#31302B';
        document.getElementById('sm_footer_background_color').color.fromString('#31302B');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '#EF672F';
        document.getElementById('sm_footer_border_color').color.fromString('#EF672F');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '#FFFFFF';
        document.getElementById('sm_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '#999999';
        document.getElementById('sm_footer_link_color').color.fromString('#999999');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '#EF672F';
        document.getElementById('sm_footer_link_hover_color').color.fromString('#EF672F');
      }
      //Footer Styling
    }
    else if(value == 10) {
      //Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '#0DC7F1';
        document.getElementById('sm_theme_color').color.fromString('#0DC7F1');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '#31302B';
        document.getElementById('sm_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '#E3E3E3';
        document.getElementById('sm_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '#555555';
        document.getElementById('sm_font_color').color.fromString('#555555');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '#888888';
        document.getElementById('sm_font_color_light').color.fromString('#888888');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '#555555';
        document.getElementById('sm_heading_color').color.fromString('#555555');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '#111111';
        document.getElementById('sm_link_color').color.fromString('#111111');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '#0DC7F1';
        document.getElementById('sm_link_color_hover').color.fromString('#0DC7F1');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '#FFFFFF';
        document.getElementById('sm_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '#EEEEEE';
        document.getElementById('sm_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sm_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '#FFFFFF';
        document.getElementById('sm_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '#000000';
        document.getElementById('sm_input_font_color').color.fromString('#000000');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '#DCE0E3';
        document.getElementById('sm_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '#60ACC9';
        document.getElementById('sm_button_background_color').color.fromString('#60ACC9');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '#31302B'; 
        document.getElementById('sm_button_background_color_active').color.fromString('#31302B');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '#FFFFFF';
        document.getElementById('sm_button_font_color').color.fromString('#FFFFFF');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '#0DC7F1';
        document.getElementById('sm_header_background_color').color.fromString('#0DC7F1');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '#0DC7F1';
        document.getElementById('sm_header_border_color').color.fromString('#0DC7F1');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '#31302B';
        document.getElementById('sm_mainmenu_background_color').color.fromString('#31302B');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '#60ACC9';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('#60ACC9');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '#31302B';
        document.getElementById('sm_mainmenu_border_color').color.fromString('#31302B');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '#FFFFFF';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '#FFFFFF';
        document.getElementById('sm_minimenu_border_color').color.fromString('#FFFFFF');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '#FFFFFF'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('#FFFFFF');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '#111111';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('#111111');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '#DDDDDD'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('#DDDDDD');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '#31302B';
        document.getElementById('sm_footer_background_color').color.fromString('#31302B');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '#0DC7F1';
        document.getElementById('sm_footer_border_color').color.fromString('#0DC7F1');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '#FFFFFF';
        document.getElementById('sm_footer_text_color').color.fromString('#FFFFFF');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '#999999';
        document.getElementById('sm_footer_link_color').color.fromString('#999999');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '#0DC7F1';
        document.getElementById('sm_footer_link_hover_color').color.fromString('#0DC7F1');
      }
      //Footer Styling
    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('sm_theme_color')) {
        $('sm_theme_color').value = '<?php echo $settings->getSetting('sm.theme.color') ?>';
        document.getElementById('sm_theme_color').color.fromString('<?php echo $settings->getSetting('sm.theme.color') ?>');
      }
      if($('sm_theme_secondary_color')) {
        $('sm_theme_secondary_color').value = '<?php echo $settings->getSetting('sm.theme.secondary.color') ?>';
        document.getElementById('sm_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('sm.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sm_body_background_color')) {
        $('sm_body_background_color').value = '<?php echo $settings->getSetting('sm.body.background.color') ?>';
        document.getElementById('sm_body_background_color').color.fromString('<?php echo $settings->getSetting('sm.body.background.color') ?>');
      }
      if($('sm_font_color')) {
        $('sm_font_color').value = '<?php echo $settings->getSetting('sm.fontcolor') ?>';
        document.getElementById('sm_font_color').color.fromString('<?php echo $settings->getSetting('sm.fontcolor') ?>');
      }
      if($('sm_font_color_light')) {
        $('sm_font_color_light').value = '<?php echo $settings->getSetting('sm.font.color.light') ?>';
        document.getElementById('sm_font_color_light').color.fromString('<?php echo $settings->getSetting('sm.font.color.light') ?>');
      }
      if($('sm_heading_color')) {
        $('sm_heading_color').value = '<?php echo $settings->getSetting('sm.heading.color') ?>';
        document.getElementById('sm_heading_color').color.fromString('<?php echo $settings->getSetting('sm.heading.color') ?>');
      }
      if($('sm_link_color')) {
        $('sm_link_color').value = '<?php echo $settings->getSetting('sm.linkcolor') ?>';
        document.getElementById('sm_link_color').color.fromString('<?php echo $settings->getSetting('sm.linkcolor') ?>');
      }
      if($('sm_link_color_hover')) {
        $('sm_link_color_hover').value = '<?php echo $settings->getSetting('sm.link.color.hover') ?>';
        document.getElementById('sm_link_color_hover').color.fromString('<?php echo $settings->getSetting('sm.link.color.hover') ?>');
      }
      if($('sm_content_heading_background_color')) {
        $('sm_content_heading_background_color').value = '<?php echo $settings->getSetting('sm.content.heading.background.color') ?>'; 
        document.getElementById('sm_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('sm.content.heading.background.color') ?>');
      }
      if($('sm_content_background_color')) {
        $('sm_content_background_color').value = '<?php echo $settings->getSetting('sm.content.background.color') ?>';
        document.getElementById('sm_content_background_color').color.fromString('<?php echo $settings->getSetting('sm.content.background.color') ?>');
      }
      if($('sm_content_border_color')) {
        $('sm_content_border_color').value = '<?php echo $settings->getSetting('sm.content.bordercolor') ?>';
        document.getElementById('sm_content_border_color').color.fromString('<?php echo $settings->getSetting('sm.content.bordercolor') ?>');
      }
      if($('sm_content_border_color_dark')) {
        $('sm_content_border_color_dark').value = '<?php echo $settings->getSetting('sm.content.border.color.dark') ?>';
        document.getElementById('sm_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('sm.content.border.color.dark') ?>');
      }
      if($('sm_input_background_color')) {
        $('sm_input_background_color').value = '<?php echo $settings->getSetting('sm.input.background.color') ?>';
        document.getElementById('sm_input_background_color').color.fromString('<?php echo $settings->getSetting('sm.input.background.color') ?>');
      }
      if($('sm_input_font_color')) {
        $('sm_input_font_color').value = '<?php echo $settings->getSetting('sm.input.font.color') ?>';
        document.getElementById('sm_input_font_color').color.fromString('<?php echo $settings->getSetting('sm.input.font.color') ?>');
      }
      if($('sm_input_border_color')) {
        $('sm_input_border_color').value = '<?php echo $settings->getSetting('sm.input.border.color') ?>';
        document.getElementById('sm_input_border_color').color.fromString('<?php echo $settings->getSetting('sm.input.border.color') ?>');
      }
      if($('sm_button_background_color')) {
        $('sm_button_background_color').value = '<?php echo $settings->getSetting('sm.button.backgroundcolor') ?>';
        document.getElementById('sm_button_background_color').color.fromString('<?php echo $settings->getSetting('sm.button.backgroundcolor') ?>');
      }
      if($('sm_button_background_color_hover')) {
        $('sm_button_background_color_hover').value = '<?php echo $settings->getSetting('sm.button.background.color.hover') ?>'; 
        document.getElementById('sm_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('sm.button.background.color.hover') ?>');
      }
      if($('sm_button_background_color_active')) {
        $('sm_button_background_color_active').value = '<?php echo $settings->getSetting('sm.button.background.color.active') ?>'; 
        document.getElementById('sm_button_background_color_active').color.fromString('<?php echo $settings->getSetting('sm.button.background.color.active') ?>');
      }
      if($('sm_button_font_color')) {
        $('sm_button_font_color').value = '<?php echo $settings->getSetting('sm.button.font.color') ?>';
        document.getElementById('sm_button_font_color').color.fromString('<?php echo $settings->getSetting('sm.button.font.color') ?>');
      }
      //Body Styling
      //Header Styling
      if($('sm_header_background_color')) {
        $('sm_header_background_color').value = '<?php echo $settings->getSetting('sm.header.background.color') ?>';
        document.getElementById('sm_header_background_color').color.fromString('<?php echo $settings->getSetting('sm.header.background.color') ?>');
      }
      if($('sm_header_border_color')) {
        $('sm_header_border_color').value = '<?php echo $settings->getSetting('sm.header.border.color') ?>';
        document.getElementById('sm_header_border_color').color.fromString('<?php echo $settings->getSetting('sm.header.border.color') ?>');
      }
      if($('sm_menu_logo_top_space')) {
        $('sm_menu_logo_top_space').value = '10px';
      }
      if($('sm_mainmenu_background_color')) {
        $('sm_mainmenu_background_color').value = '<?php echo $settings->getSetting('sm.mainmenu.backgroundcolor') ?>';
        document.getElementById('sm_mainmenu_background_color').color.fromString('<?php echo $settings->getSetting('sm.mainmenu.backgroundcolor') ?>');
      }
      if($('sm_mainmenu_background_color_hover')) {
        $('sm_mainmenu_background_color_hover').value = '<?php echo $settings->getSetting('sm.mainmenu.background.color.hover') ?>';
        document.getElementById('sm_mainmenu_background_color_hover').color.fromString('<?php echo $settings->getSetting('sm.mainmenu.background.color.hover') ?>');
      }
      if($('sm_mainmenu_link_color')) {
        $('sm_mainmenu_link_color').value = '<?php echo $settings->getSetting('sm.mainmenu.linkcolor') ?>';
        document.getElementById('sm_mainmenu_link_color').color.fromString('<?php echo $settings->getSetting('sm.mainmenu.linkcolor') ?>');
      }
      if($('sm_mainmenu_link_color_hover')) {
        $('sm_mainmenu_link_color_hover').value = '<?php echo $settings->getSetting('sm.mainmenu.link.color.hover') ?>';
        document.getElementById('sm_mainmenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sm.mainmenu.link.color.hover') ?>');
      }
      if($('sm_mainmenu_border_color')) {
        $('sm_mainmenu_border_color').value = '<?php echo $settings->getSetting('sm.mainmenu.border.color') ?>';
        document.getElementById('sm_mainmenu_border_color').color.fromString('<?php echo $settings->getSetting('sm.mainmenu.border.color') ?>');
      }
      if($('sm_minimenu_link_color')) {
        $('sm_minimenu_link_color').value = '<?php echo $settings->getSetting('sm.minimenu.linkcolor') ?>';
        document.getElementById('sm_minimenu_link_color').color.fromString('<?php echo $settings->getSetting('sm.minimenu.linkcolor') ?>');
      }
      if($('sm_minimenu_link_color_hover')) {
        $('sm_minimenu_link_color_hover').value = '<?php echo $settings->getSetting('sm.minimenu.link.color.hover') ?>';
        document.getElementById('sm_minimenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sm.minimenu.link.color.hover') ?>');
      }
      if($('sm_minimenu_border_color')) {
        $('sm_minimenu_border_color').value = '<?php echo $settings->getSetting('sm.minimenu.border.color') ?>';
        document.getElementById('sm_minimenu_border_color').color.fromString('<?php echo $settings->getSetting('sm.minimenu.border.color') ?>');
      }
      if($('sm_minimenu_icon')) {
        $('sm_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sm_header_searchbox_background_color')) {
        $('sm_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sm.header.searchbox.background.color') ?>'; 
        document.getElementById('sm_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('sm.header.searchbox.background.color') ?>');
      }
      if($('sm_header_searchbox_text_color')) {
        $('sm_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sm.header.searchbox.text.color') ?>';
        document.getElementById('sm_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('sm.header.searchbox.text.color') ?>');
      }
      if($('sm_header_searchbox_border_color')) {
        $('sm_header_searchbox_border_color').value = '<?php echo $settings->getSetting('sm.header.searchbox.border.color') ?>'; 
        document.getElementById('sm_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('sm.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('sm_footer_background_color')) {
        $('sm_footer_background_color').value = '<?php echo $settings->getSetting('sm.footer.background.color') ?>';
        document.getElementById('sm_footer_background_color').color.fromString('<?php echo $settings->getSetting('sm.footer.background.color') ?>');
      }
      if($('sm_footer_border_color')) {
        $('sm_footer_border_color').value = '<?php echo $settings->getSetting('sm.footer.border.color') ?>';
        document.getElementById('sm_footer_border_color').color.fromString('<?php echo $settings->getSetting('sm.footer.border.color') ?>');
      }
      if($('sm_footer_text_color')) {
        $('sm_footer_text_color').value = '<?php echo $settings->getSetting('sm.footer.text.color') ?>';
        document.getElementById('sm_footer_text_color').color.fromString('<?php echo $settings->getSetting('sm.footer.text.color') ?>');
      }
      if($('sm_footer_link_color')) {
        $('sm_footer_link_color').value = '<?php echo $settings->getSetting('sm.footer.link.color') ?>';
        document.getElementById('sm_footer_link_color').color.fromString('<?php echo $settings->getSetting('sm.footer.link.color') ?>');
      }
      if($('sm_footer_link_hover_color')) {
        $('sm_footer_link_hover_color').value = '<?php echo $settings->getSetting('sm.footer.link.hover.color') ?>';
        document.getElementById('sm_footer_link_hover_color').color.fromString('<?php echo $settings->getSetting('sm.footer.link.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>