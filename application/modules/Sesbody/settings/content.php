<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    array(
        'title' => 'SES - Responsive Body Theme - Scroll Top to Bottom',
        'description' => 'Displays a "Scroll Top to Bottom" button on the page on which this widget is placed. If you want this "Scroll Top to Bottom" button to appear on all the pages of your site, then just place the widget in the Footer of your site.',
        'category' => 'Responsive Body Theme',
        'type' => 'widget',
        'name' => 'sesbody.scroll-bottom-top',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'SES - Responsive Body Theme - Members',
        'description' => "Displays members of your site in Carousel or Cloud.",
        'category' => 'Responsive Body Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbody.members',
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
        'title' => 'SES - Responsive Body Theme - Paralex Effect Widget',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'Responsive Body Theme',
        'type' => 'widget',
        'name' => 'sesbody.paralex',
        'adminForm' => 'Sesbody_Form_Admin_Paralex',
    ),

);