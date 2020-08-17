<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: roboto.tpl  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesseo/views/scripts/dismiss_message.tpl';?>
<?php $basePath = APPLICATION_PATH . '/robots.txt'; ?>
<script type="text/javascript">
  var modifications = [];
  window.onbeforeunload = function() {
    if( modifications.length > 0 ) {
      return '<?php echo $this->translate("If you leave the page now, your changes will be lost. Are you sure you want to continue?") ?>';
    }
  }
  var pushModification = function(type) {
    modifications.push(type);
  }
  var removeModification = function(type) {
    modifications.erase(type);
  }
  var saveFileChanges = function() {
    var request = new Request.JSON({
      url : '<?php echo $this->url(array('action' => 'save')) ?>',
      data : {
        'body' : $('body').value,
        'basePath' : $('basePath').value,
        'format' : 'json'
      },
      onComplete : function(responseJSON) {
        if( responseJSON.status ) {
          removeModification('body');
          alert('<?php echo $this->string()->escapeJavascript($this->translate("Your changes have been saved!")) ?>');
        } else {
          alert('<?php echo $this->string()->escapeJavascript($this->translate("An error has occurred. Changes could NOT be saved.")) ?>');
        }
      }
    });
    request.send();
  }
</script>
<h3><?php echo $this->translate("Edit Robots txt file"); ?></h3>
<p>The robots.txt file is a text file that tells web robots (most often search engines) which pages on your site to crawl or not to crawl. From here, you can enter which part of website cannot access by search engine crawlers.</p>
<div class="admin_theme_editor_wrapper">
  <form action="<?php echo $this->url(array('action' => 'save')) ?>" method="post">
    <div class="admin_theme_edit">
        <div class="admin_theme_editor_edit_wrapper">
          <div class="admin_theme_editor">
            <?php echo $this->formTextarea('body', $this->activeFileContents, array('onkeypress' => 'pushModification("body")', 'spellcheck' => 'false')) ?>
          </div>
          <button class="activate_button" type="submit" onclick="saveFileChanges();return false;"><?php echo $this->translate("Save Changes") ?></button>
          <?php echo $this->formHidden('basePath', 'robots.txt', array()) ?>
        </div>
    </div>
  </form>
</div>
