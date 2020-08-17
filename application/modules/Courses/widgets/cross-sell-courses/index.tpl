<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $height = $this->params['height_grid']; ?>
<?php $width = $this->params['width_grid']; ?>
 <div class="sesbasic_clearfix sesbasic_bxs clear">
	<?php  if($this->show_item_count){ ?>
    <div class="sesbasic_clearfix sesbm courses_search_result">
    	<?php echo $this->translate(array('%s Course found.', '%s Courses found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
    </div>
	<?php } ?>
	<ul class="courses_listing sesbasic_clearfix clear">
		<?php foreach($this->paginator as $course) { ?>
      <?php if (!empty($course->category_id)): ?>
        <?php $category = Engine_Api::_ ()->getDbtable('categories', 'courses')->find($course->category_id)->current();?>
      <?php endif;  ?> 
			<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/courses-views/_gridView.tpl';?>
		<?php } ?>
	</ul>
</div>

