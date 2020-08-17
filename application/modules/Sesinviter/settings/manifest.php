<?php

return array (
'package' =>
  array(
    'type' => 'module',
    'name' => 'sesinviter',
    'version' => '4.10.3p6',
    'path' => 'application/modules/Sesinviter',
    'title' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'description' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => array(
        'path' => 'application/modules/Sesinviter/settings/install.php',
        'class' => 'Sesinviter_Installer',
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
        0 => 'application/modules/Sesinviter',
    ),
    'files' =>
    array(
        0 => 'application/languages/en/sesinviter.csv',
    ),
  ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'sesinviter_introduce', 'sesinviter_invite', 'sesinviter_affiliate'
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
        'event' => 'onUserCreateAfter',
        'resource' => 'Sesinviter_Plugin_Core',
        ),
    ),
    'routes' => array(
        'sesinviter_general' => array(
            'route' => 'inviter/:action/*',
            'defaults' => array(
                'module' => 'sesinviter',
                'controller' => 'index',
                'action' => 'signup',
            ),
            'reqs' => array(
                'action' => '(invite|inviteref|signup|manage|manage-referrals)',
            )
        ),
    )
);
