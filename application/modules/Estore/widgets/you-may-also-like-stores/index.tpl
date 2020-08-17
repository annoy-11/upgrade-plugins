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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $height = $this->height_list;?>
<?php $width = $this->width_list;?>
<?php if($this->params['viewType'] == 'listView'):?>
  <ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->results as $store):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
          <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $store->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($store->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/sidebar/_listView.tpl';?>
    <?php endforeach;?>
  </ul>
<script>
function showSocialIcons(id) {
	if($('sidebarsocialicon_' + id)) {
		if ($('sidebarsocialicon_' + id).style.display == 'block') {
			$('sidebarsocialicon_' + id).style.display = 'none';
		} else {
			$('sidebarsocialicon_' + id).style.display = 'block';
		}
	}
}
window.addEvent('domready', function() {
  $(document.body).addEvent('click', function(event){
    if(event.target.className != 'estore_sidebar_list_option_btns' && event.target.id != 'testcl') {
			
			sesJqueryObject('.estore_sidebar_list_option_btns').css('display', 'none');
    }
  });
});
</script>  
<?php else:?>
  <ul class="sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->results as $store):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $store->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($store->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_View.tpl';?>
    <?php endforeach;?>
   </ul>
<?php endif;?>
<?php if($this->params['viewType'] == 'gridview'): ?>
    <?php $height = $this->height_grid;?>
    <?php $width = $this->width_grid;?>
  <ul class="estore_store_listing  sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->results as $store):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
          <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $store->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($store->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_simpleGridView.tpl';?>
    <?php endforeach;?>
  </ul>
<script>
function showSocialIcons(id) {
  if($('sidebarsocialicon_' + id)) {
    if ($('sidebarsocialicon_' + id).style.display == 'block') {
      $('sidebarsocialicon_' + id).style.display = 'none';
    } else {
      $('sidebarsocialicon_' + id).style.display = 'block';
    }
  }
}
window.addEvent('domready', function() {
  $(document.body).addEvent('click', function(event){
    if(event.target.className != 'estore_sidebar_list_option_btns' && event.target.id != 'testcl') {
      
      sesJqueryObject('.estore_sidebar_list_option_btns').css('display', 'none');
    }
  });
});
</script>  
<?php else:?>
  <ul class="sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->results as $store):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $store->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($store->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_View.tpl';?>
    <?php endforeach;?>
   </ul>
<?php endif;?>
