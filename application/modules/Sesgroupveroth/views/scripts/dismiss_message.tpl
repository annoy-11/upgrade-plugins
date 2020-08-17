<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: deismiss_message.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Group Verification by Members Extension") ?></h2>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
