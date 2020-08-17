<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesshoutbox_Form_Admin_Create extends Engine_Form {

    public function init() {

        $slideId = Zend_Controller_Front::getInstance()->getRequest()->getParam('shoutbox_id', null);
        $this
                ->setTitle('Create New Shoutbox')
                ->setDescription("In this section, you can manage the create shoutbox and enter various details.")
                ->setAttrib('id', 'form-create')
                ->setAttrib('name', 'sesshoutbox_create_slide')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('onsubmit', 'return checkValidation();')
                ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

        $this->setMethod('post');
        $this->addElement('Text', 'title', array(
            'label' => 'Shoutbox Name',
            'description' => 'Enter the name for this shoutbox. It will be used for your indicative purpose only.',
            'allowEmpty' => true,
            'required' => true,
        ));

        //View Privacy Setting
        $this->addElement('Dummy', 'dummy_1', array(
            'content' => '<h2 style="margin: 0px;">Visibility & Posting Settings</h2>',
        ));
        $levelOptions = array();
        $levelOptions[''] = 'Everyone';
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
            $levelOptions[$level->level_id] = $level->getTitle();
        }
        $this->addElement('Multiselect', 'member_level_view_privacy', array(
            'label' => 'Member Level View Privacy',
            'description' => 'Choose the member levels to which this shoutbox will be displayed. (Ctrl + Click to select multiple member levels.)',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $levelOptions,
            'value' => '',
        ));
        $networkTable = Engine_Api::_()->getDbtable('networks', 'network');
        $select = $networkTable->select();
        $network = $networkTable->fetchAll($select);
        $dataNetwork[''] = 'Everyone';
        foreach ($network as $networks) {
            $dataNetwork[$networks->network_id] = $networks->getTitle();
        }

        $this->addElement('Multiselect', 'network_view_privacy', array(
            'label' => 'Network View Privacy',
            'description' => 'Choose the networks to which this shoutbox will be displayed. (Ctrl + Click to select multiple networks.)',
            'multiOptions' => $dataNetwork,
            'value' => '',
        ));

//         $this->addElement('Radio', 'show_non_loged_in', array(
//             'label' => 'Show to Non-logged in Users',
//             'description' => 'Do you want to show this shoutbox to non-logged in users of your website?',
//             'allowEmpty' => true,
//             'required' => false,
//             'multiOptions' => array(
//                 '1' => 'Yes',
//                 '0' => 'No'
//             ),
//             'value' => '1',
//         ));

        //View Privacy Setting
        $this->addElement('Dummy', 'dummy_2', array(
            'content' => '<h2 style="margin: 0px;">Display Settings</h2>',
        ));

        $this->addElement('Text', 'background_color', array(
            'label' => 'Shoutbox Background Color',
            'description' => 'Choose the background color for this shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => 'FFF',
        ));

        $this->addElement('Text', 'sh_font_color', array(
            'label' => 'Shoutbox Font Color',
            'description' => 'Choose the font color for this shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => '999',
        ));

        $this->addElement('Text', 'font_size', array(
            'label' => 'Font Size',
            'description' => 'Enter font size in (px).',
            'allowEmpty' => false,
            'required' => true,
            'value' => '12',
        ));

        $this->addElement('Text', 'admin_background_color', array(
            'label' => 'Shoutbox Background Color for Admin  / Moderator',
            'description' => 'Choose the background color for admin / moderator shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => 'fff7f9',

        ));
        $this->addElement('Text', 'admin_font_color', array(
            'label' => 'Admin  / Moderator Font Color',
            'description' => 'Choose the font color for admin / moderator.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => '555',
        ));

        $this->addElement('Text', 'my_background_color', array(
            'label' => 'Background Color for My Shoutbox',
            'description' => 'Choose the background color for my shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => 'fafcff',
        ));
        $this->addElement('Text', 'my_font_color', array(
            'label' => 'My Shoutbox Font Color',
            'description' => 'Choose the font color for my shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => '555',
        ));

        $this->addElement('Text', 'other_background_color', array(
            'label' => 'Shoutbox Background Color for Other Member',
            'description' => 'Choose the background color for other shoutbox.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
        ));
        $this->addElement('Text', 'other_font_color', array(
            'label' => 'Other Font Color',
            'description' => 'Choose the font color for other.',
            'class' => 'SEScolor',
            'allowEmpty' => true,
            'required' => false,
            'value' => '555',
        ));

/*
        $this->addElement('Radio', 'editors', array(
            'label' => 'Editors',
            'description' => 'Choose Editors.',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions' => array(
                1 => "WYSIWYG Editors",
                0 => "Text Area",
            ),
            'value' => 0,
            'onchange' => "chooseEditors(this.value)",
        ));*/

        $this->addElement('Text', 'text_limit', array(
            'label' => 'Text Limit',
            'description' => 'Enter Limit for posting.',
            'allowEmpty' => false,
            'required' => true,
            'value' => '50',
        ));

        $this->addElement('Radio', 'postcontentbutton', array(
            'label' => 'Post Content Button',
            'description' => 'Post Content Button',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions' => array(
                1 => "Send Button",
                2 => "Icon",
                3 => "Enter",
                4 => "Enter & Send Button",
            ),
            'value' => 1,
        ));

        //UPLOAD PHOTO URL
        $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesshoutbox', 'controller' => 'settings', 'action' => "upload-photo"), 'admin_default', true);

        $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

        $editorOptions = array(
            'upload_url' => $upload_url,
            'html' => (bool) $allowed_html,
        );

        if (!empty($upload_url)) {
            $editorOptions['plugins'] = array(
                'table', 'fullscreen', 'media', 'preview', 'paste',
                'code', 'image', 'textcolor', 'jbimages', 'link'
            );

            $editorOptions['toolbar1'] = array(
                'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
                'media', 'image', 'jbimages', 'link', 'fullscreen',
                'preview'
            );
        }

        $this->addElement('TinyMce', "sesshoutbox_rules", array(
            'label' => 'Shoutbox Rules',
            'Description' => 'Enter Shoutbox Rules',
            //  'required' => true,
            // 'allowEmpty' => false,
            'editorOptions' => $editorOptions,
        ));

        // Buttons
        $this->addElement('Button', 'submit', array(
            'label' => 'Save',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper')
        ));
//         $this->addElement('Cancel', 'cancel', array(
//             'label' => 'Cancel',
//             'link' => true,
//             'prependText' => ' or ',
//             'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
//             'onClick' => 'javascript:parent.Smoothbox.close();',
//             'decorators' => array(
//                 'ViewHelper'
//             )
//         ));
//         $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    }
}
