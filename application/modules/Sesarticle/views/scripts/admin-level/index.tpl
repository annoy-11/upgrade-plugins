<?php/** * SocialEngineSolutions * * @category   Application_Sesarticle * @package    Sesarticle * @copyright  Copyright 2015-2016 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */?><?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?><script type="text/javascript">  var fetchLevelSettings =function(level_id){    window.location.href= en4.core.baseUrl+'admin/sesarticle/level/index/id/'+level_id;    //alert(level_id);  }</script><?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/dismiss_message.tpl';?><div class='clear'>  <div class='settings sesbasic_admin_form'>    <?php echo $this->form->render($this) ?>  </div></div><script type="application/javascript">  	window.addEvent('domready', function() {		continuereadingbutton(jqueryObjectOfSes("input[name='cotinuereading']:checked").val()); 		showHideHeight(jqueryObjectOfSes("input[name='cntrdng_dflt']:checked").val());   });    function continuereadingbutton(value) {    if(value == 1) {      $('cntrdng_dflt-wrapper').style.display = 'none';      $('continue_height-wrapper').style.display = 'none';    } else {      $('cntrdng_dflt-wrapper').style.display = 'block';      $('continue_height-wrapper').style.display = 'block';    }  }    function showHideHeight(value) {    if(value == 1) {      $('continue_height-wrapper').style.display = 'block';    } else {      $('continue_height-wrapper').style.display = 'none';    }  }</script>