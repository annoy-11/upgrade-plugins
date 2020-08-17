<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-businessapps.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/styles/styles.css'); ?>

<script>
var isBusinessOnoffRequest;
function sesmanagebusinessapps(businessType, businessId) {
	var	url = en4.core.baseUrl+'sesbusiness/dashboard/managebusinessonoffapps/';
	var isBusinessOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: businessType,
        business_id: businessId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isBusinessOnoffRequest.send();
}
</script>

<?php $base_url = $this->layout()->staticBaseUrl; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array(
	'business' => $this->business,
      ));	
?>
<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesbusiness_dashboard_manage_apps">
<?php } ?>
  <div class="sesbusiness_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate("Personalize and Manage Your Business Apps"); ?></h3>
      <p><?php echo $this->translate("There are many apps available for your Business, that you can use to personalize, configure and manage your Business. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Sesbusiness/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="sesbusiness_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sesbusiness/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Business. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesbusiness_switch">
          <input onchange="sesmanagebusinessapps('photos', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="photos" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sesbusiness/externals/images/dashboard/service.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Services"); ?></div>
        <div><?php echo $this->translate("Add service in your Business.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesbusiness_switch">
          <input onchange="sesmanagebusinessapps('service', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="service" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->service) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessoffer')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesbusiness/externals/images/dashboard/offer.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Offers"); ?></div>
          <div><?php echo $this->translate("Offers can be very useful and helpful to advertise your Business. Since offers are easy to explain and showcase things, offers create a great impact on their viewer. Offers are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesbusiness_switch">
            <input onchange="sesmanagebusinessapps('offers', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="offers" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusiness apps->offers) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessvideo')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesbusiness/externals/images/dashboard/video.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Videos"); ?></div>
          <div><?php echo $this->translate("Videos can be very useful and helpful to advertise your Business. Since videos are easy to explain and showcase things, videos create a great impact on their viewer. Videos are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesbusiness_switch">
            <input onchange="sesmanagebusinessapps('videos', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="videos" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->videos) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
	<?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspoll') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.pluginactivated')) { ?>
    <div class="_appitem sesbasic_bg sesbasic_clearfix">
      <div class="_appitem_icon">
        <img src="application/modules/Sesbusiness/externals/images/dashboard/video.png" alt="">
      </div>
      <div class="_appitem_cont">
        <div class="_title"><?php echo $this->translate("Business Polls"); ?></div>
        <div><?php echo $this->translate("Add Polls to your Businesses and make them more featured and demanding.");
          ?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sesbusiness_switch">
          <input onchange="sesmanagebusinessapps('sesbusinesspoll', '<?php echo $this->business->business_id ?>');" data-id="<?php echo
          $this->business->business_id; ?>" data-type="sesbusinesspoll" class="sesbusinessonoffswitch" type="checkbox" <?php if
          ($this->managebusinessapps->sesbusinesspoll) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessmusic')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sesbusiness/externals/images/dashboard/music.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Music"); ?></div>
          <div><?php echo $this->translate("Music is for not only for music lovers, but you can use it to increase the popularity of your Business too. Upload songs which your audience may like to listen and enjoy.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sesbusiness_switch">
            <input onchange="sesmanagebusinessapps('music', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="music" id="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->music) { ?> checked <?php } ?>>
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
            <img src="application/modules/Sesbusiness/externals/images/dashboard/sell.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Sell Something"); ?></div>
            <div><?php echo $this->translate("If you wish to sell your products, services, art, etc from your Business, then this feature will help you boost your sales. Instantly message from comments on such posts and increase your sales.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sesbusiness_switch">
              <input onchange="sesmanagebusinessapps('buysell', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="buysell" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h"></span>
            </label>
          </div>
        </div>
      <?php } ?>
      
      <?php if(in_array('fileupload', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Sesbusiness/externals/images/dashboard/file.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Add File"); ?></div>
            <div><?php echo $this->translate("Adding files to your business will help you upload your portfolio, details, artwork, services.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sesbusiness_switch">
              <input onchange="sesmanagebusinessapps('fileupload', '<?php echo $this->business->business_id ?>');" data-id="<?php echo $this->business->business_id; ?>" data-type="fileupload" class="sesbusinessonoffswitch" type="checkbox" <?php if($this->managebusinessapps->fileupload) { ?> checked <?php } ?>>
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
