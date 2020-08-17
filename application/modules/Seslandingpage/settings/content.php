<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$results = Engine_Api::_()->getDbtable('featureblocks', 'seslandingpage')->getFeatureBlocks(array('params' => 1));
$designs = array();
foreach($results as $result) {
  $designs[$result->featureblock_id] = $result->title;
}

  $socialshare_enable_plusicon = array(
      'Select',
      'socialshare_enable_plusicon',
      array(
          'label' => "Enable More Icon for social share buttons?",
          'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
          ),
      )
  );
  $socialshare_icon_limit = array(
    'Text',
    'socialshare_icon_limit',
    array(
      'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
      'value' => 2,
    ),
  );

$memberWidgetPopularityCriteria = array(
  'Select',
  'popularitycriteria',
  array(
    'label' => 'Choose the popularity criteria in this widget.',
    'multiOptions' => array(
      'creation_date' => 'Recently Created',
      'modified_date' => 'Recently Modified',
      'view_count' => 'Most Viewed',
      'like_count' => 'Most Liked',
      'comment_count' => 'Most Commented',
      'member_count' => 'Most Friends',
      'random' => "Random Members",
    ),
  ),
);

$arrayGallery = array();
//if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("seslandingpage") && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslandingpage.pluginactivated')) {

  $moduleEnable = Engine_Api::_()->seslandingpage()->getModulesEnable();

  $images[] = '';
  $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
  foreach ($path as $file) {
    if ($file->isDot() || !$file->isFile())
      continue;
    $base_name = basename($file->getFilename());
    if (!($pos = strrpos($base_name, '.')))
      continue;
    $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
    if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
      continue;
    $images['public/admin/' . $base_name] = $base_name;
  }

//}

return array(

	// Design 1 Widgets
	array(
    'title' => 'Custom Design 1',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design1-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 1',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design1-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'title' => 'Title',
              'description' => "Description",
              'location' => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        //Block 1
        array(
          'Text',
          'block1title',
          array(
            'label' => 'Block - 1 Title',
          )
        ),
        array(
          'Text',
          'block1url',
          array(
            'label' => 'Block - 1 URL',
          )
        ),
        array(
          'Select',
          'block1bgimage',
          array(
            'label' => 'Choose the block - 1 Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        //Block 2
        array(
          'Text',
          'block2title',
          array(
            'label' => 'Block - 2 Title',
          )
        ),
        array(
          'Text',
          'block2url',
          array(
            'label' => 'Block - 2 URL',
          )
        ),
        array(
          'Select',
          'block2bgimage',
          array(
            'label' => 'Choose the block - 2 Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        //Block 3
        array(
          'Text',
          'block3title',
          array(
            'label' => 'Block - 3 Title',
          )
        ),
        array(
          'Text',
          'block3url',
          array(
            'label' => 'Block - 3 URL',
          )
        ),
        array(
          'Select',
          'block3bgimage',
          array(
            'label' => 'Choose the block - 3 Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
      ),
    ),
	),

	array(
    'title' => 'Content Design 2',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design1-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'ownerphoto' => 'Owner Photo',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
              'description' => "Description",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 3',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design1-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title'
            ),
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 4',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design1-widget6',
    'autoEdit' => true,
	),

	// Design 2 Widgets
	array(
    'title' => 'Content Design 5',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design2-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'leftsideheading',
          array(
            'label'=>'Enter Heading for Left Side Block',
          )
        ),
        array(
          'Text',
          'leftsidedescription',
          array(
            'label'=>'Enter Description for Left Side Block',
          )
        ),
        array(
          'Text',
          'leftsidereadmoretext',
          array(
            'label'=>'Enter read More Text for Left Side Block',
          )
        ),
        array(
          'Text',
          'leftsidereadmoreurl',
          array(
            'label'=>'Enter read More url for Left Side Block',
          )
        ),
        array(
          'Text',
          'leftsidefonticon',
          array(
            'label'=>'Enter Font Icon for Left Side Block (ex: fa-music)',
          )
        ),
        array(
          'Select',
          'leftsideresourcetype',
          array(
              'label' => 'Choose the Module to be shown in this widget for left side block.',
              'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'leftsidepopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for left side block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'rightsideheading',
          array(
            'label'=>'Enter Heading for right Side Block',
          )
        ),
        array(
          'Text',
          'rightsidedescription',
          array(
            'label'=>'Enter Description for right Side Block',
          )
        ),
        array(
          'Text',
          'rightsidereadmoretext',
          array(
            'label'=>'Enter read More Text for right Side Block',
          )
        ),
        array(
          'Text',
          'rightsidereadmoreurl',
          array(
            'label'=>'Enter read More url for right Side Block',
          )
        ),
        array(
          'Text',
          'rightsidefonticon',
          array(
            'label'=>'Enter Font Icon for right Side Block (ex: fa-music)',
          )
        ),
        array(
          'Select',
          'rightsideresourcetype',
          array(
              'label' => 'Choose the Module to be shown in this widget for right side block.',
              'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'rightsidepopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for right side block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
      ),
    ),

	),
	array(
    'title' => 'Custom Design 2',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design2-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Text',
          'videourl',
          array(
            'label'=>'Enter video url of any source ex: youtube, vimeo',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 6',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design2-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'heading',
          array(
            'label'=>'Enter Short heading',
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
              'category' => "Category",
            ),
            'escape' => false,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 7',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design2-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              'showoverlay' => "Show Overlay on mouse-over",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 1',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design2-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'loginbutton',
          array(
              'label' => 'Do you want to show login button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
        array(
          'Select',
          'signupbutton',
          array(
              'label' => 'Do you want to show singup button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
      ),
    ),
	),


	// Design 3 Widgets
	array(
    'title' => 'Content Design 8',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              //'ownername' => 'Owner Name',
              'title' => 'Title',
              "category" => "Category",
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label'=>'Enter number of content to be shown in this widget',
            "value" => 3,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Custom Design 3 ',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 9',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'bgimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'leftsidefonticon',
          array(
            'label'=>'Enter Font Icon for left Side above content (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label'=>'Enter Right Button Text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label'=>'Enter Right Side Button URL',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 10',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'description' => "Description",
              "category" => "Category",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 11',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'leftsidefonticon',
          array(
            'label'=>'Enter Font Icon for left Side (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label'=>'Enter Right Button Text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label'=>'Enter Right Side Button URL',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 2',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design3-widget7',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'tabtitle1',
          array(
            'label' => 'Enter Tab 1 Title.',
          )
        ),
        array(
          'Select',
          'popularitycriteria1',
          array(
            'label' => 'Choose the popularity criteria in this widget for tab 1.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'modified_date' => 'Recently Modified',
              'view_count' => 'Most Viewed',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'member_count' => 'Most Friends',
              'random' => "Random Members",
            ),
          ),
        ),
        array(
          'Text',
          'limit1',
          array(
            'label' => 'Count (number of members to show in tab 1).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
          'Text',
          'tabtitle2',
          array(
            'label' => 'Enter Tab 2 Title.',
          )
        ),
        array(
          'Select',
          'popularitycriteria2',
          array(
            'label' => 'Choose the popularity criteria in this widget for tab 2.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'modified_date' => 'Recently Modified',
              'view_count' => 'Most Viewed',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'member_count' => 'Most Friends',
              'random' => "Random Members",
            ),
          ),
        ),
        array(
          'Text',
          'limit2',
          array(
            'label' => 'Count (number of members to show in tab 2).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
          'Text',
          'tabtitle3',
          array(
            'label' => 'Enter Tab 3 Title.',
          ),
        ),
        array(
          'Select',
          'popularitycriteria3',
          array(
            'label' => 'Choose the popularity criteria in this widget for tab 3.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'modified_date' => 'Recently Modified',
              'view_count' => 'Most Viewed',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'member_count' => 'Most Friends',
              'random' => "Random Members",
            ),
          ),
        ),
        array(
          'Text',
          'limit3',
          array(
            'label' => 'Count (number of members to show in tab 3).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),


	// Design 4 Widgets
	array(
    'title' => 'Custom Design 4',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design4-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
			array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
			'title' => 'Design 4 Widget 3',
			'description' => 'This widget displays custom featured blocks with the content in the design of your choice from the available templates. Edit this widget to configure the settings.',
			'category' => 'SES - Custom/Content/Members Widget Collection',
			'type' => 'widget',
			'name' => 'seslandingpage.design4-widget3',
			'autoEdit' => true,
	),
	array(
    'title' => 'Content Design 12',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design4-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'heading',
          array(
            'label'=>'Enter Heading',
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label'=>'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label'=>'Enter see all button url',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'category' => "Category",
            ),
            'escape' => false,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 3',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design4-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'loginbutton',
          array(
              'label' => 'Do you want to show login button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
        array(
          'Select',
          'signupbutton',
          array(
              'label' => 'Do you want to show singup button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 13',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design4-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              'showoverlay' => "Show Overlay on mouse-over",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),


	// Design 5 Widgets
	array(
    'title' => 'Content Design 14',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design5-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 15',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design5-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 16',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design5-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Enter Content limit.',
            'value' => 3,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 17',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design5-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label' => 'Enter font icon above the content ex:fa-music',
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 6,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 4',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design5-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 8,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),


	// Design 6 Widgets
	array(
    'title' => 'Custom Design 5',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design6-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 18',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design6-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Text',
          'leftsideheading',
          array(
            'label' => 'Enter left side heading text',
          )
        ),
        array(
          'Select',
          'leftresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget for left side block.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'leftpopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for left side block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'leftsidefonticon',
          array(
            'label' => 'Enter font icon above the content for left side block ex:fa-music',
          )
        ),
        array(
          'Text',
          'leftseeallbuttontext',
          array(
            'label' => 'Enter see all button text for left side block',
          )
        ),
        array(
          'Text',
          'leftseeallbuttonurl',
          array(
            'label' => 'Enter see all button url for left side block',
          )
        ),

        array(
          'Text',
          'rightsideheading',
          array(
            'label' => 'Enter right side heading text',
          )
        ),
        array(
          'Select',
          'rightresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget for right side block.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'rightpopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for right side block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'rightsideshowstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'rightseeallbuttontext',
          array(
            'label' => 'Enter see all button text for right side block',
          )
        ),
        array(
          'Text',
          'rightseeallbuttonurl',
          array(
            'label' => 'Enter see all button url for right side block',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 19',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design6-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              'category' => "Category",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
//         array(
//           'Text',
//           'limit',
//           array(
//             'label' => 'Count (number of members to show).',
//             'value' => 6,
//             'validators' => array(
//                 array('Int', true),
//                 array('GreaterThan', true, array(0)),
//             ),
//           ),
//         ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 20',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design6-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
            'Select',
            'resourcetype',
            array(
                'label' => 'Choose the Module to be shown in this widget.',
                'multiOptions' => $moduleEnable,
            )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label' => 'Enter font icon above the content ex:fa-music',
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 6,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 5',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design6-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        $memberWidgetPopularityCriteria,
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 8,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),

	// Design 7 Widgets
	array(
    'title' => 'Custom Design 6',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design7-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 21',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design7-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 22',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design7-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter short description.',
          )
        ),
        array(
          'Text',
          'seeallbuttontext',
          array(
            'label' => 'Enter see all button text',
          )
        ),
        array(
          'Text',
          'seeallbuttonurl',
          array(
            'label' => 'Enter see all button url',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 23',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design7-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Text',
          'firstblockheading',
          array(
            'label'=>'Enter Heading for first block',
          )
        ),
        array(
          'Select',
          'firstblockresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget for first block.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'firstblockpopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for first block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'firstblockshowstats',
          array(
            'label' => 'Show Statistics for first block.',
            'multiOptions' => array(
              'ownername' => 'Owner Name',
              'rightsideicon' => 'Right Side Font Icon',
              'title' => "Title",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'firstblockfonticon',
          array(
            'label'=>'Enter Font Icon for first block (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'firstblocklimit',
          array(
            'label' => 'Count (number of content to show for first block).',
            'value' => 4,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
          'Text',
          'secondblockheading',
          array(
            'label'=>'Enter Heading for second block',
          )
        ),
        array(
          'Select',
          'secondblockresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget for second block.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'secondblockpopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for second block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'secondblockshowstats',
          array(
            'label' => 'Show Statistics for second block.',
            'multiOptions' => array(
              'ownername' => 'Owner Name',
              'rightsideicon' => 'Right Side Font Icon',
              'title' => "Title",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'secondblockfonticon',
          array(
            'label'=>'Enter Font Icon for second block (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'secondblocklimit',
          array(
            'label' => 'Count (number of content to show for second block).',
            'value' => 4,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
          'Text',
          'thirdblockheading',
          array(
            'label'=>'Enter Heading for third block',
          )
        ),
        array(
          'Select',
          'thirdblockresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget for third block.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'thirdblockpopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget for third block.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'thirdblockshowstats',
          array(
            'label' => 'Show Statistics for third block.',
            'multiOptions' => array(
              'ownername' => 'Owner Name',
              'rightsideicon' => 'Right Side Font Icon',
              'title' => "Title",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'thirdblockfonticon',
          array(
            'label'=>'Enter Font Icon for third block (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'thirdblocklimit',
          array(
            'label' => 'Count (number of content to show for third block).',
            'value' => 4,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 6',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design7-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        $memberWidgetPopularityCriteria,
        array(
          'Select',
          'loginbutton',
          array(
              'label' => 'Do you want to show login button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
        array(
          'Select',
          'signupbutton',
          array(
              'label' => 'Do you want to show singup button',
              'multiOptions' => array('1' => "Yes", "0" => "No"),
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 26,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),

	// Design 8 Widgets
	array(
    'title' => 'Custom Design 7',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 24',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label'=>'Enter Font Icon for Left Side content (ex: fa-music)',
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of contents to show).',
            'value' => 12,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 25',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'ownername' => 'Owner Name',
              'description' => "Description",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label'=>'Enter Font Icon for Left Side content (ex: fa-music)',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 26',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "readmorebutton" => "Read More Button",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'readmorebuttontext',
          array(
            'label' => 'Enter read more button text',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 27',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "readmorebutton" => "Read More Button",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'readmorebuttontext',
          array(
            'label' => 'Enter read more button text',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 7',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design8-widget7',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        $memberWidgetPopularityCriteria,
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),



	// Design 9 Widgets
	array(
    'title' => 'Custom Design 8',
    'description' => 'This widget displays custom Featured Blocks with content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design9-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    )
	),
	array(
    'title' => 'Content Design 28',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design9-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Text',
          'leftsideheading',
          array(
            'label'=>'Enter Heading for Left Side Block',
          )
        ),
        array(
          'Text',
          'leftsidedescription',
          array(
            'label'=>'Enter Description for Left Side Block',
          )
        ),
        array(
          'Select',
          'leftsideresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'leftsidepopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'leftsidefonticon',
          array(
            'label' => 'Enter font icon for left side block',
          )
        ),
        array(
          'Text',
          'leftsideseeallbuttontext',
          array(
            'label' => 'Enter see all button text for left side block',
          )
        ),
        array(
          'Text',
          'leftsideseeallbuttonurl',
          array(
            'label' => 'Enter see all button url for left side block',
          )
        ),
        array(
          'Text',
          'leftsidelimit',
          array(
            'label' => 'Count (number of content to show for left side block).',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),


        array(
          'Text',
          'rightsideheading',
          array(
            'label'=>'Enter Heading for right Side Block',
          )
        ),
        array(
          'Text',
          'rightsidedescription',
          array(
            'label'=>'Enter Description for right Side Block',
          )
        ),
        array(
          'Select',
          'rightsideresourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'rightsidepopularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'rightsidefonticon',
          array(
            'label' => 'Enter font icon for right side block',
          )
        ),
        array(
          'Text',
          'rightsideseeallbuttontext',
          array(
            'label' => 'Enter see all button text for right side block',
          )
        ),
        array(
          'Text',
          'rightsideseeallbuttonurl',
          array(
            'label' => 'Enter see all button url for right side block',
          )
        ),
        array(
          'Text',
          'rightsidelimit',
          array(
            'label' => 'Count (number of content to show for right side block).',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 29',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design9-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'readmorebuttontext',
          array(
            'label' => 'Enter read more button text',
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 30',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design9-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'likecount' => 'Like Count',
              'viewcount' => 'View Count',
              'commentcount' => 'Comment Count',
              'favouritecount' => 'Favourite Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ratingcount' => 'Rating Count [This will show when SocialEngineSolutions Plugin installed on your site.]',
              'ownername' => 'Owner Name',
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "category" => "Category",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	//Landing Page
	array(
    'title' => 'SES - Custom/Content/Members Widget Collection',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.landing-page',
    'autoEdit' => true,
	),

	// Design 10 Widgets
	array(
    'title' => 'Content Design 31',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design10-widget2',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter Description of this widget.',
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label'=>'Enter Font Icon for above content (ex: fa-music)',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 32',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design10-widget3',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter Description of this widget.',
          )
        ),
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $images,
            'value' => '',
          )
        ),
        array(
          'Text',
          'fonticon',
          array(
            'label'=>'Enter Font Icon for above content (ex: fa-music)',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 33',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design10-widget4',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter Description of this widget.',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
              "category" => "Category",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
	),
	array(
    'title' => 'Members Design 8',
    'description' => 'This widget displays members in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design10-widget5',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter Description of this widget.',
          )
        ),
        $memberWidgetPopularityCriteria,
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of members to show).',
            'value' => 7,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	array(
    'title' => 'Content Design 34',
    'description' => 'This widget displays content in design of your choice from the available templates. Edit this widget to configure the settings.',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.design10-widget6',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter Description of this widget.',
          )
        ),
        array(
          'Select',
          'resourcetype',
          array(
            'label' => 'Choose the Module to be shown in this widget.',
            'multiOptions' => $moduleEnable,
          )
        ),
        array(
          'Select',
          'popularitycriteria',
          array(
            'label' => 'Choose the popularity criteria in this widget.',
            'multiOptions' => array(
              'creation_date' => 'Recently Created',
              'view_count' => 'View Count',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Modified'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showstats',
          array(
            'label' => 'Show Statistics.',
            'multiOptions' => array(
              'title' => 'Title',
              'creationdate' => 'Creation Date',
              'description' => "Description",
              "location" => "Location [This will show when SocialEngineSolutions Plugin installed on your site.]",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'descriptiontruncation',
          array(
            'label' => 'Description truncation limit.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of content to show in this widget).',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
      ),
    ),
	),
	// Intro Section
	array(
    'title' => 'Intro Block',
    'description' => 'Intro Block',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.intro',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'heading',
          array(
            'label'=>'Enter Short Heading',
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
				array(
					'Select',
					'backgroundimage',
					array(
						'label' => 'Choose The Side Image.',
						'multiOptions' => $banner_options,
						'value' => '',
					)
				),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
        array(
          'Select',
          'design_id',
          array(
            'label' => 'Choose Design.',
            'multiOptions' => array(
							'1'=>'Design 1',
							'2'=>'Design 2'
						),
          )
        ),
        array(
          'Text',
          'buttontitle',
          array(
            'label'=>'Enter Buttom Title [This setting will work then you choose Design - 1]',
          )
        ),
        array(
          'Text',
          'buttonurl',
          array(
            'label'=>'Enter Buttom URL [This setting will work then you choose Design - 1]',
          )
        ),
      ),
    ),
	),
	// Features
	array(
    'title' => 'Features Block',
    'description' => 'Features Block',
    'category' => 'SES - Custom/Content/Members Widget Collection',
    'type' => 'widget',
    'name' => 'seslandingpage.features',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Short Description',
          )
        ),
        array(
          'Select',
          'featureblock_id',
          array(
            'label' => 'Choose feature block.',
            'multiOptions' => $designs,
          )
        ),
      ),
    ),
	),
	// Counters
  array(
		'title' => 'Counters',
		'description' => '.',
		'category' => 'SES - Custom/Content/Members Widget Collection',
		'type' => 'widget',
		'name' => 'seslandingpage.counters',
		'autoEdit' => false,
		'adminForm' => array(
			'elements' => array(
				array(
					'Select',
					'backgroundimage',
					array(
						'label' => 'Choose the Background Image to be shown in this widget.',
						'multiOptions' => $banner_options,
						'value' => '',
					)
				),
				array(
					'Text',
					'counter1',
					array(
						'label' => 'Enter Counter - 1 Value.',
					),
					'value' => '500',
				),
				array(
					'Text',
					'counter1text',
					array(
						'label' => 'Enter Counter - 1 Text.',
					),
					'value' => 'Members',
				),
				array(
					'Text',
					'counter2',
					array(
						'label' => 'Enter Counter - 2 Value.',
					),
					'value' => '9',
				),
				array(
					'Text',
					'counter2text',
					array(
						'label' => 'Enter Counter - 2 Text.',
					),
					'value' => 'Year',
				),
				array(
					'Text',
					'counter3',
					array(
						'label' => 'Enter Counter - 3 Value.',
					),
					'value' => '25',
				),
				array(
					'Text',
					'counter3text',
					array(
						'label' => 'Enter Counter - 3 Text.',
					),
					'value' => 'Clients',
				),
				array(
					'Text',
					'counter4',
					array(
						'label' => 'Enter Counter - 4 Value.',
					),
					'value' => '25',
				),
				array(
					'Text',
					'counter4text',
					array(
						'label' => 'Enter Counter - 4 Text.',
					),
					'value' => 'Clients',
				),
			),
		),
	),
  array(
		'title' => 'Mobile App',
		'description' => 'Mobile App',
		'category' => 'SES - Custom/Content/Members Widget Collection',
		'type' => 'widget',
		'name' => 'seslandingpage.mobile-app',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'heading',
          array(
            'label'=>'Enter Heading',
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label'=>'Enter Description',
          )
        ),
				array(
					'Select',
					'slideimage',
					array(
						'label' => 'Choose the side image for the bigger image block.',
						'multiOptions' => $banner_options,
						'value' => '',
					)
				),
				array(
					'Select',
					'backgroundimage',
					array(
						'label' => 'Choose the background image for the widget.',
						'multiOptions' => $banner_options,
						'value' => '',
					)
				),
        array(
          'Text',
          'height',
          array(
            'label'=>'Enter the height of the banner (in px).',
          ),
        ),
        array(
          'Text',
          'buttonurl1',
          array(
            'label'=>'Enter the URL for iOS App Button.',
          ),
        ),
        array(
          'Text',
          'buttonurl2',
          array(
            'label'=>'Enter the URL for Android App Button.',
          ),
        ),
      ),
    ),
  ),
  array(
		'title' => 'Language',
		'description' => 'Language',
		'category' => 'SES - Custom/Content/Members Widget Collection',
		'type' => 'widget',
		'name' => 'seslandingpage.language',
		'adminForm' => array(
			'elements' => array(
				array(
					'Select',
					'backgroundimage',
					array(
						'label' => 'Choose the Background Image to be shown in this widget.',
						'multiOptions' => $banner_options,
						'value' => '',
					)
				),
			),
		),
  ),
);
