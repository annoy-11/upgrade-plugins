<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Seslike/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $userlike = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslike.userlike', 0);?>
<script>

  window.addEvent('domready',function() {
    userlike('<?php echo $userlike;?>');
  });
  
  function userlike(value) {
    if(value == 1) {
      document.getElementById('seslike_bydefaultuserlike-wrapper').style.display = 'block';
    } else {
      document.getElementById('seslike_bydefaultuserlike-wrapper').style.display = 'none';
    }
  }
</script>
