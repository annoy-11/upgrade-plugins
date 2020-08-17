<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="post" class="global_form_popup">
  <div>
    <?php if($this->type == 'school') { ?>
      <h3><?php echo $this->translate("Delete School?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this school. It will not be recoverable after being deleted.") ?></p>
    <?php } else if($this->type == 'degree') { ?>
      <h3><?php echo $this->translate("Delete Degree?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this degree. It will not be recoverable after being deleted.") ?></p>
    <?php } else if($this->type == 'study') { ?>
      <h3><?php echo $this->translate("Delete Field of Study?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this. It will not be recoverable after being deleted.") ?></p>
    <?php } else if($this->type == 'position') { ?>
      <h3><?php echo $this->translate("Delete Position?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this. It will not be recoverable after being deleted.") ?></p>
    <?php } else if($this->type == 'company') { ?>
      <h3><?php echo $this->translate("Delete Company?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this. It will not be recoverable after being deleted.") ?></p>
    <?php } else if($this->type == 'authority') { ?>
      <h3><?php echo $this->translate("Delete Authority?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this. It will not be recoverable after being deleted.") ?></p>
    <?php }  ?>
    <input type="hidden" name="confirm">
    <button type='submit'><?php echo $this->translate("Delete") ?></button>
    <?php echo $this->translate(" or ") ?>
    <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Cancel") ?></a>
  </div>
</form>