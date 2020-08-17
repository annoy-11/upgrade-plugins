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
<?php 
			$totalCounts = 0;
      foreach($this->getStatusCompliments as $total){ 
				$totalCounts = $total['totalcount'] + $totalCounts	;
			} ?>

<div class="sesbasic_sidebar_block sesmember_compliments_block">
<p><b><?php echo $this->translate(array('%s Compliment', '%s Compliments', $totalCounts), $this->locale()->toNumber($totalCounts)); ?></b></p>
	<ul>
  <?php  foreach($this->getStatusCompliments as $compliment){  ?>
  	<?php
      $compliment_img = Engine_Api::_()->storage()->get($compliment->comfile_id, '')->getPhotoUrl();
      if(strpos($compliment_img,'http') === FALSE)
       $compliment_img = 'http://' . $_SERVER['HTTP_HOST'] . $compliment_img;
     ?>
  	<li><span class="orenge"><img src="<?php echo $compliment_img; ?>" alt="" class="" title="<?php echo $compliment->comtitle ?>"></span><p><?php echo $compliment['totalcount']; ?></p></li>
  <?php } ?>
  </ul>
</div>