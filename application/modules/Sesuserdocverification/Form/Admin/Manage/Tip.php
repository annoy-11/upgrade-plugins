<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tip.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Form_Admin_Manage_Tip extends Engine_Form {

  public function init() {


    $getSignupStep = Engine_Api::_()->sesuserdocverification()->getSignupStep();

    $description = $this->getTranslator()->translate('Here, you can choose to configure the text which will be displayed in the Tip when users will mouse over on the Verification Label. The verification tip will come in the “SES - Document Verification - Verification Label” widget placed on the Member Profile page from <a href="admin/content?page=5"> Layout Editor</a>.');

//     if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesusercoverphoto') && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
//         $description = $description . $this->getTranslator()->translate('<br /><br /> Note: This plugin is integrated with the verification label in "<a href="https://www.socialenginesolutions.com/social-engine/advanced-members-plugin/" target="_blank">Ultimate Members Plugin</a>" & "<a href="https://www.socialenginesolutions.com/social-engine/member-profiles-cover-photo-video-plugin/" target="_blank">Member Profiles Cover Photo & Video Plugin</a>".');
//     } else if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember')) {
//         $description = $description . $this->getTranslator()->translate('<br /><br /> Note: This plugin is integrated with the verification label in "<a href="https://www.socialenginesolutions.com/social-engine/advanced-members-plugin/" target="_blank">Ultimate Members Plugin</a>."');
//     } else if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesusercoverphoto')) {
//         $description = $description . $this->getTranslator()->translate('<br /><br /> Note: This plugin is integrated with the verification label in "<a href="https://www.socialenginesolutions.com/social-engine/member-profiles-cover-photo-video-plugin/" target="_blank">Member Profiles Cover Photo & Video Plugin</a>".');
//     }

	// Decorators
    $this->loadDefaultDecorators();
	$this->getDecorator('Description')->setOption('escape', false);

    $this->setTitle('Verification Tip Settings')
            ->setDescription($description);


    $this->addElement('Radio', 'sesuserdocverification_distip', array(
        'label' => 'Display Content in Tip',
        'description' => 'Do you want to display the content from this plugin in verification tip?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => 'showhide(this.value);',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.distip', 1),
    ));

    $documentTypes = Engine_Api::_()->getDbtable('documenttypes', 'sesuserdocverification')->getAllDocumentTypes();
    if( count($documentTypes) > 1) {
        unset($documentTypes[0]);
        $this->addElement('MultiCheckbox', 'sesuserdocverification_dotypetip', array(
            'label' => 'Document Types in Tip',
            'description' => 'Choose the document types which will be shown in the verification tip content.',
            'multiOptions' => $documentTypes,
            'value' => unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.dotypetip', '')),
        ));
    }

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
