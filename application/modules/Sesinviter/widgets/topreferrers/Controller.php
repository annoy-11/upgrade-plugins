<?php

class Sesinviter_Widget_TopreferrersController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    $this->view->params = $params = $this->_getAllParams();
    $informations = $params['information'];
    foreach ($informations as $information)
      $this->view->{$information . 'Active'} = $information;

    // Get paginator
    $table = Engine_Api::_()->getDbTable('affiliates', 'sesinviter');
    $select = $table->select()
        ->from($table->info('name'), array('*'))
        ->order('affiliates_count DESC')
        ->limit($params['limit']);
    $this->view->results = $results = $table->fetchAll($select);
    if(count($results) == 0)
        return $this->setNoRender();

  }
}
