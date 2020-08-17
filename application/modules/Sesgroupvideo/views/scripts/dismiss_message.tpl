<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Group Directories Plugin") ?></h2>
<?php //if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupvideo.pluginactivated')): ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php //endif; ?>
