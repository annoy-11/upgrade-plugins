<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sestwitterclone/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sm_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sestwitterclone.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sm_googlebody_fontfamily').value = 'Open Sans';
//       $('sm_googleheading_fontfamily').value = 'Open Sans';
//       if('sm_body-wrapper')
//         $('sm_body-wrapper').style.display = 'none';
      if($('sestwitterclone_bodygrp'))
        $('sestwitterclone_bodygrp').style.display = 'none';
//       if('sestwitterclone_heading-wrapper')
//         $('sestwitterclone_heading-wrapper').style.display = 'none';
      if($('sestwitterclone_headinggrp'))
        $('sestwitterclone_headinggrp').style.display = 'none';
//       if('sestwitterclone_mainmenu-wrapper')
//         $('sestwitterclone_mainmenu-wrapper').style.display = 'none';
      if($('sestwitterclone_mainmenugrp'))
        $('sestwitterclone_mainmenugrp').style.display = 'none';
//       if('sestwitterclone_tab-wrapper')
//         $('sestwitterclone_tab-wrapper').style.display = 'none';
      if($('sestwitterclone_tabgrp'))
        $('sestwitterclone_tabgrp').style.display = 'none';
        
      if($('sestwitterclone_googlebodygrp'))
        $('sestwitterclone_googlebodygrp').style.display = 'block';
      if($('sestwitterclone_googleheadinggrp'))
        $('sestwitterclone_googleheadinggrp').style.display = 'block';
      if($('sestwitterclone_googlemainmenugrp'))
        $('sestwitterclone_googlemainmenugrp').style.display = 'block';
      if($('sestwitterclone_googletabgrp'))
        $('sestwitterclone_googletabgrp').style.display = 'block';
    } else {
//       if('sestwitterclone_body-wrapper')
//         $('sestwitterclone_body-wrapper').style.display = 'block';
      if($('sestwitterclone_bodygrp'))
        $('sestwitterclone_bodygrp').style.display = 'block';
//       if('sestwitterclone_heading-wrapper')
//         $('sestwitterclone_heading-wrapper').style.display = 'block';
      if($('sestwitterclone_headinggrp'))
        $('sestwitterclone_headinggrp').style.display = 'block';
//       if('sestwitterclone_mainmenu-wrapper')
//         $('sestwitterclone_mainmenu-wrapper').style.display = 'block';
      if($('sestwitterclone_mainmenugrp'))
        $('sestwitterclone_mainmenugrp').style.display = 'block';
//       if('sestwitterclone_tab-wrapper')
//         $('sestwitterclone_tab-wrapper').style.display = 'block';
      if($('sestwitterclone_tabgrp'))
        $('sestwitterclone_tabgrp').style.display = 'block';
        
      if($('sestwitterclone_googlebodygrp'))
        $('sestwitterclone_googlebodygrp').style.display = 'none';
      if($('sestwitterclone_googleheadinggrp'))
        $('sestwitterclone_googleheadinggrp').style.display = 'none';
      if($('sestwitterclone_googlemainmenugrp'))
        $('sestwitterclone_googlemainmenugrp').style.display = 'none';
      if($('sestwitterclone_googletabgrp'))
        $('sestwitterclone_googletabgrp').style.display = 'none';
        
        
    }
  }
</script>
<!--<?php 
  $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
  $results = json_decode(file_get_contents($url),true);
  
  $string = 'https://fonts.googleapis.com/css?family=';
  foreach($results['items'] as $re) {
  	$string .= $re['family'] . '|';
  }
?>

<link href="<?php echo $string; ?>" type="text/css" rel="stylesheet" />
<style type="text/css">
 <?php foreach($results['items'] as $re) { ?>
      
	select option[value="<?php echo $re['family'];?>"]{
		font-family:<?php echo $re['family'];?>;
	}
	<?php } ?>
	-->
</style>
