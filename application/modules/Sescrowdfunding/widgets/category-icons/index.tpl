<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <h3 class="sescf_cat_iconlist_head"><?php echo $this->translate($this->titleC); ?></h3>
<ul class="sescf_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>">	
  <?php foreach( $this->paginator as $item ): ?>
    <li class="sescf_cat_iconlist" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <a href="<?php echo $item->getHref(); ?>">
        <span class="sescf_cat_iconlist_icon" style="background-color:<?php echo $item->color ? '#'.$item->color : '#999'; ?>">
        <?php if($item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
          <?php $icon = Engine_Api::_()->storage()->get($item->cat_icon); ?>
          <?php if($icon) { ?>
						<img src="<?php echo  $icon->getPhotoUrl(); ?>" />
          <?php } else { ?>
						<img src="<?php echo  'application/modules/Sescrowdfunding/externals/images/category-icon.png' ?>" />
          <?php } ?>
        <?php } else { ?>
          <img src="<?php echo  'application/modules/Sescrowdfunding/externals/images/category-icon.png' ?>" />
        <?php } ?>
        </span>
        <?php if(isset($this->title)){ ?>
        <span class="sescf_cat_iconlist_title"><?php echo $item->category_name; ?></span>
        <?php } ?>
        <?php if(isset($this->countCrowdfundings)){ ?>
          <span class="sescf_cat_iconlist_count"><?php echo $this->translate(array('%s crowdfunding', '%s crowdfundings', $item->total_crowdfundings_categories), $this->locale()->toNumber($item->total_crowdfundings_categories))?></span>
        <?php } ?>
      </a>
    </li>
  <?php endforeach; ?>
  <?php  if(  count($this->paginator) == 0) {  ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('No categories found.');?>
      </span>
    </div>
  <?php } ?>
</ul>
