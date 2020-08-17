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
<?php $popupInactive = $this->popupInactive; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/animate.min.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/magnific-popup.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/scripts/jquery.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/scripts/jquery.magnific-popup.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespopupbuilder/externals/styles/style.css'); ?>

<?php require(APPLICATION_PATH.'/application/modules/Sespopupbuilder/views/scripts/_popup.tpl'); ?>

<?php 
	if($popupInactive){
	 echo $this->partial('_popup.tpl','sespopupbuilder',array('popup_inactive'=>$popupInactive,'idParam'=>'-inactive'));
	}

?>

<?php 
    if($popup['popup_sound_file']):
            $popupaudio = Engine_Api::_()->storage()->get($popup['popup_sound_file'], "")->map();  
    else: 
        $popupaudio ='';
    endif; 
?>

<?php 
    if(@$popupInactive['popup_sound_file']):
            $popupInactiveaudio = Engine_Api::_()->storage()->get($popupInactive['popup_sound_file'], "")->map();
            else: 
        $popupInactiveaudio ='';  
endif; 
?>
<?php $popupjson = json_encode($popup); ?>
<?php $popupInactivejson = json_encode($popupInactive); ?>

<script type="text/javascript">
	sespopupbuilderJqueryObject('.closepopup').click(function() {
    sespopupbuilderJqueryObject.magnificPopup.close();
 	});
var sespopupbuilder = <?php echo $popupjson ?>;
var sespopupbuilderInactive = <?php echo $popupInactivejson ?>; 
var sespopupbuilderaudio = '<?php echo $popupaudio;  ?>';
var sespopupbuilderInactiveaudio = '<?php echo $popupInactiveaudio;  ?>';
var closetimeoutCounter;
//--------- inactivity -------------//
var inactiveseconds = 0;
var closeseconds = 0;
var timeoutCounter;
function OpenPopupTimer(){
	if(typeof timeoutCounter != "undefined"){
		clearInterval(timeoutCounter);
	}
	if(typeof closetimeoutCounter != "undefined"){
		clearInterval(closetimeoutCounter);
	}
	 timeoutCounter = setInterval(function(){ 
			inactiveseconds++;
			if(inactiveseconds == popupTimer) {
				if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
				}
				openPopUp(sespopupbuilderInactive,'inactive-popup','-inactive',sespopupbuilderInactiveaudio);
				 inactiveseconds = 0;
				 closeseconds = 0 ;
			}
		}, 1000);
}
var popupTimer = 0;
	if(sespopupbuilderInactive != null){
	 popupTimer = sespopupbuilderInactive.after_inactivity_time;
		OpenPopupTimer();
		sespopupbuilderJqueryObject(document).on('click load mousemove mousedown touchstart keypress scroll scroll', function (e) {
			inactiveseconds = 0;
			closeseconds = 0;
		});
	}
	if(sespopupbuilder != null){
		
		if(sespopupbuilder['whenshow']== '2'){
			sespopupbuilderJqueryObject(document).click(function() {
				openPopUp(sespopupbuilder,'','',sespopupbuilderaudio);
			});
		}else if(sespopupbuilder['whenshow'] == '3'){
			sespopupbuilderJqueryObject(document).scroll(function() {
				
				openPopUp(sespopupbuilder,'','',sespopupbuilderaudio);
			});
		}
		else if(sespopupbuilder['whenshow'] == '1' ){
			sespopupbuilderJqueryObject(document).ready(function() {
				
				openPopUp(sespopupbuilder,'','',sespopupbuilderaudio);
			});
		}else if(sespopupbuilder['whenshow'] == '6'){
			var currentPageUrl = window.location.href;
			var urls = sespopupbuilder.showspecicurl;
			var temp = new Array();
			temp = urls.split(",");
			if(temp.length > 0){
				sespopupbuilderJqueryObject.each(temp, function(key,val) {
					if(val == currentPageUrl){
						openPopUp(sespopupbuilder,'','',sespopupbuilderaudio);
					}
				});
			}
		}
	}
	
	function openPopUp(data,classNameInactive = '',idParams = '',audio = ''){
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
					var popupclosebutton = '<button class="close" style="position: absolute; top: -15px; '+closebuttonposition+' bottom:auto; '+closeWidthHeight+'overflow: visible;cursor: pointer;border: 0;-webkit-appearance: none;display: block;outline: none;padding: 0;z-index: 1046;opacity: 0.9;font-style: normal;font-size: 20px;background: #fff;border-radius: 50%;text-align: center;color: #333333;">x</button>';
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
				var animationclass = classNameInactive+" animated "+data.opening_type_animation;
			}else{
				var animationclass = classNameInactive+' animated';
			}
			var audioElement = sespopupbuilderJqueryObject('#popupAudio');
		if(data.popup_type == 'image'){
			
			sespopupbuilderJqueryObject.magnificPopup.open({
				items: {
					src: '#image-popup'+idParams
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				items: {
					src: '#html-popup'+idParams
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#video-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#ageverification'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#pdf-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#iframe-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#facebook-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#notification-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#cookie-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
						}
						sespopupbuilderJqueryObject("html").addClass("sespopupbuilder_remove_overflow");
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
					},
					close: function(){
						if(sespopupbuilderJqueryObject('.popupAudio')){
						 sespopupbuilderJqueryObject('.popupAudio').remove();
						}
					if(sespopupbuilderJqueryObject("html").hasClass("sespopupbuilder_remove_overflow")){
						sespopupbuilderJqueryObject("html").removeClass("sespopupbuilder_remove_overflow");
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#countdown-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
			sespopupbuilderJqueryObject.magnificPopup.open({
				type:'inline',
				midClick: true,
				items: {
						src: '#christmas-popup'+idParams,
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
						if(sespopupbuilderJqueryObject('.popupAudio')){
							sespopupbuilderJqueryObject('.popupAudio').remove();
					}
						sespopupbuilderJqueryObject('#sespopupmain').append('<iframe src="'+audio+'" allow="autoplay" style="display:none" class="popupAudio" id="popupAudio"></iframe>');
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
		
		sespopupbuilderJqueryObject('.mfp-bg').css('opacity',data.backgroundoverlay_opicity/10);
		if((count > 0 && data['whenshow'] != '5' && data['how_long_show'] != 'everytime') || (count > 0 && data['whenshow'] != '5' && data['how_long_show'] == 'everytime' && data['popup_visibility_duration'] > '0')){
			
			var popupid = data.popup_id;
			var url = en4.core.baseUrl + 'admin/sespopupbuilder/manage/showincrease/popup_id/' + popupid;
			sesJqueryObject.ajax({
				url:url,
				type: "POST",
				contentType:false,
				processData: false,
				cache: false,
				data: {
					'popup_id':popupid,
				},
				success: function(data) {
					
				}
			});
    }
	}
	
	
</script>

