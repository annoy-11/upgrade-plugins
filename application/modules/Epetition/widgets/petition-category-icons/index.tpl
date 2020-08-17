<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
  <h3 class="epetition_cat_iconlist_head <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>"><?php echo $this->translate($this->titleC); ?></h3>
<ul class="epetition_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>">	
  <?php foreach( $this->paginator as $item ): ?>
    <li class="epetition_cat_iconlist" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <a href="<?php echo $item->getHref(); ?>">
        <span class="epetition_cat_iconlist_icon" style="background-color:<?php echo $item->color ? '#'.$item->color : '#fff'; ?>">
        <?php if(isset($this->icon) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
          <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl(); ?>" />
        <?php }else{ 
          //default image
        ?>
        <?php } ?>
        </span>

        <?php if(isset($this->title)){ ?>
        <span class="epetition_cat_iconlist_title"><?php echo $item->category_name; ?></span>
        <?php } ?>
        <?php if(isset($this->countPetitions) && isset($item->total_petitions_categories)){ ?>
          <span class="epetition_cat_iconlist_count"><?php echo $item->total_petitions_categories; ?></span>
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
  <?php }   ?>
</ul>
