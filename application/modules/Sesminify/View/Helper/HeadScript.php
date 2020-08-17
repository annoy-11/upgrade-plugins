<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeadScript.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_View_Helper_HeadScript extends Zend_View_Helper_HeadScript
{
  /**
   * @var string
   */
  protected $_path = "sesminify";
  protected $_ignoreJs = array('externals/tinymce','/recaptcha/api','facebook.','tinymce.min.js','tagger.js','Autocompleter.min.js','Lasso.Crop.js','Lasso.js','flexcroll.js');
  protected $_storeJs = array();
  protected $_requestLength = 5;
  protected $_intent = "";
  protected $_escapeStart = "";
  protected $_escapeEnd = "";
  public function toString($indent = null)
  {
         $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.enablejs', 1);
        //get minify length
        $this->_requestLength = $length = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.jslength', 5);
        //return parent obj
        if(!$length || !$enable)
          return parent::toString($indent);
        $this->_path = $this->_path.DIRECTORY_SEPARATOR;
        $ignore = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.ignorejs', '');
        if(trim($ignore))
          $this->_ignoreJs = array_merge($this->_ignoreJs,explode(',',$ignore));                        
        $this->_intent = $indent = (null !== $indent) ? $this->getWhitespace($indent) : $this->getIndent();
        $items = array();
        $this->getContainer()->ksort();
        
        if ($this->view) {
            $useCdata = $this->view->doctype()->isXhtml() ? true : false;
        } else {
            $useCdata = $this->useCdata ? true : false;
        }
        $this->_escapeStart = $escapeStart = ($useCdata) ? '//<![CDATA[' : '//<!--';
        $this->_escapeEnd = $escapeEnd   = ($useCdata) ? '//]]>'       : '//-->';
        
        foreach ($this as $item) {
          if($this->checkValidJs($item)){ 
            $this->_storeJs[$item->attributes['src']] = $this->removeUnwantedStringFromHref($item->attributes['src']);
            continue;
          }
          $this->serve($items);
          $items[] = $this->itemToString($item,$indent,$escapeStart, $escapeEnd);
        }
        //run for last obj
        $this->serve($items);
        return implode($this->getSeparator(), $items);
    }

  function staticBaseUrl(){
      return Zend_Registry::isRegistered('StaticBaseUrl') ? Zend_Registry::get('StaticBaseUrl') : Zend_Controller_Front::getInstance()->getBaseUrl();  
    }
    function get_domain($url)
    {
      $pieces = parse_url($url);
      $domain = isset($pieces['host']) ? $pieces['host'] : '';
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
    }
    function removeUnwantedStringFromHref($href = ""){
        $validUrl = strtok($href,'?');
        if($this->staticBaseUrl() != "/")
          $validUrl = str_replace($this->staticBaseUrl(),'',$validUrl);
        $validUrl = preg_replace("#\?.*$#", '', $validUrl);
        return str_replace(array('\\'), '/', $validUrl);
    }
    function checkValidJs($item){
        if(empty($item->attributes['src']))
          return false;
        $baseUrl =  $this->staticBaseUrl();
        //get href
        $href = str_replace($baseUrl,'',$item->attributes['src']);
        if(!$href)
          return false;
        $href = $this->removeUnwantedStringFromHref($href);
        //check domain name
        $domainExists = $this->get_domain($href);
        if($domainExists)
          return false;
        $isValid = strpos($href,'.js');
        if(!$isValid)
          return false;
        //check ignore css
        
        foreach($this->_ignoreJs as $css){
          if(strpos($href,$css) !== false){
            return false;
            break;
          }  
        }
        return true;
    }
    
    function serve(&$items){
        if(!count($this->_storeJs))
          return $items;
        $minifyURL = $this->staticBaseUrl().$this->_path;
        while(count($this->_storeJs)){
            //create css obj
            $jsObj = new stdClass();
            $jsObj->type = 'text/javascript';
            $jsScript = array_splice($this->_storeJs,0,$this->_requestLength);
            $jsObj->attributes['src'] = $minifyURL.'f='.implode(',',$jsScript);
            $items[] = $this->itemToString($jsObj,$this->_indent,$this->_escapeStart, $this->_escapeEnd);            
        }
        //re initialize global store css variable
        $this->_storeJs = array();
        return $items;
    }

}