<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesnews/externals/styles/styles.css'); ?>

<ul class="sesnews_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>">	
  <li class="sesnews_cat_iconlist_head"><?php echo $this->translate($this->titleC); ?></li>
  <?php foreach( $this->paginator as $item ): ?>
    <li class="sesnews_cat_iconlist" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <a href="<?php echo $item->getHref(); ?>">
        <span class="sesnews_cat_iconlist_icon" style="background-color:<?php echo $item->color ? '#'.$item->color : '#999'; ?>">
        <?php if($item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
          <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl(); ?>" />
        <?php }else{ 
          //default image
        ?>
        <?php } ?>
        </span>
        <?php if(isset($this->title)){ ?>
        <span class="sesnews_cat_iconlist_title"><?php echo $item->category_name; ?></span>
        <?php } ?>
        <?php if(isset($this->countNews)){ ?>
          <span class="sesnews_cat_iconlist_count"><?php echo $this->translate(array('%s news', '%s news', $item->total_news_categories), $this->locale()->toNumber($item->total_news_categories))?></span>
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
