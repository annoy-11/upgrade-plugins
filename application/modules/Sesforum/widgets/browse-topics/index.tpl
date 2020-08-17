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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else: ?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php $moduleName = 'sesforum';?>

<?php if($this->paginator->getTotalItemCount() > 0) { ?>
 <?php if(!$this->is_ajax){  ?>
<div class="sesforum_topics_listing sesbasic_bxs">
  <ul id="forums-widget_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php foreach($this->paginator as $topic ):
      if($this->search_type == 'topics') { 
      $last_post = $topic->getLastCreatedPost();
      if( $last_post ) {
        $last_user = $this->user($last_post->user_id);
      } else {
        $last_user = $this->user($topic->user_id);
      }
      ?>
      
        <li>
          <div class="sesforum_deatails">
            <div class="sesforum_owner">
              <?php echo $this->htmlLink($topic->getOwner()->getHref(), $this->itemPhoto($topic->getOwner(), 'thumb.icon')) ?>
            </div>
            <div class="sesforum_info">
              <div class="_title<?php if( $topic->closed ): ?> closed<?php endif; ?><?php if( $topic->sticky ): ?> sticky<?php endif; ?>">
                <?php if(strlen($topic->getTitle()) > $this->title_truncation_limit): ?>
                    <?php $title = substr($topic->getTitle(),0,$this->title_truncation_limit).'...';?>
                    <?php echo $this->htmlLink($topic->getHref(), $title); ?>
                <?php else: ?>
                    <?php echo $this->htmlLink($topic->getHref(), $topic->getTitle()); ?>
                <?php endif;?>
              </div>
                <div class="_des sesbasic_font_small">
                <?php if(strlen($topic->description) > $this->description_truncation_limit): ?>
                    <?php $description  = substr(strip_tags($topic->description),0,$this->description_truncation_limit).'...';?>
                    <?php echo  $description; ?>
                <?php else: ?>
                    <?php echo $topic->description; ?>
                <?php endif;?>
              </div>
              <p class="sesforum_date sesbasic_font_small sesbasic_text_light">
                <span><?php echo $this->timestamp($topic->creation_date); ?></span>
              	<span><i class="sesbasic_icon_like"></i> <?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?></span>
              	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.rating', 1)) { ?>
                    <span class="sesforum_rating_star">
                        <?php $half = 0; ?>
                        <?php for($i = 1; $i <= 5; $i++){ ?>
                            <?php if(floor($topic->rating) >= $i) { ?>
                                <span class="sesbasic_rating_star_small fa fa-star"></span>
                            <?php } else if((floor($topic->rating) < $topic->rating) && !$half) { $half = 1; ?>
                                <span class="sesbasic_rating_star_small fa fa-star-half-o"></span>
                            <?php } else { ?>
                                <span class="sesbasic_rating_star_small fa fa-star sesbasic_rating_star_small_disable"></span>
                        <?php } ?>
                        <?php } ?>
                    </span>
                <?php } ?>
              </p>
              <p class="sesbasic_font_small"><?php echo $this->pageLinks($topic, $this->sesforum_topic_pagelength, null, 'sesforum_pagelinks') ?></p>
            </div>
          </div>
          <div class="sesforum_stats">
            <div class="sesforum_views">
              <span>
                <?php echo $this->translate(array('%1$s %2$s view', '%1$s %2$s views', $topic->view_count), $this->locale()->toNumber($topic->view_count), '</span><span class="_label sesbasic_text_light">') ?>
              </span>
            </div>
            <div class="sesforum_replies">
              <span>
                <?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $topic->post_count-1), $this->locale()->toNumber($topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?>
              </span>
            </div>
          </div>

          <div class="sesforum_lastpost">
          	<div class="sesforum_lastpost_owner_thumb">
            	<?php echo $this->htmlLink($last_post->getHref(), $this->itemPhoto($last_user, 'thumb.icon')) ?>
            </div>
            <div class="sesforum_topics_lastpost_info">
            	<div class="sesforum_lastpost_ownerinfo sesbasic_text_light sesbasic_font_small">
                <?php if( $last_post):
                  list($openTag, $closeTag) = explode('-----', $this->htmlLink($last_post->getHref(array('slug' => $topic->getSlug())), '-----'));
                  ?>
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
              <?php endif; ?>
          </div>
        </div>
      </li>
    <?php } else { $post = $topic;
            unset($topic);
        include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/_posts.tpl';
    } ?>
    <?php endforeach; ?>
 <?php if(!$this->is_ajax){  ?>
        </ul>
    </div>
<div class="sesbasic_clearfix">
    <?php if($this->load_content != 'pagging'): ?>
        <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
        <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
    <?php endif;?>
    </div>
    <?php if($this->load_content == 'pagging'): ?>
        <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesforum"),array('identityWidget'=>$randonNumber)); ?>
    <?php endif;?>
</div>
<?php } ?>
<?php } else { ?>
  <?php $tips = $this->search_type == 'topics' ? "There are no topics." : "There are no posts."; ?>
  <div class="sesbasic_tip">
  	<img src="application/modules/Sesforum/externals/images/topic-icon.png" alt="">
    <span class="sesbasic_text_light"><?php echo $this->translate($tips) ?></span>
  </div>
<?php } ?>
<script type="text/javascript">
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
					method: 'get',
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
					method: 'get',
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
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
						document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
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
