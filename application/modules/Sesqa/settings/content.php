<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
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
  $banner_options[] = '';
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
  $banner_options['public/admin/' . $base_name] = $base_name;
}

$setting = Engine_Api::_()->getApi('settings', 'core');
$categories = array();
if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesqa') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.pluginactivated')){
$categories = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoriesAssoc();
  if( count($categories) > 0 &&  $setting->getSetting('qanda.allow.category','1')) {
    $categories = array(''=>'')+$categories;
}
}

$seslocation = array();
if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslocation')){
  $seslocation = array(
    'Select',
    'locationEnable',
    array(
      'label' =>  Engine_Api::_()->seslocation()->getWidgetText('sesqa'),
      'multiOptions'=>array('1'=>'Yes','0'=>'No'),
      'value'=>0
    ),
  );
}

return array(
   array(
    'title' => 'Questions - Tabbed Widget',
    'description' => 'Displays Question Answers in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.tabbed-widget',
    'adminForm' => 'Sesqa_Form_Admin_Tabbed',
    'autoEdit' => true,
   ),
   array(
    'title' => 'Questions - Browse Widget',
    'description' => 'Displays Question Answers in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.browse-widget',
    'adminForm' => 'Sesqa_Form_Admin_Browse',
    'autoEdit' => true,
   ),
   array(
    'title' => 'Question- Alphabetic Filtering of Questions',
    'description' => 'Displays alphabet search in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.alphabet-search',
    'autoEdit' => false,
   ),
   array(
    'title' => 'Questions - Create New Question Link',
    'description' => 'Displays a link to create new question.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
   array(
    'title' => 'Questions - Questions Status',
    'description' => 'Displays Question Answers in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.question-status',
    'autoEdit' => true,
    'adminForm' => 'Sesqa_Form_Admin_Questionstatus',
   ),
    array(
    'title' => 'Questions - Manage Page Tabbed Widget',
    'description' => 'Displays Question Answers in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.manage-tabbed-widget',
    'adminForm' => 'Sesqa_Form_Admin_Managetabbed',
    'autoEdit' => true,
   ),
   array(
    'title' => 'Questions - Profile Widget',
    'description' => 'Displays Question Answers in the browse pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.profile-widget',
    'adminForm' => 'Sesqa_Form_Admin_Profile',
    'autoEdit' => true,
    'defaultParams' => array(
      'title' => 'Questions',
      'titleCount' => true,
    ),
   ),
    array(
    'title' => 'Questions - Browse All Question Tags',
    'description' => 'Displays all Questions tags on your website. The recommended page for this widget is "SES Q&A - Browse Tags Page".',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.tag-qa',
  ),
  array(
      'title' => 'Questions - Tags Cloud / Tab View',
      'description' => 'Displays all tags of Questions in cloud or tab view. Edit this widget to choose various other settings.',
      'category' => 'SES - Questions & Answers Plugin',
      'type' => 'widget',
      'name' => 'sesqa.tag-cloud-qa',
      'autoEdit' => true,
      'adminForm' => 'Sesqa_Form_Admin_Tagcloudqa',
  ),
   array(
        'title' => 'Questions - Question Browse Search',
        'description' => 'Displays a search form in the question  browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Questions & Answers Plugin',
        'type' => 'widget',
        'name' => 'sesqa.browse-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(

                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical'
                        ),
                        'value' => 'vertical',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'search_type',
                    array(
                        'label' => "Choose options to be shown in 'Browse By' search fields.",
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Recently Created',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPvoted' => 'Most Voted',
                            'mostSPfavourite' => 'Most Favourite',
                            'homostSPanswered' => 'Most Answered',
                            'unanswered'=>'Unanswered',
                            'featured'=>'Featured',
                            'sponsored'=>'Sponsored',
                            'verified'=>'Verified',
                            'hot'=>'Hot',
                            'new'=>'New',
                        ),
                    )
                ),
                array(
                    'Select',
                    'default_search_type',
                    array(
                        'label' => "Default 'Browse By' search fields.",
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Recently Created',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPvoted' => 'Most Voted',
                            'mostSPfavourite' => 'Most Favourite',
                            'homostSPanswered' => 'Most Answered',
                            'unanswered'=>'Unanswered',
                            'featured'=>'Featured',
                            'sponsored'=>'Sponsored',
                            'verified'=>'Verified',
                            'hot'=>'Hot',
                            'new'=>'New',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'friend_show',
                    array(
                        'label' => "Show 'View' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'search_startendtime',
                    array(
                        'label' => "Show 'Choose Date Range' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'search_title',
                    array(
                        'label' => "Show 'Search Question Keyword' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Text',
                    'searchboxwidth',
                    array(
                        'label' => "Enter the width of 'Search Question Keyword' field (in pixels).",
                        'value' => '170',
                    )
                ),
                array(
                    'Radio',
                    'browse_by',
                    array(
                        'label' => "Show 'Browse By' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'categories',
                    array(
                        'label' => "Show 'Categories' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'location',
                    array(
                        'label' => "Show 'Location' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'kilometer_miles',
                    array(
                        'label' => "Show 'Kilometer or Miles' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
            )
        ),

   ),
   array(
    'title' => 'Questions - Details & Options',
    'description' => 'Displays Single Question page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.view-page',
    'autoEdit' => true,
    'adminForm' => 'Sesqa_Form_Admin_Viewpage',
  ),

  array(
    'title' => 'Questions - People Who Acted on This Question',
    'description' => 'Displays people reacted on this question placed on question view page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.people-acted',
    'adminForm' => 'Sesqa_Form_Admin_Peopleacted',
    'autoEdit' => true,
  ),
  array(
    'title' => 'Questions Profile - Tags',
    'description' => 'Displays question tags on question view page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.question-tags',
    'autoEdit' => false,
  ),
  array(
    'title' => 'Questions Profile - Post a Similar Questions',
    'description' => 'Post a similar question placed on question view page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.question-similar',
    'autoEdit' => false,
  ),
  array(
    'title' => 'Questions Profile - Other Questions From Owner',
    'description' => 'Displays Other Questions From Owner placed on question view page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.other-questions',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array(
            array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'itemPhoto' => 'Question Photo',
                        'title'=>'Title of Question',
                        'favBtn' => 'Favourite Button',
                        'followBtn' => 'Follow Button',
                        'likeBtn' => 'Like Button',
                        'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        'location'=>'Location',
                        'date' => 'Date',
                        'tags' => 'Tags',
                        'owner' => 'Owner',
                        'category' => 'Category',
                        'vote' => 'Vote Counts',
                        'answerCount' => 'Answer Counts',
                        'view' => 'View Counts',
                        'comment'=>'Comment Count',
                        'favourite'=>'Favourite Count',
                        'follow'=>'Follow Count',
                        'like'=>'Like Count',
                        'featuredLabel'=>'Featured Label',
                        'sponsoredLabel' =>'Sponsored Label',
                        'verifiedLabel'=>'Verified Label',
                        'hotLabel'=>'Hot Label',
                        'newLabel'=>'New Label',
                    ),
                    'escape' => false,
                )
            ),
            array('Select', 'category_id', array(
              'label' => 'Category',
              'multiOptions' => $categories,
              'allowEmpty' => true,
              'required' => false,
              )
            ),
            $seslocation,
            $socialshare_enable_plusicon,
            $socialshare_icon_limit,
            array(
                'Text',
                'title_truncation',
                array(
                    'label' => 'Question title truncation limit.',
                    'value' => 45,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter the height of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of question to show.)',
                    'value' => 20,
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
    'title' => 'Questions  - Similar Questions',
    'description' => 'Displays Related Questions.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.related-questions',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array(
            array(
                'Select',
                'criteria',
                array(
                    'label' => "Choose the criteria based on which Questions will be shown in this widget.",
                    'multiOptions' => array(
                      'sameTag'=>'Same Tags',
                      'sameCategory' => 'Same Categories',
                    ),
                    'value' =>'sameCategory'
                )
            ),
            array(
                'Select',
                'contentCriteria',
                array(
                    'label' => "Choose criteria for Questions to be show in this widget.",
                    'multiOptions' => array(
                      '' => 'All',
                      '0' => 'Open',
                      '1' => 'Closed',
                    ),
                    'value' =>'all',
                )
            ),
            array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'itemPhoto' => 'Question Photo',
                        'title'=>'Title of Question',
                        'favBtn' => 'Favourite Button',
                        'followBtn' => 'Follow Button',
                        'likeBtn' => 'Like Button',
                        'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        'location'=>'Location',
                        'date' => 'Date',
                        'tags' => 'Tags',
                        'owner' => 'Owner',
                        'category' => 'Category',
                        'vote' => 'Vote Counts',
                        'answerCount' => 'Answer Counts',
                        'view' => 'View Counts',
                        'comment'=>'Comment Count',
                        'favourite'=>'Favourite Count',
                        'follow'=>'Follow Count',
                        'like'=>'Like Count',
                        'featuredLabel'=>'Featured Label',
                        'sponsoredLabel' =>'Sponsored Label',
                        'verifiedLabel'=>'Verified Label',
                        'hotLabel'=>'Hot Label',
                        'newLabel'=>'New Label',
                    ),
                    'escape' => false,
                )
            ),
            $socialshare_enable_plusicon,
            $socialshare_icon_limit,
            array(
                'Text',
                'title_truncation',
                array(
                    'label' => 'Question title truncation limit.',
                    'value' => 45,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter the height of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of question to show.)',
                    'value' => 20,
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
    'title' => 'SES Stats - Side Widget',
    'description' => 'Displays Stats.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.stats',
    'autoEdit'=>true,
    'adminForm' => array(
      'elements' => array(
          array(
              'MultiCheckbox',
              'show_criteria',
              array(
                  'label' => "Choose from below the details that you want to show in this widget.",
                  'multiOptions' => array(
                      'totalQuestions' => 'Owner Photo',
                      'totalAnswers' => 'Owner Title',
                      'totalBestAnswers' => 'Total Asked Question Counts',
                  )
              ),
          ),
       ),
    ),
  ),
   array(
    'title' => 'SES Recently Viewed Questions - Side Widget',
    'description' => 'Displays Recently Viewed Questions',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.recently-viewed-questions',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array(
            array(
                'Select',
                'criteria',
                array(
                    'label' => 'Display Criteria',
                    'multiOptions' =>
                    array(
                        'by_me' => 'Viewed By logged-in member',
                        'by_myfriend' => 'Viewed By logged-in member\'s friend',
                        'on_site' => 'Viewed by all members of website'
                    ),
                ),
            ),
            array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'itemPhoto' => 'Question Photo',
                        'title'=>'Title of Question',
                        'favBtn' => 'Favourite Button',
                        'followBtn' => 'Follow Button',
                        'likeBtn' => 'Like Button',
                        'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        'location'=>'Location',
                        'date' => 'Date',
                        'tags' => 'Tags',
                        'owner' => 'Owner',
                        'category' => 'Category',
                        'vote' => 'Vote Counts',
                        //'answer' => 'Answer Counts',
                        'view' => 'View Counts',
                        'comment'=>'Comment Count',
                        'favourite'=>'Favourite Count',
                        'follow'=>'Follow Count',
                        'like'=>'Like Count',
                        'featuredLabel'=>'Featured Label',
                        'sponsoredLabel' =>'Sponsored Label',
                        'verifiedLabel'=>'Verified Label',
                        'hotLabel'=>'Hot Label',
                        'newLabel'=>'New Label',
                    ),
                    'escape' => false,
                )
            ),
            array('Select', 'category_id', array(
              'label' => 'Category',
              'multiOptions' => $categories,
              'allowEmpty' => true,
              'required' => false,
              )
            ),
            $seslocation,
            $socialshare_enable_plusicon,
            $socialshare_icon_limit,
            array(
                'Text',
                'title_truncation',
                array(
                    'label' => 'Question title truncation limit.',
                    'value' => 45,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter the height of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of question to show.)',
                    'value' => 20,
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
    'title' => 'SES Q&A - SES Side Widget User Info Widget',
    'description' => 'Displays User Info',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.about-user',
    'autoEdit'=>true,
    'adminForm' => array(
      'elements' => array(
          array(
              'MultiCheckbox',
              'show_criteria',
              array(
                  'label' => "Choose from below the details that you want to show in this widget.",
                  'multiOptions' => array(
                      'ownerPhoto' => 'Owner Photo',
                      'ownerTitle' => 'Owner Title',
                      'askedQuestionCount' => 'Total Asked Question Counts',
                      'answerQuestionCount' => 'Total Answered Counts',
                      'totalUpquestionCount' => 'Total Un-Vote Question Counts',
                      'totalDownquestionCount' => 'Total Down-Vote Question Counts',
                      'totalFavoutiteQuestionCount' => 'Total Favourite Question Counts',
                      'totalQuestionFollowCount' => 'Total Questions Follow Counts',
              )
          ),
        ),
     ),
  ),
 ),
 array(
    'title' => 'SES Q&A - Navigation Menu',
    'description' => 'Displays a navigation menu bar in the Q&A plugin\'s pages.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.browse-menu',
    'requirements' => array(
        'no-subject',
    ),
 ),

 array(
    'title' => 'SES Q&A - Banner with Questions Search',
    'description' => 'Displays a banner with the auto-suggest search box for Questions. As user types, Questions will be displayed in an auto-suggest box. This widget can be placed any where on the website.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.banner-search',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the background image to be shown in this widget.',
            'multiOptions' => $banner_options,
            'value' => '',
          )
        ),
        array(
          'Select',
          'logo',
          array(
            'label' => 'Choose the logo to be shown in this widget.',
            'multiOptions' => $banner_options,
            'value' => '',
          )
        ),
        array(
          'Select',
          'showfullwidth',
          array(
            'label' => 'Do you want to show this banner in full width?',
            'multiOptions' => array(
              'full' => 'Yes, show in full width.',
              'half' => 'No, do not show in full width.',
            ),
            'value' => 'full',
          )
        ),
        array(
          'Select',
          'autosuggest',
          array(
            'label' => 'Do you want to provide auto-suggest search box in this widget?',
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
            ),
            'value' => 1,
          )
        ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of this banner (in pixels).',
                'value' => 400,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        $seslocation,
        array(
          'Text',
          'bannertext',
          array(
            'label' => 'Enter the title to be shown in this banner.',
            'value' => 'How Can We Help You Today?',
          )
        ),
        array(
          'Text',
          'description',
          array(
            'label' => 'Enter the description to be shown in this banner.',
          )
        ),
        array(
          'Text',
          'textplaceholder',
          array(
            'label' => 'Enter placeholder text for the auto-suggest search box.',
            'value' => 'Type your keyword for search',
          )
        ),
        array(
          'Select',
          'template',
          array(
            'label' => "Choose the design template for the banner.",
            'multiOptions' => array(
              1 => 'Design - 1',
              2 => 'Design - 2',
              3 => 'Design - 3',
            ),
          ),
        ),
        array(
          'Select',
          'qacriteria',
          array(
            'label' => "Choose Popularity Criteria of Questions.",
            'multiOptions' => array(
              'like_count' => 'Most Liked',
              'creation_date' => 'Recenty Created',
              'view_count' => 'Most Viewed',
              'comment_count' => 'Most Commented',
              'answer_count' => 'Most Aswered',
              'vote_count' => 'Most Voted',
              'unanswered' => 'Unanswered',
            ),
          ),
        ),
        array(
            'Text',
            'limit',
            array(
                'label' => 'Count (number of Questions to show).',
                'value' => 5,
            )
        ),
      ),
    ),
  ),
   array(
    'title' => 'SES Q&A - Categories Icon View',
    'description' => 'Displays Questions categories in icon view. This widget can be placed anywhere on the website.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.categories',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'showinformation',
          array(
            'label' => "Choose the details to be shown for categories in this widget.",
            'multiOptions' => array(
              'title' => 'Title',
              'socialshare' => 'Social Share Icons [Grid View] <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>'
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
            'Text',
            'mainblockheight',
            array(
                'label' => 'Enter the main block height (in pixels).',
                'value' => 200,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'mainblockwidth',
            array(
                'label' => 'Enter the main block width (in pixels).',
                'value' => 250,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconheight',
            array(
                'label' => 'Enter the category icon height (in pixels).',
                'value' => 75,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconwidth',
            array(
                'label' => 'Enter the category icon width (in pixels).',
                'value' => 75,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
      ),
    ),
  ),
   array(
    'title' => 'SES Q&A - Categories Hierarchy Sidebar View',
    'description' => 'Displays all the categories of this Question plugin in category level hierarchy view as chosen by you. Edit this widget to choose to show / hide icons in this widget. Clicking on any category in this widget will redirect users to the Browse Questions page.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.category',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'image',
          array(
            'label' => "Do you want to show category icon in this widget?",
            'multiOptions' => array(
              0 => 'Yes',
              1 => 'No',
            ),
          ),
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES Q&A - Popular Categories',
    'description' => 'Displays all Questions categories in grid and list view. This widget can be placed anywhere on the site to display Question categories.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.home-category',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Categories View Type",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Grid View'
            ),
          )
        ),
        array(
          'Select',
          'showsubcategory',
          array(
            'label' => "Do you want to show sub-categories in this widget? (Works only with the List View)",
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
            ),
          )
        ),
        array(
          'MultiCheckbox',
          'showinformation',
          array(
            'label' => "Choose the details to be shown for categories in this widget. (Will work only for Grid View).",
            'multiOptions' => array(
              'description' => 'Category Description [Only Grid View]',
              'caticon' => 'Category Icon [Both Grid and List View]',
              'subcaticon' => 'Sub-category Icon [List View]',
              'socialshare' => 'Social Share Icons [Grid View] <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>'
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Select',
          'criteria',
          array(
            'label' => "Choose Popularity Criteria.",
            'multiOptions' => array(
              'alphabetical' => 'Alphabetical order',
              'most_qa' => 'Categories with maximum Questions first',
              'admin_order' => 'Admin selected order for categories',
            ),
          ),
        ),
        array(
            'Text',
            'descriptionlimit',
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
            'mainblockheight',
            array(
                'label' => 'Enter the main block height for grid view (in pixels).',
                'value' => 300,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'mainblockwidth',
            array(
                'label' => 'Enter the main block width for grid view (in pixels).',
                'value' => 250,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconheight',
            array(
                'label' => 'Enter the category icon height (in pixels).',
                'value' => 122,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconwidth',
            array(
                'label' => 'Enter the category icon width (in pixels).',
                'value' => 122,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'subcaticonheight',
            array(
                'label' => 'Enter the sub-category icon height (in pixels).',
                'value' => 122,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'subcaticonwidth',
            array(
                'label' => 'Enter the sub-category icon width (in pixels).',
                'value' => 122,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'limit_data',
            array(
                'label' => 'Count (number of categories to show).',
                'value' => 4,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
            'Text',
            'limitsubcat',
            array(
                'label' => 'Count (number of sub-categories to show).',
                'value' => 4,
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
    'title' => 'SES Q&A - Category View - Banner',
    'description' => 'Displays category banner. This widget will be place only on "Questions - Category View Page"',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.category-banner',
  ),
  array(
    'title' => 'SES Q&A - Browse Category - Category Associated Questions',
    'description' => 'Displays Questions based on main category. This widget only for browse category page only.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.category-associate-qa',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewtype',
          array(
            'label' => "Choose View Type for Questions.",
            'multiOptions' => array(
              'list1' => 'List View 1',
              'list2' => 'List View 2',
              'grid1' => 'Grid View 1',
              'grid2' => 'Grid View 2',
            ),
            'value'=>'list1',
          ),
        ),
        array(
          'MultiCheckbox',
          'showinformation',
          array(
            'label' => "Choose the details to be shown for Questions in this widget. (Will work only for Expanded List View and Grid View).",
            'multiOptions' => array(
              'title'=>'Title of Question',
            'favBtn' => 'Favourite Button',
            'likeBtn' => 'Like Button',
            'followBtn' => 'Follow Button',
            'userImage' =>'Owner Photo',
            'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'location'=>'Location',
            'date' => 'Date',
            'tags' => 'Tags',
            'owner' => 'Owner',
            'category' => 'Category',
            'vote' => 'Vote Counts',
            'answerCount' => 'Answer Counts',
            'view' => 'View Counts',
            'comment'=>'Comment Count',
            'favourite'=>'Favourite Count',
            'follow'=>'Follow Count',
            'like'=>'Like Count',
            'featuredLabel'=>'Featured Label',
            'sponsoredLabel' =>'Sponsored Label',
            'verifiedLabel'=>'Verified Label',
            'hotLabel'=>'Hot Label',
            'newLabel'=>'New Label',
            ),
            'escape' => false,
          )
        ),
        $socialshare_icon_limit,
        $socialshare_enable_plusicon,
        array(
            'Text',
            'title_truncate',
            array(
                'label' => 'Title truncation limit for Questions.',
                'value' => 60,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
					'Text',
					'limit_data',
					array(
						'label' => 'Count (number of categories to show).',
						'value' => 3,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						),
					),
        ),
        array(
          'Select',
          'qacriteria',
          array(
            'label' => "Choose Popularity Criteria for Questions.",
            'multiOptions' => array(
              'most_liked' => 'Most Liked',
              'creation_date' => 'Recenty Created',
              'most_viewed' => 'Most Viewed',
              'most_commented' => 'Most Commented',
              'most_answered' => 'Most Aswered',
              'unanswered' => 'Unanswered',
            ),
          ),
        ),
        $seslocation,
        array(
          'Select',
          'showviewalllink',
          array(
            'label' => 'Do you want to show "See All Questions" link for each category?',
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
            ),
            'value' => 1,
          ),
        ),
        array(
					'Text',
					'limitdataqa',
					array(
						'label' => 'Count (number of Questions to show).',
						'value' => 3,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						),
					),
        ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of one block (in pixels).',
                'value' => 0,
                /*'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )*/
            ),
        ),
        array(
            'Text',
            'width',
            array(
                'label' => 'Enter the width of one block (in pixels).',
                'value' => 0,
                /*'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )*/
            ),
        ),
      ),
    ),
  ),
   array(
    'title' => 'SES Q&A - Category View - Categories of all Levels',
    'description' => 'Displays 2nd-level or 3rd level categories and Questions associated with the current category on the respective category\'s view page. This widget should be placed on the "Questions - Category View Page".',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.category-view-page',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
         array(
          'Select',
          'viewtype',
          array(
            'label' => "Choose View Type for Questions.",
            'multiOptions' => array(
              'list1' => 'List View 1',
              'list2' => 'List View 2',
              'grid1' => 'Grid View 1',
              'grid2' => 'Grid View 2',
            ),
            'value'=>'list1',
          ),
        ),
        array(
          'MultiCheckbox',
          'showinformation',
          array(
            'label' => "Choose the details to be shown for Questions in this widget. (Will work only for Expanded List View and Grid View).",
            'multiOptions' => array(
              'title'=>'Title of Question',
            'favBtn' => 'Favourite Button',
            'likeBtn' => 'Like Button',
            'followBtn' => 'Follow Button',
            'userImage' =>'Owner Photo',
            'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'location'=>'Location',
            'date' => 'Date',
            'tags' => 'Tags',
            'owner' => 'Owner',
            'category' => 'Category',
            'vote' => 'Vote Counts',
            'answerCount' => 'Answer Counts',
            'view' => 'View Counts',
            'comment'=>'Comment Count',
            'favourite'=>'Favourite Count',
            'follow'=>'Follow Count',
            'like'=>'Like Count',
            'featuredLabel'=>'Featured Label',
            'sponsoredLabel' =>'Sponsored Label',
            'verifiedLabel'=>'Verified Label',
            'hotLabel'=>'Hot Label',
            'newLabel'=>'New Label',
            ),
            'escape' => false,
          )
        ),
        $socialshare_icon_limit,
        $socialshare_enable_plusicon,
        array(
            'Text',
            'title_truncate',
            array(
                'label' => 'Title truncation limit for Questions.',
                'value' => 60,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
          'Select',
          'qacriteria',
          array(
            'label' => "Choose Popularity Criteria for Questions.",
            'multiOptions' => array(
              'most_liked' => 'Most Liked',
              'creation_date' => 'Recenty Created',
              'most_viewed' => 'Most Viewed',
              'most_commented' => 'Most Commented',
              'most_answered' => 'Most Aswered',
              'unanswered' => 'Unanswered',
            ),
          ),
        ),
        $seslocation,
        array(
					'Text',
					'limitdataqa',
					array(
						'label' => 'Count (number of Questions to show).',
						'value' => 3,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						),
					),
        ),
        array('Radio', "loadOptionData", array(
        'label' => "Do you want the questions to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
        )
       ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of one block (in pixels).',
                'value' => 0,
                /*'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )*/
            ),
        ),
        array(
            'Text',
            'width',
            array(
                'label' => 'Enter the width of one block (in pixels).',
                'value' => 0,
                /*'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )*/
            ),
        ),

      ),
    ),
  ),
  array(
        'title' => 'Questions - Find Questions Based on Time Period',
        'description' => 'Displays search criterias for searching questions on the basis of All question or created Today, Tommorrow, This Week, Next Week, This Month or on a Chosen Date in attractive view. You can also enable categories to show in this widget. Edit this widget to select search criterias to be available in this widget.',
        'category' => 'SES - Questions & Answers Plugin',
        'type' => 'widget',
        'name' => 'sesqa.find-questions',
        'autoEdit' => true,
        'adminForm' => 'Sesqa_Form_Admin_Findquestions',
    ),
    array(
        'title' => 'Questions - Question of the day',
        'description' => 'This widget displays questions of the day as chosen by you from the Edit Settings of this widget.',
        'category' => 'SES - Questions & Answers Plugin',
        'type' => 'widget',
        'name' => 'sesqa.question-off-the-day',
        'autoEdit' => true,
        'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'show_criteria',
                  array(
                      'label' => "Choose from below the details that you want to show in this widget.",
                      'multiOptions' => array(
                          'itemPhoto' => 'Question Photo',
                          'title'=>'Title of Question',
                          'favBtn' => 'Favourite Button',
                          'followBtn' => 'Follow Button',
                          'likeBtn' => 'Like Button',
                          'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                          'location'=>'Location',
                          'date' => 'Date',
                          'tags' => 'Tags',
                          'owner' => 'Owner',
                          'category' => 'Category',
                          'vote' => 'Vote Counts',
                          //'answer' => 'Answer Counts',
                          'view' => 'View Counts',
                          'comment'=>'Comment Count',
                          'favourite'=>'Favourite Count',
                          'follow'=>'Follow Count',
                          'like'=>'Like Count',
                          'featuredLabel'=>'Featured Label',
                          'sponsoredLabel' =>'Sponsored Label',
                          'verifiedLabel'=>'Verified Label',
                          'hotLabel'=>'Hot Label',
                          'newLabel'=>'New Label',
                      ),
                      'escape' => false,
                  )
              ),
              array('Select', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
                'allowEmpty' => true,
                'required' => false,
                )
              ),
              $seslocation,
              $socialshare_enable_plusicon,
              $socialshare_icon_limit,
              array(
                  'Text',
                  'title_truncation',
                  array(
                      'label' => 'Question title truncation limit.',
                      'value' => 45,
                      'validators' => array(
                          array('Int', true),
                          array('GreaterThan', true, array(0)),
                      )
                  )
              ),
              array(
                  'Text',
                  'height',
                  array(
                      'label' => 'Enter the height of one question block (in pixels).',
                      'value' => '180',
                      'validators' => array(
                          array('Int', true),
                          array('GreaterThan', true, array(0)),
                      )
                  )
              ),
              array(
                  'Text',
                  'width',
                  array(
                      'label' => 'Enter the width of one question block (in pixels).',
                      'value' => '180',
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
        'title' => 'Questions Profile - Main Photo',
        'description' => 'Displays Profile photo of the Question owner depending on its placement.',
        'category' => 'SES - Questions & Answers Plugin',
        'type' => 'widget',
        'name' => 'sesqa.question-owner',
        'autoEdit' => false,
    ),

    array(
        'title' => 'Questions - Popular Questions',
        'description' => "Displays questions based on the chosen criteria in this widget. The placement of this widget depend upon the criteria chosen.",
        'category' => 'SES - Questions & Answers Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesqa.featured-sponsored-hot',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose criteria for contests to be show in this widget.',
                        'multiOptions' => array(
                            '' => 'All Questions',
                            'today' => 'Today',
                            'week' => 'This Week',
                            'month' => 'This Month',
                        ),
                        'value' => '',
                    )
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All Questions',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "follow_count" => "Most Followed",
                            'most_answered' => 'Most Answered',
                        )
                    ),
                    'value' => 'recently_created',
                ),

                 array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'itemPhoto' => 'Question Photo',
                        'title'=>'Title of Question',
                        'favBtn' => 'Favourite Button',
                        'followBtn' => 'Follow Button',
                        'likeBtn' => 'Like Button',
                        'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        'location'=>'Location',
                        'date' => 'Date',
                        'tags' => 'Tags',
                        'owner' => 'Owner',
                        'category' => 'Category',
                        'vote' => 'Vote Counts',
                        'view' => 'View Counts',
                        'comment'=>'Comment Count',
                        'favourite'=>'Favourite Count',
                        'follow'=>'Follow Count',
                        'like'=>'Like Count',
                        'featuredLabel'=>'Featured Label',
                        'sponsoredLabel' =>'Sponsored Label',
                        'verifiedLabel'=>'Verified Label',
                        'hotLabel'=>'Hot Label',
                        'newLabel'=>'New Label',
                        'answer' => 'Answer',
                    ),
                    'escape' => false,
                )
            ),
            array('Select', 'category_id', array(
              'label' => 'Category',
              'multiOptions' => $categories,
              'allowEmpty' => true,
              'required' => false,
              )
            ),
            $seslocation,
            $socialshare_enable_plusicon,
            $socialshare_icon_limit,
            array(
                'Text',
                'answertitle_truncation',
                array(
                    'label' => 'Answer title truncation limit.',
                    'value' => 100,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'title_truncation',
                array(
                    'label' => 'Question title truncation limit.',
                    'value' => 45,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter the height of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                       // array('Int', true),
                        //array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of one question block (in pixels).',
                    'value' => '180',
                    'validators' => array(
                        //array('Int', true),
                        //array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of question to show.)',
                    'value' => 5,
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
    'title' => 'SES Q&A - 2nd and 3rd Level Categories Icon View',
    'description' => 'Displays Questions 2nd and 3rd level categories in icon view. This widget can be placed  on category view page of the website.',
    'category' => 'SES - Questions & Answers Plugin',
    'type' => 'widget',
    'name' => 'sesqa.secont-third-categories',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'showinformation',
          array(
            'label' => "Choose the details to be shown for categories in this widget.",
            'multiOptions' => array(
              'title' => 'Title',
              'socialshare' => 'Social Share Icons [Grid View] <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>'
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
            'Text',
            'mainblockheight',
            array(
                'label' => 'Enter the main block height (in pixels).',
                'value' => 200,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'mainblockwidth',
            array(
                'label' => 'Enter the main block width (in pixels).',
                'value' => 250,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconheight',
            array(
                'label' => 'Enter the category icon height (in pixels).',
                'value' => 75,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Text',
            'categoryiconwidth',
            array(
                'label' => 'Enter the category icon width (in pixels).',
                'value' => 75,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
      ),
    ),
  ),
);
