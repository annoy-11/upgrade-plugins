<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesytube_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesytube()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 13) {
      var URL = en4.core.staticBaseUrl+'sesytube/admin-settings/getcustomthemecolors/';
      (new Request.HTML({
          method: 'post',
          'url': URL ,
          'data': {
            format: 'html',
            customtheme_id: value,
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          var customthevalyearray = jqueryObjectOfSes.parseJSON(responseHTML);
          
          for(i=0;i<customthevalyearray.length;i++){
            var splitValue = customthevalyearray[i].split('||');
            jqueryObjectOfSes('#'+splitValue[0]).val(splitValue[1]);
            if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor'))
            document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
          }
        }
      })).send();
    }
    changeThemeColor(value, 'custom');
  }

	function changeThemeColor(value, custom) {

	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4 || value == 6 || value == 7 || value == 8 || value == 9 || value == 10 || value == 11 || value == 12 || value == 13)) {
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
      if($('custom_themes'))
				$('custom_themes').style.display = 'none';
      if($('edit_custom_themes'))
        $('edit_custom_themes').style.display = 'none';
      if($('delete_custom_themes'))
        $('delete_custom_themes').style.display = 'none';
      if($('deletedisabled_custom_themes'))
        $('deletedisabled_custom_themes').style.display = 'none';
      if($('submit'))
        $('submit').style.display = 'none';
	  } else if(custom == '' && value == 5) {
	    
	    if($('custom_theme_color-wrapper'))
				$('custom_theme_color-wrapper').style.display = 'block';
      if($('custom_themes'))
				$('custom_themes').style.display = 'block';
      <?php if($this->customtheme_id): ?>
        //value = '<?php echo $this->customtheme_id; ?>';
        changeCustomThemeColor('<?php echo $this->customtheme_id; ?>');
      <?php else: ?>
        changeCustomThemeColor(5);
      <?php endif; ?>
		 // changeCustomThemeColor(5);
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
			  
      if($('custom_theme_color').value > 13) {
        if($('submit'))
          $('submit').style.display = 'inline-block';
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'block';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'block';

        <?php if(empty($this->customtheme_id)): ?>
          history.pushState(null, null, 'admin/sesytube/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesytube/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesytube/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sesytube/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesytube/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesytube/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          }
        <?php endif; ?>
      } else {
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'none';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'none';
        if($('deletedisabled_custom_themes'))
          $('deletedisabled_custom_themes').style.display = 'none';
        if($('submit'))
          $('submit').style.display = 'none';
      }
	  }


		if(value == 1) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#ee0f11';
				document.getElementById('sesytube_theme_color').color.fromString('#ee0f11');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#ee0f11';
				document.getElementById('sesytube_links_hover_color').color.fromString('#ee0f11');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#ee0f11';
				document.getElementById('sesytube_button_background_color').color.fromString('#ee0f11');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#fe2022';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#fe2022');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#EE0F11';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#EE0F11');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#EE0F11';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#EE0F11');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#EE0F11';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#EE0F11');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#EE0F11';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#EE0F11');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff');
			}
			//Login Pop up Styling
			//Header Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#03aaf5';
				document.getElementById('sesytube_theme_color').color.fromString('#03aaf5');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#03aaf5';
				document.getElementById('sesytube_links_hover_color').color.fromString('#03aaf5');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#03aaf5';
				document.getElementById('sesytube_button_background_color').color.fromString('#03aaf5');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#0098dd';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#0098dd');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#03aaf5';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#03aaf5');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#03aaf5';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#03aaf5');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#03aaf5';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#03aaf5');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#03aaf5';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#03aaf5');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#8bc34a';
				document.getElementById('sesytube_theme_color').color.fromString('#8bc34a');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#8bc34a';
				document.getElementById('sesytube_links_hover_color').color.fromString('#8bc34a');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#8bc34a';
				document.getElementById('sesytube_button_background_color').color.fromString('#8bc34a');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#7cb43b';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#7cb43b');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#8bc34a';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#8bc34a');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#7cb43b';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#7cb43b');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098dd';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098dd');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#8bc34a';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#8bc34a');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#8bc34a';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#8bc34a');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
		else if(value == 4) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#ff9800';
				document.getElementById('sesytube_theme_color').color.fromString('#ff9800');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#ff9800';
				document.getElementById('sesytube_links_hover_color').color.fromString('#ff9800');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#ff9800';
				document.getElementById('sesytube_button_background_color').color.fromString('#ff9800');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#e78f0e';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#e78f0e');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#ff9800';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#ff9800');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#ff9800';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#ff9800');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098dd';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098dd');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#ff9800';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#ff9800');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#ff9800';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#ff9800');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
 		else if(value == 6) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#FB0060';
				document.getElementById('sesytube_theme_color').color.fromString('#FB0060');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#FB0060';
				document.getElementById('sesytube_links_hover_color').color.fromString('#FB0060');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#FB0060';
				document.getElementById('sesytube_button_background_color').color.fromString('#FB0060');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#DD0859';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#DD0859');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#FB0060';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#FB0060');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FB0060';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FB0060');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098dd';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098dd');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#FB0060';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#FB0060');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#FB0060';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#FB0060');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
    else if(value == 7) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#2C6C73';
				document.getElementById('sesytube_theme_color').color.fromString('#2C6C73');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#fafafa';
				document.getElementById('sesytube_body_background_color').color.fromString('#fafafa');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#545454';
				document.getElementById('sesytube_font_color').color.fromString('#545454');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#545454';
				document.getElementById('sesytube_heading_color').color.fromString('#545454s');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#000000';
				document.getElementById('sesytube_links_color').color.fromString('#000000');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#2C6C73';
				document.getElementById('sesytube_links_hover_color').color.fromString('#2C6C73');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#545454';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#545454');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#f2f2f2';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#f2f2f2');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#ededed';
				document.getElementById('sesytube_content_border_color').color.fromString('#ededed');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#545454';
				document.getElementById('sesytube_form_label_color').color.fromString('#545454');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#ffffff';
				document.getElementById('sesytube_input_background_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#545454';
				document.getElementById('sesytube_input_font_color').color.fromString('#545454');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#C6C6C6';
				document.getElementById('sesytube_input_border_color').color.fromString('#C6C6C6');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#2C6C73';
				document.getElementById('sesytube_button_background_color').color.fromString('#2C6C73');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#21575D';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#21575D');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#ffffff';
				document.getElementById('sesytube_button_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesytube_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#FFFFFF';
				document.getElementById('sesytube_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#2C6C73';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#2C6C73');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#f5f5f5';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#f5f5f5');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#ebebeb';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#ebebeb');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#000000';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#000000');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#2C6C73';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#2C6C73');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#dcdcdc';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#dcdcdc');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59b2f6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59b2f6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098dd';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098dd');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9c9c9c';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9c9c9c');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#2C6C73';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#2C6C73');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#F5F5F5';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#F5F5F5');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#a0a0a0';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#a0a0a0');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#2C6C73';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#2C6C73');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
    else if(value == 8) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#EE0F11';
				document.getElementById('sesytube_theme_color').color.fromString('#EE0F11');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#EE0F11';
				document.getElementById('sesytube_links_hover_color').color.fromString('#EE0F11');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#EE0F11';
				document.getElementById('sesytube_button_background_color').color.fromString('#EE0F11');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#FE2022';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#FE2022');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#EE0F11';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#EE0F11');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#EE0F11';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#EE0F11');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#EE0F11';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#EE0F11');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
    else if(value == 9) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#03aaf5';
				document.getElementById('sesytube_theme_color').color.fromString('#03aaf5');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#03aaf5';
				document.getElementById('sesytube_links_hover_color').color.fromString('#03aaf5');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#03aaf5';
				document.getElementById('sesytube_button_background_color').color.fromString('#03aaf5');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#0098dd';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#0098dd');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#03aaf5';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#03aaf5');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#03aaf5';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#03aaf5');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#03aaf5';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#03aaf5');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		}
    else if(value == 10) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#8bc34a';
				document.getElementById('sesytube_theme_color').color.fromString('#8bc34a');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#8bc34a';
				document.getElementById('sesytube_links_hover_color').color.fromString('#8bc34a');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#8bc34a';
				document.getElementById('sesytube_button_background_color').color.fromString('#8bc34a');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#7cb43b';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#7cb43b');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#8bc34a';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#8bc34a');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#8bc34a';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#8bc34a');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#8bc34a';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#8bc34a');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		} else if(value == 11) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#ff9800';
				document.getElementById('sesytube_theme_color').color.fromString('#ff9800');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#ff9800';
				document.getElementById('sesytube_links_hover_color').color.fromString('#ff9800');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#ff9800';
				document.getElementById('sesytube_button_background_color').color.fromString('#ff9800');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#e78f0e';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#e78f0e');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#ff9800';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#ff9800');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#ff9800';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#ff9800');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#ff9800';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#ff9800');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		} else if(value == 12) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#fb0060';
				document.getElementById('sesytube_theme_color').color.fromString('#fb0060');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#fb0060';
				document.getElementById('sesytube_links_hover_color').color.fromString('#fb0060');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#fb0060';
				document.getElementById('sesytube_button_background_color').color.fromString('#fb0060');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#dd0859';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#dd0859');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#fb0060';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#fb0060');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#fb0060';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#fb0060');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#fb0060';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#fb0060');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		} else if(value == 13) {
			//Theme Base Styling
			if($('sesytube_theme_color')) {
				$('sesytube_theme_color').value = '#2C6C73';
				document.getElementById('sesytube_theme_color').color.fromString('#2C6C73');
			}
			//Theme Base Styling
			//Body Styling
			if($('sesytube_body_background_color')) {
				$('sesytube_body_background_color').value = '#121212';
				document.getElementById('sesytube_body_background_color').color.fromString('#121212');
			}
			if($('sesytube_font_color')) {
				$('sesytube_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_font_color_light')) {
				$('sesytube_font_color_light').value = '#999999';
				document.getElementById('sesytube_font_color_light').color.fromString('#999999');
			}
			if($('sesytube_heading_color')) {
				$('sesytube_heading_color').value = '#ffffff';
				document.getElementById('sesytube_heading_color').color.fromString('#ffffff');
			}
			if($('sesytube_links_color')) {
				$('sesytube_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_links_hover_color')) {
				$('sesytube_links_hover_color').value = '#2C6C73';
				document.getElementById('sesytube_links_hover_color').color.fromString('#2C6C73');
			}
			if($('sesytube_content_header_font_color')) {
				$('sesytube_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_content_background_color')) {
				$('sesytube_content_background_color').value = '#282828';
				document.getElementById('sesytube_content_background_color').color.fromString('#282828');
			}
			if($('sesytube_content_background_color_hover')) {
				$('sesytube_content_background_color_hover').value = '#474747';
				document.getElementById('sesytube_content_background_color_hover').color.fromString('#474747');
			}
			if($('sesytube_content_border_color')) {
				$('sesytube_content_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_content_border_color').color.fromString('#4d4d4d');
			}
			if($('sesytube_form_label_color')) {
				$('sesytube_form_label_color').value = '#ffffff';
				document.getElementById('sesytube_form_label_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_background_color')) {
				$('sesytube_input_background_color').value = '#191919';
				document.getElementById('sesytube_input_background_color').color.fromString('#191919');
			}
			if($('sesytube_input_font_color')) {
				$('sesytube_input_font_color').value = '#ffffff';
				document.getElementById('sesytube_input_font_color').color.fromString('#ffffff');
			}
			if($('sesytube_input_border_color')) {
				$('sesytube_input_border_color').value = '#4d4d4d';
				document.getElementById('sesytube_input_border_color').color.fromString('#333333');
			}
			if($('sesytube_button_background_color')) {
				$('sesytube_button_background_color').value = '#2C6C73';
				document.getElementById('sesytube_button_background_color').color.fromString('#2C6C73');
			}
			if($('sesytube_button_background_color_hover')) {
				$('sesytube_button_background_color_hover').value = '#21575D';
				document.getElementById('sesytube_button_background_color_hover').color.fromString('#21575D');
			}
			if($('sesytube_button_font_color')) {
				$('sesytube_button_font_color').value = '#FFFFFF';
				document.getElementById('sesytube_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_button_font_hover_color')) {
				$('sesytube_button_font_hover_color').value = '#fff';
				document.getElementById('sesytube_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesytube_comment_background_color')) {
				$('sesytube_comment_background_color').value = '#303030';
				document.getElementById('sesytube_comment_background_color').color.fromString('#303030');
			}
			//Body Styling
			//Header Styling
			if($('sesytube_header_background_color')) {
				$('sesytube_header_background_color').value = '#282828';
				document.getElementById('sesytube_header_background_color').color.fromString('#282828');
			}
			if($('sesytube_menu_logo_font_color')) {
				$('sesytube_menu_logo_font_color').value = '#2C6C73';
				document.getElementById('sesytube_menu_logo_font_color').color.fromString('#2C6C73');
			}
			if($('sesytube_mainmenu_background_color')) {
				$('sesytube_mainmenu_background_color').value = '#1C1C1C';
				document.getElementById('sesytube_mainmenu_background_color').color.fromString('#1C1C1C');
			}
			if($('sesytube_mainmenu_background_hover_color')) {
				$('sesytube_mainmenu_background_hover_color').value = '#474747';
				document.getElementById('sesytube_mainmenu_background_hover_color').color.fromString('#474747');
			}
			if($('sesytube_mainmenu_links_color')) {
				$('sesytube_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesytube_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_mainmenu_links_hover_color')) {
				$('sesytube_mainmenu_links_hover_color').value = '#FFFFFF';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#FFFFFF');
			}
			if($('sesytube_topbar_menu_section_border_color')) {
				$('sesytube_topbar_menu_section_border_color').value = '#333333';
				document.getElementById('sesytube_topbar_menu_section_border_color').color.fromString('#333333');
			}
			if($('sesytube_minimenu_links_color')) {
				$('sesytube_minimenu_links_color').value = '#59B2F6';
				document.getElementById('sesytube_minimenu_links_color').color.fromString('#59B2F6');
			}
			if($('sesytube_minimenu_links_hover_color')) {
				$('sesytube_minimenu_links_hover_color').value = '#0098DD';
				document.getElementById('sesytube_minimenu_links_hover_color').color.fromString('#0098DD');
			}
			if($('sesytube_minimenu_icon_color')) {
				$('sesytube_minimenu_icon_color').value = '#9C9C9C';
				document.getElementById('sesytube_minimenu_icon_color').color.fromString('#9C9C9C');
			}
			if($('sesytube_minimenu_icon_active_color')) {
				$('sesytube_minimenu_icon_active_color').value = '#2C6C73';
				document.getElementById('sesytube_minimenu_icon_active_color').color.fromString('#2C6C73');
			}
			if($('sesytube_header_searchbox_background_color')) {
				$('sesytube_header_searchbox_background_color').value = '#191919';
				document.getElementById('sesytube_header_searchbox_background_color').color.fromString('#191919');
			}
			if($('sesytube_header_searchbox_text_color')) {
				$('sesytube_header_searchbox_text_color').value = '#ffffff';
				document.getElementById('sesytube_header_searchbox_text_color').color.fromString('#ffffff');
			}
			//Login Popup Styling
			if($('sesytube_login_popup_header_background_color')) {
				$('sesytube_login_popup_header_background_color').value = '#2C6C73';
				document.getElementById('sesytube_login_popup_header_background_color').color.fromString('#2C6C73');
			}
			if($('sesytube_login_popup_header_font_color')) {
				$('sesytube_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesytube_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
		} else if(value == 5) {
			
      //Theme Base Styling
      if($('sesytube_theme_color')) {
        $('sesytube_theme_color').value = '<?php echo $settings->getSetting('sesytube.theme.color') ?>';
      }
      //Theme Base Styling
      //Body Styling
      if($('sesytube_body_background_color')) {
        $('sesytube_body_background_color').value = '<?php echo $settings->getSetting('sesytube.body.background.color') ?>';
      }
      if($('sesytube_font_color')) {
        $('sesytube_font_color').value = '<?php echo $settings->getSetting('sesytube.fontcolor') ?>';
      }
      if($('sesytube_font_color_light')) {
        $('sesytube_font_color_light').value = '<?php echo $settings->getSetting('sesytube.font.color.light') ?>';
      }
      if($('sesytube_heading_color')) {
        $('sesytube_heading_color').value = '<?php echo $settings->getSetting('sesytube.heading.color') ?>';
      }
      if($('sesytube_links_color')) {
        $('sesytube_links_color').value = '<?php echo $settings->getSetting('sesytube.links.color') ?>';
      }
      if($('sesytube_links_hover_color')) {
        $('sesytube_links_hover_color').value = '<?php echo $settings->getSetting('sesytube.links.hover.color') ?>';
      }
			if($('sesytube_content_header_font_color')) {
        $('sesytube_content_header_font_color').value = '<?php echo $settings->getSetting('sesytube.content.header.font.color') ?>';
      }
      if($('sesytube_content_background_color')) {
        $('sesytube_content_background_color').value = '<?php echo $settings->getSetting('sesytube.content.backgroundcolor') ?>';
      }
      if($('sesytube_content_background_color_hover')) {
        $('sesytube_content_background_color_hover').value = '<?php echo $settings->getSetting('sesytube.content.background.color.hover') ?>';
      }
      if($('sesytube_content_border_color')) {
        $('sesytube_content_border_color').value = '<?php echo $settings->getSetting('sesytube.content.border.color') ?>';
      }
      if($('sesytube_form_label_color')) {
        $('sesytube_input_font_color').value = '<?php echo $settings->getSetting('sesytube.form.label.color') ?>';
      }
      if($('sesytube_input_background_color')) {
        $('sesytube_input_background_color').value = '<?php echo $settings->getSetting('sesytube.input.background.color') ?>';
      }
      if($('sesytube_input_font_color')) {
        $('sesytube_input_font_color').value = '<?php echo $settings->getSetting('sesytube.input.font.color') ?>';
      }
      if($('sesytube_input_border_color')) {
        $('sesytube_input_border_color').value = '<?php echo $settings->getSetting('sesytube.input.border.color') ?>';
      }
      if($('sesytube_button_background_color')) {
        $('sesytube_button_background_color').value = '<?php echo $settings->getSetting('sesytube.button.backgroundcolor') ?>';
      }
      if($('sesytube_button_background_color_hover')) {
        $('sesytube_button_background_color_hover').value = '<?php echo $settings->getSetting('sesytube.button.background.color.hover') ?>';
      }
      if($('sesytube_button_font_color')) {
        $('sesytube_button_font_color').value = '<?php echo $settings->getSetting('sesytube.button.font.color') ?>';
      }
      if($('sesytube_button_font_hover_color')) {
        $('sesytube_button_font_hover_color').value = '<?php echo $settings->getSetting('sesytube.button.font.hover.color') ?>';
      }
      if($('sesytube_comment_background_color')) {
        $('sesytube_comment_background_color').value = '<?php echo $settings->getSetting('sesytube.comment.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sesytube_header_background_color')) {
        $('sesytube_header_background_color').value = '<?php echo $settings->getSetting('sesytube.header.background.color') ?>';
      }
			if($('sesytube_mainmenu_background_color')) {
        $('sesytube_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesytube.mainmenu.background.color') ?>';
      }
			if($('sesytube_mainmenu_background_hover_color')) {
        $('sesytube_mainmenu_background_hover_color').value = '<?php echo $settings->getSetting('sesytube.mainmenu.background.hover.color') ?>';
      }
      if($('sesytube_mainmenu_links_color')) {
        $('sesytube_mainmenu_links_color').value = '<?php echo $settings->getSetting('sesytube.mainmenu.links.color') ?>';
      }
      if($('sesytube_mainmenu_links_hover_color')) {
        $('sesytube_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sesytube.mainmenu.links.hover.color') ?>';
      }
			if($('sesytube_topbar_menu_section_border_color')) {
        $('sesytube_topbar_menu_section_border_color').value = '<?php echo $settings->getSetting('sesytube.topbar.menu.section.border.color') ?>';
      }
      if($('sesytube_minimenu_links_color')) {
        $('sesytube_minimenu_links_color').value = '<?php echo $settings->getSetting('sesytube.minimenu.links.color') ?>';
      }
      if($('sesytube_minimenu_links_hover_color')) {
        $('sesytube_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sesytube.minimenu.links.hover.color') ?>';
      }
      if($('sesytube_minimenu_icon_color')) {
        $('sesytube_minimenu_icon_color').value = '<?php echo $settings->getSetting('sesytube.minimenu.icon.color') ?>';
      }
      if($('sesytube_minimenu_icon_active_color')) {
        $('sesytube_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sesytube.minimenu.icon.active.color') ?>';
      }
      if($('sesytube_header_searchbox_background_color')) {
        $('sesytube_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesytube.header.searchbox.background.color') ?>';
      }
      if($('sesytube_header_searchbox_text_color')) {
        $('sesytube_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesytube.header.searchbox.text.color') ?>';
      }
			//Login Popup Styling
      if($('sesytube_login_popup_header_font_color')) {
        $('sesytube_login_popup_header_font_color').value = '<?php echo $settings->getSetting('sesytube.login.popup.header.font.color'); ?>';
      }
      if($('sesytube_login_popup_header_background_color')) {
        $('sesytube_login_popup_header_background_color').value = '<?php echo $settings->getSetting('sesytube.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

    }
	}
</script>
