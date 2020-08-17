<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$actions = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sespoke")) {
  $results = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->getResults(array('enabled' => 1));
  foreach ($results as $result) {
    $actions[$result['name']] = ucfirst($result['name']);
  }
}

return array(
    array(
        'title' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts - Action / Gift Button',
        'description' => 'This widget displays buttons for actions & gifts. You can edit this widget to choose to show "Only Icon", "Only Text" or "Both Icon and Text" for the actions or gifts.',
        'category' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'type' => 'widget',
        'name' => 'sespoke.button',
        'defaultParams' => array(
            'title' => '',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showIconText',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget.',
                        'multiOptions' => array(
                            "1" => "Only Icon",
                            "2" => "Only Text",
                            "3" => "Both Icon and Text",
                        ),
                    ),
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Advanced Poke - Response Button for Actions and Gifts',
        'description' => 'This widget displays actions and gifts a member has recieved from other members with option respond to them.',
        'category' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'type' => 'widget',
        'name' => 'sespoke.back-button',
        'defaultParams' => array(
            'title' => '',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showType',
                    array(
                        'label' => 'Choose the View Type.',
                        'multiOptions' => array(
                            "1" => "Horizantal",
                            "0" => "Vertical"
                        ),
                    ),
                ),
                array(
                    'Select',
                    'viewMore',
                    array(
                        'label' => 'Do you want the content to be auto-loaded in this widget?',
                        'multiOptions' => array(
                            "1" => "No",
                            "0" => "Yes",
                        ),
                    ),
                ),
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count',
                        'description' => '(number of content to show)',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    )
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts - Top / Recent Members for Action or Gift',
        'description' => 'This widget displays top / recent members for taking actions or sending gifts as chosen by you by editing this widget. You can place this widget multiple times with different settings and options chosen.',
        'category' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'type' => 'widget',
        'name' => 'sespoke.recent-top',
        'defaultParams' => array(
            'title' => '',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showType',
                    array(
                        'label' => 'Choose the View Type.',
                        'multiOptions' => array(
                            "1" => "Horizantal",
                            "0" => "Vertical"
                        ),
                    ),
                ),
                array(
                    'Select',
                    'action',
                    array(
                        'label' => 'Choose the action or gift type for which members will be shown.',
                        'multiOptions' => $actions,
                    )
                ),
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' => array(
                            "top" => "Top",
                            "recent" => "Recent"
                        ),
                    ),
                ),
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count',
                        'description' => '(number of members to show)',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    )
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts - Suggestions for Actions / Gifts',
        'description' => 'This widget displays suggestions to send gifts or actions to the member viewing this widget. You can place this widget multiple times to show sugegstions with different actions / gifts chosen.',
        'category' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts Plugin',
        'type' => 'widget',
        'name' => 'sespoke.suggestions',
        'defaultParams' => array(
            'title' => '',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showType',
                    array(
                        'label' => 'Choose the View Type.',
                        'multiOptions' => array(
                            "1" => "Horizantal",
                            "0" => "Vertical"
                        ),
                    ),
                ),
                array(
                    'Select',
                    'action',
                    array(
                        'label' => 'Choose the action or gift type for which suggestions will be shown.',
                        'multiOptions' => $actions,
                    )
                ),
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count',
                        'description' => '(number of members to show)',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    )
                ),
            )
        )
    ),
);
?>