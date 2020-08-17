<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_WishlistTabbed extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
      'label' => "Choose the View Type for Products.",
      'multiOptions' => array(
      'list' => 'List View',
      'grid' => 'Grid View',
      'pinboard' => 'Pinboard View',
      'map' => 'Map View',
      ),
    ));

    $this->addElement('Select', "openViewType", array(
      'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
      'multiOptions' => array(
	    'list' => 'List View',
      'grid' => 'Grid View',
      'pinboard' => 'Pinboard View',
      'map' => 'Map View',
      ),
    ));
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
   if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.pluginactivated')) {
   $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc();
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
        'featuredLabel' => 'Featured Label',
        'sponsoredLabel' => 'Sponsored Label',
        'verifiedLabel' => 'Verified Label',
        'favouriteButton' => 'Favourite Button',
        'location'=>'Location',
        'likeButton' => 'Like Button',
        'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
        'like' => 'Like Counts',
        'favourite' => 'Favourite Counts',
        'comment' => 'Comment Counts',
        'rating' => 'Rating Starts',
        'view' => 'View Counts',
        'title' => 'Product Titles',
        'category' => 'Category',
        'quickView' => 'quick view',
        'creationDate' => 'Creation Date',
        'descriptionlist' => 'Description (In List View)',
        'descriptiongrid' => 'Description (In Grid View)',
        'descriptionpinboard' => 'Description (In Pinboard View)',
        'enableCommentPinboard'=>'Enable commenting in Pinboard View',
         'price' =>'Price',
         'discount' =>'Discount',
         'stock' =>'Stock',
         'storeName' => 'Store Name & Photo',
         'addCart' => 'Add to Cart',
         'addWishlist' => 'Add to wishlist',
         'addCompare' =>'Add to Compare',
         'brand' => 'Brand Name',
         'offer' =>'Offer',
         'totalProduct' =>'Total Product',
      ),
      'escape' => false,
    ));

    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {

      $this->addElement('Select', "socialshare_enable_listview1plusicon", array(
        'label' => "Enable plus (+) icon for social share buttons in List View?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Text', "socialshare_icon_listview1limit", array(
          'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View. Other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));

      $this->addElement('Select', "socialshare_enable_gridview1plusicon", array(
        'label' => "Enable plus (+) icon for social share buttons in Grid View?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Text', "socialshare_icon_gridview1limit", array(
          'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View. Other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));


      $this->addElement('Select', "socialshare_enable_pinviewplusicon", array(
        'label' => "Enable plus (+) icon for social share buttons in Pinboard View?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Text', "socialshare_icon_pinviewlimit", array(
          'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Pinboard View. Other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));


      $this->addElement('Select', "socialshare_enable_mapviewplusicon", array(
        'label' => "Enable plus (+) icon for social share buttons in Map View?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Text', "socialshare_icon_mapviewlimit", array(
          'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Map View. Other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));

    }
    //Social Share Plugin work

    $this->addElement('Select', "show_limited_data", array(
			'label' => 'Show only the number of products entered in above setting. [If you choose No, then you can choose how do you want to show more products in this widget.]',
			 'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));



    $this->addElement('Radio', "pagging", array(
      'label' => "Do you want the products to be auto-loaded when users scroll down the page?",
      'multiOptions' => array(
      'auto_load' => 'Yes, Auto Load',
	  'button' => 'No, show \'View more\' link.',
	  'pagging' => 'No, show \'Pagination\'.'
      ),
      'value' => 'auto_load',
    ));


     $this->addElement('Text', "title_truncation_list", array(
      'label' => 'Title truncation limit for List Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));

    $this->addElement('Text', "limit_data_list", array(
      'label' => 'Count for List Views (number of products to show).',
      'value' => 10,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "description_truncation_list", array(
      'label' => 'Description truncation limit for List Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "height_list", array(
      'label' => 'Enter the height of main photo block in List Views (in pixels).',
      'value' => '230',
    ));
    $this->addElement('Text', "width_list", array(
      'label' => 'Enter the width of main photo block in List Views (in pixels).',
      'value' => '260',
    ));

    $this->addElement('Text', "title_truncation_grid", array(
      'label' => 'Title truncation limit for Grid Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));

    $this->addElement('Text', "limit_data_grid", array(
      'label' => 'Count for Grid Views (number of products to show).',
      'value' => 10,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));

    $this->addElement('Text', "description_truncation_grid", array(
      'label' => 'Description truncation limit for Grid Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "height_grid", array(
      'label' => 'Enter the height of one block in Grid Views (in pixels).',
      'value' => '270',
    ));
    $this->addElement('Text', "width_grid", array(
      'label' => 'Enter the width of one block in Grid Views (in pixels).',
      'value' => '389',
    ));



    $this->addElement('Text', "title_truncation_pinboard", array(
      'label' => 'Title truncation limit for Pinboard View.',
      'value' => 45,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    ));

    $this->addElement('Text', "limit_data_pinboard", array(
      'label' => 'Count for Pinboard View (number of products to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "description_truncation_pinboard", array(
      'label' => 'Description truncation limit for Pinboard View.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));

     $this->addElement('Text', "height_pinboard", array(
      'label' => 'Enter the height of one block in Pinboard View (in pixels).',
      'value' => '300',
    ));

    $this->addElement('Text', "width_pinboard", array(
      'label' => 'Enter the width of one block in Pinboard View (in pixels).',
      'value' => '300',
    ));

      $this->addElement('Text', "limit_data_map", array(
      'label' => 'Count for Map View (number of products to show).',
      'value' => 10,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
  }

}
