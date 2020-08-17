<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagepoll_Api_Core extends Core_Api_Abstract
{
public function getSearchWidgetParams($widgetId) {
    $db = Engine_Db_Table::getDefaultAdapter();
    $pageId = $db->select()
            ->from('engine4_core_content', 'page_id')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`page_id` = ?', $pageId)
            ->where('`name` = ?', 'sespagepoll.browse-search')
            ->query()
            ->fetchColumn();
    if ($params)
      return json_decode($params, true);
    else
      return 0;
  }
}
