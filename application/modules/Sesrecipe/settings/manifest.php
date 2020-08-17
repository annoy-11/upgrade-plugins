<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$recipesRoute = "recipes";
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
  $recipesRoute = $setting->getSetting('sesrecipe.recipes.manifest', 'recipes');
  $recipeRoute = $setting->getSetting('sesrecipe.recipe.manifest', 'recipe');
}

return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'sesrecipe',
    //'sku' => 'sesrecipe',
    'version' => '4.10.5p1',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesrecipe',
    'title' => 'SES - Recipes With Reviews & Location Plugin',
    'description' => 'SES - Recipes With Reviews & Location Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Sesrecipe/settings/install.php',
      'class' => 'Sesrecipe_Installer',
    ),
    'directories' => array(
      'application/modules/Sesrecipe',
    ),
    'files' => array(
      'application/languages/en/sesrecipe.csv',
      'public/admin/recipes.jpg',
    ),
  ),
  // Compose
  'composer' => array(
    'sesrecipe' => array(
      'script' => array('_composeRecipe.tpl', 'sesrecipe'),
      'auth' => array('sesrecipe_recipe', 'create'),
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Sesrecipe_Plugin_Core'
    ),
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesrecipe_Plugin_Core',
		),
		array(
				'event' => 'onRenderLayoutDefaultSimple',
				'resource' => 'Sesrecipe_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefault',
				'resource' => 'Sesrecipe_Plugin_Core'
		),
		array(
				'event' => 'onRenderLayoutMobileDefaultSimple',
				'resource' => 'Sesrecipe_Plugin_Core'
		),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Sesrecipe_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesrecipe',
    'sesrecipe_parameter',
    'sesrecipe_recipe',
    'sesrecipe_claim',
    'sesrecipe_category',
    'sesrecipe_dashboards',
    'sesrecipe_album',
    'sesrecipe_photo',
    'sesrecipe_review',
    'sesrecipe_categorymapping',
    'sesrecipe_integrateothermodule',
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    // Public
    'sesrecipe_specific' => array(
      'route' => $recipesRoute.'/:action/:recipe_id/*',
      'defaults' => array(
        'module' => 'sesrecipe',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'recipe_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'sesrecipe_general' => array(
      'route' => $recipesRoute.'/:action/*',
      'defaults' => array(
        'module' => 'sesrecipe',
        'controller' => 'index',
        'action' => 'welcome',
      ),
      'reqs' => array(
        'action' => '(welcome|index|browse|create|manage|style|tag|upload-photo|link-recipe|recipe-request|tags|home|claim|claim-requests|locations|rss-feed|contributors)',
      ),
    ),

            'sesrecipe_extended' => array(
            'route' => 'Sesrecipes/:controller/:action/*',
            'defaults' => array(
                'module' => 'sesrecipe',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'controller' => '\D+',
                'action' => '\D+',
            )
        ),
    'sesrecipe_view' => array(
      'route' => $recipeRoute.'/:user_id/*',
      'defaults' => array(
        'module' => 'sesrecipe',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
		'sesrecipe_category_view' => array(
		    'route' => $recipesRoute.'/category/:category_id/*',
		    'defaults' => array(
		        'module' => 'sesrecipe',
		        'controller' => 'category',
		        'action' => 'index',
		    )
		),
    'sesrecipe_entry_view' => array(
      'route' => $recipeRoute.'/:recipe_id/*',
      'defaults' => array(
        'module' => 'sesrecipe',
        'controller' => 'index',
        'action' => 'view',
      //  'slug' => '',
      ),
      'reqs' => array(
      ),
    ),
    'sesrecipereview_extended' => array(
        'route' => $recipesRoute.'/reviews/:action/:recipe_id/*',
        'defaults' => array(
            'module' => 'sesrecipe',
            'controller' => 'review',
            'action' => 'index',
        ),
        'reqs' => array(
            'recipe_id' => '\d+',
            'action' => '(create)',
        )
    ),
            'sesrecipe_specific_album' => array(
					'route' =>  'recipe-album/:action/:album_id',
					'defaults' => array(
							'module' => 'sesrecipe',
							'controller' => 'album',
							'action' => 'view',
						),
							'reqs' => array(
							'album_id' => '\d+'
						)
        ),
    'sesrecipereview_view' => array(
        'route' => $recipesRoute.'/reviews/:action/:review_id/:slug',
        'defaults' => array(
            'module' => 'sesrecipe',
            'controller' => 'review',
            'action' => 'view',
            'slug' => ''
        ),
        'reqs' => array(
            'action' => '(edit|view|delete)',
            'review_id' => '\d+'
        )
    ),
            'sesrecipe_dashboard' => array(
            'route' => $recipesRoute.'/dashboard/:action/:recipe_id/*',
            'defaults' => array(
                'module' => 'sesrecipe',
                'controller' => 'dashboard',
                'action' => 'edit',
            ),
            'reqs' => array(
                'action' => '(edit|edit-photo|remove-photo|contact-information|style|seo|recipe-role|save-recipe-admin|fields|upgrade|edit-location)',
            )
        ),
                'sesrecipe_review' => array(
            'route' => $recipesRoute.'/browse-review/:action/*',
            'defaults' => array(
                'module' => 'sesrecipe',
                'controller' => 'review',
                'action' => 'browse'
            ),
        ),
                'sesrecipe_category' => array(
            'route' => $recipesRoute . '/categories/:action/*',
            'defaults' => array(
                'module' => 'sesrecipe',
                'controller' => 'category',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(index|browse)',
            )
        ),
        'sesrecipe_import' => array(
      'route' => $recipesRoute.'/import/:action/*',
      'defaults' => array(
        'module' => 'sesrecipe',
        'controller' => 'import',
        'action' => 'index',
      ),
      'reqs' => array(
                'action' => '(index)',
            )

    ),
  ),
);
