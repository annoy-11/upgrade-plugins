<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: classroom-roles.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
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
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs classroom_dashboard_manage_role">
<?php } ?>
      <div class="classroom_dashboard_content_header sesbasic_clearfix">
      	<div class="_left">
          <h3><?php echo $this->translate("Classroom Roles"); ?></h3>
          <p><?php echo $this->translate("Everyone who works on your Classroom can have a different role depending on what they need to work on."); ?></p>
      	</div>
        <div class="_img centerT">
          <img src="application/modules/Courses/externals/images/dashboard/role.png" alt="" />
        </div>
      </div>
      <div class="_topsection">
        <div class="_sechead"><?php echo $this->translate("Sections"); ?></div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL classroom_ht">
            <?php echo $this->translate("Assign a New Classroom Role"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="classroom_jump classroom_ht" data-div="classroom_assign_new"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL classroom_ht">
            <?php echo $this->translate("Existing Classroom Roles"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="classroom_jump classroom_ht" data-div="classroom_existing_classroom"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
      </div>
      <div class="_assignsection">
        <h4 id="classroom_assign_new"><?php echo $this->translate("Assign a New Classroom Role"); ?></h4>
        <div class="_assignform sesbasic_clearfix">
        	<div class="_input">
            <input class="classroom_input" type="text" name="username" id="classroom_role_text" placeholder="<?php echo $this->translate("Type a name or email"); ?>">
            <a href="javascript:;" class="removeuser fa fa-time" style="display:none;" title="Remove"></a>
          </div>
          <div class="_select">
            <select class="classroom_input" name="role" id="classroom_role">
              <?php 
                $counter = 0;
                foreach($this->classroomRoles as $classroomRoles){ ?>
                <option value="<?php echo $classroomRoles->getIdentity() ?>" <?php echo $counter == 0 ? 'selected' : '' ?> data-description="<?php echo $this->translate($classroomRoles->description ? $classroomRoles->description : ""); ?>"><?php echo $this->translate($classroomRoles->getTitle()); ?></option>
              <?php $counter++;
                } ?>
            </select>
          </div>
          <div class="_btn">
            <input type="hidden" value="" id="user_id" name="user_id">
            <button id="save_button_admin"  disabled class="classroom_cbtn"><?php echo $this->translate("Add"); ?></button>
          </div>
        </div>
         <div id="courses_classroom_roles_description" class="_des"></div>
      </div>
     <?php if(count($this->roles)){ ?>
     <?php $classroomRolesAdmin = Engine_Api::_()->getDbTable('classroomroles','eclassroom')->adminCount(array('classroom_id'=>$this->classroom->classroom_id)); ?>
      <?php $previousRole = 0; ?>
     	<div class="_currentmembers">
      	<h4 id="classroom_existing_classroom"><?php echo $this->translate("Existing Classroom Roles"); ?></h2>
        <?php foreach($this->roles as $roles){ ?>
          <?php if($previousRole != $roles["memberrole_id"]){  ?>
            <?php $memberRole = Engine_Api::_()->getItem('eclassroom_memberrole',$roles["memberrole_id"]);?>
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
              <?php if($classroomRolesAdmin > 1 || $memberRole->type != 1){ ?>
              <div class="_option">
                <select name="role" data-role="<?php echo $roles['classroomrole_id']; ?>" class="classroom_input classroomrole_already_added">
                  <?php 
                    $counter = 0;
                    foreach($this->classroomRoles as $classroomRoles){ ?>
                    <option value="<?php echo $classroomRoles->getIdentity() ?>" <?php echo $classroomRoles->getIdentity() == $roles["memberrole_id"] ? 'selected' : '' ?>><?php echo $this->translate($classroomRoles->getTitle()); ?></option>
                  <?php $counter++;
                    } ?>
                </select>
              </div>
              <?php } ?>
              <div class="_cont">
                <span><b><?php echo $user->getTitle(); ?></b></span>
                <span class="sesbasic_text_light"><?php echo $memberRole->title; ?></span>
                 <?php if($classroomRolesAdmin > 1 || $memberRole->type != 1){ ?>
                    <span><a href="javascript:;" data-rel="<?php echo $roles['classroomrole_id']; ?>" class="classroom_role_delete"><?php echo $this->translate("Remove Member"); ?></a></span>
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
  var previousVal = sesJqueryObject('#classroom_role').val();
  requestSend = true;
  new Request.HTML({
          url : en4.core.baseUrl + 'eclassroom/dashboard/change-classroom-admin',
          method: 'post',
          data : {
            format: 'html',
            classroom_id: <?php echo $this->classroom->getIdentity(); ?>,
            classroomroleid:id,
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            if(responseHTML != 0){
              sesJqueryObject('.classroom_dashboard_content').html(responseHTML);
              sesJqueryObject('#classroom_role').val(previousVal);
              sesJqueryObject('#classroom_role').trigger('change');
              showAutosuggest('classroom_role_text');
              Smoothbox.close();
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
            requestSend = false;
          }
        }).send()  
}
  var previousElementRemove;
   sesJqueryObject(document).on('focus','.classroom_role_delete', function () {
        // Classroom the current value on focus and on change
        previousElementRemove = this;
    })
  sesJqueryObject(document).on('click','.classroom_role_delete',function(){
      var html = "<div class='global_form_popup classroom_dashboard_remove_member_popup'><h3><?php echo $this->translate('Are you sure want to delete this user?'); ?></h3><div><button onclick='removeUser()'>Remove User</button><a href='javascript:;' onclick='closeSmoothbox()'>Cancel</a></div></div>";
      showError(html);
  })
  sesJqueryObject(document).ready(function(){
     sesJqueryObject('#courses_classroom_roles_description').html(sesJqueryObject('#classroom_role').find("option:selected").data('description'));
  })
  sesJqueryObject(document).on('change','#classroom_role',function(){
      sesJqueryObject('#courses_classroom_roles_description').html(sesJqueryObject('#classroom_role').find("option:selected").data('description'));
  })
  
 function showAutosuggest(classroomAdmin) {
	  var contentAutocomplete1 =  'classroom_role_text-'+classroomAdmin
	  contentAutocomplete1 = new Autocompleter.Request.JSON(classroomAdmin, "<?php echo $this->url(array('module' => 'eclassroom', 'controller' => 'dashboard', 'action' => 'get-members', 'classroom_id' => $this->classroom->classroom_id), 'default', true) ?>", {
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
       sesJqueryObject('#classroom_role_text').attr('readonly','readony');
			sesJqueryObject('#save_button_admin').removeAttr('disabled');
      sesJqueryObject('.removeuser').show();
		});
 }
 sesJqueryObject(document).on('click','.removeuser',function(){
       sesJqueryObject('#classroom_role_text').removeAttr('readonly');
       $('user_id').value = "";
       sesJqueryObject('#classroom_role_text').val('');
       sesJqueryObject('#save_button_admin').attr('disabled','disabled');
       sesJqueryObject(this).hide();
 })
	en4.core.runonce.add(function() {
	  showAutosuggest('classroom_role_text');
	});
  sesJqueryObject(document).on('click','#save_button_admin',function(){
    if($('user_id').value == "" || typeof sesJqueryObject('#classroom_role').val() == "undefined" || sesJqueryObject('#classroom_role').val() == ""){
      return;  
    }
    new Request.HTML({
			url : en4.core.baseUrl + 'eclassroom/dashboard/add-classroom-admin',
			method: 'post',
			data : {
				format: 'html',
				user_id: $('user_id').value ,
				classroom_id: <?php echo $this->classroom->getIdentity(); ?>,
        roleId:sesJqueryObject('#classroom_role').val(),
				is_ajax: 1,
			},
			onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        if(responseHTML != 0){
				  sesJqueryObject('.classroom_dashboard_content').html(responseHTML);
          showAutosuggest('classroom_role_text');
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
    var previousVal = sesJqueryObject('#classroom_role').val();
    requestSendChange = true;
        Smoothbox.close();
        new Request.HTML({
          url : en4.core.baseUrl + 'eclassroom/dashboard/change-classroom-admin',
          method: 'post',
          data : {
            format: 'html',
            classroom_id: <?php echo $this->classroom->getIdentity(); ?>,
            roleId:sesJqueryObject(previousElement).val(),
            classroomrole_id:sesJqueryObject(previousElement).data('role'),
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            requestSendChange = false;
            if(responseHTML != 0){
              sesJqueryObject('.classroom_dashboard_content').html(responseHTML);
              sesJqueryObject('#classroom_role').val(previousVal);
              sesJqueryObject('#classroom_role').trigger('change');
              showAutosuggest('classroom_role_text');
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
          }
        }).send()  
  }
  var previousValue;
  var previousElement;
   sesJqueryObject(document).on('focus','.classroomrole_already_added', function () {
        // Classroom the current value on focus and on change
        previousValue = this.value;
        previousElement = this;
    })
  sesJqueryObject(document).on('change','.classroomrole_already_added',function(){
    var newrole = sesJqueryObject(this).find("option:selected").text();
    var text = sesJqueryObject('#classroom_role option[value="' + sesJqueryObject(this).val() + '"]').attr('data-description');
    var html = "<div><h3><b><?php echo $this->translate('Are you sure want to change the role of this user?'); ?></b></h3></div><div><p>"+newrole+": "+text+"</p></div><br/><div><button onclick='changeRole()'>Change Role</button> &nbsp; <button onclick='closeSmoothbox()'>Cancel</button></div>";
    showError(html);
  });
  function closeSmoothbox(){
    sesJqueryObject(previousElement).val(previousValue);
    Smoothbox.close();
  }
  sesJqueryObject(document).on('click','.classroom_jump',function(){
    var id = sesJqueryObject(this).data('div');  console.log(id);
      sesJqueryObject('html, body').animate({
        scrollTop: sesJqueryObject('#'+id).offset().top - 50
    	 }, 1000); 
  });
  function showError(html){
    en4.core.showError(html);
  }
</script>
