<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $height = $this->params['height'];?>
<?php $width = $this->params['width'];?>
<?php if($this->params['viewType'] == 'listView'):?>
  <ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->results as $page):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
          <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $page->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($page->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/sidebar/_listView.tpl';?>
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
    if(event.target.className != 'sespage_sidebar_list_option_btns' && event.target.id != 'testcl') {
			
			sesJqueryObject('.sespage_sidebar_list_option_btns').css('display', 'none');
    }
  });
});
</script>  
<?php else:?>
  <ul class="sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->results as $page):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $page->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($page->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/page/_advgridView.tpl';?>
    <?php endforeach;?>
   </ul>
<?php endif;?>