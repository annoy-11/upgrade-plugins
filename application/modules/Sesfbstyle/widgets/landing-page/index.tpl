<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/sesfbstyle/landing_page.css'); ?>
<div class="landingpage_main sesbasic_bxs sesbasic_clearfix">
	<div class="landing_page_sign_up_main">
  <?php if(isset($_COOKIE['ses_login_users'])) { ?>
   <div class="recent_login_section">
     <div class="recent_login_head">
        <h2><?php echo $this->translate("Recent logins"); ?></h2>
        <p><?php echo $this->translate("Click your picture or add an account."); ?></p>
     </div>
     <div class="recent_members_data">
      <?php $recent_login = Zend_Json::decode($_COOKIE['ses_login_users']); ?>
        <?php if(count($recent_login) > 0) { ?>
          <?php foreach($recent_login as $users) {
            $userArray = explode("_", $users);
            $user = Engine_Api::_()->getItem('user', $userArray[0]);
          ?>
          <div id="recent_login_<?php echo $user->getIdentity(); ?>" class="member_item">
           <!-- <a onclick="loginAsFbstyleUser('<?php /*echo $user->user_id */?>', '<?php /*echo $user->password; */?>'); return false;" href="javascript:void(0);" >-->
            <a class="sessmoothbox" id="triggerid<?php echo $user->user_id; ?>" href="<?php echo $this->baseUrl()."/sesfbstyle/index/poploginfb?user_id=".$user->user_id;  ?>" >
              <div class="members_tab_item">
                  <div class="_img">
                    <?php echo $this->itemPhoto($user, 'thumb.profile'); ?>
                  </div>
                  <div class="_cont sesbasic_bg">
                    <span class="_name"><?php echo $user->getTitle(); ?></span>
                  </div>
              </div>
            </a>
            <a href="javascript:void(0);" onclick="removeRecentUser('<?php echo $user->getIdentity(); ?>');" class="close-btn"><i class="fa fa-times"></i></a>
            </div>
        <?php } ?>
        <div class="member_item">
            <a href="login" id="triggeridnewuseradd" class="sessmoothbox" >
              <div class="members_tab_item">
                  <div class="_img">
                    <i class="fa fa-plus"></i>
                  </div>
                  <div class="_cont sesbasic_bg">
                    <span class="_name add_user"><?php echo $this->translate("Add Account"); ?></span>
                  </div>
              </div>
            </a>
            </div>
         </div>
         </div>
      <?php } ?>
    <?php } else { ?>
      <div class="signup_left_section">
        <?php if($this->leftsideimage) { ?>
          <?php $leftsideimage = $this->baseUrl() . '/' . $this->leftsideimage; ?>
          <img alt="" src="<?php echo $leftsideimage ?>">
        <?php } else { ?>
          <img src="application/modules/Sesfbstyle/externals/images/webcrafter1.png" />
        <?php } ?>
        <div class="signup_left_content">
          <?php if($this->heading) { ?>
            <div class="left_heading"><p><?php echo $this->translate($this->heading); ?></p></div>
          <?php } ?>
          <?php if($this->description) { ?>
            <div class="left_pragraph"><p><?php echo $this->translate($this->description); ?></p></div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
    <div class="signup_right_section sesbasic_clearfix">
    	<div class="signup_form sesbasic_clearfix">
      	<h2 class="signup_headeing"><?php echo $this->translate("Sign Up"); ?></h2>
        <p class="signup_dis"><?php echo $this->translate("Lets Make Social Networking Easy, Join Us!"); ?></p>
          <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesfbstyle", array('disableContent'=>true)) ?>
      </div>
      <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin') && !empty($this->socialloginbutton)):?>
      	<div class="sociallogin_buttons">
        	<p><?php echo $this->translate("Sign in with a social network");?></p>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="sesariana_social_login_btns <?php if($numberOfLogin < 2):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php if(isset($_SESSION['popupuserid']) && !empty($_SESSION['popupuserid'])) {
    $triggervalue=$_SESSION['popupuserid'];
  unset($_SESSION['popupuserid']);
    ?>
<script type="application/javascript">
 sesJqueryObject("#triggerid<?php echo $triggervalue; ?>").click();
</script>
<?php  } ?>

<style type="text/css">
	html{overflow-y: auto !important;}
</style>
<script type="text/javascript">

  function removeRecentUser(user_id) {
  
    var url = en4.core.baseUrl + 'sesfbstyle/index/removerecentlogin';
    sesJqueryObject('#recent_login_'+user_id).fadeOut("slow", function(){
      setTimeout(function() {
        sesJqueryObject('#recent_login_'+user_id).remove();
      }, 2000);
    });
    (new Request.JSON({
      url: url,
      data: {
          format: 'json',
          user_id: user_id,
      },
      onSuccess: function () {
          window.location.replace('<?php echo $this->url(array(), 'default', true) ?>');
      }
    })).send();
  }
  
  function loginAsFbstyleUser(user_id, password) {
    var url = en4.core.baseUrl + 'sesfbstyle/index/login';
    (new Request.JSON({
      url : url,
      data : {
        format : 'json',
        user_id : user_id,
        password: password,
      },
      onSuccess : function() {
        window.location.replace('members/home/');
      }
    })).send();
  }

  sesJqueryObject (document).ready(function(e){
    sesJqueryObject ('#signup_account_form input,#signup_account_form input[type=email], #signup_account_form select').each(
      function(index){
        var input = sesJqueryObject (this);
        if(sesJqueryObject (this).closest('div').parent().css('display') != 'none' && sesJqueryObject (this).closest('div').parent().find('.form-label').find('label').first().length && sesJqueryObject (this).prop('type') != 'hidden' && sesJqueryObject (this).closest('div').parent().attr('class') != 'form-elements'){	
          if(sesJqueryObject (this).prop('type') == 'email' || sesJqueryObject (this).prop('type') == 'text' || sesJqueryObject (this).prop('type') == 'password'){
            sesJqueryObject (this).attr('placeholder',sesJqueryObject (this).closest('div').parent().find('.form-label').find('label').html());
          } else if(sesJqueryObject (this).prop('type') == 'select-one' && sesJqueryObject (this).prop('name') == 'profile_type') {
            sesJqueryObject (this).children().eq(0).text(sesJqueryObject (this).closest('div').parent().find('.form-label').find('label').html());
          }
        }
      }
    )
  });
  sesJqueryObject(document).on('click','#login_link',function(){
    if(sesJqueryObject (this).hasClass('active')){
    sesJqueryObject (this).removeClass('active');
    sesJqueryObject ('#sesfbstyle_form_login').removeClass('open_forme');
    }else{
    sesJqueryObject (this).addClass('active');
    sesJqueryObject ('#sesfbstyle_form_login').addClass('open_forme');
    }
  });

</script>
