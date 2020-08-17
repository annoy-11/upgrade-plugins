<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Auto Bot Actions Plugin - Auto Follow / Join / Like / Comment / Auto Friend Request") ?></h2>
<?php
$sesautoaction_adminmenu = Zend_Registry::isRegistered('sesautoaction_adminmenu') ? Zend_Registry::get('sesautoaction_adminmenu') : null;
if(!empty($sesautoaction_adminmenu)) { ?>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
