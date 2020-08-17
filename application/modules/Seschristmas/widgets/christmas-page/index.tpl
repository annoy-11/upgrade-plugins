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
<?php if($this->openTab): ?>
<?php echo $this->htmlLink(array('route' => 'seschristmas_welcome', 'module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'index'), $this->translate('Marray Christmas Page'), array('target' => '_blank', 'class' => 'seschristmas_button')) ?>
<?php else: ?>
<?php echo $this->htmlLink(array('route' => 'seschristmas_welcome', 'module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'index'), $this->translate('Marray Christmas Page'), array('target' => '_parent', 'class' => 'seschristmas_button')) ?>
<?php endif; ?>
