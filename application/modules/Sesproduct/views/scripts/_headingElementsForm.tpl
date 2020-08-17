<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _headingElementsForm.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $accordian = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.create.accordian', 1); ?>

<?php if($accordian){ ?>
<?php if ($this->closediv) : ?>
  </div>
<?php endif; ?>
  <?php if ($this->openDiv) { ?>
  <h4 id="<?php echo $this->id; ?>" onclick="hideShow(this)" class="sesbasic_lbg">
    <div class="" style="float:right;" id="img_<?php echo $this->id; ?>">
      <img src="<?php echo $this->layout()->staticBaseUrl ?>application/modules/Sesproduct/externals/images/<?php echo !empty($this->firstDiv) ? 'downarrow' : 'leftarrow'; ?>.png" />
    </div>
    <?php echo $this->heading; ?>
  </h4>
  <div class="content_<?php echo $this->id ?> sesproduct_cnt" style="display:<?php echo !empty($this->firstDiv) ? 'block' : 'none;'; ?>">
<?php } ?>

<?php }else{ ?>
  <h4>
    <?php echo $this->heading; ?>
  </h4>
<?php } ?>
