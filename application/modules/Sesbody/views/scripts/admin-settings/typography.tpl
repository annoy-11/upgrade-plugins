 <?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbody/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesbody_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesbody_googlebody_fontfamily').value = 'Open Sans';
//       $('sesbody_googleheading_fontfamily').value = 'Open Sans';
//       if('sesbody_body-wrapper')
//         $('sesbody_body-wrapper').style.display = 'none';
      if($('sesbody_bodygrp'))
        $('sesbody_bodygrp').style.display = 'none';
//       if('sesbody_heading-wrapper')
//         $('sesbody_heading-wrapper').style.display = 'none';
      if($('sesbody_headinggrp'))
        $('sesbody_headinggrp').style.display = 'none';
//       if('sesbody_mainmenu-wrapper')
//         $('sesbody_mainmenu-wrapper').style.display = 'none';
      if($('sesbody_mainmenugrp'))
        $('sesbody_mainmenugrp').style.display = 'none';
//       if('sesbody_tab-wrapper')
//         $('sesbody_tab-wrapper').style.display = 'none';
      if($('sesbody_tabgrp'))
        $('sesbody_tabgrp').style.display = 'none';
        
      if($('sesbody_googlebodygrp'))
        $('sesbody_googlebodygrp').style.display = 'block';
      if($('sesbody_googleheadinggrp'))
        $('sesbody_googleheadinggrp').style.display = 'block';
      if($('sesbody_googlemainmenugrp'))
        $('sesbody_googlemainmenugrp').style.display = 'block';
      if($('sesbody_googletabgrp'))
        $('sesbody_googletabgrp').style.display = 'block';
    } else {
//       if('sesbody_body-wrapper')
//         $('sesbody_body-wrapper').style.display = 'block';
      if($('sesbody_bodygrp'))
        $('sesbody_bodygrp').style.display = 'block';
//       if('sesbody_heading-wrapper')
//         $('sesbody_heading-wrapper').style.display = 'block';
      if($('sesbody_headinggrp'))
        $('sesbody_headinggrp').style.display = 'block';
//       if('sesbody_mainmenu-wrapper')
//         $('sesbody_mainmenu-wrapper').style.display = 'block';
      if($('sesbody_mainmenugrp'))
        $('sesbody_mainmenugrp').style.display = 'block';
//       if('sesbody_tab-wrapper')
//         $('sesbody_tab-wrapper').style.display = 'block';
      if($('sesbody_tabgrp'))
        $('sesbody_tabgrp').style.display = 'block';
        
      if($('sesbody_googlebodygrp'))
        $('sesbody_googlebodygrp').style.display = 'none';
      if($('sesbody_googleheadinggrp'))
        $('sesbody_googleheadinggrp').style.display = 'none';
      if($('sesbody_googlemainmenugrp'))
        $('sesbody_googlemainmenugrp').style.display = 'none';
      if($('sesbody_googletabgrp'))
        $('sesbody_googletabgrp').style.display = 'none';
        
        
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
