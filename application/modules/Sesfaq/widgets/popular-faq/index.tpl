<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/styles/styles.css'); ?>

<div class="sesfaq_sidebar_list sesfaq_clearfix sesfaq_bxs">
  <?php foreach($this->faqs as $faq): ?>
    <div class="sesfaq_sidebar_list_item">
      <div class="sesfaq_sidebar_list_title">
        <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><i class="fa fa-file-text-o"></i> <span><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></span></a>
      </div>
      <?php if(in_array('viewcount', $this->showinformation) || in_array('commentcount', $this->showinformation) || in_array('likecount', $this->showinformation) || in_array('ratingcount', $this->showinformation)): ?>
        <div class="sesfaq_sidebar_list_stats sesfaq_text_light">
          <?php if(in_array('viewcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?>"><i class="fa fa-eye"></i> <?php echo $faq->view_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('commentcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?>"><i class="fa fa-comment-o"></i> <?php echo $faq->comment_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('likecount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?>"><i class="fa fa-thumbs-o-up"></i> <?php echo $faq->like_count; ?></p>
          <?php endif; ?>
          <?php if(in_array('ratingcount', $this->showinformation)): ?>
            <p title="<?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?>"><i class="fa fa-star-o"></i> <?php echo $faq->rating; ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if(in_array('description', $this->showinformation)): ?>
        <div class="sesfaq_sidebar_list_discrtiption">
          <p><?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?> </p>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <?php if(in_array('viewAllLink', $this->showinformation)): ?>
    <div class="sesfaq_sidebar_list_item see_all"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true)?>"><?php echo $this->translate("View All"); ?><i class="fa fa-arrow-right"></i></a></div>
  <?php endif; ?>
</div>