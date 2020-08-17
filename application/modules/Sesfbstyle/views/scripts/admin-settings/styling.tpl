<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
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
<?php include APPLICATION_PATH .  '/application/modules/Sesfbstyle/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sesfbstyle_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesfbstyle()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 3) {
      var URL = en4.core.staticBaseUrl+'sesfbstyle/admin-settings/getcustomthemecolors/';
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

	  if(custom == '' && (value == 1 || value == 2 || value == 3)) {
	    if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'none';
		  if($('header_settings-wrapper'))
				$('header_settings-wrapper').style.display = 'none';
	    if($('footer_settings-wrapper'))
				$('footer_settings-wrapper').style.display = 'none';
		  if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'none';
				if($('lp_settings-wrapper'))
				$('lp_settings-wrapper').style.display = 'none';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'none';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'none';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'none';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'none';
				if($('lp_settings_group'))
			  $('lp_settings_group').style.display = 'none';
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
				if($('lp_settings-wrapper'))
				$('lp_settings-wrapper').style.display = 'block';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'block';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'block';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'block';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'block';
				if($('lp_settings_group'))
			  $('lp_settings_group').style.display = 'block';
			  
      if($('custom_theme_color').value > 3) {
        if($('submit'))
          $('submit').style.display = 'inline-block';
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'block';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'block';

        <?php if(empty($this->customtheme_id)): ?>
          history.pushState(null, null, 'admin/sesfbstyle/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesfbstyle/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesfbstyle/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sesfbstyle/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesfbstyle/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesfbstyle/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
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
		
      if($('sesfbstyle_header_background_color')) {
        $('sesfbstyle_header_background_color').value = '#264c9a';
        //document.getElementById('sesfbstyle_header_background_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_header_border_color')) {
        $('sesfbstyle_header_border_color').value = '#133783';
        //document.getElementById('sesfbstyle_header_border_color').color.fromString('#133783');
      }
      if($('sesfbstyle_header_search_background_color')) {
        $('sesfbstyle_header_search_background_color').value = '#fff';
        //document.getElementById('sesfbstyle_header_search_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_search_border_color')) {
        $('sesfbstyle_header_search_border_color').value = '#fff';
        //document.getElementById('sesfbstyle_header_search_border_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_search_button_background_color')) {
        $('sesfbstyle_header_search_button_background_color').value = '#f6f7f9';
        //document.getElementById('sesfbstyle_header_search_button_background_color').color.fromString('#f6f7f9');
      }
      if($('sesfbstyle_header_search_button_font_color')) {
        $('sesfbstyle_header_search_button_font_color').value = '#7d7d7d';
        //document.getElementById('sesfbstyle_header_search_button_font_color').color.fromString('#7d7d7d');
      }
      if($('sesfbstyle_header_font_color')) {
        $('sesfbstyle_header_font_color').value = '#fff';
       // document.getElementById('sesfbstyle_header_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_search_background_color')) {
        $('sesfbstyle_mainmenu_search_background_color').value = '#131923';
       // document.getElementById('sesfbstyle_mainmenu_search_background_color').color.fromString('#131923');
      }
      if($('sesfbstyle_mainmenu_background_color')) {
        $('sesfbstyle_mainmenu_background_color').value = '#2d3f61';
       // document.getElementById('sesfbstyle_mainmenu_background_color').color.fromString('#2d3f61');
      }
      if($('sesfbstyle_mainmenu_links_color')) {
        $('sesfbstyle_mainmenu_links_color').value = '#eef3fd';
        //document.getElementById('sesfbstyle_mainmenu_links_color').color.fromString('#eef3fd');
      }
      if($('sesfbstyle_mainmenu_links_hover_color')) {
        $('sesfbstyle_mainmenu_links_hover_color').value = '#fff';
        //document.getElementById('sesfbstyle_mainmenu_links_hover_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_footer_font_color')) {
        $('sesfbstyle_mainmenu_footer_font_color').value = '#bdbdbd';
       // document.getElementById('sesfbstyle_mainmenu_footer_font_color').color.fromString('#bdbdbd');
      }
      if($('sesfbstyle_minimenu_links_color')) {
        $('sesfbstyle_minimenu_links_color').value = '#fff';
       // document.getElementById('sesfbstyle_minimenu_links_color').color.fromString('#fff');
      }
      if($('sesfbstyle_minimenu_link_active_color')) {
        $('sesfbstyle_minimenu_link_active_color').value = '#fff';
       // document.getElementById('sesfbstyle_minimenu_link_active_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_icons_type')) {
        $('sesfbstyle_header_icons_type').value = 2;
        //document.getElementById('sesfbstyle_footer_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_background_color')) {
        $('sesfbstyle_footer_background_color').value = '#fff';
      //  document.getElementById('sesfbstyle_footer_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_font_color')) {
        $('sesfbstyle_footer_font_color').value = '#737373';
       // document.getElementById('sesfbstyle_footer_font_color').color.fromString('#737373');
      }
      if($('sesfbstyle_footer_links_color')) {
        $('sesfbstyle_footer_links_color').value = '#133783';
     //   document.getElementById('sesfbstyle_footer_links_color').color.fromString('#133783');
      }
      if($('sesfbstyle_footer_border_color')) {
        $('sesfbstyle_footer_border_color').value = '#d8dadc';
       // document.getElementById('sesfbstyle_footer_border_color').color.fromString('#d8dadc');
      }
      if($('sesfbstyle_theme_color')) {
        $('sesfbstyle_theme_color').value = '#264c9a';
        //document.getElementById('sesfbstyle_theme_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_body_background_color')) {
        $('sesfbstyle_body_background_color').value = '#d8dadc';
       // document.getElementById('sesfbstyle_body_background_color').color.fromString('#d8dadc');
      }
      if($('sesfbstyle_font_color')) {
        $('sesfbstyle_font_color').value = '#000';
       // document.getElementById('sesfbstyle_font_color').color.fromString('#000');
      }
      if($('sesfbstyle_font_color_light')) {
        $('sesfbstyle_font_color_light').value = '#808D97';
       // document.getElementById('sesfbstyle_font_color_light').color.fromString('#808D97');
      }
      if($('sesfbstyle_links_color')) {
        $('sesfbstyle_links_color').value = '#133783';
       // document.getElementById('sesfbstyle_links_color').color.fromString('#133783');
      }
      if($('sesfbstyle_links_hover_color')) {
        $('sesfbstyle_links_hover_color').value = '#133783';
        //document.getElementById('sesfbstyle_links_hover_color').color.fromString('#133783');
      }
      if($('sesfbstyle_headline_background_color')) {
        $('sesfbstyle_headline_background_color').value = '#f6f7f9';
        //document.getElementById('sesfbstyle_headline_background_color').color.fromString('#f6f7f9');
      }
      if($('sesfbstyle_headline_color')) {
        $('sesfbstyle_headline_color').value = '#000';
       // document.getElementById('sesfbstyle_headline_color').color.fromString('#000');
      }
      if($('sesfbstyle_border_color')) {
        $('sesfbstyle_border_color').value = '#e1e2e3';
       // document.getElementById('sesfbstyle_border_color').color.fromString('#e1e2e3');
      }
      if($('sesfbstyle_box_background_color')) {
        $('sesfbstyle_box_background_color').value = '#fff';
       // document.getElementById('sesfbstyle_box_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_form_label_color')) {
        $('sesfbstyle_form_label_color').value = '#455B6B';
       // document.getElementById('sesfbstyle_form_label_color').color.fromString('#455B6B');
      }
      if($('sesfbstyle_input_background_color')) {
        $('sesfbstyle_input_background_color').value = '#fff';
       // document.getElementById('sesfbstyle_input_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_input_font_color')) {
        $('sesfbstyle_input_font_color').value = '#5f727f';
       // document.getElementById('sesfbstyle_input_font_color').color.fromString('#5f727f');
      }
      if($('sesfbstyle_input_border_color')) {
        $('sesfbstyle_input_border_color').value = '#d7d8da';
       // document.getElementById('sesfbstyle_input_border_color').color.fromString('#d7d8da');
      }
      if($('sesfbstyle_button_background_color')) {
        $('sesfbstyle_button_background_color').value = '#264c9a';
        //document.getElementById('sesfbstyle_button_background_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_button_background_color_hover')) {
        $('sesfbstyle_button_background_color_hover').value = '#133783';
       // document.getElementById('sesfbstyle_button_background_color_hover').color.fromString('#133783');
      }
      if($('sesfbstyle_button_font_color')) {
        $('sesfbstyle_button_font_color').value = '#fff';
       // document.getElementById('sesfbstyle_button_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_button_border_color')) {
        $('sesfbstyle_button_border_color').value = '#133783';
       // document.getElementById('sesfbstyle_button_border_color').color.fromString('#133783');
      }
      if($('sesfbstyle_dashboard_list_background_color_hover')) {
        $('sesfbstyle_dashboard_list_background_color_hover').value = '#f4f6f7';
        //document.getElementById('sesfbstyle_dashboard_list_background_color_hover').color.fromString('#f4f6f7');
      }
      if($('sesfbstyle_dashboard_list_border_color')) {
        $('sesfbstyle_dashboard_list_border_color').value = '#dddfe2';
       // document.getElementById('sesfbstyle_dashboard_list_border_color').color.fromString('#dddfe2');
      }
      if($('sesfbstyle_dashboard_font_color')) {
        $('sesfbstyle_dashboard_font_color').value = '#040609';
       // document.getElementById('sesfbstyle_dashboard_font_color').color.fromString('#040609');
      }
      if($('sesfbstyle_dashboard_link_color')) {
        $('sesfbstyle_dashboard_link_color').value = '#040609';
      //  document.getElementById('sesfbstyle_dashboard_link_color').color.fromString('#040609');
      }
      if($('sesfbstyle_comments_background_color')) {
        $('sesfbstyle_comments_background_color').value = '#f2f3f5';
       // document.getElementById('sesfbstyle_comments_background_color').color.fromString('#f2f3f5');
      }
			/*landing page constent*/
			 if($('sesfbstyle_lp_header_background_color')) {
        $('sesfbstyle_lp_header_background_color').value = '#264c9a';
        //document.getElementById('sesfbstyle_lp_header_background_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_lp_header_border_color')) {
        $('sesfbstyle_lp_header_border_color').value = '#133783';
       // document.getElementById('sesfbstyle_lp_header_border_color').color.fromString('#133783');
      }
      if($('sesfbstyle_lp_header_input_background_color')) {
        $('sesfbstyle_lp_header_input_background_color').value = '#fff';
      //  document.getElementById('sesfbstyle_lp_header_input_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_lp_header_input_border_color')) {
        $('sesfbstyle_lp_header_input_border_color').value = '#fff';
       // document.getElementById('sesfbstyle_lp_header_input_border_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_lp_header_button_background_color')) {
        $('sesfbstyle_lp_header_button_background_color').value = '#264c9a';
       // document.getElementById('sesfbstyle_lp_header_button_background_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_lp_header_button_font_color')) {
        $('sesfbstyle_lp_header_button_font_color').value = '#fff';
       // document.getElementById('sesfbstyle_lp_header_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_header_button_hover_color')) {
        $('sesfbstyle_lp_header_button_hover_color').value = '#133783';
        //document.getElementById('sesfbstyle_lp_header_button_hover_color').color.fromString('#133783');
      }
      if($('sesfbstyle_lp_header_font_color')) {
        $('sesfbstyle_lp_header_font_color').value = '#fff';
      //  document.getElementById('sesfbstyle_lp_header_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_header_link_color')) {
        $('sesfbstyle_lp_header_link_color').value = '#9cb4d8';
       // document.getElementById('sesfbstyle_lp_header_link_color').color.fromString('#9cb4d8');
      }
			if($('sesfbstyle_lp_signup_button_color')) {
        $('sesfbstyle_lp_signup_button_color').value = '#67ae55';
       // document.getElementById('sesfbstyle_lp_signup_button_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_border_color')) {
        $('sesfbstyle_lp_signup_button_border_color').value = '#2c5115';
       // document.getElementById('sesfbstyle_lp_signup_button_border_color').color.fromString('#2c5115');
      }
			if($('sesfbstyle_lp_signup_button_font_color')) {
        $('sesfbstyle_lp_signup_button_font_color').value = '#fff';
       // document.getElementById('sesfbstyle_lp_signup_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_signup_button_hover_color')) {
        $('sesfbstyle_lp_signup_button_hover_color').value = '#67ae55';
       // document.getElementById('sesfbstyle_lp_signup_button_hover_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_hover_font_color')) {
        $('sesfbstyle_lp_signup_button_hover_font_color').value = '#fff';
      //  document.getElementById('sesfbstyle_lp_signup_button_hover_font_color').color.fromString('#fff');
      }
		} 
		else if(value == 2) {
					
      if($('sesfbstyle_header_background_color')) {
        $('sesfbstyle_header_background_color').value = '#fff';
        document.getElementById('sesfbstyle_header_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_border_color')) {
        $('sesfbstyle_header_border_color').value = '#f1eeee';
        document.getElementById('sesfbstyle_header_border_color').color.fromString('#f1eeee');
      }
      if($('sesfbstyle_header_search_background_color')) {
        $('sesfbstyle_header_search_background_color').value = '#fff';
        document.getElementById('sesfbstyle_header_search_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_search_border_color')) {
        $('sesfbstyle_header_search_border_color').value = '#e4e4e4';
        document.getElementById('sesfbstyle_header_search_border_color').color.fromString('#e4e4e4');
      }
      if($('sesfbstyle_header_search_button_background_color')) {
        $('sesfbstyle_header_search_button_background_color').value = '#2c8ef1';
        document.getElementById('sesfbstyle_header_search_button_background_color').color.fromString('#2c8ef1');
      }
      if($('sesfbstyle_header_search_button_font_color')) {
        $('sesfbstyle_header_search_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_header_search_button_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_font_color')) {
        $('sesfbstyle_header_font_color').value = '#000';
        document.getElementById('sesfbstyle_header_font_color').color.fromString('#000');
      }
      if($('sesfbstyle_mainmenu_search_background_color')) {
        $('sesfbstyle_mainmenu_search_background_color').value = '#131923';
        document.getElementById('sesfbstyle_mainmenu_search_background_color').color.fromString('#131923');
      }
      if($('sesfbstyle_mainmenu_background_color')) {
        $('sesfbstyle_mainmenu_background_color').value = '#2d3f61';
        document.getElementById('sesfbstyle_mainmenu_background_color').color.fromString('#2d3f61');
      }
      if($('sesfbstyle_mainmenu_links_color')) {
        $('sesfbstyle_mainmenu_links_color').value = '#eef3fd';
        document.getElementById('sesfbstyle_mainmenu_links_color').color.fromString('#eef3fd');
      }
      if($('sesfbstyle_mainmenu_links_hover_color')) {
        $('sesfbstyle_mainmenu_links_hover_color').value = '#fff';
        document.getElementById('sesfbstyle_mainmenu_links_hover_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_footer_font_color')) {
        $('sesfbstyle_mainmenu_footer_font_color').value = '#bdbdbd';
        document.getElementById('sesfbstyle_mainmenu_footer_font_color').color.fromString('#bdbdbd');
      }
      if($('sesfbstyle_minimenu_links_color')) {
        $('sesfbstyle_minimenu_links_color').value = '#666666';
        document.getElementById('sesfbstyle_minimenu_links_color').color.fromString('#666666');
      }
      if($('sesfbstyle_minimenu_link_active_color')) {
        $('sesfbstyle_minimenu_link_active_color').value = '#000';
        document.getElementById('sesfbstyle_minimenu_link_active_color').color.fromString('#000');
      }
      if($('sesfbstyle_header_icons_type')) {
        $('sesfbstyle_header_icons_type').value = 2;
        //document.getElementById('sesfbstyle_footer_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_background_color')) {
        $('sesfbstyle_footer_background_color').value = '#fff';
        document.getElementById('sesfbstyle_footer_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_font_color')) {
        $('sesfbstyle_footer_font_color').value = '#737373';
        document.getElementById('sesfbstyle_footer_font_color').color.fromString('#737373');
      }
      if($('sesfbstyle_footer_links_color')) {
        $('sesfbstyle_footer_links_color').value = '#133783';
        document.getElementById('sesfbstyle_footer_links_color').color.fromString('#133783');
      }
      if($('sesfbstyle_footer_border_color')) {
        $('sesfbstyle_footer_border_color').value = '#d8dadc';
        document.getElementById('sesfbstyle_footer_border_color').color.fromString('#d8dadc');
      }
      if($('sesfbstyle_theme_color')) {
        $('sesfbstyle_theme_color').value = '#2c8ef1';
        document.getElementById('sesfbstyle_theme_color').color.fromString('#2c8ef1');
      }
      if($('sesfbstyle_body_background_color')) {
        $('sesfbstyle_body_background_color').value = '#f7f7f7';
        document.getElementById('sesfbstyle_body_background_color').color.fromString('#f7f7f7');
      }
      if($('sesfbstyle_font_color')) {
        $('sesfbstyle_font_color').value = '#000';
        document.getElementById('sesfbstyle_font_color').color.fromString('#000');
      }
      if($('sesfbstyle_font_color_light')) {
        $('sesfbstyle_font_color_light').value = '#808D97';
        document.getElementById('sesfbstyle_font_color_light').color.fromString('#808D97');
      }
      if($('sesfbstyle_links_color')) {
        $('sesfbstyle_links_color').value = '#000';
        document.getElementById('sesfbstyle_links_color').color.fromString('#000');
      }
      if($('sesfbstyle_links_hover_color')) {
        $('sesfbstyle_links_hover_color').value = '#2c8ef1';
        document.getElementById('sesfbstyle_links_hover_color').color.fromString('#2c8ef1');
      }
      if($('sesfbstyle_headline_background_color')) {
        $('sesfbstyle_headline_background_color').value = '#f6f7f9';
        document.getElementById('sesfbstyle_headline_background_color').color.fromString('#f6f7f9');
      }
      if($('sesfbstyle_headline_color')) {
        $('sesfbstyle_headline_color').value = '#000';
        document.getElementById('sesfbstyle_headline_color').color.fromString('#000');
      }
      if($('sesfbstyle_border_color')) {
        $('sesfbstyle_border_color').value = '#d8dadc';
        document.getElementById('sesfbstyle_border_color').color.fromString('#d8dadc');
      }
      if($('sesfbstyle_box_background_color')) {
        $('sesfbstyle_box_background_color').value = '#fff';
        document.getElementById('sesfbstyle_box_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_form_label_color')) {
        $('sesfbstyle_form_label_color').value = '#455B6B';
        document.getElementById('sesfbstyle_form_label_color').color.fromString('#455B6B');
      }
      if($('sesfbstyle_input_background_color')) {
        $('sesfbstyle_input_background_color').value = '#fff';
        document.getElementById('sesfbstyle_input_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_input_font_color')) {
        $('sesfbstyle_input_font_color').value = '#5f727f';
        document.getElementById('sesfbstyle_input_font_color').color.fromString('#5f727f');
      }
      if($('sesfbstyle_input_border_color')) {
        $('sesfbstyle_input_border_color').value = '#d7d8da';
        document.getElementById('sesfbstyle_input_border_color').color.fromString('#d7d8da');
      }
      if($('sesfbstyle_button_background_color')) {
        $('sesfbstyle_button_background_color').value = '#2c8ef1';
        document.getElementById('sesfbstyle_button_background_color').color.fromString('#2c8ef1');
      }
      if($('sesfbstyle_button_background_color_hover')) {
        $('sesfbstyle_button_background_color_hover').value = '#4ea6ff';
        document.getElementById('sesfbstyle_button_background_color_hover').color.fromString('#4ea6ff');
      }
      if($('sesfbstyle_button_font_color')) {
        $('sesfbstyle_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_button_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_button_border_color')) {
        $('sesfbstyle_button_border_color').value = '#4ea6ff';
        document.getElementById('sesfbstyle_button_border_color').color.fromString('#4ea6ff');
      }
      if($('sesfbstyle_dashboard_list_background_color_hover')) {
        $('sesfbstyle_dashboard_list_background_color_hover').value = '#f1f1f1';
        document.getElementById('sesfbstyle_dashboard_list_background_color_hover').color.fromString('#f1f1f1');
      }
      if($('sesfbstyle_dashboard_list_border_color')) {
        $('sesfbstyle_dashboard_list_border_color').value = '#dddfe2';
        document.getElementById('sesfbstyle_dashboard_list_border_color').color.fromString('#dddfe2');
      }
      if($('sesfbstyle_dashboard_font_color')) {
        $('sesfbstyle_dashboard_font_color').value = '#4b4f56';
        document.getElementById('sesfbstyle_dashboard_font_color').color.fromString('#4b4f56');
      }
      if($('sesfbstyle_dashboard_link_color')) {
        $('sesfbstyle_dashboard_link_color').value = '#4b4f56';
        document.getElementById('sesfbstyle_dashboard_link_color').color.fromString('#4b4f56');
      }
      if($('sesfbstyle_comments_background_color')) {
        $('sesfbstyle_comments_background_color').value = '#f7f7f7';
        document.getElementById('sesfbstyle_comments_background_color').color.fromString('#f7f7f7');
      }
			/*landing page constent*/
			 if($('sesfbstyle_lp_header_background_color')) {
        $('sesfbstyle_lp_header_background_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_header_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_lp_header_border_color')) {
        $('sesfbstyle_lp_header_border_color').value = '#f1eeee';
        document.getElementById('sesfbstyle_lp_header_border_color').color.fromString('#f1eeee');
      }
      if($('sesfbstyle_lp_header_input_background_color')) {
        $('sesfbstyle_lp_header_input_background_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_header_input_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_lp_header_input_border_color')) {
        $('sesfbstyle_lp_header_input_border_color').value = '#e4e4e4';
        document.getElementById('sesfbstyle_lp_header_input_border_color').color.fromString('#264c9a');
      }
      if($('sesfbstyle_lp_header_button_background_color')) {
        $('sesfbstyle_lp_header_button_background_color').value = '#2c8ef1';
        document.getElementById('sesfbstyle_lp_header_button_background_color').color.fromString('#2c8ef1');
      }
      if($('sesfbstyle_lp_header_button_font_color')) {
        $('sesfbstyle_lp_header_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_header_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_header_button_hover_color')) {
        $('sesfbstyle_lp_header_button_hover_color').value = '#4ea6ff';
        document.getElementById('sesfbstyle_lp_header_button_hover_color').color.fromString('#4ea6ff');
      }
      if($('sesfbstyle_lp_header_font_color')) {
        $('sesfbstyle_lp_header_font_color').value = '#000';
        document.getElementById('sesfbstyle_lp_header_font_color').color.fromString('#000');
      }
			if($('sesfbstyle_lp_header_link_color')) {
        $('sesfbstyle_lp_header_link_color').value = '#4ea6ff';
        document.getElementById('sesfbstyle_lp_header_link_color').color.fromString('#4ea6ff');
      }
			if($('sesfbstyle_lp_signup_button_color')) {
        $('sesfbstyle_lp_signup_button_color').value = '#67ae55';
        document.getElementById('sesfbstyle_lp_signup_button_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_border_color')) {
        $('sesfbstyle_lp_signup_button_border_color').value = '#2c5115';
        document.getElementById('sesfbstyle_lp_signup_button_border_color').color.fromString('#2c5115');
      }
			if($('sesfbstyle_lp_signup_button_font_color')) {
        $('sesfbstyle_lp_signup_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_signup_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_signup_button_hover_color')) {
        $('sesfbstyle_lp_signup_button_hover_color').value = '#67ae55';
        document.getElementById('sesfbstyle_lp_signup_button_hover_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_hover_font_color')) {
        $('sesfbstyle_lp_signup_button_hover_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_signup_button_hover_font_color').color.fromString('#fff');
      }
		} 
		else if(value == 3) {
		
      if($('sesfbstyle_header_background_color')) {
        $('sesfbstyle_header_background_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_header_background_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_header_border_color')) {
        $('sesfbstyle_header_border_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_header_border_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_header_search_background_color')) {
        $('sesfbstyle_header_search_background_color').value = '#292929';
        document.getElementById('sesfbstyle_header_search_background_color').color.fromString('#292929');
      }
      if($('sesfbstyle_header_search_border_color')) {
        $('sesfbstyle_header_search_border_color').value = '#292929';
        document.getElementById('sesfbstyle_header_search_border_color').color.fromString('#292929');
      }
      if($('sesfbstyle_header_search_button_background_color')) {
        $('sesfbstyle_header_search_button_background_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_header_search_button_background_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_header_search_button_font_color')) {
        $('sesfbstyle_header_search_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_header_search_button_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_header_font_color')) {
        $('sesfbstyle_header_font_color').value = '#fff';
        document.getElementById('sesfbstyle_header_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_search_background_color')) {
        $('sesfbstyle_mainmenu_search_background_color').value = '#141414';
        document.getElementById('sesfbstyle_mainmenu_search_background_color').color.fromString('#141414');
      }
      if($('sesfbstyle_mainmenu_background_color')) {
        $('sesfbstyle_mainmenu_background_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_mainmenu_background_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_mainmenu_links_color')) {
        $('sesfbstyle_mainmenu_links_color').value = '#fff';
        document.getElementById('sesfbstyle_mainmenu_links_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_links_hover_color')) {
        $('sesfbstyle_mainmenu_links_hover_color').value = '#fff';
        document.getElementById('sesfbstyle_mainmenu_links_hover_color').color.fromString('#fff');
      }
      if($('sesfbstyle_mainmenu_footer_font_color')) {
        $('sesfbstyle_mainmenu_footer_font_color').value = '#fff';
        document.getElementById('sesfbstyle_mainmenu_footer_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_minimenu_links_color')) {
        $('sesfbstyle_minimenu_links_color').value = '#fff';
        document.getElementById('sesfbstyle_minimenu_links_color').color.fromString('#fff');
      }
      if($('sesfbstyle_minimenu_link_active_color')) {
        $('sesfbstyle_minimenu_link_active_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_minimenu_link_active_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_header_icons_type')) {
        $('sesfbstyle_header_icons_type').value = 3;
        //document.getElementById('sesfbstyle_footer_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_background_color')) {
        $('sesfbstyle_footer_background_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_footer_background_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_footer_font_color')) {
        $('sesfbstyle_footer_font_color').value = '#fff';
        document.getElementById('sesfbstyle_footer_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_footer_links_color')) {
        $('sesfbstyle_footer_links_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_footer_links_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_footer_border_color')) {
        $('sesfbstyle_footer_border_color').value = '#191919';
        document.getElementById('sesfbstyle_footer_border_color').color.fromString('#191919');
      }
      if($('sesfbstyle_theme_color')) {
        $('sesfbstyle_theme_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_theme_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_body_background_color')) {
        $('sesfbstyle_body_background_color').value = '#191919';
        document.getElementById('sesfbstyle_body_background_color').color.fromString('#191919');
      }
      if($('sesfbstyle_font_color')) {
        $('sesfbstyle_font_color').value = '#fff';
        document.getElementById('sesfbstyle_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_font_color_light')) {
        $('sesfbstyle_font_color_light').value = '#ccc';
        document.getElementById('sesfbstyle_font_color_light').color.fromString('#ccc');
      }
      if($('sesfbstyle_links_color')) {
        $('sesfbstyle_links_color').value = '#fff';
        document.getElementById('sesfbstyle_links_color').color.fromString('#fff');
      }
      if($('sesfbstyle_links_hover_color')) {
        $('sesfbstyle_links_hover_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_links_hover_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_headline_background_color')) {
        $('sesfbstyle_headline_background_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_headline_background_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_headline_color')) {
        $('sesfbstyle_headline_color').value = '#fff';
        document.getElementById('sesfbstyle_headline_color').color.fromString('#fff');
      }
      if($('sesfbstyle_border_color')) {
        $('sesfbstyle_border_color').value = '#191919';
        document.getElementById('sesfbstyle_border_color').color.fromString('#191919');
      }
      if($('sesfbstyle_box_background_color')) {
        $('sesfbstyle_box_background_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_box_background_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_form_label_color')) {
        $('sesfbstyle_form_label_color').value = '#fff';
        document.getElementById('sesfbstyle_form_label_color').color.fromString('#fff');
      }
      if($('sesfbstyle_input_background_color')) {
        $('sesfbstyle_input_background_color').value = '#fff';
        document.getElementById('sesfbstyle_input_background_color').color.fromString('#fff');
      }
      if($('sesfbstyle_input_font_color')) {
        $('sesfbstyle_input_font_color').value = '#5f727f';
        document.getElementById('sesfbstyle_input_font_color').color.fromString('#5f727f');
      }
      if($('sesfbstyle_input_border_color')) {
        $('sesfbstyle_input_border_color').value = '#d7d8da';
        document.getElementById('sesfbstyle_input_border_color').color.fromString('#d7d8da');
      }
      if($('sesfbstyle_button_background_color')) {
        $('sesfbstyle_button_background_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_button_background_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_button_background_color_hover')) {
        $('sesfbstyle_button_background_color_hover').value = '#04b0d3';
        document.getElementById('sesfbstyle_button_background_color_hover').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_button_font_color')) {
        $('sesfbstyle_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_button_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_button_border_color')) {
        $('sesfbstyle_button_border_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_button_border_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_dashboard_list_background_color_hover')) {
        $('sesfbstyle_dashboard_list_background_color_hover').value = '#04b0d3';
        document.getElementById('sesfbstyle_dashboard_list_background_color_hover').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_dashboard_list_border_color')) {
        $('sesfbstyle_dashboard_list_border_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_dashboard_list_border_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_dashboard_font_color')) {
        $('sesfbstyle_dashboard_font_color').value = '#fff';
        document.getElementById('sesfbstyle_dashboard_font_color').color.fromString('#fff');
      }
      if($('sesfbstyle_dashboard_link_color')) {
        $('sesfbstyle_dashboard_link_color').value = '#fff';
        document.getElementById('sesfbstyle_dashboard_link_color').color.fromString('#fff');
      }
      if($('sesfbstyle_comments_background_color')) {
        $('sesfbstyle_comments_background_color').value = '#131212';
        document.getElementById('sesfbstyle_comments_background_color').color.fromString('#131212');
      }
			/*landing page constent*/
			 if($('sesfbstyle_lp_header_background_color')) {
        $('sesfbstyle_lp_header_background_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_lp_header_background_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_lp_header_border_color')) {
        $('sesfbstyle_lp_header_border_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_lp_header_border_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_lp_header_input_background_color')) {
        $('sesfbstyle_lp_header_input_background_color').value = '#292929';
        document.getElementById('sesfbstyle_lp_header_input_background_color').color.fromString('#292929');
      }
      if($('sesfbstyle_lp_header_input_border_color')) {
        $('sesfbstyle_lp_header_input_border_color').value = '#0e0e0e';
        document.getElementById('sesfbstyle_lp_header_input_border_color').color.fromString('#0e0e0e');
      }
      if($('sesfbstyle_lp_header_button_background_color')) {
        $('sesfbstyle_lp_header_button_background_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_lp_header_button_background_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_lp_header_button_font_color')) {
        $('sesfbstyle_lp_header_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_header_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_header_button_hover_color')) {
        $('sesfbstyle_lp_header_button_hover_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_lp_header_button_hover_color').color.fromString('#04b0d3');
      }
      if($('sesfbstyle_lp_header_font_color')) {
        $('sesfbstyle_lp_header_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_header_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_header_link_color')) {
        $('sesfbstyle_lp_header_link_color').value = '#04b0d3';
        document.getElementById('sesfbstyle_lp_header_link_color').color.fromString('#04b0d3');
      }
			if($('sesfbstyle_lp_signup_button_color')) {
        $('sesfbstyle_lp_signup_button_color').value = '#67ae55';
        document.getElementById('sesfbstyle_lp_signup_button_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_border_color')) {
        $('sesfbstyle_lp_signup_button_border_color').value = '#2c5115';
        document.getElementById('sesfbstyle_lp_signup_button_border_color').color.fromString('#2c5115');
      }
			if($('sesfbstyle_lp_signup_button_font_color')) {
        $('sesfbstyle_lp_signup_button_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_signup_button_font_color').color.fromString('#fff');
      }
			if($('sesfbstyle_lp_signup_button_hover_color')) {
        $('sesfbstyle_lp_signup_button_hover_color').value = '#67ae55';
        document.getElementById('sesfbstyle_lp_signup_button_hover_color').color.fromString('#67ae55');
      }
			if($('sesfbstyle_lp_signup_button_hover_font_color')) {
        $('sesfbstyle_lp_signup_button_hover_font_color').value = '#fff';
        document.getElementById('sesfbstyle_lp_signup_button_hover_font_color').color.fromString('#fff');
      }
		} else if(value == 5) {
    
      //Theme Base Styling
      if($('sesfbstyle_theme_color')) {
        $('sesfbstyle_theme_color').value = '<?php echo $settings->getSetting('sesfbstyle.theme.color') ?>';
       // document.getElementById('sesfbstyle_theme_color').color.fromString('<?php //echo $settings->getSetting('sesfbstyle.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesfbstyle_body_background_color')) {
        $('sesfbstyle_body_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.body.background.color') ?>';
       // document.getElementById('sesfbstyle_body_background_color').color.fromString('<?php //echo $settings->getSetting('sesfbstyle.body.background.color') ?>');
      }
      if($('sesfbstyle_font_color')) {
        $('sesfbstyle_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.fontcolor') ?>';
        //document.getElementById('sesfbstyle_font_color').color.fromString('<?php //echo $settings->getSetting('sesfbstyle.font.color') ?>');
      }
      if($('sesfbstyle_font_color_light')) {
        $('sesfbstyle_font_color_light').value = '<?php echo $settings->getSetting('sesfbstyle.font.color.light') ?>';
        //document.getElementById('sesfbstyle_font_color_light').color.fromString('<?php echo $settings->getSetting('sesfbstyle.font.color.light') ?>');
      }
      if($('sesfbstyle_heading_color')) {
        $('sesfbstyle_heading_color').value = '<?php echo $settings->getSetting('sesfbstyle.heading.color') ?>';
        //document.getElementById('sesfbstyle_heading_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.heading.color') ?>');
      }
      if($('sesfbstyle_links_color')) {
        $('sesfbstyle_links_color').value = '<?php echo $settings->getSetting('sesfbstyle.links.color') ?>';
        //document.getElementById('sesfbstyle_links_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.links.color') ?>');
      }
      if($('sesfbstyle_links_hover_color')) {
        $('sesfbstyle_links_hover_color').value = '<?php echo $settings->getSetting('sesfbstyle.links.hover.color') ?>';
       // document.getElementById('sesfbstyle_links_hover_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.links.color.hover') ?>');
      }
			if($('sesfbstyle_content_header_background_color')) {
        $('sesfbstyle_content_header_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.content.header.background.color') ?>';
       // document.getElementById('sesfbstyle_content_header_background_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.content.header.background.color') ?>');
      }
			if($('sesfbstyle_content_header_font_color')) {
        $('sesfbstyle_content_header_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.content.header.font.color') ?>';
       // document.getElementById('sesfbstyle_content_header_font_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.content.header.font.color') ?>');
      }
      if($('sesfbstyle_content_background_color')) {
        $('sesfbstyle_content_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.content.background.color') ?>';
      //  document.getElementById('sesfbstyle_content_background_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.content.background.color') ?>');
      }
      if($('sesfbstyle_content_border_color')) {
        $('sesfbstyle_content_border_color').value = '<?php echo $settings->getSetting('sesfbstyle.content.border.color') ?>';
      //  document.getElementById('sesfbstyle_content_border_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.content.border.color') ?>');
      }
      if($('sesfbstyle_form_label_color')) {
        $('sesfbstyle_input_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.form.label.color') ?>';
       // document.getElementById('sesfbstyle_form_label_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.form.label.color') ?>');
      }
      if($('sesfbstyle_input_background_color')) {
        $('sesfbstyle_input_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.input.background.color') ?>';
      //  document.getElementById('sesfbstyle_input_background_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.input.background.color') ?>');
      }
      if($('sesfbstyle_input_font_color')) {
        $('sesfbstyle_input_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.input.font.color') ?>';
       // document.getElementById('sesfbstyle_input_font_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.input.font.color') ?>');
      }
      if($('sesfbstyle_input_border_color')) {
        $('sesfbstyle_input_border_color').value = '<?php echo $settings->getSetting('sesfbstyle.input.border.color') ?>';
       // document.getElementById('sesfbstyle_input_border_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.input.border.color') ?>');
      }
      if($('sesfbstyle_button_background_color')) {
        $('sesfbstyle_button_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.button.backgroundcolor') ?>';
        //document.getElementById('sesfbstyle_button_background_color').color.fromString('<?php echo $settings->getSetting('sesfbstyle.button.backgroundcolor') ?>');
      }
      if($('sesfbstyle_button_background_color_hover')) {
        $('sesfbstyle_button_background_color_hover').value = '<?php echo $settings->getSetting('sesfbstyle.button.background.color.hover') ?>';
      }
      if($('sesfbstyle_button_font_color')) {
        $('sesfbstyle_button_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.button.font.color') ?>';
      }
      if($('sesfbstyle_button_font_hover_color')) {
        $('sesfbstyle_button_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.button.font.hover.color') ?>';
      }
      if($('sesfbstyle_comment_background_color')) {
        $('sesfbstyle_comment_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.comment.background.color') ?>';
      }
      if($('sesfbstyle_comments_background_color')) {
        $('sesfbstyle_comments_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.comments.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sesfbstyle_header_background_color')) {
        $('sesfbstyle_header_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.header.background.color') ?>';
      }
			if($('sesfbstyle_mainmenu_background_color')) {
        $('sesfbstyle_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.mainmenu.background.color') ?>';
      }
      if($('sesfbstyle_mainmenu_links_color')) {
        $('sesfbstyle_mainmenu_links_color').value = '<?php echo $settings->getSetting('sesfbstyle.mainmenu.links.color') ?>';
      }
      if($('sesfbstyle_mainmenu_links_hover_color')) {
        $('sesfbstyle_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sesfbstyle.mainmenu.links.hover.color') ?>';
      }
      if($('sesfbstyle_minimenu_links_color')) {
        $('sesfbstyle_minimenu_links_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.links.color') ?>';
      }
      if($('sesfbstyle_minimenu_links_hover_color')) {
        $('sesfbstyle_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.links.hover.color') ?>';
      }
      if($('sesfbstyle_minimenu_icon_background_color')) {
        $('sesfbstyle_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.icon.background.color') ?>';
      }
      if($('sesfbstyle_minimenu_icon_background_active_color')) {
        $('sesfbstyle_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.icon.background.active.color') ?>';
      }
      if($('sesfbstyle_minimenu_icon_color')) {
        $('sesfbstyle_minimenu_icon_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.icon.color') ?>';
      }
      if($('sesfbstyle_minimenu_icon_active_color')) {
        $('sesfbstyle_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sesfbstyle.minimenu.icon.active.color') ?>';
      }
      if($('sesfbstyle_header_searchbox_background_color')) {
        $('sesfbstyle_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.header.searchbox.background.color') ?>';
      }
      if($('sesfbstyle_header_searchbox_text_color')) {
        $('sesfbstyle_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesfbstyle.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('sesfbstyle_toppanel_userinfo_background_color')) {
        $('sesfbstyle_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('sesfbstyle_toppanel_userinfo_font_color')) {
        $('sesfbstyle_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
			//Login Popup Styling
      if($('sesfbstyle_login_popup_header_font_color')) {
        $('sesfbstyle_login_popup_header_font_color').value = '<?php echo $settings->getSetting('sesfbstyle.login.popup.header.font.color'); ?>';
      }
      if($('sesfbstyle_login_popup_header_background_color')) {
        $('sesfbstyle_login_popup_header_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

      //Footer Styling
      if($('sesfbstyle_footer_background_color')) {
        $('sesfbstyle_footer_background_color').value = '<?php echo $settings->getSetting('sesfbstyle.footer.background.color') ?>';
      }
      if($('sesfbstyle_footer_heading_color')) {
        $('sesfbstyle_footer_heading_color').value = '<?php echo $settings->getSetting('sesfbstyle.footer.heading.color') ?>';
      }
      if($('sesfbstyle_footer_links_color')) {
        $('sesfbstyle_footer_links_color').value = '<?php echo $settings->getSetting('sesfbstyle.footer.links.color') ?>';
      }
      if($('sesfbstyle_footer_links_hover_color')) {
        $('sesfbstyle_footer_links_hover_color').value = '<?php echo $settings->getSetting('sesfbstyle.footer.links.hover.color') ?>';
      }
      if($('sesfbstyle_footer_border_color')) {
        $('sesfbstyle_footer_border_color').value = '<?php echo $settings->getSetting('sesfbstyle.footer.border.color') ?>';
      }
      //Footer Styling
    }
	}
</script>