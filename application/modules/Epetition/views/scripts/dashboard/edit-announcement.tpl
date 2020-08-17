<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-announcement.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="epetition_announcement_form sesbasic_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs"><?php echo $this->form->render($this); ?></div>
<script type="application/javascript">
  function sessmoothboxcallbackclose() {
    tinymce.remove();
  }
  executetimesmoothboxTimeinterval = 400;
  executetimesmoothbox = true;
  en4.core.runonce.add(function() {
    makeEditorRich();
  });
</script>
