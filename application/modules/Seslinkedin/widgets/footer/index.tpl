<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="seslinkedin_footer sesbasic_bxs">
  <div class="seslinkedin_footer_links sesbasic_clearfix"> 
   <div class="footer_column">
    <div class="seslinkedin_footer_logo">
       <img src="<?php echo $this->footerlogo; ?>" />
    </div> 
    <div class="seslinkedin_footer_social_icons">
      <?php foreach ($this->paginator as $item): ?>
        <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
        <?php if($item->name == 'facebook'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-facebook"></i>
          </a>
        <?php endif;?>
  
        <?php if($item->name == 'google'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-google-plus"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'linkdin'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-linkedin"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'twitter'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-twitter"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'pinintrest'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-pinterest-p"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'instragram'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-instagram"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'youtube'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-youtube-play"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'vimeo'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-vimeo"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'tumblr'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-tumblr"></i>
          </a>
        <?php endif;?>
        
        <?php if($item->name == 'flickr'):?>
          <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-flickr"></i>
          </a>
        <?php endif;?>
     <?php endforeach; ?>
    </div>
    </div>
    <?php foreach( $this->footerlinks as $item ):  ?>
     <div class="footer_column">
            <h3><?php echo $this->translate($item->name); ?></h3>
            <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'seslinkedin')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
            <?php foreach( $footersubresults as $item ):  ?>
            <?php if(empty($this->viewer_id)): ?>
	            <?php $link = $item->url; ?>
	            <?php if($item->nonloginenabled && !$this->viewer_id): ?>
          <div><a href="<?php echo $link ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a></div>
            <?php endif; ?>
             <?php else: ?>
            <?php $link = $item->loginurl; ?>
            <?php if($item->loginenabled && $this->viewer_id): ?>
	              <div><a href="<?php echo $link ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a></div>
               <?php endif; ?>
            <?php endif; ?>
           <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
    </div>
     <div class="footer_copyright_bg">
    <div class="footer_bottom sesbasic_clearfix">
    <div class="menu_footer_links">
        <ul>
        <?php foreach( $this->navigation as $item ): ?>
            <li><a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate($item->getLabel()); ?></a></li>
        <?php endforeach; ?>
        </ul>
        </div>
        <div class="menu_copy_lang">
        <p class="menu_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></p>
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
    </div>
   </div>
</div>
