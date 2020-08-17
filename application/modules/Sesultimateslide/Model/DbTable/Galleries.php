<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: galleries.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesultimateslide_Model_DbTable_galleries extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Sesultimateslide_Model_Gallery";

    public function getDbslideSelect($params = array()) {

        //echo "<pre>"; print_r($this->select()); die;
        $viewer = Engine_Api::_()->user()->getViewer();

        $table = Engine_Api::_()->getDbtable('galleries', 'sesultimateslide');
        $rName = $table->info('name');

        $select = $this->select()
                ->order(!empty($params['orderby']) ? $params['orderby'] . ' DESC' : $rName . '.creation_date DESC');


        return $select;
    }

    public function getDbslidePaginator($params = array()) {


        $paginator = Zend_Paginator::factory($this->getDbslideSelect($params));

        return $paginator;
    }

}
