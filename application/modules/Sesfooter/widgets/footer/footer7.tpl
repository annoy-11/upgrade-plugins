<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer7.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
  <div class="sesfooter_top_section sesfooter_clearfix sesfooter_bxs">
    <?php echo $this->content;?>
  </div>
<?php endif; ?>

<div class="sesfooter_topbar sesfooter_clearfix">
  <div class="sesfooter_social_icons">
    <?php if(count($this->paginator) > 0): ?>
    <span><?php echo $this->translate("Join Us On");?></span>
    <?php endif; ?>
    <?php foreach ($this->paginator as $item): ?>
      <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
      <?php if($item->name == 'facebook'):?>
        <a class="sesfooter_icon_facebook" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-facebook"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'google'):?>
        <a class="sesfooter_icon_gplus" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-google-plus"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'linkdin'):?>
        <a class="sesfooter_icon_linkedin" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-linkedin"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'twitter'):?>
        <a class="sesfooter_icon_twitter" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-twitter"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'pinintrest'):?>
        <a class="sesfooter_icon_pinintrest" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-pinterest-p"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'instragram'):?>
        <a class="sesfooter_icon_instragram" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-instagram"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'youtube'):?>
        <a class="sesfooter_icon_youtube" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-youtube"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'vimeo'):?>
        <a class="sesfooter_icon_vimeo" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-vimeo"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'tumblr'):?>
        <a class="sesfooter_icon_tumblr" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-tumblr"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'flickr'):?>
        <a class="sesfooter_icon_flickr" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-flickr"></i>
        </a>
      <?php endif;?>
    <?php endforeach; ?>
  </div>
  <?php if($this->footerlogo): ?>
    <div class="sesfooter_topbar_right">
      <?php $footerlogo = $this->baseUrl() . '/' . $this->footerlogo; ?>
      <img alt="" src="<?php echo $footerlogo ?>">
    </div>
  <?php endif; ?>
</div>

<div class="sesfooter_main sesfooter_clearfix sesfooter_bxs">
  <?php foreach( $this->footerlinks as $item ):  ?>
    <?php if($item->footerlink_id == 1) continue; ?>
    <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
    <?php if(count($footersubresults) > 0): ?>
	    <div class="sesfooter_main_links">
	      <span><?php echo $this->translate($item->name); ?></span>
	      <ul>
	        <?php foreach( $footersubresults as $item ): ?>
	          <li>
	            <?php if(empty($this->viewer_id)): ?>
		            <?php
// 		            if (strpos($item->url,'/') !== false) {
// 			            $link = (preg_match("#https?://#", $item->url) === 0) ? $item->url : $item->url; 
// 			          } else {
// 			            $link = $item->url;
// 		            }
		            ?>
		            <?php if($item->nonloginenabled): ?>
			            <a href="<?php if($item->url): ?><?php echo $item->url ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a>
		            <?php endif; ?>
	            <?php else: ?>
		            <?php 
// 									if (strpos($item->loginurl,'/') !== false) {
// 										$link = (preg_match("#https?://#", $item->loginurl) === 0) ? $item->loginurl : $item->loginurl; 
// 									} else {
// 										$link = $item->loginurl;
// 									}
		            ?>
		            <?php if($item->loginenabled): ?>
			            <a href="<?php if($item->loginurl): ?><?php echo $item->loginurl ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->logintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a>
		            <?php endif; ?>
	            <?php endif; ?>
	          </li>
	        <?php endforeach; ?>
	      </ul>
	    </div>
	  <?php endif; ?>
  <?php endforeach; ?>
</div>

<div class="sesfooter_btm sesfooter_bxs sesfooter_clearfix">
  <div class="sesfooter_btm_left_copy">
    <span><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></span>
    <?php if( 1 !== count($this->languageNameList) ): ?>
      <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sesfooter_language">
        <?php $selectedLanguage = $this->translate()->getLocale() ?>
        <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
        <?php echo $this->formHidden('return', $this->url()) ?>
      </form>
    <?php endif; ?>
  </div>
  <div class="sesfooter_btm_right_links">
    <?php foreach( $this->navigation as $item ):
      $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
        'reset_params', 'route', 'module', 'controller', 'action', 'type',
        'visible', 'label', 'href'))); ?>
      <a href="<?php echo $item->getHref(); ?>" class="footer_link">
        <?php echo $this->translate($item->getLabel()); ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>