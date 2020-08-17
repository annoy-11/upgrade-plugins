<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showDiscussionListGrid.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $params = $this->params;
    $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php  if(!$this->is_ajax): ?>
  <style>
    .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css'); ?> 
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<?php endif;?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>

<?php if($this->profile_discussions == true):?>
  <?php $moduleName = 'sesdiscussion';?>
<?php else:?>
  <?php $moduleName = 'sesdiscussion';?>
<?php endif;?>

<?php $counter = 0;?>
<?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
  <script type="application/javascript">
      en4.core.runonce.add(function() {
          sesJqueryObject('#tab-widget-sesdiscussion-<?php echo $randonNumber; ?>').parent().css('display', 'none');
          sesJqueryObject('.sesdiscussion_container_tabbed<?php echo $randonNumber; ?>').css('border', 'none');
      });
  </script>
<?php endif;?>

<?php if(!$this->is_ajax){ ?>
	<div class="sesbasic_view_type sesbasic_clearfix clear" style="display:<?php echo $this->bothViewEnable ? 'block' : 'none'; ?>;height:<?php echo $this->bothViewEnable ? '' : '0px'; ?>">
		<?php if(isset($this->show_item_count) && $this->show_item_count){ ?>
			<div class="sesbasic_clearfix sesbm sesdiscussion_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesdiscussion' : 'paginator_count_ajax_sesdiscussion' ?>"><span id="total_item_count_sesdiscussion" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("discussion found.") : $this->translate("discussions found."); ?></div>
		<?php } ?>
		<div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
			<?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="pinboard" id="sesdiscussion_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Pinboard View') : '' ; ?>"></a>
			<?php } ?>

		</div>
	</div>
<?php } ?>

<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
    <ul class="sesdiscussion_discussion_listing sesbasic_clearfix clear <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>

<?php foreach( $this->paginator as $item ): ?>
  <li class="sesdiscussions_listing_item" >  
    <?php if($this->votingActive && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowvoting', 1)) { ?>
      <div class="_votebtns floatL">
        <?php echo $this->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $item)); ?>
        <?php if($this->newlabelActive && $item->new) { ?>
          <div class="sesdiscussions_new_label _ih"><?php echo $this->translate("New");?></div>
        <?php } ?>
      </div>
    <?php } ?>
    <div id="sesdiscussion_description_content_<?php echo $item->getIdentity(); ?>" class='_cont'>
      <?php if($this->titleActive && !empty($item->title)) { ?>
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
        <?php if($this->postedbyActive || $this->posteddateActive): ?>
          <?php if($this->postedbyActive): ?>
            <div class="_owner_name sesbasic_text_light">
              by <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
            </div>
          <?php endif; ?>
          <?php if($this->posteddateActive) : ?>
            <?php if($this->postedbyActive): ?>
              <div class="sesbasic_text_light">-</div>
            <?php endif; ?>
            <div class="sesbasic_text_light _date">
              <i class="fa fa-clock-o"></i><?php echo $this->timestamp(strtotime($item->creation_date)) ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <?php if($this->favouritecountActive && $this->likecountActive || $this->commentcountActive || $this->viewcountActive || $this->categoryActive || $this->permalinkActive): ?>
          <div class="_stats sesbasic_text_light">
            <span>-</span>
            <?php if($this->likecountActive) { ?>
              <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                <i class="fa fa-thumbs-up"></i>
                <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
              </span>
            <?php } ?>
            <?php if($this->favouritecountActive) { ?>
              <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>">
                <i class="fa fa-heart"></i>
                <span><?php echo $this->locale()->toNumber($item->favourite_count) ?></span>
              </span>
            <?php } ?>
            <?php if($this->followcountActive) { ?>
              <span title="<?php echo $this->translate(array('%s Follow', '%s Follows', $item->follow_count), $this->locale()->toNumber($item->follow_count)) ?>">
                <i class="fa fa-check"></i>
                <span><?php echo $this->locale()->toNumber($item->follow_count) ?></span>
              </span>
            <?php } ?>
            <?php if($this->commentcountActive) { ?>
              <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                <i class="fa fa-comment"></i>
                <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
              </span>
            <?php } ?>
            <?php if($this->viewcountActive) { ?>
              <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                <i class="fa fa-eye"></i>
                <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
              </span>
            <?php } ?>
            <?php if($this->categoryActive && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1) && $item->category_id) { ?>
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
      <?php if($this->descriptionActive) { ?>
        <div class="_des">
          <?php $discussiontitle = Engine_String::strlen($item->discussiontitle)>$this->allParams['description_truncation']? Engine_String::substr($item->discussiontitle,0,($this->allParams['description_truncation'])).'...' : $item->discussiontitle; ?>
          <?php echo nl2br($discussiontitle); ?>
        </div>
      <?php } ?>
      <?php if($this->sourceActive && $item->link) { ?>
        <div class="sesbasic_text_light _link"><a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a></div>
      <?php } ?>
      <?php $tags = $item->tags()->getTagMaps(); ?>
      <?php if ($this->tagsActive && count($tags)):?>
        <div class="_tags">
          <?php foreach ($tags as $tag): ?>
            <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="_footer sesbasic_clearfix">
        <div class="sesbasic_clearfix _social_btns">
          <?php if($this->socialSharingActive && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.allowshare', 1)):?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->allParams['socialshare_icon_limit'])); ?>
          <?php endif;?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'create');?>
          <?php if($this->likebuttonActive && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->sesdiscussion()->getLikeStatus($item->discussion_id,$item->getType()); ?>
            <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdiscussion_like_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
          <?php endif;?>
          
          <?php if($this->favouritebuttonActive && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1)): ?>
            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdiscussion')->isFavourite(array('resource_type'=>'discussion','resource_id'=>$item->discussion_id)); ?>
            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesdiscussion_favourite_sesdiscussion_discussion_<?php echo $item->discussion_id ?> sesdiscussion_favourite_sesdiscussion_discussion <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->discussion_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
          <?php endif;?>
          
          <?php if($this->followbuttonActive && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.follow.active', 1)):?>
            <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->isFollow(array('resource_id' => $item->discussion_id,'resource_type' => $item->getType())); ?>
            <a href="javascript:;" data-type="follow_view" data-url="<?php echo $item->discussion_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesdiscussion_follow_<?php echo $item->discussion_id ?> sesdiscussion_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $item->follow_count;?></span></a>
          <?php endif;?>
        </div>
        
      </div>
    </div>
  </li>
<?php endforeach; ?>

<?php  if(  $this->paginator->getTotalItemCount() == 0 &&  (empty($this->widgetType))){  ?>
  <?php if( isset($this->category) || isset($this->tag) || isset($this->text) ):?>
    <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has posted a discussion with that criteria.');?>
      </span>
    </div>
  <?php else:?>
    <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has created a discussion yet.');?>
      </span>
    </div>
  <?php endif; ?>
<?php }else if( $this->paginator->getTotalItemCount() == 0 && isset($this->tabbed_widget) && $this->tabbed_widget){?>
  <div class="tip">
    <span>
      <?php $errorTip = ucwords(str_replace('SP',' ',$this->defaultOpenTab)); ?>
      <?php echo $this->translate("There are currently no %s",$errorTip);?>
    </span>
  </div>
<?php } ?>
  
<?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesdiscussion"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
  
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->loadOptionData != 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')):?>
    <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
    <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
  <?php endif;?>
  </div>

  <script type="text/javascript">
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
			window.addEvent('load', function() {
				sesJqueryObject(window).scroll( function() {
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
    <?php } ?>
    sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){
      if(sesJqueryObject(this).hasClass('active'))
      return;
      if($("view_more_<?php echo $randonNumber; ?>"))
      document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
      document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
      sesJqueryObject('#sesdiscussion_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject(this).addClass('active');
      if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				requestTab_<?php echo $randonNumber; ?>.cancel();
      }
      if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
				requestViewMore_<?php echo $randonNumber; ?>.cancel();
      }
      requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
				'data': {
					format: 'html',
					page: 1,
					type:sesJqueryObject(this).attr('rel'),
					params : <?php echo json_encode($this->params); ?>, 
					is_ajax : 1,
					searchParams: searchParams<?php echo $randonNumber; ?>,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
					if($("loading_image_<?php echo $randonNumber; ?>"))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
					pinboardLayout_<?php echo $randonNumber ?>('true');
				}
      })).send();
    });
  </script>
<?php } ?>

<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->loadOptionData != 'pagging'){ ?>
            en4.core.runonce.add(function() {
				viewMoreHide_<?php echo $randonNumber; ?>();
			});
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';

				if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
                    requestViewMore_<?php echo $randonNumber; ?>.cancel();
                }
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
						searchParams:searchParams<?php echo $randonNumber; ?> ,
						identity : '<?php echo $randonNumber; ?>',
						identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesdiscussion-wrapper'))
						sesJqueryObject('#loadingimgsesdiscussion-wrapper').hide();

						if(!isSearch) {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							isSearch = false;
						}
						document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php }else{ ?>
			function paggingNumber<?php echo $randonNumber; ?>(pageNum){
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
                if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
                    requestViewMore_<?php echo $randonNumber; ?>.cancel();
                }
				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params :params<?php echo $randonNumber; ?> , 
						is_ajax : 1,
						searchParams:searchParams<?php echo $randonNumber; ?>  ,
						identity : identity<?php echo $randonNumber; ?>,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesdiscussion-wrapper'))
						sesJqueryObject('#loadingimgsesdiscussion-wrapper').hide();
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
						document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
	</script>
<?php } ?>
