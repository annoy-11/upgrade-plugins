<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <div class="sesbasic_clearfix sesbasic_bxs clear">
	<?php  if($this->show_item_count){ ?>
    <div class="sesbasic_clearfix sesbm sesproduct_search_result">
    	<?php echo $this->translate(array('%s Product found.', '%s Products found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
    </div>
	<?php } ?>
	<ul class="sesproduct_products_listing sesbasic_clearfix clear">
		<?php foreach($this->paginator as $item) { ?>
			<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_gridView.tpl';?>
		<?php } ?>
	</ul>
</div>

