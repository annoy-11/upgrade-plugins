<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmaterial/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesmaterial_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesmaterial_googlebody_fontfamily').value = 'Open Sans';
//       $('sesmaterial_googleheading_fontfamily').value = 'Open Sans';
//       if('sesmaterial_body-wrapper')
//         $('sesmaterial_body-wrapper').style.display = 'none';
      if($('sesmaterial_bodygrp'))
        $('sesmaterial_bodygrp').style.display = 'none';
//       if('sesmaterial_heading-wrapper')
//         $('sesmaterial_heading-wrapper').style.display = 'none';
      if($('sesmaterial_headinggrp'))
        $('sesmaterial_headinggrp').style.display = 'none';
//       if('sesmaterial_mainmenu-wrapper')
//         $('sesmaterial_mainmenu-wrapper').style.display = 'none';
      if($('sesmaterial_mainmenugrp'))
        $('sesmaterial_mainmenugrp').style.display = 'none';
//       if('sesmaterial_tab-wrapper')
//         $('sesmaterial_tab-wrapper').style.display = 'none';
      if($('sesmaterial_tabgrp'))
        $('sesmaterial_tabgrp').style.display = 'none';
        
      if($('sesmaterial_googlebodygrp'))
        $('sesmaterial_googlebodygrp').style.display = 'block';
      if($('sesmaterial_googleheadinggrp'))
        $('sesmaterial_googleheadinggrp').style.display = 'block';
      if($('sesmaterial_googlemainmenugrp'))
        $('sesmaterial_googlemainmenugrp').style.display = 'block';
      if($('sesmaterial_googletabgrp'))
        $('sesmaterial_googletabgrp').style.display = 'block';
    } else {
//       if('sesmaterial_body-wrapper')
//         $('sesmaterial_body-wrapper').style.display = 'block';
      if($('sesmaterial_bodygrp'))
        $('sesmaterial_bodygrp').style.display = 'block';
//       if('sesmaterial_heading-wrapper')
//         $('sesmaterial_heading-wrapper').style.display = 'block';
      if($('sesmaterial_headinggrp'))
        $('sesmaterial_headinggrp').style.display = 'block';
//       if('sesmaterial_mainmenu-wrapper')
//         $('sesmaterial_mainmenu-wrapper').style.display = 'block';
      if($('sesmaterial_mainmenugrp'))
        $('sesmaterial_mainmenugrp').style.display = 'block';
//       if('sesmaterial_tab-wrapper')
//         $('sesmaterial_tab-wrapper').style.display = 'block';
      if($('sesmaterial_tabgrp'))
        $('sesmaterial_tabgrp').style.display = 'block';
        
      if($('sesmaterial_googlebodygrp'))
        $('sesmaterial_googlebodygrp').style.display = 'none';
      if($('sesmaterial_googleheadinggrp'))
        $('sesmaterial_googleheadinggrp').style.display = 'none';
      if($('sesmaterial_googlemainmenugrp'))
        $('sesmaterial_googlemainmenugrp').style.display = 'none';
      if($('sesmaterial_googletabgrp'))
        $('sesmaterial_googletabgrp').style.display = 'none';
        
        
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
