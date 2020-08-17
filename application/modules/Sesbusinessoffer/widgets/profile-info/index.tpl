<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessoffer/externals/styles/style.css'); ?> 
<ul class='sesbasic_clearfix sesbasic_bxs sesbasic_sidebar_block sesbusinessoffer_sidebar_info_block'>
  <?php if(in_array('by',$this->criteria)){ ?>
    <li class="sesbasic_clearfix sesbusinessoffer_list_stats sesbusinessoffer_list_created_by"> <i title='<?php echo $this->translate("Created by"); ?>' class="fa fa-user"></i> <span><a href="<?php echo $this->subject->getOwner()->getHref(); ?>"><?php echo $this->translate('');?><?php echo $this->subject->getOwner()->getTitle(); ?></a></span> </li>
  <?php } ?>
  <?php if(in_array('creationDate',$this->criteria)){ ?>
  <li class="sesbasic_clearfix sesbusinessoffer_list_stats sesbusinessoffer_list_created_on"> <i title='<?php echo $this->translate("Created on"); ?>' class="fa fa-clock-o"></i> <span><?php echo $this->translate('%1$s', $this->timestamp($this->subject->creation_date)); ?></span> </li>
  <?php } ?>
  <?php if(in_array('businessname',$this->criteria)) { ?>
    <?php $business = Engine_Api::_()->getItem('businesses',$this->subject->parent_id); ?>
    <?php if($business) { ?>
      <li class="sesbasic_clearfix sesbusinessoffer_list_stats sesbusinessoffer_list_category"> <i title="<?php echo $this->translate("Business"); ?>" class="fa fa-long-arrow-right"></i> <span><a href="<?php echo $business->getHref(); ?>"><?php echo $business->getTitle(); ?></a></span> </li>
    <?php } ?>          
  <?php } ?>
  
  <?php if(count(array_intersect($this->criteria,array('likecount','commentcount','totalquantitycount','viewcount'))) > 0):?>
  <li class="sesbasic_clearfix sesbasic_text_light"> <i title="<?php echo $this->translate('Statistics'); ?>" class="fa fa-bar-chart"></i> <span>
    <?php if(in_array('commentcount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?>"><?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('likecount',$this->criteria)) { ?>
      <span title="<?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?>"><?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('viewcount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?>"><?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('favouritecount',$this->criteria)){ ?>
      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?>"><?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('followcount',$this->criteria)){ ?>
      <span title="<?php echo $this->translate(array('%s follower', '%s followers', $this->subject->follow_count), $this->locale()->toNumber($this->subject->follow_count)); ?>"><?php echo $this->translate(array('%s follower', '%s followers', $this->subject->follow_count), $this->locale()->toNumber($this->subject->follow_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('totalquantitycount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s total quantity', '%s total quantity', $this->subject->totalquantity), $this->locale()->toNumber($this->subject->totalquantity)); ?>"><?php echo $this->translate(array('%s total quantity', '%s total quantity', $this->subject->totalquantity), $this->locale()->toNumber($this->subject->totalquantity)); ?></span>,
    <?php } ?>
    </span> </li>
  <?php endif;?>
</ul>
