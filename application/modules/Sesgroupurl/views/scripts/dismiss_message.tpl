<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupurl
 * @package    Sesgroupurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Group Communites Plugin") ?></h2>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
