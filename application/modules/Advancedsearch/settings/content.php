<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
 array(
    'title' => 'SES - Advanced Search View Page',
    'description' => 'Displays the search results.',
    'category' => 'SES - Professional Search Plugin',
    'type' => 'widget',
    'name' => 'advancedsearch.search-results',
    'isPaginated' => true,
    'adminForm' => array(
         'elements' => array(
             array(
                 'Text',
                 'more_tab',
                 array(
                     'label' => 'After How many tabs You want to show more link',
                     'validators' => array(
                         array('Int', true),
                         array('GreaterThan', true, array(0)),
                     ),
                     'value' => 8,
                 )
             ),
             array(
                 'MultiCheckbox',
                 'show_criteria',
                 array(
                     'label' => 'Select the details you want to display',
                     'multiOptions' => array(
                         'view'=>'Views',
                         'likes' => 'Likes',
                         'comment' => 'Comments',
                         'contentType' => 'Content Type',
                         'postedBy'=>'Posted By',
                         'rating' =>'Ratings',
                         'photo'=>'Photos',
                         'review'=>'Reviews',
                         'description'=>'Descriptions',
                         'category' => 'Category',
                         'location' =>'Location',
                         'sponsored' =>'Sponsored',
                         'featured' => 'Featured',
                         'hot' => 'Hot',

                     ),
                 )
             ),
             array(
                 'Radio',
                 'pagging',
                array(
                    'label'=>'Do you want the results to be auto-loaded when users scroll down the page?',
                    'multiOptions'=>array(
                        'loadmore'=>'Yes, Auto Load',
                        'viewmore'=>'No, show \'View more\' link.',
                        'pagging'=>'No, show \'Pagination\'.'
                    ),
                    'value'=>'loadmore',
                ),
             ),
         )
     ),
  ),
    array(
        'title' => 'Browse Member',
        'description' => 'Browse member.',
        'category' => 'SES - Professional Search Plugin',
        'type' => 'widget',
        'name' => 'advancedsearch.browse-member',
        'autoedit'=>false,
    ),
    array(
        'title' => 'Browse Search',
        'description' => 'Browse search page.',
        'category' => 'SES - Professional Search Plugin',
        'type' => 'widget',
        'name' => 'advancedsearch.browse-search',
        'autoedit'=>false,
    ),
    array(
        'title' => 'Browse Content',
        'description' => 'Browse content.',
        'category' => 'SES - Professional Search Plugin',
        'type' => 'widget',
        'name' => 'advancedsearch.core-content',
        'autoedit'=>false,
        'isPaginated' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Select the details you want to display',
                        'multiOptions' => array(
                            'view'=>'Views',
                            'likes' => 'Likes',
                            'comment' => 'Comments',
                            'postedBy'=>'Posted By',
                            'photo'=>'Photos'
                        ),
                    )
                ),
                array(
                    'Radio',
                    'pagging',
                    array(
                        'label'=>'Do you want the content to be auto-loaded when users scroll down the page?',
                        'multiOptions'=>array(
                            'loadmore'=>'Yes, Auto Load',
                            'viewmore'=>'No, show \'View more\' link.',
                            'pagging'=>'No, show \'Pagination\'.'
                        ),
                        'value'=>'loadmore',
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'Search Box',
        'description' => 'Display search box in mini menu.',
        'category' => 'SES - Professional Search Plugin',
        'type' => 'widget',
        'name' => 'advancedsearch.search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'loggedin',
                    array(
                        'label' => 'Enter search box width for logged-in user(in px)',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'nonloggedin',
                    array(
                        'label' => 'Enter search box width for non logged-in user(in px)',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
);
