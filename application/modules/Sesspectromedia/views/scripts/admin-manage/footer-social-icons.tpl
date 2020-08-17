<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-social-icons.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesspectromedia/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-settings'), $this->translate('Footer Settings')) ?>
    </li>
    <li >
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>

        <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
    </li>
  </ul>
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

    // Send request
    var url = '<?php echo $this->url(array('action' => 'order-social-icons')) ?>';
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


<h3><?php echo "Manage Social Sites Links & Icons"; ?></h3>
<p><?php echo "Here, you can add your links on various social sites. You can enable / disable any social site."; ?> </p>
<br />
<?php if(count($this->paginator) > 0):?>
  <div class="sesbasic_manage_table">
    <form>
      <div class="sesbasic_manage_table_head">
        <div style="width:25%">
          <?php echo "Title";?>
        </div>
        <div style="width:25%">
          <?php echo "URL";?>
        </div>
        <div style="width:25%" class="admin_table_centered">
          <?php echo "Enabled";?>
        </div>
        <div style="width:25%">
          <?php echo "Options";?>
        </div>   
      </div>
      <ul class="sesbasic_manage_table_list" id='menu_list'>
        <?php foreach ($this->paginator as $item) : ?>
          <li class="item_label" id="footersocialicons_<?php echo $item->socialicon_id ?>">
            <input type='hidden'  name='order[]' value='<?php echo $item->socialicon_id; ?>'>
						<div style="width:25%;">
				      <?php echo $item->title; ?>
						</div>
						<div style="width:25%;">
              <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
			        <a href="<?php echo $link ?>" target="_blank"><?php echo $link; ?></a>
						</div>
				    <div style="width:25%;" class="admin_table_centered">
				      <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'enabled', 'socialicon_id' => $item->socialicon_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'enabled', 'socialicon_id' => $item->socialicon_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
						</div>
						<div style="width:25%;">          
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'edit', 'socialicon_id' => $item->socialicon_id,'type' => 'footer'), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
            </div>
          </li>
        <?php endforeach; ?>
			</ul>
    </form>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo "You have not uploaded any slide yet.";?>
    </span>
  </div>
<?php endif;?>
