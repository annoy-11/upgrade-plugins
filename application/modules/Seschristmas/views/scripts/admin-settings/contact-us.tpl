<?php

/**
* SocialEngineSolutions
*
* @category   Application_Seschristmas
* @package    Seschristmas
* @copyright  Copyright 2014-2015 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: contact-us.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/
?>
<h2><?php echo $this->translate('SESCHRISTMAS_PLUGIN'); ?></h2>
<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>
<div class="settings">
  <form method="post">
    <div>
      <div>
        <h3><?php echo "Feature Requests and Suggestions"; ?></h3>
        <p><?php echo "If you have any question, query, doubt, or if you are facing problems in installing or setting up this plugins, then Don’t hesitate, just drop us a line from the Support Ticket section on SocialEngineSolutions website.
        Here, you can also share your ideas or request any extra feature, widgets, admin options."; ?> </p>
        <div class="sesbasic_site_view">
          <iframe src="http://socialenginesolutions.com/my-account" style="width:100%; height:500px" seamless scrolling="auto" scale="1.5"></iframe>
        </div>
      </div>
    </div>
  </form>
</div>
