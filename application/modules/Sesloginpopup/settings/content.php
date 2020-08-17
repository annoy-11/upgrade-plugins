<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
		array(
    'title' => 'SES - Signin Signup Popup',
    'description' => 'This widget will display Signup Form & Signin Form in Popup on your website. This widget should be placed on Site Header Page.',
    'category' => 'SES - Advanced Signin & Signup Popup',
    'type' => 'widget',
    'name' => 'sesloginpopup.login-signup-popup',
    'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popupdesign',
                    array(
                        'label' => 'Choose the popup designs.',
                        'multiOptions'=>array('1'=>'Design 1','2'=>'Design 2','3'=>'Design 3','4'=>'Design 4','5'=>'Design 5','6'=>'Design 6','7'=>'Design 7','8'=>'Design 8','9'=>'Design 9','10'=>'Design 10'),
                        'value' => 1,
                    )
                ),
            ),
        ),
				),
				array(
    'title' => 'SES - Login Page',
    'description' => 'This widget will help your members to get Signed in on your website. The recommended page for this widget is Sign-In Page.',
    'category' => 'SES - Advanced Signin & Signup Popup',
    'type' => 'widget',
    'name' => 'sesloginpopup.login-page',
    'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'page',
                    array(
                        'label' => 'Choose the page designs.',
                        'multiOptions'=>array('1'=>'Page Design 1','2'=>'Page Design 2','3'=>'Page Design 3','4'=>'Page Design 4'),
                        'value' => 1,
                    )
                ),
            ),
        ),
				),
					array(
    'title' => 'SES - Signup Page',
    'description' => 'This widget will help your members to get Signup in on your website. The recommended page for this widget is Sign-Up Page.',
    'category' => 'SES - Advanced Signin & Signup Popup',
    'type' => 'widget',
    'name' => 'sesloginpopup.signup-page',
    'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'page',
                    array(
                        'label' => 'Choose the page designs.',
                        'multiOptions'=>array('1'=>'Page Design 1','2'=>'Page Design 2','3'=>'Page Design 3','4'=>'Page Design 4'),
                        'value' => 1,
                    )
                ),
            ),
        ),
  		),
);
