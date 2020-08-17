<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Seslinkedin/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sm_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sm_googlebody_fontfamily').value = 'Open Sans';
//       $('sm_googleheading_fontfamily').value = 'Open Sans';
//       if('sm_body-wrapper')
//         $('sm_body-wrapper').style.display = 'none';
      if($('seslinkedin_bodygrp'))
        $('seslinkedin_bodygrp').style.display = 'none';
//       if('seslinkedin_heading-wrapper')
//         $('seslinkedin_heading-wrapper').style.display = 'none';
      if($('seslinkedin_headinggrp'))
        $('seslinkedin_headinggrp').style.display = 'none';
//       if('seslinkedin_mainmenu-wrapper')
//         $('seslinkedin_mainmenu-wrapper').style.display = 'none';
      if($('seslinkedin_mainmenugrp'))
        $('seslinkedin_mainmenugrp').style.display = 'none';
//       if('seslinkedin_tab-wrapper')
//         $('seslinkedin_tab-wrapper').style.display = 'none';
      if($('seslinkedin_tabgrp'))
        $('seslinkedin_tabgrp').style.display = 'none';
        
      if($('seslinkedin_googlebodygrp'))
        $('seslinkedin_googlebodygrp').style.display = 'block';
      if($('seslinkedin_googleheadinggrp'))
        $('seslinkedin_googleheadinggrp').style.display = 'block';
      if($('seslinkedin_googlemainmenugrp'))
        $('seslinkedin_googlemainmenugrp').style.display = 'block';
      if($('seslinkedin_googletabgrp'))
        $('seslinkedin_googletabgrp').style.display = 'block';
    } else {
//       if('seslinkedin_body-wrapper')
//         $('seslinkedin_body-wrapper').style.display = 'block';
      if($('seslinkedin_bodygrp'))
        $('seslinkedin_bodygrp').style.display = 'block';
//       if('seslinkedin_heading-wrapper')
//         $('seslinkedin_heading-wrapper').style.display = 'block';
      if($('seslinkedin_headinggrp'))
        $('seslinkedin_headinggrp').style.display = 'block';
//       if('seslinkedin_mainmenu-wrapper')
//         $('seslinkedin_mainmenu-wrapper').style.display = 'block';
      if($('seslinkedin_mainmenugrp'))
        $('seslinkedin_mainmenugrp').style.display = 'block';
//       if('seslinkedin_tab-wrapper')
//         $('seslinkedin_tab-wrapper').style.display = 'block';
      if($('seslinkedin_tabgrp'))
        $('seslinkedin_tabgrp').style.display = 'block';
        
      if($('seslinkedin_googlebodygrp'))
        $('seslinkedin_googlebodygrp').style.display = 'none';
      if($('seslinkedin_googleheadinggrp'))
        $('seslinkedin_googleheadinggrp').style.display = 'none';
      if($('seslinkedin_googlemainmenugrp'))
        $('seslinkedin_googlemainmenugrp').style.display = 'none';
      if($('seslinkedin_googletabgrp'))
        $('seslinkedin_googletabgrp').style.display = 'none';
        
        
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
