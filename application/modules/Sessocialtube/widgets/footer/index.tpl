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
<?php
$footerDesign = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_footer_design');
?>
<?php if($footerDesign == '1'): ?>
	 <?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="socialtube_footer_main sesbasic_clearfix sesbasic_bxs">
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getFooterName(array('footerlink_id' => 1)); ?>
    <?php if($getFooterName): ?>
	    <div>
	      <div class="socialtube_footer_head">
	      <?php echo $this->translate($getFooterName); ?>
	      </div>
	      <div class="socialtube_footer_links">
	        <?php foreach( $this->navigation as $item ): 
	          $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sessocialtube')->getIconsMenu(end((explode(' ', $item->class))));
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
      <?php //if($item->footerlink_id == 4) continue; ?>
      <div>
        <div class="socialtube_footer_head"><?php echo $this->translate($item->name); ?></div>
        <div class="socialtube_footer_links">
          <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
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
    <div>
      <div class="socialtube_footer_head"><?php echo $this->translate("Join Us On"); ?></div>
      <div class="socialtube_footer_links">
        <?php foreach ($this->paginator as $item): ?>
          <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
          <?php if($item->name == 'facebook'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-facebook"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
    
          <?php if($item->name == 'google'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-google-plus"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'linkdin'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-linkedin"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          <?php if($item->name == 'twitter'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-twitter"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'pinintrest'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-pinterest-p"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'instragram'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-instagram"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'youtube'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-youtube-play"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'vimeo'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-vimeo"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'tumblr'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-tumblr"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
          
          <?php if($item->name == 'flickr'):?>
            <a href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
              <i class="fa fa-flickr"></i>
              <?php echo $this->translate($item->title); ?>
            </a>
          <?php endif;?>
       <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="socialtube_footer_btm sesbasic_bxs sesbasic_clearfix">
    <div class="socialtube_footer_copy">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
    <?php if( 1 !== count($this->languageNameList) ): ?>
    	<div class="socialtube_footer_lang">
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="socialtube_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      </div>
    <?php endif; ?>
  </div>
<?php elseif($footerDesign == '2'): ?>
  <?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="socialtube_footer_main sesbasic_clearfix sesbasic_bxs">
    <div class="socialtube_footer_about">
    	<div class="socialtube_footer_head"><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.footer.aboutheading', 'About Us'); ?></div>
      <p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.footer.aboutdes', 'Videvo offers free stock videos and motion graphics for use in any project. You may use these video clips free of charge, in both personal and commercial productions. Video clips that carry the Creative Commons 3.0 license must be attributed the original author. '); ?></p>
      
      <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="socialtube_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
    <?php $getFooterName = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getFooterName(array('footerlink_id' => 1)); ?>
	  <?php if($getFooterName): ?>
	  <div>
	    <div class="socialtube_footer_head"><?php echo $this->translate($getFooterName); ?></div>
	    <div class="socialtube_footer_links">
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
      <?php //if($item->footerlink_id == 4) continue; ?>
      <div>
        <div class="socialtube_footer_head"><?php echo $this->translate($item->name); ?></div>
        <div class="socialtube_footer_links">
          <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
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
  <div class="socialtube_footer_btm sesbasic_bxs sesbasic_clearfix">
    <div class="socialtube_footer_head"><?php echo $this->translate("Join Us On"); ?></div>
    <div class="socialtube_footer_social_icons">
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
    <div class="socialtube_footer_copy">
      <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
    </div>
  </div>
<?php elseif($footerDesign == '3'): ?>
	<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
    <?php echo $this->content;?>
  <?php endif; ?>
  <div class="socialtube_footer_mini sesbasic_sesbasic_clearfix sesbasic_bxs">
    <div class="socialtube_footer_mini_links">
      <span><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></span>
	      <?php foreach( $this->navigation as $item ): 
			    $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sessocialtube')->getIconsMenu(end((explode(' ', $item->class))));
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
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="socialtube_footer_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
    <div class="socialtube_footer_mini_socialicons socialtube_footer_social_icons">
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
<?php endif; ?>
<?php if(empty($this->info)): ?>
	<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/jquery.min.js"></script>
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