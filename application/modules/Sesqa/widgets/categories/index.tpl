<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<div class="sesqa_category_view sesbasic_clearfix sesbasic_bxs">
  <ul>
    <?php foreach($this->resultcategories as $resultcategorie): ?>
    <li style="width:<?php echo $this->mainblockwidth ?>px;">
      <div class="category_view_section sesqa_animation">
        <?php if(@in_array('socialshare', $this->showinformation)): ?>
          <div class="qa_social_btns">
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $resultcategorie->getHref()); ?>
            <?php  echo $this->partial('_socialShareIcons.tpl', 'sesbasic', array('resource' => $resultcategorie, 'socialshare_enable_plusicon' => $this->widgetParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->widgetParams['socialshare_icon_limit'])); ?>
          </div>
        <?php endif; ?>
        <a href="<?php echo $resultcategorie->getHref(); ?>" class="sesqa_linkinherit" style="height:<?php echo $this->mainblockheight ?>px;">
          <?php if($resultcategorie->getCategoryIconUrl()){ ?>
          <p class="category_icon"><img style="width:<?php echo $this->categoryiconwidth ?>px;height:<?php echo $this->categoryiconheight ?>px;" src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" /></p>
          <?php } ?>
          <?php if(@in_array('title', $this->showinformation)): ?>
            <p class="category_title"><?php echo $this->translate($resultcategorie->category_name); ?></p>
          <?php endif; ?>
        </a>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
<script>
sesJqueryObject(document).ready(function(e){
    sesJqueryObject('.menu_sesqa_main.sesqa_main_categories').parent().addClass('active');
});
</script>
