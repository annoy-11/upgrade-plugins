<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesspectromedia/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sm_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sm_googlebody_fontfamily').value = 'Open Sans';
//       $('sm_googleheading_fontfamily').value = 'Open Sans';
//       if('sm_body-wrapper')
//         $('sm_body-wrapper').style.display = 'none';
      if($('sm_bodygrp'))
        $('sm_bodygrp').style.display = 'none';
//       if('sm_heading-wrapper')
//         $('sm_heading-wrapper').style.display = 'none';
      if($('sm_headinggrp'))
        $('sm_headinggrp').style.display = 'none';
//       if('sm_mainmenu-wrapper')
//         $('sm_mainmenu-wrapper').style.display = 'none';
      if($('sm_mainmenugrp'))
        $('sm_mainmenugrp').style.display = 'none';
//       if('sm_tab-wrapper')
//         $('sm_tab-wrapper').style.display = 'none';
      if($('sm_tabgrp'))
        $('sm_tabgrp').style.display = 'none';
        
      if($('sm_googlebodygrp'))
        $('sm_googlebodygrp').style.display = 'block';
      if($('sm_googleheadinggrp'))
        $('sm_googleheadinggrp').style.display = 'block';
      if($('sm_googlemainmenugrp'))
        $('sm_googlemainmenugrp').style.display = 'block';
      if($('sm_googletabgrp'))
        $('sm_googletabgrp').style.display = 'block';
    } else {
//       if('sm_body-wrapper')
//         $('sm_body-wrapper').style.display = 'block';
      if($('sm_bodygrp'))
        $('sm_bodygrp').style.display = 'block';
//       if('sm_heading-wrapper')
//         $('sm_heading-wrapper').style.display = 'block';
      if($('sm_headinggrp'))
        $('sm_headinggrp').style.display = 'block';
//       if('sm_mainmenu-wrapper')
//         $('sm_mainmenu-wrapper').style.display = 'block';
      if($('sm_mainmenugrp'))
        $('sm_mainmenugrp').style.display = 'block';
//       if('sm_tab-wrapper')
//         $('sm_tab-wrapper').style.display = 'block';
      if($('sm_tabgrp'))
        $('sm_tabgrp').style.display = 'block';
        
      if($('sm_googlebodygrp'))
        $('sm_googlebodygrp').style.display = 'none';
      if($('sm_googleheadinggrp'))
        $('sm_googleheadinggrp').style.display = 'none';
      if($('sm_googlemainmenugrp'))
        $('sm_googlemainmenugrp').style.display = 'none';
      if($('sm_googletabgrp'))
        $('sm_googletabgrp').style.display = 'none';
        
        
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
