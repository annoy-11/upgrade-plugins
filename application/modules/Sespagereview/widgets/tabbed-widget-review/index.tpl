<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagereview/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ ?>
<!--Default Tabs-->
<?php if($this->params['tabOption'] == '0'){ ?>
  <div class="layout_core_container_tabs" <?php if(count($this->defaultOptions) ==1){ ?> style="border-width:0;" <?php } ?>>
  	<div class="tabs_alt tabs_parent sespagereview_tabs" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<?php if($this->params['tabOption'] == '1' && count($this->defaultOptions) > 1){ ?>
  <div class="sesbasic_select_tabs_container sesbasic_clearfix sesbasic_bxs">
  	<div class="sesbasic_select_tabs">
      <p>
        <span><?php echo $this->translate("Sort By: ") ?></span>  
        <span>
          <select onchange="changeTabSes_<?php echo $randonNumber; ?>(this.value)" id="selected_optn_<?php echo $randonNumber; ?>">
            <?php $defaultOptionArray = array();?>
            <?php foreach($this->defaultOptions as $key=>$valueOptions):?>
              <?php $defaultOptionArray[] = $key;?>
              <option value="<?php echo $key; ?>"><?php echo $this->translate(($valueOptions)); ?></option>
            <?php endforeach; ?>
          </select>
        </span>
      </p>
   	</div>
   <?php } else { ?>
      <ul id="tab-widget-sespagereview-<?php echo $randonNumber; ?>">
        <?php $defaultOptionArray = array();?>
        <?php foreach($this->defaultOptions as $key=>$valueOptions):?>
         <?php $defaultOptionArray[] = $key;?>	 
           <li <?php if($this->defaultOpenTab == $key){ ?> class="active"<?php } ?> id="sesTabContainer_<?php echo $randonNumber; ?>_<?php echo $key; ?>">
             <a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes_<?php echo $randonNumber; ?>('<?php echo $key; ?>')"><?php echo $this->translate(($valueOptions)); ?></a>
           </li>
        <?php endforeach; ?>
      </ul>
    </div>
   <?php } ?>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
<?php  } ?>
<?php if(!$this->is_ajax){ ?>
  <style>.displayFN{display:none !important;}</style>
  <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_clearfix clear">
    <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
      <ul class="sespagereview_review_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>"   style="min-height:50px;">
<?php } ?>
<?php if(0 == count($this->paginator)): ?>
  <div class="tip"><span><?php echo $this->translate('There are no reviews yet.') ?></span></div>
<?php else: ?>
  <?php include APPLICATION_PATH . '/application/modules/Sespagereview/views/scripts/_showReviewList.tpl'; ?>
<?php endif ?>
<?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sespagereview"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->params['pagging'] != 'pagging' && $this->params['show_limited_data'] == 'no'):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
</div>
</div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
<?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  sesJqueryObject(document).ready(function() {
    if(sesJqueryObject('.sespage_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.sespage_browse_search').find('#filter_form');
      searchParams<?php echo $randonNumber; ?> = search.serialize();
    }
  });
  var requestTab_<?php echo $randonNumber; ?>;
  var valueTabData ;
    // globally define available tab array
  <?php if($this->params['pagging'] == 'auto_load' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')){  ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
        var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top; 
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
          document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
        }
      });
    });
  <?php } ?>
  sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){
    sesJqueryObject('#sespage_list_view_<?php echo $randonNumber; ?>').removeClass('active');
    if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
      requestTab_<?php echo $randonNumber; ?>.cancel();
    }
    if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
      requestViewMore_<?php echo $randonNumber; ?>.cancel();
    }
    requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sespage/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
      'data': {
          format: 'html',
          page: 1,
          type:sesJqueryObject(this).attr('rel'),
          is_ajax : 1,
          searchParams: searchParams<?php echo $randonNumber; ?>,
          identity : '<?php echo $randonNumber; ?>',
          widget_id: '<?php echo $this->widgetId;?>',
          getParams:'<?php echo $this->getParams;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          page_id:1,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sespagereview_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sespagereview').html(totalPage.html());
        totalPage.remove();
        if($("loading_image_<?php echo $randonNumber; ?>"))
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
       }
      })).send();
    });
  </script>
  <?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var requestViewMore_<?php echo $randonNumber; ?>;
  var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
  var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  <?php if(!$this->is_ajax):?>
    var isSearch = false;
    var is_search_<?php echo $randonNumber;?> = 0;
  <?php endif;?>
  var searchParams<?php echo $randonNumber; ?> ;
  <?php if($this->params['pagging'] != 'pagging'){ ?>
    viewMoreHide_<?php echo $randonNumber; ?>();	
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> (){
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';  
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sespagereview/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: page<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          is_search:is_search_<?php echo $randonNumber;?>,
          view_more:1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widget_id: '<?php $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
		  limit_data:'<?php echo $this->limit_data; ?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sespagereview_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sespagereview').html(totalPage.html());
            totalPage.remove();
            isSearch = false;
          }
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sespagereview/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
		  is_search:is_search_<?php echo $randonNumber;?>,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
		  limit_data:'<?php echo $this->limit_data ?>',	  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          if(isSearch){
            isSearch = false;
          }
          sesJqueryObject('html, body').animate({
              scrollTop: sesJqueryObject("#scrollHeightDivSes_<?php echo $randonNumber; ?>").offset().top
          }, 500);
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
</script>
<?php if(!$this->is_ajax){ ?>
    </div>
  </div>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
  </div>
<?php } ?>
<?php if(!$this->is_ajax):?>
  <script type="application/javascript"> 
    var availableTabs_<?php echo $randonNumber; ?>;
    var requestTab_<?php echo $randonNumber; ?>;
    <?php if(isset($defaultOptionArray)){ ?>
      availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($defaultOptionArray); ?>;
    <?php  } ?>
    var defaultOpenTab ;
    function changeTabSes_<?php echo $randonNumber; ?>(valueTab){
      if(sesJqueryObject('#selected_optn_<?php echo $randonNumber; ?>').length == 0){
        if(sesJqueryObject("#sesTabContainer_<?php echo $randonNumber; ?>_"+valueTab).hasClass('active'))
        return;
        var id = '_<?php echo $randonNumber; ?>';
        var length = availableTabs_<?php echo $randonNumber; ?>.length;
        for (var i = 0; i < length; i++){
          if(availableTabs_<?php echo $randonNumber; ?>[i] == valueTab){
            document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('active');
            sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('sesbasic_tab_selected');
          }else{
            sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('sesbasic_tab_selected');
            document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('active');
          }
        }
      }
      if(valueTab){
        if(document.getElementById("error-message_<?php echo $randonNumber;?>"))
        document.getElementById("error-message_<?php echo $randonNumber;?>").style.display = 'none';
	
        if(document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>'))
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML ='';
	
        sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = '<div class="clear sesbasic_loading_container" id="loading_image_<?php echo $randonNumber; ?>" style="width:100%;"></div>';
	
        if(typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined')
        requestTab_<?php echo $randonNumber; ?>.cancel();

        if(typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined')
        requestViewMore_<?php echo $randonNumber; ?>.cancel();
	
        defaultOpenTab = valueTab;
        requestTab_<?php echo $randonNumber; ?> = new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl+"widget/index/mod/sespagereview/name/<?php echo $this->widgetName; ?>/openTab/"+valueTab,
          'data': {
            format: 'html',  
            params : params<?php echo $randonNumber; ?>, 
            is_ajax : 1,
            page: '1',    
            searchParams:searchParams<?php echo $randonNumber; ?> ,
            identity : '<?php echo $randonNumber; ?>',
            height:'<?php echo $this->height;?>',
            widget_id: '<?php echo $this->widgetId;?>',
            getParams:'<?php echo $this->getParams;?>',
            limit_data:'<?php echo $this->limit_data; ?>',
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if(sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').length)
            sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','none');
            else
            sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
	      
            sesJqueryObject('#error-message_<?php echo $randonNumber;?>').remove();
            var check = true;
            if(document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>'))
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
            sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
            if(typeof viewMoreHide_<?php echo $randonNumber; ?> == 'function')
            viewMoreHide_<?php echo $randonNumber; ?>();
          }
        });
        requestTab_<?php echo $randonNumber; ?>.send();
        return false;			
      }
    }
  </script> 
<?php endif;?>