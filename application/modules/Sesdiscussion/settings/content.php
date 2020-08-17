<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-12-18 00:00:00 SocialEngineSolutions $
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

$title_truncation = array(
    'Text',
    'title_truncation',
        array(
        'label' => 'Title Truncation Limit',
        'value' => 16,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        ),
    ),
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
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesdiscussion')->getCategoriesAssoc(array('module'=>true));
}

return array(
  array(
    'title' => "Discussion Profile - Details & Options",
    'description' => 'This widget display discussions. This widget can only be placed on "Discussion View Page" only.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.view-page',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'stats',
          array(
            'label' => 'Choose the options that you want to be displayed in this widget.',
            'multiOptions' => array(
              "likecount" => "Likes Count",
              "commentcount" => "Comments Count",
              "viewcount" => "Views Count",
              "favouritecount" => "Favourites Count",
              "followcount" => "Follows Count",
              "postedby" => "Discussion Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Link",
              'tags' => "Tags",
              'category' => "Category",
              'voting' => "Voting",
              'new' => "New Label",
              'siteshare' => "Site Share",
              "description" => "Description",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              'followbutton' => 'Follow Button',
              'favouritebutton' => 'Favourite Button',
            ),
            'escape' => false,
          ),
        ),
      )
    ),
  ),
  array(
    'title' => 'SES Discussions - Tabbed widget for Manage Discussions',
    'description' => 'This widget displays discussions created, favourite, liked, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.manage-discussions',
    'requirements' => array(
      'subject' => 'discussion',
    ),
    'adminForm' => 'Sesdiscussion_Form_Admin_Tabbed',
  ),
  array(
    'title' => 'SES Discussions - Discussion Gutter Menu',
    'description' => 'Displays a menu in the discussion gutter.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.gutter-menu',
  ),
  array(
    'title' => 'SES Discussions - Top Discussion Posters',
    'description' => 'Displays all top discussion posters on your website.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.top-discussion-poster',
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
    'title' => 'SES Discussions - People Like Discussion',
    'description' => 'Placed on  a Discussion view page. You can place this widget on SES - Discussions - Discussion View Page.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.people-like-item',
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
    'title' => 'SES Discussions - Discussion Category Icons Block',
    'description' => 'Displays discussion categories in block view with their icon, and statistics. You can place this widget on SES  Discussions - Browse Categories Page.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.category-icons',
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
                    'most_discussion' => 'Categories with maximum discussions first',
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
                    'countDiscussions' => 'Discussions count in each category',
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
    'title' => "SES Discussions - Profile Discussions",
    'description' => 'This widget display discussions. This widget can only be placed on "Member Profile Page" only.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.profile-discussions',
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
              "postedby" => "Discussion Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Link",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
              "favouritecount" => "Favourites Count",
              'favouritebutton' => 'Favourite Button',
              "permalink" => "Permalink",
            ),
            'escape' => false,
          ),
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
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
    'title' => "SES Discussions - Browse Discussions",
    'description' => 'This widget display discussions. This widget can only be placed on "SES - Discussions - Discussions Browse Page".',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.browse-discussions',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewtype',
          array(
              'label' => "Choose widget type?",
              'multiOptions' => array(
                  'list' => 'List View',
                  'pinboard' => 'Pinboard View',
              ),
              'value' => 'list',
          ),
        ),
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
              "favouritecount" => "Favourites Count",
              "commentcount" => "Comments Count",
              "viewcount" => "Views Count",
              "postedby" => "Discussion Owner's Name",
              "posteddate" => "Posted Date",
              'source' => "Link",
              'voting' => "Voting",
              'category' => "Category",
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'newlabel' => "New Label",
              'tags' => 'Tags',
              'description' => 'Discussion Description',
              'likebutton' => 'Like Button',
              'favouritebutton' => 'Favourite Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
              "permalink" => "Permalink",
              "pinboardcomment" => "Comment Widget (Pinboard View Only)"
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
          'label' => "Do you want the discussions to be auto-loaded when users scroll down the page?",
          'multiOptions' => array(
            'autoload' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'pagging',
          )
        ),
        array(
          'Text',
          'title_truncation',
          array(
            'label' => 'Title Truncation Limit',
            'value' => 16,
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
            'label' => 'Discussion Truncation Limit',
            'value' => 200,
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
    'title' => 'SES Discussions - Breadcrumb for Discussion View Page',
    'description' => 'Displays breadcrumb for Discussion. This widget should be placed on the "SES - Discussions - Discussion View Page."',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.breadcrumb',
  ),
  array(
    'title' => 'Discussion Browse Menu',
    'description' => 'Displays a Navigation Menu Bar on SES Discussions - Browse Discussions, Browse Categories and Manage Discussions Pages.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),

  array(
    'title' => 'Discussion Browse Search',
    'description' => 'Displays a search form in the discussions browse page.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.browse-search',
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
    'title' => "SES Discussions - Discussion Of the Day",
    'description' => 'This widget display discussion of the day.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.discussions-of-the-day',
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
              "favouritecount" => "Favourites Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Text Owner's Name",
              "posteddate" => "Posted Date",
              'description' => 'Discussion Description',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              'favouritebutton' => 'Favourite Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
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
        $title_truncation,
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Discussion truncation limit',
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
    'title' => "SES Discussions - Other Discussions",
    'description' => 'This widget display discussions other than the current discussion on the site. This widget cans only be placed on "SES - Discussions - Discussion View Page".',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.other-discussions',
    'defaultParams' => array(
        'title' => 'Other Discussions',
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
              "favouritecount" => "Favourites Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Text Owner's Name",
              "posteddate" => "Posted Date",
              'description' => 'Discussion Description',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              'favouritebutton' => 'Favourite Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
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
        $title_truncation,
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Discussion truncation limit',
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
            'label' => 'Count (number of discussions to show)',
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
    'title' => "SES Discussions - Popular Discussions",
    'description' => 'This widget display discussions based on popularity criteria.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdiscussion.popularity-discussions',
    'defaultParams' => array(
        'title' => 'Popular Discussions',
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
              'favourite_count' => 'Most Favourite',
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
              "favouritecount" => "Favourites Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Discussion Owner's Name",
              "posteddate" => "Posted Date",
              'description' => 'Discussion Description',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              'favouritebutton' => 'Favourite Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
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
        $title_truncation,
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Discussion truncation limit',
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
            'label' => 'Count (number of discussions to show)',
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
    'title' => 'SES Discussions - Recently Viewed Discussions',
    'description' => 'This widget displays the recently viewed discussion by the user who is currently viewing your website or by the logged in members friend. Edit this widget to choose whose recently viewed content will show in this widget.',
    'category' => 'SES - Discussions Plugin',
    'type' => 'widget',
    'name' => 'sesdiscussion.recently-viewed-discussion',
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
              'by_me' => 'Discussions viewed by me',
              'by_myfriend' => 'Discussions viewed by my friends',
              'byallmembers' => 'Discussions viewed by all members',
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
              "favouritecount" => "Favourites Count",
              "commentCount" => "Comments Count",
              "viewCount" => "Views Count",
              "postedby" => "Discussion Owner's Name",
              "posteddate" => "Posted Date",
              'description' => 'Discussion Description',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likebutton' => 'Like Button',
              'favouritebutton' => 'Favourite Button',
              "followcount" => "Follows Count",
              'followbutton' => 'Follow Button',
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
        $title_truncation,
        array(
          'Text',
          'description_truncation',
          array(
            'label' => 'Discussion truncation limit',
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
            'label' => 'count (number of discussions to show)',
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
