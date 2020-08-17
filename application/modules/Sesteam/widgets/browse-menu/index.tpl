<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="headline">
  <h2>
    <?php if(!empty($this->params['title'])): ?>
      <?php echo $this->translate($this->params['title']); ?>
    <?php else: ?>
      <?php echo $this->translate('Team'); ?>
    <?php endif; ?>
  </h2>
  <div class="tabs">
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
</div>