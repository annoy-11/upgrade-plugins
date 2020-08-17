<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $levelId = Engine_Api::_()->getItem('user',$this->business->owner_id)->level_id;?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/style_dashboard.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php if(SESBUSINESSPACKAGE == 1 && isset($this->business->package_id) && $this->business->package_id ):?>
  <?php $package = Engine_Api::_()->getItem('sesbusinesspackage_package', $this->business->package_id);?>
  <?php $params = json_decode($package->params,true);?>
<?php endif; ?>
<?php $privacy = $this->business->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle sesbusiness_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('sesbusiness.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle sesbusiness_dashboard_container">
<div class="sesbusiness_dashboard_wrapper sesbasic_clearfix">
  <div class="sesbusiness_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="sesbusiness_dashboard_top_section_left">
      <div class="sesbusiness_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->business->getHref(), $this->itemPhoto($this->business, 'thumb.icon')) ?></div>
      <div class="sesbusiness_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->business->getHref(),$this->business->getTitle()); ?></div>
    </div>
      <div class="sesbusiness_dashboard_top_section_btns">
      <a href="<?php echo $this->business->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Business"); ?></a>
      <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_dashboard','delete')){ ?>
        <a href="<?php echo $this->url(array('business_id' => $this->business->business_id,'action'=>'delete'), 'sesbusiness_general', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Business"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="sesbusiness_dashboard_tabs sesbasic_bxs">
    <?php if(SESBUSINESSPACKAGE == 1) { ?>
      <div class="sesbusiness_db_package_info sesbasic_clearfix"><?php echo $this->content()->renderWidget('sesbusinesspackage.business-renew-button',array(business=>$this->business)); ?></div>
    <?php } ?> 
    <ul class="sesbm">
    <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_dashboard')){ ?>
      <li class="sesbm">
        <?php $manage_business = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'manage_business')); ?>
        <a href="#Manage" class="sesbusiness_dashboard_nopropagate"> <i class="tab-icon db_icon_business"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_business->title); ?></span> </a>
        <?php $edit_business = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'edit_business')); ?>
         <?php $manageLocation = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'location')); ?>
        <?php $edit_photo = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'edit_photo')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'contact_information')); ?>
        <?php $style = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'style')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'open_hour')); ?>
        <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'upgrade')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'post_attribution')); ?>
        <?php $businessRoles = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_roles')); ?>
        <?php $crossPost = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_crosspost')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'manage_notifications')); ?>
                
        <?php $backgroundphoto = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'backgroundphoto')); ?>
         <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'profile_field')); ?>
         <?php $chnageOwner = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'change_owner')); ?>
         <?php $layoutDesign = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'layout_design')); ?>
        <ul class="sesbm">	
          <?php if($edit_business->enabled): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_business->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((!empty($upgrade) && $upgrade->enabled && isset($params))): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'upgrade'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-refresh "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1) && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'allow_mlocation') && $manageLocation->enabled): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'manage-location'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($manageLocation->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled && ((isset($params) && $params['business_contactinfo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'bs_contactinfo')))): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'contact-information'), 'sesbusiness_dashboard', true); ?>" class="sesbusiness_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>   
          <?php if(@$crossPost->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_crosspost')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'cross-post'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($crossPost->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$businessRoles->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'bs_allow_roles')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'business-roles'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($businessRoles->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'manage-notification'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'seb_attribution') && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'post-attribution'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-file-o"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_close')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'open-hours'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-clock-o"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->sesbusiness()->getFieldsCount($this->business);?>
            <?php if($countFields):?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'profile-field'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
          <?php if(@$chnageOwner->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_changeowner')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'change-owner'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-user-circle"></i><span><?php echo $this->translate($chnageOwner->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_promotions')){ ?>
      <li class="sesbm">
        <?php $manage_business = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_promotion')); ?>
        <a href="#Manage" class="sesbusiness_dashboard_nopropagate"> <i class="tab-icon db_icon_business"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_business->title); ?></span> </a>
        <?php $manage_member = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'manage_member')); ?>
        <?php $contactBusinessOwner = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'contact_business_owner')); ?>
        <?php $seo = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'seo')); ?>
        <?php $overview = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'overview')); ?>
        <?php $linkedBusinesses = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'linked_businesses')); ?>
         <?php $advertise_businesses = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'advertise_businesses')); ?>
         <?php $announcement = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'announcement')); ?>
        <ul class="sesbm">	         
          <?php if($manage_member->enabled): ?>
            <li><a id="sesbusiness_search_member_search" href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'manage-member'), 'sesbusiness_dashboard', true); ?>" class="sesbusiness_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-users "></i><span><?php echo $this->translate($manage_member->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$contactBusinessOwner->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_contactgp')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'contact'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($contactBusinessOwner->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($seo->enabled && ((isset($params) && $params['business_seo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'business_seo')))): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'seo'), 'sesbusiness_dashboard', true); ?>" class="sesbusiness_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($seo->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$overview->enabled && ((isset($params) && $params['business_overview']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'bs_overview')))):?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'overview'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><?php echo $this->translate($overview->title); ?></a></li>
          <?php endif; ?>  
          <?php if(Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_linkbusines') && @$linkedBusinesses->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'linked-business'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-link"></i><span><?php echo $this->translate($linkedBusinesses->title); ?></span></a></li>
          <?php endif; ?>
            <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.share', 1); ?>
          <?php if(@$advertise_businesses->enabled && $allow_share): ?>
            <li><a class="sesbusiness_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'advertise-business'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($advertise_businesses->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$announcement->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_announce')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'announcement'), 'sesbusiness_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($announcement->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'business_service') && $businesseservices->enabled): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'manage-service'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($businesseservices->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_apps')){ ?>
      <li class="sesbm">
        <?php $business_manageapps = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_manageapps')); ?>
        <a href="#Manage" class="sesbusiness_dashboard_nopropagate"> <i class="tab-icon db_icon_business"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($business_manageapps->title); ?></span> </a>
        <?php $enableTeam = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'business_team');
        $businessteam = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'businessteam'));
        $business_businessapps = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_businessapps'));
         ?>
        <?php $businesseservices = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'businesseservices')); 
        $sesbusiness_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.service', 1);
        ?>
        <ul class="sesbm">
          <?php if($business_businessapps->enabled) { ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'manage-businessapps'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($business_businessapps->title); ?></span></a>
            </li>
          <?php } ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'business_service') && $businesseservices->enabled && $sesbusiness_allow_service): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'manage-service'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($businesseservices->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if($enableTeam && $businessteam->enabled && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessteam')): ?>
            <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'manage-team'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($businessteam->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_styling')){ ?>
      <li class="sesbm">  
        <?php $manageBusinessStyle = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'business_style')); ?>
        <a href="#Manage" class="sesbusiness_dashboard_nopropagate"> <i class="tab-icon db_icon_business_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($manageBusinessStyle->title); ?></span> </a>
        <ul class="sesbm">	
          <?php if($edit_photo->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $this->viewer(), 'upload_mainphoto')): ?>
           <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'mainphoto'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-camera"></i><span><?php echo $this->translate($edit_photo->title); ?></span></a>
           </li>
          <?php endif; ?>
          <?php if(@$backgroundphoto->enabled && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'business_bgphoto')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'backgroundphoto'), 'sesbusiness_dashboard', true); ?>" ><i class="fa fa-photo"></i><span><?php echo $this->translate($backgroundphoto->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$layoutDesign->enabled && ((isset($params) && $params['business_choose_style']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_bsstyle')))): ?>
            <li><a  href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'design'), 'sesbusiness_dashboard', true); ?>" class="sesbusiness_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-desktop"></i><span><?php echo $this->translate($layoutDesign->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'bs_edit_style') && @$style->enabled): ?>
            <li><a  href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'style'), 'sesbusiness_dashboard', true); ?>" class="sesbusiness_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($style->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('businessroles','sesbusiness')->toCheckUserBusinessRole($this->viewer()->getIdentity(),$this->business->getIdentity(),'manage_insight')){
      if(Engine_Api::_()->authorization()->isAllowed('businesses', $levelId, 'auth_insightrpt')){?>
        <li class="sesbm">  
          <?php $manageInsighReport = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'insightreport')); ?>
          <?php $insight = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'insight')); ?>
          <?php $report = Engine_Api::_()->getDbTable('dashboards', 'sesbusiness')->getDashboardsItems(array('type' => 'report')); ?>
          <a href="#Manage" class="sesbusiness_dashboard_nopropagate"> <i class="tab-icon db_icon_business_style"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manageInsighReport->title); ?></span> </a>
          <ul class="sesbm">	
            <?php if($insight->enabled): ?>
             <li><a href="<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'insights'), 'sesbusiness_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-bar-chart"></i><span><?php echo $this->translate($insight->title); ?></span></a>
             </li>
            <?php endif; ?>
            <?php if(@$report->enabled): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'reports'), 'sesbusiness_dashboard', true); ?>" ><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($report->title); ?></span></a></li>
           <?php endif; ?>
          </ul>	
        </li>
      <?php 
        }
      }?>
    </ul>
    <?php if(isset($this->business->cover_photo) && $this->business->cover_photo != 0 && $this->business->cover_photo != ''):?>
      <?php $businessCover = Engine_Api::_()->storage()->get($this->business->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $businessCover =''; ?>
    <?php endif;?>
    <div class="sesbusiness_dashboard_business_info sesbasic_clearfix sesbm">
      <?php if(isset($this->business->cover_photo) && $this->business->cover_photo != 0 && $this->business->cover_photo != ''){ ?>
        <div class="sesbusiness_dashboard_business_info_cover"> 
          <img src="<?php echo $businessCover; ?>" />
          <div class="sesbusiness_dashboard_business_main_photo sesbm">
            <img src="<?php echo $this->business->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="sesbusiness_dashboard_business_photo">
          <img src="<?php echo $this->business->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="sesbusiness_dashboard_business_info_content sesbasic_clearfix sesbd">
        <div class="sesbusiness_dashboard_business_info_title">
          <a href="<?php echo $this->business->getHref(); ?>"><?php echo $this->business->getTitle(); ?></a>
        </div>
        <?php if($this->business->category_id):?>
          <?php $category = Engine_Api::_()->getItem('sesbusiness_category', $this->business->category_id);?>
          <?php if($category):?>
            <div class="sesbusiness_dashboard_business_info_stat">
              <span>
                <span class="sesbusiness_dashboard_business_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->business->is_approved){ ?>
          <div class="sesbusiness_business_status sesbasic_clearfix unapproved clear floatL">
            <span class="sesbusiness_business_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      	<?php echo $this->content()->renderWidget('sesbusiness.advance-share',array('dashboard'=>true)); ?> 
      </div>
    </div>
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
  var sendParamInSearch = '';
    sesJqueryObject(document).on('click','.sesbusiness_dashboard_nopropagate, .sesbusiness_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('sesbusiness_dashboard_nopropagate_content')){
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".sesbusiness_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.sesbusiness_dashboard_tabs > ul > li ul > li').each(function() {
          sesJqueryObject(this).removeClass('active');
        });			
        sesJqueryObject(this).parent().addClass('active');
        sesJqueryObject(this).parent().parent().parent().addClass('active');
      }	
    });
    var ajaxRequest;
    //get data through ajax
    function getDataThroughAjax(url){
      if(!url)return;
      history.pushState(null, null, url);
      if(typeof ajaxRequest != 'undefined')
      ajaxRequest.cancel();
      sesJqueryObject('.sesbusiness_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
      ajaxRequest = new Request.HTML({
        method: 'post',
        url : url,
        data : {
          format : 'html',
            is_ajax:true,
            dataAjax : sendParamInSearch,
            is_ajax_content:true,
        },
        onComplete: function(response) {
          sendParamInSearch = '';
          sesJqueryObject('.sesbusiness_dashboard_content').html(response);
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgsesbusiness-wrapper').length)
          sesJqueryObject('#loadingimgsesbusiness-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
    sesJqueryObject(".sesbusiness_dashboard_tabs > ul li a").each(function() {
      var c = sesJqueryObject(this).attr("href");
      sesJqueryObject(this).click(function() {
        if(sesJqueryObject(this).hasClass('sesbusiness_dashboard_nopropagate')){
          if(sesJqueryObject(this).parent().find('ul').is(":visible")){
            sesJqueryObject(this).parent().find('ul').slideUp()
          }else{
            sesJqueryObject(".sesbusiness_dashboard_tabs ul ul").each(function() {
              sesJqueryObject(this).slideUp();
            });
            sesJqueryObject(this).parent().find('ul').slideDown()
          }
          return false
        }	
      })
    });
    var error = false;
    var objectError ;
    var counter = 0;
    var customAlert;
    function validateForm(){
      var errorPresent = false;
      if(sesJqueryObject('#sesbusiness_ajax_form_submit').length>0)
        var submitFormVal= 'sesbusiness_ajax_form_submit';
	  else if(sesJqueryObject('#sesbusiness_ticket_submit_form').length>0)
        var submitFormVal= 'sesbusiness_ticket_submit_form';
      else
        return false;
	  objectError;
      sesJqueryObject('#'+submitFormVal+' input, #'+submitFormVal+' select,#'+submitFormVal+' checkbox,#'+submitFormVal+' textarea,#'+submitFormVal+' radio').each(
      function(index){
        customAlert = false;
        var input = sesJqueryObject(this);
        if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
          if(sesJqueryObject(this).prop('type') == 'checkbox'){
            value = '';
            if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
              value = 1;
            };
            if(value == '')
              error = true;
            else
              error = false;
            }else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
              if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                error = true;
              else
                error = false;
            }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
              if(sesJqueryObject(this).val() === '')
                error = true;
              else
                error = false;
            }else if(sesJqueryObject(this).prop('type') == 'radio'){
              if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
                error = true;
              else
                error = false;
            }else if(sesJqueryObject(this).prop('type') == 'textarea'){
              if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                error = true;
              else
                error = false;
            }else{
              if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                error = true;
              else
                error = false;
            }
            if(error){
             if(counter == 0){
              objectError = this;
             }
             counter++
            }else{}
            if(error)
            errorPresent = true;
            error = false;
          }
		});	
        return errorPresent ;
    }
    var ajaxDeleteRequest;
    sesJqueryObject(document).on('click','.sesbusiness_ajax_delete',function(e){
      e.preventDefault();
      var object = sesJqueryObject(this);
      var url = object.attr('href');
      var value = object.attr('data-value');
      if(!value)
          value = "Are you sure want to delete?";
      if(typeof ajaxDeleteRequest != 'undefined')
        ajaxDeleteRequest.cancel();
      if(confirm(value)){
        new Request.HTML({
        method: 'post',
        url : url,
        data : {
          format : 'html',
          is_ajax:true,
        },
        onComplete: function(response) {
          if(response)
          sesJqueryObject(object).parent().parent().remove();
          else
          alert('Something went wrong,please try again later');
        }
        }).send();
      }
    });
  var submitFormAjax;
  sesJqueryObject(document).on('submit','#sesbusiness_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('business_calendar')){
          alert('<?php echo $this->translate("Start date must be less than end date."); ?>');
        }else{
          alert('<?php echo $this->translate("Please complete the red mark fields"); ?>');
        }
      }
      if(typeof objectError != 'undefined'){
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
        sesJqueryObject('html, body').animate({
        scrollTop: errorFirstObject.offset().top
        }, 2000);
      }
      return false;	
    }else{
      if(!sesJqueryObject('#sesdashboard_overlay_content').length)
        sesJqueryObject('#sesbusiness_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#sesbusiness_ajax_form_submit');
        var formData = new FormData(this);
        formData.append('is_ajax', 1);
        submitFormAjax = sesJqueryObject.ajax({
          type:'POST',
          url: sesJqueryObject(this).attr('action'),
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){
            sesJqueryObject('#sesdashboard_overlay_content').hide();
            var dataJson = data;
            try{
              var dataJson = JSON.parse(data);
            }catch(err){
                //silence
            }
            if(dataJson.redirect){
              sesJqueryObject('#'+dataJson.redirect).trigger('click');
              return;
            }else{
              if(data){
                sesJqueryObject('.sesbusiness_dashboard_content').html(data);
              }else{
                alert('Something went wrong,please try again later');	
              }
            }
          },
          error: function(data){
              //silence
          }
        });
      }
  });
  //validate email
  function checkEmail(){
    var email = sesJqueryObject('input[name="business_contact_email"]').val(),
    emailReg = "/^([w-.]+@([w-]+.)+[w-]{2,4})?$/";
    if(!emailReg.test(email) || email == ''){
      return false;
    }
    return true;
  }
  //validate phone number
  function checkPhone(){
    var phone = $('input[name="business_contact_phone"]').val(),
    intRegex = "/[0-9 -()+]+$/";
    if((phone.length < 6) || (!intRegex.test(phone))){
      return false;
    }
    return true;
  }
</script>
