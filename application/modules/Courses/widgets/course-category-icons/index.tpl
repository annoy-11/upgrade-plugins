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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>

<ul class="courses_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>">	
  <?php foreach( $this->paginator as $item ): ?>
    <li class="courses_cat_iconlist" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <a href="<?php echo $item->getHref(); ?>">
        <span class="courses_cat_iconlist_icon" style="background-color:<?php echo $item->color ? '#'.$item->color : '#999'; ?>">
            <img src="<?php echo  $item->getIconPhotoUrl(); ?>" />
        </span>
        <?php if(isset($this->title)){ ?>
        <span class="courses_cat_iconlist_title"><?php echo $item->category_name; ?></span>
        <?php } ?>
        <?php if(isset($this->countProducts)){ ?>
          <span class="courses_cat_iconlist_count"><?php echo $this->translate(array('%s course', '%s courses', $item->total_courses_categories), $this->locale()->toNumber($item->total_courses_categories))?></span>
        <?php } ?>
      </a>
    </li>
  <?php endforeach; ?>
  <?php  if(  count($this->paginator) == 0){  ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('No categories found.');?>
    </span>
  </div>
  <?php } ?>
</ul>
