<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'index'), $this->translate("Back to Manage Locations"), array('class' => 'sesbasic_icon_back buttonlink')); ?><br/><br/>

<div class="importlisting_form estore_import_buttons">
	<div>
		<h3><?php echo $this->translate('Import States from a CSV file');?></h3>
		<p><?php echo $this->translate('This page enables you to import States on your website from CSV file. Please download the template file using the "Download Template File" button below. To start importing States, click on the Import States button.<br /><br />Notes: See the points below and make sure the csv is created follows each one:<br />
<br />1. Do not add any new column in the downloaded template file.<br />2. The data in the file should be pipe ("|") separated and in same ordering as that of the template file.<br />3. Take the category_id, sub_category_id and 3rd_level_category_id for the csv file from the Manage Categories section of this plugin.<br />4. We recommend you to import 100 FAQs from the csv file at a time.<br />5. File must be in .csv format Only.<br />6. After importing FAQs, you can edit them from the "Add & Manage FAQs" section of this plugin and change accordingly.<br />'); ?></p>
<br />

    <a href=<?php echo $this->url(array('action' => 'download')) ?> target='_blank' class="estore_download buttonlink"><?php echo $this->translate('Download the CSV template')?></a>
		
    <a href="javascript:void(0)" class="buttonlink" onclick="Smoothbox.open('<?php echo $this->url(array('action' => 'view-countries-code')) ?>')"><?php echo $this->translate('View Country Codes')?></a>
   
    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location','action'=>'import-country'), $this->translate("Import Locations"), array('class' => 'smoothbox buttonlink')); ?><br/><br/>

		<br />
	</div>
</div>	