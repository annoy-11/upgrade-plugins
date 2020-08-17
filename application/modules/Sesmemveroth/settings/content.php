<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Verified Member Badge & Verify Member Button',
    'description' => 'This widget displayed the Verified Badge with the verification details and Verify button on the Member Profiles on your website. This widget must be placed on the “Member Profile” page on your website.',
    'category' => 'SES - Members Verification by Other Members Plugin',
    'type' => 'widget',
    'name' => 'sesmemveroth.verify-button-badge',
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
              'badge' => 'Verified Member Badge',
              'details' => 'Verification Details',
            ),
          )
        ),
      )
    )
  ),
);
