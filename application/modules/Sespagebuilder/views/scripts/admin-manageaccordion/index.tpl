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
  <?php echo $this->translate('Manage Accordion Menus') ?>
</h3>
<p>
  <?php echo 'This page lists all the accordion menus created by you using this plugin. Use the “Create New Accordion Menu” link to create new accordion menu. To create menu items of the menu, use “Manage Accordion Menu Items” link for the same menu.' ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Accordion Menu"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />
<?php if( count($this->pages) > 0): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" >
  <table class='admin_table' style="width:60%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Accordion Menu Name") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
      <?php if($item->type == 'accordion'): ?>
      <tr>
        <td><?php echo $item->content_id ?></td>
        <td><?php echo $item->title; ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit', 'id' => $item->content_id ), $this->translate("Edit")) ?>
          <?php if($item->show_short_code):?>
            |
	    <a href="javascript:void(0);" onclick="getShortCode('<?php echo $item->content_id;?>');"><?php echo "Get Shortcode";?></a>
          <?php endif;?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete', 'id' => $item->content_id ), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'manage-accordions', 'content_id' => $item->content_id ), $this->translate("Manage Accordion Menu Items")) ?>
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
    <?php echo $this->translate("You have not created any Accordion Menu yet.") ?>
  </span>
</div>
<?php endif; ?>

<script type="text/javascript">
  var getShortCode = function(contentId) {
    Smoothbox.open('<div><h3>Shortcode</h3><p>Copy the below shortcode and use in desired Widgetized Pages created using this plugin.</p><input type=\'text\' style=\'width:200px\' /><br /><br /><button onclick="Smoothbox.close();">Close</button></div>', {autoResize : true});
    Smoothbox.instance.content.getElement('input').set('value', '[accordion_menu_'+contentId+']').focus();
    Smoothbox.instance.content.getElement('input').select();
    Smoothbox.instance.doAutoResize();
  }
</script>