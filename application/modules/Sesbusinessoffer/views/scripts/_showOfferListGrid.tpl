<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showOfferListGrid.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $widgetType = 'profile-business';?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(isset($this->business_id)):?>
  <?php $businessId = $this->business_id;?>
<?php else:?>
  <?php $businessId = 0;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  <style>
  .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
  <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_view_type sesbasic_clearfix clear">
<?php } ?>
    <?php if(isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
      <div class="sesbasic_clearfix sesbm sesbusinessoffer_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesbusiness' : 'paginator_count_ajax_sesbusinessoffer_entry' ?>"><span id="total_item_count_sesbusinessoffer_entry" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("business found.") : $this->translate("businesses found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax){ ?>
    <div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
      <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="list" id="sesbusinessoffer_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="grid" id="sesbusinessoffer_grid_view_<?php echo $randonNumber; ?>" class="gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
      <?php } ?>
    </div>
  </div>
<?php } ?>
<?php if(!isset($this->bothViewEnable) && !$this->is_ajax){ ?>
  <script type="text/javascript">
      en4.core.runonce.add(function() {
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber ?>').addClass('displayFN');
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber ?>').parent().parent().css('border', '0px');
      });
  </script>
 <?php } ?>
<?php if(!$this->is_ajax){ ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
  <ul class="sesbusinessoffer_offers_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>
<?php foreach($this->paginator as $item): ?>
  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
  <?php if($this->view_type == 'grid'):?>
    <?php $height = $this->params['height_grid'];?>
    <?php $width = $this->params['width_grid'];?>
    <?php $viewTypeClass = "sesbusinessoffer_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/offer/_gridView.tpl';?>
  <?php elseif($this->view_type == 'list'):?>
    <?php $height = $this->params['height'];?>
    <?php $width = $this->params['width'];?>
    <?php $viewTypeClass = "sesbusinessoffer_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/offer/_listView.tpl';?>
  <?php endif;?>
<?php endforeach;?>

<?php  if(  $this->paginator->getTotalItemCount() == 0):  ?>
  <div id="browse-widget_<?php echo $randonNumber;?>" style="width:100%;">
    <div id="error-message_<?php echo $randonNumber;?>">
      <div class="sesbasic_tip clearfix">
        <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessoffer_business_no_photo', 'application/modules/Sesbusiness/externals/images/business-icon.png'); ?>" alt="" />
        <span class="sesbasic_text_light">
          <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
        </span>
      </div>
    </div>
  </div>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'none');</script>
<?php else:?>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'block');</script>
<?php endif; ?>
<?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusiness"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
</div>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  en4.core.runonce.add(function () {
    if(sesJqueryObject('.sesbusinessoffer_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.sesbusinessoffer_browse_search').find('#filter_form');
      searchParams<?php echo $randonNumber; ?> = search.serialize();
    }
  });
  var requestTab_<?php echo $randonNumber; ?>;
  var valueTabData ;
    // globally define available tab array
  <?php if($this->params['pagging'] == 'auto_load' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')){ ?>
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
    if(sesJqueryObject(this).hasClass('active'))
    return;
    if($("view_more_<?php echo $randonNumber; ?>"))
      document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
    document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
    sesJqueryObject('#sesbusinessoffer_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#sesbusinessoffer_list_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
    sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
    sesJqueryObject(this).addClass('active');
    if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
      requestTab_<?php echo $randonNumber; ?>.cancel();
    }
    if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
      requestViewMore_<?php echo $randonNumber; ?>.cancel();
    }
    requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesbusinessoffer/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
      'data': {
          format: 'html',
          business: 1,
          type:sesJqueryObject(this).attr('rel'),
          is_ajax : 1,
          searchParams: searchParams<?php echo $randonNumber; ?>,
          identity : '<?php echo $randonNumber; ?>',
          widget_id: '<?php echo $this->widgetId;?>',
          getParams:'<?php echo $this->getParams;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          business_id:'<?php echo $businessId;?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalBusiness= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesbusinessoffer_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesbusiness').html(totalBusiness.html());
        totalBusiness.remove();
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
  var business<?php echo $randonNumber; ?> = '<?php echo $this->business + 1; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  var is_search_<?php echo $randonNumber;?> = 0;
  var isSearch = true;
  <?php if($this->params['pagging'] != 'pagging'){ ?>

    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
      en4.core.runonce.add(function () {
      viewMoreHide_<?php echo $randonNumber; ?>();
      });
    function viewMore_<?php echo $randonNumber; ?> (){
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
      if(typeof requestViewMore_<?php echo $randonNumber; ?> != "undefined"){
              requestViewMore_<?php echo $randonNumber; ?>.cancel();
      }
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinessoffer/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          business: business<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          is_search:is_search_<?php echo $randonNumber;?>,
          view_more:1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          business_id:'<?php echo $businessId;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsesbusiness-wrapper'))
            sesJqueryObject('#loadingimgsesbusiness-wrapper').hide();
            
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalBusiness= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesbusinessoffer_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesbusiness').html(totalBusiness.html());
            totalBusiness.remove();
            isSearch = false;
          }
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(businessNum){
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
          if(typeof requestViewMore_<?php echo $randonNumber; ?> != "undefined"){
              requestViewMore_<?php echo $randonNumber; ?>.cancel();
          }
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinessoffer/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          business: businessNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          business_id:'<?php echo $businessId;?>',  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsesbusiness-wrapper'))
            sesJqueryObject('#loadingimgsesbusiness-wrapper').hide();
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
