<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescrowdfunding/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescrowdfunding/externals/scripts/owl.carousel.js'); 
?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax):?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber;?>" class="sesbasic_bxs sescf_catbase_listing"> 
		<div id="category-crowdfunding-widget_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
<?php endif;?>
  <?php foreach( $this->paginatorCategory as $result): ?>
  	<div class="sescf_catbase_listing_item sesbasic_clearfix">
      <div class="sescf_catbase_listing_item_header sesbasic_clearfix">
        <p class="floatL">
        	<a href="<?php echo $result->getBrowseCategoryHref(); ?>?category_id=<?php echo $result->category_id ?>" title="<?php echo $result->category_name; ?>"><?php echo $result->category_name; ?></a>
        </p>
				<?php if(isset($this->seemore_text) && $this->seemore_text != ''): ?>
					<span class="<?php echo $this->allignment_seeall == 'right' ?  'floatR' : 'floatL'; ?>"><a  class="sesbasic_link_btn" href="<?php echo $result->getBrowseCategoryHref(); ?>?category_id=<?php echo $result->category_id ?>"><?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
					<?php echo str_replace('[category_name]',$result->category_name,$seemoreTranslate); ?></a></span>
				<?php endif;?>
      </div>
      <div class="sescf_catbase_listing_item_cont sescf_cm_carousel sesbasic_clearfix sescf_carousel">
        <?php if(isset($this->resultArray['crowdfunding_data'][$result->category_id])):?>
          <?php	foreach($this->resultArray['crowdfunding_data'][$result->category_id] as $result): ?>
            <div class="sesbasic_clearfix sescf_grid_item item">
              <div class="sescf_grid_item_inner sesbasic_clearfix">
              
                <div class="sescf_grid_item_top">
                  <?php if(isset($this->titleActive)): ?>
                    <div class="sescf_grid_item_title">
                      <a href="<?php echo $result->getHref();?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->getTitle();?></a>
                    </div>
                  <?php endif;?>
                  <?php if(isset($this->byActive)):?>
                    <div class="sescf_grid_item_top_stats sesbasic_clearfix">
                      <p class="sescf_grid_item_owner floatL">
                        <i class="fa fa-user-circle sesbasic_text_light"></i>
                        <a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a>
                      </p>
                    </div>
                  <?php endif; ?>
                </div>
        
               <div class="sescf_grid_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height; ?>px;">
                  <img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl('thumb.profile'); ?>" />
                  <a href="<?php echo $result->getHref();?>" class="sescf_grid_item_thumb_overlay sesbasic_animation"></a>
                  <div class="sescf_labels_main">
          <?php if($this->featuredLabelActive && $result->featured): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_featured"><?php echo $this->translate("FEATURED");?></span>
            </p>
          <?php endif; ?>
            <?php if($this->sponsoredLabelActive && $result->sponsored): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_sponsored"><?php echo $this->translate("SPONSORED");?></span>
            </p>
          <?php endif; ?>
           <?php if($this->verifiedLabelActive && $result->verified): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_verified"><?php echo $this->translate("VERIFIED");?></span>
            </p>
          <?php endif; ?>
          </div>
                  <p class="sescf_list_btns sesbasic_animation">
                    <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
                    <?php if(isset($this->socialshareActive) && $enableShare == 2): ?>
                      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
                      <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
                      <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
                      <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
                    <?php endif; ?>
                    <?php if(isset($this->likeButtonActive)): ?>
                      <!--Like Button-->
                      <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
                      <?php if($canComment):?>
                        <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                        <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
                      <?php endif; ?>
                    <?php endif; ?>
                  </p>
                  <div class="sescf_grid_item_thumb_stats sesbasic_clearfix sesbasic_animation centerT">
                    <?php if(isset($this->likeActive)): ?>
                      <p title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></p>
                    <?php endif; ?>
                  	<?php if(isset($this->commentActive)): ?>
                      <p title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></p>
                    <?php endif; ?>
                    <?php if(isset($this->viewActive)): ?>
                      <p title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></p>
                    <?php endif; ?>
                    <?php if(isset($this->ratingActive)): ?>
                      <p title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>"><i class="fa fa-star"></i><span><?php echo round($result->rating,2); ?></span></p>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="sescf_grid_item_cont sesbasic_clearfix">
                  <p class="sescf_grid_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->crowdfunding_description_truncation) ?></p>
                  <?php 
                  $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
                  $totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $result->crowdfunding_id));
                  $getDoners = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getDoners(array('crowdfunding_id' => $result->crowdfunding_id));
                  $totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency);
                  $totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->price,$currency);
                  $totalPerAmountGain = (($totalGainAmount * 100) / $result->price);
                  if($totalPerAmountGain > 100) {
                    $totalPerAmountGain = 100;
                  } else if(empty($totalPerAmountGain)) {
                    $totalPerAmountGain = 0;
                  }
                  ?>
                  <div class="sescf_grid_item_progress sesbasic_clearfix">
                    <span class="sescf_grid_item_progress_overall sesbasic_text_light"><?php echo round($totalPerAmountGain,2).'%'; echo $this->translate(" Completed"); ?></span>
                    <span class="sescf_grid_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain;?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
                  </div>
                  <div class="sescf_grid_item_stats sesbasic_clearfix">
                    <div class="sescf_total_g">
                      <span class="sescf_grid_item_stat_value"><?php echo $totalGainAmountwithCu; ?></span>
                      <span class="sescf_grid_item_stat_label sesbasic_text_light"><?php echo $this->translate("RAISED"); ?></span>	
                    </div>	
                    <div class="sescf_total_d centerT">
                      <span class="sescf_grid_item_stat_value"><?php echo $getDoners; ?></span>
                      <span class="sescf_grid_item_stat_label sesbasic_text_light">
                      <?php if($getDoners > 1) { echo $this->translate("Donors"); } else {  echo $this->translate("Donor"); } ?></span>
                    </div>
                    <div class="sescf_total_g rightT">
                      <span class="sescf_grid_item_stat_value"><?php echo $totalAmount; ?></span>
                      <span class="sescf_grid_item_stat_label sesbasic_text_light"><?php echo $this->translate("GOAL"); ?></span>	
                    </div>	
                  </div>
                  <?php if($this->viewActive): ?>
                    <div class="sescf_grid_item_btn">
                      <a href="<?php echo $result->getHref() ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
                    </div>
                  <?php endif; ?>
                </div>   
              </div>
            </div>
          <?php endforeach;?>
        <?php endif;?>
      </div>
		</div>
  <?php endforeach;?>
  <?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):?>
		<div class="tip">
			<span>
				<?php echo $this->translate('Nobody has created an crowdfunding yet.');?>
				<?php if ($this->can_create):?>
					<?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfunding'), "sescrowdfunding_general",true).'">', '</a>'); ?>
				<?php endif; ?>
			</span>
		</div>
	<?php endif; ?> 
	<?php if($this->loadOptionData == 'pagging'): ?>
		<?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sescrowdfunding"),array('identityWidget'=>$randonNumber)); ?>
	<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
		</div>
  </div>  
	<?php if($this->loadOptionData != 'pagging') { ?>
		<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
    	<a href="javascript:void(0);" id="feed_viewmore_link_<?php $randonNumber ?>" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>
		<div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;">
    	<span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
	<?php  } ?>
<?php } ?>

<script type="text/javascript">
	<?php if($this->loadOptionData == 'autoload') { ?>
		window.addEvent('load', function() {
			sesJqueryObject(window).scroll( function() {
				var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
				var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
				if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' && document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>')) {
					document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
			});
		});
	<?php } ?>
	viewMoreHide_<?php echo $randonNumber; ?>();
	function viewMoreHide_<?php echo $randonNumber; ?>() {
		if ($('view_more_<?php echo $randonNumber; ?>'))
		$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
	}
	function viewMore_<?php echo $randonNumber; ?> () {
		document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
		document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
		en4.core.request.send(new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>",
			'data': {
			format: 'html',
			page: <?php echo $this->page + 1; ?>,    
			params :'<?php echo json_encode($this->params); ?>', 
			is_ajax : 1,
			identity : '<?php echo $randonNumber; ?>',
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('#category-crowdfunding-widget_<?php echo $randonNumber; ?>').append(responseHTML);
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
			}
		}));
		return false;
	}
	<?php if(!$this->is_ajax){ ?>
		function paggingNumber<?php echo $randonNumber; ?>(pageNum) {
			sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
			en4.core.request.send(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>",
				'data': {
					format: 'html',
					page: pageNum,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
					type:'<?php echo $this->view_type; ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
					document.getElementById('category-crowdfunding-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
					dynamicWidth();
				}
			}));
			return false;
		}
	<?php } ?>
	
		sescfJqueryObject(document).ready(function() {
			var elem = sescfJqueryObject('.sescf_carousel');
			for(i=0;i<elem.length;i++){
				sescfJqueryObject(elem[i]).owlCarousel({
					loop: true,
					margin:5,
					responsiveClass: true,
					responsive: {
						0: {
							items: 1,
							nav: true
						},
						600: {
							items: 2,
							nav: false
						},
						1000: {
							items: 3,
							nav: true,
							loop: false
						}
					}
				});
				sescfJqueryObject(elem[i]).removeClass('sescf_carousel');
			}
			sescfJqueryObject( ".owl-prev").html('<i class="fa fa-angle-left"></i>');
			sescfJqueryObject( ".owl-next").html('<i class="fa fa-angle-right"></i>');
		});
</script>
