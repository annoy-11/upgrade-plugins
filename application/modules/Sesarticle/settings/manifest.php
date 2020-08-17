<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$articlesRoute = "articles";
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
  $articlesRoute = $setting->getSetting('sesarticle.articles.manifest', 'articles');
  $articleRoute = $setting->getSetting('sesarticle.article.manifest', 'article');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesarticle',
    //'sku' => 'sesarticle',
    'version' => '4.10.5',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.10.5',
        ),
    ),
    'path' => 'application/modules/Sesarticle',
    'title' => 'SES - Advanced Article Plugin',
    'description' => 'SES - Advanced Article Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Sesarticle/settings/install.php',
      'class' => 'Sesarticle_Installer',
    ),
    'directories' => array(
      'application/modules/Sesarticle',
    ),
    'files' => array(
      'application/languages/en/sesarticle.csv',
    ),
  ),
  // Compose
  'composer' => array(
    'sesarticle' => array(
      'script' => array('_composeArticle.tpl', 'sesarticle'),
      'auth' => array('sesarticle', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesarticle_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesarticle_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Sesarticle_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Sesarticle_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Sesarticle_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Sesarticle_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesarticle',
    'sesarticle_parameter',
    'sesarticle_claim',
    'sesarticle_category',
    'sesarticle_dashboards',
    'sesarticle_album',
    'sesarticle_photo',
    'sesarticlereview',
    'sesarticle_categorymapping',
	'sesarticle_integrateothermodule',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'sesarticle_specific' => array(
      'route' => $articlesRoute.'/:action/:article_id/*',
      'defaults' => array(
        'module' => 'sesarticle',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'article_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesarticle_general' => array(
      'route' => $articlesRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesarticle',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|index|browse|create|manage|style|tag|upload-photo|link-article|article-request|tags|home|claim|claim-requests|locations|rss-feed)',
      ),
    ),

            'sesarticle_extended' => array(
            'route' => 'Sesarticles/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesarticle',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    'sesarticle_view' => array(
      'route' => $articleRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'sesarticle',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
		'sesarticle_category_view' => array(
		    'route' => $articlesRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'sesarticle',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
    'sesarticle_entry_view' => array(
      'route' => $articleRoute.'/:article_id/*',
      'defaults' => array(
        'module' => 'sesarticle',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),
    'sesarticlereview_extended' => array(
        'route' => $articlesRoute.'/reviews/:action/:article_id/*',
        'defaults' => array(
            'module' => 'sesarticle',
            'controller' => 'review',
            'action' => 'index',
        ),
        'reqs' => array(
            'article_id' => '\d+',
            'action' => '(create)',
        )
    ),
            'sesarticle_specific_album' => array(
					'route' =>  'article-album/:action/:album_id',
					'defaults' => array(
							'module' => 'sesarticle',
							'controller' => 'album',
							'action' => 'view',
						),
							'reqs' => array(
							'album_id' => '\d+'
						)
        ),
    'sesarticlereview_view' => array(
        'route' => $articlesRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'sesarticle',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete)',
            'review_id' => '\d+'
        )
    ),
            'sesarticle_dashboard' => array(
            'route' => $articlesRoute.'/dashboard/:action/:article_id/*',
            'defaults' => array(
                'module' => 'sesarticle',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|article-role|save-article-admin|fields|upgrade|edit-location)',
            )
        ),
                'sesarticle_review' => array(
            'route' => $articlesRoute.'/browse-review/:action/*',
            'defaults' => array(
                'module' => 'sesarticle',
                'controller' => 'review',
                'action' => 'browse'
            ),
        ),
                'sesarticle_category' => array(
            'route' => $articlesRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesarticle',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'sesarticle_import' => array(
      'route' => $articlesRoute.'/import/:action/*',
      'defaults' => array(
        'module' => 'sesarticle',
        'controller' => 'import',
        'action' => 'index',
      ),
      'reqs' => array(
                'action' => '(index)',
            )

    ),
  ),
);
