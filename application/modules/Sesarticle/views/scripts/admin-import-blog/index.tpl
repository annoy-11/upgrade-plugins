<?php

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

  function importSeArticle() {

    $('loading_image').style.display = '';
    $('searticle_import').style.display = 'none';
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'admin/sesarticle/import-article',
      method: 'get',
      data: {
        'is_ajax': 1,
        'format': 'json',
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.error_code) {
          $('loading_image').style.display = 'none';
          $('searticle_message').innerHTML = "<span>Some error might have occurred during the import process. Please refresh the page and click on “Start Importing Article” again to complete the import process.</span>";
        } else {
          $('loading_image').style.display = 'none';
          $('searticle_message').style.display = 'none';
          $('searticle_message1').innerHTML = "<span>" + '<?php echo $this->string()->escapeJavascript($this->translate("Articles from SE Article have been successfully imported.")) ?>' + "</span>";
        }
      }
    }));
  }
</script>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate('Import SE Article into this Plugin');?></h3>
      <p class="description">
        <?php echo $this->translate('Here, you can import articles from SE Article plugin into this plugin.'); ?>
      </p>
      <div class="clear sesarticle_import_msg sesarticle_import_loading" id="loading_image" style="display: none;">
        <span><?php echo $this->translate("Importing ...") ?></span>
      </div>
      <div id="searticle_message" class="clear sesarticle_import_msg sesarticle_import_error"></div>
      <div id="searticle_message1" class="clear sesarticle_import_msg sesarticle_import_success"></div>
      <?php if(count($this->seArticleResults) > 0): ?>
        <div id="searticle_import">
          <button class="sesarticle_import_button" type="button" name="sesarticle_import" onclick='importSeArticle();'>
            <?php echo $this->translate('Start Importing Article');?>
          </button>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate('There are no articles in SE Article plugin to be imported into this plugin.') ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </form>
</div>