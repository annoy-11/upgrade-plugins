<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SES Advanced Footer - Advanced Footer Menu',
    'description' => 'This widget site-wide displays the advanced footer on your website as per your configurations in the admin panel of this widget.',
    'category' => 'Advanced Footer',
    'type' => 'widget',
    'name' => 'sesfooter.footer',
  ),
  array(
    'title' => 'SES Advanced Footer - Social Links Widget',
    'description' => 'This widget displays the social links as per your configurations in the admin panel of this plugin. You can place this widget anywhere on your website.',
    'category' => 'Advanced Footer',
    'autoEdit' => true,
    'type' => 'widget',
    'name' => 'sesfooter.socialicon-footer',
    'adminForm' => 'Sesfooter_Form_Admin_SocialIcons',
  ),
);
?>