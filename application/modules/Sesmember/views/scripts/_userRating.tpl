<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _userRating.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesmember_review', 'view')):?>
  <div class="sesmember_list_rating">
    <?php $ratingCount = $this->rating; $x=0; ?>
    <?php if( $ratingCount > 0 ): ?>
      <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
	<span id="" class="sesmember_rating_star_small"></span>
      <?php endfor; ?>
      <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
	<span class="sesmember_rating_star_small sesmember_rating_star_small_half"></span>
      <?php }else{ $x = $x - 1;} ?>
      <?php if($x < 5){ 
	for($j = $x ; $j < 5;$j++){ ?>
	  <span class="sesmember_rating_star_small sesmember_rating_star_disable"></span>
	<?php }   	
      } ?>
    <?php endif; ?>
  </div>
<?php endif;?>