<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: poploginfb.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesfbstyel_poploginfb_login">
<ul class="sesfbstyel_poploginfb_login_ul">
<li><?php echo $this->itemPhoto($this->user,'thumb.profile');  ?></li>
  <li><span><?php echo $this->user->getTitle();  ?></span></li>
  <li>
    <input type="password" id="poploginfbpassword" name="password" placeholder="Enter your password"><br>
    <span id="poploginfbpassworderror" style="display: none;">Your password is not correct.</span>
  </li>
  <li class="remember-me sebasic_text_light"><input type="checkbox">Remember Me</li>
  <li><button id="poploginfbsubmit" onclick="loginAsFbstyleUser();">Submit</button></li>
  <li><a href="<?php echo $this->baseUrl()."/user/auth/forgot";  ?>">Forgotten password?</a></li>
</ul>
</div>


<script>
   function loginAsFbstyleUser() {
       var user_id='<?php  echo $this->user_id; ?>';
       var password=sesJqueryObject("#poploginfbpassword").val();
       if(password.length==0)
       {
        alert("Please Enter Password");
        return false;
       }
      var url = en4.core.baseUrl + 'sesfbstyle/index/login';
      (new Request.JSON({
      url : url,
      data : {
      format : 'json',
      user_id : user_id,
      password: password,
      },
      onSuccess : function(html) {
         if(html['status'])
         {
             window.location.replace('members/home/');
         }
         else
         {
            sesJqueryObject("#poploginfbpassworderror").css('display','inline-block');
         }
      }
      })).send();
   }
</script>