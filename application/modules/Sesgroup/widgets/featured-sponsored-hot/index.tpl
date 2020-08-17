<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<div class="sesgroup_welcome_block_container">
	<?php if($this->params['viewType'] == 'list'): ?>
	  <ul class="sesbasic_sidebar_block sesgroup_side_block sesbasic_bxs sesbasic_clearfix">
	<?php else: ?>
	  <ul class="sesgroup_side_block sesbasic_bxs sesbasic_clearfix">
	<?php endif; ?>
	  <?php include APPLICATION_PATH . '/application/modules/Sesgroup/views/scripts/_commonWidgetData.tpl'; ?>
	</ul>
</div>