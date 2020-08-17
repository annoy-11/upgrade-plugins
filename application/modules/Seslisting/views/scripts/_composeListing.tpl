<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeListing.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();
 
if($requestParams['action'] == 'home' && $requestParams['module'] == 'user' && $requestParams['controller'] == 'index' && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
?>
<style>
#compose-seslisting-activator{display:inline-block !important;}
</style>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); 
  $this->headScript()->appendFile($baseUrl . 'externals/tinymce/tinymce.min.js'); 
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Seslisting)
      return;
    Asset.javascript('<?php echo $baseUrl ?>application/modules/Seslisting/externals/scripts/composer_listing.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Seslisting({
          title : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Listing")) ?>',
          lang : {
            'Write New Listing' : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Listing")) ?>'
          },
          requestOptions : {
						url:"<?php echo $this->url(array('action'=>'create'), 'seslisting_general'); ?>",	
					},
        }));
      }});
  });
</script>
<?php } ?>
