<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($this->subject->user_id); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<ul class="sesbasic_sidebar_block sesmember_sidebar_information_block sesbasic_clearfix sesbasic_bxs">
  <?php if( isset($this->profileTypeActive) && !empty($this->memberType) ): ?>
  <li class="sesmember_list_stats">
  	<span class="widthfull">
    	<i class="fa fa-user" title="<?php echo $this->translate('Member Type') ?>"></i>
      <span>
        <?php // @todo implement link ?>
        <?php echo $this->translate($this->memberType) ?>
      </span>  
    </span>
  </li>
  <?php endif; ?>
  <?php if( isset($this->networkActive) && !empty($this->networks) && count($this->networks) > 0 ): ?>
    <li class="sesmember_list_stats">
      <span class="widthfull">
        <i class="fa fa-globe" title="<?php echo $this->translate('Networks') ?>"></i>
        <span><?php echo $this->fluentList($this->networks, true) ?></span>
      </span>
    </li>
  <?php endif; ?>
  <?php  if(isset($this->updateInfoActive)): ?>
    <li class="sesmember_list_stats">
      <span class="widthfull">
	<i class="fa fa-pencil" title="<?php echo $this->translate('Last Update'); ?>"></i>
	<span>
	  <?php if($this->subject->modified_date != "0000-00-00 00:00:00"):?>
	    <?php echo $this->timestamp($this->subject->modified_date);?>
	  <?php else:?>
	    <?php echo $this->timestamp($this->subject->creation_date);?>
	  <?php endif;?>
	</span>
      </span>
    </li>
  <?php endif;?>
  <?php  if(isset($this->joinInfoActive)): ?>
    <li class="sesmember_list_stats">
      <span class="widthfull">
	<i class="fa fa-sign-in" title="<?php echo $this->translate('Joined'); ?>"></i>
	<span>
	  <?php echo $this->translate('Member since'); ?>
	  <?php echo $this->timestamp($this->subject->creation_date) ?>
	</span>
      </span>
    </li>
  <?php endif;?>
  <?php if( !$this->subject->enabled && $viewer->isAdmin() ): ?>
    <li class="sesmember_list_stats">
      <span class="widthfull">
        <i class="fa fa-user" title="<?php echo $this->translate('Enabled'); ?>"></i>
        <span>
          <?php echo $this->translate('Enabled -') ?>
          <?php echo $this->translate('No') ?>
        </span>
      </span>
    </li>
  <?php endif; ?>
  <?php  if(isset($this->locationActive) && $getUserInfoItem->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)): ?>
    <li class="sesmember_list_stats">
      <span class="widthfull">
	<i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
	<span title="<?php echo $getUserInfoItem->location; ?>"><a href="<?php echo $this->url(array('resource_id' => $this->subject->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl"><?php echo $getUserInfoItem->location ?></a></span>
      </span>
    </li>
  <?php endif;?>
  <?php if(isset($this->friendCountActive)): ?>  
    <li class="sesmember_list_stats">
      <span class="widthfull">      
      <?php $direction = Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction');
      if ( $direction == 0 ): ?>
	<i class="fa fa-users" title="<?php echo $this->translate('Followers'); ?>"></i>
	<span>  
	  <?php echo $this->translate(array('%s follower', '%s followers', $this->subject->membership()->getMemberCount($this->subject)),
	  $this->locale()->toNumber($this->subject->membership()->getMemberCount($this->subject))) ?>
	</span>        
      <?php else: ?>
	<i class="fa fa-users" title="<?php echo $this->translate('Friends'); ?>"></i>
	<span>
	  <?php echo $this->translate(array('%s friend', '%s friends', $this->subject->membership()->getMemberCount($this->subject)),
	      $this->locale()->toNumber($this->subject->membership()->getMemberCount($this->subject))) ?>
	</span>
      <?php endif; ?>
      </span>
    </li>
  <?php endif;?>
  <?php if(isset($this->mutualFriendCountActive) && ($viewer->getIdentity() && !$viewer->isSelf($this->subject)) && $mcount =  Engine_Api::_()->sesmember()->getMutualFriendCount($this->subject, $viewer) ): ?> 
    <li class="sesmember_list_stats">
      <span class="widthfull">
	<i class="fa fa-users" title="<?php echo $this->translate('Mutual Friends'); ?>"></i>
	<span>
	  <a href="<?php echo $this->url(array('user_id' => $this->subject->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo $mcount. $this->translate(' Mutual Friends'); ?></a>
	</span>
      </span>
    </li>
  <?php endif;?>
  <li class="sesmember_list_stats">
    <span class="widthfull">
      <i class="fa fa-bar-chart"></i>
      <span>
        <?php if(isset($this->likeActive) && isset($getUserInfoItem->like_count)): ?>
	  <span><?php echo $this->translate(array('%s like', '%s likes', $getUserInfoItem->like_count), $this->locale()->toNumber($getUserInfoItem->like_count)); ?></span>,
	<?php endif;?>
	<?php if(isset($this->viewActive) && isset($this->subject->view_count)): ?>
	  <span><?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)) ?></span>,
	<?php endif;?>
	<?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesmember_review', 'view')):?>
	  <span><?php echo round($getUserInfoItem->rating,1).'/5';?></span>
	<?php endif;?>
      </span>
    </span>
  </li>
</ul>
<script type="text/javascript">
  $$('.core_main_user').getParent().addClass('active');
</script>
