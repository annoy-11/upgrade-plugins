<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontentcoverphoto_Form_Admin_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    $this->setTitle('Content - Member Level settings')
        ->setDescription('Below settings are applied on a per member level basis for each Content chosen. You can start by choosing the desired Content and then selecting the member level you want to modify, then adjust the settings for that level below.');

    $resource_type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type', '');
    $plugin_array = array('blog', 'classified', 'event', 'group', 'video', 'album', 'poll', 'music');

    $integrateothermoduleArray = array();
    $integrateothermoduleArray[] = '';
    $coreTable = Engine_Api::_()->getDbTable('modules', 'core');
    $select = $coreTable->select()
            ->from($coreTable->info('name'), array('name', 'title'))
            ->where('enabled =?', 1)
            ->where('name IN (?)', $plugin_array)
            ->where('type =?', 'extra');
    $resultsArray = $select->query()->fetchAll();
    if (!empty($resultsArray)) {
      foreach ($resultsArray as $result) {
        if($result['name'] == 'music') {
          $integrateothermoduleArray['music_playlist'] = 'SE - Music Sharing';
        } elseif($result['name'] == 'album') {
          $integrateothermoduleArray[$result['name']] = 'SE - Photo Albums';
        } elseif($result['name'] == 'video') {
          $integrateothermoduleArray[$result['name']] = 'SE - Video Sharing';
        } else {
          $integrateothermoduleArray[$result['name']] = 'SE - ' .$result['title'];
        }
      }
    }

    $this->addElement('Select', 'resource_type', array(
      'label' => 'Choose Content',
      'description' => 'Choose the content below for which you want to modify the member level settings.',
      'multiOptions' => $integrateothermoduleArray,
      'onchange' => 'moduleChange(this.value)',
      'value' => '',
    ));

    if($resource_type) {
      parent::init();
      if( !$this->isPublic() ) {
        $this->addElement('Radio', 'vwty_'.$resource_type, array(
          'label' => 'Choose Cover Photo Design',
          'description' => 'Choose the design of cover photo which you want to show to the members of this member level on your website.',
          'multiOptions' => array(
            1 => 'Design 1',
            2 => 'Design 2',
            4 => 'Design 3',
          ),
          'value' => 1,
          'onclick' => 'showDesigns(this.value)',
        ));

        $this->addElement('Radio', 'create_'.$resource_type, array(
          'label' => 'Allow to Upload Cover Photo',
          'description' => 'Do you want to let members upload their content cover photo?',
          'value' => 1,
          'multiOptions' => array(
            1 => 'Yes, allow to upload cover photo.',
            0 => 'No, do not allow to upload cover photo.'
          ),
          'value' => 1,
        ));

        $this->addElement('Radio', 'urpord_'.$resource_type, array(
            'label' => 'Show Profile Photo in Round',
            'description' => 'Do you want to show the profile photos of this content in round shape?',
            'multiOptions' => array(
                1 => 'Yes',
                2 => 'No'
            ),
            'value' => 1,
        ));

        $this->addElement(
              'Text',
              'height_'.$resource_type,
              array(
                  'label' => 'Height of Cover Photo',
                  'description' => 'Enter the height of the cover photo (in pixels).',
                  'value' => '400',
              )
        );

        $resourceType_array = array('group', 'event');
        if(in_array($resource_type, $resourceType_array)) {
          $this->addElement(
            'Radio',
            'tab_'.$resource_type,
            array(
              'label' => 'Choose Tab Placement',
              'description' => "Choose from below where do you want to show the Tab Container in Cover Photo widget. (Note: This setting does not work in Design - 2).",
              'multiOptions' => array(
                  'inside' => 'Inside Cover Photo Widget',
                  'outside' => 'Outside Cover Photo Widget',
              ),
              'value' => 'inside',
            )
          );
        }

        $this->addElement(
          'Radio',
          'icnty_'.$resource_type,
            array(
              'label' => "Choose Icon Type",
              'description' => 'Choose from below how do you want to show the details on cover photo.',
              'multiOptions' => array(
                  '1' => 'With only icons',
                  '2' => 'With text and icons',
              ),
              'value' => '1',
          )
        );

        $this->addElement(
          'Radio',
          'fulwth_'.$resource_type,
            array(
              'label' => "Show Cover Photo in Full Width",
              'description' => 'Do you want to show the cover photo in full width?',
              'multiOptions' => array(
                  '1' => 'Yes',
                  '2' => 'No',
              ),
              'value' => '1',
          )
        );

        //Option based on plugin
        $options = $common_options = array();
        $typeArray = Engine_Api::_()->sescontentcoverphoto()->getResourceTypeData($resource_type);
        if($typeArray)
          $options = $typeArray['options'];

        $common_options = array(
          "photo" => "Content Profile Photo",
          "membersince" => "Content Creation Date",
          "viewcount" => "View Count",
          "likecount" => "Like Count",
          "commentcount" => "Comment Count",
          'share' => "Share",
          "report" => 'Report'
        );

        if($options)
          $final_options = array_merge($options, $common_options);
        else
          $final_options = $common_options;

        $this->addElement(
          'MultiCheckbox',
          'option_'.$resource_type,
          array(
            'label' => 'Show Details',
            'description' => 'Choose from below the details that you want to show in this widget.',
            'multiOptions' => $final_options,
          )
        );

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
          $this->addElement('Select', 'dfpto_'.$resource_type, array(
            'label' => 'Choose Default Cover Photo',
            'description' => 'Choose a default cover photo.',
            'multiOptions' => $banner_options,
          ));
        } else {
          $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for default user cover. Photo to be chosen for user cover should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.') . "</span></div>";
          $this->addElement('Dummy', 'dfpto_'.$resource_type, array(
              'label' => 'Choose Default Cover Photo',
              'description' => $description,
          ));
          $defaultcoverphoto = 'dfpto_'.$resource_type;
          $this->$defaultcoverphoto->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
        }
      }
    }
  }
}
