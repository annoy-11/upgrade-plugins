<?php

?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
				$randonNumber = $this->identityForWidget;
      }else{
      	$randonNumber = $this->identity; 
      }
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); ?> 
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?> 
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
 <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear sesdocument_categories_documents_listing_container">
<?php } ?>
  <?php  foreach( $this->paginatorCategory as $item ): ?>
  	<div class="sesdocument_categories_documents_listing clear sesbasic_clearfix">
    	<div class="sesdocument_categories_documents_listing_title clear sesbasic_clearfix">
      	<a class="sesbasic_linkinherit" href="<?php echo $item->getBrowseCategoryHref(); ?>?category_id=<?php echo $item->category_id ?>" title="<?php echo $this->translate($item->category_name); ?>"><?php echo $this->translate($item->category_name); ?><?php if(isset($this->count_document) && $this->count_document == 1){ ?><?php echo "(".$item->total_document_categories.")"; ?><?php } ?></a>
       <?php if(isset($this->seemore_text) && $this->seemore_text != ''){ ?>
          <span <?php echo $this->allignment_seeall == 'right' ?  'class="floatR"' : ''; ?> >
          	<a href="<?php echo $item->getBrowseCategoryHref(); ?>?category_id=<?php echo $item->category_id ?>" title="<?php echo $this->translate($item->category_name); ?>">
            <?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
            <?php echo str_replace('[category_name]',$item->category_name,$seemoreTranslate); ?>
          </a>
         </span>
       <?php }?>
      </div>
	     <?php if($this->view_type == 1){ ?> 
       <?php if(isset($this->resultArray['document_data'][$item->category_id])){ ?>
       <div class="sesdocument_categories_documents_listing_thumbnails clear sesbasic_clearfix">
       <?php 
            $counter = 1;
            $itemDocuments = $this->resultArray['document_data'][$item->category_id];

            foreach($itemDocuments as $itemDocument){ 
            if($counter == 1)
              $documentData = $itemDocument;
            ?>
          <div class="<?php echo $counter == 1 ? 'thumbnail_active' : '' ?>" <?php if(empty($this->photoThumbnailActive)) { ?> style="display:none;" <?php } ?>>
          <a href="<?php echo $itemDocument->getHref(); ?>" title="<?php echo $itemDocument->getTitle(); ?>" data-url="<?php echo $itemDocument->sesdocument_id ?>" class="slideshow_document_data">
            <img src="<?php echo $itemDocument->getPhotoUrl('thumb.normalmain'); ?>" alt="<?php echo $itemDocument->title ?>" class="thumb_icon item_photo_user  thumb_icon"></a>
          </div>
          <?php 
            $counter++;
          } ?>
        </div>      
        <?php } ?>
      <?php  if(isset($documentData) && $documentData != '') { ?>
      <div class="sesdocument_categories_documents_conatiner clear sesbasic_clearfix sesbm">
        <div class="sesdocument_categories_documents_item sesbasic_clearfix clear">
        <?php if(isset($this->documentPhotoActive)) { ?>
          <div class="sesdocument_categories_documents_items_photo floatL sesdocument_grid_btns_wrap">
          	<a class="sesdocument_thumb_img" href="<?php echo $documentData->getHref(); ?>">
            	<span style="background-image:url(<?php echo $documentData->getPhotoUrl('thumb.main'); ?>);"></span>
            </a>
          	<?php 
              if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->listButtonActive)) {
                $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemDocument->getHref());
                $shareOptions .= "<div class='sesdocument_grid_btns'>";
               /* if(isset($this->socialSharingActive)) {

                  $shareOptions .= $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemdocument, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit));
                }*/
               // $canComment =  $itemdocument->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
                if(isset($this->likeButtonActive) ){
                  $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($itemDocument->sesdocument_id,$itemDocument->getType());
                  $likeClass = ($LikeStatus) ? ' button_active' : '' ;
                  $shareOptions .= "<a href='javascript:;' data-url=\"$itemdocument->sesdocument_id\" class='sesbasic_icon_btn sesdocument_like_sesdocument_document_". $itemdocument->sesdocument_id." sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document ".$likeClass ." '><i class='fa fa-thumbs-up'></i><span>$itemdocument->like_count</span></a>";
                }
                if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && isset($itemdocument->favourite_count) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){
                  $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$itemdocument->sesdocument_id));
                  $favClass = ($favStatus)  ? 'button_active' : '';
                  $shareOptions .= "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_". $itemdocument->sesdocument_id." sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document ".$favClass ."' data-url=\"$itemdocument->sesdocument_id\"><i class='fa fa-heart'></i><span>$itemdocument->favourite_count</span></a>";
                }
                if(isset($this->listButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity()) { 
                $shareOptions .= '<a href="javascript:;" onclick="opensmoothboxurl('."'".$this->url(array('action' => 'add','module'=>'sesdocument','controller'=>'list','document_id'=>$itemdocument->sesdocument_id),'default',true)."'".');return false;"	class="sesbasic_icon_btn  sesdocument_add_list"  title="'.$this->translate('Add To List').'" data-url="'.$itemdocument->sesdocument_id.'"><i class="fa fa-plus"></i></a>';
                }
                $shareOptions .= "</div>";
                echo $shareOptions;
              } ?>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
              <span class="sesdocument_labels">
                <?php if(isset($this->featuredLabelActive) && $documentData->featured == 1){ ?>
                  <span class="sesdocument_label_featured"><?php echo $this->translate("Featured"); ?></span>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive)  && $documentData->sponsored == 1){ ?>
                  <span class="sesdocument_label_sponsored"><?php echo $this->translate("Sponsored"); ?></span>
                <?php } ?>
              </span>
            <?php } ?>
          </div>
        <?php } ?>
          <div class="sesdocument_categories_documents_items_cont">
            <div class="sesdocument_categories_documents_items_title">
            <?php if(isset($this->titleActive)){ ?>
            	<?php 
              		if(strlen($documentData->title)>$this->title_truncation)
                  	$documentTitle = mb_substr($documentData->title,0,($this->title_truncation - 3)).'...';
                  else
              			$documentTitle = $documentData->title; 
              ?>
            	<a href="<?php echo $documentData->getHref(); ?>" class="ses_tooltip" data-src="<?php echo $documentData->getGuid(); ?>"><?php echo $documentTitle ?></a>
             <?php } 
             if(isset($this->verifiedLabelActive) && $documentData->verified == 1) { ?>
            	  <i class="sesdocument_verified_sign fa fa-check-circle" title="<?php echo $this->translate('Verified'); ?>"></i>
          	<?php
             }
             ?>
            </div>
            <div class="sesdocument_categories_documents_item_cont_btm">
              <?php if(isset($this->byActive)){ ?>
                <div class="sesdocument_categories_documents_item_stat sesdocument_list_stats">
                  <span>
                   <?php $owner = $documentData->getOwner(); ?>
                    <i class="fa fa-user sesbasic_text_light" title="<?php echo $this->translate('By');?>"></i>	
                    <?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
                  </span>
                </div>
              <?php } ?>
              
             
             
              <?php
              
                // Show Category
                $showCategory = '';
                if(isset($this->categoryActive)){
                  if($documentData->category_id != '' && intval($documentData->category_id) && !is_null($documentData->category_id)){
                    $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $documentData->category_id);
                    $categoryUrl = $categoryItem->getHref();
                    $categoryName = $categoryItem->category_name;
                    if($categoryItem){
                      $showCategory .= "<div class=\"sesdocument_list_stats\">
                        <span class=\"widthfull\">
                          <i class=\"fa fa-folder-open sesbasic_text_light\"></i> 
                          <span><a href=\"$categoryUrl\">$categoryName</a>";
                          $subcategory = Engine_Api::_()->getItem('sesdocument_category',$documentData->subcat_id);
                          if($subcategory && $documentData->subcat_id != 0){
                            $subCategoryUrl = $subcategory->getHref();
                            $subCategoryName = $subcategory->category_name;
                            $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subCategoryUrl\">$subCategoryName</a>";
                          }
                          $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$documentData->subsubcat_id);
                          if($subsubcategory && $documentData->subsubcat_id != 0){
                            $subsubCategoryUrl = $subsubcategory->getHref();
                            $subsubCategoryName = $subsubcategory->category_name;
                             $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subsubCategoryUrl)\">$subsubCategoryName</a>";
                          }
                       echo   $showCategory .= "<span></span></div>";
                    }
                  }
                }
                
             ?>
              <div class="sesdocument_categories_documents_item_stat sesdocument_list_stats">
                <?php if(isset($this->likeActive)) { ?>
                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $documentData->like_count), $this->locale()->toNumber($documentData->like_count)); ?>">
                    <i class="fa fa-thumbs-up sesbasic_text_light"></i>
                    <?php echo $documentData->like_count;?>
                  </span>
                <?php } ?>
                <?php  if(isset($this->commentActive)) { ?>
                  <span title="<?php echo $this->translate(array('%s comment', '%s comments', $documentData->comment_count), $this->locale()->toNumber($documentData->comment_count)); ?>">
                    <i class="fa fa-comment sesbasic_text_light"></i>
                    <?php echo $documentData->comment_count;?>
                  </span>
               <?php } ?>
               <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive)) { ?>
                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $documentData->favourite_count), $this->locale()->toNumber($documentData->favourite_count)); ?>">
                    <i class="fa fa-heart sesbasic_text_light"></i>
                    <?php echo $documentData->favourite_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->viewActive)) { ?>
                  <span title="<?php echo $this->translate(array('%s view', '%s views', $documentData->view_count), $this->locale()->toNumber($documentData->view_count)); ?>">
                    <i class="fa fa-eye sesbasic_text_light"></i>
                    <?php echo $documentData->view_count;?>
                  </span>
                <?php } ?>
                <?php if(isset($this->ratingActive)  && isset($documentData->rating) && $documentData->rating > 0 ): ?>
                  <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $documentData->rating), $this->locale()->toNumber($documentData->rating))?>"><i class="fa fa-star"></i><?php echo round($documentData->rating,1).'/5';?></span>
                <?php endif; ?>
              </div>
              <?php if(isset($this->descriptionActive)){ ?>
                <div class="sesdocument_list_des clear">
                <?php if(strlen(strip_tags($documentData->description)) > $this->description_truncation){
                        $description = strip_tags(mb_substr($documentData->description,0,($this->description_truncation - 3))).'...';
                      }else{ ?>
                <?php $description = strip_tags($documentData->description); ?>
                <?php } ?>
                <?php echo $description; ?>
                </div>
              <?php } ?>
						</div>
          </div>
        </div>
      <?php for($i = 2;$i <= $counter; $i++){ ?>
      		<div class="sesdocument_categories_documents_item sesbasic_clearfix clear nodata" style="display:none;"></div>
      <?php } ?>
      	<?php if($counter>2) { ?>
        <div class="sesdocument_categories_documents_btns">
        	<a href="javascript:;" class="prevbtn sesdocument_slideshow_prev"><i class="fa fa-angle-left sesbasic_text_light"></i></a>
          <a href="javascript:;" class="nxtbtn sesdocument_slideshow_next"><i class="fa fa-angle-right sesbasic_text_light"></i></a>
        </div>
        <?php } ?>
      </div>
			<?php } ?>
    <?php } else if($this->view_type == 0) { ?>
    <?php if(isset($this->resultArray['document_data'][$item->category_id])){
	    $changeClass = 0;
    ?>
    <?php foreach($this->resultArray['document_data'][$item->category_id] as $itemdocument){ 
      $href = $itemdocument->getHref();
	    $imageURL = $itemdocument->getPhotoUrl('thumb.normalmain');
    ?>
		  <div class="sesdocument_documentlist_column_<?php echo $changeClass == 0 ? 'big' : 'small'; ?> floatL">
		    <div class="sesdocument_cat_document_list">
		      <div class="sesdocument_thumb">
		        <a href="<?php echo $href; ?>">
		          <span class="sesdocument_animation" style="background-image:url(<?php echo $imageURL; ?>);"></span>
		         <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
		          <p class="sesdocument_labels">
		          <?php if(isset($this->featuredLabelActive) && $itemdocument->featured == 1){ ?>
		            <span class="sesdocument_label_featured"><?php echo $this->translate("Featured"); ?></span>
		          <?php } ?>
		          <?php if(isset($this->sponsoredLabelActive) && $itemdocument->sponsored == 1){ ?>
		            <span class="sesdocument_label_sponsored"><?php echo $this->translate("Sponsored"); ?></span>
		          <?php } ?>
		          </p>
		          <?php } ?>
		          <div class="sesdocument_cat_document_list_info sesdocument_animation">
		            <div>
		              <div class="sesdocument_cat_document_list_content">
		              <?php if(isset($this->titleActive)){ ?>
		                <div class="sesdocument_cat_document_list_title">
                      <?php 
                          if(strlen($itemdocument->title) > $this->title_truncation)
                            $documentTitle = mb_substr($itemdocument->title,0,($this->title_truncation - 3)).'...';
                          else
                            $documentTitle = $itemdocument->title; 
                      ?>                      
			                <?php echo $this->htmlLink($itemdocument->getHref(),$documentTitle ) ;
                      	if(isset($this->verifiedLabelActive) && $itemdocument->verified == 1) { ?>
                        	<i class="sesdocument_verified_sign fa fa-check-circle" title="<?php echo $this->translate('Verified'); ?>"></i>
                      <?php } ?>
		                </div>
		                <?php } ?>
		                <?php if(isset($this->byActive)){ ?>
		                	<div class="sesdocument_cat_document_list_stats sesdocument_list_stats">
                      	<span>
                        	<span>
                            <?php
                              $owner = $itemdocument->getOwner();
                             echo $this->translate('Posted by %1$s', $this->htmlLink($owner->getHref(),$owner->getTitle()));
                            ?>
                          </span>
                        </span>
		                	</div>
		                <?php } ?>
                    
                    <?php
                      
                     // Show Category
                    $showCategory = '';
                    if(isset($this->categoryActive)){
                      if($itemdocument->category_id != '' && intval($itemdocument->category_id) && !is_null($itemdocument->category_id)){
                        $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $itemdocument->category_id);
                        $categoryUrl = $categoryItem->getHref();
                        $categoryName = $categoryItem->category_name;
                        if($categoryItem){
                          $showCategory .= "<div class=\"sesdocument_list_stats sesdocument_cat_document_list_stats\">
                            <span class=\"widthfull\">
                              <i class=\"fa fa-folder-open sesbasic_text_light\"></i> 
                              <span><a href=\"$categoryUrl\">$categoryName</a>";
                              $subcategory = Engine_Api::_()->getItem('sesdocument_category',$itemdocument->subcat_id);
                              if($subcategory && $itemdocument->subcat_id != 0){
                                $subCategoryUrl = $subcategory->getHref();
                                $subCategoryName = $subcategory->category_name;
                                $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subCategoryUrl\">$subCategoryName</a>";
                              }
                              $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$itemdocument->subsubcat_id);
                              if($subsubcategory && $itemdocument->subsubcat_id != 0){
                                $subsubCategoryUrl = $subsubcategory->getHref();
                                $subsubCategoryName = $subsubcategory->category_name;
                                 $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subsubCategoryUrl)\">$subsubCategoryName</a>";
                              }
                           echo   $showCategory .= "<span></span></div>";
                        }
                      }
                    }
                  ?>
		                <div class="sesdocument_cat_document_list_stats sesdocument_list_stats sesbasic_text_light">
		                  <?php if(isset($this->likeActive) && isset($itemdocument->like_count)) { ?>
		                    <span title="<?php echo $this->translate(array('%s like', '%s likes', $itemdocument->like_count), $this->locale()->toNumber($itemdocument->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $itemdocument->like_count; ?></span>
		                  <?php } ?>
		                  <?php if(isset($this->commentActive) && isset($itemdocument->comment_count)) { ?>
		                    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $itemdocument->comment_count), $this->locale()->toNumber($itemdocument->comment_count))?>"><i class="fa fa-comment"></i><?php echo $itemdocument->comment_count;?></span>
		                  <?php } ?>
		                  <?php if(isset($this->viewActive) && isset($itemdocument->view_count)) { ?>
		                    <span title="<?php echo $this->translate(array('%s view', '%s views', $itemdocument->view_count), $this->locale()->toNumber($itemdocument->view_count))?>"><i class="fa fa-eye"></i><?php echo $itemdocument->view_count; ?></span>
		                  <?php } ?>
		                   <?php  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($itemdocument->favourite_count)) { ?>
		                    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemdocument->favourite_count), $this->locale()->toNumber($itemdocument->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $itemdocument->favourite_count; ?></span>
		                  <?php } ?>
                      <?php if(isset($this->ratingActive)  && isset($itemdocument->rating) && $itemdocument->rating > 0 ): ?>
                        <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $itemdocument->rating), $this->locale()->toNumber($itemdocument->rating))?>"><i class="fa fa-star"></i><?php echo round($itemdocument->rating,1).'/5';?></span>
                      <?php endif; ?>
		                </div>
		              </div>
		            </div>
		          </div>
		        </a>
			    </div>
		    </div>
			</div>          
	    <?php 
	    $changeClass++;
	    }
	    $changeClass = 0;
	    ?>
      <?php } ?>
    <?php } elseif($this->view_type == 2) {  ?>
    <?php foreach($this->resultArray['document_data'][$item->category_id] as $itemdocument){ 
      $href = $itemdocument->getHref();
	    $imageURL = $itemdocument->getPhotoUrl('thumb.normalmain');
    ?>
    <?php $photoWidth =  is_numeric($this->photo_width) ? $this->photo_width.'px' : $this->photo_width ?>
    <?php $photoHeight =  is_numeric($this->photo_height) ? $this->photo_height.'px' : $this->photo_height ?>
    <?php $infoHeight =  is_numeric($this->info_height) ? $this->info_height.'px' : $this->info_height ?>
    <div class="sesdocument_grid1 sesbasic_bxs sesbm" style='height:<?php echo $infoHeight ?>;width:<?php echo  $photoWidth ?>' >
			<div style="height:<?php echo $photoHeight; ?>;" class="sesdocument_list_thumb sesdocument_grid_btns_wrap">
				<a href="<?php echo $href; ?>" class="sesdocument_list_thumb_img">
			    <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
				<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
					<p class="sesdocument_labels">
						<?php if(isset($this->featuredLabelActive) && $itemdocument->featured == 1){ ?>
							<span class="sesdocument_label_featured"><?php echo $this->translate("Featured"); ?></span>
						<?php } ?>
						<?php if(isset($this->sponsoredLabelActive) && $itemdocument->sponsored == 1){ ?>
							<span class="sesdocument_label_sponsored"><?php echo $this->translate("Sponsored"); ?></span>
						<?php } ?>
            <?php if(isset($this->verifiedLabelActive) && $itemdocument->verified == 1){ ?>
							<span class="sesdocument_label_sponsored"><?php echo $this->translate("Verified"); ?></span>
						<?php } ?>
					</p>
				<?php } ?>
			<?php 
		  if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->listButtonActive)) {
        $shareOptions = '';
				$urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemdocument->getHref());
				$shareOptions .= "<div class='sesdocument_grid_btns sesbasic_pinboard_list_btns'>";
				if(isset($this->socialSharingActive)) {

					$shareOptions .= $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemdocument, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit));
				}
				$canComment =  $itemdocument->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
				if(isset($this->likeButtonActive) && $canComment){
					$LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($itemdocument->sesdocument_id,$itemdocument->getType());
					$likeClass = ($LikeStatus) ? ' button_active' : '' ;
					$shareOptions .= "<a href='javascript:;' data-url=\"$itemdocument->sesdocument_id\" class='sesbasic_icon_btn sesdocument_like_sesdocument_document_". $itemdocument->sesdocument_id." sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document ".$likeClass ." '><i class='fa fa-thumbs-up'></i><span>$itemdocument->like_count</span></a>";
				}
				if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && isset($itemdocument->favourite_count) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){
					$favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$itemdocument->sesdocument_id));
					$favClass = ($favStatus)  ? 'button_active' : '';
					$shareOptions .= "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_". $itemdocument->sesdocument_id." sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document ".$favClass ."' data-url=\"$itemdocument->sesdocument_id\"><i class='fa fa-heart'></i><span>$itemdocument->favourite_count</span></a>";
				}
         if(isset($this->listButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity()) { 
           $shareOptions .= '<a href="javascript:;" onclick="opensmoothboxurl('."'".$this->url(array('action' => 'add','module'=>'sesdocument','controller'=>'list','document_id'=>$itemdocument->sesdocument_id),'default',true)."'".');return false;"	class="sesbasic_icon_btn  sesdocument_add_list"  title="'.$this->translate('Add To List').'" data-url="'.$itemdocument->sesdocument_id.'"><i class="fa fa-plus"></i></a>';
         }
				$shareOptions .= "</div>";
				echo $shareOptions;
			} ?>
        
      </div>
      <div style='height:<?php echo $infoHeight; ?>' class="sesdocument_list_info">
      	<?php
        // Category Only for grid view
		$showgrid1Category ='';
    $colorCategory = '#990066';
    if(isset($this->categoryActive)){
     if($itemdocument->category_id != '' && intval($itemdocument->category_id) && !is_null($itemdocument->category_id)){
        $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $itemdocument->category_id);
        $categoryUrl = $categoryItem->getHref();
        $categoryName = $categoryItem->category_name;
          if($categoryItem){
            $colorCategory = (!empty($categoryItem->color)) ? '#'.$categoryItem->color : '#990066';
            $showgrid1Category .= "<span> 
                <a href=\"$categoryUrl\">$categoryName</a>";
                $subcategory = Engine_Api::_()->getItem('sesdocument_category',$itemdocument->subcat_id);
                if($subcategory && $itemdocument->subcat_id){
                  $subCategoryUrl = $subcategory->getHref();
                  $subCategoryName = $subcategory->category_name;
                  $showgrid1Category .= "&nbsp;&raquo;&nbsp;<a href=\"$subCategoryUrl\">$subCategoryName</a>";
                }
                $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$itemdocument->subsubcat_id);
                if($subsubcategory && $itemdocument->subsubcat_id){
                  $subsubCategoryUrl = $subsubcategory->getHref();
                  $subsubCategoryName = $subsubcategory->category_name;
                  $showgrid1Category .= "&nbsp;&raquo;&nbsp;<a href=\"$subsubCategoryUrl)\">$subsubCategoryName</a>";
                }
               $showgrid1Category .="<style type='text/css'>.sesdocument_grid_bubble_$categoryItem->category_id > span:after{border-top-color:$colorCategory ;}</style>";
              $showgrid1Category .= "</span>";
              
          }
       }
    }
    ?>
     <?php
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesdocumentticket') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocumentticket.pluginactivated')) {
			if(isset($this->buyActive)){
			$params['document_id'] = $document->sesdocument_id;
			$params['checkEndDateTime'] = date('Y-m-d H:i:s');
			$ticket = Engine_Api::_()->getDbtable('tickets', 'sesdocument')->getTicket($params);
			if(count($ticket))
				$buyTicket = '<a class="sesbasic_link_btn" href="'.$this->url(array('document_id' => $document->custom_url), 'sesdocument_ticket', true).'">'.$this->translate("Book Now").'</a>';
			 else
				$buyTicket = '';
			}else
				$buyTicket = '';
		}
    echo "<div class='sesdocument_grid_bubble sesdocument_grid_bubble_$categoryItem->category_id sesbasic_clearfix' style='background-color:$colorCategory ;'>
					$showgrid1Category
          $buyTicket  
				</div>";
		?>
				<?php if(isset($this->titleActive)) { ?>
					<div class="sesdocument_list_title">
          	<?php 
              		if(strlen($itemdocument->title) > $this->title_truncation)
                  	$documentTitle = mb_substr($itemdocument->title,0,($this->title_truncation - 3)).'...';
                  else
              			$documentTitle = $itemdocument->title; 
              ?>
						<?php echo $this->htmlLink($itemdocument->getHref(),$documentTitle,array('class'=>'ses_tooltip','data-src'=>$itemdocument->getGuid()) ) ?>
					</div>
				<?php } ?>											
	        <?php if(isset($this->byActive)){ ?>
	          <div class="sesdocument_list_stats">
	            <span>
                <i class="fa fa-user sesbasic_text_light" title="<?php echo $this->translate('Posted by'); ?>"></i>
                  <?php
                    $owner = $itemdocument->getOwner();
                    echo $this->translate('%1$s', $this->htmlLink($owner->getHref(),$owner->getTitle()));
                  ?>
              </span>
	          </div>
          <?php } ?>
				
		
	
        
				<div class="sesdocument_list_stats">
					<?php if(isset($this->likeActive) && isset($itemdocument->like_count)) { ?>
	          <span title="<?php echo $this->translate(array('%s like', '%s likes', $itemdocument->like_count), $this->locale()->toNumber($itemdocument->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $itemdocument->like_count; ?></span>
	        <?php } ?>
	        <?php if(isset($this->commentActive) && isset($itemdocument->comment_count)) { ?>
	          <span title="<?php echo $this->translate(array('%s comment', '%s comments', $itemdocument->comment_count), $this->locale()->toNumber($itemdocument->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $itemdocument->comment_count;?></span>
	        <?php } ?>
	        <?php if(isset($this->viewActive) && isset($itemdocument->view_count)) { ?>
	          <span title="<?php echo $this->translate(array('%s view', '%s views', $itemdocument->view_count), $this->locale()->toNumber($itemdocument->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $itemdocument->view_count; ?></span>
	        <?php } ?>
	         <?php  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($itemdocument->favourite_count)) { ?>
	          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemdocument->favourite_count), $this->locale()->toNumber($itemdocument->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $itemdocument->favourite_count; ?></span>
	        <?php } ?>
          <?php if(isset($this->ratingActive)  && isset($itemdocument->rating) && $itemdocument->rating > 0 ): ?>
            <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $itemdocument->rating), $this->locale()->toNumber($itemdocument->rating))?>"><i class="fa fa-star"></i><?php echo round($itemdocument->rating,1).'/5';?></span>
          <?php endif; ?>
				</div>
	      <?php if(isset($this->descriptionActive)){ ?>
          <div class="sesdocument_list_des">
          <?php if(strlen(strip_tags($itemdocument->description)) > $this->description_truncation){
                    $description = mb_substr(strip_tags($itemdocument->description),0,($this->description_truncation - 3 )).'...';
                   }else{ ?>
            <?php $description = strip_tags($itemdocument->description); ?>
              <?php } ?>
              <?php echo $description; ?>
          </div>
        <?php } ?>
    	</div>
    	<div class="sesdocument_list_footer"><a style="background-color:<?php echo $colorCategory; ?>" class="sesdocument_animation" href="<?php echo $href ?>"><?php echo $this->translate("View Details"); ?></a></div>
    </div>
     <?php }
		}else if($this->view_type == 5){
    $advGrid = '';
    foreach($this->resultArray['document_data'][$item->category_id] as $document){ 
    
     	$advgridHeight =  is_numeric($this->info_height) ? $this->info_height.'px' : $this->info_height; 
      $advgridWidth =  is_numeric($this->photo_width) ? $this->photo_width.'px' : $this->photo_width  ;
     	
    	//Advanced Grid View
          $advGrid .= "<li class='sesbasic_item_grid sesbasic_clearfix sesbasic_bxs sesbasic_item_grid_btns_wrap sesbm' style='width:$advgridWidth;height:$advgridHeight'>
          <div class='sesbasic_item_grid_thumb floatL'>";?>    
          <?php
          $advGrid .=
            '<a href="'.$document->getHref().'" class="sesbasic_item_grid_thumb_img floatL">
              <span class="floatL" style="background-image:url('.$document->getPhotoUrl().');"></span>
              <div class="sesbasic_item_grid_thumb_overlay"></div>
            </a>';
           
           $advLabels = '';
            if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)) {
              $advLabels .= "<p class=\"sesbasic_item_grid_labels\">";
              if(isset($this->featuredLabelActive) && $document->featured == 1) {
                $advLabels .= "<span class=\"sesdocument_label_featured\">FEATURED</span>";
              }
              if(isset($this->sponsoredLabelActive) && $document->sponsored == 1) {
                $advLabels .= "<span class=\"sesdocument_label_sponsored\">SPONSORED</span>";
              }
              $advLabels .= "</p>";
            }
            
            $shareoptionsAdv = '';
            if((isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->listButtonActive)) && $document->is_approved) {
              $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $document->getHref());
              $shareoptionsAdv .= "<div class='sesbasic_item_grid_btns sesdocument_grid_btns'>";
              if(isset($this->socialSharingActive)) {

              $shareOptions .= $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $document, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit));
              }
              $canComment =  $document->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
              if(isset($this->likeButtonActive) && $canComment){
                $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($document->sesdocument_id,$document->getType());
                $likeClass = ($LikeStatus) ? ' button_active' : '' ;
          $shareoptionsAdv .= "<a href='javascript:;' data-url=\"$document->sesdocument_id\" class='sesbasic_icon_btn sesdocument_like_sesdocument_document_". $document->sesdocument_id." sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document ".$likeClass ." '><i class='fa fa-thumbs-up'></i><span>$document->like_count</span></a>";
              }
              if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($document->favourite_count)  ){ 
                $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$document->sesdocument_id));
                $favClass = ($favStatus)  ? 'button_active' : '';
                $shareoptionsAdv .= "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_". $document->sesdocument_id." sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document ".$favClass ."' data-url=\"$document->sesdocument_id\"><i class='fa fa-heart'></i><span>$document->favourite_count</span></a>";
              }
              if(isset($this->listButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity()) { 
              $shareoptionsAdv .= '<a href="javascript:;" onclick="opensmoothboxurl('."'".$this->url(array('action' => 'add','module'=>'sesdocument','controller'=>'list','document_id'=>$document->sesdocument_id),'default',true)."'".');return false;"	class="sesbasic_icon_btn  sesdocument_add_list"  title="'.$this->translate('Add To List').'" data-url="'.$document->sesdocument_id.'"><i class="fa fa-plus"></i></a>';
              }
              $shareoptionsAdv .= "</div>";
            }
             $verifiedlabelAdvGrid = '';
          if(isset($this->verifiedLabelActive) && $document->verified == 1) {
            $verifiedlabelAdvGrid = "<i class=\"sesdocument_verified_sign fa fa-check-circle\"></i>";
          }
          if(strlen($document->getTitle()) > $this->advgrid_title_truncation) {
            $advGridViewTitle = mb_substr($document->getTitle(),0,($this->title_truncation-3)).'...';
          }else{
            $advGridViewTitle = $document->getTitle();
          }
          $documentAdvGridTitle =	"<div class=\"sesbasic_item_grid_title\">
													".$this->htmlLink($document->getHref(), $advGridViewTitle,array('class'=>'ses_tooltip','data-src'=>$document->getGuid())).$verifiedlabelAdvGrid."
												</div>";
             
             $location = '';
            ?>
           
            
           
           <?php 
           
           
           // Show Category
        $showCategory = '';
    if(isset($this->categoryActive)){
      if($document->category_id != '' && intval($document->category_id) && !is_null($document->category_id)){
        $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $document->category_id);
        $categoryUrl = $categoryItem->getHref();
        $categoryName = $categoryItem->category_name;
        if($categoryItem){
          $showCategory .= "<div class=\"sesdocument_list_stats\">
            <span class=\"widthfull\">
              <i class=\"fa fa-folder-open sesbasic_text_light\"></i> 
              <span><a href=\"$categoryUrl\">$categoryName</a>";
              $subcategory = Engine_Api::_()->getItem('sesdocument_category',$document->subcat_id);
              if($subcategory && $document->subcat_id != 0){
                $subCategoryUrl = $subcategory->getHref();
                $subCategoryName = $subcategory->category_name;
                $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subCategoryUrl\">$subCategoryName</a>";
              }
              $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$document->subsubcat_id);
              if($subsubcategory && $document->subsubcat_id != 0){
                $subsubCategoryUrl = $subsubcategory->getHref();
                $subsubCategoryName = $subsubcategory->category_name;
                 $showCategory .= "&nbsp;&raquo;&nbsp;<a href=\"$subsubCategoryUrl)\">$subsubCategoryName</a>";
              }
            	$showCategory .= "<span></span></div>";
        }
      }
    }
    				
            $stats = '<div class="sesdocument_list_stats">';
  
            if(isset($this->commentActive)){
            $stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $document->comment_count), $this->locale()->toNumber($document->comment_count)).'"><i class="fa fa-comment sesbasic_text_light"></i>'.$document->comment_count.'</span>';
            }
            if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive)){
            $stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $document->favourite_count), $this->locale()->toNumber($document->favourite_count)).'"><i class="fa fa-heart sesbasic_text_light"></i>'. $document->favourite_count.'</span>';
            }
            if(isset($this->viewActive)){
            $stats .= '<span title="'. $this->translate(array('%s view', '%s views', $document->view_count), $this->locale()->toNumber($document->view_count)).'"><i class="fa fa-eye sesbasic_text_light"></i>'.$document->view_count.'</span>';
            }
            if(isset($this->likeActive)){
             $stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $document->like_count), $this->locale()->toNumber($document->like_count)).'"><i class="fa fa-thumbs-up sesbasic_text_light"></i>'.$document->like_count.'</span> ';
             }
             if(isset($this->ratingActive)){
              if(Engine_Api::_()->getApi('core', 'sesdocument')->allowReviewRating()){
                $stats .= '<span title="'.$this->translate(array('%s rating', '%s ratings', $document->rating), $this->locale()->toNumber($document->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($document->rating,1).'/5'. '</span>';
              }
             }
            
             $stats .= '</div>';
          
            $advGrid .=  $advLabels.
            $shareoptionsAdv.
            $documentAdvGridTitle.'
            
          
          </div>
          <div class="sesbasic_item_grid_info  sesbasic_clearfix">';?>    
            <?php if(isset($this->byActive)){ ?>
              <?php $owner = $document->getOwner(); ?>
              <?php $advGrid .=' <div class="sesdocument_list_stats">
                <span>
                <i class="fa fa-user sesbasic_text_light" title="'.$this->translate('By:').'"></i>
                '.$this->htmlLink($owner->getHref(),$owner->getTitle()).'</span>
              </div>';
             } ?>
            <?php
              $advGrid .= $location.$documentStartEndDate.$showCategory;
              $advGrid .= $stats
              ?>
            
         <?php
         $advGrid .='
          </div>
        </li>';  
			}
      echo $advGrid;
    }
		 ?>
    </div>    
 <?php 
 		$documentData = '';
 		endforeach;
     if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax){  ?>
     <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has created an document yet.'); ?>
        <?php if ($this->can_create):?>
          <?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sesdocument'), "sesdocument_general",true).'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
		<?php } 
    if($this->loadOptionData == 'pagging'){ ?>
 		 <?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sesdocument"),array('identityWidget'=>$randonNumber)); ?>
 <?php } ?>
 <?php if(!$this->is_ajax){ ?>
  </div>
  	<?php if($this->loadOptionData != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  
  <?php } ?>
  <?php } ?>
 <?php if(!$this->is_ajax){ ?>
<script type="text/javascript">
<?php if($this->view_type == 0){ ?>
function dynamicWidth(){
	var objectClass = jqueryObjectOfSes('.sesdocument_cat_document_list_info');
	for(i=0;i<objectClass.length;i++){
			jqueryObjectOfSes(objectClass[i]).find('div').find('.sesdocument_cat_document_list_content').find('.sesdocument_cat_document_list_title').width(jqueryObjectOfSes(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
sesJqueryObject (document).on('click','.sesdocument_slideshow_prev',function(e){
		e.prdocumentDefault();
		var activeClassIndex;
		var elem = sesJqueryObject (this).parent().parent().parent().find('.sesdocument_categories_documents_listing_thumbnails').children();
		var elemLength = elem.length;
		for(i=0;i<elemLength;i++){
			if(elem[i].hasClass('thumbnail_active')){
				 activeClassIndex = i;
				break;	
			}
		}
		if(activeClassIndex == 0){
			var changeIndex = elemLength-1;
		}else if((activeClassIndex+1) == elemLength){
			var changeIndex =activeClassIndex-1 ;	
		}else{
			var changeIndex = activeClassIndex-1; 	
		}
		sesJqueryObject (this).parent().parent().parent().find('.sesdocument_categories_documents_listing_thumbnails').children().eq(changeIndex).find('a').click();
});

sesJqueryObject (document).on('click','.sesdocument_slideshow_next',function(e){
	e.prdocumentDefault();
	var activeClassIndex;
	var elem = sesJqueryObject (this).parent().parent().parent().find('.sesdocument_categories_documents_listing_thumbnails').children();
	var elemLength = elem.length;
	for(i=0;i<elemLength;i++){
		if(elem[i].hasClass('thumbnail_active')){
			 activeClassIndex = i;
			break;	
		}
	}
	if((activeClassIndex+1) == elemLength){
		var changeIndex = 0;	
	}else if(activeClassIndex == 0){
		var changeIndex = activeClassIndex+1;
	}else{
		var changeIndex = activeClassIndex+1; 	
	}
	sesJqueryObject (this).parent().parent().parent().find('.sesdocument_categories_documents_listing_thumbnails').children().eq(changeIndex).find('a').click();
});
sesJqueryObject (document).on('click','.slideshow_document_data',function(e){
	e.prdocumentDefault();
	var document_id = sesJqueryObject (this).attr('data-url');
	if(sesJqueryObject (this).parent().hasClass('thumbnail_active')){
			return false;
	}
	if(!album_id)
		return false;
	 var elIndex = sesJqueryObject (this).parent().index();
	 var totalDiv = sesJqueryObject (this).parent().parent().find('div');
	 for(i=0;i<totalDiv.length;i++){
			 totalDiv[i].removeClass('thumbnail_active');
	 }
	 sesJqueryObject (this).parent().addClass('thumbnail_active');
	 var containerElem = sesJqueryObject (this).parent().parent().parent().find('.sesdocument_categories_documents_conatiner').children();
	 for(i=0;i<containerElem.length;i++){
	 	if(i != (containerElem.length-1))
			containerElem[i].hide();
	 }
	sesJqueryObject (containerElem).get(elIndex).show();
	if(sesJqueryObject (containerElem).get(elIndex).hasClass('nodata')){
	 sesJqueryObject (containerElem).eq(elIndex).html('<div class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
	 new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "sesdocument/category/document-data/document_id/"+document_id,
      'data': {
        format: 'html',
				params:'<?php echo json_encode($this->params); ?>',
				document_id : sesJqueryObject (this).attr('data-url'),
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject (containerElem).eq(elIndex).html(responseHTML);
				sesJqueryObject (containerElem).eq(elIndex).removeClass('nodata');
      }
    }).send();
	}
});
var valueTabData ;
// globally define available tab array
	var availableTabs_<?php echo $randonNumber; ?>;
	var requestTab_<?php echo $randonNumber; ?>;
  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($this->defaultOptions); ?>;
<?php if($this->loadOptionData == 'auto_load'){ ?>
		window.adddocument('load', function() {
		 sesJqueryObject (window).scroll( function() {
		 var containerId = '#scrollHeightDivSes_<?php echo $randonNumber;?>';
			if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
				var hT = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').offset().top,
				hH = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').outerHeight(),
				wH = sesJqueryObject(window).height(),
				wS = sesJqueryObject(this).scrollTop();
				if ((wS + 30) > (hT + hH - wH) && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
					document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
			}
	});
<?php } ?>
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesdocument/name/<?php echo $this->widgetName; ?>",
      'data': {
        format: 'html',
        page: pageNum,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
      },

      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
        document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
			<?php if($this->view_type == 1){ ?>
				<?php }else{ ?>
				dynamicWidth();
				<?php } ?>
      }
    })).send();
    return false;
}
</script>
<?php } ?>
<script type="text/javascript">
var defaultOpenTab ;
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
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
        document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				<?php if($this->view_type == 1){ ?>
				<?php }else{ ?>
				dynamicWidth();
				<?php } ?>
      }
    })).send();
    return false;
  }
</script>
