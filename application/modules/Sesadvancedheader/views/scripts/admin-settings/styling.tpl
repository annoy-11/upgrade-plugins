<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<style type="text/css">
/*Color Scheme Form*/
.sesadvance_headers_form .form-label{
	margin-bottom:5px;
}
.sesadvance_headers_form #header_color-label{
	border-bottom-width:1px;
	font-size:15px;
	padding-bottom:15px;
	text-align:center;
	width:100%;
}
.sesadvance_headers_form #header_color-wrapper .form-element{
	clear:both;
	text-align:center;
}
.sesadvance_headers_form #header_color-wrapper .form-element li{
	box-sizing:border-box;
	float:left;
	margin:10px 10px 0 0;
	padding-bottom:30px;
	position:relative;
	width:275px;
}
.sesadvance_headers_form #header_color-wrapper .form-element li input{
	bottom:0;
	float:none;
	left:50%;
	margin-bottom:10px;
	position:absolute;
}
.sesadvance_headers_form #header_color-wrapper .form-element li label{
	cursor:pointer;
}
.sesadvance_headers_form #header_color-wrapper .form-element li img{
	width:100%;
}
.sesadvance_headers_form #header_color-wrapper .form-element li:last-child{
	clear:both;
	display:block;
	float:none;
	margin:0 auto;
	padding-top:20px;
	width:400px;
}
.sesadvance_headers_form #header_color-wrapper .form-element li:last-child:before{
  content:"Make You Own Theme (make sure the site is in Development Mode, before you make any changes)";
	font-size:15px;
	font-weight:bold;
	margin-bottom:10px;
}
.sesadvance_headers_form #header_color-wrapper .form-element li:last-child img{
	margin-top:10px;
}
.sesadvance_headers_form #header_settings-wrapper,
.sesadvance_headers_form #footer_settings-wrapper,
.sesadvance_headers_form #body_settings-wrapper{
	border-bottom-width:1px;
}
.sesadvance_headers_form #header_settings-wrapper .form-label,
.sesadvance_headers_form #footer_settings-wrapper .form-label,
.sesadvance_headers_form #body_settings-wrapper .form-label{
	font-size:15px;
	width:auto;
}
.sesadvance_headers_form #header_settings_group > fieldset > div,
.sesadvance_headers_form #footer_settings_group > fieldset > div,
.sesadvance_headers_form #body_settings_group > fieldset > div{
  margin-right:3%;
	display:inline-block;
	width:30%;
}
.sesadvance_headers_form #header_settings_group > fieldset > div > div,
.sesadvance_headers_form #footer_settings_group > fieldset > div > div,
.sesadvance_headers_form #body_settings_group > fieldset > div > div{
	width:100%;
}
.sesadvance_headers_form #sesariana_footer_heading_color-wrapper{
	display:none !important;
}
.sesadvance_headers_form #custom_theme_color-label{
	width:140px;
}
.sesadvancedheader_styling_buttons{
	float:right;
	margin-top:-35px;
}
.header_button{
	float:left;
	margin-right:15px;
	text-decoration:none !important;
}
.header_button:before{margin-right:5px;}
.header_button .disabled{color:#999;}
</style>

<script>
hashSign = '#';
isColorFieldRequired = false;
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesadvancedheader/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sesadvance_headers_form' style="position:relative;">
    <?php echo $this->form->render($this); ?>
    <div class="sesbasic_loading_cont_overlay" style="display:none"></div>
  </div>
</div>
<script>
  jqueryObjectOfSes(document).ready(function(){
    changeHeaderColor(jqueryObjectOfSes("input[name='header_color']:checked").val());  
  })
  jqueryObjectOfSes(document).on('click','.seschangeHeaderName',function(e){
    e.preventDefault();
     var id = jqueryObjectOfSes('#custom_header_color').val();
     var href = jqueryObjectOfSes(this).attr('href')+'/customheader_id/'+id;
     Smoothbox.open(href);
      parent.Smoothbox.close;
      return false;
  });
  jqueryObjectOfSes(document).on('click','#delete_custom_headers',function(e){
    e.preventDefault();
     var id = jqueryObjectOfSes('#custom_header_color').val();
     var href = jqueryObjectOfSes(this).attr('href')+'/customheader_id/'+id;
     Smoothbox.open(href);
      parent.Smoothbox.close;
      return false;
  })
  
  function changeCustomHeaderColor(value) {
  
      changeHeaderColor(jqueryObjectOfSes("input[name='header_color']:checked").val());
      
      if(jqueryObjectOfSes("input[name='header_color']:checked").val() == 5)
        jqueryObjectOfSes('.sesbasic_loading_cont_overlay').show();
        
      var URL = en4.core.baseUrl+'admin/sesadvancedheader/settings/getcustomheadercolors/';
      (new Request.HTML({
          method: 'post',
          'url': URL ,
          'data': {
            format: 'html',
            customheader_id: value,
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          
          var customthevalyearray = jqueryObjectOfSes.parseJSON(responseHTML);
          
          for(i=0;i<customthevalyearray.length;i++){
            var splitValue = customthevalyearray[i].split('||');
            jqueryObjectOfSes('#'+splitValue[0]).val(splitValue[1]);
            if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor')){
              if(splitValue[1] == ""){
                splitValue[1] = "#FFFFFF";  
              }
             try{
              document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
             }catch(err) {
               document.getElementById(splitValue[0]).value = "#FFFFFF";
             }
            }
          }
          jqueryObjectOfSes('.sesbasic_loading_cont_overlay').hide();
        }
      })).send();
  }
  
	function changeHeaderColor(value) {

    var customheaderValue = jqueryObjectOfSes('#custom_header_color').val();
    if(customheaderValue > 6) {
      jqueryObjectOfSes('#edit_custom_headers').show();
      jqueryObjectOfSes('#delete_custom_headers').show();  
    } else {
      jqueryObjectOfSes('#edit_custom_headers').hide();
      jqueryObjectOfSes('#delete_custom_headers').hide();    
    }
    if(value != 5) {
      jqueryObjectOfSes('.sesadvancedheader_bundle').prev().hide();
      jqueryObjectOfSes('.sesadvancedheader_bundle').hide();
      jqueryObjectOfSes('#custom_header_color-wrapper, .sesadvancedheader_styling_buttons').hide();
      jqueryObjectOfSes('#submit').css('display','none');
    } else {
      jqueryObjectOfSes('.sesadvancedheader_bundle').prev().show();
      jqueryObjectOfSes('.sesadvancedheader_bundle').show();
      jqueryObjectOfSes('#custom_header_color-wrapper, .sesadvancedheader_styling_buttons').show();
      jqueryObjectOfSes('#submit').css('display','inline-block');  
    }
  }
</script>
