<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



?>

<?php $headerPluginEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesheader'); ?>
<?php $identity = $this->identity; ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/scripts/core.js'); ?>
<script type="application/javascript">
//autoplaydelay 
autoPlayDelay<?php echo "_".$identity ?> = <?php echo intval($this->autoplaydelay) ? $this->autoplaydelay : '5000'; ?>
//window.addEvent('domready', function() {
	var htmlElement<?php echo "_".$identity ?> = document.getElementsByTagName("body")[0];
  htmlElement<?php echo "_".$identity ?>.addClass('seshtmlbackground_slideshow');
//});
var insideOutside = <?php echo $this->inside_ouside; ?>;
if(insideOutside){ 
htmlElement<?php echo "_".$identity ?>.addClass('header_transparency');
}
var logoSeshtml<?php echo "_".$identity ?> = sesJqueryObject('.layout_core_menu_logo').html();
if(!logoSeshtml<?php echo "_".$identity ?>)
	logoSeshtml<?php echo "_".$identity ?> = sesJqueryObject('.header_logo').html();
<?php if($this->main_navigation): ?>
sesJqueryObject('#global_wrapper').css('padding-top','0px');
<?php endif; ?>
<?php if($this->full_width): ?>
//window.addEvent('domready', function() {
	var htmlElement<?php echo "_".$identity ?> = document.getElementsByTagName("body")[0];
  htmlElement<?php echo "_".$identity ?>.addClass('seshtmlbackground_slideshow_full_width');
//});
<?php endif; ?>
</script>
<?php
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/styles/slideshowstyle.css');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/scripts/slideshowmodernizr.js');
?>

<div class="seshtmlbackground_slideshow_wrapper sesbasic_clearfix" id="seshtmlbackground_slideshow_wrapper_<?php echo $identity; ?>" style="height:<?php echo $this->height.'px'; ?>;">

      <?php if($this->templateDesign == 0){ ?>
      <script type="application/javascript">
		  sesJqueryObject(document).ready(function(){
				sesJqueryObject("body").addClass("seshtml_template_one");
		  });
      </script>
			
	    <div class="seshtmlbackground_slideshow_container ">  		
      <header class="cd-header sesbasic_bxs">
      <div class="cd-logo" id="cd-logo<?php echo "_".$identity ?>"></div>
			
    	<?php if($this->main_navigation && count($this->navigation) && ($this->show_menu)): ?>
        <nav class="cd-primary-nav cd-primary-nav<?php echo "_".$identity ?>">
        	<a href="javascript:void(0);" class="cd-primary-nav-browse-btn">
          	<span><?php echo $this->translate("Browse"); ?></span>
          	<i class="fa fa-angle-down"></i>
          </a>
          <a href="javascript:void(0);" class="cd-primary-nav-mobile-browse-btn">
          	<i class="fa fa-bars"></i>
          </a>
        	<ul class="cd-primary-nav-dropdown">
        		<?php foreach( $this->navigation as $navigationMenu ): ?>
        			<li>
        				<?php if ($navigationMenu->action):  ?>
										<a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>									
                <?php else : ?>
                <?php $classArray = explode(' ', $navigationMenu->class); 
									if($classArray[1] == 'core_main_home' && $this->viewer->getIdentity() != 0):  ?>
										<a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
									<?php elseif($classArray[1] == 'core_main_invite' && $this->viewer->getIdentity() != 0): ?>
				            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
									<?php else: ?>
                  <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                  <!--<a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>-->
                  <?php endif; ?>
                <?php endif; ?>
        			</li>
        		<?php endforeach; ?>
        	</ul>
        </nav>
      <?php endif; ?>
			
      <?php if(!$this->sesspectromedia && $this->mini_navigation && count($this->menumininavigation)){ ?>
      	<div id='core_menu_mini_menu' class="cd-mini-menu">
          <?php
            $count = count($this->menumininavigation);
            foreach( $this->menumininavigation->getPages() as $item ) $item->setOrder(--$count);
          ?>
          <ul>
            <?php if( $this->viewer->getIdentity()) :?>
            <li id='core_menu_mini_menu_update'>
              <span onclick="toggleUpdatesPulldown<?php echo "_".$identity ?>(event, this, '4');" style="display: inline-block;" class="updates_pulldown">
                <div class="pulldown_contents_wrapper">
                  <div class="pulldown_contents">
                    <ul class="notifications_menu" id="notifications_menu">
                      <div class="notifications_loading" id="notifications_loading">
                        <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' style='float:left; margin-right: 5px;' />
                        <?php echo $this->translate("Loading ...") ?>
                      </div>
                    </ul>
                  </div>
                  <div class="pulldown_options">
                    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'),
                       $this->translate('View All Updates'),
                       array('id' => 'notifications_viewall_link')) ?>
                    <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array(
                      'id' => 'notifications_markread_link',
                    )) ?>
                  </div>
                </div>
                <a href="javascript:void(0);" id="updates_toggle" <?php if( $this->notificationCount ):?> class="new_updates"<?php endif;?>><?php echo $this->translate(array('%s Update', '%s Updates', $this->notificationCount), $this->locale()->toNumber($this->notificationCount)) ?></a>
              </span>
            </li>
            <?php endif; ?>
            <?php foreach( $this->menumininavigation as $item ): ?>
              <li><?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array(
                'class' => ( !empty($item->class) ? $item->class : null ),
                'alt' => ( !empty($item->alt) ? $item->alt : null ),
                'target' => ( !empty($item->target) ? $item->target : null ),
              ))) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
			<?php }else if($this->sesspectromedia && $this->mini_navigation){ ?>
      	<div class="cd-mini-menu"> <?php echo $this->content()->renderWidget($this->moduleEnable.'.menu-mini');?></div>
      <?php } ?>
			
    </header>
    <section class="cd-hero design_1_template sesbasic_bxs">
      <ul class="cd-hero-slider cd-hero-slider<?php echo "_".$identity ?> <?php echo $this->autoplay ? 'autoplay' : '' ; ?>" style="height:<?php echo $this->height.'px'; ?>;">
    <?php 
      $counter = 0;
      foreach($this->paginator as $itemdata){ ?>	
      <?php 
        $item = Engine_Api::_()->getItem('seshtmlbackground_slide',$itemdata->slide_id); 
        ?>
				  <?php 
          if($item->overlay_type == '1'){
             $style = 'style="position: absolute; top:0; right:0; bottom:0; left:0; z-index: 1;background: #'.$item->overlay_color.'; opacity: '.$item->overlay_opacity.';"';
          }else{
            $style = 'style="position: absolute; top:0; right:0; bottom:0; left:0; z-index: 1;background: url(./application/modules/seshtmlbackground/externals/images/'.$item->overlay_pettern.') repeat center center;opacity: '.$item->overlay_opacity.';"';
          }

        ?>
    <?php if($item->file_type == 'mp4'){ ?>
        <li class="cd-bg-video <?php echo $counter == 0 ? 'selected ' : '' ; ?>form-in-<?php echo $item->position_register_form == 'right' ? 'right' : 'left'; ?>">
          <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
            <?php  if((isset($item->show_login_form) && $item->show_login_form) || $item->show_register_form){ ?>
              <div class="cd-half-width cd-signupform-container" style="padding-top:<?php echo $this->signupformtopmargin ?>px;display:<?php echo $counter == 0 ? 'block' : 'none' ; ?>">
             <?php $isLogin = false; ?>
             <?php if(isset($item->show_login_form) && $item->show_login_form){ ?>
                <?php $registerActive = $item->show_register_form; ?>
                <?php if($registerActive){ ?>
                <div class="cd-signupform-tabs design_one sesbasic_clearfix">
                  <a class="seshtmlbackground_pln_btn active" href="javascript:;" rel="login" id="login_seshtml_btn_<?php echo $itemdata->slide_id; ?>" data-url="<?php echo $itemdata->slide_id; ?>"><?php echo $this->translate('Sign In') ?></a>
                  <a rel="signup" class="seshtmlbackground_pln_btn" href="javascript:;" id="signup_seshtml_btn_<?php echo $itemdata->slide_id; ?>" data-url="<?php echo $itemdata->slide_id; ?>"><?php echo $this->translate('Sign Up') ?></a>
                </div>
                <?php } ?>
                <div class="seshtmlbackground_form sesbasic_clearfix cd-loginbox cd-loginbox-<?php echo $itemdata->slide_id; ?>">
                	<?php if(!$registerActive){ ?><div class="cd-signupform-heading"><?php echo $this->translate('Sign In'); ?></div> <?php } ?>
                  <?php echo $this->content()->renderWidget("seshtmlbackground.login-or-signup",array('id'=>$itemdata->slide_id,'registerActive'=>$registerActive)); ?>
                </div>
             <?php 
                $isLogin = true;
             } ?>
          	<?php  if($item->show_register_form){ ?>
                <div class="seshtmlbackground_form sesbasic_clearfix cd-signupform cd-signupform-<?php echo $itemdata->slide_id; ?>">
                  <?php if(!$isLogin){ ?>
                     <div class="cd-signupform-heading"><?php echo $this->translate("Sign Up")?></div>
                  <?php } ?>
                  <?php echo $this->action("index", "signup",defined('sesquicksignup') ? "quicksignup" : "seshtmlbackground", array('id'=>$itemdata->slide_id,'isLogin'=>$isLogin,'disableContent'=>true)); ?>
                </div>
          	<?php } ?>
            </div>
          <?php } ?>
          <?php } ?>
          <?php 
            $fullWidth = true;
            if($item->show_register_form == 0 && $item->show_login_form == 0){
                  $fullWidth = true;
             }else{
                if(Engine_Api::_()->user()->getViewer()->getIdentity() == 0)
                  $fullWidth = false;
                 else
                   $fullWidth = true;
              } 
          ?>
          <div class="<?php echo $fullWidth ? 'cd-full-width' : 'cd-half-width' ; ?>">
            <?php if($item->title != '' || $item->description  != ''){ ?>	
              <?php if($item->title != ''){ ?>
                <h2 style="color:#<?php echo $item->title_button_color; ?>;font-size:<?php echo  $item->title_font_size; ?>px !important;font-family:<?php echo $item->title_font_family;  ?>"><?php echo $this->translate($item->title); ?></h2>
              <?php } ?>
            <?php } ?>
            <?php if($item->description  != ''){ ?>
             <p style="color:#<?php echo $item->description_button_color; ?>;font-size:<?php echo  $item->description_font_size; ?>px !important;font-family:<?php echo $item->description_font_family;  ?>"><?php echo $this->translate(nl2br($item->description)) ; ?></p>
            <?php } ?>
            <?php if($item->login_button && Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
              <a data-effect="" href="<?php echo $this->sesspectromedia ? '#small-dialog' : $this->layout()->staticBaseUrl.'login'; ?>" class="cd-btn <?php echo $this->sesspectromedia ? 'popup-with-move-anim data-effect-bg' : '' ?>"  onMouseOver="this.style.backgroundColor='#<?php echo $item->login_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->login_button_color; ?>'" style="color:#<?php echo $item->login_button_text_color; ?>; background-color:#<?php echo $item->login_button_color; ?>"><?php echo $this->translate($item->login_button_text); ?></a>
            <?php } ?>
            <?php if($item->signup_button && Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
              <a data-effect="" href="<?php echo $this->sesspectromedia ? '#user_signup_form' : $this->layout()->staticBaseUrl.'signup'; ?>" class="cd-btn secondary <?php echo $this->sesspectromedia ? 'popup-with-move-anim data-effect-bg' : '' ?>"  onMouseOver="this.style.backgroundColor='#<?php echo $item->signup_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->signup_button_color; ?>'" style="color:#<?php echo $item->signup_button_text_color; ?>;background-color:#<?php echo $item->signup_button_color; ?>"><?php echo $this->translate($item->signup_button_text); ?></a>
            <?php } ?>
            <?php if($item->extra_button){ ?>
              <a <?php if($item->extra_button_linkopen): ?> target='_blank' <?php endif; ?> href="<?php echo $item->extra_button_link ? $item->extra_button_link : 'javascript:void(0)'; ?>" class="cd-btn secondary"  onMouseOver="this.style.backgroundColor='#<?php echo $item->extra_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->extra_button_color; ?>'" style="color:#<?php echo $item->extra_button_text_color; ?>;background-color:#<?php echo $item->extra_button_color; ?>"><?php echo $this->translate($item->extra_button_text); ?></a>
            <?php } ?> 
          </div>
          <div class="cd-bg-video-wrapper" data-image="<?php echo $item->getFilePath('thumb_icon'); ?>" data-video="<?php echo $item->getFilePath('file_id'); ?>">
          <div class="overlay" <?php echo $style; ?>></div>
					<div class="html5_slide_overlay" style"overlay-color:<?php echo $item->overlay_color; ?>opacity:<?php echo $item->overlay_opacity; ?>"></div>
					<div class="html5_slide_overlay_pettern" style"overlay-color:<?php echo $item->overlay_color; ?>;overlay-opacity:<?php echo $item->overlay_opacity; ?>"></div>
          </div> <!-- .cd-bg-video-wrapper -->
        </li>
    <?php }else{ ?>
       <li class="<?php echo $counter == 0 ? 'selected' : '' ; ?> form-in-<?php echo $item->position_register_form == 'right' ? 'right' : 'left'; ?>" style="background-image:url(<?php echo $item->getFilePath('file_id') ?>);">
          <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
            <?php  if((isset($item->show_login_form) && $item->show_login_form) || $item->show_register_form){ ?>
              <div class="cd-half-width cd-signupform-container" style="padding-top:<?php echo $this->signupformtopmargin ?>px;display:<?php echo $counter == 0 ? 'block' : 'none' ; ?>">
             <?php $isLogin = false; ?>
             <?php if(isset($item->show_login_form) && $item->show_login_form){ ?>
                <?php $registerActive = $item->show_register_form; ?>
                <?php if($registerActive){ ?>
                <div class="cd-signupform-tabs sesbasic_clearfix">
                  <a class="seshtmlbackground_pln_btn active" href="javascript:;" rel="login" id="login_seshtml_btn_<?php echo $itemdata->slide_id; ?>" data-url="<?php echo $itemdata->slide_id; ?>"><?php echo $this->translate('Sign In') ?></a>
                  <a rel="signup" class="seshtmlbackground_pln_btn" href="javascript:;" id="signup_seshtml_btn_<?php echo $itemdata->slide_id; ?>" data-url="<?php echo $itemdata->slide_id; ?>"><?php echo $this->translate('Sign Up') ?></a>
                </div>
                <?php } ?>
                <div class="seshtmlbackground_form sesbasic_clearfix cd-loginbox cd-loginbox-<?php echo $itemdata->slide_id; ?>">
                	<?php if(!$registerActive){ ?><div class="cd-signupform-heading"><?php echo $this->translate('Sign In'); ?></div> <?php } ?>
                  <?php echo $this->content()->renderWidget("seshtmlbackground.login-or-signup",array('id'=>$itemdata->slide_id,'registerActive'=>$registerActive)); ?>
                </div>
             <?php 
                $isLogin = true;
             } ?>
          	<?php  if($item->show_register_form){ ?>
                <div class="seshtmlbackground_form sesbasic_clearfix cd-signupform cd-signupform-<?php echo $itemdata->slide_id; ?>">
                  <?php if(!$isLogin){ ?>
                     <div class="cd-signupform-heading"><?php echo $this->translate("Sign Up")?></div>
                  <?php } ?>
                  <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "seshtmlbackground", array('disableContent'=>true,'id'=>$itemdata->slide_id,'isLogin'=>$isLogin)); ?>
                </div>
          	<?php } ?>
            </div>
          <?php } ?>
          <?php } ?>
          <?php 
          			$fullWidth = true;
            		if($item->show_register_form == 0 && $item->show_login_form == 0){
                    	$fullWidth = true;
          			 }else{
                 		if(Engine_Api::_()->user()->getViewer()->getIdentity() == 0)
                    	$fullWidth = false;
                     else
                     	 $fullWidth = true;
           				} 
          ?>
          <div class="<?php echo $fullWidth ? 'cd-full-width' : 'cd-half-width' ?>">
            <?php if($item->title != '' || $item->description != ''){ ?>	
              <?php if($item->title != ''){ ?>
                  <h2 style="color:#<?php echo $item->title_button_color; ?>;font-size:<?php echo  $item->title_font_size; ?>px !important;font-family:<?php echo $item->title_font_family;  ?>"><?php echo $this->translate($item->title); ?></h2>
              <?php } ?>
            <?php } ?>
            <?php if($item->description != ''){ ?>
                <p style="color:#<?php echo $item->description_button_color; ?>;font-size:<?php echo  $item->description_font_size; ?>px !important;font-family:<?php echo $item->description_font_family;  ?>"><?php echo $this->translate(nl2br($item->description)) ; ?></p>
            <?php } ?>
            <?php if($item->login_button && Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
              <a data-effect="" href="<?php echo $this->sesspectromedia ? '#small-dialog' : $this->layout()->staticBaseUrl.'login'; ?>" class="cd-btn <?php echo $this->sesspectromedia ? 'popup-with-move-anim data-effect-bg' : '' ?>"  onMouseOver="this.style.backgroundColor='#<?php echo $item->login_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->login_button_color; ?>'" style="color:#<?php echo $item->login_button_text_color; ?>; background-color:#<?php echo $item->login_button_color; ?>"><?php echo $this->translate($item->login_button_text); ?></a>
            <?php } ?>
            <?php if($item->signup_button && Engine_Api::_()->user()->getViewer()->getIdentity() == 0){ ?>
              <a  data-effect="" href="<?php echo $this->sesspectromedia ? '#user_signup_form' : $this->layout()->staticBaseUrl.'signup'; ?>" class="cd-btn secondary <?php echo $this->sesspectromedia ? 'popup-with-move-anim data-effect-bg' : '' ?>"  onMouseOver="this.style.backgroundColor='#<?php echo $item->signup_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->signup_button_color; ?>'" style="color:#<?php echo $item->signup_button_text_color; ?>;background-color:#<?php echo $item->signup_button_color; ?>"><?php echo $this->translate($item->signup_button_text); ?></a>
            <?php } ?>
            <?php if($item->extra_button){ ?>
              <a <?php if($item->extra_button_linkopen): ?> target='_blank' <?php endif; ?>  href="<?php echo $item->extra_button_link != '' ? $item->extra_button_link : 'javascript:void(0)'; ?>" class="cd-btn secondary"  onMouseOver="this.style.backgroundColor='#<?php echo $item->extra_button_mouseover_color; ?>'"   onMouseOut="this.style.backgroundColor='#<?php echo $item->extra_button_color; ?>'" style="color:#<?php echo $item->extra_button_text_color; ?>;background-color:#<?php echo $item->extra_button_color; ?>"><?php echo $this->translate($item->extra_button_text); ?></a>
            <?php } ?> 
          </div>
          <div class="overlay" <?php echo $style; ?>></div>
        </li>
   <?php } ?>
    <?php 
      $counter++;
        } ?>
      </ul> <!-- .cd-hero-slider -->
     <?php if($this->searchEnable){ ?>
        <div class="cd-slider-searchbox <?php echo ($this->paginator->getTotalItemCount() < 2 || !$this->thumbnail) ? '' : 'isnav' ?>" >
          <?php echo $this->content()->renderWidget('seshtmlbackground.search'); ?>
        </div>
     <?php } ?>
     <?php if($this->paginator->getTotalItemCount()>1 && $this->thumbnail == '1'): ?>
			<div class="cd-slider-nav thumbnail_nav cd-slider-nav<?php echo "_".$identity ?>" >
				<nav>
					<!--<span class="cd-marker item-1"></span>-->
					<ul>
					<?php $counter = 0; ?>
						<?php foreach($this->paginator as $item){ ?>
							<li class="<?php echo $counter == 0 ? 'selected' : ''; ?> " id="thumbnails">
								<a href="javascript:;" style="background-image:url(<?php echo $item->getFilePath('thumb_icon'); ?>)"></a>
							</li>
							<?php $counter++;
						} ?>
					</ul>
        </nav> 
      </div> <!-- .cd-slider-nav -->
			<?php elseif($this->paginator->getTotalItemCount()>1 && $this->thumbnail == '2'): ?>
			 <div class="cd-slider-nav bullets_nav cd-slider-nav<?php echo "_".$identity ?>" >
					<nav>
						<!--<span class="cd-marker item-1"></span>-->
						<ul>
						<?php $counter = 0; ?>
							<?php foreach($this->paginator as $item){ ?>
								<li class="<?php echo $counter == 0 ? 'selected' : ''; ?> " id="bullets">
									<a href="javascript:;" style="background-image:url(<?php echo $item->getFilePath('thumb_icon'); ?>)"></a>
								</li>
								<?php $counter++;
							} ?>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->
			<?php elseif($this->paginator->getTotalItemCount()>1 && $this->thumbnail == '3'): ?>
				<div class="cd-slider-nav lines_nav cd-slider-nav<?php echo "_".$identity ?>" >
					<nav>
						<!--<span class="cd-marker item-1"></span>-->
						<ul>
						<?php $counter = 0; ?>
							<?php foreach($this->paginator as $item){ ?>
								<li class="<?php echo $counter == 0 ? 'selected' : ''; ?> " id="lines">
									<a href="javascript:;" style="background-image:url(<?php echo $item->getFilePath('thumb_icon'); ?>)"></a>
								</li>
								<?php $counter++;
							} ?>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->
			<?php endif; ?>
    </section> 
     <script>
			<?php if($this->main_navigation): ?>
sesJqueryObject('#global_header').hide();
sesJqueryObject('.header_mini_menu').remove();
sesJqueryObject('.core_menu_mini_menu').remove();
<?php endif; ?>
			</script>
	 </div>
      <?php }else if($this->templateDesign == 1){  ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design1.tpl'; ?>
      <?php }else if($this->templateDesign == 2){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design2.tpl'; ?>
      <?php }else if($this->templateDesign == 3){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design3.tpl'; ?>
      <?php }else if($this->templateDesign == 4){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design4.tpl'; ?>
      <?php }else if($this->templateDesign == 5){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design5.tpl'; ?>
      <?php }else if($this->templateDesign == 6){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design6.tpl'; ?>
      <?php }else if($this->templateDesign == 7){ ?>
       <?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/design7.tpl'; ?>
      <?php } ?>
   
</div>  
<?php if($this->sesspectromedia){ ?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
	sesJqueryObject('.data-effect-bg').attr('data-effect',sesJqueryObject('#popup-login').attr('data-effect'));
});
</script>
<?php } ?>
<?php if($this->mini_navigation && !$this->sesspectromedia){ ?>
<script type='text/javascript'>
  var notificationUpdater<?php echo "_".$identity ?>;
  en4.core.runonce.add(function(){
    if($('global_search_field')){
      new OverText($('global_search_field'), {
        poll: true,
        pollInterval: 500,
        positionOptions: {
          position: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
          edge: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
          offset: {
            x: ( en4.orientation == 'rtl' ? -4 : 4 ),
            y: 2
          }
        }
      });
    }

    if($('notifications_markread_link')){
      $('notifications_markread_link').addEvent('click', function() {
        //$('notifications_markread').setStyle('display', 'none');
        en4.activity.hideNotifications('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
      });
    }

    <?php if ($this->updateSettings && $this->viewer->getIdentity()): ?>
    notificationUpdater<?php echo "_".$identity ?> = new NotificationUpdateHandler({
              'delay' : <?php echo $this->updateSettings;?>
            });
    notificationUpdater<?php echo "_".$identity ?>.start();
    window._notificationUpdater = notificationUpdater<?php echo "_".$identity ?>;
    <?php endif;?>
  });


  var toggleUpdatesPulldown<?php echo "_".$identity ?> = function(event, element, user_id) {
    if( element.className=='updates_pulldown' ) {
      element.className= 'updates_pulldown_active';
      showNotifications<?php echo "_".$identity ?>();
    } else {
      element.className='updates_pulldown';
    }
  }

  var showNotifications<?php echo "_".$identity ?> = function() {
    en4.activity.updateNotifications();
    new Request.HTML({
      'url' : en4.core.baseUrl + 'activity/notifications/pulldown',
      'data' : {
        'format' : 'html',
        'page' : 1
      },
      'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if( responseHTML ) {
          // hide loading icon
          if($('notifications_loading')) $('notifications_loading').setStyle('display', 'none');

          $('notifications_menu').innerHTML = responseHTML;
          $('notifications_menu').addEvent('click', function(event){
            event.stop(); //Prevents the browser from following the link.

            var current_link = event.target;
            var notification_li = $(current_link).getParent('li');

            // if this is true, then the user clicked on the li element itself
            if( notification_li.id == 'core_menu_mini_menu_update' ) {
              notification_li = current_link;
            }

            var forward_link;
            if( current_link.get('href') ) {
              forward_link = current_link.get('href');
            } else{
              forward_link = $(current_link).getElements('a:last-child').get('href');
            }

            if( notification_li.get('class') == 'notifications_unread' ){
              notification_li.removeClass('notifications_unread');
              en4.core.request.send(new Request.JSON({
                url : en4.core.baseUrl + 'activity/notifications/markread',
                data : {
                  format     : 'json',
                  'actionid' : notification_li.get('value')
                },
                onSuccess : function() {
                  window.location = forward_link;
                }
              }));
            } else {
              window.location = forward_link;
            }
          });
        } else {
          $('notifications_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new updates."));?>';
        }
      }
    }).send();
  };
</script>
<?php } ?>
<script type="application/javascript">
<?php if($this->full_height): ?>
function calculate_height(){
	var windowHeight = sesJqueryObject(window).height();
	sesJqueryObject('.cd-hero-slider<?php echo "_".$identity ?>').css('height',windowHeight+'px');
	sesJqueryObject('#seshtmlbackground_slideshow_wrapper_<?php echo $identity; ?>').css('height',windowHeight+'px');		
}
sesJqueryObject(window).resize(function() {
	calculate_height();
});
sesJqueryObject(document).ready(function(e){
		calculate_height();
});
<?php endif; ?>
var autoPlayId<?php echo "_".$identity ?>,firstVideoSrc<?php echo "_".$identity ?>=false,isOnRegister<?php echo "_".$identity ?> = false,IsfinishVideoNext<?php echo "_".$identity ?> = false,clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>,clearIntvalSesVideoSlideshow2<?php echo "_".$identity ?>,autoPlayDelay<?php echo "_".$identity ?> ;
jQuery(document).ready(function($){
	var slidesWrapper<?php echo "_".$identity ?> = $('.cd-hero-slider<?php echo "_".$identity ?>');
	//check if a .cd-hero-slider exists in the DOM onended=""
	if ( slidesWrapper<?php echo "_".$identity ?>.length > 0 ) {
		var primaryNav<?php echo "_".$identity ?> = $('.cd-primary-nav<?php echo "_".$identity ?>'),
			sliderNav<?php echo "_".$identity ?> = $('.cd-slider-nav<?php echo "_".$identity ?>'),
			navigationMarker = $('.cd-marker'),
			slidesNumber<?php echo "_".$identity ?> = slidesWrapper<?php echo "_".$identity ?>.children('li').length,
			visibleSlidePosition<?php echo "_".$identity ?> = 0;
		//upload videos (if not on mobile devices)
		uploadVideo<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>);
		//autoplay slider
		if(!firstVideoSrc<?php echo "_".$identity ?>)
			setAutoplay<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>, slidesNumber<?php echo "_".$identity ?>, autoPlayDelay<?php echo "_".$identity ?>);
		//on mobile - open/close primary navigation clicking/tapping the menu icon
		primaryNav<?php echo "_".$identity ?>.on('click', function(event){
			if($(event.target).is('.cd-primary-nav<?php echo "_".$identity ?>')) $(this).children('ul').toggleClass('is-visible');
		});
		//change visible slide
		sliderNav<?php echo "_".$identity ?>.on('click', 'li', function(event){
			event.preventDefault();
			var selectedItem = $(this);
			if(!selectedItem.hasClass('selected')) {
				// if it's not already selected
				var selectedPosition = selectedItem.index(),
					activePosition = slidesWrapper<?php echo "_".$identity ?>.find('li.selected').index();
				
				if( activePosition < selectedPosition) {
					nextSlide<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>.find('.selected'), slidesWrapper<?php echo "_".$identity ?>, sliderNav<?php echo "_".$identity ?>, selectedPosition);
				} else {
					prevSlide<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>.find('.selected'), slidesWrapper<?php echo "_".$identity ?>, sliderNav<?php echo "_".$identity ?>, selectedPosition);
				}
				//this is used for the autoplay
				visibleSlidePosition<?php echo "_".$identity ?> = selectedPosition;
				updateSliderNavigation<?php echo "_".$identity ?>(sliderNav<?php echo "_".$identity ?>, selectedPosition);
				updateNavigationMarker<?php echo "_".$identity ?>(navigationMarker, selectedPosition+1);
				//reset autoplay
				setAutoplay<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>, slidesNumber<?php echo "_".$identity ?>, autoPlayDelay<?php echo "_".$identity ?>);
				if(slidesWrapper<?php echo "_".$identity ?>.find('li.selected').hasClass('cd-bg-video')){
					 clearInterval(autoPlayId<?php echo "_".$identity ?>);
					 clearInterval(clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>);
					 clearInterval(clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>);	
				}
			}else if(slidesWrapper<?php echo "_".$identity ?>.children().length == 1 && slidesWrapper<?php echo "_".$identity ?>.children().eq(0).hasClass('cd-bg-video')){
				 slidesWrapper<?php echo "_".$identity ?>.eq(0).find('.cd-bg-video-wrapper').find('video').attr('loop','loop');
				  slidesWrapper<?php echo "_".$identity ?>.eq(0).find('.cd-bg-video-wrapper').find('video').get(0).play();
			}
		});
	}
	function nextSlide<?php echo "_".$identity ?>(visibleSlide, container, pagination, n){
		visibleSlide.removeClass('selected from-left from-right').addClass('is-moving').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			visibleSlide.removeClass('is-moving');
		});
		container.children('li').eq(n).addClass('selected from-right').prevAll().addClass('move-left');
		container.children('li').eq(n).find('.cd-signupform-container').show();
		checkVideo<?php echo "_".$identity ?>(visibleSlide, container, n);
	}
	function prevSlide<?php echo "_".$identity ?>(visibleSlide, container, pagination, n){
		visibleSlide.removeClass('selected from-left from-right').addClass('is-moving').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			visibleSlide.removeClass('is-moving');
		});
		container.children('li').eq(n).addClass('selected from-left').removeClass('move-left').nextAll().removeClass('move-left');
		checkVideo<?php echo "_".$identity ?>(visibleSlide, container, n);
	}
	function updateSliderNavigation<?php echo "_".$identity ?>(pagination, n) {
		var navigationDot = pagination.find('.selected');
		navigationDot.removeClass('selected');
		pagination.find('li').eq(n).addClass('selected');
	}
	function setAutoplay<?php echo "_".$identity ?>(wrapper,length,delay){
	 if(wrapper.hasClass('autoplay') && !isOnRegister<?php echo "_".$identity ?> && !IsfinishVideoNext<?php echo "_".$identity ?>){
			clearInterval(autoPlayId<?php echo "_".$identity ?>);
			autoPlayId<?php echo "_".$identity ?> = window.setInterval(function(){autoplaySlider<?php echo "_".$identity ?>(length)}, delay);
	 }
	}
	function autoplaySlider<?php echo "_".$identity ?>(length) {
		if( visibleSlidePosition<?php echo "_".$identity ?> < length - 1) {
			nextSlide<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>.find('.selected'), slidesWrapper<?php echo "_".$identity ?>, sliderNav<?php echo "_".$identity ?>, visibleSlidePosition<?php echo "_".$identity ?> + 1);
			visibleSlidePosition<?php echo "_".$identity ?> +=1;
		} else {
			prevSlide<?php echo "_".$identity ?>(slidesWrapper<?php echo "_".$identity ?>.find('.selected'), slidesWrapper<?php echo "_".$identity ?>, sliderNav<?php echo "_".$identity ?>, 0);
			visibleSlidePosition<?php echo "_".$identity ?> = 0;
		}
		updateNavigationMarker<?php echo "_".$identity ?>(navigationMarker, visibleSlidePosition<?php echo "_".$identity ?>+1);
		updateSliderNavigation<?php echo "_".$identity ?>(sliderNav<?php echo "_".$identity ?>, visibleSlidePosition<?php echo "_".$identity ?>);
	}
	function uploadVideo<?php echo "_".$identity ?>(container) {
		container.find('.cd-bg-video-wrapper').each(function(){
			var videoWrapper = $(this);
			if( videoWrapper.is(':visible') ) {
				// if visible - we are not on a mobile device 
				var	videoUrl = videoWrapper.data('video'),
				videoImage = videoWrapper.data('image');
					video = $('<video muted="muted"  onended="finishVideoNext<?php echo "_".$identity ?>()" <?php if($this->mute_video){ ?> muted="muted"; <?php } ?> ><source src="'+videoUrl+'" type="video/mp4" /></video><div class="cd-hero-slider-video-img" style="background-image:url('+videoImage+');"></div>');
				video.appendTo(videoWrapper);
				// play video if first slide
				if(videoWrapper.parent('.cd-bg-video.selected').length > 0) {
					 if(!Modernizr.touch){
							 sesJqueryObject(video).find('video').show();
							 video.get(0).play();
							 firstVideoSrc<?php echo "_".$identity ?> = true;
					 }else{
							sesJqueryObject(video).eq(0).hide();
							clearInterval(autoPlayId<?php echo "_".$identity ?>);
							autoPlayId<?php echo "_".$identity ?> = window.setInterval(function(){autoplaySlider<?php echo "_".$identity ?>(length)}, autoPlayDelay<?php echo "_".$identity ?>);
					 }
				};
			}
		});
	}
	function checkVideo<?php echo "_".$identity ?>(hiddenSlide, container, n) {
		//check if a video outside the viewport is playing - if yes, pause it
		var hiddenVideo = hiddenSlide.find('video');
		if( hiddenVideo.length > 0 ) hiddenVideo.get(0).pause();
		//check if the select slide contains a video element - if yes, play the video
		var visibleVideo = container.children('li').eq(n).find('video');
		if( visibleVideo.length > 0 ) { 
			clearInterval(autoPlayId<?php echo "_".$identity ?>);
			clearInterval(clearIntvalSesVideoSlideshow2<?php echo "_".$identity ?>);
			clearInterval(clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>);
			if(!Modernizr.touch){
					sesJqueryObject(visibleVideo).show();
					visibleVideo.get(0).play();
			 }else{
					sesJqueryObject(visibleVideo).hide();
					clearInterval(autoPlayId<?php echo "_".$identity ?>);
					autoPlayId<?php echo "_".$identity ?> = window.setInterval(function(){autoplaySlider<?php echo "_".$identity ?>(length)}, autoPlayDelay<?php echo "_".$identity ?>);
			}
		}else{
			IsfinishVideoNext<?php echo "_".$identity ?> = false;
		}
	}
	function updateNavigationMarker<?php echo "_".$identity ?>(marker, n) {
		marker.removeClassPrefix<?php echo "_".$identity ?>('item').addClass('item-'+n);
	}
	$.fn.removeClassPrefix<?php echo "_".$identity ?> = function(prefix) {
		//remove all classes starting with 'prefix'
	    this.each(function(i, el) {
	        var classes = el.className.split(" ").filter(function(c) {
	            return c.lastIndexOf(prefix, 0) !== 0;
	        });
	        el.className = $.trim(classes.join(" "));
	    });
	    return this;
	};
	
});
sesJqueryObject(document).ready(function(e){
	sesJqueryObject('#seshtmlbackground_form input,#seshtmlbackground_form,#signup_account_form input,#signup_account_form input[type=email]').each(
				function(index){
						var input = sesJqueryObject(this);
						if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().length && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
						  if(sesJqueryObject(this).prop('type') == 'email' || sesJqueryObject(this).prop('type') == 'text' || sesJqueryObject(this).prop('type') == 'password'){
								sesJqueryObject(this).attr('placeholder',sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').html());
								sesJqueryObject(this).removeAttr('tabindex');
							}
						}
				}
			)	
});
<?php if($this->autoplay){ ?>
sesJqueryObject("#seshtmlbackground_form, #user_form_login, .seshtmlbackground_pln_btn").mouseenter(function(e) {
	 clearInterval(autoPlayId<?php echo "_".$identity ?>);
	 clearInterval(clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>);
	 clearInterval(clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>);
	 isOnRegister<?php echo "_".$identity ?> = true;
}).mouseleave(function(e) {
   isOnRegister<?php echo "_".$identity ?> = false; 
	 if(IsfinishVideoNext<?php echo "_".$identity ?>){
	 	clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>=window.setTimeout(function(){finishVideoNext<?php echo "_".$identity ?>()}, 3000);
	 }else if(!sesJqueryObject('.cd-hero-slider<?php echo "_".$identity ?>').find('li.selected').hasClass('cd-bg-video')){
			clearIntvalSesVideoSlideshow1<?php echo "_".$identity ?>=window.setTimeout(function(){finishVideoNext<?php echo "_".$identity ?>()}, 3000);
		}
});
<?php } ?>
	<?php if($this->logo): ?>
		<?php if($this->logo_url){ ?>
			sesJqueryObject('#cd-logo<?php echo "_".$identity ?>').html('<div id="cd-logo" class="logo"><div><a href="/"><img src="<?php echo Engine_Api::_()->seshtmlbackground()->getFileUrl($this->logo_url); ?>"></a></div></div>');
		<?php }else{ ?>
			sesJqueryObject('#cd-logo<?php echo "_".$identity ?>').html(logoSeshtml<?php echo "_".$identity ?>);
		<?php } ?>
	<?php endif; ?>
<?php if($this->autoplay){ ?>
	function finishVideoNext<?php echo "_".$identity ?>(){
		if(isOnRegister<?php echo "_".$identity ?>){
				IsfinishVideoNext<?php echo "_".$identity ?> = true;
				clearIntvalSesVideoSlideshow2<?php echo "_".$identity ?> = window.setTimeout(function(){finishVideoNext<?php echo "_".$identity ?>()}, 5000);
				return;
		}
		IsfinishVideoNext<?php echo "_".$identity ?> = false;
		var indexSelectedVal = sesJqueryObject('.cd-slider-nav<?php echo "_".$identity ?>').find('li.selected').index();
		var totalLi = sesJqueryObject('.cd-slider-nav<?php echo "_".$identity ?>').find('nav').find('ul').children('li');
		if(indexSelectedVal >= totalLi.length - 1 ){
			indexSelectedVal = 0;
		}else
			indexSelectedVal++;
		sesJqueryObject(totalLi).eq(indexSelectedVal).trigger('click');
	}
<?php }else{ ?>
function finishVideoNext<?php echo "_".$identity ?>(){
	return true;	
}
<?php } ?>
</script>

<script>
if(sesJqueryObject('#tamp_mobile_menu_toggle').length){
  $('tamp_mobile_menu_toggle').addEvent('click', function(event){
    event.stop();
      $('temp_mobile_menu_container').addClass('show-menu');
      $('overlay_remove').addClass('hide-menu_div');
  });
}
if(sesJqueryObject('#overlay_remove').length){
  $('overlay_remove').addEvent('click', function(event){
    event.stop();
      $('temp_mobile_menu_container').removeClass('show-menu');
      $('overlay_remove').removeClass('hide-menu_div');
  });
}
if(sesJqueryObject('#close_menus').length){
  $('close_menus').addEvent('click', function(event){
    event.stop();
      $('temp_mobile_menu_container').removeClass('show-menu');
      $('overlay_remove').removeClass('hide-menu_div');
  });
}
</script>
