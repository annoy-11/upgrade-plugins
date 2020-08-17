<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'Team Showcase - Site / Non-Site Team Navigation Menu',
        'description' => 'Displays a navigation menu bar in the Team Showcase & Multi-Use Team Plugin pages.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'Team Showcase - Featured / Sponsored Team Members SlideShow',
        'description' => 'This widget displays slideshow of Featured or Sponsored Site Team Members / Non Iite Team Members.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.slideshows',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => "Display Members",
                        'multiOptions' => array(
                            'featured' => 'Only Featured Members',
                            'sponsored' => 'Only Sponsored Members',
                        ),
                        'value' => 'featured',
                    ),
                ),
                array(
                    'Select',
                    'sesteam_type',
                    array(
                        'label' => "Choose Member Type to be shown in this widget.",
                        'multiOptions' => array(
                            'teammember' => 'Site Team Members',
                            'nonsitemember' => 'Non-Site Team Members',
                        ),
                        'value' => 'teammember',
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'infoshow',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'displayname' => 'Display Name',
                            'designation' => 'Designation',
                            'description' => 'Short Description',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'location' => 'Location',
                            'website' => 'Website',
                            'facebook' => 'Facebook Icon',
                            'linkdin' => 'LinkedIn Icon',
                            'twitter' => 'Twitter Icon',
                            'googleplus' => 'Google Plus Icon',
                            'viewMore' => 'more',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'viewMoreText',
                    array(
                        'label' => 'Enter the text for "more"',
                    ),
                    'value' => 'more',
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Count (number of members to show)',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                )
            ),
        ),
    ),
    array(
        'title' => 'Team Showcase - Browse Site / Non-Site Team Members Page Link',
        'description' => 'Displays a link to \'Browse Site Team Members Page\' Link or \'Browse Non-Site Team Members Page\' link. Edit this widget to choose the link.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.browsenonsite-menu-quick',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'sesteamType',
                    array(
                        'label' => "Choose the page to be linked from this widget.",
                        'multiOptions' => array(
                            'sitemember' => 'Browse Site Team Members Page',
                            'nonmember' => 'Browse Non-Site Team Members Page',
                        ),
                        'value' => 'nonmember',
                    ),
                ),
                array(
                    'Text',
                    'linkText',
                    array(
                        'label' => 'Enter text for the link.',
                    ),
                    'value' => 'Browse Non-Site Team',
                ),
            ),
        ),
    ),
    array(
        'title' => 'Team Showcase - Site Team / Non-Site Team Members of the Day',
        'description' => 'This widget displays site team members or non-site team members as \'Team Member of the Day\' randomly as choosen by you from the admin panel of this plugin.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.oftheday',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'sesteamType',
                    array(
                        'label' => "Choose Member Type to be shown in this widget.",
                        'multiOptions' => array(
                            'teammember' => 'Site Team Members',
                            'nonsitemember' => 'Non-Site Team Members',
                        ),
                        'value' => 'teammember',
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'infoshow',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'displayname' => 'Display Name',
                            'designation' => 'Designation',
                            'description' => 'Short Description',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'location' => 'Location',
                            'website' => 'Website',
                            'facebook' => 'Facebook Icon',
                            'linkdin' => 'LinkedIn Icon',
                            'twitter' => 'Twitter Icon',
                            'googleplus' => 'Google Plus Icon',
                            'viewMore' => 'More as Team Member',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'viewMoreText',
                    array(
                        'label' => 'Enter the text for "more"',
                    ),
                    'value' => 'more',
                ),
            ),
        ),
    ),
    array(
        'title' => 'Team Showcase - Site / Non-Site Team Members Browse Search',
        'description' => 'Displays a search form in the Browse Site Team / Non-Site Members Page.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesteam.search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'sesteamType',
                    array(
                        'label' => "Choose Member Type to be shown in this widget.",
                        'multiOptions' => array(
                            'teammember' => 'Site Team Members',
                            'nonsitemember' => 'Non-Site Team Members',
                        ),
                        'value' => 'teammember',
                    ),
                ),
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical',
                        ),
                        'value' => 'horizontal',
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'Team Showcase - Browse Site / Non-site Team',
        'description' => 'This widget should be placed on "Browse Site Team Page" or "Browse Non-Site Team Page" only.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.browse-team',
        'adminForm' => 'Sesteam_Form_Admin_BrowseTeamPageSettings',
    ),
    array(
        'title' => 'Team Showcase - Site / Non-Site Team Members with Template Choice',
        'description' => 'Displays site / non-site team members. You can choose a template design to show team members in this widget.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.team-page',
        'adminForm' => 'Sesteam_Form_Admin_TeamPageSettings',
    ),
    array(
        'title' => 'Team Showcase - Site / Non-Site Team Members for Left / Right column',
        'description' => 'Displays site / non-site team members in the left / right column.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.team-members',
        'defaultParams' => array(
            'title' => 'Team Members',
        ),
        'adminForm' => 'Sesteam_Form_Admin_TeamMembersSettings',
    ),
    array(
        'title' => 'Team Showcase - Site / Non-Site Team Member Details',
        'description' => 'This widget displays all details of a site / non-site team member.The recommended page for this widget is "Team Showcase - Non-Site Team Member Profile Page" or "Member Profile Page".',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.profile-nonsiteteam',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'infoshow',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'profilePhoto' => "Profile Photo",
                            'displayname' => 'Display Name',
                            'designation' => 'Designation',
                            'detaildescription' => 'About Member (Detailed Description)',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'location' => 'Location',
                            'website' => 'Website',
                            'facebook' => 'Facebook Icon',
                            'linkdin' => 'LinkedIn Icon',
                            'twitter' => 'Twitter Icon',
                            'googleplus' => 'Google Plus Icon'
                        ),
                    ),
                ),
                array(
                    'Text',
                    'descriptionText',
                    array(
                        'label' => 'Enter the text for "Description"',
                    ),
                    'value' => 'more',
                ),
            )
        ),
    ),
    array(
        'title' => 'Team Showcase - Browse Members',
        'description' => 'Displays site members. You can choose a template design to show members in this widget.',
        'category' => 'Team Showcase & Multi-Use Team Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesteam.browse-members',
        'adminForm' => 'Sesteam_Form_Admin_BrowseMemebrsSettings',
    ),
);
?>
