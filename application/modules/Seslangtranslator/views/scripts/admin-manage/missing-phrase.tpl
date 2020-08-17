<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: missing-phrase.tpl 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Seslangtranslator/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">

 function selectlanguage(value) {
  var feeling_id = '<?php echo $this->feeling_id ?>';
  window.location.href="<?php echo $this->url(array('module'=>'seslangtranslator','controller'=>'manage', 'action'=>'missing-phrase'),'admin_default',true)?>/missing_lang/"+value;
 }
</script>


<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to translate the missing phrases into the chosen language. The popup will automatically close when the process is completed."); ?>
    <i></i>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="application/javascript">

  sesJqueryObject(document).ready(function() {
    sesJqueryObject('.convert_language_phrase').parent().parent().hide();
    $('submit-wrapper').style.display = 'none';
  });

  function generatelang() {
    
    var langss = '<?php echo $this->missing_lang ?>';
    
    var main_language_phrase = sesJqueryObject('#main_language_phrase').val();
    
    console.log(main_language_phrase.length);
    
    if(main_language_phrase.length <= 0) {
      alert('Enter the new phrase which you want to translate.');
      return;
    }
    
//     var convert_language_phrase = sesJqueryObject('#convert_language_phrase_'+langss).val();
//     if(convert_language_phrase.length <= 0) {
//       alert('Enter the convert phrase which you want to translate.');
//       return;
//     }
    
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
    convertlang = new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'admin/seslangtranslator/manage/convertmisssinglang',
      'data': {
        format: 'html',
        langs: '<?php echo $this->missing_lang ?>',
        main_language_phrase: main_language_phrase,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
        var response = sesJqueryObject.parseJSON( responseHTML );
        if(response.status == 1) {
          sesJqueryObject('.sesbasic_waiting_msg_box').hide();
//           var obj = response.allGeneratedLang;
//            sesJqueryObject('#convert_language_phrase_'+langss+'-wrapper').show();
//            sesJqueryObject('#convert_language_phrase_'+langss).val(obj);
//           $('submit-wrapper').style.display = 'block';
          location.reload();
        }
      }
    });
    convertlang.send();
    return false;
  }
</script>