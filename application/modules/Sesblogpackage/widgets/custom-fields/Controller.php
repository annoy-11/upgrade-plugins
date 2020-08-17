<?php

class Sesblogpackage_Widget_CustomFieldsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		if(( !Engine_Api::_()->core()->hasSubject() ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesblogpackage')) {
      return $this->setNoRender();
    }
		
		$blog =	$this->view->blog = Engine_Api::_()->core()->getSubject() ;
			// Load fields view helpers
    $view = $this->view;
    $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');

    // Values
    $this->view->fieldStructure = $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($blog);
    if( count($fieldStructure) <= 1 ) { // @todo figure out right logic
      return $this->setNoRender();
    }
  }
}
