<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesdemouser/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo $this->translate("Manage Test Users"); ?></h3>
      <p><?php echo $this->translate('This page shows a list of all the test users added by you. Here, you can choose to add as many test users as you want from the existing site users.<br />To add a test user, first create a new user on your website and then choose that user via the auto-suggest box by clicking on "Add New Test User" link. <br />Below, you can also enable / disable a test user and also remove any user anytime.') ?></p>
      <br />
      <div>
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'add-demo-member'), $this->translate('Add New Test User'), array('class' => 'smoothbox buttonlink sesdemouser_add_user'))
        ?><br/>
      </div><br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sesbasic_manage_table" style="width:60%;">
          <div class="sesbasic_manage_table_head">
            <div style="width:5%">
              <input onclick="selectAll()" type='checkbox' class='checkbox'>
            </div>
            <div style="width:50%">
              <?php echo "Display Name";?>
            </div>
             <div class="admin_table_centered" style="width:15%">
              <?php echo "Status";?>
            </div>
            <div style="width:30%" class="">
              <?php echo "Options";?>
            </div>   
          </div>
          <ul class="sesbasic_manage_table_list" id='menu_list'>
            <?php foreach ($this->paginator as $item):
            $user = $this->item('user', $item->user_id); ?>
              <li class="item_label" id="teams_<?php echo $item->demouser_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->demouser_id; ?>'>
                <div style="width:5%;">
                  <input name='delete_<?php echo $item->demouser_id ?>_<?php echo $item->demouser_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->demouser_id ?>_<?php echo $item->demouser_id ?>"/>                </div>
                <div style="width:50%;">
                  <?php echo $this->htmlLink($user->getHref(), $this->string()->truncate($user->getTitle(), 20), array('target' => '_blank', 'title' => $user->getTitle()))?>
                </div>
                <div class="admin_table_centered" style="width:15%;">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'enabled', 'demouser_id' => $item->demouser_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable this Test User'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'enabled', 'demouser_id' => $item->demouser_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable this Test User')))) ) ?>
                </div>
                <div style="width:30%;">
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdemouser', 'controller' => 'manage', 'action' => 'delete', 'demouser_id' => $item->demouser_id), $this->translate('Remove'), array('class' => 'smoothbox')) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class='buttons'>
          <button type='submit'><?php echo $this->translate('Remove Selected'); ?></button>
        </div>
      <?php else:?>
        <div class="tip">
          <span>
            <?php echo "There are no test users yet.";?>
          </span>
        </div>
      <?php endif;?>
    </div>
  </form>
</div>

<script type="text/javascript"> 
  
  var SortablesInstance;

  window.addEvent('load', function() {
    SortablesInstance = new Sortables('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentNode.childNodes;
     var ordering = {};
     var i = 1;
     for (var menuitem in menuitems)
     {
       var child_id = menuitems[menuitem].id;

       if ((child_id != undefined))
       {
         ordering[child_id] = i;
         i++;
       }
     }
 
    ordering['format'] = 'json';

    //Send request
    var url = '<?php echo $this->url(array("action" => "orderteam")) ?>';
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data' : ordering,
      onSuccess : function(responseJSON) {
      }
    });
    request.send();
  }
 
  function selectAll(){
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;

    for (i = 1; i < inputs.length - 1; i++) {
      if (!inputs[i].disabled) {
       inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
  function multiDelete(){
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected site team?")) ?>');
  }
</script>