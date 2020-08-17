<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design8.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<li class="sesmenu_submenu_item sesmenu_category_menu_item">
   <div class="sesmenu_three_items">
     <h4><?php echo $menuItem->sc1_title; ?></h4>
     <?php if($moduleData['company']=='SES') { ?>
        <?php $contentsDatasc1 = Engine_Api::_()->getApi('core','sesmenu')->getData(array('order' => $menuItem->sc1_order, 'limit' => $menuItem->sc1_count ,'fetchAll'=>true,'module'=> $menuItem->module));?>
	  <?php } ?>
      <ul>
		<?php $counter = 0 ?>
		<?php foreach($contentsDatasc1 as $ItemInfo) :?>
        <?php if($counter == $menuItem->sc1_count) {?>
        <?php break; } ?>
        <li>
            <a href="<?php echo $ItemInfo->getHref(); ?>">
                <div class="_img">
                    <?php if($moduleData['company']=='SES'){ ?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($ItemInfo->photo_id, '');
                        if($file)
                        $photo_id = $file->map(); ?>
                        <img   src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl('thumb.thumb') : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php } elseif(isset($ItemInfo->photo_id)) { ?> 
                        <img  src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl('thumb.thumb') : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php }else { ?>
                        <img  src="application/modules/Sesmenu/externals/images/default-thumb.png" />
                    <?php } ?>
                    </div>
                    <div class="_cont">
                        <span class="_title"><?php echo $ItemInfo->getTitle(); ?></span>
                    <?php $category = Engine_Api::_()->getItem($moduleData['itemTableName'],$ItemInfo->category_id); ?>
                    <?php if(!empty($category)) { ?>
                        <span class="_cat sesbasic_text_light">		
                            <?php echo $category->getTitle();?>
                        </span>
                    <?php } ?>
                    </div>
            </a>           
         </li>
		<?php endforeach; ?>
      </ul>
   </div>
    <div class="sesmenu_items_carousel">
       <h4><?php echo $menuItem->sc2_title; ?></h4>
        <?php if($moduleData['company']=='SES') { ?>
            <?php $contentsDatasc2 = Engine_Api::_()->getApi('core','sesmenu')->getData(array('order' => $menuItem->sc2_order, 'limit' => $menuItem->sc2_count,'fetchAll'=>true,'module'=> $menuItem->module));?>
	   <?php } ?>
       <div class="sesmenu_items_carousel_inner owl-carousel">
       <?php foreach($contentsDatasc2 as $ItemInfo) :?>
           <div class="item">
              <a href="<?php echo $ItemInfo->getHref();?>">
                    <?php if($moduleData['company']=='SES'){ ?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($ItemInfo->photo_id, '');
                        if($file)
                        $photo_id = $file->map(); ?>
                        <img src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl('thumb.thumb') : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php } elseif(isset($ItemInfo->photo_id)) { ?> 
                        <img src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl('thumb.thumb') : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php }else { ?>
                        <img class="_img" src="application/modules/Sesmenu/externals/images/default-thumb.png" />
                    <?php } ?>
              </a>
           </div>
        <?php endforeach; ?>
       </div>
    </div>
    <?php $ofthedayId = Engine_Api::_()->getDbTable($moduleData['dbtable'],$menuItem->module)->getOfTheDayResults(); ?>
    <?php if($ofthedayId && $menuItem->module == 'sesproduct') { ?>
    <?php  $item = Engine_Api::_()->getItem($moduleData['itemType'],$ofthedayId);?>
    <?php } else if($ofthedayId) {  
        $item = $ofthedayId;
     } ?>
     <?php if(!empty($item)) { ?>
    <div class="sesmenu_otd_item">
        <h4><?php echo $menuItem->module == 'sesproduct' ? 'Product Of The Day' : 'Store Of The Day'; ?> </h4>
        <a href="<?php echo $item->getHref(); ?>">
          <div class="product_img">
             <img src="<?php echo $item->getPhotoUrl('thumb.thumb'); ?>"  />
          </div>
          <div class="product_cont">
             <span class="_title"><?php echo $item->getTitle(); ?></span>
             <?php if($menuItem->module == 'sesproduct') { ?>
                <?php  $store = Engine_Api::_()->getItem('stores',$item->store_id);?>
                 <span class="_manuf sesbasic_text_light"><?php echo $store->getOwner(); ?></span>
                <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?> 
                <?php include "application/modules/Sesproduct/views/scripts/_rating.tpl"; ?>
              <?php } else if ($menuItem->module == 'estore')  { $store = $item; ?>
                    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_priceLabel.tpl';?>
                    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';  ?>
              <?php  } ?>
          </div>
        </a>
    </div>
 <?php } ?>
	<?php if(!empty($menuItem->first_photo) || !empty($menuItem->second_photo)) { ?>
        <div class="sesmenu_offer_banner">
        <ul>
                <?php if(!empty($menuItem->first_photo)) { ?>
                    <li><a href="<?php echo $menuItem->photo1_link; ?>"><img src="<?php echo $menuItem->first_photo; ?>" /></a></li>
                <?php } if(!empty($menuItem-second_photo)) { ?>
                    <li><a href="<?php echo $menuItem->photo2_link; ?>"><img src="<?php echo $menuItem->second_photo; ?>" /></a></li>
                <?php } if(!empty($menuItem->third_photo)) { ?>
                    <li><a href="<?php echo $menuItem->photo3_link; ?>"><img src="<?php echo $menuItem->third_photo; ?>" /></a></li>
                <?php } ?>
        </ul>
    </div>
	<?php } ?>
	<?php if($menuItem->show_cat) { ?>
    <div class="sesmenu_categories_strip">
        <?php include APPLICATION_PATH .  '/application/modules/Sesmenu/views/scripts/category_strip.tpl'; ?>
    </div>
	<?php } ?>
</li>

