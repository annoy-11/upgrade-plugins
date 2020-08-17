<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $item = $this->item;
  $allParams = $this->allParams;
  $plusicon = $this->plusicon;
  $sharelimit = $this->sharelimit;
?>
<?php if(in_array('socialSharing', $allParams['show_criteria']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1) || in_array('likeButton', $allParams['show_criteria']) || in_array('favouriteButton', $allParams['show_criteria'])): ?>
  <div class="eblog_list_share_btns">
    <div class="eblog_list_btns"> 
      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
      <?php if(in_array('socialSharing', $allParams['show_criteria']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)):?>
        <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $plusicon, 'socialshare_icon_limit' => $sharelimit)); ?>
      <?php endif;?>
      <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
        <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
        <?php if(in_array('likeButton', $allParams['show_criteria']) && $canComment):?>
          <?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($item->blog_id,$item->getType()); ?>
          <a href="javascript:;" data-url="<?php echo $item->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $item->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
        <?php endif;?>
        
        <?php if(in_array('favouriteButton', $allParams['show_criteria']) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)): ?>
          <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$item->blog_id)); ?>
          <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $item->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->blog_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
        <?php endif;?>
      <?php endif;?>
    </div>
  </div>
<?php endif; ?>
