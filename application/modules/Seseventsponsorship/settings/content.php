<?php

return array(
		array(
        'title' => 'SES - Advanced Events - Buy Sponsorship of Event',
        'description' => 'Displays a buy Sponsorship of Event on event view page.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'sesevent.buy-sponsorship',
        'defaultParams' => array(
            'title' => 'Buy Sponsorship',
        ),
        'requirements' => array(
            'subject' => 'sesevent_event',
        ),
		),
				array(
        'title' => 'SES - Advanced Events - Event Sponsorship View Page',
        'description' => 'Displays a Event Sponsorship view page.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'sesevent.sponsorship-view-page',
        'defaultParams' => array(
            'title' => 'Event Sponsorship View Page',
        ),
        'requirements' => array(
            'subject' => 'sesevent_event',
        ),
					'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'details',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'title' => 'Title',
                            'description' => 'Description',
                            'logo' => 'Logo',
                        ),
                    )
                ),
								array(
									'Text',
									'limit_data',
									array(
											'label' => 'count (number of sponsors to show).',
											'value' => 20,
											'validators' => array(
													array('Int', true),
													array('GreaterThan', true, array(0)),
											)
									)
            ),
						array(
								'Radio',
								'pagging',
								array(
										'label' => "Do you want the sponsors to be auto-loaded when users scroll down the page?",
										'multiOptions' => array(
												'button' => 'View more',
												'auto_load' => 'Auto Load',
												'pagging' => 'Pagination'
										),
										'value' => 'auto_load',
							)
        ),
			),
     ),
		),
				array(
        'title' => 'SES - Advanced Events - List Sponsors of Sponsorship of Event',
        'description' => 'Displays a list Sponsors of Sponsorship of Event on event view page.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'sesevent.event-sponsorship',
        'defaultParams' => array(
            'title' => 'Sponsors',
        ),
        'requirements' => array(
            'subject' => 'sesevent_event',
        ),
					'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'details',
                    array(
                        'label' => "Choose options to be shown in widget.",
                        'multiOptions' => array(
                            'title' => 'Title',
                            'description' => 'Description',
                            'logo' => 'Logo',
                        ),
                    )
                ),
								array(
									'Text',
									'limit_data',
									array(
											'label' => 'count (number of sponsors to show).',
											'value' => 20,
											'validators' => array(
													array('Int', true),
													array('GreaterThan', true, array(0)),
											)
									)
            ),
						array(
								'Radio',
								'pagging',
								array(
										'label' => "Do you want the sponsors to be auto-loaded when users scroll down the page?",
										'multiOptions' => array(
												'button' => 'View more',
												'auto_load' => 'Auto Load',
												'pagging' => 'Pagination'
										),
										'value' => 'auto_load',
							)
        ),
			),
     ),
    ),
    array(
        'title' => 'SES - Advanced Events - Request Sponsorship of Event',
        'description' => 'Displays a request Sponsorship of Event on event view page.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'sesevent.request-sponsorship',
        'requirements' => array(
            'subject' => 'sesevent_event',
        ),
    ),


);