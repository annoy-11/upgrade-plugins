<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-links.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sessocialtube/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
      <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-settings'), $this->translate('Footer Settings')) ?>
    </li>
        <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
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
              <li class="item_label" style="cursor:default;">
                <div style="width:50%;">
                  <b class="bold"><?php echo $item->name ?></b>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
                </div>
                <div style="width:40%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $item->footerlink_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                  <?php if($item->footerlink_id != 1): ?> |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'addsublink', 'footerlink_id' => $item->footerlink_id), $this->translate('Add New Footer Link'), array('class' => 'smoothbox')); ?><?php endif; ?>
                </div>
              </li>
	              <?php $manageSubLinks = Engine_Api::_()->getDbTable('footerlinks', 'sessocialtube')->getInfo(array('sublink' => $item->footerlink_id)); ?>
	              <?php foreach ($manageSubLinks as $item) : ?>
	              <li class="item_label" style="cursor:default;">
	                <div style="width:50%;">
	                  &nbsp;&nbsp;&nbsp; <?php echo $item->name ?>
	                </div>
	                <div style="width:10%;" class="admin_table_centered">
	                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id, 'sublink' => $item->sublink), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'enabled-link', 'footerlink_id' => $item->footerlink_id, 'sublink' => $item->sublink), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
	                </div>
	                <div style="width:40%;">          
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'editlink', 'footerlink_id' => $item->footerlink_id, 'sublink' => $item
	                  ->sublink), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
	                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'deletesublink', 'footerlink_id' => $item->footerlink_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
