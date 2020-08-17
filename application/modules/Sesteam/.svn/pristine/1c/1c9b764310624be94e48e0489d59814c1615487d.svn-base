<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo $this->translate("Manage Non-Site Team"); ?></h3>
      <p><?php echo $this->translate('Here, you can add any non site members to be shown as Team Members, Sponsors, Testimonials, etc. You can choose a new team members by using the "Add New Team Member" link below. To reorder the Team members, click on the desired row and drag them up or down.<br />
Members added using this form will have their own Profile Page on your website.') ?></p>
      <br />
      <div>
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'add-team-member', 'type' => 'nonsitemember'), $this->translate('Add New Team Member'), array('class' => ' buttonlink sesteam_icon_user'))
        ?><br/>
      </div><br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sesteam_manage_designations">
          <div class="sesteam_manage_designations_head">
            <div style="width:5%">
              <input onclick="selectAll()" type='checkbox' class='checkbox'>
            </div>
            <div style="width:20%">
              <?php echo "Display Name";?>
            </div>
            <div style="width:20%">
              <?php echo "Designation";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Featured";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Sponsored";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Of the Day";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Status";?>
            </div>
            <div style="width:15%" class="">
              <?php echo "Options";?>
            </div>   
          </div>
          <ul class="sesteam_manage_designations_list" id='menu_list'>
            <?php foreach ($this->paginator as $item):
            $user = $this->item('user', $item->user_id); ?>
              <li class="item_label" id="teams_<?php echo $item->team_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->team_id; ?>'>
                <div style="width:5%;">
                  <input name='delete_<?php echo $item->team_id ?>_<?php echo $item->team_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->team_id ?>_<?php echo $item->team_id ?>"/>
                </div>
                <div style="width:20%;">
                  <?php echo $this->htmlLink($item->getHref(), $this->string()->truncate($item->name, 20), array('target' => '_blank', 'title' => $item->getTitle()))?>
                </div>
                <div style="width:20%;">
                  <?php if($item->designation_id && $item->designation): ?>
                    <?php echo $item->designation ?>
                  <?php else: ?>
                   <?php echo "---"; ?>
                  <?php endif; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo ( $item->featured ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'featured', 'team_id' => $item->team_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark as Featured'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'featured', 'team_id' => $item->team_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Featured')))) ) ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo ( $item->sponsored ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'sponsored', 'team_id' => $item->team_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark as Sponsored'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'sponsored', 'team_id' => $item->team_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Sponsored')))) ) ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php if($item->offtheday == 1):?>  
                    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesteam', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->team_id, 'type' => 'sesteam_nonteam', 'param' => 0), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Team Member of the Day'))), array('class' => 'smoothbox')); ?>
                  <?php else: ?>
                    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesteam', 'controller' => 'admin-manage', 'action' => 'oftheday', 'id' => $item->team_id, 'type' => 'sesteam_nonteam', 'param' => 1), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Team Member of the Day'))), array('class' => 'smoothbox')) ?>
                  <?php endif; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'enabled', 'team_id' => $item->team_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </div>
                <div style="width:15%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'edit', 'team_id' => $item->team_id, 'type' => 'nonsitemember'), $this->translate('Edit'), array('class' => '')) ?> |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesteam', 'controller' => 'nonsiteteam', 'action' => 'delete', 'team_id' => $item->team_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
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
            <?php echo "There are no team members yet.";?>
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
    var url = '<?php echo $this->url(array('action' => 'orderteam')) ?>';
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
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected non site team?")) ?>');
  }
</script>