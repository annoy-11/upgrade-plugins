<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Pages"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />

<div class='clear sesbasic_admin_form sespagebuilder_custompage_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">
var showError = 0;
var existEmptyError = 0;
var existvalidationError = 0;
var previousValue = '';
jqueryObjectOfSes('body').click(function(event) {
  if(event.target.id == 'pagebuilder_url')
  showError = 1;
  if(showError == '1' && event.target.id != 'pagebuilder_url' && (existEmptyError == '0' && $('pagebuilder_url').value == '') || (existvalidationError == '0' && $('pagebuilder_url').value != '') || (previousValue != $('pagebuilder_url').value && $('pagebuilder_url').value != '')) {
    previousValue = $('pagebuilder_url').value;
    (new Request.JSON({
    'format': 'json',
    'url' : '<?php echo $this->url(array('module' => 'sespagebuilder', 'controller' => 'manage', 'action' => 'checkurl'), 'admin_default', true) ?>',
    'data' : {
      'format' : 'json',
      'pagebuilder_url' : $('pagebuilder_url').value,
      'pagebuilder_id' : '0'
    },
    'onSuccess' : function(responseJSON, responseText) {			 
      if($('pagebuilder_url').value == '')  
       existEmptyError = 1;
      
      if($('pagebuilder_url').value != '')  
       existvalidationError = 1;
       
      if(document.getElementById( 'error' )) {
	var el = document.getElementById( 'error' );
	el.parentNode.removeChild( el );
      }

      var error = responseJSON[0].error;
      var errorDiv = document.createElement('div');
      errorDiv.setAttribute("id", 'error');
      errorDiv.inject($('pagebuilder_url-element'), 'after');
      document.getElementById('error').innerHTML = error;
    }
    })).send();
  }
});

</script>