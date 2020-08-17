<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: template.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Emailtemplates/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form emailtemplates_setting'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">
  var mailTemplateLanguage = '<?php echo $this->language ?>';
  
  var setEmailLanguage = function(language) {
    var url = '<?php echo $this->url(array('language' => null, 'template' => null)) ?>';
    window.location.href = url + '/language/' + language;
  }

  var fetchEmailTemplate = function(template_id) {
    var url = '<?php echo $this->url(array('language' => null, 'template' => null)) ?>';
    window.location.href = url + '/language/' + mailTemplateLanguage + '/template/' + template_id;
  }
	

</script>







