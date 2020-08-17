<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _updownvote.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
  $isPageSubject = $this->viewer(); 
  $viewer_id = $isPageSubject->getIdentity();
  $item = $this->item;
  $isVote = Engine_Api::_()->getDbTable('voteupdowns','sesdiscussion')->isVote(array('resource_id'=>$item->getIdentity(),'resource_type'=>$item->getType(),'user_id'=>$isPageSubject->getIdentity(),'user_type'=>$isPageSubject->getType()));
?>
<div class="sesdiscussion_votebtn">
  <span class="upvote">
    <a href="javascript:;" data-viewerid="<?php echo $viewer_id; ?>" data-itemguid="<?php echo $item->getGuid(); ?>" data-userguid="<?php echo $isPageSubject->getGuid(); ?>" title="<?php echo $this->translate('Up Vote'); ?>" class="<?php echo !empty($isVote) && $isVote->type == "upvote" ? '_disabled ' : ""; ?> sesdiscussion_upvote_btn">
      <i class="fa fa-angle-up"></i>
      <span><?php echo $item->vote_up_count; ?></span>
    </a>
  </span>
  <span class="downvote">
    <a href="javascript:;" data-viewerid="<?php echo $viewer_id; ?>" data-itemguid="<?php echo $item->getGuid(); ?>" data-userguid="<?php echo $isPageSubject->getGuid(); ?>" title="<?php echo $this->translate('Down Vote'); ?>" class="<?php echo !empty($isVote) && $isVote->type == "downvote" ? '_disabled ' : ""; ?> sesdiscussion_downvote_btn">
      <i class="fa fa-angle-down"></i>
      <span><?php echo $item->vote_down_count; ?></span>
    </a>
  </span>
</div>