<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<div class="estore_howitworks_wrapper sesbasic_bxs">
	<div class="estore_howitworks_main sesbasic_clearfix">
  	<div class="estore_howitworks_img">
    	<img src="application/modules/Estore/externals/images/welcome-img.png">
    </div>
    <div class="estore_howitworks_content">
      <article>
        <div class="_title"><?php echo $this->translate("1- Claim");?></div>
        <div class="_des"><?php echo $this->translate("Best way to start managing your store listing is by claiming it so you can update.")?></div>
      </article>
      <article>
        <div class="_title"><?php echo $this->translate("2- Promote")?></div>
        <div class="_des"><?php echo $this->translate("Promote your store to target customers who need your services or products.")?></div>
      </article>
      <article>
        <div class="_title"><?php echo $this->translate("3- Convert")?></div>
        <div class="_des"><?php echo $this->translate("Turn your visitors into paying customers with exciting offers and services on your page.")?></div>
      </article>
    </div>
  </div>
</div>
