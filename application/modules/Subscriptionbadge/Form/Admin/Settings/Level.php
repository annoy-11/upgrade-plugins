<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Subscriptionbadge_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this->setTitle('Membership Subscription Badge Member Level Settings')->setDescription('These settings are applied on a per member level basis. You can configure other settings from the widgets of this plugin in Layout Editor.');

    // Element: level_id
    $multiOptions = array();
    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
      if( $level->type == 'public' || $level->type == 'admin' || $level->type == 'moderator' ) {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    $this->addElement('Select', 'level_id', array(
      'label' => 'Member Level',
      //'required' => true,
      //'allowEmpty' => false,
      'description' => 'The member will be placed into this level upon ' .
          'subscribing to this plan. If left empty, the default level at the ' .
          'time a subscription is chosen will be used.',
          'multiOptions' => $multiOptions,
          'onchange' => 'fetchLevelSettings(this.value);',
    ));

    if( !$this->isPublic() ) {

      //default photos
      $default_photos_main = array('' => '');
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
        $default_photos_main['public/admin/' . $base_name] = $base_name;
      }
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';

      $this->addElement('Select', 'userbadge', array(
        'label' => 'Upload Subscription Badge',
        'description' => 'Choose a badge for the members of this member level. [Note: You can add a new badge from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to assign badge for this member level.]',
        'multiOptions' => $default_photos_main
      ));
      $this->userbadge->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Radio', 'showupgrade', array(
        'label' => 'Display Upgrade Button',
        'description' => 'Do you want to display upgrade button to the members of this member level?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 0,
      ));

    }
  }
}
