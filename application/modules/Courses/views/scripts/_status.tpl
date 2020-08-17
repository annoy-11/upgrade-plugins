<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _status.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php if($classroom->status): ?>
  <span class="open"><?php echo $this->translate('open');?></span>
<?php else: ?>
  <span class="closed"><?php echo $this->translate('closed');?></span>
<?php endif; ?>
