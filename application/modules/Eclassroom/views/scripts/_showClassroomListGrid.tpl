<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _showClassroomListGrid.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $randonNumber = $this->widgetId; ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(isset($this->classroom_id)):?>
  <?php $classroomId = $this->classroom_id;?>
<?php else:?>
  <?php $classroomId = 0;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  <style>
  .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
  <?php if(isset($this->optionsEnable) && @in_array('pinboard',$this->optionsEnable)): ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Eclassroom/externals/scripts/imagesloaded.pkgd.js');?>
     <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Courses/externals/scripts/core.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
  <?php endif;?>
  <?php if(count($this->optionsEnable) > 1){  ?>
    <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_view_type sesbasic_clearfix clear">
  <?php } ?>
<?php } ?>
    <?php if(isset($this->params['show_item_count']) || isset($this->totalClassroomActive)){ ?>
      <div class="sesbasic_clearfix sesbm classroom_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_classrooms' : 'paginator_count_ajax_classroom_entry' ?>"><span style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("Classroom found.") : $this->translate("Classrooms found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax && count($this->optionsEnable) > 1){  ?>
    <div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
      <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){  ?>
        <a href="javascript:;" rel="list" id="eclassroom_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
         <a href="javascript:;" rel="grid" id="eclassroom_grid_view_<?php echo $randonNumber; ?>" class="gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="pinboard" id="eclassroom_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Pinboard View') : '' ; ?>"></a>
     <?php } ?>
     <?php if(is_array($this->optionsEnable) && in_array('map',$this->optionsEnable) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)){ ?>
        <a href="javascript:;" rel="map" id="eclassroom_map_view_<?php echo $randonNumber; ?>" class="mapicon map_selectView_<?php echo $randonNumber;?> selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'map') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Map View') : '' ; ?>"></a>
     <?php } ?>
    </div>
  </div>
<?php } ?>
<?php if(!isset($this->bothViewEnable) && !$this->is_ajax){ ?>
  <script type="text/javascript">
      en4.core.runonce.add(function() {
         // sesJqueryObject('.sesbasic_view_type_<?php// echo $randonNumber ?>').addClass('displayFN');
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber ?>').parent().parent().css('border', '0px');
      });
  </script>
 <?php } ?>
<?php if(!$this->is_ajax){ ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
  <ul class="eclassroom_listing sesbasic_clearfix clear <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>
<?php foreach($this->paginator as $classroom): ?>
  <?php $item = $classroom ;?>
     <?php if (!empty($classroom->category_id)): ?>
    <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
  <?php endif;?> 
    <?php if($this->view_type == 'list'): ?>
       <?php $height = $this->params['height'];?>
      <?php $width = $this->params['width'];?>
      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_listView.tpl';?>
    <?php elseif($this->view_type == 'grid'): ?>
       <?php $height = $this->params['height_grid'];?>
      <?php $width = $this->params['width_grid'];?>
      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_gridView.tpl';?>
    <?php elseif($this->view_type == 'pinboard'): ?>
     <?php $height = $this->params['height_pinboard'];?>
      <?php $width = $this->params['width_pinboard'];?>
      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_pinboardView.tpl';?>
    <?php elseif($this->view_type == 'map'):?>
    <?php if($classroom->lat): ?>
    <?php
      // Show Label
      $labels = '';
      if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)) {
        $labels .= "<p class=\"eclassroom_labels\">";
        if(isset($this->featuredLabelActive) && $classroom->featured == 1) {
          $labels .= "<span class=\"eclassroom_label_featured\">FEATURED</span>";
        }
        if(isset($this->sponsoredLabelActive) && $classroom->sponsored == 1) {
          $labels .= "<span class=\"eclassroom_label_sponsored\">SPONSORED</span>";
        }
        $labels .= "</p>";
        if(isset($this->verifiedLabelActive) && $classroom->verified == 1) {
          $labels .= "<div class=\"eclassroom_verified_label\" title=\"VERIFIED\"><i class=\"fa fa-check\"></i></div>";
        }
      }
      $location = '';?>
      <?php if(isset($this->locationActive) && $classroom->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)):?>
      <?php $locationText = $this->translate('Location');?>
      <?php $locationvalue = $classroom->location;?>
      <?php $location = "<div class=\"eclassroom_list_stats eclassroom_list_location\">
                          <span class=\"widthfull\">
                            <i class=\"fa fa-map-marker sesbasic_text_light\" title=\"$locationText\"></i>
                            <span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $classroom->classroom_id,'resource_type'=>'classroom','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"openSmoothbox\">$locationvalue</a></span>
                          </span>
                        </div>"; 
      ?>
      <?php endif;?>
        <?php 
        $canComment =  $classroom->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
        $likeButton = '';
        if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive) && $canComment){
          $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($classroom->classroom_id,$classroom->getType());
          $likeClass = ($LikeStatus) ? ' button_active' : '' ;
          $likeButton = '<a href="javascript:;" data-url="'.$classroom->getIdentity().'" data-type="eclassroom_like_view" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eclassroom_like_'. $classroom->classroom_id.' eclassroom_likefavfollow '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$classroom->like_count.'</span></a>';
        }
        $favouriteButton = '';
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allowfavourite', 1) && isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($classroom->favourite_count)){
          $favStatus = Engine_Api::_()->getDbtable('favourites', 'eclassroom')->isFavourite(array('resource_type'=>'classroom','resource_id'=>$classroom->classroom_id));
          $favClass = ($favStatus)  ? 'button_active' : '';
          $favouriteButton = '<a href="javascript:;" data-type="eclassroom_favourite_view" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eclassroom_likefavfollow eclassroom_favourite_'. $classroom->classroom_id.' '.$favClass .'" data-url="'.$classroom->getIdentity().'"><i class="fa fa-heart"></i><span>'.$classroom->favourite_count.'</span></a>';
        }
      $listButton = '';
      if(isset($this->listButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity()) {
        $URL = $this->url(array('action' => 'add','module'=>'eclassroom','controller'=>'list','classroom_id'=>$classroom->classroom_id),'default',true);
        $listButton = "<a href='javascript:;' onclick='opensmoothboxurl(\"$URL\")' class='sesbasic_icon_btn  eclassroom_add_list'  title='".$this->translate('Add To List')."' data-url='$classroom->classroom_id'><i class='fa fa-plus'></i></a>";
      }
      $user = Engine_Api::_()->getItem('user',$classroom->owner_id);
      $owner = $classroom->getOwner();
      $ratings = '';
      if( $this->ratingActive){
          if( $classroom->rating > 0 ): 
            $ratings .= '
  <div class="eclassroom_list_grid_rating" title="'.$this->translate(array('%s rating', '%s ratings', $classroom->rating), $this->locale()->toNumber($classroom->rating)).'">';
            for( $x=1; $x<= $classroom->rating; $x++ ): 
              $ratings .= '<span class="sesbasic_rating_star_small fa fa-star"></span>';
              endfor; 
              if( (round($classroom->rating) - $classroom->rating) > 0): 
              $ratings.= '<span class="sesbasic_rating_star_small fa fa-star-half"></span>';
              endif; 
              $ratings .= '</div>';
            endif;
      }
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $classroom->getHref());
      if(isset($this->byActive)){
        $owner ='<div class="eclassroom_grid_date eclassroom_list_stats sesbasic_text_light"><span><i class="fa fa-user"></i>'.$this->htmlLink($owner->getHref(),$owner->getTitle()).'</span></div>';
      }else
        $owner = '';
    $stats = $classroomStartEndDate.$ratings.'<div class="sesbasic_largemap_stats eclassroom_list_stats sesbasic_clearfix">';
    if(isset($this->commentActive)){
    $stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $classroom->comment_count), $this->locale()->toNumber($classroom->comment_count)).'"><i class="fa fa-comment"></i>'.$classroom->comment_count.'</span>';
    }
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allowfavourite', 1) && isset($this->favouriteActive)){
    $stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $classroom->favourite_count), $this->locale()->toNumber($classroom->favourite_count)).'"><i class="fa fa-heart"></i>'. $classroom->favourite_count.'</span>';
    }
    if(isset($this->viewActive)){
    $stats .= '<span title="'. $this->translate(array('%s view', '%s views', $classroom->view_count), $this->locale()->toNumber($classroom->view_count)).'"><i class="fa fa-eye"></i>'.$classroom->view_count.'</span>';
    }
    if(isset($this->likeActive)){
    $stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $classroom->like_count), $this->locale()->toNumber($classroom->like_count)).'"><i class="fa fa-thumbs-up"></i>'.$classroom->like_count.'</span> ';
    }
    $stats .= '</div>';
    
    if(isset($this->socialSharingActive)){
    $socialShare = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $classroom, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit));
    $socialshare = '<div class="eclassroom_grid_btns">'.$socialShare.$likeButton.$favouriteButton.$listButton.'</div>';

    }else
      $socialshare = $likeButton.$favouriteButton.$listButton;
          $locationArray[$counter]['id'] = $classroom->getIdentity();
          $locationArray[$counter]['owner'] = $owner;
          $locationArray[$counter]['location'] = $location;
          $locationArray[$counter]['labels'] = $labels;
          $locationArray[$counter]['stats'] = $stats;
          $locationArray[$counter]['socialshare'] = $socialshare;
          $locationArray[$counter]['lat'] = $classroom->lat;
          $locationArray[$counter]['lng'] = $classroom->lng;
          $locationArray[$counter]['iframe_url'] = '';
          $locationArray[$counter]['image_url'] = $classroom->getPhotoUrl();
          $locationArray[$counter]['title'] = '<a href="'.$classroom->getHref().'">'.$classroom->title.'</a>';
          //$locationArray[$counter]['description'] = $classroom->description;      
        $counter++;?>
      <?php endif;?>
      
    <?php endif;?>
<?php endforeach;?>
<?php if($this->view_type == 'map'): ?>
  <div id="map-data_<?php echo $randonNumber;?>" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
  <?php if(!$this->view_more || $this->is_search):?>
    <li id="classroom_map_view_<?php echo $randonNumber;?>" style="width:100%">
      <div id="map-canvas-<?php echo $randonNumber;?>" class="map sesbasic_large_map sesbm sesbasic_bxs"></div>
    </li>
  <?php endif;?>
<?php endif;?>
<?php  if($this->paginator->getTotalItemCount() == 0 && $this->view_type != 'map'): ?>
    <div id="browse-widget_<?php echo $randonNumber;?>" style="width:100%;">
    <div id="error-message_<?php echo $randonNumber; ?>">
      <div class="sesbasic_tip clearfix">
        <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.class.no.photo', 'application/modules/Eclassroom/externals/images/classroom-icon.png'); ?>" alt="" />
        <span class="sesbasic_text_light">
          <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
        </span>
        <?php if($viewerId && Engine_Api::_()->core()->hasSubject('classroom')):?>
          <?php $subject = Engine_Api::_()->core()->getSubject('classroom');?>
          <?php if((Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eclassroom', 'auth_subclass') && (!$subject->parent_id)) && Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(),$subject->getIdentity(),'auth_subclassroom')):?>
            <div class="_btn centerT">
              <a href="<?php echo $this->url(array('action' => 'create','parent_id' => $subject->getIdentity()),'eclassroom_general',true);?>" class="sesbasic_link_btn"><?php echo $this->translate("Create New Associates Sub Classroom")?></a>
            </div>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'none');</script>
<?php else:?>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'block');</script>
<?php endif; ?>

<?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>$randonNumber)); ?>
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
  sesJqueryObject(document).ready(function() {
    if(sesJqueryObject('.classroom_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.classroom_browse_search').find('#filter_form');
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
    sesJqueryObject('#eclassroom_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#eclassroom_list_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#eclassroom_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#eclassroom_map_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#eclassroom_more_<?php echo $randonNumber; ?>').css('display','none');
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
      'url': en4.core.baseUrl + "widget/index/mod/eclassroom/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
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
          classroom_id:'<?php echo $classroomId;?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalClassroom= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_classroom_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_classrooms').html(totalClassroom.html());
        totalClassroom.remove();
        if($("loading_image_<?php echo $randonNumber; ?>"))
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
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
        pinboardLayout_<?php echo $randonNumber ?>('true');
       }
      })).send();
    });
  </script>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
  <script type="application/javascript">
    var wookmark = undefined;
    //Code for Pinboard View
    var wookmark<?php echo $randonNumber ?>;
    function pinboardLayout_<?php echo $randonNumber ?>(force){
      if(sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') != 'pinboard'){
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').css('height','');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').css('display','flex');
        return;
      }
      sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
      var imgLoad = imagesLoaded('#tabbed-widget_<?php echo $randonNumber; ?>');
      imgLoad.on('progress',function(instance,image){
        sesJqueryObject(image.img).parent().parent().parent().parent().parent().show();
        sesJqueryObject(image.img).parent().parent().parent().parent().parent().removeClass('new_image_pinboard_<?php echo $randonNumber; ?>');
        imageLoadedAll<?php echo $randonNumber ?>(force);
      });
    }
    function imageLoadedAll<?php echo $randonNumber ?>(force){
      sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
      sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
      if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
        (function() {
          function getWindowWidth() {
            return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
          }				
          wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
            itemWidth: <?php echo isset($this->params['width_pinboard']) ? str_replace(array('px','%'),array(''),$this->params['width_pinboard']) : '300'; ?>, // Optional min width of a grid item
            outerOffset: 0, // Optional the distance from grid to parent
            align:'left',
            flexibleWidth: function () {
              // Return a maximum width depending on the viewport
              return getWindowWidth() < 1024 ? '100%' : '40%';
            }
          });
        })();
      } else {
        wookmark<?php echo $randonNumber ?>.initItems();
        wookmark<?php echo $randonNumber ?>.layout(true);
      }
    }
    sesJqueryObject(window).resize(function(e){
      pinboardLayout_<?php echo $randonNumber ?>('',true);
    });
    <?php if($this->view_type == 'pinboard'):?>
      sesJqueryObject(document).ready(function(){
        pinboardLayout_<?php echo $randonNumber ?>();
      });
    <?php endif;?>
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
        'url': en4.core.baseUrl + "widget/index/mod/eclassroom/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          classroom_id:'<?php echo $classroomId;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgeclassroom-wrapper'))
            sesJqueryObject('#loadingimgeclassroom-wrapper').hide();
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
            sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          var totalClassroom= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_classroom_entry");
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_classrooms').html(totalClassroom.html());
          totalClassroom.remove();
          
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
            if(document.getElementById('classroom_map_view_<?php echo $randonNumber;?>'))	
              document.getElementById('classroom_map_view_<?php echo $randonNumber;?>').style.display = 'block';
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
          pinboardLayout_<?php echo $randonNumber ?>('true');
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
        'url': en4.core.baseUrl + "widget/index/mod/eclassroom/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          classroom_id:'<?php echo $classroomId;?>',  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgeclassroom-wrapper'))
            sesJqueryObject('#loadingimgeclassroom-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          var totalClassroom= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_classroom_entry");
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_classrooms').html(totalClassroom.html());
          totalClassroom.remove();
            
          if(isSearch){
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
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
          pinboardLayout_<?php echo $randonNumber ?>('true');
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
                             
<!--Start Map Work on Classroom Load-->
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
      if(sesJqueryObject('.map_selectView_<?php echo $randonNumber;?>').hasClass('active')) {
        if(!newMapData_<?php echo $randonNumber ?>)
        return false;
        <?php if($this->loadOptionData == 'pagging'){ ?>DeleteMarkers_<?php echo $randonNumber ?>();<?php }?>
        google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
        markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
        if(markerArrayData_<?php echo $randonNumber?>.length)
        newMarkerLayout_<?php echo $randonNumber?>();
        newMapData_<?php echo $randonNumber ?> = '';
        sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
      }
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
        zoom: 17,
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
    };
    var markerArrayData_<?php echo $randonNumber?> ;
    var markerData_<?php echo $randonNumber ?> =[];
    var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
    function newMarkerLayout_<?php echo $randonNumber?>(dataLenth){
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
        //animate class "animated bounce"
        var images = '<div class="image eclassroom_map_thumb_img"><img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'"  /></div>';		
        var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
        var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
        var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
        var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
        var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
        var marker_html = '<div class="pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
            '<div class="wrapper">' +
              '<div class="small">' +
                '<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
              '</div>' +
              '<div class="large"><div class="eclassroom_map_thumb eclassroom_grid_btns_wrap">' +
                images+labels+socialshare+
                '</div><div class="sesbasic_large_map_content eclassroom_large_map_content sesbasic_clearfix">' +
                  '<div class="sesbasic_large_map_content_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+'</div>' +owner+location+stats+
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
          previousIndex = sesJqueryObject('.marker_'+ id).parent().parent().css('z-index');
          sesJqueryObject('.marker_'+ id).parent().parent().css('z-index','9999');
          sesJqueryObject('.pin').removeClass('active').css('z-index', 10);
          sesJqueryObject('.marker_'+ id).addClass('active').css('z-index', 200);
          sesJqueryObject('.marker_'+ id+' .large .close').click(function(){
          sesJqueryObject(this).parent().parent().parent().parent().parent().css('z-index',previousIndex);
            sesJqueryObject('.pin').removeClass('active');
            return false;
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
	<?php if($this->view_type == 'map'){?>
      window.addEvent('domready', function() {
        var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
        if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
          newMapData_<?php echo $randonNumber ?> = mapData;
          sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
          mapFunction_<?php echo $randonNumber?>();
          sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked')
        }
        else{
          if(typeof  map_<?php echo $randonNumber;?> == 'undefined') {
            sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
            initialize_<?php echo $randonNumber?>();	
          }
        }
      });
	<?php } ?>
  </script>
<?php endif;?>
