<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'Admin Wish and Countdown Widget',
        'description' => 'This widget displays Christmas and New Year wishes by you and the Countdown for New Year / Christmas, as chosen by you in the settings. You can choose various settings by editing this widget.',
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.banner-template1',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'designType',
                    array(
                        'label' => 'Choose from below the design for the countdown image.',
                        'multiOptions' => array(
                            'circel' => 'Circular Green',
                            'tree' => 'Triangular Red',
                        ),
                        'value' => 'tree'
                    )
                ),
                array(
                    'Radio',
                    'viewType',
                    array(
                        'label' => 'Choose the type of column for the placement of this widget.',
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal Column',
                            'vertical' => 'Vertical Column',
                        ),
                        'value' => 'vertical'
                    )
                ),
                array(
                    'Radio',
                    'showcountdown',
                    array(
                        'label' => 'Choose from below the occasion for which you want to show the countdown timer.',
                        'multiOptions' => array(
                            1 => 'New Year',
                            0 => 'Christmas'
                        ),
                        'value' => 0,
                    )
                ),
                array(
                    'Radio',
                    'showtext1',
                    array(
                        'label' => 'Do you want to write Christmas and New Year wishes for your users? [If you choose Yes, then you can write the wish in the setting below this.]',
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'text1',
                    array(
                        'label' => 'Enter the Christmas and New Year wish for your users. This wish will display in the circular block in this widget.',
                        'value' => 'Merry Christmas and Happy New Year',
                    )
                ),
                array(
                    'Radio',
                    'showtext2',
                    array(
                        'label' => 'Do you want to show any text inside the countdown image? [If you choose Yes, then you can write the text in the setting below this.]',
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'text2',
                    array(
                        'label' => 'Enter the text to be displayed inside the countdown timer widget.',
                        'value' => 'Christmas Coming Soon',
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'Christmas - Snow Effect',
        'description' => 'This widget displays the snow effect on the page on which it is placed. It is recommended to place this widget on the Site Footer page, so that the snow effect is shown globally on your website.',
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.welcome',
    ),
    array(
        'title' => 'Make a Wish',
        'description' => 'This widget displays a “Make a Wish” button clicking on which a popup with text area to write wish will open and users will be redirected to the wishes page, when they save their wishes.',
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.write-wish',
    ),
    array(
        'title' => 'Christmas - Wishes Browse Menu',
        'description' => "This widget displays a menu in 'Wishes' and 'Friends' Wishes’ Pages.",
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.browse-menu',
    ),
    array(
        'title' => 'Christmas - Go to Welcome Page',
        'description' => 'This widget displays a button, clicking on which users will be redirected to the Welcome Page of Christmas and New Year wishes. By editing this widget, you can choose to open the Welcome Page in same tab or new tab.',
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.christmas-page',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'openTab',
                    array(
                        'label' => 'Choose from the below where you want to open "Christmas" Page?',
                        'multiOptions' => array(
                            1 => 'New Tab',
                            0 => 'Same Tab'
                        ),
                        'value' => 1,
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'Christmas and New Year Countdown Clock',
        'description' => 'This widget add a simple countdown clock for Christmas and New Year to your website. This widget should be placed in Left / Right column only. By editing this widget, you can choose which countdown you want to show.',
        'category' => 'Christmas & New Year Design Elements',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seschristmas.countdown-clock',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showcountdown',
                    array(
                        'label' => 'Choose from below the occasion for which you want to show the countdown timer.',
                        'multiOptions' => array(
                            1 => 'New Year',
                            0 => 'Christmas'
                        ),
                        'value' => 0,
                    )
                ),
            ),
        ),
    ),
);
?>