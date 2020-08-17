<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: left-bar.tpl 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>

<div class="layout_middle"> <?php echo $this->content()->renderWidget('sesqa.browse-menu'); ?> </div>
<div class="layout_middle">
  <div class="sesqa_dashboard_menu_list">
    <div class="sesbasic_dashboard_container sesbasic_clearfix">
      <div class="sesbasic_dashboard_top_section sesbasic_clearfix sesbm">
        <div class="sesbasic_dashboard_top_section_left">
          <div class="sesbasic_dashboard_top_section_item_photo"> <?php echo $this->htmlLink($this->question->getHref(), $this->itemPhoto($this->question, 'thumb.icon')) ?> </div>
          <div class="sesbasic_dashboard_top_section_item_title"> <?php echo $this->htmlLink($this->question->getHref(),$this->question->getTitle()); ?> </div>
        </div>
        <div class="sesbasic_dashboard_top_section_btns"> <a href="<?php echo $this->question->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Question"); ?></a>
          <?php if($this->question->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
          <a href="<?php echo $this->url(array('question_id' => $this->question->getIdentity(),'action'=>'delete'), 'sesqa_general', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Question"); ?></a>
          <?php } ?>
        </div>
      </div>
	  </div>
      <div class="sesbasic_dashboard_tabs sesbasic_bxs">
        <ul class="sesbm">
          <li class="sesbm">
            <ul class="sesbm sesbasic_bg" display="display:block;">
              <li><a href="<?php echo $this->url(array('question_id' => $this->question->getIdentity(), 'action'=>'edit'), 'sesqa_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa  fa-edit"></i> <?php echo $this->translate('Edit Details'); ?></a></li>
              <li><a href="<?php echo $this->url(array('question_id' => $this->question->getIdentity(), 'action'=>'edit-location'), 'sesqa_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker "></i> <?php echo $this->translate('Edit Location'); ?></a></li>
              <li><a href="<?php echo $this->url(array('question_id' => $this->question->getIdentity(), 'action'=>'edit-media'), 'sesqa_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-camera"></i> <?php echo $this->translate('Edit Media'); ?></a></li>
            </ul>
          </li>
        </ul>
        <?php if(isset($this->question->cover_photo) && $this->question->cover_photo != 0 && $this->question->cover_photo != ''){ 
        $questionCover =  Engine_Api::_()->storage()->get($this->question->cover_photo, '')->getPhotoUrl(); 
      }else
        $questionCover =''; 
      ?>
        <div class="sesqa_dashboard_listing_info sesbasic_clearfix">
          <?php if(isset($this->question->cover_photo) && $this->question->cover_photo != 0 && $this->question->cover_photo != ''){ ?>
          <div class="sesqa_dashboard_listing_photo sesbm"> <img src="<?php echo $questionCover; ?>" />
            <?php if($this->question->featured || $this->question->sponsored){ ?>
            <p class="">
              <?php if($this->question->sponsored ){ ?>
              <span class=""><?php echo $this->translate("Sponsored"); ?></span>
              <?php } ?>
              <?php if($this->question->featured ){ ?>
              <span class=""><?php echo $this->translate("Featured"); ?></span>
              <?php } ?>
            </p>
            <?php } ?>
            <?php if($this->question->verified ){ ?>
            <div class="sesqa_list_labels" title="<?php echo $this->translate("VERIFIED"); ?>"><i class="fa fa-check"></i> </div>
            <?php } ?>
            <div class="sesqa_deshboard_img_listing"> <img  src="<?php echo $this->question->getPhotoUrl(); ?>" /> </div>
          </div>
          <?php } else { ?>
          <div class="sesqa_dashboard_listing_photo sesbm">
            <div class="sesqa_deshboard_img_listing"> <img src="<?php echo $this->question->getPhotoUrl(); ?>" />
              <?php if($this->question->featured || $this->question->sponsored){ ?>
              <ul class="sesqa_labels">
                <?php if($this->question->sponsored ){ ?>
                <li class="sesqa_label_sponsored"><span title="<?php echo $this->translate('Sponsored Question'); ?>" class="sesqa_sponsored_label"><i class="fa fa-star"></i></span></li>
                <?php } ?>
                <?php if($this->question->featured ){ ?>
                <li class="sesqa_label_featured"><span title="<?php echo $this->translate('Featured Question'); ?>" class="sesqa_featured_label"><i class="fa fa-star"></i></span></li>
                <?php } ?>
                <?php if($this->question->verified ){ ?>
                <li class="sesqa_label_verified"><span title="<?php echo $this->translate('Verified Question'); ?>" class="sesqa_verified_label"><i class="fa fa-star"></i></span></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </div>
            <div class="sesqa_dashboard_listing_info_content sesbasic_clearfix sesbm">
              <div class="sesqa_dashboard_listing_details">
                <div class="sesqa_dashboard_listing_title"> <a href="<?php echo $this->question->getHref(); ?>"><b><?php echo $this->question->getTitle(); ?></b></a> </div>
                <?php if($this->question->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)):?>
                <?php $locationText = $this->translate('Location');?>
                <?php $locationvalue = $this->question->location;?>
                <?php echo $location = "<div>
                    <span class=\"widthfull\">
                      <i class=\"fa fa-map-marker sesbasic_text_light\" title=\"$locationText\"></i>
                      <span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $this->question->question_id,'resource_type'=>'sesqa_question','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"openSmoothbox\">".$this->question->location."</a></span>
                    </span>
                  </div>"; 
                ?>
                <?php endif;?>
                <?php if($this->question->category_id){ 
                $category = Engine_Api::_()->getItem('sesqa_category', $this->question->category_id);
              ?>
                <?php if($category) { ?>
                <div class="sesqa_list_stats"> <span><i class="fa fa-folder-open sesbasic_text_light"></i> <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a> </span> </div>
                <?php } ?>
                <?php } ?>
              </div>
            </div>
            <?php }; ?>
          </div>
        </div>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_sharing', 1)){ ?>
        <div class="sesqa_social_share_wrap"> <a href="javascript:void(0);" class="sesqa_share_button_toggle" title='<?php echo $this->translate("Share")?>'><i class="fa fa-share"></i> <?php echo $this->translate("Share")?></a>
          <div class="sesqa_social_share_options sesbasic_bg">
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->question->getHref()); ?>
            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->question, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?> </div>
        </div>
        <?php } ?>
      </div>
      
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
  var totalLinks = sesJqueryObject('.dashboard_a_link');
  for(var i =0;i < totalLinks.length ; i++){
      var data_url = sesJqueryObject(totalLinks[i]).attr('href');
      var linkurl = window.location.href ;
      if(linkurl.indexOf(data_url) > 0){
          sesJqueryObject(totalLinks[i]).parent().addClass('active');
      }
  }
});

</script>