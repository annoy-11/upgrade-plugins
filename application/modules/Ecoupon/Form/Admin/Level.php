<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Level.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_Form_Admin_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
    parent::init();
    $this->setTitle('Member Level settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');
    // Element: view
    $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Coupon?',
        'description' => 'Do you want to allow users to create Coupon? If set to “No”, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Coupon. If this setting is chosen “Yes” for Public Member level, then when a public users click on "Create New Coupon" option, they will see Authorization Popup to Login or Sign-up on your website.',
        'multiOptions' => array(
            1 => 'Yes, allow creation of Coupon.',
            0 => 'No, do not allow to create Coupon.',
        ),
        'value' => ($this->isModerator() ? 1 : 1),
    ));
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Coupon?',
        'description' => 'Do you want to let users to view Coupon? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all Coupons, even Private ones.',
            1 => 'Yes, allow members to view their own Coupons.',
            0 => 'No, do not allow Coupons to be viewed',
        ),
        'value' => ($this->isModerator() ? 2 : 1),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }
    if (!$this->isPublic()) { 
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Coupon',
          'description' => 'Do you want to let members edit Coupon?',
          'multiOptions' => array(
              1 => 'Yes, allow members to edit their own Coupon.',
              0 => 'No, do not allow Coupon to be edited.',
          ),
          'value' => ($this->isModerator() ? 1 : 0),
      ));
      if (!$this->isModerator()) {
          unset($this->edit->options[2]);
      }
      $this->addElement('Radio', 'delete', array(
            'label' => 'Allow Deletion of Coupon',
            'description' => 'Do you want to let members delete Coupon?',
            'multiOptions' => array(
                1 => 'Yes, allow members to delete their own Coupon.',
                0 => 'No, do not allow members to delete their Coupon.',
            ),
            'value' => ($this->isModerator() ? 1 : 0),
      ));
      if (!$this->isModerator()) {
          unset($this->delete->options[2]);
      }
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Coupon?',
          'description' => 'Do you want to let members of this level comment on Coupon? If Yes is chosen for Public Member level, then when a public users click on Comment option, they will see Authorization Popup to Login or Sign-up on your website.',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment all Coupons, even Private ones.',
              1 => 'Yes, allow members to comment on Coupon.',
              0 => 'No, do not allow members to comment on Coupon.',
          ),
          'value' => ($this->isModerator() ? 2 : 1),
      ));
      if (!$this->isModerator()) {
          unset($this->comment->options[2]);
      }
      $this->addElement('Radio', 'upload_mainphoto', array(
          'label' => 'Allow to Upload Coupon  Photo',
          'description' => 'Do you want to allow members of this member level to upload the photo for their Coupon. If set to No, then the default photo will get displayed instead which you can choose in settings below.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));
      $default_photos = array();
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
          $default_photos['public/admin/' . $base_name] = $base_name;
        }
        $default_photos = array_merge(array(''), $default_photos);
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $fileLink = $view->baseUrl() . '/admin/files/';
        //page main photo
        if (count($default_photos) > 0) {
          $this->addElement('Select', 'bsdefaultphoto', array(
              'label' => 'Default Photo for Coupon',
              'description' => 'Choose the default photo for the Coupon created by the members of this level on your website. [Note: You can add a new photo from the "File & Media Manager" section. Leave the field blank if you do not want to add default photo.]',
              'multiOptions' => $default_photos,
          ));
        } else {
          $description = "<div class='tip'><span>" . 'There are currently no photo in the File & Media Manager. Please upload the Photo to be chosen from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manage</a>" section.' . "</span></div>";
          $this->addElement('Dummy', 'bsdefaultphoto', array(
              'label' => 'Default Photo for Coupon',
              'description' => $description,
          ));
        }
      // Element: create
      $this->addElement('Radio', 'auto_approve', array(
          'label' => 'Auto Approve Coupon',
          'description' => 'Do you want Coupon created by members of this level to be auto-approved? If you choose No, then you can manually approve Coupon from Manage Coupon section of this plugin.',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Ecoupon.',
              0 => 'No, do not auto-approve Ecoupon.',
          ),
          'value' => 1,
      ));
      //element for course featured
      $this->addElement('Radio', 'bs_featured', array(
          'description' => 'Do you want Coupon created by members of this level to be automatically marked as Featured? If you choose No, then you can manually mark Coupon as Featured from Manage Coupon section of this plugin.',
          'label' => 'Automatically Mark Coupon as Featured',
          'multiOptions' => array(
              1 => 'Yes',0 => 'No'),
          'class' => $class,
          'value' => 0,
      ));
      //element for course hot
      $this->addElement('Radio', 'bs_hot', array(
          'description' => 'Do you want Coupon created by members of this level to be automatically marked as Verified? If you choose No, then you can manually mark Coupon as Verified from Manage Coupon section of this plugin.',
          'label' => 'Automatically Mark Coupon as Hot',
          'multiOptions' => array(
              1 => 'Yes, automatically mark Ecoupon as Hot',
              0 => 'No, do not automatically mark Ecoupon as Hot',
          ),
          'class' => $class,
          'value' => 0,
      ));
      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
            'label' => 'Coupon View Privacy',
            'description' => 'Your users can choose any of the options from below, whom they want can see their Coupon . If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
            'multiOptions' => array(
                'everyone' => 'Everyone',
                'registered' => 'Registered Members',
                'owner_network' => 'Friends and Networks',
                'owner_member_member' => 'Friends of Friends',
                'owner_member' => 'Friends Only',
                'owner' => 'Just Me'
            ),
            'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
      ));
      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Coupon Comment Options',
          'description' => 'Your users can choose any of the options from below whom they want can post to their Coupon . If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Just Me',
          ),
          'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner','member'),
      ));
      $this->addElement('Text', 'coupon_count', array(
            'label' => 'Maximum Allowed Coupon',
            'description' => 'Enter the maximum number of allowed Coupons to be created by members of this level. The field must contain an integer between 1 and 999, or 0 for unlimited',
            'validators' => array(
                array('Int', true),
            ),
            'value' => 10,
      ));
      $this->addElement('Radio', 'auth_html', array(
          'label' => 'HTML in Coupon?',
          'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas).
          Example: b, img, a, embed, font, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No',
            ),
            'value' => 1,
      ));
    }
  }
}
