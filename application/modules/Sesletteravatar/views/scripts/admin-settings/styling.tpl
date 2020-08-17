<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesletteravatar/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $imagbgcolor = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.imagbgcolor', 1);?>
<script type="application/javascript">

  window.addEvent('domready',function() {
    showHide('<?php echo $imagbgcolor;?>');
  });

  function showHide(value) {
  
    if(value == 1) {
      $('sesletteravatar_imagebackgroundcolor-wrapper').style.display = 'block';
    } else {
      $('sesletteravatar_imagebackgroundcolor-wrapper').style.display = 'none';
    }
  
  }
</script>