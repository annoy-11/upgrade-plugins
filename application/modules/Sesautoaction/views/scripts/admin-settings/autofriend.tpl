<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: autofriend.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
    en4.core.runonce.add(function(){
      chooseoptions('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.actionperform', 0); ?>');
    });
    
    function chooseoptions(value) {
      if(value == 1) {
        if($('name-wrapper'))
          $('name-wrapper').style.display = 'block';
        if($('sesautoaction_users-wrapper'))
          $('sesautoaction_users-wrapper').style.display = 'none';
      } else { 
        if($('sesautoaction_users-wrapper'))
          $('sesautoaction_users-wrapper').style.display = 'block';
        if($('name-wrapper'))
          $('name-wrapper').style.display = 'none';
      }
    }

</script>
