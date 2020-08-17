<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $randonNumber = $this->identity; ?>
<ul class="sesbasic_sidebar_block sescf_sidebar_categroies_list">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <?php $subcategory = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getModuleSubcategory(array('column_name' => "*", 'category_id' => $item->category_id, 'countCrowdfundings' => true)); ?>
      <?php if(counT($subcategory) > 0): ?>
        <a id="sescrowdfunding_toggle_<?php echo $item->category_id ?>" class="cattoggel cattoggelright" href="javascript:void(0);" onclick="showCategory('<?php echo $item->getIdentity()  ?>')"></a>
      <?php endif; ?>
      <a class="catlabel' ?>" href="<?php echo $item->getHref(); ?>">
      <?php if($item->cat_icon != '' && !is_null($item->cat_icon)): $icon = $this->storage->get($item->cat_icon, ''); if($icon) { $icon = $icon->getPhotoUrl(); ?><img src="<?php echo $icon; ?>" /><?php } else { ?><img src="application/modules/Sescrowdfunding/externals/images/category-icon.png" /><?php } ?><?php else:?><img src="application/modules/Sescrowdfunding/externals/images/category-icon.png" /><?php endif;?><span><?php echo $this->translate($item->category_name); ?></span></a>

      <ul id="subcategory_<?php echo $item->getIdentity() ?>" style="display:none;">          
        <?php foreach( $subcategory as $subCat ): ?>
          <li>
            <?php $subsubcategory = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $subCat->category_id, 'countCrowdfundings' => true)); ?>
            <?php if(counT($subsubcategory) > 0): ?>
              <a id="sescrowdfunding_subcat_toggle_<?php echo $subCat->category_id ?>" class="cattoggel cattoggelright" href="javascript:void(0);" onclick="showCategory('<?php echo $subCat->getIdentity()  ?>')"></a>
            <?php endif; ?> 
            <a class="catlabel" href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_general', true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) ; ?>"><?php if($subCat->cat_icon != '' && !is_null($subCat->cat_icon)):?>
            <?php $subicon = $this->storage->get($subCat->cat_icon, ''); ?>
            <?php if($subicon) { ?>
							<img src="<?php echo $subicon->getPhotoUrl(); ?>" />
            <?php } else { ?>
							<img src="application/modules/Sescrowdfunding/externals/images/category-icon.png" />
            <?php } ?>
            <?php else:?><img src="application/modules/Sescrowdfunding/externals/images/category-icon.png" /><?php endif;?> <span><?php echo $this->translate($subCat->category_name); ?></span></a>  
              <ul id="subsubcategory_<?php echo $subCat->getIdentity() ?>" style="display:none;">
                <?php foreach( $subsubcategory as $subSubCat ): ?>
                  <li>                      
                    <a class="catlabel" href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_general', true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) .'&subsubcat_id='.urlencode($subSubCat->category_id) ; ?>"><?php if($subSubCat->cat_icon != '' && !is_null($subSubCat->cat_icon)):?><img src="<?php echo $this->storage->get($subSubCat->cat_icon, '')->getPhotoUrl(); ?>" /><?php else:?><img src="application/modules/Sescrowdfunding/externals/images/category-icon.png" /><?php endif;?><span><?php echo $this->translate($subSubCat->category_name); ?></span></a>
                  </li>
                <?php endforeach; ?>
              </ul>               
            </li>
        <?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
</ul>
<script>
function showCategory(id) {
  if($('subcategory_' + id)) {
    if ($('subcategory_' + id).style.display == 'block') {
      $('sescrowdfunding_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sescrowdfunding_toggle_' + id).addClass('cattoggel cattoggelright');
      $('subcategory_' + id).style.display = 'none';
    } else {
      $('sescrowdfunding_toggle_' + id).removeClass('cattoggel cattoggelright');
      $('sescrowdfunding_toggle_' + id).addClass('cattoggel cattoggeldown');
      $('subcategory_' + id).style.display = 'block';
    }
  }
  
  if($('subsubcategory_' + id)) {
    if ($('subsubcategory_' + id).style.display == 'block') {
      $('sescrowdfunding_subcat_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sescrowdfunding_subcat_toggle_' + id).addClass('cattoggel cattoggelright');      
      $('subsubcategory_' + id).style.display = 'none';
    } else {
      $('sescrowdfunding_subcat_toggle_' + id).removeClass('cattoggel cattoggelright');
      $('sescrowdfunding_subcat_toggle_' + id).addClass('cattoggel cattoggeldown');
      $('subsubcategory_' + id).style.display = 'block';
    }
  }
}
</script>
