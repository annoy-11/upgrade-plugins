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
    <?php  if($this->sptparam == 'main') : ?>
    <h3><?php echo $this->translate("Delete Specialty?") ?></h3>
    <p><?php echo $this->translate("Are you sure that you want to delete this specialty. It will not be recoverable after being deleted.") ?></p>
    <?php elseif($this->sptparam == 'sub') : ?>
    <h3><?php echo $this->translate("Delete 2nd-level Specialty?") ?></h3>
    <p><?php echo $this->translate("Are you sure that you want to delete this 2nd-level specialty. It will not be recoverable after being deleted.") ?></p>
    <?php elseif($this->sptparam == 'subsub') : ?>
    <h3><?php echo $this->translate("Delete 3rd-level specialty?") ?></h3>
    <p><?php echo $this->translate("Are you sure that you want to delete this 3rd-level specialty. It will not be recoverable after being deleted.") ?></p>
    <?php endif; ?>    
    <br />
    <p>
    <?php  if(count($this->subspecialty) > 0) : ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("A specialty which has its 2nd-level categories can not be deleted. So, first delete its 2nd-level categories, then try to delete this specialty.") ?>
      </span>
    </div>
    <button href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Ok") ?></button>
    <?php elseif(count($this->subsubspecialty) > 0) : ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("A specialty which has its 3rd-level categories can not be deleted. So, first delete its 3rd-level categories, then try to delete this specialty.") ?>
      </span>
    </div>
    <button href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Ok") ?></button>
    <?php else: ?>
      <input type="hidden" name="confirm" value="<?php echo $this->id ?>"/>
      <button type='submit'><?php echo $this->translate("Delete") ?></button>
      <?php echo $this->translate(" or ") ?>
      <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Cancel") ?></a>
    <?php endif; ?>     
    </p>
  </div>
</form>