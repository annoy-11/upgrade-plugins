<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Location.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Form_Admin_Location extends Engine_Form {

  public function init() {

    $this->addElement('Text', 'location', array(
        'label' => 'Location',
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
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified label',
            'location' => 'Location',
            'likeButton' => 'Like Button',
            'friendButton' => 'Friend Button',
            'followButton' => 'Follow Button',
            'message' => 'Message Button',
            'likemainButton' => 'Like Button',
            'rating' => 'Rating Stars',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Likes',
            'view' => 'Views',
            'profileType' => 'Profile Type',
            'age' => 'Show Member’s Age [Age will show even if any member has hide their "Birth Date"].',
            'email' => 'Email',
            'message' => 'Message',
        ),
        'escape' => false,
    ));
    $this->addElement('Text', 'limit', array(
        'label' => 'Number of member to be show',
        'value' => 10
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
    
    
    
		$this->addElement('dummy', 'location-data', array(
			'decorators' => array(array('ViewScript', array(
				'viewScript' => 'application/modules/Sesmember/views/scripts/location.tpl',
			)))
		));
  }

}