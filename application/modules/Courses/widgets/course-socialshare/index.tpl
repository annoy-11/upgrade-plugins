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

<?php if($this->design_type == 1):?>
<div class="courses_social_share_course1 sesbasic_bxs">
  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->courses)); ?>

</div>
<?php elseif($this->design_type == 2):?>
	<div class="courses_social_share_course2 sesbasic_bxs">
		<i><b><?php echo $this->translate('Share it').' :-';?></b></i>
		<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->courses)); ?>
	</div>

<?php elseif($this->design_type == 3):?>
	<div class="courses_social_share_course3 sesbasic_bxs">
		<ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->courses, 'param' => 'photoviewpage')); ?>
		</ul>
	</div>

<?php elseif($this->design_type == 4):?>
  <div class="courses_social_share_course4 sesbasic_bxs">
    <ul>
      <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->courses, 'param' => 'photoviewpage')); ?>
    </ul>
  </div>
<?php endif;?>
