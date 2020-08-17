<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer4.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
  <div class="sesfooter_top_section sesfooter_clearfix sesfooter_bxs">
    <?php echo $this->content;?>
  </div>
<?php endif; ?>
  <div class="sesfooter_main sesfooter_clearfix sesfooter_bxs">
    <div class="sesfooter_about">
    	<div class="sesfooter_head"><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.footer.aboutheading', 'About Us'); ?></div>
      <p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.footer.aboutdes', 'Videvo offers free stock videos and motion graphics for use in any project. You may use these video clips free of charge, in both personal and commercial productions. Video clips that carry the Creative Commons 3.0 license must be attributed the original author. '); ?></p>
      
      <?php if(1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sesfooter_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getFooterName(array('footerlink_id' => 1)); ?>
	  <?php if($getFooterName): ?>
	  <div>
	    <div class="sesfooter_head"><?php echo $this->translate($getFooterName); ?></div>
	    <div class="sesfooter_links">
	      <?php foreach( $this->navigation as $item ):
	        $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array('reset_params', 'route', 'module', 'controller', 'action', 'type',
	          'visible', 'label', 'href'))); ?>
	        <a href="<?php echo $item->getHref(); ?>">
	          <span><?php echo $this->translate($item->getLabel()); ?></span>
	        </a>
	      <?php endforeach; ?>
	    </div>
	  </div>
	  <?php endif; ?>
    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1) continue; ?>
      <?php if($item->footerlink_id == 5 || $item->footerlink_id == 6) continue; ?>
      <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
      <?php if(count($footersubresults) > 0): ?>
	      <div>
	        <div class="sesfooter_head"><?php echo $this->translate($item->name); ?></div>
	        <div class="sesfooter_links">
	          <?php foreach( $footersubresults as $item ):  ?>
	            <?php if(empty($this->viewer_id)): ?>
		            <?php  
// 									if (strpos($item->url,'/') !== false) {
// 										$link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; 
// 									} else {
// 										$link = $item->url;
// 									}
		            ?>
		            <?php if($item->nonloginenabled): ?>
			            <a href="<?php if($item->url): ?><?php echo $item->url ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
		            <?php endif; ?>
	            <?php else: ?>
		            <?php 
// 									if (strpos($item->loginurl,'/') !== false) {
// 										$link = (preg_match("#https?://#", $item->loginurl) === 0) ? 'http://'.$item->loginurl : $item->loginurl; 
// 									} else {
// 										$link = $item->loginurl;
// 									}
		            ?>
		            <?php if($item->loginenabled): ?>
			            <a href="<?php if($item->loginurl): ?><?php echo $item->loginurl ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->logintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
		            <?php endif; ?>
	            <?php endif; ?>
	          <?php endforeach; ?>
	        </div>
	      </div>
	    <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <div class="sesfooter_btm sesfooter_bxs sesfooter_clearfix">
    <div class="sesfooter_head">    <?php if(count($this->paginator) > 0): ?>
	    <?php echo $this->translate("Join Us On");?>
    <?php endif; ?></div>
    <div class="sesfooter_social_icons">
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
    <div class="sesfooter_copy">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
  </div>