<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: positions.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseURL = $this->layout()->staticBaseUrl;?>

<?php include APPLICATION_PATH .  '/application/modules/Sesprofilefield/views/scripts/dismiss_message.tpl';?>

<h3>Manage Positions</h3>

<p><?php echo $this->translate("This Page lists all the positions that the user will add in there experience. You can use this page to monitor all them. If you need to search for a specific positions, enter your search criteria in the fields below.You can add new positions from here.") ?></p><br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>

<br />

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'add', 'type' => 'position'), $this->translate('Add New Position'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />

<div class='admin_results'>
  <div>
    <?php echo $this->translate(array("%s position found.", "%s positions found.", $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
  </div>
</div>
<br />
<?php if(count($this->paginator) > 0):?>
  <div class="admin_table_form">
    <form>
      <table class='admin_table'>
        <thead>
          <tr>
            <th style='width: 1%;'><?php echo $this->translate("ID") ?></th>
            <th><?php echo $this->translate("Position Name") ?></th>
            <th class='admin_table_centered'><?php echo $this->translate("Status") ?></th>
            <th class='admin_table_options'><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if( count($this->paginator) ): ?>
            <?php foreach( $this->paginator as $item ): ?>
              <tr>
                <td><?php echo $item->position_id ?></td>
                <td class='admin_table_bold'>
                  <?php echo $item->name; ?>
                </td>
                <td class='admin_table_centered'>
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->position_id, 'type' => 'position'), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->position_id, 'type' => 'position'), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </td>
                <td class='admin_table_options'>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->position_id, 'type' => 'position'), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
                  |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->position_id, 'type' => 'position'), $this->translate('Delete'), array('class' => 'smoothbox')); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <br />
    </form>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo "There are no positions.";?>
    </span>
  </div>
<?php endif;?>