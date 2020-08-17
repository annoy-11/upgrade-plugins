<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesquote/externals/styles/styles.css'); ?>
<div class="sesquotes_item_view sesbasic_bxs">
	<header class="sesbasic_clearfix">	
    <div class="_photo">
    	<?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner, 'thumb.icon', $this->owner->getTitle())) ?>
    </div>
    <div class="_info">
      <p class="name"><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
      <p class="sesbasic_text_light _date">
      	<span><?php echo $this->translate("Posted")?> <?php echo $this->timestamp($this->quote->creation_date) ?></span>
        <span>|</span>
        <span>
          <i class="fa fa-thumbs-up"></i>
          <span> <?php echo $this->translate(array('%s like', '%s likes', $this->quote->like_count), $this->locale()->toNumber($this->quote->like_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-comment"></i>
          <span><?php echo $this->translate(array('%s comment', '%s comments', $this->quote->comment_count), $this->locale()->toNumber($this->quote->comment_count)) ?></span>
        </span>
        <span>
          <i class="fa fa-eye"></i>
          <span><?php echo $this->translate(array('%s view', '%s views', $this->quote->view_count), $this->locale()->toNumber($this->quote->view_count)) ?></span>
        </span>
        <?php if($this->quote->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.enablecategory', 1)) { ?>
          <span>|</span>
          <span>
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('sesquote_category', $this->quote->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($this->quote->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('sesquote_category', $this->quote->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id.'&subcat_id='.$this->quote->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($this->quote->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('sesquote_category', $this->quote->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id.'&subcat_id='.$this->quote->subcat_id.'&subsubcat_id='.$this->quote->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
      </p>  
    </div>
  </header>
  <section class="_cont">
		<div class="sesquote_feed_quote">
      <?php if(in_array($this->quote->mediatype, array(1, 3)) && !empty($this->quote->photo_id)) { ?>
        <div class="sesquote_img"><?php echo $this->itemPhoto($this->quote, 'thumb.main') ?></div>
      <?php } else if($this->quote->mediatype == 2 && $this->quote->code) { ?>
        <div class="sesquote_img"><?php echo $this->quote->code; ?></div>
      <?php } ?>
      <?php if(!empty($this->quote->quotetitle)) { ?>
        <h2 class="sesquote_title">
          <?php echo $this->quote->quotetitle; ?>
        </h2>
      <?php } ?>
    	<p class="sesquote_quote"><?php echo nl2br($this->quote->title) ?></p>
      <?php if($this->quote->source) { ?>
        <p class="sesbasic_text_light sesquote_quote_src">&mdash; <?php echo $this->quote->source; ?></p>
      <?php } ?>
      <?php if (count($this->quoteTags )):?>
        <div class="_tags">
          <?php foreach ($this->quoteTags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>  
  </section>
  <div class="_footer sesbasic_clearfix">
		<div class="_social sesquote_social_btns">
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.allowshare', 1)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->quote, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
      <?php endif;?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesquote_quote', $viewer, 'create');?>
      <?php if($canComment):?>
        <?php $likeStatus = Engine_Api::_()->sesquote()->getLikeStatus($this->quote->quote_id,$this->quote->getType()); ?>
        <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->quote->quote_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesquote_like_<?php echo $this->quote->quote_id ?> sesquote_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->quote->like_count;?></span></a>
      <?php endif;?>
    </div>
    <div class="_options">
      <?php if($this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.allowshare', 1)):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->quote->getType(), "id" => $this->quote->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_icon_share buttonlink"><?php echo $this->translate('Share');?></a>
      <?php endif;?>
      <?php if($this->viewer_id && $this->viewer_id != $this->quote->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.allowreport', 1)):?>
        <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->quote->getGuid()),'default', true);?>" class="smoothbox sesbasic_icon_report buttonlink"><?php echo $this->translate('Report');?></a>
      <?php endif;?>
        <?php if( $this->mine || $this->canEdit ): ?>
        <?php echo $this->htmlLink(array('route' => 'sesquote_specific', 'action' => 'edit', 'quote_id' => $this->quote->quote_id), $this->translate('Edit Quote'), array(
          'class' => 'buttonlink sessmoothbox sesbasic_icon_edit'
        )) ?>
        <?php echo $this->htmlLink(array('route' => 'sesquote_specific', 'action' => 'delete', 'quote_id' => $this->quote->quote_id, 'format' => 'smoothbox'), $this->translate('Delete Quote'), array(
          'class' => 'buttonlink smoothbox sesbasic_icon_delete'
        )) ?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="quote/javascript">
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesquote_general",true); ?>'+'?tag_id='+tag_id;
	}
  $$('.core_main_sesquote').getParent().addClass('active');
</script>