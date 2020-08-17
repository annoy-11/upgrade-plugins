<?php

class Eocsso_Form_Admin_Global extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');
  }
}