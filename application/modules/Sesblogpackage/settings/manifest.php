<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'sesblogpackage',
    'version' => '4.8.10',
    'path' => 'application/modules/Sesblogpackage',
    'title' => 'SES - Advanced Blog Package',
    'description' => 'Advanced Blog Package',
     'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'callback' => array(
				'path' => 'application/modules/Sesblogpackage/settings/install.php',
				'class' => 'Sesblogpackage_Installer',
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
      0 => 'application/modules/Sesblogpackage',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/sesblogpackage.csv',
    ),
  ),
	 // Items ---------------------------------------------------------------------
    'items' => array(
        'sesblogpackage_package','sesblogpackage_transaction','sesblogpackage_gateway','sesblogpackage_orderspackage'
    ),
		 // Routes --------------------------------------------------------------------
    'routes' => array(
        'sesblogpackage_general' => array(
            'route' => 'blogpackage/:action/*',
            'defaults' => array(
                'module' => 'sesblogpackage',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(blog|confirm-upgrade)',
            )
        ),
				'sesblogpackage_payment' => array(
            'route' => 'blogpayment/:action/*',
            'defaults' => array(
                'module' => 'sesblogpackage',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|process|return|finish)',
            )
        )
			),
); ?>