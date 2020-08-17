<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->isFollow(array('resource_id' => $this->subject->business_id,'resource_type' => $this->subject->getType())); ?>
  <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
  <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
  <div class="sesbusiness_sidebar_button">
    <a href='javascript:;' data-type='follow_business_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sesbusiness_likefavfollow sesbusiness_follow_view_<?php echo $this->subject->getIdentity(); ?> sesbusiness_follow_business_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>     
  </div>
<?php endif; ?>
  

