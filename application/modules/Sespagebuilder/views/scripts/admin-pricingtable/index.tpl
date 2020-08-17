<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<h3>
  <?php echo $this->translate('Manage Pricing Table') ?>
</h3>
<p>
  <?php echo 'This page lists all the Pricing Tables created by you using this plugin. You can create new pricing table by using the “Create New Pricing Table” link below.<br /><br />To place this table on any widgetized page on your website, go to Layout Editor and place the Pricing Table widget by choosing required values in the Edit Settings.' ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Pricing Table"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />
<?php if( count($this->pages) > 0): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" >
  <table class='admin_table' style="width:60%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Pricing Table Name") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
      <?php if($item->type == 'pricing_table'): ?>
      <tr>
        <td><?php echo $item->content_id ?></td>
        <td><?php echo $item->table_name; ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'edit', 'id' => $item->content_id ), $this->translate("Edit")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'delete', 'id' => $item->content_id ), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          |
          <a href="javascript:void(0);" onclick="showPopUp('<?php echo $item->short_code;?>');"><?php echo "Get Shortcode";?></a>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'manage-tables', 'content_id' => $item->content_id ), $this->translate("Manage Table Columns")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'duplicate-table', 'content_id' => $item->content_id ), $this->translate("Duplicate This Table"),array('class' => 'smoothbox')) ?>
        </td>
      </tr>
      <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("You have not created any Pricing Table yet.") ?>
  </span>
</div>
<?php endif; ?>

<script type="text/javascript">
  function showPopUp(short_code) {
  
    Smoothbox.open('<div class=\'sespagebuilder_getcode_popup\'><h3>Shortcode</h3><p>Copy the below shortcode and use in desired Widgetized Pages created using this plugin.</p><input type=\'text\' /><br /><button class="clear" onclick="Smoothbox.close();">Close</button></div>', {autoResize : true});
    Smoothbox.instance.content.getElement('input').set('value', short_code).focus();
    Smoothbox.instance.content.getElement('input').select();
    Smoothbox.instance.doAutoResize();
    
  }
</script>