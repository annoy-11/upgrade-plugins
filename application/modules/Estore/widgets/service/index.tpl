<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<div class="estore_profile_services_container sesbasic_bxs">
  <?php if(count($this->paginator) > 0): ?>
  <div class="estore_profile_services_listing">
    <?php foreach( $this->paginator as $item ): ?>
      <div class="_services sesbasic_bg sesbasic_clearfix">
       <?php if(isset($this->photoActive)): ?>
            <div class="_thumb">
                <?php echo $this->itemPhoto($item, 'thumb.profile', $item->getTitle()); ?>
            </div>
        <?php endif; ?>
        <div class="_cont">
        <?php if(isset($this->titleActive)): ?>
        	<div class='_title sesbasic_clearfix'>
          	<?php echo $item->title;?>
          </div>
          <?php endif; ?>
          <div class="_pd sesbasic_text_light">
            <?php if($item->duration && $item->duration_type): ?>
            	<span><?php echo $item->duration . ' ' . $item->duration_type; ?> </span>
            <?php endif; ?>
            <?php if($item->duration && $item->duration_type && $item->price) { ?><span>&middot;</span><?php } ?>  
           	<?php if($item->price) { ?>
                <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($item->price);?></span>
            <?php } ?>
          </div>
          <?php if($item->description && isset($this->descriptionActive)): ?>
          	<div class='_des'><?php echo $this->translate($item->description); ?> </div>
          <?php endif; ?>
        </div>  
      </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  	<div class="tip"> <span> <?php echo $this->translate("Sorry, no results matching your search criteria were found."); ?> </span> </div>
  <?php endif; ?>
</div>
