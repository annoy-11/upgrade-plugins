<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _data.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->creationDateActive)):?>
  <span><i class="fa fa-clock-o"></i><?php echo $this->timestamp($classroom->modified_date, array()) ?></span>
<?php endif;?>
<?php if(isset($this->memberActive) && 0):?>
  <span><i class="fa fa-user-o"></i><?php echo $this->translate(array('%s Member', '%s Member', $members->getTotalItemCount()), $this->locale()->toNumber($members->getTotalItemCount())) ?></span>
<?php endif;?>
