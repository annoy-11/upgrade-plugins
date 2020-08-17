<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if(count($this->paginator) <= 0): ?>
<div class="tip">
  <span>
    <?php echo $this->translate('Nobody has created a video with that criteria.') ?>
  </span>
</div>
<?php endif; ?>
