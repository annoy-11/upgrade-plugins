<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<?php $route = 'sesqa_general'; ?>
<ul class="sesqa_sidebar_categories sesqac_sidebar_widget">
  <?php foreach( $this->categories as $item ): ?>
    <li>
      <?php $subcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubcategory(array('column_name' => "*", 'category_id' => $item->category_id)); ?>
      <?php if(counT($subcategory) > 0): ?>
        <a id="sesqa_toggle_<?php echo $item->category_id ?>" class="cattoggel cattoggelright fa" href="javascript:void(0);" onclick="showCategory('<?php echo $item->getIdentity()  ?>')"></a>
      <?php endif; ?>
      <?php 
        if($item->cat_icon) { 
          $cat_icon = $this->storage->get($item->cat_icon, '');
          if($cat_icon) {
            $cat_icon = $cat_icon->getPhotoUrl();
          } else {
            $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
          }
        } else {
          $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
        }
      ?>
      <a class="catlabel <?php echo $this->image == 0 ? '' : 'noicon' ?>" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($item->getIdentity()) ; ?>" <?php if($this->image == 0 && $item->cat_icon != '' && !is_null($item->cat_icon)){ ?> style="background-image:url(<?php echo $cat_icon; ?>);"<?php } ?>><?php echo $this->translate($item->category_name); ?></a>

      <ul id="subcategory_<?php echo $item->getIdentity() ?>" style="display:none;">          
        <?php foreach( $subcategory as $subCat ): ?>
          <li>
            <?php $subsubcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $subCat->category_id)); ?>
            <?php if(counT($subsubcategory) > 0): ?>
              <a id="sesqa_subcat_toggle_<?php echo $subCat->category_id ?>" class="cattoggel cattoggelright fa" href="javascript:void(0);" onclick="showCategory('<?php echo $subCat->getIdentity()  ?>')"></a>
            <?php endif; ?> 
            
            <?php 
              if($subCat->cat_icon) { 
                $cat_icon = $this->storage->get($subCat->cat_icon, '');
                if($cat_icon) {
                  $cat_icon = $cat_icon->getPhotoUrl();
                } else {
                  $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
                }
              } else {
                $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
              }
            ?>
            
            <a class="catlabel <?php echo $this->image == 0 ? '' : 'noicon' ?>" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) ; ?>" <?php if($this->image == 0 && $subCat->cat_icon != '' && !is_null($subCat->cat_icon)){ ?> style="background-image:url(<?php echo $cat_icon; ?>);"<?php } ?>><?php echo $this->translate($subCat->category_name); ?></a>   
              
              <ul id="subsubcategory_<?php echo $subCat->getIdentity() ?>" style="display:none;">
                <?php $subsubcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $subCat->category_id)); ?>
                <?php foreach( $subsubcategory as $subSubCat ): ?>
                  <li>
                  
                    <?php 
                      if($subSubCat->cat_icon) { 
                        $cat_icon = $this->storage->get($subSubCat->cat_icon, '');
                        if($cat_icon) {
                          $cat_icon = $cat_icon->getPhotoUrl();
                        } else {
                          $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
                        }
                      } else {
                        $cat_icon = 'application/modules/Sesqa/externals/images/category.png';
                      }
                    ?>
                    <a class="catlabel <?php echo $this->image == 0 ? '' : 'noicon' ?>" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) .'&subsubcat_id='.urlencode($subSubCat->category_id) ; ?>" <?php if($this->image == 0 && $subSubCat->cat_icon != '' && !is_null($subSubCat->cat_icon)){ ?> style="background-image:url(<?php echo $cat_icon; ?>);"<?php } ?>><?php echo $this->translate($subSubCat->category_name); ?></a>
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
      $('sesqa_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sesqa_toggle_' + id).addClass('cattoggel cattoggelright');
      $('subcategory_' + id).style.display = 'none';
    } else {
      $('sesqa_toggle_' + id).removeClass('cattoggel cattoggelright');
      $('sesqa_toggle_' + id).addClass('cattoggel cattoggeldown');
      $('subcategory_' + id).style.display = 'block';
    }
  }
  
  if($('subsubcategory_' + id)) {
    if ($('subsubcategory_' + id).style.display == 'block') {
      $('sesqa_subcat_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sesqa_subcat_toggle_' + id).addClass('cattoggel cattoggelright');      
      $('subsubcategory_' + id).style.display = 'none';
    } else {
      $('sesqa_subcat_toggle_' + id).removeClass('cattoggel cattoggelright');
      $('sesqa_subcat_toggle_' + id).addClass('cattoggel cattoggeldown');
      $('subsubcategory_' + id).style.display = 'block';
    }
  }
}
</script>