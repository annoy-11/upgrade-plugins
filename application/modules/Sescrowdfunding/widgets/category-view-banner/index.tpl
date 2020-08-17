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
<div class="sescf_category_cover sesbasic_bxs sesbm sesbasic_clearfic">
  <div class="sescf_category_cover_inner">
    <?php if($this->category->colored_icon){ ?>
      <?php $image = Engine_Api::_()->storage()->get($this->category->colored_icon)->getPhotoUrl(); ?>
      <div class="sescf_category_cover_cont" style="background-image:url(<?php echo $image; ?>);height:300px;">
    <?php } else { ?>
    	<div class="sescf_category_cover_cont" style="height:300px;">
      	<div class="sescf_category_cover_cont_bg"></div>
    <?php } ?>  
      <div class="sescf_category_cover_cont_info centerT">
        <h3 class="sescf_category_cover_title"> 
          <?php echo $this->translate($this->category->category_name); ?>
        </h3>
        <p class="sescf_category_cover_des">
          <?php echo $this->category->description;?>
        </p>
      </div>
    </div>
  </div>  
</div>
