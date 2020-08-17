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
<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php 
    if($viewer->getIdentity()){
        $levelId = $viewer->level_id;
    } else {
        $levelId = 5;
    } 
?>
<?php $colours = array('#d5a900','#e4007c','#090088','#1ee3cf','#bb7171','#58b368','#dd4a14','#ff502f','#373a6d','#e41749','#c40b13','#560764','#c7004c','#00a8b5','#0b8457','#6927ff','#113f67','#005792','#c82121','#ff0000','#930077'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php $moduleName = 'sesforum';?>
<?php if(!$this->is_ajax){  ?>
    <?php if($this->category_id):
        $category = Engine_Api::_()->getItem('sesforum_category',$this->category_id);  
        if($category->description != ''): ?>
            <div class="sesforum_main_category_des"><?php echo $this->translate($category->description);?></div>
        <?php endif; ?>
    <?php endif; ?>
 <?php } ?>
<?php if(($this->openTab == 'category' || $this->openTab == 'all') && $this->paginator->count() > 0): ?>
 <?php if(!$this->is_ajax){  ?>
 <div class="sesforum_main_category_section sesbasic_clearfix">
<div class="sesforum_main_category_layout sesbasic_bxs">
<?php if($this->category_id): ?>
<?php $subsubCategories = Engine_Api::_()->getItemTable('sesforum_category')->getSubSubCat($this->category_id);?>
<?php $subCategories = Engine_Api::_()->getItemTable('sesforum_category')->getSubCat($this->category_id);?>
<?php endif; ?>
<?php 
 if(count($subCategories) > 0 ){
    $catTitle = 'Sub Categories';
 } else if(count($subsubCategories) > 0) {
    $catTitle = '3rd level Categories';
 } else {
     $catTitle = '';
 }
?>
<div class="sesforum_main_category_section_head"><?php echo $this->translate($catTitle);?></div>
	<ul id = "forums-category_<?php echo $randonNumber; ?>">
<?php } $count = $this->itemCount; ?>
	<?php foreach($this->paginator as $category ):  ?>
	<?php if($this->themecolor == 'theme'):
           // $color = 'class="sesbasic_bg"';
        else :
           $maincolors = $colours;
           $count = $count >  count($colours) ? 0 : $count;
           $color =  'style="border-left-color:'.$colours[$count].'"';
           $count++;
        endif;
    ?>
  	<li class="sesforum_main_category_layout_item">
    	<div class="sesforum_main_category_layout_item_main" <?php echo $color; ?> >
        <article class="sesbasic_bg">
          <div class="forum_category_item_top">
            <div class="forum_category_item_top_left">
              <div class="forum_category_title">
                <a href="<?php echo $category->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $category->getTitle(); ?></a>
              </div>
              <div class="forum_category_des sesbasic_text_light">
                 <?php if(strlen($category->description) > $this->description_truncation_category): ?>
                      <?php $title = mb_substr($category->description,0,$this->description_truncation_category).'...';?>
                      <?php echo $this->translate($title); ?>
                  <?php else: ?>
                      <?php echo $this->translate($category->description); ?>
                  <?php endif;?>
              </div>
            </div>
            <?php if(isset($this->topicCount) || isset($this->postCount)): ?>
            <div class="forum_category_item_top_stats">
              <?php if(isset($this->topicCount)): ?>
                  <div>
                  <span class="_count"><?php echo $category->getTopics() ? $category->getTopics() : "0"; ?></span>
                  <span class="_title sesbasic_text_light"><?php echo $this->translate(array('Topic', 'Topics', $category->getTopics()), $this->locale()->toNumber($category->getTopics())); ?></span>
                  </div>
              <?php endif;?>
              <?php if(isset($this->postCount)): ?>
                  <div>
                      <span class="_count"><?php echo $category->getPosts() ? $category->getPosts() : "0"; ?></span>
                      <span class="_title sesbasic_text_light"><?php echo $this->translate(array('Post ', 'Posts ', $category->getPosts()), $this->locale()->toNumber($category->getPosts())); ?></span>
                  </div>
              <?php endif;?>
            </div>
             <?php endif;?>
          </div>
          <?php if($this->cat2ndShow) { ?>
          <?php $subCategories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll(Engine_Api::_()->getItemTable('sesforum_category')->select()->where('subsubcat_id = ?', $category->category_id)->where("privacy LIKE ? ", '%' . $levelId. '%')->order('order ASC')); ?>
         <?php if(!count($subCategories)){  ?>
              <?php $subCategories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll(Engine_Api::_()->getItemTable('sesforum_category')->select()->where('subcat_id = ?', $category->category_id)->where("privacy LIKE ? ", '%' . $levelId. '%')->order('order ASC')); ?>
          <?php } ?>
          <?php if(count($subCategories) > 0 ) { ?>
          <div class="forum_category_item_footer">
            <ul>
              <?php foreach($subCategories as $subCategorie) {  ?>
                <li <?php if($this->iconShape): ?> class="_iconrounded" <?php endif; ?>>
                  <a href="<?php echo $subCategorie->getHref(); ?>">
                    <?php if(!empty($subCategorie->cat_icon)) { ?>
                      <?php $cat_icon = Engine_Api::_()->storage()->get($subCategorie->cat_icon, '');
                        if($cat_icon) {
                            $cat_icon = $cat_icon->map(); ?>
                          <i><img src="<?php echo $cat_icon ?>"></i>
                          <?php } else { ?>
                              <i><img src="application/modules/Sesforum/externals/images/topic-icon.png" /></i>
                          <?php } ?>
                      <?php } else { ?>
                        <i><img src="application/modules/Sesforum/externals/images/topic-icon.png" /></i>
                      <?php } ?>  
                      <span><?php  echo $subCategorie->getTitle(); ?></span>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </div>
           <?php } ?>
          <?php } ?>
        </article>
      </div>
      <div class="sesforum_main_category_layout_item_post">
      	<?php $last_post = $category->lastPost();
        if(isset($this->postDetails) ) {
           if($last_post) {
            $last_user = $this->user($last_post->user_id);
          ?>
            <div class="_poster clearfix">
            	<div class="_posterthumb">
            		<?php echo $this->htmlLink($last_post->getHref(), $this->itemPhoto($last_user, 'thumb.icon')) ?>
            	</div>
              <div class="_posterinfo">
            		<span><?php echo $this->translate('%3$s', null, null, $this->htmlLink($last_user->getHref(), $last_user->getTitle()))?></span>
            		<span class="_time sesbasic_text_light"><?php echo $this->timestamp($last_user->modified_date, array('class' => 'sesforum_topics_lastpost_date')) ?></span>
            	</div>
            </div>
            <div class="_des">
                <?php if( $this->decode_bbcode ) {
                if(strlen(nl2br($this->BBCode($last_post->body))) > $this->description_truncation_post):
                    $title = mb_substr(nl2br($this->BBCode($last_post->body)),0,$this->description_truncation_post).'...';
                        echo $title;
                    else: 
                        echo nl2br($this->BBCode($last_post->body));
                    endif;
                
            } else {
                if(strlen($last_post->getDescription()) > $this->description_truncation_post):
                    $title = mb_substr($last_post->getDescription(),0,$this->description_truncation_post).'...';
                        echo $title;
                    else: 
                        echo $last_post->getDescription();
                    endif;
            } ?>
            <?php $forum = Engine_Api::_()->getItem('sesforum_forum',$last_post->forum_id);?>
            </div>
            <div class="_des sesbasic_text_light"><?php echo $this->translate('In') ?> <a href="<?php echo $forum->getHref(); ?>"><?php echo $forum->getTitle(); ?></a></div>
                <?php } else { ?>
                    <span class="_des"><?php echo $this->translate('No one has replied'); ?></span>
                <?php   } ?>
        <?php   } ?>
        </div>
    </li>
    <?php endforeach;?>
<?php if(!$this->is_ajax){  ?>
  </ul>
    <?php if($this->load_content != 'pagging'): ?>
        <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
        <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
    <?php endif;?>
</div>
</div>
<?php } ?>
<?php endif; ?>
<?php if($this->category_id): ?>
  <?php if(($this->openTab == 'forum' || $this->openTab == 'all') && $this->showForums): ?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/category-forums.tpl'; ?>
  <?php endif; ?>
  <?php if(($this->openTab == 'topic' || $this->openTab == 'all')  && $this->showTopics): ?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/category-topics.tpl'; ?>
  <?php endif; ?>
<?php endif; ?>

<?php if($this->openTab == 'category' || $this->openTab == 'all') { ?>
<script type="text/javascript">
    var isSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
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
						itemCount:sesJqueryObject('#forums-category_<?php echo $randonNumber; ?>').children().length,
						openTab : 'category',
						params : params<?php echo $randonNumber; ?>,
						category_id: <?php echo $this->category_id ? $this->category_id : 0; ?>,
						showTopics : 0,
						identity: <?php echo $randonNumber;?>,
						view_more:1,
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
						if(!isSearch) {
							document.getElementById('forums-category_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-category_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('forums-category_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-category_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
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
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#forums-category_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
    <?php } ?>
</script>
<?php } ?>
