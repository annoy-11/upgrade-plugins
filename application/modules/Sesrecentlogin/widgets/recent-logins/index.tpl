<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecentlogin
 * @package    Sesrecentlogin
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($_COOKIE['sesrecentlogin_users'])) { ?>
  <div class="sesrecentlogin_section">
    <div class="sesrecentlogin_head">
      <h3><?php echo $this->translate("Recent logins"); ?></h3>
      <p><?php echo $this->translate("Click your picture or add an account."); ?></p>
    </div>
    <div class="sesrecentlogin_members_data">
      <?php $sesrecentlogin = Zend_Json::decode($_COOKIE['sesrecentlogin_users']); ?>
      <?php if(count($sesrecentlogin) > 0) { ?>
        <?php foreach($sesrecentlogin as $users) {
            $userArray = explode("_", $users);
            $user = Engine_Api::_()->getItem('user', $userArray[0]);
          ?>
          <div id="sesrecentlogin_<?php echo $user->getIdentity(); ?>" class="sesrecentlogin_member_item">
            <a onclick="loginAsRecentUser('<?php echo $user->user_id ?>', '<?php echo $user->password; ?>'); return false;" href="javascript:void(0);" >
              <div class="sesrecentlogin_members_tab_item">
                  <div class="_img">
                    <?php echo $this->itemBackgroundPhoto($user, 'thumb.profile'); ?>
                  </div>
                  <div class="_cont">
                    <span class="_name"><?php echo $user->getTitle(); ?></span>
                  </div>
              </div>
            </a>
            <?php $notificationCount = Engine_Api::_()->sesrecentlogin()->getNotificationsPaginator($user); ?>
            <?php if(count($notificationCount) > 0) { ?>
              <span class="_badge"><?php echo count($notificationCount); ?></span>
            <?php } ?>
            <a href="javascript:void(0);" onclick="removeRecentUser('<?php echo $user->getIdentity(); ?>');" class="close-btn"><i class="fa fa-times"></i></a>
          </div>
        <?php } ?>
        <div class="sesrecentlogin_member_item">
          <?php if(!empty($this->viewer_id)) { ?>
            <a href="logout" >
          <?php } else { ?>
            <a href="login" >
          <?php } ?>
            <div class="sesrecentlogin_members_tab_item">
              <div class="_img" style="background-image:url(./application/modules/Sesrecentlogin/externals/images/transprant-bg.png)">
                <i class="fa fa-plus"></i>
              </div>
              <div class="_cont">
                <span class="_name add_user"><?php echo $this->translate("Add Account"); ?></span>
              </div>
            </div>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>

<script type="text/javascript">

  function removeRecentUser(user_id) {
  
    var url = en4.core.baseUrl + 'sesrecentlogin/index/removerecentlogin';
    sesJqueryObject('#sesrecentlogin_'+user_id).fadeOut("slow", function(){
      setTimeout(function() {
        sesJqueryObject('#sesrecentlogin_'+user_id).remove();
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
  
  function loginAsRecentUser(user_id, password) {
    var url = en4.core.baseUrl + 'sesrecentlogin/index/login';
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
</script>
