<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: compliments.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmember_comp_popup sesbasic_bxs sesbasic_clearfix">
 <div class="sesmember_comp_popup_header"><?php echo $this->translate('Choose Your Compliment Type');?></div>
  <form action="" id="myform">
    <div class="sesmember_comp_popup_cont sesbasic_clearfix">
      <ul class="sesmember_comp_popup_cont_fields_wrapper sesbasic_clearfix">
      <?php 
      $counter = 1;
      foreach($this->complements as $com){ ?>
      	<?php
        if ($com->file_id) {
          $img_path = Engine_Api::_()->storage()->get($com->file_id, '')->getPhotoUrl();
          $path =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on' ? "https://" : 'http://') . $_SERVER['HTTP_HOST'] . $img_path;
       } ?>
        <li>
        	
          <input type="radio"  id="sescom_<?php echo $com->getIdentity(); ?>"  name="typeName" value="<?php echo $com->getIdentity(); ?>" <?php if($counter == 1){ echo 'checked="checked"' ;  } ?> />
          <label for="sescom_<?php echo $com->getIdentity(); ?>">
          <img src="<?php echo $path; ?>" /><span class=""><?php echo $this->translate($com->title); ?></span></label>
        </li>
       <?php $counter++;
       	} ?>
      </ul>
      <div class="sesmember_comp_popup_cont_text">
        <textarea id="compliment_description"></textarea>
      </div>
    </div>
     <div class="sesbasic_loading_cont_overlay" id="sesmember_widget_overlay_compliment"></div>
 </form>
  <div class="sesmember_comp_popup_footer">
   <button onclick="submitCompliment()">Send</button>&nbsp;&nbsp;
    <a onclick="javascript:sessmoothboxclose();" href="javascript:;">Cancel</a>
  </div>
</div>

<script type="application/javascript">
var requestSendCompliment;
function submitCompliment(){
	sesJqueryObject('#sesmember_widget_overlay_compliment').show();
	if(typeof requestSendCompliment != 'undefined')
		requestSendCompliment.cancel();
	if(typeof window.paramssesmember_compliment  == 'undefined')
		var sendParam   = '';
	else
		var sendParam = window.paramssesmember_compliment;
	var type = sesJqueryObject("input[name='typeName']:checked").val();;
	var description = document.getElementById('compliment_description').value;
	 requestSendCompliment = (new Request.HTML({
      method: 'post',
      'url':  "sesmember/index/save-compliment/user_id/<?php echo $this->user_id; ?>",
      'data': {
			format: 'html',
			type:type,
			params:sendParam,
			description:description
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('#sesmember_widget_overlay_compliment').hide();
				sesJqueryObject('#sesmember_compliment').find('.tip').remove();
				sesJqueryObject('#sesmember_compliment').prepend(responseHTML);
				if(sesJqueryObject('.tab_layout_sesmember_profile_compliments').length){
					if(sesJqueryObject('.tab_layout_sesmember_profile_compliments').find('a').length)
						sesJqueryObject('.tab_layout_sesmember_profile_compliments').find('a').trigger('click');
					else
						sesJqueryObject('.tab_layout_sesmember_profile_compliments').trigger('click');
				}
				sessmoothboxclose();
			}
    }));
    requestSendCompliment.send();	
}
</script>