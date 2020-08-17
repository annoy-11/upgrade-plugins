<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( !$this->noForm ): ?>
  <?php echo $this->form->render($this) ?>
  <?php if( !empty($this->fbUrl) ): ?>
    <script type="text/javascript">
      var openFbLogin = function() {
        Smoothbox.open('<?php echo $this->fbUrl ?>');
      }
      var redirectPostFbLogin = function() {
        window.location.href = window.location;
        Smoothbox.close();
      }
    </script>
    <?php // <button class="user_facebook_connect" onclick="openFbLogin();"></button> ?>
  <?php endif; ?>
<?php else: ?>
  <?php echo $this->form->setAttrib('class', 'global_form_box no_form')->render($this) ?>
<?php endif; ?>


<script type="application/javascript">
<?php $sesloginpopup = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesloginpopup'); ?>
if('<?php echo $this->viewer()->getIdentity();?>' == 0 && '1' == <?php echo !$sesloginpopup ? 0 : 1 ?>) {
    ses(document).ready(function() {
		<?php $forcehide =  Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.popupfixed', false);    ?>
   	popUp=ses('.popup-with-move-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
				enableEscapeKey:<?php echo $forcehide ? "false" : "true" ; ?>,
				showCloseBtn:<?php echo $forcehide ? "false" : "true"; ?>,
				closeOnBgClick: <?php echo $forcehide ? "false" : "true"; ?>, // allow opening popup on middle mouse click. Always set it to true if you don\'t provide alternative source.
        closeBtnInside: true,
        preloader: true,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-slide-bottom'
      });
      if(ses(".payment_form_signup"))
      ses(".payment_form_signup").attr('action',en4.core.baseUrl + 'signup');
    });    
		
		ses.magnificPopup.instance.close = function () {
   var day = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.popup.day', 5);?>';
   if(day != 0)
			setCookie("is_popup_sesadv_header",'popo',day);
			sesJqueryObject(document.body).removeClass('login-signup-popup-open');
			ses.magnificPopup.proto.close.call(this);	
		}
		
		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#signup_account_form input,#signup_account_form input[type=email]').each(
						function(index){
								var input = jqueryObjectOfSes(this);
								if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
									if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
										jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
									}
								}
						}
					)	
		});

		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#sesadvancedheader_form_login input,#sesadvancedheader_form_login input[type=email]').each(
						function(index){
								var input = jqueryObjectOfSes(this);
								if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
									if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
										jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
									}
								}
						}
					)	
		});
		
  }
  
 // cookie get and set function
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var arianaires = "arianaires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + arianaires;
} 
function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
	}
	return "";
}
// end cookie get and set function.
var popUpShow=getCookie('is_popup_sesadv_header');
if('<?php echo $this->viewer()->getIdentity();?>' == 0 && popUpShow == '' && '<?php echo $actionName != 'login' ;?>' && '<?php echo $controllerName != 'signup' ;?>' && '<?php echo !$sesloginpopup ?>') {
	ses(document).ready(function() {
    if('<?php echo $showPopup;?>' == '1' && '<?php echo $enablePopUp ?>' == 1) 
		document.getElementById("popup-login").click(); 
	});
}
</script>
