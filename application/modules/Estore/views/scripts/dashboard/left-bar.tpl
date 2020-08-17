<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php  $levelId = Engine_Api::_()->getItem('user',$this->store->owner_id)->level_id;?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php if(ESTOREPACKAGE == 1 && isset($this->store->package_id) && $this->store->package_id ):?>
  <?php $package = Engine_Api::_()->getItem('estorepackage_package', $this->store->package_id);?>
  <?php  $params = json_decode($package->params,true);?>
<?php endif; ?>
<?php $privacy = $this->store->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle">
  <div class="generic_layout_container estore_dashboard_main_nav">
   <?php echo $this->content()->renderWidget('estore.browse-menu',array('dashboard'=>true)); ?> 
  </div>
</div>
<div class="layout_middle estore_dashboard_container">
<div class="estore_dashboard_wrapper sesbasic_clearfix">
  <div class="estore_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="estore_dashboard_top_section_left">
      <div class="estore_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->store->getHref(), $this->itemPhoto($this->store, 'thumb.icon')) ?></div>
      <div class="estore_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->store->getHref(),$this->store->getTitle()); ?></div>
    </div>
      <div class="estore_dashboard_top_section_btns">
      <a href="<?php echo $this->store->getHref(); ?>" class="estore_link_btn"><?php echo $this->translate("View Store"); ?></a>
      <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_dashboard','delete')){ ?>
        <a href="<?php echo $this->url(array('store_id' => $this->store->store_id,'action'=>'delete'), 'estore_general', true); ?>" class="estore_link_btn smoothbox"><?php echo $this->translate("Delete Store"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="estore_dashboard_tabs sesbasic_bxs">
    <?php if(ESTOREPACKAGE == 1) { ?>
      <div class="estore_db_package_info sesbasic_clearfix"><?php echo $this->content()->renderWidget('estorepackage.store-renew-button',array('store'=>$this->store)); ?></div>
    <?php } ?> 
    <ul class="sesbm">
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_dashboard')){ ?>
      <li class="sesbm">
        <?php $manage_store = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_store')); ?>
        <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_store->title); ?></span> </a>
        <?php $edit_store = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'edit_store')); ?>
        <?php $policy_store = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'policies_store')); ?>
         <?php $manageLocation = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'location')); ?>
        <?php $edit_photo = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'edit_photo')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'contact_information')); ?>
        <?php $style = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'style')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'open_hour')); ?>
        <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'estore')->getDashboardsItems(array('type' => 'upgrade')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'post_attribution')); ?>
        <?php $storeRoles = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_roles')); ?>
        <?php $crossPost = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_crosspost')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_notifications')); ?>
                
        <?php $backgroundphoto = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'backgroundphoto')); ?>
         <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'profile_field')); ?>
         <?php $chnageOwner = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'change_owner')); ?>
         <?php $layoutDesign = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'layout_design')); ?>
        <ul class="sesbm">	
          <?php if($edit_store->enabled): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_store->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($policy_store->enabled && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.termncondition', 1)): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'policy'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-file-alt"></i><span><?php echo $this->translate($policy_store->title); ?></span></a></li>
          <?php endif; ?>
          <?php if((!empty($upgrade) && $upgrade->enabled && isset($params))): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'upgrade'), 'estore_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-redo-alt "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'allow_mlocation') && $manageLocation->enabled): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-location'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($manageLocation->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled && ((isset($params) && $params['store_contactinfo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'bs_contactinfo')))): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'contact-information'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>   
          <?php if(@$crossPost->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_crosspost')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'cross-post'), 'estore_dashboard', true); ?>"><i class="fa fa-arrows"></i><span><?php echo $this->translate($crossPost->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$storeRoles->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'bs_allow_roles')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'store-roles'), 'estore_dashboard', true); ?>"><i class="fa fa-users"></i><span><?php echo $this->translate($storeRoles->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'manage-notification'), 'estore_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'seb_attribution') && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'post-attribution'), 'estore_dashboard', true); ?>"><i class="far fa-file-alt"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_close')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'open-hours'), 'estore_dashboard', true); ?>"><i class="far fa-clock"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->estore()->getFieldsCount($this->store);?>
            <?php if($countFields):?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'profile-field'), 'estore_dashboard', true); ?>"><i class="far fa-file-alt "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
          <?php if(@$chnageOwner->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_changeowner')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'change-owner'), 'estore_dashboard', true); ?>"><i class="fa fa-user-circle"></i><span><?php echo $this->translate($chnageOwner->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_product')){ ?>
    <li class="sesbm">
      <?php $manage_products = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_product')); ?>
      <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_products->title); ?></span> </a>
      <?php $manage_products = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_product_product')); ?>
      <ul class="sesbm">	         
        <?php if($manage_products->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-products'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-shopping-bag"></i><span><?php echo $this->translate($manage_products->title); ?></span></a></li>
        <?php endif; ?>

        <?php $manage_products = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_product_orders')); ?>
        <?php if($manage_products->enabled): ?>
        <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-orders'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($manage_products->title); ?></span></a></li>
        <?php endif; ?>
    
      </ul>
    </li>
    <?php } ?>    
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_payments')){ ?>
      <li class="sesbm">
        <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_payments')); ?>
        <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_orders->title); ?></span> </a>

        <ul class="sesbm">
          <?php $payment_general_taxes = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'payment_general_taxes')); ?>
          <?php if($payment_general_taxes->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'general-taxes'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-dollar-sign"></i><span><?php echo $this->translate($payment_general_taxes->title); ?></span></a></li>
          <?php endif; ?>

          <?php $payment_taxes = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'payment_taxes')); ?>
          <?php if($payment_taxes->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'taxes'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-money-bill"></i><span><?php echo $this->translate($payment_taxes->title); ?></span></a></li>
          <?php endif; ?>
          
          <?php $shipping_method = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'shipping_method')); ?>
          <?php if($shipping_method->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'shippings'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-truck"></i><span><?php echo $this->translate($shipping_method->title); ?></span></a></li>
          <?php endif; ?>

          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'payment_account')); ?>
          <?php if($manage_orders->enabled): ?>
            <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-orders'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-user-circle"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>

          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'payment_requested')); ?>
          <?php if($manage_orders->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'payment-requests'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-share"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>
          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'payment_received')); ?>
          <?php if($manage_orders->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'payment-transaction'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-reply"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>
          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'sales_stats')); ?>
          <?php if($manage_orders->enabled): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'sales-stats'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-chart-bar"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>
          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'sales_report')); ?>
          <?php if($manage_orders->enabled && ((isset($params) && $params['auth_insightrpt']) || (!isset($params)))): ?>
          <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'sales-reports'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-flag"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>
           <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'account_details')); ?>
         <?php if($manage_orders->enabled): ?>
            <li> <a  class="estore_dashboard_nopropagate_content dashboard_a_link" id="dashboard_account_details" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'account-details'), 'estore_dashboard', true); ?>"><i class="fa fa-flag"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a> </li>
         <?php endif; ?> 
        </ul>
      </li>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_promotions')){ ?>
      <li class="sesbm">
        <?php $manage_store = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_promotion')); ?>
        <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_store->title); ?></span> </a>
        <?php $manage_member = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'manage_member')); ?>
        <?php $contactStoreOwner = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'contact_store_owner')); ?>
        <?php $seo = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'seo')); ?>
        <?php $overview = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'overview')); ?>
        <?php $linkedStores = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'linked_stores')); ?>
         <?php $advertise_stores = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'advertise_stores')); ?>
         <?php $announcement = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'announcement')); ?>
        <ul class="sesbm">	         
          <?php if($manage_member->enabled): ?>
            <li><a id="estore_search_member_search" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-member'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-users "></i><span><?php echo $this->translate($manage_member->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$contactStoreOwner->enabled && ((isset($params) && $params['auth_contactstore']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_contactgp')))): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'contact'), 'estore_dashboard', true); ?>"><i class="fa fa-users"></i><span><?php echo $this->translate($contactStoreOwner->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($seo->enabled && ((isset($params) && $params['store_seo']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'store_seo')))): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'seo'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-alt"></i><span><?php echo $this->translate($seo->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$overview->enabled && ((isset($params) && $params['store_overview']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'bs_overview')))):?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'overview'), 'estore_dashboard', true); ?>"><i class="far fa-file-alt "></i><?php echo $this->translate($overview->title); ?></a></li>
          <?php endif; ?>  
          <?php if(Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_linkbusines') && @$linkedStores->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'linked-store'), 'estore_dashboard', true); ?>"><i class="fa fa-link"></i><span><?php echo $this->translate($linkedStores->title); ?></span></a></li>
          <?php endif; ?>
            <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1); ?>
          <?php if(@$advertise_stores->enabled && $allow_share): ?>
            <li><a class="estore_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'advertise-store'), 'estore_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($advertise_stores->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$announcement->enabled && ((isset($params) && $params['auth_announce']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_announce')))): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'announcement'), 'estore_dashboard', true); ?>"><i class="far fa-file-alt"></i><span><?php echo $this->translate($announcement->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($storeservices->enabled && ((isset($params) && $params['store_service']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'store_service')))): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'manage-service'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($storeservices->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li> 
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_apps')){ ?>
      <li class="sesbm">
        <?php $store_manageapps = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_manageapps')); ?>
        <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($store_manageapps->title); ?></span> </a>
        <?php $enableTeam = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'store_team');
        $storeteam = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'storeteam'));
        $store_storeapps = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_storeapps'));
         ?>
        <?php $storeservices = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'storeservices')); 
        $estore_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.service', 1);
        ?>
        <ul class="sesbm">
          <?php if($store_storeapps->enabled) { ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'manage-storeapps'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-globe"></i><span><?php echo $this->translate($store_storeapps->title); ?></span></a>
            </li>
          <?php } ?>
          <?php if(((isset($params) && $params['store_service']) || (!isset($params) && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'store_service'))) && $storeservices->enabled && $estore_allow_service): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'manage-service'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($storeservices->title); ?></span></a>
            </li>
          <?php endif; ?>
          <?php if($enableTeam && $storeteam->enabled && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estoreteam')): ?>
            <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'manage-team'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($storeteam->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($this->viewer()->getIdentity(),$this->store->getIdentity(),'manage_styling')){ ?>
      <li class="sesbm">  
        <?php $manageStoreStyle = Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('type' => 'store_style')); ?>
        <a href="#Manage" class="estore_dashboard_nopropagate"> <i class="tab-icon db_icon_store_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($manageStoreStyle->title); ?></span> </a>
        <ul class="sesbm">	
          <?php if($edit_photo->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $this->viewer(), 'upload_mainphoto')): ?>
           <li><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'mainphoto'), 'estore_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-camera"></i><span><?php echo $this->translate($edit_photo->title); ?></span></a>
           </li>
          <?php endif; ?>
          <?php if(@$backgroundphoto->enabled && Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'store_bgphoto')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'backgroundphoto'), 'estore_dashboard', true); ?>" ><i class="fa fa-image"></i><span><?php echo $this->translate($backgroundphoto->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'auth_bsstyle') && @$layoutDesign->enabled): ?>
            <li><a  href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'design'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-desktop"></i><span><?php echo $this->translate($layoutDesign->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(Engine_Api::_()->authorization()->isAllowed('stores', $levelId, 'bs_edit_style') && @$style->enabled): ?>
            <li><a  href="<?php echo $this->url(array('store_id' => $this->store->custom_url, 'action'=>'style'), 'estore_dashboard', true); ?>" class="estore_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($style->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
    <?php } ?>
    </ul>
    <?php if(isset($this->store->cover_photo) && $this->store->cover_photo != 0 && $this->store->cover_photo != ''):?>
      <?php $storeCover = Engine_Api::_()->storage()->get($this->store->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $storeCover =''; ?>
    <?php endif;?>
    <div class="estore_dashboard_store_info sesbasic_clearfix sesbm">
      <?php if(isset($this->store->cover_photo) && $this->store->cover_photo != 0 && $this->store->cover_photo != ''){ ?>
        <div class="estore_dashboard_store_info_cover"> 
          <img src="<?php echo $storeCover; ?>" />
          <div class="estore_dashboard_store_main_photo sesbm">
            <img src="<?php echo $this->store->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="estore_dashboard_store_photo">
          <img src="<?php echo $this->store->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="estore_dashboard_store_info_content sesbasic_clearfix sesbd">
        <div class="estore_dashboard_store_info_title">
          <a href="<?php echo $this->store->getHref(); ?>"><?php echo $this->store->getTitle(); ?></a>
        </div>
        <?php if($this->store->category_id):?>
          <?php $category = Engine_Api::_()->getItem('estore_category', $this->store->category_id);?>
          <?php if($category):?>
            <div class="estore_dashboard_store_info_stat">
              <span>
                <span class="estore_dashboard_store_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->store->is_approved){ ?>
          <div class="estore_store_status sesbasic_clearfix unapproved clear floatL">
            <span class="estore_store_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      	<?php echo $this->content()->renderWidget('estore.advance-share',array('dashboard'=>true)); ?> 
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
    sesJqueryObject(document).on('click','.estore_dashboard_nopropagate, .estore_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('estore_dashboard_nopropagate_content')){
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".estore_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.estore_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.estore_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.estore_dashboard_content').html(response);
           // en4.core.runonce.trigger();
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgestore-wrapper').length)
          sesJqueryObject('#loadingimgestore-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
    sesJqueryObject(".estore_dashboard_tabs > ul li a").each(function() {
      var c = sesJqueryObject(this).attr("href");
      sesJqueryObject(this).click(function() {
        if(sesJqueryObject(this).hasClass('estore_dashboard_nopropagate')){
          if(sesJqueryObject(this).parent().find('ul').is(":visible")){
            sesJqueryObject(this).parent().find('ul').slideUp()
          }else{
            sesJqueryObject(".estore_dashboard_tabs ul ul").each(function() {
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
      if(sesJqueryObject('#estore_ajax_form_submit').length>0)
        var submitFormVal= 'estore_ajax_form_submit';
	  else if(sesJqueryObject('#estore_ticket_submit_form').length>0)
        var submitFormVal= 'estore_ticket_submit_form';
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
    sesJqueryObject(document).on('click','.estore_ajax_delete',function(e){
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
    sesJqueryObject(document).on('click','.estore_tax_enadisable',function (e) {
      e.preventDefault();
        var that = sesJqueryObject(this).parent();
        if(sesJqueryObject(that).hasClass('active'))
            return;
      var url = sesJqueryObject(that).attr('href');
        sesJqueryObject(that).addClass('active');
        sesJqueryObject(this).attr('src','application/modules/Core/externals/images/loading.gif');
      sesJqueryObject.post(url,{},function (response) {
          var res = sesJqueryObject.parseJSON(response);
          sesJqueryObject(that).removeClass('active');
          if(res == 1){
            sesJqueryObject(that).find('img').attr('src','application/modules/Sesbasic/externals/images/icons/check.png');
          }else{
              sesJqueryObject(that).find('img').attr('src','application/modules/Sesbasic/externals/images/icons/error.png');
          }
      });
    });
  function multiDelete()
  {
      return confirm("<?php echo $this->translate("Are you sure you want to delete the selected items?") ?>");
  }
  function selectAll()
  {
      var i;
      var multidelete_form = $('multidelete_form');
      var inputs = multidelete_form.elements;
      for (i = 1; i < inputs.length; i++) {
          if (!inputs[i].disabled) {
              inputs[i].checked = inputs[0].checked;
          }
      }
  }
  
sesJqueryObject(document).on('submit','#filter_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimge-wrapper').show();
	sesJqueryObject('#sesproduct-search-order-img').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/dashboard/manage-products/<?php echo $this->subject()->custom_url;?>',
			data : {
				format : 'html',
				store_id:<?php echo $this->subject()->getIdentity();?>,
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimge-wrapper').hide();
				sesJqueryObject('#sesproduct-search-order-img').hide();
				sesJqueryObject('.estore_dashboard_content').html(response);
			}
	}).send();
});
  
 sesJqueryObject(document).on('submit','#manage_order_search_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgestore-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/dashboard/manage-orders/<?php echo $this->subject()->custom_url;?>',
			data : {
				format : 'html',
				store_id:<?php echo $this->subject()->getIdentity();?>,
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('.estore_dashboard_content').html(response);
					sesJqueryObject('#loadingimgestore-wrapper').hide();
			}
	}).send();
});
  var submitFormAjax;
  sesJqueryObject(document).on('submit','#estore_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('store_calendar')){
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
        sesJqueryObject('#estore_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#estore_ajax_form_submit');
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
                sesJqueryObject('.estore_dashboard_content').html(data);

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
    var email = sesJqueryObject('input[name="store_contact_email"]').val(),
    emailReg = "/^([w-.]+@([w-]+.)+[w-]{2,4})?$/";
    if(!emailReg.test(email) || email == ''){
      return false;
    }
    return true;
  }
  //validate phone number
  function checkPhone(){
    var phone = $('input[name="store_contact_phone"]').val(),
    intRegex = "/[0-9 -()+]+$/";
    if((phone.length < 6) || (!intRegex.test(phone))){
      return false;
    }
    return true;
  }
   function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesproduct/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id')) {
            $('subcat_id-label').parentNode.style.display = "none";
            $('subcat_id').innerHTML = '';
          }
					 if ($('subsubcat_id')) {
            $('subsubcat_id-label').parentNode.style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send(); 
  }
</script>
