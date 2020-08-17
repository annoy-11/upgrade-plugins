<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer5.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->viewer_id && $this->logintextnonloggined): ?>
  <div class="sesfooter_top_section sesfooter_clearfix sesfooter_bxs">
    <?php echo $this->content;?>
  </div>
<?php endif; ?>
<div class="sesfooter_main sesfooter_clearfix sesfooter_bxs">
  <?php foreach( $this->footerlinks as $item ):  ?>
    <?php if($item->footerlink_id == 1 || $item->footerlink_id == 6) continue; ?>
    <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
    <?php if(count($footersubresults) > 0): ?>
	    <?php if($item->footer_headingicon): ?>
	      <?php $photoUrl = $this->baseUrl() . '/' . $item->footer_headingicon; ?>
	    <?php endif; ?>
	    <div class="sesfooter_main_links" style="background-image:url(<?php echo $photoUrl ?>);">
	      <b><?php echo $this->translate($item->name); ?></b>
	      <ul>
	        <?php foreach( $footersubresults as $item ): ?>
	          <li>
	            <?php if(empty($this->viewer_id)): ?>
		            <?php
// 		            if (strpos($item->url,'/') !== false) {
// 			            $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; 
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
// 										$link = (preg_match("#https?://#", $item->loginurl) === 0) ? 'http://'.$item->loginurl : $item->loginurl; 
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

  <div class="sesfooter_main_app">
    <?php $temp5des = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.footer.footer5.description', '');
    echo nl2br($temp5des); ?>
  </div>
</div>
  <div class="sesfooter_btm sesfooter_bxs sesfooter_clearfix">
  	<div class="sesfooter_btm_inner">
      <div class="sesfooter_btm_left">
      	<div class="sesfooter_btm_left_links">
					<?php foreach( $this->navigation as $item ):
		        $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
		          'reset_params', 'route', 'module', 'controller', 'action', 'type',
		          'visible', 'label', 'href'))); ?>
		        <a href="<?php echo $item->getHref(); ?>" class="footer_link">
		          <span><?php echo $this->translate($item->getLabel()); ?></span>
		        </a>
		      <?php endforeach; ?>
        </div>
        <div class="sesfooter_btm_left_copy">
        	<?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
        </div>
      </div>
			<div class="sesfooter_social_icons sesfooter_btm_right">
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
    </div>
  </div>