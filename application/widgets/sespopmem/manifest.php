<?php
return array (
  'package' =>
  array (
    'type' => 'widget',
    'name' => 'sespopmem',
    'version' => '4.10.3',
    'path' => 'application/widgets/sespopmem',
    'title' => 'SES - Popular Members',
    'description' => 'SES - Popular Members',
    'author' => 'SocialEngineSolutions',
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'remove',
    ),
    'directories' =>
    array (
      0 => 'application/widgets/sespopmem',
    ),
  ),
  'type' => 'widget',
  'name' => 'sespopmem',
  'version' => '4.10.3',
  'title' => 'SES - Popular Members',
  'description' => 'SES - Popular Members',
  'category' => 'SES - Widgets',
    'adminForm' => array(
        'elements' => array(
            array(
                'Select',
                'popularitycriteria',
                array(
                    'label' => 'Choose the popularity criteria in this widget.',
                    'multiOptions' => array(
                    'creation_date' => 'Recently Created',
                    'modified_date' => 'Recently Modified',
                    'view_count' => 'Most Viewed',
                    'like_count' => 'Most Liked',
                    'comment_count' => 'Most Commented',
                    'member_count' => 'Most Friends',
                    'random' => "Random Members",
                    ),
                ),
            ),
            array(
                'Radio',
                'heading',
                array(
                    'label' => "Do you want to show total member's count on your site in this widget?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    'value' => 1,
                )
            ),
            array(
                'Text',
                'memberCount',
                array(
                    'label' => 'Enter number of members to
                    be shown in this widget.',
                    'value' => 33,
                )
            ),
            array(
                'Radio',
                'showTitle',
                array(
                    'label' => "Do you want to show title ?",
                    'multiOptions' => array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    'value' => 1,
                )
            ),
            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter height [in px] of members to be shown in this widget.',
                    'value' => 150,
                ),
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter width [in px] of members to be shown in this widget.',
                    'value' => 148,
                ),
            ),
        )
    ),
);
