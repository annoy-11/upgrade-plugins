<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("News / RSS Importer & Aggregator Plugin") ?></h2>
<?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_mapKeyTip.tpl';?>
<?php $sesnews_adminmenu = Zend_Registry::isRegistered('sesnews_adminmenu') ? Zend_Registry::get('sesnews_adminmenu') : null; ?>
<?php if(!empty($sesnews_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
