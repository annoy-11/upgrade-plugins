<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _forum.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if($this->topicPaginator->count() > 0){  ?>
<?php if(!$this->is_ajax){  ?>
		<div class="sesforum_main_category_section sesforum_main_category_section_topics sesbasic_clearfix sesbasic_bxs">
    <div class="sesforum_main_category_section_head"><?php echo $this->translate("Topics");?></div> 
    <div class="sesforum_topics_listing sesbasic_bxs" id ="container-forums-topic_<?php echo $randonNumber; ?>">
        <ul id="forums-topic_<?php echo $randonNumber; ?>">
    <?php } ?>
            <?php foreach( $this->topicPaginator as $i => $topic ):
            $last_post = $topic->getLastCreatedPost();
            if( $last_post ) {
                $last_user = $this->user($last_post->user_id);
            } else {
                $last_user = $this->user($topic->user_id);
            }
            ?>
            <li class="sesforum_nth_<?php echo $i % 2; ?>">
                <div class="sesforum_deatails">
                    <div class="sesforum_owner">
                        <?php echo $this->htmlLink($topic->getOwner()->getHref(), $this->itemPhoto($topic->getOwner(), 'thumb.icon')) ?>
                    </div>
                <div class="sesforum_info">
                    <div class="_title<?php if( $topic->closed ): ?> closed<?php endif; ?><?php if( $topic->sticky ): ?> sticky<?php endif; ?>">
                        <?php echo $this->htmlLink($topic->getHref(), $topic->getTitle());?>
                    </div>
                    <p class="sesforum_date sesbasic_font_small sesbasic_text_light">
                    <span><?php echo $this->htmlLink($topic->getOwner()->getHref(), $topic->getOwner()->getTitle());?></span>
                    <span><?php echo $this->timestamp($topic->creation_date); ?></span>
                    <span><i class="sesbasic_icon_like"></i> <?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?></span>
                    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.rating', 1)) { ?>
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
                    <?php if(count($valueTags) > 0): ?> 
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
                <div class="sesforum_views">
                    <span class="_count">
                    <?php echo $this->translate(array('%1$s %2$s view', '%1$s %2$s views', $topic->view_count), $this->locale()->toNumber($topic->view_count), '</span><span class="_label sesbasic_text_light">') ?>
                    </span>
                </div>
                <div class="sesforum_replies">
                    <span class="_count">
                    <?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $topic->post_count-1), $this->locale()->toNumber($topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?>
                    </span>
                </div>
                </div>
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
            </li>
            <?php endforeach; ?>
    <?php if(!$this->is_ajax){  ?>
        </ul>
        <?php if($this->topic_load_content != 'pagging'): ?>
            <div class="sesbasic_load_btn" id="view_more_topic_<?php echo $randonNumber;?>" onclick="viewMoreTopic_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_topic_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
            <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="topic_loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
        <?php endif;?>
    </div>
    </div>
    <?php } ?>
 <?php } ?>
<script type="text/javascript">
    var topicIsSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var topicRequestViewMore_<?php echo $randonNumber; ?>;
		var topic_params<?php echo $randonNumber; ?> = <?php echo json_encode($this->topicparams); ?>;
		var topic_identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var topic_page<?php echo $randonNumber; ?> = '<?php echo $this->topic_page + 1; ?>';
		var topic_is_search_<?php echo $randonNumber;?> = 1;
		<?php if($this->topic_load_content != 'pagging'){ ?>
			topciViewMoreHide_<?php echo $randonNumber; ?>();	
			function topciViewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_topic_<?php echo $randonNumber; ?>'))
				$('view_more_topic_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->topicPaginator->count() == 0 ? 'none' : ($this->topicPaginator->count() == $this->topicPaginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMoreTopic_<?php echo $randonNumber; ?> (){ 
				sesJqueryObject('#view_more_topic_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#topic_loading_image_<?php echo $randonNumber; ?>').show(); 
				topicRequestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/",
					'data': {
						format: 'html',
						topic_page: topic_page<?php echo $randonNumber; ?>,    
						params : topic_params<?php echo $randonNumber; ?>,
						is_ajax : 1,
						openTab : 'topic',
						identity: topic_identity<?php echo $randonNumber; ?>,
						category_id: <?php echo $this->category_id; ?>,
						view_more:1,
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('topic_loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#topic_loading_image_<?php echo $randonNumber; ?>').remove();
						if(!topicIsSearch) {
							document.getElementById('forums-topic_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-topic_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('forums-topic_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-topic_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							topicIsSearch = false;
						}
					}
				});
				topicRequestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
    var topicRequestTab_<?php echo $randonNumber; ?>;
  
    // globally define available tab array
    var topicRequestTab_<?php echo $randonNumber; ?>;
		<?php if($this->topic_load_content == 'auto_load'){ ?>
			window.addEvent('load', function() {
			
			 function topciViewMoreHide_<?php echo $randonNumber; ?>() {
            if ($('view_more_topic_<?php echo $randonNumber; ?>'))
            $('view_more_topic_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->topicPaginator->count() == 0 ? 'none' : ($this->topicPaginator->count() == $this->topicPaginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
            topciViewMoreHide_<?php echo $randonNumber; ?>();	
        }
				sesJqueryObject(window).scroll( function() {
					var topicHeightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#forums-topic_<?php echo $randonNumber; ?>').offset().top;
					var topicFromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop(); 
					if(topicFromtop_<?php echo $randonNumber; ?> > topicHeightOfContentDiv_<?php echo $randonNumber; ?> - 200 && sesJqueryObject('#view_more_topic_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_topic_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
    <?php } ?>
</script>
