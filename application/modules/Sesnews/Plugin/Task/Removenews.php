<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Removenews.php  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesnews_Plugin_Task_Removenews extends Core_Plugin_Task_Abstract {

    public function execute() {

        $remove_days = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.removeoldnews', '60');

        $newsTable = Engine_Api::_()->getDbTable('news', 'sesnews');
        $newsTableName = $newsTable->info('name');
        $select = $newsTable->select()
                        ->setIntegrityCheck(false)
                        ->from($newsTableName)
                        ->where('creation_date <= now() - INTERVAL '.$remove_days.' DAY');
        $newsResults = $newsTable->fetchAll($select);
        foreach($newsResults as $newsResult) {
            Engine_Api::_()->sesnews()->deleteNews($newsResult);
        }
    }
}
