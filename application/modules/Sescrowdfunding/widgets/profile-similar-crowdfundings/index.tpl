<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->view_type == 'list'): ?>
  <ul class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs">
<?php else: ?>
  <ul class="sescf_grid_listing sesbasic_clearfix sesbasic_bxs">
<?php endif; ?>
  <?php include APPLICATION_PATH . '/application/modules/Sescrowdfunding/views/scripts/_sidebarWidgetData.tpl'; ?>
</ul>