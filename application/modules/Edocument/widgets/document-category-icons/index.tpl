<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<ul class="edocument_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($this->alignContent == 'left' ? 'gridleft' : ($this->alignContent == 'right' ? 'gridright' : '')) ?>">	
  <li class="edocument_cat_iconlist_head"><?php echo $this->translate($this->titleC); ?></li>
  <?php foreach( $this->paginator as $item ): ?>
    <li class="edocument_cat_iconlist" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <a href="<?php echo $item->getHref(); ?>">
        <span class="edocument_cat_iconlist_icon" style="background-color:<?php echo $item->color ? '#'.$item->color : '#999'; ?>">
        <?php if($item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
          <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl(); ?>" />
        <?php } ?>
        </span>
        <?php if(isset($this->title)){ ?>
          <span class="edocument_cat_iconlist_title"><?php echo $item->category_name; ?></span>
        <?php } ?>
        <?php if(isset($this->countDocuments)){ ?>
          <span class="edocument_cat_iconlist_count"><?php echo $this->translate(array('%s document', '%s documents', $item->total_documents_categories), $this->locale()->toNumber($item->total_documents_categories))?></span>
        <?php } ?>
      </a>
    </li>
  <?php endforeach; ?>
  <?php if(count($this->paginator) == 0){  ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('No categories found.');?>
      </span>
    </div>
  <?php } ?>
</ul>
