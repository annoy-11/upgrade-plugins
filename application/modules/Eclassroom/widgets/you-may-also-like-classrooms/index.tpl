<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $height = $this->height_list;?>
<?php $width = $this->width_list;?>
<?php if($this->params['viewType'] == 'listView'): ?>
  <ul class="sesbasic_sidebar_block sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->results as $classroom):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
          <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $classroom->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($classroom->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_listView.tpl';?>
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
    if(event.target.className != 'eclassroom_sidebar_list_option_btns' && event.target.id != 'testcl') {
			
			sesJqueryObject('.eclassroom_sidebar_list_option_btns').css('display', 'none');
    }
  });
});
</script>  
<?php else:?>
  <ul class="sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->results as $classroom):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $classroom->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($classroom->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
      <?php endif;?>
    <?php endforeach;?>
   </ul>
<?php endif;?>
<?php if($this->params['viewType'] == 'gridview'): ?>
    <?php $height = $this->height_grid;?>
    <?php $width = $this->width_grid;?>
  <ul class="eclassroom_listing  sesbasic_bxs sesbasic_clearfix">
    <?php foreach($this->results as $classroom):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
          <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $classroom->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($classroom->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_gridView.tpl';?>
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
    if(event.target.className != 'eclassroom_sidebar_list_option_btns' && event.target.id != 'testcl') {
      
      sesJqueryObject('.eclassroom_sidebar_list_option_btns').css('display', 'none');
    }
  });
});
</script>  
<?php else:?>
  <ul class="sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->results as $classroom):?>
      <?php if(isset($this->titleActive)):?>
        <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
        <?php else: ?>
          <?php $title = $classroom->getTitle();?>
        <?php endif; ?>
      <?php endif;?>
      <?php if (!empty($classroom->category_id)):?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
      <?php endif;?>
    <?php endforeach;?>
   </ul>
<?php endif;?>
