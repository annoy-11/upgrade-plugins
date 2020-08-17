<?php
return array (
    'package' =>
    array (
        'type' => 'widget',
        'name' => 'sesfixedlayout',
        'version' => '5.2.1',
        'path' => 'application/widgets/sesfixedlayout',
        'title' => 'SES - Fixed / Floating Page Columns Widget',
        'description' => 'SES - Fixed / Floating Page Columns Widget',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'actions' =>
        array (
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'remove',
        ),
        'directories' =>
        array (
            'application/widgets/sesfixedlayout',
        ),
        'files' =>
        array (
            'externals/ses-scripts/sesJquery.js',
        ),
    ),
    'type' => 'widget',
    'name' => 'sesfixedlayout',
    'version' => '5.2.1',
    'title' => 'SES - Fixed / Floating Page Columns Widget',
    'description' => 'SES - Fixed / Floating Page Columns Widget',
    'category' => 'SES - Widgets',
    'adminForm' => array(
        'elements' => array(
            array(
                'Radio',
                'fixedheader',
                array(
                    'label' => "Do you have fixed header on your website ?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    'value' => 1,
                )
            ),
        )
    ),
);
