<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $this->subject->page_id,'resource_type' => $this->subject->getType())); ?>
  <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
  <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
  <div class="sespage_sidebar_button">
    <a href='javascript:;' data-type='follow_page_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sespage_likefavfollow sespage_follow_view_<?php echo $this->subject->getIdentity(); ?> sespage_follow_page_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>     
  </div>
<?php endif; ?>
  

