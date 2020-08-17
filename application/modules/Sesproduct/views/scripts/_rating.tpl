<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _rating.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesproduct_list_rating">
    <div class="sesproduct_list_ratings">
      <?php for( $x=1; $x<=(int)$item->rating; $x++ ): ?>
      	<span class="sesproduct_rating_star_small"></span>
      <?php endfor; ?>
      <?php if( (round($item->rating) - (int)$item->rating) > 0): ?>
      	<span class="sesproduct_rating_star_small far fa-star-half"></span>
      <?php endif; ?>
      <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
      	<span class="sesproduct_rating_star_small sesproduct_rating_star_disable"></span>
      <?php endfor; ?>
    </div>
</div>