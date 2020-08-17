<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seswishe/externals/styles/styles.css'); ?>
<div class="seswishes_item_view sesbasic_bxs">
	<header class="sesbasic_clearfix">	
    <div class="_photo">
    	<?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner, 'thumb.icon', $this->owner->getTitle())) ?>
    </div>
    <div class="_info">
      <p class="name"><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
      <p class="sesbasic_text_light _date">
      	<span><?php echo $this->translate("Posted")?> <?php echo $this->timestamp($this->wishe->creation_date) ?></span>
        <span>|</span>
        <span>
          <i class="fa fa-thumbs-up"></i>
          <span> <?php echo $this->translate(array('%s like', '%s likes', $this->wishe->like_count), $this->locale()->toNumber($this->wishe->like_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-comment"></i>
          <span><?php echo $this->translate(array('%s comment', '%s comments', $this->wishe->comment_count), $this->locale()->toNumber($this->wishe->comment_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-eye"></i>
          <span><?php echo $this->translate(array('%s view', '%s views', $this->wishe->view_count), $this->locale()->toNumber($this->wishe->view_count)) ?></span>
        </span>
        <?php if($this->wishe->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.enablecategory', 1)) { ?>
          <span>|</span>
          <span>
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('seswishe_category', $this->wishe->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($this->wishe->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('seswishe_category', $this->wishe->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id.'&subcat_id='.$this->wishe->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($this->wishe->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('seswishe_category', $this->wishe->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id.'&subcat_id='.$this->wishe->subcat_id.'&subsubcat_id='.$this->wishe->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
      </p>  
    </div>
  </header>
  <section class="_cont">
		<div class="seswishe_feed_wishe">
      <?php if(in_array($this->wishe->mediatype, array(1, 3)) && !empty($this->wishe->photo_id)) { ?>
        <div class="seswishe_img"><?php echo $this->itemPhoto($this->wishe, 'thumb.main') ?></div>
      <?php } else if($this->wishe->mediatype == 2 && $this->wishe->code) { ?>
        <div class="seswishe_img"><?php echo $this->wishe->code; ?></div>
      <?php } ?>
      <?php if(!empty($this->wishe->wishetitle)) { ?>
        <h2 class="seswishe_title">
          <?php echo $this->wishe->wishetitle; ?>
        </h2>
      <?php } ?>
    	<p class="seswishe_wishe"><?php echo nl2br($this->wishe->title) ?></p>
      <?php if($this->wishe->source) { ?>
        <p class="sesbasic_text_light seswishe_wishe_src">&mdash; <?php echo $this->wishe->source; ?></p>
      <?php } ?>
      <?php if (count($this->wisheTags )):?>
        <div class="_tags">
          <?php foreach ($this->wisheTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>  
  </section>
  <div class="_footer sesbasic_clearfix">
		<div class="_social seswishe_social_btns">
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.allowshare', 1)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->wishe, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
      <?php endif;?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('seswishe_wishe', $viewer, 'create');?>
      <?php if($canComment):?>
        <?php $likeStatus = Engine_Api::_()->seswishe()->getLikeStatus($this->wishe->wishe_id,$this->wishe->getType()); ?>
        <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->wishe->wishe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seswishe_like_<?php echo $this->wishe->wishe_id ?> seswishe_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->wishe->like_count;?></span></a>
      <?php endif;?>
    </div>
    <div class="_options">
      <?php if($this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.allowshare', 1)):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->wishe->getType(), "id" => $this->wishe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_icon_share buttonlink"><?php echo $this->translate('Share');?></a>
      <?php endif;?>
      <?php if($this->viewer_id && $this->viewer_id != $this->wishe->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.allowreport', 1)):?>
        <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->wishe->getGuid()),'default', true);?>" class="smoothbox sesbasic_icon_report buttonlink"><?php echo $this->translate('Report');?></a>
      <?php endif;?>
        <?php if( $this->mine || $this->canEdit ): ?>
        <?php echo $this->htmlLink(array('route' => 'seswishe_specific', 'action' => 'edit', 'wishe_id' => $this->wishe->wishe_id), $this->translate('Edit Wishe'), array(
          'class' => 'buttonlink sessmoothbox sesbasic_icon_edit'
        )) ?>
        <?php echo $this->htmlLink(array('route' => 'seswishe_specific', 'action' => 'delete', 'wishe_id' => $this->wishe->wishe_id, 'format' => 'smoothbox'), $this->translate('Delete Wishe'), array(
          'class' => 'buttonlink smoothbox sesbasic_icon_delete'
        )) ?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="wishe/javascript">
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"seswishe_general",true); ?>'+'?tag_id='+tag_id;
	}
  $$('.core_main_seswishe').getParent().addClass('active');
</script>