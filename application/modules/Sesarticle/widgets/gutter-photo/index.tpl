<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<!--sesarticle onear photo three-->
<div class="sesarticle_onear_photo_three">
	<p class="about_title"><?php echo $this->translate($this->title);?></p>
  <?php if($this->photoviewtype == 'square'): ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'sesarticles_gutter_photo_square')) ?>
  <?php else: ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'sesarticles_gutter_photo')) ?>
	<?php endif; ?>
	<?php $user = $this->owner;?>
	<?php $db = Engine_Db_Table::getDefaultAdapter();?>
	<?php $data =  $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_user_fields_options.label) SEPARATOR ', ')),engine4_user_fields_values.value) AS `value`, `engine4_user_fields_meta`.`label`, `engine4_user_fields_meta`.`type` FROM `engine4_user_fields_values` LEFT JOIN `engine4_user_fields_meta` ON engine4_user_fields_meta.field_id = engine4_user_fields_values.field_id LEFT JOIN `engine4_user_fields_options` ON engine4_user_fields_values.value = engine4_user_fields_options.option_id AND `engine4_user_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_user_fields_values.item_id = ".$user->user_id.") AND (engine4_user_fields_values.field_id != 1) AND `engine4_user_fields_meta`.`type` = 'about_me' GROUP BY `engine4_user_fields_meta`.`field_id`,`engine4_user_fields_options`.`field_id`")->fetchAll();?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'sesarticles_gutter_name')) ?>
	<?php // echo '<pre>';print_r($data);die; ?>
	<p class="about_contatant">
			<?php if(count($data)): ?>
	      <?php if((strlen($data[0]['valuesMeta']) > $this->user_description_limit)):?>
        <?php $description = mb_substr($data[0]['valuesMeta'],0,$this->user_description_limit).'...';?>
        <?php echo $data[0]['valuesMeta']; ?>
        <?php else: ?>
        <?php echo $data[0]['valuesMeta'] ?>
        <?php endif; ?>
			<?php endif; ?>
	
	<?php //echo $this->string()->truncate($this->string()->stripTags($data[0]['valuesMeta']), $this->user_description_limit) ?>
	</p>
</div>
