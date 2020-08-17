<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-profile.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>

<h3><?php echo "Manage Member Home Pages";?></h3>

<p><?php echo "This page lists all of the Widgetized Pages created by you using this plugin. Below, you can create a new page by clicking on “Create New Widgetized Page” link. You can manage below pages by using various links for them in the “Options” section below." ?></p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create-profile', 'reset' => false), $this->translate("Create New Member Profile Page"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />

<?php if( count($this->pages) ): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table' style="width:100%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
        <?php $pageId = Engine_Api::_()->sesmember()->getWidgetizePageId($item->homepage_id);?>
        <tr>
          <td><?php echo $item->homepage_id ?></td>
          <td><?php echo $item->title ?></td>
          <td>
            <?php echo $this->htmlLink(
                  array('route' => 'default', 'module' => 'sesmember', 'controller' => 'admin-manage', 'action' => 'edit-profile', 'id' => $item->homepage_id),
                  $this->translate("edit")) ?>
            |
            <?php echo $this->htmlLink(
                  array('route' => 'default', 'module' => 'sesmember', 'controller' => 'admin-manage', 'action' => 'delete-profile', 'id' => $item->homepage_id),
                  $this->translate("delete"),
                  array('class' => 'smoothbox')) ?>
            <?php if($pageId):?>
	      |
	      <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$pageId;?>
	      <a href="<?php echo $url;?>"  target="_blank"><?php echo "Go To Widgetize Page";?></a>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no member profile pages created using this plugin.") ?>
    </span>
  </div>
<?php endif; ?>