<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $levelId = Engine_Api::_()->getItem('user',$this->group->owner_id)->level_id;?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/style_dashboard.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php if(SESGROUPPACKAGE == 1 && isset($this->group->package_id) && $this->group->package_id ):?>
  <?php $package = Engine_Api::_()->getItem('sesgrouppackage_package', $this->group->package_id);?>
  <?php $params = json_decode($package->params,true);?>
<?php endif; ?>
<?php $privacy = $this->group->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle sesgroup_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('sesgroup.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle sesgroup_dashboard_container">
<div class="sesgroup_dashboard_wrapper sesbasic_clearfix">
  <div class="sesgroup_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="sesgroup_dashboard_top_section_left">
      <div class="sesgroup_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->group->getHref(), $this->itemPhoto($this->group, 'thumb.icon')) ?></div>
      <div class="sesgroup_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->group->getHref(),$this->group->getTitle()); ?></div>
    </div>
      <div class="sesgroup_dashboard_top_section_btns">
      <a href="<?php echo $this->group->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Group"); ?></a>
      <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_dashboard','delete')){ ?>
        <a href="<?php echo $this->url(array('group_id' => $this->group->group_id,'action'=>'delete'), 'sesgroup_general', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Group"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="sesgroup_dashboard_tabs sesbasic_bxs">
    <?php if(SESGROUPPACKAGE == 1) { ?>
      <div class="sesgroup_db_package_info sesbasic_clearfix"><?php echo $this->content()->renderWidget('sesgrouppackage.group-renew-button',array('sesgroup_group'=>$this->group)); ?></div>
    <?php } ?> 
    <ul class="sesbm">
    <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_dashboard')){ ?>
      <li class="sesbm">
        <?php $manage_group = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'manage_group')); ?>
        <a href="#Manage" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_icon_group"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_group->title); ?></span> </a>
        <?php $edit_group = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'edit_group')); ?>
         <?php $manageLocation = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'location')); ?>
        <?php $edit_photo = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'edit_photo')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'contact_information')); ?>
        <?php $style = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'style')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'open_hour')); ?>
        <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'upgrade')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'post_attribution')); ?>
        <?php $groupRules = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_rules')); ?>
        <?php $groupRoles = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_roles')); ?>
        <?php $crossPost = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_crosspost')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'manage_notifications')); ?>
                
        <?php $backgroundphoto = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'backgroundphoto')); ?>
         <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'profile_field')); ?>
         <?php $chnageOwner = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'change_owner')); ?>
         <?php $layoutDesign = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'layout_design')); ?>
        <ul class="sesbm">	
          <?php if($edit_group->enabled): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_group->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((!empty($upgrade) && $upgrade->enabled && isset($params)) && ($package->price > 0)): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'upgrade'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-refresh "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.location', 1) && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'allow_mlocation') && $manageLocation->enabled): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'manage-location'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($manageLocation->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled && ((isset($params) && $params['group_contactinfo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'gp_contactinfo')))): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'contact-information'), 'sesgroup_dashboard', true); ?>" class="sesgroup_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>   
          <?php if(@$crossPost->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_crosspost')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'cross-post'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($crossPost->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$groupRules->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'gp_allow_rules')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'group-rules'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($groupRules->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$groupRoles->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'gp_allow_roles')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'group-roles'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($groupRoles->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'manage-notification'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'gp_attribution') && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'post-attribution'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-o"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_close')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'open-hours'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-clock-o"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->sesgroup()->getFieldsCount($this->group);?>
            <?php if($countFields):?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'profile-field'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
          <?php if(@$chnageOwner->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_changeowner')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'change-owner'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-user-circle"></i><span><?php echo $this->translate($chnageOwner->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_promotions')){ ?>
      <li class="sesbm">
        <?php $manage_group = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_promotion')); ?>
        <a href="#Manage" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_icon_group"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_group->title); ?></span> </a>
        <?php $manage_member = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'manage_member')); ?>
        <?php $contactGroupOwner = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'contact_group_owner')); ?>
        <?php $seo = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'seo')); ?>
        <?php $overview = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'overview')); ?>
        <?php $linkedGroups = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'linked_groups')); ?>
         <?php $advertise_groups = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'advertise_groups')); ?>
         <?php $announcement = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'announcement')); ?>
        <ul class="sesbm">	         
          <?php if($manage_member->enabled): ?>
            <li><a id="sesgroup_search_member_search" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'manage-member'), 'sesgroup_dashboard', true); ?>" class="sesgroup_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-users "></i><span><?php echo $this->translate($manage_member->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$contactGroupOwner->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_contactgp')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'contact'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-user-secret"></i><span><?php echo $this->translate($contactGroupOwner->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($seo->enabled && ((isset($params) && $params['group_seo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'group_seo')))): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'seo'), 'sesgroup_dashboard', true); ?>" class="sesgroup_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($seo->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$overview->enabled && ((isset($params) && $params['group_overview']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'group_overview')))):?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'overview'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><?php echo $this->translate($overview->title); ?></a></li>
          <?php endif; ?>  
          <?php if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_linkgroup') && @$linkedGroups->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'linked-group'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-link"></i><span><?php echo $this->translate($linkedGroups->title); ?></span></a></li>
          <?php endif; ?>
            <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.share', 1); ?>
          <?php if(@$advertise_groups->enabled && $allow_share): ?>
            <li><a class="sesgroup_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'advertise-group'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($advertise_groups->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$announcement->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_announce')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'announcement'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($announcement->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'group_service') && $groupservices->enabled): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'manage-service'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($groupservices->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_apps')){ ?>
      <li class="sesbm">
        <?php $group_manageapps = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_manageapps')); ?>
        <a href="#Manage" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_icon_group"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($group_manageapps->title); ?></span> </a>
        <?php $enableTeam = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'group_team');
        $groupteam = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'groupteam'));
        $group_groupapps = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_groupapps'));
         ?>
        <?php $groupservices = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'groupservices')); 
        $sesgroup_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.service', 1);
        ?>
        <ul class="sesbm">
          <?php if($group_groupapps->enabled) { ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'manage-groupapps'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($group_groupapps->title); ?></span></a>
            </li>
          <?php } ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'group_service') && $groupservices->enabled && $sesgroup_allow_service): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'manage-service'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($groupservices->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if($enableTeam && $groupteam->enabled && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupteam')): ?>
            <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'manage-team'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($groupteam->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_styling')){ ?>
      <li class="sesbm">  
        <?php $manageGroupStyle = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'group_style')); ?>
        <a href="#Manage" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_icon_group_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($manageGroupStyle->title); ?></span> </a>
        <ul class="sesbm">	
          <?php if($edit_photo->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->viewer(), 'upload_mainphoto')): ?>
           <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'mainphoto'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-camera"></i><span><?php echo $this->translate($edit_photo->title); ?></span></a>
           </li>
          <?php endif; ?>
          <?php if(@$backgroundphoto->enabled && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'group_bgphoto')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'backgroundphoto'), 'sesgroup_dashboard', true); ?>" ><i class="fa fa-photo"></i><span><?php echo $this->translate($backgroundphoto->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$layoutDesign->enabled && ((isset($params) && $params['group_choose_style']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_groupstyle')))): ?>
            <li><a  href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'design'), 'sesgroup_dashboard', true); ?>" class="sesgroup_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-desktop"></i><span><?php echo $this->translate($layoutDesign->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'gp_edit_style') && @$style->enabled): ?>
            <li><a  href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'style'), 'sesgroup_dashboard', true); ?>" class="sesgroup_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($style->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('grouproles','sesgroup')->toCheckUserGroupRole($this->viewer()->getIdentity(),$this->group->getIdentity(),'manage_insight')){
      if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $levelId, 'auth_insightrpt')){?>
        <li class="sesbm">  
          <?php $manageInsighReport = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'insightreport')); ?>
          <?php $insight = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'insight')); ?>
          <?php $report = Engine_Api::_()->getDbTable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'report')); ?>
          <a href="#Manage" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_icon_group_style"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manageInsighReport->title); ?></span> </a>
          <ul class="sesbm">	
            <?php if($insight->enabled): ?>
             <li><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'insights'), 'sesgroup_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-bar-chart"></i><span><?php echo $this->translate($insight->title); ?></span></a>
             </li>
            <?php endif; ?>
            <?php if(@$report->enabled): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'reports'), 'sesgroup_dashboard', true); ?>" ><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($report->title); ?></span></a></li>
           <?php endif; ?>
          </ul>	
        </li>
      <?php 
        }
      }?>
     <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('egroupjoinfees')): ?>
      <li class="sesbm">
        <?php $tickets = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'entry_fees_paid_sespaidext')); ?>
        <?php if(isset($tickets)):?>
          <a href="#Order" class="sesgroup_dashboard_nopropagate"> <i class="tab-icon db_manage_fees"></i> <i class="tab-arrow fa fa-caret-down sesbasic_text_light"></i> <span><?php echo $this->translate($tickets->title); ?></span> </a>
        <?php endif;?>
        <?php $create_fees = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'create_feed_sespaidext')); ?>
        <?php $account_details = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'account_details_sespaidext')); ?>
        <?php $sales_statistics = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'sales_statistics_sespaidext')); ?>
        <?php $manage_orders = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'manage_orders_sespaidext')); ?>
        <?php $sales_orders = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'sales_orders_sespaidext')); ?>
        <?php $payment_requests = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'payment_requests_sespaidext')); ?>
        <?php $payment_transactions = Engine_Api::_()->getDbtable('dashboards', 'sesgroup')->getDashboardsItems(array('type' => 'payment_transactions_sespaidext')); ?>
          <ul class="sesbm">
            <?php if($create_fees->enabled): ?>
            <li> <a class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'create-entry-fees'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-plus"></i><?php echo $this->translate($create_fees->title); ?></a> </li>
            <?php endif; ?>
            <?php if($manage_orders->enabled): ?>
            <li> <a  id="sesgroup_manage_order" class="sesgroup_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'manage-orders'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-list-alt"></i><?php echo $this->translate($manage_orders->title); ?></a> </li>
            <?php endif; ?>
            <?php if($payment_requests->enabled): ?>
            <li> <a  class="sesgroup_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'payment-requests'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-money"></i><?php echo $this->translate($payment_requests->title); ?></a> </li>
            <?php endif; ?>
            <?php if($payment_transactions->enabled): ?>
            <li> <a  class="sesgroup_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'payment-transaction'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-money"></i><?php echo $this->translate($payment_transactions->title); ?></a> </li>
            <?php endif; ?>
            <?php if($sales_statistics->enabled): ?>
            <li> <a  class="sesgroup_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'sales-stats'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-bar-chart"></i><?php echo $this->translate($sales_statistics); ?></a> </li>
            <?php endif; ?>
            <?php if($sales_orders->enabled): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'sales-reports'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-file-text-o"></i><?php echo $this->translate($sales_orders); ?></a> </li>
          <?php endif; ?>
          <?php if($account_details->enabled): ?>
          <li> <a  class="sesgroup_dashboard_nopropagate_content dashboard_a_link" id="dashboard_account_details" href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'account-details'), 'sesgroup_dashboard', true); ?>"><i class="fa fa-paypal"></i><?php echo $this->translate($account_details->title); ?></a> </li>
          <?php endif; ?>        
        </ul>
      </li>
    <?php endif; ?>

    </ul>
    <?php if(isset($this->group->cover_photo) && $this->group->cover_photo != 0 && $this->group->cover_photo != ''):?>
      <?php $groupCover = Engine_Api::_()->storage()->get($this->group->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $groupCover =''; ?>
    <?php endif;?>
    <div class="sesgroup_dashboard_group_info sesbasic_clearfix sesbm">
      <?php if(isset($this->group->cover_photo) && $this->group->cover_photo != 0 && $this->group->cover_photo != ''){ ?>
        <div class="sesgroup_dashboard_group_info_cover"> 
          <img src="<?php echo $groupCover; ?>" />
          <div class="sesgroup_dashboard_group_main_photo sesbm">
            <img src="<?php echo $this->group->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="sesgroup_dashboard_group_photo">
          <img src="<?php echo $this->group->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="sesgroup_dashboard_group_info_content sesbasic_clearfix sesbd">
        <div class="sesgroup_dashboard_group_info_title">
          <a href="<?php echo $this->group->getHref(); ?>"><?php echo $this->group->getTitle(); ?></a>
        </div>
        <?php if($this->group->category_id):?>
          <?php $category = Engine_Api::_()->getItem('sesgroup_category', $this->group->category_id);?>
          <?php if($category):?>
            <div class="sesgroup_dashboard_group_info_stat">
              <span>
                <span class="sesgroup_dashboard_group_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->group->is_approved){ ?>
          <div class="sesgroup_group_status sesbasic_clearfix unapproved clear floatL">
            <span class="sesgroup_group_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      	<?php echo $this->content()->renderWidget('sesgroup.advance-share',array('dashboard'=>true)); ?> 
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
    sesJqueryObject(document).on('click','.sesgroup_dashboard_nopropagate, .sesgroup_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('sesgroup_dashboard_nopropagate_content')){
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".sesgroup_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.sesgroup_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.sesgroup_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.sesgroup_dashboard_content').html(response);
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgsesgroup-wrapper').length)
          sesJqueryObject('#loadingimgsesgroup-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
    sesJqueryObject(".sesgroup_dashboard_tabs > ul li a").each(function() {
      var c = sesJqueryObject(this).attr("href");
      sesJqueryObject(this).click(function() {
        if(sesJqueryObject(this).hasClass('sesgroup_dashboard_nopropagate')){
          if(sesJqueryObject(this).parent().find('ul').is(":visible")){
            sesJqueryObject(this).parent().find('ul').slideUp()
          }else{
            sesJqueryObject(".sesgroup_dashboard_tabs ul ul").each(function() {
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
      if(sesJqueryObject('#sesgroup_ajax_form_submit').length>0)
        var submitFormVal= 'sesgroup_ajax_form_submit';
	  else if(sesJqueryObject('#sesgroup_ticket_submit_form').length>0)
        var submitFormVal= 'sesgroup_ticket_submit_form';
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
    sesJqueryObject(document).on('click','.sesgroup_ajax_delete',function(e){
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
  sesJqueryObject(document).on('submit','#sesgroup_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('group_calendar')){
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
        sesJqueryObject('#sesgroup_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#sesgroup_ajax_form_submit');
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
                sesJqueryObject('.sesgroup_dashboard_content').html(data);
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
    var email = sesJqueryObject('input[name="group_contact_email"]').val(),
    emailReg = "/^([w-.]+@([w-]+.)+[w-]{2,4})?$/";
    if(!emailReg.test(email) || email == ''){
      return false;
    }
    return true;
  }
  //validate phone number
  function checkPhone(){
    var phone = $('input[name="group_contact_phone"]').val(),
    intRegex = "/[0-9 -()+]+$/";
    if((phone.length < 6) || (!intRegex.test(phone))){
      return false;
    }
    return true;
  }
</script>
