
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected slides ?") ?>");
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
  	 <div class="estore_search_reasult">
    	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'index'), $this->translate("Back to Manage Custom Offers"), array('class'=>'estore_icon_back buttonlink')); ?>
      </div>
        <h3><?php echo "Manage Offer Blocks"; ?></h3>
        <p><?php echo $this->translate("This page lists all the offer blocks added by you for the custom Offer. Below, you can also add and manage any number of blocks. Each block is highly configurable and you can add caption, description, URL, photo and button type to each block.<br />To reorder the blocks, click on their row and drag them up or down.") ?>	 </p>
        <br />
        <div>
         <div class="estore_search_reasult"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'create-slide','id'=>$this->offer_id), $this->translate("Create New Offer Block"), array('class'=>'buttonlink estore_icon_add')); ?>
			</div>
        </div>
        <?php if( count($this->paginator) ): ?>
  <div class="estore_search_reasult">
    <?php echo $this->translate(array('%s block found.', '%s blocks found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div><?php endif; ?>
        <?php if(count($this->paginator) > 0):?>
        	<div class="estore_manage_table">
          	<div class="estore_manage_table_head" style="width:100%;">
              <div style="width:5%">
                <input onclick='selectAll();' type='checkbox' class='checkbox' />
              </div>
              <div style="width:5%">
                <?php echo "Id";?>
              </div>
              <div style="width:30%">
               <?php echo $this->translate("Caption") ?>
              </div>
              <div style="width:20%" class="admin_table_centered">
               <?php echo $this->translate("Thumbnail") ?>
              </div>

              <div style="width:20%" class="admin_table_centered">
               <?php echo $this->translate("Status") ?>
              </div>
              <div style="width:20%">
               <?php echo $this->translate("Options"); ?>
              </div>  
            </div>
          	<ul class="estore_manage_table_list" id='menu_list' style="width:100%;">
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label" id="slide_<?php echo $item->slide_id ?>">
                <div style="width:5%;">
                  <input type='checkbox' class='checkbox' name='delete_<?php echo $item->slide_id;?>' value='<?php echo $item->slide_id ?>' />
                </div>
                <div style="width:5%;">
                  <?php echo $item->slide_id; ?>
                </div>
                <div style="width:30%;">
                  <?php echo $item->title ?>
                </div>
    
                <div style="width:20%;" class="admin_table_centered">
                  <?php if($item->file_id): ?>
	                  <img height="100px;" width="100px;" style="object-fit: cover;" alt="" src="<?php echo Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl(); ?>" />
                  <?php else: ?>
	                  <?php echo "---"; ?>
                  <?php endif; ?>
                </div>

                <div style="width:20%;" class="admin_table_centered">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'enabled', 'offer_id' => $this->offer_id, 'id' => $item->slide_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'enabled', 'offer_id' => $this->offer_id, 'id' => $item->slide_id), $this->htmlImage('application/modules/Estore/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
                </div>  
                <div style="width:20%;">
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'create-slide', 'slide_id' => $item->slide_id,'id'=>$this->offer_id), $this->translate("Edit"), array()) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'delete-slide', 'id' => $item->slide_id, 'type' => strtolower($item->file_type) == 'jpeg' || strtolower($item->file_type) == 'jpg' || strtolower($item->file_type) == 'png' ? 'Photo' : 'Video'), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
              <?php echo "There are no offer blocks added by you yet.";?>
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
.estore_manage_form_head > div,
.estore_manage_form_list li > div{
	box-sizing:border-box;
}
</style>
