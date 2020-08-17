<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $allParams = $this->allParams; ?>
<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesquote/externals/styles/styles.css');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');
?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) { ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/mention/jquery.mentionsInput.css'); ?>    
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/underscore-min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/jquery.mentionsInput.js'); ?>
<?php } ?>
<?php $randonNumber = 8000; ?>

<script type="text/javascript">
  
  if(typeof page != "undefined")
    page = page;
  else 
    page = "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>";
  function loadMoreQUOTE() {
  
    if ($('quote_view_more'))
      $('quote_view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('quote_view_more'))
      document.getElementById('quote_view_more').style.display = 'none';
    
    if(document.getElementById('quote_loading_image'))
     document.getElementById('quote_loading_image').style.display = 'block';

    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/sesquote/name/browse-quotes',
      'data': {
        format: 'html',
        page: page,
        viewmore: 1,
        identity: '<?php echo $this->identityForWidget; ?>',
        params: '<?php echo json_encode($this->allParams); ?>',
        searchParams: searchParams,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        //if($('loadingimgsesquote-wrapper'))
        sesJqueryObject('#loadingimgsesquote-wrapper').hide();
        
        
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
        
        pinboardLayout_<?php echo $randonNumber ?>();
        
        if(document.getElementById('quote_view_more'))
          document.getElementById('quote_view_more').destroy();
        if(document.getElementById('quote_view_more'))
          document.getElementById('quote_view_more').style.display = 'block';
        if(document.getElementById('quote_loading_image'))
          document.getElementById('quote_loading_image').destroy();
        if(document.getElementById('quote_loading_image'))
         document.getElementById('quote_loading_image').style.display = 'none';
        if(document.getElementById('quote_loadmore_list'))
          document.getElementById('quote_loadmore_list').destroy();
      }
    }));
    return false;
  }

</script>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <?php if (empty($this->viewmore)): ?>
      <div class="sesbasic_bxs sesbasic_clearfix">
        <ul class="prelative sesquotes_listing sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:195px;" id="tabbed-widget_<?php echo $randonNumber; ?>" >
    <?php endif; ?>
      <?php foreach( $this->paginator as $item ): ?>
        <li class="sesquotes_list_item new_image_pinboard_<?php echo $randonNumber; ?>" >
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
              <div id="sesquote_description_content_<?php echo $item->getIdentity(); ?>" class='sesquote_feed_quote _des'>
                <?php if($item->mediatype == 1 && !empty($item->photo_id)) { ?>
                  <div class="sesquote_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
                <?php } else if($item->mediatype == 2 && $item->code) { ?>
                  <div class="sesquote_video"><?php echo $item->code; ?></div>
                <?php } ?>
                <?php if(in_array('title', $this->allParams['stats']) && !empty($item->quotetitle)) { ?>
                  <div class="sesquote_title">  
                    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.show', 0)) { ?>
                      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->quotetitle; ?></a>
                    <?php } else { ?>
                      <a data-url='sesquote/index/quote-popup/quote_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $item->quotetitle; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="sesquote_quote">
                  <?php if(strlen(nl2br($item->title)) > $this->descriplimit):?>
                    <?php $title = mb_substr(nl2br($item->title),0,$this->descriplimit).'...';?>
                      <?php echo $title;?>
                    <?php else: ?>
                      <?php echo nl2br($item->title); ?>
                  <?php endif;?>
                  <?php //echo nl2br($item->title); ?>
                </div>
                <?php if(in_array('source', $this->allParams['stats']) && $item->source) { ?>
                  <div class="sesbasic_text_light sesquote_quote_src">&mdash; <?php echo $item->source; ?></div>
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
                  <?php if(in_array('category', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.enablecategory', 1) && $item->category_id) { ?>
                    <span> 
                      <?php $category = Engine_Api::_()->getItem('sesquote_category', $item->category_id); ?>
                      -&nbsp;<a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </span>
                  <?php } ?>
                  <?php if(in_array('permalink', $this->allParams['stats'])) { ?>
                    <span>-&nbsp;
                      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.show', 0)) { ?>
                        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
                      <?php } else { ?>
                        <a data-url='sesquote/index/quote-popup/quote_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
                      <?php } ?>
                    </span>
                  <?php } ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="_footer sesbasic_clearfix sesquote_social_btns">
              <?php if(in_array('socialSharing', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.allowshare', 1)):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
              <?php endif;?>
              <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesquote_quote', $viewer, 'create');?>
              <?php if(in_array('likebutton', $this->allParams['stats']) && $canComment):?>
                <?php $likeStatus = Engine_Api::_()->sesquote()->getLikeStatus($item->quote_id,$item->getType()); ?>
                <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->quote_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesquote_like_<?php echo $item->quote_id ?> sesquote_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
              <?php endif;?>
            </div>
          </section>
        </li>
      <?php endforeach; ?>
    <?php if (empty($this->viewmore)): ?>
        </ul>
      </div>
    <?php endif; ?>
    
  <?php if ($allParams['pagging'] == 'button' && !empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clr" id="quote_loadmore_list"></div>
      <div class="sesbasic_load_btn" id="quote_view_more" onclick="loadMoreQUOTE();" style="display: block;">
        <a href="javascript:void(0);" id="feed_viewmore_link" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More'); ?></span></a>
      </div>
      <div class="sesbasic_load_btn" id="quote_loading_image" style="display: none;">
        <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  <div class="sesbasic_loading_cont_overlay" style="display:none;"></div>
<?php elseif( $this->category || $this->show == 2 || $this->search ): ?>
  <div class="sesbasic_tip">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote_quote_no_photo', 'application/modules/Sesquote/externals/images/quote-icon.png'); ?>" alt="" />
    <span>
      <?php echo $this->translate('Nobody has written a quote entry with that criteria.');?>
      <?php if (TRUE): // @todo check if user is allowed to create a poll ?>
        <?php //echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'sesquote_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php else:?>
  <div class="sesbasic_tip">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote_quote_no_photo', 'application/modules/Sesquote/externals/images/quote-icon.png'); ?>" alt="" />
    <span>
      <?php echo $this->translate('Nobody has written a quote entry yet.'); ?>
      <?php if( $this->canCreate ): ?>
        <?php //echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'sesquote_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php endif; ?>


<?php if($allParams['pagging'] == 'pagging') { ?>
  <?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
<?php } ?>

<?php if (empty($this->viewmore)): ?>
<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesquote_general",true); ?>'+'?tag_id='+tag_id;
	}
	
//   sesJqueryObject(document).on('click', '.sesquote_expand', function() {
// 
//     sesJqueryObject(this).parent().find('._des').css('max-height','none');
//     //sesJqueryObject(this).hide();
//     sesJqueryObject(this).closest('.sesquotes_list_item').addClass('sesquote_content_open');
//     imageLoadedAll<?php //echo $randonNumber ?>(1);
//   });

  var wookmark = undefined;
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force) {
    sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','block');
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

    en4.core.runonce.add(function() {
    pinboardLayout_<?php echo $randonNumber ?>();
  });

</script>
<?php endif; ?>
<?php if($allParams['pagging'] == 'auto_load'): ?>
  <script type="text/javascript">    
     //Take refrences from: http://mootools-users.660466.n2.nabble.com/Fixing-an-element-on-page-scroll-td1100601.html
    //Take refrences from: http://davidwalsh.name/mootools-scrollspy-load
    en4.core.runonce.add(function() {
      var paginatorCount = '<?php echo $this->paginator->count(); ?>';
      var paginatorCurrentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
      function ScrollLoader() { 
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if($('quote_loadmore_list')) {
          if (scrollTop > 40)
            loadMoreQUOTE();
        }
      }
      window.addEvent('scroll', function() {
        ScrollLoader(); 
      });
    });    
  </script>
<?php endif; ?>
