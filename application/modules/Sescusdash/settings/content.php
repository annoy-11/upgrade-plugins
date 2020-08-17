<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$dashboards = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sescusdash")) {
  $results = Engine_Api::_()->getDbtable('dashboards', 'sescusdash')->getDashboard(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $dashboard)
      $dashboards[$dashboard['dashboard_id']] = $dashboard['dashboard_name'];
  }
}
return array(
    array(
        'title' => 'SES - Custom Dashboard Plugin - Dashboard Links',
        'description' => 'This widget displays dashboard links for its menus on your website. The recommended
            Is member home page.',
        'category' => 'SES - Custom Dashboard Plugin',
        'type' => 'widget',
        'name' => 'sescusdash.deshboard-links',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'dashboard_id',
                    array(
                        'label' => 'Choose the Dashboard to be shown in this widget.',
                        'multiOptions' => $dashboards,
                        'value' => 1,
                    )
                ),
            )
        )
    ),
);
