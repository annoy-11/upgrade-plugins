<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-new-phrase.tpl 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Seslangtranslator/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to translate the phrase into the chosen language. The popup will automatically close when the process is completed."); ?>
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
  
    var main_language_phrase = sesJqueryObject('#main_language_phrase').val();
    if(main_language_phrase.length <= 0) {
      alert('Enter the new phrase which you want to translate.');
      return;
    }
    
    var elem = sesJqueryObject('.checkbox_slt_sm_im');
    var langs = '';
		for(var i=0;i < elem.length; i++) {
      var id = sesJqueryObject(elem[i]).attr('id').replace('convert_language-','');
      if(sesJqueryObject(elem[i]).prop('checked')) {
        langs += id + ",";
      }
		}
		
		if(langs.length <= 0) {
      alert('Please select at least one language.');
      return;
    }
    
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
    convertlang = new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'admin/seslangtranslator/manage/convertlang',
      'data': {
        format: 'html',
        langs: langs,
        main_language_phrase: main_language_phrase,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
        var response = sesJqueryObject.parseJSON( responseHTML );
        var arr = [];
        if(response.status == 1) {
          sesJqueryObject('.sesbasic_waiting_msg_box').hide();
          var obj = response.allGeneratedLang;

          sesJqueryObject.each(obj,function(k,value) {
            sesJqueryObject('#convert_language_phrase_'+k+'-wrapper').show();
            sesJqueryObject('#convert_language_phrase_'+k).val(value);
          });
          $('submit-wrapper').style.display = 'block';
        }
      }
    });
    convertlang.send();
    return false;
  }
</script>