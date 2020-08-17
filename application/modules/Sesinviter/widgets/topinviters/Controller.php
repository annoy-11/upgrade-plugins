<?php

class Sesinviter_Widget_TopinvitersController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    $this->view->params = $params = $this->_getAllParams();
    $informations = $params['information'];
    foreach ($informations as $information)
      $this->view->{$information . 'Active'} = $information;

    // Get paginator
    $table = Engine_Api::_()->getDbTable('invites', 'sesinviter');
    $select = $table->select()
        ->from($table->info('name'), array('*', new Zend_Db_Expr('COUNT(sender_id) as topinviters')))
        ->group('sender_id')
        ->order('topinviters DESC')
        ->limit($params['limit']);
    $this->view->results = $results = $table->fetchAll($select);
    if(count($results) == 0)
        return $this->setNoRender();

  }
}
