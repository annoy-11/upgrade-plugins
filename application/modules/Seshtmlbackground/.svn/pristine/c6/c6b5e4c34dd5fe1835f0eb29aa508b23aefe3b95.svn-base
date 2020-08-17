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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/styles/design2.css'); ?>
  <div class="seshtmlbackground_slideshow_container">
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
        <li class="cd-bg-video <?php echo $counter == 0 ? 'selected ' : '' ; ?>">
          <div class="overlay" <?php echo $style; ?>></div>
          <div class="cd-full-width animated bounce" style="animation-duration: 2.5s; animation-delay: 2s;">
           <div class="banner_transparent_bg">
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
          </div>
          <div class="cd-bg-video-wrapper" data-image="<?php echo $item->getFilePath('thumb_icon'); ?>" data-video="<?php echo $item->getFilePath('file_id'); ?>">
          </div> <!-- .cd-bg-video-wrapper -->
        </li>
    <?php }else{ ?>
       <li class="<?php echo $counter == 0 ? 'selected' : '' ; ?>" style="background-image:url(<?php echo $item->getFilePath('file_id') ?>);">
       <div class="overlay" <?php echo $style; ?>></div>
          <div class="cd-full-width animated bounce" style="animation-duration: 2.5s; animation-delay: 2s;">
            <div class="banner_transparent_bg">
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