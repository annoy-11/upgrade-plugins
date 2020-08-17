<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dashboard-linkks.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/odering.js'); ?>
<script>
  ajaxurl = en4.core.baseUrl+"admin/sesmenu/manage/change-order";
</script>

<?php include APPLICATION_PATH .  '/application/modules/Sesmenu/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_result"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'menus', 'action' => 'index'), "Back to Manage Categories", array('class'=>'sesbasic_icon_back buttonlink')) ?></div>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Manage Dashboard Links") ?> </h3>
      <p class="description">
        <?php echo $this->translate('Here, you can create categories and you can also manage links to be shown in the Dashboard widget of your website arranged under various categories. You can also edit / delete / enable / disable any category and links from here.') ?>
      </p>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'addheading', 'item_id' => $this->item_id,'menu_id'=>$this->menu_id), $this->translate('Add Item'), array('class' => 'smoothbox buttonlink admin_menus_additem sesmenu_icon_add')); ?><br /><br />
      <?php if(count($this->paginator)>0):?>
      <table class='admin_table' style="width: 100%;" id="menu_items_list">
        <thead>
          <tr>
            <th><?php echo $this->translate("Categories & Links") ?></th>
            <th><?php echo $this->translate("Icon") ?></th>
            <th align="center"><?php echo $this->translate("Enabled") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $category): ?>
            <tr data-article-id="<?php echo $category->getIdentity(); ?>" id="categoryid-<?php echo $category->itemlink_id; ?>"  class="item_label" >
              <td style="display:none;"><input type="checkbox" class="checkbox check-column" name="delete_tag[]" value="<?php echo $category->getIdentity(); ?>" /></td>
              <td><b class="bold"><?php echo $category->name ?></b></td>
              <td>
                    <?php if(empty($category->icon_type) && !empty($category->file_id)): ?>
                    <?php $photo = $this->storage->get($category->file_id, '');
                    if($photo) {
                    $photo = $photo->map(); ?>
                      <img class="expose_manangemenu_icon" alt="" src="<?php echo $photo ?>" />
                    <?php } else { ?>
                      <?php echo "---"; ?>
                    <?php } ?>
                  <?php elseif(empty($category->file_id) && !empty($category->icon_type)): ?>
                    <i class="fa <?php echo $category->font_icon; ?>"></i>
                  <?php endif;?>
              </td>
              <td class="admin_table_centered">
                <?php echo ( $category->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'enabled-link', 'itemlink_id' => $category->itemlink_id,'menu_id'=>$this->item_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesmenu/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'enabled-link', 'itemlink_id' => $category->itemlink_id,'menu_id'=>$this->item_id), $this->htmlImage('application/modules/Sesmenu/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
              </td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'editheading', 'itemlink_id' => $category->itemlink_id, 'item_id' => $this->item_id,'menu_id'=>$this->menu_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                <?php //if($category->itemlink_id != 1): ?> |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'addsublink', 'itemlink_id' => $category->itemlink_id, 'item_id' => $this->item_id,'menu_id'=>$this->menu_id), $this->translate('Add New Sub Link'), array('class' => 'smoothbox')); ?><?php //endif; ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'delete', 'itemlink_id' => $category->itemlink_id,'menu_id'=>$this->menu_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
              </td>
            </tr>
            <?php $manageSubLinks = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu')->getInfo(array('sublink' => $category->itemlink_id, 'admin' => 1)); ?>
            <?php foreach ($manageSubLinks as $sub_category):  ?>
              <tr data-article-id="<?php echo $sub_category->getIdentity(); ?>" id="categoryid-<?php echo $sub_category->itemlink_id; ?>" >
                
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
                <td class="admin_table_centered">
                  <?php echo ( $sub_category->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'enabled-link', 'itemlink_id' => $sub_category->itemlink_id, 'sublink' => $sub_category->sublink,'menu_id'=>$this->menu_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesmenu/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'enabled-link', 'itemlink_id' => $sub_category->itemlink_id, 'sublink' => $sub_category->sublink,'menu_id'=>$this->menu_id), $this->htmlImage('application/modules/Sesmenu/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
                </td>
                <td>
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'editlink', 'itemlink_id' => $sub_category->itemlink_id, 'sublink' => $sub_category->sublink,'menu_id'=>$this->menu_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?> |
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'manage', 'action' => 'deletesublink', 'itemlink_id' => $sub_category->itemlink_id,'menu_id'=>$this->menu_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
<script type="text/javascript">
ajaxurl = en4.core.baseUrl+"admin/sesmenu/manage/change-order";

  function ignoreDrag()
  {
    event.stopPropagation();
    return false;
  }
</script>
