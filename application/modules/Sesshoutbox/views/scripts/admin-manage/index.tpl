<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox	
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesshoutbox/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected shoutbox?") ?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length; i++) {
    if (!inputs[i].disabled) {
      inputs[i].checked = inputs[0].checked;
    }
  }
}
</script>


  
<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
  <?php endif; ?>
  <div>
  	 <div class="sesbasic_search_reasult">
    	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'index'), $this->translate("Back to Manage Shoutbox"), array('class'=>'sesbasic_icon_back buttonlink')); ?>
      </div>
        <h3><?php echo "Manage Shoutboxes"; ?></h3>
        <p><?php echo $this->translate("This page lists all shoutboxes added by you. Below, you can also add and manage any number of shoutboxes. Each shoutbox is highly configurable. <br>To reorder the shoutboxes, click on their row and drag them up or down.") ?>	 </p>
        <br />
        <div>
        <div class="sesbasic_search_reasult"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'create'), $this->translate("Create New Shoutbox"), array('class'=>'buttonlink sesbasic_icon_add')); ?></div>
        </div>
        <?php if( count($this->paginator) ): ?>
          <div class="sesbasic_search_reasult">
            <?php echo $this->translate(array('%s shoutbox found.', '%s shoutboxes found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
          </div>
        <?php endif; ?>
        <?php if(count($this->paginator) > 0):?>
        	<div class="sesbasic_manage_table">
          	<div class="sesbasic_manage_table_head" style="width:100%;">
              <div style="width:5%">
                <input onclick='selectAll();' type='checkbox' class='checkbox' />
              </div>
              <div style="width:5%">
                <?php echo "Id";?>
              </div>
              <div style="width:30%">
               <?php echo $this->translate("Title") ?>
              </div>
              <div style="width:10%"  class="admin_table_centered">
               <?php echo $this->translate("Status") ?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Options"); ?>
              </div>  
            </div>
          	<ul class="sesbasic_manage_table_list" id='menu_list' style="width:100%;">
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label" id="shoutbox_<?php echo $item->shoutbox_id ?>">
                <div style="width:5%;">
                  <input type='checkbox' class='checkbox' name='delete_<?php echo $item->shoutbox_id;?>' value='<?php echo $item->shoutbox_id ?>' />
                </div>
                <div style="width:5%;">
                  <?php echo $item->shoutbox_id; ?>
                </div>
                <div style="width:30%;">
                  <?php echo $item->title ?>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->status ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->shoutbox_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Enabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->shoutbox_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Disabled')))) ) ?>
                </div>  
                <div style="width:20%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'create', 'shoutbox_id' => $item->shoutbox_id), $this->translate("Edit"), array()) ?>
            |
            <?php echo $this->htmlLink(
                array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->shoutbox_id),
                $this->translate("Delete"),
                array('class' => 'smoothbox')) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          	<div class='buttons'>
            <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
          </div>
          </div>
        <?php else:?>
          <div class="tip">
            <span>
              <?php echo "There are no shoutboxs added by you yet.";?>
            </span>
          </div>
        <?php endif;?>
      </div>
  <br />
  </form>
  <br />
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
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
</script>
<style type="text/css">
.sesshoutbox_manage_form_head > div,
.sesshoutbox_manage_form_list li > div{
	box-sizing:border-box;
}
</style>
