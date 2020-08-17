<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer6.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php if(!$this->viewer_id && $this->logintextnonloggined && !empty($this->content)): ?>
  <div class="sesfooter_top_section sesfooter_clearfix sesfooter_bxs">
    <?php echo $this->content;?>
  </div>
<?php endif; ?>
<div class="sesfooter_main sesfooter_clearfix sesfooter_bxs">
  <div class="sesfooter_main_left_column">
  	<div class="_topsection">
    	<div class="sesfooter_main_links">
        <?php if($settings->getSetting('sesfooter.enablelogo', 1) && $this->footerlogo): ?>
          <div class="sesfooter_logo">
            <?php $footerlogo = $this->baseUrl() . '/' . $this->footerlogo; ?>
            <img alt="" src="<?php echo $footerlogo ?>">
          </div>
        <?php endif; ?>
        <?php if($settings->getSetting('sesfooter.footer.aboutdes', '')) { ?>
          <div class="_about"><?php echo $settings->getSetting('sesfooter.footer.aboutdes', ''); ?></div>
        <?php } ?>
      </div>
      <?php if($settings->getSetting('sesfooter.showcontactdetails', 1)) { ?>
        <div class="sesfooter_main_links _contactinfo">
          <ul class="contact_info">
            <?php if($settings->getSetting('sesfooter6.contactaddress', '')) { ?>
              <li>
                <i class="fa fa-map-marker"></i>
                <span><?php echo $settings->getSetting('sesfooter6.contactaddress', ''); ?></span>
              </li>
            <?php } ?>
            <?php if($settings->getSetting('sesfooter6.contactphonenumber', '')) { ?>
              <li>
                <i class="fa fa-phone"></i>
                <span><?php echo $settings->getSetting('sesfooter6.contactphonenumber', ''); ?></span>
              </li>
            <?php } ?>
            <?php if($settings->getSetting('sesfooter6.contactemail', '')) { ?>
              <li>
                <i class="fa fa-envelope-o"></i>
                <span><a href="mailto:<?php echo $settings->getSetting('sesfooter6.contactemail', '') ?>"><?php echo $settings->getSetting('sesfooter6.contactemail', ''); ?></a></span>
              </li>
            <?php } ?>
            <?php if($settings->getSetting('sesfooter6.contactwebsiteurl', '')) { ?>
              <li>
                <i class="fa fa-globe"></i>
                <span><a href="<?php echo $settings->getSetting('sesfooter6.contactwebsiteurl', '') ?>" target="_blank"><?php echo $settings->getSetting('sesfooter6.contactwebsiteurl', ''); ?></a></span>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
    </div>
    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1 || $item->footerlink_id == 6) continue; ?>
      <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
      <?php if(count($footersubresults) > 0): ?>
	      <div class="sesfooter_main_links">
	        <span class="sesfooter_block_heading"><?php echo $this->translate($item->name); ?></span>
	        <ul>
	          <?php foreach( $footersubresults as $item ): ?>
	            <li>
	              <?php if(empty($this->viewer_id)): ?>
	                <?php
// 	                if (strpos($item->url,'/') !== false) {
// 	                  $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; 
// 	                } else {
// 	                  $link = $item->url;
// 	                }
	                ?>
	                <?php if($item->nonloginenabled): ?>
	                  <a href="<?php if($item->url): ?><?php echo $item->url ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a>
	                <?php endif; ?>
	              <?php else: ?>
	                <?php 
// 	                  if (strpos($item->loginurl,'/') !== false) {
// 	                    $link = (preg_match("#https?://#", $item->loginurl) === 0) ? 'http://'.$item->loginurl : $item->loginurl; 
// 	                  } else {
// 	                    $link = $item->loginurl;
// 	                  }
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
  <div class="sesfooter_main_middle_column">
    <?php $socialmediaembedcode = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter6.socialmediaembedcode', ''); ?>
    <?php $chooseContent = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.footer.choosecontent', 1); ?>
    <?php if($chooseContent == 1) { ?>
      <span class="sesfooter_block_heading">
        <?php $memebrHeading = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter6.memberheading', '%s Members and Counting...'); 
        $totalCount = Engine_Api::_()->sesbasic()->totalSiteMembersCount();
        ?>
        <?php echo $this->translate(str_replace("%s",$totalCount, $memebrHeading)); ?>
      </span>
      <div class="sesfooter_user_list">
        <?php foreach( $this->members_results as $user ): ?>
          <div class="sesfooter_user_thumb" style="height:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter5.memberheight', 60) ?>px;width:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter5.memberwidth', 60) ?>px;">
           <a href="<?php echo $user->getHref() ?>" class ="item_thumb" title="<?php echo $user->getTitle(); ?>">
             <?php $url = $user->getPhotoUrl('thumb.profile'); ?>
             <?php if ($url == ''){
               $url = $this->layout()->staticBaseUrl ."application/modules/User/externals/images/nophoto_user_thumb_profile.png";
             } ?>
             <span style="background-image:url(<?php echo $url; ?>);"></span>
           </a>
         </div>
        <?php endforeach; ?>
      </div>
    <?php } else if($chooseContent == 2 && $socialmediaembedcode) { ?>
    <div class="sesfooter_user_list">
      <?php  echo $socialmediaembedcode; ?>
    </div>
    <?php } ?>
  </div>
  <div class="sesfooter_main_right_column">
	    <?php foreach( $this->footerlinks as $item ):  ?>
      <?php if($item->footerlink_id == 1 || $item->footerlink_id == 2 || $item->footerlink_id == 3 || $item->footerlink_id == 4 || $item->footerlink_id == 5) continue; ?>
      <?php $footersubresults = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id, 'enabled' => 1)); ?>
      <?php if(count($footersubresults) > 0): ?>
	      <div class="sesfooter_main_links">
	        <span class="sesfooter_block_heading"><?php echo $this->translate($item->name); ?></span>
	        <ul>
	          <?php foreach( $footersubresults as $item ): ?>
	            <li>
	              <?php if(empty($this->viewer_id)): ?>
	                <?php
// 	                if (strpos($item->url,'/') !== false) {
// 	                  $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; 
// 	                } else {
// 	                  $link = $item->url;
// 	                }
	                ?>
	                <?php if($item->nonloginenabled): ?>
	                  <a href="<?php if($item->url): ?><?php echo $item->url ?><?php else:?> javascript:void(0); <?php endif; ?>" <?php if($item->nonlogintarget): ?> target="_blank" <?php endif; ?>><?php echo $this->translate($item->name); ?></a>
	                <?php endif; ?>
	              <?php else: ?>
	                <?php 
// 	                  if (strpos($item->loginurl,'/') !== false) {
// 	                    $link = (preg_match("#https?://#", $item->loginurl) === 0) ? 'http://'.$item->loginurl : $item->loginurl; 
// 	                  } else {
// 	                    $link = $item->loginurl;
// 	                  }
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
    <?php $androidAppLink = $settings->getSetting('sesfooter6.androidapplink', 'https://play.google.com/store/apps/details?id=com.sesolutions&hl=en'); ?>
    <?php $iosAppLink = $settings->getSetting('sesfooter6.iosapplink', 'https://itunes.apple.com/us/app/sesolutions/id1269496435?ls=1&mt=8&ign-mscache=1&ign-msr=https%3A%2F%2Fitunesconnect.apple.com%2FWebObjects%2FiTunesConnect.woa%2Fra%2Fng%2Fapp%2F1269496435'); ?>
    <?php if($androidAppLink || $iosAppLink) { ?>
      <div class="sesfooter_appstore_links">
        <?php if($iosAppLink) { ?>
        <div>
          <a href="<?php echo $iosAppLink; ?>" target="_blank"><img src="application/modules/Sesfooter/externals/images/app-store.png" /></a>
        </div>
        <?php } ?>
        <?php if($androidAppLink) { ?>
        <div>
          <a href="<?php echo $androidAppLink; ?>" target="_blank"><img src="application/modules/Sesfooter/externals/images/google-play.png" /></a>
        </div>
        <?php } ?>
      </div>
    <?php } ?>
    <div class="sesfooter_social_icons">
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
    <div class="sesfooter_form">
      <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sesfooter_language">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<div class="sesfooter_btm sesfooter_bxs sesfooter_clearfix">
  <div class="sesfooter_btm_links">
    <?php foreach( $this->navigation as $item ):
      $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
        'reset_params', 'route', 'module', 'controller', 'action', 'type',
        'visible', 'label', 'href'))); ?>
      <a href="<?php echo $item->getHref(); ?>" class="footer_link">
        <?php echo $this->translate($item->getLabel()); ?>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="sesfooter_btm_copy">
    <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
  </div>
</div>
