<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composequote.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();
 
if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { 
  return;
}
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesquote/externals/scripts/composer_quote.js'); ?>

<?php 
$categories = Engine_Api::_()->getDbtable('categories', 'sesquote')->getCategoriesAssoc();
$data = '';
if (count($categories) > 0) {
  $categories = array('' => 'Choose Category') + $categories;
  foreach($categories as $key => $category) {
    $data .= '<option value="' . $key . '" >' . Zend_Registry::get('Zend_Translate')->_($category) . '</option>';
  }
}
?>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    composeInstance.addPlugin(new Composer.Plugin.Quote({
      title: '<?php echo $this->string()->escapeJavascript($this->translate('Quote')) ?>',
      categoryOptionValues: '<?php echo $data; ?>',
    }));
  });
</script>