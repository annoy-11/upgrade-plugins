<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: designations.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
          <div class='clear settings'>
            <form id='multidelete_form' method="post" action="<?php echo $this->url(array('action' => 'multi-delete-designations'));?>" onSubmit="return multiDelete()">
              <div>
                <h3><?php echo "Manage Designations"; ?></h3>
                <p><?php echo 'Here, you can manage designations. Below, you can add designation by using the "Add New Designation" link, edit and delete them. You can drag the designation vertically to change their order.'; ?> </p>
                <br />
                <div>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbusinessteam', 'controller' => 'manage', 'action' => 'adddesignation'), $this->translate('Add New Designation'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')); ?>
                </div><br />
                <?php if(count($this->paginator) > 0):?>
                  <div class="sesbusinessteam_manage_designations" style="width:60%">
                    <div class="sesbusinessteam_manage_designations_head">
                      <div style="width:5%">
                        <input onclick="selectAll()" type='checkbox' class='checkbox'>
                      </div>
                      <div style="width:10%">
                        <?php echo "Id";?>
                      </div>
                      <div style="width:55%">
                        <?php echo "Designations";?>
                      </div>
                      <div style="width:30%" class="">
                        <?php echo "Options";?>
                      </div>   
                    </div>
                    <ul class="sesbusinessteam_manage_designations_list" id='menu_list'>
                      <?php foreach ($this->paginator as $item) : ?>
                        <li class="item_label" id="designations_<?php echo $item->designation_id ?>">
                          <input type='hidden'  name='order[]' value='<?php echo $item->designation_id; ?>'>
                          <div style="width:5%;">
                            <input name='delete_<?php echo $item->designation_id ?>_<?php echo $item->designation_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->designation_id ?>_<?php echo $item->designation_id ?>"/>
                          </div>
                          <div style="width:10%;">
                            <?php echo $item->designation_id; ?>
                          </div>
                          <div style="width:55%;">
                            <?php echo $item->designation ?>
                          </div>
                          <div style="width:30%;">          
                            <?php echo $this->htmlLink(
                              array('route' => 'default', 'module' => 'sesbusinessteam', 'controller' => 'admin-manage', 'action' => 'editdesignation', 'designation_id' => $item->designation_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
                              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesbusinessteam', 'controller' => 'admin-manage', 'action' => 'deletedesignation', 'designation_id' => $item->designation_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
                      <?php echo "There are no designations yet.";?>
                    </span>
                  </div>
                <?php endif;?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
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
     var ordering = { };
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
    var url = '<?php echo $this->url(array("action" => "order")) ?>';
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
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected designations?")) ?>');
  }
</script>
