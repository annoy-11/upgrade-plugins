<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $allParams = $this->allParams; ?>
<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');
?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) { ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/mention/jquery.mentionsInput.css'); ?>    
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/underscore-min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/jquery.mentionsInput.js'); ?>
<?php } ?>
<?php if($this->allParams['viewtype'] == 'pinboard' && !$this->viewmore){ 
	 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');
	 $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/pinboard.css'); 
   $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');
   $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');
 } ?>
<?php $randonNumber = 8000; ?>

<script type="text/javascript">

  function loadMoreDISCUSSION() {
  
    if ($('discussion_view_more'))
      $('discussion_view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('discussion_view_more'))
      document.getElementById('discussion_view_more').style.display = 'none';
    
    if(document.getElementById('discussion_loading_image'))
     document.getElementById('discussion_loading_image').style.display = 'block';

    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/sesdiscussion/name/browse-discussions',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->allParams); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
      console.log(responseHTML);

        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
        
        <?php if($this->allParams['viewtype'] == 'pinboard') { ?>
          pinboardLayout_<?php echo $randonNumber ?>();
        <?php } ?>
        
        if(document.getElementById('discussion_view_more'))
          document.getElementById('discussion_view_more').destroy();
        if(document.getElementById('discussion_view_more'))
          document.getElementById('discussion_view_more').style.display = 'block';
        if(document.getElementById('discussion_loading_image'))
          document.getElementById('discussion_loading_image').destroy();
        if(document.getElementById('discussion_loading_image'))
         document.getElementById('discussion_loading_image').style.display = 'none';
        if(document.getElementById('discussion_loadmore_list'))
          document.getElementById('discussion_loadmore_list').destroy();
      }
    }));
    return false;
  }

</script>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <?php if (empty($this->viewmore)): ?>
      <div class="sesbasic_bxs sesbasic_clearfix">
        <div class="sesbasic_clearfix"><span style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("discussion found.") : $this->translate("discussions found."); ?></div><br />
    <?php if($this->allParams['viewtype'] == 'pinboard') { ?>
        <ul class="<?php if($this->allParams['viewtype'] == 'list') { ?> dNone <?php } ?> prelative sesdiscussions_listing sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:50px;" id="tabbed-widget_<?php echo $randonNumber; ?>"  >
        <?php } ?>
    <?php endif; ?>
      <?php if($this->allParams['viewtype'] == 'pinboard') { ?>
      <?php foreach( $this->paginator as $item ): ?>
        <li class="sesdiscussions_list_item new_image_pinboard_<?php echo $randonNumber; ?>">
        	<section>
            <?php if(in_array('newlabel', $this->allParams['stats']) && $item->new) { ?>
              <div class="sesdiscussions_new_label _ir"><?php echo $this->translate("New");?></div>
          	<?php } ?>
          	<header class="sesbasic_clearfix">
            <?php if(in_array('title', $this->allParams['stats']) && !empty($item->title)) { ?>
                  <div class="sesdiscussion_title">  
                    <?php $title = Engine_String::strlen($item->title)>$this->allParams['title_truncation']? Engine_String::substr($item->title,0,($this->allParams['title_truncation'])).'...' : $item->title; ?>
                    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0)) { ?>
                      <a href="<?php echo $item->getHref(); ?>"><?php echo $title; ?></a>
                    <?php } else { ?>
                      <a data-url='sesdiscussion/index/discussion-popup/discussion_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $title; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
              <?php if(in_array('postedby', $this->allParams['stats']) || in_array('posteddate', $this->allParams['stats'])): ?>
                <div class="header_bottom">
                  <?php if(in_array('postedby', $this->allParams['stats'])): ?>
                    <div class="_owner_name">by <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
                  <?php endif; ?>
                  <?php if(in_array('posteddate', $this->allParams['stats'])) : ?>
                    <div class="sesbasic_text_light _date">
                      <i class="fa fa-clock-o"></i><?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </header>
            <div class='_content'>
              <div id="sesdiscussion_description_content_<?php echo $item->getIdentity(); ?>" class='sesdiscussion_feed_discussion _des'>
                <?php if(in_array($item->mediatype, array(1, 3)) && !empty($item->photo_id)) { ?>
                  <div class="sesdiscussion_img"><?php echo $this->itemPhoto($item, 'thumb.main') ?></div>
                <?php } else if($item->mediatype == 2 && $item->code) { ?>
                  <div class="sesdiscussion_video"><?php echo $item->code; ?></div>
                <?php } ?>
                <?php if(in_array('description', $this->allParams['stats'])) { ?>
                  <div class="sesdiscussion_discussion">
                    <?php $discussiontitle = Engine_String::strlen($item->discussiontitle)>$this->allParams['description_truncation']? Engine_String::substr($item->discussiontitle,0,($this->allParams['description_truncation'])).'...' : $item->discussiontitle; ?>
                  <?php echo nl2br($discussiontitle); ?>
                  </div>
                <?php } ?>
                <?php if(in_array('source', $this->allParams['stats']) && $item->link) { ?>
                  <div class="sesbasic_text_light sesdiscussion_discussion_link"><a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a></div>
                <?php } ?>
              </div>
              <?php $tags = $item->tags()->getTagMaps(); ?>
              <?php if (in_array('tags', $this->allParams['stats']) && count($tags)):?>
                <div class="_tags">
                  <?php foreach ($tags as $tag): ?>
                    <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if(in_array('followcount', $this->allParams['stats']) || in_array('favouritecount', $this->allParams['stats']) || in_array('likecount', $this->allParams['stats']) || in_array('commentcount', $this->allParams['stats']) || in_array('viewcount', $this->allParams['stats']) || in_array('category', $this->allParams['stats']) || in_array('permalink', $this->allParams['stats'])): ?>
                <div class="_stats sesbasic_text_light">
                  <?php if(in_array('likecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('favouritecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>">
                      <i class="fa fa-heart"></i>
                      <span><?php echo $this->locale()->toNumber($item->favourite_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('followcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Follow', '%s Follows', $item->follow_count), $this->locale()->toNumber($item->follow_count)) ?>">
                      <i class="fa fa-check"></i>
                      <span><?php echo $this->locale()->toNumber($item->follow_count) ?></span>
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
                  <?php if(in_array('category', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1) && $item->category_id) { ?>
                    <span> 
                      <?php $category = Engine_Api::_()->getItem('sesdiscussion_category', $item->category_id); ?>
                      -&nbsp;<a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </span>
                  <?php } ?>
                  <?php if(in_array('permalink', $this->allParams['stats'])) { ?>
                    <span>-&nbsp;
                      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0)) { ?>
                        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
                      <?php } else { ?>
                        <a data-url='sesdiscussion/index/discussion-popup/discussion_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
                      <?php } ?>
                    </span>
                  <?php } ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="_footer sesbasic_clearfix sesdiscussion_social_btns">
              <?php if(in_array('socialSharing', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
              <?php endif;?>
              <?php $canComment = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'create');?>
              <?php if(in_array('likebutton', $this->allParams['stats']) && $canComment):?>
                <?php $likeStatus = Engine_Api::_()->sesdiscussion()->getLikeStatus($item->discussion_id,$item->getType()); ?>
                <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdiscussion_like_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
              <?php endif;?>
              
							<?php if(in_array('favouritebutton', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdiscussion')->isFavourite(array('resource_type'=>'discussion','resource_id'=>$item->discussion_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesdiscussion_favourite_sesdiscussion_discussion_<?php echo $item->discussion_id ?> sesdiscussion_favourite_sesdiscussion_discussion <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->discussion_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
							
              <?php if(in_array('followbutton', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.follow.active', 1)):?>
                <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->isFollow(array('resource_id' => $item->discussion_id,'resource_type' => $item->getType())); ?>
                <a href="javascript:;" data-type="follow_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesdiscussion_follow_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $item->follow_count;?></span></a>
              <?php endif;?>

              <?php if(in_array('voting', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1)) { ?>
                <?php echo $this->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $item)); ?>
              <?php } ?>
            </div>
            <?php if(in_array('pinboardcomment', $this->allParams['stats'])){ ?>
              <div class="sesbasic_pinboard_list_comments sesbasic_clearfix">
                <?php $item_id = $item->getIdentity(); 
                $itemType = $item->getType(); ?>
                <?php if(($itemType != '')){ ?>
                  <?php echo Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment') ? $this->action('list', 'comment', 'sesadvancedcomment', array('type' => $itemType, 'id' => $item_id,'page'=>'')) :  $this->action("list", "comment", "sesbasic", array("item_type" => $itemType, "item_id" => $item_id,"widget_identity"=>$randonNumber)); ?>
                <?php } ?>
              </div>
             <?php } ?>
          </section>
        </li>
      <?php endforeach; ?>
      <?php } ?>
    <?php if (empty($this->viewmore) && $this->allParams['viewtype'] == 'pinboard'): ?>
        </ul>
    <?php endif; ?>
    
    
    <?php if (empty($this->viewmore) && $this->allParams['viewtype'] == 'list'): ?>
      <ul class="sesdiscussions_listing" id="tabbed-widget_<?php echo $randonNumber; ?>" >
    <?php endif; ?>
      <?php if($this->allParams['viewtype'] == 'list') { ?>
      <?php foreach( $this->paginator as $item ): ?>
        <li class="sesdiscussions_listing_item" >  
          <?php if(in_array('voting', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1)) { ?>
            <div class="_votebtns floatL">
              <?php echo $this->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $item)); ?>
              <?php if(in_array('newlabel', $this->allParams['stats']) && $item->new) { ?>
                <div class="sesdiscussions_new_label _ih"><?php echo $this->translate("New");?></div>
              <?php } ?>
            </div>
          <?php } ?>
          <div id="sesdiscussion_description_content_<?php echo $item->getIdentity(); ?>" class='_cont'>
            <?php if(in_array('title', $this->allParams['stats']) && !empty($item->title)) { ?>
              <div class="sesdiscussion_title"> 
                <?php $title = Engine_String::strlen($item->title)> @$this->allParams['title_truncation']? Engine_String::substr($item->title,0,(@$this->allParams['title_truncation'])).'...' : $item->title; ?>
                <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0)) { ?>
                  <a href="<?php echo $item->getHref(); ?>"><?php echo $title; ?></a>
                <?php } else { ?>
                  <a data-url='sesdiscussion/index/discussion-popup/discussion_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $title; ?></a>
                <?php } ?>
              </div>
            <?php } ?>
            <div class="_info sesbasic_clearfix">
              <?php if(in_array('postedby', $this->allParams['stats']) || in_array('posteddate', $this->allParams['stats'])): ?>
                <?php if(in_array('postedby', $this->allParams['stats'])): ?>
                  <div class="_owner_name sesbasic_text_light">
                   by <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
                  </div>
                <?php endif; ?>
                <?php if(in_array('posteddate', $this->allParams['stats'])) : ?>
                	<?php if(in_array('postedby', $this->allParams['stats'])): ?>
                  	<div class="sesbasic_text_light">-</div>
                  <?php endif; ?>
                  <div class="sesbasic_text_light _date">
                    <i class="fa fa-clock-o"></i><?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
              <?php if(in_array('favouritecount', $this->allParams['stats']) && in_array('likecount', $this->allParams['stats']) || in_array('commentcount', $this->allParams['stats']) || in_array('viewcount', $this->allParams['stats']) || in_array('category', $this->allParams['stats']) || in_array('permalink', $this->allParams['stats'])): ?>
                <div class="_stats sesbasic_text_light">
                	<span>-</span>
                  <?php if(in_array('likecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('favouritecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>">
                      <i class="fa fa-heart"></i>
                      <span><?php echo $this->locale()->toNumber($item->favourite_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('followcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Follow', '%s Follows', $item->follow_count), $this->locale()->toNumber($item->follow_count)) ?>">
                      <i class="fa fa-check"></i>
                      <span><?php echo $this->locale()->toNumber($item->follow_count) ?></span>
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
                  <?php if(in_array('category', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1) && $item->category_id) { ?>
                    <span>-</span>
                    <span> 
                      <?php $category = Engine_Api::_()->getItem('sesdiscussion_category', $item->category_id); ?>
                      <i class="fa fa-folder-open"></i>
                      <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </span>
                  <?php } ?>

                </div>
              <?php endif; ?>
            </div>
            <?php if(in_array('description', $this->allParams['stats'])) { ?>
              <div class="_des">
                <?php $discussiontitle = Engine_String::strlen($item->discussiontitle)>$this->allParams['description_truncation']? Engine_String::substr($item->discussiontitle,0,($this->allParams['description_truncation'])).'...' : $item->discussiontitle; ?>
                <?php echo nl2br($discussiontitle); ?>
              </div>
            <?php } ?>
            <?php if(in_array('source', $this->allParams['stats']) && $item->link) { ?>
              <div class="sesbasic_text_light _link"><a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a></div>
            <?php } ?>
            <?php $tags = $item->tags()->getTagMaps(); ?>
            <?php if (in_array('tags', $this->allParams['stats']) && count($tags)):?>
              <div class="_tags">
                <?php foreach ($tags as $tag): ?>
                  <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <div class="_footer sesbasic_clearfix">
              <div class="sesbasic_clearfix _social_btns">
                <?php if(in_array('socialSharing', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
                <?php endif;?>
                <?php $canComment = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'create');?>
                <?php if(in_array('likebutton', $this->allParams['stats']) && $canComment):?>
                  <?php $likeStatus = Engine_Api::_()->sesdiscussion()->getLikeStatus($item->discussion_id,$item->getType()); ?>
                  <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdiscussion_like_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
                <?php endif;?>
                
                <?php if(in_array('favouritebutton', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1)): ?>
                  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdiscussion')->isFavourite(array('resource_type'=>'discussion','resource_id'=>$item->discussion_id)); ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesdiscussion_favourite_sesdiscussion_discussion_<?php echo $item->discussion_id ?> sesdiscussion_favourite_sesdiscussion_discussion <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->discussion_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                <?php endif;?>
                
                <?php if(in_array('followbutton', $this->allParams['stats']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.follow.active', 1)):?>
                  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->isFollow(array('resource_id' => $item->discussion_id,'resource_type' => $item->getType())); ?>
                  <a href="javascript:;" data-type="follow_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesdiscussion_follow_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $item->follow_count;?></span></a>
                <?php endif;?>
              </div>
              
            </div>
          </div>
        </li>
      <?php endforeach; ?>
      <?php } ?>
    <?php if (empty($this->viewmore)): ?>
        </ul>
      </div>
    <?php endif; ?>
    
  <?php if (in_array($allParams['pagging'], array('autoload', 'button')) && !empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clr" id="discussion_loadmore_list"></div>
      <div class="sesbasic_load_btn" id="discussion_view_more" onclick="loadMoreDISCUSSION();" style="display: block;">
        <a href="javascript:void(0);" id="feed_viewmore_link" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More'); ?></span></a>
      </div>
      <div class="sesbasic_load_btn" id="discussion_loading_image" style="display: none;">
        <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  
<?php elseif( $this->category || $this->show == 2 || $this->search ): ?>
  <div class="sesbasic_tip">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion_discussion_no_photo', 'application/modules/Sesdiscussion/externals/images/discussion-icon.png'); ?>" alt="" />
    <span>
      <?php echo $this->translate('Nobody has written a discussion entry with that criteria.');?>
      <?php if (TRUE): // @todo check if user is allowed to create a poll ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'sesdiscussion_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php else:?>
  <div class="sesbasic_tip">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion_discussion_no_photo', 'application/modules/Sesdiscussion/externals/images/discussion-icon.png'); ?>" alt="" />
    <span>
      <?php echo $this->translate('Nobody has written a discussion entry yet.'); ?>
      <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'sesdiscussion_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php endif; ?>


<?php if($allParams['pagging'] == 'pagging') { ?>
  <?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
<?php } ?>


<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"sesdiscussion_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>

<?php if (empty($this->viewmore) && $this->allParams['viewtype'] == 'pinboard'): ?>
  <script type="application/javascript">

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
<?php endif; ?>

<?php if($allParams['pagging'] == 'autoload'): ?>
  <script type="text/javascript">    
     //Take refrences from: http://mootools-users.660466.n2.nabble.com/Fixing-an-element-on-page-scroll-td1100601.html
    //Take refrences from: http://davidwalsh.name/mootools-scrollspy-load
    en4.core.runonce.add(function() {
      var paginatorCount = '<?php echo $this->paginator->count(); ?>';
      var paginatorCurrentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
      function ScrollLoader() { 
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if($('discussion_loadmore_list')) {
          if (scrollTop > 40)
            loadMoreDISCUSSION();
        }
      }
      window.addEvent('scroll', function() {
        ScrollLoader(); 
      });
    });    
  </script>
<?php endif; ?>
