<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>
<?php 
    
  $column = 'body';
  if( 1 !== count($this->languageNameList) && !empty($this->content->{$_COOKIE['en4_language'].'_body'})) {
    $column = $_COOKIE['en4_language'].'_body';
  }
  /*$local_language = $this->locale()->getLocale()->__toString();
  if($local_language == 'en' || $local_language == 'en_US') {
    $column = 'body';
  }
  else {
    $column = $local_language.'_body';
  }*/
?>
<?php $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');?>

<?php if($this->page_title):?>
  <h3><?php echo $this->content->title;?></h3>
<?php endif;?>
<div class="sespagebuilder_page_content sesbasic_clearfix">
    <?php $string = $this->content->{$column};?>
  <?php
  $regex = "/\[(.*?)\]/";
  preg_match_all($regex, $string, $matches);
  for($i = 0; $i < count($matches[1]); $i++)
  {
    $match = $matches[1][$i];
    $array = explode('_', $match);
    $newValue = $array[2] ;
    $params = Engine_Api::_()->getDbTable('tabs','sespagebuilder')->getParams($newValue);
    $uniqString = $array[0].'_'.$array[1];
    if($uniqString == 'price_table') {
      $newstring =  $this->partial('getshortcode.tpl', 'sespagebuilder', array(
	'table_id' => (int) @$newValue,
      ));	
    }
    elseif($uniqString == 'accordion_menu') {
      $newstring =  $this->partial('getAccordionmenuShortcode.tpl', 'sespagebuilder', array(
	'menu_id' => (int) @$newValue,
      ));	
    }
     elseif($uniqString == 'ses_popup') {
      $newstring =  $this->partial('getPopupShortcode.tpl', 'sespagebuilder', array(
	'popup_id' => (int) @$newValue,
      ));	
    }
    else {
      $newstring =  $this->partial('gettabshortcode.tpl', 'sespagebuilder', array(
      'languageNameList'=>$this->languageNameList,
	'tab_id' => (int) @$newValue,
	'tab_type' => (int) @$array[3],
	'height' => $params->height
      ));
    }
    $string = str_replace($matches[0][$i], $newstring, $string);
  }
  ?>
  <?php echo $string;?>
</div>