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
  $this->headLink()->appendStylesheet($baseURL . 'application/modules/Sesbasic/externals/styles/customscrollbar.css');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); 
?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax){ ?>
  <?php $baseUrl = $baseURL; ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">  
<?php } ?>
  <?php if($this->viewType == 'list'):?>
    <?php if(!$this->is_ajax) { ?>
      <ul class="sesbasic_clearfix sescf_list_listing" id="tabbed-widget_<?php echo $randonNumber; ?>" style="display:block;">
    <?php } ?>
    <!--List View Start Here-->
    <?php foreach($this->paginator as $result): ?>
      <li class="sesbasic_clearfix sescf_list_item">
        <div class="sesbasic_clearfix sescf_list_item_inner">
          <div class="sescf_list_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height?>px;width:<?php echo $this->width ?>px;;">
            <img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
            <a href="<?php echo $result->getHref(); ?>" class="sescf_list_item_thumb_overlay sesbasic_animation"></a>
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
              <?php if($this->socialshareActive && $enableShare == 2): ?>
                <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
                <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
              <?php endif; ?>
              <?php if($this->likeButtonActive): ?>
                <!--Like Button-->
                <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
                <?php if($canComment):?>
                  <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                  <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
                <?php endif; ?>
              <?php endif; ?>
            </p>
          </div> 
          <div class="sescf_list_item_cont sesbasic_clearfix">
            <?php if($this->titleActive): ?>
              <div class="sescf_list_item_title">
                <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->title; ?></a>
              </div>
            <?php endif; ?>
            <div class="sescf_list_item_top_stats sesbasic_clearfix">
              <?php if($this->byActive): ?>
                <span class="sescf_list_item_owner">
                  <i class="fa fa-user-circle sesbasic_text_light"></i>
                  <span><?php echo $this->translate("Created by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>
                </span>
              <?php endif; ?>
              <?php if($this->likeActive): ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>">
                  <i class="fa fa-thumbs-up sesbasic_text_light"></i>
                  <span><?php echo $result->like_count; ?></span>
                </span>
              <?php endif; ?>
              <?php if($this->commentActive): ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>">
                  <i class="fa fa-comment sesbasic_text_light"></i>
                  <span><?php echo $result->comment_count; ?></span>
                </span>
              <?php endif; ?>
              <?php if($this->viewActive): ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>">
                  <i class="fa fa-eye sesbasic_text_light"></i>
                  <span><?php echo $result->view_count; ?></span>
                </span>
              <?php endif; ?>
              <?php if($this->ratingActive): ?>
              <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>">
                <i class="fa fa-star sesbasic_text_light"></i>
                <span><?php echo round($result->rating,2); ?></span>
              </span>
              <?php endif; ?>
              <?php if($this->categoryActive && $result->category_id && 0): ?>
                <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
                <span class="sescf_list_item_category">
                  <i class="fa fa-folder-open sesbasic_text_light"></i>
                  <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
                </span>
              <?php endif; ?>
            </div>
            <?php if($this->descriptionActive): ?>
              <p class="sescf_list_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), 400) ?></p>
            <?php endif; ?>
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
            <div class="sescf_list_item_progress sesbasic_clearfix">
              <div class="sescf_list_item_fund_stats sescf_list_item_fund_stats_value sesbasic_clearfix">
                <span><?php echo $totalGainAmountwithCu; ?></span>	
                <span class="sescf_total_d centerT"><?php echo $getDoners; ?></span>
                <span class="sescf_total_g rightT"><?php echo $totalAmount; ?></span>
              </div>
              <span class="sescf_list_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
              <div class="sescf_list_item_fund_stats sesbasic_clearfix">
                <span class="sescf_total_g"><?php echo $this->translate("RAISED"); ?></span>
                <span class="sescf_total_d centerT"><?php if($getDoners > 1) { echo $this->translate("Donors"); } else { echo $this->translate("Donor"); } ?></span>
                <span class="sescf_total_g rightT"><?php echo $this->translate("GOAL"); ?></span>
              </div>
            </div>
            <?php if($this->viewButtonActive): ?>
              <div class="sescf_list_item_btn">
                <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
    <!--List View End Here-->
		<?php  if(count($this->paginator) == 0) { ?>
			<div class="tip">
				<span>
					<?php echo $this->translate("No crowdfunding in this  category."); ?>
					<?php if (!$this->can_edit):?>
						<?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfunding_general").'">', '</a>'); ?>
					<?php endif; ?>
				</span>
			</div>
		<?php } ?>    
		<?php if($this->loadOptionData == 'pagging'): ?>
			<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sescrowdfunding"),array('identityWidget'=>$randonNumber)); ?>
		<?php endif; ?>
    <?php if(!$this->is_ajax){ ?> 
      </ul>
    <?php } ?>
 <?php else: ?>
  <?php if(!$this->is_ajax) { ?>
    <ul class="sesbasic_clearfix sescf_grid_listing" id="tabbed-widget_<?php echo $randonNumber; ?>">
  <?php } ?>
  <?php foreach($this->paginator as $result): ?>
  
   	<!--Grid View Start Here-->
  	<li class="sesbasic_clearfix sescf_grid_item" style="width:<?php echo $this->width ?>px;">
    	<div class="sesbasic_clearfix sescf_grid_item_inner">
      	<div class="sescf_grid_item_top">
          <?php if($this->titleActive) { ?>
        	<div class="sescf_grid_item_title">
          	<a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->getTitle(); ?></a>
          </div>
          <?php } ?>
          <div class="sescf_grid_item_top_stats sesbasic_clearfix">
            <?php if($this->byActive) { ?>
              <p class="sescf_grid_item_owner">
                <i class="fa fa-user-circle sesbasic_text_light"></i>
                <a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a>
              </p>
            <?php } ?>
            <?php if($this->categoryActive && $result->category_id): ?>
              <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
              <p class="sescf_grid_item_category">
                <i class="fa fa-folder-open sesbasic_text_light"></i>
                <a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a>
              </p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height ?>px;">
        	<img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
          <a href="<?php echo $result->getHref(); ?>" class="sescf_grid_item_thumb_overlay sesbasic_animation"></a>
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
            <?php if($this->socialshareActive && $enableShare == 2): ?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            <?php if($this->likeButtonActive): ?>
            <!--Like Button-->
            <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
            <?php if($canComment):?>
              <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
              <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
            <?php endif; endif; ?>
          </p>
          <div class="sescf_grid_item_thumb_stats sesbasic_clearfix sesbasic_animation centerT">
            <?php if($this->likeActive): ?>
              <p title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></p>
            <?php endif; ?>
            <?php if($this->commentActive): ?>
              <p title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></p>
            <?php endif; ?>
            <?php if($this->viewActive): ?>
              <p title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></p>
            <?php endif; ?>
            <?php if($this->ratingActive): ?>
              <p title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>"><i class="fa fa-star"></i><span><?php echo round($result->rating,2); ?></span></p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_cont sesbasic_clearfix">
          <?php if($this->descriptionActive): ?>
            <p class="sescf_grid_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->description_truncation) ?></p>
        	<?php endif; ?>
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
          <?php if($this->viewButtonActive): ?>
            <div class="sescf_grid_item_btn">
              <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
            </div>
          <?php endif; ?>
        </div>
      </div>
  	</li>
    <!--Grid View End Here-->
    <?php endforeach;?>
    <?php  if(  count($this->paginator) == 0) { ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("No crowdfunding in this  category."); ?>
          <?php if (!$this->can_edit):?>
            <?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfunding_general").'">', '</a>'); ?>
          <?php endif; ?>
        </span>
      </div>
    <?php } ?>    
    <?php if($this->loadOptionData == 'pagging') { ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sescrowdfunding"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
    <?php if(!$this->is_ajax) { ?> 
      </ul>
    <?php } ?>
  <?php endif;?>
	<?php if(!$this->is_ajax) { ?>
  </div>
  <?php if($this->loadOptionData != 'pagging') { ?>
  <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
  <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $baseURL; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
  <?php } ?>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: pageNum,    
				params :<?php echo json_encode($this->params); ?>, 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
				type:'<?php echo $this->view_type; ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				dynamicWidth();
      }
    }));
    return false;
}
</script>
  <?php } ?>
<script type="text/javascript">
var valueTabData ;
// globally define available tab array
	var availableTabs_<?php echo $randonNumber; ?>;
	var requestTab_<?php echo $randonNumber; ?>;
  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($this->defaultOptions); ?>;
<?php if($this->loadOptionData == 'auto_load'){ ?>
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
var defaultOpenTab ;
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				params :<?php echo json_encode($this->params); ?>, 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				dynamicWidth();
      }
    }));
    return false;
  }
<?php if(!$this->is_ajax){ ?>
function dynamicWidth(){
	var objectClass = sesJqueryObject('.sescrowdfunding_cat_crowdfunding_list_info');
	for(i=0;i<objectClass.length;i++){
			sesJqueryObject(objectClass[i]).find('div').find('.sescrowdfunding_cat_crowdfunding_list_content').find('.sescrowdfunding_cat_crowdfunding_list_title').width(sesJqueryObject(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>
