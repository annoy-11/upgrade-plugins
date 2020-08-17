<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Add to Shortcuts',
    'description' => 'This widget enables users to add the content on which it is placed to their shortcuts list. This widget should be placed on the View / Profile page of modules on your website.',
    'category' => 'SES - Add To Shortcuts / Bookmarks Plugin',
    'type' => 'widget',
    'name' => 'sesshortcut.shortcut-button',
  ),
  array(
    'title' => 'Shortcuts Menu',
    'description' => 'This widget displays all shortcuts added by the members on your website to them. In this widget they can choose to add shortcut menus on top, search shortcuts and remove a menu from shortcut. You can place this widget anywhere on the site.',
    'category' => 'SES - Add To Shortcuts / Bookmarks Plugin',
    'type' => 'widget',
    'name' => 'sesshortcut.shortcut-menu',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limitdata',
          array(
            'label' => 'Enter the number of shortcuts after which "See More" will be shown in this widget. On clickign "See More" all shortcuts added by a user will be shown.',
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
);