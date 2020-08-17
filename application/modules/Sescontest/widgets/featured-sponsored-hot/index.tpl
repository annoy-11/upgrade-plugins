<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->params['viewType'] == 'list'): ?>
  <ul class="sesbasic_sidebar_block sescontest_side_block sesbasic_bxs sesbasic_clearfix">
<?php else: ?>
  <ul class="sescontest_side_block sesbasic_bxs sesbasic_clearfix">
<?php endif; ?>
  <?php include APPLICATION_PATH . '/application/modules/Sescontest/views/scripts/_commonWidgetData.tpl'; ?>
</ul>