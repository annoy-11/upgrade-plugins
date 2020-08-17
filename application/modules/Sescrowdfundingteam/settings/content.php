<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SES - Crowdfunding Team - Site / Non-Site Team Members with Template Choice',
    'description' => 'Displays site / non-site team members. You can choose a template design to show team members in this widget.',
    'category' => 'SES - Crowdfunding Team Showcase Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfundingteam.team',
    'adminForm' => 'Sescrowdfundingteam_Form_Admin_TeamWidgetSettings',
  ),
  array(
    'title' => 'SES - Crowdfunding Team - Site / Non-Site Team Member Details',
    'description' => 'This widget displays all details of a site / non-site team member.The recommended page for this widget is "SES - Crowdfunding Team Showcase Extension - Crowdfunding Team Profile Crowdfunding".',
    'category' => 'SES - Crowdfunding Team Showcase Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfundingteam.viewcrowdfunding-team',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'infoshow',
          array(
            'label' => 'Choose from below the details that you want to show in this widget.',
            'multiOptions' => array(
              'profilePhoto' => "Profile Photo",
              'displayname' => 'Display Name',
              'designation' => 'Designation',
              'detaildescription' => 'About Member (Detailed Description)',
              'email' => 'Email',
              'phone' => 'Phone',
              'location' => 'Location',
              'website' => 'Website',
              'facebook' => 'Facebook Icon',
              'linkdin' => 'LinkedIn Icon',
              'twitter' => 'Twitter Icon',
              'googleplus' => 'Google Plus Icon'
            ),
          ),
        ),
        array(
          'Text',
          'descriptionText',
          array(
            'label' => 'Enter the text for "Description"',
          ),
          'value' => 'more',
        ),
      )
    ),
  ),
);
