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
<script type="text/javascript">

function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected fixed pages entries?');?>");
}

function selectAll()
{
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

<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>

<h3><?php echo "Widgetized Pages";?></h3>

<p>
  <?php echo "This page lists all of the Widgetized Pages created by you using this plugin. Below, you can create a new page by clicking on “Create New Widgetized Page” link. 
You can manage below pages by using various links for them in the “Options” section below." ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Widgetized Page"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />

<?php if( count($this->pages) ): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table' style="width:100%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Short URL") ?></th>
        <th><?php echo $this->translate("Enabled"); ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
        <?php $pageId = Engine_Api::_()->sespagebuilder()->getWidgetizePageId($item->pagebuilder_id);?>
        <tr>
          <td><?php echo $item->pagebuilder_id ?></td>
          <td><?php echo $item->title ?></td>
          <td><?php echo $item->pagebuilder_url ?></td>
	  <td>
	  <?php if($item->enable ):?>
	    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manage', 'action' => 'enable', 'id' => $item->pagebuilder_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png','', array('title' => $this->translate('Disable'))));?>
	    <?php else:?>
	    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manage', 'action' => 'enable', 'id' => $item->pagebuilder_id) , $this->htmlImage($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ;?>
	  <?php endif;?>
	  </td >
          <td>
            <?php echo $this->htmlLink(
                  array('route' => 'default', 'module' => 'sespagebuilder', 'controller' => 'admin-manage', 'action' => 'edit', 'id' => $item->pagebuilder_id),
                  $this->translate("edit")) ?>
            |
            <?php echo $this->htmlLink(
                  array('route' => 'default', 'module' => 'sespagebuilder', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->pagebuilder_id),
                  $this->translate("delete"),
                  array('class' => 'smoothbox')) ?>
            <?php if($pageId):?>
	      |
	      <?php $url = $this->url(array('module' => 'core', 'controller' => 'content'), 'admin_default').'?page='.$pageId;?>
	      <a href="<?php echo $url;?>"  target="_blank"><?php echo "Go To Widgetize Page";?></a>
            <?php endif;?>
            <?php if($item->enable):?>
              |
	      <?php $url = $this->url(array(), "sespagebuilder_index_$item->pagebuilder_id");?>
	      <a href="<?php echo $url;?>"  target="_blank"><?php echo "View Page";?></a>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no widgetized pages created using this plugin.") ?>
    </span>
  </div>
<?php endif; ?>


