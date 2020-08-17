<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-announcement.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesgroup_dashboard_create_popup sesgroup_add_announcement_popup sesbasic_bxs">
  <?php echo $this->form->render() ?>
</div>

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