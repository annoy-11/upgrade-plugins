<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-groupapps.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/styles/styles.css'); ?>

<script>
var isGroupOnoffRequest;
function sesmanagegroupapps(groupType, groupId) {
	var	url = en4.core.baseUrl+'sesgroup/dashboard/managegrouponoffapps/';
	var isGroupOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: groupType,
        group_id: groupId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isGroupOnoffRequest.send();
}
</script>

<?php $base_url = $this->layout()->staticBaseUrl; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesgroup_dashboard_manage_apps">
<?php } ?>
  <div class="sesgroup_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate("Personalize and Manage Your Group Apps"); ?></h3>
      <p><?php echo $this->translate("There are many apps available for your Group, that you can use to personalize, configure and manage your Group. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Sesgroup/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="sesgroup_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sesgroup/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Group. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesgroup_switch">
          <input onchange="sesmanagegroupapps('photos', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="photos" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sesgroup/externals/images/dashboard/service.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Services"); ?></div>
        <div><?php echo $this->translate("Add service in your Group.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesgroup_switch">
          <input onchange="sesmanagegroupapps('service', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="service" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->service) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupvideo')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesgroup/externals/images/dashboard/video.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Videos"); ?></div>
          <div><?php echo $this->translate("Videos can be very useful and helpful to advertise your Group. Since videos are easy to explain and showcase things, videos create a great impact on their viewer. Videos are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesgroup_switch">
            <input onchange="sesmanagegroupapps('videos', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="videos" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->videos) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupforum')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesgroup/externals/images/dashboard/forum.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Topics"); ?></div>
          <div><?php echo $this->translate("Topics can be very useful and helpful to advertise your Group.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesgroup_switch">
            <input onchange="sesmanagegroupapps('forums', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="forums" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->forums) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
<?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgrouppoll') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.pluginactivated')) { ?>
    <div class="_appitem sesbasic_bg sesbasic_clearfix">
      <div class="_appitem_icon">
        <img src="application/modules/Sesgroup/externals/images/dashboard/video.png" alt="">
      </div>
      <div class="_appitem_cont">
        <div class="_title"><?php echo $this->translate("Group Polls"); ?></div>
        <div><?php echo $this->translate("Add Polls to your groups and make them more featured and demanding.");
          ?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesgroup_switch">
          <input onchange="sesmanagegroupapps('sesgrouppoll', '<?php echo $this->group->group_id ?>');" data-id="<?php echo
          $this->group->group_id; ?>" data-type="sesgrouppoll" class="sesgrouponoffswitch" type="checkbox" <?php if
          ($this->managegroupapps->sesgrouppoll) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesgroupmusic')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesgroup/externals/images/dashboard/music.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Music"); ?></div>
          <div><?php echo $this->translate("Music is for not only for music lovers, but you can use it to increase the popularity of your Group too. Upload songs which your audience may like to listen and enjoy.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesgroup_switch">
            <input onchange="sesmanagegroupapps('music', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="music" id="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->music) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { ?>
      <?php $composeroptions = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.composeroptions', 1);  ?>
      <?php if(in_array('buysell', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Sesgroup/externals/images/dashboard/sell.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Sell Something"); ?></div>
            <div><?php echo $this->translate("If you wish to sell your products, services, art, etc from your Group, then this feature will help you boost your sales. Instantly message from comments on such posts and increase your sales.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sesgroup_switch">
              <input onchange="sesmanagegroupapps('buysell', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="buysell" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h"></span>
            </label>
          </div>
        </div>
      <?php } ?>
      
      <?php if(in_array('fileupload', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Sesgroup/externals/images/dashboard/file.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Add File"); ?></div>
            <div><?php echo $this->translate("Adding files to your group will help you upload your portfolio, details, artwork, services.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sesgroup_switch">
              <input onchange="sesmanagegroupapps('fileupload', '<?php echo $this->group->group_id ?>');" data-id="<?php echo $this->group->group_id; ?>" data-type="fileupload" class="sesgrouponoffswitch" type="checkbox" <?php if($this->managegroupapps->fileupload) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h"></span>
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
