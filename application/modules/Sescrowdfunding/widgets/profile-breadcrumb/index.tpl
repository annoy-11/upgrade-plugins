<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), 'sescrowdfunding_general'); ?>"><?php echo $this->translate("Crowdfunding Home");?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_general'); ?>"><?php echo $this->translate("Browse Crowdfundings"); ?></a>&nbsp;&raquo;
  <?php echo $this->subject->getTitle(); ?>
</div>
