<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesletteravatar_Form_Admin_Settings_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Styling Settings for Letter Avatars')
        ->setDescription('Here, you can configure various settings for the font style, color, font size, etc for the letter avatars on your website.');

    $this->addElement('Radio', 'sesletteravatar_textfont', array(
      'label' => 'Letter Font Style',
      'description' => 'Select the font style for the letters of the letter avatar on your website.',
      'multiOptions' => array(
          'ABeeZee' => 'ABee Zee',
          'ActionIsWiderJL' => "Action Is WiderJL",
          "ArchivoNarrow" => "Archivo Narrow",
					"bauhs" => "Bauhs",
					"Flames" => "Flames",
					"GILLUBCD" => "Gillubcd",
					"GILSANUB" => "Gilsanub",
					"GOUDYSTO" => "Goudysto",
					"MOD" => "Mod",
					"OpenSansBold" => "Open Sans Bold",
					"Poppins-Bold" => "Poppins Bold",
					"VERDANA" => "Verdana",
					"VTKSNewsLabel" => "VTKS News Label"
      ),
      'value' => $settings->getSetting('sesletteravatar.textfont', 'ABeeZee'),
    ));

    $this->addElement('Text', "sesletteravatar_textcolor", array(
      'label' => 'Letter Font Color',
      'description' => 'Select the letter color of the letter avatars on your website.',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesletteravatar.textcolor', '#000000'),
    ));
    
    $this->addElement('Text', "sesletteravatar_fontsize", array(
      'label' => 'Letter Font Size',
      'description' => 'Enter the font size of the letters in letter avatars on your website.',
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesletteravatar.fontsize', 150),
    ));

    $this->addElement('Radio', 'sesletteravatar_imagbgcolor', array(
      'label' => 'Letter Avatar Background Color',
      'description' => 'Choose from below if you want the background color to be a single color by "Choose Color" option or generate random background colors.',
      'multiOptions' => array(
          1 => 'Choose Color',
          0 => "Random Color"
      ),
      'onclick' => "showHide(this.value)",
      'value' => $settings->getSetting('sesletteravatar.imagbgcolor', 0),
    ));

    $this->addElement('Text', "sesletteravatar_imagebackgroundcolor", array(
      'label' => 'Select Background Color',
      'description' => 'Select the background color of the letter avatars on your website.',
      'allowEmpty' => false,
      'required' => true,
      'class' => 'SEScolor',
      'value' => $settings->getSetting('sesletteravatar.imagebackgroundcolor', '#ffffff'),
    ));

    $this->addElement('Text', "sesletteravatar_imageheight", array(
      'label' => 'Letter Avatar Height',
      'description' => 'The letter avatar being created is itself an image, so enter the height (in pixel) of the image for the letter avatars on your website. We recommend the 400 pixel height.',
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesletteravatar.imageheight', 400),
    ));
    
    $this->addElement('Text', "sesletteravatar_imagewidth", array(
      'label' => 'Letter Avatar Width',
      'description' => 'The letter avatar being created is itself an image, so enter the width (in pixel) of the image for the letter avatars on your website. We recommend the 400 pixel width.',
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesletteravatar.imagewidth', 400),
    ));
    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));

  }
}