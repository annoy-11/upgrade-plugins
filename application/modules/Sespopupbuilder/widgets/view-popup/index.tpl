<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $popup = $this->popup; ?>
<?php $popupInactive = array(); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/animate.min.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/magnific-popup.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/scripts/jquery.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/scripts/jquery.magnific-popup.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/style.css'); ?>

<div class="sespopupbuilder_viewpopup sesbasic_bxs sesbasic_clearfix">
	<div class="sespopupbuilder_viewpopup_list">
		<ul class="view_multiplepopup">			
			<li class="animate_type">
				<h3>Select Animation Type</h3>
				<div class="animate_align">
					<div class="animation">
					  <input type="radio" id="control_01" name="transaction-select" value="mfp-zoom-in" checked>
						<label for="control_01"><span>Zoom In</span></label>
					</div>
					<div class="animation">
					  <input type="radio" id="control_02" name="transaction-select" value="mfp-newspaper" >
						<label for="control_02"><span>Newspaper</span></label>
					</div>
					<div class="animation">
					  <input type="radio" id="control_03" name="transaction-select" value="mfp-move-horizontal" >
						<label for="control_03"><span>Horizontal</span></label>
					</div>
					<div class="animation">
					  <input type="radio" id="control_04" name="transaction-select" value="mfp-move-from-top" >
						<label for="control_04"><span>Move From Top</span></label>
					</div>
					<div class="animation">
					  <input type="radio" id="control_05" name="transaction-select" value="mfp-3d-unfold" >
						<label for="control_05"><span>3D Unfold</span></label>
					</div>
					<div class="animation">
					  <input type="radio" id="control_06" name="transaction-select" value="mfp-zoom-out" >
						<label for="control_06"><span>Zoom Out</span></label>
					</div>
				</div>
			</li>
		<?php foreach($this->popup as $popup): ?>
		<?php require(APPLICATION_PATH.'/application/modules/Sespopupbuilder/views/scripts/_popup.tpl'); ?>
			<?php if($popup['popup_type'] == 'image'): ?>
				<li><a href="#" id="view_image">
					<img src="./application/modules/Sespopupbuilder/externals/images/image.png"/>
					<p>Image Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'html'): ?>
				<li><a href="#" id="view_html">
					<img src="./application/modules/Sespopupbuilder/externals/images/html.png"/>
				<p>HTML Popup</p>
			</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'video'): ?>
				<li><a href="#" id="view_video">
					<img src="./application/modules/Sespopupbuilder/externals/images/video.png"/>
					<p>Video Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'iframe'): ?>
				<li><a href="#" id="view_iframe">
					<img src="./application/modules/Sespopupbuilder/externals/images/iframe.png"/>
					<p>Iframe Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'facebook_like'): ?>
				<li><a href="#" id="view_facebook">
					<img src="./application/modules/Sespopupbuilder/externals/images/facebook.png"/>
					<p>Facebook-Like Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'pdf'): ?>
				<li><a href="#" id="view_pdf">
					<img src="./application/modules/Sespopupbuilder/externals/images/pdf.png"/>
					<p>PDF Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'age_verification'): ?>
				<li><a href="#" id="view_age">
					<img src="./application/modules/Sespopupbuilder/externals/images/age.png"/>
					<p>Age Verification Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'notification_bar'): ?>
				<li><a href="#" id="view_notification">
					<img src="./application/modules/Sespopupbuilder/externals/images/notification.png"/>
					<p>Notification Bar Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'cookie_consent'): ?>
				<li><a href="#" id="view_cookie">
					<img src="./application/modules/Sespopupbuilder/externals/images/cookie.png"/>
					<p>Cookie Consent Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'christmas'): ?>
				<li><a href="#" id="view_christmas">
					<img src="./application/modules/Sespopupbuilder/externals/images/christmas.png"/>
					<p>Christmas Popup</p>
				</a></li>
			<?php endif; ?>
			<?php if($popup['popup_type'] == 'count_down'): ?>
				<li><a href="#" id="view_countdown">
					<img src="./application/modules/Sespopupbuilder/externals/images/countdown.png"/>
					<p>Count Down Popup</p>
				</a></li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>
</div>


<script type="text/javascript">
var popup = <?php echo json_encode($this->popup);  ?>;
sespopupbuilderJqueryObject('.closepopup').click(function() {
    sespopupbuilderJqueryObject.magnificPopup.close();
 });
sespopupbuilderJqueryObject.each( popup, function( key, data) {
		var count = 0;
		if(data.close_button_position == '1'){
				var closebuttonposition = 'left: auto; right:-15px;';
			}else{
				var closebuttonposition = 'left: -15px; right:auto;';
			}
			if(data.close_button_width && data.close_button_width){
				var closeWidthHeight = 'line-height:'+data.close_button_height+'px;width:'+data.close_button_width+'px; height:'+data.close_button_height+'px;';
			}else{
				var closeWidthHeight = 'line-height:44px;width:44px; height:44px;';
			}
			if(data.close_button == '1'){
				if(data.when_close_popup == '1'){
					var popupclosebutton = '<button class="mpop-close" style="position: absolute; top: -15px; '+closebuttonposition+' bottom:auto; '+closeWidthHeight+'">x</button>';
				}else if(data.when_close_popup == '3'){
					var popupclosebutton = '<button class="close" style="position: absolute; top: -15px; '+closebuttonposition+' bottom:auto; '+closeWidthHeight+'overflow: visible;cursor: pointer;border: 0;-webkit-appearance: none;display: block;outline: none;padding: 0;z-index: 1046;opacity: 0.9;font-style: normal;font-size: 20px;background: #fff;border-radius: 50%;text-align: center;font-family: Arial, Baskerville, monospace;color: #333333;">x</button>';
					var closebuttonTimer = data.close_time;
					
					if(typeof closetimeoutCounter != "undefined"){
						clearInterval(closetimeoutCounter);
					}
					if(typeof timeoutCounter != "undefined"){
						clearInterval(timeoutCounter);
					}
				 closetimeoutCounter = setInterval(function(){
						closeseconds++;
						if(closeseconds == closebuttonTimer) {
							sespopupbuilderJqueryObject.magnificPopup.close();
							if(sespopupbuilderJqueryObject('.popupAudio')){
							 sespopupbuilderJqueryObject('.popupAudio').remove();
							}
							closeseconds = 0;
							OpenPopupTimer();
						}
					}, 1000);
					
				}else{
					var popupclosebutton = '<button class="close" style="position: absolute; top: -15px; '+closebuttonposition+' bottom:auto; '+closeWidthHeight+'overflow: visible;cursor: pointer;border: 0;-webkit-appearance: none;display: block;outline: none;padding: 0;z-index: 1046;opacity: 0.9;font-style: normal;font-size: 20px;background: #fff;border-radius: 50%;text-align: center;font-family: Arial, Baskerville, monospace;color: #333333;">x</button>';
				}
			}else{
				var popupclosebutton = '';
			}
			if(data.popup_opening_animation == '1'){
				var animationclass = " animated "+data.opening_type_animation;
			}else{
				var animationclass = ' animated';
			}
			
			var audioElement = sespopupbuilderJqueryObject('#popupAudio');
		if(data.popup_type == 'image'){
			
			sespopupbuilderJqueryObject('#view_image').magnificPopup({
				items: {
					src: '#image-popup'
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
			
		}else if(data.popup_type == 'html'){
			sespopupbuilderJqueryObject('#view_html').magnificPopup({
				items: {
					src: '#html-popup'
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}else if(data.popup_type == 'video'){
			sespopupbuilderJqueryObject('#view_video').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#video-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}else if(data.popup_type == 'age_verification'){
			sespopupbuilderJqueryObject('#view_age').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#ageverification',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}else if(data.popup_type == 'pdf'){
			sespopupbuilderJqueryObject('#view_pdf').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#pdf-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}else if(data.popup_type == 'iframe'){
			sespopupbuilderJqueryObject('#view_iframe').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#iframe-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline',
			}, 0);
			count++;
		}else if(data.popup_type == 'facebook_like'){
			sespopupbuilderJqueryObject('#view_facebook').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#facebook-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
		}, 0);
		count++;
		}else if(data.popup_type == 'notification_bar'){
			sespopupbuilderJqueryObject('#view_notification').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#notification-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject("html").addClass("sespopupbuilder_remove_overflow");
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject("html").hasClass("sespopupbuilder_remove_overflow")){
						sespopupbuilderJqueryObject("html").removeClass("sespopupbuilder_remove_overflow");
					}
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			
			count++;
		}else if(data.popup_type == 'cookie_consent'){
			sespopupbuilderJqueryObject('#view_cookie').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#cookie-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {

				
					open:function(){
						sespopupbuilderJqueryObject("html").addClass("sespopupbuilder_remove_overflow");
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject("html").hasClass("sespopupbuilder_remove_overflow")){
						sespopupbuilderJqueryObject("html").removeClass("sespopupbuilder_remove_overflow");
					}
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			
			count++;
		}else if(data.popup_type == 'count_down'){

           // var d = new Date(data.countdown_endtime.replace(' ', 'T'));
            var t = data.countdown_endtime.split(/[- :]/);
            // Apply each element to the Date function
            var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
            var countDownDate = new Date(d).getTime();
			var x = setInterval(function() {
				var now = new Date().getTime();
				var distance = countDownDate - now;
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
				+ minutes + "m " + seconds + "s ";
					if (distance < 0) {
						clearInterval(x);
						document.getElementById("countdown").innerHTML = "EXPIRED";
					}
			}, 1000);
			sespopupbuilderJqueryObject('#view_countdown').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#countdown-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}else if(data.popup_type == 'christmas'){
			sespopupbuilderJqueryObject('#view_christmas').magnificPopup({
				type:'inline',
				midClick: true,
				items: {
						src: '#christmas-popup',
				},
				closeOnContentClick: data.when_close_popup == '5' ? true : false,
				closeOnBgClick: data.when_close_popup == '2' ? true : false,
				closeBtnInside: true,
				showCloseBtn: true,
				enableEscapeKey: data.when_close_popup == '4' ? true : false,
				mainClass: animationclass,
				image: {
					verticalFit: true,
				},
				callbacks: {
					open:function(){
						sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+data.audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					}
				},
				removalDelay: 900,
				closeMarkup: popupclosebutton,
				fixedContentPos: "auto",
				fixedBgPos: "auto",
				overflowY: "auto",
				type: 'inline'
			}, 0);
			count++;
		}
		
	});
</script>