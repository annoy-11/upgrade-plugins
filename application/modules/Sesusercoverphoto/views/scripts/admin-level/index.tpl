<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesusercoverphoto/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    var url = '<?php echo $this->url(array('id' => null)) ?>';
    window.location.href = url + '/index/id/' + level_id;
  }
</script>

<div class="settings sesbasic_admin_form">
  <div class='settings'>
    <?php echo $this->form->render($this) ?>
</div>
</div>
