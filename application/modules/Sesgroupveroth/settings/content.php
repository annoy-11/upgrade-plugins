<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Verified Group Badge & Verify Group Button',
    'description' => 'This widget displayed the Verified Badge with the verification details and Verify button on the Group Profiles on your website. This widget must be placed on the “Group Profile” group on your website.',
    'category' => 'SES - Group Verification by Members Extension',
    'type' => 'widget',
    'name' => 'sesgroupveroth.verify-button-badge',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'showdetails',
          array(
            'label' => "Choose from the details to be shown in this widget.",
            'multiOptions' => array(
              'button' => 'Verify Button',
              'badge' => 'Verified Group Badge',
              'details' => 'Verification Details',
            ),
          )
        ),
      )
    )
  ),
);
