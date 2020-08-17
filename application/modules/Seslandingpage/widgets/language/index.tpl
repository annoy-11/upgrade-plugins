<?php



/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/styles.css'); ?>

<div class="seslp_language_wrapper seslp_blocks_wrapper sesbasic_bxs seslp_section_spacing" style="background-image:url(<?php echo $this->backgroundimage; ?>);">
  <div class="seslp_blocks_container seslp_language_content">
    <div class="seslp_head_d1">
      <?php if($this->title) { ?>
        <h2><?php echo $this->title; ?></h2>
      <?php } ?>
    </div>
    <?php $selectedLanguage = $this->translate()->getLocale() ?>
    
    <div class="seslp_language_content_items">
    <?php 
      foreach($this->languageNameList as $key=>$value){
//       if($selectedLanguage == $key)
//       continue; 
    ?>
    <?php echo $value; ?> &bull;
    <?php } ?>
    </div>
  </div>
</div>
