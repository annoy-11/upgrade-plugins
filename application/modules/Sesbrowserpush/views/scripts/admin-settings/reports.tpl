<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: reports.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';

?>
<div class="sesbasic-form">
	<div>
    <div class="sesbasic-form-cont">
    	<h3><?php echo $this->translate("Report & Statistics"); ?></h3>
    	<p><?php echo $this->translate("This page displays a brief report of push notifications sent by you from the admin panel of this plugin. (This report does not cover in-built site notifications.)"); ?></p>
    	<br>
      <div class='admin_search sesbrowsepush_admin_search' style="margin-bottom:20px;">
        <?php echo $this->formFilter->render($this) ?>
      </div>
    	<div class="sesbrowsepush_reports">
      	<div>
        	<article>
            <span class="_count"><?php echo count($this->sent); ?></span>
            <span class="_label"><?php echo "Total Notifications Sent"; ?></span>
        	</article>
        </div>
        <div>
        	<article>
            <span class="_count"><?php echo count($this->receivers); ?></span>
            <span class="_label"><?php echo "Total Notifications Received"; ?></span>
        	</article>
        </div>
        <div>
        	<article>  
            <span class="_count"><?php echo count($this->clicked); ?></span>
            <span class="_label"><?php echo "Total Notifications Clicked"; ?></span>
          </article>
    		</div>
      </div>
    </div>
  </div>
</div>