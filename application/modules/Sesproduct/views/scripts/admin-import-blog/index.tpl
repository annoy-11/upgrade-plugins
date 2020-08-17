<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

  function importSeProduct() {

    $('loading_image').style.display = '';
    $('seproduct_import').style.display = 'none';
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'admin/sesproduct/import-product',
      method: 'get',
      data: {
        'is_ajax': 1,
        'format': 'json',
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.error_code) {
          $('loading_image').style.display = 'none';
          $('seproduct_message').innerHTML = "<span>Some error might have occurred during the import process. Please refresh the page and click on “Start Importing Product” again to complete the import process.</span>";
        } else {
          $('loading_image').style.display = 'none';
          $('seproduct_message').style.display = 'none';
          $('seproduct_message1').innerHTML = "<span>" + '<?php echo $this->string()->escapeJavascript($this->translate("Products from SE Product have been successfully imported.")) ?>' + "</span>";
        }
      }
    }));
  }
</script>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate('Import SE Product into this Plugin');?></h3>
      <p class="description">
        <?php echo $this->translate('Here, you can import products from SE Product plugin into this plugin.'); ?>
      </p>
      <div class="clear sesproduct_import_msg sesproduct_import_loading" id="loading_image" style="display: none;">
        <span><?php echo $this->translate("Importing ...") ?></span>
      </div>
      <div id="seproduct_message" class="clear sesproduct_import_msg sesproduct_import_error"></div>
      <div id="seproduct_message1" class="clear sesproduct_import_msg sesproduct_import_success"></div>
      <?php if(count($this->seProductResults) > 0): ?>
        <div id="seproduct_import">
          <button class="sesproduct_import_button" type="button" name="sesproduct_import" onclick='importSeProduct();'>
            <?php echo $this->translate('Start Importing Product');?>
          </button>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate('There are no products in SE Product plugin to be imported into this plugin.') ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </form>
</div>
