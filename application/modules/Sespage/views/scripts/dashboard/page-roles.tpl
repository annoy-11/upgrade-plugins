<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: page-roles.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
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
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sespage_dashboard_manage_role">
<?php } ?>
      <div class="sespage_dashboard_content_top sesbasic_clearfix">
      	<div class="_left">
          <h3><?php echo $this->translate("Page Roles"); ?></h3>
          <p><?php echo $this->translate("Everyone who works on your Page can have a different role depending on what they need to work on."); ?></p>
      	</div>
        <div class="_img centerT">
          <img src="application/modules/Sespage/externals/images/dashboard/role.png" alt="" />
        </div>
      </div>
      <div class="_topsection">
        <div class="_sechead"><?php echo $this->translate("Sections"); ?></div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL sespage_ht">
            <?php echo $this->translate("Assign a New Page Role"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="sespage_jump sespage_ht" data-div="sespage_assign_new"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
        <div class="_secitem sesbasic_clearfix">
          <span class="floatL sespage_ht">
            <?php echo $this->translate("Existing Page Roles"); ?>
          </span>
          <span class="floatR">
            <a href="javascript:;" class="sespage_jump sespage_ht" data-div="sespage_existing_page"><?php echo $this->translate("Jump to Section"); ?></a>
          </span>
        </div>
      </div>
      <div class="_assignsection">
        <h4 id="sespage_assign_new"><?php echo $this->translate("Assign a New Page Role"); ?></h4>
        <div class="_assignform sesbasic_clearfix">
        	<div class="_input">
            <input class="sespage_input" type="text" name="username" id="sespage_role_text" placeholder="<?php echo $this->translate("Type a name or email"); ?>">
            <a href="javascript:;" class="removeuser fa fa-time" style="display:none;" title="Remove"></a>
          </div>
          <div class="_select">
            <select class="sespage_input" name="role" id="sespage_role">
              <?php 
                $counter = 0;
                foreach($this->pageRoles as $pageRoles){ ?>
                <option value="<?php echo $pageRoles->getIdentity() ?>" <?php echo $counter == 0 ? 'selected' : '' ?> data-description="<?php echo $this->translate($pageRoles->description ? $pageRoles->description : ""); ?>"><?php echo $this->translate($pageRoles->getTitle()); ?></option>
              <?php $counter++;
                } ?>
            </select>
          </div>
          <div class="_btn">
            <input type="hidden" value="" id="user_id" name="user_id">
            <button id="save_button_admin"  disabled class="sespage_cbtn"><?php echo $this->translate("Add"); ?></button>
          </div>
        </div>
         <div id="sespage_page_roles_description" class="_des"></div>
      </div>

     
     
     <?php if(count($this->roles)){ ?>
     <?php $pageRolesAdmin = Engine_Api::_()->getDbTable('pageroles','sespage')->adminCount(array('page_id'=>$this->page->page_id)); ?>
      <?php $previousRole = 0; ?>
     	<div class="_currentmembers">
      	<h4 id="sespage_existing_page"><?php echo $this->translate("Existing Page Roles"); ?></h2>
        <?php foreach($this->roles as $roles){ ?>
          <?php if($previousRole != $roles["memberrole_id"]){  ?>
            <?php $memberRole = Engine_Api::_()->getItem('sespage_memberrole',$roles["memberrole_id"]);?>
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
              <?php if($pageRolesAdmin > 1 || $memberRole->type != 1){ ?>
              <div class="_option">
                <select name="role" data-role="<?php echo $roles['pagerole_id']; ?>" class="sespage_input pagerole_already_added">
                  <?php 
                    $counter = 0;
                    foreach($this->pageRoles as $pageRoles){ ?>
                    <option value="<?php echo $pageRoles->getIdentity() ?>" <?php echo $pageRoles->getIdentity() == $roles["memberrole_id"] ? 'selected' : '' ?>><?php echo $this->translate($pageRoles->getTitle()); ?></option>
                  <?php $counter++;
                    } ?>
                </select>
              </div>
              <?php } ?>
              <div class="_cont">
                <span><b><?php echo $user->getTitle(); ?></b></span>
                <span class="sesbasic_text_light"><?php echo $memberRole->title; ?></span>
                 <?php if($pageRolesAdmin > 1 || $memberRole->type != 1){ ?>
                    <span><a href="javascript:;" data-rel="<?php echo $roles['pagerole_id']; ?>" class="sespage_role_delete"><?php echo $this->translate("Remove Member"); ?></a></span>
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
  var previousVal = sesJqueryObject('#sespage_role').val();
  requestSend = true;
  new Request.HTML({
          url : en4.core.baseUrl + 'sespage/dashboard/change-page-admin',
          method: 'post',
          data : {
            format: 'html',
            page_id: <?php echo $this->page->getIdentity(); ?>,
            pageroleid:id,
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            if(responseHTML != 0){
              sesJqueryObject('.sespage_dashboard_content').html(responseHTML);
              sesJqueryObject('#sespage_role').val(previousVal);
              sesJqueryObject('#sespage_role').trigger('change');
              showAutosuggest('sespage_role_text');
              Smoothbox.close();
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
            requestSend = false;
          }
        }).send()  
}
  var previousElementRemove;
   sesJqueryObject(document).on('focus','.sespage_role_delete', function () {
        // Store the current value on focus and on change
        previousElementRemove = this;
    })
  sesJqueryObject(document).on('click','.sespage_role_delete',function(){
      var html = "<div class='global_form_popup sespage_dashboard_remove_member_popup'><h3><?php echo $this->translate('Are you sure want to delete this user?'); ?></h3><div><button onclick='removeUser()'>Remove User</button><a href='javascript:;' onclick='closeSmoothbox()'>Cancel</a></div></div>";
      showError(html);
  })
  sesJqueryObject(document).ready(function(){
     sesJqueryObject('#sespage_page_roles_description').html(sesJqueryObject('#sespage_role').find("option:selected").data('description'));
  })
  sesJqueryObject(document).on('change','#sespage_role',function(){
      sesJqueryObject('#sespage_page_roles_description').html(sesJqueryObject('#sespage_role').find("option:selected").data('description'));
  })
  
 function showAutosuggest(pageAdmin) {
	  var contentAutocomplete1 =  'sespage_role_text-'+pageAdmin
	  contentAutocomplete1 = new Autocompleter.Request.JSON(pageAdmin, "<?php echo $this->url(array('module' => 'sespage', 'controller' => 'dashboard', 'action' => 'get-members', 'page_id' => $this->page->page_id), 'default', true) ?>", {
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
       sesJqueryObject('#sespage_role_text').attr('readonly','readony');
			sesJqueryObject('#save_button_admin').removeAttr('disabled');
      sesJqueryObject('.removeuser').show();
		});
 }
 sesJqueryObject(document).on('click','.removeuser',function(){
       sesJqueryObject('#sespage_role_text').removeAttr('readonly');
       $('user_id').value = "";
       sesJqueryObject('#sespage_role_text').val('');
       sesJqueryObject('#save_button_admin').attr('disabled','disabled');
       sesJqueryObject(this).hide();
 })
	en4.core.runonce.add(function() {
	  showAutosuggest('sespage_role_text');
	});
  sesJqueryObject(document).on('click','#save_button_admin',function(){
    if($('user_id').value == "" || typeof sesJqueryObject('#sespage_role').val() == "undefined" || sesJqueryObject('#sespage_role').val() == ""){
      return;  
    }
    new Request.HTML({
			url : en4.core.baseUrl + 'sespage/dashboard/add-page-admin',
			method: 'post',
			data : {
				format: 'html',
				user_id: $('user_id').value ,
				page_id: <?php echo $this->page->getIdentity(); ?>,
        roleId:sesJqueryObject('#sespage_role').val(),
				is_ajax: 1,
			},
			onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        if(responseHTML != 0){
				  sesJqueryObject('.sespage_dashboard_content').html(responseHTML);
          showAutosuggest('sespage_role_text');
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
    var previousVal = sesJqueryObject('#sespage_role').val();
    requestSendChange = true;
        Smoothbox.close();
        new Request.HTML({
          url : en4.core.baseUrl + 'sespage/dashboard/change-page-admin',
          method: 'post',
          data : {
            format: 'html',
            page_id: <?php echo $this->page->getIdentity(); ?>,
            roleId:sesJqueryObject(previousElement).val(),
            pagerole_id:sesJqueryObject(previousElement).data('role'),
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            requestSendChange = false;
            if(responseHTML != 0){
              sesJqueryObject('.sespage_dashboard_content').html(responseHTML);
              sesJqueryObject('#sespage_role').val(previousVal);
              sesJqueryObject('#sespage_role').trigger('change');
              showAutosuggest('sespage_role_text');
            }else{
              alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');  
            }
          }
        }).send()  
  }
  var previousValue;
  var previousElement;
   sesJqueryObject(document).on('focus','.pagerole_already_added', function () {
        // Store the current value on focus and on change
        previousValue = this.value;
        previousElement = this;
    })
  sesJqueryObject(document).on('change','.pagerole_already_added',function(){
    var newrole = sesJqueryObject(this).find("option:selected").text();
    var text = sesJqueryObject('#sespage_role option[value="' + sesJqueryObject(this).val() + '"]').attr('data-description');
    var html = "<div><?php echo $this->translate('Are you sure want to change the role of this user?'); ?></div><div>"+newrole+": "+text+"</div><div><button onclick='changeRole()'>Change Role</button><button onclick='closeSmoothbox()'>Cancel</button></div>";
    showError(html);
  });
  function closeSmoothbox(){
    sesJqueryObject(previousElement).val(previousValue);
    Smoothbox.close();
  }
  sesJqueryObject(document).on('click','.sespage_jump',function(){
    var id = sesJqueryObject(this).data('div'); 
      sesJqueryObject('html, body').animate({
        scrollTop: sesJqueryObject('#'+id).offset().top - 50
    	 }, 1000); 
  });
  function showError(html){
    en4.core.showError(html);
  }
  
</script>
