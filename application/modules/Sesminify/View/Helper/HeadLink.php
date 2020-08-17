<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeadLink.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesminify_View_Helper_HeadLink extends Zend_View_Helper_HeadLink
{
    protected $_path = "sesminify";
    protected $_ignoreCss = array('font');
    protected $_storeCss = array();
    protected $_requestLength = 5;
    public function toString($indent = null)
    {
        //get minify length
        $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.enablecss', 1);
        $this->_requestLength = $length = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.csslength', 5);
        //return parent obj
        if(!$length || !$enable)
          return parent::toString($indent);
        $this->_path = $this->_path.DIRECTORY_SEPARATOR;
        $ignore = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesminify.ignorecss', '');
        if(trim($ignore))
          $this->_ignoreCss = array_merge($this->_ignoreCss,explode(',',$ignore));                        
        $indent = (null !== $indent) ? $this->getWhitespace($indent) : $this->getIndent();
        $items = array();
        $this->getContainer()->ksort();
        foreach ($this as $item) {
          if($this->checkValidCss($item)){
            $this->_storeCss[$item->href] = $this->removeUnwantedStringFromHref($item->href);
            continue;
          }
          $this->serve($items);
          $items[] = $this->itemToString($item);
        }
        //run again for last obj
        $this->serve($items);
        return $indent . implode($this->_escape($this->getSeparator()) . $indent, $items);
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
    function checkValidCss($item){
        if(empty($item->type) || ($item->type != "text/css") ||  $item->conditionalStylesheet == true  || empty($item->media) || $item->media != "screen")
          return false;
        $baseUrl =  $this->staticBaseUrl();
        //get href
        $href = str_replace($baseUrl,'',$item->href);
        if(!$href)
          return false;
        $href = $this->removeUnwantedStringFromHref($href);
        //check domain name
        $domainExists = $this->get_domain($href);
        if($domainExists)
          return false;
        $isValid = strpos($href,'.css');
        if(!$isValid)
          return false;
        //check ignore css
        foreach($this->_ignoreCss as $css){
          if(strpos($href,$css) !== false){
            return false;
            break;
          }  
        }
        return true;
    }
    
    function serve(&$items){
        if(!count($this->_storeCss))
          return $items;
        $minifyURL = $this->staticBaseUrl().$this->_path;
        while(count($this->_storeCss)){
            //create css obj
            $cssObj = new stdClass();
            $cssObj->rel                   = 'stylesheet';
            $cssObj->type                  = 'text/css';
            $cssObj->media                 = 'screen';
            $cssObj->conditionalStylesheet = false;
            $cssScript = array_splice($this->_storeCss,0,$this->_requestLength);
            $cssObj->href = $minifyURL.'f='.implode(',',$cssScript);
            $items[] = $this->itemToString($cssObj);            
        }        
        //re initialize global store css variable
        $this->_storeCss = array();
        return $items;
    }
  
}