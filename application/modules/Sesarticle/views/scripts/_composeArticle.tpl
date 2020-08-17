<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeArticle.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

?>
<style>
#compose-sesarticle-activator{display:inline-block !important;}
</style>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); 
  $this->headScript()->appendFile($baseUrl . 'externals/tinymce/tinymce.min.js'); 
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Sesarticle)
      return;
    Asset.javascript('<?php echo $baseUrl ?>application/modules/Sesarticle/externals/scripts/composer_article.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Sesarticle({
          title : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Article")) ?>',
          lang : {
            'Write New Article' : '<?php echo $this->string()->escapeJavascript($this->translate("Write New Article")) ?>'
          },
          requestOptions : {
						url:"<?php echo $this->url(array('action'=>'create'), 'sesarticle_general'); ?>",	
					},
        }));
      }});
  });
</script>