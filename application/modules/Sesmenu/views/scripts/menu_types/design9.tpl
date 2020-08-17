<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design9.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
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
<?php }else{ $counter =0; ?>
<?php foreach($contentsData as $ItemInfo):?>
<?php       
    if($counter == $menuItem->categories_count) {
        break;
    }
?>
  <li class="sesmenu_submenu_item sesmenu_category_menu_item">
    <a href="<?php echo $ItemInfo->getHref();?>">
        <?php if($moduleData['company']=='SES'){ ?>
            <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($ItemInfo->photo_id, '');
            if($file)
            $photo_id = $file->map(); ?>
            <img class="_img" src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl() : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
        <?php } elseif(isset($ItemInfo->photo_id)) { ?> 
            <img class="_img" src="<?php echo ($ItemInfo->photo_id != 0 ? $ItemInfo->getPhotoUrl() : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
        <?php }else { ?>
            <img  class="_img"  src="application/modules/Sesmenu/externals/images/default-thumb.png" />
        <?php } ?>
      <div class="_cont">
        <span class="_title"><?php echo $ItemInfo->getTitle();?></span>
        <div class="_counts">
            <?php if(isset($ItemInfo->like_count)){?>
                <span class="sesbasic_text_light"><i class="fa fa-thumbs-up"></i><?php echo $ItemInfo->like_count;?></span>
            <?php } if(isset($ItemInfo->comment_count)){?>
                <span class="sesbasic_text_light"><i class="fa fa-comment"></i><?php echo $ItemInfo->comment_count;?></span>
            <?php } if(isset($ItemInfo->view_count)){?>
                <span class="sesbasic_text_light"><i class="fa fa-eye"></i><?php echo $ItemInfo->view_count;?></span>
            <?php } if(isset($ItemInfo->favourite_count)){?>
                <span class="sesbasic_text_light"><i class="fa fa-heart"></i> <?php echo $ItemInfo->favourite_count; ?></span>
            <?php } ?>
        </div>
      </div>
    </a>
  </li>
<?php $counter++; endforeach;?>
<?php } ?>
