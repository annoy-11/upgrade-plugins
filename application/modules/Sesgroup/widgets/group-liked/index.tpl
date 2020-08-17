<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<!--<h3><?php echo $this->translate("Groups liked by this Group"); ?></h3>-->
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs sesgroup_linked_pages_block">
  <?php foreach($this->result as $result){ 
  	$group = Engine_Api::_()->getItem('sesgroup_group',$result->like_group_id);
    if(!$group)
    continue;
  ?>
    <div class="sesbasic_sidebar_list">
    	<div class="_thumb">
      	<a href="<?php echo $group->getHref(); ?>"><img src="<?php echo $group->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div> 
      <div class="sesbasic_sidebar_list_info">
      	<div class="sesbasic_sidebar_list_title"> 
      		<a href="<?php echo $group->getHref(); ?>"><?php echo $group->getTitle(); ?></a>
    		</div>
      </div>
    </div>
  <?php } ?>
</div>