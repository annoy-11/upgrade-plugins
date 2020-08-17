<?php 
?>



<?php $settings = Engine_Api::_()->getApi('settings', 'core');

$socialmediaoptions = unserialize($settings->getSetting('sesinviter.socialmediaoptions', ''));

?>
<?php if($socialmediaoptions && in_array('gmail', $socialmediaoptions)) { ?>
  <?php $this->headScript()->appendFile('https://apis.google.com/js/client.js'); ?>
<?php } ?>

<?php if($socialmediaoptions && in_array('facebook', $socialmediaoptions)) { ?>
<script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<?php } ?>
 

<div class="sesinviter_main sesbasic_bxs">
  <div class="sesinviter_section">
  
    <div class="sesinviter_tab">
      <button id="socialContacts" class="tablinks active" onclick="openInviteTab(event, 'input_contact')"><?php echo $this->translate("Import Your Contacts"); ?></button>
      
      <button id="uploadContacts" class="tablinks" onclick="openInviteTab(event, 'upload_contact')"><?php echo $this->translate("Upload Your Contacts"); ?></button>
      
      <button id="inviteContacts" class="tablinks <?php if($this->param == 'friends'): ?> active <?php endif; ?>" onclick="openInviteTab(event, 'add_address')"><?php echo $this->translate("Invite Your Friends"); ?></button>
    </div>
    
    <div id="input_contact" class="tabcontent" style="display:block;">
      <p><?php echo $this->translate("How do you talk to the people you know? Choose a service:"); ?></p>
      <ul class="social_link_contact">
        
        <?php if($settings->getSetting('sesinviter.facebookclientid', '') && in_array('facebook', $socialmediaoptions)) { ?>
          <li class="facebook" id="facebookInviterContact"><a href="javascript:void(0);" onclick="FbInviterRequest('<?php echo $settings->getSetting("sesinviter.facebookmessage", "This page is amazing, check it out!"); ?>','44530');"><i class="fa fa-facebook"></i><?php echo $this->translate("Facebook"); ?></a></li>
        <?php } ?>
        
        <?php if($settings->getSetting('sesinviter.twitterclientid', '') && $settings->getSetting('sesinviter.twitterclientsecret', '') && in_array('twitter', $socialmediaoptions)) { ?>
          <li class="twitter importContactEmail" id="twitterInviterContact" data-rel="twitter" onclick="socialMediaInviterContacts('twitter');"><a href="javascript:void(0);"><i class="fa fa-twitter"></i><?php echo $this->translate("Twitter"); ?></a></li>
        <?php } ?>
        
        <?php if($settings->getSetting('sesinviter.gmailclientid', '') && $settings->getSetting('sesinviter.gmailclientsecret', '') && in_array('gmail', $socialmediaoptions)) { ?>
          <li class="google" id="gmailInviterContact"><a href="javascript:void(0);"><i class="fa fa-google-plus"></i><?php echo $this->translate("Gmail"); ?></a></li>
        <?php } ?>
        
        <?php if($settings->getSetting('sesinviter.hotmailclientid', '') && $settings->getSetting('sesinviter.hotmailclientsecret', '') && in_array('hotmail', $socialmediaoptions)) { ?>
          <li class="hotmail importContactEmail" id="importContactEmail" data-rel="hotmail" onclick="socialMediaInviterContacts('hotmail');"><a href="javascript:void(0);"><i class="fa fa-envelope"></i><?php echo $this->translate("Hotmail"); ?></a></li>
        <?php } ?>
        
        <?php if($settings->getSetting('sesinviter.yahooconsumerkey', '') && $settings->getSetting('sesinviter.yahooconsumersecret', '') && in_array('yahoo', $socialmediaoptions)) { ?>
          <li class="yahoo importContactEmail" data-rel="yahoo" onclick="socialMediaInviterContacts('yahoo');"><a href="javascript:void(0);"><i class="fa fa-yahoo"></i><?php echo $this->translate("Yahoo"); ?></a></li>
        <?php } ?>
        
        <li class="csv"><a href="javascript:void(0);" onclick="showUploadContacts('csv');"><i class="fa fa-file-text-o"></i><?php echo $this->translate("CSV"); ?></a></li>
        
        <li class="email"><a href="javascript:void(0);" onclick="showUploadContacts('email');"><i class="fa fa-envelope"></i><?php echo $this->translate("Email"); ?></a></li>
        
      </ul>
      <form action="" method="post" id="socialuploadfile" enctype="multipart/form-data">
        <input type="hidden" name="socialMediaEmails" id="socialMediaEmails" />
        <!--<p class="select_file"><input type="file" name="csv" onchange="checkcsvfile(this)" /></p>-->
        <!--<div id="errorUploadCsvFile"></div>-->
      </form>
    </div>
  
    <div id="upload_contact" class="tabcontent">
      <p><?php echo $this->translate("Lorem Ipsum is simply dummy text of the printing and typesetting industry."); ?></p> 
      <p><a id="myBtn" href="javascript:void();" onclick="showCSVMoreOption('1');" ><?php echo $this->translate("How to create a contact file."); ?></a></p> 
      <div id="option_1" class="creation_description_modal">
        <div class="creation_description_modal_content">
          <span class="close" onclick="optionClose();">&times;</span>
          <div class="creation_description_one">
            <p class="tittle"><a href="javascript:void(0);" onclick="showCSVMoreOption('2');"><?php echo $this->translate("Outlook"); ?></a></p>
            <p id="option_2" class="discription">
              <span>1. Sign into your Windows Live Hotmail account.</span>
              <span>2. Click the down-arrow at the upper-left corner of your screen.</span>
              <span>3. Choose People.</span>
              <span>4. Click Manage in the menu bar.</span>
              <span>5. Choose Export.</span>
            </p>
          </div>
          <div class="creation_description_two">
            <p class="tittle"><a href="javascript:void(0);" onclick="showCSVMoreOption('3');"><?php echo $this->translate("Yahoo"); ?></a></p>
            <p id="option_3" class="discription">
              <span>1. Launch Yahoo email and sign in.</span>
              <span>2. Click on the Contacts tab.</span>
              <span>3. Click the Actions dropdown box.</span>
              <span>4. Choose Export.</span>
              <span>5. Click Export Now next to "Yahoo! CSV" which is the type of program to which you want to export your contacts.</span>
            </p>
          </div>
<!--          <div class="creation_description_three">
            <p class="tittle"><a href="javascript:void(0);" onclick="showCSVMoreOption('4');">creation description three</a></p>
            <p id="option_4" class="discription">unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
          </div>-->
          <div class="creation_description_four">
            <p class="tittle"><a href="javascript:void(0);" onclick="showCSVMoreOption('5');"><?php echo $this->translate("Other"); ?></a></p>
            <p id="option_5" class="discription">
             <span> We support the following types of contact file:</span>
             <span>- Comma-separated values (.csv)</span>
            </p>
          </div>
        </div>
      </div>
  
      <form action="" class="upload_csv_file" method="post" id="csvuploadfile" enctype="multipart/form-data">
        <p class="select_file"><input type="file" name="csv" onchange="checkcsvfile(this)" /></p>
        <div id="errorUploadCsvFile"></div>
      </form>
      <div id="contactImportData"></div>
    </div>
  
    <div id="add_address" class="tabcontent">
      <?php echo $this->form->render($this) ?>
      <div class="sesbasic_loading_cont_overlay" id="sesinviter_loading_cont_overlay"></div>
    </div>
  </div>
</div>

<script type="application/javascript">
  
  function optionClose() {
    document.getElementById('option_1').style.display = 'none';
  }
  
  function showCSVMoreOption(option) {
    if (document.getElementById('option_'+option).style.display == "block") {

      document.getElementById('option_'+option).style.display = "none";

    } else {

      document.getElementById('option_'+option).style.display = "block";

    }
  }
</script>

<?php if($socialmediaoptions && in_array('facebook', $socialmediaoptions)) { ?>
  <script type="text/javascript">
  
    function FbInviterRequest(message, data) {
      FB.ui(
        {
          method:'apprequests',
          message:message,
          data:data,
          title:'<?php echo $settings->getSetting("sesinviter.facebookmessage", "Share this site with your friends"); ?>'
        },
        function(response){
          // response.request_ids holds an array of user ids that received the request
        }
      );
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId : '<?php echo $settings->getSetting("sesinviter.facebookclientid", ""); ?>',
        xfbml : true,
        version : 'v2.0'
      });
      open_facebook_invite_dialog();
    }; 

    (function(d, s, id) {

      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }
    (document, 'script', 'facebook-jssdk'));

    function open_facebook_invite_dialog() {
      if ( typeof FB == 'undefined')
        return;
    }
  </script>
<?php } ?>

<script type="application/javascript">
  
  //invite from work
  
  function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( email );
  }

  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#sesinviter_invite').submit(function(e){
      e.preventDefault();
      
      var subscribe_email = sesJqueryObject('#recipients').val();

      if(subscribe_email.length <= 0) {
        alert('Please enter valid email address.');
        return;
      }
      var str_array = subscribe_email.split(',');

      for(var i = 0; i < str_array.length; i++) {
        // Trim the excess whitespace.
        str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
        // Add additional code here, such as:
        if(validateEmail(str_array[i])) {
      
        } else {
          alert('Please enter valid email address.');
          return;
        }
      }
      
			$('sesinviter_loading_cont_overlay').style.display='block';
      invitepeoplesespymk = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'sesinviter/index/invite/',
        'data': {
          format: 'html',    
          params : sesJqueryObject(this).serialize(), 
          is_ajax : 1,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        
          $('sesinviter_loading_cont_overlay').style.display='none';
          
          sesJqueryObject('#recipients').before("<div id='sespymk_invite_success_message' class='sespymk_invite_success_message'><span>Invitations Sent.</span></div>");

          sesJqueryObject('#sespymk_invite_success_message').fadeOut("slow", function(){
            setTimeout(function() {
              sesJqueryObject('#sespymk_invite_success_message').remove();
            }, 2000);
          });
          
          sesJqueryObject('#recipients').val('');
          sesJqueryObject('#message').val('You are being invited to join our social network.');
          sesJqueryObject('#friendship').prop('checked', false);
        }
      });
      invitepeoplesespymk.send();
      return false;
    });
  });
</script>
<script type="application/javascript">

  var inputCSVFile;
  var socialMediaEmail = [];
  var socialMediaName = '';
  
  <?php if($socialmediaoptions && in_array('gmail', $socialmediaoptions)) { ?>
  
    var clientId = '<?php echo $settings->getSetting("sesinviter.gmailclientid", ""); ?>';
    var apiKey = '<?php echo $settings->getSetting("sesinviter.gmailclientsecret", ""); ?>';
    
    var scopes = 'https://www.googleapis.com/auth/contacts.readonly';
    
    sesJqueryObject(document).on("click","#gmailInviterContact", function(){
      gapi.client.setApiKey(apiKey);
      window.setTimeout(authorize);
    });
    
    function authorize() {
      gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthorization);
    }
    
    function handleAuthorization(authorizationResult) {
    
      if (authorizationResult && !authorizationResult.error) {
        sesJqueryObject.get("https://www.google.com/m8/feeds/contacts/default/full?alt=json&access_token=" + authorizationResult.access_token + "&max-results=500&v=3.0",
        function(response) {
          //process the response here
          var entries = response.feed.entry; 
          
          var Gemail= [];
          for (var i = 0; i < entries.length; i++) {
            if(response.feed.entry[i].gd$phoneNumber)
              continue; 
            else {
              if(checkEmailExists(response.feed.entry[i].gd$email[0].address))
                continue;
              Gemail[i]= response.feed.entry[i].gd$email[0].address+'||'+response.feed.entry[i].title.$t;
              socialMediaEmail[i]= response.feed.entry[i].gd$email[0].address+'||'+response.feed.entry[i].title.$t;
            }
          }
          if(Gemail.length > 0) {
            socialMediaName = 'gmail';
            sesJqueryObject('#socialMediaEmails').val(socialMediaEmail);
            sesJqueryObject('#socialuploadfile').trigger('submit');
          }
        });
      }
    }
  <?php } ?>

  function socialMediaInviterContacts(id) {

    //var id = sesJqueryObject(this).attr('data-rel');
    url = 'sesinviter/index/csvimport/socialMediaName/'+id; 
    if (id == 'yahoo') {
      popup_height = '500';
      popup_width = '500';
    }else if (id == 'windowslive' || id == 'aol') {
      popup_height = '550';
      popup_width = '600';
    } else if (id == 'yahoo' || id == 'facebook') {
      popup_height = '550';
      popup_width = '600';
    } else {
      popup_height = '600';
      popup_width = '987';
    }
    window.open(url, "_popupWindow", 'height='+popup_height+',width='+popup_width+',location=no,menubar=no,resizable=no,status=no,toolbar=no');
  }


  sesJqueryObject(document).on('submit', '#socialuploadfile', function(e){

    e.preventDefault();
    var socialEmails = sesJqueryObject('#socialMediaEmails').val();
    
    socialMediaEmails = new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'sesinviter/index/csvimport/',
      'data': {
        format: 'html',
        socialEmails: socialEmails,
        socialMediaName: socialMediaName,
        is_ajax : 1,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      
        response = sesJqueryObject.parseJSON(responseHTML);
        if(response.status == 1) {
          sesJqueryObject(response.message).appendTo('body');
          sesJqueryObject('#importsend_email').show();
          sesJqueryObject('#emailimport_content').show();
        }
      }
    });
    socialMediaEmails.send();
    return false;

  });

  function checkEmailExists(value){
    var returnV = false;
    var emailsS = sesJqueryObject('.email_inst_snt');
    for(var i =0 ; i < emailsS.length; i++){
      if(sesJqueryObject(emailsS[i]).val() == value)	{
        return true;
        break;	
      }
    }
  }

  sesJqueryObject(document).on('submit', '#csvuploadfile', function(e) {

    e.preventDefault();
    var formData = new FormData();
    formData.append('contact', inputCSVFile);
    sesJqueryObject.ajax({
      xhr:  function() {
        var xhrobj = sesJqueryObject.ajaxSettings.xhr();
        if (xhrobj.upload) {
          xhrobj.upload.addEventListener('progress', function(event) {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            if (event.lengthComputable) {
              percent = Math.ceil(position / total * 100);
            }
            //Set progress
          }, false);
        }
        return xhrobj;
      },
      url:  en4.core.staticBaseUrl+'sesinviter/index/csvimport/',
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        text = JSON.parse(response);
        if(text.status == 1) {
        
          sesJqueryObject(text.message).appendTo('body');
          sesJqueryObject('#importsend_email').show();
          sesJqueryObject('#emailimport_content').show();
          //sesJqueryObject('#contactImportData').html(text.message);
        }
        sesJqueryObject('#errorUploadCsvFile').hide();
      }
      });
  });

  function checkcsvfile(input) {
  
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

    if (input.files && input.files[0] && (ext == "csv")) { 
      inputCSVFile = input.files[0];
      var reader = new FileReader();
      reader.onload = function (e) {
        sesJqueryObject('#errorUploadCsvFile').css('color','green').html('uploading ...');
        sesJqueryObject('#csvuploadfile').trigger('submit');
        
        //var formData = new FormData(this);
        //uplaodCSV(input.files[0]);
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      sesJqueryObject('#errorUploadCsvFile').css('color','red').html('Please select valid csv file.');
    }
  }

  function openInviteTab(evt, cityName) {

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
  
  function showUploadContacts(type) {
    if(type == 'csv') {
      sesJqueryObject('#socialContacts').removeClass('active');
      sesJqueryObject('#input_contact').hide();
      sesJqueryObject('#uploadContacts').addClass('active');
      sesJqueryObject('#upload_contact').show();
    } else if(type == 'email') {
      sesJqueryObject('#socialContacts').removeClass('active');
      sesJqueryObject('#input_contact').hide();
      sesJqueryObject('#inviteContacts').addClass('active');
      sesJqueryObject('#add_address').show();
    }
  }

  // Get the element with id="defaultOpen" and click on it
  //document.getElementById("defaultOpen").click();
  
  //Yahoo window open call
  function inviterYahooData(yahoodata) {
    if(yahoodata.length > 0) {
      socialMediaName = 'yahoo';
      sesJqueryObject('#socialMediaEmails').val(yahoodata);
      sesJqueryObject('#socialuploadfile').trigger('submit');
    }
  }
  
  //Yahoo window open call
  function inviterTwitterData(twitterdata) {

    if(twitterdata.length > 0) {
      socialMediaName = 'twitter';
      sesJqueryObject('#socialMediaEmails').val(twitterdata);
      sesJqueryObject('#socialuploadfile').trigger('submit');
    }
  }
</script>
