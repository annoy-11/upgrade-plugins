<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
$footerDesign = Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_footer_design');
?>
<?php if($footerDesign == '1'): ?>
  <?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="sm_footer_main sesbasic_clearfix sesbasic_bxs">
    <?php if($this->footerlogo || 1 !== count($this->languageNameList)): ?>
      <div>
        <?php if($this->footerlogo): ?>
          <div class="sm_footer_logo">
            <?php $footerlogo = $this->baseUrl() . '/' . $this->footerlogo; ?>
            <img alt="" src="<?php echo $footerlogo ?>">
          </div>
        <?php endif; ?>
        <?php if( 1 !== count($this->languageNameList) ): ?>
          <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sm_footer_language">
            <?php $selectedLanguage = $this->translate()->getLocale() ?>
            <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
            <?php echo $this->formHidden('return', $this->url()) ?>
          </form>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getFooterName(array('footerlink_id' => 1)); ?>
    <?php if($getFooterName): ?>
	    <div>
	      <div class="sm_footer_head">
	      <?php echo $this->translate($getFooterName); ?>
	      </div>
	      <div class="sm_footer_links">
	        <?php foreach( $this->navigation as $item ): 
            $class = explode(' ', $item->class);
	          $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sesspectromedia')->getIconsMenu(end($class));
	          $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
	            'reset_params', 'route', 'module', 'controller', 'action', 'type',
	            'visible', 'label', 'href'
	          )));
	          ?>
	          <a href="<?php echo $item->getHref(); ?>" class="footer_link">
	            <span><?php echo $this->translate($item->getLabel()); ?></span>
	          </a>
	        <?php endforeach; ?>
	      </div>
	    </div>
    <?php endif; ?>
    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1) continue; ?>
      <?php if($item->footerlink_id == 4) continue; ?>
      <div>
        <div class="sm_footer_head"><?php echo $this->translate($item->name); ?></div>
        <div class="sm_footer_links">
          <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
          <?php foreach( $footersubresults as $item ):  ?>
          <?php if(empty($this->viewer_id)): ?>
            <?php  
            if (strpos($item->url,'/') !== false) {
              $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; 
            } else {
              $link = $item->url;
            }
            ?>
            <?php if($item->nonloginenabled): ?>
              <a href="<?php if($link): ?><?php echo $link ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
            <?php endif; ?>
          <?php else: ?>
            <?php 
            if (strpos($item->loginurl,'/') !== false) {
              $link = (preg_match("#https?://#", $item->loginurl) === 0) ? 'http://'.$item->loginurl : $item->loginurl; 
            } else {
              $link = $item->loginurl;
            }
            ?>
            <?php if($item->loginenabled): ?>
              <a href="<?php if($link): ?><?php echo $link ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->logintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
            <?php endif; ?>
          <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="sm_footer_btm sesbasic_bxs sesbasic_clearfix">
    <div class="sm_footer_head"><?php echo $this->translate("Join Us On"); ?></div>
    <div class="sm_footer_social_icons">
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
    <div class="sm_footer_copy">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
  </div>
<?php elseif($footerDesign == '2'): ?>
	<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="sm_footer_main sesbasic_clearfix sesbasic_bxs">
  	<div>
    	<div class="sm_footer_head"><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.footer.aboutheading', 'About Us'); ?></div>
      <p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.footer.aboutdes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer cursus orci enim, ut maximus neque gravida at. Etiam sit amet dapibus sem. Etiam nisi odio, porta eget nulla a, sodales blandit urna. Morbi sodales malesuada augue vulputate bibendum. Aenean blandit ante a massa porttitor, eget accumsan ipsum pulvinar. Curabitur molestie id ex non rhoncus.'); ?></p>
    </div>
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getFooterName(array('footerlink_id' => 1)); ?>
    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1 || $item->footerlink_id == 2 || $item->footerlink_id == 4) continue; ?>
      <div>
        <div class="sm_footer_head"><?php echo $this->translate($item->name); ?></div>
        <ul class="sm_footer_links">
          <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
          <?php foreach( $footersubresults as $item ):  ?>
            <?php if(empty($this->viewer_id)): ?>
	            <?php $link = $item->url; ?>
	            <?php if($item->nonloginenabled): ?>
		            <a href="<?php echo $link ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
	            <?php endif; ?>
            <?php else: ?>
	            <?php $link = $item->loginurl; ?>
	            <?php if($item->loginenabled): ?>
		            <a href="<?php echo $link ?>" <?php if($item->logintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
	            <?php endif; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
    <div>
    	<div class="sm_footer_head">SOCIAL MEDIA</div>
      <div class="sm_footer_social_icons sesbasic_clearfix">
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
      
      <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sm_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
  </div>
  <div class="sm_footer_btm sesbasic_bxs sesbasic_clearfix">
  	<div class="sesbasic_clearfix">
      <div class="sm_footer_btm_links">
        <?php foreach( $this->navigation as $item ): 
          $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sesspectromedia')->getIconsMenu(end((explode(' ', $item->class))));
          $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
            'reset_params', 'route', 'module', 'controller', 'action', 'type',
            'visible', 'label', 'href'
          )));
          ?>
          <a href="<?php echo $item->getHref(); ?>" class="footer_link">
            <span><?php echo $this->translate($item->getLabel()); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
      <div class="sm_footer_copy">
        <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
      </div>
  	</div>
  </div>
<?php elseif($footerDesign == '3'): ?>
	<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="sm_footer_mini sesbasic_sesbasic_clearfix sesbasic_bxs">
    <div class="sm_footer_mini_links">
      <span><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></span>
	      <?php foreach( $this->navigation as $item ):
          $class = explode(' ', $item->class);
			    $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sesspectromedia')->getIconsMenu(end($class));
	        $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
	          'reset_params', 'route', 'module', 'controller', 'action', 'type',
	          'visible', 'label', 'href'
	        )));
	        ?>
	        <a href="<?php echo $item->getHref(); ?>" class="footer_link">
	          <span><?php echo $this->translate($item->getLabel()); ?></span>
	        </a>
	      <?php endforeach; ?>
      <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sm_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
    <div class="sm_footer_mini_socialicons sm_footer_social_icons">
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
<?php elseif($footerDesign == '4'): ?>
  <?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="sm_footer_main sesbasic_clearfix sesbasic_bxs">
    <div class="sm_footer_about">
    	<div class="sm_footer_head"><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.footer.aboutheading', 'About Us'); ?></div>
      <p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.footer.aboutdes', 'Videvo offers free stock videos and motion graphics for use in any project. You may use these video clips free of charge, in both personal and commercial productions. Video clips that carry the Creative Commons 3.0 license must be attributed the original author. '); ?></p>
      
      <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sm_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getFooterName(array('footerlink_id' => 1)); ?>
	  <?php if($getFooterName): ?>
	  <div>
	    <div class="sm_footer_head"><?php echo $this->translate($getFooterName); ?></div>
	    <div class="sm_footer_links">
	      <?php foreach( $this->navigation as $item ):
	        $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array('reset_params', 'route', 'module', 'controller', 'action', 'type',
	          'visible', 'label', 'href'))); ?>
          <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), $attribs) ?>
	        <!--<a href="<?php //echo $item->getHref(); ?>">
	          <span><?php //echo $this->translate($item->getLabel()); ?></span>
	        </a>-->
	      <?php endforeach; ?>
	    </div>
	  </div>
	  <?php endif; ?>
    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1) continue; ?>
      <?php //if($item->footerlink_id == 4) continue; ?>
      <div>
        <div class="sm_footer_head"><?php echo $this->translate($item->name); ?></div>
        <div class="sm_footer_links">
          <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesspectromedia')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
          <?php foreach( $footersubresults as $item ):  ?>
            <?php if(empty($this->viewer_id)): ?>
	            <?php $link = $item->url; ?>
	            <?php if($item->nonloginenabled): ?>
		            <a href="<?php echo $link ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
	            <?php endif; ?>
            <?php else: ?>
	            <?php $link = $item->loginurl; ?>
	            <?php if($item->loginenabled): ?>
		            <a href="<?php echo $link ?>" <?php if($item->logintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a><br />
	            <?php endif; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="sm_footer_btm sesbasic_bxs sesbasic_clearfix">
    <div class="sm_footer_head"><?php echo $this->translate("Join Us On"); ?></div>
    <div class="sm_footer_social_icons">
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
    <div class="sm_footer_copy">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
  </div>
<?php endif; ?>
<?php if(empty($this->info)): ?>
	<script type="text/javascript" src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/scripts/jquery.min.js"></script>
	<script>
	if('<?php echo $this->viewer_id ?>' == 0) {
		jqueryObjectOfSes(document).ready(function() {
			if(!jqueryObjectOfSes('#user_signup_form').length) {
				jqueryObjectOfSes(document).on('click','.popup-with-move-anim',function(e){
					e.preventDefault();
					var href = jqueryObjectOfSes(this).attr('href');
					if(href.indexOf('signup') > 0) {
						//signup redirect
						window.location.href = 'signup';
						return;
					} else {
						//redirect login
						window.location.href = 'login';
						return;
					}
				});
			}
		});
	}
	</script>
<?php endif; ?>
