<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeJob.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();
 
if($requestParams['action'] == 'home' && $requestParams['module'] == 'user' && $requestParams['controller'] == 'index' && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
?>
<style>
#compose-sesjob-activator{display:inline-block !important;}
</style>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); 
  $this->headScript()->appendFile($baseUrl . 'externals/tinymce/tinymce.min.js'); 
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Sesjob)
      return;
    Asset.javascript('<?php echo $baseUrl ?>application/modules/Sesjob/externals/scripts/composer_job.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Sesjob({
          title : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Job")) ?>',
          lang : {
            'Write New Job' : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Job")) ?>'
          },
          requestOptions : {
						url:"<?php echo $this->url(array('action'=>'create'), 'sesjob_general'); ?>",	
					},
        }));
      }});
  });
</script>
<?php } ?>
