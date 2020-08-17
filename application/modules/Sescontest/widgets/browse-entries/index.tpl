<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = $this->widgetId; ?>
<?php $widgetName = '';?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php if(!$this->is_ajax){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'); ?>
  <?php if(isset($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)):?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
  <?php endif;?>
  <div class="sesbasic_view_type_<?php echo $randonNumber; ?> sesbasic_clearfix clear sesbasic_view_type">
<?php } ?>
    <?php if(isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
        <div class="sesbasic_clearfix sesbm sescontest_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sescontest' : 'paginator_count_ajax_sescontest_entry' ?>"><span id="total_item_count_sescontest_entry" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("entry found.") : $this->translate("entries found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax){ ?>
    <div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
      <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="list" id="sescontest_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="grid" id="sescontest_grid_view_<?php echo $randonNumber; ?>" class="gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>
        <a href="javascript:;" rel="pinboard" id="sescontest_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Pinboard View') : '' ; ?>"></a>
      <?php } ?>
    </div>
  </div>
<?php } ?>
<?php if(!isset($this->bothViewEnable) && !$this->is_ajax){ ?>
  <script type="text/javascript">
      en4.core.runonce.add(function() {
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber ?>').addClass('displayFN');
      });
  </script>
 <?php } ?>
<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sescontest_winners_listing sesbasic_clearfix sesbasic_bxs">
    <ul id="tabbed-widget_<?php echo $randonNumber; ?>" class="sescontest_winners_list sesbasic_clearfix <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php foreach($this->paginator as $entry):?>
      <?php $contest = Engine_Api::_()->getItem('contest', $entry->contest_id);?>
      <?php if($contest->contest_type == 1):?>
        <?php $contestType =  $this->translate('Blog Contest');?>
        <?php $action = 'text';?>
        <?php $imageClass = 'fa fa-file-text-o';?>
      <?php elseif($contest->contest_type == 2):?>
        <?php $contestType =  $this->translate('Photo Contest');?>
        <?php $action = 'photo';?>
        <?php $imageClass = 'fa fa-picture-o';?>
      <?php elseif($contest->contest_type == 3):?>
        <?php $contestType =  $this->translate('Video Contest');?>
        <?php $action = 'video';?>
        <?php $imageClass = 'fa fa-video-camera';?>
      <?php else:?>
        <?php $contestType =  $this->translate('Music Contest');?>
        <?php $action = 'audio';?>
        <?php $imageClass = 'fa fa-music';?>
      <?php endif;?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('participant', $this->viewer(), 'comment');?>
      <?php $likeStatus = Engine_Api::_()->sescontest()->getLikeStatus($entry->participant_id,$entry->getType()); ?>
      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sescontest')->isFavourite(array('resource_id' => $entry->participant_id,'resource_type' => $entry->getType())); ?>
      <?php $owner = $entry->getOwner();?>
      <?php if($this->view_type == 'grid'):?>
        <?php $height = $this->params['height_grid'];?>
        <?php $width = $this->params['width_grid'];?>
        <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/winners/_gridView.tpl';?>
      <?php elseif($this->view_type == 'list'):?>
        <?php $height = $this->params['height_list'];?>
        <?php $width = $this->params['width_list'];?>
        <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/winners/_listView.tpl';?>
      <?php elseif($this->view_type == 'pinboard'):?>
        <?php $width = $this->params['width_pinboard'];?>
        <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/winners/_pinboardView.tpl';?>
      <?php endif;?>
    <?php endforeach;?>
    <?php  if(  $this->paginator->getTotalItemCount() == 0):  ?>
      <div id="browse-widget_<?php echo $randonNumber;?>" class="">
        <div id="error-message_<?php echo $randonNumber;?>">
          <div class="sesbasic_tip clearfix">
            <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('contest_no_photo', 'application/modules/Sescontest/externals/images/contest-icon.png'); ?>" alt="" />
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
    <?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['fixed_data']) || $this->params['fixed_data'] == 'no')): ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sescontest"),array('identityWidget'=>$randonNumber)); ?>
    <?php endif;?>
<?php if(!$this->is_ajax){ ?>
    </ul>
    <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['fixed_data']) || $this->params['fixed_data'] == 'no')):?>
      <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
        <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php $randonNumber; ?>">
          <i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span>
        </a>
      </div>  
      <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
    <?php endif;?>
  </div>
<script type="text/javascript">
    var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
    var searchParams<?php echo $randonNumber; ?> ;
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
		<?php if($this->params['pagging'] == 'auto_load'  && (!isset($this->params['fixed_data']) || $this->params['fixed_data'] == 'no')){ ?>
			window.addEvent('load', function() {
				sesJqueryObject(window).scroll( function() {
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('view_more_<?php echo $randonNumber; ?>').click();
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
      sesJqueryObject('#sescontest_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sescontest_list_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sescontest_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
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
        'url': en4.core.baseUrl + "widget/index/mod/sescontest/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
        'data': {
          format: 'html',
          page: 1,
          type:sesJqueryObject(this).attr('rel'),
          is_ajax : 1,
          searchParams: searchParams<?php echo $randonNumber; ?>,
          identity : '<?php echo $randonNumber; ?>',
          widget_id: '<?php echo $this->widgetId;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
          if($("loading_image_<?php echo $randonNumber; ?>"))
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
          pinboardLayout_<?php echo $randonNumber ?>('true');
        }
      })).send();
    });
    
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
        var imgLoad = imagesLoaded('#tabbed-widget_<?php echo $randonNumber; ?>');console.log(imgLoad);
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
          'url': en4.core.baseUrl + "widget/index/mod/sescontest/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
              identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
            if($('loadingimgsescontest-wrapper'))
            sesJqueryObject('#loadingimgsescontest-wrapper').hide();
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalEntry= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sescontest_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sescontest').html(totalEntry.html());
            totalEntry.remove();
            document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
            pinboardLayout_<?php echo $randonNumber ?>();
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
              'url': en4.core.baseUrl + "widget/index/mod/sescontest/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
              'data': {
                format: 'html',
                page: pageNum,    
                params :params<?php echo $randonNumber; ?> , 
                is_ajax : 1,
                searchParams:searchParams<?php echo $randonNumber; ?>,
                widget_id: '<?php echo $this->widgetId;?>',
                type:'<?php echo $this->view_type;?>',
              },
              onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                if($('loading_images_browse_<?php echo $randonNumber; ?>'))
                sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
                if($('loadingimgsescontest-wrapper'))
                sesJqueryObject('#loadingimgsescontest-wrapper').hide();
                sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
                document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
								pinboardLayout_<?php echo $randonNumber ?>()
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
