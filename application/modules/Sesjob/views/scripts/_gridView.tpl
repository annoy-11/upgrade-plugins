<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<li class="sesjob_grid sesbasic_bxs <?php if((isset($this->my_jobs) && $this->my_jobs)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="sesjob_grid_inner sesjob_thumb">
    <div class="sesjob_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;width:<?php echo is_numeric($this->width_grid_photo) ? $this->width_grid_photo.'px' : $this->width_grid_photo ?>">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesjob_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php include APPLICATION_PATH . '/application/modules/Sesjob/views/scripts/_label.tpl'; ?>
      <?php if(isset($this->categoryActive)){ ?>
      <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
      <?php $categoryItem = Engine_Api::_()->getItem('sesjob_category', $item->category_id);?>
      <?php if($categoryItem):?>
      <div class="sesjob_grid_memta_title">
        <?php $categoryItem = Engine_Api::_()->getItem('sesjob_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <span> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
        <?php endif;?>
      </div>
      <?php endif;?>
      <?php endif;?>
      <?php } ?>
    </div>
    <div class="sesjob_grid_info clear clearfix sesbm">
      <?php if(isset($this->titleActive) ){ ?>
      <div class="sesjob_grid_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
      </div>
      <?php } ?>
      <div class="sesjob_grid_meta_block">
        <div class="sesjob_list_stats">
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
						<div class="sesjob_list_stats">
							<span class="sesbasic_text_light">
							<i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
							<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
          <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)){ ?>
        <div class="sesjob_list_stats sesjob_list_location"> <span class="sesbasic_text_light"> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
        <?php } ?>
      </div>
      <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
      <?php if($company) { ?>
       <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
        <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
        <?php if($industry) { ?>
         <div class="sesjob_grid_itype sesbasic_text_light">
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
    </div>
    <?php if(isset($this->expiredLabelActive) && !empty($item->expired)) { ?>
      <div class="sesjob_expired_job">
        <?php echo $this->translate("Expired"); ?>
      </div>
    <?php } ?>
     <?php if(isset($this->byActive)){ ?>
       <div class="sesjob_grid_owner sesbasic_clearfix">
        <div class="sesjob_list_stats sesbasic_text_light"> <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
        <span>on <?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?></span> </div>
        <?php endif;?>
        </div>
  </div>
  <div class="sesjob_grid_hover_block">
      <div class="sesjob_grid_meta_block">
      <div class="sesjob_grid_hover_block_footer">
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
      </div>
    </div>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    <div class="sesjob_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
      <div class="sesjob_list_grid_thumb_btns">
        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
        
        <?php if($this->socialshare_icon_limit): ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
        <?php else: ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview1limit)); ?>
        <?php endif; ?>
        
        
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
</li>
<script>
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesjob_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>
