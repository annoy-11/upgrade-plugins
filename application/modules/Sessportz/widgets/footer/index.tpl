<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $moduleName = $request->getModuleName();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php if(!empty($this->viewer_id)) { ?>
  <style>
    .layout_page_footer{
      background-image:url('<?php echo Engine_Api::_()->sessportz()->getFileUrl($this->footerbgimage); ?>');
      background-blend-mode:overlay;
      background-color: rgba(0, 0, 0, 0.7);
      background-size: cover;
      background-attachment: fixed;
    }
  </style>
<?php } ?>
<div class="sessportz_footer_top sesbasic_clearfix sesbasic_bxs">
   <div class="footer_col">
     <div class="footer_logo">
      <?php echo $this->content()->renderWidget('sessportz.menu-logo'); ?>
     </div>
     <?php if($settings->getSetting('sessportz.footer.aboutdes', '')) { ?>
     <div class="footer_desc">
       <p><?php echo $settings->getSetting('sessportz.footer.aboutdes', '') ?></p>
     </div>
     <?php } ?>
   </div>
   <?php if($this->news_show && count($this->results) > 0) { ?>
   <div class="footer_col">
     <h3><?php echo $this->translate("Recent News"); ?></h3>
     <div class="footer_news">
        <?php foreach($this->results as $result) { ?>
          <div class="news_block">
            <span class="_date">SEPTEMBER 6, 2018</span>
            <a href="<?php echo $result->getHref(); ?>" class="_head"><?php echo $result->getTitle(); ?></a>
          </div>
        <?php } ?>
     </div>
   </div>
   <?php } ?>
    <?php if($settings->getSetting('sessportz.twitter.embedcode', '')) { ?>
      <div class="footer_col">
        <h3><?php echo $this->translate("Twitter FEED"); ?></h3>
        <?php echo $settings->getSetting('sessportz.twitter.embedcode', '') ?>
      </div>
    <?php } ?>
    <?php if($settings->getSetting('sessportz.con.location', '') || $settings->getSetting('sessportz.con.phone', '') || $settings->getSetting('sessportz.con.email', '')) { ?>
      <div class="footer_col">
      <h3><?php echo $this->translate("Contact us"); ?></h3>
        <div class="contact_info">
          <?php if($settings->getSetting('sessportz.con.location', '')) { ?>
          <div class="cont_block">
            <div class="_icon"><i class="fa fa-map-marker"></i></div>
            <div class="_text"><?php echo $settings->getSetting('sessportz.con.location', '') ?></div>
          </div>
          <?php } ?>
          <?php if($settings->getSetting('sessportz.con.phone', '')) { ?>
            <div class="cont_block">
              <a href="#"><i class="fa fa-phone"></i><?php echo $settings->getSetting('sessportz.con.phone', '') ?></a>
            </div>
          <?php } ?>
          <?php if($settings->getSetting('sessportz.con.email', '')) { ?>
          <div class="cont_block">
            <a href="mailto:<?php echo $settings->getSetting('sessportz.con.email', '') ?>"><i class="far fa-envelope"></i><?php echo $settings->getSetting('sessportz.con.email', '') ?></a>
          </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
</div>
<div class="sessportz_footer_mini sesbasic_sesbasic_clearfix sesbasic_bxs">
  <div class="sessportz_footer_mini_links">
     <div class="add_links">
        <?php foreach( $this->navigation as $item ):
        $class = explode(' ', $item->class);
        $footerMenuIcon = Engine_Api::_()->sessportz()->getMenuIcon(end($class));
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
     <div class="copyright">
    <span><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></span>
      
    <?php if( 1 !== count($this->languageNameList) ): ?>
      <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sessportz_footer_language">
        <?php $selectedLanguage = $this->translate()->getLocale() ?>
        <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
        <?php echo $this->formHidden('return', $this->url()) ?>
      </form>
    <?php endif; ?>
    </div>
  </div>
  <div class="sessportz_footer_mini_socialicons sessportz_footer_social_icons">
    <?php foreach ($this->paginator as $item): ?>
      <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
      <?php if($item->name == 'facebook'):?>
        <a href="<?php echo $link;?>" target="_blank" class="fb" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-facebook-f"></i>
        </a>
      <?php endif;?>

      <?php if($item->name == 'google'):?>
        <a href="<?php echo $link;?>" target="_blank" class="gp" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-google-plus-g"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'linkdin'):?>
        <a href="<?php echo $link;?>" target="_blank" class="ln" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-linkedin"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'twitter'):?>
        <a href="<?php echo $link;?>" target="_blank" class="tw" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-twitter"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'pinintrest'):?>
        <a href="<?php echo $link;?>" target="_blank" class="pin" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-pinterest-p"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'instragram'):?>
        <a href="<?php echo $link;?>" target="_blank" class="im" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-instagram"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'youtube'):?>
        <a href="<?php echo $link;?>" target="_blank" class="yt" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-youtube"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'vimeo'):?>
        <a href="<?php echo $link;?>" target="_blank" class="vimeo" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-vimeo"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'tumblr'):?>
        <a href="<?php echo $link;?>" target="_blank" class="tumblr" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-tumblr"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'flickr'):?>
        <a href="<?php echo $link;?>" target="_blank" class="flickr" title="<?php echo $this->translate($item->title); ?>">
          <i class="fab fa-flickr"></i>
        </a>
      <?php endif;?>
   <?php endforeach; ?>
  </div>
</div>
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
