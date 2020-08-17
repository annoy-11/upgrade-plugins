<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Professional File & Media Manager") ?></h2>
<?php $sesfmm_adminmenu = Zend_Registry::isRegistered('sesfmm_adminmenu') ? Zend_Registry::get('sesfmm_adminmenu') : null; ?>
<?php if($sesfmm_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
