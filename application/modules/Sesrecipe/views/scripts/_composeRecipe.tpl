<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeRecipe.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();
 
if($requestParams['action'] == 'home' && $requestParams['module'] == 'user' && $requestParams['controller'] == 'index' && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
?>
<style>
#compose-sesrecipe-activator{display:inline-block !important;}
</style>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); 
  $this->headScript()->appendFile($baseUrl . 'externals/tinymce/tinymce.min.js'); 
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Sesrecipe)
      return;
    Asset.javascript('<?php echo $baseUrl ?>application/modules/Sesrecipe/externals/scripts/composer_recipe.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Sesrecipe({
          title : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Recipe")) ?>',
          lang : {
            'Write New Recipe' : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Recipe")) ?>'
          },
          requestOptions : {
						url:"<?php echo $this->url(array('action'=>'create'), 'sesrecipe_general'); ?>",	
					},
        }));
      }});
  });
</script>
<?php } ?>