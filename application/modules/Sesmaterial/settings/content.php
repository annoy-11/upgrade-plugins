<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    array(
      'title' => 'SES - Responsive Material Theme - Dashboard Links',
      'description' => '',
      'category' => 'SES - Responsive Material Theme',
      'type' => 'widget',
      'name' => 'sesmaterial.deshboard-links',
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
        'title' => 'SES - Responsive Material Theme - Landing Page Widget',
        'description' => 'Display content in this widget by Global Settings. This is only for landing Page Only',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sesmaterial.landing-page',
        'defaultParams' => array(
            'title' => '',
        ),
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Scroll Top to Bottom',
        'description' => 'Displays a "Scroll Top to Bottom" button on the page on which this widget is placed. If you want this "Scroll Top to Bottom" button to appear on all the pages of your site, then just place the widget in the Footer of your site.',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'name' => 'sesmaterial.scroll-bottom-top',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Header',
        'description' => 'This widget displays the header of your website and includes Site Logo, Main Menu, Mini Menu and Global Search.',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmaterial.header',
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Members',
        'description' => "Displays members of your site in Carousel or Cloud.",
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmaterial.members',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showType',
                    array(
                        'label' => "Show Type",
                        'multiOptions' => array(
                            '1' => 'Carousel',
                            '0' => 'Cloud',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Radio',
                    'heading',
                    array(
                        'label' => "Do you want to show total member's count on your site in this widget?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'memberCount',
                    array(
                        'label' => 'Enter number of members to
						be shown in this widget.',
                        'value' => 33,
                    )
                ),
                array(
                    'Radio',
                    'showTitle',
                    array(
                        'label' => "Do you want to show title ?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter height [in px] of members to be shown in this widget.',
                        'value' => 150,
                    ),
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter width [in px] of members to be shown in this widget.',
                        'value' => 148,
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Footer Menu',
        'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor.',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'name' => 'sesmaterial.footer',
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Banner Image',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'name' => 'sesmaterial.banner',
        'adminForm' => 'Sesmaterial_Form_Admin_Banner',
    ),
    array(
        'title' => 'SES - Responsive Material Theme - Custom Browse Menu',
        'description' => 'You can place this widget anywhere.',
        'category' => 'Responsive Material Theme',
        'type' => 'widget',
        'name' => 'sesmaterial.custom-browse-menu',
    ),
);
