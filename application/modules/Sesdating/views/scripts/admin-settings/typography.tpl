<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating	
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesdating/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesdating_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdating.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesdating_googlebody_fontfamily').value = 'Open Sans';
//       $('sesdating_googleheading_fontfamily').value = 'Open Sans';
//       if('sesdating_body-wrapper')
//         $('sesdating_body-wrapper').style.display = 'none';
      if($('sesdating_bodygrp'))
        $('sesdating_bodygrp').style.display = 'none';
//       if('sesdating_heading-wrapper')
//         $('sesdating_heading-wrapper').style.display = 'none';
      if($('sesdating_headinggrp'))
        $('sesdating_headinggrp').style.display = 'none';
//       if('sesdating_mainmenu-wrapper')
//         $('sesdating_mainmenu-wrapper').style.display = 'none';
      if($('sesdating_mainmenugrp'))
        $('sesdating_mainmenugrp').style.display = 'none';
//       if('sesdating_tab-wrapper')
//         $('sesdating_tab-wrapper').style.display = 'none';
      if($('sesdating_tabgrp'))
        $('sesdating_tabgrp').style.display = 'none';
        
      if($('sesdating_googlebodygrp'))
        $('sesdating_googlebodygrp').style.display = 'block';
      if($('sesdating_googleheadinggrp'))
        $('sesdating_googleheadinggrp').style.display = 'block';
      if($('sesdating_googlemainmenugrp'))
        $('sesdating_googlemainmenugrp').style.display = 'block';
      if($('sesdating_googletabgrp'))
        $('sesdating_googletabgrp').style.display = 'block';
    } else {
//       if('sesdating_body-wrapper')
//         $('sesdating_body-wrapper').style.display = 'block';
      if($('sesdating_bodygrp'))
        $('sesdating_bodygrp').style.display = 'block';
//       if('sesdating_heading-wrapper')
//         $('sesdating_heading-wrapper').style.display = 'block';
      if($('sesdating_headinggrp'))
        $('sesdating_headinggrp').style.display = 'block';
//       if('sesdating_mainmenu-wrapper')
//         $('sesdating_mainmenu-wrapper').style.display = 'block';
      if($('sesdating_mainmenugrp'))
        $('sesdating_mainmenugrp').style.display = 'block';
//       if('sesdating_tab-wrapper')
//         $('sesdating_tab-wrapper').style.display = 'block';
      if($('sesdating_tabgrp'))
        $('sesdating_tabgrp').style.display = 'block';
        
      if($('sesdating_googlebodygrp'))
        $('sesdating_googlebodygrp').style.display = 'none';
      if($('sesdating_googleheadinggrp'))
        $('sesdating_googleheadinggrp').style.display = 'none';
      if($('sesdating_googlemainmenugrp'))
        $('sesdating_googlemainmenugrp').style.display = 'none';
      if($('sesdating_googletabgrp'))
        $('sesdating_googletabgrp').style.display = 'none';
        
        
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
