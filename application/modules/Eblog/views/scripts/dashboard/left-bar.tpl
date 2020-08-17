<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblogpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblogpackage.enable.package', 1) && isset($this->blog->package_id) && $this->blog->package_id ){ 
  $package = Engine_Api::_()->getItem('eblogpackage_package', $this->blog->package_id);
  $modulesEnable = json_decode($package->params,true);	
 } ?>
<div class="layout_middle eblog_dashboard_main_nav">
	<?php echo $this->content()->renderWidget('eblog.browse-menu'); ?>
</div>
<div class="layout_middle">
  <div class="eblog_dashboard_menu_list">
    <div class="sesbasic_dashboard_container sesbasic_clearfix">
      <div class="sesbasic_dashboard_top_section sesbasic_clearfix sesbm">
        <div class="sesbasic_dashboard_top_section_left">
          <div class="sesbasic_dashboard_top_section_item_photo"> <?php echo $this->htmlLink($this->blog->getHref(), $this->itemPhoto($this->blog, 'thumb.icon')) ?> </div>
          <div class="sesbasic_dashboard_top_section_item_title"> <?php echo $this->htmlLink($this->blog->getHref(),$this->blog->getTitle()); ?> </div>
        </div>
        <div class="sesbasic_dashboard_top_section_btns">
          <a href="<?php echo $this->blog->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View Blog"); ?></a>
          <?php if($this->blog->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
            <a href="<?php echo $this->url(array('blog_id' => $this->blog->blog_id,'action'=>'delete'), 'eblog_specific', true); ?>" class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Blog"); ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="sesbasic_dashboard_tabs sesbasic_bxs">
      <ul class="sesbm">
        <li class="sesbm">
          <?php $manage_blog = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'manage_blog')); ?>
          <a href="#Manage" class="sesbasic_dashboard_nopropagate"> </a>
          <?php $edit_blog = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'edit_blog')); ?>
          <?php $edit_photo = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'edit_photo')); ?>
          <?php $blog_roles = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'blog_role')); ?>
          <?php $blog_changeowner = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'change_owner')); ?>
          <?php $contact_information = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'contact_information')); ?>
          <?php $seo = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'seo')); ?>
          <?php $style = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'edit_style')); ?>
          <?php $editLocation = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'edit_location')); ?>
          <?php $fields = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'fields')); ?>
          <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'upgrade')); ?>
          <?php $mainphoto = Engine_Api::_()->getDbtable('dashboards', 'eblog')->getDashboardsItems(array('type' => 'mainphoto')); ?>
          <ul class="sesbm" style="display:none">
            
            <?php if(!empty($edit_blog) && $edit_blog->enabled): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url), 'eblog_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa  fa-edit"></i> <?php echo $this->translate($edit_blog->title); ?></a></li>
            <?php endif; ?>
            
            <?php if((!empty($edit_photo) && $edit_photo->enabled && empty($modulesEnable) ) || ((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])))): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url,'action'=>'edit-photo'), 'eblog_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-photo"></i> <?php echo $this->translate($edit_photo->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(!empty($blog_roles) && $blog_roles->enabled && Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'blogrolesman')): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url,'action'=>'blog-role'), 'eblog_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-user-plus "></i> <?php echo $this->translate($blog_roles->title); ?></a></li>
            <?php endif; ?>
            
            <?php if((!empty($fields) && $fields->enabled && empty($modulesEnable)) || (isset($modulesEnable) &&  isset($modulesEnable['custom_fields']) && $modulesEnable['custom_fields'] && $package->custom_fields_params != '[]')): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url,'action'=>'fields'), 'eblog_dashboard', true); ?>" class="dashboard_a_link" ><?php echo $this->translate($fields->title); ?></a></li>
            <?php endif; ?>
            <?php if((!empty($upgrade) && $upgrade->enabled && !empty($modulesEnable))): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url,'action'=>'upgrade'), 'eblog_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-refresh "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
            <?php endif; ?>
            <?php if(!empty($contact_information) && $contact_information->enabled && Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'contactinfo')): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url,'action'=>'contact-information'), 'eblog_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-envelope "></i> <?php echo $this->translate($contact_information->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(!empty($seo) && $seo->enabled &&  Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'seofields')): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url, 'action'=>'seo'), 'eblog_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i> <?php echo $this->translate($seo->title); ?></a></li>
            <?php endif; ?>


            <?php if($this->blog->owner_id==Engine_Api::_()->user()->getViewer()->getIdentity()  && !empty($blog_changeowner) && $blog_changeowner->enabled &&  Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'auth_changeowner')): ?>
            <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url, 'action'=>'change-owner'), 'eblog_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-text"></i> <?php echo $this->translate($blog_changeowner->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(@$style->enabled &&  Engine_Api::_()->authorization()->isAllowed('eblog_blog', Engine_Api::_()->user()->getViewer(), 'enablestyle')): ?>
            <li><a  href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url, 'action'=>'style'), 'eblog_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-pencil "></i> <?php echo $this->translate($style->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(@$editLocation->enabled && !empty($this->blog->location)): ?>
                <li><a href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url, 'action'=>'edit-location'), 'eblog_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker "></i> <?php echo $this->translate($editLocation->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(@$mainphoto->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('blog_id' => $this->blog->custom_url, 'action'=>'mainphoto'), 'eblog_dashboard', true); ?>" ><?php echo $this->translate($mainphoto->title); ?></a></li>
            <?php endif; ?>
            
          </ul>
        </li>
      </ul>
      <?php if(isset($this->blog->cover_photo) && $this->blog->cover_photo != 0 && $this->blog->cover_photo != ''){ 
        $blogCover =	Engine_Api::_()->storage()->get($this->blog->cover_photo, '')->getPhotoUrl(); 
      }else
        $blogCover =''; 
      ?>
      <div class="eblog_dashboard_blog_info sesbasic_clearfix">
        <?php if(isset($this->blog->cover_photo) && $this->blog->cover_photo != 0 && $this->blog->cover_photo != ''){ ?>
          <div class="eblog_dashboard_blog_info_cover"> 
            <img src="<?php echo $blogCover; ?>" />
            <?php if($this->blog->featured || $this->blog->sponsored){ ?>
              <p class="eblog_labels">
               <?php if($this->blog->sponsored ){ ?>
                <span class="eblog_label_sponsored"><?php echo $this->translate("Sponsored"); ?></span>
                <?php } ?>
                <?php if($this->blog->featured ){ ?>
                <span class="eblog_label_featured"><?php echo $this->translate("Featured"); ?></span>
                <?php } ?>
              </p>
            <?php } ?>
            <?php if($this->blog->verified ){ ?>
              <div class="eblog_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>"><i class="fa fa-check"></i>
              </div>
            <?php } ?>
            <div class="eblog_dashboard_blog_main_photo sesbm">
              <img  src="<?php echo $this->blog->getPhotoUrl(); ?>" />
            </div>
          </div>
        <?php } else { ?>
          <div class="eblog_dashboard_blog_photo sesbm">
            <div class="eblog_deshboard_img_blog">
              <img src="<?php echo $this->blog->getPhotoUrl(); ?>" />
              <?php if($this->blog->featured || $this->blog->sponsored){ ?>
                <div class="eblog_list_labels">
                  <?php if($this->blog->sponsored ){ ?>
                  <p class="eblog_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
                  <?php } ?>
                  <?php if($this->blog->featured ){ ?>
                  <p class="eblog_label_featured"><?php echo $this->translate("Featured"); ?></p>
                  <?php } ?>
                  <?php if($this->blog->verified ){ ?>
                <p class="eblog_label_verified"><?php echo $this->translate("Verified"); ?>
                </p>
              <?php } ?>
                </div>
              <?php } ?>
            </div>
          <div class="eblog_dashboard_blog_info_content sesbasic_clearfix sesbm">
            <div class="eblog_dashboard_blog_details">
              <div class="eblog_dashboard_blog_title">
                <a href="<?php echo $this->blog->getHref(); ?>"><b><?php echo $this->blog->getTitle(); ?></b></a>
              </div>
              <?php if($this->blog->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog_enable_location', 1)):?>
                <?php $locationText = $this->translate('Location');?>
                <?php $locationvalue = $this->blog->location;?>
                <?php echo $location = "<div class=\"eblog_list_stats eblog_list_location\">
                    <span class=\"widthfull\">
                      <i class=\"fa fa-map-marker sesbasic_text_light\" title=\"$locationText\"></i>
                      <span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $this->blog->blog_id,'resource_type'=>'eblog_blog','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"openSmoothbox\">".$this->blog->location."</a></span>
                    </span>
                  </div>"; 
                ?>
              <?php endif;?>
              <?php if($this->blog->category_id){ 
                $category = Engine_Api::_()->getItem('eblog_category', $this->blog->category_id);
              ?>
                <?php if($category) { ?>
                  <div class="eblog_list_stats">
                    <span><i class="fa fa-folder-open sesbasic_text_light"></i> 
                    <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a> 
                    </span> 
                  </div>
                <?php } ?>
              <?php } ?>
              <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblogpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblogpackage.enable.package', 1)) { ?>
                <div class="eblog_list_stats eblog_list_payment">
                  <span class="widthfull">
                  <i class="fa fa-credit-card-alt sesbasic_text_light" title="<?php echo '';?>"></i></span>
                  <?php echo $this-> content()->renderWidget('eblogpackage.blog-renew-button',array('eblog_blog'=>$this->blog)); ?> 
                </div>            
              <?php } ?>        
            </div>
          </div>
        <?php }; ?>
        </div>
      </div>
      <?php echo $this->content()->renderWidget('eblog.advance-share',array('dashboard'=>true)); ?> 
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
				if(sesJqueryObject('#loadingimgeblog-wrapper').length)
					sesJqueryObject('#loadingimgeblog-wrapper').hide();
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
		if(sesJqueryObject('#eblog_ajax_form_submit').length>0)
			var submitFormVal= 'eblog_ajax_form_submit';
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
sesJqueryObject(document).on('click','.eblog_ajax_delete',function(e){
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
  sesJqueryObject(document).on('submit','#eblog_ajax_form_submit',function(e){
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
    sesJqueryObject('#eblog_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content"></div>');
    else
    sesJqueryObject('#sesdashboard_overlay_content').show();
    //submit form 
    var form = sesJqueryObject('#eblog_ajax_form_submit');
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