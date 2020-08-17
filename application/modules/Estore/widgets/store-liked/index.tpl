<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<!--<h3><?php echo $this->translate("Stores liked by this Store"); ?></h3>-->
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs estore_linked_pages_block">
  <?php foreach($this->result as $result){ 
  	$store = Engine_Api::_()->getItem('stores',$result->like_store_id);
    if(!$store)
    continue;
  ?>
    <div class="sesbasic_sidebar_list">
    	<div class="_thumb">
      	<a href="<?php echo $store->getHref(); ?>"><img src="<?php echo $store->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div> 
      <div class="sesbasic_sidebar_list_info">
      	<div class="sesbasic_sidebar_list_title"> 
      		<a href="<?php echo $store->getHref(); ?>"><?php echo $store->getTitle(); ?></a>
    		</div>
      </div>
    </div>
  <?php } ?>
</div>
