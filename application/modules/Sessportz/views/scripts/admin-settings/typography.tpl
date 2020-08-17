<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sessportz_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sessportz_googlebody_fontfamily').value = 'Open Sans';
//       $('sessportz_googleheading_fontfamily').value = 'Open Sans';
//       if('sessportz_body-wrapper')
//         $('sessportz_body-wrapper').style.display = 'none';
      if($('sessportz_bodygrp'))
        $('sessportz_bodygrp').style.display = 'none';
//       if('sessportz_heading-wrapper')
//         $('sessportz_heading-wrapper').style.display = 'none';
      if($('sessportz_headinggrp'))
        $('sessportz_headinggrp').style.display = 'none';
//       if('sessportz_mainmenu-wrapper')
//         $('sessportz_mainmenu-wrapper').style.display = 'none';
      if($('sessportz_mainmenugrp'))
        $('sessportz_mainmenugrp').style.display = 'none';
//       if('sessportz_tab-wrapper')
//         $('sessportz_tab-wrapper').style.display = 'none';
      if($('sessportz_tabgrp'))
        $('sessportz_tabgrp').style.display = 'none';
        
      if($('sessportz_googlebodygrp'))
        $('sessportz_googlebodygrp').style.display = 'block';
      if($('sessportz_googleheadinggrp'))
        $('sessportz_googleheadinggrp').style.display = 'block';
      if($('sessportz_googlemainmenugrp'))
        $('sessportz_googlemainmenugrp').style.display = 'block';
      if($('sessportz_googletabgrp'))
        $('sessportz_googletabgrp').style.display = 'block';
    } else {
//       if('sessportz_body-wrapper')
//         $('sessportz_body-wrapper').style.display = 'block';
      if($('sessportz_bodygrp'))
        $('sessportz_bodygrp').style.display = 'block';
//       if('sessportz_heading-wrapper')
//         $('sessportz_heading-wrapper').style.display = 'block';
      if($('sessportz_headinggrp'))
        $('sessportz_headinggrp').style.display = 'block';
//       if('sessportz_mainmenu-wrapper')
//         $('sessportz_mainmenu-wrapper').style.display = 'block';
      if($('sessportz_mainmenugrp'))
        $('sessportz_mainmenugrp').style.display = 'block';
//       if('sessportz_tab-wrapper')
//         $('sessportz_tab-wrapper').style.display = 'block';
      if($('sessportz_tabgrp'))
        $('sessportz_tabgrp').style.display = 'block';
        
      if($('sessportz_googlebodygrp'))
        $('sessportz_googlebodygrp').style.display = 'none';
      if($('sessportz_googleheadinggrp'))
        $('sessportz_googleheadinggrp').style.display = 'none';
      if($('sessportz_googlemainmenugrp'))
        $('sessportz_googlemainmenugrp').style.display = 'none';
      if($('sessportz_googletabgrp'))
        $('sessportz_googletabgrp').style.display = 'none';
        
        
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
