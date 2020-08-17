<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showPageLocationsListGrid.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = $this->widgetId; ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(!$this->is_ajax){ ?>
  <a href="javascript:;" id="sespage_browse_location" class="sessmoothbox" style="display:none;">MAP</a>
  <style>
    .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>

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
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs sespage_locations_conteiner">
	<div class="_listing" id="sespagelocation_content">
    <?php if($this->paginator->getTotalItemCount() > 0 && isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
      <div class="sesbasic_clearfix sesbm _result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sespage' : 'paginator_count_ajax_sespage_entry' ?>"><span id="total_item_count_sespage_entry"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("page found.") : $this->translate("pages found."); ?></div>
    <?php } ?>
  <ul class="sespage_page_listing sesbasic_clearfix clear  <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
<?php foreach($this->paginator as $page):?>
  <?php if (!empty($page->category_id)):?>
    <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
  <?php endif;?> 
  <?php if($this->view_type == 'list'):?>
    <?php $height = $this->params['height'];?>
    <?php $width = $this->params['width'];?>
    <?php $viewTypeClass = "sespage_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/page/_advListView.tpl';?>
  <?php endif; ?>
<?php endforeach;?>
<?php if(!$this->is_ajax){ ?>
		</ul>
    <?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sespage"),array('identityWidget'=>$randonNumber)); ?>
    <?php endif;?>
    <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
      <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
        <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>  
      <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
    <?php endif;?>
  </div>
<?php } ?>
<?php // map view work ?>
<?php foreach($this->paginator as $page):?>
  <?php if($page->lat): ?>
    <?php
    $locationArray[$counter]['id'] = $page->getIdentity();
    $locationArray[$counter]['lat'] = $page->lat;
    $locationArray[$counter]['lng'] = $page->lng;
    $locationArray[$counter]['image_url'] = $page->getPhotoUrl();
    $counter++;?>
  <?php endif;?>
<?php endforeach;?>
<?php if( $this->paginator->getTotalItemCount() > 0 ) { ?>
  <div class="_map" id="sespagelocation_map">
    <div id="map-data_<?php echo $randonNumber;?>" style="display:none;"><?php echo json_encode(@$locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
    <?php if(!$this->view_more || $this->is_search): ?>
      <div class="_map_inner" id="sespage_map_view_<?php echo $randonNumber;?>" style="width:100%">
        <div id="map-canvas-<?php echo $randonNumber;?>" class="map sesbasic_large_map sesbm sesbasic_bxs"></div>
      </div>
    <?php endif;?>
  </div>
<?php } ?>
<?php if( $this->paginator->getTotalItemCount() == 0 && $this->view_type != 'map'):  ?>
  <div id="browse-widget_<?php echo $randonNumber;?>" style="width:100%;">
    <div id="error-message_<?php echo $randonNumber;?>">
      <div class="sesbasic_tip clearfix">
        <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_page_no_photo', 'application/modules/Sespage/externals/images/page-icon.png'); ?>" alt="" />
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
<?php if(!$this->is_ajax){ ?>

</div>

<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  en4.core.runonce.add(function () {
    if(sesJqueryObject('.sespage_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.sespage_browse_search').find('#filter_form');
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
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sespage_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sespage').html(totalPage.html());
        totalPage.remove();
        
        if($("loading_image_<?php echo $randonNumber; ?>"))
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
          
        if(document.getElementById('map-data_<?php echo $randonNumber;?>')){
          var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              oldMapData_<?php echo $randonNumber; ?> = [];
              newMapData_<?php echo $randonNumber ?> = mapData;
              loadMap_<?php echo $randonNumber ?> = true;
              sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
              initialize_<?php echo $randonNumber?>();	
              mapFunction_<?php echo $randonNumber?>();
            }
            else {
              sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
              initialize_<?php echo $randonNumber?>();	
            }
        }
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
  var searchParams<?php echo $randonNumber; ?> ;
  var is_search_<?php echo $randonNumber;?> = 0;
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
        'url': en4.core.baseUrl + "widget/index/mod/sespage/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: page<?php echo $randonNumber; ?>,    
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
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
            sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sespage_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sespage').html(totalPage.html());
            totalPage.remove();
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>')) {
            if(document.getElementById('sespage_map_view_<?php echo $randonNumber;?>'))	
              document.getElementById('sespage_map_view_<?php echo $randonNumber;?>').style.display = 'block';
            var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              newMapData_<?php echo $randonNumber ?> = mapData;
              for(var i=0; i < mapData.length; i++) {
                var isInsert = 1;
                for(var j= 0;j < oldMapData_<?php echo $randonNumber; ?>.length; j++){
                  if(oldMapData_<?php echo $randonNumber; ?>[j]['id'] == mapData[i]['id']){
                    isInsert = 0;
                    break;
                  }
                }
                if(isInsert){
                  oldMapData_<?php echo $randonNumber; ?>.push(mapData[i]);
                }
              }	
              loadMap_<?php echo $randonNumber;?> = true;
              mapFunction_<?php echo $randonNumber?>();
            }
            else{
              if(typeof  map_<?php echo $randonNumber;?> == 'undefined'){
                sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
                initialize_<?php echo $randonNumber?>();	
              }	
            }
          }
          else{
            oldMapData_<?php echo $randonNumber; ?> = [];	
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
        'url': en4.core.baseUrl + "widget/index/mod/sespage/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          if(isSearch){
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>')){
            var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              oldMapData_<?php echo $randonNumber; ?> = [];
              newMapData_<?php echo $randonNumber ?> = mapData;
              loadMap_<?php echo $randonNumber ?> = true;
              sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
              mapFunction_<?php echo $randonNumber?>();
            }
            else{
              sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
              initialize_<?php echo $randonNumber?>();	
            }
          }
          else{
            oldMapData_<?php echo $randonNumber; ?> = [];	
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
                             
<!--Start Map Work on Page Load-->
<?php if(!$this->is_ajax): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
  <script type="application/javascript">
    var  loadMap_<?php echo $randonNumber;?> = false;
    var newMapData_<?php echo $randonNumber ?> = [];
    function mapFunction_<?php echo $randonNumber?>(){
      if(!map_<?php echo $randonNumber;?> || loadMap_<?php echo $randonNumber;?>){
        initialize_<?php echo $randonNumber?>();
        loadMap_<?php echo $randonNumber;?> = false;
      }
      //if(sesJqueryObject('.map_selectView_<?php echo $randonNumber;?>').hasClass('active')) {
        if(!newMapData_<?php echo $randonNumber ?>)
        return false;
        <?php if($this->loadOptionData == 'pagging'){ ?>DeleteMarkers_<?php echo $randonNumber ?>();<?php }?>
        google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
        markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
        if(markerArrayData_<?php echo $randonNumber?>.length)
        newMarkerLayout_<?php echo $randonNumber?>();
        newMapData_<?php echo $randonNumber ?> = '';
        //sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
      //}
    }
    var isSearch = false;
    var oldMapData_<?php echo $randonNumber; ?> = [];
    var markers_<?php echo $randonNumber;?>  = [];
    var map_<?php echo $randonNumber;?>;
    if('<?php echo $this->lat; ?>' == '') {
      var latitude_<?php echo $randonNumber;?> = '26.9110600';
      var longitude_<?php echo $randonNumber;?> = '75.7373560';
    }else{
      var latitude_<?php echo $randonNumber;?> = '<?php echo $this->lat; ?>';
      var longitude_<?php echo $randonNumber;?> = '<?php echo $this->lng; ?>';
    }
    function initialize_<?php echo $randonNumber?>() {
      var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
      map_<?php echo $randonNumber;?> = new google.maps.Map(document.getElementById('map-canvas-<?php echo $randonNumber;?>'), {
        zoom: 4,
        scrollwheel: true,
        center: new google.maps.LatLng(latitude_<?php echo $randonNumber;?>, longitude_<?php echo $randonNumber;?>),
      });
      oms_<?php echo $randonNumber;?> = new OverlappingMarkerSpiderfier(map_<?php echo $randonNumber;?>,
      {nearbyDistance:40,circleSpiralSwitchover:0 });
    }
    var countMarker_<?php echo $randonNumber;?> = 0;
    function DeleteMarkers_<?php echo $randonNumber ?>(){
      //Loop through all the markers and remove
      for (var i = 0; i < markers_<?php echo $randonNumber;?>.length; i++) {
        markers_<?php echo $randonNumber;?>[i].setMap(null);
      }
      markers_<?php echo $randonNumber;?> = [];
      markerData_<?php echo $randonNumber ?> = [];
      markerArrayData_<?php echo $randonNumber?> = [];
    }
    
    var markerArrayData_<?php echo $randonNumber?> ;
    var markerData_<?php echo $randonNumber ?> =[];
    var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
    
    function newMarkerLayout_<?php echo $randonNumber?>(dataLenth) {
    
      if(typeof dataLenth != 'undefined') {
        initialize_<?php echo $randonNumber?>();
        markerArrayData_<?php echo $randonNumber?> = sesJqueryObject.parseJSON(dataLenth);
      }
      if(!markerArrayData_<?php echo $randonNumber?>.length)
      return;
      DeleteMarkers_<?php echo $randonNumber ?>();
      markerArrayData_<?php echo $randonNumber?> = oldMapData_<?php echo $randonNumber; ?>;
      var bounds = new google.maps.LatLngBounds();
      for(i=0;i<markerArrayData_<?php echo $randonNumber?>.length;i++){

        var resource_id = markerArrayData_<?php echo $randonNumber?>[i]['id'];
        var animateClass = 'animated bounce ';

        //animate class "animated bounce"
        var marker_html = '<div data-url="sespage/index/mapmarkercontent/page_id/'+resource_id+'" data-id="'+resource_id+'" class="'+animateClass+'pin public sespage_browse_location marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
        '<div class="wrapper">' +
        '<div class="small">' +
        '<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
        '</div>' +
        '<a class="icn close" href="javascript:;" title="Close"><i class="fa fa-close"></i></a>' + 
        '</div>' +
        '</div>' +
        '<span class="sesbasic_largemap_pointer"></span>' +
        '</div>';
                
        markerData = new RichMarker({
          position: new google.maps.LatLng(markerArrayData_<?php echo $randonNumber?>[i]['lat'], markerArrayData_<?php echo $randonNumber?>[i]['lng']),
          map: map_<?php echo $randonNumber;?>,
          flat: true,
          draggable: false,
          scrollwheel: false,
          id:countMarker_<?php echo $randonNumber;?>,
          anchor: RichMarkerPosition.BOTTOM,
          content: marker_html,
        });

        oms_<?php echo $randonNumber;?>.addListener('click', function(marker) {
          var id = marker.markerid;
          sesJqueryObject('#sespage_browse_location').attr('data-url', sesJqueryObject('.marker_'+ id).attr('data-url'));
          sesJqueryObject('#sespage_browse_location').trigger('click');
          sesJqueryObject('.sespage_manage_listing_item').removeClass('_browse_location_heightlight');
          sesJqueryObject('#sespage_manage_listing_item_'+sesJqueryObject('.marker_'+ id).attr('data-id')).addClass('_browse_location_heightlight');
        });

        $$('.sespage_browse_location_' + resource_id).each(function(markers_<?php echo $randonNumber;?>) {
          markers_<?php echo $randonNumber;?>.addEvent('mouseover',function(marker) {

            //sesJqueryObject('#sespage_browse_location').attr('data-url', 'sespage/index/mapmarkercontent/page_id/'+resource_id);
            //sesJqueryObject('#sespage_browse_location').trigger('click');
          });
        });


        markers_<?php echo $randonNumber;?> .push( markerData);
        markerData.setMap(map_<?php echo $randonNumber;?>);
        bounds.extend(markerData.getPosition());
        markerData.markerid = countMarker_<?php echo $randonNumber;?>;
        oms_<?php echo $randonNumber;?>.addMarker(markerData);
        countMarker_<?php echo $randonNumber;?>++;
      }
      map_<?php echo $randonNumber;?>.fitBounds(bounds);
    }

    en4.core.runonce.add(function () {
      var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
      if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
        newMapData_<?php echo $randonNumber ?> = mapData;
        sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
        initialize_<?php echo $randonNumber?>();	
        mapFunction_<?php echo $randonNumber?>();
      }
      else {
        if(typeof  map_<?php echo $randonNumber;?> == 'undefined') {
          sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
          initialize_<?php echo $randonNumber?>();	
        }
      }
    });
  </script>
<?php endif;?>