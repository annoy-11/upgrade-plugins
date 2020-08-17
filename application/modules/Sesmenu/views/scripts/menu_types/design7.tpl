<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design7.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $contentsData  = $apiTable->getMenuItemInfo($menuItem->module); ?>
<?php if(!count($contentsData)){ ?>
	<li class="no_content">
    <div class="sesbasic_tip">
        <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
        <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
    </div>
	</li>
<?php }else{ ?>
    <li class="sesmenu_submenu_item sesmenu_category_menu_item">
        <?php foreach($contentsData as $ItemInfo){ ?>
        <?php $contentsDataArray[] = $ItemInfo; ?>
        <?php } ?>
        <?php $dataArray = array_chunk($contentsDataArray,2); ?>
        <?php $defaultClass= "_left";  ?>
        <?php $counter=0; ?>
        <?php foreach($dataArray as $data){ ?>
            <ul class="<?php echo $defaultClass; ?>">
                <?php foreach($data as $ItemInfo){ ?>
                <?php 
                    if($counter == $menuItem->content_count) {
                    break;
                    }
                ?>
                <li>
                    <a href="<?php echo $ItemInfo->getHref(); ?>">
                    <div class="_img">
                    <?php if($moduleData['company']=='SES'){ ?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($ItemInfo->photo_id, '');
                        if($file)
                        $photo_id = $file->map(); ?>
                        <img src="<?php echo ($ItemInfo->photo_id != 0 ? $photo_id : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php } elseif(isset($ItemInfo->photo_id)) { ?> 
                        <img src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl() : 					'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                    <?php }else { ?>
                        <img src="application/modules/Sesmenu/externals/images/default-thumb.png" />
                    <?php } ?>
                    </div>
                    <div class="_img_overlay">
                        <?php if(isset($ItemInfo->category_id)) { ?>
                            <?php $category = Engine_Api::_()->getItem($moduleData['itemTableName'],$ItemInfo->category_id); ?>
                            <?php if(isset($category)) { ?>
                                    <?php if(isset($category['category_name'])) { ?>
                                        <span class="_cat">
                                        <?php echo $category['category_name'];?>
                                        </span>
                                    <?php } else if(isset($category['title'])) { ?>
                                    <span class="_cat">
                                        <?php echo $category['title'];?>
                                    <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <span class="_title">		
                            <?php echo $ItemInfo->getTitle(); ?>
                        </span>
                    </div>
                    </a>
                </li>
                <?php $counter++; } ?>
                <?php 
                    if($defaultClass == "_left")
                        $defaultClass = "_right";
                    else
                        $defaultClass = "_left";
                ?>
            </ul>
        <?php  } ?> 
    </li>
<?php } ?>
