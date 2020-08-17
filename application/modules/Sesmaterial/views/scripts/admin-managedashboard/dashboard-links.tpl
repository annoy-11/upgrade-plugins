<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dashboard-links.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/odering.js'); ?>
<script>
  ajaxurl = en4.core.baseUrl+"admin/sesmaterial/managedashboard/change-order";
</script>

<?php include APPLICATION_PATH .  '/application/modules/Sesmaterial/views/scripts/dismiss_message.tpl';?>

<div class='settings sesbasic_admin_form'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Manage Dashboard Links") ?> </h3>
      <p class="description">
        <?php echo $this->translate('Here, you can create categories and you can also manage links to be shown in the Dashboard widget of your website arranged under various categories. You can also edit / delete / enable / disable any category and links from here.') ?>
      </p>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'addheading'), $this->translate('Add Category'), array('class' => 'smoothbox sesbasic_icon_add buttonlink')); ?><br /><br />
      <?php if(count($this->paginator)>0):?>
      <table class='admin_table' style="width: 100%;">
        <thead>
          <tr>
            <th><?php echo $this->translate("Categories & Links") ?></th>
            <th><?php echo $this->translate("Icon") ?></th>
            <th><?php echo $this->translate("Enabled") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $category): ?>
            <tr data-article-id="<?php echo $category->getIdentity(); ?>">
              <td style="display:none;"><input type="checkbox" class="checkbox check-column" name="delete_tag[]" value="<?php echo $category->getIdentity(); ?>" /></td>
              <td><b class="bold"><?php echo $category->name ?></b></td>
              <td>
                <?php echo "---"; ?>
              </td>
              <td>
                <?php echo ( $category->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'enabled-link', 'dashboardlink_id' => $category->dashboardlink_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'enabled-link', 'dashboardlink_id' => $category->dashboardlink_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
              </td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'editheading', 'dashboardlink_id' => $category->dashboardlink_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                <?php //if($category->dashboardlink_id != 1): ?> |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'addsublink', 'dashboardlink_id' => $category->dashboardlink_id), $this->translate('Add New Sub Link'), array('class' => 'smoothbox')); ?><?php //endif; ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'delete', 'dashboardlink_id' => $category->dashboardlink_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
              </td>
            </tr>
            <?php $manageSubLinks = Engine_Api::_()->getDbTable('dashboardlinks', 'sesmaterial')->getInfo(array('sublink' => $category->dashboardlink_id)); ?>
            <?php foreach ($manageSubLinks as $sub_category):  ?>
              <tr data-article-id="<?php echo $sub_category->getIdentity(); ?>">
                
                <td style="display:none;"><input type="checkbox" class="checkbox check-column" name="delete_tag[]" value="<?php echo $sub_category->getIdentity(); ?>" /></td>
                <td>&rarr; <?php echo $sub_category->name ?></td>
                <td>
                  <?php if(empty($sub_category->icon_type) && !empty($sub_category->file_id)): ?>
                    <?php $photo = $this->storage->get($sub_category->file_id, '');
                    if($photo) {
                    $photo = $photo->map(); ?>
                      <img class="expose_manangemenu_icon" alt="" src="<?php echo $photo ?>" />
                    <?php } else { ?>
                      <?php echo "---"; ?>
                    <?php } ?>
                  <?php elseif(empty($sub_category->file_id) && !empty($sub_category->icon_type)): ?>
                    <i class="fa <?php echo $sub_category->font_icon; ?>"></i>
                  <?php endif;?>
                </td>
                <td>
                  <?php echo ( $sub_category->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'enabled-link', 'dashboardlink_id' => $sub_category->dashboardlink_id, 'sublink' => $sub_category->sublink), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'enabled-link', 'dashboardlink_id' => $sub_category->dashboardlink_id, 'sublink' => $sub_category->sublink), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enabled')))) ) ?>
                </td>
                <td>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'editlink', 'dashboardlink_id' => $sub_category->dashboardlink_id, 'sublink' => $sub_category->sublink), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'managedashboard', 'action' => 'deletesublink', 'dashboardlink_id' => $sub_category->dashboardlink_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else:?>
      <br/>
      <div class="tip">
        <span><?php echo $this->translate("There are currently no entry yet.") ?></span>
      </div>
      <?php endif;?>
    </div>
  </form>
</div>