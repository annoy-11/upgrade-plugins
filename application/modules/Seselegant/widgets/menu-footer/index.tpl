<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="el_footer_main">
  <div class="el_footer_social_links sesbasic_clearfix">
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
  <div class="el_footer_links sesbasic_clearfix">
    <?php foreach( $this->navigation as $item ): 
      $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
        'reset_params', 'route', 'module', 'controller', 'action', 'type',
        'visible', 'label', 'href'
      )));
      ?>
      <?php //echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), $attribs) ?>
      <a href="<?php echo $item->getHref(); ?>" class="footer_link"><?php echo $this->translate($item->getLabel()); ?></a>
    <?php endforeach; ?>
  </div>
  <div class="el_footer_copy sesbasic_bxs">
    <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
  </div>
  <?php if( 1 !== count($this->languageNameList) ): ?>
    <div class="el_footer_lang sesbasic_clearfix">
      <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
        <?php $selectedLanguage = $this->translate()->getLocale() ?>
        <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
        <?php echo $this->formHidden('return', $this->url()) ?>
      </form>
    </div>
  <?php endif; ?>
  <?php if( !empty($this->affiliateCode) ): ?>
    <div class="affiliate_banner">
      <?php 
        echo $this->translate('Powered by %1$s', 
          $this->htmlLink('http://www.socialengine.com/?source=v4&aff=' . urlencode($this->affiliateCode), 
          $this->translate('SocialEngine Community Software'),
          array('target' => '_blank')))
      ?>
    </div>
  <?php endif; ?>
</div>
