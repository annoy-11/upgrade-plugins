<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Location.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Form_Admin_Location extends Engine_Form {

  public function init() {

    $this->addElement('Radio', 'sesweather_isintegrate', array(
        'label' => 'Do you want to integrate user\'s location in this widget which is entered by users of your website through Advanced Members Plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 1,
    ));
    $this->addElement('Text', 'location', array(
        'label' => 'Enter location associated to which weather will be displayed in this widget.',
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
    $this->addElement('dummy', 'location-data', array(
        'decorators' => array(array('ViewScript', array(
                    'viewScript' => 'application/modules/Sesweather/views/scripts/location.tpl',
                )))
    ));
    $this->addElement('Radio', 'sesweather_temdesign', array(
        'label' => 'Template Design (This setting will work in "Weather with Background Image" widget only. If you need template design options, then choose from mentioned widget.)',
        'multiOptions' => array(
            1 => 'Design 1',
            0 => 'Design 2'
        ),
        'value' => 1,
    ));
    $this->addElement('Radio', 'sesweather_showdays', array(
        'label' => 'Show days (This setting will work in "SES - Weather - Sidebar Weather" widget only.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 1,
    ));
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $banner_options[] = '';
    $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($path as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $base_name = basename($file->getFilename());
      if (!($pos = strrpos($base_name, '.')))
        continue;
      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
      if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
        continue;
      $banner_options['public/admin/' . $base_name] = $base_name;
    }
    $fileLink = $view->baseUrl() . '/admin/files/';
    if (count($banner_options) > 1) {
      $this->addElement('Select', 'sesweather_bgphoto', array(
          'label' => 'Choose a photo which you want to add as Background image for this widget. [Note: You can add a new photo from the "Appearance" >> "File & Media Manager" section. Leave the field blank if you do not want to add photo.]',
          'description' => '',
          'multiOptions' => $banner_options,
      ));
    } else {
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo to add for background. Image to be chosen for background should be first uploaded from the "Appearance" >> "File & Media Manager" section. Leave the field blank if you do not want to add photo.') . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'sesweather_bgphoto', array(
          'label' => 'Weather Background Photo',
          'description' => $description,
      ));
      $this->sesweather_bgphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }
    $this->addElement('Radio', 'sesweather_location_search', array(
        'label' => 'Do you want to enable the "Location Search" field in this widget? If you choose Yes, then users will be able to modify location from this widget to check weather on the chosen location.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 1,
    ));
  }

}
