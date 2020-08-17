<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: emojiicons.tpl  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesemoji/views/scripts/dismiss_message.tpl';?>
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
    var url = '<?php echo $this->url(array('action' => 'order-manage-emojiicons')) ?>';
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
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected emoji icons?") ?>");
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
<h3>Reorder Emojis for Browsers</h3>
<p>Here, you can reorder the emoji images. These will be reflected when users try to add emojis in their posts and comments from browsers.<br />To reorder the emojis, click on their names and drag them up or down.</p><br />
<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
  <?php endif; ?>
  <div>
     <div class="sesbasic_search_reasult">
     	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'index'), $this->translate("Back to Categories & Emojis"), array('class'=>'sesbasic_button fa fa-long-arrow-left')); ?>
      
      <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'add-emojiicon','emoji_id' => $this->emoji_id), $this->translate("Add Emoji Icon"), array('class'=>'sesbasic_button fa fa-plus smoothbox')); ?>
     
     <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'upload-zip-file','emoji_id'=>$this->emoji_id), $this->translate("Upload Stickers in Zip"), array('class'=>'sesbasic_button fa fa-plus smoothbox')); ?>
</div>
        <?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s emoji found.', '%s emojis found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div><?php endif; ?>
        <?php if(count($this->paginator) > 0):?>
					<div class="sesfeelingactivity_emojies_listing"  id='menu_list'>
           <?php foreach ($this->paginator as $item): ?>
            <div class="sesfeelingactivity_emojies_list" id="manageemojiicons_<?php echo $item->getIdentity() ?>">
              <input type='hidden'  name='order[]' value='<?php echo $item->getIdentity(); ?>'>
            	<!--<span class="_input"><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity();?>' value='<?php echo $item->getIdentity() ?>' /></span>-->
              <div class="_img">
                <img alt="" src="<?php echo Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl(); ?>" />
                <?php // echo Engine_Api::_()->sesemoji()->DecodeEmoji($item->emoji_icon);; ?>
              </div>
              <div class="_options">          
                <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'add-emojiicon', 'id' => $item->getIdentity(),'emoji_id'=>$this->emoji_id), $this->translate(""), array('title'=> $this->translate("Edit"), 'class' => 'smoothbox fa fa-pencil')) ?>
                
                <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'delete-emojiicon', 'id' => $item->getIdentity()), $this->translate(""), array('title'=> $this->translate("Delete"), 'class' => 'smoothbox fa fa-trash')) ?>
              </div>
              <div class="_title">
              
              </div>
            </div>
          <?php endforeach; ?>
          </div>
<!--          <div class='buttons' style="margin-top:15px;">
          	<button type='submit'><?php //echo $this->translate('Delete Selected'); ?></button>
        	</div>-->
        	<?php else: ?>
          <div class="tip">
            <span>
              <?php echo "There are no emoji icon created by you yet.";?>
            </span>
          </div>
        <?php endif;?>
      </div>
  </form>
  <br />
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>