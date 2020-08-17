<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesblog
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesblog/externals/styles/styles.css'); ?> 
<?php foreach($this->categories as $key => $item) { ?>
  <?php $item = Engine_Api::_()->getItem('sesblog_category', $key); ?>
  <a href="<?php echo $item->getHref(); ?>"><?php echo $item->category_name; ?></a>
<?php } ?>
