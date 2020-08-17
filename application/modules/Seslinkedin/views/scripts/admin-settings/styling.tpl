<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Seslinkedin/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form seslinkedin_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->seslinkedin()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 3) {
      var URL = en4.core.staticBaseUrl+'seslinkedin/admin-settings/getcustomthemecolors/';
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
          history.pushState(null, null, 'admin/seslinkedin/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'seslinkedin/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'seslinkedin/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/seslinkedin/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'seslinkedin/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'seslinkedin/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
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
		
      if($('seslinkedin_header_background_color')) {
        $('seslinkedin_header_background_color').value = '#283e4a';
        //document.getElementById('seslinkedin_header_background_color').color.fromString('#4267b2');
      }
      if($('seslinkedin_header_search_background_color')) {
        $('seslinkedin_header_search_background_color').value = '#e1e9ee';
        //document.getElementById('seslinkedin_header_search_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_header_search_button_font_color')) {
        $('seslinkedin_header_search_button_font_color').value = '#283e4a';
        //document.getElementById('seslinkedin_header_search_button_font_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_header_font_color')) {
        $('seslinkedin_header_font_color').value = '#c7d1d8';
       // document.getElementById('seslinkedin_header_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_mainmenu_search_background_color')) {
        $('seslinkedin_mainmenu_search_background_color').value = '#fff';
       // document.getElementById('seslinkedin_mainmenu_search_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_mainmenu_background_color')) {
        $('seslinkedin_mainmenu_background_color').value = '#f5f5f5';
       // document.getElementById('seslinkedin_mainmenu_background_color').color.fromString('#f5f5f5');
      }
      if($('seslinkedin_mainmenu_links_color')) {
        $('seslinkedin_mainmenu_links_color').value = '#000';
        //document.getElementById('seslinkedin_mainmenu_links_color').color.fromString('#000');
      }
      if($('seslinkedin_mainmenu_links_hover_color')) {
        $('seslinkedin_mainmenu_links_hover_color').value = '#0073b1';
        //document.getElementById('seslinkedin_mainmenu_links_hover_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_mainmenu_footer_font_color')) {
        $('seslinkedin_mainmenu_footer_font_color').value = '#000';
       // document.getElementById('seslinkedin_mainmenu_footer_font_color').color.fromString('#000');
      }
      if($('seslinkedin_minimenu_links_color')) {
        $('seslinkedin_minimenu_links_color').value = '#c7d1d8';
       // document.getElementById('seslinkedin_minimenu_links_color').color.fromString('#c7d1d8');
      }
      if($('seslinkedin_minimenu_link_active_color')) {
        $('seslinkedin_minimenu_link_active_color').value = '#fff';
       // document.getElementById('seslinkedin_minimenu_link_active_color').color.fromString('#fff');
      }
      if($('seslinkedin_minimenu_link_active_color')) {
        $('seslinkedin_minimenu_link_active_color').value = '#fff';
        //document.getElementById('seslinkedin_minimenu_link_active_color').color.fromString('#fff');
      }
      if($('seslinkedin_header_icons_type')) {
        $('seslinkedin_header_icons_type').value = 2;
        //document.getElementById('seslinkedin_footer_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_footer_background_color')) {
        $('seslinkedin_footer_background_color').value = '#f5f5f5';
      //  document.getElementById('seslinkedin_footer_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_footer_font_color')) {
        $('seslinkedin_footer_font_color').value = '#485d69';
       // document.getElementById('seslinkedin_footer_font_color').color.fromString('#485d69');
      }
      if($('seslinkedin_footer_links_color')) {
        $('seslinkedin_footer_links_color').value = '#485d69';
     //   document.getElementById('seslinkedin_footer_links_color').color.fromString('#485d69');
      }
      if($('seslinkedin_footer_border_color')) {
        $('seslinkedin_footer_border_color').value = '#e9ebee';
       // document.getElementById('seslinkedin_footer_border_color').color.fromString('#e9ebee');
      }
      if($('seslinkedin_theme_color')) {
        $('seslinkedin_theme_color').value = '#4267b2';
        //document.getElementById('seslinkedin_theme_color').color.fromString('#4267b2');
      }
      if($('seslinkedin_body_background_color')) {
        $('seslinkedin_body_background_color').value = '#f5f5f5';
       // document.getElementById('seslinkedin_body_background_color').color.fromString('#e9ebee');
      }
      if($('seslinkedin_font_color')) {
        $('seslinkedin_font_color').value = '#000';
       // document.getElementById('seslinkedin_font_color').color.fromString('#000');
      }
      if($('seslinkedin_font_color_light')) {
        $('seslinkedin_font_color_light').value = '#767676';
       // document.getElementById('seslinkedin_font_color_light').color.fromString('#767676');
      }
      if($('seslinkedin_links_color')) {
        $('seslinkedin_links_color').value = '#2d2d2d';
       // document.getElementById('seslinkedin_links_color').color.fromString('#2d2d2d');
      }
      if($('seslinkedin_links_hover_color')) {
        $('seslinkedin_links_hover_color').value = '#0073b1';
        //document.getElementById('seslinkedin_links_hover_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_headline_color')) {
        $('seslinkedin_headline_color').value = '#000';
       // document.getElementById('seslinkedin_headline_color').color.fromString('#000');
      }
      if($('seslinkedin_border_color')) {
        $('seslinkedin_border_color').value = '#e1e2e3';
       // document.getElementById('seslinkedin_border_color').color.fromString('#e1e2e3');
      }
      if($('seslinkedin_box_background_color')) {
        $('seslinkedin_box_background_color').value = '#fff';
       // document.getElementById('seslinkedin_box_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_form_label_color')) {
        $('seslinkedin_form_label_color').value = '#455B6B';
       // document.getElementById('seslinkedin_form_label_color').color.fromString('#455B6B');
      }
      if($('seslinkedin_input_background_color')) {
        $('seslinkedin_input_background_color').value = '#fff';
       // document.getElementById('seslinkedin_input_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_input_font_color')) {
        $('seslinkedin_input_font_color').value = '#5f727f';
       // document.getElementById('seslinkedin_input_font_color').color.fromString('#5f727f');
      }
      if($('seslinkedin_input_border_color')) {
        $('seslinkedin_input_border_color').value = '#d7d8da';
       // document.getElementById('seslinkedin_input_border_color').color.fromString('#d7d8da');
      }
      if($('seslinkedin_button_background_color')) {
        $('seslinkedin_button_background_color').value = '#0073b1';
        //document.getElementById('seslinkedin_button_background_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_button_background_color_hover')) {
        $('seslinkedin_button_background_color_hover').value = '#365899';
       // document.getElementById('seslinkedin_button_background_color_hover').color.fromString('#365899');
      }
      if($('seslinkedin_button_font_color')) {
        $('seslinkedin_button_font_color').value = '#fff';
       // document.getElementById('seslinkedin_button_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_button_border_color')) {
        $('seslinkedin_button_border_color').value = '#0073b1';
       // document.getElementById('seslinkedin_button_border_color').color.fromString('#0073b1');
      }
			/*landing page constent*/
			if($('seslinkedin_lp_header_link_color')) {
        $('seslinkedin_lp_header_link_color').value = '#666666';
       // document.getElementById('seslinkedin_lp_header_link_color').color.fromString('#666666');
      }
			if($('seslinkedin_lp_signup_button_color')) {
        $('seslinkedin_lp_signup_button_color').value = '#fff';
       // document.getElementById('seslinkedin_lp_signup_button_color').color.fromString('#fff');
      }
			if($('seslinkedin_lp_signup_button_border_color')) {
        $('seslinkedin_lp_signup_button_border_color').value = '#0073b1';
       // document.getElementById('seslinkedin_lp_signup_button_border_color').color.fromString('#0073b1');
      }
			if($('seslinkedin_lp_signup_button_font_color')) {
        $('seslinkedin_lp_signup_button_font_color').value = '#0073b1';
       // document.getElementById('seslinkedin_lp_signup_button_font_color').color.fromString('#0073b1');
      }
			if($('seslinkedin_lp_signup_button_hover_color')) {
        $('seslinkedin_lp_signup_button_hover_color').value = '#e5f5fc';
       // document.getElementById('seslinkedin_lp_signup_button_hover_color').color.fromString('#e5f5fc');
      }
			if($('seslinkedin_lp_signup_button_hover_font_color')) {
        $('seslinkedin_lp_signup_button_hover_font_color').value = '#0073b1';
      //  document.getElementById('seslinkedin_lp_signup_button_hover_font_color').color.fromString('#0073b1');
      }
		} 
		
		else if(value == 2) {
		
      if($('seslinkedin_header_background_color')) {
        $('seslinkedin_header_background_color').value = '#283e4a';
        document.getElementById('seslinkedin_header_background_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_header_search_background_color')) {
        $('seslinkedin_header_search_background_color').value = '#292929';
        document.getElementById('seslinkedin_header_search_background_color').color.fromString('#292929');
      }
      if($('seslinkedin_header_search_button_font_color')) {
        $('seslinkedin_header_search_button_font_color').value = '#fff';
        document.getElementById('seslinkedin_header_search_button_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_header_font_color')) {
        $('seslinkedin_header_font_color').value = '#fff';
        document.getElementById('seslinkedin_header_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_mainmenu_search_background_color')) {
        $('seslinkedin_mainmenu_search_background_color').value = '#141414';
        document.getElementById('seslinkedin_mainmenu_search_background_color').color.fromString('#141414');
      }
      if($('seslinkedin_mainmenu_background_color')) {
        $('seslinkedin_mainmenu_background_color').value = '#283e4a';
        document.getElementById('seslinkedin_mainmenu_background_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_mainmenu_links_color')) {
        $('seslinkedin_mainmenu_links_color').value = '#fff';
        document.getElementById('seslinkedin_mainmenu_links_color').color.fromString('#fff');
      }
      if($('seslinkedin_mainmenu_links_hover_color')) {
        $('seslinkedin_mainmenu_links_hover_color').value = '#fff';
        document.getElementById('seslinkedin_mainmenu_links_hover_color').color.fromString('#fff');
      }
      if($('seslinkedin_mainmenu_footer_font_color')) {
        $('seslinkedin_mainmenu_footer_font_color').value = '#fff';
        document.getElementById('seslinkedin_mainmenu_footer_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_minimenu_links_color')) {
        $('seslinkedin_minimenu_links_color').value = '#c7d1d8';
        document.getElementById('seslinkedin_minimenu_links_color').color.fromString('#c7d1d8');
      }
      if($('seslinkedin_minimenu_link_active_color')) {
        $('seslinkedin_minimenu_link_active_color').value = '#fff';
        document.getElementById('seslinkedin_minimenu_link_active_color').color.fromString('#fff');
      }
      if($('seslinkedin_header_icons_type')) {
        $('seslinkedin_header_icons_type').value = 3;
        //document.getElementById('seslinkedin_footer_background_color').color.fromString('#fff');
      }
      if($('seslinkedin_footer_background_color')) {
        $('seslinkedin_footer_background_color').value = '#283e4a';
        document.getElementById('seslinkedin_footer_background_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_footer_font_color')) {
        $('seslinkedin_footer_font_color').value = '#fff';
        document.getElementById('seslinkedin_footer_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_footer_links_color')) {
        $('seslinkedin_footer_links_color').value = '#d8d8d8';
        document.getElementById('seslinkedin_footer_links_color').color.fromString('#d8d8d8');
      }
      if($('seslinkedin_footer_border_color')) {
        $('seslinkedin_footer_border_color').value = '#191919';
        document.getElementById('seslinkedin_footer_border_color').color.fromString('#191919');
      }
      if($('seslinkedin_theme_color')) {
        $('seslinkedin_theme_color').value = '#0073b1';
        document.getElementById('seslinkedin_theme_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_body_background_color')) {
        $('seslinkedin_body_background_color').value = '#14232c';
        document.getElementById('seslinkedin_body_background_color').color.fromString('#14232c');
      }
      if($('seslinkedin_font_color')) {
        $('seslinkedin_font_color').value = '#fff';
        document.getElementById('seslinkedin_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_font_color_light')) {
        $('seslinkedin_font_color_light').value = '#ccc';
        document.getElementById('seslinkedin_font_color_light').color.fromString('#ccc');
      }
      if($('seslinkedin_links_color')) {
        $('seslinkedin_links_color').value = '#fff';
        document.getElementById('seslinkedin_links_color').color.fromString('#fff');
      }
      if($('seslinkedin_links_hover_color')) {
        $('seslinkedin_links_hover_color').value = '#0073b1';
        document.getElementById('seslinkedin_links_hover_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_headline_color')) {
        $('seslinkedin_headline_color').value = '#fff';
        document.getElementById('seslinkedin_headline_color').color.fromString('#fff');
      }
      if($('seslinkedin_border_color')) {
        $('seslinkedin_border_color').value = '#385869';
        document.getElementById('seslinkedin_border_color').color.fromString('#385869');
      }
      if($('seslinkedin_box_background_color')) {
        $('seslinkedin_box_background_color').value = '#283e4a';
        document.getElementById('seslinkedin_box_background_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_form_label_color')) {
        $('seslinkedin_form_label_color').value = '#fff';
        document.getElementById('seslinkedin_form_label_color').color.fromString('#fff');
      }
      if($('seslinkedin_input_background_color')) {
        $('seslinkedin_input_background_color').value = '#14232c';
        document.getElementById('seslinkedin_input_background_color').color.fromString('#14232c');
      }
      if($('seslinkedin_input_font_color')) {
        $('seslinkedin_input_font_color').value = '#5f727f';
        document.getElementById('seslinkedin_input_font_color').color.fromString('#5f727f');
      }
      if($('seslinkedin_input_border_color')) {
        $('seslinkedin_input_border_color').value = '#283e4a';
        document.getElementById('seslinkedin_input_border_color').color.fromString('#283e4a');
      }
      if($('seslinkedin_button_background_color')) {
        $('seslinkedin_button_background_color').value = '#0073b1';
        document.getElementById('seslinkedin_button_background_color').color.fromString('#0073b1');
      }
      if($('seslinkedin_button_background_color_hover')) {
        $('seslinkedin_button_background_color_hover').value = '#0073b1';
        document.getElementById('seslinkedin_button_background_color_hover').color.fromString('#0073b1');
      }
      if($('seslinkedin_button_font_color')) {
        $('seslinkedin_button_font_color').value = '#fff';
        document.getElementById('seslinkedin_button_font_color').color.fromString('#fff');
      }
      if($('seslinkedin_button_border_color')) {
        $('seslinkedin_button_border_color').value = '#0073b1';
        document.getElementById('seslinkedin_button_border_color').color.fromString('#0073b1');
      }
			
			/*landing page constent*/
			if($('seslinkedin_lp_header_link_color')) {
        $('seslinkedin_lp_header_link_color').value = '#fff';
        document.getElementById('seslinkedin_lp_header_link_color').color.fromString('#fff');
      }
			if($('seslinkedin_lp_signup_button_color')) {
        $('seslinkedin_lp_signup_button_color').value = '#283e4a';
        document.getElementById('seslinkedin_lp_signup_button_color').color.fromString('#283e4a');
      }
			if($('seslinkedin_lp_signup_button_border_color')) {
        $('seslinkedin_lp_signup_button_border_color').value = '#fff';
        document.getElementById('seslinkedin_lp_signup_button_border_color').color.fromString('#fff');
      }
			if($('seslinkedin_lp_signup_button_font_color')) {
        $('seslinkedin_lp_signup_button_font_color').value = '#fff';
        document.getElementById('seslinkedin_lp_signup_button_font_color').color.fromString('#fff');
      }
			if($('seslinkedin_lp_signup_button_hover_color')) {
        $('seslinkedin_lp_signup_button_hover_color').value = '#0073b1';
        document.getElementById('seslinkedin_lp_signup_button_hover_color').color.fromString('#0073b1');
      }
			if($('seslinkedin_lp_signup_button_hover_font_color')) {
        $('seslinkedin_lp_signup_button_hover_font_color').value = '#fff';
        document.getElementById('seslinkedin_lp_signup_button_hover_font_color').color.fromString('#fff');
      }
		} else if(value == 5) {
    
      //Theme Base Styling
      if($('seslinkedin_theme_color')) {
        $('seslinkedin_theme_color').value = '<?php echo $settings->getSetting('seslinkedin.theme.color') ?>';
       // document.getElementById('seslinkedin_theme_color').color.fromString('<?php //echo $settings->getSetting('seslinkedin.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('seslinkedin_body_background_color')) {
        $('seslinkedin_body_background_color').value = '<?php echo $settings->getSetting('seslinkedin.body.background.color') ?>';
       // document.getElementById('seslinkedin_body_background_color').color.fromString('<?php //echo $settings->getSetting('seslinkedin.body.background.color') ?>');
      }
      if($('seslinkedin_font_color')) {
        $('seslinkedin_font_color').value = '<?php echo $settings->getSetting('seslinkedin.fontcolor') ?>';
        //document.getElementById('seslinkedin_font_color').color.fromString('<?php //echo $settings->getSetting('seslinkedin.font.color') ?>');
      }
      if($('seslinkedin_font_color_light')) {
        $('seslinkedin_font_color_light').value = '<?php echo $settings->getSetting('seslinkedin.font.color.light') ?>';
        //document.getElementById('seslinkedin_font_color_light').color.fromString('<?php echo $settings->getSetting('seslinkedin.font.color.light') ?>');
      }
      if($('seslinkedin_heading_color')) {
        $('seslinkedin_heading_color').value = '<?php echo $settings->getSetting('seslinkedin.heading.color') ?>';
        //document.getElementById('seslinkedin_heading_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.heading.color') ?>');
      }
      if($('seslinkedin_links_color')) {
        $('seslinkedin_links_color').value = '<?php echo $settings->getSetting('seslinkedin.links.color') ?>';
        //document.getElementById('seslinkedin_links_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.links.color') ?>');
      }
      if($('seslinkedin_links_hover_color')) {
        $('seslinkedin_links_hover_color').value = '<?php echo $settings->getSetting('seslinkedin.links.hover.color') ?>';
       // document.getElementById('seslinkedin_links_hover_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.links.color.hover') ?>');
      }
			if($('seslinkedin_content_header_background_color')) {
        $('seslinkedin_content_header_background_color').value = '<?php echo $settings->getSetting('seslinkedin.content.header.background.color') ?>';
       // document.getElementById('seslinkedin_content_header_background_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.content.header.background.color') ?>');
      }
			if($('seslinkedin_content_header_font_color')) {
        $('seslinkedin_content_header_font_color').value = '<?php echo $settings->getSetting('seslinkedin.content.header.font.color') ?>';
       // document.getElementById('seslinkedin_content_header_font_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.content.header.font.color') ?>');
      }
      if($('seslinkedin_content_background_color')) {
        $('seslinkedin_content_background_color').value = '<?php echo $settings->getSetting('seslinkedin.content.background.color') ?>';
      //  document.getElementById('seslinkedin_content_background_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.content.background.color') ?>');
      }
      if($('seslinkedin_content_border_color')) {
        $('seslinkedin_content_border_color').value = '<?php echo $settings->getSetting('seslinkedin.content.border.color') ?>';
      //  document.getElementById('seslinkedin_content_border_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.content.border.color') ?>');
      }
      if($('seslinkedin_form_label_color')) {
        $('seslinkedin_input_font_color').value = '<?php echo $settings->getSetting('seslinkedin.form.label.color') ?>';
       // document.getElementById('seslinkedin_form_label_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.form.label.color') ?>');
      }
      if($('seslinkedin_input_background_color')) {
        $('seslinkedin_input_background_color').value = '<?php echo $settings->getSetting('seslinkedin.input.background.color') ?>';
      //  document.getElementById('seslinkedin_input_background_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.input.background.color') ?>');
      }
      if($('seslinkedin_input_font_color')) {
        $('seslinkedin_input_font_color').value = '<?php echo $settings->getSetting('seslinkedin.input.font.color') ?>';
       // document.getElementById('seslinkedin_input_font_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.input.font.color') ?>');
      }
      if($('seslinkedin_input_border_color')) {
        $('seslinkedin_input_border_color').value = '<?php echo $settings->getSetting('seslinkedin.input.border.color') ?>';
       // document.getElementById('seslinkedin_input_border_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.input.border.color') ?>');
      }
      if($('seslinkedin_button_background_color')) {
        $('seslinkedin_button_background_color').value = '<?php echo $settings->getSetting('seslinkedin.button.backgroundcolor') ?>';
        //document.getElementById('seslinkedin_button_background_color').color.fromString('<?php echo $settings->getSetting('seslinkedin.button.backgroundcolor') ?>');
      }
      if($('seslinkedin_button_background_color_hover')) {
        $('seslinkedin_button_background_color_hover').value = '<?php echo $settings->getSetting('seslinkedin.button.background.color.hover') ?>';
      }
      if($('seslinkedin_button_font_color')) {
        $('seslinkedin_button_font_color').value = '<?php echo $settings->getSetting('seslinkedin.button.font.color') ?>';
      }
      if($('seslinkedin_button_font_hover_color')) {
        $('seslinkedin_button_font_color').value = '<?php echo $settings->getSetting('seslinkedin.button.font.hover.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('seslinkedin_header_background_color')) {
        $('seslinkedin_header_background_color').value = '<?php echo $settings->getSetting('seslinkedin.header.background.color') ?>';
      }
			if($('seslinkedin_mainmenu_background_color')) {
        $('seslinkedin_mainmenu_background_color').value = '<?php echo $settings->getSetting('seslinkedin.mainmenu.background.color') ?>';
      }
      if($('seslinkedin_mainmenu_links_color')) {
        $('seslinkedin_mainmenu_links_color').value = '<?php echo $settings->getSetting('seslinkedin.mainmenu.links.color') ?>';
      }
      if($('seslinkedin_mainmenu_links_hover_color')) {
        $('seslinkedin_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('seslinkedin.mainmenu.links.hover.color') ?>';
      }
      if($('seslinkedin_minimenu_links_color')) {
        $('seslinkedin_minimenu_links_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.links.color') ?>';
      }
      if($('seslinkedin_minimenu_links_hover_color')) {
        $('seslinkedin_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.links.hover.color') ?>';
      }
      if($('seslinkedin_minimenu_icon_background_color')) {
        $('seslinkedin_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.icon.background.color') ?>';
      }
      if($('seslinkedin_minimenu_icon_background_active_color')) {
        $('seslinkedin_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.icon.background.active.color') ?>';
      }
      if($('seslinkedin_minimenu_icon_color')) {
        $('seslinkedin_minimenu_icon_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.icon.color') ?>';
      }
      if($('seslinkedin_minimenu_icon_active_color')) {
        $('seslinkedin_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('seslinkedin.minimenu.icon.active.color') ?>';
      }
      if($('seslinkedin_header_searchbox_background_color')) {
        $('seslinkedin_header_searchbox_background_color').value = '<?php echo $settings->getSetting('seslinkedin.header.searchbox.background.color') ?>';
      }
      if($('seslinkedin_header_searchbox_text_color')) {
        $('seslinkedin_header_searchbox_text_color').value = '<?php echo $settings->getSetting('seslinkedin.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('seslinkedin_toppanel_userinfo_background_color')) {
        $('seslinkedin_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('seslinkedin.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('seslinkedin_toppanel_userinfo_font_color')) {
        $('seslinkedin_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('seslinkedin.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
			//Login Popup Styling
      if($('seslinkedin_login_popup_header_font_color')) {
        $('seslinkedin_login_popup_header_font_color').value = '<?php echo $settings->getSetting('seslinkedin.login.popup.header.font.color'); ?>';
      }
      if($('seslinkedin_login_popup_header_background_color')) {
        $('seslinkedin_login_popup_header_background_color').value = '<?php echo $settings->getSetting('seslinkedin.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

      //Footer Styling
      if($('seslinkedin_footer_background_color')) {
        $('seslinkedin_footer_background_color').value = '<?php echo $settings->getSetting('seslinkedin.footer.background.color') ?>';
      }
      if($('seslinkedin_footer_heading_color')) {
        $('seslinkedin_footer_heading_color').value = '<?php echo $settings->getSetting('seslinkedin.footer.heading.color') ?>';
      }
      if($('seslinkedin_footer_links_color')) {
        $('seslinkedin_footer_links_color').value = '<?php echo $settings->getSetting('seslinkedin.footer.links.color') ?>';
      }
      if($('seslinkedin_footer_links_hover_color')) {
        $('seslinkedin_footer_links_hover_color').value = '<?php echo $settings->getSetting('seslinkedin.footer.links.hover.color') ?>';
      }
      if($('seslinkedin_footer_border_color')) {
        $('seslinkedin_footer_border_color').value = '<?php echo $settings->getSetting('seslinkedin.footer.border.color') ?>';
      }
      //Footer Styling
    }
	}
</script>
