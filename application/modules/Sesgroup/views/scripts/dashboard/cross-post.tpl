<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: cross-post.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_clearfix sesgroup_dashboard_manage_crossposting">
<?php }	?>
  <div class="sesgroup_dashboard_content_header">
    <h3><?php echo $this->translate('Add Groups to Crosspost'); ?></h3>
    <p><?php echo $this->translate('Crossposting is a way to share status feed across multiple Groups. Crossposting can only happen between Groups that have added each other. You control which status post you want to crosspost.
'); ?></p>
  	<p><?php echo $this->translate('Add or remove Groups here to manage your crossposting relationships.'); ?></p>
	</div>
  <div class="_addgroup_form">
		<span class="_label"><?php echo $this->translate("Add Group");?></span>
    <span class="_input"><input class="sesgroup_input" type="text" name="group" id="sesgroup_group" /></span>
   </div> 
  <div class="_groupslist sesbasic_clearfix">
    <?php foreach($this->crosspost as $crosspost){ 
          $group_id = $this->group->group_id != $crosspost['sender_group_id'] ? $crosspost['sender_group_id'] : $crosspost['receiver_group_id'];
          $group = Engine_Api::_()->getItem('sesgroup_group',$group_id);
          if(!$group)
            continue;
    ?>
    <?php $confirmationlink = $this->absoluteUrl($this->url(array('group_id' => $group->custom_url, 'action'=>'cross-post','id'=>$crosspost['crosspost_id']), 'sesgroup_dashboard', true));?>
    <div class="sesgroup_crosspost_main sesgroup_dashboard_crossposting_item sesbasic_clearfix" data-crosspost="<?php echo $crosspost['crosspost_id']; ?>" data-confirmationlink="<?php echo $confirmationlink; ?>">
      <div class="_thumb">
        <a href="<?php echo $group->getHref(); ?>" target="_blank"><img src="<?php echo $group->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div>
      <div class="_cont">
        <div id="sesgroup_title" class="_title">
          <a href="<?php echo $group->getHref(); ?>" target="_blank"><?php echo $group->getTitle(); ?></a>
        </div>

        <div class="_category sesbasic_text_light">
          <?php $category = Engine_Api::_()->getItem('sesgroup_category',$group->category_id); ?>
          <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this group', '%s people liked this group', $group->like_count), $this->locale()->toNumber($group->like_count)) ?></span>
        </div>
      </div>
      <div class="_options">
        <div class="_msg">
          <?php if($crosspost['receiver_approved'] == 0){ ?>
            <span class="sesbasic_text_light"><?php echo $this->translate("This Group hasn't added yours"); ?></span>
            <a href="javascript:;" class="sesgroup_link sesbasic_button sesgroup_cbtn" title="<?php echo $this->translate('get link'); ?>"><i class="fa fa-link"></i></a>
          <?php } ?>
        </div>
        <div>
        	<a href="javascript:;" class="sesgroup_remove sesbasic_button sesgroup_cbtn"><?php echo $this->translate('remove'); ?></a>
        </div>
      </div>
   	</div>
   <?php } ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  <div class="sesbasic_loading_cont_overlay" id="sesgroup_crosspost_overlay"></div>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<div class="sesgroup_dashboard_manage_crossposting_popup" id="sesgroup_link_popup">
	<div class="_maincont sesgroup_fg_color">
    <div class="_field">
      <textarea id="sesgroup_textarea_val"></textarea>
      <a class="copytoclipboard sesbasic_button" href="javascript:;"><?php echo $this->translate('Copy to Clipboard'); ?></a>
    </div>
    <div class="_footer sesbasic_clearfix">
      <div class="_btns floatR">
        <a class="sesgroup_popup_close sesgroup_button" href="javascript:;"><?php echo $this->translate('close'); ?></a>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($this->crosspostgroup)){ ?>
  <div class="sesgroup_link_popup_crosspost sesgroup_dashboard_manage_crossposting_popup" id="sesgroupsesgroup_link_popup_crosspost_link_popup">
    <div class="_maincont sesgroup_fg_color">
      <div class="_header">
        <?php echo $this->translate("Crosspost With"); ?> <?php echo $this->crosspostgroup->getTitle(); ?>
      </div>
      <div class="_field">
        <div class="sesgroup_dashboard_crossposting_item sesbasic_clearfix">
          <div class="_thumb">
            <img src="<?php echo $this->crosspostgroup->getPhotoUrl('thumb.icon'); ?>" />
          </div>
          <div class="_cont">
            <div class="_title">
              <?php echo $this->crosspostgroup->getTitle(); ?>
            </div>          
            <div class="sesbasic_text_light">
            	<?php $category = Engine_Api::_()->getItem('sesgroup_category',$this->crosspostgroup->category_id); ?>
              <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this group', '%s people liked this group', $this->crosspostgroup->like_count), $this->locale()->toNumber($this->crosspostgroup->like_count)) ?></span>
            </div>      
        	</div>
      	</div>  
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_btns floatR">
        	<a href="javascript:;" class="cancel_crosspost sesbasic_button">cancel</a>
        	<a href="javascript:;" class="approve_crosspost sesgroup_button"><?php echo $this->translate("Add"); ?></a>
        </div>
      </div>
    </div>
  </div>
  <script type="application/javascript">
    sesJqueryObject('#sesgroupsesgroup_link_popup_crosspost_link_popup').show();
  </script>
<?php } ?>
<?php $base_url = $this->layout()->staticBaseUrl;?>
	<?php $this->headScript()
	->appendFile($base_url . 'externals/autocompleter/Observer.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
	?>
<script type="application/javascript">

sesJqueryObject(document).on('click','.approve_crosspost',function(){
   sesJqueryObject('#sesgroup_crosspost_overlay').show();
  var id = <?php echo !empty($this->crosspostgroupid) ? $this->crosspostgroupid : "0"; ?>;
  sesJqueryObject.post('sesgroup/dashboard/approve-cross-post/group_id/<?php echo $this->group->getIdentity(); ?>',{crossgroup:id},function(res){
    if(res != 0){
        sesJqueryObject('#sesgroupsesgroup_link_popup_crosspost_link_popup').hide();
        sesJqueryObject('.sesgroup_dashboard_content').html(res);
        attachTagger();
    }else{
      alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
    }
  })
});
sesJqueryObject(document).on('click','.cancel_crosspost',function(){
  sesJqueryObject('#sesgroupsesgroup_link_popup_crosspost_link_popup').hide();
});
function attachTagger(){
    var groupAdmin = "sesgroup_group";
    var contentAutocomplete1 =  'sesgroup_role_text-'+groupAdmin
		contentAutocomplete1 = new Autocompleter.Request.JSON(groupAdmin, "<?php echo $this->url(array('module' => 'sesgroup', 'controller' => 'dashboard', 'action' => 'cross-post-group', 'group_id' => $this->group->group_id), 'default', true) ?>", {
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
			 submitForm(selected.retrieve('autocompleteChoice').id);
		});
}
    function submitForm(id){
        sesJqueryObject('#sesgroup_crosspost_overlay').show();
        sesJqueryObject.post('sesgroup/dashboard/create-cross-post/group_id/<?php echo $this->group->getIdentity(); ?>',{crossgroup:id},function(res){
          if(res != 0){
              sesJqueryObject('.sesgroup_dashboard_content').html(res);
              attachTagger();
          }else{
            alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
          }
        })
    }
    attachTagger();
 sesJqueryObject(document).on('click','.sesgroup_link',function(){
    sesJqueryObject('#sesgroup_link_popup').show();
  var mainDiv = sesJqueryObject(this).closest('.sesgroup_crosspost_main'); 
  var conLink =  mainDiv.data('confirmationlink');
  sesJqueryObject('#sesgroup_textarea_val').val(conLink);
 })
sesJqueryObject(document).on('click','.copytoclipboard',function(){
  document.getElementById('sesgroup_textarea_val').select();
  // Copy the highlighted text
  document.execCommand("copy");  
});
sesJqueryObject(document).on('click','.sesgroup_popup_close',function(){
  sesJqueryObject('#sesgroup_link_popup').hide();
});
sesJqueryObject(document).on('click','.sesgroup_remove',function(){
  if(confirm("Are you sure want to delete this group?")){
    sesJqueryObject('#sesgroup_link_popup').hide();
    sesJqueryObject('#sesgroup_crosspost_overlay').show();
    var mainDiv = sesJqueryObject(this).closest('.sesgroup_crosspost_main'); 
    var id =  mainDiv.data('crosspost');
     sesJqueryObject.post('sesgroup/dashboard/delete-cross-post/group_id/<?php echo $this->group->getIdentity(); ?>',{crossgroup:id},function(res){
        if(res != 0){
            sesJqueryObject('.sesgroup_dashboard_content').html(res);
            attachTagger();
        }else{
          alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
        }
      })
  }
});
</script>