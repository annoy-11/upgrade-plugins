<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-links.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfooter/views/scripts/dismiss_message.tpl';?>

<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('action' => 'multi-delete-designations'));?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo "Manage Footer Links"; ?></h3>
      <p><?php echo $this->translate('Here, you can manage links to be shown in the Footer of your website arranged in various columns. You can also enable disable any footer column or their associated links from below. <br />For each footer link, you can also choose it to be shown to non-logged in users, logged-in users, open in same tab or new tab and URL to be shown to logged-in and non-logged in user. <br /><br />Q: How should add a URL?<br />Ans: If you are adding a URL from your website site, then simply write the URL Slug after the site URL. For example: to enter the URL of Groups: http://www.yourwebsite.com/groups, simply write "groups" in the URL field. If you enter full URL, then that will also work.<br /> If the URL is some external site URL, then enter the full URL. <br /><br />Note: The Footer Column 1 will have all the links you have added from the <a href="admin/menus?name=core_footer">Footer Menu</a>.'); ?></p>
      <br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sesfooter_manage_table" style="width:70%">
          <div class="sesfooter_manage_table_head">
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
          <ul class="sesfooter_manage_table_list" id='menu_list'>
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label" style="cursor:default;">
                <div style="width:50%;">
                  <b class="bold"><?php echo $item->name ?></b>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesfooter/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage('application/modules/Sesfooter/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
                </div>
                <div style="width:40%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $item->footerlink_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                  <?php if($item->footerlink_id != 1): ?> |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'addsublink', 'footerlink_id' => $item->footerlink_id), $this->translate('Add New Footer Link'), array('class' => 'smoothbox')); ?><?php endif; ?>
                </div>
              </li>
	              <?php $manageSubLinks = Engine_Api::_()->getDbTable('footerlinks', 'sesfooter')->getInfo(array('sublink' => $item->footerlink_id)); ?>
	              <?php foreach ($manageSubLinks as $item) : ?>
	              <li class="item_label" style="cursor:default;">
	                <div style="width:50%;">
	                  &nbsp;&nbsp;&nbsp; <?php echo $item->name ?>
	                </div>
	                <div style="width:10%;" class="admin_table_centered">
	                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id, 'sublink' => $item->sublink), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesfooter/externals/images/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id, 'sublink' => $item->sublink), $this->htmlImage('application/modules/Sesfooter/externals/images/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
	                </div>
	                <div style="width:40%;">          
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $item->footerlink_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfooter', 'controller' => 'manage', 'action' => 'deletesublink', 'footerlink_id' => $item->footerlink_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
	                </div>
	              </li>
	            <?php endforeach; ?>
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
