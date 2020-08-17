<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-content-data.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!-- For Design 4 -->
<?php $contentsData = $this->contentsData; ?>
 <?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu'); ?>
<?php $moduleData = $apiTable->getModuleData($this->menuItem->module); ?>

<?php if(!empty($this->isAjax) && empty($this->tabdata)){?>
    <?php if(count($contentsData)): $counter = 0; ?>
        <?php foreach($contentsData as $ItemInfo): ?>
            <?php if($this->menuItem->content_count == $counter ) { ?>
            <?php break; } ?>
            <li>
                <a href="<?php echo $ItemInfo->getHref(); ?>">
                    <div class="_img">
                        <?php if($moduleData['company']=='SES'){ ?>
                        <?php $photo_id = isset($ItemInfo->photo_id) ? $ItemInfo->photo_id : $ItemInfo->file_id; ?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo_id, '');
                        if($file)
                      //  $photo_id = $file->map(); ?>
                        <img src="<?php echo (isset($photo_id) != 0 ? $ItemInfo->getPhotoUrl() : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                        <?php } elseif(isset($photo_id)) { ?> 
                        <img src="<?php echo (isset($photo_id) != 0 ? $ItemInfo->getPhotoUrl() : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                        <?php }else { ?>
                        <img src="application/modules/Sesmenu/externals/images/default-thumb.png" />
                        <?php } ?>
                    </div>
                    <span class="_title">
                        <?php if(isset($ItemInfo['category_name'])) { ?>
                        <?php echo $ItemInfo['category_name'];?>
                        <?php } else if(isset($ItemInfo['title'])) { ?>
                        <?php echo $ItemInfo['title'];?>
                        <?php } ?>
                    </span>
                </a>
            </li>
        <?php  $counter++; endforeach; ?>
    <?php else :?>
    <li class="no_content">
        <div class="sesbasic_tip">
            <img src="<?php echo $apiTable->contentNoFoundImg($this->menuItem) ; ?>">
            <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($this->menuItem) ; ?></span>

        </div>
    </li>
    <?php endif; ?>
<?php } ?>

<!-- For Design 10 --> 
<?php if(empty($this->isAjax) && !empty($this->tabdata)){ ?>
    <?php if(count($contentsData) > 0 ): $counter = 0;   ?>
        <?php foreach($contentsData as $ItemInfo): ?> 
        <?php if($this->menuItem->content_count == $counter ) { ?>
            <?php break; } ?>
            <li id="<?php echo ($this->tab_id != null ? $this->tab_id : $this->category_id); ?>li">
                <div class="offer-img">
                    <a href="<?php echo $ItemInfo->getHref(); ?>">
                        <?php if($moduleData['company']=='SES'){ ?>
                             <?php $photo_id = isset($ItemInfo->photo_id) ? $ItemInfo->photo_id : $ItemInfo->file_id; ?>
                            <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo_id, '');
                            if($file)
                          //  $photo_id = $file->map(); ?>
                            <img src="<?php echo ($photo_id != 0 ? $ItemInfo->getPhotoUrl() : 'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                        <?php } elseif(isset($photo_id)) { ?> 
                            <img src="<?php echo ($photo_id != 0 ? $ItemInfo->getPhotoUrl() :'application/modules/Sesmenu/externals/images/default-thumb.png'); ?>" />
                        <?php }else { ?>
                            <img src="application/modules/Sesmenu/externals/images/default-thumb.png" />
                        <?php } ?>
                    </a>
                </div>
                <ul class="sesmenu_tabs_submenu">
                  <li>
                  	<a href="<?php echo $ItemInfo->getHref(); ?>"><?php echo $ItemInfo->getTitle(); ?></a>
                  </li>
                </ul>
            </li>	
        <?php $counter++; endforeach; ?>  
    <?php else :?>
      <li class="no_content">
          <div class="sesbasic_tip">
              <img src="<?php echo $apiTable->contentNoFoundImg($this->menuItem) ; ?>">
              <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($this->menuItem) ; ?></span>
          </div>
      </li>
    <?php endif; ?> 
<?php } ?>
