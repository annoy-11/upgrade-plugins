<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  array(
    'title' => 'SES - Membership Subscription Badge - Member Home Page Badge',
    'description' => 'Displays a member\'s badge entries on their member home page. You can place this widget only on Member Home Page.',
    'category' => 'SES - Membership Subscription Badge',
    'type' => 'widget',
    'name' => 'subscriptionbadge.member-home-badge',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array(
            array(
            'Radio',
            'showlevel',
                array(
                    'label' => 'Show Level',
                    'description'=> 'Do you want to show Level in this widget?',
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => 1,
                ),
            ),
            array(
                'Radio',
                'showbadge',
                array(
                    'label' => 'Show Badge',
                    'description'=> 'Do you want to show badge in this widget?',
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => 1,
                ),
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Membership Subscription Badge - Profile Badge',
    'description' => 'Displays a member\'s badge entries on their profile.',
    'category' => 'SES - Membership Subscription Badge',
    'type' => 'widget',
    'name' => 'subscriptionbadge.profile-badge',
    'requirements' => array(
      'subject' => 'user',
    ),
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'showbadge',
          array(
            'label' => 'Show Badge',
            'description'=> 'Do you want to show badge in this widget?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'value' => 1,
        )
        ),
        array(
        'Radio',
        'showlevel',
            array(
                'label' => 'Show Level',
                'description'=> 'Do you want to show Level in this widget?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                ),
                'value' => 1,
            ),
        ),
      )
    ),
  ),
);
