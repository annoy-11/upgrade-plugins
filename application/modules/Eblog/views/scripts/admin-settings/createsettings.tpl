<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id:createsettings.tpl 2019-08-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/dismiss_message.tpl';?>
<div class="settings sesbasic_admin_form">
  <?php echo $this->form->render(); ?>
</div>
<script>
window.onload=function() {
  changeenablecategory();
  changeenabledescriptition();
  changeenablephoto();
  changereadtime();
};

function changeenablephoto() {
  var values = document.querySelector('input[name="eblog_cre_photo"]:checked').value;
  if (parseInt(values) == 1) {
    document.getElementById("eblog_photo_mandatory-wrapper").style.display='block';
  } else {
    document.getElementById("eblog_photo_mandatory-wrapper").style.display= 'none';
  }
}

function changeenablecategory() {
  var values = document.querySelector('input[name="eblogcre_enb_category"]:checked').value;
  if (parseInt(values) == 1) {
    document.getElementById("eblogcre_cat_req-wrapper").style.display='block';
  } else {
    document.getElementById("eblogcre_cat_req-wrapper").style.display='none';
  }
}

function changeenabledescriptition() {
  var values = document.querySelector('input[name="eblogcre_enb_des"]:checked').value;
  if (parseInt(values) == 1) {
    document.getElementById("eblogcre_des_req-wrapper").style.display='block';
  } else {
    document.getElementById("eblogcre_des_req-wrapper").style.display='none';
  }
}

function  changereadtime() {
  var values = document.querySelector('input[name="eblog_readtime"]:checked').value;
  if (parseInt(values) == 1) {
    document.getElementById("eblog_man_readtime-wrapper").style.display='block';
  } else {
    document.getElementById("eblog_man_readtime-wrapper").style.display='none';
  }
}
</script>
