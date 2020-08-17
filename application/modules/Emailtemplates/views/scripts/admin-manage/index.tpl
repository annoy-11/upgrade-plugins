<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Emailtemplates/views/scripts/dismiss_message.tpl';?>

<p>
  <?php echo "This page list all templates which you have created by you using this plugin. Below, you can create a new Email Template by clicking on “Create New Template link. 
	You can manage below Email Template by using various links for them in the “Options” section below." ?>
</p>
</br>
<div>
  <?php echo $this->htmlLink(array('controller'=>'manage','module'=>'emailtemplates','action' => 'create', 'reset' => true), $this->translate("Create New Template"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br/>
<script type="text/javascript">
	function multiDelete(){
			return confirm("<?php echo $this->translate("Are you sure you want to delete the selected templates ?") ?>");
	}
	function selectAll(){
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


<?php if( count($this->paginator) ): ?>
<div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s Email Template found.', '%s Email Templates  found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
</div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
	<table class='admin_table' width="100%">
		<thead>
			<tr>
				<th class='admin_table_short' style="width:5%;"><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
				<th class='admin_table_short' style="width:5%;"><?php echo $this->translate('Id') ?></th>
				<th class='admin_table_short' style="width:40%;"><?php echo $this->translate('Title') ?></th>
				<th class="text-center" style="width:15%;"><?php echo $this->translate('Status') ?></th>
				<th style="width:35%;"><?php echo $this->translate('Options') ?></th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($this->paginator as $item):  ?>
				<tr>
					<td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->template_id;?>' value="<?php echo $item->template_id ?>"/></td>
					<td><?php echo $item->template_id; ?></td>
					<td><?php echo $item->title; ?></td>
					<td class="admin_table_centered">
						<?php echo ( $item->is_active ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'enabled', 'template_id' => $item->template_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Enabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'enabled', 'template_id' => $item->template_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Disabled')))) ) ?>
							</td>  
							<td>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'create','template_id' => $item->template_id), $this->translate("Edit")) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'delete','template_id' => $item->template_id), $this->translate("Delete"),array('class' => 'smoothbox')) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'create','duplicate'=>$item->template_id), $this->translate("Duplicate")) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'emailtemplates', 'controller' => 'manage', 'action' => 'testmail','template_id'=>$item->template_id), $this->translate("Send Test Mail"),array('class' => 'smoothbox')) ?>
							</td>
					</tr>
					<?php endforeach; ?>
			</tbody>
	</table>
	<br />
	<div class='buttons'>
			<button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
	</div>
	<br />
</form>
<br/>
<div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
</div>
<?php else: ?>
<div class="tip">
    <span>
        <?php echo $this->translate("There are no templates created yet.") ?>
    </span>
</div>
<?php endif; ?>
<style>
.text-center {
   text-align: center;
}
</style>





