<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showStoreListGrid.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
		
?>
<?php $randonNumber = $this->widgetId; ?>
<?php $widgetType = 'profile-store';?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(isset($this->store_id)):?>
  <?php $storeId = $this->store_id;?>
<?php else:?>
  <?php $storeId = 0;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  <style>
  .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
  <?php if(isset($this->optionsEnable) && @in_array('pinboard',$this->optionsEnable)):?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
  <?php endif;?>
  <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_view_type sesbasic_clearfix clear">
<?php } ?>
    <?php if(isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
      <div class="sesbasic_clearfix sesbm estore_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_estore' : 'paginator_count_ajax_estore_entry' ?>"><span id="total_item_count_estore_entry" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("store found.") : $this->translate("stores found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax){ ?>
    <div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
      <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="list" id="estore_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
         <a href="javascript:;" rel="grid" id="estore_grid_view_<?php echo $randonNumber; ?>" class="gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('simplegrid',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="simplegrid" id="estore_simplegrid_view_<?php echo $randonNumber; ?>" class="s-gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'simplegrid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Plain Grid View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="pinboard" id="estore_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Pinboard View') : '' ; ?>"></a>
     <?php } ?>
     <?php if(is_array($this->optionsEnable) && in_array('map',$this->optionsEnable) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)){ ?>
        <a href="javascript:;" rel="map" id="estore_map_view_<?php echo $randonNumber; ?>" class="mapicon map_selectView_<?php echo $randonNumber;?> selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'map') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Map View') : '' ; ?>"></a>
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
  <ul class="estore_store_listing sesbasic_clearfix clear <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>
<?php foreach($this->paginator as $store): 	 ?>
  <?php $item = $store ;?>
  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
  <?php if (!empty($store->category_id)): ?>
    <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
  <?php endif;?> 
  <?php if(isset($this->widgetName) && $this->widgetName == 'manage-stores'): ?>
   	<?php $height = $this->params['height'];?>
    <?php $width = $this->params['width'];?>
    <?php $viewTypeClass = "estore_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_managelistView.tpl';?>
  <?php else:  ?>
    <?php  if($this->view_type == 'grid'): ?>
      <?php $height = $this->params['height_grid'];?>
      <?php $width = $this->params['width_grid'];?>
      <?php $viewTypeClass = "estore_list_type";?>
     <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_simpleGridView.tpl';?>
     <?php //include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_gridView.tpl';?>
    <?php elseif($this->view_type == 'simplegrid'):?>
      <?php $height = $this->params['height_simplegrid'];?>
      <?php $width = $this->params['width_simplegrid'];?>
      <?php $viewTypeClass = "estore_list_type";?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_simpleGridView.tpl';?>
    <?php  elseif($this->view_type == 'advlist'): ?>
      <?php $height = $this->params['height_advlist'];?>
      <?php $width = $this->params['width_advlist'];?>
      <?php $viewTypeClass = "estore_list_type";?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_advListView.tpl';?>
    <?php elseif($this->view_type == 'list'): ?>
      <?php $height = $this->params['height'];?>
      <?php $width = $this->params['width'];?>
      <?php $viewTypeClass = "estore_list_type";?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_listView.tpl';?>
    <?php  elseif($this->view_type == 'advgrid'): ?>
      <?php $height = $this->params['height_advgrid'];?>
      <?php $width = $this->params['width_advgrid'];?>
      <?php $viewTypeClass = "estore_list_type sesbasic_animation";?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_advgridView.tpl';?>
    <?php elseif($this->view_type == 'pinboard'):  ?>
      <?php $pinboardWidth = $this->params['width_pinboard'];?>
      <?php $this->height_pinboard = $pinboardHeight = $this->params['height_pinboard'];?>
      <?php $viewTypeClass = "estore_list_type";?>
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/store/_pinboardView.tpl';?>
    <?php elseif($this->view_type == 'map'):?>
      <?php $location = '';?>
      <?php if($store->lat): ?>
		<?php $labels = '';?>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
          <?php $labels .= "<div class=\"estore_list_labels\">";?>
		  <?php if(isset($this->featuredLabelActive) && $store->featured == 1):?>
            <?php $labels .= "<span class=\"estore_label_featured\" title='".$this->translate('FEATURED')."'>".$this->translate("Featured")."</span>";?>
          <?php endif;?>
          <?php if(isset($this->sponsoredLabelActive) && $store->sponsored == 1):?>
            <?php $labels .= "<span class=\"estore_label_sponsored\" title='".$this->translate('SPONSORED')."'>".$this->translate("Sponsored")."</span>";?>
          <?php endif;?>
          <?php $labels .= "<span class=\"estore_label_hot\" title='".$this->translate('HOT')."'>".$this->translate("Hot")."</span>";?>
          <?php $labels .= "</div>";?>
		<?php endif;?>
    <?php $newlabel = '';?>
		 <?php
	$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission((Engine_Api::_()->user()->getViewer()->getIdentity() ? Engine_Api::_()->user()->getViewer() : 0), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
	$currentTime = strtotime(date("Y-m-d H:i:s"));
	if(isset($this->newLabelActive) && $dayIncludeTime > $currentTime && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
    <?php $newlabel = "<div class=\"estore_newlabel\">
	<div class=\"ribbon top_left_label\">
		<span>".$this->translate("New")."</span>
	</div>
</div>";?>
  <?php endif; ?>
		<?php $vlabel = '';?>
		<?php if(isset($this->verifiedLabelActive) && $store->verified == 1) :?>
          <?php $vlabel = "<i class=\"estore_label_verified sesbasic_verified_icon\" title=\"VERIFIED\"></i>";?>
		<?php endif;?>
		<?php if($store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)):?>
          <?php $locationText = $this->translate('Location');?>
          <?php $locationvalue = $store->location;?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
           <?php $locationHref = "<a href='".$this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a>";?>
          <?php else:?>
           <?php $locationHref = $locationvalue;?>
          <?php endif;?>
          <?php $location = "<div class=\"_stats sesbasic_text_light\">
          <span class=\"widthfull\">
            <i class=\"fa fa-map-marker-alt\" title=\"$locationText\"></i>
            <span title=\"$locationvalue\">$locationHref</span>
          </span>
          </div>";?>
		<?php endif;?>
		<?php $likeButton = '';?>
		<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive)):?>
          <?php $LikeStatus = Engine_Api::_()->estore()->getLikeStatus($store->store_id,$store->getType());?>
          <?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
          <?php $likeButton = '<a href="javascript:;" data-url="'.$store->getIdentity().'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn estore_like_estore_store_'. $store->store_id.' estore_like_estore_store '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$store->like_count.'</span></a>';?>
		<?php endif;?>
		<?php $favouriteButton = '';?>
		<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($store->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.favourite', 1)){
          $favStatus = Engine_Api::_()->getDbTable('favourites', 'estore')->isFavourite(array('resource_type'=>'stores','resource_id'=>$store->store_id));
        $favClass = ($favStatus)  ? 'button_active' : '';
        $favouriteButton = '<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn  estore_favourite_estore_store_'. $store->store_id.' estore_favourite_estore_store '.$favClass .'" data-url="'.$store->getIdentity().'"><i class="fa fa-heart"></i><span>'.$store->favourite_count.'</span></a>';
		}?>
		<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $store->getHref());?>
		<?php $stats = '<div class="_stats sesbasic_text_light">';
		if(isset($this->commentActive)){
          $stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)).'"><i class="far fa-comment"></i>'.$store->comment_count.'</span>';
		}
		if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.favourite', 1)){
          $stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)).'"><i class="far fa-heart"></i>'. $store->favourite_count.'</span>';
		}
		if(isset($this->viewActive)){
			$stats .= '<span title="'. $this->translate(array('%s view', '%s views', $store->view_count), $this->locale()->toNumber($store->view_count)).'"><i class="far fa-eye"></i>'.$store->view_count.'</span>';
		}
		if(isset($this->likeActive)){
			$stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $store->like_count), $this->locale()->toNumber($store->like_count)).'"><i class="far fa-thumbs-up"></i>'.$store->like_count.'</span> ';
		}
		?>
   <?php if(isset($this->memberActive)){
      $stats .= '<span title=""><i class="far fa-user"></i>&nbsp; '.$store->member_count.'</span>';
    }
    ?>
	  <?php $stats .= '</div>';?>
      <?php $socialshare = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $store, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
      <?php $buttons = '<div class="_btns sesbasic_animation">'.$socialshare.$likeButton.$favouriteButton.'</div>';?>
      <?php $date = $this->partial('_date.tpl','estore',array('mapstore' => $store)); ?>
      <?php $owner = $store->getOwner();
        $owner =  '<div class="_stats sesbasic_text_light"><span><i class="far fa-user"></i>'.$this->translate("by ") .$this->htmlLink($owner->getHref(),$owner->getTitle() ).'</span>&nbsp;'.$date.'<span><i class="far fa-folder-open"></i>'.$category.'</span></div>';
        $locationArray[$counter]['id'] = $store->getIdentity();
        $locationArray[$counter]['owner'] = $owner;
        $locationArray[$counter]['location'] = $location;
        $locationArray[$counter]['stats'] = $stats;
        $locationArray[$counter]['buttons'] = $buttons;
        $locationArray[$counter]['lat'] = $store->lat;
        $locationArray[$counter]['lng'] = $store->lng;
        $locationArray[$counter]['labels'] = $labels;
        $locationArray[$counter]['vlabel'] = $vlabel;
        $locationArray[$counter]['newlabel'] = $newlabel;
        $locationArray[$counter]['category'] = $category;
        $locationArray[$counter]['iframe_url'] = '';
        $locationArray[$counter]['image_url'] = $store->getPhotoUrl();
        $locationArray[$counter]['sponsored'] = $store->sponsored;
        $locationArray[$counter]['title'] = '<a href="'.$store->getHref().'">'.$store->getTitle().'</a>';  
        $counter++;?>
      <?php endif;?>
    <?php endif;?>
  <?php endif;?>
<?php endforeach;?>
<?php if($this->view_type == 'map'):?>
  <div id="map-data_<?php echo $randonNumber;?>" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
  <?php if(!$this->view_more || $this->is_search):?>
    <li id="estore_map_view_<?php echo $randonNumber;?>"  class="estore_map_view" style="width:100%">
      <div id="map-canvas-<?php echo $randonNumber;?>" class="map sesbasic_large_map sesbm sesbasic_bxs"></div>
    </li>
  <?php endif;?>
<?php endif;?>
<?php  if(  $this->paginator->getTotalItemCount() == 0 && $this->view_type != 'map'):  ?>
  <div id="browse-widget_<?php echo $randonNumber;?>" style="width:100%;">
    <div id="error-message_<?php echo $randonNumber;?>">
      <div class="sesbasic_tip clearfix">
        <img src="<?php echo Engine_Api::_()->estore()->getFileUrl(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_store_no_photo', 'application/modules/Estore/externals/images/store-icon.png')); ?>" alt="" />
        <span class="sesbasic_text_light">
          <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
        </span>
        <?php if($viewerId && Engine_Api::_()->core()->hasSubject('stores')):?>
          <?php $subject = Engine_Api::_()->core()->getSubject('stores');?>
          <?php if((Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'stores', 'auth_substore') && (!$subject->parent_id)) && Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($viewer->getIdentity(),$subject->getIdentity(),'post_behalf_store')):?>
            <div class="_btn centerT">
              <a href="<?php echo $this->url(array('action' => 'create','parent_id' => $subject->getIdentity()),'estore_general',true);?>" class="sesbasic_link_btn"><?php echo $this->translate("Create New Associates Sub Store")?></a>
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
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "estore"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-sync"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
</div>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  sesJqueryObject(document).ready(function() {
    if(sesJqueryObject('.estore_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.estore_browse_search').find('#filter_form');
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
    sesJqueryObject('#estore_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_simplegrid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_advgrid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_list_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_advlist_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#estore_map_view_<?php echo $randonNumber; ?>').removeClass('active');
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
      'url': en4.core.baseUrl + "widget/index/mod/estore/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
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
          store_id:'<?php echo $storeId;?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalStore= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_estore_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_estore').html(totalStore.html());
        totalStore.remove();
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
        'url': en4.core.baseUrl + "widget/index/mod/estore/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          store_id:'<?php echo $storeId;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgestore-wrapper'))
            sesJqueryObject('#loadingimgestore-wrapper').hide();
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
            sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalStore= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_estore_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_estore').html(totalStore.html());
            totalStore.remove();
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
            if(document.getElementById('estore_map_view_<?php echo $randonNumber;?>'))	
              document.getElementById('estore_map_view_<?php echo $randonNumber;?>').style.display = 'block';
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
        'url': en4.core.baseUrl + "widget/index/mod/estore/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          store_id:'<?php echo $storeId;?>',  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgestore-wrapper'))
            sesJqueryObject('#loadingimgestore-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
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
        

<!--Start Map Work on Store Load-->
<?php if(!$this->is_ajax && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
  <script type="text/javascript" src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/scripts/richMarker.js?c=2" defer></script>
  <script type="text/javascript" src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/scripts/marker.js" defer></script>
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
        var images = '<div class="estore_thumb_img"><span style="background-image:url('+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+');"  /></span></div>';		
        var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
        var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
				var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
				var buttons = markerArrayData_<?php echo $randonNumber?>[i]['buttons'];
        var sponsored = markerArrayData_<?php echo $randonNumber?>[i]['sponsored'];
        var vlabel = markerArrayData_<?php echo $randonNumber?>[i]['vlabel'];
				var newlabel = markerArrayData_<?php echo $randonNumber?>[i]['newlabel'];
				var category = markerArrayData_<?php echo $randonNumber?>[i]['category'];
        var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
        var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.bounce', 1); ?>;
        if(sponsored == 1 && allowBlounce)
          var animateClass = 'animated bounce ';
        else
          var animateClass = '';
        //animate class "animated bounce"
        var marker_html = '<div class="'+animateClass+'pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
        '<div class="wrapper">' +
        '<div class="small">' +
        '<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
        '</div>' +
        '<div class="large map_large_marker estore_map_item"><div class="estore_map_thumb estore_thumb">' +
        images + buttons+labels+newlabel+
        '</div><div class="_cont sesbasic_clearfix">' +
        '<div class="_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+vlabel+'</div>' +owner+stats+location+
				'</div>' +
        '<a class="icn close" href="javascript:;" title="Close"><i class="fa fa-times"></i></a>' + 
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
