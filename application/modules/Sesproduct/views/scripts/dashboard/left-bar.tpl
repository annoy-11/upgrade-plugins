<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: left-bar.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/style_album.css'); ?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1) && isset($this->product->package_id) && $this->product->package_id ){ 
  $package = Engine_Api::_()->getItem('sesproductpackage_package', $this->product->package_id);
  $modulesEnable = json_decode($package->params,true);	
 } ?>
<div class="layout_middle">
  <div class="generic_layout_container estore_dashboard_main_nav">
    <?php echo $this->content()->renderWidget('estore.browse-menu'); ?>
  </div>
</div>
<div class="layout_middle">
  <div class="estore_dashboard_wrapper sesbasic_clearfix">
    <div class="estore_dashboard_top_section sesbasic_clearfix sesbm">
      <div class="estore_dashboard_top_section_left">
        <div class="estore_dashboard_top_section_item_photo"> <?php echo $this->htmlLink($this->product->getHref(), $this->itemPhoto($this->product, 'thumb.icon')) ?> </div>
        <div class="estore_dashboard_top_section_item_title"> <?php echo $this->htmlLink($this->product->getHref(),$this->product->getTitle()); ?> </div>
      </div>
      <div class="estore_dashboard_top_section_btns">
        <a href="<?php echo $this->product->getHref(); ?>" class="estore_link_btn"><?php echo $this->translate("View Product"); ?></a>
        <?php if($this->product->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
          <a href="<?php echo $this->url(array('product_id' => $this->product->product_id,'action'=>'delete'), 'sesproduct_specific', true); ?>" class="estore_link_btn smoothbox"><?php echo $this->translate("Delete Product"); ?></a>
        <?php } ?>
      </div>
    </div>
    <div class="estore_dashboard_tabs sesbasic_bxs">
      <ul class="sesbm"> 
        <li class="sesbm">
          <?php $manage_product = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'manage_product')); ?>
          <!-- <a href="#Manage" class="sesbasic_dashboard_nopropagate"> </a> -->
          <?php $edit_product = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'edit_product')); ?>
          
           <?php $variation = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'variation')); ?>
           <?php $attribute = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'attributes')); ?>
          
          <?php $edit_photo = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'edit_photo')); ?>
          
          <?php $edit_photos = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'edit_photos')); ?>
          
          <?php $product_roles = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'product_role')); ?>
          <?php $contact_information = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'contact_information')); ?>
          <?php $seo = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'seo')); ?>
          <?php $style = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'edit_style')); ?>
          <?php $editLocation = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'edit_location')); ?>
          <?php $fields = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'fields')); ?>
          <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'upgrade')); ?>
          <?php $mainphoto = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'mainphoto')); ?>
          
          <?php $orders = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'orders')); ?>
          <?php $slideshow = Engine_Api::_()->getDbtable('dashboards', 'sesproduct')->getDashboardsItems(array('type' => 'slideshow')); ?>
          <ul class="sesbm _innersesbm">
            
            <?php if(!empty($edit_product) && $edit_product->enabled): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa  fa-edit"></i> <?php echo $this->translate($edit_product->title); ?></a></li>
            <?php endif; ?>
            
            
            
            <?php if(!empty($attribute) && $attribute->enabled): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'attributes'), 'sesproduct_cartproducts', true); ?>" class="dashboard_a_link" ><i class="far fa-file-alt"></i> <?php echo $this->translate($attribute->title); ?></a></li>
            <?php endif; ?>
       
            <?php if(!empty($variation) && $variation->enabled && $this->product->type == 'configurableProduct'): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'variations'), 'sesproduct_cartproducts', true); ?>" class="dashboard_a_link" ><i class="fa fa-arrows-alt"></i> <?php echo $this->translate($variation->title); ?></a></li>
            <?php endif; ?>
            
            <?php if((!empty($edit_photo) && $edit_photo->enabled && empty($modulesEnable) ) || ((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])))): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'edit-photo'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-image"></i> <?php echo $this->translate($edit_photo->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(!empty($slideshow) && $slideshow->enabled): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'slideshow'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><i class="far fa-image"></i> <?php echo $this->translate($slideshow->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(!empty($orders) && $orders->enabled): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'manage-orders'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-user-plus "></i> <?php echo $this->translate($orders->title); ?></a></li>
            <?php endif; ?>
            
            <?php if((!empty($fields) && $fields->enabled && empty($modulesEnable)) || (isset($modulesEnable) &&  isset($modulesEnable['custom_fields']) && $modulesEnable['custom_fields'] && $package->custom_fields_params != '[]')): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'fields'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><?php echo $this->translate($fields->title); ?></a></li>
            <?php endif; ?>
            <?php if((!empty($upgrade) && $upgrade->enabled && !empty($modulesEnable))): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'upgrade'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link" ><i class="fa fa-sync "></i> <?php echo $this->translate($upgrade->title); ?></a></li>
            <?php endif; ?>
         
            
            <?php if(!empty($edit_photos) && $edit_photos->enabled): ?>
            <!-- <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url, 'action'=>'photos'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-photo"></i> <?php echo $this->translate($edit_photos->title); ?></a></li> -->
            <?php endif; ?>
            
            <?php if(!empty($seo) && $seo->enabled): ?>
            <li><a href="<?php echo $this->url(array('product_id' => $this->product->custom_url, 'action'=>'seo'), 'sesproduct_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-file-alt"></i> <?php echo $this->translate($seo->title); ?></a></li>
            <?php endif; ?>
            
            <?php if(@$style->enabled): ?>
            <li><a  href="<?php echo $this->url(array('product_id' => $this->product->custom_url, 'action'=>'style'), 'sesproduct_dashboard', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-edit "></i> <?php echo $this->translate($style->title); ?></a></li>
            <?php endif; ?>
            
						<?php if(@$editLocation->enabled && !empty($this->product->location)): ?>
							<li><a  href="<?php echo $this->url(array('product_id' => $this->product->custom_url, 'action'=>'edit-location'), 'sesproduct_dashboard', true); ?>" class="dashboard_a_link"><i class="fa fa-map-marker "></i> <?php echo $this->translate($editLocation->title); ?></a></li>
						<?php endif; ?>
            
            <?php if(@$mainphoto->enabled): ?>
            <li><a class="dashboard_a_link" href="<?php echo $this->url(array('product_id' => $this->product->custom_url, 'action'=>'mainphoto'), 'sesproduct_dashboard', true); ?>" ><?php echo $this->translate($mainphoto->title); ?></a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
      <?php if(isset($this->product->cover_photo) && $this->product->cover_photo != 0 && $this->product->cover_photo != ''){ 
        $productCover =	Engine_Api::_()->storage()->get($this->product->cover_photo, '')->getPhotoUrl(); 
      }else
        $productCover =''; 
      ?>
      <div class="sesproduct_dashboard_product_info sesbasic_clearfix sesbm">
        <?php if(isset($this->product->cover_photo) && $this->product->cover_photo != 0 && $this->product->cover_photo != ''){ ?>
          <div class="sesproduct_dashboard_product_info_cover"> 
            <img src="<?php echo $productCover; ?>" />
            <?php if($this->product->featured || $this->product->sponsored){ ?>
              <p class="sesproduct_labels">
                <?php if($this->product->featured ){ ?>
                <span class="sesproduct_label_featured"><?php echo $this->translate("Featured"); ?></span>
                <?php } ?>
                <?php if($this->product->sponsored ){ ?>
                <span class="sesproduct_label_sponsored"><?php echo $this->translate("Sponsored"); ?></span>
                <?php } ?>
              </p>
            <?php } ?>
            <?php if($this->product->verified ){ ?>
              <div class="sesproduct_verified_label" title="<?php echo $this->translate("Verified"); ?>"><i class="fa fa-check"></i>
              </div>
            <?php } ?>
            <div class="sesproduct_dashboard_product_main_photo sesbm">
              <img src="<?php echo $this->product->getPhotoUrl(); ?>" /> 
            </div>
          </div>
        <?php } else { ?>
          <div class="sesproduct_dashboard_product_photo sesbm">
            <div class="sesproduct_deshboard_img_product">
              <img src="<?php echo $this->product->getPhotoUrl(); ?>" />
              <?php if($this->product->featured || $this->product->sponsored){ ?>
                <div class="sesproduct_list_labels">
                  <?php if($this->product->featured ){ ?>
                  <p class="sesproduct_label_featured"><?php echo $this->translate("Featured"); ?></p>
                  <?php } ?>
                  <?php if($this->product->sponsored ){ ?>
                  <p class="sesproduct_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php if($this->product->verified ){ ?>
                <div class="sesproduct_verified_label" title="<?php echo $this->translate("Verified"); ?>"><i class="fa fa-check"></i>
                </div>
              <?php } ?>
            </div>
        	</div>
        <?php }; ?>    
        <div class="sesproduct_dashboard_product_info_content sesbasic_clearfix">
          <div class="sesproduct_dashboard_product_details">
            <div class="sesproduct_dashboard_product_title">
              <a href="<?php echo $this->product->getHref(); ?>"><b><?php echo $this->product->getTitle(); ?></b></a>
            </div>
            <?php if($this->product->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct_enable_location', 1)):?>
              <?php $locationText = $this->translate('Location');?>
              <?php $locationvalue = $this->product->location;?>
              <?php echo $location = "<div class=\"sesproduct_list_stats sesproduct_list_location\">
                  <span>
                    <i class=\"fa fa-map-marker sesbasic_text_light\" title=\"$locationText\"></i>
                    <span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $this->product->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"openSmoothbox\">".$this->product->location."</a></span></span></div>"; 
              ?>
            <?php endif;?>
            <?php if($this->product->category_id){ 
              $category = Engine_Api::_()->getItem('sesproduct_category', $this->product->category_id);
            ?>
              <?php if($category) { ?>
                <div class="sesproduct_list_stats">
                  <span><i class="fa fa-folder-open sesbasic_text_light"></i> 
                  <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a> 
                  </span> 
                </div>
              <?php } ?>
            <?php } ?>
            <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1)) { ?>
              <div class="sesproduct_list_stats sesproduct_list_payment">
                <span class="widthfull">
                <i class="fa fa-credit-card-alt sesbasic_text_light" title="<?php echo '';?>"></i></span>
                <?php echo $this-> content()->renderWidget('sesproductpackage.product-renew-button',array('sesproduct'=>$this->product)); ?>
              </div>            
            <?php } ?>        
          </div>
        </div>
      </div>  
      <?php echo $this->content()->renderWidget('sesproduct.advance-share',array('dashboard'=>true)); ?>
    </div>

       


<script type="application/javascript">
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>

sesJqueryObject(document).ready(function(){
	var totalLinks = sesJqueryObject('.dashboard_a_link');
	for(var i =0;i < totalLinks.length ; i++){
			var data_url = sesJqueryObject(totalLinks[i]).attr('href');
			var linkurl = window.location.href;
			if(linkurl.indexOf(data_url) > 0 || (("<?php echo $actionName; ?>" == "manage-photos" || "<?php echo $actionName; ?>" == "edit-album" || "<?php echo $actionName; ?>" == "create-album") && data_url.indexOf('dashboard/photos') > -1) || ("<?php echo $actionName; ?>" == "create-slide" && data_url.indexOf('dashboard/slideshow') > -1) ){
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
	sesJqueryObject('.estore_dashboard_content ').html('<div class="sesbasic_loading_container"></div>');
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
				sesJqueryObject('.estore_dashboard_content ').html(response);
				if(typeof executeAfterLoad == 'function'){
					executeAfterLoad();
				}
				if(sesJqueryObject('#loadingimgsesproduct-wrapper').length)
					sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
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
		if(sesJqueryObject('#sesproduct_ajax_form_submit').length>0)
			var submitFormVal= 'sesproduct_ajax_form_submit';
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
sesJqueryObject(document).on('click','.sesproduct_ajax_delete',function(e){
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
  sesJqueryObject(document).on('submit','#sesproduct_ajax_form_submit',function(e){
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
    sesJqueryObject('#sesproduct_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content"></div>');
    else
    sesJqueryObject('#sesdashboard_overlay_content').show();
    //submit form 
    var form = sesJqueryObject('#sesproduct_ajax_form_submit');
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
    sesJqueryObject('.estore_dashboard_content ').html(data);
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
  sesJqueryObject(document).on('submit','#manage_order_search_form',function(product){
	if(sesJqueryObject('#manage_order_search_form').hasClass('manage_sponsorship')){
		var widgetName = 'manage-sponsorship-orders';	
	}else if(sesJqueryObject('#manage_order_search_form').hasClass('search_ticket')){
		var widgetName = 'search-ticket';	
	}else
		var widgetName = 'manage-orders';	
	product.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgsesproduct-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'widget/index/mod/sesproduct/name/'+widgetName,
			data : {
				format : 'html',
				product_id:'<?php echo $this->product_id ? $this->product_id : $this->product->getIdentity(); ?>',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
				sesJqueryObject('#sesproduct_manage_order_content').html(response);
			}
	}).send();
});
</script>
