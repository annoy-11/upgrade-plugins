<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Companies.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Companies extends Engine_Db_Table {

  protected $_rowClass = 'Sesjob_Model_Company';

    public function getCompaniesAssoc($params = array()) {
        $select = $this->select()
            ->from($this, array('company_id', 'company_name'))
            ->order('company_name ASC');

        if(isset($params['user_id']) && !empty($params['user_id']))
            $select->where('owner_id =?', $params['user_id']);

        $results = $this->fetchAll($select);
        $data = array();
        foreach( $results as $company ) {
            $data[$company['company_id']] = $company['company_name'];
        }

        return $data;
    }

    /**
    * Gets a paginator for companies
    *
    * @param Core_Model_Item_Abstract $user The user to get the messages for
    * @return Zend_Paginator
    */
    public function getCompaniesPaginator($params = array()) {

        $paginator = Zend_Paginator::factory($this->getCompanySelect($params));

        if( !empty($params['page']) )
            $paginator->setCurrentPageNumber($params['page']);

        if( !empty($params['limit']) )
            $paginator->setItemCountPerPage($params['limit']);

        return $paginator;
    }

    /**
    * Gets a select object for the user's sesjob entries
    *
    * @param Core_Model_Item_Abstract $user The user to get the messages for
    * @return Zend_Db_Table_Select
    */
    public function getCompanySelect($params = array()) {

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();

        $companiesTable = Engine_Api::_()->getDbtable('companies', 'sesjob');
        $companiesTableName = $companiesTable->info('name');

        $select = $companiesTable->select()/*->setIntegrityCheck(false)*/->from($companiesTableName);
        $select->where($companiesTableName.'.enable =?', 1);

        if( !empty($params['industry_id']) && is_numeric($params['industry_id']) )
            $select->where($companiesTableName.'.industry_id = ?', $params['industry_id']);

        if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
            $select->where($companiesTableName . ".company_name LIKE ?", $params['alphabet'] . '%');

        if(isset($params['popularCol']) && !empty($params['popularCol'])) {
            $select = $select->order($companiesTableName . '.' .$params['popularCol'] . ' DESC');
        }

        if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
        $select = $select->where($companiesTableName . '.' . $params['fixedData'] . ' =?', 1);

        if (!empty($params['category_id']))
        $select = $select->where($companiesTableName . '.category_id =?', $params['category_id']);

        if( !empty($params['text']) )
        $select->where($companiesTableName.".company_name LIKE ? OR ".$companiesTableName.".company_description LIKE ?", '%'.$params['text'].'%');

        if( !empty($params['textSearch']) )
        $select->where($companiesTableName.".company_name LIKE ? OR ".$companiesTableName.".company_description LIKE ?", '%'.$params['textSearch'].'%');

        if (isset($params['criteria'])) {
            switch ($params['info']) {
                case 'recently_created':
                    $select->order($companiesTableName . '.creation_date DESC');
                    break;
                case 'most_viewed':
                    $select->order($companiesTableName . '.view_count DESC');
                    break;
                case 'random':
                    $select->order('Rand()');
                    break;
            }
        }

        $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $companiesTableName.'.creation_date DESC' );
        if(isset($params['fetchAll'])) {
        return $this->fetchAll($select);
        }
        else
            return $select;
    }
}
