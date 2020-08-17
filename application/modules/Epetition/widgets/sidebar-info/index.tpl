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
<?php $allsettings = $this->allParams['sidebar_info']; ?>
<ul>
  <?php if (in_array("petitiondeadline", $allsettings) && isset($this->deadline)) { ?>
      <li><b><i class="fa fa-clock"></i></b> <?php echo $this->translate($this->deadline); ?></li>
  <?php } ?>

  <?php if (in_array("petitioncategory", $allsettings) && isset($this->category)) { ?>
      <li><b><i class="fa fa-folder-open"></i></b> <?php echo $this->translate($this->category); ?></li>
  <?php } ?>


  <?php if (in_array("tags", $allsettings) && isset($this->tags)) { ?>
      <li><b><i class="fa fa-tag"></i></b> <?php echo $this->translate($this->tags); ?></li>
  <?php } ?>


  <?php if (in_array("petitionlocation", $allsettings) && isset($this->location)) { ?>
      <li><b><i class="fa fa-map-marker"></i></b> <?php echo $this->translate($this->location); ?></li>
  <?php } ?>
</ul>