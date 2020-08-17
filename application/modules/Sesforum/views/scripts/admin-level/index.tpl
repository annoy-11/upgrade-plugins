<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>


<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/sesforum/level/index/id/'+level_id;
    //alert(level_id);
  }
</script>

<div class='clear'>
<?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/dismiss_message.tpl';?>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this) ?>
  </div>

</div>
