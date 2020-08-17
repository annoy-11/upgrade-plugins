<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Advancedsearch/views/scripts/dismiss_message.tpl';?>
<?php
if(0) {
$pluginArrays = array(
'sesmember' => '4.10.3p8',
'sesalbum' => '4.10.3p5',
'sesblog' => '4.10.3p12',
'sesbusiness' => '4.10.3p11',
'sescontest' => '4.10.3p21',
'sesevent' => '4.10.3p10',
'sesgroup' => '	4.10.3p18',
'sespage' => '4.10.3p23',
'sesqa' => '	4.10.3p3',
'sesquote' => '4.10.3p6',
'sesteam' => '4.10.3p3',
'sesrecipe' => '4.10.3p3',
'sesthought' => '4.10.3p2',
'sesvideo' => '4.10.3p6',
'seswishe' => '4.10.3p2',
'sesprayer' => '4.10.3p11',
);
foreach ($pluginArrays as $key=>$pluginArray) {
$modulesExist = Engine_Api::_()->sesbasic()->isModuleExist($key);
if (!empty($modulesExist) && !empty($modulesExist['version'])) {
  $modulesExistSES = Engine_Api::_()->sesbasic()->checkpluginversion($key, $pluginArray);
  if (empty($modulesExistSES)) {
?>
<div><span style="border-radius: 3px;border: 2px solid #cd4545;background-color: #da5252;padding: 10px;display: block;margin-bottom: 15px;"><p style="color:#fff;font-weight:bold;">Note: Your website does not have the latest version of <?php echo $modulesExist['title']; ?>. Please upgrade <?php echo $modulesExist['title']; ?> on your website to the latest version available in your SocialEngineSolutions Client Area to enable its integration with "Professional Search Plugin". Please <a href="<?php echo 'admin/packages'; ?>" style="color:#fff;text-decoration:underline;font-weight:bold;">Click here</a> to go Manage Packages.</p></span></div>
<?php } } } } ?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedsearch.pluginactivated',0)) {
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
