<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessportz_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sessportz()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {
	  changeThemeColor(value, 'custom');
  }


	function changeThemeColor(value, custom) {
	
	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4)) {
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
if($('sessportz_theme_color')) {
  $('sessportz_theme_color').value = '#00aeff';
  document.getElementById('sessportz_theme_color').color.fromString('#00aeff');
}
if($('sessportz_theme_secondary_color')) {
  $('sessportz_theme_secondary_color').value = '#a5bad5';
  document.getElementById('sessportz_theme_secondary_color').color.fromString('#a5bad5');
}
//Theme Base Styling

//Body Styling
if($('sessportz_body_background_color')) {
  $('sessportz_body_background_color').value = '#1e364d';
  document.getElementById('sessportz_body_background_color').color.fromString('#1e364d');
}
if($('sessportz_font_color')) {
  $('sessportz_font_color').value = '#a5bad5';
  document.getElementById('sessportz_font_color').color.fromString('#a5bad5');
}
if($('sessportz_font_color_light')) {
  $('sessportz_font_color_light').value = '#a5bad5';
  document.getElementById('sessportz_font_color_light').color.fromString('#a5bad5');
}

if($('sessportz_heading_color')) {
  $('sessportz_heading_color').value = '#00aeff';
  document.getElementById('sessportz_heading_color').color.fromString('#00aeff');
}
if($('sessportz_link_color')) {
  $('sessportz_link_color').value = '#fff';
  document.getElementById('sessportz_link_color').color.fromString('#fff');
}
if($('sessportz_link_color_hover')) {
  $('sessportz_link_color_hover').value = '#00AEFF';
  document.getElementById('sessportz_link_color_hover').color.fromString('#00AEFF');
}
if($('sessportz_content_heading_background_color')) {
  $('sessportz_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sessportz_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sessportz_content_background_color')) {
  $('sessportz_content_background_color').value = '#1e364d';
  document.getElementById('sessportz_content_background_color').color.fromString('#1e364d');
}
if($('sessportz_content_border_color')) {
  $('sessportz_content_border_color').value = '#244565';
  document.getElementById('sessportz_content_border_color').color.fromString('#244565');
}
if($('sessportz_content_border_color_dark')) {
  $('sessportz_content_border_color_dark').value = '#244565';
  document.getElementById('sessportz_content_border_color_dark').color.fromString('#244565');
}

if($('sessportz_input_background_color')) {
  $('sessportz_input_background_color').value = '#1e364d';
  document.getElementById('sessportz_input_background_color').color.fromString('#1e364d');
}
if($('sessportz_input_font_color')) {
  $('sessportz_input_font_color').value = '#a5bad5';
  document.getElementById('sessportz_input_font_color').color.fromString('#a5bad5');
}
if($('sessportz_input_border_color')) {
  $('sessportz_input_border_color').value = '#244565';
  document.getElementById('sessportz_input_border_color').color.fromString('#244565');
}
if($('sessportz_button_background_color')) {
  $('sessportz_button_background_color').value = '#00AEFF';
  document.getElementById('sessportz_button_background_color').color.fromString('#00AEFF');
}
if($('sessportz_button_background_color_hover')) {
  $('sessportz_button_background_color_hover').value = '#2F5B85'; document.getElementById('sessportz_button_background_color_hover').color.fromString('#2F5B85');
}
if($('sessportz_button_background_color_active')) {
  $('sessportz_button_background_color_active').value = '#00AEFF'; document.getElementById('sessportz_button_background_color_active').color.fromString('#00AEFF');
}
if($('sessportz_button_font_color')) {
  $('sessportz_button_font_color').value = '#fff';
  document.getElementById('sessportz_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sessportz_header_background_color')) {
  $('sessportz_header_background_color').value = '#192c3e';
  document.getElementById('sessportz_header_background_color').color.fromString('#192c3e');
}
if($('sessportz_header_border_color')) {
  $('sessportz_header_border_color').value = '#244565';
  document.getElementById('sessportz_header_border_color').color.fromString('#244565');
}
if($('sessportz_menu_logo_top_space')) {
  $('sessportz_menu_logo_top_space').value = '10px';
}
if($('sessportz_mainmenu_background_color')) {
  $('sessportz_mainmenu_background_color').value = '#285183';
  document.getElementById('sessportz_mainmenu_background_color').color.fromString('#285183');
}
if($('sessportz_mainmenu_background_color_hover')) {
  $('sessportz_mainmenu_background_color_hover').value = '#00aeff';
  document.getElementById('sessportz_mainmenu_background_color_hover').color.fromString('#00aeff');
}
if($('sessportz_mainmenu_link_color')) {
  $('sessportz_mainmenu_link_color').value = '#00aeff';
  document.getElementById('sessportz_mainmenu_link_color').color.fromString('#00aeff');
}
if($('sessportz_mainmenu_link_color_hover')) {
  $('sessportz_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sessportz_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sessportz_mainmenu_border_color')) {
  $('sessportz_mainmenu_border_color').value = '#222';
  document.getElementById('sessportz_mainmenu_border_color').color.fromString('#222');
}
if($('sessportz_minimenu_link_color')) {
  $('sessportz_minimenu_link_color').value = '#a5bad5';
  document.getElementById('sessportz_minimenu_link_color').color.fromString('#a5bad5');
}
if($('sessportz_minimenu_link_color_hover')) {
  $('sessportz_minimenu_link_color_hover').value = '#00aeff';
  document.getElementById('sessportz_minimenu_link_color_hover').color.fromString('#00aeff');
}
if($('sessportz_minimenu_border_color')) {
  $('sessportz_minimenu_border_color').value = '#aaa';
  document.getElementById('sessportz_minimenu_border_color').color.fromString('#aaa');
}
if($('sessportz_minimenu_icon')) {
  $('sessportz_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('sessportz_header_searchbox_background_color')) {
  $('sessportz_header_searchbox_background_color').value = '#192c3e'; document.getElementById('sessportz_header_searchbox_background_color').color.fromString('#192c3e');
}
if($('sessportz_header_searchbox_text_color')) {
  $('sessportz_header_searchbox_text_color').value = '#a5bad5';
  document.getElementById('sessportz_header_searchbox_text_color').color.fromString('#a5bad5');
}
if($('sessportz_header_searchbox_border_color')) {
  $('sessportz_header_searchbox_border_color').value = '#244565';
  document.getElementById('sessportz_header_searchbox_border_color').color.fromString('#244565');
}
//Header Styling

//Footer Styling
if($('sessportz_footer_background_color')) {
  $('sessportz_footer_background_color').value = '#14212f';
  document.getElementById('sessportz_footer_background_color').color.fromString('#14212f');
}
if($('sessportz_footer_border_color')) {
  $('sessportz_footer_border_color').value = '#1b2d40';
  document.getElementById('sessportz_footer_border_color').color.fromString('#1b2d40');
}
if($('sessportz_footer_text_color')) {
  $('sessportz_footer_text_color').value = '#fff';
  document.getElementById('sessportz_footer_text_color').color.fromString('#fff');
}
if($('sessportz_footer_link_color')) {
  $('sessportz_footer_link_color').value = '#929599';
  document.getElementById('sessportz_footer_link_color').color.fromString('#929599');
}
if($('sessportz_footer_link_hover_color')) {
  $('sessportz_footer_link_hover_color').value = '#00AEFF';
  document.getElementById('sessportz_footer_link_hover_color').color.fromString('#00AEFF');
}
//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
if($('sessportz_theme_color')) {
  $('sessportz_theme_color').value = '#f92552';
  document.getElementById('sessportz_theme_color').color.fromString('#f92552');
}
if($('sessportz_theme_secondary_color')) {
  $('sessportz_theme_secondary_color').value = '#9e9caa';
  document.getElementById('sessportz_theme_secondary_color').color.fromString('#9e9caa');
}
//Theme Base Styling

//Body Styling
if($('sessportz_body_background_color')) {
  $('sessportz_body_background_color').value = '#1e202f';
  document.getElementById('sessportz_body_background_color').color.fromString('#1e202f');
}
if($('sessportz_font_color')) {
  $('sessportz_font_color').value = '#9e9caa';
  document.getElementById('sessportz_font_color').color.fromString('#9e9caa');
}
if($('sessportz_font_color_light')) {
  $('sessportz_font_color_light').value = '#9e9caa';
  document.getElementById('sessportz_font_color_light').color.fromString('#9e9caa');
}

if($('sessportz_heading_color')) {
  $('sessportz_heading_color').value = '#fff';
  document.getElementById('sessportz_heading_color').color.fromString('#fff');
}
if($('sessportz_link_color')) {
  $('sessportz_link_color').value = '#fff';
  document.getElementById('sessportz_link_color').color.fromString('#fff');
}
if($('sessportz_link_color_hover')) {
  $('sessportz_link_color_hover').value = '#f92552';
  document.getElementById('sessportz_link_color_hover').color.fromString('#f92552');
}
if($('sessportz_content_heading_background_color')) {
  $('sessportz_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sessportz_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sessportz_content_background_color')) {
  $('sessportz_content_background_color').value = '#1e202f';
  document.getElementById('sessportz_content_background_color').color.fromString('#1e202f');
}
if($('sessportz_content_border_color')) {
  $('sessportz_content_border_color').value = '#3c3b5b';
  document.getElementById('sessportz_content_border_color').color.fromString('#3c3b5b');
}
if($('sessportz_content_border_color_dark')) {
  $('sessportz_content_border_color_dark').value = '#3c3b5b';
  document.getElementById('sessportz_content_border_color_dark').color.fromString('#3c3b5b');
}

if($('sessportz_input_background_color')) {
  $('sessportz_input_background_color').value = '#232335';
  document.getElementById('sessportz_input_background_color').color.fromString('#232335');
}
if($('sessportz_input_font_color')) {
  $('sessportz_input_font_color').value = '#9e9caa';
  document.getElementById('sessportz_input_font_color').color.fromString('#9e9caa');
}
if($('sessportz_input_border_color')) {
  $('sessportz_input_border_color').value = '#232335';
  document.getElementById('sessportz_input_border_color').color.fromString('#232335');
}
if($('sessportz_button_background_color')) {
  $('sessportz_button_background_color').value = '#f92552';
  document.getElementById('sessportz_button_background_color').color.fromString('#f92552');
}
if($('sessportz_button_background_color_hover')) {
  $('sessportz_button_background_color_hover').value = '#fa486e'; document.getElementById('sessportz_button_background_color_hover').color.fromString('#fa486e');
}
if($('sessportz_button_background_color_active')) {
  $('sessportz_button_background_color_active').value = '#fa486e'; document.getElementById('sessportz_button_background_color_active').color.fromString('#fa486e');
}
if($('sessportz_button_font_color')) {
  $('sessportz_button_font_color').value = '#fff';
  document.getElementById('sessportz_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sessportz_header_background_color')) {
  $('sessportz_header_background_color').value = '#282840';
  document.getElementById('sessportz_header_background_color').color.fromString('#282840');
}
if($('sessportz_header_border_color')) {
  $('sessportz_header_border_color').value = '#3c3b5b';
  document.getElementById('sessportz_header_border_color').color.fromString('#3c3b5b');
}
if($('sessportz_menu_logo_top_space')) {
  $('sessportz_menu_logo_top_space').value = '10px';
}
if($('sessportz_mainmenu_background_color')) {
  $('sessportz_mainmenu_background_color').value = '#323150';
  document.getElementById('sessportz_mainmenu_background_color').color.fromString('#323150');
}
if($('sessportz_mainmenu_background_color_hover')) {
  $('sessportz_mainmenu_background_color_hover').value = '#f92552';
  document.getElementById('sessportz_mainmenu_background_color_hover').color.fromString('#f92552');
}
if($('sessportz_mainmenu_link_color')) {
  $('sessportz_mainmenu_link_color').value = '#fff';
  document.getElementById('sessportz_mainmenu_link_color').color.fromString('#fff');
}
if($('sessportz_mainmenu_link_color_hover')) {
  $('sessportz_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sessportz_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sessportz_mainmenu_border_color')) {
  $('sessportz_mainmenu_border_color').value = '#3c3b5b';
  document.getElementById('sessportz_mainmenu_border_color').color.fromString('#3c3b5b');
}
if($('sessportz_minimenu_link_color')) {
  $('sessportz_minimenu_link_color').value = '#fff';
  document.getElementById('sessportz_minimenu_link_color').color.fromString('#fff');
}
if($('sessportz_minimenu_link_color_hover')) {
  $('sessportz_minimenu_link_color_hover').value = '#f92552';
  document.getElementById('sessportz_minimenu_link_color_hover').color.fromString('#f92552');
}
if($('sessportz_minimenu_border_color')) {
  $('sessportz_minimenu_border_color').value = '#aaa';
  document.getElementById('sessportz_minimenu_border_color').color.fromString('#aaa');
}
if($('sessportz_minimenu_icon')) {
  $('sessportz_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('sessportz_header_searchbox_background_color')) {
  $('sessportz_header_searchbox_background_color').value = '#282840'; document.getElementById('sessportz_header_searchbox_background_color').color.fromString('#282840');
}
if($('sessportz_header_searchbox_text_color')) {
  $('sessportz_header_searchbox_text_color').value = '#9e9caa';
  document.getElementById('sessportz_header_searchbox_text_color').color.fromString('#9e9caa');
}
if($('sessportz_header_searchbox_border_color')) {
  $('sessportz_header_searchbox_border_color').value = '#282840';
  document.getElementById('sessportz_header_searchbox_border_color').color.fromString('#282840');
}
//Header Styling

//Footer Styling
if($('sessportz_footer_background_color')) {
  $('sessportz_footer_background_color').value = '#282840';
  document.getElementById('sessportz_footer_background_color').color.fromString('#282840');
}
if($('sessportz_footer_border_color')) {
  $('sessportz_footer_border_color').value = '#3c3b5b';
  document.getElementById('sessportz_footer_border_color').color.fromString('#3c3b5b');
}
if($('sessportz_footer_text_color')) {
  $('sessportz_footer_text_color').value = '#fff';
  document.getElementById('sessportz_footer_text_color').color.fromString('#fff');
}
if($('sessportz_footer_link_color')) {
  $('sessportz_footer_link_color').value = '#9e9caa';
  document.getElementById('sessportz_footer_link_color').color.fromString('#9e9caa');
}
if($('sessportz_footer_link_hover_color')) {
  $('sessportz_footer_link_hover_color').value = '#f92552';
  document.getElementById('sessportz_footer_link_hover_color').color.fromString('#f92552');
}
		} 
		else if(value == 3) {
					//Theme Base Styling
if($('sessportz_theme_color')) {
  $('sessportz_theme_color').value = '#f44336';
  document.getElementById('sessportz_theme_color').color.fromString('#f44336');
}
if($('sessportz_theme_secondary_color')) {
  $('sessportz_theme_secondary_color').value = '#6d6d6d';
  document.getElementById('sessportz_theme_secondary_color').color.fromString('#6d6d6d');
}
//Theme Base Styling

//Body Styling
if($('sessportz_body_background_color')) {
  $('sessportz_body_background_color').value = '#000000';
  document.getElementById('sessportz_body_background_color').color.fromString('#000000');
}
if($('sessportz_font_color')) {
  $('sessportz_font_color').value = '#6d6d6d';
  document.getElementById('sessportz_font_color').color.fromString('#6d6d6d');
}
if($('sessportz_font_color_light')) {
  $('sessportz_font_color_light').value = '#6d6d6d';
  document.getElementById('sessportz_font_color_light').color.fromString('#6d6d6d');
}

if($('sessportz_heading_color')) {
  $('sessportz_heading_color').value = '#fff';
  document.getElementById('sessportz_heading_color').color.fromString('#fff');
}
if($('sessportz_link_color')) {
  $('sessportz_link_color').value = '#fff';
  document.getElementById('sessportz_link_color').color.fromString('#fff');
}
if($('sessportz_link_color_hover')) {
  $('sessportz_link_color_hover').value = '#f44336';
  document.getElementById('sessportz_link_color_hover').color.fromString('#f44336');
}
if($('sessportz_content_heading_background_color')) {
  $('sessportz_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sessportz_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sessportz_content_background_color')) {
  $('sessportz_content_background_color').value = '#000000';
  document.getElementById('sessportz_content_background_color').color.fromString('#000000');
}
if($('sessportz_content_border_color')) {
  $('sessportz_content_border_color').value = '#1f1f1f';
  document.getElementById('sessportz_content_border_color').color.fromString('#1f1f1f');
}
if($('sessportz_content_border_color_dark')) {
  $('sessportz_content_border_color_dark').value = '#1f1f1f';
  document.getElementById('sessportz_content_border_color_dark').color.fromString('#1f1f1f');
}

if($('sessportz_input_background_color')) {
  $('sessportz_input_background_color').value = '#000000';
  document.getElementById('sessportz_input_background_color').color.fromString('#000000');
}
if($('sessportz_input_font_color')) {
  $('sessportz_input_font_color').value = '#1f1f1f';
  document.getElementById('sessportz_input_font_color').color.fromString('#1f1f1f');
}
if($('sessportz_input_border_color')) {
  $('sessportz_input_border_color').value = '#1f1f1f';
  document.getElementById('sessportz_input_border_color').color.fromString('#1f1f1f');
}
if($('sessportz_button_background_color')) {
  $('sessportz_button_background_color').value = '#f44336';
  document.getElementById('sessportz_button_background_color').color.fromString('#f44336');
}
if($('sessportz_button_background_color_hover')) {
  $('sessportz_button_background_color_hover').value = '#ff6d62'; document.getElementById('sessportz_button_background_color_hover').color.fromString('#ff6d62');
}
if($('sessportz_button_background_color_active')) {
  $('sessportz_button_background_color_active').value = '#ff6d62'; document.getElementById('sessportz_button_background_color_active').color.fromString('#ff6d62');
}
if($('sessportz_button_font_color')) {
  $('sessportz_button_font_color').value = '#fff';
  document.getElementById('sessportz_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sessportz_header_background_color')) {
  $('sessportz_header_background_color').value = '#000000';
  document.getElementById('sessportz_header_background_color').color.fromString('#000000');
}
if($('sessportz_header_border_color')) {
  $('sessportz_header_border_color').value = '#232323';
  document.getElementById('sessportz_header_border_color').color.fromString('#232323');
}
if($('sessportz_menu_logo_top_space')) {
  $('sessportz_menu_logo_top_space').value = '10px';
}
if($('sessportz_mainmenu_background_color')) {
  $('sessportz_mainmenu_background_color').value = '#131313';
  document.getElementById('sessportz_mainmenu_background_color').color.fromString('#131313');
}
if($('sessportz_mainmenu_background_color_hover')) {
  $('sessportz_mainmenu_background_color_hover').value = '#f44336';
  document.getElementById('sessportz_mainmenu_background_color_hover').color.fromString('#f44336');
}
if($('sessportz_mainmenu_link_color')) {
  $('sessportz_mainmenu_link_color').value = '#fff';
  document.getElementById('sessportz_mainmenu_link_color').color.fromString('#fff');
}
if($('sessportz_mainmenu_link_color_hover')) {
  $('sessportz_mainmenu_link_color_hover').value = '#fff';
  document.getElementById('sessportz_mainmenu_link_color_hover').color.fromString('#fff');
}
if($('sessportz_mainmenu_border_color')) {
  $('sessportz_mainmenu_border_color').value = '#232323';
  document.getElementById('sessportz_mainmenu_border_color').color.fromString('#232323');
}
if($('sessportz_minimenu_link_color')) {
  $('sessportz_minimenu_link_color').value = '#fff';
  document.getElementById('sessportz_minimenu_link_color').color.fromString('#fff');
}
if($('sessportz_minimenu_link_color_hover')) {
  $('sessportz_minimenu_link_color_hover').value = '#f44336';
  document.getElementById('sessportz_minimenu_link_color_hover').color.fromString('#f44336');
}
if($('sessportz_minimenu_border_color')) {
  $('sessportz_minimenu_border_color').value = '#aaa';
  document.getElementById('sessportz_minimenu_border_color').color.fromString('#aaa');
}
if($('sessportz_minimenu_icon')) {
  $('sessportz_minimenu_icon').value = 'minimenu-icons-white.png';
}
if($('sessportz_header_searchbox_background_color')) {
  $('sessportz_header_searchbox_background_color').value = '#000000'; document.getElementById('sessportz_header_searchbox_background_color').color.fromString('#000000');
}
if($('sessportz_header_searchbox_text_color')) {
  $('sessportz_header_searchbox_text_color').value = '#fff';
  document.getElementById('sessportz_header_searchbox_text_color').color.fromString('#fff');
}
if($('sessportz_header_searchbox_border_color')) {
  $('sessportz_header_searchbox_border_color').value = '#000000';
  document.getElementById('sessportz_header_searchbox_border_color').color.fromString('#000000');
}
//Header Styling

//Footer Styling
if($('sessportz_footer_background_color')) {
  $('sessportz_footer_background_color').value = '#131313';
  document.getElementById('sessportz_footer_background_color').color.fromString('#131313');
}
if($('sessportz_footer_border_color')) {
  $('sessportz_footer_border_color').value = '#212121';
  document.getElementById('sessportz_footer_border_color').color.fromString('#212121');
}
if($('sessportz_footer_text_color')) {
  $('sessportz_footer_text_color').value = '#fff';
  document.getElementById('sessportz_footer_text_color').color.fromString('#fff');
}
if($('sessportz_footer_link_color')) {
  $('sessportz_footer_link_color').value = '#6d6d6d';
  document.getElementById('sessportz_footer_link_color').color.fromString('#6d6d6d');
}
if($('sessportz_footer_link_hover_color')) {
  $('sessportz_footer_link_hover_color').value = '#f44336';
  document.getElementById('sessportz_footer_link_hover_color').color.fromString('#f44336');
}
		}
		else if(value == 4) {
			//Theme Base Styling
if($('sessportz_theme_color')) {
  $('sessportz_theme_color').value = '#ff9800';
  document.getElementById('sessportz_theme_color').color.fromString('#ff9800');
}
if($('sessportz_theme_secondary_color')) {
  $('sessportz_theme_secondary_color').value = '#DDDDDD';
  document.getElementById('sessportz_theme_secondary_color').color.fromString('#DDDDDD');
}
//Theme Base Styling

//Body Styling
if($('sessportz_body_background_color')) {
  $('sessportz_body_background_color').value = '#fff';
  document.getElementById('sessportz_body_background_color').color.fromString('#fff');
}
if($('sessportz_font_color')) {
  $('sessportz_font_color').value = '#808080';
  document.getElementById('sessportz_font_color').color.fromString('#808080');
}
if($('sessportz_font_color_light')) {
  $('sessportz_font_color_light').value = '#999';
  document.getElementById('sessportz_font_color_light').color.fromString('#999');
}

if($('sessportz_heading_color')) {
  $('sessportz_heading_color').value = '#000';
  document.getElementById('sessportz_heading_color').color.fromString('#000');
}
if($('sessportz_link_color')) {
  $('sessportz_link_color').value = '#000';
  document.getElementById('sessportz_link_color').color.fromString('#000');
}
if($('sessportz_link_color_hover')) {
  $('sessportz_link_color_hover').value = 'ff9800';
  document.getElementById('sessportz_link_color_hover').color.fromString('ff9800');
}
if($('sessportz_content_heading_background_color')) {
  $('sessportz_content_heading_background_color').value = '#131326'; document.getElementById('sessportz_content_heading_background_color').color.fromString('#131326');
}
if($('sessportz_content_background_color')) {
  $('sessportz_content_background_color').value = '#fff';
  document.getElementById('sessportz_content_background_color').color.fromString('#fff');
}
if($('sessportz_content_border_color')) {
  $('sessportz_content_border_color').value = '#d0d0d0';
  document.getElementById('sessportz_content_border_color').color.fromString('#d0d0d0');
}
if($('sessportz_content_border_color_dark')) {
  $('sessportz_content_border_color_dark').value = '#d0d0d0';
  document.getElementById('sessportz_content_border_color_dark').color.fromString('#d0d0d0');
}

if($('sessportz_input_background_color')) {
  $('sessportz_input_background_color').value = '#fff';
  document.getElementById('sessportz_input_background_color').color.fromString('#fff');
}
if($('sessportz_input_font_color')) {
  $('sessportz_input_font_color').value = '#ddd';
  document.getElementById('sessportz_input_font_color').color.fromString('#ddd');
}
if($('sessportz_input_border_color')) {
  $('sessportz_input_border_color').value = '#ddd';
  document.getElementById('sessportz_input_border_color').color.fromString('#ddd');
}
if($('sessportz_button_background_color')) {
  $('sessportz_button_background_color').value = 'ff9800';
  document.getElementById('sessportz_button_background_color').color.fromString('ff9800');
}
if($('sessportz_button_background_color_hover')) {
  $('sessportz_button_background_color_hover').value = '#da8200'; document.getElementById('sessportz_button_background_color_hover').color.fromString('#da8200');
}
if($('sessportz_button_background_color_active')) {
  $('sessportz_button_background_color_active').value = '#da8200'; document.getElementById('sessportz_button_background_color_active').color.fromString('#da8200');
}
if($('sessportz_button_font_color')) {
  $('sessportz_button_font_color').value = '#fff';
  document.getElementById('sessportz_button_font_color').color.fromString('#fff');
}
//Body Styling


//Header Styling
if($('sessportz_header_background_color')) {
  $('sessportz_header_background_color').value = '#222222';
  document.getElementById('sessportz_header_background_color').color.fromString('#222222');
}
if($('sessportz_header_border_color')) {
  $('sessportz_header_border_color').value = '#e0e0e0';
  document.getElementById('sessportz_header_border_color').color.fromString('#e0e0e0');
}
if($('sessportz_menu_logo_top_space')) {
  $('sessportz_menu_logo_top_space').value = '10px';
}
if($('sessportz_mainmenu_background_color')) {
  $('sessportz_mainmenu_background_color').value = '#fff';
  document.getElementById('sessportz_mainmenu_background_color').color.fromString('#fff');
}
if($('sessportz_mainmenu_background_color_hover')) {
  $('sessportz_mainmenu_background_color_hover').value = '#ff9800';
  document.getElementById('sessportz_mainmenu_background_color_hover').color.fromString('#ff9800');
}
if($('sessportz_mainmenu_link_color')) {
  $('sessportz_mainmenu_link_color').value = '#000';
  document.getElementById('sessportz_mainmenu_link_color').color.fromString('#000');
}
if($('sessportz_mainmenu_link_color_hover')) {
  $('sessportz_mainmenu_link_color_hover').value = '#FFFFFF';
  document.getElementById('sessportz_mainmenu_link_color_hover').color.fromString('#FFFFFF');
}
if($('sessportz_mainmenu_border_color')) {
  $('sessportz_mainmenu_border_color').value = '#e0e0e0';
  document.getElementById('sessportz_mainmenu_border_color').color.fromString('#e0e0e0');
}
if($('sessportz_minimenu_link_color')) {
  $('sessportz_minimenu_link_color').value = '#FFFFFF';
  document.getElementById('sessportz_minimenu_link_color').color.fromString('#FFFFFF');
}
if($('sessportz_minimenu_link_color_hover')) {
  $('sessportz_minimenu_link_color_hover').value = '#ff9800';
  document.getElementById('sessportz_minimenu_link_color_hover').color.fromString('#ff9800');
}
if($('sessportz_minimenu_border_color')) {
  $('sessportz_minimenu_border_color').value = '#666666';
  document.getElementById('sessportz_minimenu_border_color').color.fromString('#666666');
}
if($('sessportz_minimenu_icon')) {
  $('sessportz_minimenu_icon').value = 'minimenu-icons-gray.png';
}
if($('sessportz_header_searchbox_background_color')) {
  $('sessportz_header_searchbox_background_color').value = '#fff'; document.getElementById('sessportz_header_searchbox_background_color').color.fromString('#fff');
}
if($('sessportz_header_searchbox_text_color')) {
  $('sessportz_header_searchbox_text_color').value = '#808080';
  document.getElementById('sessportz_header_searchbox_text_color').color.fromString('#808080');
}
if($('sessportz_header_searchbox_border_color')) {
  $('sessportz_header_searchbox_border_color').value = '#ddd'; document.getElementById('sessportz_header_searchbox_border_color').color.fromString('#ddd');
}
//Header Styling

//Footer Styling
if($('sessportz_footer_background_color')) {
  $('sessportz_footer_background_color').value = '#222222';
  document.getElementById('sessportz_footer_background_color').color.fromString('#222222');
}
if($('sessportz_footer_border_color')) {
  $('sessportz_footer_border_color').value = '#444047';
  document.getElementById('sessportz_footer_border_color').color.fromString('#444047');
}
if($('sessportz_footer_text_color')) {
  $('sessportz_footer_text_color').value = '#fff';
  document.getElementById('sessportz_footer_text_color').color.fromString('#fff');
}
if($('sessportz_footer_link_color')) {
  $('sessportz_footer_link_color').value = '#999999';
  document.getElementById('sessportz_footer_link_color').color.fromString('#999999');
}
if($('sessportz_footer_link_hover_color')) {
  $('sessportz_footer_link_hover_color').value = '#ff9800';
  document.getElementById('sessportz_footer_link_hover_color').color.fromString('#ff9800');
}
//Footer Styling
		}
  
    else if(value == 5) {
      //Theme Base Styling
      if($('sessportz_theme_color')) {
        $('sessportz_theme_color').value = '<?php echo $settings->getSetting('sessportz.theme.color') ?>';
        document.getElementById('sessportz_theme_color').color.fromString('<?php echo $settings->getSetting('sessportz.theme.color') ?>');
      }
      if($('sessportz_theme_secondary_color')) {
        $('sessportz_theme_secondary_color').value = '<?php echo $settings->getSetting('sessportz.theme.secondary.color') ?>';
        document.getElementById('sessportz_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('sessportz.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sessportz_body_background_color')) {
        $('sessportz_body_background_color').value = '<?php echo $settings->getSetting('sessportz.body.background.color') ?>';
        document.getElementById('sessportz_body_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.body.background.color') ?>');
      }
      if($('sessportz_font_color')) {
        $('sessportz_font_color').value = '<?php echo $settings->getSetting('sessportz.fontcolor') ?>';
        document.getElementById('sessportz_font_color').color.fromString('<?php echo $settings->getSetting('sessportz.fontcolor') ?>');
      }
      if($('sessportz_font_color_light')) {
        $('sessportz_font_color_light').value = '<?php echo $settings->getSetting('sessportz.font.color.light') ?>';
        document.getElementById('sessportz_font_color_light').color.fromString('<?php echo $settings->getSetting('sessportz.font.color.light') ?>');
      }
      if($('sessportz_heading_color')) {
        $('sessportz_heading_color').value = '<?php echo $settings->getSetting('sessportz.heading.color') ?>';
        document.getElementById('sessportz_heading_color').color.fromString('<?php echo $settings->getSetting('sessportz.heading.color') ?>');
      }
      if($('sessportz_link_color')) {
        $('sessportz_link_color').value = '<?php echo $settings->getSetting('sessportz.linkcolor') ?>';
        document.getElementById('sessportz_link_color').color.fromString('<?php echo $settings->getSetting('sessportz.linkcolor') ?>');
      }
      if($('sessportz_link_color_hover')) {
        $('sessportz_link_color_hover').value = '<?php echo $settings->getSetting('sessportz.link.color.hover') ?>';
        document.getElementById('sessportz_link_color_hover').color.fromString('<?php echo $settings->getSetting('sessportz.link.color.hover') ?>');
      }
      if($('sessportz_content_heading_background_color')) {
        $('sessportz_content_heading_background_color').value = '<?php echo $settings->getSetting('sessportz.content.heading.background.color') ?>'; 
        document.getElementById('sessportz_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.content.heading.background.color') ?>');
      }
      if($('sessportz_content_background_color')) {
        $('sessportz_content_background_color').value = '<?php echo $settings->getSetting('sessportz.content.background.color') ?>';
        document.getElementById('sessportz_content_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.content.background.color') ?>');
      }
      if($('sessportz_content_border_color')) {
        $('sessportz_content_border_color').value = '<?php echo $settings->getSetting('sessportz.content.bordercolor') ?>';
        document.getElementById('sessportz_content_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.content.bordercolor') ?>');
      }
      if($('sessportz_content_border_color_dark')) {
        $('sessportz_content_border_color_dark').value = '<?php echo $settings->getSetting('sessportz.content.border.color.dark') ?>';
        document.getElementById('sessportz_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('sessportz.content.border.color.dark') ?>');
      }
      if($('sessportz_input_background_color')) {
        $('sessportz_input_background_color').value = '<?php echo $settings->getSetting('sessportz.input.background.color') ?>';
        document.getElementById('sessportz_input_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.input.background.color') ?>');
      }
      if($('sessportz_input_font_color')) {
        $('sessportz_input_font_color').value = '<?php echo $settings->getSetting('sessportz.input.font.color') ?>';
        document.getElementById('sessportz_input_font_color').color.fromString('<?php echo $settings->getSetting('sessportz.input.font.color') ?>');
      }
      if($('sessportz_input_border_color')) {
        $('sessportz_input_border_color').value = '<?php echo $settings->getSetting('sessportz.input.border.color') ?>';
        document.getElementById('sessportz_input_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.input.border.color') ?>');
      }
      if($('sessportz_button_background_color')) {
        $('sessportz_button_background_color').value = '<?php echo $settings->getSetting('sessportz.button.backgroundcolor') ?>';
        document.getElementById('sessportz_button_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.button.backgroundcolor') ?>');
      }
      if($('sessportz_button_background_color_hover')) {
        $('sessportz_button_background_color_hover').value = '<?php echo $settings->getSetting('sessportz.button.background.color.hover') ?>'; 
        document.getElementById('sessportz_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('sessportz.button.background.color.hover') ?>');
      }
      if($('sessportz_button_background_color_active')) {
        $('sessportz_button_background_color_active').value = '<?php echo $settings->getSetting('sessportz.button.background.color.active') ?>'; 
        document.getElementById('sessportz_button_background_color_active').color.fromString('<?php echo $settings->getSetting('sessportz.button.background.color.active') ?>');
      }
      if($('sessportz_button_font_color')) {
        $('sessportz_button_font_color').value = '<?php echo $settings->getSetting('sessportz.button.font.color') ?>';
        document.getElementById('sessportz_button_font_color').color.fromString('<?php echo $settings->getSetting('sessportz.button.font.color') ?>');
      }
      //Body Styling
      //Header Styling
      if($('sessportz_header_background_color')) {
        $('sessportz_header_background_color').value = '<?php echo $settings->getSetting('sessportz.header.background.color') ?>';
        document.getElementById('sessportz_header_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.header.background.color') ?>');
      }
      if($('sessportz_header_border_color')) {
        $('sessportz_header_border_color').value = '<?php echo $settings->getSetting('sessportz.header.border.color') ?>';
        document.getElementById('sessportz_header_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.header.border.color') ?>');
      }
      if($('sessportz_menu_logo_top_space')) {
        $('sessportz_menu_logo_top_space').value = '10px';
      }
      if($('sessportz_mainmenu_background_color')) {
        $('sessportz_mainmenu_background_color').value = '<?php echo $settings->getSetting('sessportz.mainmenu.backgroundcolor') ?>';
        document.getElementById('sessportz_mainmenu_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.mainmenu.backgroundcolor') ?>');
      }
      if($('sessportz_mainmenu_background_color_hover')) {
        $('sessportz_mainmenu_background_color_hover').value = '<?php echo $settings->getSetting('sessportz.mainmenu.background.color.hover') ?>';
        document.getElementById('sessportz_mainmenu_background_color_hover').color.fromString('<?php echo $settings->getSetting('sessportz.mainmenu.background.color.hover') ?>');
      }
      if($('sessportz_mainmenu_link_color')) {
        $('sessportz_mainmenu_link_color').value = '<?php echo $settings->getSetting('sessportz.mainmenu.linkcolor') ?>';
        document.getElementById('sessportz_mainmenu_link_color').color.fromString('<?php echo $settings->getSetting('sessportz.mainmenu.linkcolor') ?>');
      }
      if($('sessportz_mainmenu_link_color_hover')) {
        $('sessportz_mainmenu_link_color_hover').value = '<?php echo $settings->getSetting('sessportz.mainmenu.link.color.hover') ?>';
        document.getElementById('sessportz_mainmenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sessportz.mainmenu.link.color.hover') ?>');
      }
      if($('sessportz_mainmenu_border_color')) {
        $('sessportz_mainmenu_border_color').value = '<?php echo $settings->getSetting('sessportz.mainmenu.border.color') ?>';
        document.getElementById('sessportz_mainmenu_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.mainmenu.border.color') ?>');
      }
      if($('sessportz_minimenu_link_color')) {
        $('sessportz_minimenu_link_color').value = '<?php echo $settings->getSetting('sessportz.minimenu.linkcolor') ?>';
        document.getElementById('sessportz_minimenu_link_color').color.fromString('<?php echo $settings->getSetting('sessportz.minimenu.linkcolor') ?>');
      }
      if($('sessportz_minimenu_link_color_hover')) {
        $('sessportz_minimenu_link_color_hover').value = '<?php echo $settings->getSetting('sessportz.minimenu.link.color.hover') ?>';
        document.getElementById('sessportz_minimenu_link_color_hover').color.fromString('<?php echo $settings->getSetting('sessportz.minimenu.link.color.hover') ?>');
      }
      if($('sessportz_minimenu_border_color')) {
        $('sessportz_minimenu_border_color').value = '<?php echo $settings->getSetting('sessportz.minimenu.border.color') ?>';
        document.getElementById('sessportz_minimenu_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.minimenu.border.color') ?>');
      }
      if($('sessportz_minimenu_icon')) {
        $('sessportz_minimenu_icon').value = 'minimenu-icons-white.png';
      }
      if($('sessportz_header_searchbox_background_color')) {
        $('sessportz_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sessportz.header.searchbox.background.color') ?>'; 
        document.getElementById('sessportz_header_searchbox_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.header.searchbox.background.color') ?>');
      }
      if($('sessportz_header_searchbox_text_color')) {
        $('sessportz_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sessportz.header.searchbox.text.color') ?>';
        document.getElementById('sessportz_header_searchbox_text_color').color.fromString('<?php echo $settings->getSetting('sessportz.header.searchbox.text.color') ?>');
      }
      if($('sessportz_header_searchbox_border_color')) {
        $('sessportz_header_searchbox_border_color').value = '<?php echo $settings->getSetting('sessportz.header.searchbox.border.color') ?>'; 
        document.getElementById('sessportz_header_searchbox_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.header.searchbox.border.color') ?>');
      }
      //Header Styling
      //Footer Styling
      if($('sessportz_footer_background_color')) {
        $('sessportz_footer_background_color').value = '<?php echo $settings->getSetting('sessportz.footer.background.color') ?>';
        document.getElementById('sessportz_footer_background_color').color.fromString('<?php echo $settings->getSetting('sessportz.footer.background.color') ?>');
      }
      if($('sessportz_footer_border_color')) {
        $('sessportz_footer_border_color').value = '<?php echo $settings->getSetting('sessportz.footer.border.color') ?>';
        document.getElementById('sessportz_footer_border_color').color.fromString('<?php echo $settings->getSetting('sessportz.footer.border.color') ?>');
      }
      if($('sessportz_footer_text_color')) {
        $('sessportz_footer_text_color').value = '<?php echo $settings->getSetting('sessportz.footer.text.color') ?>';
        document.getElementById('sessportz_footer_text_color').color.fromString('<?php echo $settings->getSetting('sessportz.footer.text.color') ?>');
      }
      if($('sessportz_footer_link_color')) {
        $('sessportz_footer_link_color').value = '<?php echo $settings->getSetting('sessportz.footer.link.color') ?>';
        document.getElementById('sessportz_footer_link_color').color.fromString('<?php echo $settings->getSetting('sessportz.footer.link.color') ?>');
      }
      if($('sessportz_footer_link_hover_color')) {
        $('sessportz_footer_link_hover_color').value = '<?php echo $settings->getSetting('sessportz.footer.link.hover.color') ?>';
        document.getElementById('sessportz_footer_link_hover_color').color.fromString('<?php echo $settings->getSetting('sessportz.footer.link.hover.color') ?>');
      }
      //Footer Styling
    }
	}
</script>
