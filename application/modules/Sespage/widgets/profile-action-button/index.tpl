<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 $allowed = false;
 if (SESPAGEPACKAGE == 1) {
    if (isset($this->subject)) {
      $package = Engine_Api::_()->getItem('sespagepackage_package', $this->subject->package_id);
    }
    if (!isset($package)) {
      $packageId = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
      $package = Engine_Api::_()->getItem('sespagepackage_package', $packageId);
    }
    $params = json_decode($package->params, true);
  }
  if(isset($params)){
    if (!empty($params['auth_insightrpt'])) {
       $allowed = true;
    }
  }else{
  if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->viewer(), 'auth_addbutton'))
    $allowed = true;
  }
 
?>
<div class="sespage_profile_action_button prelative sesbasic_bxs">
    <?php if($allowed):?>
      <a data-id="<?php echo $this->identity; ?>" href="javascript:;" class="sespage_button sespagecallaction"> <?php echo $this->canEdit ? '<i class="fa fa-plus"></i>' : ""; ?> <?php echo !empty($this->calCall) ? $this->translate($this->calCall) : '<span>'.$this->translate("Add a Button").'</span>'; ?></a>
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
    <div id="sespage_call_now" class="_tip">
    	<span></span>
      <p><?php echo $this->subject->getTitle().'<br>'.$this->callAction->params; ?></p>
    </div>
  <?php } ?>
    <a class="sessmoothbox sespage_call_btn_a" href="sespage/index/call-button/page_id/<?php echo $this->subject->getGuid(); ?>" style="display:none;">call</a>
  <?php if(!empty($this->callAction) && $this->callAction->params != "callnow" && !$this->canEdit){ ?>
    <a id="sespage_call_btn_outside_a" href="<?php echo $this->callAction->params; ?>" target="_blank" style="display:none;">call</a>
  <?php } ?>
</div> 
<script type="application/javascript">
function editCallActionBtn(obj){
  sesJqueryObject(obj).closest('.sespage_profile_action_button').find('.sespagecallaction').trigger('click');
}
function deleteCallActionBtn(obj){
  sesJqueryObject.post('sespage/index/remove-callaction/',{page:sesItemSubjectGuid},function(res){
    if(res == 1){
      var id = sesJqueryObject('.sespagecallaction').data('id');
       sesJqueryObject.post(en4.core.baseUrl + "widget/index/mod/sespage/name/profile-action-button/identity/"+id ,{is_ajax:true,page:sesItemSubjectGuid},function(res){
         if(res){
            sesJqueryObject('.layout_sespage_profile_action_button').html(res); 
         }
       });
    }
 });
} 
function sespageCallBackActionBtn(){
  <?php if($this->canEdit){ ?>
    sesJqueryObject('.sespage_call_btn_a').trigger('click');
  <?php }else if(!empty($this->callAction) && $this->callAction->type == "sendmessage"){ ?>
      var sendMessage = '<?php echo $this->url(array('owner_id' => $this->subject->owner_id,'action'=>'contact'), 'sespage_general', true); ?>';
      sesJqueryObject('#sespage_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#sespage_call_btn_outside_a').addClass('sessmoothbox');
      sesJqueryObject('#sespage_call_btn_outside_a').attr('href',sendMessage);
      setTimeout(function(){document.getElementById('sespage_call_btn_outside_a').click()},100);
  <?php
    }else if(!empty($this->callAction) && $this->callAction->type == "sendemail"){ ?>
      sesJqueryObject('#sespage_call_btn_outside_a').removeAttr('target');
      sesJqueryObject('#sespage_call_btn_outside_a').attr('href','mailto:<?php echo $this->callAction->params; ?>?Subject=');
      setTimeout(function(){document.getElementById('sespage_call_btn_outside_a').click()},100);
  <?php    
  }else if(!empty($this->callAction) && $this->callAction->type == "callnow"){ ?> 
    if(sesJqueryObject('#sespage_call_now').hasClass('active')){
        sesJqueryObject('#sespage_call_now').removeClass('active');
        sesJqueryObject('#sespage_call_now').hide();
      }else{
        sesJqueryObject('#sespage_call_now').addClass('active');
        sesJqueryObject('#sespage_call_now').show();  
      }
  <?php }else { ?>
    setTimeout(function(){document.getElementById('sespage_call_btn_outside_a').click()},100);
  <?php } ?>  
}
</script>
<?php if(!empty($this->is_ajax)){die;} ?>