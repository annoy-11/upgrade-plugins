<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $crowdfunding = $this->crowdfunding; ?>
<?php $dashTable = Engine_Api::_()->getDbtable('dashboards', 'sescrowdfunding'); ?>
<?php $authorization = Engine_Api::_()->authorization(); ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php $levelId = Engine_Api::_()->getItem('user',$crowdfunding->owner_id)->level_id;?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<?php $privacy = $crowdfunding->authorization();?>
<?php $viewer = $this->viewer();?>


<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/styles/style_dashboard.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>

<div class="layout_middle sescrowdfunding_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('sescrowdfunding.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle sescrowdfunding_dashboard_container">
<div class="sescrowdfunding_dashboard_wrapper sesbasic_clearfix">
  <div class="sescrowdfunding_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="sescrowdfunding_dashboard_top_section_left">
      <div class="sescrowdfunding_dashboard_top_section_item_photo"><?php echo $this->htmlLink($crowdfunding->getHref(), $this->itemPhoto($crowdfunding, 'thumb.icon')) ?></div>
      <div class="sescrowdfunding_dashboard_top_section_item_title"><?php echo $this->htmlLink($crowdfunding->getHref(),$crowdfunding->getTitle()); ?></div>
    </div>
      <div class="sescrowdfunding_dashboard_top_section_btns">
      <a href="<?php echo $crowdfunding->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Crowdfunding"); ?></a>
      <?php if($crowdfunding->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
        <a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->crowdfunding_id,'action'=>'delete'), 'sescrowdfunding_specific', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Crowdfunding"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="sescrowdfunding_dashboard_tabs sesbasic_bxs"> 
    <ul class="sesbm">
      <li class="sesbm">
        <?php $manage_crowdfunding = $dashTable->getDashboardsItems(array('type' => 'manage_crowdfunding')); ?>
        <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_crowdfunding->title); ?></span> </a>
        <?php $edit_crowdfunding = $dashTable->getDashboardsItems(array('type' => 'edit_crowdfunding')); ?>
        <?php $editLocation = $dashTable->getDashboardsItems(array('type' => 'edit_location')); ?>
        <?php $contact_information = $dashTable->getDashboardsItems(array('type' => 'contact_information')); ?>
        <ul class="sesbm">
          <?php if(!empty($edit_crowdfunding) && $edit_crowdfunding->enabled): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-edit"></i> <?php echo $this->translate($edit_crowdfunding->title); ?></a></li>
          <?php endif; ?>
          
          <?php if(@$editLocation->enabled && !empty($crowdfunding->location) && $settings->getSetting('sescrowdfunding.enable.location', 1)): ?>
            <li><a  href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'edit-location'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker "></i> <?php echo $this->translate($editLocation->title); ?></a></li>
          <?php endif; ?>

          <?php if(!empty($contact_information) && $contact_information->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'contactinfo')): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'contact-information'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-envelope"></i> <?php echo $this->translate($contact_information->title); ?></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li class="sesbm">
        <?php $manage_crowdfunding = $dashTable->getDashboardsItems(array('type' => 'crowdfunding_promotion')); ?>
        <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_crowdfunding->title); ?></span> </a>
          <?php $seo = $dashTable->getDashboardsItems(array('type' => 'seo')); ?>
          <?php $overview = $dashTable->getDashboardsItems(array('type' => 'overview')); ?>
          <?php $advertise_crowdfundings = $dashTable->getDashboardsItems(array('type' => 'advertise_crowdfundings')); ?>
          <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.allow.share', 1); ?>
          <?php $announcement = $dashTable->getDashboardsItems(array('type' => 'announcement')); ?>
          <?php $rewards = $dashTable->getDashboardsItems(array('type' => 'rewards')); ?>
          <ul class="sesbm">
            <?php if(!empty($seo) && $seo->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'seo')): ?>
              <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'seo'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($seo->title); ?></span></a></li>
            <?php endif; ?>
            
            <?php if(!empty($overview) && @$overview->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'overview')): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'overview'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><?php echo $this->translate($overview->title); ?></a></li>
            <?php endif; ?>
            
            <?php $allow_share = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
            <?php if(@$advertise_crowdfundings->enabled && $allow_share): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'advertise-crowdfunding'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($advertise_crowdfundings->title); ?></span></a></li>
            <?php endif; ?>
            
            <?php if(@$announcement->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'auth_announce')): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'announcement'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($announcement->title); ?></span></a></li>
            <?php endif; ?>
            <?php if(@$rewards->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'auth_rewards')): ?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'rewards'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($rewards->title); ?></span></a></li>
            <?php endif; ?>
          </ul>
      </li>
    
      
      <li class="sesbm">
        <?php $crowdfunding_manageapps = $dashTable->getDashboardsItems(array('type' => 'crowdfunding_crowdfundingapps')); ?>
        <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($crowdfunding_manageapps->title); ?></span> </a>
        <?php 
          $enableTeam = $authorization->isAllowed('crowdfunding', $viewer,  'team');
          $crowdfundingteam = $dashTable->getDashboardsItems(array('type' => 'crowdfundingteam'));
         ?>
         <?php $manage_crowdfunding_albums = $dashTable->getDashboardsItems(array('type' => 'manage_crowdfunding_albums')); ?>
        <ul class="sesbm">
          
          <?php if(!empty($manage_crowdfunding_albums) && $manage_crowdfunding_albums->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'album')): ?>
            <?php $album_id = Engine_Api::_()->getDbtable('albums', 'sescrowdfunding')->getAlbumId($crowdfunding->crowdfunding_id); ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'manage-photos', 'album_id' => $album_id), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-photo"></i> <?php echo $this->translate($manage_crowdfunding_albums->title); ?></a></li>
          <?php endif; ?>
          
          <?php if($enableTeam && $crowdfundingteam->enabled && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sescrowdfundingteam')): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'manage-team'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i><span><?php echo $this->translate($crowdfundingteam->title); ?></span></a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    
      <li class="sesbm">  
        <?php $manageCrowdfundingStyle = $dashTable->getDashboardsItems(array('type' => 'crowdfunding_style')); ?>
        <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($manageCrowdfundingStyle->title); ?></span> </a>
        <ul class="sesbm">
          <?php $edit_photo = $dashTable->getDashboardsItems(array('type' => 'edit_photo')); ?>
          <?php $style = $dashTable->getDashboardsItems(array('type' => 'style')); ?>
          <?php $backgroundphoto = $dashTable->getDashboardsItems(array('type' => 'backgroundphoto')); ?>
          <?php $layoutDesign = Engine_Api::_()->getDbTable('dashboards', 'sescrowdfunding')->getDashboardsItems(array('type' => 'layout_design')); ?>
          <?php if(!empty($edit_photo) && $edit_photo->enabled && $authorization->isAllowed('crowdfunding', $this->viewer(), 'upload_mainphoto')): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'edit-photo'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-photo"></i> <?php echo $this->translate($edit_photo->title); ?></a></li>
          <?php endif; ?>
          
          <?php if(@$backgroundphoto->enabled && $authorization->isAllowed('crowdfunding', $this->viewer(), 'bgphoto')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'backgroundphoto'), 'sescrowdfunding_dashboard', true); ?>" ><i class="fa fa-photo"></i><span><?php echo $this->translate($backgroundphoto->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$layoutDesign->enabled && Engine_Api::_()->authorization()->isAllowed('crowdfunding', $levelId, 'auth_crodstyle')): ?>
            <li><a  href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'design'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-desktop"></i><span><?php echo $this->translate($layoutDesign->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$style->enabled && $authorization->isAllowed('crowdfunding', $levelId, 'edit_style')): ?>
            <li><a  href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'style'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($style->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
      
      <li class="sesbm">  
        <?php $paymentsettings = $dashTable->getDashboardsItems(array('type' => 'paymentsettings')); ?>
        <?php $sales_statistics = $dashTable->getDashboardsItems(array('type' => 'sales_statistics')); ?>
        <?php $sales_orders = $dashTable->getDashboardsItems(array('type' => 'sales_orders')); ?>
        <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding_style"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($paymentsettings->title); ?></span> </a>
        <?php $view_doners = $dashTable->getDashboardsItems(array('type' => 'view_doners')); ?>
        <?php $account_details = $dashTable->getDashboardsItems(array('type' => 'account_details')); ?>
        <?php $payment_requests = $dashTable->getDashboardsItems(array('type' => 'payment_requests')); ?>
        <?php $payment_transactions = $dashTable->getDashboardsItems(array('type' => 'payment_transactions')); ?>
        <ul class="sesbm">
          <?php if(@$view_doners->enabled): ?>
            <li><a  href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'view-doners'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-users"></i> <?php echo $this->translate($view_doners->title); ?></a></li>
          <?php endif; ?>
          <?php if(@$account_details->enabled): ?>
            <li><a  href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url, 'action'=>'account-details'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-paypal"></i> <?php echo $this->translate($account_details->title); ?></a></li>
          <?php endif; ?>
          <?php if($payment_requests->enabled): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'payment-requests'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-money sescf_db_payment_request_icon"></i> <?php echo $this->translate($payment_requests->title); ?></a> </li>
          <?php endif; ?>
          
          <?php if($payment_transactions->enabled): ?>
            <li><a href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'payment-transaction'), 'sescrowdfunding_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-money sescf_db_payment_received_icon"></i> <?php echo $this->translate($payment_transactions->title); ?></a> </li>
          <?php endif; ?>
        </ul>
      </li>
      
      <?php if($authorization->isAllowed('crowdfunding', $levelId, 'auth_insightrpt')) { ?>
        <li class="sesbm">  
          <?php $manageInsighReport = $dashTable->getDashboardsItems(array('type' => 'insightreport')); ?>
          <?php $sales_statistics = $dashTable->getDashboardsItems(array('type' => 'sales_statistics')); ?>
          <?php $sales_orders = $dashTable->getDashboardsItems(array('type' => 'sales_orders')); ?>
          <a href="#Manage" class="sescrowdfunding_dashboard_nopropagate"> <i class="tab-icon db_icon_crowdfunding_style"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manageInsighReport->title); ?></span> </a>
          <ul class="sesbm">
            <?php if($sales_statistics->enabled): ?>
              <li class="sesbm"> <a  class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'donations-stats'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-bar-chart"></i> <?php echo $this->translate($sales_statistics); ?></a> </li>
            <?php endif; ?>
            <?php if($sales_orders->enabled): ?>
              <li class="sesbm"> <a  class="dashboard_a_link" href="<?php echo $this->url(array('crowdfunding_id' => $crowdfunding->custom_url,'action'=>'donations-reports'), 'sescrowdfunding_dashboard', true); ?>"><i class="fa fa-file-text-o"></i> <?php echo $this->translate($sales_orders); ?></a> </li>
            <?php endif; ?>
          </ul>	
        </li>
      <?php } ?>
      
      
    </ul>
    <?php if(isset($crowdfunding->cover_photo) && $crowdfunding->cover_photo != 0 && $crowdfunding->cover_photo != ''):?>
      <?php $crowdfundingCover = Engine_Api::_()->storage()->get($crowdfunding->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $crowdfundingCover =''; ?>
    <?php endif;?>
    <div class="sescrowdfunding_dashboard_crowdfunding_info sesbasic_clearfix sesbm">
      <?php if(isset($crowdfunding->cover_photo) && $crowdfunding->cover_photo != 0 && $crowdfunding->cover_photo != ''){ ?>
        <div class="sescrowdfunding_dashboard_crowdfunding_info_cover"> 
          <img src="<?php echo $crowdfundingCover; ?>" />
          <div class="sescrowdfunding_dashboard_crowdfunding_main_photo sesbm">
            <img src="<?php echo $crowdfunding->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="sescrowdfunding_dashboard_crowdfunding_photo">
          <img src="<?php echo $crowdfunding->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="sescrowdfunding_dashboard_crowdfunding_info_content sesbasic_clearfix sesbd">
        <div class="sescrowdfunding_dashboard_crowdfunding_info_title">
          <a href="<?php echo $crowdfunding->getHref(); ?>"><?php echo $crowdfunding->getTitle(); ?></a>
        </div>
        <?php if($crowdfunding->category_id):?>
          <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $crowdfunding->category_id);?>
          <?php if($category):?>
            <div class="sescrowdfunding_dashboard_crowdfunding_info_stat">
              <span>
                <span class="sescrowdfunding_dashboard_crowdfunding_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1)) { ?>
          <?php echo $this->content()->renderWidget('sescrowdfunding.advance-share',array('dashboard'=>true)); ?> 
      	<?php } ?>
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
    sesJqueryObject(document).on('click','.sescrowdfunding_dashboard_nopropagate, .sescrowdfunding_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('sescrowdfunding_dashboard_nopropagate_content')){
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".sescrowdfunding_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.sescrowdfunding_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.sescrowdfunding_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.sescrowdfunding_dashboard_content').html(response);
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgsescrowdfunding-wrapper').length)
          sesJqueryObject('#loadingimgsescrowdfunding-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
    sesJqueryObject(".sescrowdfunding_dashboard_tabs > ul li a").each(function() {
      var c = sesJqueryObject(this).attr("href");
      sesJqueryObject(this).click(function() {
        if(sesJqueryObject(this).hasClass('sescrowdfunding_dashboard_nopropagate')){
          if(sesJqueryObject(this).parent().find('ul').is(":visible")){
            sesJqueryObject(this).parent().find('ul').slideUp()
          }else{
            sesJqueryObject(".sescrowdfunding_dashboard_tabs ul ul").each(function() {
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
      if(sesJqueryObject('#sescrowdfunding_ajax_form_submit').length>0)
        var submitFormVal= 'sescrowdfunding_ajax_form_submit';
	  else if(sesJqueryObject('#sescrowdfunding_ticket_submit_form').length>0)
        var submitFormVal= 'sescrowdfunding_ticket_submit_form';
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
    sesJqueryObject(document).on('click','.sescrowdfunding_ajax_delete',function(e){
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
  sesJqueryObject(document).on('submit','#sescrowdfunding_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('crowdfunding_calendar')){
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
        sesJqueryObject('#sescrowdfunding_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#sescrowdfunding_ajax_form_submit');
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
                sesJqueryObject('.sescrowdfunding_dashboard_content').html(data);
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
    var email = sesJqueryObject('input[name="crowdfunding_contact_email"]').val(),
    emailReg = "/^([w-.]+@([w-]+.)+[w-]{2,4})?$/";
    if(!emailReg.test(email) || email == ''){
      return false;
    }
    return true;
  }
  //validate phone number
  function checkPhone(){
    var phone = $('input[name="crowdfunding_contact_phone"]').val(),
    intRegex = "/[0-9 -()+]+$/";
    if((phone.length < 6) || (!intRegex.test(phone))){
      return false;
    }
    return true;
  }
</script>
