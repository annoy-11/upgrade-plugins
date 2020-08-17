<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/styles/styles.css'); ?>

<div class="sesariana_features_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <p><?php echo $this->translate($this->caption); ?></p>
  <div class="sesariana_features_block">
    <div class="sesariana_feature_inner">
      <div class="sesariana_feature_bg">
      	<img src="<?php echo $this->bgimage ?>" />
      </div>
    <?php 
    $counter = 0;
    foreach($this->content as $content){ 
      if($counter == 6)
        break;
    ?>
      <div class="sesariana_feature_item">
        <div class="sesariana_feature_item_icon">
        	<i class="icon_feature" style="background-image:url(<?php echo $content['iconimage']; ?>);"></i>
        </div>
        <div class="sesariana_feature_item_cont">
          <h3><a href="<?php if($content['url']){ echo $content['url'];}else{ echo 'javascript:;'; } ?>"><?php echo $this->translate($content['caption']); ?></a></h3>
          <p><?php echo $this->translate($content['description']); ?></p>
        </div>
      </div>
    <?php 
     $counter++;
      } ?> 
     

    </div>
  </div>
</div>
