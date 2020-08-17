<?php 

return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'ecoupon',
    'version' => '4.10.5',
    'path' => 'application/modules/Ecoupon',
    'title' => 'SNS - Advanced Discount & Coupon Plugin',
    'description' => 'Ecoupon',
    'author' => 'socialenginesolutions',
    'callback' => 
    array (
      'path' => 'application/modules/Ecoupon/settings/install.php',
      'class' => 'Ecoupon_Installer',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Ecoupon',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/ecoupon.csv',
    ),
  ),
   'hooks' => array(
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Ecoupon_Plugin_Core',
      ),
      array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Ecoupon_Plugin_Core'
      ),
  ),
  
    // Items ---------------------------------------------------------------------
  'items' => array(
      'coupon',
      'ecoupon_coupon',
      'ecoupon_ordercoupon',
      'ecoupon_type',
  ),
  'routes' => array(
    'ecoupon_general' => array(
        'route' => '/coupon/:action/*',
        'defaults' => array(
            'module' => 'ecoupon',
            'controller' => 'index',
            'action' => 'create',
        ),
        'reqs' => array(
            'action' => '(create|edit|view|check-availability|delete|enable|print|browse|coupon-faqs|applied|manage)',
        )
    ),
    'ecoupon_profile' => array(
        'route' => '/coupon/:subject/view/:action/:coupon_id/*',
        'defaults' => array(
            'module' => 'ecoupon',
            'controller' => 'profile',
            'action' => 'index',
        ),
        'reqs' => array(
            'action' => '(index)',
        )
    ),
  ),
); ?> 
