<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composewishe.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seswishe/externals/scripts/composer_wishe.js'); ?>

<?php 
$categories = Engine_Api::_()->getDbtable('categories', 'seswishe')->getCategoriesAssoc();
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
    composeInstance.addPlugin(new Composer.Plugin.Wishe({
      title: '<?php echo $this->string()->escapeJavascript($this->translate('Wishe')) ?>',
      categoryOptionValues: '<?php echo $data; ?>',
    }));
  });
</script>