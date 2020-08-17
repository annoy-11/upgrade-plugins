<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Location.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_Location extends Engine_Form {
  public function init() {
		$this->addElement('Text', 'location', array(
        'label' => 'Search Location',
        'id' => 'locationSesList',
    ));
    $this->addElement('Text', 'lat', array(
        'label' => 'Lat',
        'id' => 'latSesList',
    ));
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
    $script = '
    sesJqueryObject(document).ready(function(){
    var params = parent.pullWidgetParams();
    sesJqueryObject("#locationSesList").val(params["location"]);
    sesJqueryObject("#latSesList").val(params["lat"]);
    sesJqueryObject("#lngSesList").val(params["lng"]);
    })';
    $view->headScript()->appendScript($script);

    $this->addElement('Text', 'lng', array(
        'label' => 'Lng',
        'id' => 'lngSesList',

    ));
			$this->addElement('MultiCheckbox', "show_criteria", array(
			'label' => "Choose from below the details that you want to show in this widget.",
			'multiOptions' => array(
					'price' =>'Price',
                    'discount' => 'Discount',
                    'stock' =>'Stock',
                    'storeName' =>'Store Name & Photo',
                    'addCart' => 'Add to Cart Button',
                    'addWishlist' => 'Add to wishlist',
                    'addCompare'=>'Add to Compare',
                    'brand' => 'Brand Name',
                    // 'offre' => 'Offer',
                    'featuredLabel' => 'Featured Label',
                    'sponsoredLabel' => 'Sponsored Label',
                    'verifiedLabel' => 'Verified Label',
                    'favouriteButton' => 'Favourite Button',
                    'likeButton' => 'Like Button',
                    'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                    'like' => 'Likes Count',
                    'favourite' => 'Favorites Count',
                    'comment' => 'Comments Count',
                    'rating' => 'Ratings Count',
                    'view' => 'Views Count',
                    'category' => 'Category',
                    'creationDate' => 'Creation Date',
                    'location'=> 'Location',
			),
			'escape' => false,
	));

    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {

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

   $this->addElement('Text', "limit_data", array(
      'label' => 'Count (number of products to show).',
      'value' => 100,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    ));
   $this->addElement('dummy', 'location-data', array(
		'decorators' => array(array('ViewScript', array(
				'viewScript' => 'application/modules/Sesproduct/views/scripts/location.tpl',
		)))
  ));
  }
}
