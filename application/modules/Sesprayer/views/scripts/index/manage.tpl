<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');
?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) { ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/mention/jquery.mentionsInput.css'); ?>    
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/underscore-min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/jquery.mentionsInput.js'); ?>
<?php } ?>
<?php $randonNumber = 2000; ?>

<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="prelative sesprayers_listing sesbasic_bxs sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:50px;" id="tabbed-widget_<?php echo $randonNumber; ?>" >
      <?php foreach( $this->paginator as $item ): ?>
        <li class="sesprayers_list_item new_image_pinboard_<?php echo $randonNumber; ?>" >
        	<section>
          	<header class="sesbasic_clearfix">
            	<div class="_owner_thumb">
              	<?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle()), array('class' => '')) ?>
              </div>
              <div class="_owner_info">
                  <div class="_owner_name"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
                  <div class="sesbasic_text_light _date">
                    <?php echo $this->translate('Posted');?>
                    <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                  </div>
              </div>
              	<div class="_options">
               		<span class="_options_toggle fa fa-ellipsis-v sesbasic_text_light"></span>
                	<div class="_options_pulldown">
                    <?php echo $this->htmlLink(array(
                      'action' => 'edit',
                      'prayer_id' => $item->getIdentity(),
                      'route' => 'sesprayer_specific',
                      'reset' => true,
                    ), $this->translate('Edit'), array(
                      'class' => 'icon_prayer_edit sessmoothbox',
                    )) ?>
                    <?php
                    echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprayer', 'controller' => 'index', 'action' => 'delete', 'prayer_id' => $item->getIdentity(), 'format' => 'smoothbox'), $this->translate('Delete'), array(
                      'class' => 'smoothbox icon_prayer_delete'
                    ));
                    ?>
                	</div>
            		</div>
            </header>
            <div class='_content'>
              <div id="sesprayer_description_content_<?php echo $item->getIdentity(); ?>" class='sesprayer_feed_prayer _des'>
                <?php if($item->mediatype == 1 && !empty($item->photo_id)) { ?>
                  <div class="sesprayer_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
                <?php } else if($item->mediatype == 2 && $item->code) { ?>
                  <div class="sesprayer_video"><?php echo $item->code; ?></div>
                <?php } ?>
                <?php if(!empty($item->prayertitle)) { ?>
                  <div class="sesprayer_title">  
                    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->prayertitle; ?></a>
                    <?php } else { ?>
                      <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>/actionparam/manage/' class="sessmoothbox" href="javascript:;"><?php echo $item->prayertitle; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="sesprayer_prayer">
                  <?php echo nl2br($item->title); ?>
                </div>
                <?php if($item->source) { ?>
                  <div class="sesbasic_text_light sesprayer_prayer_src">&mdash; <?php echo $item->source; ?></div>
                <?php } ?>
              </div>
              <?php $tags = $item->tags()->getTagMaps(); ?>
              <?php if (count($tags)):?>
                <div class="_tags">
                  <?php foreach ($tags as $tag): ?>
                    <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <div class="_stats sesbasic_text_light">
                <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                </span>
                <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                  <i class="fa fa-comment"></i>
                  <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
                </span>
                <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                  <i class="fa fa-eye"></i>
                  <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
                </span>
                <?php if($item->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.enablecategory', 1)) { ?>
                  <span>-&nbsp;
                    <?php $category = Engine_Api::_()->getItem('sesprayer_category', $item->category_id); ?>
                    <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                  </span>
                <?php } ?>
                <span>-&nbsp;
                  <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                    <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
                  <?php } else { ?>
                    <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>/actionparam/manage/' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
                  <?php } ?>
                </span>
              </div>
            </div>
            <div class="_footer sesbasic_clearfix sesprayer_social_btns">
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowshare', 1)):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => 0, 'socialshare_icon_limit' => 2)); ?>
              <?php endif;?>
              <?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
              <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesprayer_prayer', $viewer, 'create');?>
              <?php if($canComment):?>
                <?php $likeStatus = Engine_Api::_()->sesprayer()->getLikeStatus($item->prayer_id,$item->getType()); ?>
                <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->prayer_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesprayer_like_<?php echo $item->prayer_id ?> sesprayer_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
              <?php endif;?>
            </div>
          </section>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php elseif($this->search): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any prayer entries that match your search criteria.');?>
      </span>
    </div>
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have created any prayer.');?>
        <?php if( $this->canCreate ): ?>
          <?php echo $this->translate('Get started by %1$swriting%2$s a new prayer.', '<a class="sessmoothbox" href="'.$this->url(array('action' => 'create'), 'sesprayer_general').'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
  <?php endif; ?>

  <?php echo $this->paginationControl($this->paginator, null, null, array(
    'pageAsQuery' => true,
    'query' => $this->formValues,
    //'params' => $this->formValues,
  )); ?>

<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"manage"),"sesprayer_general",true); ?>'+'?tag_id='+tag_id;
	}
	
  sesJqueryObject(document).on('click', '.sesprayer_expand', function() {

    sesJqueryObject(this).parent().find('._des').css('max-height','none');
    //sesJqueryObject(this).hide();
    sesJqueryObject(this).closest('.sesprayers_list_item').addClass('sesprayer_content_open');
    imageLoadedAll<?php echo $randonNumber ?>(1);
  });

  var wookmark = undefined;
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force) {
    sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
    imageLoadedAll<?php echo $randonNumber ?>(force);
  }
  
  function imageLoadedAll<?php echo $randonNumber ?>(force) {
  
    sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
    if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
      (function() {
        function getWindowWidth() {
          return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
        }
        wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
          itemWidth: <?php echo isset($this->allParams['width']) ? str_replace(array('px','%'),array(''),$this->allParams['width']) : '250'; ?>, // Optional min width of a grid item
          outerOffset: 0, // Optional the distance from grid to parent
          align:'left',
          flexibleWidth: function () {
            // Return a maximum width depending on the viewport
            return getWindowWidth() < 1024 ? '100%' : '40%';
          }
        });
      })();
    } else {
      wookmark<?php echo $randonNumber ?>.initItems();
      wookmark<?php echo $randonNumber ?>.layout(true);
    }
  }
  
  sesJqueryObject(document).ready(function(){
    pinboardLayout_<?php echo $randonNumber ?>();
  });
	
	sesJqueryObject(document).on('click','._options_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	
  $$('.core_main_prayer').getParent().addClass('active');
</script>
