<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="estore_welcome_block_container">
  <?php if($this->params['viewType'] == 'list'): ?>
    <ul class="sesbasic_sidebar_block estore_side_block sesbasic_bxs sesbasic_clearfix">
  <?php else: ?>
    <ul class="estore_side_block sesbasic_bxs sesbasic_clearfix">
  <?php endif; ?>
    <?php include APPLICATION_PATH . '/application/modules/Estore/views/scripts/_commonWidgetData.tpl'; ?>
  </ul>
</div>