<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); ?>

<?php include APPLICATION_PATH . '/application/modules/Sesdocument/views/scripts/_showDocumentListGrid.tpl'; ?>
