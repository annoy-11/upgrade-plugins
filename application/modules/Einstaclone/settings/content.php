<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: content.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

return array(
  array(
    'title' => 'SNS - Insta Clone Theme - Header',
    'description' => 'This widget will display the header of your website. The recommended page is "SIte Header".',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.header',
  ),
  array(
    'title' => 'SNS - Insta Clone Theme - Footer',
    'description' => 'This widget will display the footer of your website. The recommended page is "Site Footer".',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.footer',
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
    'title' => 'SNS - Insta Clone Theme - Landing Page',
    'description' => 'This widget displays Landing Page of your website. The recommended page is Landing Page".',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.landing-page',
    'adminForm' => array(
      'elements' => array(
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
    'title' => 'SNS - Insta Clone Theme - Home Photo',
    'description' => 'It will display the User Photo & Name with the total number of posts posted, followers & followings. The recommended page is "Member Home Page".',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.home-photo',
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Sidebar Footer',
    'description' => 'This widget will display footer of your website at the sidebar columns (left/right). You can place this widget at any page. ',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.sidebar-footer',
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Suggested Members',
    'description' => 'This widget will display suggested members of your website at the sidebar columns (left/right). You can place this widget at any page. ',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.suggested-members',
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit',
          array(
              'label' => 'Enter limit of user that you want to show in this widgte.',
              'value' => 30,
          )
        ),
      )
    ),
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Member Profile User Info',
    'description' => 'This widget will display member profile of your website.',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.member-profile-user-info',
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Member Profile Photos',
    'description' => 'This widget will display photos on member profile of your website.',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.member-profile-photos',
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'paginationType',
            array(
                'label' => 'Do you want the photos to be auto-loaded when users scroll down the page?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No, show \'View More\''
                ),
                'value' => 1,
            )
        ),
        array(
          'Text',
          'limit',
          array(
              'label' => 'Enter limit of photos that you want to show in this widgte.',
              'value' => 30,
          )
        ),
      )
    ),
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Member Tagged Photos',
    'description' => 'This widget will display tagged photos on member profile of your website.',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.member-tagged-photos',
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'paginationType',
            array(
                'label' => 'Do you want the photos to be auto-loaded when users scroll down the page?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No, show \'View More\''
                ),
                'value' => 1,
            )
        ),
        array(
          'Text',
          'limit',
          array(
              'label' => 'Enter limit of photos that you want to show in this widgte.',
              'value' => 30,
          )
        ),
      )
    ),
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Explore People',
    'description' => 'This widget will display members of your website at the explore page. ',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.explore-people',
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit',
          array(
              'label' => 'Enter limit of user that you want to show in this widgte.',
              'value' => 30,
          )
        ),
      )
    ),
  ),
	array(
    'title' => 'SNS - Insta Clone Theme - Explore Posts',
    'description' => 'This widget will display posts of your website at the explore page. ',
    'category' => 'SNS - Insta Clone Theme',
    'type' => 'widget',
    'name' => 'einstaclone.explore-posts',
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'paginationType',
            array(
                'label' => 'Do you want the photos to be auto-loaded when users scroll down the page?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No, show \'View More\''
                ),
                'value' => 1,
            )
        ),
        array(
          'Text',
          'limit',
          array(
              'label' => 'Enter limit of photos that you want to show in this widgte.',
              'value' => 30,
          )
        ),
      )
    ),
  ),
);
