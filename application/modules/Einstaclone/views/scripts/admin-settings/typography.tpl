<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: typography.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php include APPLICATION_PATH .  '/application/modules/Einstaclone/views/scripts/dismiss_message.tpl';?>

<div class='clear einstaclone_admin_form sm_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
    if(value == 1) {
      if($('einstaclone_bodygrp'))
        $('einstaclone_bodygrp').style.display = 'none';
      if($('einstaclone_headinggrp'))
        $('einstaclone_headinggrp').style.display = 'none';
      if($('einstaclone_mainmenugrp'))
        $('einstaclone_mainmenugrp').style.display = 'none';
      if($('einstaclone_tabgrp'))
        $('einstaclone_tabgrp').style.display = 'none';
      if($('einstaclone_googlebodygrp'))
        $('einstaclone_googlebodygrp').style.display = 'block';
      if($('einstaclone_googleheadinggrp'))
        $('einstaclone_googleheadinggrp').style.display = 'block';
      if($('einstaclone_googlemainmenugrp'))
        $('einstaclone_googlemainmenugrp').style.display = 'block';
      if($('einstaclone_googletabgrp'))
        $('einstaclone_googletabgrp').style.display = 'block';
    } else {
      if($('einstaclone_bodygrp'))
        $('einstaclone_bodygrp').style.display = 'block';
      if($('einstaclone_headinggrp'))
        $('einstaclone_headinggrp').style.display = 'block';
      if($('einstaclone_mainmenugrp'))
        $('einstaclone_mainmenugrp').style.display = 'block';
      if($('einstaclone_tabgrp'))
        $('einstaclone_tabgrp').style.display = 'block';
      if($('einstaclone_googlebodygrp'))
        $('einstaclone_googlebodygrp').style.display = 'none';
      if($('einstaclone_googleheadinggrp'))
        $('einstaclone_googleheadinggrp').style.display = 'none';
      if($('einstaclone_googlemainmenugrp'))
        $('einstaclone_googlemainmenugrp').style.display = 'none';
      if($('einstaclone_googletabgrp'))
        $('einstaclone_googletabgrp').style.display = 'none';
    }
  }
</script>
