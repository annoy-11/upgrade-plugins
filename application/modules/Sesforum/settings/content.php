<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
    array(
        'title' => 'SES - Advanced Forums - Browse Topics',
        'description' => 'This widget is used to display categories, forums, topics and posts. This widget should be placed on “SES - Advanced Forums - Topic Search Page”.',
        'category' => 'SES - Advanced Forums',
        'type' => 'widget',
        'name' => 'sesforum.browse-topics',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array (
                array(
                    'Text',
                    'title_truncation_limit',
                    array(
                        'label' => 'Truncation Limit for Title',
                        'value' => 45,
                        'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'description_truncation_limit',
                    array(
                        'label' => 'Truncation Limit for Description',
                        'value' => 45,
                        'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Radio',
                    'load_content',
                    array(
                        'label' => "Do you want the Topics to be auto-loaded when users scroll down the page?.",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count(number of topics and posts to be shown in this widget)',
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
        'title' => 'SES - Advanced Forums - User Dashboard',
        'description' => 'This widget displays the User Dashboard, edit this widget to configure the various settings. This widget must be placed on the “SES - Advanced Forums - User Dashboard Page”.',
        'category' => 'SES - Advanced Forums',
        'type' => 'widget',
        'name' => 'sesforum.user-dashboard',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array (
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                    'label' => 'Choose from the below the Tabs that you want to show in this widget:',
                        'multiOptions' => array(
                            "myTopics" => "My Topics",
                            "myPosts" => "My Posts",
                            "mySubscribedTopics" => "My Subscribed Topics",
                            "TopicsILiked" =>"Topics I Liked",
                            "postsILiked" =>"Posts I Liked",
                            "signature"=>"Signature",
                        ),
                    ),
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => "Count (number of topics / posts to be shown in this widget.)",
                        'value' => '3',
                    )
                ),
                array(
                    'Radio',
                    'load_content',
                    array(
                        'label' => "Do you want the Topics or Posts to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                        ),
                        'value' => 'auto_load',
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Advanced Forums - Navigation',
        'description' => 'Displays a navigation menu in the SES - Advanced Forums Pages.',
        'category' => 'SES - Advanced Forums',
        'type' => 'widget',
        'name' => 'sesforum.navigation',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Advanced Forums - Most Popular Members',
        'description' => 'This widget displays members based on the popularity criteria. You can place this widget anywhere on the website. ',
        'category' => 'SES - Advanced Forums',
        'type' => 'widget',
        'name' => 'sesforum.popular-members',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => 'Popularity Criteria',
                        'description' => '',
                        'multiOptions' => array(
                            'topicCount' => 'Most Topic Posted',
                            'postCount' => 'Most Post Posted',
                            'thanksCount' => 'Maximum Thanks',
                            'reputationCount' => 'Most Reputation',
                        ),
                        'value' => 'topicCount',
                    ),
                ),
                array(
                    'Text',
                    'itemCountPerPage',
                    array(
                        'label' => 'Number of members to show',
                        'allowEmpty' => false,
                        'value' => 3,
                    ),
                ),
            ),
        ),
    ),
  array(
    'title' => 'SES - Advanced Forums - Popular Forum Topics',
    'description' => 'Displays topics based on chosen criteria for this widget. This widget can be placed anywhere on the website.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.list-recent-topics',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
			array(
				'Select',
				'criteria',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                    'multiOptions' => array(
                        "creation_date" => "Most Recent",
                        "modified_date" => "Recently Modified",
                        "view_count" => "Most Viewed",
                        "like_count" => "Most Liked",
                        'post_count' => "Most Posted",
                        "rating" => "Most Rated",
                    ),
                ),
            ),
			array(
				'MultiCheckbox',
				'stats',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                    'multiOptions' => array(
                        "forumName" => "Forums Name",
                        "topicName" => "Topic Name",
                        "likeCount" => "Likes Count",
                        "by" => "Posted By",
                        'postCount' => "Replies Count",
                        "viewCount" => "View Count",
                        'photo' => 'Member Photo',
                        'rating' => 'Rating',
                        "creationdate" => "Creation Date",
                    ),
                ),
            ),
            array(
                'Text',
                'itemCountPerPage',
                array(
                    'label' => "Number of Topics to show",
                    'value' => '3',
                )
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Recent Forum Posts',
    'description' => 'Displays posts based on the criteria chosen for this widget. You can place this widget anywhere on the website.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.list-recent-posts',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
			array(
				'Select',
				'criteria',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                    'multiOptions' => array(
                        "creation_date" => "Most Recent",
                        "modified_date" => "Recently Modified",
                        "like_count" => "Most Liked",
                    ),
                ),
            ),
			array(
				'MultiCheckbox',
				'stats',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                    'multiOptions' => array(
                        "forumName" => "Forums Name",
                        "topicName" => "Topic Name",
                        "likeCount" => "Likes Count",
                        "by" => "Posted By",
                        'photo' => 'Member Photo',
                        "creationdate" => "Creation Date",
                    ),
                ),
            ),
            array(
                'Text',
                'itemCountPerPage',
                array(
                    'label' => "Number of Replies to show",
                    'value' => '3',
                )
            ),
            array(
                'Text',
                'descLimit',
                array(
                    'label' => "Enter Truncation Limit of Replies",
                    'value' => '64',
                )
            ),
        ),
    ),
  ),

 array(
    'title' => 'SES - Advanced Forums - Tag Hierarchy Widget',
    'description' => 'Displays all tags of forum in Hierarchy View. Edit this widget to choose various other settings.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.tags',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'tags_count',
          array(
            'label'=>'Count(Number of  Tags to show)',
          )
        ),

      ),
    ),
  ),

  array(
        'title' => 'SES - Advanced Forums - Forum Tags',
        'description' => 'Display all forum tags on your website. The recommended page for this widget is “SES - Advanced Forums - Browse Tags Page”',
        'category' => 'SES - Advanced Forums',
        'type' => 'widget',
        'name' => 'sesforum.tag-topics',
    ),

  array(
      'title' => 'SES - Advanced Forums - Breadcrumb',
      'description' => 'Displays breadcrumb for Forums. The recommended page for this widget is “SES - Advanced Forums - Category View Page”.',
      'category' => 'SES - Advanced Forums',
      'type' => 'widget',
      'name' => 'sesforum.breadcrumb',
      'autoEdit' => true,
      'adminForm' => array(
        'elements' => array (
            array(
                'Text',
                'fontSize',
                array(
                    'label' => "Enter font size of heading.",
                    'value' => '24px',
                )
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Forum Statistics',
    'description' => 'Displays forum statistics. You can place this widget any pages of your website.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.statistics',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'Select',
                'viewtype',
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
				'stats',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                    'multiOptions' => array(
                        "forumCount" => "Forums Count",
                        "topicCount" => "Topics Count",
                        "postCount" => "Posts Count",
                        "totaluserCount" => "Total Users Count",
                        "activeusercount" => "Active Users Count",
                    ),
                ),
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Profile Forum Topics',
    'description' => 'Displays a Member’s forum topics on the Member Profile Page.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.profile-forum-topics',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose the details you want to show in this widget:',
                    'multiOptions' => array(
                        "likeCount" => "Like Count",
                        "rating" => "Ratings",
                        "creationDetails" => "Creation Date",
                        "viewsCount"=>"Views Count",
                        "repliesCount"=>"Replies Count",
                        "latestPostDetails"=>"Latest Post Details"
                    ),
                ),
            ),

            array(
                'Text',
                'title_truncation_limit',
                array(
                    'label' => 'Truncation Limit for Title',
                    'value' => 45,
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
                    'label' => 'Topics Count (number of topics to be shown in this widget)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Radio',
                'load_content',
                array(
                    'label' => " Do you want the topics to be auto-loaded when users scroll down the page?",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),

        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Profile Forum Posts',
    'description' => 'Displays a Member’s forum posts on the Member Profile Page.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.profile-forum-posts',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose the details you want to show in this widget:',
                    'multiOptions' => array(
                        "topic" => "Topics",
                        "likeCount" => "Like Count",
                        "thanksCount"=>"Thanks Count",
                        "creationDetails" => "Creation Date",
                    ),
                ),
            ),
             array(
                'Text',
                'title_truncation_limit',
                array(
                    'label' => 'Truncation Limit for Replies',
                    'value' => 45,
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
                    'label' => 'Replies Count (number of replies to be shown in this widget)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Radio',
                'load_content',
                array(
                    'label' => "Do you want the replies to be auto-loaded when users scroll down the page?",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),

        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Topic Browse Search',
    'description' => 'This widget is used to display a search form. The recommended page for this widget is “SES - Advanced Forums - Forum Main Page”.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.browse-search',
    'autoEdit' => true,
  ),
  array(
    'title' => 'SES - Advanced Forums - Forum Main & Category Design 1',
    'description' => 'Displays Categories and Forums based on the chosen criteria in this widget in design 1. This widget must be placed on the “SES - Advanced Forums - Forum Main Page”, “SES - Advanced Forums - Forum Category View Page”. (Note: Category display settings will work as per the category level.)',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.forums',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'Radio',
                'cat2ndShow',
                array(
                    'label' => "Do you want to display 2nd level categories, their forums?.",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Radio',
                'cat3rdShow',
                array(
                    'label' => "Do you want to display 3rd level categories and their forums?.",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
             array(
                'Radio',
                'forumShow',
                array(
                    'label' => "Do you want to display forums in categories?.",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Radio',
                'expandAbleCat',
                array(
                    'label' => "Do you want to allow users to expand / collapse forum categories.",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Radio',
                'load_content',
                array(
                    'label' => "Do you want the categories to be auto-loaded when users scroll down the page?.",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),
            array(
                'Text',
                'description_truncation_category',
                array(
                    'label' => 'Truncation Limit for Categories Description.',
                    'value' => 45,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
             array(
                'Text',
                'description_truncation_forum',
                array(
                    'label' => 'Truncation Limit for Forum Description',
                    'value' => 45,
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
                    'label' => 'Categories Count (number of categories to be shown in this widget)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
			array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose the details you want to show in this widget:',
                    'multiOptions' => array(
                        "topicCount" => "Topics Count",
                        "postCount" => "Posts Count",
                        "postDetails" => "Latest Post Detail",
                    ),
                ),
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Advanced Forums - Forum View',
    'description' => 'Displays Topics of the Forums based on the chosen criteria in this widget. This widget must be placed on the “SES - Advanced Forums - Forum View Page”.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.forum-view',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'Radio',
                'moderators',
                array(
                    'label' => "Do you want to show the Moderators of this Forum?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
			array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose from below the details that you want to show in this widget:',
                    'multiOptions' => array(
                        "ownerName" => "Owner Name",
                        "ownerPhoto" => "Owner Photo",
                        "likeCount" => "Like Count",
                        "ratings" => "Rating",
                        "tags"=>"Tags",
                        "showDatetime" => "Date and Time",
                        "viewCount" => "Views Count",
                        "replyCount" => " Replies Count",
                        "latestPostDetails" =>"Latest Post Details",
                        "postTopicButton" =>"Post Topic Button",
                    ),
                ),
            ),
            array(
                'Select',
                'show_data',
                array(
                    'label' => 'Do you want to display total Topic count in this widget?',
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Radio',
                'load_content',
                array(
                    'label' => "Do you want the Topics to be auto-loaded when users scroll down the page?.",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Enter number of topics to be shown in this widget.',
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
    'title' => 'SES - Advanced Forums - Post New Topic Button',
    'description' => 'Displays a button to Post a New Topic',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.post-new-topic',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of block (in pixels).',
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
    'title' => 'SES - Advanced Forums - Topic View',
    'description' => 'Displays a Topics with all the discussion posts and threads. Edit this widget to configure the various settings. This widget must be placed on the “SES - Advanced Forums - Topic View Page”.',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.topic-view',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
			array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose from below the options that you want to show for Posts & Replies:',
                    'multiOptions' => array(
                        "likeCount" => "Like Count",
                        "replyCount" => "Reply Count",
                        "ratings" => "Rating",
                        "postReply" => "Post Reply Button",
                        "shareButton" =>"Share Button",
                        "backToTopicButton" =>"Back to Topic Button",
                        "likeButton" => "Like Button",
                        "quote" =>"Quote",
                        'signature'=>'Signature',
                    ),
                ),
            ),
            array(
				'MultiCheckbox',
				'show_details',
                array(
                'label' => 'Choose from below the details that you want to show for members:',
                    'multiOptions' => array(
                        "thanksCount" => "Thanks Count",
                        "reputationCount" => "Reputation Count",
                        "postsCount" => "Posts Count",
                    ),
                ),
            ),

            array(
                'Radio',
                'tags',
                array(
                    'label' => "Do you want to displays the Tags?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of posts to be shown in this widget.)',
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
    'title' => 'SES - Advanced Forums - Forum Main Design 2',
    'description' => 'Displays Categories based on the chosen criteria in this widget in design 2. This widget must be placed on the “SES - Advanced Forums - Forum Main Page”. (Note: Category display settings will work as per the category level.)',
    'category' => 'SES - Advanced Forums',
    'type' => 'widget',
    'name' => 'sesforum.forum-category',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'Radio',
                'showcategory',
                array(
                    'label' => "Do you want to display the immediate lower level categories in this widget?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Radio',
                'themecolor',
                array(
                    'label' => "Do you want to show random colors or theme based color for Vertical Bar?",
                    'multiOptions' => array(
                        'random' => 'Random Color',
                        'theme' => 'Theme based'
                    ),
                    'value' => 'theme',
                )
            ),
             array(
                'Radio',
                'iconShape',
                array(
                    'label' => "Do you want to show subcategory icon in round Shape?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
             array(
                'Text',
                'description_truncation_category',
                array(
                    'label' => 'Truncation Limit for Category Description',
                    'value' => 45,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'description_truncation_post',
                array(
                    'label' => 'Truncation Limit for user post',
                    'value' => 45,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
			array(
				'MultiCheckbox',
				'show_criteria',
                array(
                'label' => 'Choose the details you want to show in this widget:',
                    'multiOptions' => array(
                        "topicCount" => "Topics Count",
                        "postCount" => "Posts Count",
                        "postDetails" => "Latest Post Detail",
                    ),
                ),
            ),
            array(
                'Radio',
                'showForum',
                array(
                    'label' => "Do you want to display forums of selected Category in this widget ?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),

            array(
                'Radio',
                'showTopics',
                array(
                    'label' => "Do you want to show topics created under selected category in this widget ?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'value' => '1',
                )
            ),
             array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Category Count (number of categories to be shown in this widget.)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'forum_limit_data',
                array(
                    'label' => 'Forums Count (number of forums to show)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Text',
                'topic_limit_data',
                array(
                    'label' => 'Topics Count (number of topics to show)',
                    'value' => 5,
                    'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                    )
                )
            ),
            array(
                'Radio',
                'load_content',
                array(
                    'label' => "Do you want the categories to be auto-loaded when users scroll down the page?.",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),
            array(
                'Radio',
                'topic_load_content',
                array(
                    'label' => "Do you want to show topics to be auto-loaded when users scroll down the page?.",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),
            array(
                'Radio',
                'forum_load_content',
                array(
                    'label' => "Do you want to show forums to be auto-loaded when users scroll down the page?.",
                    'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load.',
                        'button' => 'No, show \'View more\' link.',
                    ),
                    'value' => 'auto_load',
                )
            ),

        ),
    ),
  ),
);
