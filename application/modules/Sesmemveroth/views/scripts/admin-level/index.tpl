<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmemveroth/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/sesmemveroth/level/index/id/'+level_id;
  }
</script>
<div class='clear'>
  <div class='settings sesbasic_admin_form sesmemveroth_ml_settings'>
    <?php echo $this->form->render($this) ?>
  </div>
</div>
