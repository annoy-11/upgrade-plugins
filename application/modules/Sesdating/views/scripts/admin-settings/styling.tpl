<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating
 * @package    Sesdating
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sesdating/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sesdating_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesdating()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 13) {
      var URL = en4.core.staticBaseUrl+'sesdating/admin-settings/getcustomthemecolors/';
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
          history.pushState(null, null, 'admin/sesdating/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesdating/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesdating/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sesdating/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesdating/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesdating/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
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
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#bf3f34';
				document.getElementById('sesdating_theme_color').color.fromString('#bf3f34');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#bf3f34';
				document.getElementById('sesdating_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#bf3f34';
				document.getElementById('sesdating_button_background_color').color.fromString('#bf3f34');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#243238';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#bf3f34';
				document.getElementById('sesdating_header_background_color').color.fromString('#bf3f34');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#bf3f34';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#bf3f34';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#bf3f34');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#bf3f34';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#bf3f34');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#bf3f34';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#bf3f34');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#bf3f34';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#bf3f34 ');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#fff';
				document.getElementById('sesdating_footer_background_color').color.fromString('#fff');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#243238';
				document.getElementById('sesdating_footer_links_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#bf3f34';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
		 else if(value == 2) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#0296C0';
				document.getElementById('sesdating_theme_color').color.fromString('#0296C0');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#0296C0';
				document.getElementById('sesdating_links_hover_color').color.fromString('#0296C0');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#ED0058';
				document.getElementById('sesdating_button_background_color').color.fromString('#ED0058');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#0296C0';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#0296C0');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
					//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#0296C0';
				document.getElementById('sesdating_header_background_color').color.fromString('#0296C0');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#0296C0';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#0296C0');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#0296C0';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#0296C0');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#0296C0';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#0296C0');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#0296C0';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#0296C0');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#0296C0';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#0296C0');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#000627';
				document.getElementById('sesdating_footer_background_color').color.fromString('#000627');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#fff';
				document.getElementById('sesdating_footer_links_color').color.fromString('#fff');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#0296C0';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#0296C0');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#d03e82';
				document.getElementById('sesdating_theme_color').color.fromString('#d03e82');
			}
			//Theme Base Styling
			
	//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#101419';
				document.getElementById('sesdating_body_background_color').color.fromString('#101419');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#CCCCCC';
				document.getElementById('sesdating_font_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#fff';
				document.getElementById('sesdating_font_color_light').color.fromString('#fff');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#b1b1b1';
				document.getElementById('sesdating_heading_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#fff';
				document.getElementById('sesdating_links_color').color.fromString('#fff');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#d03e82';
				document.getElementById('sesdating_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#b1b1b1';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#334354';
				document.getElementById('sesdating_content_border_color').color.fromString('#334354');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#CCCCCC';
				document.getElementById('sesdating_form_label_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#CCCCCC';
				document.getElementById('sesdating_input_background_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#243238';
				document.getElementById('sesdating_input_font_color').color.fromString('#243238');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#d03e82';
				document.getElementById('sesdating_button_background_color').color.fromString('#d03e82');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#fff';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#fff');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#fff';
				document.getElementById('sesdating_button_font_color').color.fromString('#fff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#243238';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#243238');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#1D2632';
				document.getElementById('sesdating_comment_background_color').color.fromString('#1D2632');
			}
			
		//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#1D2632';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#d03e82';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#d03e82';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#d03e82');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#fff';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#FFF';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#FFF');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#d03e82';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#d03e82');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#d03e82';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#d03e82');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#d03e82';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#d03e82');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#d03e82';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#d03e82');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#26323F';
				document.getElementById('sesdating_footer_background_color').color.fromString('#26323F');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#d03e82';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_border_color').color.fromString('#B3B3B3');
			}
			//Footer Styling

		}
		else if(value == 4) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#7155f9';
				document.getElementById('sesdating_theme_color').color.fromString('#7155f9');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#7155f9';
				document.getElementById('sesdating_links_hover_color').color.fromString('#7155f9');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#7155f9';
				document.getElementById('sesdating_button_background_color').color.fromString('#7155f9');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#243238';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
								//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#7155f9';
				document.getElementById('sesdating_header_background_color').color.fromString('#7155f9');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#7155f9';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#7155f9');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#7155f9';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#7155f9');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#7155f9';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#7155f9');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#7155f9';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#7155f9');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#7155f9';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#7155f9');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#fff';
				document.getElementById('sesdating_footer_background_color').color.fromString('#fff');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#243238';
				document.getElementById('sesdating_footer_links_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#7155f9';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#7155f9');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
 		else if(value == 6) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#03A9F4';
				document.getElementById('sesdating_theme_color').color.fromString('#03A9F4');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#03A9F4';
				document.getElementById('sesdating_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#03A9F4';
				document.getElementById('sesdating_button_background_color').color.fromString('#03A9F4');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#243238';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#03A9F4';
				document.getElementById('sesdating_header_background_color').color.fromString('#03A9F4');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#03A9F4';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#03A9F4';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#03A9F4');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#03A9F4';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#03A9F4');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#03A9F4';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#03A9F4');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#03A9F4';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#03A9F4');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#fff';
				document.getElementById('sesdating_footer_background_color').color.fromString('#fff');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#243238';
				document.getElementById('sesdating_footer_links_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#03A9F4';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#FF5722';
				document.getElementById('sesdating_theme_color').color.fromString('#FF5722');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#101419';
				document.getElementById('sesdating_body_background_color').color.fromString('#101419');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#CCCCCC';
				document.getElementById('sesdating_font_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#fff';
				document.getElementById('sesdating_font_color_light').color.fromString('#fff');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#b1b1b1';
				document.getElementById('sesdating_heading_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#fff';
				document.getElementById('sesdating_links_color').color.fromString('#fff');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#FF5722';
				document.getElementById('sesdating_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#b1b1b1';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#334354';
				document.getElementById('sesdating_content_border_color').color.fromString('#334354');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#CCCCCC';
				document.getElementById('sesdating_form_label_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#CCCCCC';
				document.getElementById('sesdating_input_background_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#243238';
				document.getElementById('sesdating_input_font_color').color.fromString('#243238');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#FF5722';
				document.getElementById('sesdating_button_background_color').color.fromString('#FF5722');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#fff';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#fff');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#fff';
				document.getElementById('sesdating_button_font_color').color.fromString('#fff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#243238';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#243238');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#1D2632';
				document.getElementById('sesdating_comment_background_color').color.fromString('#1D2632');
			}
			//Body Styling
			
				
								//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#1D2632';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#FF5722';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#FF5722';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#FF5722');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#fff';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#FFF';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#FFF');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#FF5722';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#FF5722');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#FF5722';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#FF5722');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#FF5722';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#FF5722');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#FF5722';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#FF5722');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#26323F';
				document.getElementById('sesdating_footer_background_color').color.fromString('#26323F');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#FFFFFF';
				document.getElementById('sesdating_footer_links_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#FF5722';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_border_color').color.fromString('#B3B3B3');
			}
			//Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#673AB7';
				document.getElementById('sesdating_theme_color').color.fromString('#673AB7');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#673AB7';
				document.getElementById('sesdating_links_hover_color').color.fromString('#673AB7');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#673AB7';
				document.getElementById('sesdating_button_background_color').color.fromString('#673AB7');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#243238';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
				//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#673AB7';
				document.getElementById('sesdating_header_background_color').color.fromString('#673AB7');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#673AB7';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#673AB7');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#673AB7';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#673AB7');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#673AB7';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#673AB7');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#673AB7';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#673AB7');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#673AB7';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#673AB7');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#fff';
				document.getElementById('sesdating_footer_background_color').color.fromString('#fff');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#243238';
				document.getElementById('sesdating_footer_links_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#673AB7';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#673AB7');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
    else if(value == 9) {
		 //Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#009f8b';
				document.getElementById('sesdating_theme_color').color.fromString('#009f8b');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#999';
				document.getElementById('sesdating_font_color_light').color.fromString('#999');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#009f8b';
				document.getElementById('sesdating_links_hover_color').color.fromString('#009f8b');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#ebecee';
				document.getElementById('sesdating_content_border_color').color.fromString('#ebecee');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#ffffff';
				document.getElementById('sesdating_input_background_color').color.fromString('#ffffff');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#009f8b';
				document.getElementById('sesdating_button_background_color').color.fromString('#009f8b');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#243238';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#ffffff';
				document.getElementById('sesdating_button_font_color').color.fromString('#ffffff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#fff';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesdating_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#009f8b';
				document.getElementById('sesdating_header_background_color').color.fromString('#009f8b');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#009f8b';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#009f8b');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#009f8b';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#009f8b');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#009f8b';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#009f8b');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#009f8b';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#009f8b');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#009f8b';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#009f8b');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#fff';
				document.getElementById('sesdating_footer_background_color').color.fromString('#fff');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#243238';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#243238';
				document.getElementById('sesdating_footer_links_color').color.fromString('#243238');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#009f8b';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#009f8b');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
		}
    else if(value == 10) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#ff9800';
				document.getElementById('sesdating_theme_color').color.fromString('#ff9800');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#101419';
				document.getElementById('sesdating_body_background_color').color.fromString('#101419');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#CCCCCC';
				document.getElementById('sesdating_font_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#fff';
				document.getElementById('sesdating_font_color_light').color.fromString('#fff');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#b1b1b1';
				document.getElementById('sesdating_heading_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#fff';
				document.getElementById('sesdating_links_color').color.fromString('#fff');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#ff9800';
				document.getElementById('sesdating_links_hover_color').color.fromString('#ff9800');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#b1b1b1';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#334354';
				document.getElementById('sesdating_content_border_color').color.fromString('#334354');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#CCCCCC';
				document.getElementById('sesdating_form_label_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#CCCCCC';
				document.getElementById('sesdating_input_background_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#243238';
				document.getElementById('sesdating_input_font_color').color.fromString('#243238');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#ff9800';
				document.getElementById('sesdating_button_background_color').color.fromString('#ff9800');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#fff';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#fff');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#fff';
				document.getElementById('sesdating_button_font_color').color.fromString('#fff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#243238';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#243238');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#1D2632';
				document.getElementById('sesdating_comment_background_color').color.fromString('#1D2632');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#1D2632';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#ff9800';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#ff9800');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#ff9800';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#ff9800');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#fff';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#FFF';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#FFF');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#ff9800';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#ff9800');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#ff9800';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#ff9800');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#ff9800';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#ff9800');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#ff9800';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#ff9800');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#26323F';
				document.getElementById('sesdating_footer_background_color').color.fromString('#26323F');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#ff9800';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#ff9800');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_border_color').color.fromString('#B3B3B3');
			}
			//Footer Styling
    }
		else if(value == 11) {
    
      //Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#ed54a4';
				document.getElementById('sesdating_theme_color').color.fromString('#ED54A4');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#F5F5F5';
				document.getElementById('sesdating_body_background_color').color.fromString('#F5F5F5');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#707070';
				document.getElementById('sesdating_font_color_light').color.fromString('#707070');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#243238';
				document.getElementById('sesdating_links_color').color.fromString('#243238');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#4682B4';
				document.getElementById('sesdating_links_hover_color').color.fromString('#4682B4');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#EBECEE';
				document.getElementById('sesdating_content_border_color').color.fromString('#EBECEE');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_input_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#E8288D';
				document.getElementById('sesdating_button_background_color').color.fromString('#E8288D');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#4682B4';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#4682B4');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#FDFDFD';
				document.getElementById('sesdating_comment_background_color').color.fromString('#FDFDFD');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#E8288D';
				document.getElementById('sesdating_header_background_color').color.fromString('#E8288D');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#E8288D';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#E8288D');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#E8288D';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#E8288D');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#E8288D';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#E8288D');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#ED54A4';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#ED54A4');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#ED54A4';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#ED54A4 ');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#FFFFFF');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_footer_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#A4A4A4';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#A4A4A4');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#4682B4';
				document.getElementById('sesdating_footer_links_color').color.fromString('#4682B4');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#ED54A4';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#ED54A4');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#ddd';
				document.getElementById('sesdating_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    } else if(value == 12) {
      //Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#2E363F';
				document.getElementById('sesdating_theme_color').color.fromString('#2E363F');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#F5F5F5';
				document.getElementById('sesdating_body_background_color').color.fromString('#F5F5F5');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#243238';
				document.getElementById('sesdating_font_color').color.fromString('#243238');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#707070';
				document.getElementById('sesdating_font_color_light').color.fromString('#707070');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#243238';
				document.getElementById('sesdating_heading_color').color.fromString('#243238');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#49AFCD';
				document.getElementById('sesdating_links_color').color.fromString('#49AFCD');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#243238';
				document.getElementById('sesdating_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#243238';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#243238');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#EBECEE';
				document.getElementById('sesdating_content_border_color').color.fromString('#EBECEE');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#243238';
				document.getElementById('sesdating_form_label_color').color.fromString('#243238');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#FFFFFF';
				document.getElementById('sesdating_input_background_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#6D6D6D';
				document.getElementById('sesdating_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#2E363F';
				document.getElementById('sesdating_button_background_color').color.fromString('#2E363F');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#49AFCD';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#49AFCD');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#FDFDFD';
				document.getElementById('sesdating_comment_background_color').color.fromString('#FDFDFD');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#49AFCD';
				document.getElementById('sesdating_header_background_color').color.fromString('#49AFCD');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#243238';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#49AFCD';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#49AFCD');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#49AFCD';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#49AFCD');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#243238';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#243238');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#ECEFF1';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#49AFCD';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#49AFCD');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#243238';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#243238');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#49AFCD';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#49AFCD');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#2E363F';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#2E363F');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#FFFFFF');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#2E363F';
				document.getElementById('sesdating_footer_background_color').color.fromString('#2E363F');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#CBCBCB';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#CBCBCB');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#CBCBCB';
				document.getElementById('sesdating_footer_links_color').color.fromString('#CBCBCB');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#49AFCD';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#49AFCD');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#4A5766';
				document.getElementById('sesdating_footer_border_color').color.fromString('#4A5766');
			}
			//Footer Styling
    }    
		 else if(value == 13) {
			//Theme Base Styling
			if($('sesdating_theme_color')) {
				$('sesdating_theme_color').value = '#9C27B0';
				document.getElementById('sesdating_theme_color').color.fromString('#9C27B0');
			}
			//Theme Base Styling
			
				//Body Styling
			if($('sesdating_body_background_color')) {
				$('sesdating_body_background_color').value = '#101419';
				document.getElementById('sesdating_body_background_color').color.fromString('#101419');
			}
			if($('sesdating_font_color')) {
				$('sesdating_font_color').value = '#CCCCCC';
				document.getElementById('sesdating_font_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_font_color_light')) {
				$('sesdating_font_color_light').value = '#fff';
				document.getElementById('sesdating_font_color_light').color.fromString('#fff');
			}
			
			if($('sesdating_heading_color')) {
				$('sesdating_heading_color').value = '#b1b1b1';
				document.getElementById('sesdating_heading_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_links_color')) {
				$('sesdating_links_color').value = '#fff';
				document.getElementById('sesdating_links_color').color.fromString('#fff');
			}
			if($('sesdating_links_hover_color')) {
				$('sesdating_links_hover_color').value = '#9C27B0';
				document.getElementById('sesdating_links_hover_color').color.fromString('#9C27B0');
			}
			if($('sesdating_content_header_background_color')) {
				$('sesdating_content_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_header_font_color')) {
				$('sesdating_content_header_font_color').value = '#b1b1b1';
				document.getElementById('sesdating_content_header_font_color').color.fromString('#b1b1b1');
			}
			if($('sesdating_content_background_color')) {
				$('sesdating_content_background_color').value = '#1D2632';
				document.getElementById('sesdating_content_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_content_border_color')) {
				$('sesdating_content_border_color').value = '#334354';
				document.getElementById('sesdating_content_border_color').color.fromString('#334354');
			}
			if($('sesdating_form_label_color')) {
				$('sesdating_form_label_color').value = '#CCCCCC';
				document.getElementById('sesdating_form_label_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_background_color')) {
				$('sesdating_input_background_color').value = '#CCCCCC';
				document.getElementById('sesdating_input_background_color').color.fromString('#CCCCCC');
			}
			if($('sesdating_input_font_color')) {
				$('sesdating_input_font_color').value = '#243238';
				document.getElementById('sesdating_input_font_color').color.fromString('#243238');
			}
			if($('sesdating_input_border_color')) {
				$('sesdating_input_border_color').value = '#CACACA';
				document.getElementById('sesdating_input_border_color').color.fromString('#CACACA');
			}
			if($('sesdating_button_background_color')) {
				$('sesdating_button_background_color').value = '#9C27B0';
				document.getElementById('sesdating_button_background_color').color.fromString('#9C27B0');
			}
			if($('sesdating_button_background_color_hover')) {
				$('sesdating_button_background_color_hover').value = '#fff';
				document.getElementById('sesdating_button_background_color_hover').color.fromString('#fff');
			}
			if($('sesdating_button_font_color')) {
				$('sesdating_button_font_color').value = '#fff';
				document.getElementById('sesdating_button_font_color').color.fromString('#fff');
			}
			if($('sesdating_button_font_hover_color')) {
				$('sesdating_button_font_hover_color').value = '#243238';
				document.getElementById('sesdating_button_font_hover_color').color.fromString('#243238');
			}
			if($('sesdating_comment_background_color')) {
				$('sesdating_comment_background_color').value = '#1D2632';
				document.getElementById('sesdating_comment_background_color').color.fromString('#1D2632');
			}
			//Body Styling
			
			//Header Styling
			if($('sesdating_header_background_color')) {
				$('sesdating_header_background_color').value = '#1D2632';
				document.getElementById('sesdating_header_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_menu_logo_font_color')) {
				$('sesdating_menu_logo_font_color').value = '#fff';
				document.getElementById('sesdating_menu_logo_font_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_background_color')) {
				$('sesdating_mainmenu_background_color').value = '#1D2632';
				document.getElementById('sesdating_mainmenu_background_color').color.fromString('#1D2632');
			}
			if($('sesdating_mainmenu_links_color')) {
				$('sesdating_mainmenu_links_color').value = '#fff';
				document.getElementById('sesdating_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesdating_mainmenu_links_hover_color')) {
				$('sesdating_mainmenu_links_hover_color').value = '#9C27B0';
				document.getElementById('sesdating_mainmenu_links_hover_color').color.fromString('#9C27B0');
			}
			if($('sesdating_minimenu_links_color')) {
				$('sesdating_minimenu_links_color').value = '#9C27B0';
				document.getElementById('sesdating_minimenu_links_color').color.fromString('#9C27B0');
			}
			if($('sesdating_minimenu_links_hover_color')) {
				$('sesdating_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesdating_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_color')) {
				$('sesdating_minimenu_icon_background_color').value = '#fff';
				document.getElementById('sesdating_minimenu_icon_background_color').color.fromString('#fff');
			}
			if($('sesdating_minimenu_icon_background_active_color')) {
				$('sesdating_minimenu_icon_background_active_color').value = '#FFF';
				document.getElementById('sesdating_minimenu_icon_background_active_color').color.fromString('#FFF');
			}
			if($('sesdating_minimenu_icon_color')) {
				$('sesdating_minimenu_icon_color').value = '#9C27B0';
				document.getElementById('sesdating_minimenu_icon_color').color.fromString('#9C27B0');
			}
			if($('sesdating_minimenu_icon_active_color')) {
				$('sesdating_minimenu_icon_active_color').value = '#9C27B0';
				document.getElementById('sesdating_minimenu_icon_active_color').color.fromString('#9C27B0');
			}
			if($('sesdating_header_searchbox_background_color')) {
				$('sesdating_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesdating_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesdating_header_searchbox_text_color')) {
				$('sesdating_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesdating_header_searchbox_text_color').color.fromString('#fff');
			}
			//Top Panel Color
			if($('sesdating_toppanel_userinfo_background_color')) {
				$('sesdating_toppanel_userinfo_background_color').value = '#9C27B0';
				document.getElementById('sesdating_toppanel_userinfo_background_color').color.fromString('#9C27B0');
			}
			if($('sesdating_toppanel_userinfo_font_color')) {
				$('sesdating_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesdating_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesdating_login_popup_header_background_color')) {
				$('sesdating_login_popup_header_background_color').value = '#9C27B0';
				document.getElementById('sesdating_login_popup_header_background_color').color.fromString('#9C27B0');
			}
			if($('sesdating_login_popup_header_font_color')) {
				$('sesdating_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesdating_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesdating_footer_background_color')) {
				$('sesdating_footer_background_color').value = '#26323F';
				document.getElementById('sesdating_footer_background_color').color.fromString('#26323F');
			}
			if($('sesdating_footer_heading_color')) {
				$('sesdating_footer_heading_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_heading_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_color')) {
				$('sesdating_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesdating_footer_links_hover_color')) {
				$('sesdating_footer_links_hover_color').value = '#9C27B0';
				document.getElementById('sesdating_footer_links_hover_color').color.fromString('#9C27B0');
			}
			if($('sesdating_footer_border_color')) {
				$('sesdating_footer_border_color').value = '#B3B3B3';
				document.getElementById('sesdating_footer_border_color').color.fromString('#B3B3B3');
			}
			//Footer Styling
    }
		 else if(value == 5) {
    
      //Theme Base Styling
      if($('sesdating_theme_color')) {
        $('sesdating_theme_color').value = '<?php echo $settings->getSetting('sesdating.theme.color') ?>';
       // document.getElementById('sesdating_theme_color').color.fromString('<?php //echo $settings->getSetting('sesdating.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesdating_body_background_color')) {
        $('sesdating_body_background_color').value = '<?php echo $settings->getSetting('sesdating.body.background.color') ?>';
       // document.getElementById('sesdating_body_background_color').color.fromString('<?php //echo $settings->getSetting('sesdating.body.background.color') ?>');
      }
      if($('sesdating_font_color')) {
        $('sesdating_font_color').value = '<?php echo $settings->getSetting('sesdating.fontcolor') ?>';
        //document.getElementById('sesdating_font_color').color.fromString('<?php //echo $settings->getSetting('sesdating.font.color') ?>');
      }
      if($('sesdating_font_color_light')) {
        $('sesdating_font_color_light').value = '<?php echo $settings->getSetting('sesdating.font.color.light') ?>';
        //document.getElementById('sesdating_font_color_light').color.fromString('<?php echo $settings->getSetting('sesdating.font.color.light') ?>');
      }
      if($('sesdating_heading_color')) {
        $('sesdating_heading_color').value = '<?php echo $settings->getSetting('sesdating.heading.color') ?>';
        //document.getElementById('sesdating_heading_color').color.fromString('<?php echo $settings->getSetting('sesdating.heading.color') ?>');
      }
      if($('sesdating_links_color')) {
        $('sesdating_links_color').value = '<?php echo $settings->getSetting('sesdating.links.color') ?>';
        //document.getElementById('sesdating_links_color').color.fromString('<?php echo $settings->getSetting('sesdating.links.color') ?>');
      }
      if($('sesdating_links_hover_color')) {
        $('sesdating_links_hover_color').value = '<?php echo $settings->getSetting('sesdating.links.hover.color') ?>';
       // document.getElementById('sesdating_links_hover_color').color.fromString('<?php echo $settings->getSetting('sesdating.links.color.hover') ?>');
      }
			if($('sesdating_content_header_background_color')) {
        $('sesdating_content_header_background_color').value = '<?php echo $settings->getSetting('sesdating.content.header.background.color') ?>';
       // document.getElementById('sesdating_content_header_background_color').color.fromString('<?php echo $settings->getSetting('sesdating.content.header.background.color') ?>');
      }
			if($('sesdating_content_header_font_color')) {
        $('sesdating_content_header_font_color').value = '<?php echo $settings->getSetting('sesdating.content.header.font.color') ?>';
       // document.getElementById('sesdating_content_header_font_color').color.fromString('<?php echo $settings->getSetting('sesdating.content.header.font.color') ?>');
      }
      if($('sesdating_content_background_color')) {
        $('sesdating_content_background_color').value = '<?php echo $settings->getSetting('sesdating.content.background.color') ?>';
      //  document.getElementById('sesdating_content_background_color').color.fromString('<?php echo $settings->getSetting('sesdating.content.background.color') ?>');
      }
      if($('sesdating_content_border_color')) {
        $('sesdating_content_border_color').value = '<?php echo $settings->getSetting('sesdating.content.border.color') ?>';
      //  document.getElementById('sesdating_content_border_color').color.fromString('<?php echo $settings->getSetting('sesdating.content.border.color') ?>');
      }
      if($('sesdating_form_label_color')) {
        $('sesdating_input_font_color').value = '<?php echo $settings->getSetting('sesdating.form.label.color') ?>';
       // document.getElementById('sesdating_form_label_color').color.fromString('<?php echo $settings->getSetting('sesdating.form.label.color') ?>');
      }
      if($('sesdating_input_background_color')) {
        $('sesdating_input_background_color').value = '<?php echo $settings->getSetting('sesdating.input.background.color') ?>';
      //  document.getElementById('sesdating_input_background_color').color.fromString('<?php echo $settings->getSetting('sesdating.input.background.color') ?>');
      }
      if($('sesdating_input_font_color')) {
        $('sesdating_input_font_color').value = '<?php echo $settings->getSetting('sesdating.input.font.color') ?>';
       // document.getElementById('sesdating_input_font_color').color.fromString('<?php echo $settings->getSetting('sesdating.input.font.color') ?>');
      }
      if($('sesdating_input_border_color')) {
        $('sesdating_input_border_color').value = '<?php echo $settings->getSetting('sesdating.input.border.color') ?>';
       // document.getElementById('sesdating_input_border_color').color.fromString('<?php echo $settings->getSetting('sesdating.input.border.color') ?>');
      }
      if($('sesdating_button_background_color')) {
        $('sesdating_button_background_color').value = '<?php echo $settings->getSetting('sesdating.button.backgroundcolor') ?>';
        //document.getElementById('sesdating_button_background_color').color.fromString('<?php echo $settings->getSetting('sesdating.button.backgroundcolor') ?>');
      }
      if($('sesdating_button_background_color_hover')) {
        $('sesdating_button_background_color_hover').value = '<?php echo $settings->getSetting('sesdating.button.background.color.hover') ?>';
      }
      if($('sesdating_button_font_color')) {
        $('sesdating_button_font_color').value = '<?php echo $settings->getSetting('sesdating.button.font.color') ?>';
      }
      if($('sesdating_button_font_hover_color')) {
        $('sesdating_button_font_hover_color').value = '<?php echo $settings->getSetting('sesdating.button.font.hover.color') ?>';
      }
      if($('sesdating_comment_background_color')) {
        $('sesdating_comment_background_color').value = '<?php echo $settings->getSetting('sesdating.comment.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sesdating_header_background_color')) {
        $('sesdating_header_background_color').value = '<?php echo $settings->getSetting('sesdating.header.background.color') ?>';
      }
			if($('sesdating_mainmenu_background_color')) {
        $('sesdating_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesdating.mainmenu.background.color') ?>';
      }
      if($('sesdating_mainmenu_links_color')) {
        $('sesdating_mainmenu_links_color').value = '<?php echo $settings->getSetting('sesdating.mainmenu.links.color') ?>';
      }
      if($('sesdating_mainmenu_links_hover_color')) {
        $('sesdating_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sesdating.mainmenu.links.hover.color') ?>';
      }
      if($('sesdating_minimenu_links_color')) {
        $('sesdating_minimenu_links_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.links.color') ?>';
      }
      if($('sesdating_minimenu_links_hover_color')) {
        $('sesdating_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.links.hover.color') ?>';
      }
      if($('sesdating_minimenu_icon_background_color')) {
        $('sesdating_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.icon.background.color') ?>';
      }
      if($('sesdating_minimenu_icon_background_active_color')) {
        $('sesdating_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.icon.background.active.color') ?>';
      }
      if($('sesdating_minimenu_icon_color')) {
        $('sesdating_minimenu_icon_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.icon.color') ?>';
      }
      if($('sesdating_minimenu_icon_active_color')) {
        $('sesdating_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sesdating.minimenu.icon.active.color') ?>';
      }
      if($('sesdating_header_searchbox_background_color')) {
        $('sesdating_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesdating.header.searchbox.background.color') ?>';
      }
      if($('sesdating_header_searchbox_text_color')) {
        $('sesdating_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesdating.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('sesdating_toppanel_userinfo_background_color')) {
        $('sesdating_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('sesdating.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('sesdating_toppanel_userinfo_font_color')) {
        $('sesdating_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('sesdating.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
			//Login Popup Styling
      if($('sesdating_login_popup_header_font_color')) {
        $('sesdating_login_popup_header_font_color').value = '<?php echo $settings->getSetting('sesdating.login.popup.header.font.color'); ?>';
      }
      if($('sesdating_login_popup_header_background_color')) {
        $('sesdating_login_popup_header_background_color').value = '<?php echo $settings->getSetting('sesdating.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

      //Footer Styling
      if($('sesdating_footer_background_color')) {
        $('sesdating_footer_background_color').value = '<?php echo $settings->getSetting('sesdating.footer.background.color') ?>';
      }
      if($('sesdating_footer_heading_color')) {
        $('sesdating_footer_heading_color').value = '<?php echo $settings->getSetting('sesdating.footer.heading.color') ?>';
      }
      if($('sesdating_footer_links_color')) {
        $('sesdating_footer_links_color').value = '<?php echo $settings->getSetting('sesdating.footer.links.color') ?>';
      }
      if($('sesdating_footer_links_hover_color')) {
        $('sesdating_footer_links_hover_color').value = '<?php echo $settings->getSetting('sesdating.footer.links.hover.color') ?>';
      }
      if($('sesdating_footer_border_color')) {
        $('sesdating_footer_border_color').value = '<?php echo $settings->getSetting('sesdating.footer.border.color') ?>';
      }
      //Footer Styling
    }
	}
</script>
