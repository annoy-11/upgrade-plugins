<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-compliment.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmember_comp_popup sesbasic_bxs sesbasic_clearfix">
 <div class="sesmember_comp_popup_header"><?php echo $this->translate('Edit Your Compliment Type');?></div>
  <form action="" id="myform">
    <div class="sesmember_comp_popup_cont sesbasic_clearfix">
      <ul class="sesmember_comp_popup_cont_fields_wrapper sesbasic_clearfix">
      <?php 
      $counter = 1;
      foreach($this->complements as $com){ ?>
      	<?php
        if ($com->file_id) {
          $img_path = Engine_Api::_()->storage()->get($com->file_id, '')->getPhotoUrl();
          if(strpos($img_path,'http') === FALSE)
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
         else
          $path = $img_path;
       } ?>
        <li>
        	
          <input type="radio"  id="sescom_<?php echo $com->getIdentity(); ?>"  name="typeName" value="<?php echo $com->getIdentity(); ?>" <?php if($this->compliment->type == $com->compliment_id){ echo 'checked="checked"' ;  } ?> />
          <label for="sescom_<?php echo $com->getIdentity(); ?>">
          <img src="<?php echo $path; ?>" /><span class=""><?php echo $com->title; ?></span></label>
        </li>
       <?php $counter++;
       	} ?>
      </ul>
      <div class="sesmember_comp_popup_cont_text">
        <textarea id="compliment_description"><?php echo $this->compliment->description; ?></textarea>
      </div>
    </div>
   <div class="sesbasic_loading_cont_overlay" id="sesmember_widget_overlay_compliment"></div>
 </form>
  <div class="sesmember_comp_popup_footer">
   <button onclick="submitCompliment()"><?php echo $this->translate('Send');?></button>&nbsp;&nbsp;
    <a onclick="javascript:sessmoothboxclose();" href="javascript:;"><?php echo $this->translate('Cancel');?></a>
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
      'url':  "sesmember/index/editsave-compliment/compliment_id/<?php echo $this->compliment_id; ?>",
      'data': {
			format: 'html',
			type:type,
			params:paramssesmember_compliment,
			description:description
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('#sesmember_widget_overlay_compliment').hide();
				sesJqueryObject('#sesmember_compliment').find('.tip').remove();
				sesJqueryObject('#sesmember_compliment_<?php echo $this->compliment_id; ?>').html(responseHTML);
				sessmoothboxclose();
			}
    }));
    requestSendCompliment.send();	
}
</script>