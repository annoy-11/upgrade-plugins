<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/ecoupon/settings/level/id/'+level_id;
    //alert(level_id);
  }
function enablecoursedesignview(value) {
  if(value == 1) {
    $('chooselayout-wrapper').style.display = 'block';
    $('defaultlayout-wrapper').style.display = 'none';
  } else {
    $('chooselayout-wrapper').style.display = 'none';
    $('defaultlayout-wrapper').style.display = 'block';
  }
}
</script>

<?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this) ?>
  </div>

</div>
