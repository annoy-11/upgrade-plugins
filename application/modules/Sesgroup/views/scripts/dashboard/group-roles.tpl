<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: group-roles.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $base_url = $this->layout()->staticBaseUrl;?>
	<?php $this->headScript()
	->appendFile($base_url . 'externals/autocompleter/Observer.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
	?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesgroup_dashboard_manage_role">
<?php } ?>
      <div class="sesgroup_dashboard_content_top sesbasic_clearfix">
      	<div class="_left">
          <h3><?php echo $this->translate("Group Roles"); ?></h3>
          <p><?php echo $this->translate("Everyone who works on your Group can have a different role depending on what they need to work on."); ?></p>
      	</div>
        <div class="_img centerT">
          <img src="application/modules/Sesgroup/externals/images/dashboard/role.png" alt="" />
        </div>
      </div>
      <div class="_topsection">
        <div class="_sechead"><?php echo $this->translate("Sections"); ?></div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL sesgroup_ht">
            <?php echo $this->translate("Assign a New Group Role"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="sesgroup_jump sesgroup_ht" data-div="sesgroup_assign_new"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL sesgroup_ht">
            <?php echo $this->translate("Existing Group Roles"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="sesgroup_jump sesgroup_ht" data-div="sesgroup_existing_group"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
      </div>
      <div class="_assignsection">
        <h4 id="sesgroup_assign_new"><?php echo $this->translate("Assign a New Group Role"); ?></h4>
        <div class="_assignform sesbasic_clearfix">
        	<div class="_input">
            <input class="sesgroup_input" type="text" name="username" id="sesgroup_role_text" placeholder="<?php echo $this->translate("Type a name or email"); ?>">
            <a href="javascript:;" class="removeuser fa fa-time" style="display:none;" title="Remove"></a>
          </div>
          <div class="_select">
            <select class="sesgroup_input" name="role" id="sesgroup_role">
              <?php 
                $counter = 0;
                foreach($this->groupRoles as $groupRoles){ ?>
                <option value="<?php echo $groupRoles->getIdentity() ?>" <?php echo $counter == 0 ? 'selected' : '' ?> data-description="<?php echo $this->translate($groupRoles->description ? $groupRoles->description : ""); ?>"><?php echo $this->translate($groupRoles->getTitle()); ?></option>
              <?php $counter++;
                } ?>
            </select>
          </div>
          <div class="_btn">
            <input type="hidden" value="" id="user_id" name="user_id">
            <button id="save_button_admin"  disabled class="sesgroup_cbtn"><?php echo $this->translate("Add"); ?></button>
          </div>
        </div>
         <div id="sesgroup_group_roles_description" class="_des"></div>
      </div>

     
     
     <?php if(count($this->roles)){ ?>
     <?php $groupRolesAdmin = Engine_Api::_()->getDbTable('grouproles','sesgroup')->adminCount(array('group_id'=>$this->group->group_id)); ?>
      <?php $previousRole = 0; ?>
     	<div class="_currentmembers">
      	<h4 id="sesgroup_existing_group"><?php echo $this->translate("Existing Group Roles"); ?></h2>
        <?php foreach($this->roles as $roles){ ?>
          <?php if($previousRole != $roles["memberrole_id"]){  ?>
            <?php $memberRole = Engine_Api::_()->getItem('sesgroup_memberrole',$roles["memberrole_id"]);?>
            <div class="_currentmembers_header">
               <strong><?php echo $memberRole->title; ?></strong>     
               <p><?php echo $memberRole->description ; ?></p>
            </div>
            
            
            
            <?php 
              $previousRole = $roles["memberrole_id"];
            } ?>
            <div class="_currentmembers_item sesbasic_clearfix">
              <?php $user = Engine_Api::_()->getItem('user',$roles['user_id']);?>
              <div class="_thumb">
                <?php echo $this->itemPhoto($user, 'thumb.icon', $user->getTitle()) ?>
              </div>
              <?php if($groupRolesAdmin > 1 || $memberRole->type != 1){ ?>
              <div class="_option">
                <select name="role" data-role="<?php echo $roles['grouprole_id']; ?>" class="sesgroup_input grouprole_already_added">
                  <?php 
                    $counter = 0;
                    foreach($this->groupRoles as $groupRoles){ ?>
                    <option value="<?php echo $groupRoles->getIdentity() ?>" <?php echo $groupRoles->getIdentity() == $roles["memberrole_id"] ? 'selected' : '' ?>><?php echo $this->translate($groupRoles->getTitle()); ?></option>
                  <?php $counter++;
                    } ?>
                </select>
              </div>
              <?php } ?>
              <div class="_cont">
                <span><b><?php echo $user->getTitle(); ?></b></span>
                <span class="sesbasic_text_light"><?php echo $memberRole->title; ?></span>
                 <?php if($groupRolesAdmin > 1 || $memberRole->type != 1){ ?>
                    <span><a href="javascript:;" data-rel="<?php echo $roles['grouprole_id']; ?>" class="sesgroup_role_delete"><?php echo $this->translate("Remove Member"); ?></a></span>
                 <?php } ?>
              </div>
          </div>
        <?php } ?>
     	</h4>   
     <?php } ?>

<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>


<?php if($this->is_ajax) die; ?>
<script type="application/javascript">
var requestSend = false;
function removeUser(){
  if(requestSend)
    return;
  var id = sesJqueryObject(previousElementRemove).data('rel');
  var previousVal = sesJqueryObject('#sesgroup_role').val();
  requestSend = true;
  new Request.HTML({
          url : en4.core.baseUrl + 'sesgroup/dashboard/change-group-admin',
          method: 'post',
          data : {
            format: 'html',
            group_id: <?php echo $this->group->getIdentity(); ?>,
            grouproleid:id,
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            if(responseHTML != 0){
              sesJqueryObject('.sesgroup_dashboard_content').html(responseHTML);
              sesJqueryObject('#sesgroup_role').val(previousVal);
              sesJqueryObject('#sesgroup_role').trigger('change');
              showAutosuggest('sesgroup_role_text');
              Smoothbox.close();
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
            requestSend = false;
          }
        }).send()  
}
  var previousElementRemove;
   sesJqueryObject(document).on('focus','.sesgroup_role_delete', function () {
        // Store the current value on focus and on change
        previousElementRemove = this;
    })
  sesJqueryObject(document).on('click','.sesgroup_role_delete',function(){
      var html = "<div class='global_form_popup sesgroup_dashboard_remove_member_popup'><h3><?php echo $this->translate('Are you sure want to delete this user?'); ?></h3><div><button onclick='removeUser()'>Remove User</button><a href='javascript:;' onclick='closeSmoothbox()'>Cancel</a></div></div>";
      showError(html);
  })
  sesJqueryObject(document).ready(function(){
     sesJqueryObject('#sesgroup_group_roles_description').html(sesJqueryObject('#sesgroup_role').find("option:selected").data('description'));
  })
  sesJqueryObject(document).on('change','#sesgroup_role',function(){
      sesJqueryObject('#sesgroup_group_roles_description').html(sesJqueryObject('#sesgroup_role').find("option:selected").data('description'));
  })
  
 function showAutosuggest(groupAdmin) {
	  var contentAutocomplete1 =  'sesgroup_role_text-'+groupAdmin
	  contentAutocomplete1 = new Autocompleter.Request.JSON(groupAdmin, "<?php echo $this->url(array('module' => 'sesgroup', 'controller' => 'dashboard', 'action' => 'get-members', 'group_id' => $this->group->group_id), 'default', true) ?>", {
			'postVar': 'text',
			'minLength': 1,
			'selectMode': '',
			'autocompleteType': 'tag',
			'customChoices': true,
			'filterSubset': true,
			'maxChoices': 20,
			'cache': false,
			'multiple': false,
			'className': 'sesbasic-autosuggest',
			'indicatorClass':'input_loading',
			'injectChoice': function(token) {
				var choice = new Element('li', {
					'class': 'autocompleter-choices', 
					'html': token.photo, 
					'id':token.label
				});
				new Element('div', {
					'html': this.markQueryValue(token.label),
					'class': 'autocompleter-choice'
				}).inject(choice);
				this.addChoiceEvents(choice).inject(this.choices);
				choice.store('autocompleteChoice', token);
			}
		});
		contentAutocomplete1.addEvent('onSelection', function(element, selected, value, input) {		
			 $('user_id').value = selected.retrieve('autocompleteChoice').id;
       sesJqueryObject('#sesgroup_role_text').attr('readonly','readony');
			sesJqueryObject('#save_button_admin').removeAttr('disabled');
      sesJqueryObject('.removeuser').show();
		});
 }
 sesJqueryObject(document).on('click','.removeuser',function(){
       sesJqueryObject('#sesgroup_role_text').removeAttr('readonly');
       $('user_id').value = "";
       sesJqueryObject('#sesgroup_role_text').val('');
       sesJqueryObject('#save_button_admin').attr('disabled','disabled');
       sesJqueryObject(this).hide();
 })
	en4.core.runonce.add(function() {
	  showAutosuggest('sesgroup_role_text');
	});
  sesJqueryObject(document).on('click','#save_button_admin',function(){
    if($('user_id').value == "" || typeof sesJqueryObject('#sesgroup_role').val() == "undefined" || sesJqueryObject('#sesgroup_role').val() == ""){
      return;  
    }
    new Request.HTML({
			url : en4.core.baseUrl + 'sesgroup/dashboard/add-group-admin',
			method: 'post',
			data : {
				format: 'html',
				user_id: $('user_id').value ,
				group_id: <?php echo $this->group->getIdentity(); ?>,
        roleId:sesJqueryObject('#sesgroup_role').val(),
				is_ajax: 1,
			},
			onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        if(responseHTML != 0){
				  sesJqueryObject('.sesgroup_dashboard_content').html(responseHTML);
          showAutosuggest('sesgroup_role_text');
        }else{
          alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
        }
			}
		}).send()
  });
  var requestSendChange = false;
  function changeRole(){
    if(requestSendChange)
      return;
    var previousVal = sesJqueryObject('#sesgroup_role').val();
    requestSendChange = true;
        Smoothbox.close();
        new Request.HTML({
          url : en4.core.baseUrl + 'sesgroup/dashboard/change-group-admin',
          method: 'post',
          data : {
            format: 'html',
            group_id: <?php echo $this->group->getIdentity(); ?>,
            roleId:sesJqueryObject(previousElement).val(),
            grouprole_id:sesJqueryObject(previousElement).data('role'),
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            requestSendChange = false;
            if(responseHTML != 0){
              sesJqueryObject('.sesgroup_dashboard_content').html(responseHTML);
              sesJqueryObject('#sesgroup_role').val(previousVal);
              sesJqueryObject('#sesgroup_role').trigger('change');
              showAutosuggest('sesgroup_role_text');
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
          }
        }).send()  
  }
  var previousValue;
  var previousElement;
   sesJqueryObject(document).on('focus','.grouprole_already_added', function () {
        // Store the current value on focus and on change
        previousValue = this.value;
        previousElement = this;
    })
  sesJqueryObject(document).on('change','.grouprole_already_added',function(){
    var newrole = sesJqueryObject(this).find("option:selected").text();
    var text = sesJqueryObject('#sesgroup_role option[value="' + sesJqueryObject(this).val() + '"]').attr('data-description');
    var html = "<div><?php echo $this->translate('Are you sure want to change the role of this user?'); ?></div><div>"+newrole+": "+text+"</div><div><button onclick='changeRole()'>Change Role</button><button onclick='closeSmoothbox()'>Cancel</button></div>";
    showError(html);
  });
  function closeSmoothbox(){
    sesJqueryObject(previousElement).val(previousValue);
    Smoothbox.close();
  }
  sesJqueryObject(document).on('click','.sesgroup_jump',function(){
    var id = sesJqueryObject(this).data('div'); 
      sesJqueryObject('html, body').animate({
        scrollTop: sesJqueryObject('#'+id).offset().top - 50
    	 }, 1000); 
  });
  function showError(html){
    en4.core.showError(html);
  }
  
</script>
