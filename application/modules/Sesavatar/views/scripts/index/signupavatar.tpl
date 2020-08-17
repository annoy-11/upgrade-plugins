<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar	
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: signupavatar.tpl  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php //echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesavatar.signup.photo', 0);die; ?>

<script>
  <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesavatar.signup.photo', 0) == 1 ) { ?>
    
    window.addEvent('domready',function() { alert('121');
      if($('done'))
        $('done').style.display = 'none';
    });
    
    function showAvatarButton() { 
      if($('done'))
        $('done').style.display = 'block';
    }
    
  <?php } ?>
</script>
<?php echo $this->form->render($this); ?>

