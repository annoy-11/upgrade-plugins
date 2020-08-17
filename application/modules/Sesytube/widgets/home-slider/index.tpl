<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesytube_home_slider clearfix sesbasic_bxs">
	<div class="sesytube_home_slider_img" style="background-image:url(<?php echo $this->bgimage; ?>);"></div>
  <div class="sesytube_home_slider_cont clearfix">
  	<div class="sesytube_home_slider_cont_inner clearfix">
      <div class="sesytube_home_slider_cont_inner_cont">
        <h1><?php echo $this->translate($this->staticContent); ?></h1>
        <p class="sesytube_slider_caption"><?php echo $this->sesytube_banerdes; ?></p>
      </div>
    </div>
  </div>
</div>
