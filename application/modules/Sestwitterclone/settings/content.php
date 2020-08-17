<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestwitterclone
 * @package    Sestwitterclone
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$banner_options[] = '';
$path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
foreach ($path as $file) {
  if ($file->isDot() || !$file->isFile())
    continue;
  $base_name = basename($file->getFilename());
  if (!($pos = strrpos($base_name, '.')))
    continue;
  $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
  if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
    continue;
  $banner_options['public/admin/' . $base_name] = $base_name;
}

return array(
  array(
    'title' => 'SES - Professional Twitter Clone - Header',
    'description' => 'This widget will display the header of your website. The recommended page is "SIte Header".',
    'category' => 'SES - Professional Twitter Clone',
    'type' => 'widget',
    'name' => 'sestwitterclone.header',
  ),
  array(
    'title' => 'SES - Professional Twitter Clone - Footer',
    'description' => 'This widget will display the footer of your website. The recommended page is "Site Footer".',
    'category' => 'SES - Professional Twitter Clone',
    'type' => 'widget',
    'name' => 'sestwitterclone.footer',
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'language_count',
          array(
            'label' => 'Show More / Plus Icon',
            'description'=>'Enter the number of languages after which you want the Plus icon to be shown in the widget. When users will click on Plus icon, they will see more languages in attractive popup.',
            'value' => '4',
          ),
        ),
       ),
      ),
  ),
	array(
    'title' => 'SES - Professional Twitter Clone - Landing Page',
    'description' => 'This widget displays Landing Page of your website. The recommended page is Landing Page".',
    'category' => 'SES - Professional Twitter Clone',
    'type' => 'widget',
    'name' => 'sestwitterclone.landing-page',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'socialloginbutton',
          array(
              'label' => 'Do you want to show Social Login button in this widget ? This settings is depandent on "Social Media Login - 1 Click Social Connect Plugin".',
              'multiOptions' => array(
                1 => "Yes",
                0 => "No",
              ),
              'value' => 0,
          )
        ),
      )
    ),
  ),
	array(
    'title' => 'SES - Professional Twitter Clone - Home Photo',
    'description' => 'It will display the User Photo & Name with the total number of posts posted, followers & followings. The recommended page is "Member Home Page".',
    'category' => 'SES - Professional Twitter Clone',
    'type' => 'widget',
    'name' => 'sestwitterclone.home-photo',
  ),
	array(
    'title' => 'SES - Professional Twitter Clone - Sidebar Footer',
    'description' => 'This widget will display footer of your website at the sidebar columns (left/right). You can place this widget at any page. ',
    'category' => 'SES - Professional Twitter Clone',
    'type' => 'widget',
    'name' => 'sestwitterclone.sidebar-footer',
  ),
);
