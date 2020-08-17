<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: all-results.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php if(!$this->loading_data){ ?>
<div class="layout_middle">
 <div class="generic_layout_container">
   <?php } ?>
<?php $randonNumber = !empty($this->randonNumber) ? $this->randonNumber : time().md5(time()); ?>
<?php if( empty($this->paginator) ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
    </span>
  </div>
<?php elseif( $this->paginator->getTotalItemCount() <= 0 ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
    </span>
  </div>
<?php else: ?>
<?php if(!$this->loading_data){ ?>
  <?php echo $this->translate(array('<b>%s result found</b>', '<b>%s results found</b>', $this->paginator->getTotalItemCount()),
         $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
<?php } ?>
   <?php if(!$this->loading_data){ ?>
<div class="advancedsearch_result_main sesbasic_bxs sebasic_clearfix" style="position: relative;">
<?php } ?>
  <?php foreach( $this->paginator as $item ):
      $item = $this->item($item->type, $item->id);
      if( !$item ) continue;
    ?>
    <div class="advancedsearch_result all_results">
      <div class="advancedsearch_item_top">
        <?php if(in_array('photo',$this->searchParams)){ ?>
          <div class="advancedsearch_photo">
            <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.main')) ?>
          </div>
        <?php } ?>
        <div class="advancedsearch_labels">
      <?php if(in_array('sponsored',$this->searchParams) && !empty($item->featured)){ ?>
       <div class="advancedsearch_featured" title="Featured">
          <i class="fa fa-star"></i>
       </div>
      <?php  } ?>

      <?php if(in_array('featured',$this->searchParams)  && !empty($item->sponsored)){ ?>
       <div class="advancedsearch_sponsored" title="Sponsored">
          <i class="fa fa-star"></i>
        </div>
      <?php  } ?>

      <?php if(in_array('hot',$this->searchParams)  && !empty($item->hot)){ ?>
        <div class="advancedsearch_hot" title="Hot">
          <i class="fa fa-star"></i>
        </div>
      <?php  } ?>
     </div>
    <div class="advancedsearch_overlay">
       <?php if(in_array('contentType',$this->searchParams)){ ?>
      <div class="advancedsearch_type">
        <?php $type = ucfirst($item->getShortType()); ?>
        <?php echo  $type && $type == "User" ? $this->translate("Member") : $this->translate($type); ?>
      </div>
      <?php } ?>
      <div class="advancedsearch_stats">
      <?php if(in_array('view',$this->searchParams) && !empty($item->view_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', ' <i class="fa fa-eye"></i> %s', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>
        <?php } ?>
        <?php if(in_array('likes',$this->searchParams) && !empty($item->like_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-thumbs-o-up"></i> %s', '<i class="fa fa-thumbs-o-up"></i> %s', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>
        <?php } ?>
        <?php if(in_array('comment',$this->searchParams) && !empty($item->comment_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-comment-o"></i> %s', '<i class="fa fa-comment-o"></i> %s', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>
        <?php } ?>
        <?php if(in_array('review',$this->searchParams) && !empty($item->review_count)){ ?>
        <?php echo $this->translate(array('%s <i class="fa fa-pencil-square-o"></i>', '%s <i class="fa fa-pencil-square-o"></i>', $item->review_count), $this->locale()->toNumber($item->review_count)) ?>
        <?php } ?>
      </div>
      <?php if(in_array('rating',$this->searchParams) && !empty($item->rating)){ ?>
      <div class="advancedsearch_rating">
        <div class="sesmusic_songslist_rating" title="<?php echo $this->translate(array('%s rating', '%s ratings', $item->rating), $this->locale()->toNumber($item->rating)); ?>">
          <?php if( $item->rating > 0 ): ?>
          <?php for( $x=1; $x<= $item->rating; $x++ ): ?>
          <span class="sesbasic_rating_star_small fa fa-star"></span>
          <?php endfor; ?>
          <?php if( (round($item->rating) - $item->rating) > 0): ?>
          <span class="sesbasic_rating_star_small fa fa-star-half"></span>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
      <?php } ?>

      <?php if(in_array('category',$this->searchParams) && !empty($item->category_id)){
            $moduleName = ucfirst($item->getModuleName());
            if(class_exists($moduleName.'_Model_DbTable_Categories')){
                try{
                    $type = strtolower($item->getModuleName()).'_categories';
                    $category = Engine_Api::_()->getItem($type,$item->category_id);
                    if($category){ ?>
                    <?php echo $this->htmlLink($category->getHref() ? $category->getHref() : "javascript:;", $category->getTitle(), array('class' => 'advancedsearch_category')); ?>

                <?php
                if(!empty($item->subcat_id)){
                    $subcategory = Engine_Api::_()->getItem($type,$item->subcat_id);
                    if($subcategory){ ?>
                        <?php echo ' <i class="fa fa-angle-double-left" aria-hidden="true"></i> '.$this->htmlLink($subcategory->getHref() ? $subcategory->getHref() : "javascript:;", $subcategory->getTitle(), array('class' => 'advancedsearch_category')); ?>

                  <?php
                  if(!empty($item->subsubcat_id)){
                  $subsubcategory = Engine_Api::_()->getItem($type,$item->subsubcat_id);
                  if($subsubcategory){ ?>
                     <?php echo ' <i class="fa fa-angle-double-left" aria-hidden="true"></i> '.$this->htmlLink($subsubcategory->getHref() ? $subsubcategory->getHref() : "javascript:;", $subsubcategory->getTitle(), array('class' => 'advancedsearch_category')); ?>
                  <?php
                    }
                } ?>
                <?php
                    }
                } ?>
                 <?php
                    }
                }catch(Exception $e){}
            }
       ?>

      <?php } ?>

      <?php if(in_array('postedBy',$this->searchParams) && $item->getType() != "user"){ ?>
      <div class="advancedsearch_owner">
        by <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'search_title')); ?>
      </div>
      <?php } ?>
      <div class="advancedsearch_location">
      <?php if(in_array('location',$this->searchParams) && !empty($item->location)){ ?>
       <?php echo "<a href='".$this->url(array('resource_id' => $item->getIdentity(),'resource_type'=>$item->getType(),'action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$item->location</a>";?>
      <?php  } ?>
      </div>
      </div>
      </div>
      <div class="advancedsearch_info">
        <?php if( '' != $this->query ): ?>
          <?php echo $this->htmlLink($item->getHref(), $this->highlightText($item->getTitle(), $this->query), array('class' => 'search_title')) ?>
        <?php else: ?>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('class' => 'search_title')) ?>
        <?php endif; ?>
        <?php if(in_array('description',$this->searchParams)){ ?>
        <p class="advancedsearch_description sesbasic_text_light">
          <?php if( '' != $this->query ): ?>
            <?php echo $this->highlightText($this->viewMore($item->getDescription()), $this->query); ?>
          <?php else: ?>
            <?php echo $this->viewMore($item->getDescription()); ?>
          <?php endif; ?>
        </p>
        <?php } ?>
      </div>
    </div>
  <?php endforeach; ?>
    <?php if($this->loadmore == "pagging"){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "advancedsearch"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
  <?php if(!$this->loading_data){ ?>

    </div>
  <?php } ?>
  <?php if($this->loadmore != 'pagging'){ ?>
  <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
				<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div> 
        
         <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
</div>
   <?php if(!$this->loading_data){ ?>
    </div>
   <?php } ?>
<script type="application/javascript">
  <?php if($this->loadmore == "pagging"){ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
        sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
        (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + "advancedsearch/index/all-results/",
            'data': {
                format: 'html',
                limit:<?php echo $this->limit; ?>,
                loadmore : "<?php echo $this->loadmore; ?>",
                page: pageNum,
                query : "<?php echo $this->query; ?>",
                randonNumber:"<?php echo $randonNumber; ?>",
                loading_data:true,
                searchParams : <?php echo json_encode($this->searchParams); ?>,
            },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            sesJqueryObject(".advancedsearch_result_main").html(responseHTML);
        }
    })).send();
        return false;
    }
  <?php }else{ ?>
    var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';

    function viewMoreHide_<?php echo $randonNumber; ?>() {
        if ($('view_more_<?php echo $randonNumber; ?>'))
            $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
      en4.core.runonce.add(function() {
          viewMoreHide_<?php echo $randonNumber; ?>();
      });
    function viewMore_<?php echo $randonNumber; ?> (){
        document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
        document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';
        new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + 'advancedsearch/index/all-results/',
            'data': {
                format: 'html',
                limit:<?php echo $this->limit; ?>,
                loadmore : "<?php echo $this->loadmore; ?>",
                page: page<?php echo $randonNumber; ?>,
                query : "<?php echo $this->query; ?>",
                randonNumber:"<?php echo $randonNumber; ?>",
                loading_data:true,
                searchParams : <?php echo json_encode($this->searchParams); ?>,
            },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
           sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').remove();
            sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
            sesJqueryObject(".advancedsearch_result_main").append(responseHTML);
            viewMoreHide_<?php echo $randonNumber; ?>();
        }
    }).send();
        return false;
    };
<?php } ?>
</script>
<?php if($this->loadmore == 'loadmore' && !$this->loading_data){ ?>
<script type="text/javascript">
    window.addEvent('load', function() {
        sesJqueryObject(window).scroll( function() {
            var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('.advancedsearch_result_main').offset().top;
            var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
            if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
                document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
            }
        });
    });
</script>
<?php } ?>
<?php endif; ?>


