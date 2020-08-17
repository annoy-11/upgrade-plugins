<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-category-data.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu'); ?>
<?php $subcategory = $this->subcategory;?>
    <?php if(count($subcategory)): $counter = 0;   ?>
        <?php foreach($subcategory as $ItemInfo): ?> 
        <?php if($this->menuItem->content_count == $counter ) { ?>
            <?php break; } ?>
            <li id="<?php echo ($this->tab_id != null ? $this->tab_id : $this->category_id); ?>li">
                <div class="offer-img">
                    <a href="<?php echo $ItemInfo->getHref(); ?>">
                        <?php if($this->moduleData['company']=='SES'){ ?>
                            <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($ItemInfo->thumbnail, '');
                            if($file)
                            $photo = $file->map(); ?>
                            <img src="<?php echo ($photo != '' ? $photo : 'application/modules/Sesmenu/externals/images/default-category-thumb.png'); ?>" />
                        <?php } else { ?>
                            <img src="application/modules/Sesmenu/externals/images/default-category-thumb.png" />
                        <?php } ?>
                    </a>
                </div>
                <ul class="sesmenu_tabs_submenu">
                    <li>
                        <a href="<?php echo $ItemInfo->getHref(); ?>">	
                            <?php if(isset($ItemInfo['category_name'])) { ?>
                                <?php echo $ItemInfo['category_name'];?>
                            <?php } else if(isset($ItemInfo['title'])) { ?>
                                <?php echo $ItemInfo['title'];?>
                            <?php } ?>
                        </a>
                        <ul> 
                        <?php if(count($ItemInfo->category_id)) { ?>
                          <?php //SubSubcategory Work
                                $subsubcategory = Engine_Api::_()->getDbtable('categories', $this->menuItem->module)->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $ItemInfo->category_id));  
                            ?>
                            <?php if(count($subsubcategory)) { ?>
                                <?php $subCategorycount =0 ;?>
                                <?php foreach ($subsubcategory as $sub_category): ?>
                                    <?php if($this->menuItem->show_cat == $subCategorycount) { ?>
                                    <?php break; } ?>
                                    <li>
                                        <a href="<?php echo $sub_category->getHref(); ?>" class="sesbasic_text_light">
                                            <?php if(isset($sub_category['category_name'])) { ?>
                                                <?php echo $sub_category['category_name'];?>
                                            <?php } else if(isset($sub_category['title'])) { ?>
                                                <?php echo $sub_category['title'];?>
                                            <?php } ?>
                                        </a>
                                    </li>
                                <?php $subCategorycount++; endforeach; ?>
                            <?php } ?>
                        </ul>
                    <?php } ?>
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
