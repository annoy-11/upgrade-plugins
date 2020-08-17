<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesexp_footer_main_bg_image" <?php if($this->footer_image): ?> style="background-image:url(<?php echo $this->baseUrl() . '/'. $this->footer_image ?>); <?php endif; ?>"></div>
<div class="sesexp_footer_main sesbasic_bxs">
  <div class="sesexp_footer_about_us sesbasic_clearfix sesexp_footer_blogs">
    <div class="sesexp_footer_about_tittle sesbasic_footer_tittle">
      <h3><?php echo $this->translate($this->aboutusheading); ?></h3>
    </div>
    <div class="sesexp_footer_about_desc">
      <p><?php echo $this->translate($this->aboutusdescription); ?></p>
    </div>
  </div>
  
  <?php if(count($this->results) > 0): ?>
    <div class="sesexp_footer_blog_widget sesexp_footer_blogs">
      <div class="sesexp_footer_blog_tittle">
        <h3><?php echo $this->translate($this->blogsectionheading); ?></h3>
      </div>
      <div class="sesexp_footer_blogs_imges">
        <ul>
          <?php foreach($this->results as $result): ?>
            <li>
              <a href="<?php echo $result->getHref(); ?>">
                <img style="" src="<?php echo $result->getPhotoUrl('thumb.normal'); ?>" alt="" align="left" />
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php //elseif(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesblog')): ?>
    <?php //$blogs = Engine_Api::_()->getDbTable('blogs', 'sesblog')->getSesblogsSelect(array('fetchAll' => 1, 'criteria' => 'recently_created', 'limit' => 6));  ?>
<!--    <div class="sesexp_footer_blog_widget sesexp_footer_blogs">
      <div class="sesexp_footer_blog_tittle">
        <h3><?php //echo $this->translate($this->blogsectionheading); ?></h3>
      </div>
      <div class="sesexp_footer_blogs_imges">
        <ul>
          <?php //foreach($blogs as $blog): ?>
            <li>
              <a href="<?php //echo $blog->getHref(); ?>">
                <img style="" src="<?php //echo $blog->getPhotoUrl('thumb.normal'); ?>" alt="" align="left" />
              </a>
            </li>
          <?php //endforeach; ?>
        </ul>
      </div>
    </div>-->
  <?php endif; ?>

  <div class="sesexp_footer_social_blog sesexp_footer_blogs">
    <div class="sesexp_footer_social_tittle">
      <h3><?php echo $this->translate($this->socialmediaheading); ?></h3>
    </div>
    <div class="sesexp_footer_social_links sesbasic_clearfix">
      <?php if(!empty($this->facebookButton)):?>
        <a href="<?php echo $this->facebookButton;?>" target="_blank">
          <i class="fa fa-facebook"></i>
        </a>
      <?php endif;?>
      <?php if(!empty($this->googleplusButton)):?>
        <a href="<?php echo $this->googleplusButton;?>" target="_blank">
          <i class="fa fa-google-plus"></i>
        </a>
      <?php endif;?>
      <?php if(!empty($this->twitterButton)):?>
        <a href="<?php echo $this->twitterButton;?>" target="_blank">
          <i class="fa fa-twitter"></i>
        </a>
      <?php endif;?>
      <?php if(!empty($this->pinterestButton)):?>
        <a href="<?php echo $this->pinterestButton;?>" target="_blank">
          <i class="fa fa-pinterest-p"></i>
        </a>
      <?php endif;?>
    </div>
    <?php if( 1 !== count($this->languageNameList) ): ?>
      <div class="sesexp_footer_lang sesbasic_clearfix">
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      </div>
    <?php endif; ?>
  </div>
  
  <?php if	( !empty($this->affiliateCode) ): ?>
    <div class="affiliate_banner">
      <?php 
        echo $this->translate('Powered by %1$s', 
          $this->htmlLink('http://www.socialengine.com/?source=v4&aff=' . urlencode($this->affiliateCode), 
          $this->translate('SocialEngine Community Software'),
          array('target' => '_blank')))
      ?>
    </div>
  <?php endif; ?>
  <div class="sesexp_footer_bottom">
    <div class="sesexp_footer_links sesbasic_clearfix">
      <?php foreach( $this->navigation as $item ): 
        $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
          'reset_params', 'route', 'module', 'controller', 'action', 'type',
          'visible', 'label', 'href'
        )));
        ?>
        <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), $attribs) ?>
      <?php endforeach; ?>
    </div>
        <div class="sesexp_footer_copy sesbasic_bxs">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
  </div>
</div>