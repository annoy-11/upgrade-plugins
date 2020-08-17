<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $tab_id = Engine_Api::_()->sesbasic()->getWidgetTabId(array('name' => 'sesrecipe.profile-photos'));  ?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->content_item->getHref(); ?>"><?php echo $this->content_item->getTitle(); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->content_item->getHref(array('tab' => $tab_id)); ?>"><?php echo $this->translate("Albums"); ?></a>&nbsp;&raquo;
  <?php echo $this->album->getTitle(); ?>
</div>
