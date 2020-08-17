<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pageRating.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('pagereview', 'view') && Engine_Api::_()->getApi('core', 'sespagereview')->allowReviewRating() && $this->showRating):?>
  <div class="sespagereview_list_rating sespagereview_rating_info_tip">
    <?php $ratingCount = $this->rating; $x=0; ?>
    <?php if( $ratingCount > 0 ): ?>
      <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
	<span id="" class="sespagereview_rating_star_small"></span>
      <?php endfor; ?>
      <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
	<span class="sespagereview_rating_star_small sespagereview_rating_star_small_half"></span>
      <?php }else{ $x = $x - 1;} ?>
      <?php if($x < 5){ 
	for($j = $x ; $j < 5;$j++){ ?>
	  <span class="sespagereview_rating_star_small sespagereview_rating_star_disable"></span>
	<?php }   	
      } ?>
    <?php endif; ?>
  </div>
  <div class="sespagereview_rating_info" style="display:none">
    <div class="review_top">
      <span><?php echo $ratingCount;?><?php echo $this->translate('SESPAGE Out of 5 Stars');?></span>
    </div>
    <?php $starData = Engine_Api::_()->getDbTable('pagereviews','sespagereview')->getStarData(array('page_id' => $this->page_id));?>
    <?php $starArray = array();?>
    <?php foreach($starData as $data):?>
      <?php $startArray[$data['rating']] = $data->toArray();?>
    <?php endforeach;?>
    <div class="review_bottom">
      <?php $counter = 5;?>
      <?php for($i=0;$i<5;$i++):?>
        <div class="progress_bar">
          <?php if(empty($startArray[$counter])):?>
            <span class="numbering_review"><?php echo $counter;?><?php echo $this->translate(' SESPAGE Star');?></span>
            <span class="bar_bg animate"><span class="bar_width"></span></span>
            <span class="bar_bg_value">0%</span>
          <?php else: ?>          
            <span class="numbering_review"><?php echo $startArray[$counter]['rating'];?> Star</span>
            <?php $width = ($startArray[$counter]['count']/$startArray[$counter]['sum'])*100;?>
            <span class="bar_bg animate"><span class="bar_width" style="width: <?php echo $width;?>%;"></span></span>
            <span class="bar_bg_value"><?php echo $width;?>%</span>
          <?php endif;?>
        </div>
        <?php $counter--;?>
      <?php endfor;?>
      <a href="<?php echo $this->url(array(),'sespagereview_review',true);?>"><span class="see_review"><?php echo $this->translate('See All ');?><?php echo $this->review;?><?php echo $this->translate(" SESPAGE Reviews ");?><i class="fa fa-angle-double-right"></i></span></a>
    </div>
  </div>
<?php endif;?>
