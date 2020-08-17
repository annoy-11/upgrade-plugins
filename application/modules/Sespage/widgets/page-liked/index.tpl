<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<!--<h3><?php echo $this->translate("Pages liked by this Page"); ?></h3>-->
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs sespage_linked_pages_block">
  <?php foreach($this->result as $result){ 
  	$page = Engine_Api::_()->getItem('sespage_page',$result->like_page_id);
    if(!$page)
    continue;
  ?>
    <div class="sesbasic_sidebar_list">
    	<div class="_thumb">
      	<a href="<?php echo $page->getHref(); ?>"><img src="<?php echo $page->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div> 
      <div class="sesbasic_sidebar_list_info">
      	<div class="sesbasic_sidebar_list_title"> 
      		<a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>
    		</div>
      </div>
    </div>
  <?php } ?>
</div>