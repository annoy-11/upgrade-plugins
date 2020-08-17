<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<form method="post" class="global_form_popup">
  <div>    
    <?php  if($this->cataccordion == 'maincat') : ?>
      <h3><?php echo $this->translate("Delete Menu Item?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this menu item. It is not recoverable after being deleted.") ?></p>
    <?php elseif($this->cataccordion == 'sub') : ?>
      <h3><?php echo $this->translate("Delete Sub Level Menu Item?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this sub level menu item. It is not recoverable after being deleted.") ?></p>
    <?php elseif($this->cataccordion == 'subsub') : ?>
      <h3><?php echo $this->translate("Delete 3rd Level Menu Item?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this 3rd level menu item. It is not recoverable after being deleted.") ?></p>
    <?php else:?>
      <h3><?php echo $this->translate("Delete Menu?") ?></h3>
      <p><?php echo $this->translate("Are you sure that you want to delete this menu. It is not recoverable after being deleted.") ?></p>
    <?php endif; ?>    
    <br />
    <p>
      <?php  if(count($this->subaccordion) > 0) : ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("You have created Sub Accordion, so first delete subaccordion then delete main accordion.") ?>
      </span>
    </div>
    <?php elseif(count($this->subsubaccordion) > 0) : ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("You have created 3rd Accordion, so first delete 3rd accordion then delete subaccordion.") ?>
      </span>
    </div>
    <?php else: ?>
    <input type="hidden" name="confirm" value="<?php echo $this->id ?>"/>
    <button type='submit'><?php echo $this->translate("Delete") ?></button>
    <?php echo $this->translate(" or ") ?> 
    <?php endif; ?>
    <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Cancel") ?></a>
    </p>
  </div>
</form>