<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), 'sesadvpoll_general'); ?>"><?php echo $this->translate("Polls Home"); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), 'sesadvpoll_general'); ?>"><?php echo $this->translate("Browse Polls"); ?></a>&nbsp;&raquo;
  <?php echo $this->subject->getTitle(); ?>
</div>
