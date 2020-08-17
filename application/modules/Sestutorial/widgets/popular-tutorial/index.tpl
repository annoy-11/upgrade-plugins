<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestutorial/externals/styles/styles.css'); ?>

<div class="sestutorial_sidebar_list sestutorial_clearfix sestutorial_bxs">
  <?php foreach($this->tutorials as $tutorial): ?>
    <div class="sestutorial_sidebar_list_item">
      <div class="sestutorial_sidebar_list_title">
        <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><i class="fa fa-file-text-o"></i> <span><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), $this->tutorialtitlelimit); ?></span></a>
      </div>
      <?php if(in_array('viewcount', $this->showinformation) || in_array('commentcount', $this->showinformation) || in_array('likecount', $this->showinformation) || in_array('ratingcount', $this->showinformation)): ?>
        <div class="sestutorial_sidebar_list_stats sestutorial_text_light">
          <?php if(in_array('viewcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s view', '%s views', $tutorial->view_count), $this->locale()->toNumber($tutorial->view_count)); ?>"><i class="fa fa-eye"></i> <?php echo $tutorial->view_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('commentcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s comment', '%s comments', $tutorial->comment_count), $this->locale()->toNumber($tutorial->comment_count)); ?>"><i class="fa fa-comment-o"></i> <?php echo $tutorial->comment_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('likecount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s like', '%s likes', $tutorial->like_count), $this->locale()->toNumber($tutorial->like_count)); ?>"><i class="fa fa-thumbs-o-up"></i> <?php echo $tutorial->like_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('ratingcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s rating', '%s ratings', $tutorial->rating), $this->locale()->toNumber($tutorial->rating)); ?>"><i class="fa fa-star-o"></i> <?php echo $tutorial->rating; ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if(in_array('description', $this->showinformation)): ?>
        <div class="sestutorial_sidebar_list_discrtiption">
          <p><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->description), $this->tutorialdescriptionlimit); ?> </p>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <?php if(in_array('viewAllLink', $this->showinformation)): ?>
    <div class="sestutorial_sidebar_list_item see_all"><a href="<?php echo $this->url(array('action' => 'browse'), 'sestutorial_general', true)?>"><?php echo $this->translate("View All"); ?><i class="fa fa-arrow-right"></i></a></div>
  <?php endif; ?>
</div>