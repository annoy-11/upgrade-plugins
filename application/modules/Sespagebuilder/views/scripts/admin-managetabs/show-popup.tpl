<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-popup.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>

<div>
  <h3>Shortcode</h3>
  <div>
    <p>Copy the below shortcode and use in desired Widgetized Pages created using this plugin.</p>
    <input type="text" value="<?php echo $this->short_code; ?>"  /><br />
    <button onclick='javascript:parent.Smoothbox.close()' class="clear"><?php echo $this->translate("Close") ?></button>
  </div>
</div>
