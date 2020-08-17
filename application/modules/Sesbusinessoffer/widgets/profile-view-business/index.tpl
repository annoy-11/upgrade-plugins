<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $offer = $item = $this->offer; 
$allParams = $this->allParams;
?>

<div class="sesbusinessoffer_view_business">
   <div class="sesbusinessoffer_view_top">
     <div class="_head">
       <h2>
          <?php echo $offer->getTitle() ?>
        </h2>
      </div>
      <div class="sesbusinessoffer_main">
          <?php if($this->showcouponcodeActive) { ?>
          <span class="sesbusinessoffer_coupon">
              <?php echo $offer->couponcode; ?>
          </span>
          <?php } ?>
          <?php if($this->offerlinkActive) { ?>
            <span class="sesbusinessoffer_link">
              <a href="<?php echo $offer->offerlink; ?>"><?php echo $this->translate("Click Here"); ?><i class="fa fa-long-arrow-right"></i></a>
            </span>
          <?php } ?>
		 </div>
     </div>
  <div class="sesbusinessoffer_view_img">
    <img src="<?php echo $offer->getPhotoUrl(); ?>" />
    <!-- Labels -->
     <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataLabel.tpl';?>
      <?php if($this->offertypevalueActive && !empty($item->offertypevalue)) { ?>
          <span class="sesbusinessoffer_type">
            <?php if($item->offertype == 1) { ?>
              <?php echo $item->offertypevalue . '%'; ?> 
            <?php } elseif($item->offertype == 2) { ?>
              <?php echo $this->translate("Fixed %s", $item->offertypevalue); ?>
            <?php } ?>
          </span>
        <?php } ?>
  </div>
   <ul>
    <li>
     <div class="sesbusinessoffer_view_stats sesbasic_text_light">
			<span class="_owner sesbasic_text_light">
          <?php if(isset($this->byActive)) { ?>
            <span>
              <?php echo $this->translate('<i class="fa fa-user"></i>');
                $itemOwner  = Engine_Api::_()->getItem('user',$item->owner_id); ?>
              <?php echo $this->htmlLink($itemOwner->getHref(), $itemOwner->getTitle(), array('class' => 'thumbs_author')) ?>
            </span>
          <?php }?>
          <?php if($this->businessnameActive) { ?>
            <?php $business = Engine_Api::_()->getItem('businesses', $item->parent_id); ?>
            <span> 
                <i class="fa fa-file-text"></i> <a href="<?php echo $business->getHref(); ?>"><?php echo $business->getTitle(); ?></a>
            </span>
          <?php } ?>
          <?php if($this->posteddateActive) { ?>
            <span>
              <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?>
            </span>
          <?php } ?>
        </span>
        <?php if($this->claimedcountActive || $this->remainingcountActive || $this->getofferlinkActive) { ?>
          <div class="sesbusinessoffer_claim">
            <?php if($this->claimedcountActive) { ?>
              <span class="sesbasic_text_light"><?php echo $this->translate("Claimed: "); ?><span class="_num"><?php echo $item->claimed_count; ?></span></span>
            <?php } ?>
            <?php if($this->remainingcountActive) { ?>
              <span class="sesbasic_text_light"><?php echo $this->translate("Remaining: "); ?><span class="_num"><?php echo $item->totalquantity - $item->claimed_count; ?> </span></span>
            <?php } ?>
            <?php if($this->getofferlinkActive && $item->claimed_count < $item->totalquantity) { ?>
              <span class="sesbusinessoffer_get_offer"><a class="smoothbox" href="<?php echo $this->url(array('controller' => 'index', 'action' => 'getoffer','parent_id' => $item->parent_id, 'businessoffer_id' => $item->getIdentity()), 'sesbusinessoffer_general', true); ?>"><?php echo $this->translate(" Get Offer"); ?></a></span>
            <?php } ?>
          </div>
        <?php } ?>
         <!-- Stats -->
        <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataStatics.tpl';?>
    </div>
    <?php if($this->descriptionActive) { ?>
    <div class="sesbusinessoffer_entrylist_entry_body rich_content_body">
      <?php echo $offer->body ?>
    </div>
    <?php } ?>
    <div class="sesbusinessoffer_view_footer">
    <!-- Share Buttons -->
    <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataSharing.tpl';?>
    </div>
  </li>
</ul>
</div>
