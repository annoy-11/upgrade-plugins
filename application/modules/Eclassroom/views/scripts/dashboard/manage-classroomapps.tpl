<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
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
var isClassroomOnoffRequest;
function sesmanageclassroomapps(classroomType, classroomId) {
	var	url = en4.core.baseUrl+'classroom/dashboard/manageclassroomonoffapps/';
	var isClassroomOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: classroomType,
        classroom_id: classroomId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isClassroomOnoffRequest.send();
}
</script>
<?php $base_url = $this->layout()->staticBaseUrl; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
<div class="classroom_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs classroom_dashboard_manage_apps">
<?php } ?>
  <div class="classroom_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate("Personalize and Manage Your Classroom Apps"); ?></h3>
      <p><?php echo $this->translate("There are many apps available for your Classroom, that you can use to personalize, configure and manage your Classroom. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Courses/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="classroom_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Courses/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Classroom. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="classroom_switch">
          <input onchange="sesmanageclassroomapps('photos', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="photos" class="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->photos) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
        </label>
      </div>
    </div>
    
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Courses/externals/images/dashboard/service.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Services"); ?></div>
        <div><?php echo $this->translate("Add service in your Classroom.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="classroom_switch">
          <input onchange="sesmanageclassroomapps('service', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="service" class="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->service) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->service) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
        </label>
      </div>
    </div>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('eclassroomvideo')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Courses/externals/images/dashboard/video.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Videos"); ?></div>
          <div><?php echo $this->translate("Videos can be very useful and helpful to advertise your Classroom. Since videos are easy to explain and showcase things, videos create a great impact on their viewer. Videos are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="classroom_switch">
            <input onchange="sesmanageclassroomapps('videos', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="videos" class="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->videos) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->videos) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
          </label>
        </div>
      </div>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('eclassroommusic')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Courses/externals/images/dashboard/music.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Music"); ?></div>
          <div><?php echo $this->translate("Music is for not only for music lovers, but you can use it to increase the popularity of your Classroom too. Upload songs which your audience may like to listen and enjoy.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="classroom_switch">
            <input onchange="sesmanageclassroomapps('music', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="music" id="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->music) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->music) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
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
            <label class="classroom_switch">
              <input onchange="sesmanageclassroomapps('buysell', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="buysell" class="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->buysell) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
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
            <label class="classroom_switch">
              <input onchange="sesmanageclassroomapps('fileupload', '<?php echo $this->classroom->classroom_id ?>');" data-id="<?php echo $this->classroom->classroom_id; ?>" data-type="fileupload" class="classroomonoffswitch" type="checkbox" <?php if($this->manageclassroomapps->fileupload) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->manageclassroomapps->fileupload) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
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
