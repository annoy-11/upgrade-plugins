<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesfooter/views/scripts/dismiss_message.tpl';?>

<div class='clear sesfooter_admin_form sesfooter_elements_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
  window.addEvent('domready', function() {
    show_settings('<?php echo Engine_Api::_()->sesfooter()->getContantValueXML("ses_footer_design") ?>');
    choosecontent('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.footer.choosecontent', 1); ?>');
    showContactDetails('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.showcontactdetails', 1); ?>');
  });
  
  function show_settings(value) {
    if(value == '2' || value == '4') {
      if($('sesfooter_footer_aboutheading-wrapper'))
				$('sesfooter_footer_aboutheading-wrapper').style.display = 'block';
      if($('sesfooter_footer_aboutdes-wrapper'))
				$('sesfooter_footer_aboutdes-wrapper').style.display = 'block';
      if($('ses_footer_footer5_description-wrapper'))
				$('ses_footer_footer5_description-wrapper').style.display = 'none';
			if($('sesfooter5_membercount-wrapper'))
				$('sesfooter5_membercount-wrapper').style.display = 'none';
			if($('sesfooter5_popularity-wrapper'))
				$('sesfooter5_popularity-wrapper').style.display = 'none';
			if($('sesfooter5_memberheight-wrapper'))
				$('sesfooter5_memberheight-wrapper').style.display = 'none';
			if($('sesfooter5_memberwidth-wrapper'))
				$('sesfooter5_memberwidth-wrapper').style.display = 'none';
			if($('sesfooter6_memberheading-wrapper'))
				$('sesfooter6_memberheading-wrapper').style.display = 'none';
      if($('sesfooter_enablelogo-wrapper'))
					$('sesfooter_enablelogo-wrapper').style.display = 'none';
      if($('sesfooter_footer_choosecontent-wrapper'))
					$('sesfooter_footer_choosecontent-wrapper').style.display = 'none';
    } else if(value == '1' || value == '3' || value == '5' || value == '6' || value == '7') {
      if($('sesfooter_footer_aboutheading-wrapper'))
				$('sesfooter_footer_aboutheading-wrapper').style.display = 'none';
      if($('sesfooter_footer_aboutdes-wrapper'))
				$('sesfooter_footer_aboutdes-wrapper').style.display = 'none';
      if($('ses_footer_footer5_description-wrapper') && value == '5')
				$('ses_footer_footer5_description-wrapper').style.display = 'block';
			else
				$('ses_footer_footer5_description-wrapper').style.display = 'none';
				
		  if(value == '6') {
        if($('sesfooter_footer_aboutdes-wrapper'))
          $('sesfooter_footer_aboutdes-wrapper').style.display = 'block';
        if($('sesfooter_enablelogo-wrapper'))
					$('sesfooter_enablelogo-wrapper').style.display = 'block';
        if($('sesfooter_footer_choosecontent-wrapper'))
					$('sesfooter_footer_choosecontent-wrapper').style.display = 'block';
			  if($('sesfooter5_membercount-wrapper'))
					$('sesfooter5_membercount-wrapper').style.display = 'block';
				if($('sesfooter5_popularity-wrapper'))
					$('sesfooter5_popularity-wrapper').style.display = 'block';
				if($('sesfooter5_memberheight-wrapper'))
					$('sesfooter5_memberheight-wrapper').style.display = 'block';
				if($('sesfooter5_memberwidth-wrapper'))
          $('sesfooter5_memberwidth-wrapper').style.display = 'block';
				if($('sesfooter6_memberheading-wrapper'))
          $('sesfooter6_memberheading-wrapper').style.display = 'block';
				if($('sesfooter6_module-wrapper'))
          $('sesfooter6_module-wrapper').style.display = 'block';
				if($('sesfooter6_socialmediaembedcode-wrapper'))
          $('sesfooter6_socialmediaembedcode-wrapper').style.display = 'block';
          
        if($('sesfooter6_androidapplink-wrapper'))
          $('sesfooter6_androidapplink-wrapper').style.display = 'block';
        if($('sesfooter6_iosapplink-wrapper'))
          $('sesfooter6_iosapplink-wrapper').style.display = 'block';
          
        if($('sesfooter_showcontactdetails-wrapper'))
					$('sesfooter_showcontactdetails-wrapper').style.display = 'block';
		  } else {
        if($('sesfooter_enablelogo-wrapper'))
					$('sesfooter_enablelogo-wrapper').style.display = 'none';
        if($('sesfooter_showcontactdetails-wrapper'))
					$('sesfooter_showcontactdetails-wrapper').style.display = 'none';
        showContactDetails(0);
        if($('sesfooter_footer_choosecontent-wrapper'))
					$('sesfooter_footer_choosecontent-wrapper').style.display = 'none';
			  if($('sesfooter5_membercount-wrapper'))
					$('sesfooter5_membercount-wrapper').style.display = 'none';
				if($('sesfooter5_popularity-wrapper'))
					$('sesfooter5_popularity-wrapper').style.display = 'none';
				if($('sesfooter5_memberheight-wrapper'))
					$('sesfooter5_memberheight-wrapper').style.display = 'none';
				if($('sesfooter5_memberwidth-wrapper'))
					$('sesfooter5_memberwidth-wrapper').style.display = 'none';
				if($('sesfooter6_memberheading-wrapper'))
          $('sesfooter6_memberheading-wrapper').style.display = 'none';
				if($('sesfooter6_module-wrapper'))
          $('sesfooter6_module-wrapper').style.display = 'none';
				if($('sesfooter6_socialmediaembedcode-wrapper'))
          $('sesfooter6_socialmediaembedcode-wrapper').style.display = 'none';
        if($('sesfooter6_androidapplink-wrapper'))
          $('sesfooter6_androidapplink-wrapper').style.display = 'none';
        if($('sesfooter6_iosapplink-wrapper'))
          $('sesfooter6_iosapplink-wrapper').style.display = 'none';
		  }
    }
    
  } 
  
  function choosecontent(value) {
  
    if(value == 1) {

      if($('sesfooter5_membercount-wrapper'))
        $('sesfooter5_membercount-wrapper').style.display = 'block';
      if($('sesfooter5_popularity-wrapper'))
        $('sesfooter5_popularity-wrapper').style.display = 'block';
      if($('sesfooter5_memberheight-wrapper'))
        $('sesfooter5_memberheight-wrapper').style.display = 'block';
      if($('sesfooter5_memberwidth-wrapper'))
        $('sesfooter5_memberwidth-wrapper').style.display = 'block';
      if($('sesfooter6_memberheading-wrapper'))
        $('sesfooter6_memberheading-wrapper').style.display = 'block';
      if($('sesfooter6_module-wrapper'))
        $('sesfooter6_module-wrapper').style.display = 'block';
      if($('sesfooter6_socialmediaembedcode-wrapper'))
          $('sesfooter6_socialmediaembedcode-wrapper').style.display = 'none';
//         if($('sesfooter6_androidapplink-wrapper'))
//           $('sesfooter6_androidapplink-wrapper').style.display = 'none';
//         if($('sesfooter6_iosapplink-wrapper'))
//           $('sesfooter6_iosapplink-wrapper').style.display = 'none';
    } else {
				if($('sesfooter6_socialmediaembedcode-wrapper'))
          $('sesfooter6_socialmediaembedcode-wrapper').style.display = 'block';
//         if($('sesfooter6_androidapplink-wrapper'))
//           $('sesfooter6_androidapplink-wrapper').style.display = 'block';
//         if($('sesfooter6_iosapplink-wrapper'))
//           $('sesfooter6_iosapplink-wrapper').style.display = 'block';
			  if($('sesfooter5_membercount-wrapper'))
					$('sesfooter5_membercount-wrapper').style.display = 'none';
				if($('sesfooter5_popularity-wrapper'))
					$('sesfooter5_popularity-wrapper').style.display = 'none';
				if($('sesfooter5_memberheight-wrapper'))
					$('sesfooter5_memberheight-wrapper').style.display = 'none';
				if($('sesfooter5_memberwidth-wrapper'))
					$('sesfooter5_memberwidth-wrapper').style.display = 'none';
				if($('sesfooter6_memberheading-wrapper'))
          $('sesfooter6_memberheading-wrapper').style.display = 'none';
				if($('sesfooter6_module-wrapper'))
          $('sesfooter6_module-wrapper').style.display = 'none';
    }
  
  }
  
  function showContactDetails(value) {
  
    if(value == 1) {
      if($('sesfooter6_contactaddress-wrapper'))
          $('sesfooter6_contactaddress-wrapper').style.display = 'block';
      if($('sesfooter6_contactphonenumber-wrapper'))
          $('sesfooter6_contactphonenumber-wrapper').style.display = 'block';
      if($('sesfooter6_contactemail-wrapper'))
          $('sesfooter6_contactemail-wrapper').style.display = 'block';
      if($('sesfooter6_contactwebsiteurl-wrapper'))
          $('sesfooter6_contactwebsiteurl-wrapper').style.display = 'block';
    } else {
      if($('sesfooter6_contactaddress-wrapper'))
          $('sesfooter6_contactaddress-wrapper').style.display = 'none';
      if($('sesfooter6_contactphonenumber-wrapper'))
          $('sesfooter6_contactphonenumber-wrapper').style.display = 'none';
      if($('sesfooter6_contactemail-wrapper'))
          $('sesfooter6_contactemail-wrapper').style.display = 'none';
      if($('sesfooter6_contactwebsiteurl-wrapper'))
          $('sesfooter6_contactwebsiteurl-wrapper').style.display = 'none';
    }
  
  }
</script>
