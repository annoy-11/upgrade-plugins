<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
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
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesprayer')->getCategoriesAssoc(array('module'=>true));
}

return array(
  array(
    'title' => 'SES Prayers - Top Prayer Posters',
    'description' => 'Displays all top prayer posters on your website.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.top-prayer-poster',
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
    'title' => 'SES Prayers - People Like Prayer',
    'description' => 'Placed on  a Prayer view page. You can place this widget on SES - Prayers - Prayer View Page.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.people-like-item',
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
    'title' => 'SES Prayers - Prayer Category Icons Block',
    'description' => 'Displays prayer categories in block view with their icon, and statistics. You can place this widget on SES  Prayers - Browse Categories Page.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.category-icons',
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
                    'most_prayer' => 'Categories with maximum prayers first',
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
                    'countPrayers' => 'Prayers count in each category',
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
    'title' => "SES Prayers - Profile Prayers",
    'description' => 'This widget display prayers. This widget can only be placed on "Member Profile Page" only.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.profile-prayers',
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
              "postedby" => "Prayer Owner's Name",
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
    'title' => "SES Prayers - Browse Prayers",
    'description' => 'This widget display prayers. This widget can only be placed on "SES - Prayers - Prayers Browse Page".',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.browse-prayers',
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
              "postedby" => "Prayer Owner's Name",
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
          'label' => "Do you want the prayers to be auto-loaded when users scroll down the page?",
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
    'title' => 'SES Prayers - Breadcrumb for Prayer View Page',
    'description' => 'Displays breadcrumb for Prayer. This widget should be placed on the "SES - Prayers - Prayer View Page."',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.breadcrumb',
  ),
  array(
    'title' => 'Prayer Browse Menu',
    'description' => 'Displays a Navigation Menu Bar on SES Prayers - Browse Prayers, Browse Categories and Manage Prayers Pages.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),

  array(
    'title' => 'Prayer Browse Search',
    'description' => 'Displays a search form in the prayers browse page.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.browse-search',
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
    'title' => "SES Prayers - Prayer Of the Day",
    'description' => 'This widget display prayer of the day.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.prayers-of-the-day',
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
            'label' => 'Prayer truncation limit',
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
    'title' => "SES Prayers - Other Prayers",
    'description' => 'This widget display prayers other than the current prayer on the site. This widget cans only be placed on "SES - Prayers - Prayer View Page".',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.other-prayers',
    'defaultParams' => array(
        'title' => 'Other Prayers',
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
            'label' => 'Prayer truncation limit',
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
            'label' => 'Count (number of prayers to show)',
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
    'title' => "SES Prayers - Popular Prayers",
    'description' => 'This widget display prayers based on popularity criteria.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesprayer.popularity-prayers',
    'defaultParams' => array(
        'title' => 'Popular Prayers',
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
              "postedby" => "Prayer Owner's Name",
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
            'label' => 'Prayer truncation limit',
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
            'label' => 'Count (number of prayers to show)',
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
    'title' => 'SES Prayers - Recently Viewed Prayers',
    'description' => 'This widget displays the recently viewed prayer by the user who is currently viewing your website or by the logged in members friend. Edit this widget to choose whose recently viewed content will show in this widget.',
    'category' => 'SES - Prayers Plugin',
    'type' => 'widget',
    'name' => 'sesprayer.recently-viewed-prayer',
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
              'by_me' => 'Prayers viewed by me',
              'by_myfriend' => 'Prayers viewed by my friends',
              'byallmembers' => 'Prayers viewed by all members',
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
              "postedby" => "Prayer Owner's Name",
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
            'label' => 'Prayer truncation limit',
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
            'label' => 'count (number of prayers to show)',
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