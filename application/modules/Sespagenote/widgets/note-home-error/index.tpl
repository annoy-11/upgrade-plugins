<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->paginator->getTotalItemCount() <= 0): ?>
<div class="tip">
  <span>
    <?php echo $this->translate('Nobody has created a note with that criteria.') ?>
  </span>
</div>
<?php endif; ?>
