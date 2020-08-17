<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesquote/externals/styles/styles.css'); ?>
<?php $allParams = $this->allParams; ?>

<?php if($allParams['title']) { ?>
  <div class="sesquote"><?php echo $allParams['title']; ?></div>
<?php } ?>

<ul class="sesquote_cat_iconlist_container sesbasic_clearfix clear sesbasic_bxs <?php echo ($allParams['alignContent'] == 'left' ? 'gridleft' : ($allParams['alignContent'] == 'right' ? 'gridright' : '')) ?>">	
  <?php foreach( $this->paginator as $item ): ?>
    <li class="sesquote_cat_iconlist" style="height:<?php echo is_numeric($allParams['height']) ? $allParams['height'].'px' : $allParams['height'] ?>; width:<?php echo is_numeric($allParams['width']) ? $allParams['width'].'px' : $allParams['width'] ?>;">
      
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$item->category_id; ?>">
        <span class="sesquote_cat_iconlist_icon">
          <?php if($item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
          <?php $cat_icon = Engine_Api::_()->storage()->get($item->cat_icon); ?>
          <?php if($cat_icon) { ?>
            <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl(); ?>" style="height:<?php echo is_numeric($allParams['heighticon']) ? $allParams['heighticon'].'px' : $allParams['heighticon'] ?>; width:<?php echo is_numeric($allParams['widthicon']) ? $allParams['widthicon'].'px' : $allParams['widthicon'] ?>;" />
          <?php } ?>
          <?php } else { ?>
          <?php } ?>
        </span>
        <?php if(in_array('title', $allParams['showStats'])){ ?>
          <span class="sesquote_cat_iconlist_title"><?php echo $this->translate($item->category_name); ?></span>
        <?php } ?>
        <?php if(in_array('countQuotes', $allParams['showStats'])){ ?>
          <span class="sesquote_cat_iconlist_count sesbasic_text_light"><?php echo $this->translate(array('%s quote', '%s quotes', $item->total_quote_categories), $this->locale()->toNumber($item->total_quote_categories))?></span>
        <?php } ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
