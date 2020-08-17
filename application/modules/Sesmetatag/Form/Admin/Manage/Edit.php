<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesmetatag_Form_Admin_Manage_Edit extends Engine_Form {

  public function init() {
  
    $managemetatag_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('managemetatag_id', 0);
    $managemetatag = Engine_Api::_()->getItem('sesmetatag_managemetatag', $managemetatag_id);
    
    $moreinfo = $this->getTranslator()->translate($managemetatag->meta_title);
    
    $title = vsprintf('Edit Meta Tags For '.$moreinfo, array($managemetatag->meta_title));
    
    $description = vsprintf('Here, you can edit the meta tags information for the '.$moreinfo.'.', array($managemetatag->meta_title));
  
    $this->setTitle($title);
    
    
    $this->setDescription($description);

//     $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0);
//     $results = $select->query()->fetchAll();
//     $allpages = array();
//     foreach($results as $result) { 
//       if(empty($result['title'])) continue;
//       $allpages[$result['page_id']] = $result['title'];
//     }
    
//     $this->addElement('Select', 'page_id', array(
//       'label' => 'Choose Widgitize Page',
//       'description' => 'Below, you can choose widgitize page.',
//       //'allowEmpty' => false,
//       'disabled' => "disabled",
//       'multiOptions' => $allpages,
//     ));
    
    $this->addElement('Text', "meta_title", array(
        'label' => 'OG & Twitter Card Meta Title',
        'description' => "Enter Facebook Open Graph and Twitter Card meta Title for this page. This title will show up when this page from website is shared on Facebook or Twitter.",
        'allowEmpty' => false,
        'required' => true,
    ));
      
    $this->addElement('Textarea', "meta_description", array(
        'label' => 'OG & Twitter Card Meta Description',
        'description' => "Enter Facebook Open Graph and Twitter Card meta Description for this page. This description will show up when this from website is shared on Facebook or Twitter.",
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('File', 'photo_id', array(
        'label' => 'OG & Twitter Card Meta Image',
        'description' => 'Choose from below the Facebook Open Graph and Twitter Card Meta Image for this page. This image will show up when this page from website is shared on Facebook or Twitter. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show image.]',
    ));
    $this->photo_id->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $managemetatag_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('managemetatag_id', null);
    $metatags = Engine_Api::_()->getItem('sesmetatag_managemetatag', $managemetatag_id);
    $photo_id = 0;
    if (isset($metatags->file_id))
      $photo_id = $metatags->file_id;
    if ($photo_id && $metatags) {
      $path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
      if (!empty($path)) {
        $this->addElement('Image', 'meta_photo_preview', array(
            'label' => 'Meta Image Preview',
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
    }
    if ($photo_id) {
      $this->addElement('Checkbox', 'remove_metaphoto', array(
          'label' => 'Yes, remove meta image.'
      ));
    }
    
    $this->addElement('Checkbox', 'enabled', array(
        'description' => 'Enable Meta Tags',
        'label' => 'Yes, enable Facebook Open Graph & Twitter Card Meta tags for this page.',
        'value' => 1,
    ));
    
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'prependText' => ' or ',
        'ignore' => true,
        'link' => true,
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'decorators' => array('ViewHelper'),
    ));
  }
}