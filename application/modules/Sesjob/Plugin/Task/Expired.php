<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Expired.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Plugin_Task_Expired extends Core_Plugin_Task_Abstract {

    public function execute() {

        $expiration_days = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.expirationtime', '30');

        $table = Engine_Api::_()->getDbTable('jobs', 'sesjob');
        $select = $table->select()
                    ->where('draft =?', 0)
                    ->where('is_approved =?', 1)
                    ->where('expired =?', 0)
                    ->where('is_publish =?', 0)
                    ->where('publish_date <= now() - INTERVAL '.$expiration_days.' DAY');
        $jobs = $table->fetchAll($select);
        if(count($jobs) > 0) {
            foreach($jobs as $job) {
                Engine_Api::_()->getItemTable('sesjob_job')->update(array('expired' => 1), array('job_id = ?' => $job->job_id));
            }
        }
    }
}
