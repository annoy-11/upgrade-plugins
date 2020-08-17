<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$data = array('' => '');
$table = Engine_Api::_()->getDbtable('shoutboxs', 'sesshoutbox');
$select = $table->select()->where('status =?', 1);
$shoutbox = $table->fetchAll($select);

foreach ($shoutbox as $shoutboxs) {
    $data[$shoutboxs->getIdentity()] = $shoutboxs->getTitle();
}
return array(
  array(
    'title' => 'SES - Shoutbox',
    'description' => 'This widget displays the shoutbox on your website. You can choose the shoutbox which you want to display by editing this widget.',
    'category' => 'SES - Shoutbox',
    'type' => 'widget',
    'name' => 'sesshoutbox.shoutbox',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select', 'shoutbox_id',
                    array(
                        'label' => 'Choose shoutbox which you want to dispaly in this widget.',
                        'multiOptions' => $data,
                    )
                ),

            )
        ),
  ),
);
