<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialtube/externals/styles/styles.css'); ?>
<div class="socialtube_intro_wrapper sesbasic_bxs sesbasic_clearfix">
  <div class="socialtube_intro_container">
    <?php if($this->sidebarimage): ?>
    	<div class="socialtube_intro_media">
      	<img src="<?php echo $this->baseUrl() . '/' . $this->sidebarimage ?>" alt="" />
      </div>
    <?php endif; ?>
    <div class="socialtube_intro_cont">
      <div class="socialtube_intro_title"><?php echo $this->titleheading;?></h3></div>
      <div class="socialtube_intro_des"><?php echo $this->description;?></div>
      <div class="socialtube_intro_btn"><a href="<?php echo $this->buttonlink; ?>" class="sesbasic_link_btn sesbasic_animation"><?php echo $this->buttontext;?></a></div>
    </div>
  </div>
</div>