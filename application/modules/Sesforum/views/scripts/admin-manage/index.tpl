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
 
<?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3><?php echo $this->translate("Manage Categories & Forums"); ?></h3>
      <p><?php echo $this->translate("This page lists all the categories and forums created under them. You can use this page to monitor them and delete offensive material if necessary. From here, you can also create new categories & forums. You can add moderators for the created forums to provide access for making changes in the forums. If you want to change the order of the forums then, click on move up link below to move it to the top. Entering criteria into the filter fields will help you find specific topic entries."); ?>
      </p>
      <br />
      <br />

<script type="text/javascript">
  var moveCategoryUp = function(category_id) {
    var url = '<?php echo $this->url(array('action' => 'move-category')) ?>';
    var request = new Request.JSON({
      url : url,
      data : {
        format : 'json',
        category_id : category_id
      },
      onComplete : function() {
        window.location.replace( window.location.href );
      }
    });
    request.send();
  }
  var moveSesforumUp = function(forum_id) {
    var url = '<?php echo $this->url(array('action' => 'move-sesforum')) ?>';
    var request = new Request.JSON({
      url : url,
      data : {
        format : 'json',
        forum_id : forum_id
      },
      onComplete : function() {
        window.location.replace( window.location.href );
      }
    });
    request.send();
  }
</script>

   
      <div class="admin_sesforums_options">
        <a href="<?php echo $this->url(array('action'=>'add-category'));?>" class="buttonlink smoothbox admin_sesforums_createcategory"><?php echo $this->translate("Add Category") ?></a>
        <a href="<?php echo $this->url(array('action'=>'add-forum'));?>" class="buttonlink smoothbox admin_sesforums_create"><?php echo $this->translate("Add Forum") ?></a>
      </div>
      
      <br />
  
      <ul class="admin_sesforum_categories">
        <?php foreach ($this->categories as $category): ?>
        <li>
          <div class="admin_sesforum_categories_info">
            <?php if(!empty($category->cat_icon)) { ?>
              <div class="admin_sesforum_categories_icon">
                <?php $cat_icon = Engine_Api::_()->storage()->get($category->cat_icon, '');
                if($cat_icon) {
                $cat_icon = $cat_icon->map(); ?>
                  <img alt="" src="<?php echo $cat_icon ?>" />
                <?php } else { ?>
                  <?php echo "---"; ?>
                <?php } ?>
              </div>
            <?php } ?>
            <div class="admin_sesforum_categories_options">
              <span class="admin_sesforums_moveup">      
                <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveCategoryUp(' . $category->category_id .');'));?> |
              </span>
              <a href="<?php echo $this->url(array('action'=>'edit-category', 'category_id'=>$category->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
              | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-category', 'category_id'=>$category->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
            </div>
            <div class="admin_sesforum_categories_info_cont">
              <div class="admin_sesforum_categories_title">
                <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle();?></a>
              </div>
              <?php if($category->description) { ?>
                <div class="admin_sesforum_categories_description">
                  <?php echo $category->description;?>
                </div>
              <?php } ?>
            </div>
          </div>
          <ul class="admin_sesforums">
          <?php $categoryForum = $category->getChildren('sesforum_forum', array('order'=>'order'));
          ?>
            <?php foreach ($categoryForum as $sesforum):?>
              <li>
                <?php if(!empty($sesforum->forum_icon)) { ?>
                  <span class="admin_sesforums_icon">
                    <?php $forum_icon = Engine_Api::_()->storage()->get($sesforum->forum_icon, '');
                    if($forum_icon) {
                    $forum_icon = $forum_icon->map(); ?>
                      <img alt="" src="<?php echo $forum_icon ?>" />
                    <?php } else { ?>
                      <?php echo "---"; ?>
                    <?php } ?>
                  </span>
                <?php } ?>
                <div class="admin_sesforums_options">
                  <span class="admin_sesforums_moveup">
                    <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveSesforumUp(' . $sesforum->getIdentity() .');'));?> |
                  </span>
                  <a href="<?php echo $this->url(array('action'=>'edit-forum', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
                  | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-forum', 'forum_id'=>$sesforum->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
                </div>
                <div class="admin_sesforums_info">
                  <span class="admin_sesforums_title">
                    <?php echo $sesforum->getTitle();?>
                  </span>
                  <span class="admin_sesforums_description">
                    <?php echo $sesforum->getDescription(); ?>
                  </span>
                  <span class="admin_sesforums_moderators">
                    <span class="admin_sesforums_moderators_top">
                      <?php echo $this->translate("Moderators") ?>
                      (<a href="<?php echo $this->url(array('action'=>'add-moderator', 'format'=>'smoothbox', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("add") ?></a>)
                    </span>
                    <span>
                      <?php
                        $i = 0;
                        foreach ($sesforum->getModeratorList()->getAllChildren() as $moderator)
                        {
                          if ($i > 0)
                          {
                            echo ', ';
                          }
                          $i++;
                          echo $moderator->__toString() . ' (<a class="smoothbox" href="' . $this->url(array('action'=>'remove-moderator', 'forum_id'=>$sesforum->getIdentity(), 'user_id'=>$moderator->getIdentity())) . '">' . $this->translate("remove") . '</a>)';
                        }
                      ?>
                    </span>
                  </span>
                </div>
              </li>
            <?php endforeach;?>
          </ul>
          <?php  if($category->category_id) { ?>
            <div class="admin_sesforum_subcategories">
              <?php $subCategories = Engine_Api::_()->getItemTable('sesforum_category')->getSubCat($category->category_id);?>
                <?php foreach($subCategories as $subCategorie) { ?>
                  <div class="admin_sesforum_categories_info">
                    <?php if(!empty($subCategorie->cat_icon)) { ?>
                      <div class="admin_sesforum_categories_icon">
                        <?php $cat_icon = Engine_Api::_()->storage()->get($subCategorie->cat_icon, '');
                        if($cat_icon) {
                        $cat_icon = $cat_icon->map(); ?>
                          <img alt="" src="<?php echo $cat_icon ?>" />
                        <?php } else { ?>
                          <?php echo "---"; ?>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <div class="admin_sesforum_categories_options">
                      <span class="admin_sesforums_moveup">      
                        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveCategoryUp(' . $subCategorie->category_id .');'));?> |
                      </span>
                      <a href="<?php echo $this->url(array('action'=>'edit-category', 'category_id'=>$subCategorie->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
                      | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-category', 'category_id'=>$subCategorie->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
                    </div>
                    <div class="admin_sesforum_categories_info_cont">
                      <div class="admin_sesforum_categories_title">
                        <a href="<?php echo $subCategorie->getHref(); ?>"><?php echo $subCategorie->getTitle();?></a>
                      </div>
                      <?php if($subCategorie->description) { ?>
                        <div class="admin_sesforum_categories_description">
                          <?php echo $subCategorie->description;?>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="admin_sesforum_subcategories_content">
                    <ul class="admin_sesforums">
                      <?php $subCategorieForum = $subCategorie->getChildren('sesforum_forum', array('order'=>'order')); 
                      ?>
                      <?php foreach ($subCategorieForum as $sesforum):?>
                        <li>
                          <?php if(!empty($sesforum->forum_icon)) { ?>
                            <span class="admin_sesforums_icon">
                              <?php $forum_icon = Engine_Api::_()->storage()->get($sesforum->forum_icon, '');
                              if($forum_icon) {
                              $forum_icon = $forum_icon->map(); ?>
                                <img alt="" src="<?php echo $forum_icon ?>" />
                              <?php } else { ?>
                                <?php echo "---"; ?>
                              <?php } ?>
                            </span>
                          <?php } ?>
                          <div class="admin_sesforums_options">
                            <span class="admin_sesforums_moveup">
                              <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveSesforumUp(' . $sesforum->getIdentity() .');'));?> |
                            </span>
                            <a href="<?php echo $this->url(array('action'=>'edit-forum', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
                            | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-forum', 'forum_id'=>$sesforum->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
                          </div>
                          <div class="admin_sesforums_info">
                            <span class="admin_sesforums_title">
                              <?php echo $sesforum->getTitle();?>
                            </span>
                            <span class="admin_sesforums_description">
                              <?php echo $sesforum->getDescription();?>
                            </span>
                            <span class="admin_sesforums_moderators">
                              <span class="admin_sesforums_moderators_top">
                                <?php echo $this->translate("Moderators") ?>
                                (<a href="<?php echo $this->url(array('action'=>'add-moderator', 'format'=>'smoothbox', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("add") ?></a>)
                              </span>
                              <span>
                                <?php
                                  $i = 0;
                                  foreach ($sesforum->getModeratorList()->getAllChildren() as $moderator)
                                  {
                                    if ($i > 0)
                                    {
                                      echo ', ';
                                    }
                                    $i++;
                                    echo $moderator->__toString() . ' (<a class="smoothbox" href="' . $this->url(array('action'=>'remove-moderator', 'forum_id'=>$sesforum->getIdentity(), 'user_id'=>$moderator->getIdentity())) . '">' . $this->translate("remove") . '</a>)';
                                  }
                                ?>
                              </span>
                            </span>
                          </div>
                        </li>
                      <?php endforeach;?>
                    </ul>
                    <?php if($subCategorie->category_id) {  ?>
                    <?php $subsubCategories = Engine_Api::_()->getItemTable('sesforum_category')->getSubSubCat($subCategorie->category_id);?>
                    <?php foreach($subsubCategories as $subsubCategorie) { ?>
                        <div class="admin_sesforum_categories_info">
                        <?php if(!empty($subsubCategorie->cat_icon)) { ?>
                            <div class="admin_sesforum_categories_icon">
                            <?php $cat_icon = Engine_Api::_()->storage()->get($subsubCategorie->cat_icon, '');
                            if($cat_icon) {
                            $cat_icon = $cat_icon->map(); ?>
                                <img alt="" src="<?php echo $cat_icon ?>" />
                            <?php } else { ?>
                                <?php echo "---"; ?>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="admin_sesforum_categories_options">
                            <span class="admin_sesforums_moveup">      
                            <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveCategoryUp(' . $subsubCategorie->category_id .');'));?> |
                            </span>
                            <a href="<?php echo $this->url(array('action'=>'edit-category', 'category_id'=>$subsubCategorie->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
                            | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-category', 'category_id'=>$subsubCategorie->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
                        </div>
                        <div class="admin_sesforum_categories_info_cont">
                          <div class="admin_sesforum_categories_title">
                              <a href="<?php echo $subsubCategorie->getHref(); ?>"><?php echo $subsubCategorie->getTitle();?></a>
                          </div>
                          <?php if($subsubCategorie->description) { ?>
                              <div class="admin_sesforum_categories_description">
                              <?php echo $subsubCategorie->description;?>
                              </div>
                          <?php } ?>
                        </div>
                        </div>
                        <div class="admin_sesforum_subsubcategories_content">
                          <ul class="admin_sesforums">
                          <?php $subsubCategorieForum = $subsubCategorie->getChildren('sesforum_forum', array('order'=>'order')); 
                          ?>
                          <?php foreach ($subsubCategorie->getChildren('sesforum_forum', array('order'=>'order')) as $sesforum):?>
                              <li>
                              <?php if(!empty($sesforum->forum_icon)) { ?>
                                  <span class="admin_sesforums_icon">
                                  <?php $forum_icon = Engine_Api::_()->storage()->get($sesforum->forum_icon, '');
                                  if($forum_icon) {
                                  $forum_icon = $forum_icon->map(); ?>
                                      <img alt="" src="<?php echo $forum_icon ?>" />
                                  <?php } else { ?>
                                      <?php echo "---"; ?>
                                  <?php } ?>
                                  </span>
                              <?php } ?>
                              <div class="admin_sesforums_options">
                                  <span class="admin_sesforums_moveup">
                                  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('move up'), array('onclick' => 'moveSesforumUp(' . $sesforum->getIdentity() .');'));?> |
                                  </span>
                                  <a href="<?php echo $this->url(array('action'=>'edit-forum', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("edit") ?></a>
                                  | <a class="smoothbox" href="<?php echo $this->url(array('action'=>'delete-forum', 'forum_id'=>$sesforum->getIdentity()));?>"><?php echo $this->translate("delete") ?></a>
                              </div>
                              <div class="admin_sesforums_info">
                                  <span class="admin_sesforums_title">
                                  <?php echo $sesforum->getTitle();?>
                                  </span>
                                  <span class="admin_sesforums_description">
                                  <?php echo $sesforum->getDescription();?>
                                  </span>
                                  <span class="admin_sesforums_moderators">
                                  <span class="admin_sesforums_moderators_top">
                                      <?php echo $this->translate("Moderators") ?>
                                      (<a href="<?php echo $this->url(array('action'=>'add-moderator', 'format'=>'smoothbox', 'forum_id'=>$sesforum->getIdentity()));?>" class="smoothbox"><?php echo $this->translate("add") ?></a>)
                                  </span>
                                  <span>
                                      <?php
                                      $i = 0;
                                      foreach ($sesforum->getModeratorList()->getAllChildren() as $moderator)
                                      {
                                          if ($i > 0)
                                          {
                                          echo ', ';
                                          }
                                          $i++;
                                          echo $moderator->__toString() . ' (<a class="smoothbox" href="' . $this->url(array('action'=>'remove-moderator', 'forum_id'=>$sesforum->getIdentity(), 'user_id'=>$moderator->getIdentity())) . '">' . $this->translate("remove") . '</a>)';
                                      }
                                      ?>
                                  </span>
                                  </span>
                              </div>
                              </li>
                          <?php endforeach;?>
                          </ul>
                        </div>
                    <?php } ?>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
          <?php } ?>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
</div>    

