<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Api_Core extends Core_Api_Abstract {

    public function postCount($subject_id) {

        $actionTable = Engine_Api::_()->getDbTable('actions', 'activity');
        $actionTableName = $actionTable->info('name');

        $select = $actionTable->select()
                    ->from($actionTable, array('action_id'))
                    ->where('subject_id =?', $subject_id);
        $results = $actionTable->fetchAll($select);
        return Engine_Api::_()->sesbasic()->number_format_short(count($results));

    }

    public function setPhotoIcons($photo, $menuId = null) {

        $temp_path = dirname($photo['tmp_name']);
        $main_file_name = $temp_path . '/' . $photo['name'];
        $params = array(
            'parent_id' => $menuId,
            'parent_type' => "twitterclone",
        );
        $image = Engine_Image::factory();
        $image->open($photo['tmp_name']);
        $image->open($photo['tmp_name'])
                ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
                ->write($main_file_name)
                ->destroy();
        try {
        $photo_params = Engine_Api::_()->storage()->create($main_file_name, $params);
        } catch (Exception $e) {
        if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
            echo $e->getMessage();
            exit();
        }
        }
        return $photo_params;
    }

    public function getContantValueXML($key) {
        $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
        $results = simplexml_load_file($filePath);
        $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
        $nodeName = $xmlNodes[0];
        $value = $nodeName->value;
        return $value;
    }

    public function readWriteXML($keys, $value, $default_constants = null) {

        $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
        $results = simplexml_load_file($filePath);

        if (!empty($keys) && !empty($value)) {
            $contactsThemeArray = array($keys => $value);
        } elseif (!empty($keys)) {
            $contactsThemeArray = array($keys => '');
        } elseif ($default_constants) {
            $contactsThemeArray = $default_constants;
        }

        foreach ($contactsThemeArray as $key => $value) {
            $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
            $nodeName = $xmlNodes[0];
            $params = json_decode(json_encode($nodeName));
            $paramsVal = $params->value;
            if ($paramsVal && $paramsVal != '' && $paramsVal != null) {
                $nodeName->value = $value;
            } else {
                $entry = $results->addChild('constant');
                $entry->addChild('name', $key);
                $entry->addChild('value', $value);
            }
        }
        return $results->asXML($filePath);
    }
}
