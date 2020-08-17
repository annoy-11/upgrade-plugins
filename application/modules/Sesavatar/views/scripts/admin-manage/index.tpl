<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar	
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesavatar/views/scripts/dismiss_message.tpl';?>

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

    // Send request
    var url = '<?php echo $this->url(array('action' => 'order')) ?>';
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

<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected avatar images?") ?>");
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
<div>
  <h3><?php echo "Manage Avatar Images"; ?></h3>
  <p><?php echo $this->translate("This page lists all the Avatar uploaded by you on your website. From below you can upload Avatar from your computer or hard drive. <br />") ?></p>
  <br />
<div>
<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
<?php endif; ?>

    <div class="sesbasic_search_reasult">
   
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'create'), $this->translate("<i style='vertical-align:middle' class='fa fa-plus'></i> Upload Avatar Image"), array('class'=>'sesbasic_button smoothbox')); ?>
    
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'upload-zip-file'), $this->translate("<i style='vertical-align:middle' class='fa fa-plus'></i> Upload Zipped Folder"), array('class'=>'sesbasic_button smoothbox')); ?>
    </div>
  </div>
  <?php if( count($this->paginator) ): ?>
    <div class="sesbasic_search_reasult">
      <?php echo $this->translate(array('%s avatar image found.', '%s avatar images found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
    </div>
  <?php endif; ?>
  <?php if(count($this->paginator) > 0):?>
    <div class="clear">
      <ul class="sesavatar_packs_list" id='menu_list'>
        <?php foreach ($this->paginator as $item) : ?>
          <?php if(empty($item->file_id)) continue; ?>
          <li class="item_label" id="manageimages_<?php echo $item->image_id ?>">
          	<div class="sesavatar_packs_item">
              <div class="sesavatar_packs_list_input">
                <input type='checkbox' class='checkbox' name='delete_<?php echo $item->image_id;?>' value='<?php echo $item->image_id ?>' />
              </div>
              <div class="sesavatar_packs_list_options">
                <?php echo ($item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'enabled', 'image_id' => $this->image_id, 'id' => $item->image_id), '', array('title' => $this->translate('Disable'), 'class' => 'fa sesavatar_icon_enabled')) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'enabled', 'image_id' => $this->image_id, 'id' => $item->image_id), '', array('title' => $this->translate('Enable'), 'class' => 'fa sesavatar_icon_disabled'))) ?>&nbsp;
                <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'create', 'id'=>$item->image_id), '', array('class' => 'smoothbox fa fa-pencil', 'title' => $this->translate('Edit'))) ?>&nbsp;
                <?php echo $this->htmlLink(
                array('route' => 'admin_default', 'module' => 'sesavatar', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->image_id), '', array('class' => 'smoothbox fa sesavatar_icon_delete', 'title' => $this->translate('Delete'))) ?>
              </div>
              <div class="sesavatar_packs_list_img">
                <?php $photo = Engine_Api::_()->storage()->get($item->file_id, '');
                if($photo) { ?>
                <img alt="" src="<?php echo $photo->getPhotoUrl(); ?>" />
                <?php } else { ?> 
                <?php echo "---"; ?>
                <?php } ?>
              </div>
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
	<?php echo "There are no gif images added by you.";?>
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
