<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _data.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  $locale = new Zend_Locale($localeLanguage);?>
<?php Zend_Date::setOptions(array('format_type' => 'php'));?>
<?php $date = new Zend_Date(strtotime($course->creation_date), false, $locale);?>
<?php if(isset($this->creationDateActive)):?>
  <span class="_duration sesbasic_text_light"><i class="fa fa-calendar" ></i><?php echo $date->toString('jS M');?>,&nbsp;<?php echo date('Y', strtotime($course->creation_date)); ?></span>
<?php endif;?>


