<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-moderator.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php echo $this->form->render($this) ?>

<div class="sesforum_admin_manage_users">
  <ul id="user_list"></ul>
</div>
<script type="text/javascript">

  window.addEvent('domready', function() {
    $('sesforum_form_admin_moderator_create').addEvent('submit', function(event) {
      event.stop();
      updateUsers();
    });
  });

function addModerator(user_id) {
  $('user_id').set('value', user_id);
  $('sesforum_form_admin_moderator_create').submit();
}

function updateUsers() {
  var request = new Request/*.HTML*/({
    url : '<?php echo $this->url(array('module' => 'sesforum', 'controller' => 'manage', 'action' => 'user-search'), 'admin_default', true);?>',
    method: 'GET',
    data : {
      format : 'html',
      page : '1',
      forum_id : <?php echo $this->sesforum->getIdentity();?>,
      username : $('username').value
    },
    'onSuccess' : function(/*responseTree, responseElements,*/ responseHTML/*, responseJavaScript*/) {
      if( responseHTML.length > 0 ) {
        $('user_list').setStyle('display', 'block');
      } else {
        $('user_list').setStyle('display', 'none');
      }
      $('user_list').set('html', responseHTML);
      parent.Smoothbox.instance.doAutoResize();
      return false;
    }
  });
  request.send();
}
</script>
