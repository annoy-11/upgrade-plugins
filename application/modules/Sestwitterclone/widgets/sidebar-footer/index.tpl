<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sestwitterclone_sidebar_footer sesbasic_bxs">
  <div class="sesbasic_clearfix">  
    <?php foreach(array_chunk($this->sestwitterclone_extra_menu->toArray(),3) as $value) {  ?>
      <div class="footer_column">
        <?php foreach( $value as $item ): ?>
          <?php
            $params = @$item['params'];
            $params['module'] = @$item['module'];
            $params['action'] = @$item['action'];
            $params['controller'] = @$item['controller'];
            $urlHref = $this->url->url($params, @$item['route'], @$item['reset_params'], @$item['encodeUrl']);
            $scheme = @$item['scheme'];
            if (null !== $scheme) {
              $urlHref = $this->schemes->setScheme($scheme)->serverUrl($urlHref);
            }
            $fragment = @$item['fragment'];
            if (null !== $fragment) {
              $urlHref .= '#' . $fragment;
            }
            if(!empty($item['uri']))
              $urlHref = $item['uri'];
          ?>        
          <div><a href="<?php echo $urlHref; ?>"><?php echo $this->translate($item['label']); ?></a></div>
        <?php endforeach; ?> 
      </div>
    <?php } ?>
    <div class="footer_bottom sesbasic_clearfix">
      <div class="footer_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></p></div>
      <div class="footer_social_icon">
        <?php foreach( $this->socialnavigation as $link ): ?>
          <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
            <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
            <i class="fa <?php echo $link->get('icon') ? $link->get('icon') : 'fa-star' ?>"></i>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sescommunityads')) { ?>
      <div class="footer_ad_button"><a href="ads/help-and-learn"><i class="fa fa-external-link"></i><?php echo $this->translate("Advertise with us"); ?></a></div>
    <?php } ?>
  </div>
</div>
