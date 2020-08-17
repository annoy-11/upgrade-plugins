<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo $this->translate("Manage Team"); ?></h3>
      <p><?php echo $this->translate('Here, you can add team. To reorder the Team members, click on the desired row and drag them up or down.') ?></p>
      <br />
      <div>
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'add-team-member'), $this->translate('Add New Team'), array('class' => ' buttonlink sesbasic_icon_add'))
        ?><br/>
      </div><br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sessportz_manage_teams">
          <div class="sessportz_manage_teams_head">
            <div style="width:5%">
              <input onclick="selectAll()" type='checkbox' class='checkbox'>
            </div>
            <div style="width:20%">
              <?php echo "Team Name";?>
            </div>
            <div style="width:20%">
              <?php echo "Wins";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Draw";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Loss";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Points";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Status";?>
            </div>
            <div style="width:15%" class="">
              <?php echo "Options";?>
            </div>   
          </div>
          <ul class="sessportz_manage_teams_list" id='menu_list'>
            <?php foreach ($this->paginator as $item): ?>
              <li class="item_label" id="teams_<?php echo $item->team_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->team_id; ?>'>
                <div style="width:5%;">
                  <input name='delete_<?php echo $item->team_id ?>_<?php echo $item->team_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->team_id ?>_<?php echo $item->team_id ?>"/>
                </div>
                <div style="width:20%;">
                  <?php echo $item->name; ?>
                </div>
                <div style="width:20%;">
                  <?php echo $item->wins; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo $item->draw; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo $item->loss; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo $item->points; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </div>
                <div style="width:15%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'edit', 'team_id' => $item->team_id), $this->translate('Edit'), array('class' => '')) ?> |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'delete', 'team_id' => $item->team_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class='buttons'>
          <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
        </div>
      <?php else:?>
        <div class="tip">
          <span>
            <?php echo "There are no team yet.";?>
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
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected team?")) ?>');
  }
</script>
