<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _date.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $store = empty($this->mapstore) ? $store : $this->mapstore;?>
<?php if(empty($localeLanguage)):?>
  <?php     
  $languageNameList  = array();
  $languageDataList  = Zend_Locale_Data::getList(null, 'language');
  $territoryDataList = Zend_Locale_Data::getList(null, 'territory');
  $languageList = Zend_Registry::get('Zend_Translate')->getList();
  foreach( $languageList as $localeCode ) {
    $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
    if (empty($languageNameList[$localeCode])) {
      if( false !== strpos($localeCode, '_') ) {
        list($locale, $territory) = explode('_', $localeCode);
      } else {
        $locale = $localeCode;
        $territory = null;
      }
      if( isset($territoryDataList[$territory]) && isset($languageDataList[$locale]) ) {
        $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
      } else if( isset($territoryDataList[$territory]) ) {
        $languageNameList[$localeCode] = $territoryDataList[$territory];
      } else if( isset($languageDataList[$locale]) ) {
        $languageNameList[$localeCode] = $languageDataList[$locale];
      } else {
        continue;
      }
    }
  }
  $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
  $languageNameList = array_merge(array(
    $defaultLanguage => $defaultLanguage
  ), $languageNameList);
  $languageNameList = $languageNameList;
  ?>
  <?php $localeLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');?>
  <?php if( 1 !== count($languageNameList)):?>
    <?php $localeLanguage = $_COOKIE['en4_language'];?>
  <?php endif;?>
<?php endif;?>

<?php  $locale = new Zend_Locale($localeLanguage);?>
<?php Zend_Date::setOptions(array('format_type' => 'php'));?>
<?php $date = new Zend_Date(strtotime($store->creation_date), false, $locale);?>
<span class="_date sesbasic_text_light" title=""><i class="far fa-clock" ></i><?php echo $date->toString('jS M');?>,&nbsp;<?php echo date('Y', strtotime($store->creation_date));?></span>
