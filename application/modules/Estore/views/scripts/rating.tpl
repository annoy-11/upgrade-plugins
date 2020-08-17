<?php if(!empty($item)) {  ?>
  <?php $rating = Engine_Api::_()->getDbTable('reviews','estore')->getRating($item->getIdentity()); ?>
  <div class="estore_rating_review sesbasic_clearfix sesbasic_bxs">
    <div class="estore_ratings">
      <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($rating,1)), $this->locale()->toNumber(round($rating,1)))?>"><?php echo round($rating,1);?>&nbsp;<i class="fa fa-star"></i></span>
    </div>
    <?php 
    $totalReviewCount = (int)Engine_Api::_()->getDbTable('reviews','estore')->getReviewCount(array('store_id'=>$item->getIdentity()))[0]; ?>
    <div class="estore_rating_info" style="display:none;">
      <div class="review_left">
        <h3><?php echo $rating; ?> <i class="fa fa-star"></i></h3>
        <p>
          <?php echo $this->translate(array('%s Rating <br/>& Review', '%s Ratings <br/>& Reviews', round($totalReviewCount,1)), $this->locale()->toNumber(round($totalReviewCount,1)))?>
        </p>
      </div>
      <div class="review_right">
        <div class="progress_bar">
          <?php  $fiveStar = count(Engine_Api::_()->getDbTable('reviews','estore')->getUserReviewCount(array('rating'=>5,'store_id'=>$item->getIdentity()))); ?>
          <span class="numbering_review">5<i class="fa fa-star"></i></span>
          <span class="bar_bg animate"><span style="width:<?php echo (int)($fiveStar/$totalReviewCount)*100 ?>%" class="bar_width" data-percent="<?php echo (int)($fiveStar/$totalReviewCount)*100 ?>"></span></span>
        </div>
        <div class="progress_bar">
          <?php $fourStar =  count(Engine_Api::_()->getDbTable('reviews','estore')->getUserReviewCount(array('rating'=>4,'store_id'=>$item->getIdentity()))); ?>
          <span class="numbering_review">4<i class="fa fa-star"></i></span>
           <span class="bar_bg animate"><span style="width:<?php echo (int)($fourStar/$totalReviewCount)*100 ?>%" class="bar_width" data-percent="<?php echo (int)($fourStar/$totalReviewCount)*100 ?>"></span></span>
        </div>
        <div class="progress_bar">
          <?php $threeStar =  count(Engine_Api::_()->getDbTable('reviews','estore')->getUserReviewCount(array('rating'=>3,'store_id'=>$item->getIdentity()))); ?>
          <span class="numbering_review">3<i class="fa fa-star"></i></span>
          <span class="bar_bg animate"><span style="width:<?php echo (int)($threeStar/$totalReviewCount)*100 ?>%" class="bar_width" data-percent="<?php echo (int)($threeStar/$totalReviewCount)*100 ?>"></span></span>
        </div>
        <div class="progress_bar">
          <?php $twoStar =  count(Engine_Api::_()->getDbTable('reviews','estore')->getUserReviewCount(array('rating'=>2,'store_id'=>$item->getIdentity()))); ?>
          <span class="numbering_review">2<i class="fa fa-star"></i></span>
          <span class="bar_bg animate"><span style="width:<?php echo (int)($twoStar/$totalReviewCount)*100 ?>%" class="bar_width" data-percent="<?php echo (int)($twoStar/$totalReviewCount)*100 ?>"></span></span>
        </div>
        <div class="progress_bar">
          <?php $oneStar =  count(Engine_Api::_()->getDbTable('reviews','estore')->getUserReviewCount(array('rating'=>1,'store_id'=>$item->getIdentity()))); ?>
           <span class="numbering_review">1<i class="fa fa-star"></i></span>
           <span class="bar_bg animate"><span style="width:<?php echo (int)($oneStar/$totalReviewCount)*100 ?>%" class="bar_width" data-percent="<?php echo (int)($oneStar/$totalReviewCount)*100 ?>"></span></span>
        </div>
      </div>
    </div>
    <div class="estorereview">
      <a href="javascript:void(0);"><span class="no_of_reviews sesbasic_text_light">&#40; <?php echo  (int)$totalReviewCount; ?> &#41;</span></a>
    </div>
  </div>
  <?php  if(!empty($showCountData)){  ?>
    <div class="estore_rating_value sesbasic_text_light">
      <span><?php echo $this->translate(array('%s Rating &amp; Review', '%s Ratings &amp; Reviews', $totalReviewCount), $this->locale()->toNumber($totalReviewCount))?></span>
    </div>
  <?php } ?>
<?php } ?>
