<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
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

  en4.core.runonce.add(function() {

    <?php if( !$this->renderOne ): ?>
    
      var anchor = $('tabbed-widget_<?php echo $randonNumber; ?>').getParent();
      
      $('sesprayer_profile_previous').style.display = '<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>';
      $('sesprayer_profile_next').style.display = '<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>';

      $('sesprayer_profile_previous').removeEvents('click').addEvent('click', function() {
        en4.core.request.send(new Request.HTML({
          url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
          data : {
            format : 'html',
            subject : en4.core.subject.guid,
            is_ajax:1,
            page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>,
            params:'<?php echo json_encode($this->allParams); ?>',
          }
        }), {
          'element' : anchor
        });
        pinboardLayout_<?php echo $randonNumber ?>();
      });

      $('sesprayer_profile_next').removeEvents('click').addEvent('click', function(){
        en4.core.request.send(new Request.HTML({
          url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
          data : {
            format : 'html',
            subject : en4.core.subject.guid,
            is_ajax:1,
            page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>,
            params:'<?php echo json_encode($this->allParams); ?>',
          }
        }), {
          'element' : anchor
        });
        pinboardLayout_<?php echo $randonNumber ?>();
      });
    <?php endif; ?>

  });
</script>


<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
	<div class="sesbasic_bxs sesbasic_clearfix">
    <ul class="prelative sesprayers_listing sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:50px;" id="tabbed-widget_<?php echo $randonNumber; ?>" >
      <?php foreach( $this->paginator as $item ): ?>
      
        <li class="sesprayers_list_item new_image_pinboard_<?php echo $randonNumber; ?>" >
        	<section>
          	<header class="sesbasic_clearfix">
            	<div class="_owner_thumb">
              	<?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle()), array('class' => '')) ?>
              </div>
              <?php if(in_array('postedby', $this->allParams['stats']) || in_array('posteddate', $this->allParams['stats'])): ?>
                <div class="_owner_info">
                  <?php if(in_array('postedby', $this->allParams['stats'])): ?>
                    <div class="_owner_name"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
                  <?php endif; ?>
                  <?php if(in_array('posteddate', $this->allParams['stats'])) : ?>
                    <div class="sesbasic_text_light _date">
                      <?php echo $this->translate('Posted');?>
                      <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </header>
            <div class='_content'>
              <div id="sesprayer_description_content_<?php echo $item->getIdentity(); ?>" class='sesprayer_feed_prayer _des'>
                <?php if($item->mediatype == 1 && !empty($item->photo_id)) { ?>
                  <div class="sesprayer_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
                <?php } else if($item->mediatype == 2 && $item->code) { ?>
                  <div class="sesprayer_video"><?php echo $item->code; ?></div>
                <?php } ?>
                <?php if(in_array('title', $this->allParams['stats']) && !empty($item->prayertitle)) { ?>
                  <div class="sesprayer_title">  
                    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->prayertitle; ?></a>
                    <?php } else { ?>
                      <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $item->prayertitle; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="sesprayer_prayer">
                  <?php echo nl2br($item->title); ?>
                </div>
                <?php if(in_array('source', $this->allParams['stats']) && $item->source) { ?>
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
              <?php if(in_array('likecount', $this->allParams['stats']) || in_array('commentcount', $this->allParams['stats']) || in_array('viewcount', $this->allParams['stats']) || in_array('category', $this->allParams['stats']) || in_array('permalink', $this->allParams['stats'])): ?>
                <div class="_stats sesbasic_text_light">
                  <?php if(in_array('likecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('commentcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                      <i class="fa fa-comment"></i>
                      <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('viewcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                      <i class="fa fa-eye"></i>
                      <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('category', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.enablecategory', 1) && $item->category_id) { ?>
                    <span> 
                      <?php $category = Engine_Api::_()->getItem('sesprayer_category', $item->category_id); ?>
                      -&nbsp;<a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </span>
                  <?php } ?>
                  <?php if(in_array('permalink', $this->allParams['stats'])) { ?>
                    <span>-&nbsp;
                      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
                        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
                      <?php } else { ?>
                        <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
                      <?php } ?>
                    </span>
                  <?php } ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="_footer sesbasic_clearfix sesprayer_social_btns">
              <?php if(in_array('socialSharing', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowshare', 1)):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
              <?php endif;?>
              <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesprayer_prayer', $viewer, 'create');?>
              <?php if(in_array('likebutton', $this->allParams['stats']) && $canComment):?>
                <?php $likeStatus = Engine_Api::_()->sesprayer()->getLikeStatus($item->prayer_id,$item->getType()); ?>
                <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->prayer_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesprayer_like_<?php echo $item->prayer_id ?> sesprayer_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
              <?php endif;?>
            </div>
          </section>
        </li>
      <?php endforeach; ?>
    </ul>
    <div>
      <div id="sesprayer_profile_previous" class="paginator_previous">
        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
          'onclick' => '',
          'class' => 'buttonlink icon_previous'
        )); ?>
      </div>
      <div id="sesprayer_profile_next" class="paginator_next">
        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
          'onclick' => '',
          'class' => 'buttonlink_right icon_next'
        )); ?>
      </div>
    </div>
  </div>

<?php else:?>
  <div class="sesbasic_tip">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer_prayer_no_photo', 'application/modules/Sesprayer/externals/images/prayer-icon.png'); ?>" alt="" />
    <span>
      <?php echo $this->translate('There are no prayer entry yet.'); ?>
    </span>
  </div>
<?php endif; ?>

<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesprayer_general",true); ?>'+'?tag_id='+tag_id;
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
          itemWidth: <?php echo isset($this->allParams['width']) ? str_replace(array('px','%'),array(''),$this->allParams['width']) : '300'; ?>, // Optional min width of a grid item
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

</script>