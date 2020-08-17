<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SES - Business Team - Site / Non-Site Team Members with Template Choice',
    'description' => 'Displays site / non-site team members. You can choose a template design to show team members in this widget.',
    'category' => 'SES - Business Team Showcase Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesbusinessteam.team',
    'adminForm' => 'Sesbusinessteam_Form_Admin_TeamWidgetSettings',
  ),
  array(
    'title' => 'SES - Business Team - Site / Non-Site Team Member Details',
    'description' => 'This widget displays all details of a site / non-site team member.The recommended business for this widget is "SES - Business Team Showcase Extension - Business Team Profile Business".',
    'category' => 'SES - Business Team Showcase Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesbusinessteam.viewbusiness-team',
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
