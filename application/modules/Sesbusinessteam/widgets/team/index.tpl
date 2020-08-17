<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(count($this->paginator) > 0): ?>
  <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessteam/views/scripts/index/widget/_teamtemplate'.$this->template_settings.'.tpl'; ?> 
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("Sorry, no results matching your search criteria were found."); ?>
    </span>
  </div>
<?php endif; ?>
