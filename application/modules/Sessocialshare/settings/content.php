<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$socialshare_enable_plusicon = array(
    'Select',
    'socialshare_enable_plusicon',
    array(
        'label' => "Enable More Icon to view all social share buttons?",
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
    'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this more icon.',
    'value' => 4,
  ),
);

return array(
  array(
    'title' => 'SES - Social Share Services in Buttons View',
    'description' => 'This widget displays the social networking services in Buttons View. Edit this widget to configure various settings.',
    'category' => 'SES - Professional Share Plugin – Inside and Outside Site Sharing',
    'type' => 'widget',
    'name' => 'sessocialshare.social-share',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'showTitle',
          array(
              'label' => "Do you want to show the Share(s) text for each social networking service?",
              'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
              ),
          )
        ),
        array(
          'Text',
          'height',
          array(
            'label' => 'Enter the height of one button (in pixels).',
            'value' => '64',
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
                'label' => 'Enter the width of one button (in pixels).',
                'value' => '64',
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
            'Select',
            'showTitleTip',
            array(
                'label' => "Show Title Tip?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        $socialshare_icon_limit,
        $socialshare_enable_plusicon,
//         array(
//           'Text',
//           'shareText',
//           array(
//             'label' => 'Enter the "Share" text.',
//             'value' => 'Share',
//           )
//         ),
        array(
            'Select',
            'showCount',
            array(
                'label' => "Do you want to show number of shares in this widget?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'showCountnumber',
          array(
            'label' => 'Enter minimum share count, after which share counts will display in this widget.',
            'value' => '100',
          )
        ),

      ),
    ),
  ),
  array(
    'title' => 'SES - Social Share Services in Flat / Square View',
    'description' => 'This widget displays the social networking services in Flat or Square View. Edit this widget to configure various settings.',
    'category' => 'SES - Professional Share Plugin – Inside and Outside Site Sharing',
    'type' => 'widget',
    'name' => 'sessocialshare.sociallinks',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label'=>'Choose the view type for social share services.',
            'multiOptions' => array('1'=>'Flat View','2'=>'Square View'),
            'value' => '1',
          )
        ),
        array(
            'Select',
            'showShareText',
            array(
                'label' => "Do you want to show the Share(s) text for each social networking service?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
            'Select',
            'showTitleTip',
            array(
                'label' => "Show Title Tip?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        $socialshare_icon_limit,
        $socialshare_enable_plusicon,
        array(
            'Select',
            'showCount',
            array(
                'label' => "Do you want to show number of shares in this widget?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'showCountnumber',
          array(
            'label' => 'Enter minimum share count, after which share counts will display in this widget.',
            'value' => '100',
          )
        ),
        array(
            'Text',
            'width',
            array(
                'label' => 'Enter the width of one block (in pixels).',
                'value' => '89',
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
    'title' => 'SES - Sticky Social Share Sidebar',
    'description' => 'This widget displays all the social networking services enabled from the admin panel of this plugin and will stick to the right or left sidebar. If you want to enable sticky social share button on all the pages, then place this widget in Header or Footer of your website. Edit this widget to choose the placement of this widget and configure other settings.',
    'category' => 'SES - Professional Share Plugin – Inside and Outside Site Sharing',
    'type' => 'widget',
    'name' => 'sessocialshare.sidebar-social-share',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'position',
          array(
            'label'=>'Choose the placement of this widget.',
            'multiOptions' => array('1'=>'In Right Side','2'=>'In Left Side'),
            'value' => '1',
          )
        ),
        $socialshare_icon_limit,
        $socialshare_enable_plusicon,
        array(
          'Text',
          'margin',
          array(
            'label' => 'Enter the value for the top margin of this widget.',
            'value' => '30',
          )
        ),
        array(
          'Select',
          'margintype',
          array(
            'label' => 'Choose the unit of margin.',
            'multiOptions' => array('pix'=>'Pixels (px)','per'=>'Percentage (%)'),
            'value' => 1,
            'required' => true
          )
        ),
        array(
          'Text',
          'radius',
          array(
            'label' => 'Enter the radius of the social share buttons.',
            'value' => '5',
          )
        ),
        array(
            'Select',
            'showCount',
            array(
                'label' => "Do you want to show number of shares for each social networking service.",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
            'Select',
            'showTitleTip',
            array(
                'label' => "Do you want to show tip when users mouse over on the social networking service button?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Select',
          'showtotalshare',
          array(
            'label' => "Do you want to show total share counts in this widget?",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
            ),
          )
        ),
        array(
          'Text',
          'showCountnumber',
          array(
            'label' => 'Enter minimum share count, after which share counts will display in this widget.',
            'value' => '100',
          )
        ),
        array(
          'Select',
          'showsharedefault',
          array(
            'label' => "Do you want to hide the sticky social share side bar by default? If you choose Yes, then users will see the arrow icon to make it visible and share the content from your website.",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
            ),
            'value' => 0,
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Automatic Sharing Fly-Ins',
    'description' => 'This widget enables automatic fly-ins for sharing the pages of your website on which it is placed when users scroll down on the page. If you want to enable automatic fly-ins on all the pages, then place this widget in Header or Footer of your website. Edit this widget to choose the placement of the fly-in.',
    'category' => 'SES - Professional Share Plugin – Inside and Outside Site Sharing',
    'type' => 'widget',
    'name' => 'sessocialshare.bottom-share-popup',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'description',
          array(
            'label' => 'Description of this widget.',
            'value' => 'Share this page with your family and friends.',
          )
        ),
        array(
            'Select',
            'position',
            array(
                'label' => "Choose the placement of this widget.",
                'multiOptions' => array(
                  '1' => 'Bottom Right Corner of Screen',
                  '2' => 'Bottom Left Corner of Screen',
                ),
            )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
            'Select',
            'showCount',
            array(
                'label' => "Do you want to show number of shares in this widget?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'showminimumnumber',
          array(
            'label' => 'Enter minimum share count, after which share counts will display in this widget.',
            'value' => '100',
          )
        ),
        array(
            'Select',
            'showtotalshare',
            array(
                'label' => "Do you want to show total share counts in this widget?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
      ),
    ),
  ),
);
