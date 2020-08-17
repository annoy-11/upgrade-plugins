<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
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
