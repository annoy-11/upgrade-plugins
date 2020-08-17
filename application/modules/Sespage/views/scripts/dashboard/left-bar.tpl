<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $levelId = Engine_Api::_()->getItem('user',$this->page->owner_id)->level_id;?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/style_dashboard.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php if(SESPAGEPACKAGE == 1 && isset($this->page->package_id) && $this->page->package_id ):?>
  <?php $package = Engine_Api::_()->getItem('sespagepackage_package', $this->page->package_id);?>
  <?php $params = json_decode($package->params,true);?>
<?php endif; ?>
<?php $privacy = $this->page->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle sespage_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('sespage.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle sespage_dashboard_container">
<div class="sespage_dashboard_wrapper sesbasic_clearfix">
  <div class="sespage_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="sespage_dashboard_top_section_left">
      <div class="sespage_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->page->getHref(), $this->itemPhoto($this->page, 'thumb.icon')) ?></div>
      <div class="sespage_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->page->getHref(),$this->page->getTitle()); ?></div>
    </div>
      <div class="sespage_dashboard_top_section_btns">
      <a href="<?php echo $this->page->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Page"); ?></a>
      <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_dashboard','delete')){ ?>
        <a href="<?php echo $this->url(array('page_id' => $this->page->page_id,'action'=>'delete'), 'sespage_general', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Page"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="sespage_dashboard_tabs sesbasic_bxs">
    <?php if(SESPAGEPACKAGE == 1) { ?>
      <div class="sespage_db_package_info sesbasic_clearfix"><?php echo $this->content()->renderWidget('sespagepackage.page-renew-button',array('sespage_page'=>$this->page)); ?></div>
    <?php } ?> 
    <ul class="sesbm">
    <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_dashboard')){ ?>
      <li class="sesbm">
        <?php $manage_page = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'manage_page')); ?>
        <a href="#Manage" class="sespage_dashboard_nopropagate"> <i class="tab-icon db_icon_page"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_page->title); ?></span> </a>
        <?php $edit_page = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'edit_page')); ?>
         <?php $manageLocation = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'location')); ?>
        <?php $edit_photo = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'edit_photo')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'contact_information')); ?>
        <?php $style = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'style')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'open_hour')); ?>
        <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'upgrade')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'post_attribution')); ?>
        <?php $pageRoles = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_roles')); ?>
        <?php $crossPost = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_crosspost')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'manage_notifications')); ?>
                
        <?php $backgroundphoto = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'backgroundphoto')); ?>
         <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'profile_field')); ?>
         <?php $chnageOwner = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'change_owner')); ?>
         <?php $layoutDesign = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'layout_design')); ?>
        <ul class="sesbm">	
          <?php if($edit_page->enabled): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_page->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((!empty($upgrade) && $upgrade->enabled && isset($params))): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'upgrade'), 'sespage_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-refresh "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.location', 1) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'allow_mlocation') && $manageLocation->enabled): ?>
            <li>
              <a href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'manage-location'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($manageLocation->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled && ((isset($params) && $params['page_contactinfo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_contactinfo')))): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'contact-information'), 'sespage_dashboard', true); ?>" class="sespage_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>   
          <?php if(@$crossPost->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_crosspost')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'cross-post'), 'sespage_dashboard', true); ?>"><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($crossPost->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$pageRoles->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_allow_roles')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'page-roles'), 'sespage_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($pageRoles->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'manage-notification'), 'sespage_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_attribution') && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'post-attribution'), 'sespage_dashboard', true); ?>"><i class="fa fa-file-o"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_close')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'open-hours'), 'sespage_dashboard', true); ?>"><i class="fa fa-clock-o"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->sespage()->getFieldsCount($this->page);?>
            <?php if($countFields):?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'profile-field'), 'sespage_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
          <?php if(@$chnageOwner->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_changeowner')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'change-owner'), 'sespage_dashboard', true); ?>"><i class="fa fa-user-circle"></i><span><?php echo $this->translate($chnageOwner->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_promotions')){ ?>
      <li class="sesbm">
        <?php $manage_page = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_promotion')); ?>
        <a href="#Manage" class="sespage_dashboard_nopropagate"> <i class="tab-icon db_icon_page"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_page->title); ?></span> </a>
        <?php $manage_member = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'manage_member')); ?>
        <?php $contactPageOwner = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'contact_page_owner')); ?>
        <?php $seo = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'seo')); ?>
        <?php $overview = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'overview')); ?>
        <?php $linkedPages = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'linked_pages')); ?>
         <?php $advertise_pages = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'advertise_pages')); ?>
         <?php $announcement = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'announcement')); ?>
        <ul class="sesbm">	         
          <?php if($manage_member->enabled): ?>
            <li><a id="sespage_search_member_search" href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'manage-member'), 'sespage_dashboard', true); ?>" class="sespage_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-users "></i><span><?php echo $this->translate($manage_member->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((empty($params) || $params['auth_contactpage']) && @$contactPageOwner->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_contactpage')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'contact'), 'sespage_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($contactPageOwner->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($seo->enabled && ((isset($params) && $params['page_seo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_seo')))): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'seo'), 'sespage_dashboard', true); ?>" class="sespage_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($seo->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$overview->enabled && ((isset($params) && $params['page_overview']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_overview')))):?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'overview'), 'sespage_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><?php echo $this->translate($overview->title); ?></a></li>
          <?php endif; ?>  
          <?php if(Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_linkpage') && @$linkedPages->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'linked-page'), 'sespage_dashboard', true); ?>"><i class="fa fa-link"></i><span><?php echo $this->translate($linkedPages->title); ?></span></a></li>
          <?php endif; ?>
            <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.share', 1); ?>
          <?php if(@$advertise_pages->enabled && $allow_share): ?>
            <li><a class="sespage_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'advertise-page'), 'sespage_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($advertise_pages->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((empty($params) || $params['auth_announce'])  && @$announcement->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_announce')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'announcement'), 'sespage_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($announcement->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((empty($params) || $params['page_service']) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_service') && $pageservices->enabled): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'manage-service'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($pageservices->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_apps')){ ?>
      <li class="sesbm">
        <?php $page_manageapps = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_manageapps')); ?>
        <a href="#Manage" class="sespage_dashboard_nopropagate"> <i class="tab-icon db_icon_page"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($page_manageapps->title); ?></span> </a>
        <?php $enableTeam = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'page_team');
        $pageteam = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'pageteam'));
        $page_pageapps = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_pageapps'));
         ?>
        <?php $pageservices = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'pageservices')); 
        $sespage_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.service', 1);
        ?>
        <ul class="sesbm">
          <?php if($page_pageapps->enabled) { ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'manage-pageapps'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($page_pageapps->title); ?></span></a>
            </li>
          <?php } ?>
          <?php if((empty($params) || $params['page_service']) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_service') && $pageservices->enabled && $sespage_allow_service): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'manage-service'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($pageservices->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if($enableTeam && $pageteam->enabled && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespageteam')): ?>
            <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'manage-team'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($pageteam->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_styling')){ ?>
      <li class="sesbm">  
        <?php $managePageStyle = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'page_style')); ?>
        <a href="#Manage" class="sespage_dashboard_nopropagate"> <i class="tab-icon db_icon_page_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($managePageStyle->title); ?></span> </a>
        <ul class="sesbm">	
          <?php if($edit_photo->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->viewer(), 'upload_mainphoto')): ?>
           <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'mainphoto'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-camera"></i><span><?php echo $this->translate($edit_photo->title); ?></span></a>
           </li>
          <?php endif; ?>
          <?php if(@$backgroundphoto->enabled && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_bgphoto')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'backgroundphoto'), 'sespage_dashboard', true); ?>" ><i class="fa fa-photo"></i><span><?php echo $this->translate($backgroundphoto->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$layoutDesign->enabled && ((isset($params) && $params['page_choose_style']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_pagestyle')))): ?>
            <li><a  href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'design'), 'sespage_dashboard', true); ?>" class="sespage_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-desktop"></i><span><?php echo $this->translate($layoutDesign->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'page_edit_style') && @$style->enabled): ?>
            <li><a  href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'style'), 'sespage_dashboard', true); ?>" class="sespage_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($style->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($this->viewer()->getIdentity(),$this->page->getIdentity(),'manage_insight')){
      if((empty($params) || $params['auth_insightrpt']) && Engine_Api::_()->authorization()->isAllowed('sespage_page', $levelId, 'auth_insightrpt')){?>
        <li class="sesbm">  
          <?php $manageInsighReport = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'insightreport')); ?>
          <?php $insight = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'insight')); ?>
          <?php $report = Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('type' => 'report')); ?>
          <a href="#Manage" class="sespage_dashboard_nopropagate"> <i class="tab-icon db_icon_page_style"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manageInsighReport->title); ?></span> </a>
          <ul class="sesbm">	
            <?php if($insight->enabled): ?>
             <li><a href="<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'insights'), 'sespage_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-bar-chart"></i><span><?php echo $this->translate($insight->title); ?></span></a>
             </li>
            <?php endif; ?>
            <?php if(@$report->enabled): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'reports'), 'sespage_dashboard', true); ?>" ><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($report->title); ?></span></a></li>
           <?php endif; ?>
          </ul>	
        </li>
      <?php 
        }
      }?>
    </ul>
    <?php if(isset($this->page->cover_photo) && $this->page->cover_photo != 0 && $this->page->cover_photo != ''):?>
      <?php $pageCover = Engine_Api::_()->storage()->get($this->page->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $pageCover =''; ?>
    <?php endif;?>
    <div class="sespage_dashboard_page_info sesbasic_clearfix sesbm">
      <?php if(isset($this->page->cover_photo) && $this->page->cover_photo != 0 && $this->page->cover_photo != ''){ ?>
        <div class="sespage_dashboard_page_info_cover"> 
          <img src="<?php echo $pageCover; ?>" />
          <div class="sespage_dashboard_page_main_photo sesbm">
            <img src="<?php echo $this->page->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="sespage_dashboard_page_photo">
          <img src="<?php echo $this->page->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="sespage_dashboard_page_info_content sesbasic_clearfix sesbd">
        <div class="sespage_dashboard_page_info_title">
          <a href="<?php echo $this->page->getHref(); ?>"><?php echo $this->page->getTitle(); ?></a>
        </div>
        <?php if($this->page->category_id):?>
          <?php $category = Engine_Api::_()->getItem('sespage_category', $this->page->category_id);?>
          <?php if($category):?>
            <div class="sespage_dashboard_page_info_stat">
              <span>
                <span class="sespage_dashboard_page_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->page->is_approved){ ?>
          <div class="sespage_page_status sesbasic_clearfix unapproved clear floatL">
            <span class="sespage_page_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      	<?php echo $this->content()->renderWidget('sespage.advance-share',array('dashboard'=>true)); ?> 
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
    sesJqueryObject(document).on('click','.sespage_dashboard_nopropagate, .sespage_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('sespage_dashboard_nopropagate_content')){
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".sespage_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.sespage_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.sespage_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.sespage_dashboard_content').html(response);
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgsespage-wrapper').length)
          sesJqueryObject('#loadingimgsespage-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
    sesJqueryObject(".sespage_dashboard_tabs > ul li a").each(function() {
      var c = sesJqueryObject(this).attr("href");
      sesJqueryObject(this).click(function() {
        if(sesJqueryObject(this).hasClass('sespage_dashboard_nopropagate')){
          if(sesJqueryObject(this).parent().find('ul').is(":visible")){
            sesJqueryObject(this).parent().find('ul').slideUp()
          }else{
            sesJqueryObject(".sespage_dashboard_tabs ul ul").each(function() {
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
      if(sesJqueryObject('#sespage_ajax_form_submit').length>0)
        var submitFormVal= 'sespage_ajax_form_submit';
	  else if(sesJqueryObject('#sespage_ticket_submit_form').length>0)
        var submitFormVal= 'sespage_ticket_submit_form';
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
    sesJqueryObject(document).on('click','.sespage_ajax_delete',function(e){
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
  sesJqueryObject(document).on('submit','#sespage_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('page_calendar')){
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
        sesJqueryObject('#sespage_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#sespage_ajax_form_submit');
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
                sesJqueryObject('.sespage_dashboard_content').html(data);
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
    var email = sesJqueryObject('input[name="page_contact_email"]').val(),
    emailReg = "/^([w-.]+@([w-]+.)+[w-]{2,4})?$/";
    if(!emailReg.test(email) || email == ''){
      return false;
    }
    return true;
  }
  //validate phone number
  function checkPhone(){
    var phone = $('input[name="page_contact_phone"]').val(),
    intRegex = "/[0-9 -()+]+$/";
    if((phone.length < 6) || (!intRegex.test(phone))){
      return false;
    }
    return true;
  }
</script>
