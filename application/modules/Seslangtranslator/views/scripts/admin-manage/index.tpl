<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php include APPLICATION_PATH .  '/application/modules/Seslangtranslator/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div id="sesbasic_waiting_msg_box_cont"  class="sesbasic_waiting_msg_box_cont" style="height:185px;">
    <?php echo $this->translate("Please wait.. It might take some time to translate the selected csv files into the chosen language. You will be notified here when the process is complete, do not close this pop up until the process ends."); ?>
    <i></i>
    <div id="completelangs"></div>
    <div id="startlangs"></div>
  </div>
  
</div>
<script type="application/javascript">
sesJqueryObject(document).ready(function() {

  sesJqueryObject('.global_form').submit(function(e) {
  
    e.preventDefault();

    var elem = sesJqueryObject('.checkBoxClass');
    var langss = [];
		for(var i=0;i < elem.length; i++) {
      var id = sesJqueryObject(elem[i]).attr('id').replace('main_languagefiles-','');
      if(sesJqueryObject(elem[i]).prop('checked')) { 
        //langs += sesJqueryObject("#"+sesJqueryObject(elem[i]).attr('id')).val() + ",";
        langss.push(sesJqueryObject("#"+sesJqueryObject(elem[i]).attr('id')).val());
      }
		}
		
		if(langss.length <= 0) {
      alert('Please select at least one csv file.');
      return;
    }
    
    var allLangChoose = sesJqueryObject(sesJqueryObject('#main_languagefiles-all')).prop('checked');

//     var elem = sesJqueryObject('.checkBoxClassconvert');
//     var langs = '';
// 		for(var i=0;i < elem.length; i++) {
//       var id = sesJqueryObject(elem[i]).attr('id').replace('convert_languages-','');
//       if(sesJqueryObject(elem[i]).prop('checked')) {
//         langs += id + ",";
//       }
// 		}
// 		
// 		if(langs.length <= 0) {
//       alert('Please select at least one language.');
//       return;
//     }

    if(allLangChoose == true) {
      convertlanguagses(allLangChoose, langss, 1);
    } else {
      convertlanguagses(allLangChoose, langss, 0);
    }

  });
});

  function convertlanguagses(allLangChoose, langss, counter) {

    var langs = langss[counter];
    var convert_languages = sesJqueryObject("#convert_languages option:selected").val();
    sesJqueryObject('.sesbasic_waiting_msg_box').show();

    sesJqueryObject('#startlangs').html('<div class="seslangtranslator_success_message"><span>'+langs+' file is in translation process...</span></div>');
    
    convertlang = new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'admin/seslangtranslator/manage/addnewpack',
      'data': {
        format: 'html',
        langs: langs,
        convert_languages: convert_languages,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      
        var response = sesJqueryObject.parseJSON( responseHTML );
        if(response.status == 1) {
          counter = counter+ 1;
          if(counter > langss.length) {
            sesJqueryObject('#sesbasic_waiting_msg_box_cont').html('');
            sesJqueryObject('#sesbasic_waiting_msg_box_cont').html('<div class="seslangtranslator_success_message"><span>Chosen files are successfully translated in the selected language. Please check and edit the phrases in Manage Language Packs section.</span></div><a href="javascript:void();" class="close" onclick="closepopup()">Close</a>');
          } else {
            sesJqueryObject('#startlangs').html('');
            sesJqueryObject('#completelangs').show();
            sesJqueryObject('#completelangs').html('<div class="seslangtranslator_success_message"><span>'+langs+' file is successfully translated.</span></div>').fadeOut(15000,'',function(){ sesJqueryObject(this).hide();});
            convertlanguagses(allLangChoose, langss, counter);
            console.log(counter);
          }
        }
      }
    });
    convertlang.send();
    return false;
  }
  
  function closepopup(){
    location.reload();
  }

  sesJqueryObject(document).ready(function () {
    sesJqueryObject("#main_languagefiles-all").click(function () {
        sesJqueryObject(".checkBoxClass").prop('checked', sesJqueryObject(this).prop('checked'));
    });
  });
  
  sesJqueryObject(document).ready(function () {
    sesJqueryObject("#convert_languages-all").click(function () {
        sesJqueryObject(".checkBoxClassconvert").prop('checked', sesJqueryObject(this).prop('checked'));
    });
  });

</script>
<style>
.seslangtranslator_success_message{
	background-color:#c8e5bc;
	border:1px solid #b2dba1;
	font-size:12px;
	padding:10px;
	text-align:center;
	margin-top:15px;
}
.form-options-wrapper{
	max-width:240px;
	max-height:150px;
	overflow:auto !IMPORTANT;
	border-width:1px;
	padding:10px;
}
</style>