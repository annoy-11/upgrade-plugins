<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Company.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_Company extends Core_Model_Item_Abstract {

    protected $_searchTriggers = false;
    protected $_modifiedTriggers = false;
	
	public function getTitle() {
		return $this->company_name;
	}

    public function getHref($params = array()) {

        $params = array_merge(array(
            'route' => 'sesjob_company_view',
            'reset' => true,
            'company_id' => $this->company_id,
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()
                        ->assemble($params, $route, $reset);
    }

    public function getPhotoUrl($type = null) {
        $photo_id = $this->photo_id;
        if ($photo_id) {
            $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, $type);
            if($file)
                return $file->map();
            else{
                $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id,'thumb.profile');
                if($file)
                    return $file->map();
            }
        }
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $defaultPhoto = Zend_Registry::get('StaticBaseUrl').'application/modules/Sesjob/externals/images/nophoto_company_thumb_profile.png';
        return $defaultPhoto;
    }
}
