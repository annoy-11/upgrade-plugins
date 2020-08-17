<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesproductArrayFieldValueLoop.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_View_Helper_SesproductArrayFieldValueLoop extends Fields_View_Helper_FieldAbstract
{
  protected $_fieldArray = array();
  public function sesproductArrayFieldValueLoop($subject, $partialStructure)
  {
    if( empty($partialStructure) ) {
      return array();
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    if( !($subject instanceof Core_Model_Item_Abstract) || !$subject->getIdentity() ) {
      return array();
    }

    // Calculate viewer-subject relationship
    $usePrivacy = ($subject instanceof User_Model_User);
    if( $usePrivacy ) {
      $relationship = 'everyone';
      if( $viewer && $viewer->getIdentity() ) {
        if( $viewer->getIdentity() == $subject->getIdentity() ) {
          $relationship = 'self';
        } elseif( $viewer->membership()->isMember($subject, true) ) {
          $relationship = 'friends';
        } else {
          $relationship = 'registered';
        }
      }
    }

    // Generate
    $content = '';
    $lastContents = '';
    $lastHeadingTitle = null; //Zend_Registry::get('Zend_Translate')->_("Missing heading");
    $showHidden = $viewer->getIdentity()
                 ? ($subject->getOwner()->isSelf($viewer) || 'admin' === Engine_Api::_()->getItem('authorization_level', $viewer->level_id)->type)
                 : false;

    $arrayContent = array();
    $arrayLoop = 0;
    $tempArray = array();
    foreach( $partialStructure as $map ) {

      // Get field meta object
      $field = $map->getChild();
      $value = $field->getValue($subject);

      if( !$field || $field->type == 'profile_type' ) continue;

      if( !$field->display && !$showHidden && $subject->getType() == "user") continue;
      $isHidden = $subject->getType() == "user" ? !$field->display : false;

      // Get first value object for reference
      $firstValue = $value;
      if( is_array($value) && !empty($value) ) {
        $firstValue = $value[0];
      }

      // Evaluate privacy
      if( $usePrivacy && !empty($firstValue->privacy) && $relationship != 'self' ) {
        if( $firstValue->privacy == 'self' && $relationship != 'self' ) {
          $isHidden = true; //continue;
        } elseif( $firstValue->privacy == 'friends' && ($relationship != 'friends' && $relationship != 'self') ) {
          $isHidden = true; //continue;
        } elseif( $firstValue->privacy == 'registered' && $relationship == 'everyone' ) {
          $isHidden = true; //continue;
        }
      }

      // Render
      if( $field->type == 'heading' ) {
        // Heading
        if( $isHidden ) {
          continue;
        }
        if( !empty($lastContents) ) {
          $contentArray = $this->_buildLastContents($lastContents, $lastHeadingTitle,$tempArray,$arrayLoop,$arrayContent);
          $content .=$contentArray['content'];
          $arrayContent = $contentArray['array'];
          $tempArray = array();
          $arrayLoop++;
          $lastContents = '';
        }
        $lastHeadingTitle = $this->view->translate($field->label);
      } else {
        // Normal fields
        $tmp = $this->getFieldValueString($field, $value, $subject, $map, $partialStructure);
        $hasValidValue = !empty($firstValue->value) || $field->type === 'checkbox';

        if( $hasValidValue && !empty($tmp) ) {

          $notice = $isHidden && $showHidden
                  ? sprintf('<div class="tip"><span>%s</span></div>',
                      $this->view->translate('This field is hidden and only visible to you and admins:'))
                  : '';
          if( !$isHidden || $showHidden ) {
            $label = $this->view->translate($field->label);
            $tempArray[] = strip_tags($tmp);
            $lastContents .= "temp";
          }
        }
      }

    }

    if( !empty($lastContents) ) {
      $contentArray1 = $this->_buildLastContents($lastContents, $lastHeadingTitle,$tempArray,$arrayLoop,$arrayContent);
      $content .= $contentArray1['content'];
      $arrayContent = $contentArray1['array'];
    }
    return $arrayContent;
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

  protected function _buildLastContents($content, $title,$tempArray,$arrayLoop,$arrayContent)
  {
    if( !$title ) {
      $merge = array_merge($arrayContent,$tempArray);
      return array('content'=>$content,'array'=>$merge);
    }
    $temp[] = $title;
    $merge = array_merge($arrayContent,$temp,$tempArray);
    return array('content'=>$content,'array'=>$merge);
  }
}
