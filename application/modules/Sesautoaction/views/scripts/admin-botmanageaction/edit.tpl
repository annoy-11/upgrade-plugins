<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'botmanageaction', 'action' => 'index'), "Back to Manage Bot Auto Actions", array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='settings sesbasic_admin_form sesautoaction_botmanageaction_create'>
  <?php echo $this->form->render($this); ?>
</div>
<script>

  en4.core.runonce.add(function(){      
    chooseoptions(<?php echo $this->item->actionperform; ?>);
  });

  function chooseoptions(value) {
    if(value == 1) {
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'block';
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'none';
    } else { 
      if($('member_levels-wrapper'))
        $('member_levels-wrapper').style.display = 'block';
      if($('name-wrapper'))
        $('name-wrapper').style.display = 'none';
    }
  }
</script>
