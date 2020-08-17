<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-storeapps.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/styles/styles.css'); ?>

<script>
var isStoreOnoffRequest;
function sesmanagestoreapps(storeType, storeId) {
	var	url = en4.core.baseUrl+'estore/dashboard/managestoreonoffapps/';
	var isStoreOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: storeType,
        store_id: storeId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isStoreOnoffRequest.send();
}
</script>

<?php $base_url = $this->layout()->staticBaseUrl; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estoreteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs estore_dashboard_manage_apps">
<?php } ?>
  <div class="estore_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate("Personalize and Manage Your Store Apps"); ?></h3>
      <p><?php echo $this->translate("There are many apps available for your Store, that you can use to personalize, configure and manage your Store. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Estore/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="estore_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Estore/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Store. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="estore_switch">
          <input onchange="sesmanagestoreapps('photos', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="photos" class="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->photos) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
        </label>
      </div>
    </div>
    
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Estore/externals/images/dashboard/service.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Services"); ?></div>
        <div><?php echo $this->translate("Add service in your Store.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="estore_switch">
          <input onchange="sesmanagestoreapps('service', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="service" class="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->service) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->service) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
        </label>
      </div>
    </div>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estorevideo')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Estore/externals/images/dashboard/video.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Videos"); ?></div>
          <div><?php echo $this->translate("Videos can be very useful and helpful to advertise your Store. Since videos are easy to explain and showcase things, videos create a great impact on their viewer. Videos are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="estore_switch">
            <input onchange="sesmanagestoreapps('videos', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="videos" class="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->videos) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->videos) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estoremusic')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Estore/externals/images/dashboard/music.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Music"); ?></div>
          <div><?php echo $this->translate("Music is for not only for music lovers, but you can use it to increase the popularity of your Store too. Upload songs which your audience may like to listen and enjoy.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="estore_switch">
            <input onchange="sesmanagestoreapps('music', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="music" id="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->music) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->music) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { ?>
      <?php $composeroptions = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.composeroptions', 1);  ?>
      <?php if(in_array('buysell', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Estore/externals/images/dashboard/sell.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Sell Something"); ?></div>
            <div><?php echo $this->translate("If you wish to sell your products, services, art, etc from your Store, then this feature will help you boost your sales. Instantly message from comments on such posts and increase your sales.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="estore_switch">
              <input onchange="sesmanagestoreapps('buysell', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="buysell" class="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->buysell) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
            </label>
          </div>
        </div>
      <?php } ?>
      
      <?php if(in_array('fileupload', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Estore/externals/images/dashboard/file.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Add File"); ?></div>
            <div><?php echo $this->translate("Adding files to your store will help you upload your portfolio, details, artwork, services.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="estore_switch">
              <input onchange="sesmanagestoreapps('fileupload', '<?php echo $this->store->store_id ?>');" data-id="<?php echo $this->store->store_id; ?>" data-type="fileupload" class="estoreonoffswitch" type="checkbox" <?php if($this->managestoreapps->fileupload) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h" title='<?php if($this->managestoreapps->fileupload) { ?> <?php echo $this->translate("Disable"); ?> <?php } else { ?> <?php echo $this->translate("Enable"); ?><?php } ?>'></span>
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
