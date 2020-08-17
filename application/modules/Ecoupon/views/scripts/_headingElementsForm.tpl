<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _headingElementsForm.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $accordian = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.create.accordian', 1); ?>
<?php if($accordian){ ?>
<?php if ($this->closediv) : ?>
  </div>
<?php endif; ?>
  <?php if ($this->openDiv) { ?>
  <h4 id="<?php echo $this->id; ?>" onclick="hideShow(this)">
    <div class="" style="float:right;" id="img_<?php echo $this->id; ?>">
      <img src="<?php echo $this->layout()->staticBaseUrl ?>application/modules/Ecoupon/externals/images/<?php echo !empty($this->firstDiv) ? 'downarrow' : 'leftarrow'; ?>.png" />
    </div>
    <?php echo $this->heading; ?>
  </h4>
  <div class="content_<?php echo $this->id ?> ecoupon_cnt" style="display:<?php echo !empty($this->firstDiv) ? 'block' : 'none;'; ?>">
<?php } ?>
<?php }else{ ?>
  <h4>
    <?php echo $this->heading; ?>
  </h4>
<?php } ?>
