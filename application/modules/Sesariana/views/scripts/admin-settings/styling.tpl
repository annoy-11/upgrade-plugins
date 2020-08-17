<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
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
<?php include APPLICATION_PATH .  '/application/modules/Sesariana/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sesariana_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesariana()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 13) {
      var URL = en4.core.staticBaseUrl+'sesariana/admin-settings/getcustomthemecolors/';
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
          history.pushState(null, null, 'admin/sesariana/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesariana/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesariana/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sesariana/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesariana/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesariana/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
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
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#005c99';
				document.getElementById('sesariana_theme_color').color.fromString('#005c99');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#005c99';
				document.getElementById('sesariana_links_hover_color').color.fromString('#005c99');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#005c99';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#005c99');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#005c99';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#005c99');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#005c99';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#005c99');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#005c99';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#005c99');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#005c99';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#005c99');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#005c99';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#005c99');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#005c99';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#005c99 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#005c99';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#005c99');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#FF5722';
				document.getElementById('sesariana_theme_color').color.fromString('#FF5722');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#FF5722';
				document.getElementById('sesariana_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#FF5722';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#FF5722');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#FF5722';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#FF5722');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#FF5722';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#FF5722';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#FF5722';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#FF5722');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#FF5722';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#FF5722');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#FF5722';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#FF5722 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#FF5722';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#FF5722');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
		} 
		else if(value == 3) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#d03e82';
				document.getElementById('sesariana_theme_color').color.fromString('#d03e82');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#d03e82';
				document.getElementById('sesariana_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#d03e82';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#d03e82');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#d03e82';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#d03e82');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#d03e82';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#d03e82';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#d03e82';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#d03e82');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#d03e82';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#d03e82');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#d03e82';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#d03e82 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#d03e82';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#d03e82');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling

		}
		else if(value == 4) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#354c17';
				document.getElementById('sesariana_theme_color').color.fromString('#354c17');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#354c17';
				document.getElementById('sesariana_links_hover_color').color.fromString('#354c17');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#354c17';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#354c17');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#354c17';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#354c17');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#354c17';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#354c17');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#354c17';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#354c17');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#354c17';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#354c17');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#354c17';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#354c17');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#354c17';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#354c17 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#354c17';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#354c17');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
 		else if(value == 6) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#2c6c73';
				document.getElementById('sesariana_theme_color').color.fromString('#2c6c73');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#2c6c73';
				document.getElementById('sesariana_links_hover_color').color.fromString('#2c6c73');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#2c6c73';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#2c6c73');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#2c6c73';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#2c6c73');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#2c6c73';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#2c6c73');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#2c6c73';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#2c6c73');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#2c6c73';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#2c6c73');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#2c6c73';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#2c6c73');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#2c6c73';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#2c6c73 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#2c6c73';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#2c6c73');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
    else if(value == 7) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#bf3f34';
				document.getElementById('sesariana_theme_color').color.fromString('#bf3f34');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#bf3f34';
				document.getElementById('sesariana_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#bf3f34';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#bf3f34');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#bf3f34';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#bf3f34');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#bf3f34';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#bf3f34';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#bf3f34';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#bf3f34');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#bf3f34';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#bf3f34');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#bf3f34';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#bf3f34 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#bf3f34';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#bf3f34');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
    else if(value == 8) {
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#b09800';
				document.getElementById('sesariana_theme_color').color.fromString('#b09800');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#b09800';
				document.getElementById('sesariana_links_hover_color').color.fromString('#b09800');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#b09800';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#b09800');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#b09800';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#b09800');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#b09800';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#b09800');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#b09800';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#b09800');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#b09800';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#b09800');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#b09800';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#b09800');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#b09800';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#b09800 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#b09800';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#b09800');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    }
    else if(value == 9) {
		 //Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#83431b';
				document.getElementById('sesariana_theme_color').color.fromString('#83431b');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#83431b';
				document.getElementById('sesariana_links_hover_color').color.fromString('#83431b');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#ebecee';
				document.getElementById('sesariana_content_border_color').color.fromString('#ebecee');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#ffffff';
				document.getElementById('sesariana_input_background_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#243238';
				document.getElementById('sesariana_button_background_color').color.fromString('#243238');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#83431b';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#83431b');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesariana_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#83431b';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#83431b');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#fff';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#fff');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#243238';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#000';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#000');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#243238';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#83431b';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#83431b');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#83431b';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#83431b');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#243238';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#243238');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#8DA1AB';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#8DA1AB');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#83431b';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#83431b');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#83431b';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#83431b ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#fff';
				document.getElementById('sesariana_footer_background_color').color.fromString('#fff');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#243238';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#243238';
				document.getElementById('sesariana_footer_links_color').color.fromString('#243238');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#83431b';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#83431b');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
		}
    else if(value == 10) {
				
			//Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#FF1D23';
				document.getElementById('sesariana_theme_color').color.fromString('#FF1D23');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#111418';
				document.getElementById('sesariana_body_background_color').color.fromString('#111418');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#f1f1f1';
				document.getElementById('sesariana_font_color').color.fromString('#f1f1f1');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#ddd';
				document.getElementById('sesariana_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#FFFFFF';
				document.getElementById('sesariana_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#ff1d23';
				document.getElementById('sesariana_links_hover_color').color.fromString('#ff1d23');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#222428';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#222428');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#222428';
				document.getElementById('sesariana_content_background_color').color.fromString('#222428');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#36383D';
				document.getElementById('sesariana_content_border_color').color.fromString('#36383D');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#ffffff';
				document.getElementById('sesariana_form_label_color').color.fromString('#ffffff');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#222428';
				document.getElementById('sesariana_input_background_color').color.fromString('#222428');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#fff';
				document.getElementById('sesariana_input_font_color').color.fromString('#fff');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#36383D';
				document.getElementById('sesariana_input_border_color').color.fromString('#36383D');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#ff1d23';
				document.getElementById('sesariana_button_background_color').color.fromString('#ff1d23');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#FF5252';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#FF5252');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#ffffff';
				document.getElementById('sesariana_button_font_color').color.fromString('#ffffff');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#fff';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#1E1F23';
				document.getElementById('sesariana_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#222428';
				document.getElementById('sesariana_header_background_color').color.fromString('#222428');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#ff1d23';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#ff1d23');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#222428';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#222428');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#ff1d23';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#ff1d23');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#fff';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#ff1d23';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#ff1d23');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#ff1d23';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#ff1d23');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#fff';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#fff');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#FF1D23';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#FF1D23');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#FF1D23';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#FF1D23 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#fff';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#fff ');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#222222';
				document.getElementById('sesariana_footer_background_color').color.fromString('#222222');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesariana_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#ff1d23';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#ff1d23');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ff1d23';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ff1d23');
			}
			//Footer Styling
				
    } else if(value == 11) {
    
      //Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#ED54A4';
				document.getElementById('sesariana_theme_color').color.fromString('#ED54A4');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#F5F5F5';
				document.getElementById('sesariana_body_background_color').color.fromString('#F5F5F5');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#707070';
				document.getElementById('sesariana_font_color_light').color.fromString('#707070');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#243238';
				document.getElementById('sesariana_links_color').color.fromString('#243238');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#4682B4';
				document.getElementById('sesariana_links_hover_color').color.fromString('#4682B4');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#EBECEE';
				document.getElementById('sesariana_content_border_color').color.fromString('#EBECEE');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_input_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#4682B4';
				document.getElementById('sesariana_button_background_color').color.fromString('#4682B4');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#E8288D';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#E8288D');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#FDFDFD';
				document.getElementById('sesariana_comment_background_color').color.fromString('#FDFDFD');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#ED54A4';
				document.getElementById('sesariana_header_background_color').color.fromString('#ED54A4');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#36383D';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#36383D');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#4682B4';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#4682B4');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#F1F1F1';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#F1F1F1');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#F07AB1';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#F07AB1');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#ED54A4';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#ED54A4');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#C7C7C7';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#C7C7C7');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#FFFFFF');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#ED54A4';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#ED54A4');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#ED54A4';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#ED54A4 ');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#FFFFFF');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_footer_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#A4A4A4';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#A4A4A4');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#4682B4';
				document.getElementById('sesariana_footer_links_color').color.fromString('#4682B4');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#ED54A4';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#ED54A4');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#ddd';
				document.getElementById('sesariana_footer_border_color').color.fromString('#ddd');
			}
			//Footer Styling
    } else if(value == 12) {
      //Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#2E363F';
				document.getElementById('sesariana_theme_color').color.fromString('#2E363F');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#F5F5F5';
				document.getElementById('sesariana_body_background_color').color.fromString('#F5F5F5');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#243238';
				document.getElementById('sesariana_font_color').color.fromString('#243238');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#707070';
				document.getElementById('sesariana_font_color_light').color.fromString('#707070');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#243238';
				document.getElementById('sesariana_heading_color').color.fromString('#243238');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#49AFCD';
				document.getElementById('sesariana_links_color').color.fromString('#49AFCD');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#243238';
				document.getElementById('sesariana_links_hover_color').color.fromString('#243238');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#243238';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#243238');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#EBECEE';
				document.getElementById('sesariana_content_border_color').color.fromString('#EBECEE');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#243238';
				document.getElementById('sesariana_form_label_color').color.fromString('#243238');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_input_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#49AFCD';
				document.getElementById('sesariana_button_background_color').color.fromString('#49AFCD');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#2E363F';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#2E363F');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#FDFDFD';
				document.getElementById('sesariana_comment_background_color').color.fromString('#FDFDFD');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#2E363F';
				document.getElementById('sesariana_header_background_color').color.fromString('#2E363F');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#2E363F';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#2E363F');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#49AFCD';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#49AFCD');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#F1F1F1';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#F1F1F1');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#49AFCD';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#49AFCD');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#49AFCD';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#49AFCD');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#C7C7C7';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#C7C7C7');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#FFFFFF');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#49AFCD';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#49AFCD');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#2E363F';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#2E363F');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#FFFFFF');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#2E363F';
				document.getElementById('sesariana_footer_background_color').color.fromString('#2E363F');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#CBCBCB';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#CBCBCB');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#CBCBCB';
				document.getElementById('sesariana_footer_links_color').color.fromString('#CBCBCB');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#49AFCD';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#49AFCD');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#4A5766';
				document.getElementById('sesariana_footer_border_color').color.fromString('#4A5766');
			}
			//Footer Styling
    } else if(value == 13) {
      //Theme Base Styling
			if($('sesariana_theme_color')) {
				$('sesariana_theme_color').value = '#D93A33';
				document.getElementById('sesariana_theme_color').color.fromString('#D93A33');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesariana_body_background_color')) {
				$('sesariana_body_background_color').value = '#F8F8F8';
				document.getElementById('sesariana_body_background_color').color.fromString('#F8F8F8');
			}
			if($('sesariana_font_color')) {
				$('sesariana_font_color').value = '#292929';
				document.getElementById('sesariana_font_color').color.fromString('#292929');
			}
			if($('sesariana_font_color_light')) {
				$('sesariana_font_color_light').value = '#999999';
				document.getElementById('sesariana_font_color_light').color.fromString('#999999');
			}
			
			if($('sesariana_heading_color')) {
				$('sesariana_heading_color').value = '#D93A33';
				document.getElementById('sesariana_heading_color').color.fromString('#D93A33');
			}
			if($('sesariana_links_color')) {
				$('sesariana_links_color').value = '#292929';
				document.getElementById('sesariana_links_color').color.fromString('#292929');
			}
			if($('sesariana_links_hover_color')) {
				$('sesariana_links_hover_color').value = '#D93A33';
				document.getElementById('sesariana_links_hover_color').color.fromString('#D93A33');
			}
			if($('sesariana_content_header_background_color')) {
				$('sesariana_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_header_font_color')) {
				$('sesariana_content_header_font_color').value = '#D93A33';
				document.getElementById('sesariana_content_header_font_color').color.fromString('#D93A33');
			}
			if($('sesariana_content_background_color')) {
				$('sesariana_content_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_content_border_color')) {
				$('sesariana_content_border_color').value = '#EBECEE';
				document.getElementById('sesariana_content_border_color').color.fromString('#EBECEE');
			}
			if($('sesariana_form_label_color')) {
				$('sesariana_form_label_color').value = '#292929';
				document.getElementById('sesariana_form_label_color').color.fromString('#292929');
			}
			if($('sesariana_input_background_color')) {
				$('sesariana_input_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_input_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_input_font_color')) {
				$('sesariana_input_font_color').value = '#6D6D6D';
				document.getElementById('sesariana_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesariana_input_border_color')) {
				$('sesariana_input_border_color').value = '#CACACA';
				document.getElementById('sesariana_input_border_color').color.fromString('#CACACA');
			}
			if($('sesariana_button_background_color')) {
				$('sesariana_button_background_color').value = '#292929';
				document.getElementById('sesariana_button_background_color').color.fromString('#292929');
			}
			if($('sesariana_button_background_color_hover')) {
				$('sesariana_button_background_color_hover').value = '#D93A33';
				document.getElementById('sesariana_button_background_color_hover').color.fromString('#D93A33');
			}
			if($('sesariana_button_font_color')) {
				$('sesariana_button_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_button_font_hover_color')) {
				$('sesariana_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesariana_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_comment_background_color')) {
				$('sesariana_comment_background_color').value = '#FDFDFD';
				document.getElementById('sesariana_comment_background_color').color.fromString('#FDFDFD');
			}
			//Body Styling
			
			//Header Styling
			if($('sesariana_header_background_color')) {
				$('sesariana_header_background_color').value = '#D93A33';
				document.getElementById('sesariana_header_background_color').color.fromString('#D93A33');
			}
			if($('sesariana_menu_logo_font_color')) {
				$('sesariana_menu_logo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_menu_logo_font_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_background_color')) {
				$('sesariana_mainmenu_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_mainmenu_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_mainmenu_links_color')) {
				$('sesariana_mainmenu_links_color').value = '#292929';
				document.getElementById('sesariana_mainmenu_links_color').color.fromString('#292929');
			}
			if($('sesariana_mainmenu_links_hover_color')) {
				$('sesariana_mainmenu_links_hover_color').value = '#D93A33';
				document.getElementById('sesariana_mainmenu_links_hover_color').color.fromString('#D93A33');
			}
			if($('sesariana_minimenu_links_color')) {
				$('sesariana_minimenu_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_links_hover_color')) {
				$('sesariana_minimenu_links_hover_color').value = '#F1F1F1';
				document.getElementById('sesariana_minimenu_links_hover_color').color.fromString('#F1F1F1');
			}
			if($('sesariana_minimenu_icon_background_color')) {
				$('sesariana_minimenu_icon_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_minimenu_icon_background_active_color')) {
				$('sesariana_minimenu_icon_background_active_color').value = '#292929';
				document.getElementById('sesariana_minimenu_icon_background_active_color').color.fromString('#292929');
			}
			if($('sesariana_minimenu_icon_color')) {
				$('sesariana_minimenu_icon_color').value = '#292929';
				document.getElementById('sesariana_minimenu_icon_color').color.fromString('#292929');
			}
			if($('sesariana_minimenu_icon_active_color')) {
				$('sesariana_minimenu_icon_active_color').value = '#FFFFFF';
				document.getElementById('sesariana_minimenu_icon_active_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_header_searchbox_background_color')) {
				$('sesariana_header_searchbox_background_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_searchbox_background_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_header_searchbox_text_color')) {
				$('sesariana_header_searchbox_text_color').value = '#FFFFFF';
				document.getElementById('sesariana_header_searchbox_text_color').color.fromString('#FFFFFF');
			}
			
			//Top Panel Color
			if($('sesariana_toppanel_userinfo_background_color')) {
				$('sesariana_toppanel_userinfo_background_color').value = '#D93A33';
				document.getElementById('sesariana_toppanel_userinfo_background_color').color.fromString('#D93A33');
			}
			if($('sesariana_toppanel_userinfo_font_color')) {
				$('sesariana_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Login Popup Styling
			if($('sesariana_login_popup_header_background_color')) {
				$('sesariana_login_popup_header_background_color').value = '#D93A33';
				document.getElementById('sesariana_login_popup_header_background_color').color.fromString('#D93A33');
			}
			if($('sesariana_login_popup_header_font_color')) {
				$('sesariana_login_popup_header_font_color').value = '#FFFFFF';
				document.getElementById('sesariana_login_popup_header_font_color').color.fromString('#FFFFFF');
			}
			//Login Pop up Styling
			//Header Styling
			
			//Footer Styling
			if($('sesariana_footer_background_color')) {
				$('sesariana_footer_background_color').value = '#292929';
				document.getElementById('sesariana_footer_background_color').color.fromString('#292929');
			}
			if($('sesariana_footer_heading_color')) {
				$('sesariana_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesariana_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_footer_links_color')) {
				$('sesariana_footer_links_color').value = '#FFFFFF';
				document.getElementById('sesariana_footer_links_color').color.fromString('#FFFFFF');
			}
			if($('sesariana_footer_links_hover_color')) {
				$('sesariana_footer_links_hover_color').value = '#D93A33';
				document.getElementById('sesariana_footer_links_hover_color').color.fromString('#D93A33');
			}
			if($('sesariana_footer_border_color')) {
				$('sesariana_footer_border_color').value = '#FFFFFF';
				document.getElementById('sesariana_footer_border_color').color.fromString('#FFFFFF');
			}
			//Footer Styling
    } else if(value == 5) {
    
      //Theme Base Styling
      if($('sesariana_theme_color')) {
        $('sesariana_theme_color').value = '<?php echo $settings->getSetting('sesariana.theme.color') ?>';
       // document.getElementById('sesariana_theme_color').color.fromString('<?php //echo $settings->getSetting('sesariana.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesariana_body_background_color')) {
        $('sesariana_body_background_color').value = '<?php echo $settings->getSetting('sesariana.body.background.color') ?>';
       // document.getElementById('sesariana_body_background_color').color.fromString('<?php //echo $settings->getSetting('sesariana.body.background.color') ?>');
      }
      if($('sesariana_font_color')) {
        $('sesariana_font_color').value = '<?php echo $settings->getSetting('sesariana.fontcolor') ?>';
        //document.getElementById('sesariana_font_color').color.fromString('<?php //echo $settings->getSetting('sesariana.font.color') ?>');
      }
      if($('sesariana_font_color_light')) {
        $('sesariana_font_color_light').value = '<?php echo $settings->getSetting('sesariana.font.color.light') ?>';
        //document.getElementById('sesariana_font_color_light').color.fromString('<?php echo $settings->getSetting('sesariana.font.color.light') ?>');
      }
      if($('sesariana_heading_color')) {
        $('sesariana_heading_color').value = '<?php echo $settings->getSetting('sesariana.heading.color') ?>';
        //document.getElementById('sesariana_heading_color').color.fromString('<?php echo $settings->getSetting('sesariana.heading.color') ?>');
      }
      if($('sesariana_links_color')) {
        $('sesariana_links_color').value = '<?php echo $settings->getSetting('sesariana.links.color') ?>';
        //document.getElementById('sesariana_links_color').color.fromString('<?php echo $settings->getSetting('sesariana.links.color') ?>');
      }
      if($('sesariana_links_hover_color')) {
        $('sesariana_links_hover_color').value = '<?php echo $settings->getSetting('sesariana.links.hover.color') ?>';
       // document.getElementById('sesariana_links_hover_color').color.fromString('<?php echo $settings->getSetting('sesariana.links.color.hover') ?>');
      }
			if($('sesariana_content_header_background_color')) {
        $('sesariana_content_header_background_color').value = '<?php echo $settings->getSetting('sesariana.content.header.background.color') ?>';
       // document.getElementById('sesariana_content_header_background_color').color.fromString('<?php echo $settings->getSetting('sesariana.content.header.background.color') ?>');
      }
			if($('sesariana_content_header_font_color')) {
        $('sesariana_content_header_font_color').value = '<?php echo $settings->getSetting('sesariana.content.header.font.color') ?>';
       // document.getElementById('sesariana_content_header_font_color').color.fromString('<?php echo $settings->getSetting('sesariana.content.header.font.color') ?>');
      }
      if($('sesariana_content_background_color')) {
        $('sesariana_content_background_color').value = '<?php echo $settings->getSetting('sesariana.content.background.color') ?>';
      //  document.getElementById('sesariana_content_background_color').color.fromString('<?php echo $settings->getSetting('sesariana.content.background.color') ?>');
      }
      if($('sesariana_content_border_color')) {
        $('sesariana_content_border_color').value = '<?php echo $settings->getSetting('sesariana.content.border.color') ?>';
      //  document.getElementById('sesariana_content_border_color').color.fromString('<?php echo $settings->getSetting('sesariana.content.border.color') ?>');
      }
      if($('sesariana_form_label_color')) {
        $('sesariana_input_font_color').value = '<?php echo $settings->getSetting('sesariana.form.label.color') ?>';
       // document.getElementById('sesariana_form_label_color').color.fromString('<?php echo $settings->getSetting('sesariana.form.label.color') ?>');
      }
      if($('sesariana_input_background_color')) {
        $('sesariana_input_background_color').value = '<?php echo $settings->getSetting('sesariana.input.background.color') ?>';
      //  document.getElementById('sesariana_input_background_color').color.fromString('<?php echo $settings->getSetting('sesariana.input.background.color') ?>');
      }
      if($('sesariana_input_font_color')) {
        $('sesariana_input_font_color').value = '<?php echo $settings->getSetting('sesariana.input.font.color') ?>';
       // document.getElementById('sesariana_input_font_color').color.fromString('<?php echo $settings->getSetting('sesariana.input.font.color') ?>');
      }
      if($('sesariana_input_border_color')) {
        $('sesariana_input_border_color').value = '<?php echo $settings->getSetting('sesariana.input.border.color') ?>';
       // document.getElementById('sesariana_input_border_color').color.fromString('<?php echo $settings->getSetting('sesariana.input.border.color') ?>');
      }
      if($('sesariana_button_background_color')) {
        $('sesariana_button_background_color').value = '<?php echo $settings->getSetting('sesariana.button.backgroundcolor') ?>';
        //document.getElementById('sesariana_button_background_color').color.fromString('<?php echo $settings->getSetting('sesariana.button.backgroundcolor') ?>');
      }
      if($('sesariana_button_background_color_hover')) {
        $('sesariana_button_background_color_hover').value = '<?php echo $settings->getSetting('sesariana.button.background.color.hover') ?>';
      }
      if($('sesariana_button_font_color')) {
        $('sesariana_button_font_color').value = '<?php echo $settings->getSetting('sesariana.button.font.color') ?>';
      }
      if($('sesariana_button_font_hover_color')) {
        $('sesariana_button_font_hover_color').value = '<?php echo $settings->getSetting('sesariana.button.font.hover.color') ?>';
      }
      if($('sesariana_comment_background_color')) {
        $('sesariana_comment_background_color').value = '<?php echo $settings->getSetting('sesariana.comment.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sesariana_header_background_color')) {
        $('sesariana_header_background_color').value = '<?php echo $settings->getSetting('sesariana.header.background.color') ?>';
      }
			if($('sesariana_mainmenu_background_color')) {
        $('sesariana_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesariana.mainmenu.background.color') ?>';
      }
      if($('sesariana_mainmenu_links_color')) {
        $('sesariana_mainmenu_links_color').value = '<?php echo $settings->getSetting('sesariana.mainmenu.links.color') ?>';
      }
      if($('sesariana_mainmenu_links_hover_color')) {
        $('sesariana_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sesariana.mainmenu.links.hover.color') ?>';
      }
      if($('sesariana_minimenu_links_color')) {
        $('sesariana_minimenu_links_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.links.color') ?>';
      }
      if($('sesariana_minimenu_links_hover_color')) {
        $('sesariana_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.links.hover.color') ?>';
      }
      if($('sesariana_minimenu_icon_background_color')) {
        $('sesariana_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.icon.background.color') ?>';
      }
      if($('sesariana_minimenu_icon_background_active_color')) {
        $('sesariana_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.icon.background.active.color') ?>';
      }
      if($('sesariana_minimenu_icon_color')) {
        $('sesariana_minimenu_icon_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.icon.color') ?>';
      }
      if($('sesariana_minimenu_icon_active_color')) {
        $('sesariana_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sesariana.minimenu.icon.active.color') ?>';
      }
      if($('sesariana_header_searchbox_background_color')) {
        $('sesariana_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesariana.header.searchbox.background.color') ?>';
      }
      if($('sesariana_header_searchbox_text_color')) {
        $('sesariana_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesariana.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('sesariana_toppanel_userinfo_background_color')) {
        $('sesariana_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('sesariana.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('sesariana_toppanel_userinfo_font_color')) {
        $('sesariana_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('sesariana.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
			//Login Popup Styling
      if($('sesariana_login_popup_header_font_color')) {
        $('sesariana_login_popup_header_font_color').value = '<?php echo $settings->getSetting('sesariana.login.popup.header.font.color'); ?>';
      }
      if($('sesariana_login_popup_header_background_color')) {
        $('sesariana_login_popup_header_background_color').value = '<?php echo $settings->getSetting('sesariana.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

      //Footer Styling
      if($('sesariana_footer_background_color')) {
        $('sesariana_footer_background_color').value = '<?php echo $settings->getSetting('sesariana.footer.background.color') ?>';
      }
      if($('sesariana_footer_heading_color')) {
        $('sesariana_footer_heading_color').value = '<?php echo $settings->getSetting('sesariana.footer.heading.color') ?>';
      }
      if($('sesariana_footer_links_color')) {
        $('sesariana_footer_links_color').value = '<?php echo $settings->getSetting('sesariana.footer.links.color') ?>';
      }
      if($('sesariana_footer_links_hover_color')) {
        $('sesariana_footer_links_hover_color').value = '<?php echo $settings->getSetting('sesariana.footer.links.hover.color') ?>';
      }
      if($('sesariana_footer_border_color')) {
        $('sesariana_footer_border_color').value = '<?php echo $settings->getSetting('sesariana.footer.border.color') ?>';
      }
      //Footer Styling
    }
	}
</script>