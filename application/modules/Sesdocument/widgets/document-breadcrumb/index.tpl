<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), 'sesdocument_general'); ?>"><?php  echo $this->translate("Documents Home"); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), 'sesdocument_general'); ?>"><?php echo $this->translate("Browse Documents"); ?></a>&nbsp;&raquo;


  <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>

</div>

    