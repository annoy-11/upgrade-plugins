<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<!--<h3><?php echo $this->translate("Classrooms liked by this Classroom"); ?></h3>-->
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs eclassroom_linked_pages_block">
  <?php foreach($this->result as $result){ 
  	$classroom = Engine_Api::_()->getItem('classroom',$result->like_classroom_id);
    if(!$classroom)
    continue;
  ?>
    <div class="sesbasic_sidebar_list">
    	<div class="_thumb">
      	<a href="<?php echo $classroom->getHref(); ?>"><img src="<?php echo $classroom->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div> 
      <div class="sesbasic_sidebar_list_info">
      	<div class="sesbasic_sidebar_list_title"> 
      		<a href="<?php echo $classroom->getHref(); ?>"><?php echo $classroom->getTitle(); ?></a>
    		</div>
      </div>
    </div>
  <?php } ?>
</div>
