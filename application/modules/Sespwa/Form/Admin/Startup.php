<?php

class Sespwa_Form_Admin_Startup extends Engine_Form {
  protected $_mode;

  public function init() {

    $this->setTitle('Choose startup screen data')
            ->setDescription('');

    // Get available files
    $images = array('0' => '');
    $allowedExt = array('gif', 'jpg', 'jpeg', 'png');

    $it = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($it as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $basename = basename($file->getFilename());
      if (!($pos = strrpos($basename, '.')))
        continue;
      $ext = strtolower(ltrim(substr($basename, $pos), '.'));
      if (!in_array($ext, $allowedExt))
        continue;
        $images['public/admin/' . $basename] = $basename;
    }
      asort($images);
      $images[0] = '';

    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'value'=>Engine_Api::_()->getApi('settings', 'core')->getSetting('core_general_site_title'),
    ));
      $this->addElement('Radio', 'copyright', array(
          'label' => 'Show Copyright',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>'1',
      ));
    $this->addElement('Select', 'logo', array(
        'label' => 'Select Logo Image',
        'multiOptions' => $images,
    ));
  }

}