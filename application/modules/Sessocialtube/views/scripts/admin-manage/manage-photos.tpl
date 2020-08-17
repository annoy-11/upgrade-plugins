<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-photos.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sessocialtube/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'manage-photos'), $this->translate('Header Background Images')) ?>
    </li>
  </ul>
</div>

<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
<?php endif; ?>
  <div>
    <h3><?php echo "Manage Header Background Images"; ?></h3>
    <p><?php echo $this->translate("This page lists all the banner images uploaded by you. Here, you can also add and manage any number of images for the Header Background on your website. The uploaded banner images will be shown randomly 1 at a time on page refresh.
These images will only work with the 5th Header Design.") ?></p>
    <br />
    <div>
    <div class="sesbasic_search_reasult"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'create-image'), $this->translate("Upload Image"), array('class'=>'buttonlink sesbasic_icon_add')); ?></div>
  </div>
  <?php if( count($this->paginator) ): ?>
    <div class="sesbasic_search_reasult">
      <?php echo $this->translate(array('%s photo found.', '%s photos found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
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
	<div style="width:15%" class="admin_table_centered">
	  <?php echo $this->translate("Thumbnail") ?>
	</div>
	<div style="width:7.5%" class="admin_table_centered">
	  <?php echo $this->translate("Enabled") ?>
	</div>
	<div style="width:15%">
	  <?php echo $this->translate("Options"); ?>
	</div>  
      </div>
      <ul class="sesbasic_manage_table_list" id='menu_list' style="width:100%;">
	<?php foreach ($this->paginator as $item) : ?>
	  <li class="item_label" id="slide_<?php echo $item->headerphoto_id ?>">
	    <div style="width:5%;">
	      <input type='checkbox' class='checkbox' name='delete_<?php echo $item->headerphoto_id;?>' value='<?php echo $item->headerphoto_id ?>' />
	    </div>
	    <div style="width:5%;">
	      <?php echo $item->headerphoto_id; ?>
	    </div>
	    <div style="width:15%;">
	      <img height="100px;" width="100px;" alt="" src="<?php echo Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl(); ?>" />
	    </div>               
	    <div style="width:7.5%;" class="admin_table_centered">
	      <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-image', 'headerphoto_id' => $this->headerphoto_id, 'id' => $item->headerphoto_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-image', 'headerphoto_id' => $this->headerphoto_id, 'id' => $item->headerphoto_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
	    </div>  
	    <div style="width:15%;">          
	      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'create-image', 'headerphoto_id' => $item->headerphoto_id,'id'=>$this->headerphoto_id), $this->translate("Edit"), array()) ?>
	      |
	      <?php echo $this->htmlLink(
	      array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'delete-image', 'id' => $item->headerphoto_id),
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
	<?php echo "There are no images added by you.";?>
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

  function multiDelete() {
    return confirm("<?php echo $this->translate("Are you sure you want to delete the selected images ?") ?>");
  }
  function selectAll(){
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
	inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
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
    for (var menuitem in menuitems) {
      var child_id = menuitems[menuitem].id;
      if ((child_id != undefined)) {
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
  .sessocialtube_manage_form_head > div,
  .sessocialtube_manage_form_list li > div{
    box-sizing:border-box;
  }
</style>