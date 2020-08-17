<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$allParams = $this->params;

?>
<ul class="sespageoffer_offers_listing sespageoffer_popular_listing sesbasic_clearfix sesbasic_bxs clear sespageoffer_popular_listing">
<?php if(@$allParams['viewType'] == 'list') { ?>
	<?php foreach( $this->paginator as $item ) { ?>
    <?php $viewTypeClass = "sespageoffer_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sespageoffer/views/scripts/offer/_listView.tpl';?>
    
	<?php } ?>
<?php } elseif(@$allParams['viewType'] == 'grid') { ?>
	<?php foreach( $this->paginator as $item ) { ?>
		<?php $height = $this->params['height_grid'];?>
    <?php $width = $this->params['width_grid'];?>
     <?php $viewTypeClass = "sespageoffer_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sespageoffer/views/scripts/offer/_gridView.tpl';?>
	<?php } ?>
<?php } ?>
