<?php

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

  function importSeRecipe() {

    $('loading_image').style.display = '';
    $('serecipe_import').style.display = 'none';
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'admin/sesrecipe/import-recipe',
      method: 'get',
      data: {
        'is_ajax': 1,
        'format': 'json',
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.error_code) {
          $('loading_image').style.display = 'none';
          $('serecipe_message').innerHTML = "<span>Some error might have occurred during the import process. Please refresh the page and click on “Start Importing Recipe” again to complete the import process.</span>";
        } else {
          $('loading_image').style.display = 'none';
          $('serecipe_message').style.display = 'none';
          $('serecipe_message1').innerHTML = "<span>" + '<?php echo $this->string()->escapeJavascript($this->translate("Recipes from SE Recipe have been successfully imported.")) ?>' + "</span>";
        }
      }
    }));
  }
</script>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate('Import SE Recipe into this Plugin');?></h3>
      <p class="description">
        <?php echo $this->translate('Here, you can import recipes from SE Recipe plugin into this plugin.'); ?>
      </p>
      <div class="clear sesrecipe_import_msg sesrecipe_import_loading" id="loading_image" style="display: none;">
        <span><?php echo $this->translate("Importing ...") ?></span>
      </div>
      <div id="serecipe_message" class="clear sesrecipe_import_msg sesrecipe_import_error"></div>
      <div id="serecipe_message1" class="clear sesrecipe_import_msg sesrecipe_import_success"></div>
      <?php if(count($this->seRecipeResults) > 0): ?>
        <div id="serecipe_import">
          <button class="sesrecipe_import_button" type="button" name="sesrecipe_import" onclick='importSeRecipe();'>
            <?php echo $this->translate('Start Importing Recipe');?>
          </button>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate('There are no recipes in SE Recipe plugin to be imported into this plugin.') ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </form>
</div>