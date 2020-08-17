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
<?php $allsettings=$this->allParams;  ?>
<div class="epetition_owner_photo_three">
    <p class="about_title"><?php echo $this->translate($this->title); ?></p>
  <?php  if(isset($allsettings['ownerphoto']) && !strcmp($allsettings['ownerphoto'],"yes")) { ?>
  <?php if (!strcmp($allsettings['photoviewtype'],"square")): ?>
    <?php  echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner), array('class' => 'epetition_gutter_photo_square')) ?>
  <?php else: ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner), array('class' => 'epetition_gutter_photo_circle')) ?>
  <?php endif; ?>
    <?php } ?>


  <?php  if(isset($allsettings['toppetition']) && !strcmp($allsettings['toppetition'],"yes")) { ?>
    <div id="totalpeition">
        <p><?php echo $this->translate("Total Petition: %s",$this->totalpeition);  ?></p>
    </div>
    <?php } ?>


  <?php  if(isset($allsettings['toppetition']) && !strcmp($allsettings['ownername'],"yes")) { ?>
  <?php $user = $this->owner; ?>
  <?php $db = Engine_Db_Table::getDefaultAdapter(); ?>
  <?php $data = $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_user_fields_options.label) SEPARATOR ', ')),engine4_user_fields_values.value) AS `value`, `engine4_user_fields_meta`.`label`, `engine4_user_fields_meta`.`type` FROM `engine4_user_fields_values` LEFT JOIN `engine4_user_fields_meta` ON engine4_user_fields_meta.field_id = engine4_user_fields_values.field_id LEFT JOIN `engine4_user_fields_options` ON engine4_user_fields_values.value = engine4_user_fields_options.option_id AND `engine4_user_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_user_fields_values.item_id = " . $user->user_id . ") AND (engine4_user_fields_values.field_id != 1) AND `engine4_user_fields_meta`.`type` = 'about_me' GROUP BY `engine4_user_fields_meta`.`field_id`,`engine4_user_fields_options`.`field_id`")->fetchAll(); ?>
  <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'epetition_gutter_name')) ?>
    <?php  } ?>
    <?php  if(isset($data[0]['valuesMeta'])) { ?>
      <p class="about_contatant"><?php echo $this->string()->truncate($this->string()->stripTags($data[0]['valuesMeta']), $allsettings['aboutuser']); ?></p>
  <?php } ?>
</div>
