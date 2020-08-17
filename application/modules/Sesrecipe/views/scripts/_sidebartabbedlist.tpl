<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sidebartabbedlist.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php  if(!$this->is_ajax): ?>
  <style>
    .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?> 
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php $moduleName = 'sesrecipe';?>

<?php $counter = 0;?>
<?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
  <script type="application/javascript">
    sesJqueryObject('#tab-widget-sesrecipe-<?php echo $randonNumber; ?>').parent().css('display','none');
    sesJqueryObject('.sesrecipe_container_tabbed<?php echo $randonNumber; ?>').css('border','none');
  </script>
<?php endif;?>


<?php $locationArray = array();?>
<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
    <ul class="sesrecipe_recipe_listing sesbasic_clearfix clear" id="sidebar-tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>

<?php foreach( $this->paginator as $item ): ?>
  <?php $href = $item->getHref();?>
  <?php $photoPath = $item->getPhotoUrl();?>
  <?php if($this->view_type == 'list'){ ?>
    <li class="sesrecipe_sidebar_recipe_list sesbasic_clearfix">
			<div class="sesrecipe_sidebar_recipe_list_img" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
        <?php $href = $item->getHref();$imageURL = $photoPath;?>
        <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>">
        	<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
      </div>
      <div class="sesrecipe_sidebar_recipe_list_cont">
        <div class="sesrecipe_sidebar_recipe_list_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
            <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
            <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
          <?php else: ?>
            <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
          <?php endif;?>
        </div>
				<?php if(isset($this->byActive) || isset($this->creationDateActive)){ ?>
          <div class="sesrecipe_sidebar_recipe_list_date">
          	<?php if(isset($this->byActive)){ ?>
              <?php $owner = $item->getOwner(); ?>
              <span>
                <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
              </span>
            <?php } ?>
            <?php if(isset($this->byActive) && isset($this->creationDateActive)){ ?><span>|</span><?php } ?>
            <?php if(isset($this->creationDateActive)){ ?>
              <span title="<?php echo date('M d, Y',strtotime($item->publish_date));?>">
              	<?php echo date('M d, Y',strtotime($item->publish_date));?>
              </span>
            <?php } ?>
          </div>
        <?php } ?>
        <?php if(isset($this->categoryActive)){ ?>
          <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
            <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <div class="sesrecipe_sidebar_recipe_list_date">
                <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category'); ?>"></i> 
                <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $this->translate($categoryItem->category_name); ?></a>
              </div>
            <?php endif;?>
          <?php endif;?>
        <?php } ?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
          <div class="sesrecipe_sidebar_recipe_list_date">
            <i class="fa fa-map-marker sesbasic_text_light"></i>
            <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
          </div>
        <?php } ?>
				<div class="sesrecipe_sidebar_recipe_list_date sesbasic_text_light">
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
        </div>
      </div>
    </li>
  <?php } else if($this->view_type == 'grid'){ ?>
  	<li class="sesrecipe_grid sesbasic_bxs <?php if((isset($this->my_recipes) && $this->my_recipes)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
    <div class="sesrecipe_grid_inner sesrecipe_thumb">
      <div class="sesrecipe_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
        <?php $href = $item->getHref();$imageURL = $photoPath;?>
        <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesrecipe_thumb_img">
        <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
          <div class="sesrecipe_grid_labels">
            <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
              <p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
              <p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
            <?php endif;?>
            <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
              <div class="sesrecipe_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
            <?php endif;?>
          </div>
        <?php endif;?>
      
        <?php if(isset($this->categoryActive)){ ?>
          <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
            <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <div class="sesrecipe_grid_memta_title">
                <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
                <?php if($categoryItem):?>
                  <span>
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                  </span>
                <?php endif;?>
              </div>
            <?php endif;?>
          <?php endif;?>
        <?php } ?>
      </div>
        <div class="sesrecipe_grid_info clear clearfix sesbm">
          <?php if(isset($this->titleActive) ){ ?>
            <div class="sesrecipe_grid_info_title">
            <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
              <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
              <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
            <?php else: ?>
              <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
            <?php endif; ?>
            </div>
          <?php } ?>
          <div class="sesrecipe_grid_meta_block">
            <?php if(isset($this->byActive)){ ?>
              <div class="sesrecipe_list_stats sesbasic_text_light">
                <span>
                  <?php $owner = $item->getOwner(); ?>
                  <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
                  <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>&nbsp;|
                </span>
              </div>
            <?php } ?>
            <?php if(isset($this->creationDateActive)): ?>
              <div class="sesrecipe_list_stats sesbasic_text_light">
                <span><i class=" fa fa-clock-o"></i> <?php echo date('M d',strtotime($item->publish_date));?></span>
              </div>
            <?php endif;?>
            <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
              <div class="sesrecipe_list_stats sesrecipe_list_location sesbasic_text_light">
                <span>
                  <i class="fa fa-map-marker"></i>
                  <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
                </span>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="sesrecipe_grid_hover_block">
          <div class="sesrecipe_grid_info_hover_title">
            <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
              <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
            <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
            <?php else: ?>
              <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
            <?php endif; ?>
            <span></span>
          </div>
          <?php  if(isset($this->descriptiongridActive)){?>
          <div class="sesrecipe_grid_des clear">
            <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_grid) ?>
          </div>
          <?php } ?>
          <div class="sesrecipe_grid_hover_block_footer">
            <div class="sesrecipe_list_stats sesbasic_text_light">
              <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
              <?php } ?>
              <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
              <?php } ?>
              <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
              <?php } ?>
              <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
              <?php } ?>
              <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
            </div>
            <div class="sesrecipe_grid_read_btn floatR"><a href="<?php echo $href; ?>">Read More...</a></div>
          </div>
        </div>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        <div class="sesrecipe_list_thumb_over"> 
          <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
          <div class="sesrecipe_list_grid_thumb_btns">
            <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

            <?php endif;?>
            <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
              <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
              <?php if(isset($this->likeButtonActive) && $canComment):?>
                <!--Like Button-->
                <?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($item->recipe_id,$item->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $item->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
              <?php endif;?>
              <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
                <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$item->recipe_id)); ?>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
              <?php endif;?>
            <?php endif;?>
          </div>
        </div>
        <?php endif;?> 
      </div>
    </li>
  <?php }?>
<?php endforeach; ?>

<?php  if(  $this->paginator->getTotalItemCount() == 0 &&  (empty($this->widgetType)) && $this->view_type != 'map'){  ?>
  <?php if( isset($this->category) || isset($this->tag) || isset($this->text) ):?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has posted a recipe with that criteria.');?>
	<?php if ($this->can_create):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesrecipe_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php else:?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has created a recipe yet.');?>
	<?php if ($this->can_create):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesrecipe_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php endif; ?>
<?php }else if( $this->paginator->getTotalItemCount() == 0 && isset($this->tabbed_widget) && $this->tabbed_widget){?>
  <div class="tip">
    <span>
      <?php $errorTip = ucwords(str_replace('SP',' ',$this->defaultOpenTab)); ?>
      <?php echo $this->translate("There are currently no %s",$errorTip);?>
      <?php if (isset($this->can_create) && $this->can_create):?>
	<?php echo $this->translate('%1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesrecipe_general").'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php } ?>
  
<?php if($this->loadOptionData == 'pagging' && !($this->show_limited_data)): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesrecipe"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
  
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->loadOptionData != 'pagging' && !($this->show_limited_data)):?>
    <div class="sesbasic_view_more sesrecipe_recipe_listing_more" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink fa fa-arrow-circle-o-down')); ?> </div>
    <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Core/externals/images/loading.gif" /> </div>
  <?php endif;?>
  </div>

  <script type="text/javascript">
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->loadOptionData == 'auto_load' && !($this->show_limited_data)){ ?>
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
      document.getElementById("sidebar-tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container' style='margin-top:10px;'></div>";
      sesJqueryObject('#sesrecipe_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesrecipe_list_view_<?php echo $randonNumber; ?>').removeClass('active');
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
				'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
				'data': {
					format: 'html',
					page: 1,
					type:sesJqueryObject(this).attr('rel'),
					params : <?php echo json_encode($this->params); ?>, 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
					if($("loading_image_<?php echo $randonNumber; ?>"))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				}
      })).send();
    });
  </script>
<?php } ?>
<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		<?php if($this->loadOptionData != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();	
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
				//document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						view_more:1,
						identity : '<?php echo $randonNumber; ?>',
						identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesrecipe-wrapper'))
						sesJqueryObject('#loadingimgsesrecipe-wrapper').hide();
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
						sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
							document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
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
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params :params<?php echo $randonNumber; ?> , 
						is_ajax : 1,
						identity : identity<?php echo $randonNumber; ?>,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesrecipe-wrapper'))
						sesJqueryObject('#loadingimgsesrecipe-wrapper').hide();
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
						document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
	</script>
<?php } ?>

<?php if(!$this->is_ajax): ?>
	<script type="application/javascript">
		sesJqueryObject(document).on('click',function(){
			sesJqueryObject('.sesrecipe_list_option_toggle').removeClass('open');
		});
	</script> 
<?php endif;?>
<!--End Map Work-->
