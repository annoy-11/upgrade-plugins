<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
				$randonNumber = $this->identityForWidget;
      }else{
      	$randonNumber = $this->identity; 
      }
?>
<?php  if(!$this->is_ajax){ ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->category->thumbnail) && !empty($this->category->thumbnail)){?>

<div class="sesdocument_category_cover sesbasic_bxs sesbm sesbasic_bxs">
  <div class="sesdocument_category_cover_inner" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);">
    <div class="sesdocument_category_cover_content">
      <div class="sesdocument_category_cover_breadcrumb"> 
        <!--breadcrumb --> 
        <a href="<?php echo $this->url(array('action' => 'browse'), "sesdocument_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
        <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
        <?php if($this->breadcrumb['subcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?></a>
        <?php }else{ ?>
        <?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?>
        <?php } ?>
        <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
        <?php } ?>
        <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
        <?php if($this->breadcrumb['subSubcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?></a>
        <?php }else{ ?>
        <?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?>
        <?php } ?>
        <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
        <?php } ?>
        <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
        <?php echo $this->translate($this->breadcrumb['subSubcategory'][0]->category_name) ?>
        <?php } ?>
      </div>
      <div class="sesdocument_category_cover_blocks">
        <div class="sesdocument_category_cover_block_img"> <span style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl(''); ?>);"></span> </div>
        <div class="sesdocument_category_cover_block_info">
          <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
          <div class="sesdocument_category_cover_title"> <?php echo $this->translate($this->category->title); ?> </div>
          <?php endif; ?>
          <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
          <div class="sesdocument_category_cover_des clear sesbasic_custom_scroll">
            <p><?php echo nl2br($this->category->description);?></p>
          </div>
          <?php endif; ?>
          <?php if(count($this->paginatorc)){ ?>
          <div class="sesdocument_category_cover_documents">
            <div class="sesdocument_category_cover_documents_head"> <?php echo $this->title_pop; ?> </div>
            <?php foreach($this->paginatorc as $documentsCri){ ?>
            <div class="sesdocument_thumb sesbasic_animation"> <a href="<?php echo $documentsCri->getHref(); ?>" data-src="<?php echo $documentsCri->getGuid(); ?>" class="sesdocument_thumb_img ses_tooltip"> <span class="sesdocument_animation" style="background-image:url(<?php echo $documentsCri->getPhotoUrl('thumb.normal'); ?>);"></span>
              <div class="sesdocument_category_cover_documents_item_info sesdocument_animation">
                <div class="sesdocument_list_title"><?php echo $documentsCri->getTitle(); ?> </div>
              </div>
              </a> </div>
            <?php }  ?>
          </div>
          <?php	}  ?>
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
  </div>
</div>
<?php } else { ?>
<div class="sesvide_breadcrumb clear sesbasic_clearfix"> 
  <!--breadcrumb --> 
  <a href="<?php echo $this->url(array('action' => 'browse'), "sesdocument_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
  <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
  <?php if($this->breadcrumb['subcategory']) { ?>
  <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->breadcrumb['category'][0]->category_name ?></a>
  <?php }else{ ?>
  <?php echo $this->breadcrumb['category'][0]->category_name ?>
  <?php } ?>
  <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
  <?php } ?>
  <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
  <?php if($this->breadcrumb['subSubcategory']) { ?>
  <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->breadcrumb['subcategory'][0]->category_name ?></a>
  <?php }else{ ?>
  <?php echo $this->breadcrumb['subcategory'][0]->category_name ?>
  <?php } ?>
  <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
  <?php } ?>
  <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
  <?php echo $this->breadcrumb['subSubcategory'][0]->category_name ?>
  <?php } ?>
</div>
<div class="sesdocument_browse_cat_top sesbm">
  <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
  <div class="sesdocument_catview_title"> <?php echo $this->category->title; ?> </div>
  <?php endif; ?>
  <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
  <div class="sesdocument_catview_des"> <?php echo nl2br($this->category->description);?> </div>
  <?php endif; ?>
</div>
<?php if(count($this->paginatorc)){ ?>
<div class="sesdocument_category_cover_documents clearfix sesdocument_category_top_documents sesbasic_bxs">
  <div class="sesdocument_categories_documents_listing_title clear sesbasic_clearfix"> <span class="sesdocument_category_title"><?php echo $this->title_pop; ?></span> </div>
  <?php foreach($this->paginatorc as $documentsCri){ ?>
  <div class="sesdocument_thumb sesbasic_animation"> <a href="<?php echo $documentsCri->getHref(); ?>" data-src="<?php echo $documentsCri->getGuid(); ?>" class="sesdocument_thumb_img ses_tooltip"> <span class="sesdocument_animation" style="background-image:url(<?php echo $documentsCri->getPhotoUrl('thumb.profile'); ?>);"></span>
    <div class="sesdocument_category_cover_documents_item_info sesdocument_animation">
      <div class="sesdocument_list_title"><?php echo $documentsCri->getTitle(); ?> </div>
    </div>
    </a> </div>
  <?php }  ?>
</div>
<?php	}  ?>
<?php } ?>
<!-- category subcategory -->
<?php if($this->show_subcat == 1){?>
<div class="sesdocument_categories_documents_listing_title clear sesbasic_clearfix"> <span class="sesdocument_category_title"><?php echo $this->subcategory_title; ?></span> </div>
<div class="sesbasic_clearfix">
  <ul class="sesdocument_category_grid_listing sesbasic_clearfix clear sesbasic_bxs">
    <?php foreach( $this->innerCatData as $item ): ?>
    <li class="sesdocument_category_grid sesbm" style="height:<?php echo is_numeric($this->heightSubcat) ? $this->heightSubcat.'px' : $this->heightSubcat ?>;width:<?php echo is_numeric($this->widthSubcat) ? $this->widthSubcat.'px' : $this->widthSubcat ?>;"> <a href="<?php echo $item->getHref(); ?>">
      <div class="sesdocument_category_grid_img">
        <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)){ ?>
        <span class="sesdocument_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
        <?php } ?>
      </div>
      <div class="sesdocument_category_grid_overlay sesdocument_animation"></div>
      <div class="sesdocument_category_grid_info">
        <div>
          <div class="sesdocument_category_grid_details">
            <?php if(isset($this->iconSubcatActive) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
            <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl('thumb.icon'); ?>" />
            <?php } ?>
            <?php if(isset($this->titleSubcatActive)){ ?>
            <span><?php echo $item->category_name; ?></span>
            <?php } ?>
            <?php if(isset($this->countdocumentsSubcatActive)){ ?>
            <span class="sesdocument_category_grid_stats"><?php echo $this->translate(array('%s document', '%s documents', $item->total_documents_categories), $this->locale()->toNumber($item->total_documents_categories))?></span>
            <?php } ?>
          </div>
        </div>
      </div>
      </a> </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php } ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
  <div class="sesdocument_categories_documents_listing_title clear sesbasic_clearfix"> <span class="sesdocument_category_title"><?php echo $this->document_title; ?></span> </div>
  <ul class="sesdocument_cat_document_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>">
    <?php } ?>
    <?php $totalCount = $this->paginator->getCurrentItemCount();
    			$allowedLimit = 5;
          $counter = 1;
          $break = false;
          $type = 1;
          $close = false;
    ?>
    <?php foreach($this->paginator as $item){ ?>
    <?php
          $href = $item->getHref();
          $imageURL = $item->getPhotoUrl();          
      ?>
    <?php if(($this->paginator->getCurrentPageNumber() == 1 || $this->loadOptionData == 'pagging') && !$break && $totalCount >= $allowedLimit ){ ?>
    <?php if(($counter-1)%5 == 0 ){ ?>
    <li class="sesbasic_clearfix sesbasic_bxs clear">
      <div class="sesdocument_documentlist_row clear sesbasic_clearfix">
        <?php } ?>
        <?php if($type == 1) { ?>
        <?php if(!$close){  ?>
        <div class="sesdocument_documentlist_column_small floatL">
          <?php } ?>
          <div class="sesdocument_cat_document_list">
            <div class="sesdocument_thumb"> <a href="<?php echo $href; ?>" class="sesdocument_thumb_img"> <span class="sesdocument_animation" style="background-image:url(<?php echo $imageURL; ?>);"></span>
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
              <div class="sesdocument_cat_document_list_info sesdocument_animation">
                <div>
                  <div class="sesdocument_cat_document_list_content">
                    <?php if(isset($this->titleActive)){ ?>
                    <div class="sesdocument_cat_document_list_title"> <?php echo $item->getTitle(); ?> </div>
                    <?php } ?>
                    <?php if(isset($this->byActive)){ ?>
                    <div class="sesdocument_cat_document_list_stats sesbasic_text_light">
                      <i class='fa fa-user'></i> <?php
                                $owner = $item->getOwner();
                                echo $this->translate('%1$s', $owner->getTitle());
                              ?>
                    </div>
                    <?php } ?>
                    <div class="sesdocument_cat_document_list_stats sesdocument_list_stats sesbasic_text_light">
                      <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                      <?php } ?>
                      <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                      <?php } ?>
                      <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                      <?php } ?>
                      <?php  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
                      <?php } ?>
                      <?php if(isset($this->ratingActive)  && isset($item->rating) ): ?>
                      <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
                      <?php endif; ?>
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
                </div>
              </div>
              </a> </div>
          </div>
          <?php if($close){ $close = false;  ?>
        </div>
        <?php }else{ $close = true;  }   ?>
        <?php } ?>
        <?php if($type == 2){  ?>
        <div class="sesdocument_documentlist_column_big floatL">
          <div class="sesdocument_cat_document_list">
            <div class="sesdocument_thumb"> <a href="<?php echo $href; ?>" class="sesdocument_thumb_img"> <span class="sesdocument_animation" style="background-image:url(<?php echo $imageURL; ?>);"></span>
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
              <div class="sesdocument_cat_document_list_info sesdocument_animation">
                <div>
                  <div class="sesdocument_cat_document_list_content">
                    <?php if(isset($this->titleActive)){ ?>
                    <div class="sesdocument_cat_document_list_title"> <?php echo $item->getTitle(); ?> </div>
                    <?php } ?>
                    <?php if(isset($this->byActive)){ ?>
                  <div class="sesdocument_cat_document_list_stats sesbasic_text_light">
                      <i class='fa fa-user'></i> <?php
                                $owner = $item->getOwner();
                                echo $this->translate('%1$s', $owner->getTitle());
                              ?>
                    </div>
                    <?php } ?>
                    <div class="sesdocument_cat_document_list_stats sesdocument_list_stats sesbasic_text_light">
                      <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                      <?php } ?>
                      <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                      <?php } ?>
                      <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                      <?php } ?>
                      <?php  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
                      <?php } ?>
                      <?php if(isset($this->ratingActive)  && isset($item->rating) ): ?>
                      <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
                      <?php endif; ?>
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
                </div>
              </div>
              </a> </div>
          </div>
        </div>
        <?php } ?>
        <?php if(($counter)%5 == 0){ ?>
      </div>
    </li>
    <?php } ?>
    <?php
      	if($counter == 2 || $counter == 9 || $counter == 10) $type = 2;
       		else $type = 1;
        ?>
    <?php if($counter%5 == 0){
              $allowedLimit = $allowedLimit + 5;
            }
            if($counter%15 == 0){
              $break = true;
            }
      ?>
    <?php }else{ ?>
    <li class="sesdocument_cat_document_list" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <div class="sesdocument_thumb"> <a href="<?php echo $href; ?>" class="sesdocument_thumb_img"> <span class="bg_item_photo sesdocument_animation" style="background-image:url(<?php echo $imageURL; ?>);"></span>
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
        <div class="sesdocument_cat_document_list_info sesdocument_animation">
          <div>
            <div class="sesdocument_cat_document_list_content">
              <?php if(isset($this->titleActive)){ ?>
              <div class="sesdocument_cat_document_list_title"> <?php echo $item->getTitle(); ?> </div>
              <?php } ?>
              <?php if(isset($this->byActive)){ ?>
              <div class="sesdocument_cat_document_list_stats sesbasic_text_light">
                      <i class='fa fa-user'></i> <?php
                                $owner = $item->getOwner();
                                echo $this->translate('%1$s', $owner->getTitle());
                              ?>
                    </div>
                    <?php } ?>
              <div class="sesdocument_cat_document_list_stats sesdocument_list_stats sesbasic_text_light">
                <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                <?php } ?>
                <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                <?php } ?>
                <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                <?php } ?>
                <?php  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
                <?php } ?>
                <?php if(isset($this->ratingActive)  && isset($item->rating)  ): ?>
                <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>
                <?php endif; ?>
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
          </div>
        </div>
        </a> </div>
    </li>
    <?php }
   		 $counter ++;
    } ?>
    <?php  if(  $totalCount == 0){  ?>
    <div class="tip"> <span> <?php echo $this->translate("No documents in this  category."); ?>
      <?php if (!$this->can_edit):?>
      <?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesdocument_general").'">', '</a>'); ?>
      <?php endif; ?>
      </span> </div>
    <?php } ?>
    <?php
          if($this->loadOptionData == 'pagging'){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesdocument"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
    <?php if(!$this->is_ajax){ ?>
  </ul>
</div>
<?php if($this->loadOptionData != 'pagging'){ ?>
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>
<?php } ?>
<script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 jqueryObjectOfSes('.overlay_<?php echo $randonNumber ?>').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesdocument/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: pageNum,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
				type:'<?php echo $this->view_type; ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				jqueryObjectOfSes('.overlay_<?php echo $randonNumber ?>').css('display','none');
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				dynamicWidth();
      }
    })).send();
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
		 jqueryObjectOfSes(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = jqueryObjectOfSes('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = jqueryObjectOfSes(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && jqueryObjectOfSes('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
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
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesdocument/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				dynamicWidth();
      }
    })).send();
    return false;
  }
<?php if(!$this->is_ajax){ ?>
function dynamicWidth(){
	var objectClass = jqueryObjectOfSes('.sesdocument_cat_document_list_info');
	for(i=0;i<objectClass.length;i++){
			jqueryObjectOfSes(objectClass[i]).find('div').find('.sesdocument_cat_document_list_content').find('.sesdocument_cat_document_list_title').width(jqueryObjectOfSes(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script> 
