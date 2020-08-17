<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesytube_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesytube_googlebody_fontfamily').value = 'Open Sans';
//       $('sesytube_googleheading_fontfamily').value = 'Open Sans';
//       if('sesytube_body-wrapper')
//         $('sesytube_body-wrapper').style.display = 'none';
      if($('sesytube_bodygrp'))
        $('sesytube_bodygrp').style.display = 'none';
//       if('sesytube_heading-wrapper')
//         $('sesytube_heading-wrapper').style.display = 'none';
      if($('sesytube_headinggrp'))
        $('sesytube_headinggrp').style.display = 'none';
//       if('sesytube_mainmenu-wrapper')
//         $('sesytube_mainmenu-wrapper').style.display = 'none';
      if($('sesytube_mainmenugrp'))
        $('sesytube_mainmenugrp').style.display = 'none';
//       if('sesytube_tab-wrapper')
//         $('sesytube_tab-wrapper').style.display = 'none';
      if($('sesytube_tabgrp'))
        $('sesytube_tabgrp').style.display = 'none';
        
      if($('sesytube_googlebodygrp'))
        $('sesytube_googlebodygrp').style.display = 'block';
      if($('sesytube_googleheadinggrp'))
        $('sesytube_googleheadinggrp').style.display = 'block';
      if($('sesytube_googlemainmenugrp'))
        $('sesytube_googlemainmenugrp').style.display = 'block';
      if($('sesytube_googletabgrp'))
        $('sesytube_googletabgrp').style.display = 'block';
    } else {
//       if('sesytube_body-wrapper')
//         $('sesytube_body-wrapper').style.display = 'block';
      if($('sesytube_bodygrp'))
        $('sesytube_bodygrp').style.display = 'block';
//       if('sesytube_heading-wrapper')
//         $('sesytube_heading-wrapper').style.display = 'block';
      if($('sesytube_headinggrp'))
        $('sesytube_headinggrp').style.display = 'block';
//       if('sesytube_mainmenu-wrapper')
//         $('sesytube_mainmenu-wrapper').style.display = 'block';
      if($('sesytube_mainmenugrp'))
        $('sesytube_mainmenugrp').style.display = 'block';
//       if('sesytube_tab-wrapper')
//         $('sesytube_tab-wrapper').style.display = 'block';
      if($('sesytube_tabgrp'))
        $('sesytube_tabgrp').style.display = 'block';
        
      if($('sesytube_googlebodygrp'))
        $('sesytube_googlebodygrp').style.display = 'none';
      if($('sesytube_googleheadinggrp'))
        $('sesytube_googleheadinggrp').style.display = 'none';
      if($('sesytube_googlemainmenugrp'))
        $('sesytube_googlemainmenugrp').style.display = 'none';
      if($('sesytube_googletabgrp'))
        $('sesytube_googletabgrp').style.display = 'none';
        
        
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
