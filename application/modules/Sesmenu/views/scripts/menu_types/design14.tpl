<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design14.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();
      if($viewer->getIdentity())
        $level_id = $viewer->level_id;
      else
        $level_id = 5;
?>
<?php  $customData  =$apiTable->getCustomData($menu_id); ?>
	<?php if(!count($customData)) { ?>
	<li class="no_content">
        <div class="sesbasic_tip">
            <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
            <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
        </div>
	</li>
	<?php } else { $counter=0; ?>
<?php foreach($customData as $category):?>
	<?php if(!in_array($level_id,explode(",", $category->privacy)) && $category->privacy != null) { ?>
    <?php continue; } ?>
    <?php if($counter == $menuItem->categories_count) {
			 break;
			}
		?>
    <?php $manageSubLinks = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu')->getInfo(array('sublink' => $category->itemlink_id, 'admin' => 1)); ?>
    <li class="sesmenu_submenu_item sesmenu_category_menu_item">
        <a href="<?php echo $category->url; ?>">
            <?php if($menuItem->show_icon) { ?>
                <?php if(empty($category->icon_type) && !empty($category->file_id)): ?>
                <?php $photo = Engine_Api::_()->getItemTable('storage_file')->getFile($category->file_id, '');
                    if($photo) {
                    $photo = $photo->map();?>
                    <i class="sesbasic_text_light"><img src="<?php echo ($photo != '' ? $photo : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                <?php } else { ?>
                    <?php echo "---"; ?>
                <?php } ?>
                <?php elseif(empty($category->file_id) && !empty($category->icon_type)): ?>
                    <i class="fa <?php echo $category->font_icon; ?>"></i>
                <?php endif;?>
            <?php } ?>
                <?php echo $category->name;?>	
                <?php $manageSubLinks = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu')->getInfo(array('sublink' => $category->itemlink_id, 'admin' => 1)); ?>
            <?php if(count($manageSubLinks)>0) { ?>
                <span><i class="fa fa-angle-right"></i></span>
            <?php } ?>
        </a>
        <ul class="sesmenu_level_2 sesbasic_bg">
        <?php if($menuItem->show_cat !=0) { $submenucounter = 0;?>
            <?php $submenucounter = 0; ?>
            <?php foreach ($manageSubLinks as $sub_category): ?>
                <?php if(!in_array($level_id,explode(",", $sub_category->privacy)) && $sub_category->privacy != null) { ?>
                <?php continue; } ?>
                <?php if($menuItem->show_cat == $submenucounter) { ?>
                    <?php break; } ?>
                <li>
                    <a href="<?php echo $sub_category->url; ?>">
                    <?php if($menuItem->show_icon) { ?>
                            <?php if(empty($sub_category->icon_type) && !empty($sub_category->file_id)): ?>
                            <?php $photo = Engine_Api::_()->getItemTable('storage_file')->getFile($sub_category->file_id, '');
                            if($photo) {
                            $photo = $photo->map();?>
                            <i class="sesbasic_text_light"><img src="<?php echo ($photo!= '' ? $photo : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                            <?php } else { ?>
                                <?php echo "---"; ?>
                            <?php } ?>
                            <?php elseif(empty($sub_category->file_id) && !empty($sub_category->icon_type)): ?>
                                <i class="fa <?php echo $category->font_icon; ?>"></i>
                            <?php endif;?>
                        <?php } ?>
                        <?php echo $sub_category->name; ?>
                    </a>	
                    <ul class="sesmenu_level_3 sesbasic_bg">
                    </ul>
                </li>
            <?php $submenucounter++; endforeach; ?>
        <?php } ?>
        </ul>
    </li>
    <?php $counter++; endforeach; ?>
<?php } ?>
