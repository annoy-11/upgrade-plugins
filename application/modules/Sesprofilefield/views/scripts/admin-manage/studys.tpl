<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: studys.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseURL = $this->layout()->staticBaseUrl;?>

<?php include APPLICATION_PATH .  '/application/modules/Sesprofilefield/views/scripts/dismiss_message.tpl';?>

<h3>Manage Studies</h3>

<p><?php echo $this->translate("This Page lists all the study fields that the user will add in there profile. You can use this page to monitor all the fields of study. If you need to search for a specific Field, enter your search criteria in the fields below. Also you can add new Field of Study from this section.") ?></p>
<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>

<br />

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'add', 'type' => 'study'), $this->translate('Add New Study'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />

<div class='admin_results'>
  <div>
    <?php echo $this->translate(array("%s studies found.", "%s studies found.", $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
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
            <th><?php echo $this->translate("Study Name") ?></th>
            <th class='admin_table_centered'><?php echo $this->translate("Status") ?></th>
            <th class='admin_table_options'><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if( count($this->paginator) ): ?>
            <?php foreach( $this->paginator as $item ): ?>
              <tr>
                <td><?php echo $item->study_id ?></td>
                <td class='admin_table_bold'>
                  <?php echo $item->name; ?>
                </td>
                <td class='admin_table_centered'>
                  <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->study_id, 'type' => 'study'), $this->htmlImage($baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->study_id, 'type' => 'study'), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </td>
                <td class='admin_table_options'>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->study_id, 'type' => 'study'), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
                  |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->study_id, 'type' => 'study'), $this->translate('Delete'), array('class' => 'smoothbox')); ?>
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
      <?php echo "There are no studys.";?>
    </span>
  </div>
<?php endif;?>