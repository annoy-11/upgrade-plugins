<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-11-14 00:00:00 SocialEngineSolutions $
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
    var url = '<?php echo $this->url(array('action' => 'order-manage-emoji')) ?>';
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
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected emojis category ?") ?>");
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
<h3>Categories & Emojis</h3>
<p>The Emoji are unicode emojis which will be compatible for iOS, Android Apps and all supporting Browsers. This plugin comes with pre-configured emojis and categories in various categories.<br />Below, you can change the name and photo of the categories by editing them. Since, the unicode images are universal, these can not be edited.<br />To reorder the categories, click on their names and drag them up or down.</p><br />
<?php if( count($this->paginator) ): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()"> 
  <?php endif; ?>
  <div>
<!--    <div>
      <div class="sesbasic_search_reasult">
        <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'create-emojicategory'), $this->translate("Create New Emoji Category"), array('class'=>'sesbasic_button fa fa-plus smoothbox')); ?>
      </div>
    </div>-->
    <?php if( count($this->paginator) ): ?>
        <div class="sesbasic_search_reasult">
          <?php echo $this->translate(array('%s emoji category found.', '%s emoji categories found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
        </div><?php endif; ?>
        <?php if(count($this->paginator) > 0):?>
        	<div class="sesfeelingactivity_packs_listing" id='menu_list'>
          	 <?php foreach ($this->paginator as $item) : ?>
             	<div class="sesfeelingactivity_packs_list" id="manageemojis_<?php echo $item->emoji_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->emoji_id; ?>'>
              	<div>
<!--                	<div class="_input">
                		<input type='checkbox' class='checkbox' name='delete_<?php //echo $item->getIdentity();?>' value='<?php //echo $item->getIdentity() ?>' />
                  </div>-->
                  <div class="_icon">
                    <?php $icon = Engine_Api::_()->storage()->get($item->file_id, '');
                    if($icon) {
                      $iconURL = $icon->getPhotoUrl(); ?>
                  	<img alt="" src="<?php echo $iconURL; ?>" />
                  	<?php } else { ?>
                  	<?php } ?>
                  </div>
                  <div class="_cont">
                  	<div class="_title">
                    	<?php echo $item->title ?>
                    </div>
                    <div class="_options">
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'create-emojicategory', 'id' => $item->getIdentity()), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                      |
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'emojiicons', 'emoji_id' => $item->getIdentity()), $this->translate("Reorder Emojis"), array()); ?>
                      
                      <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesemoji', 'controller' => 'emoji', 'action' => 'delete-emojicategory', 'id' => $item->getIdentity()), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
                    </div>
                  </div>
                </div>
              </div>
             <?php endforeach; ?>
          </div>
<!--          <div class='buttons'>
          	<button type='submit'><?php //echo $this->translate('Delete Selected'); ?></button>
          </div>-->
        </div>
        <?php else:?>
          <div class="tip">
            <span>
              <?php echo "There are no emojis category created by you yet.";?>
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