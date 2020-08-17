<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Schema.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Schema extends Engine_Form {

    public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');

        $this->setTitle('Schema Markup')
            ->setDescription('You can enter information for schema markup that you want to show for rich content of your website in Search Engine Result Pages (SERP).');

        $this->addElement('Radio', "sesseo_schema_type", array(
            'label' => 'Schema Type',
            'description' => "Select schema type.",
            'multiOptions' => array(
                '1' => 'Website',
                //'2' => 'Organization',
                '3' => "Custom",
            ),
            'allowEmpty' => false,
            'required' => true,
            'onchange' => 'hideside(this.value)',
            'value' => $settings->getSetting('sesseo_schema_type', 1),
        ));

        $this->addElement('Text', "sesseo_sitetitle", array(
            'label' => 'Site Title',
            'description' => "Enter Site Title.",
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesseo.sitetitle', Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title')),
        ));

        $this->addElement('Text', "sesseo_alternatetitle", array(
            'label' => 'Website Alternate Title',
            'description' => "Enter Website Alternate Title.",
            'value' => $settings->getSetting('sesseo.alternatetitle', ''),
        ));


        $this->addElement('Text', "sesseo_facebook", array(
            'label' => 'Facebook URL',
            'description' => "Enter URL of the Facebook for your website.",
            'value' => $settings->getSetting('sesseo.facebook', ''),
        ));

        $this->addElement('Text', "sesseo_twitter", array(
            'label' => 'Twitter URL',
            'description' => "Enter URL of the Twitter for your website.",
            'value' => $settings->getSetting('sesseo.twitter', ''),
        ));

        $this->addElement('Text', "sesseo_linkdin", array(
            'label' => 'LinkedIn URL',
            'description' => "Enter URL of the LinkedIn for your website..",
            'value' => $settings->getSetting('sesseo.linkdin', ''),
        ));

        $this->addElement('Text', "sesseo_googleplus", array(
            'label' => 'Google Plus URL',
            'description' => "Enter URL of the Google Plus for your website..",
            'value' => $settings->getSetting('sesseo.googleplus', ''),
        ));

        $this->addElement('Text', "sesseo_instagram", array(
            'label' => 'Instagram URL',
            'description' => "Enter URL of the Instagram for your website.",
            'value' => $settings->getSetting('sesseo.instagram', ''),
        ));

        $this->addElement('Text', "sesseo_youtube", array(
            'label' => 'YouTube URL',
            'description' => "Enter URL of the YouTube for your website.",
            'value' => $settings->getSetting('sesseo.youtube', ''),
        ));

        $this->addElement('Textarea', "sesseo_othermediaurl", array(
            'label' => 'Other SocialMedia URL',
            'description' => "Enter URL of other social media for your website.",
            'value' => $settings->getSetting('sesseo.othermediaurl', ''),
        ));

        $this->addElement('Textarea', "sesseo_customschema", array(
            'label' => 'Custom Schema Markup',
            'description' => "Enter the Custom Schema Markup you want to enter for your website in json-ld format. [Note: You need not to include script tags, you can just add the json code.]",
            'value' => $settings->getSetting('sesseo.customschema', ''),
        ));

        // Add submit button
        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true
        ));

    }
}
