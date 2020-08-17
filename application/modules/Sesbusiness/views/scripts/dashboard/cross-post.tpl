<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: cross-post.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array(
	'business' => $this->business,
      ));	
?>
	<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix sesbasic_clearfix sesbusiness_dashboard_manage_crossposting">
<?php }	?>
  <div class="sesbusiness_dashboard_content_header">
    <h3><?php echo $this->translate('Add Businesses to Crosspost'); ?></h3>
    <p><?php echo $this->translate('Crossposting is a way to share status feed across multiple Businesses. Crossposting can only happen between Businesses that have added each other. You control which status post you want to crosspost.
'); ?></p>
  	<p><?php echo $this->translate('Add or remove Businesses here to manage your crossposting relationships.'); ?></p>
	</div>
  <div class="_addbusiness_form">
		<span class="_label"><?php echo $this->translate("Add Business");?></span>
    <span class="_input"><input class="sesbusiness_input" type="text" name="business" id="business" /></span>
   </div> 
  <div class="_businesseslist sesbasic_clearfix">
    <?php foreach($this->crosspost as $crosspost){ 
          $business_id = $this->business->business_id != $crosspost['sender_business_id'] ? $crosspost['sender_business_id'] : $crosspost['receiver_business_id'];
          $business = Engine_Api::_()->getItem('businesses',$business_id);
          if(!$business)
            continue;
    ?>
    <?php $confirmationlink = $this->absoluteUrl($this->url(array('business_id' => $business->custom_url, 'action'=>'cross-post','id'=>$crosspost['crosspost_id']), 'sesbusiness_dashboard', true));?>
    <div class="sesbusiness_crosspost_main sesbusiness_dashboard_crossposting_item sesbasic_clearfix" data-crosspost="<?php echo $crosspost['crosspost_id']; ?>" data-confirmationlink="<?php echo $confirmationlink; ?>">
      <div class="_thumb">
        <a href="<?php echo $business->getHref(); ?>" target="_blank"><img src="<?php echo $business->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div>
      <div class="_cont">
        <div id="sesbusiness_title" class="_title">
          <a href="<?php echo $business->getHref(); ?>" target="_blank"><?php echo $business->getTitle(); ?></a>
        </div>

        <div class="_category sesbasic_text_light">
          <?php $category = Engine_Api::_()->getItem('sesbusiness_category',$business->category_id); ?>
          <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this business', '%s people liked this business', $business->like_count), $this->locale()->toNumber($business->like_count)) ?></span>
        </div>
      </div>
      <div class="_options">
        <div class="_msg">
          <?php if($crosspost['receiver_approved'] == 0){ ?>
            <span class="sesbasic_text_light"><?php echo $this->translate("This Business hasn't added yours"); ?></span>
            <a href="javascript:;" class="sesbusiness_link sesbasic_button sesbusiness_cbtn" title="<?php echo $this->translate('get link'); ?>"><i class="fa fa-link"></i></a>
          <?php } ?>
        </div>
        <div>
        	<a href="javascript:;" class="sesbusiness_remove sesbasic_button sesbusiness_cbtn"><?php echo $this->translate('remove'); ?></a>
        </div>
      </div>
   	</div>
   <?php } ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  <div class="sesbasic_loading_cont_overlay" id="sesbusiness_crosspost_overlay"></div>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<div class="sesbusiness_dashboard_manage_crossposting_popup" id="sesbusiness_link_popup">
	<div class="_maincont sesbusiness_fg_color">
    <div class="_field">
      <textarea id="sesbusiness_textarea_val"></textarea>
      <a class="copytoclipboard sesbasic_button" href="javascript:;"><?php echo $this->translate('Copy to Clipboard'); ?></a>
    </div>
    <div class="_footer sesbasic_clearfix">
      <div class="_btns floatR">
        <a class="sesbusiness_popup_close sesbusiness_button" href="javascript:;"><?php echo $this->translate('close'); ?></a>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($this->crosspostbusiness)){ ?>
  <div class="sesbusiness_link_popup_crosspost sesbusiness_dashboard_manage_crossposting_popup" id="sesbusinessesesbusiness_link_popup_crosspost_link_popup">
    <div class="_maincont sesbusiness_fg_color">
      <div class="_header">
        <?php echo $this->translate("Crosspost With"); ?> <?php echo $this->crosspostbusiness->getTitle(); ?>
      </div>
      <div class="_field">
        <div class="sesbusiness_dashboard_crossposting_item sesbasic_clearfix">
          <div class="_thumb">
            <img src="<?php echo $this->crosspostbusiness->getPhotoUrl('thumb.icon'); ?>" />
          </div>
          <div class="_cont">
            <div class="_title">
              <?php echo $this->crosspostbusiness->getTitle(); ?>
            </div>          
            <div class="sesbasic_text_light">
            	<?php $category = Engine_Api::_()->getItem('sesbusiness_category',$this->crosspostbusiness->category_id); ?>
              <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this business', '%s people liked this business', $this->crosspostbusiness->like_count), $this->locale()->toNumber($this->crosspostbusiness->like_count)) ?></span>
            </div>      
        	</div>
      	</div>  
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_btns floatR">
        	<a href="javascript:;" class="cancel_crosspost sesbasic_button">cancel</a>
        	<a href="javascript:;" class="approve_crosspost sesbusiness_button"><?php echo $this->translate("Add"); ?></a>
        </div>
      </div>
    </div>
  </div>
  <script type="application/javascript">
    sesJqueryObject('#sesbusinessesesbusiness_link_popup_crosspost_link_popup').show();
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
   sesJqueryObject('#sesbusiness_crosspost_overlay').show();
  var id = <?php echo !empty($this->crosspostbusinessid) ? $this->crosspostbusinessid : "0"; ?>;
  sesJqueryObject.post('sesbusiness/dashboard/approve-cross-post/business_id/<?php echo $this->business->getIdentity(); ?>',{crossbusiness:id},function(res){
    if(res != 0){
        sesJqueryObject('#sesbusinessesesbusiness_link_popup_crosspost_link_popup').hide();
        sesJqueryObject('.sesbusiness_dashboard_content').html(res);
        attachTagger();
    }else{
      alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
    }
  })
});
sesJqueryObject(document).on('click','.cancel_crosspost',function(){
  sesJqueryObject('#sesbusinessesesbusiness_link_popup_crosspost_link_popup').hide();
});
function attachTagger(){
    var businessAdmin = "businesses";
    var contentAutocomplete1 =  'sesbusiness_role_text-'+businessAdmin
		contentAutocomplete1 = new Autocompleter.Request.JSON(businessAdmin, "<?php echo $this->url(array('module' => 'sesbusiness', 'controller' => 'dashboard', 'action' => 'cross-post-business', 'business_id' => $this->business->business_id), 'default', true) ?>", {
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
        sesJqueryObject('#sesbusiness_crosspost_overlay').show();
        sesJqueryObject.post('sesbusiness/dashboard/create-cross-post/business_id/<?php echo $this->business->getIdentity(); ?>',{crossbusiness:id},function(res){
          if(res != 0){
              sesJqueryObject('.sesbusiness_dashboard_content').html(res);
              attachTagger();
          }else{
            alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
          }
        })
    }
    attachTagger();
 sesJqueryObject(document).on('click','.sesbusiness_link',function(){
    sesJqueryObject('#sesbusiness_link_popup').show();
  var mainDiv = sesJqueryObject(this).closest('.sesbusiness_crosspost_main'); 
  var conLink =  mainDiv.data('confirmationlink');
  sesJqueryObject('#sesbusiness_textarea_val').val(conLink);
 })
sesJqueryObject(document).on('click','.copytoclipboard',function(){
  document.getElementById('sesbusiness_textarea_val').select();
  // Copy the highlighted text
  document.execCommand("copy");  
});
sesJqueryObject(document).on('click','.sesbusiness_popup_close',function(){
  sesJqueryObject('#sesbusiness_link_popup').hide();
});
sesJqueryObject(document).on('click','.sesbusiness_remove',function(){
  if(confirm("Are you sure want to delete this business?")){
    sesJqueryObject('#sesbusiness_link_popup').hide();
    sesJqueryObject('#sesbusiness_crosspost_overlay').show();
    var mainDiv = sesJqueryObject(this).closest('.sesbusiness_crosspost_main'); 
    var id =  mainDiv.data('crosspost');
     sesJqueryObject.post('sesbusiness/dashboard/delete-cross-post/business_id/<?php echo $this->business->getIdentity(); ?>',{crossbusiness:id},function(res){
        if(res != 0){
            sesJqueryObject('.sesbusiness_dashboard_content').html(res);
            attachTagger();
        }else{
          alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
        }
      })
  }
});
</script>
