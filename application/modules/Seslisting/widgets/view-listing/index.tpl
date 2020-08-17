<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->seslisting->getHref()); ?>
<?php $isListingAdmin = Engine_Api::_()->seslisting()->isListingAdmin($this->seslisting, 'edit');?>
<?php $reviewCount = Engine_Api::_()->seslisting()->getTotalReviews($this->seslisting->listing_id);?>
<?php $canComment =  $this->seslisting->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($this->seslisting->listing_id,$this->seslisting->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$this->seslisting->listing_id)); ?>
<?php $isAllowReview = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.allow.review', 1);?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1);?>
<?php if($this->seslisting->style == 1):?>
	<div class="seslisting_layout_contant  seslisting_layout_profile sesbasic_clearfix sesbasic_bxs">
		<?php if(isset($this->photoActive) && $this->seslisting->photo_id):?>
				<div class="seslisting_listing_image clear">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->seslisting->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
	  <?php if(isset($this->titleActive)):?>
     <div class="seslisting_layout_contant seslisting_layout_contant_title">
      <a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
			<h2><?php echo $this->seslisting->getTitle() ?></h2>

		<?php endif;?>
		<div class="seslisting_footer_two_listing">
		<?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star">
					<?php $ratingCount = $this->seslisting->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="seslisting_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="seslisting_rating_star seslisting_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="seslisting_rating_star seslisting_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
		</div>
	</div>
		 <?php if(isset($this->priceActive)):?>
		<div class="seslisting_list_grid_price">
         <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($this->seslisting->price); ?>
       </div>
       <?php endif;?>
		<?php //echo '<pre>';print_r(isset($this->ratingActive));die; ?>
		 
		
		<div class="seslisting_entrylist_entry_body">
			<?php if(isset($this->descriptionActive)):?>
				<?php if($this->seslisting->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo $this->seslisting->body;?></div>
				<?php if($check): ?>
					<div class="seslisting_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
    <div class="seslisting_entrylist_entry_date">
    	<p class="sesbasic_text_light"><i class="fa fa-user"></i> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
			<p class="sesbasic_text_light"><i class="fa fa-calendar"></i> <?php echo $this->timestamp($this->seslisting->creation_date) ?><?php if( $this->category ): ?></p>
				
				<?php endif; ?>
			<p class="sesbasic_text_light"><?php if (count($this->seslistingTags )):?>
        <i class="fa fa-tag"></i>
				<?php foreach ($this->seslistingTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>
				<?php endforeach; ?>
			<?php endif; ?>
      </p>
      <?php if(isset($this->locationActive) && isset($this->seslisting->location) && $this->seslisting->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
        <p class="sesbasic_text_light"><i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $this->seslisting->location;?>"><?php echo $this->seslisting->location;?></a> 
       </p> <?php } ?>
			<?php if(isset($this->staticsActive)):?>
				<p>
					<?php if(isset($this->viewActive)):?>
						<span class="sesbasic_text_light"><?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', '<i class="fa fa-eye"></i> %s', $this->seslisting->view_count), $this->locale()->toNumber($this->seslisting->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span class="sesbasic_text_light"><?php echo $this->translate(array('<i class="fa fa-comment"></i> %s', '<i class="fa fa-comment"></i> %s', $this->seslisting->comment_count), $this->locale()->toNumber($this->seslisting->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span class="sesbasic_text_light"><?php echo $this->translate(array('<i class="fa fa-thumbs-up"></i> %s', '<i class="fa fa-thumbs-up"></i> %s', $this->seslisting->like_count), $this->locale()->toNumber($this->seslisting->like_count)) ?></span>
					<?php endif;?>
					<?php if($isAllowReview && isset($this->reviewActive)):?>
                       
						<span class="sesbasic_text_light"><?php echo $this->translate(array('<i class="fa fa-star"></i> %s', '<i class="fa fa-star"></i> %s', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
		</div>
			<div class="seslisting_deshboard_listing floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive) && $isListingAdmin):?>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sublisting', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->seslisting->listing_id), 'seslisting_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Listing');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'listing_id' => $this->seslisting->custom_url), 'seslisting_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'listing_id' => $this->seslisting->getIdentity()), 'seslisting_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Listing');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->seslisting->getType(), "id" => $this->seslisting->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->seslisting->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->seslisting->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="seslisting_comment"><i class="seslisting_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
          <?php endif;?>
				</ul>
			</div>
      <div class="seslisting_share_listing sesbasic_bxs">
        <?php if(isset($this->socialShareActive) && $enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->seslisting, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->seslisting->getType(), "id" => $this->seslisting->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i><span><?php echo $this->translate('Share');?></span></a>
				<?php endif;?>
				<?php if($this->viewer_id):?>
					<?php if(isset($this->likeButtonActive) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->seslisting->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  seslisting_like_seslisting_listing_<?php echo $this->seslisting->listing_id ?> seslisting_like_seslisting_listing_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $this->translate($likeText);?></span></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->seslisting->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  seslisting_favourite_seslisting_listing_<?php echo $this->seslisting->listing_id ?> seslisting_favourite_seslisting_listing_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
					<?php endif;?>
        <?php endif;?>
			</div>
		</div>
	</div>
 <?php endif;?>

<script type="text/javascript">
  
    window.addEvent('domready', function() {
      var height = sesJqueryObject('.rich_content_body').height();
      <?php if($this->seslisting->cotinuereading && $this->seslisting->continue_height) { ?>
      if(height > '<?php echo $this->seslisting->continue_height; ?>'){
        sesJqueryObject('.seslisting_morebtn').css("display","block");
        sesJqueryObject('.rich_content_body').css("height",'<?php echo $this->seslisting->continue_height; ?>');
        sesJqueryObject('.rich_content_body').css("overflow","hidden");
      }
      <?php } ?>
      sesJqueryObject('.rich_content_body').css("visibility","visible");
    });
  

  $$('.core_main_seslisting').getParent().addClass('active');
  sesJqueryObject('.seslisting_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->seslisting->listing_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"seslisting_general",true); ?>'+'?tag_id='+tag_id;
	}
	var logincheck = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.login.continuereading', 1); ?>';
	
	var viwerId = <?php echo $this->viewer_id ?>;
	function continuereading(){
		
		if(logincheck>0 && !viwerId){
			window.location.href = en4.core.baseUrl +'login';
		}else{
			sesJqueryObject('.rich_content_body').css('height', 'auto');
			sesJqueryObject('.seslisting_morebtn').hide();
		}
	}
</script>
