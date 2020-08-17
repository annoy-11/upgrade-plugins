
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); 
?>
<?php $count = 0;?>
<?php  foreach( $this->results as $item ): ?>
<?php $count= $count + 1;?>

<?php if(isset($this->getitem)){ 
	$item = Engine_Api::_()->getItem('sesdocument', $item['sesdocument_id']);
 } ?>
<?php if($this->view_type == 'list'){ ?>
  <li class="sesdocument_sidebar_list sesbasic_sidebar_list sesbasic_clearfix">
    
       <?php echo $this->htmlLink($item, $this->itemPhoto($item, 'thumb.icon')); ?>
   
    <div class="sesdocument_sidebar_list_info sesbasic_sidebar_list_info" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ;?>;">
      <?php  if(isset($this->titleActive)){ ?>
        <div class="sesdocument_sidebar_list_title sesbasic_sidebar_list_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_list){
          $title = mb_substr($item->getTitle(),0,($this->title_truncation_list)).'...';
          echo $this->htmlLink($item->getHref(),$title, array( 'data-src' => $item->getGuid()));
          } else { ?>
          <?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array( 'data-src' => $item->getGuid())) ?>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if(isset($this->byActive)){ ?>
        <div class="sesdocument_list_stats">
          <?php $owner = $item->getOwner(); ?>
            <span>
             <i class="fa fa-user sesbasic_text_light" title="<?php echo $this->translate('By'); ?>"></i>  
             <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
        </div>
      <?php } ?>
      
       <?php if(isset($this->categoryActive)){ ?>
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)){ 
          $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);
        ?>
        <div class="sesdocument_list_stats">
          <span class="widthfull">
            <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i><span>
              <a href="<?php echo $categoryItem->getHref(); ?>">
                <?php echo $categoryItem->category_name; ?></a>
              <?php $subcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subcat_id); ?>
              <?php if($subcategory && $item->subcat_id){ ?>
              &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subsubcat_id); ?>
              <?php if($subsubcategory && $item->subsubcat_id){ ?>
              &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        </div>
        <?php } ?>
      <?php } ?>
      <div class="sesdocument_sidebar_stats sesbasic_text_light">
        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
        <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
        <?php } ?>
        <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
        <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
        <?php } ?>
       
        <?php if(isset($this->favouriteActive) ) { ?>
        <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
        <?php } ?>
     
        <?php
        //if($this->ratings == 1){ 
          if(isset( $this->ratingActive)){
  				echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($item->rating,1).'/5'. '</span>';
      		}
        //}
          if(isset( $this->viewActive)){
            echo '<span title="'.$this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)).'"><i class="fa fa-eye sesbasic_text_light"></i>'. $item->view_count. '</span>';
        }
        ?>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
      <div class="sesdocument_list_labels">
        <?php if($item->featured && isset($this->featuredLabelActive)){ ?>
        <p class="sesdocument_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->sponsored && isset($this->sponsoredLabelActive) ){ ?>
       <p class="sesdocument_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->verified && isset($this->verifiedLabelActive) ){ ?>
        <p class="sesdocument_label_verified" title="Verified"><i class="fa fa-star"></i></p>
      <?php } ?>
      </div>
      <?php } ?>
      </div>
    </div>
  </li>
<?php }else if($this->view_type == 'gridInside'){ ?>
  <li class="sesdocument_grid_<?php echo $this->gridInsideOutside ; ?> sesbasic_clearfix sesbasic_bxs sesdocument_grid_btns_wrap sesae-i-<?php echo $this->mouseOver; ?>" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
    <div class="sesdocument_list_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ;?>;">
      <?php
      $href = $item->getHref();
      $photo_id = $item->photo_id; 
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($item->photo_id, 'sesdocument');
      if($file)
        $imageURL = $file->getPhotoUrl('thumb.profile');     }
      ?>
      <a href="<?php echo $href; ?>" class="sesdocument_list_thumb_img">
        <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
      </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
      <div class="sesdocument_list_labels">
        <?php if($item->featured && isset($this->featuredLabelActive)){ ?>
        <p class="sesdocument_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->sponsored && isset($this->sponsoredLabelActive) ){ ?>
       <p class="sesdocument_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->verified && isset($this->verifiedLabelActive) ){ ?>
        <p class="sesdocument_label_verified" title="Verified"><i class="fa fa-star"></i></p>
      <?php } ?>
      </div>
      <?php } ?>
       <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) ) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
          <div class="sesdocument_grid_btns"> 
            <?php if(isset($this->socialSharingActive)){  ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

            <?php } 
            $itemtype = 'sesdocument';
            $getId = 'sesdocument_id';
            $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
            if(isset($this->likeButtonActive) && $canComment){
             
            ?>
            <!--Like Button-->
            <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($item->$getId, $item->getType()); ?>
            <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesdocument_like_sesdocument_document_<?php echo $item->sesdocument_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
            <?php } 
            if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($item->favourite_count)  ){ 
              $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$item->sesdocument_id));
              $favClass = ($favStatus)  ? 'button_active' : '';
            echo "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_". $item->sesdocument_id." sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document ".$favClass ."' data-url=\"$item->sesdocument_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
            } 
        ?>
          </div>
          <?php } ?>
    </div>
   
    <div class="sesdocument_list_info sesbasic_clearfix">
      <?php if(isset($this->titleActive) ){ ?>
      <div class="sesdocument_list_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
        $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid )).'...';
        echo $this->htmlLink($item->getHref(),$title, array( 'data-src' => $item->getGuid())) ?>
        <?php }else{ ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array( 'data-src' => $item->getGuid())) ?>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if(isset($this->byActive)){ ?>
        <div class="sesdocument_list_stats">
          <?php $owner = $item->getOwner(); ?>
            <span> 
                <i class="fa fa-user sesbasic_text_light" title="<?php echo $this->translate('Created By:'); ?>"></i><?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
        </div>
      <?php } ?>
      <?php $showCtegory ='';  
                  if(isset($this->categoryActive)){ 
                    if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)){
                       $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);
                    if($categoryItem){
                    $categoryUrl = $categoryItem->getHref();
                    $categoryName = $this->translate($categoryItem->category_name);
                    if($categoryItem){ ?>
                    <div class="sesdocument_list_stats">
                    <span class="widthfull">
                    <i class="fa fa-folder-open sesbasic_text_light"></i><span><a href="<?php echo $categoryUrl;?>"><?php echo $categoryName ; ?></a>                    
                    </span></span></div>
                   <?php }
                    }
                    }
                } 
              ?>
       <div class="sesdocument_sidebar_stats">
        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
        <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
        <?php } ?>
        <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
        <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
        <?php } ?>
       
        <?php if(isset($this->favouriteActive) ) { ?>
        <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
        <?php } ?>
        <?php
        //if($this->ratings == 1){ 
          if(isset( $this->ratingActive)){ 
          echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($item->rating,1).'/5'. '</span>';
          }
        //}
        if(isset( $this->viewActive)){
            echo '<span title="'.$this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)).'"><i class="fa fa-eye sesbasic_text_light"></i>'. $item->view_count. '</span>';
        }
        ?>
      </div>
    </div>
  </li>
<?php }else{ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
  <li class="sesbasic_item_grid sesbasic_clearfix sesbasic_bxs sesbasic_item_grid_btns_wrap sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
    <div class="sesbasic_item_grid_thumb floatL">
      <?php
      $href = $item->getHref();
      $imageURL = $item->getPhotoUrl('thumb.profile');
      ?>
      <a href="<?php echo $href; ?>" class="sesbasic_item_grid_thumb_img floatL">
        <span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
        <div class="sesbasic_item_grid_thumb_overlay"></div>
      </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
      <div class="sesdocument_list_labels">
        <?php if($item->featured && isset($this->featuredLabelActive)){ ?>
        <p class="sesdocument_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->sponsored && isset($this->sponsoredLabelActive) ){ ?>
       <p class="sesdocument_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
        <?php } ?>
        <?php if($item->verified && isset($this->verifiedLabelActive) ){ ?>
        <p class="sesdocument_label_verified" title="Verified"><i class="fa fa-star"></i></p>
      <?php } ?>
      </div>
      <?php } ?>
      <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)) {
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        <div class="sesbasic_item_grid_btns"> 
          <?php if(isset($this->socialSharingActive)){ ?>
          
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php } 
          $itemtype = 'sesdocument';
          $getId = 'sesdocument_id';
    
          $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');
          if(isset($this->likeButtonActive) && $canComment){
          ?>
          <!--Like Button-->
          <?php $LikeStatus = Engine_Api::_()->sesdocument()->getLikeStatusDocument($item->$getId, $item->getType()); ?>
          <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
          <?php } ?>
          <?php
						if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id) {
							$favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$item->sesdocument_id));
							$favClass = ($favStatus)  ? 'button_active' : '';
							$shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_". $item->sesdocument_id." sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document ".$favClass ."' data-url=\"$item->sesdocument_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
							echo $shareOptions;
						}
          ?>
					
        </div>
      <?php } ?>
      
      <?php if(isset($this->titleActive) ){ ?>
        <div class="sesbasic_item_grid_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
          $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid )).'...';
          echo $this->htmlLink($item->getHref(),$title, array( 'data-src' => $item->getGuid()) ) ?>
          <?php }else{ ?>
          <?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array( 'data-src' => $item->getGuid())) ?>
          <?php } ?>
          <?php if(isset($this->verifiedLabelActive) && $item->verified == 1){ ?>
          <i class="sesdocument_verified_sign fa fa-check-circle"></i>
          <?php } ?>
        </div>
      <?php } ?>
      
     
    </div>
    <div class="sesbasic_item_grid_info  sesbasic_clearfix">
      <?php if(isset($this->byActive)){ ?>
        <div class="sesdocument_list_stats">
          <?php $owner = $item->getOwner(); ?>
            <span>
              <i class="fa fa-user sesbasic_text_light" title="<?php echo $this->translate('Created By:'); ?>"></i>  
              <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
        </div>
      <?php } ?>
      
       
      <?php if(isset($this->categoryActive)){ ?>
      <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)){ 
        $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);
      ?>
      <div class="sesdocument_list_stats">
        <span class="widthfull">
          <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i><span>
            <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
            <?php $subcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subcat_id); ?>
            <?php if($subcategory && $item->subcat_id) { ?>
            &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
            <?php } ?>
            <?php $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subsubcat_id); ?>
            <?php if($subsubcategory && $item->subsubcat_id) { ?>
            &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
            <?php } ?>
          </span>
        </span>
      </div>
      <?php } ?>
      <?php } ?>
      <div class="sesdocument_list_stats">
        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
        <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
        <?php } ?>
        <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
        <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
        <?php } ?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
        <?php } ?>
         <?php if(isset( $this->viewActive)) { ?>
          <?php echo '<span title="'.$this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)).'"><i class="fa fa-eye sesbasic_text_light"></i>'. $item->view_count. '</span>'; ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>
<?php  if($this->show_item_count == 1 && 0){ ?>
   <div class="sesbasic_clearfix sesbm sesdocument_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesdocument' : 'paginator_count_ajax_sesdocument' ?>"><span id="total_item_count_sesdocument" style="display:inline-block;"></span> <?php echo $count; ?></div>
<?php } ?>
<?php endforeach; ?>
