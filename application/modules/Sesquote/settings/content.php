<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2017-12-12 00:00:00 SocialEngineSolutions $
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

$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesquote')->getCategoriesAssoc(array('module'=>true));
}

return array(
  array(
    'title' => 'SES Quotes - Top Quote Posters',
    'description' => 'Displays all top quote posters on your website.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.top-quote-poster',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit_data',
          array(
            'label' => 'Show view more after how much data?.',
            'value' => 11,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      )
    )
  ),
  array(
    'title' => 'SES Quotes - People Like Quote',
    'description' => 'Placed on  a Quote view page. You can place this widget on SES - Quotes - Quote View Page.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.people-like-item',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit_data',
          array(
            'label' => 'Show view more after how much data?.',
            'value' => 11,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      )
    )
  ),
  array(
    'title' => 'SES Quotes - Quote Category Icons Block',
    'description' => 'Displays quote categories in block view with their icon, and statistics. You can place this widget on SES  Quotes - Browse Categories Page.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.category-icons',
    'adminForm' => array(
      'elements' => array(
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of one block (in pixels).',
                'value' => '160px',
            )
        ),
        array(
            'Text',
            'width',
            array(
                'label' => 'Enter the width of one block (in pixels).',
                'value' => '160px',
            )
        ),
        array(
            'Text',
            'heighticon',
            array(
                'label' => 'Enter the height of category icon (in pixels).',
                'value' => '50px',
            )
        ),
        array(
            'Text',
            'widthicon',
            array(
                'label' => 'Enter the width of category icon (in pixels).',
                'value' => '50px',
            )
        ),
         array(
            'Select',
            'alignContent',
            array(
                'label' => "Where do you want to show content of this widget?",
                'multiOptions' => array(
                    'center' => 'In Center',
                    'left' => 'In Left',
                    'right' => 'In Right',
                ),
                'value' => 'center',
            ),
        ),
        array(
            'Select',
            'criteria',
            array(
                'label' => "Choose Popularity Criteria.",
                'multiOptions' => array(
                    'alphabetical' => 'Alphabetical order',
                    'most_quote' => 'Categories with maximum quotes first',
                    'admin_order' => 'Admin selected order for categories',
                ),
            ),
        ),
        array(
            'MultiCheckbox',
            'showStats',
            array(
                'label' => "Choose from below the details that you want to show on each block.",
                'multiOptions' => array(
                    'title' => 'Category title',
                    'countQuotes' => 'Quotes count in each category',
                ),
            )
        ),
        array(
            'Text',
            'limit_data',
            array(
                'label' => 'Count (number of categories to show.)',
                'value' => 10,
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
    'title' => "SES Quotes - Content Profile Quotes",
    'description' => 'This widget enables you to allow users to create quotes on different content on your website like Groups. Place this widget on the content profile page, for example SE Group to enable group owners to create quotes in their Groups. You can choose the visibility of the quotes created in a content to only that content or show in this plugin as well from the "Quotes Created in Content Visibility" setting in Global setting of this plugin.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.other-modules-profile-quotes',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'stats',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likecount" => "Likes Count",
              "commentcount" => "Comments Count",
              "viewcount" => "Views Count",
              "postedby" => "Quote Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Source",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view',
            'value' => 250,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Radio',
          'pagging',
          array(
          'label' => "Do you want the quotes to be auto-loaded when users scroll down the page?",
          'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'pagging',
          )
        ),
        array(
          'Text',
          'descriplimit',
          array(
            'label' => 'Enter description limit.',
            'value' => 150,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of content to show)',
            'value' => 10,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
      )
    ),
  ),
  array(
    'title' => "SES Quotes - Profile Quotes",
    'description' => 'This widget display quotes. This widget can only be placed on "Member Profile Page" only.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.profile-quotes',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'stats',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likecount" => "Likes Count",
              "commentcount" => "Comments Count",
              "viewcount" => "Views Count",
              "postedby" => "Quote Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Source",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view',
            'value' => 250,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of content to show)',
            'value' => 10,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
      )
    ),
  ),
  array(
    'title' => "SES Quotes - Browse Quotes",
    'description' => 'This widget display quotes. This widget can only be placed on "SES - Quotes - Quotes Browse Page".',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.browse-quotes',
    'adminForm' => array(
      'elements' => array(
        array(
        'Select',
        'category_id',
          array(
            'label' => 'Choose the category.',
            'multiOptions' => $categories
          ),
          'value' => ''
        ),
        array(
          'MultiCheckbox',
          'stats',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likecount" => "Likes Count",
              "commentcount" => "Comments Count",
              "viewcount" => "Views Count",
              "postedby" => "Quote Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Source",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view',
            'value' => 250,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Radio',
          'pagging',
          array(
          'label' => "Do you want the quotes to be auto-loaded when users scroll down the page?",
          'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'pagging',
          )
        ),
        array(
          'Text',
          'descriplimit',
          array(
            'label' => 'Enter description limit.',
            'value' => 150,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Count (number of content to show)',
            'value' => 10,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
      )
    ),
  ),
  array(
    'title' => 'SES Quotes - Breadcrumb for Quote View Page',
    'description' => 'Displays breadcrumb for Quote. This widget should be placed on the "SES - Quotes - Quote View Page."',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.breadcrumb',
  ),
  array(
    'title' => 'Quote Browse Menu',
    'description' => 'Displays a Navigation Menu Bar on SES Quotes - Browse Quotes, Browse Categories and Manage Quotes Pages.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),

  array(
    'title' => 'Quote Browse Search',
    'description' => 'Displays a search form in the quotes browse page.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.browse-search',
    'requirements' => array(
      'no-subject',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose the View Type.",
            'multiOptions' => array(
              'horizontal' => 'Horizontal',
              'vertical' => 'Vertical'
            ),
            'value' => 'vertical',
          )
        ),
      )
    ),
  ),
  array(
    'title' => "SES Quotes - Quote Of the Day",
    'description' => 'This widget display quote of the day.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.quotes-of-the-day',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likeCount" => "Likes Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Text Owner's Name",
              "posteddate" => "Posted Date",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Grid view.',
            'value' => 300,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Quote truncation limit',
            'value' => 60,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      )
    ),
  ),
  array(
    'title' => "SES Quotes - Other Quotes",
    'description' => 'This widget display quotes other than the current quote on the site. This widget cans only be placed on "SES - Quotes - Quote View Page".',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.other-quotes',
    'defaultParams' => array(
        'title' => 'Other Quotes',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose the view type which you want to display by default.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Pinboard View',
            ),
            'value' => 'list',
          )
        ),
        array(
          'Select',
          'popularity',
          array(
            'label' => 'Popularity Criteria',
            'multiOptions' => array(
              'creation_date' => 'Most Recent',
              'view_count' => 'Most Viewed',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Updated',
              'random' => "Random"
            ),
            'value' => 'creation_date',
          )
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likeCount" => "Likes Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Text Owner's Name",
              "posteddate" => "Posted Date",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view.',
            'value' => 300,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Quote truncation limit',
            'value' => 60,
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
            'label' => 'Count (number of quotes to show)',
            'value' => 3,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
      )
    ),
  ),
  array(
    'title' => "SES Quotes - Popular Quotes",
    'description' => 'This widget display quotes based on popularity criteria.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesquote.popularity-quotes',
    'defaultParams' => array(
        'title' => 'Popular Quotes',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose the view type which you want to display by default.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Pinboard View',
            ),
            'value' => 'list',
          )
        ),
        array(
          'Select',
          'popularity',
          array(
            'label' => 'Popularity Criteria',
            'multiOptions' => array(
              'creation_date' => 'Most Recent',
              'view_count' => 'Most Viewed',
              'like_count' => 'Most Liked',
              'comment_count' => 'Most Commented',
              'modified_date' => 'Recently Updated',
            ),
            'value' => 'creation_date',
          )
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likeCount" => "Likes Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Quote Owner's Name",
              "posteddate" => "Posted Date",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view',
            'value' => 250,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Quote truncation limit',
            'value' => 60,
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
            'label' => 'Count (number of quotes to show)',
            'value' => 3,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
      )
    ),
  ),
  array(
    'title' => 'SES Quotes - Recently Viewed Quotes',
    'description' => 'This widget displays the recently viewed quote by the user who is currently viewing your website or by the logged in members friend. Edit this widget to choose whose recently viewed content will show in this widget.',
    'category' => 'SES - Quotes Plugin',
    'type' => 'widget',
    'name' => 'sesquote.recently-viewed-quote',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose the view type which you want to display by default.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Pinboard View',
            ),
            'value' => 'list',
          )
        ),
        array(
          'Select',
          'criteria',
          array(
            'label' => 'Popularity Criteria',
            'multiOptions' =>
            array(
              'by_me' => 'Quotes viewed by me',
              'by_myfriend' => 'Quotes viewed by my friends',
              'byallmembers' => 'Quotes viewed by all members',
            ),
          ),
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "title" => "Title",
              "likeCount" => "Likes Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Quote Owner's Name",
              "posteddate" => "Posted Date",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of Pinboard view.',
            'value' => 300,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          ),
        ),
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Quote truncation limit',
            'value' => 60,
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
            'label' => 'count (number of quotes to show)',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
  ),
);
