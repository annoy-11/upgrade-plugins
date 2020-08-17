<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminFieldMeta.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Quicksignup_View_Helper_AdminFieldMeta extends Zend_View_Helper_Abstract {

    public function adminFieldMeta($map) {
        $meta = $map->getChild();

        if (!($meta instanceof Fields_Model_Meta)) {
            return '';
        }

        // Prepare translations
        $translate = Zend_Registry::get('Zend_Translate');

        // Prepare params
        if ($meta->type == 'heading') {
            $containerClass = 'heading';
        } else {
            $containerClass = 'field';
        }

        $key = $map->getKey();
        $label = $this->view->translate($meta->label);
        $type = $meta->type;

        $typeLabel = Engine_Api::_()->fields()->getFieldInfo($type, 'label');
        $typeLabel = $this->view->translate($typeLabel);

        // Options data
        $optionContent = '';
        $dependentFieldContent = '';

        if ($meta->canHaveDependents()) {
            $extraOptionsClass = 'field_extraoptions ' . $this->_generateClassNames($key, 'field_extraoptions_');
            $optionContent .= <<<EOF
<div class="{$extraOptionsClass}" id="field_extraoptions_{$key}">
  <div class="field_extraoptions_contents_wrapper">
    <div class="field_extraoptions_contents">
      <div class="field_extraoptions_add">
        {$this->view->formText('text', '', array('title' => $this->view->translate('add new choice'), 'onkeypress' => 'void(0);', 'onmousedown' => "void(0);"))}
      </div>
EOF;

            $options = $meta->getOptions();

            if (!empty($options)) {
                $extraOptionsChoicesClass = 'field_extraoptions_choices ' . $this->_generateClassNames($key, 'field_extraoptions_choices_');
                $optionContent .= <<<EOF
      <ul class="{$extraOptionsChoicesClass}" id="admin_field_extraoptions_choices_{$key}">
EOF;
                foreach ($options as $option) {
                    $optionId = $option->option_id;
                    $optionLabel = $this->view->translate($option->label);
                    $dependentFieldCount = count(Engine_Api::_()->fields()->getFieldsMaps($option->getFieldType())->getRowsMatching('option_id', $optionId));
                    $dependentFieldCountString = ( $dependentFieldCount <= 0 ? '' : ' (' . $dependentFieldCount . ')' );

                    $optionClass = 'field_option_select field_option_select_' . $optionId . ' ' . $this->_generateClassNames($key, 'field_option_select_');
                    $optionContent .= <<<EOF
        <li id="field_option_select_{$key}_{$optionId}" class="{$optionClass}">
          <span class="field_extraoptions_choices_options">
            <a href="javascript:void(0);" onclick="void(0);">{$translate->_('enable')}</a>
            | <a href="javascript:void(0);" onclick="void(0);">X</a>
          </span>
          <span class="field_extraoptions_choices_label" onclick="void(0);">
            {$optionLabel} {$dependentFieldCountString}
          </span>
        </li>
EOF;
                }

                $optionContent .= <<<EOF
      </ul>
EOF;
                foreach ($options as $option) {
                    $dependentFieldContent .= $this->view->adminFieldOption($option, $map);
                }
            }
        }

        if ($meta->show == 1) :
            // Generate
            $contentClass = 'admin_field ' . $this->_generateClassNames($key, 'admin_field_');
            $content = <<<EOF
  <li id="admin_field_{$key}" class="{$contentClass}">
    <span class='{$containerClass}'>
      <div class='item_handle'>
        &nbsp;
      </div>
      <div class='item_options'>
         <a style="display:none;" href='javascript:void(0);' onclick='void(0);' onmousedown="void(0);"></a>
         <a  href='javascript:void(0);' onclick='void(0);' onmousedown="void(0);">{$translate->_('disable')}</a>
      </div>
      <div class='item_title'>
        {$label}
        <span>({$typeLabel})</span>
      </div>
      {$optionContent}
    </span>
    {$dependentFieldContent}
  </li>
EOF;
        else :
// Generate
            $contentClass = 'admin_field ' . $this->_generateClassNames($key, 'admin_field_');
            $content = <<<EOF
  <li id="admin_field_{$key}" class="{$contentClass}">
    <span class='{$containerClass}'>
      <div class='item_handle'>
        &nbsp;
      </div>
      <div class='item_options'>
         <a   href='javascript:void(0);' onclick='void(0);' onmousedown="void(0);">{$translate->_('enable')}</a>
         <a  style="display:none;" href='javascript:void(0);' onclick='void(0);' onmousedown="void(0);"></a>
      </div>
      <div class='item_title'>
        {$label}
        <span>({$typeLabel})</span>
      </div>
      {$optionContent}
    </span>
    {$dependentFieldContent}
  </li>
EOF;
        endif;

        return $content;
    }

    protected function _generateClassNames($key, $prefix = '') {
        list($parent_id, $option_id, $child_id) = explode('_', $key);
        return
                $prefix . 'parent_' . $parent_id . ' ' .
                $prefix . 'option_' . $option_id . ' ' .
                $prefix . 'child_' . $child_id
        ;
    }

}
