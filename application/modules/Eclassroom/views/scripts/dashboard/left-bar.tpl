<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: left-bar.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $levelId = Engine_Api::_()->getItem('user',$this->classroom->owner_id)->level_id; ?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/core.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#date-date_to{display:block !important;}
#date-date_from{display:block !important;}
</style>
<?php $privacy = $this->classroom->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle courses_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('eclassroom.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle courses_dashboard_container">
<div class="classroom_dashboard_wrapper sesbasic_clearfix">
  <div class="classroom_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="classroom_dashboard_top_section_left">
      <div class="classroom_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->classroom->getHref(), $this->itemPhoto($this->classroom, 'thumb.icon')) ?></div>
      <div class="classroom_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->classroom->getHref(),$this->classroom->getTitle()); ?></div>
    </div>
      <div class="classroom_dashboard_top_section_btns">
      <a href="<?php echo $this->classroom->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Classroom"); ?></a>
      <?php if(Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'delete')){ ?>
        <a href="<?php echo $this->url(array('classroom_id' => $this->classroom->classroom_id,'action'=>'delete'), 'eclassroom_general', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Classroom"); ?></a>
      <?php } ?>
    </div>
  </div>
  <div class="classroom_dashboard_tabs sesbasic_bxs">
    <ul class="sesbm">
      <li class="sesbm">
        <?php $manage_course = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_classroom')); ?>
        <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_course->title); ?></span> </a>
        <?php $edit_course = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'edit_classroom')); ?>
        <?php $edit_location = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'edit_location')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'contact_info')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'operating_hours')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'post_attri')); ?>
        <?php $classroomRoles = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'class_roles')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_notification')); ?>
        <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'cat_profile_info')); ?>
        <ul class="sesbm">	
          <?php if($edit_course->enabled): ?>
            <li><a href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_course->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($edit_location->enabled): ?>
            <li><a href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-location'), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($edit_location->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($terms_conditions->enabled && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.termncondition', 1)): ?>
            <li><a href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'policy'), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($terms_conditions->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled): ?>
            <li><a href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'contact-information'), 'eclassroom_dashboard', true); ?>" class="eclassroom_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$classroomRoles->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'bs_allow_roles')): ?>
            <li><a class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'classroom-roles'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-users"></i><span><?php echo $this->translate($classroomRoles->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'manage-notification'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'seb_attribution') && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'post-attribution'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-file-o"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled): ?>
            <li><a class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'open-hours'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-clock-o"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
           <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->eclassroom()->getFieldsCount($this->classroom);?>
            <?php if($countFields):?>
              <li><a class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'profile-field'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
        </ul>
      </li> 
      <?php if(Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($this->viewer()->getIdentity(),$this->classroom->getIdentity(),'manage_course')){ ?>
      <li class="sesbm">
        <?php $manage_classroom_orders = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_courses_orders')); ?>
        <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_classroom_orders->title); ?></span> </a>
        <?php $manage_course = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_course')); ?>
        <ul class="sesbm">	         
          <?php if($manage_course->enabled): ?>
            <li><a id="courses_search_member_search" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-courses'), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-book"></i><span><?php echo $this->translate($manage_course->title); ?></span></a></li>
          <?php endif; ?>
          <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_orders')); ?>
          <?php if($manage_orders->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-orders'), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <?php } ?>  
      <li class="sesbm">
        <?php $manage_reports = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_reports')); ?>
        <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_reports->title); ?></span> </a>
        <ul class="sesbm">
          <?php $sales_stats = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'sales_stats')); ?>
          <?php if($sales_stats->enabled): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" id="dashboard_account_details" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'sales-stats'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-bar-chart"></i><span><?php echo $this->translate($sales_stats->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $sales_reports = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'sales_reports')); ?>
          <?php if($sales_reports->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'sales-reports'), 'eclassroom_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-file-o"></i><span><?php echo $this->translate($sales_reports->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <?php if(Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($this->viewer()->getIdentity(),$this->classroom->getIdentity(),'manage_promotions')){ ?>
      <li class="sesbm">
        <?php $class_promotions = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'class_promotions')); ?>
        <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($class_promotions->title); ?></span> </a>
        <ul class="sesbm">	
          <?php $class_members = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'class_members')); ?>
          <?php if($class_members->enabled): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'account-details'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-envelope"></i><span><?php echo $this->translate($class_members->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $seo = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'seo')); ?>
          <?php if($seo->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'classroom_seo')): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'seo'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-file-text"></i><span><?php echo $this->translate($seo->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $overview = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'overview')); ?>
          <?php if($overview->enabled): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'overview'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-file-text-o"></i><span><?php echo $this->translate($overview->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $linked_class = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'linked_class')); ?>
          <?php if($linked_class->enabled): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'linked-classroom'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-link"></i><span><?php echo $this->translate($linked_class->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $advertise_class = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'advertise_class')); ?>
          <?php if($advertise_class->enabled): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'advertise-classroom'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-bullseye"></i><span><?php echo $this->translate($advertise_class->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $manage_announcements = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_announcements')); ?>
          <?php if($manage_announcements->enabled  && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'auth_announce')): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'announcement'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-bullhorn"></i><span><?php echo $this->translate($manage_announcements->title); ?></span></a> </li>
          <?php endif; ?>
        </ul>
      </li>
      <?php } ?>
      <?php if(Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($this->viewer()->getIdentity(),$this->classroom->getIdentity(),'manage_apps')){ ?>
      <li class="sesbm">
        <?php $manage_apps = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'manage_apps')); ?>
      <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_apps->title); ?></span> </a>
        <ul class="sesbm">	
          <?php $class_apps = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'class_apps')); ?>
          <?php if($class_apps->enabled): ?>
           <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-classroomapps'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-mobile"></i><span><?php echo $this->translate($class_apps->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $services = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'services')); ?>
          <?php if($services->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'service')): ?>
          <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-service'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-cog"></i><span><?php echo $this->translate($services->title); ?></span></a> </li>
          <?php endif; ?>
        </ul>
      </li>
      <?php } ?>
      <?php if(Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($this->viewer()->getIdentity(),$this->classroom->getIdentity(),'manage_styling')){ ?>
      <li class="sesbm">
        <?php $style = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'style')); ?>
        <a href="#Manage" class="eclassroom_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($style->title); ?></span> </a>
        <ul class="sesbm">	
          <?php $main_photo = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'main_photo')); ?>
          <?php if($main_photo->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'upload_mainphoto')): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'mainphoto'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-camera"></i><span><?php echo $this->translate($main_photo->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $bgphoto = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'bgphoto')); ?>
          <?php if($bgphoto->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'bgphoto')): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'backgroundphoto'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-photo"></i><span><?php echo $this->translate($bgphoto->title); ?></span></a> </li>
          <?php endif; ?>
           <?php $design_view = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'design_view')); ?>
          <?php if($design_view->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'bs_edit_style')): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'design'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-desktop"></i><span><?php echo $this->translate($design_view->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $css_style = Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('type' => 'css_style')); ?>
          <?php if($css_style->enabled && Engine_Api::_()->authorization()->isAllowed('eclassroom', $levelId, 'bs_edit_style')): ?>
            <li> <a  class="eclassroom_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'style'), 'eclassroom_dashboard', true); ?>"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($css_style->title); ?></span></a> </li>
          <?php endif; ?>
        </ul>
      </li>
      <?php } ?>
      
    </ul>
    <?php if(isset($this->classroom->cover_photo) && $this->classroom->cover_photo != 0 && $this->classroom->cover_photo != ''):?>
      <?php $courseCover = Engine_Api::_()->storage()->get($this->classroom->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $courseCover =''; ?>
    <?php endif;?>
    <div class="classroom_dashboard_classroom_info sesbasic_clearfix sesbm">
      <?php if(isset($this->classroom->cover_photo) && $this->classroom->cover_photo != 0 && $this->classroom->cover_photo != ''){ ?>
        <div class="courses_dashboard_course_info_cover"> 
          <img src="<?php echo $courseCover; ?>" />
          <div class="classroom_dashboard_classroom_main_photo sesbm">
            <img src="<?php echo $this->classroom->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="classroom_dashboard_classroom_photo">
          <img src="<?php echo $this->classroom->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="classroom_dashboard_course_info_content sesbasic_clearfix sesbd">
        <div class="classroom_dashboard_course_info_title">
          <a href="<?php echo $this->classroom->getHref(); ?>"><?php echo $this->classroom->getTitle(); ?></a>
        </div>
        <?php if($this->classroom->category_id):?>
          <?php $category = Engine_Api::_()->getItem('courses_category', $this->classroom->category_id);?>
          <?php if($category):?>
            <div class="classroom_dashboard_classroom_info_stat">
              <span>
                <span class="classroom_dashboard_classroom_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->classroom->is_approved){ ?>
          <div class="classroom_classroom_status sesbasic_clearfix unapproved clear floatL">
            <span class="courses_course_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      </div>
    </div>
     <?php echo $this->content()->renderWidget('eclassroom.advance-share',array('dashboard'=>true)); ?>
  </div>
<script type="application/javascript">
    function validateForm(){
		var errorPresent = false;
		if(sesJqueryObject('#eclassroom_ajax_form_submit').length>0)
			var submitFormVal= 'eclassroom_ajax_form_submit';
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
							}else{
							}
							if(error)
								errorPresent = true;
							error = false;
						}
				}
			);	
    return errorPresent ;
  }
  
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
  sesJqueryObject(document).on('click','.eclassroom_dashboard_nopropagate, .eclassroom_dashboard_nopropagate_content',function(e){
    e.preventDefault();
    //ajax request
    if(sesJqueryObject(this).hasClass('eclassroom_dashboard_nopropagate_content')){ 
      if(!sesJqueryObject(this).parent().hasClass('active'))
      getDataThroughAjax(sesJqueryObject(this).attr('href'));
      sesJqueryObject(".classroom_dashboard_tabs > ul li").each(function() {
        sesJqueryObject(this).removeClass('active');
      });
      sesJqueryObject('.classroom_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.classroom_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.classroom_dashboard_content').html(response);
           // en4.core.runonce.trigger();
          if(typeof executeAfterLoad == 'function'){
            executeAfterLoad();
          }
          if(sesJqueryObject('#loadingimgcourses-wrapper').length)
          sesJqueryObject('#loadingimgcourses-wrapper').hide();
        }
      });
      ajaxRequest.send();
    }
  sesJqueryObject(document).on('submit','#filter_form',function(event){
    event.preventDefault();
    var searchFormData = sesJqueryObject(this).serialize();
    sesJqueryObject('#loadingimge-wrapper').show();
    sesJqueryObject('#courses-search-order-img').show();
    new Request.HTML({
        method: 'post',
        url :  '<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'manage-courses'), 'eclassroom_dashboard', true); ?>',
        data : {
          format : 'html',
          classroom_id:<?php echo $this->subject()->getIdentity();?>,
          searchParams :searchFormData, 
          is_search_ajax:true,
        },
        onComplete: function(response) {
          sesJqueryObject('#loadingimge-wrapper').hide();
          sesJqueryObject('#courses-search-order-img').hide();
          sesJqueryObject('.classroom_dashboard_content').html(response);
        }
    }).send();
  });
    var submitFormAjax;
    sesJqueryObject(document).on('submit','#eclassroom_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('classroom_calendar')){
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
        sesJqueryObject('#eclassroom_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#eclassroom_ajax_form_submit');
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
                sesJqueryObject('.classroom_dashboard_content').html(data);

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
  sesJqueryObject(".classroom_dashboard_tabs > ul li a").each(function() {
    var c = sesJqueryObject(this).attr("href");
    sesJqueryObject(this).click(function() {
      if(sesJqueryObject(this).hasClass('eclassroom_dashboard_nopropagate')){
        if(sesJqueryObject(this).parent().find('ul').is(":visible")){
          sesJqueryObject(this).parent().find('ul').slideUp()
        }else{
          sesJqueryObject(".classroom_dashboard_tabs ul ul").each(function() {
            sesJqueryObject(this).slideUp();
          });
          sesJqueryObject(this).parent().find('ul').slideDown()
        }
        return false
      }	
    })
  });
</script>
