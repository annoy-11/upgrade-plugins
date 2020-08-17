<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslink
 * @package    Seslink
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'index'), "seslink_general"); ?>"><?php echo $this->translate("Browse Link"); ?></a>&nbsp;&raquo;
  <?php echo $this->link->getTitle(); ?>
</div>
