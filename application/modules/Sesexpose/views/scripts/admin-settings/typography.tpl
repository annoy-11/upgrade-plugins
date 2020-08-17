<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesexpose/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form exp_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('exp_googlebody_fontfamily').value = 'Open Sans';
//       $('exp_googleheading_fontfamily').value = 'Open Sans';
//       if('exp_body-wrapper')
//         $('exp_body-wrapper').style.display = 'none';
      if($('exp_bodygrp'))
        $('exp_bodygrp').style.display = 'none';
//       if('exp_heading-wrapper')
//         $('exp_heading-wrapper').style.display = 'none';
      if($('exp_headinggrp'))
        $('exp_headinggrp').style.display = 'none';
//       if('exp_mainmenu-wrapper')
//         $('exp_mainmenu-wrapper').style.display = 'none';
      if($('exp_mainmenugrp'))
        $('exp_mainmenugrp').style.display = 'none';
//       if('exp_tab-wrapper')
//         $('exp_tab-wrapper').style.display = 'none';
      if($('exp_tabgrp'))
        $('exp_tabgrp').style.display = 'none';
        
      if($('exp_googlebodygrp'))
        $('exp_googlebodygrp').style.display = 'block';
      if($('exp_googleheadinggrp'))
        $('exp_googleheadinggrp').style.display = 'block';
      if($('exp_googlemainmenugrp'))
        $('exp_googlemainmenugrp').style.display = 'block';
      if($('exp_googletabgrp'))
        $('exp_googletabgrp').style.display = 'block';
    } else {
//       if('exp_body-wrapper')
//         $('exp_body-wrapper').style.display = 'block';
      if($('exp_bodygrp'))
        $('exp_bodygrp').style.display = 'block';
//       if('exp_heading-wrapper')
//         $('exp_heading-wrapper').style.display = 'block';
      if($('exp_headinggrp'))
        $('exp_headinggrp').style.display = 'block';
//       if('exp_mainmenu-wrapper')
//         $('exp_mainmenu-wrapper').style.display = 'block';
      if($('exp_mainmenugrp'))
        $('exp_mainmenugrp').style.display = 'block';
//       if('exp_tab-wrapper')
//         $('exp_tab-wrapper').style.display = 'block';
      if($('exp_tabgrp'))
        $('exp_tabgrp').style.display = 'block';
        
      if($('exp_googlebodygrp'))
        $('exp_googlebodygrp').style.display = 'none';
      if($('exp_googleheadinggrp'))
        $('exp_googleheadinggrp').style.display = 'none';
      if($('exp_googlemainmenugrp'))
        $('exp_googlemainmenugrp').style.display = 'none';
      if($('exp_googletabgrp'))
        $('exp_googletabgrp').style.display = 'none';
        
        
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
