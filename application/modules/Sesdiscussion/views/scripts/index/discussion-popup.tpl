<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: discussion-popup.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css'); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="sesdiscussion_item_view_popup sesbasic_bxs">
	<div class="sesbasic_clearfix _details">
    <?php if($item->new) { ?>
      <div class="sesdiscussions_new_label _ir"><?php echo $this->translate("New");?></div>
  	<?php } ?>
  	<div class="_photo">
      <?php 
        $item = $this->discussions;
        echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle()), array()) 
      ?>
    </div>
    <div class="_info">
    	<p class="name"><a href="<?php echo $item->getOwner()->getHref(); ?>"><?php echo $item->getOwner()->getTitle(); ?></a></p>
      <p class="sesbasic_text_light _date">
      	<span><?php echo $this->translate("Posted")?> <?php echo $this->timestamp(strtotime($item->creation_date)) ?></span>
        <span>|</span>
        <span>
          <i class="fa fa fa-thumbs-up"></i>
          <span><?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?></span>
        </span>
        <span>
          <i class="fa fa fa-comment"></i>
          <span><?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?></span>
        </span>
        <span>
          <i class="fa fa fa-eye"></i>
          <span><?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?></span>
        </span>
        <?php if($item->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1)) { ?>
          <span>|</span>
          <span>
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('sesdiscussion_category', $item->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($item->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('sesdiscussion_category', $item->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$item->category_id.'&subcat_id='.$item->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($item->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('sesdiscussion_category', $item->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$item->category_id.'&subcat_id='.$item->subcat_id.'&subsubcat_id='.$item->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
        <?php if($this->viewer_id) { ?>
          <div class="_options">
            <span class="_options_toggle fa fa-ellipsis-v sesbasic_text_light"></span>  
            <div class="_options_pulldown">
              <?php if($this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
                <a href="javascript:void(0);" class="sesbasic_icon_share" onclick="sesdiscussionSmoothBox('<?php echo $this->escape($this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $item->getType(), "id" => $item->getIdentity(), "format" => "smoothbox"), 'default', true)); ?>'); return false;"><?php echo $this->translate('Share');?></a>
              <?php endif;?>
              <?php if($this->viewer_id && $this->viewer_id != $item->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowreport', 1)):?>
                <a href="javascript:void(0);" class="sesbasic_icon_report" onclick="sesdiscussionSmoothBox('<?php echo $this->escape($this->url(array("module" => "core","controller" => "report","action" => "create", 'subject'=> $item->getGuid(), "format" => "smoothbox"), 'default', true)); ?>'); return false;"><?php echo $this->translate('Report');?></a>
              <?php endif;?>
              <?php if($this->canEdit && $this->actionparam == 'manage'): ?>
                <?php if($this->createform) { ?>
                  <?php echo $this->htmlLink(array('route' => 'sesdiscussion_specific', 'action' => 'edit', 'discussion_id' => $item->getIdentity()), $this->translate('Edit Discussion'), array('class' => 'buttonlink sessmoothbox sesbasic_icon_edit')) ?>
                <?php } else { ?>
                  <?php echo $this->htmlLink(array('route' => 'sesdiscussion_specific', 'action' => 'edit', 'discussion_id' => $item->getIdentity()), $this->translate('Edit Discussion'), array('class' => 'buttonlink sesbasic_icon_edit')); ?>
                <?php } ?>
                <a href="javascript:void(0);" class="buttonlink sesbasic_icon_delete" onclick="sesdiscussionSmoothBox('<?php echo $this->escape($this->url(array("action" => "delete", 'discussion_id'=> $item->getIdentity(), "format" => "smoothbox"), 'sesdiscussion_specific', true)); ?>'); return false;"><?php echo $this->translate('Delete');?></a>

              <?php endif;?>
            </div>
          </div>
        <?php } ?>
      </p>
    </div>
  </div>
  <?php if(in_array($item->mediatype, array(1, 3)) && !empty($item->photo_id)) { ?>
    <div class="sesdiscussion_item_view_popup_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
  <?php } else if($item->mediatype == 2 && $item->code) { ?>
    <div class="sesdiscussion_item_view_popup_video"><?php echo $item->code; ?></div>
  <?php } ?>
  <div class="_cont sesdiscussion_feed_discussion">
    <?php if(!empty($item->title)) { ?>
      <h2 class="sesdiscussion_title">
        <?php echo $item->title; ?>
      </h2>
    <?php } ?>
    <div class="sesdiscussion_discussion">
      <?php echo nl2br($item->title); ?>
    </div>
    <?php if($item->link) { ?>
      <div class="sesbasic_text_light sesdiscussion_discussion_link"><a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a></div>
    <?php } ?>
    <div class="_tags">
      <?php if (count($this->discussionTags )):?>
        <div class="_tags">
          <?php foreach ($this->discussionTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="_social sesdiscussion_social_btns sesbasic_clearfix">
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
    <?php endif;?>
    <?php $viewer = Engine_Api::_()->user()->getViewer();?>
    <?php $canComment = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'create');?>
    <?php if($canComment):?>
      <?php $likeStatus = Engine_Api::_()->sesdiscussion()->getLikeStatus($item->discussion_id,$item->getType()); ?>
      <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdiscussion_like_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
    <?php endif;?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1)) { ?>
      <?php echo $this->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $item)); ?>
    <?php } ?>
  </div>
  <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')){ ?>
    <div class="_comments">
      <?php echo $this->action("list", "comment", "sesadvancedcomment", array("type" => $item->getType(), "id" => $item->getIdentity()));  ?>
    </div>
  <?php } else { ?>
    <div class="_comments">
      <?php echo $this->action("list", "comment", "core", array("type" => "sesdiscussion_discussion", "id" => $item->getIdentity())); ?>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesdiscussion_general",true); ?>'+'?tag_id='+tag_id;
	}
  
	sesJqueryObject(document).on('click','._options_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});

function sesdiscussionSmoothBox(url) {
  Smoothbox.open(url);
  parent.Smoothbox.close;
}
</script>
