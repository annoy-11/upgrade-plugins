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

<?php $allParams = $this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css'); ?>
<div class="sesdiscussions_item_view sesbasic_bxs">
	<header class="sesbasic_clearfix">	
   <?php if(!empty($this->discussion->discussiontitle)) { ?>
        <h2 class="sesdiscussion_title">
          <?php echo $this->discussion->getTitle() ?>
        </h2>
      <?php } ?>
    <?php if(in_array('new', $allParams['stats']) && $this->discussion->new) { ?>
      <div class="sesdiscussions_new_label _ir"><?php echo $this->translate("New");?></div>
  	<?php } ?>
    <div class="header_bottom">
    <?php if(in_array('postedby', $allParams['stats'])) { ?>
    <div>
        <p class="name">by <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
    </div>
    <?php } ?>
    <?php if(in_array('posteddate', $allParams['stats'])) { ?>
     <div class="sesbasic_text_light _date">
      	<span><i class="fa fa-clock-o"></i><?php echo $this->timestamp($this->discussion->creation_date) ?></span>
        </div>
        <?php } ?>
       <div class="_stats sesbasic_text_light">
        <?php if(in_array('likecount', $allParams['stats'])) { ?>
        <span>
          <span> <?php echo $this->translate(array('<i class="fa fa-thumbs-up"></i> %s  ', '<i class="fa fa-thumbs-up"></i> %s  ', $this->discussion->like_count), $this->locale()->toNumber($this->discussion->like_count)) ?></span>
        </span>
        <?php } ?>
        <?php if(in_array('favouritecount', $allParams['stats'])) { ?>
        <span>
          <span> <?php echo $this->translate(array('<i class="fa fa-heart"></i> %s', '<i class="fa fa-heart"></i> %s', $this->discussion->favourite_count), $this->locale()->toNumber($this->discussion->favourite_count)) ?></span>
        </span>
        <?php } ?>
        <?php if(in_array('followcount', $allParams['stats'])) { ?>
        <span>
          <span> <?php echo $this->translate(array('<i class="fa fa-check"></i> %s', '<i class="fa fa-check"></i> %s', $this->discussion->follow_count), $this->locale()->toNumber($this->discussion->follow_count)) ?></span>
        </span>
        <?php } ?>
        <?php if(in_array('commentcount', $allParams['stats'])) { ?>
        <span>
          <span><?php echo $this->translate(array('<i class="fa fa-comment"></i> %s', '<i class="fa fa-comment"></i> %s', $this->discussion->comment_count), $this->locale()->toNumber($this->discussion->comment_count)) ?></span>
        </span>
        <?php } ?>
        <?php if(in_array('viewcount', $allParams['stats'])) { ?>
        <span>
          <span><?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', '<i class="fa fa-eye"></i> %s', $this->discussion->view_count), $this->locale()->toNumber($this->discussion->view_count)) ?></span>
        </span>
        <?php } ?>
        <?php if(in_array('category', $allParams['stats']) && $this->discussion->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1)) { ?>
          <span class="sesdisc_category">
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($this->discussion->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id.'&subcat_id='.$this->discussion->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($this->discussion->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id.'&subcat_id='.$this->discussion->subcat_id.'&subsubcat_id='.$this->discussion->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
      </p>  
    </div>
    </div>
  </header>
  <?php if(in_array($this->discussion->mediatype, array(1, 3,4)) && !empty($this->discussion->photo_id)) { ?>
    <div class="sesdiscussion_item_view_img"><?php echo $this->itemPhoto($this->discussion, 'thumb.main') ?></div>
  <?php } else if($this->discussion->mediatype == 2 && $this->discussion->code) { ?>
    <div class="sesdiscussion_item_view_video"><?php echo $this->discussion->code; ?></div>
  <?php } ?>
  <section class="_cont">
		<div class="sesdiscussion_feed_discussion">
      <?php if(in_array('description', $allParams['stats'])) { ?>
    	<p class="sesdiscussion_discussion"><?php echo $this->discussion->discussiontitle; ?></p>
    	<?php } ?>
      <?php if(in_array('source', $allParams['stats']) && $this->discussion->link) { ?>
        <div class="sesbasic_text_light sesdiscussion_discussion_link"><a href="<?php echo $this->discussion->link; ?>" target="_blank"><?php echo $this->discussion->link; ?></a></div>
      <?php } ?>
      <?php if (in_array('tags', $allParams['stats']) && count($this->discussionTags )):?>
        <div class="_tags">
          <?php foreach ($this->discussionTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>  
  </section>
  <div class="_footer sesbasic_clearfix">
		<div class="_social sesdiscussion_social_btns">
      <?php if(in_array('socialSharing', $allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->discussion, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
      <?php endif;?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('discussion', $this->viewer, 'create');?>
      <?php if(in_array('likebutton', $allParams['stats']) && $canComment):?>
        <?php $likeStatus = Engine_Api::_()->sesdiscussion()->getLikeStatus($this->discussion->discussion_id,$this->discussion->getType()); ?>
        <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->discussion->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdiscussion_like_<?php echo $this->discussion->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->discussion->like_count;?></span></a>
      <?php endif;?>
      
      <?php if(in_array('favouritebutton', $allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1)): ?>
        <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdiscussion')->isFavourite(array('resource_type'=>'discussion','resource_id'=>$this->discussion->discussion_id)); ?>
        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesdiscussion_favourite_sesdiscussion_discussion_<?php echo $this->discussion->discussion_id ?> sesdiscussion_favourite_sesdiscussion_discussion <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $this->discussion->discussion_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $this->discussion->favourite_count; ?></span></a>
      <?php endif;?>
      
      <?php if(in_array('followbutton', $allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.follow.active', 1)):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->isFollow(array('resource_id' => $this->discussion->discussion_id,'resource_type' => $this->discussion->getType())); ?>
        <a href="javascript:;" data-type="follow_view" data-url="<?php echo $this->discussion->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesdiscussion_follow_<?php echo $this->discussion->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $this->discussion->follow_count;?></span></a>
      <?php endif;?>
      
    </div>
    <?php if(in_array('voting', $allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1)) { ?>
      <?php echo $this->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $this->discussion)); ?>
    <?php } ?>
    <div class="_options">
      <?php if(in_array('siteshare', $allParams['stats']) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->discussion->getType(), "id" => $this->discussion->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_icon_share buttonlink"><?php echo $this->translate('Share');?></a>
      <?php endif;?>
      <?php if($this->viewer_id && $this->viewer_id != $this->discussion->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowreport', 1)):?>
        <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->discussion->getGuid()),'default', true);?>" class="smoothbox sesbasic_icon_report buttonlink"><?php echo $this->translate('Report');?></a>
      <?php endif;?>
        <?php if( $this->canEdit || $this->canDelete): ?>
        <?php if( $this->canEdit) { ?>
        <?php if($this->createform) { ?>
          <?php echo $this->htmlLink(array('route' => 'sesdiscussion_specific', 'action' => 'edit', 'discussion_id' => $this->discussion->discussion_id), $this->translate('Edit Discussion'), array('class' => 'buttonlink sessmoothbox sesbasic_icon_edit')) ?>
        <?php } else { ?>
          <?php echo $this->htmlLink(array('route' => 'sesdiscussion_specific', 'action' => 'edit', 'discussion_id' => $this->discussion->discussion_id), $this->translate('Edit Discussion'), array('class' => 'buttonlink sesbasic_icon_edit')) ?>
        <?php } ?>
        <?php } ?>
        <?php if( $this->canDelete) { ?>
        <?php echo $this->htmlLink(array('route' => 'sesdiscussion_specific', 'action' => 'delete', 'discussion_id' => $this->discussion->discussion_id, 'format' => 'smoothbox'), $this->translate('Delete Discussion'), array(
          'class' => 'buttonlink smoothbox sesbasic_icon_delete'
        )) ?>
        <?php } ?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="discussion/javascript">
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesdiscussion_general",true); ?>'+'?tag_id='+tag_id;
	}
  $$('.core_main_sesdiscussion').getParent().addClass('active');
</script>

