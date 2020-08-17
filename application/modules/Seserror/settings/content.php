<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Sign-in Required Page Image',
    'description' => 'This widget displays the background image for the “Sign-in Required Page” of your website.',
    'category' => 'SES - Private / Page Not Found',
    'type' => 'widget',
    'name' => 'seserror.auth-bg-image',
  ),
	 array(
    'title' => 'SES - Error - Exception Handling Page',
    'description' => 'This widget displays the Exception Handling Page for the website.',
    'category' => 'SES - Private / Page Not Found',
    'type' => 'widget',
    'name' => 'seserror.exception-handling',
  ),
  array(
    'title' => 'SES - Error - Coming Soon',
    'description' => 'This widget displays the design template on the Coming Soon page.',
    'category' => 'SES - Private / Page Not Found',
    'type' => 'widget',
    'name' => 'seserror.comingsoon',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'hidden',
            'nomobile',
            array(
                'label' => ''
            )
        ),
      )
    )
  ),
  array(
    'title' => 'SES - Error - Private Page',
    'description' => 'This widget displays the design template on the Private page.',
    'category' => 'SES - Private / Page Not Found',
    'type' => 'widget',
    'name' => 'seserror.private',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'showsearch',
          array(
            'label' => 'Enable Search?',
            'multiOptions' => array(
              "1" => "Yes",
              "0" => "No",
            ),
          ),
        ),
        array(
          'Select',
          'showhomebutton',
          array(
            'label' => 'Enable Home Button?',
            'multiOptions' => array(
              "1" => "Yes",
              "0" => "No",
            ),
          ),
        ),
        array(
          'Select',
          'showbackbutton',
          array(
            'label' => 'Show Back Button',
            'multiOptions' => array(
              "1" => "Yes",
              "0" => "No",
            ),
          ),
        ),
        array(
            'hidden',
            'nomobile',
            array(
                'label' => ''
            )
        ),
      )
    )
  ),
  array(
    'title' => 'SES - Error - Page Not Found',
    'description' => 'This widget displays the design template on the Page Not Found page.',
    'category' => 'SES - Private / Page Not Found',
    'type' => 'widget',
    'name' => 'seserror.pagenotfound',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'showsearch',
          array(
            'label' => 'Enable Search?',
            'multiOptions' => array(
              "1" => "Yes",
              "0" => "No",
            ),
          ),
        ),
        array(
          'Select',
          'showhomebutton',
          array(
            'label' => 'Enable Go Back Button?',
            'multiOptions' => array(
              "1" => "Yes",
              "0" => "No",
            ),
          ),
        ),
        array(
            'hidden',
            'nomobile',
            array(
                'label' => ''
            )
        ),
      )
    )
  ),
);