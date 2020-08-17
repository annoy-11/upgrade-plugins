<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AlbumTabbed.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Admin_AlbumTabbed extends Engine_Form {

  public function init() {

		$this->addElement('Radio', "tab_option", array(
			'label' => "Choose the design of the tabs.",
      'multiOptions' => array(
        'default' => 'Default SE Tabs',
        'advance' => 'Advanced Tabs',
        'filter' =>'Advanced Tabs like Buttons'
      ),
      'value' => 'filter',
    ));

		$this->addElement('Radio', "showdefaultalbum", array(
			'label' => "Do you want to show default album in this widget?",
      'multiOptions' => array(
        '1' => 'Yes',
        '0' => 'No',
      ),
      'value' => '0',
    ));

		$this->addElement('Select', "insideOutside", array(
			'label' => 'Choose where do you want to show the statistics of albums.',
        'multiOptions' => array(
            'inside' => 'Inside the Album Block',
						'outside' => 'Outside the Album Block',
        ),
        'value' => 'inside',
    ));
		$this->addElement('Select', "fixHover", array(
			'label' => 'Show album statistics Always or when users Mouse-over on album blocks (this setting will work only if you choose to show information inside the Album block.)',
        'multiOptions' => array(
           'fix' => 'Always',
					 'hover' => 'On Mouse-over',
					),
						'value' => 'always',
    ));
		$this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'businessname' => "Business Name",
            'featured' => "Featured Label",
            "sponsored" => "Sponsored Label",
						'like' => 'Likes Count',
						'comment' => 'Comments Count',
						'view' => 'Views Count',
						'title' => 'Album Title',
						'by' => 'Owner\'s Name',
						'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
						'favouriteCount' => 'Favourites Count',
						'photoCount' => 'Photos Count',
						'likeButton' =>'Like Button',
						'favouriteButton' =>'Favourite Button',
        ),
        'escape' => false,
    ));

    //Social Share Plugin work
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')) {

      $this->addElement('Select', "socialshare_enable_plusicon", array(
        'label' => "Enable More Icon for social share buttons?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Text', "socialshare_icon_limit", array(
          'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
    }
    //Social Share Plugin work

		$this->addElement('Select', "show_item_count", array(
			'label' => 'Show Albums count in this widget',
			'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '0',
    ));

		$this->addElement('Text', "limit_data", array(
			'label' => 'count (number of albums to show).',
        'value' => 20,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Select', "show_limited_data", array(
			'label' => 'Show only the number of albums entered in above setting. [If you choose No, then you can choose how do you want to show more albums in this widget in below setting.]',
			'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '0',
    ));
		$this->addElement('Radio', "pagging", array(
			'label' => "Do you want the albums to be auto-loaded when users scroll down the page? [This setting will work if you choose 'No' in the above setting.]",
					'multiOptions' => array(
					'auto_load' => 'Yes, Auto Load.',
					'button' => 'No, show \'View more\' link.',
					'pagging' =>'No, show \'Pagination\'.'
			),

        'value' => 'auto_load',
    ));
		$this->addElement('Text', "title_truncation", array(
			'label' => 'Album title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "height", array(
			'label' => 'Enter the height of one block (in pixels).',
        'value' => '160',
    ));
		$this->addElement('Text', "width", array(
			'label' => 'Enter the width of one block (in pixels).',
        'value' => '140',
    ));
		$this->addElement('MultiCheckbox', "search_type", array(
			 'label' => "Choose Popularity Criteria.",
			'multiOptions' => array(
					'recentlySPcreated' => 'Recently Created',
					'mostSPviewed' => 'Most Viewed',
					'mostSPfavourite' => 'Most Favourite',
					'mostSPliked' => 'Most Liked',
					'mostSPcommented' => 'Most Commented',
					'featured' => "Featured",
					"sponsored" => "Sponsored",
			),
    ));

	 //Recently Created
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
		// setting for Most Favourite

				$this->addElement('Dummy', "dummy3", array(
			 'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favorite' Tab</span>",
    ));

		$this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "mostSPfavourite_order", array(
			'label' => "Order of this Tab.",
			'value' => '2',
    ));
		$this->addElement('Text', "mostSPfavourite_label", array(
     		'label' => 'Title of this Tab.',
			'value' => 'Most Favourite',
    ));
		// setting for Most Downloaded


		// setting for Most Liked
		$this->addElement('Dummy', "dummy5", array(
			 'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Liked' Tab</span>",
    ));

		$this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "mostSPliked_order", array(
			'label' =>'Order of this Tab.',
			'value' => '3',
    ));
		$this->addElement('Text', "mostSPliked_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Liked',
    ));
		// setting for Most Commented

		$this->addElement('Dummy', "dummy6", array(
			 'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Commented' Tab</span>",
    ));

		$this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "mostSPcommented_order", array(
			'label' =>'Order of this Tab.',
			'value' => '4',
    ));
		$this->addElement('Text', "mostSPcommented_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Commented',
    ));

		$this->addElement('Dummy', "dummy7", array(
			 'label' => "<span style='font-weight:bold;'>Order and Title of 'Featured' Tab</span>",
    ));

		$this->getElement('dummy7')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "featured_order", array(
			'label' =>'Order of this Tab.',
			'value' => '5',
    ));
		$this->addElement('Text', "featured_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Featured',
    ));


		$this->addElement('Dummy', "dummy8", array(
			 'label' => "<span style='font-weight:bold;'>Order and Title of 'Sponsored' Tab</span>",
    ));

		$this->getElement('dummy8')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "sponsored_order", array(
			'label' =>'Order of this Tab.',
			'value' => '6',
    ));
		$this->addElement('Text', "sponsored_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Sponsored',
    ));


  }
}
