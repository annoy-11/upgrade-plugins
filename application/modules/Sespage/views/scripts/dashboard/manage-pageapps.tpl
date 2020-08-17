<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-pageapps.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/scripts/core.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/styles/styles.css'); ?>

<script>
var isPageOnoffRequest;
function sesmanagepageapps(pageType, pageId) {
	var	url = en4.core.baseUrl+'sespage/dashboard/managepageonoffapps/';
	var isPageOnoffRequest =	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        type: pageType,
        page_id: pageId,
        format: 'html',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
				location.reload();
      }
    }));
		isPageOnoffRequest.send();
}
</script>

<?php $base_url = $this->layout()->staticBaseUrl; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageteam/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
<div class="sespage_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sespage_dashboard_manage_apps">
<?php } ?>
  <div class="sespage_dashboard_content_top sesbasic_clearfix">
  	<div class="_left">
      <h3><?php echo $this->translate("Personalize and Manage Your Page Apps"); ?></h3>
      <p><?php echo $this->translate("There are many apps available for your Page, that you can use to personalize, configure and manage your Page. You can simply choose to enable or disable them from here as per your requirement of functionality."); ?></p>
		</div>
    <div class="_img centerT">
    	<img src="application/modules/Sespage/externals/images/dashboard/apps.png" alt="" />
  	</div>
  </div>
  <div class="sespage_dashboard_manage_apps_section">
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sespage/externals/images/dashboard/album.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Photos & Albums"); ?></div>
        <div><?php echo $this->translate("Add Photos and create Albums in your Page. Make it more attractive, informative and easy to connect with your audience.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sespage_switch">
          <input onchange="sesmanagepageapps('photos', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="photos" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->photos) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    
 		<div class="_appitem sesbasic_bg sesbasic_clearfix">
    	<div class="_appitem_icon">
      	<img src="application/modules/Sespage/externals/images/dashboard/service.png" alt="">
      </div>
      <div class="_appitem_cont">
      	<div class="_title"><?php echo $this->translate("Services"); ?></div>
        <div><?php echo $this->translate("Add service in your Page.");?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sespage_switch">
          <input onchange="sesmanagepageapps('service', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="service" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->service) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagenote')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sespage/externals/images/dashboard/note.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Notes"); ?></div>
          <div><?php echo $this->translate("Notes can be very useful and helpful to advertise your Page. Since notes are easy to explain and showcase things, notes create a great impact on their viewer. Notes are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sespage_switch">
            <input onchange="sesmanagepageapps('notes', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="notes" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->notes) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespageoffer')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sespage/externals/images/dashboard/offer.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Offers"); ?></div>
          <div><?php echo $this->translate("Offers can be very useful and helpful to advertise your Page. Since offers are easy to explain and showcase things, offers create a great impact on their viewer. Offers are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sespage_switch">
            <input onchange="sesmanagepageapps('offers', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="offers" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->offers) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagevideo')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sespage/externals/images/dashboard/video.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Videos"); ?></div>
          <div><?php echo $this->translate("Videos can be very useful and helpful to advertise your Page. Since videos are easy to explain and showcase things, videos create a great impact on their viewer. Videos are also easy to remember and understand things.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sespage_switch">
            <input onchange="sesmanagepageapps('videos', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="videos" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->videos) { ?> checked <?php } ?>>
            <span class="_appitem_btn_switch_h"></span>
          </label>
        </div>
      </div>
    <?php } ?>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagepoll') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.pluginactivated')) { ?>
    <div class="_appitem sesbasic_bg sesbasic_clearfix">
      <div class="_appitem_icon">
        <img src="application/modules/Sespage/externals/images/dashboard/video.png" alt="">
      </div>
      <div class="_appitem_cont">
        <div class="_title"><?php echo $this->translate("Page Polls"); ?></div>
        <div><?php echo $this->translate("Add Polls to your pages and make them more featured and demanding.");
          ?></div>
      </div>
      <div class="_appitem_btn">
        <label class="sespage_switch">
          <input onchange="sesmanagepageapps('sespagepoll', '<?php echo $this->page->page_id ?>');" data-id="<?php echo
          $this->page->page_id; ?>" data-type="sespagepoll" class="sespageonoffswitch" type="checkbox" <?php if
          ($this->managepageapps->sespagepoll) { ?> checked <?php } ?>>
          <span class="_appitem_btn_switch_h"></span>
        </label>
      </div>
    </div>
    <?php } ?>
    
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagemusic')) { ?>
      <div class="_appitem sesbasic_bg sesbasic_clearfix">
        <div class="_appitem_icon">
          <img src="application/modules/Sespage/externals/images/dashboard/music.png" alt="">
        </div>
        <div class="_appitem_cont">
          <div class="_title"><?php echo $this->translate("Music"); ?></div>
          <div><?php echo $this->translate("Music is for not only for music lovers, but you can use it to increase the popularity of your Page too. Upload songs which your audience may like to listen and enjoy.");?></div>
        </div>
        <div class="_appitem_btn">
          <label class="sespage_switch">
            <input onchange="sesmanagepageapps('music', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="music" id="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->music) { ?> checked <?php } ?>>
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
            <img src="application/modules/Sespage/externals/images/dashboard/sell.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Sell Something"); ?></div>
            <div><?php echo $this->translate("If you wish to sell your products, services, art, etc from your Page, then this feature will help you boost your sales. Instantly message from comments on such posts and increase your sales.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sespage_switch">
              <input onchange="sesmanagepageapps('buysell', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="buysell" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->buysell) { ?> checked <?php } ?>>
              <span class="_appitem_btn_switch_h"></span>
            </label>
          </div>
        </div>
      <?php } ?>
      
      <?php if(in_array('fileupload', $composeroptions)) { ?>
        <div class="_appitem sesbasic_bg sesbasic_clearfix">
          <div class="_appitem_icon">
            <img src="application/modules/Sespage/externals/images/dashboard/file.png" alt="">
          </div>
          <div class="_appitem_cont">
            <div class="_title"><?php echo $this->translate("Add File"); ?></div>
            <div><?php echo $this->translate("Adding files to your page will help you upload your portfolio, details, artwork, services.");?></div>
          </div>
          <div class="_appitem_btn">
            <label class="sespage_switch">
              <input onchange="sesmanagepageapps('fileupload', '<?php echo $this->page->page_id ?>');" data-id="<?php echo $this->page->page_id; ?>" data-type="fileupload" class="sespageonoffswitch" type="checkbox" <?php if($this->managepageapps->fileupload) { ?> checked <?php } ?>>
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
