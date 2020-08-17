 <?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sesbody/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sessmtheme_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesbody()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {
	  changeThemeColor(value, 'custom');
  }


	function changeThemeColor(value, custom) {
	
	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4 || value == 6 || value == 7 || value == 8 || value == 9)) {
	    if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'none';

		  if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'none';
			if($('button_settings-wrapper'))
			  $('button_settings-wrapper').style.display = 'none';
			if($('header_settings-wrapper'))
			  $('header_settings-wrapper').style.display = 'none';
			if($('footer_settings-wrapper'))
			  $('footer_settings-wrapper').style.display = 'none';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'none';
			if($('button_settings_group'))
			  $('button_settings_group').style.display = 'none';
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

			if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'block';
				if($('button_settings-wrapper'))
			  $('button_settings-wrapper').style.display = 'block';
			if($('header_settings-wrapper'))
			  $('header_settings-wrapper').style.display = 'block';
			if($('footer_settings-wrapper'))
			  $('footer_settings-wrapper').style.display = 'block';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'block';
			if($('button_settings_group'))
			  $('button_settings_group').style.display = 'block';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'block';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'block';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'block';
	  }


		if(value == 1) {
			//Theme Base Styling
if($('sesbody_theme_color')) {
  $('sesbody_theme_color').value = '#e82f34';
  document.getElementById('sesbody_theme_color').color.fromString('#e82f34');
}
if($('sesbody_theme_secondary_color')) {
  $('sesbody_theme_secondary_color').value = '#222';
  document.getElementById('sesbody_theme_secondary_color').color.fromString('#222');
}
//Theme Base Styling

//Body Styling
if($('sesbody_body_background_color')) {
  $('sesbody_body_background_color').value = '#f7f8fa';
  document.getElementById('sesbody_body_background_color').color.fromString('#f7f8fa');
}
if($('sesbody_font_color')) {
  $('sesbody_font_color').value = '#555';
  document.getElementById('sesbody_font_color').color.fromString('#555');
}
if($('sesbody_font_color_light')) {
  $('sesbody_font_color_light').value = '#888';
  document.getElementById('sesbody_font_color_light').color.fromString('#888');
}

if($('sesbody_heading_color')) {
  $('sesbody_heading_color').value = '#555';
  document.getElementById('sesbody_heading_color').color.fromString('#555');
}
if($('sesbody_link_color')) {
  $('sesbody_link_color').value = '#222';
  document.getElementById('sesbody_link_color').color.fromString('#222');
}
if($('sesbody_link_color_hover')) {
  $('sesbody_link_color_hover').value = '#e82f34';
  document.getElementById('sesbody_link_color_hover').color.fromString('#e82f34');
}
if($('sesbody_content_heading_background_color')) {
  $('sesbody_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesbody_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesbody_content_background_color')) {
  $('sesbody_content_background_color').value = '#fff';
  document.getElementById('sesbody_content_background_color').color.fromString('#fff');
}
if($('sesbody_content_border_color')) {
  $('sesbody_content_border_color').value = '#eee';
  document.getElementById('sesbody_content_border_color').color.fromString('#eee');
}
if($('sesbody_content_border_color_dark')) {
  $('sesbody_content_border_color_dark').value = '#ddd';
  document.getElementById('sesbody_content_border_color_dark').color.fromString('#ddd');
}

if($('sesbody_input_background_color')) {
  $('sesbody_input_background_color').value = '#fff';
  document.getElementById('sesbody_input_background_color').color.fromString('#fff');
}
if($('sesbody_input_font_color')) {
  $('sesbody_input_font_color').value = '#000';
  document.getElementById('sesbody_input_font_color').color.fromString('#000');
}
if($('sesbody_input_border_color')) {
  $('sesbody_input_border_color').value = '#dce0e3';
  document.getElementById('sesbody_input_border_color').color.fromString('#dce0e3');
}
if($('sesbody_button_background_color')) {
  $('sesbody_button_background_color').value = '#e82f34';
  document.getElementById('sesbody_button_background_color').color.fromString('#e82f34');
}
if($('sesbody_button_background_color_hover')) {
  $('sesbody_button_background_color_hover').value = '#2d2d2d'; 
	document.getElementById('sesbody_button_background_color_hover').color.fromString('#2d2d2d');
}
if($('sesbody_button_background_color_active')) {
  $('sesbody_button_background_color_active').value = '#e82f34'; 
	document.getElementById('sesbody_button_background_color_active').color.fromString('#e82f34');
}
if($('sesbody_button_font_color')) {
  $('sesbody_button_font_color').value = '#fff';
  document.getElementById('sesbody_button_font_color').color.fromString('#fff');
}
if($('sesbody_button_font_hover_color')) {
  $('sesbody_button_font_hover_color').value = '#fff';
  document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
}
if($('sesbody_button_background_gradient_top_color')) {
  $('sesbody_button_background_gradient_top_color').value = '#7f090c';
  document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#7f090c');
}
if($('sesbody_button_background_gradient_top_hover_color')) {
  $('sesbody_button_background_gradient_top_hover_color').value = '#E82F34';
  document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#E82F34');
}
//Body Styling
//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#E82F34';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#E82F34');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#C9292D';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#C9292D');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#C9292D';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#C9292D');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#E82F34';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#E82F34');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#E82F34';
		document.getElementById('sesbody_footer_border_color').color.fromString('#E82F34');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#E82F34';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#E82F34');
	}
	// Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
if($('sesbody_theme_color')) {
  $('sesbody_theme_color').value = '#0186bf';
  document.getElementById('sesbody_theme_color').color.fromString('#0186bf');
}
if($('sesbody_theme_secondary_color')) {
  $('sesbody_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesbody_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesbody_body_background_color')) {
  $('sesbody_body_background_color').value = '#E3E3E3';
  document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
}
if($('sesbody_font_color')) {
  $('sesbody_font_color').value = '#555';
  document.getElementById('sesbody_font_color').color.fromString('#555');
}
if($('sesbody_font_color_light')) {
  $('sesbody_font_color_light').value = '#888';
  document.getElementById('sesbody_font_color_light').color.fromString('#888');
}

if($('sesbody_heading_color')) {
  $('sesbody_heading_color').value = '#555';
  document.getElementById('sesbody_heading_color').color.fromString('#555');
}
if($('sesbody_link_color')) {
  $('sesbody_link_color').value = '#222';
  document.getElementById('sesbody_link_color').color.fromString('#222');
}
if($('sesbody_link_color_hover')) {
  $('sesbody_link_color_hover').value = '#0186BF';
  document.getElementById('sesbody_link_color_hover').color.fromString('#0186BF');
}
if($('sesbody_content_heading_background_color')) {
  $('sesbody_content_heading_background_color').value = '#f1f1f1'; document.getElementById('sesbody_content_heading_background_color').color.fromString('#f1f1f1');
}
if($('sesbody_content_background_color')) {
  $('sesbody_content_background_color').value = '#fff';
  document.getElementById('sesbody_content_background_color').color.fromString('#fff');
}
if($('sesbody_content_border_color')) {
  $('sesbody_content_border_color').value = '#eee';
  document.getElementById('sesbody_content_border_color').color.fromString('#eee');
}
if($('sesbody_content_border_color_dark')) {
  $('sesbody_content_border_color_dark').value = '#ddd';
  document.getElementById('sesbody_content_border_color_dark').color.fromString('#ddd');
}

if($('sesbody_input_background_color')) {
  $('sesbody_input_background_color').value = '#fff';
  document.getElementById('sesbody_input_background_color').color.fromString('#fff');
}
if($('sesbody_input_font_color')) {
  $('sesbody_input_font_color').value = '#000';
  document.getElementById('sesbody_input_font_color').color.fromString('#000');
}
if($('sesbody_input_border_color')) {
  $('sesbody_input_border_color').value = '#dce0e3';
  document.getElementById('sesbody_input_border_color').color.fromString('#dce0e3');
}
if($('sesbody_button_background_color')) {
  $('sesbody_button_background_color').value = '#0186BF';
  document.getElementById('sesbody_button_background_color').color.fromString('#0186BF');
}
if($('sesbody_button_background_color_hover')) {
  $('sesbody_button_background_color_hover').value = '#2B2D2E'; document.getElementById('sesbody_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('sesbody_button_background_color_active')) {
  $('sesbody_button_background_color_active').value = '#2B2D2E'; document.getElementById('sesbody_button_background_color_active').color.fromString('#2B2D2E');
}
if($('sesbody_button_font_color')) {
  $('sesbody_button_font_color').value = '#fff';
  document.getElementById('sesbody_button_font_color').color.fromString('#fff');
}
if($('sesbody_button_font_hover_color')) {
  $('sesbody_button_font_hover_color').value = '#fff';
  document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
}
if($('sesbody_button_background_gradient_top_color')) {
  $('sesbody_button_background_gradient_top_color').value = '#005579';
  document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#005579');
}
if($('sesbody_button_background_gradient_top_hover_color')) {
  $('sesbody_button_background_gradient_top_hover_color').value = '#0186bf';
  document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#0186bf');
}
//Body Styling
//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#0186bf';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#0186bf');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#0076a9';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#0076a9');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#0076a9';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#0076a9');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#0186bf';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#0186bf');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#0186bf';
		document.getElementById('sesbody_footer_border_color').color.fromString('#0186bf');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#0186bf';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#0186bf');
	}
	// Footer Styling

		} 
		else if(value == 3) {
			//Theme Base Styling
if($('sesbody_theme_color')) {
  $('sesbody_theme_color').value = '#ff4700';
  document.getElementById('sesbody_theme_color').color.fromString('#ff4700');
}
if($('sesbody_theme_secondary_color')) {
  $('sesbody_theme_secondary_color').value = '#2B2D2E';
  document.getElementById('sesbody_theme_secondary_color').color.fromString('#2B2D2E');
}
//Theme Base Styling

//Body Styling
if($('sesbody_body_background_color')) {
  $('sesbody_body_background_color').value = '#E3E3E3';
  document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
}
if($('sesbody_font_color')) {
  $('sesbody_font_color').value = '#555';
  document.getElementById('sesbody_font_color').color.fromString('#555');
}
if($('sesbody_font_color_light')) {
  $('sesbody_font_color_light').value = '#888';
  document.getElementById('sesbody_font_color_light').color.fromString('#888');
}

if($('sesbody_heading_color')) {
  $('sesbody_heading_color').value = '#FF4700';
  document.getElementById('sesbody_heading_color').color.fromString('#FF4700');
}
if($('sesbody_link_color')) {
  $('sesbody_link_color').value = '#222';
  document.getElementById('sesbody_link_color').color.fromString('#222');
}
if($('sesbody_link_color_hover')) {
  $('sesbody_link_color_hover').value = '#ff4700';
  document.getElementById('sesbody_link_color_hover').color.fromString('#ff4700');
}
if($('sesbody_content_heading_background_color')) {
  $('sesbody_content_heading_background_color').value = '#fff'; document.getElementById('sesbody_content_heading_background_color').color.fromString('#fff');
}
if($('sesbody_content_background_color')) {
  $('sesbody_content_background_color').value = '#fff';
  document.getElementById('sesbody_content_background_color').color.fromString('#fff');
}
if($('sesbody_content_border_color')) {
  $('sesbody_content_border_color').value = '#eee';
  document.getElementById('sesbody_content_border_color').color.fromString('#eee');
}
if($('sesbody_content_border_color_dark')) {
  $('sesbody_content_border_color_dark').value = '#ddd';
  document.getElementById('sesbody_content_border_color_dark').color.fromString('#ddd');
}

if($('sesbody_input_background_color')) {
  $('sesbody_input_background_color').value = '#fff';
  document.getElementById('sesbody_input_background_color').color.fromString('#fff');
}
if($('sesbody_input_font_color')) {
  $('sesbody_input_font_color').value = '#000';
  document.getElementById('sesbody_input_font_color').color.fromString('#000');
}
if($('sesbody_input_border_color')) {
  $('sesbody_input_border_color').value = '#dce0e3';
  document.getElementById('sesbody_input_border_color').color.fromString('#dce0e3');
}
if($('sesbody_button_background_color')) {
  $('sesbody_button_background_color').value = '#ff4700';
  document.getElementById('sesbody_button_background_color').color.fromString('#ff4700');
}
if($('sesbody_button_background_color_hover')) {
  $('sesbody_button_background_color_hover').value = '#2B2D2E'; document.getElementById('sesbody_button_background_color_hover').color.fromString('#2B2D2E');
}
if($('sesbody_button_background_color_active')) {
  $('sesbody_button_background_color_active').value = '#2B2D2E'; document.getElementById('sesbody_button_background_color_active').color.fromString('#2B2D2E');
}
if($('sesbody_button_font_color')) {
  $('sesbody_button_font_color').value = '#fff';
  document.getElementById('sesbody_button_font_color').color.fromString('#fff');
}
if($('sesbody_button_font_hover_color')) {
  $('sesbody_button_font_hover_color').value = '#fff';
  document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
}
if($('sesbody_button_background_gradient_top_color')) {
  $('sesbody_button_background_gradient_top_color').value = '#af3100';
  document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#af3100');
}
if($('sesbody_button_background_gradient_top_hover_color')) {
  $('sesbody_button_background_gradient_top_hover_color').value = '#ff4700';
  document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#ff4700');
}
//Body Styling
//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#ff4700';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#ff4700');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#F32D06';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#F32D06');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#F32D06';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#F32D06');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#ff4700';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#ff4700');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#ff4700';
		document.getElementById('sesbody_footer_border_color').color.fromString('#ff4700');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#ff4700';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#ff4700');
	}
	// Footer Styling


		}
		else if(value == 4) {
			//Theme Base Styling
if($('sesbody_theme_color')) {
  $('sesbody_theme_color').value = '#FFC000';
  document.getElementById('sesbody_theme_color').color.fromString('#FFC000');
}
if($('sesbody_theme_secondary_color')) {
  $('sesbody_theme_secondary_color').value = '#DDDDDD';
  document.getElementById('sesbody_theme_secondary_color').color.fromString('#DDDDDD');
}
//Theme Base Styling

//Body Styling
if($('sesbody_body_background_color')) {
  $('sesbody_body_background_color').value = '#222222';
  document.getElementById('sesbody_body_background_color').color.fromString('#222222');
}
if($('sesbody_font_color')) {
  $('sesbody_font_color').value = '#ddd';
  document.getElementById('sesbody_font_color').color.fromString('#ddd');
}
if($('sesbody_font_color_light')) {
  $('sesbody_font_color_light').value = '#999';
  document.getElementById('sesbody_font_color_light').color.fromString('#999');
}

if($('sesbody_heading_color')) {
  $('sesbody_heading_color').value = '#ddd';
  document.getElementById('sesbody_heading_color').color.fromString('#ddd');
}
if($('sesbody_link_color')) {
  $('sesbody_link_color').value = '#fff';
  document.getElementById('sesbody_link_color').color.fromString('#fff');
}
if($('sesbody_link_color_hover')) {
  $('sesbody_link_color_hover').value = '#FFC000';
  document.getElementById('sesbody_link_color_hover').color.fromString('#FFC000');
}
if($('sesbody_content_heading_background_color')) {
  $('sesbody_content_heading_background_color').value = '#2f2f2f'; document.getElementById('sesbody_content_heading_background_color').color.fromString('#2f2f2f');
}
if($('sesbody_content_background_color')) {
  $('sesbody_content_background_color').value = '#2f2f2f';
  document.getElementById('sesbody_content_background_color').color.fromString('#2f2f2f');
}
if($('sesbody_content_border_color')) {
  $('sesbody_content_border_color').value = '#383838';
  document.getElementById('sesbody_content_border_color').color.fromString('#383838');
}
if($('sesbody_content_border_color_dark')) {
  $('sesbody_content_border_color_dark').value = '#535353';
  document.getElementById('sesbody_content_border_color_dark').color.fromString('#535353');
}

if($('sesbody_input_background_color')) {
  $('sesbody_input_background_color').value = '#4c4c4c';
  document.getElementById('sesbody_input_background_color').color.fromString('#4c4c4c');
}
if($('sesbody_input_font_color')) {
  $('sesbody_input_font_color').value = '#ddd';
  document.getElementById('sesbody_input_font_color').color.fromString('#ddd');
}
if($('sesbody_input_border_color')) {
  $('sesbody_input_border_color').value = '#666';
  document.getElementById('sesbody_input_border_color').color.fromString('#666');
}
if($('sesbody_button_background_color')) {
  $('sesbody_button_background_color').value = '#FFC000';
  document.getElementById('sesbody_button_background_color').color.fromString('#ffc000');
}
if($('sesbody_button_background_color_hover')) {
  $('sesbody_button_background_color_hover').value = '#797979'; document.getElementById('sesbody_button_background_color_hover').color.fromString('#797979');
}
if($('sesbody_button_background_color_active')) {
  $('sesbody_button_background_color_active').value = '#797979'; document.getElementById('sesbody_button_background_color_active').color.fromString('#797979');
}
if($('sesbody_button_font_color')) {
  $('sesbody_button_font_color').value = '#fff';
  document.getElementById('sesbody_button_font_color').color.fromString('#fff');
}
if($('sesbody_button_font_hover_color')) {
  $('sesbody_button_font_hover_color').value = '#fff';
  document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
}
if($('sesbody_button_background_gradient_top_color')) {
  $('sesbody_button_background_gradient_top_color').value = '#a87f03';
  document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#a87f03');
}
if($('sesbody_button_background_gradient_top_hover_color')) {
  $('sesbody_button_background_gradient_top_hover_color').value = '#FFC000';
  document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#FFC000');
}
//Body Styling
	//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#FFC000';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#FFC000');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#D49F00';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#D49F00');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#D49F00';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#D49F00');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#FFC000';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#FFC000');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#FFC000';
		document.getElementById('sesbody_footer_border_color').color.fromString('#FFC000');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#FFC000';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#FFC000');
	}
	// Footer Styling

		}
    else if(value == 6) {
			//Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '#3EA9A9';
        document.getElementById('sesbody_theme_color').color.fromString('#3EA9A9');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '#FF5F3F';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('#FF5F3F');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '#E3E3E3';
        document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '#555555';
        document.getElementById('sesbody_font_color').color.fromString('#555555');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '#888888';
        document.getElementById('sesbody_font_color_light').color.fromString('#888888');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '#555555';
        document.getElementById('sesbody_heading_color').color.fromString('#555555');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '#3EA9A9';
        document.getElementById('sesbody_link_color').color.fromString('#3EA9A9');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '#FF5F3F';
        document.getElementById('sesbody_link_color_hover').color.fromString('#FF5F3F');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '#EEEEEE';
        document.getElementById('sesbody_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '#000000';
        document.getElementById('sesbody_input_font_color').color.fromString('#000000');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '#DCE0E3';
        document.getElementById('sesbody_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '#FF5F3F';
        document.getElementById('sesbody_button_background_color').color.fromString('#FF5F3F');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '#3EA9A9'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('#3EA9A9');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '#3EA9A9'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('#3EA9A9');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '#FFFFFF';
        document.getElementById('sesbody_button_font_color').color.fromString('#FFFFFF');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '#fff';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '#C2482F';
				document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#C2482F');
			}
			if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '#3EA9A9';
				document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#3EA9A9');
			}
      //Body Styling
     //Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#3EA9A9';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#3EA9A9');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#379696';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#379696');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#379696';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#379696');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#3EA9A9';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#3EA9A9');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#3EA9A9';
		document.getElementById('sesbody_footer_border_color').color.fromString('#3EA9A9');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#3EA9A9';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#3EA9A9');
	}
	// Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '#00B841';
        document.getElementById('sesbody_theme_color').color.fromString('#00B841');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '#31302B';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '#E3E3E3';
        document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '#555555';
        document.getElementById('sesbody_font_color').color.fromString('#555555');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '#888888';
        document.getElementById('sesbody_font_color_light').color.fromString('#888888');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '#555555';
        document.getElementById('sesbody_heading_color').color.fromString('#555555');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '#111111';
        document.getElementById('sesbody_link_color').color.fromString('#111111');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '#00B841';
        document.getElementById('sesbody_link_color_hover').color.fromString('#00B841');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '#EEEEEE';
        document.getElementById('sesbody_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '#000000';
        document.getElementById('sesbody_input_font_color').color.fromString('#000000');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '#DCE0E3';
        document.getElementById('sesbody_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '#25783C';
        document.getElementById('sesbody_button_background_color').color.fromString('#25783C');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('#31302B');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '#FFFFFF';
        document.getElementById('sesbody_button_font_color').color.fromString('#FFFFFF');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '#fff';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
			}
				if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '#00B841';
			document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#00B841');
			}
				if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '#25783C';
			document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#25783C');
			}
      //Body Styling
			   //Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#00B841';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#00B841');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#25783C';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#25783C');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#25783C';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#25783C');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#00B841';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#00B841');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#00B841';
		document.getElementById('sesbody_footer_border_color').color.fromString('#00B841');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#00B841';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#00B841');
	}
	// Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '#A61C28';
        document.getElementById('sesbody_theme_color').color.fromString('#A61C28');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '#31302B';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '#E3E3E3';
        document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '#555555';
        document.getElementById('sesbody_font_color').color.fromString('#555555');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '#888888';
        document.getElementById('sesbody_font_color_light').color.fromString('#888888');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '#555555';
        document.getElementById('sesbody_heading_color').color.fromString('#555555');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '#111111';
        document.getElementById('sesbody_link_color').color.fromString('#111111');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '#A61C28';
        document.getElementById('sesbody_link_color_hover').color.fromString('#A61C28');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '#EEEEEE';
        document.getElementById('sesbody_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '#000000';
        document.getElementById('sesbody_input_font_color').color.fromString('#000000');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '#DCE0E3';
        document.getElementById('sesbody_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '#730710';
        document.getElementById('sesbody_button_background_color').color.fromString('#730710');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('#31302B');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '#FFFFFF';
        document.getElementById('sesbody_button_font_color').color.fromString('#FFFFFF');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '#fff';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '#A61C28';
				document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#A61C28');
			}
			if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '#730710';
				document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#730710');
			}
      //Body Styling
			//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#A61C28';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#A61C28');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#730710';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#730710');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#730710';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#730710');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#A61C28';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#A61C28');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#A61C28';
		document.getElementById('sesbody_footer_border_color').color.fromString('#A61C28');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#A61C28';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#A61C28');
	}
	// Footer Styling
    }
    else if(value == 9) {
      //Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '#EF672F';
        document.getElementById('sesbody_theme_color').color.fromString('#EF672F');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '#31302B';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '#E3E3E3';
        document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '#555555';
        document.getElementById('sesbody_font_color').color.fromString('#555555');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '#888888';
        document.getElementById('sesbody_font_color_light').color.fromString('#888888');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '#555555';
        document.getElementById('sesbody_heading_color').color.fromString('#555555');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '#111111';
        document.getElementById('sesbody_link_color').color.fromString('#111111');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '#EF672F';
        document.getElementById('sesbody_link_color_hover').color.fromString('#EF672F');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '#EEEEEE';
        document.getElementById('sesbody_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '#000000';
        document.getElementById('sesbody_input_font_color').color.fromString('#000000');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '#DCE0E3';
        document.getElementById('sesbody_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '#C14800';
        document.getElementById('sesbody_button_background_color').color.fromString('#C14800');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('#31302B');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '#FFFFFF';
        document.getElementById('sesbody_button_font_color').color.fromString('#FFFFFF');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '#fff';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '#EF672F';
				document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#EF672F');
			}
			if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '#C14800';
				document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#C14800');
			}
      //Body Styling
	//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#EF672F';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#EF672F');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#C14800';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#C14800');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#730710';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#730710');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#EF672F';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#EF672F');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#EF672F';
		document.getElementById('sesbody_footer_border_color').color.fromString('#EF672F');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#EF672F';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#EF672F');
	}
	// Footer Styling
    }
    else if(value == 10) {
      //Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '#0DC7F1';
        document.getElementById('sesbody_theme_color').color.fromString('#0DC7F1');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '#31302B';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('#31302B');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '#E3E3E3';
        document.getElementById('sesbody_body_background_color').color.fromString('#E3E3E3');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '#555555';
        document.getElementById('sesbody_font_color').color.fromString('#555555');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '#888888';
        document.getElementById('sesbody_font_color_light').color.fromString('#888888');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '#555555';
        document.getElementById('sesbody_heading_color').color.fromString('#555555');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '#111111';
        document.getElementById('sesbody_link_color').color.fromString('#111111');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '#0DC7F1';
        document.getElementById('sesbody_link_color_hover').color.fromString('#0DC7F1');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '#F1F1F1'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('#F1F1F1');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_content_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '#EEEEEE';
        document.getElementById('sesbody_content_border_color').color.fromString('#EEEEEE');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '#DDDDDD';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('#DDDDDD');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '#FFFFFF';
        document.getElementById('sesbody_input_background_color').color.fromString('#FFFFFF');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '#000000';
        document.getElementById('sesbody_input_font_color').color.fromString('#000000');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '#DCE0E3';
        document.getElementById('sesbody_input_border_color').color.fromString('#DCE0E3');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '#60ACC9';
        document.getElementById('sesbody_button_background_color').color.fromString('#60ACC9');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('#31302B');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '#31302B'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('#31302B');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '#FFFFFF';
        document.getElementById('sesbody_button_font_color').color.fromString('#FFFFFF');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '#fff';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '#0DC7F1';
				document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('#0DC7F1');
			}
			if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '#60ACC9';
				document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('#60ACC9');
			}
      //Body Styling
		//Header Styling
	if($('sesbody_header_background_color')) {
		$('sesbody_header_background_color').value = '#191919';
		document.getElementById('sesbody_header_background_color').color.fromString('#191919');
	}
	if($('sesbody_mainmenu_background_color')) {
		$('sesbody_mainmenu_background_color').value = '#0DC7F1';
		document.getElementById('sesbody_mainmenu_background_color').color.fromString('#0DC7F1');
	}
	if($('sesbody_mainmenu_link_color')) {
		$('sesbody_mainmenu_link_color').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color').color.fromString('#fff');
	}
		if($('sesbody_mainmenu_background_color_hover')) {
		$('sesbody_mainmenu_background_color_hover').value = '#60ACC9';
		document.getElementById('sesbody_mainmenu_background_color_hover').color.fromString('#60ACC9');
	}
	if($('sesbody_mainmenu_link_color_hover')) {
		$('sesbody_mainmenu_link_color_hover').value = '#fff';
		document.getElementById('sesbody_mainmenu_link_color_hover').color.fromString('#fff');
	}
	if($('sesbody_mainmenu_border_color')) {
		$('sesbody_mainmenu_border_color').value = '#60ACC9';
		document.getElementById('sesbody_mainmenu_border_color').color.fromString('#60ACC9');
	}
	if($('sesbody_minimenu_link_color')) {
		$('sesbody_minimenu_link_color').value = '#fff';
		document.getElementById('sesbody_minimenu_link_color').color.fromString('#fff');
	}
	if($('sesbody_minimenu_link_color_hover')) {
		$('sesbody_minimenu_link_color_hover').value = '#0DC7F1';
		document.getElementById('sesbody_minimenu_link_color_hover').color.fromString('#0DC7F1');
	}
	if($('sesbody_header_searchbox_background_color')) {
		$('sesbody_header_searchbox_background_color').value = '#191919';
		document.getElementById('sesbody_header_searchbox_background_color').color.fromString('#191919');
	}
	if($('sesbody_header_searchbox_text_color')) {
		$('sesbody_header_searchbox_text_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_text_color').color.fromString('#fff');
	}
	if($('sesbody_header_searchbox_border_color')) {
		$('sesbody_header_searchbox_border_color').value = '#fff';
		document.getElementById('sesbody_header_searchbox_border_color').color.fromString('#fff');
	}
// Footer Styling
 if($('sesbody_footer_background_color')) {
		$('sesbody_footer_background_color').value = '#191919';
		document.getElementById('sesbody_footer_background_color').color.fromString('#191919');
	}
	if($('sesbody_footer_border_color')) {
		$('sesbody_footer_border_color').value = '#0DC7F1';
		document.getElementById('sesbody_footer_border_color').color.fromString('#0DC7F1');
	}
	if($('sesbody_footer_link_color')) {
		$('sesbody_footer_link_color').value = '#fff';
		document.getElementById('sesbody_footer_link_color').color.fromString('#fff');
	}
	if($('sesbody_footer_link_hover_color')) {
		$('sesbody_footer_link_hover_color').value = '#0DC7F1';
		document.getElementById('sesbody_footer_link_hover_color').color.fromString('#0DC7F1');
	}
	// Footer Styling
    } 
    else if(value == 5) {
      //Theme Base Styling
      if($('sesbody_theme_color')) {
        $('sesbody_theme_color').value = '<?php echo $settings->getSetting('sesbody.theme.color') ?>';
        document.getElementById('sesbody_theme_color').color.fromString('<?php echo $settings->getSetting('sesbody.theme.color') ?>');
      }
      if($('sesbody_theme_secondary_color')) {
        $('sesbody_theme_secondary_color').value = '<?php echo $settings->getSetting('sesbody.theme.secondary.color') ?>';
        document.getElementById('sesbody_theme_secondary_color').color.fromString('<?php echo $settings->getSetting('sesbody.theme.secondary.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesbody_body_background_color')) {
        $('sesbody_body_background_color').value = '<?php echo $settings->getSetting('sesbody.body.background.color') ?>';
        document.getElementById('sesbody_body_background_color').color.fromString('<?php echo $settings->getSetting('sesbody.body.background.color') ?>');
      }
      if($('sesbody_font_color')) {
        $('sesbody_font_color').value = '<?php echo $settings->getSetting('sesbody.fontcolor') ?>';
        document.getElementById('sesbody_font_color').color.fromString('<?php echo $settings->getSetting('sesbody.fontcolor') ?>');
      }
      if($('sesbody_font_color_light')) {
        $('sesbody_font_color_light').value = '<?php echo $settings->getSetting('sesbody.font.color.light') ?>';
        document.getElementById('sesbody_font_color_light').color.fromString('<?php echo $settings->getSetting('sesbody.font.color.light') ?>');
      }
      if($('sesbody_heading_color')) {
        $('sesbody_heading_color').value = '<?php echo $settings->getSetting('sesbody.heading.color') ?>';
        document.getElementById('sesbody_heading_color').color.fromString('<?php echo $settings->getSetting('sesbody.heading.color') ?>');
      }
      if($('sesbody_link_color')) {
        $('sesbody_link_color').value = '<?php echo $settings->getSetting('sesbody.linkcolor') ?>';
        document.getElementById('sesbody_link_color').color.fromString('<?php echo $settings->getSetting('sesbody.linkcolor') ?>');
      }
      if($('sesbody_link_color_hover')) {
        $('sesbody_link_color_hover').value = '<?php echo $settings->getSetting('sesbody.link.color.hover') ?>';
        document.getElementById('sesbody_link_color_hover').color.fromString('<?php echo $settings->getSetting('sesbody.link.color.hover') ?>');
      }
      if($('sesbody_content_heading_background_color')) {
        $('sesbody_content_heading_background_color').value = '<?php echo $settings->getSetting('sesbody.content.heading.background.color') ?>'; 
        document.getElementById('sesbody_content_heading_background_color').color.fromString('<?php echo $settings->getSetting('sesbody.content.heading.background.color') ?>');
      }
      if($('sesbody_content_background_color')) {
        $('sesbody_content_background_color').value = '<?php echo $settings->getSetting('sesbody.content.background.color') ?>';
        document.getElementById('sesbody_content_background_color').color.fromString('<?php echo $settings->getSetting('sesbody.content.background.color') ?>');
      }
      if($('sesbody_content_border_color')) {
        $('sesbody_content_border_color').value = '<?php echo $settings->getSetting('sesbody.content.bordercolor') ?>';
        document.getElementById('sesbody_content_border_color').color.fromString('<?php echo $settings->getSetting('sesbody.content.bordercolor') ?>');
      }
      if($('sesbody_content_border_color_dark')) {
        $('sesbody_content_border_color_dark').value = '<?php echo $settings->getSetting('sesbody.content.border.color.dark') ?>';
        document.getElementById('sesbody_content_border_color_dark').color.fromString('<?php echo $settings->getSetting('sesbody.content.border.color.dark') ?>');
      }
      if($('sesbody_input_background_color')) {
        $('sesbody_input_background_color').value = '<?php echo $settings->getSetting('sesbody.input.background.color') ?>';
        document.getElementById('sesbody_input_background_color').color.fromString('<?php echo $settings->getSetting('sesbody.input.background.color') ?>');
      }
      if($('sesbody_input_font_color')) {
        $('sesbody_input_font_color').value = '<?php echo $settings->getSetting('sesbody.input.font.color') ?>';
        document.getElementById('sesbody_input_font_color').color.fromString('<?php echo $settings->getSetting('sesbody.input.font.color') ?>');
      }
      if($('sesbody_input_border_color')) {
        $('sesbody_input_border_color').value = '<?php echo $settings->getSetting('sesbody.input.border.color') ?>';
        document.getElementById('sesbody_input_border_color').color.fromString('<?php echo $settings->getSetting('sesbody.input.border.color') ?>');
      }
      if($('sesbody_button_background_color')) {
        $('sesbody_button_background_color').value = '<?php echo $settings->getSetting('sesbody.button.backgroundcolor') ?>';
        document.getElementById('sesbody_button_background_color').color.fromString('<?php echo $settings->getSetting('sesbody.button.backgroundcolor') ?>');
      }
      if($('sesbody_button_background_color_hover')) {
        $('sesbody_button_background_color_hover').value = '<?php echo $settings->getSetting('sesbody.button.background.color.hover') ?>'; 
        document.getElementById('sesbody_button_background_color_hover').color.fromString('<?php echo $settings->getSetting('sesbody.button.background.color.hover') ?>');
      }
      if($('sesbody_button_background_color_active')) {
        $('sesbody_button_background_color_active').value = '<?php echo $settings->getSetting('sesbody.button.background.color.active') ?>'; 
        document.getElementById('sesbody_button_background_color_active').color.fromString('<?php echo $settings->getSetting('sesbody.button.background.color.active') ?>');
      }
      if($('sesbody_button_font_color')) {
        $('sesbody_button_font_color').value = '<?php echo $settings->getSetting('sesbody.button.font.color') ?>';
        document.getElementById('sesbody_button_font_color').color.fromString('<?php echo $settings->getSetting('sesbody.button.font.color') ?>');
      }
			if($('sesbody_button_font_hover_color')) {
				$('sesbody_button_font_hover_color').value = '<?php echo $settings->getSetting('sesbody.button.font.hover.color') ?>';
				document.getElementById('sesbody_button_font_hover_color').color.fromString('<?php echo $settings->getSetting('sesbody.button.font.hover.color') ?>');
			}
			if($('sesbody_button_background_gradient_top_color')) {
				$('sesbody_button_background_gradient_top_color').value = '<?php echo $settings->getSetting('sesbody.button.background.gradient.top.color') ?>';
				document.getElementById('sesbody_button_background_gradient_top_color').color.fromString('<?php echo $settings->getSetting('sesbody.button.background.gradient.top.color') ?>');
			}
			if($('sesbody_button_background_gradient_top_hover_color')) {
				$('sesbody_button_background_gradient_top_hover_color').value = '<?php echo $settings->getSetting('sesbody.button.background.gradient.top.hover.color') ?>';
				document.getElementById('sesbody_button_background_gradient_top_hover_color').color.fromString('<?php echo $settings->getSetting('sesbody.button.background.gradient.top.hover.color') ?>');
			}
      //Body Styling
    }
	}
</script>