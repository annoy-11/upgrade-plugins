<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesfooter/views/scripts/dismiss_message.tpl';?>
<div class='clear sesfooter_admin_form sesfooter_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {

      if($('sesfooter_headinggrp'))
        $('sesfooter_headinggrp').style.display = 'none';

      if($('sesfooter_textgrp'))
        $('sesfooter_textgrp').style.display = 'none';
        

      if($('sesfooter_googleheadinggrp'))
        $('sesfooter_googleheadinggrp').style.display = 'block';

      if($('sesfooter_googletextgrp'))
        $('sesfooter_googletextgrp').style.display = 'block';
    } else {

      if($('sesfooter_headinggrp'))
        $('sesfooter_headinggrp').style.display = 'block';

      if($('sesfooter_textgrp'))
        $('sesfooter_textgrp').style.display = 'block';

      if($('sesfooter_googleheadinggrp'))
        $('sesfooter_googleheadinggrp').style.display = 'none';

      if($('sesfooter_googletextgrp'))
        $('sesfooter_googletextgrp').style.display = 'none';
        
        
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