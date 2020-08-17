<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Elivestreaming
 * @package    Elivestreaming
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeStreaming.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php
$request = Zend_Controller_Front::getInstance()->getRequest();
$requestParams = $request->getParams();

if(($requestParams['action'] == 'home' || $requestParams['action'] == 'index') && $requestParams['module'] == 'user' && ($requestParams['controller'] == 'index' || $requestParams['controller'] == 'profile')) {
?>
<style>
    #compose-elivestreaming-activator{display:inline-block !important;}
</style>
<?php
$dataLiveStream =  Engine_Api::_()->elivestreaming()->getPermission();
if($dataLiveStream){
$dataLiveStream["loggedinUserId"] = $this->viewer()->getIdentity();
$dataLiveStream["type"] = "host";
?>
<script type="text/javascript">
    var elLiveStreamingContentData = <?php echo json_encode($dataLiveStream); ?>;
    if(elLiveStreamingContentData) {
        en4.core.runonce.add(function () {
            if (Composer.Plugin.Elivestreaming)
                return;
            Asset.javascript('<?php echo $this->layout()->staticBaseUrl ?>application/modules/Elivestreaming/externals/scripts/composer_livestreaming.js', {
                onLoad: function () {
                    var type = 'wall';
                    if (composeInstance.options.type) type = composeInstance.options.type;
                    composeInstance.addPlugin(new Composer.Plugin.Elivestreaming({
                        title: '<?php echo $this->string()->escapeJavascript($this->translate("Live Video")) ?>',
                        lang: {
                            'Live Video': '<?php echo $this->string()->escapeJavascript($this->translate("Live Video")) ?>'
                        }
                    }));
                }
            });
        });
        sesJqueryObject(document).on('click', '.elivestreaming_a', function () {
            if (sesJqueryObject("#elivestreaming_popup_iframe").length) {
                return;
            }
            sesJqueryObject("body").append("<div class='elive_loading'><span></span></div>");
            sesJqueryObject("body").append('<iframe id="elivestreaming_popup_iframe" src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('elivestreaming_linux_base_url',''); ?>" allow="camera;microphone" style="height: 100%;width: 100%;position:fixed;top:0;z-index: 100;left:0"></iframe>');
        })
    }
</script>
<?php
}
} ?>