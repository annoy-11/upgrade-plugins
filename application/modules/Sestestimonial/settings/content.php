<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'SES - Testimonial Showcase Plugin - Testimonial Browse Menu',
        'description' => 'Displays a menu in the testimonial browse page.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'name' => 'sestestimonial.browse-menu',
    ),
    array(
        'title' => 'SES - Testimonial Showcase Plugin - Testimonial Browse Search',
        'description' => 'Displays a search form in the testimonial browse / manage page.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'name' => 'sestestimonial.browse-search',
    ),
    array(
        'title' => 'SES - Testimonial Showcase Plugin - Browse Testimonials',
        'description' => 'Displays all testimonial created by site member on SES - Browse Testimonial Page.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'name' => 'sestestimonial.browse-testimonials',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewtype',
                    array(
                        'label' => "Choose Designs",
                        'multiOptions' => array(
                            'listview' => 'List View',
                            'advlistview' => 'Advanced List View',
                            'gridview' => 'Grid View',
                            'advgridview' => 'Advanced Grid View',
                            'pinview' => 'Pinboard View',
                        ),
                    ),
                ),
                array(
                    'Select',
                    'paginationType',
                    array(
                        'label' => 'Do you want the Testimonial to be auto-loaded when users scroll down the page?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No, show \'View More\''
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'truncationlimit',
                    array(
                        'label' => 'Enter testimonial truncation limit.',
                        'value' => 100,
                    ),
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Count (number of Testimonial to show).',
                        'value' => 10,
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
        'title' => 'SES - Testimonial Showcase Plugin - Side Bar with all designs',
        'description' => 'Display the testimonial in all the design views at the sidebar of any page. You can place it any page.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sestestimonial.sidebar-alldesigns',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewtype',
                    array(
                        'label' => "Choose Designs",
                        'multiOptions' => array(
                            'listview' => 'List View',
                            'advlistview' => 'Advanced List View',
                            'gridview' => 'Grid View',
                            'advgridview' => 'Advanced Grid View',
                            'pinview' => 'Pinboard View (Horizantal Only)',
                        ),
                    ),
                ),
                array(
                    'Select',
                    'popularitycreteria',
                    array(
                        'label' => "Choose Popularity Creteria",
                        'multiOptions' => array(
                            'creation_date' => 'Recently Created',
                            'modified_date' => 'Recently Updated',
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'comment_count' => 'Most Commented',
                            'helpful_count' => 'Most Helpful',
                            'ratinghightolow' => 'Rating: High to Low',
                            'ratinglowtohigh' => 'Rating: Low to High',
                            'random' => 'Random',
                        ),
                    ),
                ),
                array(
                    'Select',
                    'rating',
                    array(
                        'label' => "Show Testimonial based on Rating",
                        'multiOptions' => array(
                            '' => '',
                            '5' => 'Only 5 Star',
                            '4' => 'Only 4 Star',
                            '3' => 'Only 3 Star',
                            '2' => 'Only 2 Star',
                            '1' => 'Only 1 Star',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'truncationlimit',
                    array(
                        'label' => 'Enter testimonial truncation limit.',
                        'value' => 100,
                    ),
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Count (number of Testimonial to show).',
                        'value' => 10,
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
        'title' => 'SES - Testimonial Showcase Plugin - Slideshow',
        'description' => 'The recommended page is landing page. Display testimonials in a carousel slider at your website.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'name' => 'sestestimonial.slideshow',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popularitycreteria',
                    array(
                        'label' => "Choose Popularity Creteria",
                        'multiOptions' => array(
                            'creation_date' => 'Recently Created',
                            'modified_date' => 'Recently Updated',
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'comment_count' => 'Most Commented',
                            'helpful_count' => 'Most Helpful',
                            'ratinghightolow' => 'Rating: High to Low',
                            'ratinglowtohigh' => 'Rating: Low to High',
                            'random' => 'Random',
                        ),
                    ),
                ),
                array(
                    'Select',
                    'rating',
                    array(
                        'label' => "Show Testimonial based on Rating",
                        'multiOptions' => array(
                            '' => '',
                            '5' => 'Only 5 Star',
                            '4' => 'Only 4 Star',
                            '3' => 'Only 3 Star',
                            '2' => 'Only 2 Star',
                            '1' => 'Only 1 Star',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'truncationlimit',
                    array(
                        'label' => 'Enter testimonial truncation limit.',
                        'value' => 100,
                    ),
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Count (number of Testimonial to show).',
                        'value' => 10,
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
        'title' => 'SES - Testimonial Showcase Plugin - View-Page',
        'description' => 'The recommended page is SES - Testimonial View Page. The testimonial can be viewed under this widget.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sestestimonial.view-page',
        'adminForm' => array(
        'elements' => array(
            array(
                'MultiCheckbox',
                'stats',
                array(
                    'label' => "Show Information in this widget.",
                    'multiOptions' => array(
                        'likecount' => 'Like Count',
                        'commentcount' => 'Comment Count',
                        'viewcount' => 'View Count',
                        'rating' => 'Ratings',
                    ),
                ),
            ),
          ),
        ),
    ),
    array(
        'title' => 'SES - Testimonial Showcase Plugin - Sidebar-Listview',
        'description' => 'Display testimonials in List view at the sidebar of the Page.',
        'category' => 'SES - Testimonial Showcase Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sestestimonial.sidebar-listview',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popularitycreteria',
                    array(
                        'label' => "Choose Popularity Creteria",
                        'multiOptions' => array(
                            'creation_date' => 'Recently Created',
                            'modified_date' => 'Recently Updated',
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'comment_count' => 'Most Commented',
                            'helpful_count' => 'Most Helpful',
                            'ratinghightolow' => 'Rating: High to Low',
                            'ratinglowtohigh' => 'Rating: Low to High',
                            'random' => 'Random',
                        ),
                    ),
                ),
                array(
                    'Select',
                    'rating',
                    array(
                        'label' => "Show Testimonial based on Rating",
                        'multiOptions' => array(
                            '' => '',
                            '5' => 'Only 5 Star',
                            '4' => 'Only 4 Star',
                            '3' => 'Only 3 Star',
                            '2' => 'Only 2 Star',
                            '1' => 'Only 1 Star',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'truncationlimit',
                    array(
                        'label' => 'Enter testimonial truncation limit.',
                        'value' => 100,
                    ),
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Count (number of Testimonial to show).',
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
);
