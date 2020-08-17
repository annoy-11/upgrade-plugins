<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesmaterial_footer_mini sesbasic_sesbasic_clearfix sesbasic_bxs">
  <div class="sesmaterial_footer_mini_links">
    <span><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></span>
      <?php foreach( $this->navigation as $item ):
        $class = explode(' ', $item->class);
        $footerMenuIcon = Engine_Api::_()->getApi('menus', 'sesmaterial')->getIconsMenu(end($class));
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
      <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" class="sesmaterial_footer_language">
        <?php $selectedLanguage = $this->translate()->getLocale() ?>
        <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
        <?php echo $this->formHidden('return', $this->url()) ?>
      </form>
    <?php endif; ?>
  </div>
<div class="sesmaterial_footer_mini_socialicons sesmaterial_footer_social_icons">
    <?php foreach ($this->paginator as $item): ?>
      <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
      <?php if($item->name == 'facebook'):?>
        <a href="<?php echo $link;?>" class="sematerial_fb" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-facebook"></i>
        </a>
      <?php endif;?>

      <?php if($item->name == 'google'):?>
        <a href="<?php echo $link;?>" class="sematerial_gp" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-google-plus"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'linkdin'):?>
        <a href="<?php echo $link;?>" class="sematerial_ln" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-linkedin"></i>
        </a>
      <?php endif;?>
      <?php if($item->name == 'twitter'):?>
        <a href="<?php echo $link;?>" class="sematerial_tw" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-twitter"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'pinintrest'):?>
        <a href="<?php echo $link;?>" class="sematerial_pt" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-pinterest-p"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'instragram'):?>
        <a href="<?php echo $link;?>" class="sematerial_im" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-instagram"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'youtube'):?>
        <a href="<?php echo $link;?>" class="sematerial_ye" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-youtube-play"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'vimeo'):?>
        <a href="<?php echo $link;?>" class="sematerial_vo" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-vimeo"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'tumblr'):?>
        <a href="<?php echo $link;?>" class="sematerial_tr" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-tumblr"></i>
        </a>
      <?php endif;?>
      
      <?php if($item->name == 'flickr'):?>
        <a href="<?php echo $link;?>" class="sematerial_fr" target="_blank" title="<?php echo $this->translate($item->title); ?>">
          <i class="fa fa-flickr"></i>
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
