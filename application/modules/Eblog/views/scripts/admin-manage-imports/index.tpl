<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Import Blogs Using CSV File") ?></h3><br />
<p><?php echo $this->translate('This page enables you to import Blogs on your website from CSV file. Please download the template file using the "Download Template File" button below. To start importing Blogs, click on the "Import Blogs" button.<br /><br />Notes: See the points below and make sure the csv is created follows each one:<br />
<br />1. Do not add any new column in the downloaded template file.<br />2. The data in the file should be pipe ("|") separated and in same ordering as that of the template file.<br />3. We recommend you to import 100 Blogs from the csv file at a time.<br />4. File must be in .csv format Only.<br />'); ?></p>
<br />
<div class="eblog_import_buttons">
<a href="<?php echo $this->url(array('action' => 'download')) ?>" class="eblog_download"><?php echo $this->translate('Download Template File')?></a>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'eblog', 'controller' => 'manage-imports', 'action' => 'import'), $this->translate('Import Blogs'), array('class' => 'smoothbox eblog_import')) ?>
</div>
