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
<?php $likeCounter = 0;?>
<?php $favouriteCounter = 0;?>
<?php $followCounter = 0;?>
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs">
	<!------- people Liked business ------->
  <?php if(isset($this->likeActive)):?>
    <?php if(count($this->likeMembers)):?>
      <div class="sesbusiness_people_like_field sesbasic_clearfix">
        <div class="sesbusiness_people_like_title sesbasic_clearfix">
        	<i class="fa fa-thumbs-up"></i>
        	<span><?php echo $this->translate("People Who Liked");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->likeMembers as $member):?>
            <?php if($likeCounter == $this->params['view_more_like']):?>
              <?php break;?>
            <?php endif;?>
              <?php $item = Engine_Api::_()->getItem('user', $member['poster_id']);?>
            <li class="sesbusiness_people_like_list">
              <div class="sesbusiness_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])? $this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])? $this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?></a>
              </div>
            </li>
            <?php $likeCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->likeMembers) > $this->params['view_more_like']):?>
            <li class="sesbusiness_more_link sesbusiness_people_like_list">
              <a href="javascript:void(0);" onclick="getLikeData('<?php echo $this->business->business_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])? $this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->likeMembers)+1) - $this->params['view_more_like'];?></a>
            </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
  
  <?php if(isset($this->favouriteActive)):?>
    <?php if(count($this->favMembers)):?>
      <div class="sesbusiness_people_like_field sesbasic_clearfix">
        <div class="sesbusiness_people_like_title sesbasic_clearfix">
        	<i class="fa fa-heart"></i>
          <span><?php echo $this->translate("People Who Favourited");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->favMembers as $member):?>
            <?php if($favouriteCounter == $this->params['view_more_favourite']):?>
              <?php break;?>
            <?php endif;?>
            <?php $item = Engine_Api::_()->getItem('user', $member['owner_id']);?>
            <li class="sesbusiness_people_like_list">
              <div class="sesbusiness_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?></a>
              </div>
            </li>
            <?php $favouriteCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->favMembers) > $this->params['view_more_favourite']):?>
             <li class="sesbusiness_more_link sesbusiness_people_like_list">
              <a href="javascript:void(0);" onclick="getFavouriteData('<?php echo $this->business->business_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->favMembers)+1) - $this->params['view_more_favourite'];?></a>
           </li>
          <?php endif;?>
        </ul>
      </div>
    <?php endif;?>
  <?php endif;?>
  
  <?php if(isset($this->followActive)):?>
    <?php if(count($this->followMembers)):?>
      <div class="sesbusiness_people_like_field sesbasic_clearfix">
      	<div class="sesbusiness_people_like_title sesbasic_clearfix">
        	<i class="fa fa-users"></i>
          <span><?php echo $this->translate("People Who Followed");?></span>
        </div>
        <ul class="sesbasic_clearfix">
          <?php foreach($this->followMembers as $member):?>
            <?php if($followCounter == $this->params['view_more_follow']):?>
              <?php break;?>
            <?php endif;?>
            <?php $item = Engine_Api::_()->getItem('user', $member['owner_id']);?>
            <li class="sesbusiness_people_like_list">
              <div class="sesbusiness_people_like_list_img" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;">
                <a href="<?php echo $item->getHref();?>"><?php echo $this->itemBackgroundPhoto($item, 'thumb.profile');?> </a>
              </div>
            </li>
            <?php $followCounter++;?>
          <?php endforeach;?>
          <?php if(count($this->followMembers) > $this->params['view_more_follow']):?>
            <li class="sesbusiness_more_link sesbusiness_people_like_list">
              <a href="javascript:void(0);" onclick="getFollowerData('<?php echo $this->business->business_id; ?>')" style="height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;width:<?php echo is_numeric($this->params['width'])?$this->params['width'].'px':$this->params['width'];?>;line-height:<?php echo is_numeric($this->params['height'])?$this->params['height'].'px':$this->params['height'];?>;">+<?php echo (count($this->followMembers)+1) - $this->params['view_more_follow'];?></a>
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
      url = en4.core.staticBaseUrl+'sesbusiness/ajax/like-business/business_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  }  
  function getFavouriteData(value){
    if(value){
      url = en4.core.staticBaseUrl+'sesbusiness/ajax/favourite-business/business_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  } 
  function getFollowerData(value){
    if(value){
      url = en4.core.staticBaseUrl+'sesbusiness/ajax/follow-business/business_id/'+value;
      openURLinSmoothBox(url);	
      return;
    }
  } 
</script>
