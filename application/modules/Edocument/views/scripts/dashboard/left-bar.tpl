<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<div class="layout_middle edocument_dashboard_main_nav">
	<?php echo $this->content()->renderWidget('edocument.browse-menu'); ?>
</div>
<div class="layout_middle">
  <div class="edocument_dashboard_menu_list">
    <div class="sesbasic_dashboard_container sesbasic_clearfix">
      <div class="sesbasic_dashboard_top_section sesbasic_clearfix sesbm">
        <div class="sesbasic_dashboard_top_section_left">
          <div class="sesbasic_dashboard_top_section_item_photo"> <?php echo $this->htmlLink($this->document->getHref(), $this->itemPhoto($this->document, 'thumb.icon')) ?> </div>
          <div class="sesbasic_dashboard_top_section_item_title"> <?php echo $this->htmlLink($this->document->getHref(),$this->document->getTitle()); ?> </div>
        </div>
        <div class="sesbasic_dashboard_top_section_btns">
          <a href="<?php echo $this->document->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Document"); ?></a>
          <?php if($this->document->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
            <a href="<?php echo $this->url(array('edocument_id' => $this->document->edocument_id,'action'=>'delete'), 'edocument_specific', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Document"); ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="sesbasic_dashboard_tabs sesbasic_bxs">
      <ul class="sesbm">
        <li class="sesbm">
          <?php $manage_document = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'manage_document')); ?>
          <a href="#Manage" class="sesbasic_dashboard_nopropagate"> </a>
          <?php $edit_document = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'edit_document')); ?>
          <?php $edit_photo = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'edit_photo')); ?>
          <?php $seo = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'seo')); ?>
          <?php $fields = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'fields')); ?>
          <?php $edit_photo = Engine_Api::_()->getDbtable('dashboards', 'edocument')->getDashboardsItems(array('type' => 'edit_photo')); ?>
          <ul class="sesbm" style="display:none">
            <?php if(!empty($edit_document) && $edit_document->enabled): ?>
              <li><a href="<?php echo $this->url(array('edocument_id' => $this->document->custom_url), 'edocument_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa  fa-edit"></i> <?php echo $this->translate($edit_document->title); ?></a></li>
            <?php endif; ?>
            <?php if(!empty($seo) && $seo->enabled): ?>
              <li><a href="<?php echo $this->url(array('edocument_id' => $this->document->custom_url, 'action'=>'seo'), 'edocument_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i> <?php echo $this->translate($seo->title); ?></a></li>
            <?php endif; ?>
            <?php if(@$edit_photo->enabled): ?>
              <li><a href="<?php echo $this->url(array('edocument_id' => $this->document->custom_url,'action'=>'edit-photo'), 'edocument_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-photo"></i> <?php echo $this->translate($edit_photo->title); ?></a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
      <div class="edocument_dashboard_document_info sesbasic_clearfix">
          <div class="edocument_dashboard_document_photo sesbm">
            <div class="edocument_deshboard_img_document">
              <img src="<?php echo $this->document->getPhotoUrl(); ?>" />
              <?php if($this->document->featured || $this->document->sponsored){ ?>
                <div class="edocument_list_labels">
                  <?php if($this->document->featured ){ ?>
                  <p class="edocument_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
                  <?php } ?>
                  <?php if($this->document->sponsored ){ ?>
                  <p class="edocument_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php if($this->document->verified ){ ?>
                <div class="edocument_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>"><i class="fa fa-check"></i>
                </div>
              <?php } ?>
            </div>
          <div class="edocument_dashboard_document_info_content sesbasic_clearfix sesbm">
            <div class="edocument_dashboard_document_details">
              <div class="edocument_dashboard_document_title">
                <a href="<?php echo $this->document->getHref(); ?>"><b><?php echo $this->document->getTitle(); ?></b></a>
              </div>

              <?php if($this->document->category_id){ 
                $category = Engine_Api::_()->getItem('edocument_category', $this->document->category_id);
              ?>
                <?php if($category) { ?>
                  <div class="edocument_list_stats">
                    <span><i class="fa fa-folder-open sesbasic_text_light"></i> 
                    <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a> 
                    </span> 
                  </div>
                <?php } ?>
              <?php } ?>
              <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('edocumentpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocumentpackage.enable.package', 1)) { ?>
                <div class="edocument_list_stats edocument_list_payment">
                  <span class="widthfull">
                  <i class="fa fa-credit-card-alt sesbasic_text_light" title="<?php echo '';?>"></i></span>
                  <?php echo $this-> content()->renderWidget('edocumentpackage.document-renew-button',array('edocument'=>$this->document)); ?> 
                </div>            
              <?php } ?>        
            </div>
          </div>
        </div>
      </div>
      <?php echo $this->content()->renderWidget('edocument.advance-share',array('dashboard'=>true)); ?> 
    </div>


<script type="application/javascript">
sesJqueryObject(document).ready(function(){
	var totalLinks = sesJqueryObject('.dashboard_a_link');
	for(var i =0;i < totalLinks.length ; i++){
			var data_url = sesJqueryObject(totalLinks[i]).attr('href');
			var linkurl = window.location.href ;
			if(linkurl.indexOf(data_url) > 0){
					sesJqueryObject(totalLinks[i]).parent().addClass('active');
					sesJqueryObject(totalLinks[i]).parent().parent().parent().find('a.sesbasic_dashboard_nopropagate').trigger('click');
			}
	}
});

var sendParamInSearch = '';
sesJqueryObject(document).on('click','.sesbasic_dashboard_nopropagate, .sesbasic_dashboard_nopropagate_content',function(e){
	e.preventDefault();
	//ajax request
	if(sesJqueryObject(this).hasClass('sesbasic_dashboard_nopropagate_content')){
			if(!sesJqueryObject(this).parent().hasClass('active'))
				getDataThroughAjax(sesJqueryObject(this).attr('href'));
		  sesJqueryObject(".sesbasic_dashboard_tabs > ul li").each(function() {
				sesJqueryObject(this).removeClass('active');
			});
			sesJqueryObject('.sesbasic_dashboard_tabs > ul > li ul > li').each(function() {
					sesJqueryObject(this).removeClass('active');
			});			
			sesJqueryObject(this).parent().addClass('active');
			sesJqueryObject(this).parent().parent().parent().addClass('active');
	}	
});
var ajaxRequest;
//get data through ajax
function getDataThroughAjax(url){
	if(!url)
		return;
	history.pushState(null, null, url);
	if(typeof ajaxRequest != 'undefined')
		ajaxRequest.cancel();
	sesJqueryObject('.sesbasic_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
	ajaxRequest = new Request.HTML({
      method: 'post',
      url : url,
      data : {
        format : 'html',
				is_ajax:true,
				dataAjax : sendParamInSearch,
				is_ajax_content:true,
      },
      onComplete: function(response) {
				sesJqueryObject('.sesbasic_dashboard_content').html(response);
				if(typeof executeAfterLoad == 'function'){
					executeAfterLoad();
				}
				if(sesJqueryObject('#loadingimgedocument-wrapper').length)
					sesJqueryObject('#loadingimgedocument-wrapper').hide();
			}
    });
    ajaxRequest.send();
}
sesJqueryObject(".sesbasic_dashboard_tabs > ul li a").each(function() {
	var c = sesJqueryObject(this).attr("href");
	sesJqueryObject(this).click(function() {
		if(sesJqueryObject(this).hasClass('sesbasic_dashboard_nopropagate')){
			if(sesJqueryObject(this).parent().find('ul').is(":visible")){
				sesJqueryObject(this).parent().find('ul').slideUp()
			}else{
					sesJqueryObject(".sesbasic_dashboard_tabs ul ul").each(function() {
							sesJqueryObject(this).slideUp();
					});
					sesJqueryObject(this).parent().find('ul').slideDown()
			}
					return false
			}	
	})
});
var error = false;
var objectError ;
var counter = 0;
var customAlert;
function validateForm(){
		var errorPresent = false;
		if(sesJqueryObject('#edocument_ajax_form_submit').length>0)
			var submitFormVal= 'edocument_ajax_form_submit';
		else
			return false;
		objectError;
		sesJqueryObject('#'+submitFormVal+' input, #'+submitFormVal+' select,#'+submitFormVal+' checkbox,#'+submitFormVal+' textarea,#'+submitFormVal+' radio').each(
				function(index){
						customAlert = false;
						var input = sesJqueryObject(this);
						if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
						  if(sesJqueryObject(this).prop('type') == 'checkbox'){
								value = '';
								if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
										value = 1;
								};
								if(value == '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
								if(sesJqueryObject(this).val() === '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'radio'){
								if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'textarea'){
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}else{
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}
							if(error){
							 if(counter == 0){
							 	objectError = this;
							 }
								counter++
							}else{
							}
							if(error)
								errorPresent = true;
							error = false;
						}
				}
			);	
			return errorPresent ;
}
var ajaxDeleteRequest;
sesJqueryObject(document).on('click','.edocument_ajax_delete',function(e){
	e.preventDefault();
	var object = sesJqueryObject(this);
	var url = object.attr('href');
	if(typeof ajaxDeleteRequest != 'undefined')
			ajaxDeleteRequest.cancel();
	if(confirm("Are you sure want to delete?")){
		 new Request.HTML({
      method: 'post',
      url : url,
      data : {
        format : 'html',
				is_ajax:true,
      },
      onComplete: function(response) {
				if(response)
					sesJqueryObject(object).parent().parent().remove();
				else
					alert('Something went wrong,please try again later');
			}
    }).send();
	}
});
  var submitFormAjax;
  sesJqueryObject(document).on('submit','#edocument_ajax_form_submit',function(e){
    e.preventDefault();
    //validate form
    var validation = validateForm();
    //if error comes show alert message and exit.
    if(validation)
    {
    if(!customAlert){
    alert('<?php echo $this->translate("Please complete the red mark fields"); ?>');

    }
    if(typeof objectError != 'undefined'){
    var errorFirstObject = sesJqueryObject(objectError).parent().parent();
    sesJqueryObject('html, body').animate({
    scrollTop: errorFirstObject.offset().top
    }, 2000);
    }
    return false;	
    }else{
    if(!sesJqueryObject('#sesdashboard_overlay_content').length)
    sesJqueryObject('#edocument_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content"></div>');
    else
    sesJqueryObject('#sesdashboard_overlay_content').show();
    //submit form 
    var form = sesJqueryObject('#edocument_ajax_form_submit');
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    submitFormAjax = sesJqueryObject.ajax({
    type:'POST',
    url: sesJqueryObject(this).attr('action'),
    data:formData,
    cache:false,
    contentType: false,
    processData: false,
    success:function(data){
    sesJqueryObject('#sesdashboard_overlay_content').hide();

    var dataJson = data;
    try{
    var dataJson = JSON.parse(data);
    }catch(err){
    //silence
    }
    if(dataJson.redirect){
    sesJqueryObject('#'+dataJson.redirect).trigger('click');
    return;
    }else{
    if(data){
    sesJqueryObject('.sesbasic_dashboard_content').html(data);
    }else{
    alert('Something went wrong,please try again later');	
    }
    }
    },
    error: function(data){
    //silence
    }
    });
    }
  });
</script>
