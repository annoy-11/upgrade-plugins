<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Landing Page Widget',
        'description' => 'Display content in this widget by Global Settings. This is only for landing Page Only',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sesspectromedia.landing-page-text',
        'defaultParams' => array(
            'title' => '',
        ),
    ),
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Scroll Top to Bottom',
        'description' => 'Displays a "Scroll Top to Bottom" button on the page on which this widget is placed. If you want this "Scroll Top to Bottom" button to appear on all the pages of your site, then just place the widget in the Footer of your site.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'name' => 'sesspectromedia.scroll-bottom-top',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Header',
        'description' => 'This widget displays the header of your website and includes Site Logo, Main Menu, Mini Menu and Global Search.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesspectromedia.header',
    ),
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Members',
        'description' => "Displays members of your site in Carousel or Cloud.",
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesspectromedia.members',
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
        'title' => 'SES - Responsive SpectroMedia Theme - Footer Menu',
        'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'name' => 'sesspectromedia.footer',
    ),
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Banner Image',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'name' => 'sesspectromedia.banner',
        'adminForm' => 'Sesspectromedia_Form_Admin_Banner',
    ),
    array(
        'title' => 'SES - Responsive SpectroMedia Theme - Paralex Effect Widget',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'name' => 'sesspectromedia.paralex',
        'adminForm' => 'Sesspectromedia_Form_Admin_Paralex',
    ),
		 array(
        'title' => 'SES - Responsive SpectroMedia Theme - Features Block Widget',
        'description' => 'You can place this widget anywhere.',
        'category' => 'Responsive SpectroMedia Theme',
        'type' => 'widget',
        'name' => 'sesspectromedia.features-block',
    ),

);
?>