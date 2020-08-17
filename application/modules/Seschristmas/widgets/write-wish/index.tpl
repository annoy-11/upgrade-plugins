<?php

/**
* SocialEngineSolutions
*
* @category   Application_Seschristmas
* @package    Seschristmas
* @copyright  Copyright 2014-2015 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: index.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/

?>
<?php if($this->viewer_id && empty($this->has_wish)): ?>
  <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'create', 'widget' => '1'), $this->translate('Make a Wish'), array('class' => 'smoothbox seschristmas_button')) ?>
<?php endif; ?>
<?php if(!empty($this->has_wish) && $this->viewer_id): ?>
  <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'action' => 'edit', 'christmas_id' => $this->has_wish, 'widget' => '1'), $this->translate('Edit your Wish'), array('class' => 'smoothbox seschristmas_button')) ?>
<?php endif; ?>