<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespopupbuilder/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Popups") ?></h3>
<p>
  <?php echo "This page lists all of the popups  created by you using this plugin. Below, you can create a new popup by clicking on “Create New Popup” link. 
You can enable / disable any popup as per your requirement." ?>
</p>
<br />
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />	
<div>
  <?php echo $this->htmlLink(array('controller'=>'manage','module'=>'sespopupbuilder','action' => 'create', 'reset' => true), $this->translate("Create New Popup"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br/>
<script type="text/javascript">
	function multiDelete(){
			return confirm("<?php echo $this->translate("Are you sure you want to delete the selected popups ? These will not be recoverable after being deleted.") ?>");
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
    <?php echo $this->translate(array('%s Popup  found.', '%s Popups  found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
</div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
	<table class='admin_table'>
		<thead>
			<tr>
				<th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
				<th class='admin_table_short'>Id</th>
				<th><?php echo $this->translate('Title') ?></th>
				<th><?php echo $this->translate('Popup Type') ?></th>
				<th class="text-center"><?php echo $this->translate('Status') ?></th>
				<th><?php echo $this->translate('Options') ?></th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($this->paginator as $item):  ?>
				<tr>
					<td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->popup_id;?>' value="<?php echo $item->popup_id ?>"/></td>
					<td><?php echo $item->popup_id; ?></td>
					<td><?php echo $item->title ?></td>
					<td><?php
					if($item->popup_type == 'html'){
						$popupType = 'HTML';
					}elseif($item->popup_type == 'video'){
						$popupType = 'video';
					}elseif($item->popup_type == 'iframe'){
						$popupType = 'iframe';
					}elseif($item->popup_type == 'facebook_like'){
						$popupType = 'Facebook Page Plugin';
					}elseif($item->popup_type == 'pdf'){
						$popupType = 'PDF';
					}elseif($item->popup_type == 'age_verification'){
						$popupType = 'Age-Verification';
					}elseif($item->popup_type == 'notification_bar'){
						$popupType = 'Notification Promo Bar';
					}elseif($item->popup_type == 'cookie_consent'){
						$popupType = 'Cookie Consent';
					}elseif($item->popup_type == 'christmas'){
						$popupType = 'Christmas & New Year';
					}elseif($item->popup_type == 'count_down'){
						$popupType = 'Count Down';
					}elseif($item->popup_type == 'image'){
						$popupType = 'Image';
					}
					echo $popupType ?></td>
					<td style="width:10%;" class="admin_table_centered">
						<?php echo ( $item->is_deleted ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'enabledpopup', 'popup_id' => $item->popup_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'enabledpopup', 'popup_id' => $item->popup_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable')))) ) ?>
							</td>  
							<td>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup','popup_id' => $item->popup_id), $this->translate("Edit")) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'delete-popup','id' => $item->popup_id), $this->translate("Delete"),array('class' => 'smoothbox')) ?>
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
        <?php echo $this->translate("There are no popups created yet.") ?>
    </span>
</div>
<?php endif; ?>
<style>
.text-center {
   text-align: center;
}
</style>





