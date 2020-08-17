<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
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
    'title' => 'SES - Professional FB Clone - Enable Fixed Sidebar Layout',
    'description' => 'Enable Fixed Sidebar Layout',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.fixed-layout',
  ),
  array(
    'title' => 'SES - Professional FB Clone - Header',
    'description' => 'Displays all faq tags on your website. The recommended page for this widget is "SES - FAQs - Browse Tags Page".',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.header',
  ),
	array(
    'title' => 'SES - Professional FB Clone - Dashboard Links',
    'description' => 'Displays all faq tags on your website. The recommended page for this widget is "SES - FAQs - Browse Tags Page".',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.deshboard-links',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limitdata',
          array(
            'label' => 'Enter the number of shortcuts after which "See More" will be shown in this widget. On clickign "See More" all shortcuts added by a user will be shown. This setting is depandent on "SES - Add To Shortcuts / Bookmarks Plugin".',
            'value' => 5,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      )
    )
  ),
	array(
    'title' => 'SES - Professional FB Clone - Footer',
    'description' => 'Displays all faq tags on your website. The recommended page for this widget is "SES - FAQs - Browse Tags Page".',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.footer',
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
    'title' => 'SES - Professional FB Clone - Landing Page',
    'description' => 'Displays all faq tags on your website. The recommended page for this widget is "SES - FAQs - Browse Tags Page".',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.landing-page',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'leftsideimage',
          array(
              'label' => 'Choose the Image to be shown in this widget.',
              'multiOptions' => $banner_options,
              'value' => '',
          )
        ),
        array(
          'Text',
          'heading',
          array(
            'label' => 'Enter the heading text.',
            'value' => 'Welcome to SocialEngine! We\'re glad that you\'re here.',
          ),
        ),
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter the description.',
            'value' => 'We believe that friends are important – we hope that you\'ll connect with yours on SocialEngine.',
          ),
        ),
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
    'title' => 'SES - Professional FB Clone - Language Chooser',
    'description' => 'Facebook Language choose',
    'category' => 'SES - Professional FB Clone',
    'type' => 'widget',
    'name' => 'sesfbstyle.language-chooser',
  ),
);
