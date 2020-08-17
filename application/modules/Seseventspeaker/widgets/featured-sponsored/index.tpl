<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventspeaker/externals/styles/styles.css'); ?>

<ul class="sesbasic_bxs sesbasic_clearfix sesbasic_sidebar_block">
  <?php include APPLICATION_PATH . '/application/modules/Seseventspeaker/views/scripts/_sidebarWidgetData.tpl'; ?>
</ul>