<?php



class Sesmembershipcard_View_Helper_Userprofilefields extends Fields_View_Helper_FieldAbstract
{
  public function userprofilefields($subject, $partialStructure,$profiles,$item = null)
  {
    if( empty($partialStructure) ) {
      return '';
    }
    // Generate
    $content = '';
    $lastContents = '';
    $lastHeadingTitle = null; //Zend_Registry::get('Zend_Translate')->_("Missing heading");
    $showHidden = true;
    $alreadyId = array();
    $alreadyHeading = array();
    foreach( $partialStructure as $map ) {

      // Get field meta object
      $field = $map->getChild();
      $alias = $field->alias;
      if(!in_array($alias,$profiles))
       continue;


      $value = $field->getValue($subject);
      if( !$field || $field->type == 'profile_type' ) continue;
      if( !$field->display && !$showHidden ) continue;
      $isHidden = false;

      // Get first value object for reference
      $firstValue = $value;
      if( is_array($value) && !empty($value) ) {
        $firstValue = $value[0];
      }


      // Render
      if( $field->type == 'heading' ) {
         continue;
      } else {
        // Normal fields
        $tmp = $this->getFieldValueString($field, $value, $subject, $map, $partialStructure);
        $hasValidValue = !empty($firstValue->value) || $field->type === 'checkbox';

        if( ($hasValidValue && !empty($tmp)) || $item->empty_field) {
          if(in_array($field->field_id, $alreadyId)) {
            continue;
          }
          $notice ='';
          $alreadyId[] = $field->field_id;
          if( !$isHidden || $showHidden ) {
          if(empty($tmp))
          $tmp = "N/As";
            $label = $this->view->translate($field->label);
            $titleColor = '#'.$item->field_color;
            $titleFont = str_replace('"','',$item->field_font);
            $lastContents .= <<<EOF
    <p style="color:{$titleColor};font-family:{$titleFont};">
      {$label} :
    <span style="color:{$titleColor};font-family:{$titleFont};">
      {$tmp}
    </span>
    </p>
EOF;
          }
        }
      }

    }

    if( !empty($lastContents) ) {
      $content .= $this->_buildLastContents($lastContents, $lastHeadingTitle);
    }

    return $content;
  }

  public function getFieldValueString($field, $value, $subject, $map = null,
      $partialStructure = null)
  {
    if( (!is_object($value) || !isset($value->value)) && !is_array($value) ) {
      return null;
    }

    // @todo This is not good practice:
    // if($field->type =='textarea'||$field->type=='about_me') $value->value = nl2br($value->value);

    $helperName = Engine_Api::_()->fields()->getFieldInfo($field->type, 'helper');
    if( !$helperName ) {
      return null;
    }

    $helper = $this->view->getHelper($helperName);
    if( !$helper ) {
      return null;
    }

    $helper->structure = $partialStructure;
    $helper->map = $map;
    $helper->field = $field;
    $helper->subject = $subject;
    $tmp = $helper->$helperName($subject, $field, $value);
    unset($helper->structure);
    unset($helper->map);
    unset($helper->field);
    unset($helper->subject);

    return $tmp;
  }

  protected function _buildLastContents($content, $title)
  {
    if( !$title ) {
      return $content;
    }
  }
}
