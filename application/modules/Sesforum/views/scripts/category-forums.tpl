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

<?php if($this->forumPaginator->count() > 0){  ?>
<?php if(!$this->is_ajax){  ?>
	<div class="sesforum_main_category_section sesforum_main_category_section_forums sesbasic_clearfix sesbasic_bxs">
     <div class="sesforum_main_category_section_head"><?php echo $this->translate("Forums");?></div>
    <div class="sesforum_main_category_forums" id='<?php echo "forum_".$this->category_id; ?>' style="display:block;">
        <ul id="category-forum_<?php echo $randonNumber; ?>">
<?php } ?>
          <?php foreach( $this->forumPaginator as $sesforum ):
            $last_topic = $sesforum->getLastUpdatedTopic();
            $last_post = null;
            $last_user = null;
            if( $last_topic ) {
              $last_post = $last_topic->getLastCreatedPost();
              $last_user = $this->user($last_post->user_id);
            }
            ?>
            <li>
              <div class="sesforum_deatails">
                <div class="sesforum_icon">
                  <?php if(!empty($sesforum->forum_icon)) { ?>
                    <?php $forum_icon = Engine_Api::_()->storage()->get($sesforum->forum_icon, '');
                    if($forum_icon) {
                    $forum_icon = $forum_icon->map(); ?>
                      <i><img alt="" src="<?php echo $forum_icon ?>" /></i>
                    <?php } else { ?>
                      <i><svg version="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490"><path d="M395 262V82c0-25-20-46-45-46H45C20 37 0 57 0 82v180c0 24 20 45 45 45h13v54c0 10 8 18 18 18 5 0 10-2 14-6l57-66h203c25 0 45-21 45-45zm-254 20c-3 0-6 2-9 4l-50 58v-50c1-6-5-12-12-12H45c-11 0-20-9-20-21V82c0-12 9-21 20-21h305c11 0 20 9 20 21v180c0 11-9 20-20 20H141z"/><path d="M400 447a18 18 0 0 0 20 5c7-3 11-9 11-17v-54h13c25 0 46-21 46-45V156c0-25-21-46-46-46a12 12 0 1 0 0 25c12 0 21 9 21 21v180c0 11-9 20-21 20h-25c-7 0-12 6-12 12v50l-50-57c-2-3-5-5-9-5H164a12 12 0 1 0 0 25h178l58 66z"/><circle cx="197" cy="176" r="15"/><circle cx="246" cy="176" r="15"/><circle cx="149" cy="176" r="15"/></svg></i>
                    <?php } ?>
                  <?php } else { ?>
                    <i><svg version="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 490"><path d="M395 262V82c0-25-20-46-45-46H45C20 37 0 57 0 82v180c0 24 20 45 45 45h13v54c0 10 8 18 18 18 5 0 10-2 14-6l57-66h203c25 0 45-21 45-45zm-254 20c-3 0-6 2-9 4l-50 58v-50c1-6-5-12-12-12H45c-11 0-20-9-20-21V82c0-12 9-21 20-21h305c11 0 20 9 20 21v180c0 11-9 20-20 20H141z"/><path d="M400 447a18 18 0 0 0 20 5c7-3 11-9 11-17v-54h13c25 0 46-21 46-45V156c0-25-21-46-46-46a12 12 0 1 0 0 25c12 0 21 9 21 21v180c0 11-9 20-21 20h-25c-7 0-12 6-12 12v50l-50-57c-2-3-5-5-9-5H164a12 12 0 1 0 0 25h178l58 66z"/><circle cx="197" cy="176" r="15"/><circle cx="246" cy="176" r="15"/><circle cx="149" cy="176" r="15"/></svg></i>
                  <?php } ?>
                </div>
                <div class="sesforum_info">
                  <div class="_title">
                        <?php echo $this->htmlLink($sesforum->getHref(),$this->translate($sesforum->getTitle())) ?>
                  </div>
                  <p class="sesbasic_font_small">
                    <?php if(strlen($sesforum->getDescription()) > $this->description_truncation_forum):?>
                        <?php $title = mb_substr($sesforum->getDescription(),0,$this->description_truncation_forum).'...';?>
                        <?php echo $title;?>
                    <?php else: ?>
                            <?php echo $sesforum->getDescription(); ?>
                    <?php endif;?>
                  </p>
                </div>
              </div>
              <?php if(isset($this->postCount) || isset($this->topicCount)) { ?>
              <div class="sesforum_stats">
                <?php if(isset($this->postCount)) { ?>
                    <div class="sesforum_posts">
                        <span class="_count"><?php echo $sesforum->post_count;?></span>
                        <span class="_label sesbasic_text_light"><?php echo $this->translate(array('post', 'posts', $sesforum->post_count),$this->locale()->toNumber($sesforum->post_count)) ?>
                        </span>
                    </div>
                <?php } ?>
                <?php if(isset($this->topicCount)) { ?>
                    <div class="sesforum_topics">
                        <span class="_count"><?php echo $sesforum->topic_count;?></span>
                        <span class="_label sesbasic_text_light"><?php echo $this->translate(array('topic', 'topics', $sesforum->topic_count),$this->locale()->toNumber($sesforum->topic_count)) ?></span>
                    </div>
                <?php } ?>
              </div>
             <?php } ?>
            <?php if(isset($this->postDetails)) { ?>
              <div class="sesforum_lastpost">
                <?php if( $last_topic && $last_post ): ?>
                  <div class="sesforum_lastpost_owner_thumb">
                    <?php echo $this->htmlLink($last_post->getHref(), $this->itemPhoto($last_user, 'thumb.icon')) ?>
                  </div>
                  <div class="sesforum_topics_lastpost_info">
                    <div class="sesforum_lastpost_ownerinfo sesbasic_text_light sesbasic_font_small">
                      <?php echo $this->translate("by %s", $last_user->__toString()); ?> - <?php echo $this->timestamp($last_post->creation_date, array('class' => 'sesforum_lastpost_date')) ?>
                    </div>
                    <div class="sesforum_lastpost_post sesbasic_text_light sesbasic_font_small">
                      <?php echo $this->translate('in %s',  $this->htmlLink($last_post->getHref(), $last_topic->getTitle())) ?>
                      
                    </div>
                  </div>  
                <?php endif;?>
              </div>
            <?php } ?>
            </li>
          <?php endforeach;?>
      <?php if(!$this->is_ajax){  ?>
        </ul>
        <?php if($this->forum_load_content != 'pagging'): ?>
            <div class="sesbasic_load_btn" id="view_more_forum_<?php echo $randonNumber;?>" onclick="viewMoreForum_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_forum_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
            <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="forum_loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
        <?php endif;?>
    </div>
    </div>
    <?php } ?>
<?php } ?>
<script type="text/javascript">
    var forumIsSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var topicRequestViewMore_<?php echo $randonNumber; ?>;
		var forum_params<?php echo $randonNumber; ?> = <?php echo json_encode($this->forumParams); ?>;
		var forum_identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var forum_page<?php echo $randonNumber; ?> = '<?php echo $this->forum_page + 1; ?>';
		var forum_is_search_<?php echo $randonNumber;?> = 1;
		<?php if($this->forum_load_content != 'pagging'){ ?>
			topciViewMoreHide_<?php echo $randonNumber; ?>();	
			function topciViewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_forum_<?php echo $randonNumber; ?>'))
				$('view_more_forum_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->forumPaginator->count() == 0 ? 'none' : ($this->forumPaginator->count() == $this->forumPaginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMoreForum_<?php echo $randonNumber; ?> (){ 
				sesJqueryObject('#view_more_forum_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#forum_loading_image_<?php echo $randonNumber; ?>').show(); 
				forumRequestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/",
					'data': {
						format: 'html',
						forum_page: forum_page<?php echo $randonNumber; ?>,    
            is_ajax : 1,
            openTab : 'forum',
						params : forum_params<?php echo $randonNumber; ?>,
						identity: forum_identity<?php echo $randonNumber; ?>,
						category_id: <?php echo $this->category_id; ?>,
						view_more:1,
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('forum_loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#forum_loading_image_<?php echo $randonNumber; ?>').remove();
						if(!forumIsSearch) {
							document.getElementById('category-forum_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-forum_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('category-forum_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-forum_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							forumIsSearch = false;
						}
					}
				});
				forumRequestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
    var forumRequestTab_<?php echo $randonNumber; ?>;
  
    // globally define available tab array
    var forumRequestTab_<?php echo $randonNumber; ?>;
		<?php if($this->forum_load_content == 'auto_load'){ ?>
			window.addEvent('load', function() {
			function topciViewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_forum_<?php echo $randonNumber; ?>'))
            $('view_more_forum_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->forumPaginator->count() == 0 ? 'none' : ($this->forumPaginator->count() == $this->forumPaginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
            topciViewMoreHide_<?php echo $randonNumber; ?>();	
       }
				sesJqueryObject(window).scroll( function() {
					var forumHeightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#category-forum_<?php echo $randonNumber; ?>').offset().top;
					var forumFromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(forumFromtop_<?php echo $randonNumber; ?> > forumHeightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_forum_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_forum_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
    <?php } ?>
</script>
    
