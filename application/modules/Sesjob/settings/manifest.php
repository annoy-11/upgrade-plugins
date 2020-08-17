<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$jobsRoute = "jobs";
$module1 = null;
$controller = null;
$action = null;
$request = Zend_Controller_Front::getInstance()->getRequest();
if (!empty($request)) {
  $module1 = $request->getModuleName();
  $action = $request->getActionName();
  $controller = $request->getControllerName();
}
if (empty($request) || !((strpos($_SERVER['REQUEST_URI'],'/install/') !== false))) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
  $jobsRoute = $setting->getSetting('sesjob.jobs.manifest', 'jobs');
  $jobRoute = $setting->getSetting('sesjob.job.manifest', 'job');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesjob',
    //'sku' => 'sesjob',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesjob',
    'title' => 'SES - Advanced Job Plugin',
    'description' => 'SES - Advanced Job Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Sesjob/settings/install.php',
      'class' => 'Sesjob_Installer',
    ),
    'directories' => array(
      'application/modules/Sesjob',
    ),
    'files' => array(
      'application/languages/en/sesjob.csv',
    ),
  ),
  // Compose
  'composer' => array(
    'sesjob' => array(
      'script' => array('_composeJob.tpl', 'sesjob'),
      'auth' => array('sesjob_job', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesjob_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesjob_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Sesjob_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Sesjob_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Sesjob_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Sesjob_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesjob',
    'sesjob_parameter',
    'sesjob_job',
    'sesjob_category',
    'sesjob_dashboards',
    'sesjob_album',
    'sesjob_photo',
    'sesjob_categorymapping',
    'sesjob_industry',
    'sesjob_employment',
    'sesjob_education',
    'sesjob_company',
    'sesjob_application',
    'sesjob_cpnysubscribe',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'sesjob_specific' => array(
      'route' => $jobsRoute.'/:action/:job_id/*',
      'defaults' => array(
        'module' => 'sesjob',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'job_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesjob_general' => array(
      'route' => $jobsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesjob',
        'controller' => 'index',
        'action' => 'home',
      ),
      'reqs' => array(
        'action' => '(index|browse|create|manage|style|tag|upload-photo|link-job|job-request|tags|home|locations|contributors)',
      ),
    ),
    'sesjob_companygeneral' => array(
      'route' => $jobsRoute.'/companies/:action/*',
      'defaults' => array(
        'module' => 'sesjob',
        'controller' => 'company',
        'action' => 'browse',
      ),
    ),

            'sesjob_extended' => array(
            'route' => 'Sesjobs/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesjob',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    'sesjob_view' => array(
      'route' => $jobRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'sesjob',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
		'sesjob_company_view' => array(
		    'route' => $jobsRoute.'/company/:company_id/*',
		    'defaults' => array(
		        'module' => 'sesjob',
		        'controller' => 'company',
		        'action' => 'view',
		    ),
            'reqs' => array(
                'action' => '(browse|edit|view)',
            ),
		),
		'sesjob_category_view' => array(
		    'route' => $jobsRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'sesjob',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
    'sesjob_entry_view' => array(
      'route' => $jobRoute.'/:job_id/*',
      'defaults' => array(
        'module' => 'sesjob',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),

            'sesjob_dashboard' => array(
            'route' => $jobsRoute.'/dashboard/:action/:job_id/*',
            'defaults' => array(
                'module' => 'sesjob',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|job-role|save-job-admin|fields|upgrade|edit-location|applications)',
            )
        ),
                'sesjob_category' => array(
            'route' => $jobsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesjob',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
  ),
);
