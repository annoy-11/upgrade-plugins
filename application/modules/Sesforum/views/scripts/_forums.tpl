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

<div class="sesforum_main_categories sesbasic_clearfix sesbasic_bxs">
  <div class="sesforum_main_category_item sesbasic_clearfix">
    <div class="sesforum_main_category_item_header">
      <?php if(!empty($this->categories->cat_icon)) { ?>
        <div class="_icon">
          <?php $cat_icon = Engine_Api::_()->storage()->get($this->categories->cat_icon, '');
          if($cat_icon) {
          $cat_icon = $cat_icon->map(); ?>
            <img alt="" src="<?php echo $cat_icon ?>" />
          <?php } else { ?>
            <?php echo "---"; ?>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="_info">
       <?php if($subCategoryLink || $subSubCategoryLink) { ?>
            <a href= "<?php echo $this->categories->getHref(); ?>"> 
                <div class="_title" onmouseover="this.style.color = 'blue'" onmouseleave="this.style.color = 'black'">
                    <?php echo $this->translate($this->categories->getTitle()) ?>
                </div>
            </a>
        <?php } else {  ?>
            <div class="_title">
                    <?php echo $this->translate($this->categories->getTitle()) ?>
            </div>
        <?php } ?>
        <?php if($this->categories->description) { ?>
          <p><?php echo $this->categories->description; ?></p>
        <?php } ?>
      </div>
    </div>
    <div class="sesforum_main_category_forums">
    	<ul>
        <?php foreach( $this->sesforums[$this->categories->category_id] as $sesforum ):
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
                  <?php echo $this->htmlLink($sesforum->getHref(), $this->translate($sesforum->getTitle())) ?>
                </div>
                <p class="sesbasic_font_small"><?php echo $sesforum->getDescription() ?></p>
              </div>
           	</div>
            <div class="sesforum_stats">
              <div class="sesforum_posts">
                <span class="_count"><?php echo $sesforum->post_count;?></span>
                <span class="_label sesbasic_text_light"><?php echo $this->translate(array('post', 'posts', $sesforum->post_count),$this->locale()->toNumber($sesforum->post_count)) ?></span>
              </div>
              <div class="sesforum_topics">
                <span class="_count"><?php echo $sesforum->topic_count;?></span>
                <span class="_label sesbasic_text_light"><?php echo $this->translate(array('topic', 'topics', $sesforum->topic_count),$this->locale()->toNumber($sesforum->topic_count)) ?></span>
              </div>
            </div>
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
          </li>
        <?php endforeach;?>
      </ul>
  	</div>
  </div>
</div>

