<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $widgetName = 'peopleyoumayknow';?>
<?php if($this->view_type == 'list'): ?>
  <ul class="sesbasic_sidebar_block sesmember_side_block sesbasic_bxs sesbasic_clearfix">
<?php else: ?>
  <ul class="sesmember_side_block sesbasic_bxs sesbasic_clearfix">
<?php endif; ?>
  <?php include APPLICATION_PATH . '/application/modules/Sesmember/views/scripts/_sidebarWidgetData.tpl'; ?>
</ul>
