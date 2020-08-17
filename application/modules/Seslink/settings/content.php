<?php

return array(
array(
    'title' => "SES Links - Browse Links",
    'description' => 'This widget display links. This widget is only placed on Browse Links Page.',
    'category' => 'SES - Links Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'seslink.browse-links',
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
              "postedby" => "Link Owner's Name",
              "posteddate" => "Posted Date",
              "category" => "Category",
              "permalink" => "Permalink",
            ), 
            'escape' => false,
          ),
        ),
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter width of pinboard view',
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
    'title' => 'SES - External Link and Topic Sharing - Breadcrumb for Link View Page',
    'description' => 'Displays breadcrumb for Link. This widget should be placed on the SES - External Link and Topic Sharing - Link View Page.',
    'category' => 'SES - Links Plugin',
    'type' => 'widget',
    'name' => 'seslink.breadcrumb',
  ),
  array(
    'title' => 'SES - External Link and Topic Sharing - Link Browse Menu',
    'description' => 'Displays a menu in the link browse page.',
    'category' => 'SES - Links Plugin',
    'type' => 'widget',
    'name' => 'seslink.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - External Link and Topic Sharing - Link Browse Search',
    'description' => 'Displays a search form in the link browse page.',
    'category' => 'SES - Links Plugin',
    'type' => 'widget',
    'name' => 'seslink.browse-search',
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
);