<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Fields.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Form_Fields extends Engine_Form
{
  protected $_defaultProfileId;

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

  public function init() {
 		if (Engine_Api::_()->core()->hasSubject('sesarticle'))
    	$sesarticle = Engine_Api::_()->core()->getSubject();
		
		
    $this->setTitle('Custom Fields Entry')
      ->setDescription('Edit custom fields below, then click "Post Form" to publish the entry on your article.')->setAttrib('name', 'sesarticles_fields');
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

		
      // General form w/o profile type
      $aliasedFields = $sesarticle->fields()->getFieldsObjectsByAlias();
      $topLevelId = $topLevelId = 0;
      $topLevelValue = $topLevelValue = null;

      if (isset($aliasedFields['profile_type'])) {
				$aliasedFieldValue = $aliasedFields['profile_type']->getValue($sesarticle);
				$topLevelId = $aliasedFields['profile_type']->field_id;
				$topLevelValue = ( is_object($aliasedFieldValue) ? $aliasedFieldValue->value : null );
				if (!$topLevelId || !$topLevelValue) {	
					$topLevelId = null;
					$topLevelValue = null;
				}
				$topLevelId = $topLevelId;
				$topLevelValue = $topLevelValue;
      }
      // Get category map form data
      $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
      $customFields = new Sesarticle_Form_Custom_Dashboardfields(array(
				'item' => Engine_Api::_()->core()->getSubject(),
				'decorators' => array(
	      'FormElements'
      )));

      $customFields->removeElement('submit');
      if ($customFields->getElement($defaultProfileId)) {
				$customFields->getElement($defaultProfileId)
					->clearValidators()
					->setRequired(false)
					->setAllowEmpty(true);
						}
						$this->addSubForms(array(
					'fields' => $customFields
			 ));
		 
    
  // Element: execute
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));
  }
}
