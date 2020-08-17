<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Emails.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_Model_DbTable_Emails extends Engine_Db_Table {

    protected $_rowClass = "Emailtemplates_Model_Email";

    public function getResult() {

        $tableName = $this->info('name');
        $select = $this->select()
                ->from($tableName)
                ->where('stop =?', 1)
                ->order('email_id ASC');
        return $this->fetchAll($select);
    }
}
