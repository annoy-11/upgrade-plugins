<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesrecipe_popular_tabbed sesbasic_bxs">
<?php $allParams = $this->allParams; ?>
<?php foreach($this->defaultOptionsArray as $defaultOptionsArray) { ?>
  <?php 
      switch ($defaultOptionsArray) {
      case 'recentlySPcreated':
        $popularCol = 'creation_date';
        $type = 'creation';
        break;
      case 'mostSPviewed':
        $popularCol = 'view_count';
        $type = 'view';
        break;
      case 'mostSPliked':
        $popularCol = 'like_count';
        $type = 'like';
        break;
      case 'mostSPcommented':
        $popularCol = 'comment_count';
        $type = 'comment';
        break;
      case 'mostSPrated':
        $popularCol = 'rating';
        $type = 'rating';
        break;
      case 'mostSPfavourite':
        $popularCol = 'favourite_count';
        $type = 'favourite';
        break;
      case 'featured':
        $popularCol = 'featured';
        $type = 'featured';
        $fixedData = 'featured';
        break;
      case 'sponsored':
        $popularCol = 'sponsored';
        $type = 'sponsored';
        $fixedData = 'sponsored';
        break;
      case 'verified':
        $popularCol = 'verified';
        $type = 'verified';
        $fixedData = 'verified';
        break;
    }
    $value['popularCol'] = isset($popularCol) ? $popularCol : '';
    $value['fixedData'] = isset($fixedData) ? $fixedData : '';
    $value['draft'] = 0;
    $value['search'] = 1;
    $value['fetchAll'] = 1;
    $value['limit'] = $allParams['countrecipe'];
  ?>
  <?php $results = Engine_Api::_()->getDbTable('recipes', 'sesrecipe')->getSesrecipesPaginator($value); ?>
  <?php if(count($results) > 0) { ?>
  <div class="sesrecipe_multiblocks sesbasic_bxs">
    <h3><?php echo $allParams[$defaultOptionsArray.'_label']; ?></h3>
    <?php foreach($results as $item) { ?>
      <ul class="sesbasic_sidebar_block sesbasic_sidebar_block sesrecipe_side_block sesbasic_bxs sesbasic_clearfix" style="position:relative;">
        <li class="sesrecipe_sidebar_recipe_list sesbasic_clearfix">
          <div class="sesrecipe_sidebar_recipe_list_img <?php if($this->image_type == 'rounded'):?>sesrecipe_sidebar_image_rounded<?php endif;?> sesrecipe_list_thumb sesrecipe_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
            <?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
            <a href="<?php echo $href; ?>" class="sesrecipe_thumb_img">
              <span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
            </a>     
          </div>
          <div class="sesrecipe_sidebar_recipe_list_cont">
            <div class="sesrecipe_sidebar_recipe_list_title sesrecipe_list_info_title">
              <?php if(strlen($item->getTitle()) > $allParams['title_truncation']):?>
                <?php $title = mb_substr($item->getTitle(),0,$allParams['title_truncation']).'...';?>
                <?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid()));?>
              <?php  else : ?>
                <?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
              <?php endif; ?>
            </div>
            <?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && $type == 'rating'): ?>
              <?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $item->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting', 'style' => 'margin-bottom:0px; margin-top:10px;'));?>
            <?php endif;?> 
            <div class="sesrecipe_sidebar_recipe_list_date sesbasic_text_light">
              <?php if($type == 'like' && isset($item->like_count)) { ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
              <?php } ?>
              <?php if($type == 'comment'  && isset($item->comment_count)) { ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
              <?php } ?>
              <?php if($type == 'view' && isset($item->view_count)) { ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
              <?php } ?>
              <?php if($type == 'favourite'  && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
              <?php } ?>
            </div>
          </div>
        </li>
      </ul>
    <?php } ?>
    </div>
  <?php } ?>
<?php } ?>
</div>