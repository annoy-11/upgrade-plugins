<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SNS - Group Forums Extension - Profile Topics',
    'description' => 'Displays Topics of the Groups based on the chosen criteria in this widget. This widget must be placed on the SNS - Group Communities - Group View Page.',
    'category' => 'SNS - Group Forums Extension',
    'type' => 'widget',
    'name' => 'sesgroupforum.forum-view',
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
    'title' => 'SNS - Group Forums Extension - Topic View',
    'description' => 'Displays a Topics with all the discussion posts and threads. Edit this widget to configure the various settings. This widget must be placed on the SNS - Group Forums Extension - Topic View Page.',
    'category' => 'SNS - Group Forums Extension',
    'type' => 'widget',
    'name' => 'sesgroupforum.topic-view',
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
);
