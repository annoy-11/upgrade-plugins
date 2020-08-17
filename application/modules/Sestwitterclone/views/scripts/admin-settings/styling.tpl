<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
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
<?php include APPLICATION_PATH .  '/application/modules/Sestwitterclone/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sestwitterclone_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sestwitterclone()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 13) {
      var URL = en4.core.staticBaseUrl+'sestwitterclone/admin-settings/getcustomthemecolors/';
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
              if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor')){
                if(splitValue[1] == ""){
                  splitValue[1] = "#FFFFFF";  
                }
              try{
                document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
              }catch(err) {
                document.getElementById(splitValue[0]).value = "#FFFFFF";
              }
              }
            }
          
          
//           var customthevalyearray = jqueryObjectOfSes.parseJSON(responseHTML);
//           
//           for(i=0;i<customthevalyearray.length;i++){
//             var splitValue = customthevalyearray[i].split('||');
//             jqueryObjectOfSes('#'+splitValue[0]).val(splitValue[1]);
//             if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor'))
//             document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
//           }
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
				
      if($('custom_theme_color').value > 3) {
        if($('submit'))
          $('submit').style.display = 'inline-block';
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'block';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'block';

        <?php if(empty($this->customtheme_id)): ?>
          history.pushState(null, null, 'admin/sestwitterclone/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sestwitterclone/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sestwitterclone/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sestwitterclone/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sestwitterclone/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sestwitterclone/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
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
		
      if($('sestwitterclone_header_background_color')) {
        $('sestwitterclone_header_background_color').value = '#fff';
        //document.getElementById('sestwitterclone_header_background_color').color.fromString('#fff');
      }
      if($('sestwitterclone_header_border_color')) {
        $('sestwitterclone_header_border_color').value = '#b7b7b7';
        //document.getElementById('sestwitterclone_header_border_color').color.fromString('#b7b7b7');
      }
      if($('sestwitterclone_header_search_background_color')) {
        $('sestwitterclone_header_search_background_color').value = '#f5f8fa';
        //document.getElementById('sestwitterclone_header_search_background_color').color.fromString('#f5f8fa');
      }
      if($('sestwitterclone_header_search_border_color')) {
        $('sestwitterclone_header_search_border_color').value = '#e6ecf0';
        //document.getElementById('sestwitterclone_header_search_border_color').color.fromString('#e6ecf0');
      }
      if($('sestwitterclone_header_search_button_background_color')) {
        $('sestwitterclone_header_search_button_background_color').value = '#f5f8fa';
        //document.getElementById('sestwitterclone_header_search_button_background_color').color.fromString('#f5f8fa');
      }
      if($('sestwitterclone_header_search_button_font_color')) {
        $('sestwitterclone_header_search_button_font_color').value = '#66757f';
        //document.getElementById('sestwitterclone_header_search_button_font_color').color.fromString('#66757f');
      }
      if($('sestwitterclone_mainmenu_search_background_color')) {
        $('sestwitterclone_mainmenu_search_background_color').value = '#1DA1F2';
       // document.getElementById('sestwitterclone_mainmenu_search_background_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_mainmenu_background_color')) {
        $('sestwitterclone_mainmenu_background_color').value = '#fff';
       // document.getElementById('sestwitterclone_mainmenu_background_color').color.fromString('#fff');
      }
      if($('sestwitterclone_mainmenu_links_color')) {
        $('sestwitterclone_mainmenu_links_color').value = '#66757f';
        //document.getElementById('sestwitterclone_mainmenu_links_color').color.fromString('#66757f');
      }
      if($('sestwitterclone_mainmenu_links_hover_color')) {
        $('sestwitterclone_mainmenu_links_hover_color').value = '#1DA1F2';
        //document.getElementById('sestwitterclone_mainmenu_links_hover_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_mainmenu_footer_font_color')) {
        $('sestwitterclone_mainmenu_footer_font_color').value = '#bdbdbd';
       // document.getElementById('sestwitterclone_mainmenu_footer_font_color').color.fromString('#bdbdbd');
      }
      if($('sestwitterclone_minimenu_links_color')) {
        $('sestwitterclone_minimenu_links_color').value = '#657786';
       // document.getElementById('sestwitterclone_minimenu_links_color').color.fromString('#657786');
      }
      if($('sestwitterclone_minimenu_link_active_color')) {
        $('sestwitterclone_minimenu_link_active_color').value = '#1DA1F2';
       // document.getElementById('sestwitterclone_minimenu_link_active_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_footer_background_color')) {
        $('sestwitterclone_footer_background_color').value = '#fff';
      //  document.getElementById('sestwitterclone_footer_background_color').color.fromString('#fff');
      }
      if($('sestwitterclone_footer_font_color')) {
        $('sestwitterclone_footer_font_color').value = '#aab8c2';
       // document.getElementById('sestwitterclone_footer_font_color').color.fromString('#aab8c2');
      }
      if($('sestwitterclone_footer_links_color')) {
        $('sestwitterclone_footer_links_color').value = '#aab8c2';
     //   document.getElementById('sestwitterclone_footer_links_color').color.fromString('#aab8c2');
      }
      if($('sestwitterclone_footer_border_color')) {
        $('sestwitterclone_footer_border_color').value = '#e6ecf0';
       // document.getElementById('sestwitterclone_footer_border_color').color.fromString('#e6ecf0');
      }
      if($('sestwitterclone_theme_color')) {
        $('sestwitterclone_theme_color').value = '#1DA1F2';
        //document.getElementById('sestwitterclone_theme_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_body_background_color')) {
        $('sestwitterclone_body_background_color').value = '#e6ecf0';
       // document.getElementById('sestwitterclone_body_background_color').color.fromString('#e6ecf0');
      }
      if($('sestwitterclone_font_color')) {
        $('sestwitterclone_font_color').value = '#14171a';
       // document.getElementById('sestwitterclone_font_color').color.fromString('#14171a');
      }
      if($('sestwitterclone_font_color_light')) {
        $('sestwitterclone_font_color_light').value = '#657786';
       // document.getElementById('sestwitterclone_font_color_light').color.fromString('#657786');
      }
      if($('sestwitterclone_links_color')) {
        $('sestwitterclone_links_color').value = '#14171a';
       // document.getElementById('sestwitterclone_links_color').color.fromString('#14171a');
      }
      if($('sestwitterclone_links_hover_color')) {
        $('sestwitterclone_links_hover_color').value = '#1DA1F2';
        //document.getElementById('sestwitterclone_links_hover_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_headline_color')) {
        $('sestwitterclone_headline_color').value = '#14171a';
       // document.getElementById('sestwitterclone_headline_color').color.fromString('#14171a');
      }
      if($('sestwitterclone_border_color')) {
        $('sestwitterclone_border_color').value = '#e6ecf0';
       // document.getElementById('sestwitterclone_border_color').color.fromString('#e6ecf0');
      }
      if($('sestwitterclone_box_background_color')) {
        $('sestwitterclone_box_background_color').value = '#fff';
       // document.getElementById('sestwitterclone_box_background_color').color.fromString('#fff');
      }
      if($('sestwitterclone_form_label_color')) {
        $('sestwitterclone_form_label_color').value = '#455B6B';
       // document.getElementById('sestwitterclone_form_label_color').color.fromString('#455B6B');
      }
      if($('sestwitterclone_input_background_color')) {
        $('sestwitterclone_input_background_color').value = '#fff';
       // document.getElementById('sestwitterclone_input_background_color').color.fromString('#fff');
      }
      if($('sestwitterclone_input_font_color')) {
        $('sestwitterclone_input_font_color').value = '#5f727f';
       // document.getElementById('sestwitterclone_input_font_color').color.fromString('#5f727f');
      }
      if($('sestwitterclone_input_border_color')) {
        $('sestwitterclone_input_border_color').value = '#d7d8da';
       // document.getElementById('sestwitterclone_input_border_color').color.fromString('#d7d8da');
      }
      if($('sestwitterclone_button_background_color')) {
        $('sestwitterclone_button_background_color').value = '#1da1f2';
        //document.getElementById('sestwitterclone_button_background_color').color.fromString('#1da1f2');
      }
      if($('sestwitterclone_button_background_color_hover')) {
        $('sestwitterclone_button_background_color_hover').value = '#eaf5fd';
       // document.getElementById('sestwitterclone_button_background_color_hover').color.fromString('#eaf5fd);
      }
      if($('sestwitterclone_button_font_color')) {
        $('sestwitterclone_button_font_color').value = '#fff';
       // document.getElementById('sestwitterclone_button_font_color').color.fromString('#fff');
      }
      if($('sestwitterclone_button_border_color')) {
        $('sestwitterclone_button_border_color').value = '#1da1f2';
       // document.getElementById('sestwitterclone_button_border_color').color.fromString('#1da1f2');
      }
      if($('sestwitterclone_comments_background_color')) {
        $('sestwitterclone_comments_background_color').value = '#e8f5fe';
       // document.getElementById('sestwitterclone_comments_background_color').color.fromString('#e8f5fe');
      }
		} 
		else if(value == 2) {
		
      if($('sestwitterclone_header_background_color')) {
        $('sestwitterclone_header_background_color').value = '#22313e';
        document.getElementById('sestwitterclone_header_background_color').color.fromString('#22313e');
      }
      if($('sestwitterclone_header_border_color')) {
        $('sestwitterclone_header_border_color').value = '#22313e';
        document.getElementById('sestwitterclone_header_border_color').color.fromString('#22313e');
      }
      if($('sestwitterclone_header_search_background_color')) {
        $('sestwitterclone_header_search_background_color').value = '#2C4058';
        document.getElementById('sestwitterclone_header_search_background_color').color.fromString('#2C4058');
      }
      if($('sestwitterclone_header_search_border_color')) {
        $('sestwitterclone_header_search_border_color').value = '#2C4058';
        document.getElementById('sestwitterclone_header_search_border_color').color.fromString('#2C4058');
      }
      if($('sestwitterclone_header_search_button_background_color')) {
        $('sestwitterclone_header_search_button_background_color').value = '#2C4058';
        document.getElementById('sestwitterclone_header_search_button_background_color').color.fromString('#2C4058');
      }
      if($('sestwitterclone_header_search_button_font_color')) {
        $('sestwitterclone_header_search_button_font_color').value = '#fff';
        document.getElementById('sestwitterclone_header_search_button_font_color').color.fromString('#fff');
      }
      if($('sestwitterclone_mainmenu_search_background_color')) {
        $('sestwitterclone_mainmenu_search_background_color').value = '#141414';
        document.getElementById('sestwitterclone_mainmenu_search_background_color').color.fromString('#141414');
      }
      if($('sestwitterclone_mainmenu_background_color')) {
        $('sestwitterclone_mainmenu_background_color').value = '#1DA1F2';
        document.getElementById('sestwitterclone_mainmenu_background_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_mainmenu_links_color')) {
        $('sestwitterclone_mainmenu_links_color').value = '#fff';
        document.getElementById('sestwitterclone_mainmenu_links_color').color.fromString('#fff');
      }
      if($('sestwitterclone_mainmenu_links_hover_color')) {
        $('sestwitterclone_mainmenu_links_hover_color').value = '#000';
        document.getElementById('sestwitterclone_mainmenu_links_hover_color').color.fromString('#000');
      }
      if($('sestwitterclone_mainmenu_footer_font_color')) {
        $('sestwitterclone_mainmenu_footer_font_color').value = '#fff';
        document.getElementById('sestwitterclone_mainmenu_footer_font_color').color.fromString('#fff');
      }
      if($('sestwitterclone_minimenu_links_color')) {
        $('sestwitterclone_minimenu_links_color').value = '#fff';
        document.getElementById('sestwitterclone_minimenu_links_color').color.fromString('#fff');
      }
      if($('sestwitterclone_minimenu_link_active_color')) {
        $('sestwitterclone_minimenu_link_active_color').value = '#1DA1F2';
        document.getElementById('sestwitterclone_minimenu_link_active_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_footer_background_color')) {
        $('sestwitterclone_footer_background_color').value = '#2c4058';
        document.getElementById('sestwitterclone_footer_background_color').color.fromString('#2c4058');
      }
      if($('sestwitterclone_footer_font_color')) {
        $('sestwitterclone_footer_font_color').value = '#acacac';
        document.getElementById('sestwitterclone_footer_font_color').color.fromString('#acacac');
      }
      if($('sestwitterclone_footer_links_color')) {
        $('sestwitterclone_footer_links_color').value = '#acacac';
        document.getElementById('sestwitterclone_footer_links_color').color.fromString('#acacac');
      }
      if($('sestwitterclone_footer_border_color')) {
        $('sestwitterclone_footer_border_color').value = '#2c4058';
        document.getElementById('sestwitterclone_footer_border_color').color.fromString('#2c4058');
      }
      if($('sestwitterclone_theme_color')) {
        $('sestwitterclone_theme_color').value = '#1DA1F2';
        document.getElementById('sestwitterclone_theme_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_body_background_color')) {
        $('sestwitterclone_body_background_color').value = '#2c4058';
        document.getElementById('sestwitterclone_body_background_color').color.fromString('#2c4058');
      }
      if($('sestwitterclone_font_color')) {
        $('sestwitterclone_font_color').value = '#fff';
        document.getElementById('sestwitterclone_font_color').color.fromString('#fff');
      }
      if($('sestwitterclone_font_color_light')) {
        $('sestwitterclone_font_color_light').value = '#acacac';
        document.getElementById('sestwitterclone_font_color_light').color.fromString('#acacac');
      }
      if($('sestwitterclone_links_color')) {
        $('sestwitterclone_links_color').value = '#fff';
        document.getElementById('sestwitterclone_links_color').color.fromString('#fff');
      }
      if($('sestwitterclone_links_hover_color')) {
        $('sestwitterclone_links_hover_color').value = '#1DA1F2';
        document.getElementById('sestwitterclone_links_hover_color').color.fromString('#1DA1F2');
      }
      if($('sestwitterclone_headline_color')) {
        $('sestwitterclone_headline_color').value = '#fff';
        document.getElementById('sestwitterclone_headline_color').color.fromString('#fff');
      }
      if($('sestwitterclone_border_color')) {
        $('sestwitterclone_border_color').value = '#2c4058';
        document.getElementById('sestwitterclone_border_color').color.fromString('#2c4058');
      }
      if($('sestwitterclone_box_background_color')) {
        $('sestwitterclone_box_background_color').value = '#1b2936';
        document.getElementById('sestwitterclone_box_background_color').color.fromString('#1b2936');
      }
      if($('sestwitterclone_form_label_color')) {
        $('sestwitterclone_form_label_color').value = '#fff';
        document.getElementById('sestwitterclone_form_label_color').color.fromString('#fff');
      }
      if($('sestwitterclone_input_background_color')) {
        $('sestwitterclone_input_background_color').value = '#1B2936';
        document.getElementById('sestwitterclone_input_background_color').color.fromString('#1B2936');
      }
      if($('sestwitterclone_input_font_color')) {
        $('sestwitterclone_input_font_color').value = '#ACACAC';
        document.getElementById('sestwitterclone_input_font_color').color.fromString('#ACACAC');
      }
      if($('sestwitterclone_input_border_color')) {
        $('sestwitterclone_input_border_color').value = '#2C4058';
        document.getElementById('sestwitterclone_input_border_color').color.fromString('#2C4058');
      }
     if($('sestwitterclone_button_background_color')) {
        $('sestwitterclone_button_background_color').value = '#1da1f2';
        //document.getElementById('sestwitterclone_button_background_color').color.fromString('#1da1f2');
      }
      if($('sestwitterclone_button_background_color_hover')) {
        $('sestwitterclone_button_background_color_hover').value = '#eaf5fd';
       // document.getElementById('sestwitterclone_button_background_color_hover').color.fromString('#eaf5fd);
      }
      if($('sestwitterclone_button_font_color')) {
        $('sestwitterclone_button_font_color').value = '#1b2936';
       // document.getElementById('sestwitterclone_button_font_color').color.fromString('#1b2936');
      }
      if($('sestwitterclone_button_border_color')) {
        $('sestwitterclone_button_border_color').value = '#1da1f2';
       // document.getElementById('sestwitterclone_button_border_color').color.fromString('#1da1f2');
      }
      if($('sestwitterclone_comments_background_color')) {
        $('sestwitterclone_comments_background_color').value = '#2c4058';
        document.getElementById('sestwitterclone_comments_background_color').color.fromString('#2c4058');
      }
			
		} else if(value == 5) {
    
      //Theme Base Styling
      if($('sestwitterclone_theme_color')) {
        $('sestwitterclone_theme_color').value = '<?php echo $settings->getSetting('sestwitterclone.theme.color') ?>';
       // document.getElementById('sestwitterclone_theme_color').color.fromString('<?php //echo $settings->getSetting('sestwitterclone.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sestwitterclone_body_background_color')) {
        $('sestwitterclone_body_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.body.background.color') ?>';
       // document.getElementById('sestwitterclone_body_background_color').color.fromString('<?php //echo $settings->getSetting('sestwitterclone.body.background.color') ?>');
      }
      if($('sestwitterclone_font_color')) {
        $('sestwitterclone_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.fontcolor') ?>';
        //document.getElementById('sestwitterclone_font_color').color.fromString('<?php //echo $settings->getSetting('sestwitterclone.font.color') ?>');
      }
      if($('sestwitterclone_font_color_light')) {
        $('sestwitterclone_font_color_light').value = '<?php echo $settings->getSetting('sestwitterclone.font.color.light') ?>';
        //document.getElementById('sestwitterclone_font_color_light').color.fromString('<?php echo $settings->getSetting('sestwitterclone.font.color.light') ?>');
      }
      if($('sestwitterclone_heading_color')) {
        $('sestwitterclone_heading_color').value = '<?php echo $settings->getSetting('sestwitterclone.heading.color') ?>';
        //document.getElementById('sestwitterclone_heading_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.heading.color') ?>');
      }
      if($('sestwitterclone_links_color')) {
        $('sestwitterclone_links_color').value = '<?php echo $settings->getSetting('sestwitterclone.links.color') ?>';
        //document.getElementById('sestwitterclone_links_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.links.color') ?>');
      }
      if($('sestwitterclone_links_hover_color')) {
        $('sestwitterclone_links_hover_color').value = '<?php echo $settings->getSetting('sestwitterclone.links.hover.color') ?>';
       // document.getElementById('sestwitterclone_links_hover_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.links.color.hover') ?>');
      }
			if($('sestwitterclone_content_header_background_color')) {
        $('sestwitterclone_content_header_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.content.header.background.color') ?>';
       // document.getElementById('sestwitterclone_content_header_background_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.content.header.background.color') ?>');
      }
			if($('sestwitterclone_content_header_font_color')) {
        $('sestwitterclone_content_header_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.content.header.font.color') ?>';
       // document.getElementById('sestwitterclone_content_header_font_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.content.header.font.color') ?>');
      }
      if($('sestwitterclone_content_background_color')) {
        $('sestwitterclone_content_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.content.background.color') ?>';
      //  document.getElementById('sestwitterclone_content_background_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.content.background.color') ?>');
      }
      if($('sestwitterclone_content_border_color')) {
        $('sestwitterclone_content_border_color').value = '<?php echo $settings->getSetting('sestwitterclone.content.border.color') ?>';
      //  document.getElementById('sestwitterclone_content_border_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.content.border.color') ?>');
      }
      if($('sestwitterclone_form_label_color')) {
        $('sestwitterclone_input_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.form.label.color') ?>';
       // document.getElementById('sestwitterclone_form_label_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.form.label.color') ?>');
      }
      if($('sestwitterclone_input_background_color')) {
        $('sestwitterclone_input_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.input.background.color') ?>';
      //  document.getElementById('sestwitterclone_input_background_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.input.background.color') ?>');
      }
      if($('sestwitterclone_input_font_color')) {
        $('sestwitterclone_input_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.input.font.color') ?>';
       // document.getElementById('sestwitterclone_input_font_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.input.font.color') ?>');
      }
      if($('sestwitterclone_input_border_color')) {
        $('sestwitterclone_input_border_color').value = '<?php echo $settings->getSetting('sestwitterclone.input.border.color') ?>';
       // document.getElementById('sestwitterclone_input_border_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.input.border.color') ?>');
      }
      if($('sestwitterclone_button_background_color')) {
        $('sestwitterclone_button_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.button.backgroundcolor') ?>';
        //document.getElementById('sestwitterclone_button_background_color').color.fromString('<?php echo $settings->getSetting('sestwitterclone.button.backgroundcolor') ?>');
      }
      if($('sestwitterclone_button_background_color_hover')) {
        $('sestwitterclone_button_background_color_hover').value = '<?php echo $settings->getSetting('sestwitterclone.button.background.color.hover') ?>';
      }
      if($('sestwitterclone_button_font_color')) {
        $('sestwitterclone_button_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.button.font.color') ?>';
      }
      if($('sestwitterclone_button_font_hover_color')) {
        $('sestwitterclone_button_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.button.font.hover.color') ?>';
      }
      if($('sestwitterclone_comment_background_color')) {
        $('sestwitterclone_comment_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.comment.background.color') ?>';
      }
      if($('sestwitterclone_comments_background_color')) {
        $('sestwitterclone_comments_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.comments.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sestwitterclone_header_background_color')) {
        $('sestwitterclone_header_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.header.background.color') ?>';
      }
			if($('sestwitterclone_mainmenu_background_color')) {
        $('sestwitterclone_mainmenu_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.mainmenu.background.color') ?>';
      }
      if($('sestwitterclone_mainmenu_links_color')) {
        $('sestwitterclone_mainmenu_links_color').value = '<?php echo $settings->getSetting('sestwitterclone.mainmenu.links.color') ?>';
      }
      if($('sestwitterclone_mainmenu_links_hover_color')) {
        $('sestwitterclone_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sestwitterclone.mainmenu.links.hover.color') ?>';
      }
      if($('sestwitterclone_minimenu_links_color')) {
        $('sestwitterclone_minimenu_links_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.links.color') ?>';
      }
      if($('sestwitterclone_minimenu_links_hover_color')) {
        $('sestwitterclone_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.links.hover.color') ?>';
      }
      if($('sestwitterclone_minimenu_icon_background_color')) {
        $('sestwitterclone_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.icon.background.color') ?>';
      }
      if($('sestwitterclone_minimenu_icon_background_active_color')) {
        $('sestwitterclone_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.icon.background.active.color') ?>';
      }
      if($('sestwitterclone_minimenu_icon_color')) {
        $('sestwitterclone_minimenu_icon_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.icon.color') ?>';
      }
      if($('sestwitterclone_minimenu_icon_active_color')) {
        $('sestwitterclone_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sestwitterclone.minimenu.icon.active.color') ?>';
      }
      if($('sestwitterclone_header_searchbox_background_color')) {
        $('sestwitterclone_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.header.searchbox.background.color') ?>';
      }
      if($('sestwitterclone_header_searchbox_text_color')) {
        $('sestwitterclone_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sestwitterclone.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('sestwitterclone_toppanel_userinfo_background_color')) {
        $('sestwitterclone_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('sestwitterclone_toppanel_userinfo_font_color')) {
        $('sestwitterclone_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
			//Login Popup Styling
      if($('sestwitterclone_login_popup_header_font_color')) {
        $('sestwitterclone_login_popup_header_font_color').value = '<?php echo $settings->getSetting('sestwitterclone.login.popup.header.font.color'); ?>';
      }
      if($('sestwitterclone_login_popup_header_background_color')) {
        $('sestwitterclone_login_popup_header_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.login.popup.header.background.color'); ?>';
      }
			//Login Pop up Styling
      //Header Styling

      //Footer Styling
      if($('sestwitterclone_footer_background_color')) {
        $('sestwitterclone_footer_background_color').value = '<?php echo $settings->getSetting('sestwitterclone.footer.background.color') ?>';
      }
      if($('sestwitterclone_footer_heading_color')) {
        $('sestwitterclone_footer_heading_color').value = '<?php echo $settings->getSetting('sestwitterclone.footer.heading.color') ?>';
      }
      if($('sestwitterclone_footer_links_color')) {
        $('sestwitterclone_footer_links_color').value = '<?php echo $settings->getSetting('sestwitterclone.footer.links.color') ?>';
      }
      if($('sestwitterclone_footer_links_hover_color')) {
        $('sestwitterclone_footer_links_hover_color').value = '<?php echo $settings->getSetting('sestwitterclone.footer.links.hover.color') ?>';
      }
      if($('sestwitterclone_footer_border_color')) {
        $('sestwitterclone_footer_border_color').value = '<?php echo $settings->getSetting('sestwitterclone.footer.border.color') ?>';
      }
      //Footer Styling
    }
	}
</script>
