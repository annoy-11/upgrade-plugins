<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<div class="einstaclone_footer einstaclone_bxs">
  <div class="einstaclone_footer_links einstaclone_clearfix">
    <?php
    $url = Zend_Controller_Action_HelperBroker::getStaticHelper('Url');
    $schemes = new Zend_View_Helper_ServerUrl();
    ?>
     <?php foreach(array_chunk($this->einstaclone_extra_menu->toArray(),3) as $value) {  ?>
      <div class="footer_column">
        <?php foreach( $value as $item ): ?>
          <?php
             $params = @$item['params'];
             $params['module'] = @$item['module'];
             $params['action'] = @$item['action'];
             $params['controller'] = @$item['controller'];
             $urlHref = $url->url(
                  $params,
                  @$item['route'],
                  @$item['reset_params'],
                  @$item['encodeUrl']
              );
             $scheme = @$item['scheme'];
             if (null !== $scheme) {
                  $urlHref = $schemes->setScheme($scheme)->serverUrl($urlHref);
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
    <div class="footer_bottom einstaclone_clearfix">
      <div class="footer_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></div>
      <div class="footer_social_icon">
        <?php foreach( $this->socialnavigation as $link ): ?>
          <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
            <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
            <i class="fa <?php echo $link->get('icon') ? $link->get('icon') : 'fa-star' ?>"></i>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if( 1 !== count($this->languageNameList) ): ?>
      <div class="footer_lang">
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      </div>
    <?php endif; ?>
</div>
