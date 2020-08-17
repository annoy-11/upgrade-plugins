<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmembershipcard_Form_Admin_Level extends Engine_Form {
protected $_itemData;
function getItemData($itemData){
  $this->_itemData = $itemData;
}
function setItemData($itemData){
  $this->_itemData = $itemData;
}
  public function init() {

        $this
            ->setTitle('Member Level Settings')
            ->setDescription('These settings are applied on a per member level & profile type basis. Start by selecting the member level you want to modify
                                 , then adjust the settings for that level below.');

        $this->addElement('Select', "member_level", array(
              'label' => 'Member Level',
              'description' => '',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(),
        ));
        $this->getElement('member_level')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Select', "profile_type", array(
              'label' => 'Profile Type',
              'description' => '',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(),
        ));
        $this->getElement('profile_type')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "enable", array(
              'label' => 'Enable Membership Cards',
              'description' => 'Do you want to enable membership cards for users of this Member Level and Profile Type',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(
              '1'=>'Yes',
              '0'=>'No',
               ),
              'value'=>'1',
        ));
        $this->getElement('enable')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "templates_custom", array(
              'label' => 'Templates / Custom',
              'description' => 'What you want to apply Template or Custom Background',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(
              '1'=>'Templates',
              '0'=>'Custom',
              ),
              'value' => '1' ,
        ));
        $this->getElement('templates_custom')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["templates_custom"]) && $_POST["templates_custom"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Select', "templates", array(
              'label' => 'Select Front Template',
              'description' => 'Template-1 to Template-6 are for Horizontal Cards and Template-7 to Template-9 are for Vertical Cards',
              'required' =>$required,
              'allowEmpty'=>$allowEmpty,
              'multiOptions'=>array(
              '1'=>'Template 1',
              '2'=>'Template 2',
              '3'=>'Template 3',
              '4'=>'Template 4',
              '5'=>'Template 5',
              '6'=>'Template 6',
              '7'=>'Template 7',
              '8'=>'Template 8',
              '9'=>'Template 9',
               ),
              'value'=>'1',
        ));
        $this->getElement('templates')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "custom_front", array(
              'label' => 'Do you want Custom Front',
              'description' => ' ',
              'required' =>$required,
              'allowEmpty'=>$allowEmpty,
              'multiOptions'=>array(
              '1'=>'Yes',
              '0'=>'No',
              ),
              'value' => '0',
        ));

        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["custom_front"]) && $_POST["custom_front"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Radio', "background", array(
              'label' => 'Card Background',
              'description' => 'Choose one of the below options for the background of the Membership Cards on your site.[The card will also have a shiny plastic look.] ',
              'required' =>$required,
              'allowEmpty'=>$allowEmpty,
              'multiOptions'=>array(
              '1'=>'Select a background color for the cards.',
              '2'=>'Upload a background image for the cards',
              ),
              'value' => '2',
        ));
       // $this->getElement('background')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["custom_front"]) && $_POST["custom_front"] == 1){
            $image_id = !empty($this->_itemData->background_image) ? 1:0 ;
            if($image_id == 0  &&  (!empty($_POST["background"]) && $_POST["background"] == 2)){
                $required = true;
                $allowEmpty = false;
            }
        }

        $this->addElement('File', "background_image_img", array(
              'label' => 'Background Image',
              'description' => 'Please upload background image.[Note: The deal dimensions of the background image are 326*210 pixels .Please also be sure to choose only as many profile fields  to be shown in the card as might fit in it.] ',
              'required' =>$required,
              'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('background_image_img')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $this->background_image_img->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        if($this->_itemData){
        $this->addElement('Dummy', 'background_image_name', array(
			  'content' => '<img style="height:100px;width:100px" src="'.$this->_itemData->getPhotoUrl('background_image').'">',
		));
        }

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["templates_custom"]) && $_POST["templates_custom"] == 0){
          if(!empty($_POST["custom_front"]) && $_POST["custom_front"] == 1){
            if(!empty($_POST["background"]) && $_POST["background"] == 1){
            $required = true;
            $allowEmpty = false;
            }
          }
        }

        $this->addElement('Text', "background_color", array(
                'label' => 'Background Color',
                'class' =>'SESColor',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'description' => 'Select color for Background ',
        ));
        $this->getElement('background_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

   //$this->background->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $this->addElement('Radio', "site_title_logo", array(
                'label' => ' Logo/Title',
                'description' => 'What you want to show Site Title or Site Logo.',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Title',
                '0'=>'Logo',
                ),
                'value' => '1' ,
        ));

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["site_title_logo"]) && $_POST["site_title_logo"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Text', "site_title", array(
                'label' => 'Site Title',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'value' => '' ,
         ));
        $this->getElement('site_title')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "font_color", array(
                'label' => 'Site Title font-color ',
                'description' => 'Enter the Site title font-color.',
                'class'=>'SESColor',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'value'=> '',
        ));
        $this->getElement('font_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
        $image_id = !empty($this->_itemData->logo_image) ? 1:0;
        if($image_id == 0 &&  $_POST["site_title_logo"] == 0){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('File', "logo_image_img", array(
                'label' => 'Upload Logo',
                'description' => ' ',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('logo_image_img')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $this->logo_image_img->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        if($this->_itemData){
        $this->addElement('Dummy', 'logo_image_name', array(
			    'content' => '<img style="height:100px;width:100px" src="'.$this->_itemData->getPhotoUrl('logo_image').'">',
		));
        }

        $this->addElement('Radio', "show_title", array(
                'label' => 'Show Label/Title',
                'description' => 'Do you want to show a Label/Title on the Membership Cards',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Yes',
                '0'=>'No',
                ),
                'value' => '1' ,
        ));

      // $this->getElement('show_title')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["show_title"]) && $_POST["show_title"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Text', "title", array(
                'label' => 'Enter Label/Title',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('title')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "title_color", array(
                'label' => 'Customize Label/Title Color',
                'description' => 'Select the color of the label/title for the cards.(Click on the rainbow below to choose your color.)',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'class' => 'SESColor',
        ));
        $this->getElement('title_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $font_array = array(
        'Georgia, serif' => 'Georgia, serif',
        '"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
        '"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
        'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
        '"Arial Black", Gadget, sans-serif' => '"Arial Black", Gadget, sans-serif',
        '"Comic Sans MS", cursive, sans-serif' => '"Comic Sans MS", cursive, sans-serif',
        'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
        '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
        'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
        '"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
        'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
        '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
        '"Lucida Console", Monaco, monospace' => '"Lucida Console", Monaco, monospace',
        );

        $this->addElement('Select', "title_font", array(
                'label' => 'Customize Label/Title Font',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'multiOptions'=>$font_array,
        ));
        $this->getElement('title_font')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "profile_photo", array(
                'label' => 'Show Profile Photo',
                'description' => 'Do you want to show profile photo of users on the Membership Cards?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Yes',
                '0'=>'No',
                ),
                'value'=>'1',
        ));
        $this->getElement('profile_photo')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('MultiCheckbox', "profile_fields", array(
                'label' => 'Profile Fields on Cards',
                'description' => 'Select the items from the Profile Fields that should be shown on the Membership Cards.',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(),
        ));
        $this->getElement('profile_fields')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "empty_field", array(
                'label' => 'Show Empty Fields',
                'description' => 'Do you want to show empty fields(fields with no value for the user)on the Membership Cards ?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Yes',
                '0'=>'No',
                ),
                'value'=>'1',
        ));
        $this->getElement('empty_field')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "field_color", array(
                'label' => 'Customize Label/Title Color',
                'description' => 'Select the color of  the card data.(Click on the rainbow below to choose your color.)',
                'class' => 'SESColor',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '0'=>'Regular',
                '1'=>' Singer'
                ),
        ));
        $this->getElement('field_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Select', "field_font", array(
                'label' => 'Customize  Information Font',
                'description' => '',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>$font_array,
        ));
        $this->getElement('field_font')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "backside", array(
                'label' => 'Show Backside',
                'description' => 'Do you want to enable backside on the Membership Cards?',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Yes',
                '0'=>'No',
                ),
                'value' => '1' ,
        ));
     //   $this->getElement('backside')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["backside"]) && $_POST["backside"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Radio', "back_templates_custom", array(
                'label' => ' Back Template / Custom',
                'description' => 'What you want to apply Template or Custom Background',
                'allowEmpty' => $allowEmpty,
                'required' => $required,
                'multiOptions'=>array(
                '1'=>'Templates',
                '0'=>'Custom',
                ),
                'value' => '1' ,
        ));

        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["back_templates_custom"]) && $_POST["back_templates_custom"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Select', "back_templates", array(
                'label' => 'Select Back Template',
                'description' => '"Back Template-1 " to "Back Template-6 " are for Horizontal Cards and "Back Template-7 " to "Back Template-9 " are for Vertical Cards',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'multiOptions'=>array(
                '1'=>'Back Template 1',
                '2'=>'Back Template 2',
                '3'=>'Back Template 3',
                '4'=>'Back Template 4',
                '5'=>'Back Template 5',
                '6'=>'Back Template 6',
                '7'=>'Back Template 7',
                '8'=>'Back Template 8',
                '9'=>'Back Template 9',
                ),
                'value'=>'1',
        ));
        $this->getElement('back_templates')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "back_custom_front", array(
                'label' => 'Do you want Custom Back',
                'description' => ' ',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'multiOptions'=>array(
                '1'=>'Yes',
                '0'=>'No',
                ),
                'value' => '1',
        ));

        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["back_custom_front"]) && $_POST["back_custom_front"] == 1){
            $required = true;
            $allowEmpty = false;
        }

        $this->addElement('Radio', "back_background", array(
                'label' => 'Card Background',
                'description' => 'Choose one of the below options for the background of the Membership Cards on your site.[The card will also have a shiny plastic look.] ',
                'allowEmpty' => $allowEmpty,
                'required' => $required,
                'multiOptions'=>array(
                '1'=>'Select a background color for the cards.',
                '2'=>'Upload a background image for the cards',
                ),
                'value' => '2',
        ));
       // $this->getElement('background')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
         if( $_POST["back_custom_front"] == 0){
        if(!empty($_POST["back_custom_front"]) && $_POST["back_custom_front"] == 1){
        $image_id = !empty($this->_itemData->back_background_image) ? 1:0 ;
            if(($image_id == 0)  &&  (!empty($_POST["back_background"]) && $_POST["back_background"] == 2)){
                $required = true;
                $allowEmpty = false;
            }
        }
}

        $this->addElement('File', "back_background_image_img", array(
                'label' => 'Background Image',
                'description' => 'Please upload background image.[Note: The deal dimensions of the background image are 326*210 pixels .Please also be sure to choose only as many profile fields to vbe shown in the card as might fit in it.] ',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('back_background_image_img')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $this->back_background_image_img->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        if($this->_itemData){
        $this->addElement('Dummy', 'back_background_image_name', array(
			'content' => '<img style="height:100px;width:100px" src="'.$this->_itemData->getPhotoUrl('back_background_image').'">',
		));
        }

        $required = false;
        $allowEmpty = true;
         if(!empty($_POST["backside"]) && $_POST["backside"] == 1){
           if(!empty($_POST["back_templates_custom"]) && $_POST["back_templates_custom"] == 0){
             if(!empty($_POST["back_custom_front"]) && $_POST["back_custom_front"] == 1){
               if(!empty($_POST["back_background"]) && $_POST["back_background"] == 1){
                   $required = true;
                   $allowEmpty = false;
               }
             }
           }
         }

        $this->addElement('Text', "back_background_color", array(
                'label' => 'Back Background Color',
                'class' =>'SESColor',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'description' => '',
        ));
        $this->getElement('back_background_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "back_title_logo", array(
                'label' => 'Title/Logo',
                'description' => 'What you want to show Site Title or Site Logo.',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Title',
                '0'=>'Logo',
                ),
                'value' => '' ,
        ));

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["backside"]) && $_POST["backside"] == 1){
           if(!empty($_POST["back_title_logo"]) && $_POST["back_title_logo"] == 1){
              $required = true;
              $allowEmpty = false;
           }
        }

        $this->addElement('Text', "back_site_title", array(
                'label' => 'Site Title',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'value' => '' ,
         ));
        $this->getElement('back_site_title')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "back_font_color", array(
                'label' => 'Card back-side Site Title and Description font-color ',
                'description' => 'card back-side Site Title and Description font-color.',
                'class'=>'SESColor',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'value'=> '',
            ));
        $this->getElement('back_font_color')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $required = false;
        $allowEmpty = true;
        if(!empty($_POST["backside"]) && $_POST["backside"] == 1){
        $image_id = !empty($this->_itemData->back_logo) ? 1 : 0;
           if($image_id == 0  && ( $_POST["back_title_logo"] == 0)){
               $required = true;
               $allowEmpty = false;
           }
        }

        $this->addElement('File', "back_logo_img", array(
            'label' => 'Upload Back Logo',
            'description' => ' ',
            'required' =>$required,
            'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('back_logo_img')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $this->back_logo_img->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        if($this->_itemData){
        $this->addElement('Dummy', 'backg_logo_image', array(
			'content' => '<img style="height:100px;width:100px" src="'.$this->_itemData->getPhotoUrl('back_logo').'">',
		));
        }

        $required = false;
        $allowEmpty = true;
        if (!empty($_POST["backside"]) && $_POST["backside"] == 1){
              $required = true;
              $allowEmpty = false;
         }


        $font_array = array(
        'Georgia, serif' => 'Georgia, serif',
        '"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
        '"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
        'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
        '"Arial Black", Gadget, sans-serif' => '"Arial Black", Gadget, sans-serif',
        '"Comic Sans MS", cursive, sans-serif' => '"Comic Sans MS", cursive, sans-serif',
        'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
        '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
        'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
        '"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
        'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
        '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
        '"Lucida Console", Monaco, monospace' => '"Lucida Console", Monaco, monospace',
        );

        $this->addElement('Select', "back_title_font", array(
                'label' => 'Customize Label/Title Font',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
                'multiOptions'=>$font_array,
        ));
        $this->getElement('back_title_font')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Textarea', "back_description", array(
                'label' => 'Description',
                'description' => '',
                'required' =>$required,
                'allowEmpty'=>$allowEmpty,
        ));
        $this->getElement('back_description')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', "direction", array(
                'label' => ' Alignment',
                'description' => 'Choose Card Alignment from below',
                'allowEmpty' => false,
                'required' => true,
                'multiOptions'=>array(
                '1'=>'Horizontal',
                '2'=>'Vertical',
                ),
                'value'=>'1',
        ));
        $this->getElement('direction')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    // Element: submit
        $this->addElement('Button', 'submit', array(
                'label' => 'Save Settings',
                'type' => 'submit',
    ));

      // Add submit button



  }

}
