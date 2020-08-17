<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: slide-image.tpl 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesprofilelock/views/scripts/dismiss_message.tpl';?>
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
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected slide image?")) ?>');
  }

</script>
<h3><?php echo "Manage Locked Screen Slides"; ?></h3>
<p><?php echo 'Here, you can manage slides which will be shown on locked screens of users. This locked screen will be shown to users when they lock their screens by clicking on “Lock Screen” link in Mini Navigation menu or by pressing “Alt+L” key. Below, you can add new slides by using the "Upload New Slide" link and delete them. You can drag the slides vertically.'; ?> </p>
<br />
<div>
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilelock', 'controller' => 'manage', 'action' => 'upload-slideshow-photo'), $this->translate('Upload New Slide'), array('class' => 'buttonlink admin_files_upload smoothbox')) ?>
</div><br />
<?php if(count($this->slides) > 0):?>
  <div class="sesprofilelock_manage_slides">
    <form id='multidelete_form' method="post" action="<?php echo $this->url(array('action' => 'multi-delete-slide'));?>" onSubmit="return multiDelete()">
      <div class="sesprofilelock_manage_slides_head">
        <div style="width:5%">
          <input onclick="selectAll()" type='checkbox' class='checkbox'>
        </div>
        <div style="width:10%">
          <?php echo "Id";?>
        </div>
        <div style="width:35%">
          <?php echo "Slide Image";?>
        </div>
        <div style="width:35%" class="">
          <?php echo "Option";?>
        </div>   
      </div>
      <ul class="sesprofilelock_manage_slides_list" id='menu_list'>
        <?php foreach ($this->slides as $item) : ?>
          <li class="item_label" id="slideimage_<?php echo $item->slideimage_id ?>">
            <input type='hidden'  name='order[]' value='<?php echo $item->slideimage_id; ?>'>
            <div style="width:5%;">
              <input name='delete_<?php echo $item->slideimage_id ?>_<?php echo $item->file_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->slideimage_id ?>_<?php echo $item->file_id ?>"/>
            </div>
            <div style="width:10%;">
                      <?php echo $item->slideimage_id; ?>
            </div>
            <div style="width:35%;">
            <?php if($item->file_id): ?>
                      <img class="sesprofilelock_manage_slides" alt="" src="<?php echo $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>" />
            <?php else: ?>
            <?php echo "---"; ?>
            <?php endif; ?>
            </div>
            <div style="width:35%;">
                <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesprofilelock', 'controller' => 'admin-manage', 'action' => 'delete-photo', 'id' => $item->slideimage_id, 'file_id' => $item->file_id),
                $this->translate("Delete"),
                array('class' => 'smoothbox')) ?>
            </div>
          </li>
        <?php endforeach; ?>
	</ul>
      <div class='buttons'>
        <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
      </div>
    </form>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo "You have not uploaded any slide yet.";?>
    </span>
  </div>
<?php endif;?>