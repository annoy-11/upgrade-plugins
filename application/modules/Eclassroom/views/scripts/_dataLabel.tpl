<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataLabel.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->featuredLabelActive) && $classroom->featured):?>
  <p class="eclassroom_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></p>
<?php endif; ?>
<?php if(isset($this->sponsoredLabelActive) && $classroom->sponsored):?>
  <p class="eclassroom_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><?php echo $this->translate('SPONSORED');?></p>
<?php endif; ?>
<?php if(isset($this->hotLabelActive) && $classroom->hot): ?>
  <p class="eclassroom_label_hot" title="<?php echo $this->translate('Hot');?>"><?php echo $this->translate('HOT');?></p>
<?php endif; ?>

