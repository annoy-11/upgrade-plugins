<?php/** * SocialEngineSolutions * * @category   Application_Sesproduct * @package    Sesproduct * @copyright  Copyright 2019-2020 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */  ?><script type="text/javascript">  var fetchLevelSettings =function(level_id){    window.location.href= en4.core.baseUrl+'admin/sesproduct/level/index/id/'+level_id;    //alert(level_id);  }	window.addEvent('domready',function() {		enableproductdesignview(sesJqueryObject("#productdesign").val());	});function enableproductdesignview(value) {    if(value == 1) {      $('chooselayout-wrapper').style.display = 'block';      $('defaultlayout-wrapper').style.display = 'none';    } else {      $('chooselayout-wrapper').style.display = 'none';      $('defaultlayout-wrapper').style.display = 'block';    }  }</script><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?><div class='clear'>  <div class='settings sesbasic_admin_form'>    <?php echo $this->form->render($this) ?>  </div></div>