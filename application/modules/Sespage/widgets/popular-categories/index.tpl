<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $widgetParams = $this->widgetParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php $route = 'sespage_general';?>
<?php if($widgetParams['viewType'] == 'list') { ?>
  <div class="sespage_home_category_list_view sesbasic_clearfix sesbasic_bxs <?php if(($widgetParams['showsubcategory'])) { ?>is_subcat<?php } ?>">
    <?php foreach($this->resultcategories as $resultcategorie): ?>
      <div class="sespage_home_category_list_item">
      	<section class="sesbasic_clearfix">
          <?php //if(empty($widgetParams['showsubcategory'])) { ?>
            <a href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($resultcategorie->category_id); ?>" class="sespage_home_category_list_item_icon" style="width:<?php echo $widgetParams['categoryiconwidth'] ?>px;"><?php if(@in_array('caticon', $widgetParams['showinformation'])) { ?><img style="max-width:<?php echo $widgetParams['categoryiconwidth'] ?>px;max-height:<?php echo $widgetParams['categoryiconheight'] ?>px;" src="<?php echo $resultcategorie->getPhotoUrl(); ?>" /><?php } ?></a>
          <?php //} ?>
          <div class="sespage_home_category_list_item_cont" style="line-height:<?php echo $widgetParams['categoryiconheight'] ?>px;">
          <a href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($resultcategorie->category_id); ?>"><?php echo $this->translate($resultcategorie->category_name); ?></a>
        	</div>
          <?php if($widgetParams['showsubcategory']) { ?>
            <?php $subCategories = Engine_Api::_()->getDbTable('categories', 'sespage')->getModuleSubcategory(array('category_id' => $resultcategorie->getIdentity(), 'column_name' => '*', 'limit' => $widgetParams['limitsubcat'])); ?>
            <div class="sespage_home_category_list_sub">
              <?php foreach($subCategories as $subCategory) { ?>
              	<div class="sespage_home_category_list_sub_item sesbasic_clearfix">
                  <a class="sespage_home_category_list_sub_item_icon" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($resultcategorie->category_id) . '&subcat_id='.urlencode($subCategory->category_id) ; ?>" style="width:<?php echo $widgetParams['subcaticonwidth'] ?>px;"><?php if(@in_array('subcaticon', $widgetParams['showinformation'])) { ?><img style="max-width:<?php echo $widgetParams['subcaticonwidth'] ?>px;max-height:<?php echo $widgetParams['subcaticonheight'] ?>px;" src="<?php echo $subCategory->getPhotoUrl(); ?>" /><?php } ?></a>
                  <div class="sespage_home_category_list_sub_item_cont" style="line-height:<?php echo $widgetParams['subcaticonheight'] ?>px;">
                    <a href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($resultcategorie->category_id) . '&subcat_id='.urlencode($subCategory->category_id) ; ?>"><?php echo $this->translate($subCategory->category_name); ?></a>
                  </div>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </section>
			</div>      
    <?php endforeach; ?>
  
  </div>
<?php } elseif($widgetParams['viewType'] == 'grid') { ?>
  <div class="sespage_home_category_content sesbasic_clearfix sesbasic_bxs">
    <?php foreach($this->resultcategories as $resultcategorie): ?>
      <div class="sespage_home_category_section" style="width:<?php echo $widgetParams['mainblockwidth'] ?>px;height:<?php echo $widgetParams['mainblockheight'] ?>px;">
        <?php if(@in_array('socialshare', $widgetParams['showinformation'])) { ?>
          <div class="sespage_list_btns">
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $resultcategorie->getHref()); ?>
            <?php  echo $this->partial('_socialShareIcons.tpl', 'sesbasic', array('resource' => $resultcategorie, 'socialshare_enable_plusicon' => $widgetParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $widgetParams['socialshare_icon_limit'])); ?>
          </div>
        <?php } ?>
        <a href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($resultcategorie->category_id); ?>">	
          <?php if(@in_array('caticon', $widgetParams['showinformation'])): ?>
            <?php $thumbnail = $resultcategorie->thumbnail; ?>
            <div class="sespage_home_category_section_img" style="width:<?php echo $widgetParams['categoryiconwidth'] ?>px;height:<?php echo $widgetParams['categoryiconheight'] ?>px;">
                <img src="<?php echo $resultcategorie->getPhotoUrl(); ?>" />
            </div>
          <?php endif; ?>
          <div class="sespage_home_category_section_title">
            <?php echo $this->translate($resultcategorie->category_name); ?>
          </div>
          <?php if(@in_array('description', $widgetParams['showinformation'])): ?>
            <div class="sespage_home_category_section_des">
              <?php echo $this->string()->truncate($this->string()->stripTags($resultcategorie->description), $widgetParams['description_truncation']); ?>
            </div>
          <?php endif; ?>
          </a>
      </div>
    <?php endforeach; ?>
  </div>
<?php } ?>