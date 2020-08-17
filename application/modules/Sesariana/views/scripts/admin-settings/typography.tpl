<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesariana/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesariana_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesariana_googlebody_fontfamily').value = 'Open Sans';
//       $('sesariana_googleheading_fontfamily').value = 'Open Sans';
//       if('sesariana_body-wrapper')
//         $('sesariana_body-wrapper').style.display = 'none';
      if($('sesariana_bodygrp'))
        $('sesariana_bodygrp').style.display = 'none';
//       if('sesariana_heading-wrapper')
//         $('sesariana_heading-wrapper').style.display = 'none';
      if($('sesariana_headinggrp'))
        $('sesariana_headinggrp').style.display = 'none';
//       if('sesariana_mainmenu-wrapper')
//         $('sesariana_mainmenu-wrapper').style.display = 'none';
      if($('sesariana_mainmenugrp'))
        $('sesariana_mainmenugrp').style.display = 'none';
//       if('sesariana_tab-wrapper')
//         $('sesariana_tab-wrapper').style.display = 'none';
      if($('sesariana_tabgrp'))
        $('sesariana_tabgrp').style.display = 'none';
        
      if($('sesariana_googlebodygrp'))
        $('sesariana_googlebodygrp').style.display = 'block';
      if($('sesariana_googleheadinggrp'))
        $('sesariana_googleheadinggrp').style.display = 'block';
      if($('sesariana_googlemainmenugrp'))
        $('sesariana_googlemainmenugrp').style.display = 'block';
      if($('sesariana_googletabgrp'))
        $('sesariana_googletabgrp').style.display = 'block';
    } else {
//       if('sesariana_body-wrapper')
//         $('sesariana_body-wrapper').style.display = 'block';
      if($('sesariana_bodygrp'))
        $('sesariana_bodygrp').style.display = 'block';
//       if('sesariana_heading-wrapper')
//         $('sesariana_heading-wrapper').style.display = 'block';
      if($('sesariana_headinggrp'))
        $('sesariana_headinggrp').style.display = 'block';
//       if('sesariana_mainmenu-wrapper')
//         $('sesariana_mainmenu-wrapper').style.display = 'block';
      if($('sesariana_mainmenugrp'))
        $('sesariana_mainmenugrp').style.display = 'block';
//       if('sesariana_tab-wrapper')
//         $('sesariana_tab-wrapper').style.display = 'block';
      if($('sesariana_tabgrp'))
        $('sesariana_tabgrp').style.display = 'block';
        
      if($('sesariana_googlebodygrp'))
        $('sesariana_googlebodygrp').style.display = 'none';
      if($('sesariana_googleheadinggrp'))
        $('sesariana_googleheadinggrp').style.display = 'none';
      if($('sesariana_googlemainmenugrp'))
        $('sesariana_googlemainmenugrp').style.display = 'none';
      if($('sesariana_googletabgrp'))
        $('sesariana_googletabgrp').style.display = 'none';
        
        
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
