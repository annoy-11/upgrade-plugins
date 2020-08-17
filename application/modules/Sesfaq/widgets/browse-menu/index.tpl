<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="headline">
  <h2>
    <?php echo $this->translate('FAQs');?>
  </h2>
  <?php if( count($this->browsenavigation) > 0 ): ?>
    <div class="tabs">
      <?php echo $this->navigation()->menu()->setContainer($this->browsenavigation)->render(); ?>
    </div>
  <?php endif; ?>
</div>