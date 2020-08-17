<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sessocialtube")) {
  $results = Engine_Api::_()->getDbtable('banners', 'sessocialtube')->getBanner(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
  }
}
$banner_options[] = '';
$path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
foreach ($path as $file) {
  if ($file->isDot() || !$file->isFile())
    continue;
  $base_name = basename($file->getFilename());
  if (!($pos = strrpos($base_name, '.')))
    continue;
  $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
  if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
    continue;
  $banner_options['public/admin/' . $base_name] = $base_name;
}

if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')) {
  $videopluginWidget = array(
    array(
    'title' => 'SES - Responsive SocialTube Theme - Popularity Videos Widget',
    'description' => 'Displays a videos according to popularity. This widget is only place on landing page.',
    'category' => 'SES - Responsive SocialTube Theme',
    'type' => 'widget',
    'name' => 'sessocialtube.popularity-videos',
    'adminForm' => array(
    'elements' => array(
          array(
              'Select',
              'backgroundimage',
              array(
                  'label' => 'Choose the Background Image to be shown in this widget.',
                  'multiOptions' => $banner_options,
                  'value' => '',
              )
          ),
          array(
              'Select',
              'popularity',
              array(
                  'label' => 'Popularity Criteria',
                  'multiOptions' => array(
                      'is_featured' => 'Only Featured',
                      'is_sponsored' => 'Only Sponsored',
                      'is_hot' => 'Only Hot',
                      'view_count' => 'Most Viewed',
                      'like_count' => 'Most Liked',
                      'creation_date' => 'Most Recent',
                      'modified_date' => 'Recently Updated',
                      'favourite_count' => "Most Favorite",
                  ),
                  'value' => 'creation_date',
              )
          ),
          array(
              'Text',
              'textVideo',
              array(
                  'label' => 'Text Heading For Videos.',
                  'value' => 'Videos we love',
              )
          ),
          array(
              'MultiCheckbox',
              'show_criteria',
              array(
                  'label' => "Data show in videos ?",
                  'multiOptions' => array(
                      'like' => 'Likes',
                      'comment' => 'Comments',
                      'rating' => 'Ratings',
                      'favourite'=>'Favourite',
                      'view' => 'Views',
                      'title' => 'Titles',
                      'by' => 'Item Owner Name',
                  ),
              )
          ),
          array(
              'Text',
              'video_limit',
              array(
                  'label' => 'count (number of videos to show).',
                  'value' => '10',
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
                  'label' => 'Enter the height of one block (in pixels,this setting will effect after 3 designer blocks).',
                  'value' => '160px',
              )
          ),
          array(
              'Text',
              'width',
              array(
                  'label' => 'Enter the width of one block (in pixels,this setting will effect after 3 designer blocks).',
                  'value' => '160px',
              )
          ),
        ),
      ),
    ),
  );
}

$socialtube_theme_widget = array(
		array(
			'title' => 'SES - Responsive SocialTube Theme - Custom browse Menu',
			'description' => "",
			'category' => 'SES - Responsive SocialTube Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'sessocialtube.custom-browse-menu',
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Banner Slideshow',
        'description' => 'You can place this widget anywhere. You can choose Slideshow in this widget. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'name' => 'sessocialtube.banner-slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'banner_id',
                    array(
                        'label' => 'Choose the Banner to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this Banner in full width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of this Banner (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Landing Page Widget - 1',
        'description' => 'This is only for landing Page Only',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sessocialtube.landing-page-widget',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
          'elements' => array(
              array(
                  'Select',
                  'sidebarimage',
                  array(
                      'label' => 'Choose the Sidebar image to be shown in this widget.',
                      'multiOptions' => $banner_options,
                      'value' => '',
                  )
              ),
              array(
                  'Text',
                  'titleheading',
                  array(
                      'label' => 'Enter text for Heading to be shown in this widget.',
                      'value' => '',
                  )
              ),
              array(
                  'Textarea',
                  'description',
                  array(
                      'label' => "Enter description to be shown in this widget.",
                      'multiOptions' => array(
                          '1' => 'Yes',
                          '0' => 'No',
                      ),
                      'value' => '',
                  )
              ),
              array(
                  'Text',
                  'buttontext',
                  array(
                      'label' => 'Enter button text to be shown in this widget.',
                      'value' => '',
                  ),
              ),
              array(
                  'Text',
                  'buttonlink',
                  array(
                      'label' => 'Enter button link to redirect when any user click on button to be shown in this widget.',
                      'value' => '',
                  ),
              ),
          )
        ),
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Landing Page Widget',
        'description' => 'Display content in this widget by Global Settings. This is only for landing Page Only',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sessocialtube.landing-page-text',
        'defaultParams' => array(
            'title' => '',
        ),
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Scroll Top to Bottom',
        'description' => 'Displays a "Scroll Top to Bottom" button on the page on which this widget is placed. If you want this "Scroll Top to Bottom" button to appear on all the pages of your site, then just place the widget in the Footer of your site.',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'name' => 'sessocialtube.scroll-bottom-top',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Header',
        'description' => 'This widget displays the header of your website and includes Site Logo, Main Menu, Mini Menu and Global Search.',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sessocialtube.header',
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Members',
        'description' => "Displays members of your site in Carousel or Cloud.",
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sessocialtube.members',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showType',
                    array(
                        'label' => "Show Type",
                        'multiOptions' => array(
                            '1' => 'Carousel',
                            '0' => 'Cloud',
                        ),
                        'value' => 1,
                    )
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
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Footer Menu',
        'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor.',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'name' => 'sessocialtube.footer',
    ),
    array(
        'title' => 'SES - Responsive SocialTube Theme - Paralex Effect Widget',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - Responsive SocialTube Theme',
        'type' => 'widget',
        'name' => 'sessocialtube.paralex',
        'adminForm' => 'Sessocialtube_Form_Admin_Paralex',
    ),
);

if (!empty($videopluginWidget)) {
  $socialtube_theme_widget = array_merge($socialtube_theme_widget, $videopluginWidget);
}
return $socialtube_theme_widget;