<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?> 
<div class="sespage_welcome_block_container">
<?php if($this->params['viewType'] == 'list'): ?>
  <ul class="sesbasic_sidebar_block sespage_side_block sesbasic_bxs sesbasic_clearfix">
<?php else: ?>
  <ul class="sespage_side_block sesbasic_bxs sesbasic_clearfix">
<?php endif; ?>
  <?php include APPLICATION_PATH . '/application/modules/Sespage/views/scripts/_commonWidgetData.tpl'; ?>
</ul>
</div>