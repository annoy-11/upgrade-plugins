<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesfaq_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), "sesfaq_general"); ?>"><?php echo $this->translate("FAQs Home"); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), "sesfaq_general"); ?>"><?php echo $this->translate("Browse FAQs"); ?></a>&nbsp;&raquo;
  <?php echo $this->subject->getTitle(); ?>
</div>
