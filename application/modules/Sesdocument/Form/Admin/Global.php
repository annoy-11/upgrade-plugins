<?php
class Sesdocument_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $this->addElement('Text', "sesdocument_google_email", array(
                'label' => ' Google Email',
                'description' => 'Please enter your Google email id for the Google drive which    you want to use for Documents.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sesdocument_google_email',''),
    ));
    $this->getElement('sesdocument_google_email')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "sesdocument_client_id", array(
                'label' => ' Client ID',
                'description' => 'Please enter your Client ID.',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sesdocument_client_id',''),
    ));
    $this->getElement('sesdocument_client_id')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "sesdocument_secret_key", array(
                'label' => 'Client Secret Key',
                'description' => 'Please enter your Client Secret Key. ',
                'allowEmpty' => false,
                'required' => true,
                'value' => $settings->getSetting('sesdocument_secret_key',''),
    ));
    $this->getElement('sesdocument_secret_key')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesdocument_text_singular', array(
        'label' => 'Singular Text for "Document"',
        'description' => 'Enter the text which you want to show in place of "Document" at various places in this plugin like activity feeds, etc.',
        'value' => $settings->getSetting('sesdocument.text.singular', 'document'),
    ));

    $this->addElement('Text', 'sesdocument_text_plural', array(
        'label' => 'Plural Text for "Document"',
        'description' => 'Enter the text which you want to show in place of "Documents" at various places in this plugin like search form, navigation menu, etc.',
        'value' => $settings->getSetting('sesdocument.text.plural', 'documents'),
    ));

    $this->addElement('Text', 'sesdocument_document_manifest', array(
        'label' => 'Singular "document" Text in URL',
        'description' => 'Enter the text which you want to show in place of "document" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesdocument.document.manifest', 'document'),
    ));

    $this->addElement('Text', 'sesdocument_documents_manifest', array(
        'label' => 'Plural "documents" Text in URL',
        'description' => 'Enter the text which you want to show in place of "documents" in the URLs of this plugin.',
        'value' => $settings->getSetting('sesdocument.documents.manifest', 'documents'),
    ));

    $this->addElement('Radio', "sesdocument_rating", array(
                'label' => 'Allow Rating',
                'description' => 'Do you want to allow rating for documents on your website?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                    '1'=>'Yes',
                    '0'=>'No',
                ),
                'value' => $settings->getSetting('sesdocument_rating','1'),
    ));
    $this->getElement('sesdocument_rating')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Radio', "sesdocument_reporting", array(
                'label' => 'Report Document',
                'description' => 'Do you want to allow report document as inappropriate on your website?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                    '1'=>'Yes',
                    '0'=>'No',
                ),
                'value' => $settings->getSetting('sesdocument_reporting','1'),
    ));
    $this->getElement('sesdocument_reporting')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Radio', "sesdocument_sharing", array(
                'label' => 'Allow to Share Documents',
                'description' => 'Do you want to allow users to share Documents inside on your website and outside on other social networking sites?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                    '1'=>'Yes, allow sharing on this site and on social networking sites both.',
                    '2'=>'Yes, allow sharing on this site and do not allow sharing on other Social sites.',
                    '3'=>'No, do not allow sharing of Documents.',
                ),
                'value' => $settings->getSetting('sesdocument_sharing','1'),
    ));
    $this->getElement('sesdocument_sharing')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Radio', 'sesdocument_category_enable', array(
        'label' => 'Enable Category',
        'description' => 'Do you want to enable Category field for the Documents uploaded on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => "showHideCategory(this.value);",
        'value' => $settings->getSetting('sesdocument.category.enable', 1),
    ));
    $this->addElement('Radio', 'sesdocument_category_mandatory', array(
        'label' => 'Category Mandatory',
        'description' => 'Do you want to make Category field mandatory for the Documents on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesdocument.category.mandatory', 1),
    ));

    $this->addElement('Radio', 'sesdocument_description_enable', array(
        'label' => 'Enable Description',
        'description' => 'Do you want to enable Description field for the Documents uploaded on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => "showHideDescription(this.value);",
        'value' => $settings->getSetting('sesdocument.description.enable', 1),
    ));
    $this->addElement('Radio', 'sesdocument_description_mandatory', array(
        'label' => 'Description Mandatory',
        'description' => 'Do you want to make Description field mandatory for the Documents on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sesdocument.description.mandatory', 1),
    ));

    $this->addElement('Radio', "sesdocument_thumbnails", array(
        'label' => 'Document Thumbnails',
        'description' => 'Do you want to allow user to upload the document thumbnail? [Note: If you select "no" then Google Drive thumbnail will be uploaded for the respective document.]',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>array(
            '1'=>'Yes',
            '0'=>'No',
        ),
        'value' => $settings->getSetting('sesdocument_thumbnails','1'),
    ));
    $this->getElement('sesdocument_thumbnails')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Radio', "sesdocument_extensions", array(
        'label' => ' Document Extension',
        'description' => 'Do you want to allow user to upload a document with any extension?',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>array(
            '1'=>'Yes, allow document with any extension.',
            '0'=>'No, limited number of extension.',
        ),
        'onchange' => "hideshow(this.value);",
        'value' => $settings->getSetting('sesdocument.extensions','1'),
    ));
    $this->getElement('sesdocument_extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "sesdocument_extensionstype", array(
        'label' => ' Document Extension Type',
        'description' => 'Please enter the documents extension which you want to allow while uploading the documents on your website.[DEFAULT ALLOWED EXTENSIONS: pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov.]',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesdocument.extensionstype','pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov'),
    ));
    $this->getElement('sesdocument_extensionstype')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    // Add submit button
    $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
  }
}
