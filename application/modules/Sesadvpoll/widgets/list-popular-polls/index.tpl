<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvpoll/externals/styles/styles.css'); ?>
<div class="generic_list_wrapper sesadvpoll_sidebar_widget">
	<ul class="generic_list_widget">
		<?php foreach( $this->paginator as $item ): ?>
			<li>
				<div class="photo">
					<?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon'), array('class' => 'thumb')) ?>
				</div>
				<div class="sesadvpoll_browse_info">
					<div class="sesadvpoll_browse_info_title">
						<?php if((in_array("title", $this->show_criteria))): ?>
              <?php if(strlen($item->getTitle()) > $this->title_truncation):?>
              <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
						<?php else:?>
              <?php $title = $item->getTitle();?>
						<?php endif; ?>
              <?php echo $this->htmlLink($item->getHref(), $title) ?>
						<?php endif; ?>
					</div>
           <?php if((in_array("description", $this->show_criteria))): ?>
          <?php if (!empty($item->description)): ?>
            <?php if(strlen($item->description) > $this->description_truncation):?>
              <?php $description = mb_substr($item->description,0,$this->description_truncation).'...';?>
            <?php else:?>
              <?php $description = $item->description;?>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="sesadvpoll_browse_info_desc sesbasic_text_light">
                <?php echo $description; ?>
              </div>
            <?php endif; ?>	
          <?php endif; ?>
        <?php endif; ?>
					<?php if((in_array("by", $this->show_criteria))): ?>
            <div class="stats sesbasic_text_light">
              <?php echo $this->translate('by %s', $this->htmlLink($item->getOwner(), $item->getOwner()->getTitle())) ?>
            </div>
					<?php endif; ?>
					<?php if(in_array('posteddate', $this->show_criteria)) { ?>
					<div class="stats sesbasic_text_light">
						<?php echo $this->timestamp($item->creation_date) ?>
					</div>
					<?php } ?>
					<div class="stats sesbasic_text_light">
						<?php if((in_array("view", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber(	$item->view_count)) ?>">
								<i class="fa fa-eye"></i> <span><?php echo $item->view_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("comment", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber(	$item->view_count)) ?>">
								<i class="fa fa-comment"></i> <span><?php echo $item->comment_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("like", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
								<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("favourite", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber(	$item->favourite_count)) ?>">
								<i class="fa fa-heart"></i> <span><?php echo $item->favourite_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("vote", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber(	$item->vote_count)) ?>">
								<i class="fa fa-hand-o-up"></i><span><?php echo $item->vote_count ;?></span>
							</span>
						<?php endif; ?>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
