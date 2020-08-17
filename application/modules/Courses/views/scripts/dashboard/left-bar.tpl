<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: left-bar.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  $levelId = Engine_Api::_()->getItem('user',$this->course->owner_id)->level_id; ?>
<?php $addThisCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.addthis',0); ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addThisCode; ?>" async></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $privacy = $this->course->authorization();?>
<?php $viewer = $this->viewer();?>
<div class="layout_middle courses_dashboard_main_nav">
 <?php echo $this->content()->renderWidget('eclassroom.browse-menu',array('dashboard'=>true)); ?> 
</div>
<div class="layout_middle courses_dashboard_container">
<div class="courses_dashboard_wrapper sesbasic_clearfix">
  <div class="courses_dashboard_top_section sesbasic_clearfix sesbm">
    <div class="courses_dashboard_top_section_left">
      <div class="courses_dashboard_top_section_item_photo"><?php echo $this->htmlLink($this->course->getHref(), $this->itemPhoto($this->course, 'thumb.icon')) ?></div>
      <div class="courses_dashboard_top_section_item_title"><?php echo $this->htmlLink($this->course->getHref(),$this->course->getTitle()); ?></div>
    </div>
      <div class="courses_dashboard_top_section_btns">
      <a href="<?php echo $this->course->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Course"); ?></a>
        <a href="<?php echo $this->url(array('course_id' => $this->course->course_id,'action'=>'delete'), 'courses_specific', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Course"); ?></a>
    </div>
  </div>
  <div class="courses_dashboard_tabs sesbasic_bxs">
    <ul class="sesbm">
      <li class="sesbm">
        <?php $manage_course = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_course')); ?>
        <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_course->title); ?></span> </a>
        <?php $edit_course = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'edit_course')); ?>
        <?php $edit_location = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'edit_location')); ?>
        <?php $terms_conditions = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'terms_conditions')); ?>
        <?php $contact_information = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'contact_info')); ?>
        <?php $openHour = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'operating_hours')); ?>
        <?php $postAttribution = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'post_attri')); ?>
        <?php $manageNotifications = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_notification')); ?>
        <?php $profieFields = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'cat_profile_info')); ?>
        <ul class="sesbm">	
          <?php if($edit_course->enabled): ?>
            <li><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-edit"></i><span><?php echo $this->translate($edit_course->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($edit_location->enabled): ?>
            <li><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-location'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker"></i><span><?php echo $this->translate($edit_location->title); ?></span></a></li>
          <?php endif; ?>
          <?php if($terms_conditions->enabled && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.termncondition', 1)): ?>
            <li><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'policy'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-file-text"></i><span><?php echo $this->translate($terms_conditions->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$contact_information->enabled): ?>
            <li><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'contact-information'), 'courses_dashboard', true); ?>" class="courses_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i><span><?php echo $this->translate($contact_information->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$manageNotifications->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url, 'action'=>'manage-notification'), 'courses_dashboard', true); ?>"><i class="fa fa-bell"></i><span><?php echo $this->translate($manageNotifications->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$postAttribution->enabled && Engine_Api::_()->authorization()->isAllowed('courses', $levelId, 'seb_attribution') && Engine_Api::_()->authorization()->isAllowed('courses', $levelId, 'auth_defattribut') == 1): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url, 'action'=>'post-attribution'), 'courses_dashboard', true); ?>"><i class="fa fa-file-o"></i><span><?php echo $this->translate($postAttribution->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$openHour->enabled && Engine_Api::_()->authorization()->isAllowed('courses', $levelId, 'auth_close')): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url, 'action'=>'open-hours'), 'courses_dashboard', true); ?>"><i class="fa fa-clock-o"></i><span><?php echo $this->translate($openHour->title); ?></span></a></li>
          <?php endif; ?>
          <?php if(@$profieFields->enabled): ?>
            <?php $countFields = Engine_Api::_()->courses()->getFieldsCount($this->course);?>
            <?php if($countFields):?>
              <li><a class="dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url, 'action'=>'profile-field'), 'courses_dashboard', true); ?>"><i class="fa fa-file-text-o "></i><span><?php echo $this->translate($profieFields->title); ?></span></a></li>
            <?php endif;?>
          <?php endif; ?>
        </ul>
      </li> 
    <li class="sesbm">
      <?php $manage_courses_orders = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_courses_orders')); ?>
      <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_courses_orders->title); ?></span> </a>
      <?php $manage_courses = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_course')); ?>
      <ul class="sesbm">	         
        <?php $manage_orders = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_orders')); ?>
        <?php if($manage_orders->enabled): ?>
        <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-orders'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-cogs"></i><span><?php echo $this->translate($manage_orders->title); ?></span></a></li>
        <?php endif; ?>
      </ul>
    </li>
      <li class="sesbm">
        <?php $manage_payments = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_payments')); ?>
        <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_payments->title); ?></span> </a>
        <ul class="sesbm">
          <?php $payment_taxes = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'payment_taxes')); ?>
          <?php if($payment_taxes->enabled): ?>
            <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'taxes'), 'courses_dashboard', true); ?>" class="courses_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-money"></i><span><?php echo $this->translate($payment_taxes->title); ?></span></a></li>
          <?php endif; ?>
          <?php $account_details = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'account_details')); ?>
          <?php if($account_details->enabled): ?>
            <li> <a  class="courses_dashboard_nopropagate_content dashboard_a_link" id="dashboard_account_details" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'account-details'), 'courses_dashboard', true); ?>"><i class="fa fa-flag"></i><span><?php echo $this->translate($account_details->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $payment_requested = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'payment_requested')); ?>
          <?php if($payment_requested->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'payment-requests'), 'courses_dashboard', true); ?>" class="courses_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-share"></i><span><?php echo $this->translate($payment_requested->title); ?></span></a></li>
          <?php endif; ?>
          <?php $payment_received = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'payment_received')); ?>
          <?php if($payment_received->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'payment-transaction'), 'courses_dashboard', true); ?>" class="courses_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-reply"></i><span><?php echo $this->translate($payment_received->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li>
      <li class="sesbm">
        <?php $manage_lectures_test = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_lectures_test')); ?>
        <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course"></i> <i class="tab-arrow fa fa-caret-down"></i> <span><?php echo $this->translate($manage_lectures_test->title); ?></span> </a>
        <ul class="sesbm">	
          <?php $manage_lecture = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_lecture')); ?>
          <?php if($manage_lecture->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-lectures'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-bell"></i><span><?php echo $this->translate($manage_lecture->title); ?></span></a></li>
          <?php endif; ?>
          <?php $manage_test = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'manage_test')); ?>
          <?php if($manage_test->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-tests'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-list"></i><span><?php echo $this->translate($manage_test->title); ?></span></a></li>
          <?php endif; ?>
        </ul>
      </li> 
       <li class="sesbm">  
        <?php $edit_style = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'edit_style')); ?>
        <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($edit_style->title); ?></span> </a>
        <ul class="sesbm">
          <?php $main_photo = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'main_photo')); ?>
          <?php if($main_photo->enabled && Engine_Api::_()->authorization()->isAllowed('courses', $levelId, 'upload_mainphoto')): ?>
            <li> <a  class="dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'mainphoto'), 'courses_dashboard', true); ?>"><i class="fa fa-camera"></i><span><?php echo $this->translate($main_photo->title); ?></span></a> </li>
          <?php endif; ?>
           <?php $css_style = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'css_style')); ?>
          <?php if($css_style->enabled && Engine_Api::_()->authorization()->isAllowed('courses', $levelId, 'bs_css_style')): ?>
            <li> <a  class="courses_dashboard_nopropagate_content dashboard_a_link" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'style'), 'courses_dashboard', true); ?>"><i class="fa fa-paint-brush"></i><span><?php echo $this->translate($css_style->title); ?></span></a> </li>
          <?php endif; ?>
        </ul>	
      </li>
      <li class="sesbm">  
        <?php $insights_reports = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'insights_reports')); ?>
        <a href="#Manage" class="courses_dashboard_nopropagate"> <i class="tab-icon db_icon_course_style"></i> <i class="tab-arrow fa fa-caret-down"></i><span><?php echo $this->translate($insights_reports->title); ?></span> </a>
        <ul class="sesbm">
          <?php $sales_stats = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'sales_stats')); ?>
          <?php if($sales_stats->enabled): ?>
            <li> <a  class="dashboard_a_link" id="dashboard_account_details" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'sales-stats'), 'courses_dashboard', true); ?>"><i class="fa fa-bar-chart"></i><span><?php echo $this->translate($sales_stats->title); ?></span></a> </li>
          <?php endif; ?>
          <?php $sales_reports = Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('type' => 'sales_reports')); ?>
          <?php if($sales_reports->enabled): ?>
          <li><a id="courses_search_member_search" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'sales-reports'), 'courses_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-share"></i><span><?php echo $this->translate($sales_reports->title); ?></span></a></li>
          <?php endif; ?>
        </ul>	
      </li>
    </ul>
    <?php if(isset($this->course->cover_photo) && $this->course->cover_photo != 0 && $this->course->cover_photo != ''):?>
      <?php $courseCover = Engine_Api::_()->storage()->get($this->course->cover_photo, '')->getPhotoUrl(); ?>
    <?php else:?>
      <?php $courseCover =''; ?>
    <?php endif;?>
    <div class="courses_dashboard_course_info sesbasic_clearfix sesbm">
      <?php if(isset($this->course->cover_photo) && $this->course->cover_photo != 0 && $this->course->cover_photo != ''){ ?>
        <div class="courses_dashboard_course_info_cover"> 
          <img src="<?php echo $courseCover; ?>" />
          <div class="courses_dashboard_course_main_photo sesbm">
            <img src="<?php echo $this->course->getPhotoUrl(); ?>" /> 
          </div>
        </div>
      <?php } else { ?>
        <div class="courses_dashboard_course_photo">
          <img src="<?php echo $this->course->getPhotoUrl(); ?>" />
        </div>
      <?php }; ?>
      <div class="courses_dashboard_course_info_content sesbasic_clearfix sesbd">
        <div class="courses_dashboard_course_info_title">
          <a href="<?php echo $this->course->getHref(); ?>"><?php echo $this->course->getTitle(); ?></a>
        </div>
        <?php if($this->course->category_id):?>
          <?php $category = Engine_Api::_()->getItem('courses_category', $this->course->category_id);?>
          <?php if($category):?>
            <div class="courses_dashboard_course_info_stat">
              <span>
                <span class="courses_dashboard_course_info_stat_label"><?php echo $this->translate('Category');?></span> 
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
              </span> 
            </div>
          <?php endif;?>
        <?php endif;?>
        <?php if(!$this->course->is_approved){ ?>
          <div class="courses_course_status sesbasic_clearfix unapproved clear floatL">
            <span class="courses_course_status_txt"><?php echo $this->translate('UNAPPROVED');?></b></span>
          </div>
        <?php } ?>
      </div>
    </div>
      <?php echo $this->content()->renderWidget('courses.advance-share',array('dashboard'=>true)); ?>
  </div>
<script type="application/javascript">
  function validateForm(){
		var errorPresent = false;
		if(sesJqueryObject('#courses_ajax_form_submit').length>0)
			var submitFormVal= 'courses_ajax_form_submit';
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
    sesJqueryObject(document).on('click','.courses_dashboard_nopropagate, .courses_dashboard_nopropagate_content',function(e){
      e.preventDefault();
      //ajax request
      if(sesJqueryObject(this).hasClass('courses_dashboard_nopropagate_content')){ 
        if(!sesJqueryObject(this).parent().hasClass('active'))
        getDataThroughAjax(sesJqueryObject(this).attr('href'));
        sesJqueryObject(".courses_dashboard_tabs > ul li").each(function() {
          sesJqueryObject(this).removeClass('active');
        });
        sesJqueryObject('.courses_dashboard_tabs > ul > li ul > li').each(function() {
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
      sesJqueryObject('.courses_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
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
          sesJqueryObject('.courses_dashboard_content').html(response);
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
    
    var submitFormAjax;
    sesJqueryObject(document).on('submit','#courses_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    if(validation){
      if(!customAlert){
        if(sesJqueryObject(objectError).hasClass('courses_calendar')){
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
        sesJqueryObject('#courses_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content" style="display:block;"></div>');
      else
        sesJqueryObject('#sesdashboard_overlay_content').show();
        //submit form 
        var form = sesJqueryObject('#courses_ajax_form_submit');
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
                sesJqueryObject('.courses_dashboard_content').html(data);

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
  sesJqueryObject(".courses_dashboard_tabs > ul li a").each(function() {
    var c = sesJqueryObject(this).attr("href");
    sesJqueryObject(this).click(function() {
      if(sesJqueryObject(this).hasClass('courses_dashboard_nopropagate')){
        if(sesJqueryObject(this).parent().find('ul').is(":visible")){
          sesJqueryObject(this).parent().find('ul').slideUp()
        }else{
          sesJqueryObject(".courses_dashboard_tabs ul ul").each(function() {
            sesJqueryObject(this).slideUp();
          });
          sesJqueryObject(this).parent().find('ul').slideDown()
        }
        return false
      }	
    })
  });
   var ajaxDeleteRequest;
    sesJqueryObject(document).on('click','.courses_ajax_delete',function(e){
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
    sesJqueryObject(document).on('click','.courses_tax_enadisable',function (e) {
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
</script>
