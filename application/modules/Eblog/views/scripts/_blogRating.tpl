<?php/** * SocialEngineSolutions * * @category   Application_Eblog * @package    Eblog * @copyright  Copyright 2015-2016 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: _blogRating.tpl 2016-07-23 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */?><?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('eblog_review', 'view')):?>  <div class="<?php echo $this->class;?>" style="<?php echo $this->style;?>">    <?php $ratingCount = $this->rating; $x=0; ?>    <?php if( $ratingCount > 0 ): ?>      <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>	<span id="" class="eblog_rating_star_small"></span>      <?php endfor; ?>      <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>	<span class="eblog_rating_star_small eblog_rating_star_small_half"></span>      <?php }else{ $x = $x - 1;} ?>      <?php if($x < 5){ 	for($j = $x ; $j < 5;$j++){ ?>	  <span class="eblog_rating_star_small eblog_rating_star_disable"></span>	<?php }   	      } ?>    <?php endif; ?>  </div><?php endif;?>