<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sessportz") && Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.pluginactivated')) {
    //New File System Code
    $banner_options = array('' => '');
    $files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
    foreach( $files as $file ) {
      $banner_options[$file->storage_path] = $file->name;
    }
}
return array(
    array(
        'title' => 'SES - Responsive Sportz Theme - Landing Page Table Widget',
        'description' => 'Display content in this widget by Global Settings. This is only for landing Page Only',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sessportz.landing-page-table',
        'defaultParams' => array(
            'title' => '',
        ),
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Scroll Top to Bottom',
        'description' => 'Displays a "Scroll Top to Bottom" button on the page on which this widget is placed. If you want this "Scroll Top to Bottom" button to appear on all the pages of your site, then just place the widget in the Footer of your site.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.scroll-bottom-top',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Header',
        'description' => 'This widget displays the header of your website and includes Site Logo, Main Menu, Mini Menu and Global Search.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sessportz.header',
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Members',
        'description' => "Displays members of your site in Carousel or Cloud.",
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sessportz.members',
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
        'title' => 'SES - Responsive Sportz Theme - Footer Menu',
        'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.footer',
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Banner Image',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.banner',
        'adminForm' => 'Sessportz_Form_Admin_Banner',
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Paralex Effect Widget',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.paralex',
        'adminForm' => 'Sessportz_Form_Admin_Paralex',
    ),
 array(
        'title' => 'SES - Responsive Sportz Theme - Custom Browse Menu',
        'description' => 'You can place this widget anywhere.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.custom-browse-menu',
    ),
    array(
        'title' => 'SES - Responsive Sportz Theme - Footer Newsletter',
        'description' => 'You can place this widget anywhere.',
        'category' => 'Responsive Sportz Theme',
        'type' => 'widget',
        'name' => 'sessportz.footer-newsletter',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'bgimage',
                    array(
                        'label' => 'Choose the background image.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
            ),
        ),
    ),
);
?>
