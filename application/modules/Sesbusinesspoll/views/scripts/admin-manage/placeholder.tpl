<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: placeholder.tpl  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Business Poll Plugin") ?></h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>

  <div class='clear'>
    <div class='settings'>

      <?php echo $this->message; ?>

    </div>
  </div>
