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
		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1))):?>
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
				</div>
			</div>
		<?php endif;?>
	</div>
	<div class="sesjob_list_info">
  <div class="sesbasic_clearfix clear">
		<?php if(isset($this->titleActive)): ?>
			<div class="sesjob_list_info_title floatL">
				<?php if(strlen($item->company_name) > $this->title_truncation_list):?>
					<?php $title = mb_substr($item->company_name,0,$this->title_truncation_list).'...';?>
					<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->company_name));?>
				<?php else: ?>
					<?php echo $this->htmlLink($item->getHref(),$item->company_name,array('title'=>$item->company_name)  ) ?>
				<?php endif;?>
			</div>
		<?php endif;?>
    <?php if(isset($this->readmoreActive)):?>
    <div class="sesjob_list_right_cont floatR">
			<div class="sesjob_list_readmore"><a class="sesjob_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
		</div>
    <?php endif;?>
  </div>
		<div class="sesjob_list_contant">
    <?php if(isset($this->categoryActive)){ ?>
				<?php if($item->industry_id != '' && intval($item->industry_id) && !is_null($item->industry_id)):?> 
					<?php $industryItem = Engine_Api::_()->getItem('sesjob_industry', $item->industry_id);?>
					<?php if($industryItem):?>
						<div class="sesjob_stats_list sesbasic_text_dark">
							<span>
							<i class="fa fa-folder-open" title="<?php echo $this->translate('Industry'); ?>"></i> 
							<?php echo $industryItem->industry_name; ?>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
      <?php if(isset($this->descriptionlistActive)){ ?>
        <p class="sesjob_list_des sesbasic_text_light">
          <?php echo nl2br( Engine_String::strlen($item->company_description) > $this->description_truncation_list ? Engine_String::substr($item->company_description, 0, $this->description_truncation_list) . '...' : $item->company_description); ?>
        </p>
      <?php } ?>      
		</div>
	</div>
  		</div>
  		<div class="sesjob_admin_list">
    <div class="sesjob_static_list_group">
      <div class="sesjob_list_stats sesbasic_text_dark">
        <?php if(isset($this->subscribecountActive) && isset($item->subscribe_count)) { ?>
          <span title="<?php echo $this->translate(array('%s subscriber', '%s subscribers', $item->subscribe_count), $this->locale()->toNumber($item->subscribe_count)); ?>"><i class="fa fa-check-square-o"></i><?php echo $item->subscribe_count; ?></span>
        <?php } ?>
        <?php if(isset($this->jobcountActive) && isset($item->job_count)) { ?>
          <span title="<?php echo $this->translate(array('%s job', '%s jobs', $item->job_count), $this->locale()->toNumber($item->job_count)); ?>"><i class="fa fa-briefcase"></i><?php echo $item->job_count; ?></span>
        <?php } ?>
      </div>
    </div>
    <div class="sesjob_stats_list sesbasic_text_dark">
			<?php if(isset($this->byActive)){ ?>
				<?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
						<?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
			<?php } ?>
			<?php if(isset($this->creationDateActive)){ ?>
					<span>
             on <?php echo date('M d, Y',strtotime($item->creation_date));?>
					</span>
			<?php } ?>
     	</div>
</li>
