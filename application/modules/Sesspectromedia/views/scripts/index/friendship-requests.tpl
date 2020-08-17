<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: friendship-requests.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<script type="text/javascript">
  var widget_request_send = function(action, user_id, notification_id, event, tokenName, tokenValue)
  {
    event.stopPropagation();
    var url;
    if( action == 'confirm' ) {
      url = '<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'friends', 'action' => 'confirm'), 'default', true) ?>';
    } else if( action == 'reject' ) {
      url = '<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'friends', 'action' => 'reject'), 'default', true) ?>';
    } else if( action == 'add' ) {
      url = '<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'friends', 'action' => 'add'), 'default', true) ?>';
    } else {
      return false;
    }
    
    var data = {
      'user_id' : user_id,
      'format' : 'json',
    };
    data[tokenName] = tokenValue;
    
    (new Request.JSON({
      'url' : url,
      'data' : data,
      'onSuccess' : function(responseJSON) {
        if( !responseJSON.status ) {
          $('user-widget-request-' + notification_id).innerHTML = responseJSON.error;
        } else {
          $('user-widget-request-' + notification_id).innerHTML = responseJSON.message;
        }
      }
    })).send();
  }
</script>

<?php if( $this->friendRequests->getTotalItemCount() > 0 ): ?>  
  <ul class='pulldown_content_list' id="notifications_main">
    <?php foreach( $this->friendRequests as $notification ): ?>
      <?php $user = Engine_Api::_()->getItem('user', $notification->subject_id);?>
      <?php
        $tokenName = 'token_' . $user->getGuid();
        $salt = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.secret');
        $tokenValue = $this->token(null, $tokenName, $salt);
      ?>
      <li id="user-widget-request-<?php echo $notification->notification_id ?>" class="clearfix <?php if( !$notification->read ): ?>pulldown_content_list_highlighted<?php endif; ?>"  value="<?php echo $notification->getIdentity();?>">
        <div class="pulldown_item_photo">
          <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon')) ?>
        </div>
        <div class="pulldown_item_content">
          <p class="pulldown_item_content_title">
            <?php echo $notification->__toString() ?>
          </p>
          <p class="pulldown_item_content_btns clearfix">
          <button type="submit" onclick='widget_request_send("confirm", <?php echo $this->string()->escapeJavascript($notification->getSubject()->getIdentity()) ?>, <?php echo $notification->notification_id ?>, event, "<?php echo $tokenName; ?>", "<?php echo $tokenValue; ?>")'>
            <?php echo $this->translate('Add Friend');?>
          </button>
          <button class="button button_alt" onclick='widget_request_send("reject", <?php echo $this->string()->escapeJavascript($notification->getSubject()->getIdentity()) ?>, <?php echo $notification->notification_id ?>, event, "<?php echo $tokenName; ?>", "<?php echo $tokenValue; ?>")'>
            <?php echo $this->translate('ignore request');?>
          </button>
          </p>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
  <div class="sm_pulldown_options">
    <a href="<?php echo $this->url(array('action' => 'index'), 'recent_activity', true) ?>"><?php echo $this->translate("See All Friend Request") ?></a>
  </div>
<?php else:?>
  <div class="pulldown_loading"><?php echo $this->translate('You have no any friend request.');?></div>
<?php endif;?>
  

<script type="text/javascript">
  
  function redirectPage(event) {
    
    event.stopPropagation();
    var url;
    var current_link = event.target;
    var notification_li = $(current_link).getParent('div');
    if(current_link.get('href') == null && $(current_link).get('tag')!='img') {
      if($(current_link).get('tag') == 'li') {
        var element = $(current_link).getElements('div:last-child');
        var html = element[0].outerHTML;
        var doc = document.createElement("html");
        doc.innerHTML = html;
        var links = doc.getElementsByTagName("a");
        var url = links[links.length - 1].getAttribute("href");
      }
      else
      url = $(notification_li).getElements('a:last-child').get('href');
      if(typeof url == 'object') {
        url = url[0];
      }
      window.location = url;
    }
  }
</script>