<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Activity
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Body.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Core
 * @package    Activity
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Activity_Model_Helper_Body extends Activity_Model_Helper_Abstract
{
    /**
     * Body helper
     *
     * @param string $body
     * @return string
     */
    public function direct($body, $noTranslate = false)
    {
        if (Zend_Registry::isRegistered('Zend_View')) {
            $view = Zend_Registry::get('Zend_View');
            $body = $view->viewMore($body);
        }

        $body = Engine_Text_Emoji::decode($body);

        return '<span class="feed_item_bodytext">' . $body . '</span>';
    }
}
