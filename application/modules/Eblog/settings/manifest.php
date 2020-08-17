<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$blogsRoute = "blogs";
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
  $blogsRoute = $setting->getSetting('eblog.blogs.manifest', 'blogs');
  $blogRoute = $setting->getSetting('eblog.blog.manifest', 'blog');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'eblog',
    //'sku' => 'eblog',
    'version' => '4.10.5',
    'path' => 'application/modules/Eblog',
    'title' => 'SNS - Advanced Blog Plugin',
    'description' => 'SNS - Advanced Blog Plugin',
    'author' => '<a href="http://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Eblog/settings/install.php',
      'class' => 'Eblog_Installer',
    ),
    'directories' => array(
      'application/modules/Eblog',
    ),
    'files' => array(
      'application/languages/en/eblog.csv',
    ),
  ),
  // Compose
  'composer' => array(
    'eblog' => array(
      'script' => array('_composeBlog.tpl', 'eblog'),
      'auth' => array('eblog_blog', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Eblog_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Eblog_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Eblog_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Eblog_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Eblog_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Eblog_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'eblog',
    'eblog_parameter',
    'eblog_blog',
    'eblog_claim',
    'eblog_category',
    'eblog_dashboards',
    'eblog_album',
    'eblog_photo',
    'eblog_review',
    'eblog_categorymapping',
    'eblog_integrateothermodule',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'eblog_specific' => array(
      'route' => $blogsRoute.'/:action/:blog_id/*',
      'defaults' => array(
        'module' => 'eblog',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'blog_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'eblog_general' => array(
      'route' => $blogsRoute.'/:action/*',
      'defaults' => array(
        'module' => 'eblog',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|index|browse|create|manage|style|tag|upload-photo|link-blog|blog-request|tags|home|claim|claim-requests|locations|rss-feed|contributors|nonloginredirect|viewpagescroll)',
      ),
    ),

            'eblog_extended' => array(
            'route' => 'Eblogs/:controller/:action/*',
            'defaults' => array(
                'module' => 'eblog',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    'eblog_view' => array(
      'route' => $blogRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'eblog',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
		'eblog_category_view' => array(
		    'route' => $blogsRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'eblog',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
    'eblog_entry_view' => array(
      'route' => $blogRoute.'/:blog_id/*',
      'defaults' => array(
        'module' => 'eblog',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),
    'eblogreview_extended' => array(
        'route' => $blogsRoute.'/reviews/:action/:blog_id/*',
        'defaults' => array(
            'module' => 'eblog',
            'controller' => 'review',
            'action' => 'index',
        ),
        'reqs' => array(
            'blog_id' => '\d+',
            'action' => '(create)',
        )
    ),
            'eblog_specific_album' => array(
					'route' =>  'blog-album/:action/:album_id',
					'defaults' => array(
							'module' => 'eblog',
							'controller' => 'album',
							'action' => 'view',
						),
							'reqs' => array(
							'album_id' => '\d+'
						)
        ),
    'eblogreview_view' => array(
        'route' => $blogsRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'eblog',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete)',
            'review_id' => '\d+'
        )
    ),
            'eblog_dashboard' => array(
            'route' => $blogsRoute.'/dashboard/:action/:blog_id/*',
            'defaults' => array(
                'module' => 'eblog',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|blog-role|save-blog-admin|fields|upgrade|edit-location|change-owner|search-member)',
            )
        ),
                'eblog_review' => array(
            'route' => $blogsRoute.'/browse-review/:action/*',
            'defaults' => array(
                'module' => 'eblog',
                'controller' => 'review',
                'action' => 'browse'
            ),
        ),
                'eblog_category' => array(
            'route' => $blogsRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'eblog',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'eblog_import' => array(
      'route' => $blogsRoute.'/import/:action/*',
      'defaults' => array(
        'module' => 'eblog',
        'controller' => 'import',
        'action' => 'index',
      ),
      'reqs' => array(
                'action' => '(index)',
            )

    ),
  ),
);
