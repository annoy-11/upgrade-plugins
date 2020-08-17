<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _emailhtml.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $result = $this->result; ?>
<?php $bodyTextTemplate = $this->body; ?>
<?php $id = $this->id; ?>
<?php $title = Engine_Api::_()->getApi('settings', 'core')->getSetting('core_general_site_title', $this->translate('_SITE_TITLE'));
$photoUrl = null;
 ?>


<?php 
		if($result->header_logo && Engine_Api::_()->storage()->get($result->header_logo, '')){
			$image = Engine_Api::_()->storage()->get($result->header_logo, '')->getPhotoUrl();
		}
		$socialIcons = (explode(",", $result->footer_social_icons));
		if($result->header_logo_align == '1'){
			$headerlogoAlign = 'left';
		}
		else if($result->header_logo_align == '3'){
			$headerlogoAlign = 'right';
		}
		if($result->header_emailphone_align == '1'){
			$emailphoneAlign = 'left';
		}else if($result->header_emailphone_align == '2'){
			$emailphoneAlign = 'right';
		}
		if($result->tagline_text_alignment == '1'){
			$taglineTextAlign = 'left';
		}else if($result->tagline_text_alignment == '2'){
			$taglineTextAlign = 'center';
		}else if($result->tagline_text_alignment == '3'){
			$taglineTextAlign = 'right';
		}
		if($result->footer_text_alignment == '1'){
			$footerTextAlign = 'left';
		}else if($result->footer_text_alignment == '2'){
			$footerTextAlign = 'center';
		}else if($result->footer_text_alignment == '3'){
			$footerTextAlign = 'right';
		}
	
		$view = Zend_Registry::get('Zend_View');
		$unsubscribe = $view->absoluteUrl('members/settings/notifications/id/'.$id);
		//echo '<pre>';print_r($unsubscribe);die;
		if($image)
		$photoUrl = $view->absoluteUrl($image);
		$facebookUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/facebook.png');
		$twitterUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/twitter.png');
		$pinterestUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/pinterest.png');
		$coloredUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/call_colored.png');
		$lightUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/call_light.png');
		
		$flickrUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/flickr.png');
		$globecoloredUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/globe_colored.png');$globelightUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/globe_light.png');
		if($result->footer_social_icons_type == '1'){
			$call_coloredUrl = $lightUrl ;
			$globe_coloredUrl= $globelightUrl ;
		}else{
			$call_coloredUrl =$coloredUrl ;
			$globe_coloredUrl= $globecoloredUrl ;
		} 
		$gplusUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/gplus.png');
		$instagramUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/instagram.png');
		$linkedinUrl = $view->absoluteUrl('/application/modules/Emailtemplates/externals/images/linkedin.png');
		if($result->header_emailphone_show != '1'){ 
			if($result->header_logo_align == '1'){
				$headerlogoAn = 'style="float:left;"';
			}else if($result->header_logo_align == '2'){
				$headerlogoAn = 'style="float:none;margin:0 auto;text-align:center;"';
			}
			else if($result->header_logo_align == '3'){
				$headerlogoAn = 'style="float:right;"';
			}
		}
		?>
			
		<!DOCTYPE HTML><html>
			<head>
				<title></title>
				<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
			</head>
			<body>
			<?php 
				$divstyle = 'style="background-color:#'.$result->mail_background_color.';padding:'.$result->mail_padding_topbottom.'px '.$result->mail_padding_rightleft.'px;"';
			?>
			<div <?php echo $divstyle; ?>>
			<table class="emailer_template" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#fff" style="width:100%; max-width:700px;">
			<tbody>
			<?php if($result->tagline_position == '1'){ ?>
				<tr class="tagline">
					<td align="center" valign="top">
						<table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:<?php echo $result->tagline_padding ?>px;border:<?php echo $result->tagline_border_Width ?>px <?php echo $result->tagline_border_style ?> #<?php echo $result->tagline_border_color ?>; background-color:#<?php echo $result->tagline_background_color ?> ;box-sizing: border-box; display: table;  color:#<?php echo $result->tagline_font_color ?>; font-family:'Open Sans', sans-serif; font-size:16px;">
							<tbody>
								<tr>
									<td class="blackBgcolor" data-bgcolor="Inner Background Color" align="<?php echo $taglineTextAlign ?>" valign="top">
									<?php echo $result->tagline_content ?>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr class="header">
				
					<td style="padding:<?php echo $result->header_padding ?>px;border:<?php echo $result->header_border_Width ?>px <?php echo $result->header_border_style ?> #<?php echo $result->header_border_color ?>; background-color:#<?php echo $result->header_background_color ?>; box-sizing: border-box;width:100%;">
					<?php if($result->header_emailphone_show != '1'){ 					?>
						<div <?php echo $headerlogoAn ?>>
								<?php if($photoUrl){ ?>
								<img src="<?php echo $photoUrl ?>" alt="" style="display:inline-block; border:0; max-height: 55px; width:auto;" class="image_target">
								<?php }else{ 
									echo $title;
								}?>
						</div>
					<?php }else{ ?>
						<div style="float:<?php echo $headerlogoAlign ?>;">
								<?php if($photoUrl){ ?>
									<img src="<?php echo $photoUrl ?>" alt="" style="display:inline-block; border:0; max-height: 55px; width:auto;" class="image_target">
								<?php }else{ 
									echo $title;
								}?>
						</div>
						<div style="float:<?php echo $emailphoneAlign ?>; margin-top:8px;}">
							<div style="margin-bottom:5px;">
								<span align="left" valign="center" width="auto">
									<img src="<?php echo $globe_coloredUrl ?>" width="" alt="" style="border:0; margin-right:7px; width:17px; height:auto; object-fit:contain; float:left;" class="">
								</span>
								<span align="left" valign="center" span style="font-family:'Open Sans', sans-serif; font-size:13px; font-weight:500;  line-height:15px;"><a href="mailto:<?php echo $result->header_mail ?>" style="color:#<?php echo $result->font_color_textemailphone;  ?>; text-decoration:none;" target="_blank"><?php echo $result->header_mail ?></a></span>
							</div>
							<div>
								<span align="left" valign="top">
									<img src="<?php echo $call_coloredUrl ?>" width="" alt="" style="border:0; margin-right:7px; width:17px; height:auto; object-fit:contain; float:left;" class=""></span>
								<span align="left" valign="top" style="font-family:'Open Sans', sans-serif; font-size:13px; font-weight:500; color:#<?php echo $result->font_color_textemailphone;  ?>; line-height:15px;"><?php echo $result->header_phone ?></span>
							</div>
						</div>
					<?php } ?>
								
					</td>	
				</tr>
				<tr style="clear:both;"></tr>
			<?php }else{ ?>
				<tr class="header">
					<td style="padding:<?php echo $result->header_padding ?>px;border:<?php echo $result->header_border_Width ?>px <?php echo $result->header_border_style ?> #<?php echo $result->header_border_color ?>; background-color:#<?php echo $result->header_background_color ?>; box-sizing: border-box;width:100%;">
					<?php if($result->header_emailphone_show != '1'){ ?>
						<div <?php echo $headerlogoAn ?>>
								<?php if($photoUrl){ ?>
									<img src="<?php echo $photoUrl ?>" alt="" style="display:inline-block; border:0; max-height: 55px; width:auto;" class="image_target">
								<?php }else{ 
									echo $title;
								}?>
						</div>
					<?php }else{ ?>
						<div style="float:<?php echo $headerlogoAlign ?>;">
								<?php if($photoUrl){ ?>
									<img src="<?php echo $photoUrl ?>" alt="" style="display:inline-block; border:0; max-height: 55px; width:auto;" class="image_target">
								<?php }else{ 
									echo $title;
								}?>
						</div>
						<div style="float:<?php echo $emailphoneAlign ?>; margin-top:8px;">
							<div style="margin-bottom:5px;">
								<span align="left" valign="center" width="auto">
									<img src="<?php echo $globe_coloredUrl ?>" width="" alt="" style="border:0; margin-right:7px;  width:17px; height:auto; object-fit:contain; float:left;" class="">
								</span>
								<span align="left" valign="center" span style="font-family:'Open Sans', sans-serif; font-size:13px; font-weight:500; color:#<?php echo $result->font_color_textemailphone;  ?>; line-height:15px;"><a href="mailto:<?php echo $result->header_mail ?>" style="color:#<?php echo $result->font_color_textemailphone;  ?>; text-decoration:none;" target="_blank"><?php echo $result->header_mail ?></a></span>
							</div>
							<div>
								<span align="left" valign="top">
									<img src="<?php echo $call_coloredUrl ?>" width="" alt="" style="border:0; margin-right:7px;  width:17px; height:auto; object-fit:contain; float:left;" class="">
								</span>
								<span align="left" valign="top" style="font-family:'Open Sans', sans-serif; font-size:13px; font-weight:500; color:#607d8b; line-height:15px;color:#<?php echo $result->font_color_textemailphone;  ?>;"><?php echo $result->header_phone ?>
								</span>
							</div>
						</div>
					<?php } ?>
					</td>	
				</tr>
				<tr style="clear:both;"></tr>
				<tr class="tagline">
					<td align="center" valign="top">
						<table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:<?php echo $result->tagline_padding ?>px;border:<?php echo $result->tagline_border_Width ?>px <?php echo $result->tagline_border_style ?> #<?php echo $result->tagline_border_color ?>; background-color:#<?php echo $result->tagline_background_color ?> ;box-sizing: border-box; display: table; color:#<?php echo $result->tagline_font_color ?>; font-family:'Open Sans', sans-serif; font-size:16px;">
							<tbody>
								<tr>
									<td class="blackBgcolor" data-bgcolor="Inner Background Color" align="<?php echo $taglineTextAlign ?>" valign="top">
									<?php echo $result->tagline_content ?>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<?php } ?>
				
				<tr>
					<td align="left" valign="top"  style="padding:<?php echo $result->body_padding ?>px;border:<?php echo $result->body_border_Width ?>px <?php echo $result->body_border_style ?> #<?php echo $result->body_border_color ?>; color:#<?php echo $result->body_text_color; ?>;background-color:#<?php echo $result->body_background_color ?> ">
					<table>
						<thead></thead>
							<tbody>
								<tr>
									<td><?php echo $bodyTextTemplate ?></td>
								</tr>
							</tbody>
					</table>
					</td>
				</tr>
				<!--Footer-->
				<tr>
					<td bgcolor="ffffff" style="padding:<?php echo $result->footer_padding ?>px;border:<?php echo $result->footer_border_Width ?>px <?php echo $result->footer_border_style	?> #<?php echo $result->footer_border_color ?>; background-color:#<?php echo $result->footer_background_color ?>;">
						<table width="100%" cellspacing="0" cellpadding="0" >
							<tbody>
								<tr>
									<td style="padding:0 0 14px 0" align="<?php echo $footerTextAlign ?>">
										<?php if(in_array('Facebbok',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.facebook.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $facebookUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Facebook"/></a>
										<?php	} ?>
										<?php if(in_array('Twitter',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.twitter.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $twitterUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Twitter"/></a>
										<?php } ?>
										<?php if(in_array('Linkedin',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.linkedin.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $linkedinUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="LinkedIn"/></a>
										<?php } ?>
										<?php if(in_array('instagram',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.instagram.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $instagramUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Instagram"/></a>
										<?php } ?>
										<?php if(in_array('Google Plus',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.googleplus.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $gplusUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Facebook"/></a>
										<?php } ?>
										<?php if(in_array('Pinterest',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.pinterest.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $pinterestUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Pinterest"/></a>
										<?php } ?>
										<?php if(in_array('Flickr',$socialIcons)){ ?>
												<a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('emailtemplates.flickr.url','#') ?>" style="padding:1px 7px;" target="_blank"><img src="<?php echo $flickrUrl ?>" style="width:35px; height:35px; object-fit: contain;" alt="Flickr"/></a>
										<?php } ?>
												<!-- <span style="width:175px;margin:8px 0 0 0;padding:7px 0 0 0;border-top:1px solid #000000;display:block"></span> -->
                        <span style="font-family: 'Open Sans',sans-serif;"><?php $view->translate('Stay in Touch With Us') ?></span>
									</td>
								</tr>
								<tr>
									<?php if(!$this->is_signature){ ?>
									<td style="padding:0 0 16px 0;color:#191919;font-family: 'Open Sans',sans-serif;" align="<?php echo $footerTextAlign ?>">
											<span style="font-size:14px;color:#000000;line-height:18px;display:block; margin-bottom: 5px;"><?php $view->translate('For any queries, drop an email to') ?><a style="color:#000;text-decoration:none" href="mailto:<?php echo $result->header_mail ?>" target="_blank"> <?php echo $result->header_mail ?></a></span>
											<span style="font-size:12px;color:#000000;line-height:18px;display:block;"><?php $view->translate('If you find our email in spam, please move it to inbox to receive important communication.') ?></span>
											<span style="font-size:12px;color:#000000;line-height:18px;display:block; margin-top:10px;">If you Don\'t want to recieve these emails <a href="<?php echo $view->absoluteUrl('/members/settings/notifications/id/'.$id); ?>" style="color:#607d8b; text-decoration: none;"><?php $view->translate('Unsubscribe') ?></a>

											</span>
									</td>
									<?php }else{ ?>
									<td align="<?php echo $footerTextAlign ?>">
									<?php echo $this->signature; ?>
									</td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
    </table>
		</div>
	</body>
</html>
