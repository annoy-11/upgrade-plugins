<?php

/**
* SocialEngineSolutions
*
* @category   Application_Sesprofilelock
* @package    Sesprofilelock
* @copyright  Copyright 2015-2016 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: index.tpl 2016-04-30 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/

?>
<ul id="blocked_users" class="sesprofilelock_user_widget sesprofilelock_blocked_members">
  <?php foreach( $this->results as $user ): ?>
  <?php $userItem = Engine_Api::_()->getItem('user', $user->blocked_user_id); ?>
  <li id="locked_<?php echo $user->blocked_user_id ?>">
    <?php echo $this->htmlLink($userItem->getHref(), $this->itemPhoto($userItem, 'thumb.icon', $userItem->getTitle()), array('class' => 'sesprofilelock_user_thumb')) ?>
    <div class='sesprofilelock_user_info'>
      <div class='sesprofilelock_user_name'>
        <?php echo $this->htmlLink($userItem->getHref(), $userItem->getTitle()) ?>
      </div>
      <div class="sesprofilelock_user_stats">
        <button id="unlocked_<?php echo $user->blocked_user_id ?>" onclick="sesprofilelock_unlocked('<?php echo $this->viewer_id; ?>', '<?php echo $user->blocked_user_id ?>');">
          <?php echo $this->translate("Unblock") ?>
        </button>
      </div>
    </div>
  </li>
  <?php endforeach; ?>
</ul>
<script type="text/javascript">

  function sesprofilelock_unlocked(user_id, blocked_user_id) {

    en4.core.request.send(new Request.HTML({
      url: en4.core.baseUrl + 'sesprofilelock/index/unblock',
      data: {
        format: 'html',
        'user_id': user_id,
        'blocked_user_id': blocked_user_id
      },
      'onSuccess': function(responseTree, responseElements, responseHTML, responseJavaScript) {

        document.getElementById('locked_' + blocked_user_id).destroy();
        if (document.getElementById('blocked_users').getChildren().length == 0) {
          document.getElementById('blocked_users').innerHTML =
                  "<div class='tip' id=''><span><?php echo $this->translate('There are no more blocked members.');?> </span></div>";
        }
      }
    }));
  }
</script>