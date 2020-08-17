<?php ?>
<?php
$importedData = $this->importedData;
$importmethod = $this->importmethod;
?>
<div id="importsend_email" class="ic_content_modal" style="display:none">
  <div class="ic_content_modal_content">
    <span class="ic_close" id="inviterpopup_close">&times;</span>
    <div class="sesimporter_contactlist">
      <?php if($importmethod == 'facebook') { ?>
        <h2><i class="fa fa-facebook"></i> <?php echo $this->translate("Facebook"); ?></h2>
      <?php } else if($importmethod == 'csv') { ?>
        <h2><i class="fa fa-file-text-o"></i> <?php echo $this->translate("CSV Import"); ?></h2>
      <?php } else if($importmethod == 'gmail') { ?>
        <h2><i class="fa fa-google-plus"></i> <?php echo $this->translate("Gmail"); ?></h2>
      <?php } else if($importmethod == 'yahoo') { ?>
        <h2><i class="fa fa-yahoo"></i> <?php echo $this->translate("Yahoo"); ?></h2>
      <?php } else if($importmethod == 'twitter') { ?>
        <h2><i class="fa fa-twitter"></i> <?php echo $this->translate("Twitter"); ?></h2>
      <?php } ?>
      <?php if(isset($importedData) && count($importedData)){ ?>
      
        <div id="emailimport_content" class="importer_content sesbasic-bxs" style="display:none;">

            <p class="head_line"><?php echo $this->translate("Connect with people you know."); ?></p>
            <p class="discription" id="import_email_description"><?php echo $this->translate("We found %s people from your address book. Select the people you'd like to connect to.", count($importedData)); ?></p>

          <div id="emailerror_message" style="display:none;"><?php echo $this->translate("Please choose ar least one email id."); ?></div>
          <div class="contact_search_box">
            <input type="text" name="" id="namesearch" onkeyup="importContentSearch()" placeholder="Search..."/>
            <p class="select_all">
              <input type="checkbox" name="checkall" id="checkall" value=""><?php echo $this->translate("Select All"); ?>
            </p>
          </div>
          <div class="importer_list">
            <ul id="allcontact_list" class="imp-list sesinviter_import_popup_list">
              <?php foreach($importedData as $key => $valS) { ?>
                <li>
                  <div class="importer_list_content">
                    <div class="input_checkbox">
                      <input name="imcon_<?php echo $key; ?>" id="imcon_<?php echo $key; ?>" class="checkbox_slt_sm_im" type="checkbox" value="">
                      <span></span>
                    </div>

                      <div class="inporter_profile_photo">
                        <img src="application/modules/Sesinviter/externals/images/Zac-Efron.png" />
                      </div>

                    <?php if($importmethod == 'twitter'): ?>
                      <div class="inporter_details">
                      <?php if($valS['name']): ?>
                        <p class="name" id="imp_name_<?php echo $key; ?>" title="<?php echo $valS['name']; ?>"><?php echo $valS['name']; ?></p>
                       <?php endif; ?>
                        <p class="email_id" id="imp_email_<?php echo $key; ?>" title="<?php echo $valS['screen_name']; ?>"><?php echo $valS['screen_name']; ?></p>
                      </div>
                    <?php else: ?>
                      <div class="inporter_details">
                      <?php if($valS['name']): ?>
                        <p class="name" id="imp_name_<?php echo $key; ?>" title="<?php echo $valS['name']; ?>"><?php echo $valS['name']; ?></p>
                        <?php endif; ?>
                        <p class="email_id" id="imp_email_<?php echo $key; ?>" title="<?php echo $valS['email']; ?>"><?php echo $valS['email']; ?></p>
                      </div>
                    <?php endif; ?>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
          <div class="importer_message">
            <input class="sesbasic_btn" id="importcnt" type="submit" value="Proceed" name="">
          </div>
        </div>
      <?php } ?>
      
      <div class="send_invitions_form" id="send_invitions_form" style="display:none">
        <form action="" method="post" id="inviteImportIds" enctype="multipart/form-data">
          <div class="torow mailing_row">
            <div class="mailing_label">To</div>
            <div class="mailing_box_holdier">
              <ul class="mailing_box_names_tabs" id="mailing_box_names_tabs" style="display:none;"></ul>
              <input type="text" name="import_emails" placeholder=""  readonly />
            </div>
          </div>
          <?php if($importmethod != 'twitter'): ?>
            <div class="subjectrow mailing-row">
              <div class="mailing_label"><?php echo $this->translate("Subject*"); ?></div>
              <div class=" mailing_box_holdier">
                <input type="text" name="" id="import_subject">
              </div>
            </div>
          <?php endif; ?>
          <div class="messagerow mailing-row">
            <div class="mailing_label"><?php echo $this->translate("Message*"); ?></div>
            <div class="mailing_box_holdier">
              <textarea id="import_message"></textarea>
            </div>
          </div>
          <input type="hidden" name="importEmails" id="importEmails" />
          <div class="mailing_footer_holder">
            <div class="mailing_footer_back" id="mailing_footer_back"><input class="sesbasic_btn" type="button" value="Back" /></div>
            <div class="mailing_footer_send"><input class="sesbasic_btn" id="import_invitesentemail" type="submit" value="Send" /></div>
          </div>
        </form>
        <div class="sesbasic_loading_cont_overlay" id="sesinviter_loading_contoverlay"></div>
      </div>
    </div>
  </div>
</div>

<script type="application/javascript">

//static search function
function importContentSearch() {

  // Declare variables
  var namesearch, namesearchfilter, allcontact_list, allcontact_list_li, allcontact_list_p, i;
  
  namesearch = document.getElementById('namesearch');
  namesearchfilter = namesearch.value.toUpperCase();
  allcontact_list = document.getElementById("allcontact_list");
  allcontact_list_li = allcontact_list.getElementsByTagName('li');
  
  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < allcontact_list_li.length; i++) {
    allcontact_list_p = allcontact_list_li[i].getElementsByTagName("p")[0];
    if (allcontact_list_p.innerHTML.toUpperCase().indexOf(namesearchfilter) > -1) {
        allcontact_list_li[i].style.display = "";
    } else {
        allcontact_list_li[i].style.display = "none";
    }
  }
}


function inviterValidateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( email );
}
  
sesJqueryObject(document).on('submit', '#inviteImportIds', function(e){

  e.preventDefault();
  
  var importEmails = sesJqueryObject('#importEmails').val();
  var str_array = importEmails.split(',');
  var import_subject = sesJqueryObject('#import_subject').val();
  var import_message = sesJqueryObject('#import_message').val();

  if(str_array.length == 1) {
    alert('Please enter at least one email.');
    return;
  }
  
  if(import_message.length == '') {
    alert('Please enter a message.');
    return;
  }

//   if(subscribe_email.length <= 0) {
//     alert('Please enter valid email address.');
//     return;
//   }
  <?php if($importmethod != 'twitter'): ?>
    for(var i = 0; i < str_array.length; i++) {
      // Trim the excess whitespace.
      str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
      // Add additional code here, such as:
      if(inviterValidateEmail(str_array[i])) {
    
      } else {
        alert('Please enter valid email address.' + str_array[i]);
        return;
      }
    }
  <?php endif; ?>
  
  $('sesinviter_loading_contoverlay').style.display='block';
  invitepeoplesespymk = new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesinviter/index/importinvite',
    'data': {
      format: 'html',
      importEmails: importEmails,
      import_subject: import_subject,
      import_message: import_message, 
      import_method: '<?php echo $importmethod ?>',
      is_ajax : 1,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
    
      var response = sesJqueryObject.parseJSON( responseHTML );
      $('sesinviter_loading_contoverlay').style.display='none';
      sesJqueryObject('#inviteImportIds').fadeOut("slow", function(){
        sesJqueryObject('#inviteImportIds').remove();
        sesJqueryObject('#inviterpopup_close').trigger('click');
      });
      document.getElementById('send_invitions_form').innerHTML = "<div class='sesinviter_invite_success_message'><span>Invitations Sent.</span></div>";
    }
  });
  invitepeoplesespymk.send();
  return false;
});


//Click on import button and show pop up
sesJqueryObject('#importcnt').click(function(e) {
		
		e.preventDefault();

		var elem = sesJqueryObject('.checkbox_slt_sm_im');

		var openerElem = window.opener; 
		
		var emailIds = [] ;
		var counter = 0;
		
		var importEmails = sesJqueryObject('#importEmails').val();
    var emailToContent = '';
    var importuserEmail = '';
		
		for(var i=0;i < elem.length; i++) {
		
      var id = sesJqueryObject(elem[i]).attr('id').replace('imcon_','');
      if(sesJqueryObject(elem[i]).prop('checked')) {
      
        //if(openerElem.checkEmailExists(sesJqueryObject('#imp_email_'+id).html().trim()))
          //continue;
          
        importuserEmail = sesJqueryObject('#imp_email_'+id).html().trim();
        
        importEmails += sesJqueryObject('#imp_email_'+id).html().trim() + ",";

        emailToContent += '<li id="useremail_'+importuserEmail+'"><div class="names_tabs"><div class="mailing_name" title="'+sesJqueryObject('#imp_email_'+id).html().trim()+'">'+sesJqueryObject('#imp_name_'+id).html().trim()+'</div><div id="mailing_name_close" class="mailing_name_close" data-rel="'+importuserEmail+'">x</div></div></li>';

        emailIds[counter] = sesJqueryObject('#imp_email_'+id).html().trim()+'||'+sesJqueryObject('#imp_name_'+id).html().trim();
        counter++;
      }
		}
		
		if(emailIds.length == 0) {
      if($('emailerror_message'))
        $('emailerror_message').style.display = 'block';
		} else {
		
      if($('emailerror_message'))
        $('emailerror_message').style.display = 'none';
        
      sesJqueryObject('#emailimport_content').hide();
        
      sesJqueryObject('#importsend_email').show();
      $('send_invitions_form').style.display = 'block';
      
      if(emailToContent) {
        sesJqueryObject('#mailing_box_names_tabs').show();
        sesJqueryObject('#mailing_box_names_tabs').html(emailToContent);
      }
      
      if(importEmails) {
        sesJqueryObject('#importEmails').val(importEmails);
      }
    }

		//openerElem.printEmail(emailIds);
		//window.close();
});

sesJqueryObject(document).on('click', '#mailing_footer_back', function(){
  sesJqueryObject('#send_invitions_form').hide();
  sesJqueryObject('#emailimport_content').show();
  sesJqueryObject('#importEmails').val('');
  
});

sesJqueryObject(document).on('click', '#inviterpopup_close', function(){
  sesJqueryObject('#importsend_email').remove();
  sesJqueryObject('#sesinviter_import_popup_list_container').remove();
});

sesJqueryObject(document).on('click','#mailing_name_close',function(){

  var dataid = sesJqueryObject(this).attr('data-rel');
  sesJqueryObject(this).closest('li').remove();
  var partsOfStr = sesJqueryObject('#importEmails').val().split(',');
  partsOfStr = sesJqueryObject.grep(partsOfStr, function(value) {
    return value != dataid;
  });
  partsOfStr = partsOfStr.join();
  sesJqueryObject('#importEmails').val(partsOfStr);
});

sesJqueryObject('#checkall').change(function(e){
	sesJqueryObject('.checkbox_slt_sm_im').prop('checked',sesJqueryObject(this).prop("checked"));
	if($('emailerror_message'))
    $('emailerror_message').style.display = 'none';
});

sesJqueryObject(document).on('change','.checkbox_slt_sm_im',function() {

	if(!sesJqueryObject(this).prop('checked')) {
		sesJqueryObject('#checkall').prop('checked',false);
// 		if($('emailerror_message'))
//         $('emailerror_message').style.display = 'block';
	} else {
		if(!inviterCheckAllsmCheckbox()) {
			sesJqueryObject('#checkall').prop('checked',false);
      if($('emailerror_message'))
        $('emailerror_message').style.display = 'none';
		} else {
			sesJqueryObject('#checkall').prop('checked',true);
			if($('emailerror_message'))
        $('emailerror_message').style.display = 'none';
		}
	}
});

function inviterCheckAllsmCheckbox() {

	var check = true;	
	var elem = sesJqueryObject('.checkbox_slt_sm_im');
	for(var i =0 ; i < elem.length;i++){
		if(!sesJqueryObject(elem[i]).prop('checked')){
			check  = false;
			break;	
		}
	}
	return check;	
}
</script>