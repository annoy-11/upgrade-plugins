<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Verified Page Badge & Verify Page Button',
    'description' => 'This widget displayed the Verified Badge with the verification details and Verify button on the Page Profiles on your website. This widget must be placed on the “Page Profile” page on your website.',
    'category' => 'SES - Page Verification by Members Extension',
    'type' => 'widget',
    'name' => 'sespageveroth.verify-button-badge',
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
              'badge' => 'Verified Page Badge',
              'details' => 'Verification Details',
            ),
          )
        ),
      )
    )
  ),
);
