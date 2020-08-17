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
<?php $allsettings = $this->allParams['statistics_info']; ?>
<ul>
<?php if (in_array("createdby", $allsettings) && isset($this->createdby)) { ?>
<li><b><?php echo $this->translate("Created By"); ?> : </b><?php echo $this->translate($this->createdby); ?></li>
<?php } ?>

  <?php if (in_array("creationdate", $allsettings) && isset($this->creationdate)) { ?>
      <li><b><?php echo $this->translate("Created Date"); ?> : </b><?php echo $this->translate($this->creationdate); ?></li>
  <?php } ?>

  <?php if (in_array("goalreach", $allsettings) && isset($this->goalreach)) { ?>
      <li><b><?php echo $this->translate("Goal Reach"); ?> : </b><?php echo $this->translate($this->goalreach); ?></li>
  <?php } ?>

  <?php if (in_array("approvedby", $allsettings) && isset($this->approvedby)) { ?>
      <li><b><?php echo $this->translate("Approve By"); ?> : </b><?php echo $this->translate($this->approvedby); ?></li>
  <?php } ?>

  <?php if (in_array("markedvictory", $allsettings) && isset($this->markedvictory)) { ?>
      <li><b><?php echo $this->translate("Victory"); ?> : </b><?php echo $this->translate($this->markedvictory); ?></li>
  <?php } ?>

  <?php if (in_array("countpresentsign", $allsettings) && isset($this->countpresentsign)) { ?>
      <li><b><?php echo $this->translate("Total Signatures"); ?> : </b><?php echo $this->translate($this->countpresentsign); ?></li>
  <?php } ?>

