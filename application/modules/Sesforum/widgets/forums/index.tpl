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
<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php $randonNumber = $this->identityForWidget; ?>
 <?php $moduleName = 'sesforum';?>
<?php if(!$this->is_ajax){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>
<?php if(!$this->category_id): ?>
<div class="sesforum_page_title">
  <h2>
    <?php echo $this->translate('Forums'); ?>
  </h2>
</div>
<?php endif; ?>
<div>
<div class="sesforum_main_categories sesbasic_clearfix sesbasic_bxs" id = "forums-widget_<?php echo $randonNumber; ?>">
<?php } ?>
	<?php foreach($this->paginator as $category ): 
//   	if( empty($this->sesforums[$category->category_id]) ) {
//     continue;
//   	}
  ?>
    <div class="sesforum_main_category_item sesbasic_clearfix">
      <div class="sesforum_main_category_item_header">
        <?php if(!empty($category->cat_icon)) { ?>
          <div class="_icon">
            <?php $cat_icon = Engine_Api::_()->storage()->get($category->cat_icon, '');
            if($cat_icon) {
            $cat_icon = $cat_icon->map(); ?>
              <img alt="" src="<?php echo $cat_icon ?>" />
            <?php } else { ?>
              <?php echo "---"; ?>
            <?php } ?>
          </div>
        <?php } ?>
        <div class="_info">
          <div class="_title">
            <a href="<?php echo $category->getHref(); ?>">
                <?php echo $this->translate($category->getTitle()); ?>
            </a>
         </div>
          <?php if($category->description) { ?>
            <p> 
                <?php if(strlen($category->description) > $this->description_truncation_category): ?>
                    <?php $title = mb_substr($category->description,0,$this->description_truncation_category).'...';?>
                    <?php echo $this->translate($title); ?>
                <?php else: ?>
                    <?php echo $this->translate($category->description); ?>
                <?php endif;?>
            </p>
          <?php } ?>
        </div>
        <div class="_btn">
          <i id='<?php echo "forumcat_".$category->category_id; ?>' <?php if($this->expandAbleCat && (isset($this->forumShow) && $this->forumShow != 0)) { ?> class="fa fa-minus"  onClick="forumshow('<?php echo "forum_".$category->category_id; ?>', '<?php echo $category->category_id; ?>');"<?php }  ?> ></i>
        </div>
      </div>
      <div class="sesforum_main_category_forums" id='<?php echo "forum_".$category->category_id; ?>' style="display:block;">
        <ul>
        <?php if(isset($this->forumShow) && $this->forumShow != 0) { ?>
          <?php foreach( $this->sesforums[$category->category_id] as $sesforum ):
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
        <?php } ?>
        </ul>
<?php
if($viewer->getIdentity()){
     $levelId = $viewer->level_id;
} else {
    $levelId = 5;
}
$subCategories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll(Engine_Api::_()->getItemTable('sesforum_category')->select()->where('subcat_id = ?', $category->category_id)->where("privacy LIKE ? ", '%' . $levelId. '%')->order('order ASC'));
 if($this->cat2ndShow) { 
    if(count($subCategories) > 0) { 
        foreach($subCategories as $subCategorie) { 
            include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/_subCategory.tpl';
        } 
    } else { $subCategorie = $category;
        include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/_subsubCategory.tpl';
    }
} 
?>

      </div>
    </div>
	<?php endforeach; ?>
	
<?php if(!$this->is_ajax){  ?>

</div>
  <?php if($this->load_content != 'pagging'): ?>
  
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
    
    <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
    
  <?php endif;?>

<?php } ?>


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
						is_ajax : 1,
						params : params<?php echo $randonNumber; ?>,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
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
