<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!--seslisting onear photo three-->
<div class="seslisting_owner_photo">
  <?php if($this->photoviewtype == 'square'): ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'seslistings_gutter_photo_square')) ?>
  <?php else: ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'seslistings_gutter_photo')) ?>
	<?php endif; ?>
	<?php $user = $this->owner;?>
	<?php $db = Engine_Db_Table::getDefaultAdapter();?>
	<?php $data =  $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_user_fields_options.label) SEPARATOR ', ')),engine4_user_fields_values.value) AS `value`, `engine4_user_fields_meta`.`label`, `engine4_user_fields_meta`.`type` FROM `engine4_user_fields_values` LEFT JOIN `engine4_user_fields_meta` ON engine4_user_fields_meta.field_id = engine4_user_fields_values.field_id LEFT JOIN `engine4_user_fields_options` ON engine4_user_fields_values.value = engine4_user_fields_options.option_id AND `engine4_user_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_user_fields_values.item_id = ".$user->user_id.") AND (engine4_user_fields_values.field_id != 1) AND `engine4_user_fields_meta`.`type` = 'about_me' GROUP BY `engine4_user_fields_meta`.`field_id`,`engine4_user_fields_options`.`field_id`")->fetchAll();?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'seslistings_gutter_name')) ?>
    <?php if(isset($data[0]['valuesMeta'])):?>
      <p class="about_content"><?php echo $this->string()->truncate($this->string()->stripTags($data[0]['valuesMeta']), $this->user_description_limit) ?></p>
    <?php endif;?>
</div>
