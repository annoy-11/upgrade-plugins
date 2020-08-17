<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css'); ?>
<div class="sesprayers_item_view sesbasic_bxs">
	<header class="sesbasic_clearfix">	
    <div class="_photo">
    	<?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner, 'thumb.icon', $this->owner->getTitle())) ?>
    </div>
    <div class="_info">
      <p class="name"><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
      <p class="sesbasic_text_light _date">
      	<span><?php echo $this->translate("Posted")?> <?php echo $this->timestamp($this->prayer->creation_date) ?></span>
        <span>|</span>
        <span>
          <i class="fa fa-thumbs-up"></i>
          <span> <?php echo $this->translate(array('%s like', '%s likes', $this->prayer->like_count), $this->locale()->toNumber($this->prayer->like_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-comment"></i>
          <span><?php echo $this->translate(array('%s comment', '%s comments', $this->prayer->comment_count), $this->locale()->toNumber($this->prayer->comment_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-eye"></i>
          <span><?php echo $this->translate(array('%s view', '%s views', $this->prayer->view_count), $this->locale()->toNumber($this->prayer->view_count)) ?></span>
        </span>
        <?php if($this->prayer->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.enablecategory', 1)) { ?>
          <span>|</span>
          <span>
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($this->prayer->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id.'&subcat_id='.$this->prayer->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($this->prayer->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id.'&subcat_id='.$this->prayer->subcat_id.'&subsubcat_id='.$this->prayer->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
      </p>  
    </div>
  </header>
  <section class="_cont">
		<div class="sesprayer_feed_prayer">
      <?php if(in_array($this->prayer->mediatype, array(1, 3)) && !empty($this->prayer->photo_id)) { ?>
        <div class="sesprayer_img"><?php echo $this->itemPhoto($this->prayer, 'thumb.main') ?></div>
      <?php } else if($this->prayer->mediatype == 2 && $this->prayer->code) { ?>
        <div class="sesprayer_img"><?php echo $this->prayer->code; ?></div>
      <?php } ?>
      <?php if(!empty($this->prayer->prayertitle)) { ?>
        <h2 class="sesprayer_title">
          <?php echo $this->prayer->prayertitle; ?>
        </h2>
      <?php } ?>
    	<p class="sesprayer_prayer"><?php echo nl2br($this->prayer->title) ?></p>
      <?php if($this->prayer->source) { ?>
        <p class="sesbasic_text_light sesprayer_prayer_src">&mdash; <?php echo $this->prayer->source; ?></p>
      <?php } ?>
      <?php if (count($this->prayerTags )):?>
        <div class="_tags">
          <?php foreach ($this->prayerTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>  
  </section>
  <div class="_footer sesbasic_clearfix">
		<div class="_social sesprayer_social_btns">
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowshare', 1)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->prayer, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
      <?php endif;?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesprayer_prayer', $viewer, 'create');?>
      <?php if($canComment):?>
        <?php $likeStatus = Engine_Api::_()->sesprayer()->getLikeStatus($this->prayer->prayer_id,$this->prayer->getType()); ?>
        <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->prayer->prayer_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesprayer_like_<?php echo $this->prayer->prayer_id ?> sesprayer_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->prayer->like_count;?></span></a>
      <?php endif;?>
    </div>
    <div class="_options">
      <?php if($this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowshare', 1)):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->prayer->getType(), "id" => $this->prayer->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_icon_share buttonlink"><?php echo $this->translate('Share');?></a>
      <?php endif;?>
      <?php if($this->viewer_id && $this->viewer_id != $this->prayer->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowreport', 1)):?>
        <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->prayer->getGuid()),'default', true);?>" class="smoothbox sesbasic_icon_report buttonlink"><?php echo $this->translate('Report');?></a>
      <?php endif;?>
        <?php if( $this->mine || $this->canEdit ): ?>
        <?php echo $this->htmlLink(array('route' => 'sesprayer_specific', 'action' => 'edit', 'prayer_id' => $this->prayer->prayer_id), $this->translate('Edit Prayer'), array(
          'class' => 'buttonlink sessmoothbox sesbasic_icon_edit'
        )) ?>
        <?php echo $this->htmlLink(array('route' => 'sesprayer_specific', 'action' => 'delete', 'prayer_id' => $this->prayer->prayer_id, 'format' => 'smoothbox'), $this->translate('Delete Prayer'), array(
          'class' => 'buttonlink smoothbox sesbasic_icon_delete'
        )) ?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="prayer/javascript">
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesprayer_general",true); ?>'+'?tag_id='+tag_id;
	}
  $$('.core_main_sesprayer').getParent().addClass('active');
</script>