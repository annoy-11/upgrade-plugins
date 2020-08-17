<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<li class="sesjob_list_job_view sesbasic_clearfix clear">
 <div class="sesjob_list_job_main">
  <div class="sesjob_list_thumb sesjob_thumb" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
		<?php $href = $item->getHref();$imageURL = $photoPath;?>
		<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesjob_thumb_img">
		<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
		</a>
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
				<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
				<div class="sesjob_grid_btns"> 
					<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
            
            <?php if($this->socialshare_icon_limit): ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php else: ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
            <?php endif; ?>
						
					<?php endif;?>
					<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
						<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
						<?php if(isset($this->likeButtonActive) && $canComment):?>
							<!--Like Button-->
							<?php $LikeStatus = Engine_Api::_()->sesjob()->getLikeStatus($item->job_id,$item->getType()); ?>
							<a href="javascript:;" data-url="<?php echo $item->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesjob_like_sesjob_job_<?php echo $item->job_id ?> sesjob_like_sesjob_job <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?> 
	</div>
	<div class="sesjob_list_info">
  	<div class="sesbasic_clearfix clear">
		<?php if(isset($this->titleActive)): ?>
			<div class="sesjob_list_info_title floatL">
				<?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
					<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
					<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
				<?php else: ?>
					<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
				<?php endif;?>
			</div>
		<?php endif;?>
       <div class="sesjob_list_right_cont floatR">
     <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)): ?>
				<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$item->job_id)); ?>
				<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesjob_favourite_sesjob_job_<?php echo $item->job_id ?> sesjob_favourite_sesjob_job <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->job_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
	   <?php endif;?>
  	<?php if(isset($this->readmoreActive)):?>
			<div class="sesjob_list_readmore"><a class="sesjob_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
		<?php endif;?>
   </div>
    </div>
		<div class="sesjob_job_points sesbasic_clearfix">
    <div class="sesjob_stats_list">
    	<span class="sesbasic_text_light">
       <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
<?php if($company) { ?>
  <?php if(isset($this->companynameActive) && isset($item->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
  <i class="fa fa-building" aria-hidden="true"></i> <a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
  <?php } ?>
<?php } ?>
   </span>
     </div>
			<?php if(isset($this->categoryActive)){ ?>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('sesjob_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<div class="sesjob_stats_list">
							<span  class="sesbasic_text_light">
							<i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
							<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
      		<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)){ ?>
			<div class="sesjob_stats_list">
				<span class="sesbasic_text_light">
					<i class="fa fa-map-marker"></i>
					<a href="<?php echo $this->url(array('resource_id' => $item->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"  title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
				</span>
			</div>
		<?php } ?>
		</div>
    <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
      <?php if($company) { ?>
       <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
        <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
        <?php if($industry) { ?>
         <div class="sesjob_stats_list_itype sesbasic_text_light">
           <span><?php echo $this->translate('Industry Type: '); ?></span><?php echo $this->translate($industry->industry_name); ?>
        </div>
        <?php } ?>
      <?php } ?>
      <?php } ?>
      <?php if(isset($this->skillsActive)) { ?>
        <?php $skills = $item->tags()->getTagMaps(); ?>
        <?php if(count($skills) > 0) { ?>
          <div class="sesjob_key_skills">
            <p class="sesbasic_text_light">
              <span><?php echo $this->translate("Key Skills:"); ?></span>
              <?php foreach ($skills as $skill): ?>
                <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $skill->getTag()->tag_id; ?>);'><?php echo $skill->getTag()->text?></a>&nbsp;
              <?php endforeach; ?>
            </p>
          </div>
        <?php } ?>
      <?php } ?>
<!--	<div class="sesjob_list_contant">
		<?php if(isset($this->descriptionlistActive)){ ?>
			<p class="sesjob_list_des">
				<?php echo nl2br( Engine_String::strlen($item->description) > $this->description_truncation_list ? Engine_String::substr($item->description, 0, $this->description_truncation_list) . '...' : $item->description ); ?>
			</p>
		<?php } ?>      
		</div> -->
		<?php if(isset($this->my_jobs) && $this->my_jobs){ ?> 
    <div class="sesjob_options_buttons sesjob_list_options sesbasic_clearfix">
				<?php if($this->can_edit){ ?>
				<a href="<?php echo $this->url(array('action' => 'edit', 'job_id' => $item->job_id), 'sesjob_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Job'); ?>">
				<i class="fa fa-pencil"></i>
				</a>
				<?php } ?>
				<?php if ($this->can_delete){ ?>
					<a href="<?php echo $this->url(array('action' => 'delete', 'job_id' => $item->job_id), 'sesjob_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Job'); ?>" onclick='opensmoothboxurl(this.href);return false;'>
					<i class="fa fa-trash"></i>
					</a>
				<?php } ?>

		</div>
			<?php } ?>
	</div>
  </div>
    <?php if(isset($this->expiredLabelActive) && !empty($item->expired)) { ?>
      <div class="sesjob_expired_job">
        <?php echo $this->translate("Expired"); ?>
      </div>
    <?php } ?>
  <div class="sesjob_admin_list">
    <div class="sesjob_list_stats sesbasic_text_light">
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
			<?php if(isset($this->creationDateActive)){ ?>
				<div class="sesjob_stats_list sesbasic_text_light">
					<span>
            <?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?>
					</span>
				</div>
			<?php } ?>
      <?php if(isset($this->byActive)){ ?>
				<div class="sesjob_stats_list sesbasic_text_light">
					<?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
						<?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
		</div>
</li>
<script>
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesjob_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>
