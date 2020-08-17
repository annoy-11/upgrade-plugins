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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>
<?php $moduleName = 'sesforum';?>

<script>
var selectedTab;
var data;
var defaultOpenTab;
	var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
</script>
<?php if(!$this->is_ajax){  ?>
<div class="sesforum_user_dashboard sesbasic_bxs">
  <div class="sesforum_user_dashboard_container">
  	<div class="sesforum_user_dashboard_tabs sesbasic_lbg">
      <ul>
      <?php if(isset($this->myTopics)) { ?>
        <li class="<?php echo $this->view_type == 'my-topics' ? '_selected' :'' ?>" id="sesforum_mytopics"><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'my-topics'), 'sesforum_extend', true); ?>"><span><?php echo $this->translate("My Topics")?></span><i class="fa fa-angle-right"></i></a></li>
      <?php } ?>
      <?php if(isset($this->myPosts)) { ?>
        <li id="sesforum_myposts" class="<?php echo $this->view_type == 'my-posts' ? '_selected' :'' ?>" ><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'my-posts'), 'sesforum_extend', true); ?>" ><span><?php echo $this->translate("My Posts")?></span><i class="fa fa-angle-right"></i></a></li>
      <?php } ?>
      <?php if(isset($this->mySubscribedTopics)) { ?>
        <li id="sesforum_subscriptions" class="<?php echo $this->view_type == 'my-subscriptions' ? '_selected' :'' ?>" ><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'my-subscriptions'), 'sesforum_extend', true); ?>"><span><?php echo $this->translate("My Subscribe Topics")?></span><i class="fa fa-angle-right"></i></a></li>
      <?php } ?>
         <?php if(isset($this->TopicsILiked)) { ?>
        <li id="sesforum_topic_i_liked" class="<?php echo $this->view_type == 'topics-i-liked' ? '_selected' :'' ?>" ><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'topics-i-liked'), 'sesforum_extend', true); ?>"><span><?php echo $this->translate("Topics I Liked")?></span><i class="fa fa-angle-right"></i></a></li>
      <?php } ?>
      <?php if(isset($this->postsILiked)) { ?>
        <li id="sesforum_posts_i_liked" class="<?php echo $this->view_type == 'posts-i-liked' ? '_selected' :'' ?>" ><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'posts-i-liked'), 'sesforum_extend', true); ?>"><span><?php echo $this->translate("Posts I Liked")?></span><i class="fa fa-angle-right"></i></a></li> 	
      <?php } ?>
      <?php if(isset($this->signature)) { ?>
        <li id="edit_signature" class="<?php echo $this->view_type == 'signature' ? '_selected' :'' ?>" ><a href="<?php echo $this->url(array('action' => 'dashboard','type'=>'signature'), 'sesforum_extend', true); ?>"><span><?php echo $this->translate("Edit Signature")?></span><i class="fa fa-angle-right"></i></a></li>   	
      <?php } ?>
      </ul>
    </div>
    <div class="sesforum_user_dashboard_content" id="tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
      <?php if($this->type == "topics"){ 
              include APPLICATION_PATH . '/application/modules/Sesforum/views/scripts/my-topics.tpl';
          }  elseif($this->type == "posts") { 
              include APPLICATION_PATH . '/application/modules/Sesforum/views/scripts/my-posts.tpl';
          } elseif($this->type == "signature") { ?>
           	<div class="sesforum_edit_signature"><?php echo $this->form->setAttrib('class', 'sesforum_edit_signature_form')->render($this) ?></div>
        <?php }
      ?>
    <?php if(!$this->is_ajax){  ?>
    </div>
  </div>
</ul>
</div>
    <?php if($this->load_content != 'pagging' && $this->type != "signature"): ?>
        <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
        <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
    <?php endif;?>
    </div>
</div>
<?php } ?>
