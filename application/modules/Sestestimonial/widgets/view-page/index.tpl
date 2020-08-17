<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $item = $this->testimonial; 
$user = Engine_Api::_()->getItem('user', $item->user_id);
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<div class="sestestimonial_view_page sesbasic_clearfix sesbasic_bxs">
	<div class="testimonial_view_content">
		<div class="testimonial_view_item">
			<div class="testimonial_user_img">
				<div class="testimonial_user_img_inner">
					<a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
					<div class="testimonial_user_detail">
						<span class="_name"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
						<?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
		          <span class="_designation sesbasic_text-light">&#40;<?php echo $item->designation; ?>&#41;</span>
		        <?php } ?>
					</div>
				</div>
			</div>
			<div class="testimonial_user_desc">
				<div class="testimonial_user_title">
					<h4><?php echo $item->title; ?></h4>
				</div>
				<div class="testimonial_posting_date sesbasic_text_light">
					<span><?php echo $this->translate("Posted "); ?><?php echo $this->timestamp($item->creation_date); ?></span>
				</div>
				<?php if(in_array('likecount', $this->stats) || in_array('commentcount', $this->stats) || in_array('viewcount', $this->stats)) { ?>
				<div class="testimonial_list_stats sesbasic_text_light">
					<span>
              <?php if(in_array('likecount', $this->stats)) { ?>
                <span><i class="fa fa-thumbs-up"></i><?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?></span>    
              <?php } ?>
              <?php if(in_array('commentcount', $this->stats)) { ?>
                <span><i class="fa fa-comments"></i><?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?></span>
              <?php } ?>
              <?php if(in_array('viewcount', $this->stats)) { ?>
                <span><i class="fa fa-eye"></i><?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?></span>                          
              <?php } ?>
          </span>
				</div>
				<?php } ?>
	      <?php if(in_array('rating', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
	        <div class="testimonial_rating">
	          <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
	            <span class="rating_star_generic rating_star"></span>
	          <?php endfor; ?>
	          <?php if( (round($item->rating) - $item->rating) > 0): ?>
	            <span class="rating_star_generic rating_star_half"></span>
	          <?php endif; ?>
	          <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
	            <span class="rating_star_generic rating_star_empty"></span>
	          <?php endfor; ?>
	        </div>
	      <?php } ?>
				<div class="testimonial_short_desc">
					<p><?php echo $item->description; ?></p>
				</div>		
			</div>
			
		</div>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.longdes', 1)) { ?>
	        <div class="testimonial_view_body">
	          <div class="testimonial_view_desc">
	            <p><?php echo $item->body; ?></p>
	          </div>
	        </div>
		<?php } ?>
		<?php if($this->editTesti || $this->deleteTesti && $this->viewer_id == $item->user_id) { ?>
	        <div class="testimonial_view_button">
	          <?php if($this->editTesti) { ?>
	            <a href="<?php echo $this->url(array('action' => 'edit', 'testimonial_id' => $item->testimonial_id), 'sestestimonial_specific') ?>" class="testimonial_button"><i class="fa fa-pencil"></i><?php echo $this->translate("Edit"); ?></a>
	          <?php } ?>
	          <?php if($this->deleteTesti) { ?>
	            <a href="<?php echo $this->url(array('action' => 'delete', 'testimonial_id' => $item->testimonial_id), 'sestestimonial_specific') ?>" class="smoothbox testimonial_button"><i class="fa fa-trash"></i><?php echo $this->translate("Delete"); ?></a>
	          <?php } ?>
	        </div>
		<?php } ?>
	</div>
</div>
<?php if($this->canhelpful && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.helpful', 1)): ?>
    <?php $checkHelpful = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->checkHelpful($item->testimonial_id, $this->viewer_id);
    
    $getHelpfulvalue = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->getHelpfulvalue($item->testimonial_id, $this->viewer_id);
    $helpfulCountforYes = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->helpfulCount($item->testimonial_id, 1);
    $helpfulCountforNo = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->helpfulCount($item->testimonial_id, 2);
    
    $totalHelpful = $helpfulCountforYes + $helpfulCountforNo;
    $percentageHelpful = ($helpfulCountforYes / ($totalHelpful))*100;
    $final_value = round($percentageHelpful);
    ?>
    <div class="sestestimonial_view_helpful_section" id="helpful_content">
      <div id="helpful_testimonial">
        <p class="sestestimonial_view_helpful_section_des"><?php echo $this->translate("Was this helpful?"); ?></p>
        <div class="sestestimonial_view_helpful_section_btns">
          <?php if(empty($checkHelpful)) { ?>
            <p class="sestestimonial_helpfull_yes"><a href="javascript:void(0);" onclick="markasHelpful('1', '<?php echo $item->testimonial_id; ?>')" class="sestestimonial_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
            <p class="sestestimonial_helpfull_no"><a href="javascript:void(0);" onclick="markasHelpful('2', '<?php echo $item->testimonial_id; ?>')" class="sestestimonial_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
          <?php } elseif($checkHelpful && $getHelpfulvalue == 1) { ?>
            <p class="disabled sestestimonial_helpfull_yes"><a href="javascript:void(0);" class="sestestimonial_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
            <p class="sestestimonial_helpfull_no"><a href="javascript:void(0);" onclick="markasHelpful('2', '<?php echo $item->testimonial_id; ?>')" class="sestestimonial_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
          <?php } elseif($checkHelpful && $getHelpfulvalue == 2) { ?>
            <p class="sestestimonial_helpfull_yes"><a href="javascript:void(0);" onclick="markasHelpful('1', '<?php echo $item->testimonial_id; ?>')" class="sestestimonial_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
            <p class="disabled sestestimonial_helpfull_no"><a href="javascript:void(0);" class="sestestimonial_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
          <?php } ?>
        </div>
        <?php if($final_value > 0): ?>
          <p class="sestestimonial_view_helpful_section_total"><?php echo '<b>'.$final_value.'%</b>'.$this->translate(' users marked this Testimonial as helpful.');?></p>
        <?php else: ?>
          <p class="sestestimonial_view_helpful_section_total"><?php echo '<b>0%</b>'.$this->translate(' users marked this Testimonial as helpful.');?></p>
        <?php endif; ?>
      </div>
    </div>
<?php endif; ?>
<script>

function markasHelpful(helpfultestimonial, testimonial_id) {
  
  if($('helpful_testimonial'))
    $('helpful_testimonial').style.disply = 'none';
  (new Request.HTML({
    method: 'post',              
    'url': en4.core.baseUrl + 'sestestimonial/index/helpful/',
    'data': {
      format: 'html',
      testimonial_id: testimonial_id,
      helpfultestimonial: helpfultestimonial,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      document.getElementById('helpful_content').innerHTML = "<div class='sestestimonial_success_msg'><i class='fa fa-check'></i><span><?php echo $this->translate('Thank you for your feedback!.');?> </span></div>";
    }
  }).send());
  return false;
} 


</script>
