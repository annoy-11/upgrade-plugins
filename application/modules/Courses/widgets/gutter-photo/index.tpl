<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="courses_gutter_photo sesbasic_bxs">
  <?php if($this->photoviewtype == 'square'): ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'courses_gutter_photo_square')) ?>
  <?php elseif($this->photoviewtype == 'circle'): ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'courses_gutter_photo_circle')) ?>
	<?php else: ?>
	  <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'courses_gutter_photo')) ?>
	<?php endif; ?>
	<?php $user = $this->owner;?>
	<?php $db = Engine_Db_Table::getDefaultAdapter();?>
	<?php $data =  $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_user_fields_options.label) SEPARATOR ', ')),engine4_user_fields_values.value) AS `value`, `engine4_user_fields_meta`.`label`, `engine4_user_fields_meta`.`type` FROM `engine4_user_fields_values` LEFT JOIN `engine4_user_fields_meta` ON engine4_user_fields_meta.field_id = engine4_user_fields_values.field_id LEFT JOIN `engine4_user_fields_options` ON engine4_user_fields_values.value = engine4_user_fields_options.option_id AND `engine4_user_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_user_fields_values.item_id = ".$user->user_id.") AND (engine4_user_fields_values.field_id != 1) AND `engine4_user_fields_meta`.`type` = 'about_me' GROUP BY `engine4_user_fields_meta`.`field_id`,`engine4_user_fields_options`.`field_id`")->fetchAll();?>
	<div class="_title centerT"><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'courses_gutter_name')) ?></div>
  <?php if(!empty($this->course->working_profiles)): ?>
    <div class="_profile centerT sesbasic_text_light"><?php echo $this->course->working_profiles; ?></div>
  <?php endif; ?> 
  <?php if(!empty($this->course->instructor_qualifications)): ?>
  <div class="_qual centerT "><?php echo $this->course->instructor_qualifications; ?></div>
  <?php endif; ?> 
	<div class="_des centerT"><?php echo $this->string()->truncate($this->string()->stripTags($data[0]['valuesMeta']), $this->user_description_limit) ?></div>
</div>
