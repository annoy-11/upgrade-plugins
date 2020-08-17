<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(count($this->paginator) <= 0): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Nobody has created an album yet.');?>
    </span>
  </div>
<?php endif; ?>
