<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-links.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Seslinkedin/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
      <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'footer'), $this->translate('Footer Settings')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>
     <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
    </li>
  </ul>
</div>

<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('action' => 'multi-delete-designations'));?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo "Manage Footer Links"; ?></h3>
      <p><?php echo $this->translate("Here, you can manage links to be shown in the Footer of your website arranged in various columns. You can also enable disable any footer column or their associated links from below."); ?></p>
      <br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sesbasic_manage_table" style="width:70%">
          <div class="sesbasic_manage_table_head">
            <div style="width:50%">
              <?php echo "Column & Link";?>
            </div>
            <div style="width:10%" class="admin_table_centered">
              <?php echo "Enabled";?>
            </div>
            <div style="width:40%">
              <?php echo "Options";?>
            </div>   
          </div>
          <ul class="sesbasic_manage_table_list" id='menu_list'>
            <?php foreach ($this->paginator as $item) : ?>
              <li style="cursor:default;" id="footerlink_<?php echo $item->footerlink_id; ?>">
                <div style="width:50%;" class="item_label">
                  <b class="bold"><?php echo $item->name ?></b>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
                </div>
                <div style="width:40%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $item->footerlink_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                    |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'addsublink', 'footerlink_id' => $item->footerlink_id), $this->translate('Add New Footer Link'), array('class' => 'smoothbox')); ?>
                </div>
                <?php $manageSubLinks = Engine_Api::_()->getDbTable('footerlinks', 'seslinkedin')->getInfo(array('sublink' => $item->footerlink_id)); ?>
                <ul  id='sub_menu_list'>
	              <?php foreach ($manageSubLinks as $sublink) : ?>
	              <li  style="cursor:default;" id="footerlink_<?php echo $sublink->footerlink_id; ?>" >
	                <div style="width:50%;" class ="sub_item_label">
	                  &nbsp;&nbsp;&nbsp; <?php echo $sublink->name ?>
	                </div>
	                <div style="width:10%;" class="admin_table_centered">
	                  <?php echo ( $sublink->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $sublink->footerlink_id, 'sublink' => $sublink->sublink), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $sublink->footerlink_id, 'sublink' => $sublink->sublink), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
	                </div>
	                <div style="width:40%;">          
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $sublink->footerlink_id, 'sublink' => $sublink
	                  ->sublink), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslinkedin', 'controller' => 'manage', 'action' => 'deletesublink', 'footerlink_id' => $sublink->footerlink_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
	                </div>
	              </li>
	            <?php endforeach; ?>
              </li>
            </ul>
            <?php endforeach; ?>
          </ul>
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
  
    window.addEvent('load', function() {
    SortablesInstance = new Sortables('sub_menu_list', {
      clone: true,
      constrain: false,
      handle: '.sub_item_label',
      onComplete: function(e) { 
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentElement.children;
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
    var url = '<?php echo $this->url(array('action' => 'order-footer-links')) ?>';
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
