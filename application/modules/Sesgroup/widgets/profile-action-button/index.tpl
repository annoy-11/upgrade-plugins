<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesgroup_profile_action_button prelative sesbasic_bxs">
    <?php if(Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->viewer(), 'auth_addbutton')):?>
      <a data-id="<?php echo $this->identity; ?>" href="javascript:;" class="sesgroup_button sesgroupcallaction"> <?php echo $this->canEdit ? '<i class="fa fa-plus"></i>' : ""; ?> <?php echo !empty($this->calCall) ? $this->translate($this->calCall) : '<span>'.$this->translate("Add a Button").'</span>'; ?></a>
    <?php endif;?>
	<?php if($this->canEdit && !empty($this->calCall)){ ?>
  <div class="sesbasic_pulldown_options">
		<ul>
      <li><a href="javascript:;" onClick="editCallActionBtn(this);" class="editCallActionBtn"><?php echo $this->translate('Edit Button'); ?></a></li>
      <li class="_sep"></li>
      <li><a href="javascript:;" onClick="deleteCallActionBtn(this);"  class="deleteCallActionBtn"><?php echo $this->translate('Delete Button'); ?></a></li>
		</ul>
  </div>
  <?php } ?>
  <?php 
   if(!empty($this->callAction) && $this->callAction->type == "callnow" && !$this->canEdit){
  ?>
    <div id="sesgroup_call_now" class="_tip">
    	<span></span>
      <p><?php echo $this->subject->getTitle().'<br>'.$this->callAction->params; ?></p>
    </div>
  <?php } ?>
    <a class="sessmoothbox sesgroup_call_btn_a" href="sesgroup/index/call-button/group_id/<?php echo $this->subject->getGuid(); ?>" style="display:none;">call</a>
  <?php if(!empty($this->callAction) && $this->callAction->params != "callnow" && !$this->canEdit){ ?>
    <a id="sesgroup_call_btn_outside_a" href="<?php echo $this->callAction->params; ?>" target="_blank" style="display:none;">call</a>
  <?php } ?>
</div> 
<script type="application/javascript">
function editCallActionBtn(obj){
  sesJqueryObject(obj).closest('.sesgroup_profile_action_button').find('.sesgroupcallaction').trigger('click');
}
function deleteCallActionBtn(obj){
  sesJqueryObject.post('sesgroup/index/remove-callaction/',{page:sesItemSubjectGuid},function(res){
    if(res == 1){
      var id = sesJqueryObject('.sesgroupcallaction').data('id');
       sesJqueryObject.post(en4.core.baseUrl + "widget/index/mod/sesgroup/name/profile-action-button/identity/"+id ,{is_ajax:true,page:sesItemSubjectGuid},function(res){
         if(res){
            sesJqueryObject('.layout_sesgroup_profile_action_button').html(res); 
         }
       });
    }
 });
} 
function sesgroupCallBackActionBtn(){
  <?php if($this->canEdit){ ?>
    sesJqueryObject('.sesgroup_call_btn_a').trigger('click');
  <?php }else if(!empty($this->callAction) && $this->callAction->type == "sendmessage"){ ?>
      var sendMessage = '<?php echo $this->url(array('owner_id' => $this->subject->owner_id,'action'=>'contact'), 'sesgroup_general', true); ?>';
      sesJqueryObject('#sesgroup_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#sesgroup_call_btn_outside_a').addClass('sessmoothbox');
      sesJqueryObject('#sesgroup_call_btn_outside_a').attr('href',sendMessage);
      setTimeout(function(){document.getElementById('sesgroup_call_btn_outside_a').click()},100);
  <?php
    }else if(!empty($this->callAction) && $this->callAction->type == "sendemail"){ ?>
      sesJqueryObject('#sesgroup_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#sesgroup_call_btn_outside_a').attr('href','mailto:<?php echo $this->callAction->params; ?>?Subject=');
      setTimeout(function(){document.getElementById('sesgroup_call_btn_outside_a').click()},100);
  <?php    
  }else if(!empty($this->callAction) && $this->callAction->type == "callnow"){ ?> 
    if(sesJqueryObject('#sesgroup_call_now').hasClass('active')){
        sesJqueryObject('#sesgroup_call_now').removeClass('active');
        sesJqueryObject('#sesgroup_call_now').hide();
      }else{
        sesJqueryObject('#sesgroup_call_now').addClass('active');
        sesJqueryObject('#sesgroup_call_now').show();  
      }
  <?php }else { ?>
    setTimeout(function(){document.getElementById('sesgroup_call_btn_outside_a').click()},100);
  <?php } ?>  
}
</script>
<?php if(!empty($this->is_ajax)){die;} ?>