<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeBlog.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();
 
if($requestParams['action'] == 'home' && $requestParams['module'] == 'user' && $requestParams['controller'] == 'index' && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
?>
<style>
#compose-eblog-activator{display:inline-block !important;}
</style>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Eblog/externals/styles/styles.css'); 
  $this->headScript()->appendFile($baseUrl . 'externals/tinymce/tinymce.min.js'); 
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Eblog)
      return;
    Asset.javascript('<?php echo $baseUrl ?>application/modules/Eblog/externals/scripts/composer_blog.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Eblog({
          title : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Blog")) ?>',
          lang : {
            'Write New Blog' : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Blog")) ?>'
          },
          requestOptions : {
						url:"<?php echo $this->url(array('action'=>'create'), 'eblog_general'); ?>",	
					},
        }));
      }});
  });
</script>
<?php } ?>