<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sesmember',
        //'sku' => 'sesmember',
        'version' => '4.10.5',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
        'path' => 'application/modules/Sesmember',
        'title' => 'SES - Advanced Members Plugin - Enhanced Searching, Reviews, Compliments, Members Verification & Location',
        'description' => 'SES - Advanced Members Plugin - Enhanced Searching, Reviews, Compliments, Members Verification & Location',
        'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
        'callback' => array(
            'path' => 'application/modules/Sesmember/settings/install.php',
            'class' => 'Sesmember_Installer',
        ),
        'actions' =>
        array(
            0 => 'install',
            1 => 'upgrade',
            2 => 'refresh',
            3 => 'enable',
            4 => 'disable',
        ),
        'directories' =>
        array(
            0 => 'application/modules/Sesmember',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sesmember.csv',
        ),
    ),
    'items' => array(
        'sesmember_homepage',
        'sesmember_review',
		'sesmember_userdetail',
        'sesmember_parameter',
        'sesmember_compliment',
        'sesmember_profilephoto',
        'sesmember_usercompliment',
        'sesmember_follow',
        'sesmember_userinfo'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserCreateAfter',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onRenderLayoutDefault',
            'resource' => 'Sesmember_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutDefaultSimple',
            'resource' => 'Sesmember_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefault',
            'resource' => 'Sesmember_Plugin_Core'
        ),
        array(
            'event' => 'onRenderLayoutMobileDefaultSimple',
            'resource' => 'Sesmember_Plugin_Core'
        ),
        array(
            'event' => 'onCoreLikeCreateAfter',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onCoreLikeDeleteAfter',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onCoreLikeDeleteBefore',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onFieldMetaCreate',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onFieldMetaEdit',
            'resource' => 'Sesmember_Plugin_Core',
        ),
        array(
            'event' => 'onItemCreateAfter',
            'resource' => 'Sesmember_Plugin_Core',
        ),
				array(
					'event' => 'onUserDeleteBefore',
					'resource' => 'Sesmember_Plugin_Core',
				),
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesmember_general' => array(
            'route' => 'member/:action/*',
            'defaults' => array(
                'module' => 'sesmember',
                'controller' => 'index',
                'action' => 'browse',
            ),
            'reqs' => array(
                'action' => '(browse|locations|featured-block|review-stats|edit-compliment|delete-compliment|get-friends|get-mutual-friends|nearest-member|top-members|pinborad-view-members|add-location|edit-location|member-compliments|alphabetic-members-search|editormembers)',
            )
        ),
        'sesmember_review_view' => array(
            'route' => 'reviews/:action/:review_id/:slug',
            'defaults' => array(
                'module' => 'sesmember',
                'controller' => 'review',
                'action' => 'view',
                'slug' => ''
            ),
            'reqs' => array(
                'action' => '(edit|view|delete|edit-review)',
                'review_id' => '\d+'
            )
        ),
        'sesmember_review' => array(
            'route' => 'browse-review/:action/*',
            'defaults' => array(
                'module' => 'sesmember',
                'controller' => 'review',
                'action' => 'browse'
            ),
        ),
    ),
);
