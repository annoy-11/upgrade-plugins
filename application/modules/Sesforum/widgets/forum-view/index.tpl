<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = $this->identityForWidget;?>
 <?php $moduleName = 'sesforum';?>
<?php if(!$this->is_ajax){  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>
<div class="sesforum_forum_view sesbasic_bxs" id = "sesforum_forum_view_<?php echo $randonNumber; ?>">
<?php if(($this->showModerators || isset($this->postTopicButton))): ?>
  <div class="sesforum_forum_view_header sesbasic_clearfix sesbasic_lbg">
   <?php if($this->showModerators && count($this->moderators) > 0): ?>
    <div class="floatL sesforum_moderators">
        <b><?php echo $this->translate('Moderators:');?></b>
        <?php echo $this->fluentList($this->moderators) ?>
    </div>
     <?php endif; ?>
    <?php if($this->canPost && isset($this->postTopicButton)): ?>
      <div class="floatR sesforum_option">
        <!--<a href="javascript:void(0);" class="sesbasic_button sesbasic_icon_follow"><?php //echo $this->translate("Follow")?></a>-->
        <?php echo $this->htmlLink($this->sesforum->getHref(array(
          'action' => 'topic-create',
        )), $this->translate('Post New Topic'), array(
          'class' => 'sesforum_button sesbasic_icon_add sesbasic_animation'
        )) ?>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>
 <?php } ?>
  <?php if( count($this->paginator) > 0 ): ?>
   <?php if(!$this->is_ajax){  ?>
     <?php if(isset($this->show_data) && $this->show_data != 0 ): ?> 
      <div class="sesforum_forum_view_result">
      	<?php echo $this->translate(array('%s Topic found.', '%s Topics found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
      </div>
    <?php endif; ?>
    <div class="sesforum_topics_listing sesbasic_bxs">
      <ul id="forums-widget_<?php echo $randonNumber; ?>">
    <?php } ?>
        <?php foreach( $this->paginator as $i => $topic ):
          $last_post = $topic->getLastCreatedPost();
          if( $last_post ) {
            $last_user = $this->user($last_post->user_id);
          } else {
            $last_user = $this->user($topic->user_id);
          }
        ?>
          <li class="sesforum_nth_<?php echo $i % 2; ?>">
            <div class="sesforum_deatails">
             <?php if(isset($this->ownerPhoto)): ?> 
                <div class="sesforum_owner">
                    <?php echo $this->htmlLink($topic->getOwner()->getHref(), $this->itemPhoto($topic->getOwner(), 'thumb.icon')) ?>
                </div>
               <?php endif; ?>
              <div class="sesforum_info">
                <div class="_title<?php if( $topic->closed ): ?> closed<?php endif; ?><?php if( $topic->sticky ): ?> sticky<?php endif; ?>">
                    <?php echo $this->htmlLink($topic->getHref(), $topic->getTitle());?>
                </div>
                <p class="sesforum_date sesbasic_font_small sesbasic_text_light">
                <?php if(isset($this->ownerName)): ?> 
                  <span><?php echo $this->htmlLink($topic->getOwner()->getHref(), $topic->getOwner()->getTitle());?></span>
                <?php endif; ?>
                <?php if(isset($this->showDatetime)): ?>
                  <span><?php echo $this->timestamp($topic->creation_date); ?></span>
                <?php endif; ?>
                <?php if(isset($this->likeCount)): ?>
                  <span><i class="sesbasic_icon_like"></i> <?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?></span>
                <?php endif; ?>
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.rating', 1) && isset($this->ratings)) { ?>
                  <span class="sesforum_rating_star">
                    <?php for( $x=1; $x<=$topic->rating; $x++ ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star rating_star"></span>
                    <?php endfor; ?>
                    <?php if( (round($topic->rating) - $topic->rating) > 0): ?>
                      <span class="sesbasic_rating_star_small fa fa-star-half-o"></span>
                    <?php endif; ?>
                    <?php for( $x=5; $x>round($topic->rating); $x-- ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star sesbasic_rating_star_small_disable"></span>
                    <?php endfor; ?>
                  </span>
                  <?php } ?>
                </p>
                <?php $valueTags = Engine_Api::_()->sesforum()->tagCloudItemCore('fetchAll',null,$topic->getIdentity()); ?>
                <?php if(isset($this->tags) && count($valueTags) > 0): ?> 
                	<div class="sesbasic_tags" >
                  	<?php foreach($valueTags as $valueTag): ?>
                    	<a href="<?php echo $this->url(array('module' => 'sesforum', 'controller' => 'index', 'action' => 'search'), 'default', true).'?tag_id='.$valueTag['tag_id'].'&tag_name='.$valueTag['text']  ;?>" ><?php echo $valueTag['text'] ?></sup></a>
                  	<?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <p class="sesbasic_font_small"><?php echo $this->pageLinks($topic, $this->sesforum_topic_pagelength, null, 'sesforum_pagelinks') ?></p>
              </div>
            </div>
            <div class="sesforum_stats">
             <?php if(isset($this->viewCount)): ?>
              <div class="sesforum_views">
                <span class="_count">
                  <?php echo $this->translate(array('%1$s %2$s view', '%1$s %2$s views', $topic->view_count), $this->locale()->toNumber($topic->view_count), '</span><span class="_label sesbasic_text_light">') ?>
                </span>
              </div>
               <?php endif; ?>
              <?php if(isset($this->replyCount)): ?>
                <div class="sesforum_replies">
                    <span class="_count">
                    <?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $topic->post_count-1), $this->locale()->toNumber($topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?>
                    </span>
                </div>
               <?php endif; ?>
            </div>
            <?php if(isset($this->latestPostDetails)): ?>
            <div class="sesforum_lastpost">
              <?php if( $last_post):
                list($openTag, $closeTag) = explode('-----', $this->htmlLink($last_post->getHref(array('slug' => $topic->getSlug())), '-----'));
                ?>
                <div class="sesforum_lastpost_owner_thumb">
                  <span><?php echo $this->htmlLink($last_post->getHref(), $this->itemPhoto($last_user, 'thumb.icon')) ?></span>
                </div>
                <div class="sesforum_topics_lastpost_info">
                  <div class="sesforum_lastpost_ownerinfo sesbasic_text_light sesbasic_font_small">                  
                    <?php echo $this->translate(
                      '%1$sLast post%2$s by %3$s',
                      $openTag,
                      $closeTag,
                      $this->htmlLink($last_user->getHref(), $last_user->getTitle())
                    )?>
                  </div>
                  <div class="sesforum_lastpost_post sesbasic_text_light sesbasic_font_small">
                    <?php echo $this->timestamp($topic->modified_date, array('class' => 'sesforum_topics_lastpost_date')) ?>
                  </div>
                </div>  
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>

<?php if(!$this->is_ajax){  ?>
    </ul>
    <?php if($this->load_content != 'pagging'): ?>
        <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
        <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
    <?php endif;?>
</div>
<?php } ?>
  <?php elseif( preg_match("/search=/", $_SERVER['REQUEST_URI'] )): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has created a topic with that criteria.');?>
      </span>
    </div> 
  <?php else: ?>
    <div class="tip">
      <span><?php echo $this->translate('There are no topics yet.') ?></span>
    </div>
  <?php endif; ?>
    <div class="sesforum_pages">
    </div>
 <?php if(!$this->is_ajax){  ?>
</div>
<?php } ?>
<script type="text/javascript">
  $$('.core_main_sesforum').getParent().addClass('active');
</script>

<script type="text/javascript">
  function forumshow(id, value) {
    if($(id).style.display == 'block') {
      $(id).style.display = 'none';
      sesJqueryObject('#forumcat_'+value).removeClass('fa-minus');
      sesJqueryObject('#forumcat_'+value).addClass('fa-plus');
    } else {
      $(id).style.display = 'block';
      sesJqueryObject('#forumcat_'+value).addClass('fa-minus');
      sesJqueryObject('#forumcat_'+value).removeClass('fa-plus');
    }
  }

    var isSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->load_content != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();	
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){ 
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
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
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
						if(!isSearch) {
							document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } else{ ?>
			function paggingNumber<?php echo $randonNumber; ?>(pageNum){
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params : params<?php echo $randonNumber; ?>,
						is_ajax : 1,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('ses_pagging_128738hsdkfj'))
                document.getElementById('ses_pagging_128738hsdkfj').remove();
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none'); 
						document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
						var paginatorhtml = document.getElementById('ses_pagging_128738hsdkfj');
							if($('ses_pagging_128738hsdkfj'))
                document.getElementById('ses_pagging_128738hsdkfj').remove();
						if(paginatorhtml) {
                document.getElementById('sesforum_forum_view_<?php echo $randonNumber; ?>').appendChild(paginatorhtml);
						}
						if(isSearch){
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
		  var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->load_content == 'auto_load'){ ?>
			window.addEvent('load', function() {
				sesJqueryObject(window).scroll( function() {
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#forums-widget_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
<?php } ?>
</script>
