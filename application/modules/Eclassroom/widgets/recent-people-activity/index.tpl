<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $likeCounter = 0;?>
<?php $favouriteCounter = 0;?>
<?php $followCounter = 0;?>
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs">
	<!------- people Liked classroom ------->
  <?php if(isset($this->likeActive)):?>
    <?php if(count($this->likeMembers)):?>
      <div class="eclassroom_people_like_field sesbasic_clearfix">
        <div class="eclassroom_people_like_title sesbasic_clearfix">
        	<i class="fa fa-thumbs-up"></i>
        	<span><?php echo $this->translate("People Who Liked");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->likeMembers as $member):?>
            <?php if($likeCounter == $this->params['view_more_like']):?>
              <?php break;?>
            <?php endif;?>
              <?php $item = Engine_Api::_()->getItem('user', $member['poster_id']);?>
            <li class="eclassroom_people_like_list">
              <div class="eclassroom_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])? $this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])? $this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?></a>
              </div>
            </li>
            <?php $likeCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->likeMembers) > $this->params['view_more_like']):?>
            <li class="eclassroom_more_link eclassroom_people_like_list">
              <a href="javascript:void(0);" onclick="getLikeData('<?php echo $this->classroom->classroom_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])? $this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->likeMembers)+1) - $this->params['view_more_like'];?></a>
            </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
  
  <?php if(isset($this->favouriteActive)):?>
    <?php if(count($this->favMembers)):?>
      <div class="eclassroom_people_like_field sesbasic_clearfix">
        <div class="eclassroom_people_like_title sesbasic_clearfix">
        	<i class="fa fa-heart"></i>
          <span><?php echo $this->translate("People Who Favourited");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->favMembers as $member):?>
            <?php if($favouriteCounter == $this->params['view_more_favourite']):?>
              <?php break;?>
            <?php endif;?>
            <?php $item = Engine_Api::_()->getItem('user', $member['owner_id']);?>
            <li class="eclassroom_people_like_list">
              <div class="eclassroom_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?></a>
              </div>
            </li>
            <?php $favouriteCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->favMembers) > $this->params['view_more_favourite']):?>
             <li class="eclassroom_more_link eclassroom_people_like_list">
              <a href="javascript:void(0);" onclick="getFavouriteData('<?php echo $this->classroom->classroom_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->favMembers)+1) - $this->params['view_more_favourite'];?></a>
           </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
  
  <?php if(isset($this->followActive)):?>
    <?php if(count($this->followMembers)):?>
      <div class="eclassroom_people_like_field sesbasic_clearfix">
      	<div class="eclassroom_people_like_title sesbasic_clearfix">
        	<i class="fa fa-users"></i>
          <span><?php echo $this->translate("People Who Followed");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->followMembers as $member):?>
            <?php if($followCounter == $this->params['view_more_follow']):?>
              <?php break;?>
            <?php endif;?>
            <?php $item = Engine_Api::_()->getItem('user', $member['owner_id']);?>
            <li class="eclassroom_people_like_list">
              <div class="eclassroom_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?> </a>
              </div>
            </li>
            <?php $followCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->followMembers) > $this->params['view_more_follow']):?>
            <li class="eclassroom_more_link eclassroom_people_like_list">
              <a href="javascript:void(0);" onclick="getFollowerData('<?php echo $this->classroom->classroom_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->followMembers)+1) - $this->params['view_more_follow'];?></a>
            </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
  
  <?php if(isset($this->reviewActive)):?>
    <?php if(count($this->reviewMembers)):?>
      <div class="eclassroom_people_like_field sesbasic_clearfix">
      	<div class="eclassroom_people_like_title sesbasic_clearfix">
        	<i class="fa fa-star"></i>
          <span><?php echo $this->translate("People Who Review");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->reviewMembers as $member):?>
            <?php if($reviewCounter == $this->params['view_more_reviews']):?>
              <?php break;?>
            <?php endif;?>
            <?php $item = Engine_Api::_()->getItem('user', $member['owner_id']);?>
            <li class="eclassroom_people_like_list">
              <div class="eclassroom_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?> </a>
              </div>
            </li>
            <?php $reviewCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->reviewMembers) > $this->params['view_more_reviews']):?>
            <li class="eclassroom_more_link eclassroom_people_like_list">
              <a href="javascript:void(0);" onclick="getReviewData('<?php echo $this->classroom->classroom_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->reviewMembers)+1) - $this->params['view_more_reviews'];?></a>
            </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
</div>

<script type='text/javascript'>
  function getLikeData(value){
    if(value){
      url = en4.core.staticBaseUrl+'eclassroom/ajax/like-classroom/classroom_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  }  
  function getFavouriteData(value){
    if(value){
      url = en4.core.staticBaseUrl+'eclassroom/ajax/favourite-classroom/classroom_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  } 
  function getFollowerData(value){
    if(value){
      url = en4.core.staticBaseUrl+'eclassroom/ajax/follow-classroom/classroom_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  } 
  function getReviewData(value){
    if(value){
      url = en4.core.staticBaseUrl+'eclassroom/ajax/review-classroom/classroom_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  } 
</script>
