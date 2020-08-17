<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="eclassroom_profile_action_button prelative sesbasic_bxs">
    <?php if(Engine_Api::_()->authorization()->isAllowed('eclassroom', $this->viewer(), 'auth_addbutton')):?>
      <a data-id="<?php echo $this->identity; ?>" href="javascript:;" class="eclassroom_button eclassroomcallaction"> <?php echo $this->canEdit ? '<i class="fa fa-plus"></i>' : ""; ?> <?php echo !empty($this->calCall) ? $this->translate($this->calCall) : '<span>'.$this->translate("Add a Button").'</span>'; ?></a>
    <?php endif;?>
	<?php  if($this->canEdit && !empty($this->calCall)){ ?>
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
    <div id="eclassroom_call_now" class="_tip">
    	<span></span>
      <p><?php echo $this->subject->getTitle().'<br>'.$this->callAction->params; ?></p>
    </div>
  <?php } ?>
    <a class="sessmoothbox eclassroom_call_btn_a" href="eclassroom/index/call-button/classroom_id/<?php echo $this->subject->getGuid(); ?>" style="display:none;">call</a>
  <?php if(!empty($this->callAction) && $this->callAction->params != "callnow" && !$this->canEdit){ ?>
    <a id="eclassroom_call_btn_outside_a" href="<?php echo $this->callAction->params; ?>" target="_blank" style="display:none;">call</a>
  <?php } ?>
</div> 
<script type="application/javascript">
function editCallActionBtn(obj){
  sesJqueryObject(obj).closest('.eclassroom_profile_action_button').find('.eclassroomcallaction').trigger('click');
}
function deleteCallActionBtn(obj){
  sesJqueryObject.post('eclassroom/index/remove-callaction/',{page:sesItemSubjectGuid},function(res){
    if(res == 1){
      var id = sesJqueryObject('.eclassroomcallaction').data('id');
       sesJqueryObject.post(en4.core.baseUrl + "widget/index/mod/eclassroom/name/profile-action-button/identity/"+id ,{is_ajax:true,page:sesItemSubjectGuid},function(res){
         if(res){
            sesJqueryObject('.layout_eclassroom_profile_action_button').html(res); 
         }
       });
    }
 });
} 
function eclassroomCallBackActionBtn(){
  <?php if($this->canEdit){ ?>
    sesJqueryObject('.eclassroom_call_btn_a').trigger('click');
  <?php }else if(!empty($this->callAction) && $this->callAction->type == "sendmessage"){ ?>
      var sendMessage = '<?php echo $this->url(array('owner_id' => $this->subject->owner_id,'action'=>'contact'), 'eclassroom_general', true); ?>';
      sesJqueryObject('#eclassroom_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#eclassroom_call_btn_outside_a').addClass('sessmoothbox');
      sesJqueryObject('#eclassroom_call_btn_outside_a').attr('href',sendMessage);
      setTimeout(function(){document.getElementById('eclassroom_call_btn_outside_a').click()},100);
  <?php
    }else if(!empty($this->callAction) && $this->callAction->type == "sendemail"){ ?>
      sesJqueryObject('#eclassroom_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#eclassroom_call_btn_outside_a').attr('href','mailto:<?php echo $this->callAction->params; ?>?Subject=');
      setTimeout(function(){document.getElementById('eclassroom_call_btn_outside_a').click()},100);
  <?php    
  }else if(!empty($this->callAction) && $this->callAction->type == "callnow"){ ?> 
    if(sesJqueryObject('#eclassroom_call_now').hasClass('active')){
        sesJqueryObject('#eclassroom_call_now').removeClass('active');
        sesJqueryObject('#eclassroom_call_now').hide();
      }else{
        sesJqueryObject('#eclassroom_call_now').addClass('active');
        sesJqueryObject('#eclassroom_call_now').show();  
      }
  <?php }else { ?>
    setTimeout(function(){document.getElementById('eclassroom_call_btn_outside_a').click()},100);
  <?php } ?>  
}
</script>
<?php if(!empty($this->is_ajax)){die;} ?>
