<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sessocialshare/views/scripts/dismiss_message.tpl';?>

<h3 style="margin-bottom:6px;"><?php echo $this->translate("Sharing of Site Content in Activity Feeds Settings"); ?></h3>
<p>Here, you can enable / disable the plugins (modules) on whose activity feeds users of your website will be able to share various content, other activity feeds from within your website. Use the “Add New Plugin” link to add a new plugin on which content can be shared.<br />The shared content will be shown in the Updates tab of the plugin which have Activity Feeds (Also, make sure to place the Activity Feeds widget on enabled plugins view pages.)</p>
<br class="clear" />
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'integrateothermodule', 'action' => 'addmodule', 'type' => 'socialshare'), $this->translate("Add New Plugin"), array('class'=>'buttonlink sesbasic_icon_add'));
?>
<br /><br />

<?php if(count($this->paginator)): ?>
<form id='multidelete_form'>
  <table class='admin_table'>
    <thead>
      <tr>
        <th align="left">
          <?php echo $this->translate("Plugin Name"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Item Type"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("DropDown Option Text"); ?>
        </th>
        <th class="left">
          <?php echo $this->translate("Status"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Options"); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
      <?php 
        $module_name = $item->module_name; 
        $enabledModules = $this->enabledModules;
      ?>
      <?php if(in_array($module_name, $enabledModules )): ?>
      <tr>
        <td><?php if( !empty($item->module_name) ){ echo $item->module_name; }else { echo '-'; } ?></td>
        <td><?php if( !empty($item->content_type) ){ echo $item->content_type; }else { echo '-'; } ?></td>
        <td><?php if( !empty($item->title) ){ echo $item->title; }else { echo '-'; } ?></td>
        <td><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'integrateothermodule', 'action' => 'enabled', 'integrateothermodule_id' => $item->integrateothermodule_id ), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'integrateothermodule', 'action' => 'enabled', 'integrateothermodule_id' => $item->integrateothermodule_id ), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td >
        <td>
          <a href="<?php echo $this->url(array('action' => 'edit', 'integrateothermodule_id' => $item->integrateothermodule_id)) ?>" class="smoothbox"><?php echo $this->translate("Edit Option Text") ?>
          </a>
          <?php if(!in_array($item->content_type, array('self_profile', 'self_friend', 'email'))): ?>
          |
          <a href="<?php echo $this->url(array('action' => 'delete', 'integrateothermodule_id' => $item->integrateothermodule_id)) ?>" class="smoothbox"><?php echo $this->translate("Delete") ?>
          </a>
          <?php endif; ?>

        </td>
      </tr>
      <?php endif; ?>
      <?php  endforeach; ?>
    </tbody>
  </table>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("No plugins integrated yet.") ?>
  </span>
</div>
<?php endif; ?>