<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: content.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
return array(
    array(
        'title' => 'SNS - Coupon - Coupon Navigation Menu',
        'description' => 'Displays a navigation menu bar for the Coupon pages like Browse Coupon, Mange Coupon etc.',
        'category' => 'SNS - Advanced Discount & Coupon Plugin',
        'type' => 'widget',
        'name' => 'ecoupon.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SNS - Coupon - Profile linked widget.',
        'description' => 'This widget should be placed on profile pages of the plugin on which coupon will be created.',
        'category' => 'SNS - Advanced Discount & Coupon Plugin',
        'type' => 'widget',
        'name' => 'ecoupon.profile-offers',
              'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'show_criteria',
                  array(
                      'label' => "Choose from below the details that you want to show in this widget.",
                      'multiOptions' => array(
                          'title' => 'Coupon Title',
                          'couponPhoto' => 'Coupon Photo',
                          'startDate' => 'Show coupon start date',
                          'endDate' => 'Show coupon expiry date',
                          'couponCode' => 'Show coupon code',
                          'remaingCoupon' => 'Show left coupons',
                          'description' => 'Show Description',
                          'discount'=>'Discount',
                          'printButton'=>'Print Button',
                          'likeButton' => 'Like Button',
                          'favoriteButton' => 'Favorite Button',
                          'likeCount' => 'Likes Count',
                          'favoriteCount'=>'Favorite Count',
                          'commentCount'=>'Comment Count',
                          'viewCount' => 'View Count',
                          'couponUsed' =>'Coupon Used',
                          'featuredLabel' => 'Featured Label',
                          'verifiedLabel'=>'Verified Label',
                          'hotLabel'=>'Hot Label'
                      ),
                      'escape' => false,
                  )
              ),
              array(
                'Radio',
                'pagging',
                array(
                  'label' => "Do you want the Coupon to be auto-loaded when users scroll down the page?",
                  'multiOptions' => array(
                    'auto_load' => 'Yes, Auto Load',
                    'button' => 'No, show \'View more\' link.',
                    'pagging' => 'No, show \'Pagination\'.'
                  ),
                  'value' => 'auto_load',
                )
              ),
               array(
                  'Text',
                  'limit_data',
                  array(
                      'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
                      'value' => 10,
                  )
              ),
          ),
      ),
      'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Coupons - Profile - Coupon Content',
        'description' => 'Displays Coupon content according to the design chosen by the Instructor while creating or editing the Coupon. The recommended page for this widget is "SNS - Coupons - Profile View Page" ',
        'category' => 'SNS - Advanced Discount & Coupon Plugin',
        'type' => 'widget',
        'name' => 'ecoupon.coupon-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                              'title' => 'Coupon Title',
                              'couponPhoto' => 'Coupon Photo',
                              'startDate' => 'Show coupon start date',
                              'endDate' => 'Show coupon expiry date',
                              'couponCode' => 'Show coupon code',
                              'remaingCoupon' => 'Show left coupons',
                              'description' => 'Show Description',
                              'discount'=>'Discount',
                              'printButton'=>'Print Button',
                              'likeButton' => 'Like Button',
                              'favoriteButton' => 'Favorite Button',
                              'likeCount' => 'Likes Count',
                              'favoriteCount'=>'Favorite Count',
                              'commentCount'=>'Comment Count',
                              'viewCount' => 'View Count',
                              'couponUsed' =>'Coupon Used',
                              'featuredLabel' => 'Featured Label',
                              'verifiedLabel'=>'Verified Label',
                              'hotLabel'=>'Hot Label'
                        ),
                        'escape' => false,
                    )
                ),
            ),
        ),
    ),
    array(
      'title' => 'SNS - Coupons -Browse Coupons',
      'description' => 'Displays courses on browse courses page. ',
      'category' => 'SNS - Advanced Discount & Coupon Plugin',
      'type' => 'widget',
      'name' => 'ecoupon.browse-coupons',
      'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'show_criteria',
                  array(
                      'label' => "Choose from below the details that you want to show in this widget.",
                      'multiOptions' => array(
                          'title' => 'Coupon Title',
                          'couponPhoto' => 'Coupon Photo',
                          'startDate' => 'Show coupon start date',
                          'endDate' => 'Show coupon expiry date',
                          'couponCode' => 'Show coupon code',
                          'remaingCoupon' => 'Show left coupons',
                          'description' => 'Show Description',
                          'discount'=>'Discount',
                          'printButton'=>'Print Button',
                          'likeButton' => 'Like Button',
                          'favoriteButton' => 'Favorite Button',
                          'likeCount' => 'Likes Count',
                          'favoriteCount'=>'Favorite Count',
                          'commentCount'=>'Comment Count',
                          'viewCount' => 'View Count',
                          'couponUsed' =>'Coupon Used',
                          'featuredLabel' => 'Featured Label',
                          'verifiedLabel'=>'Verified Label',
                          'hotLabel'=>'Hot Label'
                      ),
                      'escape' => false,
                  )
              ),
              array(
                'Radio',
                'pagging',
                array(
                  'label' => "Do you want the Coupon to be auto-loaded when users scroll down the page?",
                  'multiOptions' => array(
                    'auto_load' => 'Yes, Auto Load',
                    'button' => 'No, show \'View more\' link.',
                    'pagging' => 'No, show \'Pagination\'.'
                  ),
                  'value' => 'auto_load',
                )
              ),
               array(
                  'Text',
                  'limit_data',
                  array(
                      'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
                      'value' => 10,
                  )
              ),
          ),
      ),
      'autoEdit' => true,
    ),
     array(
      'title' => 'SNS - Coupon - Manage Coupons',
      'description' => 'This widget should be placed only on SNS - Manage Coupons Page and this page displays all the user’s created coupon. From this page user can edit, delete their coupons.',
      'category' => 'SNS - Advanced Discount & Coupon Plugin',
      'type' => 'widget',
      'name' => 'ecoupon.manage-coupons',
      'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'show_criteria',
                  array(
                      'label' => "Choose from below the details that you want to show in this widget.",
                      'multiOptions' => array(
                          'title' => 'Coupon Title',
                          'couponPhoto' => 'Coupon Photo',
                          'startDate' => 'Show coupon start date',
                          'endDate' => 'Show coupon expiry date',
                          'couponCode' => 'Show coupon code',
                          'remaingCoupon' => 'Show left coupons',
                          'description' => 'Show Description',
                          'discount'=>'Discount',
                          'printButton'=>'Print Button',
                          'likeButton' => 'Like Button',
                          'favoriteButton' => 'Favorite Button',
                          'likeCount' => 'Likes Count',
                          'favoriteCount'=>'Favorite Count',
                          'commentCount'=>'Comment Count',
                          'viewCount' => 'View Count',
                          'couponUsed' =>'Coupon Used',
                          'featuredLabel' => 'Featured Label',
                          'verifiedLabel'=>'Verified Label',
                          'hotLabel'=>'Hot Label'
                      ),
                      'escape' => false,
                  )
              ),
              array(
                'Radio',
                'pagging',
                array(
                  'label' => "Do you want the Coupon to be auto-loaded when users scroll down the page?",
                  'multiOptions' => array(
                    'auto_load' => 'Yes, Auto Load',
                    'button' => 'No, show \'View more\' link.',
                    'pagging' => 'No, show \'Pagination\'.'
                  ),
                  'value' => 'auto_load',
                )
              ),
               array(
                  'Text',
                  'limit_data',
                  array(
                      'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
                      'value' => 10,
                  )
              ),
          ),
      ),
      'autoEdit' => true,
    ),
//       array(
//       'title' => 'SNS - Coupons - My Applied Coupons',
//       'description' => 'This widget should be placed only on SNS -  Applied Coupon Page and this page displays all the coupons which are used by the users.',
//       'category' => 'SNS - Advanced Discount & Coupon Plugin',
//       'type' => 'widget',
//       'name' => 'ecoupon.applied-coupons',
//       'adminForm' => array(
//           'elements' => array(
//               array(
//                   'MultiCheckbox',
//                   'show_criteria',
//                   array(
//                       'label' => "Choose from below the details that you want to show in this widget.",
//                       'multiOptions' => array(
//                           'title' => 'Coupon Title',
//                           'couponPhoto' => 'Coupon Photo',
//                           'startDate' => 'Show coupon start date',
//                           'endDate' => 'Show coupon expiry date',
//                           'couponCode' => 'Show coupon code',
//                           'remaingCoupon' => 'Show left coupons',
//                           'description' => 'Show Description',
//                           'discount'=>'Discount',
//                           'printButton'=>'Print Button',
//                           'likeButton' => 'Like Button',
//                           'favoriteButton' => 'Favorite Button',
//                           'likeCount' => 'Likes Count',
//                           'favoriteCount'=>'Favorite Count',
//                           'commentCount'=>'Comment Count',
//                           'viewCount' => 'View Count',
//                           'couponUsed' =>'Coupon Used',
//                           'featuredLabel' => 'Featured Label',
//                           'verifiedLabel'=>'Verified Label',
//                           'hotLabel'=>'Hot Label'
//                       ),
//                       'escape' => false,
//                   )
//               ),
//               array(
//                 'Radio',
//                 'pagging',
//                 array(
//                   'label' => "Do you want the Coupon to be auto-loaded when users scroll down the page?",
//                   'multiOptions' => array(
//                     'auto_load' => 'Yes, Auto Load',
//                     'button' => 'No, show \'View more\' link.',
//                     'pagging' => 'No, show \'Pagination\'.'
//                   ),
//                   'value' => 'auto_load',
//                 )
//               ),
//                array(
//                   'Text',
//                   'limit_data',
//                   array(
//                       'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
//                       'value' => 10,
//                   )
//               ),
//           ),
//       ),
//       'autoEdit' => true,
//     ),
    array(
      'title' => 'SNS - Coupons - Coupon Of The Day',
      'description' => "This widget displays Coupons of the Day as chosen by you from the Edit Settings of this widget.",
      'category' => 'SNS - Advanced Discount & Coupon Plugin',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'ecoupon.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                      array(
                        'label' => "Choose from below the details that you want to show for coupon in this widget.",
                            'multiOptions' => array(
                                'title' => 'Coupon Title',
                                'couponPhoto' => 'Coupon Photo',
                                'startDate' => 'Show coupon start date',
                                'endDate' => 'Show coupon expiry date',
                                'couponCode' => 'Show coupon code',
                                'remaingCoupon' => 'Show left coupons',
                                'description' => 'Show Description',
                                'discount'=>'Discount',
                                'printButton'=>'Print Button',
                                'likeButton' => 'Like Button',
                                'favoriteButton' => 'Favorite Button',
                                'likeCount' => 'Likes Count',
                                'favoriteCount'=>'Favorite Count',
                                'commentCount'=>'Comment Count',
                                'viewCount' => 'View Count',
                                'couponUsed' =>'Coupon Used',
                                'featuredLabel' => 'Featured Label',
                                'verifiedLabel'=>'Verified Label',
                                'hotLabel'=>'Hot Label'
                            ),
                            'escape' => false,
                      )
                ),
                array(
                'Text',
                'title_truncation',
                    array(
                        'label' => 'Coupon Title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Coupon Description truncation limit.',
                        'value' => 60,
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
                        'label' => 'Enter the height of block (in pixels).',
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
                        'label' => 'Enter the width of block (in pixels).',
                        'value' => '180',
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
      'title' => 'SNS - Coupons - Breadcrumb',
      'description' => ' This widget displays breadcrumb for the SNS - Coupons - View Page.',
      'category' => 'SNS - Advanced Discount & Coupon Plugin',
      'type' => 'widget',
      'name' => 'ecoupon.breadcrumb',
      'autoEdit' => true,
    ),
)

?>
