<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-suvmenu-data.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu'); ?>
<?php  if(!count($this->subcategory)) { ?>
	<li class="no_content">
        <div class="sesbasic_tip">
            <img src="<?php echo $apiTable->contentNoFoundImg($this->menuItem) ; ?>">
            <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($this->menuItem) ; ?></span>
        </div>
	</li>
<?php }else { ?>
	<?php foreach ($this->subcategory as $sub_category): ?>
	  <li>
		<a href="<?php echo $sub_category->getHref(); ?>"><?php echo $sub_category->category_name; ?></a>
		<ul>
		<?php //SubSubcategory Work
    if($moduleData['subCat']=='yes'){
		  $subsubcategory = Engine_Api::_()->getDbtable('categories', $this->module_name)->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $sub_category->category_id));  
    }
		?>
		<?php foreach ($subsubcategory as $subsub_category):  ?>
		  <li><a href="<?php echo $subsub_category->getHref(); ?>"><?php echo $subsub_category->category_name; ?></a></li>
		  
		<?php endforeach; ?>
		</ul>
	  </li>
	<?php endforeach; ?>
<?php } ?>
