<?php 

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<li class="sesdocument_grid sesbasic_bxs <?php if((isset($this->my_documents) && $this->my_documents)){ ?>isoptions<?php } ?>" style="width:	<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="sesdocument_grid_inner sesdocument_thumb">
    <div class="sesdocument_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
      <?php $href = $item->getHref(); $imageURL = $imageurl;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesdocument_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php include APPLICATION_PATH . '/application/modules/Sesdocument/views/scripts/_label.tpl'; ?>
      <?php if(isset($this->categoryActive)){ ?>
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
        <?php $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <div class="sesdocument_grid_category">
          <?php $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);?>
          <?php if($categoryItem):?>
          <span> <a href="<?php echo $categoryItem->getHref(); ?>"><i class="fa fa-folder-open"></i> <?php echo $categoryItem->category_name; ?></a> </span>
          <?php endif;?>
        </div>
        <?php endif;?>
        <?php endif;?>
      <?php } ?>
      </div>
      <div class="sesdocument_grid_hover_block">
      <div class="sesdocument_grid_meta_block">
      <div class="sesdocument_grid_hover_block_inner">
        <div class="sesdocument_list_stats sesbasic_text_light">
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
          <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
          <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.enable.favourite', 1)) { ?>
          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
          <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
      <div class="sesdocument_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
        <div class="sesdocument_list_grid_thumb_btns">
          <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.enable.sharing', 1)):?>
          
          <?php if($this->socialshare_icon_limit): ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
          <?php else: ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview1limit)); ?>
          <?php endif; ?>
          
          
          <?php endif;?>
          <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
          <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment): ?>
          <!--Like Button-->
          <?php $LikeStatus = Engine_Api::_()->sesdocument()->getLikeStatusDocument($item->sesdocument_id,$item->getType()); ?>
          <a href="javascript:;" data-url="<?php echo $item->sesdocument_id ; ?>" class="sesbasic_icon_btn sesdocument_like_sesdocument_document_<?php echo $item->sesdocument_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
          <?php endif;?>
          <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.enable.favourite', 1)): ?>
          <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$item->sesdocument_id)); ?>
          <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document_<?php echo $item->sesdocument_id ?> sesdocument_favourite_sesdocument_document <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->sesdocument_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
          <?php endif;?>
          <?php endif;?>
        </div>
      </div>
      <?php endif;?>
    </div>
    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)): ?>
			<div class="sesdocument_list_labels ">
				<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
					<p class="sesdocument_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
				<?php endif;?>
				<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
					<p class="sesdocument_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
				<?php endif;?>
        <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <p class="sesdocument_label_verified" title="Verified"><i class="fa fa-star"></i></p>
      <?php endif;?>
			</div>
		<?php endif;?>
    <div class="sesdocument_document_type">
       <img src="application/modules/Sesdocument/externals/images/pdf.png" />
    </div>
	</div>
  <div class="sesdocument_grid_info clear clearfix sesbm">
    <?php if(isset($this->titleActive) ){ ?>
      <div class="sesdocument_grid_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
      </div>
    <?php } ?>
    <div class="sesdocument_grid_info_desc">
      <?php if(isset($this->griddescriptionActive)){ ?>
        <p class="sesjob_list_des">
          <?php echo nl2br( Engine_String::strlen($this->string()->stripTags($item->description)) > $this->description_truncation_grid ? Engine_String::substr($this->string()->stripTags($item->description), 0, $this->description_truncation_grid) . '...' : $this->string()->stripTags($item->description)); ?>
        </p>
      <?php } ?>
    </div>
    <div class="sesdocument_grid_meta_block">
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.enable.location', 1)){ ?>
      <div class="sesdocument_list_stats sesdocument_list_location"> <span class="sesbasic_text_light"> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->sesdocument_id,'resource_type'=>'sesdocument_document','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
      <?php } ?>
    </div>
  </div>
  <div class="sesdocument_grid_owner sesbasic_clearfix">
    <div class="sesdocument_list_stats sesbasic_text_light"> <span>
      <?php if(isset($this->byActive)){ ?>
        <?php $owner = $item->getOwner(); ?>
        <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span> 
      <?php } ?>
      <?php if(isset($this->creationDateActive)): ?>
        <span>on <?php if($item->creation_date): ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
        <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
        <?php endif; ?>
        </span> 
      <?php endif;?>
    </div>
  </div>
</li>
<script>
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesdocument_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>
