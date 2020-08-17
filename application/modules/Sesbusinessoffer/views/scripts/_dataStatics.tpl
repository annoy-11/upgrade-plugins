<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataStatics.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(isset($this->likecountActive) || isset($this->commentcountActive) || isset($this->favouritecountActive) || isset($this->viewcountActive)){ ?>
<div class="sesbusinessoffer_profile_footer">
  <p class="sesbusinessoffer_profile_labels">
    <span>
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer.enable.like', '1') && isset($this->likecountActive) && isset($item->like_count)) { ?>
        <span  title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count))?>">
          <i class="fa fa-thumbs-up"></i>
          <?php echo $item->like_count;?>
        </span>
      <?php } ?>
      <?php if(isset($this->commentcountActive)) { ?>
        <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>">
          <i class="fa fa-comment"></i>
          <?php echo $item->comment_count;?>
        </span>
      <?php } ?>
      <?php if(isset($this->viewcountActive)) { ?>
        <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>">
          <i class="fa fa-eye"></i>
          <?php echo $item->view_count;?>
        </span>
      <?php } ?>
      <?php if(isset($this->favouritecountActive)):?>
        <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>">
          <i class="fa fa-heart"></i>
          <?php echo $item->favourite_count;?>
        </span>
      <?php endif;?>
      <?php if(isset($this->followcountActive) && isset($item->follow_count)):?>
        <span title="<?php echo $this->translate(array('%s follower', '%s followers', $item->follow_count), $this->locale()->toNumber($item->follow_count))?>">
          <i class="fa fa-check"></i>
          <?php echo $item->follow_count;?>
        </span>
      <?php endif;?>
    </span>
    <span>
      <?php if(isset($this->totalquantitycountActive)) { ?>
        <span title="<?php echo $this->translate(array('%s total quantity', '%s total quantity', $item->totalquantity), $this->locale()->toNumber($item->totalquantity))?>">
          Quantity: 
          <?php echo $item->totalquantity;?>
        </span>
      <?php } ?>
    </span>
  </p>
  </div>
<?php } ?>
