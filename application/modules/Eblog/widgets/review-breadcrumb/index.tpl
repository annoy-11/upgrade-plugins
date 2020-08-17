<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $tab_id = Engine_Api::_()->sesbasic()->getWidgetTabId(array('name' => 'eblog.blog-reviews'));  ?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->content_item->getHref(); ?>"><?php echo $this->content_item->getTitle(); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->content_item->getHref(array('tab' => $tab_id)); ?>"><?php echo $this->translate("Reviews"); ?></a>&nbsp;&raquo;
  <?php echo $this->review->getTitle(); ?>
</div>
