<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: notificationlistappend.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if( count($this->paginator) == 0 ): ?>
  <div class="pulldown_loading">
    <?php echo $this->translate('You have no messages.'); ?>
  </div>
<?php endif; ?>
<?php if( count($this->paginator) ): ?>
  <div class="pulldown_content_list">
    <ul id="swingerslife_messagess_menu">
      <?php foreach( $this->paginator as $conversation ):
          $exitornot=1;
	      $viewer = Engine_Api::_()->user()->getViewer();
           if(isset($conversation['type']) && $conversation['type']==1)
           {
	           $exitornot = Engine_Api::_()->emessages()->checksingleuserblockornot($conversation['sender_id']);
           }
           else
           {
	           $exitornot=Engine_Api::_()->emessages()->userexites($conversation['receiver_id'], $viewer->getIdentity());
           }
           if($exitornot!=1){ continue;  }

          $read_status=$conversation['receiver_status'];
          $sender=Engine_Api::_()->getItem('user', $conversation['sender_id']);
          $messages='';
          $user_img='';
          if(isset($conversation['text']) && !empty($conversation['text']))
          {
	          $messages = isset($conversation['text']) && !empty($conversation['text']) ? trim($conversation['text']) : null;
	          if (preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $messages, $match))
	          {
		          $messages ="send gif";
	          }
	          else
              {
	              $messages=isset($conversation['text']) && !empty($conversation['text']) ? strlen($conversation['text']) > 30 ? substr($conversation['text'], 0, 30) . " ..." : $conversation['text'] : '';
              }
          }
          else if(isset($conversation['image_id']) && !empty($conversation['image_id']))
          {
	          $messages ="send image";
          }
          if(isset($conversation['type']) && $conversation['type']==2)
          {
	          $sender_name='Send by: '.$this->htmlLink($sender->getHref(), $sender->getTitle());
	          $name=Engine_Api::_()->emessages()->groupname($conversation['receiver_id']);
	          $user_img="<img class='thumb_icon' src=".Engine_Api::_()->emessages()->groupimage($conversation['receiver_id'])." />";
              $r_view='g.'.$conversation['receiver_id'];
              $url=$this->htmlLink(array("route" => 'messages', "module" => 'emessages', "controller" => 'messages', "action" => 'index', 'view' =>'g'.$conversation['sender_id']));
          }
          else
          {
              $sender_name='';
	          $name=$this->htmlLink($sender->getHref(), $sender->getTitle());
	          $user_img=$this->htmlLink($sender->getHref(), $this->itemPhoto($sender, 'thumb.icon'));
	          $r_view=$conversation['sender_id'];
	          $url=$this->htmlLink(array("route" => 'messages', "module" => 'emessages', "controller" => 'messages', "action" => 'index', 'view' =>$conversation['sender_id']));
          }
        ?>
        <li class='clearfix <?php if($read_status==0): ?>pulldown_content_list_highlighted<?php endif; ?>' id="messages_conversation_<?php echo $conversation['messages_id']; ?>" onclick="window.location.href=en4.core.baseUrl + 'messagess/view/'+'<?php echo $r_view; ?>';">
          <div class="pulldown_item_photo">
            <?php echo $user_img; ?>  <!-- photo -->
          </div>
          <div class="pulldown_item_content">
            <p class="pulldown_item_content_title">
                <?php echo $name; ?>
            </p>
            <p class="pulldown_item_content_des msg_body">
              <?php echo $url; ?> <?php echo $sender_name; ?>: <?php echo $messages; ?>
            </p>
            <p class="pulldown_item_content_date">
              <?php echo Engine_Api::_()->emessages()->TimeAgo($conversation['creation_date'], false); ?>
            </p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="pulldown_options">
    <a href="<?php echo $this->url(array('action' => 'inbox'), 'messagess_general', true) ?>"><?php echo $this->translate("View All Messages") ?></a>
    <a href="javascript:void(0);" onclick="markallmessages();"><?php echo $this->translate("Mark All Read") ?></a>
   </div>
<?php endif; ?>


<script type="text/javascript">

  function markallmessages() {
  
    event.stopPropagation();
    en4.core.request.send(new Request.JSON({
      url : en4.core.baseUrl + 'index/markallmessages',
      data : {
        format: 'json'
      },
      onSuccess : function(responseJSON) {
        if($('swingerslife_messagess_menu')){
          var messages_children = $('swingerslife_messagess_menu').getChildren('li');
//           console.log(messages_children);
          messages_children.each(function(el){
            el.setAttribute('class', '');
          });
        }
      }
    }));
  
  }
  
  function messagesProfilePage(pageUrl){
    if(pageUrl != 'null' ) {
        window.location.href=pageUrl;
    }
  }
  
  function deleteMessage(id, event) {

    event.stopPropagation();
    document.getElementById('messages_conversation_'+id).remove();

    en4.core.request.send(new Request.JSON({
      url : en4.core.baseUrl + 'index/delete-messages',
      data : {
        format     : 'json',
        'id' : id
      }
    }));
  };
  
</script>
