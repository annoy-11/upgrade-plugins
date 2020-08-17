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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/styles/design3.css'); ?>
  <div class="seshtmlbackground_slideshow_container">
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
    <section class="cd-hero sesbasic_bxs">
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
        <li class="cd-bg-video <?php echo $counter == 0 ? 'selected ' : '' ; ?>form-in-<?php echo $item->position_register_form == 'right' ? 'right' : 'left'; ?> cut_rectangle">
           <div class="overlay" <?php echo $style; ?>></div>
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
                  <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "seshtmlbackground", array('id'=>$itemdata->slide_id,'isLogin'=>$isLogin,'disableContent'=>true)); ?>
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
                <h2 style="color:#<?php echo $item->title_button_color; ?>;font-size:<?php echo  $item->title_font_size; ?>px;font-family:<?php echo $item->title_font_family;  ?>"><?php echo $this->translate($item->title); ?></h2>
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
          </div> <!-- .cd-bg-video-wrapper -->
        </li>
    <?php }else{ ?>
       <li class="<?php echo $counter == 0 ? 'selected' : '' ; ?> form-in-<?php echo $item->position_register_form == 'right' ? 'right' : 'left'; ?> cut_rectangle" style="background-image:url(<?php echo $item->getFilePath('file_id') ?>);">
         <div class="overlay" <?php echo $style; ?>></div>
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
                  <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "seshtmlbackground", array('id'=>$itemdata->slide_id,'isLogin'=>$isLogin,'disableContent'=>true)); ?>
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
                  <h2 style="color:#<?php echo $item->title_button_color; ?>;font-size:<?php echo  $item->title_font_size; ?>px;font-family:<?php echo $item->title_font_family;  ?>"><?php echo $this->translate($item->title); ?></h2>
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
        </li>
   <?php } ?>
    <?php 
      $counter++;
        } ?>
      </ul>
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
  </div>
  <script>
			<?php if($this->main_navigation): ?>
sesJqueryObject('#global_header').hide();
sesJqueryObject('.header_mini_menu').remove();
sesJqueryObject('.core_menu_mini_menu').remove();
<?php endif; ?>
			</script>