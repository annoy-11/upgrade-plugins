<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: call-button.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="estore_profile_button_action_popup sesbasic_bxs">
  <div class="_header"><?php echo $this->translate("Add a Button to Your Store"); ?></div>
  <form method="post">
    <section class="step1">
      <div class="_contmain">
      	<div class="button_preview sesbasic_clearfix">
          <span class="_text floatL"><?php echo $this->translate("Preview"); ?></span>
          <?php if(Engine_Api::_()->authorization()->isAllowed('stores', $this->viewer(), 'auth_addbutton')):?>  
            <span class="_btn floatR"><a href="javascript:;" class="estore_button disabled"><span id="estore_call_btn_"><?php echo $this->translate("Add a Button"); ?></span></a></span>
          <?php endif;?>
        </div>
        <div class="_contmaintop">
          <p><b><?php echo $this->translate("Step 1:"); ?></b> <?php echo $this->translate("Which button do you want people to see?"); ?></p>
          <p class="_des sesbasic_text_light"><?php echo $this->translate("The button at the top of your Store helps people take an action. People see it on your Store and in search results when your Store appears. You can edit it any time."); ?></p>
          
          <ul class="btn_type_options">
            <li class="btn_type_options_i sesbasic_clearfix _op">
              <div>
                <i class="_ico fa fa-calendar sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Book with you"); ?></span>
              </div>
              
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio" data-popuptitle="<?php echo $this->translate("Link to Website"); ?>" data-popupdescription="<?php echo $this->translate("Store on your website where customers can book with you:
"); ?>" data-placeholder="<?php echo $this->translate("Enter a URL"); ?>" data-title="<?php echo $this->translate("Link to Website"); ?>" data-description="<?php echo $this->translate("Send people to your booking website when they click the button on your Facebook Store."); ?>" data-src="application/modules/Estore/externals/images/link.png" name="callactionbutton" value="booknow" id="cbtn_popup_booknow" /><label for="cbtn_popup_booknow" class="estore_callaction_label"><?php echo $this->translate("Book Now"); ?></label></p>
              </div>
            </li>
            <li class="btn_type_options_i sesbasic_clearfix _op">
              <div>
                <i class="_ico far fa-comments sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Contact you"); ?></span>
              </div>
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio" data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("This button will make it easy for people to call you. Enter the phone number to be dialed when people click this button."); ?>" data-placeholder="<?php echo $this->translate("(888) 999-6564"); ?>" value="callnow" name="callactionbutton" data-title="<?php echo $this->translate("Add your phone number"); ?> " data-description="<?php echo $this->translate("The phone number that will be dialed when customers click your button") ?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_callnow" /><label for="cbtn_popup_callnow" class="estore_callaction_label"><?php echo $this->translate("Call Now"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton"  value="contactus"  data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_contactus" /><label for="cbtn_popup_contactus" class="estore_callaction_label"><?php echo $this->translate("Contact Us"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("This button will make it easy for people to message you."); ?>"  data-placeholder="<?php echo $this->translate(""); ?>" name="callactionbutton" value="sendmessage" data-title="<?php echo $this->translate("Message")?>" data-description="<?php echo $this->translate("You will receive messages from customers in the Messages section on your Profile")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_sendmessage" /><label for="cbtn_popup_sendmessage" class="estore_callaction_label"><?php echo $this->translate("Send Message"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("This button will make it easy for people to call you."); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="signup" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_signup" /><label for="cbtn_popup_signup" class="estore_callaction_label"><?php echo $this->translate("Sign Up"); ?></label></p>
                <p style="display:none;"><input type="radio" name="callactionbutton" value="getQuote" /><label  class="estore_callaction_label"><?php echo $this->translate("Get Quote"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What email would you like people to contact when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Email Address"); ?>" name="callactionbutton" value="sendemail" data-title="<?php echo $this->translate("Add your email address")?>" data-description="<?php echo $this->translate("Choose the email address that will be prefilled in an email when people click your button")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_sendemail" /><label for="cbtn_popup_sendemail" class="estore_callaction_label"><?php echo $this->translate("Send Email"); ?></label></p>
              </div>
            </li>
            <li class="btn_type_options_i sesbasic_clearfix _op">
              <div>
                <i class="_ico fa fa-info-circle sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Learn more about your store"); ?></span>
              </div>
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="watchvideo" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_watchvideo" /><label for="cbtn_popup_watchvideo" class="estore_callaction_label"><?php echo $this->translate("Watch Video"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="learnmore" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_learnmore" /><label for="cbtn_popup_learnmore" class="estore_callaction_label"><?php echo $this->translate("Learn More"); ?></label></p>
              </div>
            </li>
            <li class="btn_type_options_i sesbasic_clearfix _op">
              <div>
                <i class="_ico fa fa-shopping-bag sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Shop with you or make a donation"); ?></span>
              </div>
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="shopnow" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_shopnow" /><label for="cbtn_popup_shopnow" class="estore_callaction_label"><?php echo $this->translate("Shop Now"); ?></label></p>
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?
"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="seeoffers" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_seeoffers" /><label for="cbtn_popup_seeoffers" class="estore_callaction_label"><?php echo $this->translate("See Offers"); ?></label></p>
              </div>
            </li>
            <li class="btn_type_options_i sesbasic_clearfix _op">
              <div>
                <i class="_ico fa fa-download sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Download your App or play your game"); ?></span>
              </div>
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="useapp" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_useapp" /><label for="cbtn_popup_useapp" class="estore_callaction_label"><?php echo $this->translate("Use App"); ?></label></p>
                
                
                <p><input type="radio"  data-popuptitle="<?php echo $this->translate(""); ?>" data-popupdescription="<?php echo $this->translate("What website would you like to send people to when they click this button?"); ?>" data-placeholder="<?php echo $this->translate("Add a website link"); ?>" name="callactionbutton" value="playgames" data-title="<?php echo $this->translate("Website Link")?>" data-description="<?php echo $this->translate("Send people to a website you choose.")?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_playgames" /><label for="cbtn_popup_playgames" class="estore_callaction_label"><?php echo $this->translate("Play Games"); ?></label></p>
              </div>
            </li>
            <li class="btn_type_options_i sesbasic_clearfix _op" style="display:none;">
              <div>
                <i class="_ico fa fa-users sesbasic_text_light"></i>
                <i class="_ind fa sesbasic_text_light"></i>
                <span class="_tit"><?php echo $this->translate("Join your community"); ?></span>
              </div>
              <div class="op_fields sesbasic_clearfix">
                <p><input type="radio" name="callactionbutton" value="visitstore" data-title="<?php echo $this->translate("")?>" data-description="<?php echo $this->translate("")?>" data-placeholder="<?php echo $this->translate(""); ?>" data-src="application/modules/Estore/externals/images/link.png" id="cbtn_popup_visitstore" /><label for="cbtn_popup_visitstore" class="estore_callaction_label"><?php echo $this->translate("Visit Store"); ?></label></p>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_text sesbasic_text_light"><?php echo $this->translate("Step 1 of 2"); ?></div>
        <div class="_btns">
          <a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();"><?php echo $this->translate("Cancel"); ?></a>
          <a href="javascript:;" class="disabled estore_button estore_firststep_btn"><?php echo $this->translate("Next"); ?></a>
        </div>
      </div>
    </section>
    <section class="step2" style="display:none;">
      <div class="_contmain">
      	<div class="button_preview sesbasic_clearfix">
      		<span class="_text floatL"><?php echo $this->translate("Preview"); ?></span>
          <span class="_btn floatR"><a href="javascript:;" class="estore_button"><span id="estore_call1_btn_"><?php echo $this->translate("Call Now"); ?></span></a></span>
        </div>
      	<div class="sesbasic_clearfix _selectedresult">
        	<p class="_text floatL">
          	<i class="fa fa-check"></i>
            <span><b><?php echo $this->translate("Your Button"); ?></b> <span id="estore_btn_val"><?php echo $this->translate("Book Now"); ?></span></span>
          </p>
          <p class="_btn floatR"><a href="javascript:void(0);" class="sesbasic_button estore_btn_finish"><?php echo $this->translate("Edit"); ?></a></p>	
        </div>
				<div class="sesbasic_clearfix _selectedresult _stepsuccessmsg" style="display:none;">
        	<p class="_text floatL">
          	<i class="fa fa-check"></i>
            <span><b><?php echo $this->translate("Configured"); ?></b></span>
          </p>
          <p class="_btn floatR"><a href="javascript:;" class="sesbasic_button estore_conf_edit"><?php echo $this->translate("Edit"); ?></a></p>	
        </div>
        <div>
        <div class="_contmaintop secondmaintop">
          <p><b><?php echo $this->translate("Step 2:"); ?></b> <?php echo $this->translate("Where would you like this button to send people?"); ?></p>
          <p class="_des sesbasic_text_light"><?php echo $this->translate("When customers click your button, they will be directed to a place where they can take an action or find more information."); ?></p>
        </div>
        <ul class="step2_ops">
        	<li class="sesbasic_bxs">
          	<a href="javascript:void(0)" class="estore_call_action_elem">
              <i class="prelative fa fa-check floatL _icon sesbasic_text_light"></i>
              <div class="_cont">
                <b id="estore_selected_title"><?php echo $this->translate("Link to Website"); ?></b>
                <p class="sesbasic_text_light" id="estore_selected_description"><?php echo $this->translate("Send people to your booking website when they click the button on your Facebook Store."); ?></p>	
              </div>
            </a>
          </li>
        </ul>
        </div>
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_text sesbasic_text_light"><?php echo $this->translate("Step 2 of 2"); ?></div>
        <div class="_btns">
      		<i id="sesbasic_loading_cont_overlay_a" class="floatL fa fa-circle-notch fa-spin" style="display:none;margin:12px 5px 0 0;"></i>
          <a href="javascript:void(0);" class="sesbasic_button estore_btn_finish"><?php echo $this->translate("Back"); ?></a>
          <a href="javascript:void(0);" class="estore_button" id="estore_call_action_remove" style="display:none;"><?php echo $this->translate("Delete"); ?></a>
          <a href="javascript:void(0);" class="estore_button disabled estore_btn_finish_save"><?php echo $this->translate("Finish"); ?></a>
        </div>
      </div>
    </section>
  </form>
</div>
<div class="estore_profile_button_action_link_popup sesbasic_bxs" style="position:relative;">
	<div class="estore_profile_button_action_link_popup_cont">
  	<div class="_field">
    	<p id="estore_popip_title"><?php echo $this->translate("What website would you like to send people to when they click this button?"); ?></p>
      <input type="text" id="estore_popip_title_input" name="estore_link" placeholder="<?php echo $this->translate("Enter a URL"); ?>"  />
    </div>
    <div class="_footer sesbasic_clearfix">
      <div class="_btns">
        <a href="javascript:void(0);" class="sesbasic_button estore_popup_cancel_callaction"><?php echo $this->translate("Cancel"); ?></a>
        <a href="javascript:void(0);" class="disabled estore_button estore_popup_save_callaction"><?php echo $this->translate("Save"); ?></a>
      </div>
    </div>
  </div>
</div>		
<script type="application/javascript">

<?php if($this->callAction){?>
en4.core.runonce.add(function() {
  sesJqueryObject("input[name=callactionbutton][value='<?php echo $this->callAction->type; ?>']").prop("checked",true);
  sesJqueryObject("input[type=radio][name=callactionbutton]:checked").closest('li').addClass('_op_selected_');
  sesJqueryObject("input[type=radio][name=callactionbutton]:checked").trigger('change');
  sesJqueryObject(".estore_firststep_btn").trigger('click');
  sesJqueryObject('#estore_popip_title_input').val("<?php echo $this->callAction->params; ?>");
  sesJqueryObject('.estore_popup_save_callaction').trigger("click");
  sesJqueryObject('#estore_call_action_remove').show();
});

function removeCallActionBtn(){
  sesJqueryObject('#sesbasic_loading_cont_overlay_a').show();
 sesJqueryObject.post('estore/index/remove-callaction/',{page:sesItemSubjectGuid},function(res){
    if(res == 1){
      var id = sesJqueryObject('.estorecallaction').data('id');
       sesJqueryObject.post(en4.core.baseUrl + "widget/index/mod/estore/name/profile-action-button/identity/"+id ,{is_ajax:true,page:sesItemSubjectGuid},function(res){
         if(res){
            sesJqueryObject('.layout_estore_profile_action_button').html(res); 
            sessmoothboxclose(); 
         }
         sesJqueryObject('#sesbasic_loading_cont_overlay_a').hide();
       });
    }
    sesJqueryObject('#sesbasic_loading_cont_overlay_a').hide();
 })
}
<?php } ?>

function saveCallActionBtn(){
  sesJqueryObject('#sesbasic_loading_cont_overlay_a').show();
   var fieldValue = sesJqueryObject('input[name="estore_link"]').val();
   var checkboxVal = sesJqueryObject("input[type=radio][name=callactionbutton]:checked").val();
   
   sesJqueryObject.post('estore/index/save-callaction/',{fieldValue:fieldValue,checkboxVal:checkboxVal,page:sesItemSubjectGuid},function(res){
      if(res == 1){
        var id = sesJqueryObject('.estorecallaction').data('id');
         sesJqueryObject.post(en4.core.baseUrl + "widget/index/mod/estore/name/profile-action-button/identity/"+id ,{is_ajax:true,page:sesItemSubjectGuid},function(res){
           if(res){
              sesJqueryObject('.layout_estore_profile_action_button').html(res); 
              sessmoothboxclose(); 
           }
         });
      }
      sesJqueryObject('#sesbasic_loading_cont_overlay_a').hide();
   })
}
function checkEmail(){
  var email = sesJqueryObject('input[name="estore_link"]').val();
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function checkURL(){
  var url = sesJqueryObject('input[name="estore_link"]').val();
      return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);

}
//validate phone number
function checkPhone(){
  //return true for now.
  return true;
  var phone = sesJqueryObject('input[name="estore_link"]').val(),
  intRegex = "/[0-9 -()+]+$/";
  if((phone.length < 6) || (!intRegex.test(phone))){
    return false;
  }
  return true;
}
</script>
