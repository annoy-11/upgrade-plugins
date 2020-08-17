<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-dashboards.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>


<h3><?php echo "Manage Dashboard Menu Items"; ?></h3>
<p><?php echo "Here, you can manage the Page dashboard menu items and edit their Titles. You can also enable / disable any menu item from below."; ?> </p>
<br />
<table class='admin_table' style="width:50%;">
  <thead>
    <tr>
      <th><?php echo $this->translate("Menu Item") ?></th>
      <th><?php echo $this->translate("Status") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $result):  ?>
      <tr>
        <td><?php echo $result->title ?></td>
				<td class='admin_table_centered'>
					<?php if(!$result->main): ?>
						<?php echo ( $result->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespage', 'controller' => 'settings', 'action' => 'enabled', 'dashboard_id' => $result->dashboard_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespage', 'controller' => 'settings', 'action' => 'enabled', 'dashboard_id' => $result->dashboard_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
					<?php else: ?>
						<?php echo "-"; ?>
					<?php endif; ?>
				</td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespage', 'controller' => 'admin-settings', 'action' => 'edit-dashboards-settings', 'dashboard_id' => $result->dashboard_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
