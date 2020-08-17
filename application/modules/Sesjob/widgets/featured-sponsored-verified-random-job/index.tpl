<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?> 
<div class="sesjob-featured_job_view sesbasic_clearfix sesbasic_bxs clear">
	<?php $itemCount = 1;?>
	<?php foreach($this->jobs as $item):?>
		<?php if($itemCount == 1):?>
			<div class="featured_job_list featured_job_listing sesbasic_bxs">
				<div class="featured_job_list_inner sesjob_thumb">
        <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('sesjob_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
					<?php endif;?>
				<?php endif;?>
				  <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel) || isset($this->hotLabelActive)):?>
                <div class="sesjob_list_labels ">
                  <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                  <p class="sesjob_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <p class="sesjob_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->hotLabelActive) && $item->hot == 1):?>
                  <p class="sesjob_label_hot" title="Hot"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                </div>
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                <div class="sesjob_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
                <?php endif;?>
                <?php endif;?>
        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
					<div class="sesjob_list_thumb_over">
						<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
						<div class="sesjob_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->sesjob()->getLikeStatus($item->job_id,$item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesjob_like_sesjob_job_<?php echo $item->job_id ?> sesjob_like_sesjob_job <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$item->job_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesjob_favourite_sesjob_job_<?php echo $item->job_id ?> sesjob_favourite_sesjob_job <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->job_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
		    <?php endif;?>		
				<div class="featured_job_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <div class="featured_job_date_location">
          <div class="sesjob_list_stats">
             <p>
                <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
                <?php if($company) { ?>
                <?php if(isset($this->companynameActive) && isset($item->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
                <i class="fa fa-building" aria-hidden="true"></i><a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
                <?php } ?>
                <?php } ?>
             </p>
           </div>
           </div>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_job_date_location"><div class="sesjob_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <i class="fa fa-user"></i><?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
           <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
                    <?php if($company) { ?>
                    <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
                    <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
                    <?php if($industry) { ?>
                    <div class="featured_job_industry"><span class="sesbasic_text_light"><?php echo $this->translate('Industry Type: '); ?> <?php echo $this->translate($industry->industry_name); ?></span></div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
				  <div class="featured_job_date_location"> 	
				    <?php if(isset($this->creationDateActive)):?>
							<div class="sesjob_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif;?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)){ ?>
							<div class="sesjob_list_stats  sesjob_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="sesjob_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
						</div>
          </div>
        </div>
			</div>
		</div>
	<?php else:?>
	<div class="featured_job_list sesbasic_bxs">
		<div class="featured_job_list_inner sesjob_thumb">
			<a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
			<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
				<?php $categoryItem = Engine_Api::_()->getItem('sesjob_category', $item->category_id);?>
				<?php if($categoryItem):?>
					<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
				<?php endif;?>
			<?php endif;?>
			  <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel) || isset($this->hotLabelActive)):?>
                <div class="sesjob_list_labels ">
                  <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                  <p class="sesjob_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <p class="sesjob_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->hotLabelActive) && $item->hot == 1):?>
                  <p class="sesjob_label_hot" title="Hot"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                </div>
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                <div class="sesjob_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
                <?php endif;?>
                <?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
				<div class="sesjob_list_thumb_over">
					<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
					<div class="sesjob_list_grid_thumb_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
              
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
						<?php endif;?>
						<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
							<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
							<?php if(isset($this->likeButtonActive) && $canComment):?>
								<!--Like Button-->
								<?php $LikeStatus = Engine_Api::_()->sesjob()->getLikeStatus($item->job_id,$item->getType()); ?>
								<a href="javascript:;" data-url="<?php echo $item->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesjob_like_sesjob_job_<?php echo $item->job_id ?> sesjob_like_sesjob_job <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
							<?php endif;?>
							<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$item->job_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesjob_favourite_sesjob_job_<?php echo $item->job_id ?> sesjob_favourite_sesjob_job <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->job_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
		  <?php endif;?>		
				<div class="featured_job_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <div class="featured_job_date_location">
          <div class="sesjob_list_stats">
             <p>
                <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
                <?php if($company) { ?>
                <?php if(isset($this->companynameActive) && isset($item->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
                <i class="fa fa-building" aria-hidden="true"></i><a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
                <?php } ?>
                <?php } ?>
             </p>
           </div>
           </div>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_job_date_location"><div class="sesjob_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <i class="fa fa-user"></i><?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
           <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
                    <?php if($company) { ?>
                    <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
                    <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
                    <?php if($industry) { ?>
                    <div class="featured_job_industry"><span class="sesbasic_text_light"><?php echo $this->translate('Industry Type: '); ?> <?php echo $this->translate($industry->industry_name); ?></span></div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
					<div class="featured_job_date_location">
            <?php if(isset($this->creationDateActive)):?>
						<div class="sesjob_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif; ?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)){ ?>
							<div class="sesjob_list_stats  sesjob_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="sesjob_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
						</div>
          </div>
        </div>
				</div>
			</div>
		<?php endif;?>
		<?php $itemCount++;?>
	<?php endforeach;?>
</div>
