<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _popup.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<style>
<?php if(count($popup)> 0) : ?>
<?php if($popup['opening_speed_animation']): ?>
	.mfp-zoom-in.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10?>s ease-in;
	}
	
	.mfp-newspaper.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10 ?>s ease-in;
	}
	.mfp-move-horizontal.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.mfp-move-from-top.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.mfp-3d-unfold.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.mfp-with-fade.mfp-ready .mfp-with-anim {
		transition: all <?php echo $popup['opening_speed_animation']/10 ?>s ease-in;
	}
	
<?php endif; ?>
<?php if($popup['closing_speed_animation']): ?>
	.mfp-with-fade.mfp-removing .mfp-with-anim {
		transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
	.mfp-3d-unfold.mfp-removing .mfp-with-anim {
	 transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
	.mfp-move-from-top.mfp-removing .mfp-with-anim {
		transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
	.mfp-move-horizontal.mfp-removing .mfp-with-anim {
		transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
	.mfp-zoom-in.mfp-removing .mfp-with-anim {
		transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
	.mfp-newspaper.mfp-removing .mfp-with-anim {
		transition: all <?php echo $popup['closing_speed_animation']/10 ?>s ease-out;
	}
<?php endif; ?>
<?php endif; ?>
<?php if($this->popup_inactive['closing_speed_animation']): ?>
	.inactive-popup.mfp-with-fade.mfp-removing .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
	.inactive-popup.mfp-3d-unfold.mfp-removing .mfp-with-anim {
	 transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
	.inactive-popup.mfp-move-from-top.mfp-removing .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
	.inactive-popup.mfp-move-horizontal.mfp-removing .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
	.inactive-popup.mfp-zoom-in.mfp-removing .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
	.inactive-popup.mfp-newspaper.mfp-removing .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['closing_speed_animation']/10 ?>s ease-out;
	}
<?php endif; ?>
<?php if($this->popup_inactive['opening_speed_animation']): ?>
	.inactive-popup.mfp-zoom-in.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10?>s ease-in;
	}
	
	.inactive-popup.mfp-newspaper.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10 ?>s ease-in;
	}
	.inactive-popup.mfp-move-horizontal.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.inactive-popup.mfp-move-from-top.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.inactive-popup.mfp-3d-unfold.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10 ?>s ease-in;
	}
	
	.inactive-popup.mfp-with-fade.mfp-ready .mfp-with-anim {
		transition: all <?php echo $this->popup_inactive['opening_speed_animation']/10 ?>s ease-in;
	}
<?php endif; ?>
</style>

<div class="sespopupbuilder_popup sesbasic_clearfix sesbasic_bxs" id="sespopupmain">
<?php
 
  $popup = !empty($this->popup_inactive) ? $this->popup_inactive : $popup;
 
	$idParam = !empty($this->idParam) ? $this->idParam : "";
	$style = 'style=';
	if($popup['popup_type'] == 'notification_bar'){
		if($popup['background_photo']){
				$backgroundImageSrc = Engine_Api::_()->storage()->get($popup['background_photo'], '')->getPhotoUrl();
				$style .= '"background:url('.$backgroundImageSrc.'); background-size:cover; background-position:center center;width:100%;height:auto;padding: 10px;margin:0 auto;"';
			}
		elseif(isset($popup['background'])&& $popup['background'] == '2'){
			$style .= '"background:#'.$popup['background_color'].'; background-size:cover; background-position:center center;width:100%;height:auto;padding: 10px;margin:0 auto;"';
		}else{
			$style .= '"background-size:cover; background-position:center center;width:100%;height:auto;padding: 10px;margin:0 auto;"';
		}
	}else{
		if(isset($popup['background']) && $popup['background'] == '1'){
			if($popup['background_photo']){
				$backgroundImageSrc = Engine_Api::_()->storage()->get($popup['background_photo'], '')->getPhotoUrl();
				$style .= '"background:url('.$backgroundImageSrc.'); background-size:cover; background-position:center center;';
				if($this->ismobile){
					$style .= 'width:90%;height:auto;';
				}else{
					if($popup['popup_responsive_mode']== '1'){
						$style .= 'width:'.$popup['custom_width'].'px; 
						height:'.$popup['custom_height'].'px; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px; max-width:'.$popup['max_width'].'px; max-height:'.$popup['max_height'].'px;';
					}else{
						$screen = $popup['responsive_size'] *10;
						$style .= 'width:'.$screen.'%; 
							height:auto; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px;  max-height:'.$popup['max_height'].'px;';
					}
				}
				$style .= 'padding: 10px;margin:0 auto;"';
			}
		}elseif(isset($popup['background'])&& $popup['background'] == '2'){
			$style .= '"background:#'.$popup['background_color'].';';
			if($this->ismobile){
				$style .= 'width:90%;height:auto;';
			}else{
				if($popup['popup_responsive_mode']== '1'){
					$style .= 'width:'.$popup['custom_width'].'px; 
						height:'.$popup['custom_height'].'px; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px; max-width:'.$popup['max_width'].'px; max-height:'.$popup['max_height'].'px;';
				}else{
					$screen = $popup['responsive_size']*10;
					$style .= 'width:'.$screen.'%; 
						height:auto; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px;  max-height:'.$popup['max_height'].'px;';
				}
			}
			$style .= 'padding: 10px;margin:0 auto;"';
		}else{
			if($this->ismobile){
				$style .= 'width:90%;height:auto;';
			}else{
				if($popup['popup_responsive_mode'] == '1'){
					$style .= '"width:'.$popup['custom_width'].'px; 
						height:'.$popup['custom_height'].'px; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px; max-width:'.$popup['max_width'].'px; max-height:'.$popup['max_height'].'px;';
				}else{
					$screen = $popup['responsive_size']*10;
					$style .= '"width:'.$screen.'%; 
						height:auto; min-width:'.$popup['min_width'].'px; min-height:'.$popup['min_height'].'px; max-height:'.$popup['max_height'].'px;';
				}
			}
			$style .= 'background:transparent;padding: 0px;margin:0 auto;"';
		}

		if(isset($popup['image'])){
			$mainImage = Engine_Api::_()->storage()->get($popup['image'], '')->getPhotoUrl();
			if($mainImage){
				$mainImageSrc = $mainImage;
			}else{
				$mainImageSrc = '#';
			}
		}else{
			$mainImageSrc = '#';
		}
	}
	
	?>

<?php if($popup['popup_type'] == 'image'): ?>
	<!-- ------------- IMAGE POPUP------------------------------------>
	<div id="image-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_image sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain"  >
			<img src="<?php  echo $mainImageSrc ?>"/>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'html'): ?>
	<!---------------------SIMPLE HTML POPUP-------------------------->
	<div id="html-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_html sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain">
			<div class="html_inner_iframe">
				<?php echo $popup['html']; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'video'): ?>
	<!--SIMPLE VIDEO POPUP-->
	<div id="video-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_video sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain">
			<?php echo $popup['video_code']; ?>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'pdf'): ?>
	<div id="pdf-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_pdf sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain">
		<?php	if(isset($popup['pdf_file'])){
		$pdf = Engine_Api::_()->storage()->get($popup['pdf_file'], "")->map();;
			if($pdf){ ?>
				<iframe src="<?php echo $this->absoluteUrl($pdf); ?>"
				width="800px" height="600px" ></iframe>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'iframe'): ?>
	<!--SIMPLE IFRAME POPUP-->
	<div id="iframe-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_iframe sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain">
			<?php echo $popup['iframe_url']; ?>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'notification_bar'): ?>

<div id="notification-popup<?php echo $idParam; ?>" <?php echo $style; ?>   class="sespopupbuilder_sticky_notification_bar sespopupbuilder_popup sespopupbuilder_popup_notification sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
  <div class="tip_content_section">  <p style="color:#<?php echo $popup['notification_font_color'] ?>"><strong><?php echo $popup['notification_text']?></strong></p>
 	</div>
 	<?php if($popup['notification_button_target']): ?>
				<?php $target = 'target="_blank"' ?>
			<?php else: ?>
			<?php $target = 'target=" "' ?>
			<?php endif; ?>
  <div class="tip-announce-icon"><a <?php echo $target ?> href="<?php echo $popup['notification_button_link'] ?>" class="use-ajax ajax-processed button" style="color:#fff;font-weight:bold"><?php echo $popup['notification_button_label'] ?></a>
  	<a href="javascript:void(0)" id="" class="mpop-close submit-btn button">Dismiss</a>
  </div>        
</div>
<?php endif; ?>

<?php if($popup['popup_type'] == 'facebook_like'): ?>
<!--FACEBOOK IFRAME POPUP-->
<div id="facebook-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_facebook sesbasic_clearfix sesbasic_bxs mfp-hide  mfp-with-anim" data-effect="fadeIn">
	<div class="sespopupbuilder_outermain">
		<?php	if(isset($popup['facebook_url'])){ ?>
			<?php echo $popup['facebook_url']; ?>
	<?php } ?>
	</div>
</div>
<?php endif;?>
<?php if($popup['popup_type'] == 'age_verification'): ?>
<?php //echo '<pre>';print_r($popup);die; ?>
	<!--SIMPLE AGE VERIFICATION POPUP-->
	<div id="ageverification<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_age sesbasic_clearfix sesbasic_bxs mfp-hide  mfp-with-anim" data-effect="fadeIn">
		<div class="sespopupbuilder_outermain">
			<div class="sespopupbuilder_age_body">
				<h3><?php echo $popup['text_verifiaction']?></h3>
			</div>
			<div class="sespopupbuilder_age_footer">
				<div class="age_btns">
				<?php if($popup['is_button_text'] != '1'): ?>
					<a href="javascript:void(0)" id="ageconfirm_button" class="closepopup submit-btn button">I am Over 18</a>
					<a href="javascript:void(0)" id="agedeny_button" class="closepopup close-btn button">Exit</a>
				<?php else: ?>
					<a href="javascript:void(0)" id="ageconfirm_button" class="closepopup submit-btn button"><?php echo $popup['first_button_verifiaction']  ?></a>
					<a href="javascript:void(0)" id="agedeny_button" class="closepopup close-btn button"><?php echo $popup['second_button_verifiaction']  ?></a></a>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif;?>
<?php if($popup['popup_type'] == 'contact'): ?>
	<!--CONTACT FORM POPUP-->
	<div id="contact-popup<?php echo $idParam; ?>" class="sespopupbuilder_popup sespopupbuilder_popup_contact sesbasic_clearfix sesbasic_bxs white-popup mfp-hide">
		<div class="sespopupbuilder_outermain">
			<div class="sespopupbuilder_contact_header">
				<h4>Contact Form</h4>
			</div>
			<div class="sespopupbuilder_contact_body">
				<form>
					<div class="_contact_group">
						<label for="name">Name</label>
						<input type="text" id="name" name="name" placeholder="Your Name">
					</div>
					<div class="_contact_group">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" placeholder="Your Email">
					</div>
					<div class="_contact_group">
						<label for="mobileno">Mobile Number</label>
						<input type="text" id="mobileno" name="mobileno" placeholder="Your Mobile No">
					</div>
					<div class="_contact_group">
						<label for="message">Message</label>
						<textarea id="message" name="message" placeholder="Send Message"></textarea>
					</div>
					<div class="_contact_group">
						<div class="contact_submit">
							<a href="javascript:void(0)" class="submit-btn button">Submit</a>
							<a href="javascript:void(0)" class="close-btn button">Close</a>
						</div>
					</div>
				</form>
			</div>
			<div class="sespopupbuilder_contact_footer">
				
			</div>
		</div>
	</div>
<?php endif;?>	
<?php if($popup['popup_type'] == 'cookie_consent'): ?>
<!--COOKIE CONSENT POPUP-->
<div id="cookie-popup<?php echo $idParam; ?>" <?php echo $style; ?> class="sespopupbuilder_popup sespopupbuilder_popup_cookie sesbasic_clearfix sesbasic_bxs mfp-hide mfp-with-anim" data-effect="fadeIn">
<div class="sespopupbuilder_outermain">
	<?php echo $popup['cookies_description']; ?>
	<div class="sespopupbuilder_cookie_footer">
		<div class="cookie_btns">
			<?php if($popup['cookie_button']): ?>
					<a href="javascript:void(0)" id="cookie-button" class="closepopup submit-btn button"><?php echo $popup['cookies_button_title'] ?></a>
			<?php else: ?>
				<a href="javascript:void(0)" id="cookie-button" class="closepopup submit-btn button">Ok</a>
			<?php endif; ?>
		</div>
	</div>
</div>
</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'count_down'): ?>
	<!--COUNTDOWN POPUP-->
	<div id="countdown-popup<?php echo $idParam; ?>" class="sespopupbuilder_popup sespopupbuilder_popup_countdown  sesbasic_clearfix sesbasic_bxs white-popup mfp-hide mfp-with-anim" data-effect="fadeIn" <?php echo $style; ?> >
	<div class="sespopupbuilder_outermain">
  		<div class="sespopupbuilder_countdown_body">
  			<p id="countdown"></p>
  			<p><?php echo $popup['coundown_description'] ?></p>
  		</div>
		</div>
	</div>
<?php endif; ?>
<?php if($popup['popup_type'] == 'christmas'): ?>
	<!--COUNTDOWN POPUP-->
	<div id="christmas-popup<?php echo $idParam; ?>" class="sespopupbuilder_popup sespopupbuilder_popup_christmas  sesbasic_clearfix sesbasic_bxs white-popup mfp-hide mfp-with-anim" data-effect="fadeIn" <?php echo $style; ?> >
		<div class="sespopupbuilder_outermain">
				<p><?php echo $popup['christmas_description'] ?></p>
				<?php if($popup['christmas_image1_check'] == '1'):
				$Image1 = Engine_Api::_()->storage()->get($popup['christmas_image1_upload'], '');
				if($Image1){
					$image1Src = $Image1->getPhotoUrl();
					
				}else{
					$image1Src = '#';
				}
				?>
				<img src="<?php echo $image1Src ?>" alt="" class="christmas_image1"/>
				<?php else: ?>
				
				<img src="<?php echo './application/modules/Sespopupbuilder/externals/images/'.$popup['christmas_image1_select'] ?>" alt="" class="image_christmas"/>
				
				<?php endif; ?>
				
				<?php if($popup['christmas_image2_check'] == '1'): 
				$Image2 = Engine_Api::_()->storage()->get($popup['christmas_image2_upload'], '');
				if($Image2){
					$image2Src = $Image2->getPhotoUrl();
				}else{
					$image2Src = '#';
				}
				?>
				<img src="<?php echo $image2Src ?>" alt="" class="christmas_image2"/>
				<?php else: ?>
				<img src="<?php echo './application/modules/Sespopupbuilder/externals/images/'.$popup['christmas_image2_select'] ?>" alt="" class="image_newyear"/>
				
				<?php endif; ?>
			</div>
	</div>
<?php endif; ?>		
</div>