<?php/** * SocialEngineSolutions * * @category   Application_Sesproduct * @package    Sesproduct * @copyright  Copyright 2019-2020 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */  ?><?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?><div class='clear'>  <div class='settings sesbasic_admin_form '>    <?php echo $this->form->render($this); ?>  </div></div><div class="sesbasic_waiting_msg_box" style="display:none;">	<div class="sesbasic_waiting_msg_box_cont">    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>    <i></i>  </div></div><?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.pluginactivated',0)): $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>	<script type="application/javascript">  	sesJqueryObject('.global_form').submit(function(e){			sesJqueryObject('.sesbasic_waiting_msg_box').show();		});  </script><?php endif; ?><script type="application/javascript">  window.addEvent('domready', function() {    showSearchType("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1); ?>");    enableproductdesignview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enableproductdesignview', 1); ?>");  });    function enableproductdesignview(value) {      if(value == 1) {      $('chooselayout-wrapper').style.display = 'block';      $('defaultlayout-wrapper').style.display = 'none';    } else {      $('chooselayout-wrapper').style.display = 'none';      $('defaultlayout-wrapper').style.display = 'block';    }  }	function show_position(value){		if(value == 1){				document.getElementById('sesproduct_position_watermark-wrapper').style.display = 'block';		}else{				document.getElementById('sesproduct_position_watermark-wrapper').style.display = 'none';				}	}	if(document.querySelector('[name="sesproduct_watermark_enable"]:checked').value == 0){		document.getElementById('sesproduct_position_watermark-wrapper').style.display = 'none';		}else{			document.getElementById('sesproduct_watermark_enable-wrapper').style.display = 'block';	}	function showSearchType(value) {		if(value == 1){      document.getElementById('sesproduct_location_mandatory-wrapper').style.display = 'block';			document.getElementById('sesproduct_search_type-wrapper').style.display = 'block';		}else{			document.getElementById('sesproduct_search_type-wrapper').style.display = 'none';	      document.getElementById('sesproduct_location_mandatory-wrapper').style.display = 'none';		}	}</script>