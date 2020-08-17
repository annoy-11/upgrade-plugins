<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessveroth
 * @package    Sesbusinessveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Verified Business Badge & Verify Business Button',
    'description' => 'This widget displayed the Verified Badge with the verification details and Verify button on the Business Profiles on your website. This widget must be placed on the “Business Profile” business on your website.',
    'category' => 'SES - Business Verification by Members Extension',
    'type' => 'widget',
    'name' => 'sesbusinessveroth.verify-button-badge',
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
              'badge' => 'Verified Business Badge',
              'details' => 'Verification Details',
            ),
          )
        ),
      )
    )
  ),
);
