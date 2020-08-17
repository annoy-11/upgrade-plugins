<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $note = $item = $this->note; 
$allParams = $this->allParams;
?>

<div class="sespagenote_view_page">
  <div class="sespagenote_view_img">
    <img src="<?php echo $note->getPhotoUrl(); ?>" />
    <!-- Labels -->
     <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataLabel.tpl';?>
  </div>
    <h2>
      <?php echo $note->getTitle() ?>
    </h2>
   <ul>
    <li>
     <div class="sespagenote_view_stats sesbasic_text_light">
			<?php if(in_array('by', $allParams['show_criteria'])) { ?>
				<span><?php echo $this->translate('<i class="fa fa-user"></i>');?> <?php echo $this->htmlLink($note->getOwner()->getHref(), $note->getOwner()->getTitle()) ?></span>
      <?php } ?>
      <?php if(in_array('posteddate', $allParams['show_criteria'])) { ?>
				<span><i class="fa fa-clock-o"></i><?php echo $this->timestamp($note->creation_date) ?></span>
      <?php } ?>
      <span>
      <?php if(in_array('viewcount', $allParams['show_criteria'])) { ?>
				<?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', '<i class="fa fa-eye"></i> %s', $note->view_count), $this->locale()->toNumber($note->view_count)) ?>
      <?php } ?>
      <?php if(in_array('likecount', $allParams['show_criteria'])) { ?>
				<?php echo $this->translate(array('<i class="fa fa-thumbs-up"></i> %s', '<i class="fa fa-thumbs-up"></i> %s', $note->like_count), $this->locale()->toNumber($note->like_count)) ?>
      <?php } ?>
      <?php if(in_array('commentcount', $allParams['show_criteria'])) { ?>
				<?php echo $this->translate(array('<i class="fa fa-comment"></i> %s', '<i class="fa fa-comment"></i> %s', $note->comment_count), $this->locale()->toNumber($note->comment_count)) ?>
      <?php } ?>
      <?php if(in_array('favouritecount', $allParams['show_criteria'])) { ?>
				<?php echo $this->translate(array('<i class="fa fa-heart"></i> %s', '<i class="fa fa-heart"></i> %s', $note->favourite_count), $this->locale()->toNumber($note->favourite_count)) ?>
      <?php } ?>
      </span>
    </div>
    <div class="sespagenote_entrylist_entry_body rich_content_body">
      <?php echo $note->body ?>
    </div>
    <div class="sespagenote_view_footer">
    <?php if (in_array('tags', $allParams['show_criteria']) && count($this->noteTags )):?>
       <div class="sespagenote_tags">
        <?php foreach ($this->noteTags as $tag): ?>
				  <span> #<?php echo $tag->getTag()->text?>&nbsp; </span>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <!-- Share Buttons -->
    <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataSharing.tpl';?>
    </div>
  </li>
</ul>
</div>
