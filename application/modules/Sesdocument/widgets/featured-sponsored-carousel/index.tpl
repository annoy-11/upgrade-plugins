
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js')
->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/PeriodicalExecuter.js')
->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/Carousel.js')
->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/Carousel.Extra.js'); 

$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/carousel.css');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/style.css');
?>
<style>
  #documentslide_<?php echo $this->identity; ?> {
    position: relative;
    height:<?php echo $this->height ?>px;
    overflow: hidden;
  }
	#documentslide_<?php echo $this->identity; ?> .sesdocument_grid_out{
		height:<?php echo $this->height ?>px;
	} 
</style>

<div class="sesdocument_featured_carousel slide sesbasic_carousel_wrapper sesbm clearfix sesbasic_bxs <?php if($this->viewType == 'horizontal'): ?>sesbasic_carousel_h_wrapper<?php else: ?>sesbasic_carousel_v_wrapper <?php endif; ?>">
  <div id="documentslide_<?php echo $this->identity; ?>">
    <?php foreach( $this->paginator as $item):  ?>
    <div class="sesdocument_grid_<?php echo $this->gridInsideOutside ; ?> sesbasic_clearfix sesbasic_bxs sesdocument_grid_btns_wrap sesae-i-<?php echo $this->mouseOver; ?>" style="width:<?php echo $this->width ?>px;">
      <div class="sesdocument_list_thumb" style="height:<?php echo $this->imageheight ?>px;">
        <?php //echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.normal')) ?>
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl('thumb.profile');
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
            <?php if(isset($this->socialSharingActive)){ ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

            <?php } 
            $itemtype = 'sesdocument';
            $getId = 'sesdocument_id';
            $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
            if(isset($this->likeButtonActive) && $canComment){
            ?>
            <!--Like Button-->
            <?php $LikeStatus = Engine_Api::_()->sesdocument()->getLikeStatusDocument($item->$getId, $item->getType()); ?>
            <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
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
              <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                $title = mb_substr($item->getTitle(),0,($this->title_truncation - 3)).'...';
                echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid()) ) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid()) ) ?>
              <?php } ?>
            </div>
          <?php } ?>
          
          <?php if(isset($this->byActive)){ ?>    
          	<?php $owner = $item->getOwner(); ?>
            <div class="sesdocument_list_stats">
            	<span class="sesbasic_text_light">
               
              	 <i class="fa fa-user"></i>
              	<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
              </span>
            </div>
         	<?php } ?>                   
          <?php if(isset($this->categoryActive)){ ?>
            <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)){ 
            $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $item->category_id);
            ?>
              <div class="sesdocument_list_stats">
              	<span class="sesbasic_text_light">
                  <i class="fa fa-folder-open"></i><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                  <?php $subcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subcat_id); ?>
                  <?php if($subcategory && $item->subcat_id){ ?>
                  &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                  <?php } ?>
                  <?php $subsubcategory = Engine_Api::_()->getItem('sesdocument_category',$item->subsubcat_id); ?>
                  <?php if($subsubcategory && $item->subsubcat_id){ ?>
                  &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                  <?php } ?>
                </span>
              </div>
            <?php } ?>
          <?php } 
         
          ?>
          <?php if(isset($this->creationDateActive) ) { ?>
          <div class="sesdocument_list_stats sesbasic_text_light ">
            <span title="Creation Date"><i class="fa fa-calendar"></i><?php echo $item->creation_date;?></span>
           </div>
            <?php } ?>
          <div class="sesdocument_list_stats">
            <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <span  class="sesbasic_text_light" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
            <?php } ?>
						<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
            <span  class="sesbasic_text_light" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)); ?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
            <?php } ?>
            <?php if(isset($this->commentActive) ) { ?>
            <span  class="sesbasic_text_light" title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
            <?php } ?>
            <?php if(isset($this->viewActive) ) { ?>
            <span  class="sesbasic_text_light" title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count;?></span>
            <?php } ?>
          </div>
        </div>
    	</div>
    <?php endforeach; ?>
  </div>
  <?php if($this->viewType == 'horizontal'): ?>
    <div class="tabs_<?php echo $this->identity; ?> sesbasic_carousel_nav">
      <a class="sesbasic_carousel_nav_pre" href="#page-p"><i class="fa fa-caret-left"></i></a>
      <a class="sesbasic_carousel_nav_nxt" href="#page-p"><i class="fa fa-caret-right"></i></a>
    </div>  
    <?php else: ?>
    <div class="tabs_<?php echo $this->identity; ?> sesbasic_carousel_nav">
      <a class="sesbasic_carousel_nav_pre" href="#page-p"><i class="fa fa-caret-up"></i></a>
      <a class="sesbasic_carousel_nav_nxt" href="#page-p"><i class="fa fa-caret-down"></i></a>
    </div>  
  <?php endif; ?>

</div>
<script type="text/javascript">
  window.addEvent('domready', function () {
    var duration = 150,
    div = document.getElement('div.tabs_<?php echo $this->identity; ?>');
    links = div.getElements('a'),
    carousel = new Carousel.Extra({
      activeClass: 'selected',
      container: 'documentslide_<?php echo $this->identity; ?>',
      circular: true,
      current: 1,
      previous: links.shift(),
      next: links.pop(),
      tabs: links,
      mode: '<?php echo $this->viewType; ?>',
      fx: {
        duration: duration
      }
    })
  });
</script>

