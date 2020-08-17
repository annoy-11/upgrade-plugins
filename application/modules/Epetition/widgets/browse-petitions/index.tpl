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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<?php  if(!$this->is_ajax): ?>
	<div class="epetition_browse_petitions">
<?php endif;?>
	<?php include APPLICATION_PATH . '/application/modules/Epetition/views/scripts/_showPetitionListGrid.tpl'; ?>
<?php  if(!$this->is_ajax): ?>
	</div>
<?php endif;?>