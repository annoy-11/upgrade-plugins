<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Admin_Tabbed extends Engine_Form {

    public function init() {

        $this->addElement('Select', "tabOption", array(
            'label' => 'Show Tab Type?',
            'multiOptions' => array(
                'default' => 'Default',
                'advance' => 'Advanced',
                'filter'=>'Filter',
                'vertical'=>'Vertical',
            ),
            'value' => 'advance',
        ));

        $this->addElement('Select', "htmlTitle", array(
            'label' => 'Do you want to show HTML title on view type?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => 'advance',
        ));

        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.pluginactivated')) {
            $categories = Engine_Api::_()->getDbtable('categories', 'sesdiscussion')->getCategoriesAssoc();
            $categories = array('' => '') + $categories;
            // category field
            $this->addElement('Select', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
                'allowEmpty' => true,
                'required' => false,
            ));
        }

        $this->addElement('MultiCheckbox', "show_criteria", array(
            'label' => "Choose from below the details that you want to show in this widget.",
            'multiOptions' => array(
                "title" => "Title",
                "likecount" => "Likes Count",
                "favouritecount" => "Favourites Count",
                "commentcount" => "Comments Count",
                "viewcount" => "Views Count",
                "postedby" => "Discussion Owner's Name",
                "posteddate" => "Posted Date",
                'source' => "Link",
                'voting' => "Voting",
                'category' => "Category",
                'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                'newlabel' => "New Label",
                'tags' => 'Tags',
                'description' => 'Discussion Description',
                'likebutton' => 'Like Button',
                'favouritebutton' => 'Favourite Button',
                "followcount" => "Follows Count",
                'followbutton' => 'Follow Button',
                "permalink" => "Permalink",
            ),
            'escape' => false,
        ));

        //Social Share Plugin work
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {

            $this->addElement('Select', "socialshare_enable_pinviewplusicon", array(
                'label' => "Enable plus (+) icon for social share buttons in List View?",
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => 1,
            ));

            $this->addElement('Text', "socialshare_icon_pinviewlimit", array(
                'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View. Other social sharing icons will display on clicking this plus icon.',
                'value' => 2,
                'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
                )
            ));
        }
        //Social Share Plugin work

        $this->addElement('Select', "show_limited_data", array(
            'label' => 'Show only the number of discussions entered in above setting. [If you choose No, then you can choose how do you want to show more discussions in this widget.]',
            'multiOptions' => array(
                'yes' => 'Yes',
                'no' => 'No',
            ),
            'value' => 'no',
        ));

        $this->addElement('Radio', "pagging", array(
            'label' => "Do you want the discussions to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
                'auto_load' => 'Yes, Auto Load',
                'button' => 'No, show \'View more\' link.',
                'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'auto_load',
        ));

        $this->addElement('Text', "limit_data_list", array(
            'label' => 'Count for List View (number of discussions to show).',
            'value' => 10,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));

        $this->addElement('MultiCheckbox', "search_type", array(
            'label' => "Choose from below the Tabs that you want to show in this widget.",
            'multiOptions' => array(
                'recentlySPcreated' => 'Recently Created',
                'mostSPviewed' => 'Most Viewed',
                'mostSPliked' => 'Most Liked',
                'mostSPcommented' => 'Most Commented',
                'mostSPfavourite' => 'Most Favourite',
            ),
        ));

        // setting for Recently Created
        $this->addElement('Dummy', "dummy1", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Recently Created' Tab</span>",
        ));
        $this->getElement('dummy1')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "recentlySPcreated_order", array(
            'label' => "Order of this Tab.",
            'value' => '1',
        ));
        $this->addElement('Text', "recentlySPcreated_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Recently Created',
        ));

        // setting for Most Viewed
        $this->addElement('Dummy', "dummy2", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Viewed' Tab</span>",
        ));
        $this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "mostSPviewed_order", array(
            'label' => "Order of this Tab.",
            'value' => '2',
        ));
        $this->addElement('Text', "mostSPviewed_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Most Viewed',
        ));

        // setting for Most Liked
        $this->addElement('Dummy', "dummy3", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Liked' Tab</span>",
        ));
        $this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "mostSPliked_order", array(
            'label' => "Order of this Tab.",
            'value' => '3',
        ));
        $this->addElement('Text', "mostSPliked_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Most Liked',
        ));

        // setting for Most Commented
        $this->addElement('Dummy', "dummy4", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Commented' Tab</span>",
        ));
        $this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "mostSPcommented_order", array(
            'label' => "Order of this Tab.",
            'value' => '4',
        ));
        $this->addElement('Text', "mostSPcommented_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Most Commented',
        ));


        // setting for Most Favourite
        $this->addElement('Dummy', "dummy6", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favourite' Tab</span>",
        ));
        $this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "mostSPfavourite_order", array(
            'label' => "Order of this Tab.",
            'value' => '6',
        ));
        $this->addElement('Text', "mostSPfavourite_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Most Favourite',
        ));
    }
}
