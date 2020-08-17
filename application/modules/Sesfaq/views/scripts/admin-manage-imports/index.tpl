<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfaq/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Import FAQs Using CSV File") ?></h3>
<p><?php echo $this->translate('This page enables you to import FAQs on your website from CSV file. Please download the template file using the "Download Template File" button below. To start importing FAQs, click on the Import FAQs button.<br /><br />Notes: See the points below and make sure the csv is created follows each one:<br />
<br />1. Do not add any new column in the downloaded template file.<br />2. The data in the file should be pipe ("|") separated and in same ordering as that of the template file.<br />3. Take the category_id, sub_category_id and 3rd_level_category_id for the csv file from the Manage Categories section of this plugin.<br />4. We recommend you to import 100 FAQs from the csv file at a time.<br />5. File must be in .csv format Only.<br />6. After importing FAQs, you can edit them from the "Add & Manage FAQs" section of this plugin and change accordingly.<br />'); ?></p>
<br />
<div class="sesfaq_import_buttons">
<a href="<?php echo $this->url(array('action' => 'download')) ?>" class="sesfaq_download"><?php echo $this->translate('Download Template File')?></a>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfaq', 'controller' => 'manage-imports', 'action' => 'import'), $this->translate('Import FAQs'), array('class' => 'smoothbox sesfaq_import')) ?>
</div>