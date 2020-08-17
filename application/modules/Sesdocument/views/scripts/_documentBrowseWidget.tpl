
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/scripts/core.js');?>
<?php  if(!$this->is_ajax){ ?>
<style>
.displayFN{display:none !important;}
</style>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/style.css'); ?> 
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?> 
<?php }  ?>

  <?php if(!$this->is_ajax){ ?>
   <div class="sesbasic_view_type sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_clearfix clear">
      
    <div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber;?>">
      <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){  ?>
         <a title="List View" class="listicon list_selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" rel="list" href="javascript:showData_<?php echo $randonNumber; ?>('list');"></a>
      <?php } ?>
      <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
         <a title="Grid View" class="gridicon grid_selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" rel="grid" href="javascript:showData_<?php echo $randonNumber; ?>('grid');"></a>
      <?php } ?>   
    </div>
   </div>
  <?php } ?>
  <?php if(!isset($this->bothViewEnable) && !$this->is_ajax){ ?>
    <script type="text/javascript">
        en4.core.runonce.add(function() { 
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber;?>').addClass('displayFN');
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber;?>').parent().parent().css('border', '0px');
        });
    </script>
  <?php } ?>
  <?php if(!$this->is_ajax){?>
    <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber;?>').setStyle('display', 'block');</script>
  <?php } ?>
<?php if($this->show_item_count == 1){ ?>
   <div class="sesbasic_clearfix sesbm sesdocument_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesdocument' : 'paginator_count_ajax_sesdocument' ?>"><span id="total_item_count_sesdocument" style="display:inline-block;"></span> <?php echo $this->translate(array('%s document found.', '%s documents found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?></div>
   <?php } ?>
  
       

  <?php $view = $this->view_type; ?>
  <?php if( count($this->paginator) > 0 ): ?>

    <?php if(!$this->is_ajax){ ?>
      <div class="sesdoc_browse_doc sesbasic_bxs sesbasic_clearfix">
      <div class="sesdoc_browse_doc_inner">
    <?php } ?>
 <!-- GRID  -->    
    
    <?php if($view == 'grid'){?>
    <?php if(!$this->is_ajax){ ?>
     <ul class="sesdoc_view sesdoc_tabbed_grid" id="browse-widget_<?php echo $randonNumber;?>">
    <?php } ?>
      <?php foreach( $this->paginator as $document ):?> 
  
      <li class="sesdoc_grid_item" id ="tabbed_grid_<?php echo $randonNumber;?>">
    <!-- photo -->
      <?php
        $href = $document->getHref(); 
      $photo_id = $document->photo_id;
    if ($photo_id) { 
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, 'sesdocument');
      if($file)
        $imageURL = $file->getPhotoUrl('thumb.profile');      }
      ?>
         <article class="sesbasic_bg">
           <div class="sesdoc_top" style="">            
              <a href="<?php echo $href; ?>">
                 <span style="background-image:url('<?php echo $imageURL;?>');height:<?php echo is_numeric($this->photo_height) ? $this->photo_height.'px' : $this->photo_height ;?>; width:<?php echo is_numeric($this->photo_width) ? $this->photo_width.'px' : $this->photo_width ;?>;"></span>
              </a>
              <div class="sesdoc_icon">
                 <img src="application/modules/Sesdocument/externals/images/pdf.png" />
              </div>
    <!-- labels -->           
              <div class="sesdoc_labels">
                <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)) { ?>
                     <?php  if(isset($this->featuredLabelActive) && $document->featured == 1){ ?>
                            <span class="featured" title="Featured"><i class="fa fa-star"></i></span>
                     <?php } ?>
                     <?php  if(isset($this->sponsoredLabelActive) && $document->sponsored == 1){ ?>
                            <span class="new" title="Sponsored"><i class="fa fa-star"></i></span>
                     <?php } ?>
                     <?php  if(isset($this->verifiedLabelActive) && $document->verified == 1){ ?>
                            <span class="hot" title="Verified"><i class="fa fa-star"></i></span>
                     <?php } ?>
                <?php } ?>
              </div>
    <!-- social_sharing  -->
             <?php 
                $canComment =  $document->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');      
                if(isset($this->likeButtonActive)){ 
                    $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($document->sesdocument_id,$document->getType());
                    $likeClass = ($LikeStatus) ? 'button_active' : '' ;
                }
                if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($document->favourite_count)  ){ 
                    $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$document->sesdocument_id));
                $favClass = ($favStatus)  ? 'button_active' : '';           
                }
             ?>      
             <?php if(isset($this->socialSharingActive)) { ?>
              <div class="social_share">
               <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $document, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_listviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listviewlimit));?>
                 <a href="javascript:;" data-url="<?php echo $document->sesdocument_id;?> " class="sesbasic_icon_btn sesdocument_like_sesdocument_document_<?php echo $document->sesdocument_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document <?php echo $likeClass ;?>" tabindex="-1"> <i class="fa fa-thumbs-up"></i><span><?php echo $document->like_count ;?></span></a>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_<?php echo $document->sesdocument_id ;?> sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document <?php echo $favClass;?>" data-url="<?php echo $document->sesdocument_id ; ?>" tabindex="-1"><i class="fa fa-heart"></i><span><?php echo $document->favourite_count ;?></span></a>
              </div>
             <?php } ?>
    <!-- Stats  -->
             <?php 
                   $view_count = $document->view_count;
                  $favourite_count = $document->favourite_count;
              $like_count = $document->like_count;
              $comment_count = $document->comment_count;
              if((isset($this->commentActive)) ||  (isset($this->likeActive)) || (isset($this->favouriteActive)) || (isset($this->viewActive))) {?>
                 <span class="stats">                    
                    <?php if(isset($this->commentActive)) { ?>
                            <span class="comment"><i class="fa fa-comment"></i> <?php echo $comment_count; ?> </span>
                    <?php }?>
                    <?php if(isset($this->likeActive)) { ?>
                            <span class="like"><i class="fa fa-thumbs-up"></i> <?php echo $like_count; ?> </span>
                    <?php } ?>
                     <?php if(isset($this->viewActive)) { ?>
                      <span  title="<?php echo $hoverViews ;?>" class="comment"><i class="fa fa-eye"></i> <?php echo  $view_count; ?> </span>
                    <?php }?>
                    <?php if(isset($this->favouriteActive)) { ?>
                      <span title="<?php echo $hoverFavourites ;?>" class="comment"><i class="fa fa-heart"></i> <?php echo $favourite_count; ?> </span>
                    <?php }?>
                 </span>                   
             <?php }?>
             <?php if(isset($this->creationDateActive)) echo "Created On : ".$document->creation_date ; ?>       
           </div>     
    <!-- title  -->  
           <div class="sesdoc_bottom">
             <div class="title"> 
                <?php if(strlen($document->getTitle()) > $this->params['grid_title_truncation']){ 
                  $title = mb_substr($document->getTitle(),0,($this->params['grid_title_truncation']  )).'...';
                  echo $this->htmlLink($document->getHref(),$this->translate($title)) ?>
                <?php }else{ ?>
                  <?php 
                  echo $this->htmlLink($document->getHref(),$this->translate($document->getTitle()) )?>
                <?php } ?>
              
             </div>
              <div class="title"> 
                <?php $showCtegory ='';  
                  if(isset($this->categoryActive)){ 
                    if($document->category_id != '' && intval($document->category_id) && !is_null($document->category_id)){
                       $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $document->category_id);
                    if($categoryItem){
                    $categoryUrl = $categoryItem->getHref();
                    $categoryName = $this->translate($categoryItem->category_name);
                    if($categoryItem){ ?>
                    <div class="sesdocument_list_stats">
                    <span class="widthfull">
                    <i class="fa fa-folder-open sesbasic_text_light"></i> 
                    <span><a href="<?php echo $categoryUrl;?>"><?php echo $categoryName ; ?></a>                    
                    </span></span></div>
                   <?php }
                    }
                    }
                } 
              ?>
            </div>
    <!-- owner  -->
             <div class="sesdoc_user_stats">
              <?php if(isset($this->byActive)) { ?>
                 <span class="owner"><a href="#"> <?php if (isset($this->profileActive)) echo $this->itemPhoto($document->getOwner()); ?> <?php echo $this->htmlLink($document->getOwner()->getHref(), $document->getOwner()->getTitle(), array('class' => 'thumbs_author')) ;?></a></span>
              <?php } ?>
    <!-- rating  -->
            <?php if($this->ratings == 1){  ?>
              <?php if(isset($this->ratingActive)){?>                   
                 <p class="sesbasic_rating_star">
                  <?php if(isset($this->ratingActive)){ ?>
                             <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $document->rating), $this->locale()->toNumber($document->rating));?>"><i class="fa fa-star sesbasic_text_light"></i><?php echo round($document->rating,1).'/5' ; ?></span>
                         <?php } ?>
                 </p>
              <?php  } ?> 
            <?php }?>  
             </div>
           </div>
         </article>
      </li>
    
 <?php endforeach; ?>
 <?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesdocument"),array('identityWidget'=>$randonNumber)); ?>
  <?php } ?>   
    <?php if(!$this->is_ajax){ ?>
     </ul> 
         <?php }?>
    <?php }?>

<!-- LIST  -->

 <?php if($view == 'list'){ ?>
  <?php if(!$this->is_ajax){ ?>
    <ul class="sesdoc_view sesdoc_list_view  sesdoc_tabbed_list" id="browse-widget_<?php echo $randonNumber;?>">
  <?php } ?>
        <?php foreach( $this->paginator as $document ):?>
       
        
         <li class="sesdoc_list_item"  id = "tabbed_list_<?php echo $randonNumber;?>" >
          <?php 
            $canComment =  $document->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');      
            if(isset($this->likeButtonActive)){ 
              $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($document->sesdocument_id,$document->getType());
              $likeClass = ($LikeStatus) ? 'button_active' : '' ;
            }
            if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.allowfavourite', 1) && isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($document->favourite_count)  ){ 
              $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$document->sesdocument_id));
              $favClass = ($favStatus)  ? 'button_active' : '';           
            }
         ?>        
             <?php
              $href = $document->getHref(); 
            $photo_id = $document->photo_id; 
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($document->photo_id, 'sesdocument');
      if($file)
        $imageURL = $file->getPhotoUrl('thumb.profile');     }
           ?> 
    <!-- photo  -->
           <article class="sesbasic_bg">
             <div class="sesdoc_top" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ;?>; width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ;?>;">
              <a href="#">
                 <span style="background-image:url(<?php echo $imageURL;?>);"></span>
              </a>
    <!-- icon  -->
              <?php if(isset($this->docTypeActive)){?>
                      <div class="sesdoc_icon">
                        <?php  
                          $file =  $document->file_id;$type = NULL;
                          $documenttype = Engine_Api::_()->getItemTable('storage_file')->getFile($file, $type);
                          $type = $documenttype->extension;
                          if($type == "png" || $type == "jpeg" || $type == "gif" || $type == "jpg"){?>
                            <img src="application/modules/Sesdocument/externals/images/picture.png" />
                          <?php }else if($type == "pdf"){?>
                            <img src="application/modules/Sesdocument/externals/images/pdf.png" />
                          <?php } else if($type == "pptx"){?>
                            <img src="application/modules/Sesdocument/externals/images/ppt.png" />
                          <?php } else if($type == "mkv" || $type == "flv" || $type == "mp4" || $type == "mpg" || $type == "mpeg" || $type == "3gp"){?>
                            <img src="application/modules/Sesdocument/externals/images/video-player.png" />
                          <?php } else {?>
                            <img src="application/modules/Sesdocument/externals/images/file.png" />
                          <?php }?>
                      </div>
              <?php }?>
    <!-- labels  -->
              <div class="sesdoc_labels">
                <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)) { ?>
                  <?php  if(isset($this->featuredLabelActive) && $document->featured == 1){ ?>
                            <span class="featured" title="Featured"><i class="fa fa-star"></i></span>
                     <?php } ?>
                     <?php  if(isset($this->sponsoredLabelActive) && $document->sponsored == 1){ ?>
                            <span class="new" title="Sponsored"><i class="fa fa-star"></i></span>
                     <?php } ?>
                     <?php  if(isset($this->verifiedLabelActive) && $document->verified == 1){ ?>
                            <span class="hot" title="Verified"><i class="fa fa-star"></i></span>
                     <?php } ?>
                <?php } ?>
              </div>
    <!-- social_sharing -->
             <?php if(isset($this->socialSharingActive)) { ?>
              <div class="social_share">
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $document, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_listviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listviewlimit));?>
                <a href="javascript:;" data-url="<?php echo $document->sesdocument_id;?> " class="sesbasic_icon_btn sesdocument_like_sesdocument_document_<?php echo $document->sesdocument_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesdocument_like_sesdocument_document <?php echo $likeClass ;?>" tabindex="-1"> <i class="fa fa-thumbs-up"></i><span><?php echo $document->like_count ;?></span></a>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesdocument_favourite_sesdocument_document_<?php echo $document->sesdocument_id ;?> sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document <?php echo $favClass;?>" data-url="<?php echo $document->sesdocument_id ; ?>" tabindex="-1"><i class="fa fa-heart"></i><span><?php echo $document->favourite_count ;?></span></a>
              </div>
             <?php }?>
           </div>
           <div class="sesdoc_bottom">
    <!-- title -->
             <div class="title">
              <?php
              if(strlen($document->getTitle()) > $this->params['list_title_truncation']){ 
                  $title = mb_substr($document->getTitle(),0,($this->params['list_title_truncation']  )).'...';
                  echo $this->htmlLink($document->getHref(),$this->translate($title)) ?>
                <?php }else{ ?>
                  <?php 
                  echo $this->htmlLink($document->getHref(),$this->translate($document->getTitle()) )?>
                <?php } ?>
             
    <!-- rating -->
            <?php if($this->ratings == 1){  ?>
              <?php if(isset($this->ratingActive)){?>
                <p class="sesbasic_rating_star">
                    <?php if(isset($this->ratingActive)){
                          ?>
                             <span title="<?php echo $this->translate(array('%s rating', '%s ratings', $document->rating), $this->locale()->toNumber($document->rating));?>"><i class="fa fa-star sesbasic_text_light"></i><?php echo round($document->rating,1).'/5' ; ?></span>
                    <?php   } ?>
                </p>
              <?php  } ?>
            <?php }?>
             </div>
    <!-- owner -->
             <div class="sesdoc_user_stats">

                <?php if(isset($this->byActive)) { ?>
                  <span class="owner"><?php if (isset($this->profileActive)) echo $this->itemPhoto($document->getOwner()); ?> <?php echo $this->htmlLink($document->getOwner()->getHref(), $document->getOwner()->getTitle(), array('class' => 'thumbs_author')) ;?></span>              
                <?php } ?>
    <!-- categories -->            
                <?php $showCtegory ='';
                  if(isset($this->categoryActive)){ 
                    if($document->category_id != '' && intval($document->category_id) && !is_null($document->category_id)){
                       $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $document->category_id);
                    if($categoryItem){ 
                    $categoryUrl = $categoryItem->getHref();
                    $categoryName = $this->translate($categoryItem->category_name);
                    if($categoryItem){ ?>                  
                       <a href="<?php echo $categoryUrl;?>"><?php echo $categoryName ; ?></a>                    
                   <?php }
                    }
                    }
                } 
              ?>                       
    <!-- stats -->
                <?php 
                  $view_count = $document->view_count;
                  $favourite_count = $document->favourite_count;
                  $like_count = $document->like_count;
                  $comment_count = $document->comment_count;
                  $hoverComments = $this->translate(array('%s comment', '%s comments', $comment_count), $this->locale()->toNumber($comment_count));
                  $hoverLikes = $this->translate(array('%s like', '%s likes', $like_count), $this->locale()->toNumber($like_count));
                  $hoverFavourites = $this->translate(array('%s favourite', '%s favourites', $favourite_count), $this->locale()->toNumber($favourite_count));  
                  $hoverViews = $this->translate(array('%s view', '%s views', $view_count), $this->locale()->toNumber($view_count));

                  if((isset($this->commentActive)) ||  (isset($this->likeActive)) || (isset($this->favouriteActive)) || (isset($this->viewActive))) {?>
                    <span class="stats">                    
                    <?php if(isset($this->commentActive)) { ?>
                      <span title="<?php echo $hoverComments ;?>" class="comment"><i class="fa fa-comment"></i> <?php echo $comment_count; ?> </span>
                    <?php }?>
                    <?php if(isset($this->viewActive)) { ?>
                      <span  title="<?php echo $hoverViews ;?>" class="comment"><i class="fa fa-eye"></i> <?php echo  $view_count; ?> </span>
                    <?php }?>
                    <?php if(isset($this->favouriteActive)) { ?>
                      <span title="<?php echo $hoverFavourites ;?>" class="comment"><i class="fa fa-heart"></i> <?php echo $favourite_count; ?> </span>
                    <?php }?>
                    <?php if(isset($this->likeActive)) { ?>
                      <span title="<?php echo $hoverLikes ;?>" class="like"><i class="fa fa-thumbs-up"></i> <?php echo $like_count; ?> </span>
                    <?php } ?>
                    </span>                   
                <?php }?>   
                <?php if(isset($this->creationDateActive)) echo "Created On : ".$document->creation_date ; ?>         
             </div>
    <!-- description -->
             <div class="desc">
              <?php 
                if(isset($this->listdescriptionActive)){                  
                if(strlen($document->description) > $this->list_description_truncation) {
                        $listViewdescription = mb_substr($document->description,0,($this->list_description_truncation)).'...';
                      }else{
                        $listViewdescription = $document->description;
                      }      
                      echo  $listViewdescription;
                }
              ?>
              
             </div>
           </div>
           </article>
         </li>  
     
<?php endforeach; ?>


  <?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesdocument"),array('identityWidget'=>$randonNumber)); ?>
  <?php } ?>   
<?php if(!$this->is_ajax){ ?>
    </ul>
  
    <?php }?> 
 <?php }?>    
</div>
     <!-- LIST VIEW ENDS -->
  </div>

<script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'block');</script>
<?php elseif( preg_match("/category_id=/", $_SERVER['REQUEST_URI'] )): ?>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'none');</script>
  <div id="browse-widget_<?php echo $randonNumber;?>" class=" sesdocument_document_all_documents sesdocument_browse_listing_<?php echo $randonNumber;?>">
     <div id="error-message_<?php echo $randonNumber;?>">
  <div class="sesbasic_tip clearfix">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument_document_no_photo', 'application/modules/Sesdocument/externals/images/document-icon.png'); ?>" alt="" />
    <span class="sesbasic_text_light">
      <?php echo $this->translate('Nobody has created an document with that criteria.');?>
      <?php if( $this->canCreate ): ?>
  <?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action'=>'create'), 'sesdocument_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>   
  </div>
  </div>
 <?php else: ?>
<div id="browse-widget_<?php echo $randonNumber;?>" class=" sesdocument_document_all_documents sesdocument_browse_listing sesdocument_browse_listing_<?php echo $randonNumber;?>">
  <div id="error-message_<?php echo $randonNumber;?>">
  <div class="sesbasic_tip clearfix">
    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument_document_no_photo', 'application/modules/Sesdocument/externals/images/document-icon.png'); ?>" alt="" />
    <span class="sesbasic_text_light">
    <?php if( $this->filter != "past" ): ?>
      <?php echo $this->translate('Nobody has created an document yet.') ?>
      <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action'=>'create'), 'sesdocument_general').'">', '</a>'); ?>
      <?php endif; ?>
    <?php else: ?>
      <?php echo $this->translate('There are no past documents yet.') ?>
    <?php endif; ?>
    </span>
  </div>
</div>
</div>
  <script type="text/javascript">$$('.sesbasic_view_type_<?php echo $randonNumber ?>').setStyle('display', 'none');</script>
<?php endif; ?>
<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')):?>
  <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
<?php endif;?>
<?php if (empty($this->is_ajax)) : ?>
  <div id="temporary-data-<?php echo $randonNumber?>" style="display:none"></div>
<?php endif;?>
<script type="text/javascript">
  <?php if(!$this->is_ajax):?>
 
  <?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
        var containerId = '#browse-widget_<?php echo $randonNumber;?>';
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
    });
  <?php } ?>
  <?php endif; ?>
  <?php if(!$this->is_ajax):?>
  var loadMap_<?php echo $randonNumber;?> = false;
  var activeType_<?php echo $randonNumber ?>;
  function showData_<?php echo $randonNumber; ?>(type) {
    activeType_<?php echo $randonNumber ?> = '';
    if(type == 'grid') {       
     
      sesJqueryObject('#grid_work').show();
       sesJqueryObject('#list_work').hide();
      sesJqueryObject('.list_selectView_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('.grid_selectView_<?php echo $randonNumber; ?>').addClass('active');
      activeType_<?php echo $randonNumber ?> = 'grid';      
    }else if(type == 'list') {       
      
      sesJqueryObject('#list_work').show();
       sesJqueryObject('#grid_work').hide();
      sesJqueryObject('.list_selectView_<?php echo $randonNumber; ?>').addClass('active');
      sesJqueryObject('.grid_selectView_<?php echo $randonNumber; ?>').removeClass('active');
      activeType_<?php echo $randonNumber ?> = 'list';    
    }
  } 
  <?php endif;?> 
  var searchParams<?php echo $randonNumber; ?> ;
  var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  <?php if(!$this->is_ajax):?>
    var isSearch = false;
    var oldMapData_<?php echo $randonNumber; ?> = [];
  <?php endif;?>

   <?php if($this->loadOptionData != 'pagging') { ?>
      en4.core.runonce.add(function() {
    viewMoreHide_<?php echo $randonNumber; ?>();
    });
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
  $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> () {
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      
      if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
              requestViewMore_<?php echo $randonNumber; ?>.cancel();
          }
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/sesdocument/name/<?php echo $this->widgetName; ?>",
          'data': {
            format: 'html',
            page: page<?php echo $randonNumber; ?>,    
            params : params<?php echo $randonNumber; ?>, 
            is_ajax : 1,

            searchParams:searchParams<?php echo $randonNumber; ?> ,
            identity : '<?php echo $randonNumber; ?>',
            height:'<?php echo $this->masonry_height;?>',
            type:activeType_<?php echo $randonNumber ?>,
            identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
          },
              onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('#temporary-data-<?php echo $randonNumber?>').html(responseHTML);
              if(sesJqueryObject('#error-message_<?php echo $randonNumber;?>').length > 0) {
                  var optionEnable = sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel');
                  var optionEnableList = sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?> > a');
                  
                  for(i=0;i<optionEnableList.length;i++)
                    sesJqueryObject('#sesdocument_'+optionEnable+'_view_<?php echo $randonNumber; ?>').hide();
                  sesJqueryObject('#tabbed-widget_<?php echo $randonNumber;?>').append('<div id="error-message_<?php echo $randonNumber;?>">'+sesJqueryObject('#error-message_<?php echo $randonNumber;?>').html()+'</div>')
                }
                  if(!isSearch){     
                   if($('loadingimgsesdocument-wrapper'))
                    sesJqueryObject('#loadingimgsesdocument-wrapper').hide();        
                  if(document.getElementById('browse-widget_<?php echo $randonNumber;?>'))
                    document.getElementById('browse-widget_<?php echo $randonNumber;?>').innerHTML =document.getElementById('browse-widget_<?php echo $randonNumber;?>').innerHTML+ responseHTML;
                   }           
                                                                               
                if(document.getElementById('temporary-data-<?php echo $randonNumber?>'))
                  document.getElementById('temporary-data-<?php echo $randonNumber?>').innerHTML = '';
                sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
               
                viewMoreHide_<?php echo $randonNumber; ?>();
              }
        });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
    <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','block');
     
          if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
              requestViewMore_<?php echo $randonNumber; ?>.cancel();
          }
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/sesdocument/name/<?php echo $this->widgetName; ?>",
          'data': {
          format: 'html',
          page: pageNum,
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          identity : <?php echo $randonNumber; ?>,
          type:sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel'),
          height:'<?php echo $this->masonry_height;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
          },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {         
          sesJqueryObject('#temporary-data-<?php echo $randonNumber?>').html(responseHTML);
          if(!isSearch){
                  if($('loadingimgsesdocument-wrapper'))
                    sesJqueryObject('#loadingimgsesdocument-wrapper').hide();
                  if(document.getElementById('browse-widget_<?php echo $randonNumber;?>'))
                    document.getElementById('browse-widget_<?php echo $randonNumber;?>').innerHTML = responseHTML;
                   }
               
           
          sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'none');
          sesJqueryObject('#loadingimgsesdocument-wrapper').hide();
          }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>  
</script>
  <?php if(!$this->is_ajax):?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>

  <?php endif;?>
