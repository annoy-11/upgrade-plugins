<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="epetition_signtaure_profile">
<?php

if ($this->sign_goal <= $this->signpet) {

  //petition victory
  if ($this->victory == 1) { ?>
      <div class="epetition-victory">
          <p><?php echo $this->translate("Victory! This petition made change with %s supporters!",$this->sign_goal);?></p>
      </div>
  <?php } else { ?>
      <div class="epetition-near-victory">
          <p><?php echo $this->translate("This petition made change with %s supporters!.",$this->sign_goal); ?></p>
      </div>
  <?php }
  //petition close
} else if ($this->victory == 2) {
   ?>
    <div class="epetition-near-close">
        <p><?php echo $this->translate("This petition is closed"); ?></p>
    </div>
<?php } 
else {  ?>
    <div class="epetition_lets_get" id="epetition-complete" xmlns="">
       <span class="countpetition" id="epetition_singpet"><?php echo $this->signpet; ?></span> <?php  echo $this->translate(" have signed."); ?>
    </div>
    <div class="epetition_target" id="epetition-target"><span id="epetition_singgoal"><?php echo $this->translate("Let’s get to %s",$this->sign_goal); ?></span></div>


    <div class="epetition_signature_bar_container">
      <div class="epetition_signature_bar">
         <div id="epetition-lineasign" class="epetition_signature_bar_filled per<?php echo $this->epetition_id; ?>"
               style="width:<?php echo $this->sign_per; ?>%;"></div>
      </div>
   </div>
  <?php if ($this->user_check && (empty($this->startdate) || (strtotime(date("Y-m-d H:i:s")) >= strtotime($this->startdate))) && (empty($this->enddate) || (strtotime(date("Y-m-d H:i:s")) <= strtotime($this->enddate)))) { ?>
      <?php $viewer = Engine_Api::_()->user()->getViewer();
         if($viewer->getIdentity()) { ?>
        <a class="sessmoothbox" href="<?php echo $this->baseUrl() . "/epetition/index/popsignpetition?id=" . $this->epetition_id; ?>"><?php echo $this->translate("Sign This Petition"); ?></a>
           <?php  } else { ?>
             <a class="sessmoothbox" href="<?php echo $this->baseUrl() . "/login"; ?>"><?php echo $this->translate("Sign This Petition"); ?></a>
           <?php } ?>
  <?php }
} ?>
</div>
<script type="application/javascript">

    sesJqueryObject('.countpetition').each(function () {
        sesJqueryObject(this).prop('Counter', 0).animate({
            Counter: sesJqueryObject(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                sesJqueryObject(this).text(Math.ceil(now));
            }
        });
    });

    window.setInterval(function () {
        ajaxcallforupdate();
    }, <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');  ?>);
</script>
