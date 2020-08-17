<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: UploadPhotos.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Dashboard_UploadPhotos extends Engine_Form {

  public function init() {

		$album_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('album_id',null);
		
    $this->setTitle('Add New Photos')
      ->setDescription('Choose photos on your computer to add to this album.')
      ->setAttrib('id', 'form-upload')
      ->setAttrib('name', 'albums_create')
      ->setAttrib('enctype','multipart/form-data')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('Hidden', 'album', array(
      'value' => $album_id,
    ));

    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('Dummy', 'fancyuploadfileids', array('content'=>'<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));

    $this->addElement('Dummy', 'tabs_form_albumcreate', array(
        'content' => '<div class="sescf_create_form_tabs sesbasic_clearfix sesbm"><ul id="sescf_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">'.$translate->translate('Drag & Drop').'</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">'.$translate->translate('Multi Upload').'</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">'.$translate->translate('From URL').'</a></li></ul></div>',
    ));

    $this->addElement('Dummy', 'drag-drop', array(
        'content' => '<div id="dragandrophandler" class="sescf_upload_dragdrop_content sesbasic_bxs dragandrophandler">'.$translate->translate('Drag & Drop Photos Here').'</div>',
    ));

    $this->addElement('Dummy', 'from-url', array(
        'content' => '<div id="from-url" class="sesalbum_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="'.$translate->translate('Enter Image URL to upload').'"><span id="loading_image"></span><span></span><button id="upload_from_url">'.$translate->translate('Upload').'</button></div>',
    ));
    $this->addElement('Dummy', 'file_multi_sesalbum', array('content'=>'<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrlsesalbum(this)" multiple="multiple" id="file_multi_sesalbum" name="file_multi">'));
    $this->addElement('Dummy', 'uploadFileContainer', array('content'=>'<div id="show_photo_sesalbum_container" class="sesalbum_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo_sesalbum" class="sescf_dash_photos"></div></div>'));
    //Init file
//      $fancyUpload = new Engine_Form_Element_FancyUpload('file');
//     $fancyUpload->clearDecorators()
//       ->addDecorator('FormFancyUpload')
//       ->addDecorator('viewScript', array(
//           'viewScript' => '_FancyUpload.tpl',
//           'placement' => '',
//     ));
//     Engine_Form::addDefaultDecorators($fancyUpload);
//     $this->addElement($fancyUpload);

    $i = -5000;

    //Init hidden file IDs
    $this->addElement('Hidden', 'photo_id', array(
        'order' => $i--,
    ));

    //Init hidden file IDs
    $this->addElement('Hidden', 'selected_photo_id', array(
        'order' => $i--,
    ));

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Photos',
      'type' => 'submit',
    ));
  }

  public function clearAlbum() {
    $this->getElement('album')->setValue(0);
  }

  public function saveValues() {

    $crowdfunding_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('crowdfunding_id',null);
		$album_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('album_id',null);
		
		if(isset($album_id)){
			$album = Engine_Api::_()->getItem('sescrowdfunding_album', $album_id);
		}
    $set_cover = false;
    $values = $this->getValues();
		
    $params = Array();
    if ((empty($values['owner_type'])) || (empty($values['owner_id'])))
    {
      $params['owner_id'] = Engine_Api::_()->user()->getViewer()->user_id;
    }
    else
    {
      $params['owner_id'] = $values['owner_id'];
      throw new Zend_Exception("Non-user album owners not yet implemented");
    }

		if (!isset($album))
		{
			$album = Engine_Api::_()->getItem('sescrowdfunding_album', $values['album']);
			
		}
		
		$selectedFile = trim($values['selected_photo_id'],' ');
		$explodeFile = explode(' ',$selectedFile);
		$db = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding')->getAdapter();
    $db->beginTransaction();
		 $photoTable = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding');
		$viewer = Engine_Api::_()->user()->getViewer();
		$siteUrl = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST']).Zend_Registry::get('StaticBaseUrl');
		foreach($explodeFile as $file){
			if(!$file)
				continue;
			$file_id = Engine_Api::_()->getItem('sesalbum_photo',$file)->file_id;
			if(!$file_id)
				continue;
			$storage_file = Engine_Api::_()->getItem('storage_file',$file_id)->storage_path;
			$storage_file = $siteUrl.$storage_file;
			try
			{
				$photo = $photoTable->createRow();
				$photo->setFromArray(array(
					'user_id' => $viewer->getIdentity()
				));
				$photo->crowdfunding_id = $crowdfunding_id;
     	  $photo->album_id = $album->album_id;
				$photo->save();

				$photo->order = $photo->photo_id;
				$file_id = Engine_Api::_()->artist()->setPhoto($storage_file, false,false,'sescrowdfunding',$photo->getType(),'',$photo,true);
				if($file_id)
					$photo->file_id = $file_id;
				//$photo->setPhoto($storage_file);
				$photo->save();

				$db->commit();
			} catch( Album_Model_Exception $e ) {
				$db->rollBack();
				throw $e;
			}
		}
    $explodeFile = explode(' ',rtrim($_POST['file'],' '));
    foreach( $explodeFile as $photo_id ) {

      $photo = Engine_Api::_()->getItem("sescrowdfunding_photo", $photo_id);
      if( !($photo instanceof Core_Model_Item_Abstract) || !$photo->getIdentity() ) continue;

      if( $set_cover )
      {
        $album->photo_id = $photo_id;
        $album->save();
        $set_cover = false;
      }

      $photo->crowdfunding_id = $crowdfunding_id;
      $photo->album_id = $album->album_id;
      $photo->order    = $photo_id;
      $photo->save();
    }

    return $album;
  }

}
