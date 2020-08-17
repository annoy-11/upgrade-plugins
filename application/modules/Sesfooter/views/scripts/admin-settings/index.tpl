<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php
$translate = Zend_Registry::get('Zend_Translate');
$languageList = $translate->getList(); 
$final_array = array();
foreach($languageList as $key => $language) {
  $final_array[] = $key;
}
?>
<script>
  window.addEvent('domready', function() {
    hideLanguage('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.logintext', 1); ?>');
  });
  hashSign = '#';
  var final_array = <?php echo json_encode($final_array); ?>;

  function hideLanguage(value) {
  
    if(value == 1) {
      jqueryObjectOfSes.each( final_array, function( key, value ) {
        jqueryObjectOfSes('#sesfooter_footertext_'+value+'-wrapper').show();
      });
    } else {
      jqueryObjectOfSes.each( final_array, function( key, value ) {
        jqueryObjectOfSes('#sesfooter_footertext_'+value+'-wrapper').hide();
      });   
    }
  }
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesfooter/views/scripts/dismiss_message.tpl';?>
<div class='clear sesfooter_admin_form sesfooter_global_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesfooter_waiting_msg_box" style="display:none;">
	<div class="sesfooter_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesfooter_waiting_msg_box').show();
		});
  </script>
<?php endif; ?>
<style type="text/css">
/*Loading Message*/
.sesfooter_waiting_msg_box{
	background-color:rgba(255, 255, 255, 0.8);
	height:100%;
	left:0;
	position:fixed;
	top:0;
	width:100%;
}
.sesfooter_waiting_msg_box_cont{
	background-color:rgba(255, 255, 255, 0.8);
	border:5px solid #43bbef;
	box-shadow:0 0 5px rgba(0, 0, 0, 0.5);
	font-size:20px;
	font-weight:bold;
	height:100px;
	left:50%;
	margin:-50px 0 0 -300px;
	padding:20px;
	position:fixed;
	text-align:center;
	top:50%;
	width:600px;
	z-index:24;
}
.sesfooter_waiting_msg_box_cont i{
	background-image:url(application/modules/Sesfooter/externals/images/loading.gif);
	background-position:center center;
	background-repeat:no-repeat;
	display:block;
	height:30px;
	margin-top:20px;
	width:100%;
}
</style>