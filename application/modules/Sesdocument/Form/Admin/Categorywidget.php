<?php

class Sesdocument_Form_Admin_Categorywidget extends Engine_Form
{
  public function init()
  {
		$this->addElement('textarea', "description", array(
			'label' => "Category Description."
    ));
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
		if (count($banner_options) > 1){
			$link = '<a>asd</a>';
      $this->addElement('Select', 'sesdocument_category_cover', array(
          'label' => 'Document Category Default Cover Photo',
          'description' => 'Choose a default cover photo for the document categories on your website. [Note: You can add a new photo from the "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section from here: .$link.. Leave the field blank if you do not want to change document category default cover photo.]',
          'multiOptions' => $banner_options,
      ));
      $this->sesdocument_category_cover->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }else{
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo to add for category cover. Image to be chosen for category cover should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.') . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'category_cover', array(
          'label' => 'Document Category Default Cover Photo',
          'description' => $description,
      ));
      $this->category_cover->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }

	 $this->addElement('Text', "title_pop", array(
			'label' => "Title for document",
			'value'=>'Documents',
    ));

		$this->addElement(
				'Select',
				'info',
				array(
						'label' => "choose criteria by which document shown in this widget.",
						'multiOptions' => array(
							     '' =>'',
													 "creation_date" => "Recently Created",
                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            "most_viewed"=>"Most Viewed",
                            "sponsored"=>"Sponsored",
                            "featured"=>"Featured",
                            "verified"=>"Verified",


						),
						'value'=>'',
				)
		);
	}
}
