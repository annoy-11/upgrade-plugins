<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: request-sesgroup.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
  var sesgroupWidgetRequestSend = function(action, group_id, notification_id)
  {
    var url;
    if( action == 'accept' )
    {
      url = '<?php echo $this->url(array('module'=> 'sesgroup','controller' => 'request','action' => 'accept'), 'default', true) ?>'+'/group_id/'+group_id;
    }
    else if( action == 'reject' )
    {
      url = '<?php echo $this->url(array('module'=> 'sesgroup','controller' => 'request','action' => 'reject'), 'default', true) ?>'+'/group_id/'+group_id;
    }
    else
    {
      return false;
    }
    (new Request.JSON({
      'url' : url,
      'data' : {
        'group_id' : group_id,
        'format' : 'json',
      },
      'onSuccess' : function(responseJSON)
      {
        if( !responseJSON.status )
        {
          $('sesgroup-widget-request-' + notification_id).innerHTML = responseJSON.error;
        }
        else
        {
          $('sesgroup-widget-request-' + notification_id).innerHTML = responseJSON.message;
        }
      }
    })).send();
  }
</script>

<li id="sesgroup-widget-request-<?php echo $this->notification->notification_id ?>">
  <?php echo $this->itemPhoto($this->notification->getObject(), 'thumb.icon') ?>
  <div>
    <div>
      <?php echo $this->translate('%1$s want you to join group %2$s', $this->htmlLink($this->notification->getSubject()->getHref(), $this->notification->getSubject()->getTitle()), $this->htmlLink($this->notification->getObject()->getHref(), $this->notification->getObject()->getTitle())); ?>
    </div>
    <div>
      <button type="submit" onclick='sesgroupWidgetRequestSend("accept", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Accept');?>
      </button>
      <?php echo $this->translate('or');?>
      <a href="javascript:void(0);" onclick='sesgroupWidgetRequestSend("reject", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Declined');?>
      </a>
    </div>
  </div>
</li>