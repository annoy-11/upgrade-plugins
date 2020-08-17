<?php

class Sesblogpackage_Form_Admin_Package_Edit extends Sesblogpackage_Form_Admin_Package_Create
{
  public function init()
  {
    parent::init();
    
    $this
      ->setTitle('Edit Package')
      ->setDescription('Please note that payment parameters (Price, Recurrence, Duration) cannot be edited. If you wish to change these, you will have to create a new package and disable the current one.')
      ;

    // Disable some elements
		$this->getElement('item_count')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
    // Disable some elements
    $this->getElement('price')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
    $this->getElement('recurrence')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
    $this->getElement('duration')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
    $this->removeElement('trial_duration');
   
		$this->getElement('is_renew_link')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
		$this->getElement('renew_link_days')
        ->setIgnore(true)
        ->setAttrib('disable', true)
        ->clearValidators()
        ->setRequired(false)
        ->setAllowEmpty(true)
        ;
    // Change the submit label
    $this->getElement('execute')->setLabel('Edit Package');
  }
}