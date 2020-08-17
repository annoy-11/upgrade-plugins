<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->addElement('Text', "edocument_google_email", array(
        'label' => 'Google Email',
        'description' => 'Please enter your Google email id for the Google drive which    you want to use for Documents.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('edocument.google.email',''),
    ));
    $this->getElement('edocument_google_email')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "edocument_client_id", array(
        'label' => 'Client ID',
        'description' => 'Please enter your Client ID.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('edocument.client.id',''),
    ));
    $this->getElement('edocument_client_id')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "edocument_secret_key", array(
        'label' => 'Client Secret Key',
        'description' => 'Please enter your Client Secret Key. ',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('edocument.secret.key',''),
    ));
    $this->getElement('edocument_secret_key')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('edocument.pluginactivated')) {

      $this->addElement('Text', 'edocument_text_singular', array(
          'label' => 'Singular Text for "Document"',
          'description' => 'Enter the text which you want to show in place of "Document" at various places in this plugin like activity feeds, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('edocument.text.singular', 'document'),
      ));

      $this->addElement('Text', 'edocument_text_plural', array(
          'label' => 'Plural Text for "Documents"',
          'description' => 'Enter the text which you want to show in place of "Documents" at various places in this plugin like search form, navigation menu, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('edocument.text.plural', 'documents'),
      ));

      $this->addElement('Text', 'edocument_manifest', array(
          'label' => 'Singular "document" Text in URL',
          'description' => 'Enter the text which you want to show in place of "document" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('edocument.document.manifest', 'document'),
      ));

      $this->addElement('Text', 'edocuments_manifest', array(
          'label' => 'Plural "documents" Text in URL',
          'description' => 'Enter the text which you want to show in place of "documents" in the URLs of this plugin.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('edocument.documents.manifest', 'documents'),
      ));

      $this->addElement('Radio', 'edocument_enable_welcome', array(
          'label' => 'Document Main Menu Redirection',
          'description' => 'Choose from below where do you want to redirect users when Documents Menu item is clicked in the Main Navigation Menu Bar.',
          'multiOptions' => array(
              0 => 'Document Home Page',
              2 => 'Document Browse Page',
          ),
          'value' => $settings->getSetting('edocument.enable.welcome', 0),
      ));

      $this->addElement('Radio', 'edocument_redirect_creation', array(
          'label' => 'Redirection After Document Creation',
          'description' => 'Choose from below where do you want to redirect users after a document is successfully created.',
          'multiOptions' => array('1' => 'On Document Dashboard Page', '0' => 'On Document Profile Page'),
          'value' => $settings->getSetting('edocument.redirect.creation', 0),
      ));


      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement('Radio', 'edocument_watermark_enable', array(
          'label' => 'Add Watermark to Photos',
          'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the <a href="' . $view->baseUrl() . "/admin/edocument/level" . '">Member Level Settings</a>.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'show_position(this.value)',
          'value' => $settings->getSetting('edocument.watermark.enable', 0),
      ));
      $this->addElement('Select', 'edocument_position_watermark', array(
          'label' => 'Watermark Position',
          'description' => 'Choose the position for the watermark.',
          'multiOptions' => array(
              0 => 'Middle ',
              1 => 'Top Left',
              2 => 'Top Right',
              3 => 'Bottom Right',
              4 => 'Bottom Left',
              5 => 'Top Middle',
              6 => 'Middle Right',
              7 => 'Bottom Middle',
              8 => 'Middle Left',
          ),
          'value' => $settings->getSetting('edocument.position.watermark', 0),
      ));
      $this->edocument_watermark_enable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Text', "edocument_mainheight", array(
          'label' => 'Large Photo Height',
          'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Document Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('edocument.mainheight', 1600),
      ));
      $this->addElement('Text', "edocument_mainwidth", array(
          'label' => 'Large Photo Width',
          'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Document Photo View Page". Also, this setting will apply on new uploaded photos.]',
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('edocument.mainwidth', 1600),
      ));
      $this->addElement('Text', "edocument_normalheight", array(
          'label' => 'Medium Photo Height',
          'description' => "Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('edocument.normalheight', 500),
      ));
      $this->addElement('Text', "edocument_normalwidth", array(
          'label' => 'Medium Photo Width',
          'description' => "Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('edocument.normalwidth', 500),
      ));

      //default photos
      $default_photos_main = array();
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
      //document main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array('application/modules/Edocument/externals/images/nophoto_document_thumb_profile.png' => ''), $default_photos_main);
        $this->addElement('Select', 'edocument_default_photo', array(
            'label' => 'Main Default Photo for Documents',
            'description' => 'Choose Main default photo for the documents on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change document default photo.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('edocument.document.default.photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for main photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'edocument_default_photo', array(
            'label' => 'Main Default Photo for Documents',
            'description' => $description,
        ));
      }
      $this->edocument_default_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

//       $this->addElement('Radio', 'edocument_start_date', array(
//           'label' => 'Enable Custom Document Publish Date',
//           'description' => 'Do you want to allow users to choose a custom publish date for their documents. If you choose Yes, then documents on your website will display in activity feeds, various pages and widgets on their publish dates.',
//           'multiOptions' => array(
//               1 => 'Yes',
//               0 => 'No',
//           ),
//           'value' => $settings->getSetting('edocument.start.date', 1),
//       ));

      $this->addElement('Radio', 'edocument_category_enable', array(
          'label' => 'Make Document Categories Mandatory',
          'description' => 'Do you want to make category field mandatory when users create or edit their documents?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('edocument.category.enable', 1),
      ));
      $this->addElement('Radio', 'edocument_description_mandatory', array(
          'label' => 'Make Document Description Mandatory',
          'description' => 'Do you want to make description field mandatory when users create or edit their documents?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('edocument.description.mandatory', 1),
      ));
      $this->addElement('Radio', 'edocument_photo_mandatory', array(
          'label' => 'Make Document Main Photo Mandatory',
          'description' => 'Do you want to make main photo field mandatory when users create or edit their documents?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('edocument.photo.mandatory', 1),
      ));

      $this->addElement('Radio', 'edocument_enable_favourite', array(
          'label' => 'Allow to Favourite Documents',
          'description' => 'Do you want to allow users to favourite documents on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('edocument.enable.favourite', 1),
      ));

      $this->addElement('Radio', 'edocument_enable_rate', array(
          'label' => 'Allow to Rate Documents',
          'description' => 'Do you want to allow users to rate documents on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('edocument.enable.rate', 1),
      ));

      $this->addElement('Radio', 'edocument_enable_report', array(
          'label' => 'Allow to Report Documents',
          'description' => 'Do you want to allow users to report documents on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('edocument.enable.report', 1),
      ));

      $this->addElement('Radio', 'edocument_enable_sharing', array(
          'label' => 'Allow to Share Documents',
          'description' => 'Do you want to allow users to share documents on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('edocument.enable.sharing', 1),
      ));

//       $this->addElement('Select', 'edocument_taboptions', array(
//           'label' => 'Menu Items Count in Main Navigation',
//           'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
//           'multiOptions' => array(
//               0 => 0,
//               1 => 1,
//               2 => 2,
//               3 => 3,
//               4 => 4,
//               5 => 5,
//               6 => 6,
//               7 => 7,
//               8 => 8,
//               9 => 9,
//           ),
//           'value' => $settings->getSetting('edocument.taboptions', 6),
//       ));

      $this->addElement('Radio', 'edocument_enable_sharing', array(
        'label' => 'Allow to Share Documents',
        'description' => 'Do you want to allow users to share documents on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('edocument.enable.sharing', 1),
      ));

        $this->addElement('Radio', "edocument_extensions", array(
            'label' => ' Document Extension',
            'description' => 'Do you want to allow user to upload a document with any extension?',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions'=>array(
                '1'=>'Yes, allow document with any extension.',
                '0'=>'No, limited number of extension.',
            ),
            'onchange' => "hideshow(this.value);",
            'value' => $settings->getSetting('edocument.extensions','1'),
        ));
        $this->getElement('edocument_extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "edocument_extensionstype", array(
            'label' => ' Document Extension Type',
            'description' => 'Please enter the documents extension which you want to allow while uploading the documents on your website.[DEFAULT ALLOWED EXTENSIONS: pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov.]',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('edocument.extensionstype','pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov'),
        ));
        $this->getElement('edocument_extensionstype')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
