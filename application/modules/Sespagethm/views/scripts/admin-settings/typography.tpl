<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sespagethm/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sespagethm_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sespagethm_googlebody_fontfamily').value = 'Open Sans';
//       $('sespagethm_googleheading_fontfamily').value = 'Open Sans';
//       if('sespagethm_body-wrapper')
//         $('sespagethm_body-wrapper').style.display = 'none';
      if($('sespagethm_bodygrp'))
        $('sespagethm_bodygrp').style.display = 'none';
//       if('sespagethm_heading-wrapper')
//         $('sespagethm_heading-wrapper').style.display = 'none';
      if($('sespagethm_headinggrp'))
        $('sespagethm_headinggrp').style.display = 'none';
//       if('sespagethm_mainmenu-wrapper')
//         $('sespagethm_mainmenu-wrapper').style.display = 'none';
      if($('sespagethm_mainmenugrp'))
        $('sespagethm_mainmenugrp').style.display = 'none';
//       if('sespagethm_tab-wrapper')
//         $('sespagethm_tab-wrapper').style.display = 'none';
      if($('sespagethm_tabgrp'))
        $('sespagethm_tabgrp').style.display = 'none';
        
      if($('sespagethm_googlebodygrp'))
        $('sespagethm_googlebodygrp').style.display = 'block';
      if($('sespagethm_googleheadinggrp'))
        $('sespagethm_googleheadinggrp').style.display = 'block';
      if($('sespagethm_googlemainmenugrp'))
        $('sespagethm_googlemainmenugrp').style.display = 'block';
      if($('sespagethm_googletabgrp'))
        $('sespagethm_googletabgrp').style.display = 'block';
    } else {
//       if('sespagethm_body-wrapper')
//         $('sespagethm_body-wrapper').style.display = 'block';
      if($('sespagethm_bodygrp'))
        $('sespagethm_bodygrp').style.display = 'block';
//       if('sespagethm_heading-wrapper')
//         $('sespagethm_heading-wrapper').style.display = 'block';
      if($('sespagethm_headinggrp'))
        $('sespagethm_headinggrp').style.display = 'block';
//       if('sespagethm_mainmenu-wrapper')
//         $('sespagethm_mainmenu-wrapper').style.display = 'block';
      if($('sespagethm_mainmenugrp'))
        $('sespagethm_mainmenugrp').style.display = 'block';
//       if('sespagethm_tab-wrapper')
//         $('sespagethm_tab-wrapper').style.display = 'block';
      if($('sespagethm_tabgrp'))
        $('sespagethm_tabgrp').style.display = 'block';
        
      if($('sespagethm_googlebodygrp'))
        $('sespagethm_googlebodygrp').style.display = 'none';
      if($('sespagethm_googleheadinggrp'))
        $('sespagethm_googleheadinggrp').style.display = 'none';
      if($('sespagethm_googlemainmenugrp'))
        $('sespagethm_googlemainmenugrp').style.display = 'none';
      if($('sespagethm_googletabgrp'))
        $('sespagethm_googletabgrp').style.display = 'none';
        
        
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
