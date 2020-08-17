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
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->content_item->getHref(); ?>"><?php echo $this->content_item->getTitle(); ?></a>&nbsp;&raquo;
  <?php echo $this->review->getTitle(); ?>
</div>
