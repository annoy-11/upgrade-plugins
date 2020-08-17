<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-classroomapps.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/core.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<script>
var isCourseOnoffRequest;
function sesmanagecourseapps(classroomType, courseId) {
	var	url = en4.core.baseUrl+'courses/dashboard/managecourseonoffapps/';
	var isCourseOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: classroomType,
        course_id: courseId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isCourseOnoffRequest.send();
}
</script>
<?php $base_url = $this->layout()->staticBaseUrl; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
	'course' => $this->course,
      ));	
?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs courses_dashboard_manage_apps">
<?php } ?>
  <div class="courses_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate(" Personalize and Manage your Course Photo Albums"); ?></h3>
      <p><?php echo $this->translate("You can  personalize, configure and manage your Course Album Photos. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Courses/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="courses_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Courses/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Course. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="courses_switch">
          <input onchange="sesmanagecourseapps('photos', '<?php echo $this->course->course_id ?>');" data-id="<?php echo $this->course->course_id; ?>" data-type="photos" class="courseonoffswitch" type="checkbox" <?php if($this->managecourseapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h" title='<?php if($this->managecourseapps->photos) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
        </label>
      </div>
    </div>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { ?>
      <?php $composeroptions = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.composeroptions', 1);  ?>
      <?php if(in_array('buysell', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Courses/externals/images/dashboard/sell.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Sell Something"); ?></div>
            <div><?php echo $this->translate("If you wish to sell your products, services, art, etc from your Classroom, then this feature will help you boost your sales. Instantly message from comments on such posts and increase your sales.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="courses_switch">
              <input onchange="sesmanagecourseapps('buysell', '<?php echo $this->course->course_id ?>');" data-id="<?php echo $this->course->course_id; ?>" data-type="buysell" class="courseonoffswitch" type="checkbox" <?php if($this->managecourseapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->managecourseapps->buysell) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
            </label>
          </div>
        </div>
      <?php } ?>
      <?php if(in_array('fileupload', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Courses/externals/images/dashboard/file.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Add File"); ?></div>
            <div><?php echo $this->translate("Adding files to your classroom will help you upload your portfolio, details, artwork, services.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="courses_switch">
              <input onchange="sesmanagecourseapps('fileupload', '<?php echo $this->course->course_id ?>');" data-id="<?php echo $this->course->course_id; ?>" data-type="fileupload" class="courseonoffswitch" type="checkbox" <?php if($this->managecourseapps->fileupload) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->managecourseapps->fileupload) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
            </label>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
  <?php if(!$this->is_ajax){ ?>
	</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
