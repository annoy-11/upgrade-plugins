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
<p>
  <?php echo "This page lists all the accordions and custom tab containers created by you in this plugin. Click on “Create New Accordion or Tab” link below and choose the display criterias in the “Accordion and Tab Container” widget or while getting the shortcode." ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Accordion or Tab"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />

<?php if( count($this->pages) ): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table' style="width:100%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Accordion / Tab Title") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
      <tr>
        <td><?php echo $item->tab_id ?></td>
        <td><?php echo $item->name; ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'managetabs', 'action' => 'edit', 'id' => $item->tab_id), $this->translate("Edit")) ?>
          <?php if($item->short_code):?>
	    |
	    <a href="javascript:void(0);" onclick="showTabContainer('<?php echo $item->tab_id ?>');"><?php echo "Get Shortcode";?></a>
          <?php endif;?>
          |
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespagebuilder', 'controller' => 'admin-managetabs', 'action' => 'delete', 'id' => $item->tab_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("You have not created any accordion or tab yet.") ?>
  </span>
</div>
<?php endif; ?>


<script type="text/javascript">

  function showTabContainer(tab_id) {
    var url = '<?php echo $this->url(Array('module' => 'sespagebuilder', 'controller' => 'admin-managetabs', 'action' => 'show-container-type'), 'default') ?>' + '/tab_id/'+tab_id;
    Smoothbox.open(url);
  }
  
  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected fixed pages entries?');?>");
  }

  function selectAll() {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
        inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
</script>