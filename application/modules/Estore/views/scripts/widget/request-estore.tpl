<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: request-estore.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
  var estoreWidgetRequestSend = function(action, store_id, notification_id)
  {
    var url;
    if( action == 'accept' )
    {
      url = '<?php echo $this->url(array('module'=> 'estore','controller' => 'request','action' => 'accept'), 'default', true) ?>'+'/store_id/'+store_id;
    }
    else if( action == 'reject' )
    {
      url = '<?php echo $this->url(array('module'=> 'estore','controller' => 'request','action' => 'reject'), 'default', true) ?>'+'/store_id/'+store_id;
    }
    else
    {
      return false;
    }
    (new Request.JSON({
      'url' : url,
      'data' : {
        'store_id' : store_id,
        'format' : 'json',
      },
      'onSuccess' : function(responseJSON)
      {
        if( !responseJSON.status )
        {
          $('estore-widget-request-' + notification_id).innerHTML = responseJSON.error;
        }
        else
        {
          $('estore-widget-request-' + notification_id).innerHTML = responseJSON.message;
        }
      }
    })).send();
  }
</script>

<li id="estore-widget-request-<?php echo $this->notification->notification_id ?>">
  <?php echo $this->itemPhoto($this->notification->getObject(), 'thumb.icon') ?>
  <div>
    <div>
      <?php echo $this->translate('%1$s is want you to link your store %2$s', $this->htmlLink($this->notification->getSubject()->getHref(), $this->notification->getSubject()->getTitle()), $this->htmlLink($this->notification->getObject()->getHref(), $this->notification->getObject()->getTitle())); ?>
    </div>
    <div>
      <button type="submit" onclick='estoreWidgetRequestSend("accept", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Accept');?>
      </button>
      <?php echo $this->translate('or');?>
      <a href="javascript:void(0);" onclick='estoreWidgetRequestSend("reject", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Declined');?>
      </a>
    </div>
  </div>
</li>
