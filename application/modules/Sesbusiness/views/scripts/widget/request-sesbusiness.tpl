<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: request-sesbusiness.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
  var sesbusinessWidgetRequestSend = function(action, business_id, notification_id)
  {
    var url;
    if( action == 'accept' )
    {
      url = '<?php echo $this->url(array('module'=> 'sesbusiness','controller' => 'request','action' => 'accept'), 'default', true) ?>'+'/business_id/'+business_id;
    }
    else if( action == 'reject' )
    {
      url = '<?php echo $this->url(array('module'=> 'sesbusiness','controller' => 'request','action' => 'reject'), 'default', true) ?>'+'/business_id/'+business_id;
    }
    else
    {
      return false;
    }
    (new Request.JSON({
      'url' : url,
      'data' : {
        'business_id' : business_id,
        'format' : 'json',
      },
      'onSuccess' : function(responseJSON)
      {
        if( !responseJSON.status )
        {
          $('sesbusiness-widget-request-' + notification_id).innerHTML = responseJSON.error;
        }
        else
        {
          $('sesbusiness-widget-request-' + notification_id).innerHTML = responseJSON.message;
        }
      }
    })).send();
  }
</script>

<li id="sesbusiness-widget-request-<?php echo $this->notification->notification_id ?>">
  <?php echo $this->itemPhoto($this->notification->getObject(), 'thumb.icon') ?>
  <div>
    <div>
      <?php echo $this->translate('%1$s is want you to link your business %2$s', $this->htmlLink($this->notification->getSubject()->getHref(), $this->notification->getSubject()->getTitle()), $this->htmlLink($this->notification->getObject()->getHref(), $this->notification->getObject()->getTitle())); ?>
    </div>
    <div>
      <button type="submit" onclick='sesbusinessWidgetRequestSend("accept", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Accept');?>
      </button>
      <?php echo $this->translate('or');?>
      <a href="javascript:void(0);" onclick='sesbusinessWidgetRequestSend("reject", <?php echo $this->string()->escapeJavascript($this->notification->getObject()->getIdentity()) ?>, <?php echo $this->notification->notification_id ?>)'>
        <?php echo $this->translate('Declined');?>
      </a>
    </div>
  </div>
</li>
