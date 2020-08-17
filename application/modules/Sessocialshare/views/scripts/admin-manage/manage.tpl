<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sessocialshare/views/scripts/dismiss_message.tpl';?>

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
    var url = '<?php echo $this->url(array('action' => 'order-manage')) ?>';
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


<h3><?php echo "Manage Social Network Services"; ?></h3>
<p><?php echo "This page lists all the social networking services on which you can share the content from your website. You can edit the name for the network or enable / disable them."; ?> </p>
<br />
<?php if(count($this->getAllSearchOptions) > 0):?>
  <div class="sesbasic_manage_table">
    <form>
      <div class="sesbasic_manage_table_head">
        <div style="width:50%">
          <?php echo "Title";?>
        </div>
<!--        <div style="width:20%" class="admin_table_centered">
          <?php //echo "Icon";?>
        </div>-->
        <div style="width:30%" class="admin_table_centered">
          <?php echo "Enabled";?>
        </div>
        <div style="width:20%" class="">
          <?php echo "Options";?>
        </div>   
      </div>
      <ul class="sesbasic_manage_table_list" id='menu_list'>
        <?php foreach ($this->getAllSearchOptions as $item): ?>
          <li class="item_label" id="managesocialicons_<?php echo $item->socialicon_id ?>">
            <input type='hidden'  name='order[]' value='<?php echo $item->socialicon_id; ?>'>
					 	<div style="width:50%;">
				      <?php echo $this->translate($item->title); ?>
						</div>
<!--						<div style="width:20%;" class="admin_table_centered">
							<?php //if(!empty($item->file_id)):?>
								<img class="" alt="" src="<?php //echo $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>" />
							<?php //endif;?>
						</div>-->
				    <div style="width:30%;" class="admin_table_centered">
				      <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'manage', 'action' => 'enabled', 'socialicon_id' => $item->socialicon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'manage', 'action' => 'enabled', 'socialicon_id' => $item->socialicon_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
						</div>
						<div style="width:20%;">
						  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->socialicon_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
              <?php if(!empty($item->file_id)):?>
		          <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'manage', 'action' => 'delete-search-icon', 'file_id' => $item->file_id, 'id' => $item->socialicon_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
		          <?php endif;?>
            </div>
          </li>
        <?php endforeach; ?>
			</ul>
    </form>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo "There are not any social share entry yet.";?>
    </span>
  </div>
<?php endif;?>