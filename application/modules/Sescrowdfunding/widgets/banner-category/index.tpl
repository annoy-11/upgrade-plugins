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
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<div class="sescf_category_cover sesbasic_bxs sesbm sesbasic_clearfix">
  <div class="sescf_category_cover_inner">
    <?php if(isset($this->bannerImage) && !empty($this->bannerImage)){ ?>
      <div class="sescf_category_cover_cont" style="background-image:url(<?php echo $this->bannerImage; ?>);height:300px;">
    <?php } else { ?>
    	<div class="sescf_category_cover_cont" style="height:300px;">
      	<div class="sescf_category_cover_cont_bg"></div>
    <?php } ?>  
      <div class="sescf_category_cover_cont_info centerT">
        <?php if(isset($this->title) && !empty($this->title)): ?>
          <h3 class="sescf_category_cover_title"> 
            <?php echo $this->translate($this->title); ?>
          </h3>
        <?php endif; ?>
        <?php if(isset($this->description) && !empty($this->description)): ?>
          <p class="sescf_category_cover_des">
            <?php echo $this->translate($this->description);?>
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>  
</div>
