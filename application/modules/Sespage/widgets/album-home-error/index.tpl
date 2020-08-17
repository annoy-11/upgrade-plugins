<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if(count($this->paginator) <= 0): ?>
<div class="tip">
      <span>
        <?php echo $this->translate('Nobody has created an album yet.');?>
      </span>
    </div>
<?php endif; ?>