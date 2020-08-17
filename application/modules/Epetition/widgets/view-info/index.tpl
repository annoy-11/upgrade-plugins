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
<?php if(isset($this->petition)){ ?>
<ul class="epetition_profile_view_info">
    <li><b><?php echo $this->translate('Total Signature Goal');  ?></b> - <span class="epetition_info_goal"><?php echo  $this->petition['signature_goal']; ?></span></li>
    <li><b><i class="fa fa-map-marker"></i> <?php echo  $this->translate($this->petition['location']); ?></b></li>
</ul>
<?php  } ?>