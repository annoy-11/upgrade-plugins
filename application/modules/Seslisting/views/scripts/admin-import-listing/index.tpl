<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

  function importSeListing() {

    $('loading_image').style.display = '';
    $('selisting_import').style.display = 'none';
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'admin/seslisting/import-listing',
      method: 'get',
      data: {
        'is_ajax': 1,
        'format': 'json',
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.error_code) {
          $('loading_image').style.display = 'none';
          $('selisting_message').innerHTML = "<span>Some error might have occurred during the import process. Please refresh the page and click on “Start Importing Listing” again to complete the import process.</span>";
        } else {
          $('loading_image').style.display = 'none';
          $('selisting_message').style.display = 'none';
          $('selisting_message1').innerHTML = "<span>" + '<?php echo $this->string()->escapeJavascript($this->translate("Listings from SE Listing have been successfully imported.")) ?>' + "</span>";
        }
      }
    }));
  }
</script>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate('Import SE Listing into this Plugin');?></h3>
      <p class="description">
        <?php echo $this->translate('Here, you can import listings from SE Listing plugin into this plugin.'); ?>
      </p>
      <div class="clear seslisting_import_msg seslisting_import_loading" id="loading_image" style="display: none;">
        <span><?php echo $this->translate("Importing ...") ?></span>
      </div>
      <div id="selisting_message" class="clear seslisting_import_msg seslisting_import_error"></div>
      <div id="selisting_message1" class="clear seslisting_import_msg seslisting_import_success"></div>
      <?php if(count($this->seListingResults) > 0): ?>
        <div id="selisting_import">
          <button class="seslisting_import_button" type="button" name="seslisting_import" onclick='importSeListing();'>
            <?php echo $this->translate('Start Importing Listing');?>
          </button>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate('There are no listings in SE Listing plugin to be imported into this plugin.') ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </form>
</div>
