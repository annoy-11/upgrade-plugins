<?php
class Sesblogpackage_Api_Core extends Core_Api_Abstract {

 public function getCustomFieldMapData($blog) {
    if ($blog) {
      $db = Engine_Db_Table::getDefaultAdapter();
      return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_sesblog_blog_fields_options.label) SEPARATOR ', ')),engine4_sesblog_blog_fields_values.value) AS `value`, `engine4_sesblog_blog_fields_meta`.`label`, `engine4_sesblog_blog_fields_meta`.`type` FROM `engine4_sesblog_blog_fields_values` LEFT JOIN `engine4_sesblog_blog_fields_meta` ON engine4_sesblog_blog_fields_meta.field_id = engine4_sesblog_blog_fields_values.field_id LEFT JOIN `engine4_sesblog_blog_fields_options` ON engine4_sesblog_blog_fields_values.value = engine4_sesblog_blog_fields_options.option_id AND `engine4_sesblog_blog_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_sesblog_blog_fields_values.item_id = ".$blog->getIdentity().") AND (engine4_sesblog_blog_fields_values.field_id != 1) GROUP BY `engine4_sesblog_blog_fields_meta`.`field_id`,`engine4_sesblog_blog_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }
}