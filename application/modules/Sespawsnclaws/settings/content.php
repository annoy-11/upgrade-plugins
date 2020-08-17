<?php

/**
 */
return array(
  array(
      'title' => 'SES Pawsnclaws - Intro Block',
      'description' => '',
      'category' => 'SES Pawsnclaws',
      'type' => 'widget',
      'name' => 'sespawsnclaws.intro-block'
  ),
  array(
      'title' => 'SES Pawsnclaws - Mobile App',
      'description' => '',
      'category' => 'SES Pawsnclaws',
      'type' => 'widget',
      'name' => 'sespawsnclaws.mobile-app'
  ),
  array(
      'title' => 'SES Pawsnclaws - Features',
      'description' => '',
      'category' => 'SES Pawsnclaws',
      'type' => 'widget',
      'name' => 'sespawsnclaws.features'
  ),
  array(
      'title' => 'SES Pawsnclaws - Photo Gallery',
      'description' => '',
      'category' => 'SES Pawsnclaws',
      'type' => 'widget',
      'name' => 'sespawsnclaws.photo-gallery'
  ),
    array(
        'title' => 'SES Pawsnclaws - Counters',
        'description' => 'This widget displays the counters entered in the admin panel of this theme.',
        'category' => 'SES Pawsnclaws',
        'type' => 'widget',
        'name' => 'sespawsnclaws.counters',
        'autoEdit' => false,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'backgroundimage',
                    array(
                        'label' => 'Choose the Background Image to be shown in this widget.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                  'Text',
                  'counter1',
                  array(
                    'label' => 'Enter Counter - 1 Value.',
                  ),
                  'value' => '500',
                ),
                array(
                  'Text',
                  'counter1text',
                  array(
                    'label' => 'Enter Counter - 1 Text.',
                  ),
                  'value' => 'Members',
                ),
                array(
                  'Text',
                  'counter2',
                  array(
                    'label' => 'Enter Counter - 2 Value.',
                  ),
                  'value' => '9',
                ),
                array(
                  'Text',
                  'counter2text',
                  array(
                    'label' => 'Enter Counter - 2 Text.',
                  ),
                  'value' => 'Year',
                ),
                array(
                  'Text',
                  'counter3',
                  array(
                    'label' => 'Enter Counter - 3 Value.',
                  ),
                  'value' => '25',
                ),
                array(
                  'Text',
                  'counter3text',
                  array(
                    'label' => 'Enter Counter - 3 Text.',
                  ),
                  'value' => 'Clients',
                ),
            ),
        ),
    ),
);
