<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Seslandingpage/views/scripts/dismiss_message.tpl';?>

<h3><?php echo "Manage Feature Blocks"; ?></h3>
<p>
	<?php echo $this->translate("This page lists all the feature block for landing page. Here, you can edit entry according to you.") ?>	
</p>
<br class="clear" />
<div class="sesbasic_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'add'), $this->translate("Add New"), array('class'=>'sesbasic_icon_add buttonlink')) ?>
	
	<?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'create-gallery'), $this->translate("Add New"), array('class'=>'smoothbox sesbasic_icon_add buttonlink')) ?>
</div>
<?php if( count($this->paginator) ): ?>
  <form method="post" action="<?php echo $this->url();?>">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Option") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><?php echo $item->featureblock_id ?></td>
          <td><?php echo $item->title; ?></td>
          <td>
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seslandingpage', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->featureblock_id), $this->translate("Edit")) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </form>
<?php endif; ?>
