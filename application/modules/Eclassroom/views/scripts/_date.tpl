<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _date.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $classroom = empty($this->mapclassroom) ? $classroom : $this->mapclassroom;?>
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
<?php $date = new Zend_Date(strtotime($classroom->creation_date), false, $locale);?>
<span class="_date sesbasic_text_light" title=""><i class="fa fa-calendar" ></i> <?php echo $date->toString('jS M');?>,&nbsp;<?php echo date('Y', strtotime($classroom->creation_date)); ?></span>
