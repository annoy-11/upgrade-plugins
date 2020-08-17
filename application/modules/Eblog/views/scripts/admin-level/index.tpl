<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/eblog/level/index/id/' + level_id;
  }
</script>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this) ?>
  </div>
</div>

<script type="text/javascript">
  window.onload = function() {
    enableblogdesignview();
  };
  window.addEvent('domready', function() {
    continuereadingbutton(sesJqueryObject("input[name='cotinuereading']:checked").val());
    showHideHeight(sesJqueryObject("input[name='cntrdng_dflt']:checked").val());
  });

  function continuereadingbutton(value) {
    if (value == 1) {
      $('cntrdng_dflt-wrapper').style.display = 'none';
      $('continue_height-wrapper').style.display = 'none';
    } else {
      $('cntrdng_dflt-wrapper').style.display = 'block';
      $('continue_height-wrapper').style.display = 'block';
    }
  }

  function showHideHeight(value) {
    if (value == 1) {
      $('continue_height-wrapper').style.display = 'block';
    } else {
      $('continue_height-wrapper').style.display = 'none';
    }
  }
  
  function enableblogdesignview() {
    var values=document.querySelector('input[name="eblog_enblogdes"]:checked').value;
    if(values == 1) {
        document.getElementById('eblog_chooselay-wrapper').style.display = 'block';
        document.getElementById('eblog_defaultlay-wrapper').style.display = 'none';
    } else {
        document.getElementById('eblog_chooselay-wrapper').style.display = 'none';
        document.getElementById('eblog_defaultlay-wrapper').style.display = 'block';
    }
  }
</script>
