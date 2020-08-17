<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$banner_options[] = '';
$video[] = '';
$path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
foreach ($path as $file) {
  if ($file->isDot() || !$file->isFile())
    continue;
  $base_name = basename($file->getFilename());
  if (!($pos = strrpos($base_name, '.')))
    continue;
  $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
  if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
    $video['public/admin/' . $base_name] = $base_name;
  else
    $banner_options['public/admin/' . $base_name] = $base_name;

}

$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
$fileLink = $view->baseUrl() . '/admin/files/';

return array(
  array(
    'title' => 'SES - LinkedIn Clone Theme - Header',
    'description' => 'It Displays the header of your website. The recommended page is "Site Header".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.header',
  ),
  array(
    'title' => 'SES - LinkedIn Clone Theme - Footer',
    'description' => 'It Displays footer of your website. The recommended page is "Site Footer".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.footer',
  ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page',
    'description' => 'This widget shows the site landing page”. The recommended page for this widget is “Landing Page".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'leftsideimage',
          array(
              'label' => 'Choose the Image to be shown in this widget.',
              'multiOptions' => $banner_options,
              'value' => '',
          )
        ),
        array(
          'Text',
          'heading',
          array(
            'label' => 'Enter the heading text.',
            'value' => 'Welcome to SocialEngine! We\'re glad that you\'re here.',
          ),
        ),
        array(
          'Select',
          'search',
          array(
            'label' => 'Enable/disable search.',
            'multiOptions'=>array(
                1 => 'Yes',
                0 => 'No'
            )
          ),
        ),
      )
    ),
  ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Home Photo',
    'description' => 'This widget will display the total connections counts & total profile view counts for the logged in user. The recommended page is "Member Home Page".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.home-photo',
  ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Video',
    'description' => 'This widget will display the total connections counts & total profile view counts for the logged in user. The recommended page is "Member Home Page".',
    'name' => 'seslinkedin.landing-page-video',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
        'adminForm' => array(
            'elements' => array(
                 array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Enter the Title.',
                    ),
                ),
                 array(
                    'Text',
                    'description',
                    array(
                        'label' => 'Enter the Description.',
                    ),
                ),
                array(
                    'Radio',
                    'video_type',
                    array(
                        'label' => 'choose type of video',
                        'multiOptions'=>array(
                            'uploaded' => 'Use Uploaded video',
                            'embed' => 'Use Embed Code of video'
                        )
                    )
                ),

                array(
                    'Select',
                    'video',
                    array(
                        'label' => 'Choose the Video to show In this widget.',
                        'multiOptions'=>$video
                    )
                ),
                 array(
                    'Text',
                    'embedCode',
                    array(
                        'label' => 'Enter the Embed Code for the Video here.',
                    )
                ),
            ),
        ),
    ),
	 array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Categories',
    'description' => 'This widget displays jobs categories at the landing page.',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page-categories',
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'heading',
          array(
            'label' => 'Enter the text.',
            'value' => 'Connect with people who can help.',
          ),
        ),
      )
    ),
  ),
	 array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Features',
	'description' => 'It displays the featured sections at the landing page of your website. The recommended page is "Landing Page".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page-features',
    'adminForm' => array(
            'elements' => array(
                 array(
                    'Text',
                    'heading',
                    array(
                        'label' => 'Enter the heading text.',
                        'value' => 'Welcome to SocialEngine! We\'re glad that you\'re here.',
                    ),
                ),
                array(
                    'Select',
                    'fe1img',
                    array(
                        'label' => 'Choose the Feature - 1 Image.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                    'Text',
                    'fe1heading',
                    array(
                        'label' => 'Enter Feature - 1 Heading.',
                         'value' => 'Create An Account',
                    ),

                ),
                array(
                    'Text',
                    'fe1description',
                    array(
                        'label' => 'Enter Feature - 1 description.',
                         'value' => "Post a job to tell us about your project. We'll quickly match you with the right freelancers find place best.",
                    ),

                ),
                array(
                    'Select',
                    'fe2img',
                    array(
                        'label' => 'Choose the Feature - 2 Image.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                    'Text',
                    'fe2heading',
                    array(
                        'label' => 'Enter Feature - 2 Heading.',
                        'value' => 'Search Jobs',
                    ),

                ),
                array(
                    'Text',
                    'fe2description',
                    array(
                        'label' => 'Enter Feature - 2 description.',
                        'value' => "Post a job to tell us about your project. We'll quickly match you with the right freelancers find place best.",
                    ),

                ),
                array(
                    'Select',
                    'fe3img',
                    array(
                        'label' => 'Choose the Feature - 3 Image.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                    'Text',
                    'fe3heading',
                    array(
                        'label' => 'Enter Feature - 3 Heading.',
                        'value' => 'Save & Apply',
                    ),

                ),
                array(
                    'Text',
                    'fe3description',
                    array(
                        'label' => 'Enter Feature - 3 description.',
                         'value' => "Post a job to tell us about your project. We'll quickly match you with the right freelancers find place best.",
                    ),

                ),
            ),
        ),
    ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Post Job',
    'description' => 'It help site users to post new jobs directly from the landing page. The recommended page is "Landing Page".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page-post-job',
        'adminForm' => array(
            'elements' => array(
                 array(
                    'Text',
                    'heading',
                    array(
                        'label' => 'Enter the heading text.',
                        'value' => 'Post your job for millions of people to see.',
                    ),
                ),
                array(
                    'Text',
                    'buttonText',
                    array(
                        'label' => 'Enter the Button text.',
                        'value' => 'Post a job',
                    ),
                ),
                array(
                    'Text',
                    'buttonUrl',
                    array(
                        'label' => 'Enter the Url of the page to which you want your users get redirected after clicking on the button.'
                    ),
                ),
                array(
                    'Select',
                    'image',
                    array(
                        'label' => 'Choose the Image to be shown in this widget.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
            ),
        ),
    ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Members Jobs',
    'description' => 'It displays the jobs created by the users and help other users to get connected with them. The recommended page is "Landing Page".',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page-members-jobs',
    'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'fe1img',
                    array(
                        'label' => 'Choose the Feature Image for Section - 1.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                    'Text',
                    'fe1heading',
                    array(
                        'label' => 'Enter the heading text for Section - 1.',
                        'value' => 'Connect with people who can help.',
                    ),
                ),
                array(
                    'Text',
                    'fe1buttonText',
                    array(
                        'label' => 'Enter the Button text for Section - 1.',
                        'value' => 'Find People You Know',
                    ),
                ),
                array(
                    'Text',
                    'fe1buttonUrl',
                    array(
                        'label' => 'Enter the Url of the Page to which you want to redirect users when they click on Section - 1 button.',
                        'value' => '',
                    ),
                ),
                array(
                    'Select',
                    'fe2img',
                    array(
                        'label' => 'Choose the Feature Image for Section - 2.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                 array(
                    'Text',
                    'fe2heading',
                    array(
                        'label' => 'Enter the heading text for Section - 2.',
                        'value' => 'Find the Jobs you love to work.',
                    ),
                ),
                array(
                    'Text',
                    'fe2buttonText',
                    array(
                        'label' => 'Enter the Button text for Section - 2.',
                        'value' => 'Find Jobs You Love',
                    ),
                ),
                array(
                    'Text',
                    'fe2buttonUrl',
                    array(
                        'label' => 'Enter the Url of the Page to which you want to redirect users when they click on Section - 2 button.',
                        'value' => '',
                    ),
                ),
            ),
        ),
    ),
	array(
    'title' => 'SES - LinkedIn Clone Theme - Landing Page Bottom Banner',
    'description' => 'It displays Banner at the bottom of the Landing Page.',
    'category' => 'SES - LinkedIn Clone Theme',
    'type' => 'widget',
    'name' => 'seslinkedin.landing-page-bottom-banner',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'image',
          array(
              'label' => 'Choose the Image to be shown in this widget.',
              'multiOptions' => $banner_options,
              'value' => '',
          )
        ),
        array(
          'Text',
          'heading',
          array(
            'label' => 'Enter the text.',
            'value' => 'Connect with people who can help.',
          ),
        ),
         array(
          'Text',
          'buttonText',
          array(
            'label' => 'Enter the button text.',
            'value' => 'Get Started',
          ),
        ),
        array(
          'Text',
          'buttonUrl',
          array(
            'label' => 'Url of which page that page you want to open when user click button.',
            'value' => '',
          ),
        ),
      )
    ),
  ),
);
