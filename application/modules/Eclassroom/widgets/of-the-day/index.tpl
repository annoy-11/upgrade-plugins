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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php $height = $this->height;?>
<?php $width = $this->width;?>

<div class="eclassroom_classroom_of_the_day">
    <ul class="eclassroom_listing sesbasic_bxs">
        <?php $limit = 0;?>
        <?php  $classroom = Engine_Api::_()->getItem('classroom',$this->classroom_id);?>
        <?php if($classroom):?>
            <?php if (!empty($classroom->category_id)): ?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
            <?php endif;?> 
          <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/classroom-views/_gridView.tpl';?>
        <?php endif;?>
        <?php $limit++;?>
    </ul>
</div>
