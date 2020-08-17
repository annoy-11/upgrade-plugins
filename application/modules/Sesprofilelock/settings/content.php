<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Content.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'Most Viewed Members',
        'description' => 'Displays the list of most viewed members on your website.',
        'category' => 'User Accounts Privacy and Security',
        'type' => 'widget',
        'name' => 'sesprofilelock.most-viewed',
        'defaultParams' => array(
            'title' => 'Most Viewed Members',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'statistics',
                    array(
                        'label' => 'Choose the information to be displayed about the members shown in this widget.',
                        'multiOptions' => array('viewCount' => 'Total number of profile views of the member.', 'memberCount' => 'Total number of friends of the members.'),
                    ),
                ),
                array(
                    'Text',
                    'itemCountPerPage',
                    array(
                        'label' => 'Count (number of members to show)',
                        'value' => 3,
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'Blocked Members',
        'description' => 'Displays the list of all blocked members. This widget should be placed on ‘User Accounts - Block Members Page’.',
        'category' => 'User Accounts Privacy and Security',
        'type' => 'widget',
        'name' => 'sesprofilelock.blocked-members',
        'defaultParams' => array(
            'title' => 'Blocked Members',
        ),
    ),
);