<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: cross-post.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sespage', array(
	'page' => $this->page,
      ));	
?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix sesbasic_clearfix sespage_dashboard_manage_crossposting">
<?php }	?>
  <div class="sespage_dashboard_content_header">
    <h3><?php echo $this->translate('Add Pages to Crosspost'); ?></h3>
    <p><?php echo $this->translate('Crossposting is a way to share status feed across multiple Pages. Crossposting can only happen between Pages that have added each other. You control which status post you want to crosspost.
'); ?></p>
  	<p><?php echo $this->translate('Add or remove Pages here to manage your crossposting relationships.'); ?></p>
	</div>
  <div class="_addpage_form">
		<span class="_label"><?php echo $this->translate("Add Page");?></span>
    <span class="_input"><input class="sespage_input" type="text" name="page" id="sespage_page" /></span>
   </div> 
  <div class="_pageslist sesbasic_clearfix">
    <?php foreach($this->crosspost as $crosspost){ 
          $page_id = $this->page->page_id != $crosspost['sender_page_id'] ? $crosspost['sender_page_id'] : $crosspost['receiver_page_id'];
          $page = Engine_Api::_()->getItem('sespage_page',$page_id);
          if(!$page)
            continue;
    ?>
    <?php $confirmationlink = $this->absoluteUrl($this->url(array('page_id' => $page->custom_url, 'action'=>'cross-post','id'=>$crosspost['crosspost_id']), 'sespage_dashboard', true));?>
    <div class="sespage_crosspost_main sespage_dashboard_crossposting_item sesbasic_clearfix" data-crosspost="<?php echo $crosspost['crosspost_id']; ?>" data-confirmationlink="<?php echo $confirmationlink; ?>">
      <div class="_thumb">
        <a href="<?php echo $page->getHref(); ?>" target="_blank"><img src="<?php echo $page->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div>
      <div class="_cont">
        <div id="sespage_title" class="_title">
          <a href="<?php echo $page->getHref(); ?>" target="_blank"><?php echo $page->getTitle(); ?></a>
        </div>

        <div class="_category sesbasic_text_light">
          <?php $category = Engine_Api::_()->getItem('sespage_category',$page->category_id); ?>
          <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this page', '%s people liked this page', $page->like_count), $this->locale()->toNumber($page->like_count)) ?></span>
        </div>
      </div>
      <div class="_options">
        <div class="_msg">
          <?php if($crosspost['receiver_approved'] == 0){ ?>
            <span class="sesbasic_text_light"><?php echo $this->translate("This Page hasn't added yours"); ?></span>
            <a href="javascript:;" class="sespage_link sesbasic_button sespage_cbtn" title="<?php echo $this->translate('get link'); ?>"><i class="fa fa-link"></i></a>
          <?php } ?>
        </div>
        <div>
        	<a href="javascript:;" class="sespage_remove sesbasic_button sespage_cbtn"><?php echo $this->translate('remove'); ?></a>
        </div>
      </div>
   	</div>
   <?php } ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  <div class="sesbasic_loading_cont_overlay" id="sespage_crosspost_overlay"></div>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<div class="sespage_dashboard_manage_crossposting_popup" id="sespage_link_popup">
	<div class="_maincont sespage_fg_color">
    <div class="_field">
      <textarea id="sespage_textarea_val"></textarea>
      <a class="copytoclipboard sesbasic_button" href="javascript:;"><?php echo $this->translate('Copy to Clipboard'); ?></a>
    </div>
    <div class="_footer sesbasic_clearfix">
      <div class="_btns floatR">
        <a class="sespage_popup_close sespage_button" href="javascript:;"><?php echo $this->translate('close'); ?></a>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($this->crosspostpage)){ ?>
  <div class="sespage_link_popup_crosspost sespage_dashboard_manage_crossposting_popup" id="sespagesespage_link_popup_crosspost_link_popup">
    <div class="_maincont sespage_fg_color">
      <div class="_header">
        <?php echo $this->translate("Crosspost With"); ?> <?php echo $this->crosspostpage->getTitle(); ?>
      </div>
      <div class="_field">
        <div class="sespage_dashboard_crossposting_item sesbasic_clearfix">
          <div class="_thumb">
            <img src="<?php echo $this->crosspostpage->getPhotoUrl('thumb.icon'); ?>" />
          </div>
          <div class="_cont">
            <div class="_title">
              <?php echo $this->crosspostpage->getTitle(); ?>
            </div>          
            <div class="sesbasic_text_light">
            	<?php $category = Engine_Api::_()->getItem('sespage_category',$this->crosspostpage->category_id); ?>
              <?php if($category){ ?><span><?php echo $category->category_name; ?></span><span>&nbsp;•&nbsp;</span><?php } ?><span><?php echo $this->translate(array('%s person liked this page', '%s people liked this page', $this->crosspostpage->like_count), $this->locale()->toNumber($this->crosspostpage->like_count)) ?></span>
            </div>      
        	</div>
      	</div>  
      </div>
      <div class="_footer sesbasic_clearfix">
        <div class="_btns floatR">
        	<a href="javascript:;" class="cancel_crosspost sesbasic_button">cancel</a>
        	<a href="javascript:;" class="approve_crosspost sespage_button"><?php echo $this->translate("Add"); ?></a>
        </div>
      </div>
    </div>
  </div>
  <script type="application/javascript">
    sesJqueryObject('#sespagesespage_link_popup_crosspost_link_popup').show();
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
   sesJqueryObject('#sespage_crosspost_overlay').show();
  var id = <?php echo !empty($this->crosspostpageid) ? $this->crosspostpageid : "0"; ?>;
  sesJqueryObject.post('sespage/dashboard/approve-cross-post/page_id/<?php echo $this->page->getIdentity(); ?>',{crosspage:id},function(res){
    if(res != 0){
        sesJqueryObject('#sespagesespage_link_popup_crosspost_link_popup').hide();
        sesJqueryObject('.sespage_dashboard_content').html(res);
        attachTagger();
    }else{
      alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
    }
  })
});
sesJqueryObject(document).on('click','.cancel_crosspost',function(){
  sesJqueryObject('#sespagesespage_link_popup_crosspost_link_popup').hide();
});
function attachTagger(){
    var pageAdmin = "sespage_page";
    var contentAutocomplete1 =  'sespage_role_text-'+pageAdmin
		contentAutocomplete1 = new Autocompleter.Request.JSON(pageAdmin, "<?php echo $this->url(array('module' => 'sespage', 'controller' => 'dashboard', 'action' => 'cross-post-page', 'page_id' => $this->page->page_id), 'default', true) ?>", {
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
        sesJqueryObject('#sespage_crosspost_overlay').show();
        sesJqueryObject.post('sespage/dashboard/create-cross-post/page_id/<?php echo $this->page->getIdentity(); ?>',{crosspage:id},function(res){
          if(res != 0){
              sesJqueryObject('.sespage_dashboard_content').html(res);
              attachTagger();
          }else{
            alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
          }
        })
    }
    attachTagger();
 sesJqueryObject(document).on('click','.sespage_link',function(){
    sesJqueryObject('#sespage_link_popup').show();
  var mainDiv = sesJqueryObject(this).closest('.sespage_crosspost_main'); 
  var conLink =  mainDiv.data('confirmationlink');
  sesJqueryObject('#sespage_textarea_val').val(conLink);
 })
sesJqueryObject(document).on('click','.copytoclipboard',function(){
  document.getElementById('sespage_textarea_val').select();
  // Copy the highlighted text
  document.execCommand("copy");  
});
sesJqueryObject(document).on('click','.sespage_popup_close',function(){
  sesJqueryObject('#sespage_link_popup').hide();
});
sesJqueryObject(document).on('click','.sespage_remove',function(){
  if(confirm("Are you sure want to delete this page?")){
    sesJqueryObject('#sespage_link_popup').hide();
    sesJqueryObject('#sespage_crosspost_overlay').show();
    var mainDiv = sesJqueryObject(this).closest('.sespage_crosspost_main'); 
    var id =  mainDiv.data('crosspost');
     sesJqueryObject.post('sespage/dashboard/delete-cross-post/page_id/<?php echo $this->page->getIdentity(); ?>',{crosspage:id},function(res){
        if(res != 0){
            sesJqueryObject('.sespage_dashboard_content').html(res);
            attachTagger();
        }else{
          alert('<?php echo $this->translate("Something went wrong, please try again later"); ?>');    
        }
      })
  }
});
</script>