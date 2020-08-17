<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: request-sespage.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
  var sespageWidgetRequestSend = function(action, page_id, notification_id)
  {
    var url;
    if( action == 'accept' )
    {
      url = '<?php echo $this->url(array('module'=> 'sespage','controller' => 'request','action' => 'accept'), 'default', true) ?>'+'/page_id/'+page_id;
    }
    else if( action == 'reject' )
    {
      url = '<?php echo $this->url(array('module'=> 'sespage','controller' => 'request','action' => 'reject'), 'default', true) ?>'+'/page_id/'+page_id;
    }
    else
    {
      return false;
    }
    (new Request.JSON({
      'url' : url,
      'data' : {
        'page_id' : page_id,
        'format' : 'json',
      },
      'onSuccess' : function(responseJSON)
      {
        if( !responseJSON.status )
        {
          $('sespage-widget-request-' + notification_id).innerHTML = responseJSON.error;
        }
        else
        {
          $('sespage-widget-request-' + notification_id).innerHTML = responseJSON.message;
        }
      }
    })).send();
  }
</script>

<li id="sespage-widget-request-<?php echo $this->notification->notification_id ?>">
  <?php echo $this->itemPhoto($this->notification->getObject(), 'thumb.icon') ?>
  <div>
    <div>
      <?php echo $this->translate('%1$s is want you to link your page %2$s', $this->htmlLink($this->notification->getSubject()->getHref(), $this->notification->getSubject()->getTitle()), $this->htmlLink($this->notification->getObject()->getHref(), $this->notification->getObject()->getTitle())); ?>
    </div>
    <div>
      <button type="submit" onclick='sespageWidgetRequestSend("accept", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Accept');?>
      </button>
      <?php echo $this->translate('or');?>
      <a href="javascript:void(0);" onclick='sespageWidgetRequestSend("reject", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Declined');?>
      </a>
    </div>
  </div>
</li>