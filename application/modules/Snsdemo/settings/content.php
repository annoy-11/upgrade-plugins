<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'Main Demo Strip',
    'description' => '',
    'category' => 'SNS - Demo Plugin',
    'type' => 'widget',
    'name' => 'snsdemo.maindemo-strip',
  'adminForm' => array(
    'elements' => array(
      array(
        'Text',
        'button1text',
        array(
          'label' => 'Button 1 Text',
        )
      ),
      array(
        'Text',
        'button1price',
        array(
          'label' => 'Button 1 Price',
        )
      ),
      array(
        'Text',
        'button1link',
        array(
          'label' => 'Button 1 Link',
        )
      ),
      array(
        'Text',
        'button2text',
        array(
          'label' => 'Button 2 Text',
        )
      ),
      array(
        'Text',
        'button2price',
        array(
          'label' => 'Button 2 Price',
        )
      ),
      array(
        'Text',
        'button2link',
        array(
          'label' => 'Button 2 Link',
        )
      ),
    )
  ),
  ),

);
