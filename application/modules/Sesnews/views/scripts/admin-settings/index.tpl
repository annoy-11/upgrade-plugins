<?php/** * SocialEngineSolutions * * @category   Application_Sesnews * @package    Sesnews * @copyright  Copyright 2019-2020 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: index.tpl  2019-02-27 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */  ?><?php include APPLICATION_PATH .  '/application/modules/Sesnews/views/scripts/dismiss_message.tpl';?><div class='clear'>  <div class='settings sesbasic_admin_form '>    <?php echo $this->form->render($this); ?>  </div></div><div class="sesbasic_waiting_msg_box" style="display:none;">	<div class="sesbasic_waiting_msg_box_cont">    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>    <i></i>  </div></div><?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.pluginactivated',0)): $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>	<script type="application/javascript">  	sesJqueryObject('.global_form').submit(function(e){			sesJqueryObject('.sesbasic_waiting_msg_box').show();		});  </script><?php endif; ?><script type="application/javascript">  window.addEvent('domready', function() {    showSearchType("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.enable.location', 1); ?>");    enablenewsdesignview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.enablenewsdesignview', 0); ?>");  });  function enablenewsdesignview(value) {    if(value == 1) {      $('sesnews_chooselayout-wrapper').style.display = 'block';      $('sesnews_defaultlayout-wrapper').style.display = 'none';    } else {      $('sesnews_chooselayout-wrapper').style.display = 'none';      $('sesnews_defaultlayout-wrapper').style.display = 'block';    }  }  function showSearchType(value) {    if(value == 1){        document.getElementById('sesnews_search_type-wrapper').style.display = 'block';    }else{        document.getElementById('sesnews_search_type-wrapper').style.display = 'none';		    }  }</script>