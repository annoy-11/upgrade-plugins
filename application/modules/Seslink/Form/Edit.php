<?php

class Seslink_Form_Edit extends Seslink_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Link Entry')
      ->setDescription('Edit your entry below, then click "Save Changes" to publish.');
    $this->submit->setLabel('Save Changes');
  }
}