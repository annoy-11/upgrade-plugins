<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->isReview){ ?>
 <div class="sesmember_button sesmember_like_btn">
	<a href="javascript:;" onclick="openSesmemberReviewTab();"  class="sesbasic_animation sesbasic_link_btn"><i class='fa fa-plus'></i><?php echo $this->translate('Write a Review');?></a>
  </div>
<?php }else{ ?>
 <div class="sesmember_button">
	<a href="javascript:;" onclick="openSesmemberReviewTab();"  class="sesbasic_animation sesbasic_link_btn"><i class='fa fa-pencil'></i><?php echo $this->translate('Update Review');?></a>
  </div>
<?php } ?>

<script type="application/javascript">
function openSesmemberReviewTab(){
  var elem = sesJqueryObject('.tab_layout_sesmember_member_reviews');
  if(elem.find('a').length)
  elem.find('a').trigger('click');
  else
  elem.trigger('click');
  sesJqueryObject('.sesmember_review_profile_btn').find('a').trigger('click');
}
</script>