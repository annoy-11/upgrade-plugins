<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: cross-post.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_clearfix estore_dashboard_manage_crossposting">
<?php }	?>
  <div class="estore_dashboard_content_header">
    <h3><?php echo $this->translate('Add Stores to Crosspost'); ?></h3>
    <p><?php echo $this->translate('Crossposting is a way to share status feed across multiple Stores. Crossposting can only happen between Stores that have added each other. You control which status post you want to crosspost.
'); ?></p>
  	<p><?php echo $this->translate('Add or remove Stores here to manage your crossposting relationships.'); ?></p>
	</div>
  <div class="_addstore_form">
		<span class="_label"><?php echo $this->translate("Add Store");?></span>
    <span class="_input"><input class="estore_input" type="text" name="store" id="store" /></span>
   </div> 
  <div class="_storeslist sesbasic_clearfix">
    <?php foreach($this->crosspost as $crosspost){ 
          $store_id = $this->store->store_id != $crosspost['sender_store_id'] ? $crosspost['sender_store_id'] : $crosspost['receiver_store_id'];
          $store = Engine_Api::_()->getItem('stores',$store_id);
          if(!$store)
            continue;
    ?>
    <?php $confirmationlink = $this->absoluteUrl($this->url(array('store_id' => $store->custom_url, 'action'=>'cross-post','id'=>$crosspost['crosspost_id']), 'estore_dashboard', true));?>
    <div class="estore_crosspost_main estore_dashboard_crossposting_item sesbasic_clearfix" data-crosspost="<?php echo $crosspost['crosspost_id']; ?>" data-confirmationlink="<?php echo $confirmationlink; ?>">
      <div class="_thumb">
        <a href="<?php echo $store->getHref(); ?>" target="_blank"><img src="<?php echo $store->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div>
      <div class="_cont">
        <div id="estore_title" class="_title">
          <a href="<?php echo $store->getHref(); ?>" target="_blank"><?php echo $store->getTitle(); ?></a>
        </div>

        <div class="_category sesbasic_text_light">
          <?php $category = Engine_Api::_()->getItem('estore_category',$store->category_id); ?>
          <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this store', '%s people liked this store', $store->like_count), $this->locale()->toNumber($store->like_count)) ?></span>
        </div>
      </div>
      <div class="_options">
        <div class="_msg">
          <?php if($crosspost['receiver_approved'] == 0){ ?>
            <span class="sesbasic_text_light"><?php echo $this->translate("This Store hasn't added yours"); ?></span>
            <a href="javascript:;" class="estore_link sesbasic_button estore_cbtn" title="<?php echo $this->translate('get link'); ?>"><i class="fa fa-link"></i></a>
          <?php } ?>
        </div>
        <div>
        	<a href="javascript:;" class="estore_remove sesbasic_button estore_cbtn"><?php echo $this->translate('remove'); ?></a>
        </div>
      </div>
   	</div>
   <?php } ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  <div class="sesbasic_loading_cont_overlay" id="estore_crosspost_overlay"></div>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<div class="estore_dashboard_manage_crossposting_popup" id="estore_link_popup">
	<div class="_maincont estore_fg_color">
    <div class="_field">
      <textarea id="estore_textarea_val"></textarea>
      <a class="copytoclipboard sesbasic_button" href="javascript:;"><?php echo $this->translate('Copy to Clipboard'); ?></a>
    </div>
    <div class="_footer sesbasic_clearfix">
      <div class="_btns floatR">
        <a class="estore_popup_close estore_button" href="javascript:;"><?php echo $this->translate('close'); ?></a>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($this->crosspoststore)){ ?>
  <div class="estore_link_popup_crosspost estore_dashboard_manage_crossposting_popup" id="estoreestore_link_popup_crosspost_link_popup">
    <div class="_maincont estore_fg_color">
      <div class="_header">
        <?php echo $this->translate("Crosspost With"); ?> <?php echo $this->crosspoststore->getTitle(); ?>
      </div>
      <div class="_field">
        <div class="estore_dashboard_crossposting_item sesbasic_clearfix">
          <div class="_thumb">
            <img src="<?php echo $this->crosspoststore->getPhotoUrl('thumb.icon'); ?>" />
          </div>
          <div class="_cont">
            <div class="_title">
              <?php echo $this->crosspoststore->getTitle(); ?>
            </div>          
            <div class="sesbasic_text_light">
            	<?php $category = Engine_Api::_()->getItem('estore_category',$this->crosspoststore->category_id); ?>
              <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this store', '%s people liked this store', $this->crosspoststore->like_count), $this->locale()->toNumber($this->crosspoststore->like_count)) ?></span>
            </div>      
        	</div>
      	</div>  
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_btns floatR">
        	<a href="javascript:;" class="cancel_crosspost sesbasic_button">cancel</a>
        	<a href="javascript:;" class="approve_crosspost estore_button"><?php echo $this->translate("Add"); ?></a>
        </div>
      </div>
    </div>
  </div>
  <script type="application/javascript">
    sesJqueryObject('#estoreestore_link_popup_crosspost_link_popup').show();
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
   sesJqueryObject('#estore_crosspost_overlay').show();
  var id = <?php echo !empty($this->crosspoststoreid) ? $this->crosspoststoreid : "0"; ?>;
  sesJqueryObject.post('estore/dashboard/approve-cross-post/store_id/<?php echo $this->store->getIdentity(); ?>',{crossstore:id},function(res){
    if(res != 0){
        sesJqueryObject('#estoreestore_link_popup_crosspost_link_popup').hide();
        sesJqueryObject('.estore_dashboard_content').html(res);
        attachTagger();
    }else{
      alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
    }
  })
});
sesJqueryObject(document).on('click','.cancel_crosspost',function(){
  sesJqueryObject('#estoreestore_link_popup_crosspost_link_popup').hide();
});
function attachTagger(){
    var storeAdmin = "stores";
    var contentAutocomplete1 =  'estore_role_text-'+storeAdmin
		contentAutocomplete1 = new Autocompleter.Request.JSON(storeAdmin, "<?php echo $this->url(array('module' => 'estore', 'controller' => 'dashboard', 'action' => 'cross-post-store', 'store_id' => $this->store->store_id), 'default', true) ?>", {
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
        sesJqueryObject('#estore_crosspost_overlay').show();
        sesJqueryObject.post('estore/dashboard/create-cross-post/store_id/<?php echo $this->store->getIdentity(); ?>',{crossstore:id},function(res){
          if(res != 0){
              sesJqueryObject('.estore_dashboard_content').html(res);
              attachTagger();
          }else{
            alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
          }
        })
    }
    attachTagger();
 sesJqueryObject(document).on('click','.estore_link',function(){
    sesJqueryObject('#estore_link_popup').show();
  var mainDiv = sesJqueryObject(this).closest('.estore_crosspost_main'); 
  var conLink =  mainDiv.data('confirmationlink');
  sesJqueryObject('#estore_textarea_val').val(conLink);
 })
sesJqueryObject(document).on('click','.copytoclipboard',function(){
  document.getElementById('estore_textarea_val').select();
  // Copy the highlighted text
  document.execCommand("copy");  
});
sesJqueryObject(document).on('click','.estore_popup_close',function(){
  sesJqueryObject('#estore_link_popup').hide();
});
sesJqueryObject(document).on('click','.estore_remove',function(){
  if(confirm("Are you sure want to delete this store?")){
    sesJqueryObject('#estore_link_popup').hide();
    sesJqueryObject('#estore_crosspost_overlay').show();
    var mainDiv = sesJqueryObject(this).closest('.estore_crosspost_main'); 
    var id =  mainDiv.data('crosspost');
     sesJqueryObject.post('estore/dashboard/delete-cross-post/store_id/<?php echo $this->store->getIdentity(); ?>',{crossstore:id},function(res){
        if(res != 0){
            sesJqueryObject('.estore_dashboard_content').html(res);
            attachTagger();
        }else{
          alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
        }
      })
  }
});
</script>
