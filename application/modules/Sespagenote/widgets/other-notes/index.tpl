<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$allParams = $this->allParams;

?>
<ul class="sespagenote_notes_listing sespagenote_popular_listing sesbasic_clearfix sesbasic_bxs clear sespagenote_popular_listing">
<?php if($allParams['viewType'] == 'list') { ?>
	<?php foreach( $this->paginator as $item ) { ?>
    <?php $viewTypeClass = "sespagenote_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/note/_listView.tpl';?>
    
	<?php } ?>
<?php } elseif($allParams['viewType'] == 'grid') { ?>
	<?php foreach( $this->paginator as $item ) { ?>
		<?php $height = $this->params['height_grid'];?>
    <?php $width = $this->params['width_grid'];?>
     <?php $viewTypeClass = "sespagenote_list_type";?>
    <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/note/_gridView.tpl';?>
	<?php } ?>
<?php } ?>
